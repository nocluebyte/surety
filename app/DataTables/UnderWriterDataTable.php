<?php

namespace App\DataTables;

use App\Models\UnderWriter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;

class UnderWriterDataTable extends DataTable
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
        return dataTables()
        ->eloquent($query)
        ->addColumn('action', function ($row) {
            return $this->checkrights($row);
        })
        ->editColumn('is_active', function ($row) {
            return getStatusHtmlTeam($row);
        })
        ->editColumn('full_name', function ($row) {
            return $this->checkViewrights($row);
        })
        ->rawColumns(['action', 'is_active', 'full_name']);
    }

    public function checkViewrights($row){
        $full_name = $row->full_name ?? '';
        $route = route('underwriter.show',[encryptId($row->id)]);
        
        if ($this->user->hasAnyAccess(['underwriter.view','users.superadmin'])) {
            $value =  "<a href='{$route}'>{$full_name}</a>";
        }
        else{
            $value = $full_name;
        }
        return $value;
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editUrl = route('underwriter.edit', [encryptId($row->id)]);
        $deleteUrl = route('underwriter.destroy', [encryptId($row->id)]);

        if($user -> hasAnyAccess(['users.info', 'underwriter.edit', 'underwriter.delete', 'users.superadmin']))
        {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                            <ul class="navi navi-hover">';
        }

        if($user -> hasAnyAccess(['underwriter.edit', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $editUrl . '" data-url="' . $editUrl . '" class="navi-link">' .
            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';
        }

        if($user -> hasAnyAccess(['underwriter.delete', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $deleteUrl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
                '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
                '</a></li>';
        }

        if($user -> hasAnyAccess(['users.info', 'users.superadmin']))
        {
            $menu .= getInfoHtml($row);
        }

        if($user -> hasAnyAccess(['users.info', 'underwriter.edit', 'underwriter.delete', 'users.superadmin']))
        {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UnderWriter $model)
    {
        $field = [
            DB::raw("CONCAT_WS(' ', users.first_name,users.middle_name,users.last_name) as full_name"),
            "users.email",
            "users.mobile as phone_no",
            "underwriters.id",
            "underwriters.type",
            "underwriters.is_active",
        ];
        $model = UnderWriter::select($field)->leftJoin('users', function($join) {
            $join->on('underwriters.user_id', '=', 'users.id');
            $join->whereNull('users.deleted_at');
        });
        $fullName = request()->get('full_name');

        if (request()->get('full_name',false)) {
            $model->whereHas('user',function($q) use($fullName){
                $q->whereRaw("CONCAT_WS(' ',users.first_name,users.middle_name,users.last_name) LIKE ?", '%' . $fullName . '%');
            });
        }

        if(request()->get('type')){
            $model->where('type', 'like', '%' . request()->get('type') . '%');
        }

        if (request()->get('email')) {
            $model->where('users.email', 'like', "%" . request()->get("email") . "%");
        }

        if(request()->get('phone_no')) {
            $model->where('users.mobile', 'like', '%' . request()->get('phone_no') . '%');
        }

        if (request()->get('underwriter_type', false)) {
            $model->where('type', request()->get("underwriter_type"));
        }

        if (request()->get('status', false)) {
            $model->where('underwriters.is_active', request()->get("status"));
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
            ['name' => 'underwriter', 'data' => 'underwriter', 'title' => trans("underwriter.underwriter")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get the filename for export.
     */
    // protected function filename(): string
    // {
    //     return 'UnderWriter_' . date('YmdHis');
    // }
}
