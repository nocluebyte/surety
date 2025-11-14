<?php

namespace App\DataTables;

use App\Models\Beneficiary;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;

class BeneficiaryDataTable extends DataTable
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
        ->editColumn('phone_no', function ($row) {
            return $row->phone_no ?? '-';
        })
        // ->setRowClass(function($row){
        //     return $row?->markAsRead?->created_by === $this->user->id ? '' : 'bg-light-secondary'; 
        // })
        ->rawColumns(['is_active','code']);
    }

    public function checkViewrights($row){

        $code = $row->code ?? '';
        $route = route('beneficiary.show',[encryptId($row->id)]);

        if ($this->user->hasAnyAccess(['beneficiaries.view', 'users.superadmin'])) {
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
    public function query(Beneficiary $model)
    {
        $field = [
            "users.email",
            "users.mobile as phone_no",
            "beneficiaries.id",
            "beneficiaries.code",
            "beneficiaries.company_name",
            "beneficiaries.beneficiary_type",
            "beneficiaries.is_active",
            "establishment_types.name as establishment_type",
            // "type_of_entities.name as type_of_entity",
        ];
        $model = Beneficiary::with('markAsRead')->select($field)
        ->leftJoin('users', function($join) {
            $join->on('beneficiaries.user_id', '=', 'users.id')
            ->whereNull('users.deleted_at');
        })
        ->leftJoin('establishment_types', function($join) {
            $join->on('beneficiaries.establishment_type_id' ,'=' ,'establishment_types.id')
            ->whereNull('establishment_types.deleted_at');
        });
        // ->leftJoin('type_of_entities', function($join) {
        //     $join->on('beneficiaries.type_of_beneficiary_entity', '=', 'type_of_entities.id')
        //     ->whereNull('type_of_entities.deleted_at');
        // });

        if(request()->get('code')) {
            $model->where('beneficiaries.code', 'like', '%' . request()->get('code') . '%');
        }

        if(request()->get('company_name')) {
            $model->where('company_name', 'like', '%' . request()->get('company_name') . '%');
        }

        if(request()->get('beneficiary_type')) {
            $model->where('beneficiary_type', request()->get('beneficiary_type'));
        }

        if(request()->get('establishment_type')) {
            $model->where('establishment_types.id', 'like', '%' . request()->get('establishment_type') . '%');
        }

        // if(request()->get('type_of_entity')) {
        //     $model->where('type_of_entities.name', 'like', '%' . request()->get('type_of_entity') . '%');
        // }

        if (request()->get('email')) {
            $model->where('users.email', 'like', "%" . request()->get("email") . "%");
        }

        if(request()->get('phone_no')) {
            $model->where('users.mobile', 'like', '%' . request()->get('phone_no') . '%');
        }

        if (request()->get('filter_establishment_type')) {
            $model->whereHas('establishmentTypeId', function ($q) {
                $q->where('id', request()->get("filter_establishment_type"));
            });
        }

        // if (request()->get('filter_beneficiary_entity')) {
        //     $model->whereHas('typeOfBeneficiaryEntity', function ($q) {
        //         $q->where('id', request()->get("filter_beneficiary_entity"));
        //     });
        // }

        if (request()->get('filter_beneficiary_type', false)) {
            $model->where('beneficiary_type', request()->get("filter_beneficiary_type"));
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
            ['name' => 'beneficiary', 'data' => 'beneficiary', 'title' => trans("beneficiary.beneficiary")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get the filename for export.
     */
    // protected function filename(): string
    // {
    //     return 'Beneficiary_' . date('YmdHis');
    // }
}
