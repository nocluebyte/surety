<?php

namespace App\Exports;

use App\Models\{Account, Employee};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class SupplierExport implements FromView, ShouldAutoSize, WithEvents
{
    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        $category_type = request()->get('category_type') ?? '';
        $suppliersfilter =  request()->get('suppliersfilter') ?? '';
        $categoryfilter = request()->get('categoryfilter')  ?? '';
        $statefilter = request()->get('statefilter')  ?? '';

        $fields = [
            'accounts.id as id',
            'accounts.company_name as company_name',
            'accounts.person_name as person_name',
            'account_addresses.mobile as mobile',
            'accounts.email',
            'account_addresses.address_line1 as address_line1',
            'account_addresses.city as city',
            'accounts.category as category',
            'accounts.is_active',
            'accounts.created_by',
            'accounts.created_at',
            'accounts.updated_by',
            'accounts.updated_at',
            'states.name as states_name',
            'account_bank_details.bank_name as bank_name',
            'account_bank_details.beneficiary_name as beneficiary_name',     
            'account_bank_details.branch_name as branch_name',         
            'account_bank_details.account_no as account_no',          
            'account_bank_details.ifsc_code as ifsc_code', 
            'account_bank_details.swift_code as swift_code', 
            
        ];
        $supplierData = Account::with(['createdBy'])->select($fields)
        ->leftJoin('account_addresses', function ($join) {
            $join->on('account_addresses.account_id', '=', 'accounts.id')->where('account_addresses.address_type', '=', 'office');
        })

        ->when($suppliersfilter !='',function($query) use($suppliersfilter){
            $query->where('accounts.id',$suppliersfilter);
        })

        ->when($categoryfilter != '', function ($query) use ($categoryfilter) {
            $query->where('category', $categoryfilter);
        })

        ->when($statefilter != '', function ($query) use ($statefilter) {
            $query->where('states.id', $statefilter);
        })

        ->leftJoin('states', 'account_addresses.state_id', '=', 'states.id')
        ->leftJoin('account_bank_details', 'accounts.id', '=', 'account_bank_details.account_id')
        ->where('object_type', "Supplier")
        ->orderBy('company_name', 'Desc')
        ->groupBy('accounts.id');

        if($category_type != "Supplier"){
            $supplierData->where('category', '!=', "Supplier");
        }else{
            $supplierData->where('category', "Supplier");
        }
        $supplierData = $supplierData->get();
        $this->data['supplierData'] = $supplierData;
        $this->data['category_type'] = $category_type;
        return view('suppliers.excel-export', $this->data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A7:N7'; // All headers

                $styleArray = [
                    'font' => [
                        'bold' => true,
                        'size' => '12',
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
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
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(20);
            },
        ];
    }
}
