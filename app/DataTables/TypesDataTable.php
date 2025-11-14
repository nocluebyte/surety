<?php

namespace App\DataTables;

use App\Models\Type;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;

class TypesDataTable extends DataTable
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
            })
            ->editColumn('is_active', function ($row) {
                return getStatusHtml($row,'RM_type.edit');
                // return $this->changeStatus($row);
            })
            ->editColumn('name',function ($row) {
                $copyHtml = ' <a href="javascript:void(0)"
                class="btn btn-hover-light-primary btn-sm btn-icon copy-btn">
                <i class="fas fa-copy"></i>
            </a> ';

                $user = Sentinel::getUser();
                if ($user->hasAnyAccess(['users.superadmin'])) {
                    // return '<a href="' .route('types.show', [$row->id]) . '"  class="navi-link" target="_blank">' .
                    //     '  <span class="navi-text type-text">' .$row->name.'</span></a> '.$copyHtml;
                    return '<span class="navi-text type-text">' .$row->name.'</span> '.$copyHtml;
                } else {
                    return $row->name;

                }
            })
            ->rawColumns(['action', 'is_active','name']);
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editurl = route('types.edit', [$row->id]);
        $deleteurl = route('types.destroy', [$row->id]);
        // $rmCount = (!empty($row->rmType)) ? $row->rmType->count() : 0;
        $rmCount = 0;
       
        if ($user->hasAnyAccess(['users.info', 'RM_type.edit', 'RM_type.delete', 'users.superadmin'])) {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-right" style="">
                            <ul class="navi navi-hover">';
        }

        if ($user->hasAnyAccess(['RM_type.edit', 'users.superadmin'])) {
            $menu .= '<li class="navi-item"><a href="' . $editurl . '" data-toggle="modal" data-target-modal="#commonModalID"  data-url="' . $editurl . '" class="call-modal navi-link">' .
                            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
                        '</a></li>';
        }

       if ($user->hasAnyAccess(['RM_type.delete', 'users.superadmin']) && $rmCount == 0) {
            $menu .= '<li class="navi-item"><a href="' . $deleteurl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
                            '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
                        '</a></li>';
        }
        

        if ($user->hasAnyAccess(['users.info', 'users.superadmin'])) {
            $menu .= getInfoHtml($row);
        }
        if ($user->hasAnyAccess(['users.info', 'RM_type.edit', 'RM_type.delete', 'users.superadmin'])) {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Type $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        // $model = Type::with('rmType')->select();
        $model = Type::select();
       //dd($model->first());
        if (!empty(request()->get('name'))) {
            $model->where('name', 'like', "%" . request()->get("name") . "%");
        }
        if (!empty(request()->get('disp_in_rm_name'))) {
            $model->where('display_in_rm_name', request()->get("disp_in_rm_name"));
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
            ->parameters(['searching' => false, 'dom' => '<"wrapper"B>lfrtip', 'buttons' => ['excel', 'pdf'],])
            ->columns($this->getColumns())
            ->ajax('');
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
            Column::make('name'),
            Column::make('is_active')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    // protected function filename()
    // {
    //     return 'Types_' . date('YmdHis');
    // }
}
