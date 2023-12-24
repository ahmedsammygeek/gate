<?php

namespace App\Exports;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class UsersExport implements FromCollection , WithHeadings  , WithMapping , ShouldAutoSize , WithEvents
{
    protected $users;
    protected $i;

    public function __construct($users)
    {
        $this->i = 1;
        $this->users = $users;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->users->get();
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
    public function map($user): array
    {
        return [
            $this->i++ ,
            $user->name,
            $user->email,
            $user->phone,
            $user->created_at->toFormattedDateString(),
            $user->university?->title,
            $user->studyTypeAsText(),
            count($user->courses) ? 'مشترك' : 'غير مشترك' ,
            $user->is_banned == 1 ?  'غير فعال' : 'فعال' ,
        ];
    }


    public function headings(): array
    {
        return [
            '#' ,
            'الطالب' ,
            'الاميل' ,
            'رقم اوواتس' ,
            'تاريخ الاشتارك' ,
            'الجامعه' ,
            'نعم الدراسه' ,
            'التفاعل' ,
            'الحاله' ,
        ];
    }

}
