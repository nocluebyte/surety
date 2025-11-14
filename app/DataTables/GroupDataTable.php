<?php

namespace App\DataTables;

use App\Models\Group;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;

class GroupDataTable extends DataTable
{
    public function __construct(){
        $user = Sentinel::getUser();
        $this->user = $user;
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) {
                return $this->checkrights($row);
            })
            ->editColumn('is_active', function ($row) {
                return getStatusHtml($row);
            })
            ->editColumn('code', function ($row) {
                return $this->checkViewrights($row);
            })
            ->editColumn('group_contractor_count', function ($row) {
                return $row->group_contractor_count + 1 ;
            })
            ->rawColumns(['action', 'is_active', 'code','group_contractor_count']);
    }

    public function checkViewrights($row){

        $code = $row->contractor->code ?? '';
        $route = route('group.show',[encryptId($row->id)]);
        if ($this->user->hasAnyAccess(['group.view', 'users.superadmin'])) {
            $value =  "<a href='{$route}'>{$code}</a>";
        }
        else{
            $value = $code;
        }
        return $value;
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editUrl = route('group.edit', [encryptId($row->id)]);

        if($user -> hasAnyAccess(['users.info', 'group.edit', 'users.superadmin']))
        {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                            <ul class="navi navi-hover">';
        }

        if($user -> hasAnyAccess(['group.edit', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $editUrl . '" data-url="' . $editUrl . '" class="navi-link">' .
            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';
        }

        if($user -> hasAnyAccess(['users.info', 'users.superadmin']))
        {
            $menu .= getInfoHtml($row);
        }

        if($user -> hasAnyAccess(['users.info', 'group.edit', 'users.superadmin']))
        {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Group $model)
    {
        $field = [
            'groups.id',
            'principles.code',
            'principles.company_name',
            'groups.contractor_id',
        ];

        $model = Group::select($field)->with(['contractor'])->withCount('groupContractor')
                    ->leftJoin('principles', function($join){
                        $join->on('groups.contractor_id', '=', 'principles.id');
                        $join->whereNull('principles.deleted_at');
                    });

        if(request()->get('code')){
            $model->where('principles.code', 'like', '%' . request()->get('code') . '%');
        }

        if(request()->get('name')){
            $model->where('principles.company_name', 'like', '%' . request()->get('name') . '%');
        }

        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('group-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Group_' . date('YmdHis');
    }
}
