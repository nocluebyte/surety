<?php

namespace App\DataTables;

use App\Models\{Principle, DMS};
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use App\Http\Controllers\CommonController;

class DmsDataTable extends DataTable
{
       public function __construct(CommonController $commonController){
        $this->user = Sentinel::getUser();
        $this->role = $this->user?->roles?->first()?->slug;
        $this->team_member_id = $commonController->getTeamMemberByUserId($this->role,$this->user->id);
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) {
                return $this->checkrights($row);
            })
            ->editColumn('code', function ($row) {
                $user = Sentinel::getUser();
                if ($user->hasAnyAccess(['dms.view', 'users.superadmin'])) {
                    return '<a href="' . route('dms.show', ['contractor_id' => encryptId($row->id), encryptId($row->id)]) . '"  class="navi-link">' .
                        '<span class="navi-text">' . $row->code . '</span>' .
                        '</a>';
                } else {
                    return $row->code;
                }
            })->editColumn('company_name', function ($row) {
                $user = Sentinel::getUser();
                if ($user->hasAnyAccess(['dms.view', 'users.superadmin'])) {
                    return '<a href="' . route('dms.show', ['contractor_id' => encryptId($row->id), encryptId($row->id)]) . '"  class="navi-link">' .
                        '<span class="navi-text">' . $row->company_name . '</span>' .
                        '</a>';
                } else {
                    return $row->company_name;
                }
            })
            ->rawColumns(['action', 'code', 'company_name']);
    }
    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editUrl = route('dms.edit', [$row->id]);
        $deleteUrl = route('dms.destroy', [$row->id]);

        if ($user->hasAnyAccess(['dms.edit', 'dms.delete', 'users.superadmin'])) {
            $menu .= '<td class="text-center">
                    <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                    <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ki ki-bold-more-hor"></i>
                    </a>
                    <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                        <ul class="navi navi-hover">';
        }

        if ($user->hasAnyAccess(['dms.delete', 'users.superadmin'])) {
            $menu .= '<li class="navi-item"><a href="' . $deleteUrl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
                '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
                '</a></li>';
        }
        if ($user->hasAnyAccess(['dms.edit', 'dms.delete', 'users.superadmin'])) {
            $menu .= "</div></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Dm $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DMS $model)
    {
        $user = Sentinel::getUser();
        $role = $user->roles->first();
        $cin = request()->get('cin', false);
        $company_name = request()->get('company_name', false);

        $fields = [
            'principles.*',
        ];

        $model = Principle::RoleBasedScope($this->role,$this->team_member_id)->select($fields);
        if ($cin) {
            $model->where('principles.code', 'like', "%" . $cin . "%");
        }
        if ($company_name) {
            $model->where('principles.company_name', 'like', "%" . $company_name . "%");
        }
        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('dms-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
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
}
