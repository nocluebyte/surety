<?php

namespace App\DataTables;

use App\Models\IssuingOfficeBranch;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;

class IssuingOfficeBranchDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable($query)
    {
        return dataTables()
        ->eloquent($query)
        ->addColumn('action', function ($row) {
            return $this->checkrights($row);
        })
        ->editColumn('is_active', function ($row) {
            return getStatusHtml($row);
        })
        ->rawColumns(['action', 'is_active']);
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editUrl = route('issuing-office-branch.edit', [encryptId($row->id)]);
        $deleteUrl = route('issuing-office-branch.destroy', [encryptId($row->id)]);

        if($user -> hasAnyAccess(['users.info', 'issuing_office_branch.edit', 'issuing_office_branch.delete', 'users.superadmin']))
        {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                            <ul class="navi navi-hover">';
        }

        if($user -> hasAnyAccess(['issuing_office_branch.edit', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $editUrl . '" data-url="' . $editUrl . '" class="navi-link">' .
            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';
        }

        if($user -> hasAnyAccess(['issuing_office_branch.delete', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $deleteUrl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
                '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
                '</a></li>';
        }

        if($user -> hasAnyAccess(['users.info', 'users.superadmin']))
        {
            $menu .= getInfoHtml($row);
        }

        if($user -> hasAnyAccess(['users.info', 'issuing_office_branch.edit', 'issuing_office_branch.delete', 'users.superadmin']))
        {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(IssuingOfficeBranch $model)
    {
        $model = IssuingOfficeBranch::select('id' ,'branch_name', 'branch_code', 'address', 'country_id', 'state_id', 'city', 'gst_no', 'oo_cbo_bo_kbo', 'bank', 'bank_branch', 'account_no', 'ifsc', 'micr', 'mode', 'is_active');

        if(request()->get('branch_name')){
            $model->where('branch_name', 'like', '%' . request()->get('branch_name') . '%');
        }

        if(request()->get('branch_code')){
            $model->where('branch_code', 'like', '%' . request()->get('branch_code') . '%');
        }

        // if(request()->get('cin_no')){
        //     $model->where('cin_no', 'like', '%' . request()->get('cin_no') . '%');
        // }

        if(request()->get('bank')){
            $model->where('bank', 'like', '%' . request()->get('bank') . '%');
        }

        // if(request()->get('sac_code')){
        //     $model->where('sac_code', 'like', '%' . request()->get('sac_code') . '%');
        // }

        if(request()->get('mode')){
            $model->where('mode', 'like', '%' . request()->get('mode') . '%');
        }

        if(request()->get('filter_mode')){
            $model->where('mode', 'like', '%' . request()->get('filter_mode') . '%');
        }

        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
            ->parameters(['searching' => false, 'dom' => '<"wrapper"B>lfrtip', 'buttons' => ['excel', 'pdf'],])
            ->columns($this->getColumns())
            ->ajax('');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            ['name' => 'issuing_office_branch', 'data' => 'issuing_office_branch', 'title' => trans("issuing_office_branch.issuing_office_branch")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'IssuingOfficeBranch_' . date('YmdHis');
    }
}
