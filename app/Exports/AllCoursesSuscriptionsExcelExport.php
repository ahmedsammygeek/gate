<?php

namespace App\Exports;


use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Purchase;
use App\Models\Transaction;
class AllCoursesSuscriptionsExcelExport implements  FromCollection , WithHeadings  , WithMapping , ShouldAutoSize , WithEvents
{
    protected $courses;
    protected $i;

    public function __construct($courses)
    {
        $this->i = 1;
        $this->courses = $courses;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $courses = $this->courses->get();

        $courses->map(function($course){
            $course->purchase_count = Purchase::whereHas('item' , function($query) use($course) {
                $query->where('item_id' , $course->id );
            })->count() ;
            $purchase_total_price =  Purchase::whereHas('item' , function($query) use($course) {
                $query->where('item_id' , $course->id );
            })->sum('total');
            $course->purchase_total_price = $purchase_total_price ;
            $purchase_total_paid = Transaction::whereHas('purchase' , function($query) use($course) {
                $query->whereHas('item' , function($query) use($course) {
                    $query->where('item_id' , $course->id );
                }) ;
            })->sum('amount');
            $course->purchase_total_paid = $purchase_total_paid ;
            $course->purchase_total_remains = ($purchase_total_price - $purchase_total_paid  ) ;
        });

        return $courses;
    }

        public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('C1:C10000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('B1:B10000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E1:E10000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F1:F10000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('D1:D10000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F1:F10000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G1:G10000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('H1:H10000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('I1:I10000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            },
        ];
    }


    /**
    * @var Invoice $invoice
    */
    public function map($course): array
    {
        return [
            $this->i++ ,
            $course->title,
            $course->university?->title , 
            $course->trainer?->name  , 
            $course->purchase_total_price , 
            $course->purchase_count   , 
            $course->purchase_total_paid , 
            $course->purchase_total_remains ,
        ];
    }


    public function headings(): array
    {
        return [
            '#' ,
            'الكورس' ,
            'الجامعه' ,
            'الدكتور' ,
            'اجمالى الاشتراكات  ' ,
            'عدد الاشتراكات ' ,
            'المدفوع' ,
            'المتبقى' ,
        ];
    }
}
