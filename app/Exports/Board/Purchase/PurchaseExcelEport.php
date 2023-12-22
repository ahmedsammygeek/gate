<?php

namespace App\Exports\Board\Purchase;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PurchaseExcelEport  implements FromCollection , WithHeadings  , WithMapping , ShouldAutoSize , WithEvents
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
            $purchase->purchase_number,
            $purchase->created_at,
            $purchase->purchaseTypeAsText() ,
            $purchase->purchasePayingStatusAsText()  ,
            $purchase->subtotal ,
            $purchase->total ,
            $purchase->user?->name,
            $purchase->user?->phone,
            $purchase->purchaseItemsAsText() ,
        ];
    }


    public function headings(): array
    {
        return [
            '#' ,
            'رقم عمليه الشراء' ,
            'تاريخ عمليه الشراء' ,
            'نوع عمليه الشراء' ,
            'هل تم الدفع' ,
            'المبلغ الفرعى' ,
            'المبلغ النهائى' ,
            'اسم المستخدم' ,
            'رقم موبيل المستخدم' ,
            'عنصار الشراء' ,
        ];
    }


}
