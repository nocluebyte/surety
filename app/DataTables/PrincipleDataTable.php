<?php

namespace App\DataTables;

use App\Models\{Principle, PrincipleType};

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;

class PrincipleDataTable extends DataTable
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
        ->editColumn('code',function($row){
            return $this->checkViewrights($row);
        })
        ->editColumn('is_active', function ($row) {
            return getStatusHtmlTeam($row);
        })
        // ->setRowClass(function($row){
        //     return $row->markAsRead ? ' ' : 'bg-light-secondary' ;
        // })
        ->rawColumns(['is_active', 'code']);
    }

    public function checkViewrights($row){

        $code = $row->code ?? '';
        $route = route('principle.show',[encryptId($row->id)]);

        if ($this->user->hasAnyAccess(['principle.view', 'users.superadmin'])) {
            $value =  "<a href='{$route}'>{$code}</a>";
        }
        else{
            $value = $code;
        }
        return $value;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Principle $model)
    {
        $field = [
            // DB::raw("CONCAT_WS(' ', users.first_name, users.middle_name, users.last_name) as full_name"),
            "users.email",
            "users.mobile as phone_no",
            "principles.id",
            "principles.principle_type_id",
            "principles.code",
            "principles.company_name",
            "principles.is_active",
            "principles.venture_type",
            "principle_types.name"
        ];
        // dd(request()->all());

        $model = Principle::with(['principleType','markAsRead'=>fn($q)=> $q->where('created_by',$this->user->id)])->select($field)
            ->leftJoin('users', function ($join) {
                $join->on('principles.user_id', '=', 'users.id')
                ->whereNull('users.deleted_at');
            })
            ->leftJoin('principle_types', function ($join) {
                $join->on('principles.principle_type_id', '=', 'principle_types.id')
                ->whereNull('principle_types.deleted_at');
            });

        $fullName = request()->get('full_name');

        if (request()->get('name')) {
            $model->where('principle_types.name', 'like', '%' . request()->get('name') . '%');
        }

        if(request()->get('code')){
            $model->where('code', 'like', '%' . request()->get('code') . '%');
        }

        if(request()->get('company_name')){
            $model->where('company_name', 'like', '%' . request()->get('company_name') . '%');
        }

        // if (request()->get('full_name',false)) {
        //     $model->whereHas('user',function($q) use($fullName){
        //         $q->whereRaw("CONCAT_WS(' ',users.first_name,users.middle_name,users.last_name) LIKE ?", '%' . $fullName . '%');
        //     });
        // }

        if (request()->get('email')) {
            $model->where('users.email', 'like', "%" . request()->get("email") . "%");
        }

        if(request()->get('phone_no')) {
            $model->where('users.mobile', 'like', '%' . request()->get('phone_no') . '%');
        }

        if(request()->get('venture_type')) {
            $model->where('venture_type', 'like', '%' . request()->get('venture_type') . '%');
        }

        if (request()->get('filter_principle_types')) {
            $model->whereHas('principleType', function ($q) {
                $q->where('id', request()->get("filter_principle_types"));
            });
        }

        if (request()->get('filter_venture_type', false)) {
            $model->where('venture_type', request()->get("filter_venture_type"));
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
            ['name' => 'principle', 'data' => 'principle', 'title' => trans("principle.principle")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get the filename for export.
     */
    // protected function filename(): string
    // {
    //     return 'Principle_' . date('YmdHis');
    // }
}
