<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Controllers\NbiController;

class NbiExport implements FromView, ShouldAutoSize, WithEvents, WithColumnFormatting
{
    public function __construct($data) {
        $this->data = $data;
    }

    public function columnFormats(): array
    {
        return [];
    }

    public function view(): View
    {
        $id = $this->data['id'];
        $nbiCtl = new NbiController;
        $nbi_data = $nbiCtl->show($id,true);
        $this->data = array_merge($this->data,$nbi_data);
        return view('nbi.export', $this->data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $colspan = "B";
                $cellRange = 'A1:'.$colspan .'1'; // All headers
                $alignLeft = 'B2:B32';

                $styleArray = [
                    'font' => [
                        'bold' => true,
                        'size' => '12',
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
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

                $alignLeftStyle = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ];
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:'.$colspan .'1')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getRowDimension('6')->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle($alignLeft)->applyFromArray($alignLeftStyle);
            },
        ];
    }
}
