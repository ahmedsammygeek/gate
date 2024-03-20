<?php

namespace App\Exports;


use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class AllStudentSuscriptionsExcelExport implements FromCollection , WithHeadings  , WithMapping , ShouldAutoSize , WithEvents
{
     protected $purchases;
    protected $i;

    public function __construct($purchases)
    {
        $this->i = 1;
        $this->purchases = $purchases;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->purchases->get();
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
    public function map($purchase): array
    {
        return [
            $this->i++ ,
            $purchase->created_at,
            $purchase->user?->name,
            $purchase->user?->phone,
            $purchase->user?->email,
            $purchase->transactions()->sum('amount') , 
            ($purchase->total - $purchase->transactions()->sum('amount')) , 
            ($purchase->total - $purchase->transactions()->sum('amount')) == 0 ? 'مدفوع' : 'متبقى'
        ];
    }


    public function headings(): array
    {
        return [
            '#' ,
            'التاريخ' ,
            'اسم الطالب' ,
            'رقم الواتس' ,
            'البريد الاكترونى' ,
            'مدفوع' ,
            'متبقى' ,
            'الحاله' ,
        ];
    }
}
