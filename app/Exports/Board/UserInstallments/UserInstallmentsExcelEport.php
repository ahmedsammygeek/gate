<?php

namespace App\Exports\Board\UserInstallments;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserInstallmentsExcelEport implements FromCollection , WithHeadings  , WithMapping , ShouldAutoSize , WithEvents
{


    protected $UserInstallments;
    protected $i;

    public function __construct($UserInstallments)
    {
        $this->i = 1;
        $this->UserInstallments = $UserInstallments;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->UserInstallments;
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


    public function headings(): array
    {
        return [
            '#' ,
            'رقم القسط' ,
            'قيمه القسط' , 
            'تاريخ الاستحقاق' , 
            'رقم عمليه الشراء ' , 
            'حاليه الدفع' , 
            'بيانات عمليه الدفع' ,            
        ];
    }
    
    /**
    * @var Invoice $invoice
    */
    public function map($installment): array
    {
        return [
            $this->i++ ,
            $installment->installment_number,
            $installment->amount,
            $installment->due_date,
            $installment->purchase?->purchase_number,
            $installment->status == 1 ? 'تم الدفع' : 'لم يتد الفدع',
            $installment->transaction?->purchase_number,
        ];
    }


    
}
