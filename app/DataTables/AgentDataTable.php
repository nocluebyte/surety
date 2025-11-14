<?php

namespace App\DataTables;

use App\Models\Agent;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;

class AgentDataTable extends DataTable
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
            return getStatusHtmlTeam($row);
        })
        ->rawColumns(['action', 'is_active']);
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editUrl = route('agent.edit', [encryptId($row->id)]);
        $deleteUrl = route('agent.destroy', [encryptId($row->id)]);

        if($user -> hasAnyAccess(['users.info', 'agent.edit', 'agent.delete', 'users.superadmin']))
        {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                            <ul class="navi navi-hover">';
        }

        if($user -> hasAnyAccess(['agent.edit', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $editUrl . '" data-url="' . $editUrl . '" class="navi-link">' .
            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';
        }

        if($user -> hasAnyAccess(['agent.delete', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $deleteUrl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
                '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
                '</a></li>';
        }

        if($user -> hasAnyAccess(['users.info', 'users.superadmin']))
        {
            $menu .= getInfoHtml($row);
        }

        if($user -> hasAnyAccess(['users.info', 'agent.edit', 'agent.delete', 'users.superadmin']))
        {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Agent $model)
    {
        $field = [
            DB::raw("CONCAT_WS(' ',users.first_name,users.middle_name,users.last_name) as full_name"),
            "users.email",
            "users.mobile as phone_no",
            "agents.id",
            "agents.is_active",
            "agents.city"
        ];
        $model = Agent::select($field)->leftJoin('users',function($join){
            $join->on('agents.user_id','=','users.id');
            $join->whereNull('users.deleted_at');
        });
        $fullName = request()->get('full_name');

        if (request()->get('full_name',false)) {
            $model->whereHas('user',function($q) use($fullName){
                $q->whereRaw("CONCAT_WS(' ',users.first_name,users.middle_name,users.last_name) LIKE ?", '%' . $fullName . '%');
            });
        }

        if (request()->get('email')) {
            $model->where('users.email', 'like', "%" . request()->get("email") . "%");
        }

        if(request()->get('phone_no')) {
            $model->where('users.mobile', 'like', '%' . request()->get('phone_no') . '%');
        }

        if(request()->get('city')) {
            $model->where('city', 'like', '%' . request()->get('city') . '%');
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
            ['name' => 'agent', 'data' => 'agent', 'title' => trans("agent.agent")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get the filename for export.
     */
    // protected function filename(): string
    // {
    //     return 'Agent_' . date('YmdHis');
    // }
}
