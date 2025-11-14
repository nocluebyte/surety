<?php

namespace App\DataTables;

use App\Models\Year;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use DB;


class YearDataTable extends DataTable
{
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
        })->editColumn('is_default', function ($row) {
            return getDefaultHtml($row,'years.edit');
        })->editColumn('is_displayed', function ($row) {
            return getDisplayHtml($row,'years.edit');
        })->rawColumns(['action', 'is_default','is_displayed']);
        
    }
    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editUrl = route('year.edit', [encryptId($row->id)]);
        $deleteUrl = route('year.destroy', [encryptId($row->id)]);

        if ($user->hasAnyAccess(['users.info', 'years.edit', 'years.delete', 'users.superadmin'])) {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                            <ul class="navi navi-hover">';
        }

        if ($user->hasAnyAccess(['years.edit', 'users.superadmin'])) {
            $menu .= '<li class="navi-item"><a href="' . $editUrl . '" data-toggle="modal" data-target-modal="#commonModalID"  data-url="' . $editUrl . '" class="call-modal navi-link">' .
            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';
        }

        if ($user->hasAnyAccess(['years.delete', 'users.superadmin'])) {
        $menu .= '<li class="navi-item"><a href="' . $deleteUrl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
            '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
            '</a></li>';
        }
        if ($user->hasAnyAccess(['users.info', 'users.superadmin'])) {
            $menu .= getInfoHtml($row);
        }
        if ($user->hasAnyAccess(['users.info', 'years.edit', 'years.delete', 'users.superadmin'])) {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Year $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Year $model)
    {
        $model = Year::select('years.id as id',
        DB::raw("DATE_FORMAT(years.from_date, '%d-%m-%Y') as from_date"),DB::raw("DATE_FORMAT(years.to_date, '%d-%m-%Y') as to_date"),'years.yearname as yearname','years.is_default as is_default','years.is_displayed as is_displayed');


        if (request()->get('yearname', false)) {
            $model->where('yearname', 'like', "%" . request()->get("yearname") . "%");
        }
        if (request()->get('is_default', false)) {
            $model->where('is_default', 'like', "%" . request()->get("is_default") . "%");
        }
        if (request()->get('from_date', false)) {
            $model->where('from_date', 'like', "%" . request()->get("from_date") . "%");
        }
        if (request()->get('to_date', false)) {
            $model->where('to_date', 'like', "%" . request()->get("to_date") . "%");
        }
        return $this->applyScopes($model->newQuery());
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('year-table')
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

    /**
     * Get filename for export.
     *
     * @return string
     */
    // protected function filename()
    // {
    //     return 'Year_' . date('YmdHis');
    // }
}
