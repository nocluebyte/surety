<?php

namespace App\DataTables;

use App\Models\ProjectDetail;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;

class ProjectDetailDataTable extends DataTable
{
    public function __construct(CommonController $commonController){
        $this->user = Sentinel::getUser();
        $this->role = $this->user?->roles?->first()?->slug;
        $this->team_member_id = $commonController->getTeamMemberByUserId($this->role,$this->user->id);
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
                return getStatusHtml($row);
            })
            ->editColumn('project_value', function ($row) {
                return numberFormatPrecision($row->project_value, 0);
            })
            ->editColumn('code',function($row){
                return $this->checkViewrights($row);
            })
            // ->setRowClass(function($row){
            //     return $row?->markAsRead?->created_by === $this->user->id ? '' : 'bg-light-secondary';
            // })
            ->editColumn('project_start_date', function($row){
                return $row->project_start_date ? custom_date_format($row->project_start_date, 'd/m/Y') : '-';
            })
            ->editColumn('project_end_date', function($row){
                return $row->project_end_date ? custom_date_format($row->project_end_date, 'd/m/Y') : '-';
            })
            ->rawColumns(['code', 'is_active']);
    }

    public function checkViewrights($row){

        $code = $row->code ?? '';
        $route = route('project-details.show',[encryptId($row->id)]);

        if ($this->user->hasAnyAccess(['project-details.view','users.superadmin'])) {
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
    public function query(ProjectDetail $model)
    {
        $model = ProjectDetail::with('markAsRead')->RoleBasedScope($this->role,$this->team_member_id)->select('project_details.id', 'project_details.project_name', 'project_details.code', 'project_details.project_value', 'beneficiaries.company_name as beneficiary', 'project_details.is_active', 'project_details.project_start_date', 'project_details.project_end_date')
            ->leftJoin('beneficiaries', 'project_details.beneficiary_id', '=', 'beneficiaries.id' )
            ->whereNull('project_details.deleted_at');

        if(request()->get('code')){
            $model->where('project_details.code', 'like', '%' . request()->get('code') . '%');
        }

        if(request()->get('project_value')) {
            $model->where('project_details.project_value', 'like', '%' . request()->get('project_value') . '%');
        }

        if(request()->get('project_name')) {
            $model->where('project_details.project_name', 'like', '%' . request()->get('project_name') . '%');
        }

        if(request()->get('beneficiary')) {
            $model->where('beneficiaries.company_name', 'like', '%' . request()->get('beneficiary') . '%');
        }

        if(request()->get('project_start_date')) {
            $model->where('project_start_date', 'like', '%' . request()->get('project_start_date') . '%');
        }

        if(request()->get('project_end_date')) {
            $model->where('project_end_date', 'like', '%' . request()->get('project_end_date') . '%');
        }

        $filter_project_date = request()->get('filter_project_date', false);

        if($filter_project_date) {
            $filter_project_date = explode('|', $filter_project_date);
            $startDate = !empty($filter_project_date[0]) ? custom_date_format($filter_project_date[0], 'Y-m-d') : '';
            $endDate = !empty($filter_project_date[1]) ? custom_date_format($filter_project_date[1], 'Y-m-d') : '';
            $model->when($startDate && $endDate, function($q) use ($startDate, $endDate) {
                $q->whereDate('project_start_date', '>=', $startDate)->whereDate('project_end_date', '<=', $endDate);
            });
        }

        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('projectdetail-table')
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
        return 'ProjectDetail_' . date('YmdHis');
    }
}
