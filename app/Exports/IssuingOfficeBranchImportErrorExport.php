<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IssuingOfficeBranchImportErrorExport implements FromView, ShouldAutoSize
{
    public function __construct($data){
        $this->data['excel_error'] = $data;
        // dd($this->data['excel_error']);
    }

    public function view(): View
    {
       return view('issuing_office_branch.export.issuing_office_branch_import_error_export', $this->data);
    }

    public function headings(): array
    {
        return [
            'branch_name',
            'branch_code',
            'address',
            'country',
            'state',
            'city',
            'gst_no',
            'oo_cbo_bo_kbo',
            'bank',
            'bank_branch',
            'account_no',
            'ifsc',
            'micr',
            'mode',
        ];
    }
}