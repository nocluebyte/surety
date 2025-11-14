<?php

namespace App\DataTables;

use App\Models\Currency;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;


class CurrencyDatatable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
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
            ->editColumn('name', function ($row) {
                return $row->name ?? '';
            })
            ->rawColumns(['action', 'is_active', 'name']);
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editUrl = route('currency.edit', [encryptId($row->id)]);
        $deleteUrl = route('currency.destroy', [encryptId($row->id)]);

        if ($user->hasAnyAccess(['users.info', 'currency.edit', 'currency.delete', 'users.superadmin'])) {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                            <ul class="navi navi-hover">';
        }

        if ($user->hasAnyAccess(['currency.edit', 'users.superadmin'])) {
            $menu .= '<li class="navi-item"><a href="' . $editUrl . '" data-toggle="modal" data-target-modal="#commonModalID"  data-url="' . $editUrl . '" class="call-modal navi-link">' .
            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';
        }

        if ($user->hasAnyAccess(['currency.delete', 'users.superadmin'])) {
        $menu .= '<li class="navi-item"><a href="' . $deleteUrl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
            '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
            '</a></li>';
        }
        if ($user->hasAnyAccess(['users.info', 'users.superadmin'])) {
            $menu .= getInfoHtml($row);
        }
        if ($user->hasAnyAccess(['users.info', 'currency.edit', 'currency.delete', 'users.superadmin'])) {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $models = currency::with(['createdBy'])
            ->leftJoin('countries', 'countries.id', '=', 'currencys.country_id')
            ->select([
                'currencys.id as id',
                'countries.name as name',
                'currencys.short_name as short_name',
                'currencys.symbol as symbol',
                'currencys.is_active as is_active',
            ])
            ->whereNull('countries.deleted_at');
            
        $request = request();
        $name = $request->get('name',false);
        $short_name = $request->get('short_name',false);
        $symbol = $request->get('symbol',false);
        $status = $request->get('status',false);

        if ($name) {
            $models->where("countries.name", 'like','%' . $name . '%');
        }
        if($short_name) {$models->where('short_name', 'like', "%" . $short_name . "%");}
        if($symbol) {$models->where('symbol', 'like', "%" . $symbol . "%");}
        if($status) {$models->where('currencys.is_active', $status);}
        return $this->applyScopes($models);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
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
    private function getColumns()
    {
        return [
            ['name' => 'currency', 'data' => 'currency', 'title' => trans("currency.title")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }
}
