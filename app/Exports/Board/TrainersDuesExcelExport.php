<?php

namespace App\Exports\Board;


use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\User;
use App\Models\University;
use App\Models\TrainerTransfer;
class TrainersDuesExcelExport implements FromCollection , WithHeadings  , WithMapping , ShouldAutoSize , WithEvents
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
            $course_purchases_query =  Purchase::whereHas('item' , function($query) use($course) {
                $query->where('item_id' , $course->id );
            });
            $course_purchases_total_amount =  $course_purchases_query->sum('total');
            $course_purchases_ids =  $course_purchases_query->pluck('id')->toArray();
            $course->course_purchases_total_amount = $course_purchases_total_amount ;
            $total_course_purchases_transactions_amount = Transaction::whereIn('purchase_id' , $course_purchases_ids )->sum('amount');
            $course->total_course_purchases_transactions_amount = $total_course_purchases_transactions_amount ;
            $trainer_total_amount_received_till_now = TrainerTransfer::where('course_id' , $course->id )->where('trainer_id' , $course->trainer_id )->sum('amount');
            $course->trainer_total_amount_received_till_now = $trainer_total_amount_received_till_now;
            $trainer_total_dues = ($course->trainer_percentage / 100 ) * $course_purchases_total_amount;
            $course->trainer_total_dues = $trainer_total_dues;
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
            $course->trainer?->name , 
            $course->title , 
            $course->university?->title , 
            $course->course_purchases_total_amount , 
            $course->total_course_purchases_transactions_amount , 
            ($course->course_purchases_total_amount - $course->total_course_purchases_transactions_amount) , 
            $course->trainer_percentage , 
            $course->trainer_total_amount_received_till_now , 
            $course->trainer_total_dues ,         
        ];
    }


    public function headings(): array
    {
        return [
            '#' ,
            'الدكتور' ,
            'الكورس' ,
            'الجامعه' ,
            'القيمه الاجماليه ' ,
            'المحصل' ,
            'المتبقى' ,
            'النسبه' ,
            'المدفوع' ,
            'مستحق الدفع' ,
        ];
    }
}
