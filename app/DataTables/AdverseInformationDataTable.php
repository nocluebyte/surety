<?php

namespace App\DataTables;

use App\Models\AdverseInformation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;

class AdverseInformationDataTable extends DataTable
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
            ->editColumn('is_active', function($row){
                // return getStatusHtml($row);
                return getInactiveStatus($row);
            })
            ->editColumn('code',function($row){
                return $this->checkViewrights($row);
            })
            ->editColumn('source_date', function($row){
                return custom_date_format($row->source_date, 'd/m/Y');
            })
            ->rawColumns(['is_active', 'code']);
    }

    public function checkViewrights($row){

        $code = $row->code ?? '';
        $route = route('adverse-information.show',[encryptId($row->id)]);

        if ($this->user->hasAnyAccess(['adverse_information.view', 'users.superadmin'])) {
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
    public function query(AdverseInformation $model)
    {
        $model = AdverseInformation::select('adverse_informations.id', 'adverse_informations.contractor_id', 'adverse_informations.source_of_adverse_information', 'adverse_informations.is_active', 'principles.company_name as company_name', 'adverse_informations.source_date', 'adverse_informations.created_by', 'adverse_informations.code', 'principles.code as contractorId', DB::raw('CONCAT_WS(" ", users.first_name,users.middle_name,users.last_name) as added_by'))
            ->leftJoin('principles', 'adverse_informations.contractor_id', '=', 'principles.id')
            ->leftJoin('users', 'adverse_informations.created_by', '=', 'users.id')
            ->whereNull('adverse_informations.deleted_at')
            ->groupBy('adverse_informations.id');
        $filter_created_date = request()->get('filter_created_date', false);
        $added_by = request()->get('added_by');

        if (request()->get('code')) {
            $model->where('adverse_informations.code', 'like', '%' . request()->get('code') . '%');
        }

        if(request()->get('contractorId')) {
            $model->where('principles.code', 'like', '%' . request()->get('contractorId') . '%');
        }

        if(request()->get('added_by')) {
            $model->whereRaw("CONCAT_WS(' ',users.first_name,users.middle_name,users.last_name) LIKE ?", '%' . $added_by . '%');
        }

        if (request()->get('company_name')) {
            $model->where('company_name', 'like', '%' . request()->get('company_name') . '%');
        }

        if (request()->get('source_of_adverse_information')) {
            $model->where('source_of_adverse_information', 'like', '%' . request()->get('source_of_adverse_information') . '%');
        }

        if (request()->get('source_date')) {
            $model->where('source_date', 'like', '%' . request()->get('source_date') . '%');
        }

        if($filter_created_date) {
            $filter_created_date = explode('|', $filter_created_date);
            $fromDate = !empty($filter_created_date[0]) ? custom_date_format($filter_created_date[0], 'Y-m-d') : '';
            $toDate = !empty($filter_created_date[1]) ? custom_date_format($filter_created_date[1], 'Y-m-d') : '';
            $model->when($fromDate && $toDate, function($q) use ($fromDate, $toDate) {
                $q->whereDate('source_date', '>=', $fromDate)->whereDate('source_date', '<=', $toDate);
            });
        }

        if(request()->get('filter_status')) {
            $model->where('adverse_informations.is_active', 'like', '%' . request()->get('filter_status') . '%');
        }

        if(request()->get('filter_contractor_id')) {
            $model->where('principles.id', request()->get('filter_contractor_id'));
        }

        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('adverseinformation-table')
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
        return 'AdverseInformation_' . date('YmdHis');
    }
}
