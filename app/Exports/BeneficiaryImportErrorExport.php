<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BeneficiaryImportErrorExport implements FromView, ShouldAutoSize
{
    public function __construct($data){
        $this->data['excel_error'] = $data;
        // dd($this->data['excel_error']);
    }

    public function view(): View
    {
       return view('beneficiary.export.beneficiary_import_error_export', $this->data);
    }

    public function headings(): array
    {
        return [
            'registration_no',
            'company_name',
            'email',
            'mobile',
            'address',
            'country',
            'state',
            'city',
            'gst_no',
            'pan_no',
            'beneficiary_type',
            'establishment_type',
            'ministry_type',
            'bond_wording',
            'website',
            'pincode',
            'trade_sector',
            'from',
            'till',
            'is_main',
        ];
    }
}