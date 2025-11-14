<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TenderWiseExport implements FromView, ShouldAutoSize, WithEvents
{
    public function __construct($export_data){
        $this->data = $export_data;
    }

    public function view(): View
    {
        $this->data['checkedFields'] = $this->data['checkedFields'];
        $this->data['fields'] = collect(config('report.tender_wise'));
        $this->data['tender'] = $this->data['tender_wise_data'];
        return view('reports.tender_wise.tender_wise_export', $this->data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:P1';

                $styleArray = [
                    'font' => [
                        'bold' => true,
                        'size' => '12',
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'd9e1f2',
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(50);
            },
        ];
    }
}
