<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TenderImportErrorExport implements FromView, ShouldAutoSize
{
    public function __construct($data){
        $this->data['excel_error'] = $data;
        // dd($this->data['excel_error']);
    }

    public function view(): View
    {
       return view('tender.export.tender_import_error_export', $this->data);
    }

    public function headings(): array
    {
        return [
            'tender_id',
            'tender_header',
            'tender_description',
            'location',
            'project_type',
            'beneficiary',
            'contract_value',
            'period_of_contract',
            'bond_value',
            'bond_type',
            'type_of_contracting',
            'rfp_date',
            'project_description',
            'project_details_id',
        ];
    }
}