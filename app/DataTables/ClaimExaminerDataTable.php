<?php

namespace App\DataTables;

use App\Models\ClaimExaminer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;

class ClaimExaminerDataTable extends DataTable
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
        $route = route('claim-examiner.show',[encryptId($row->id)]);
        
        if ($this->user->hasAnyAccess(['claim_examiner.view','users.superadmin'])) {
            $value =  "<a href='{$route}'>{$full_name}</a>";
        }
        else{
            $value = $full_name;
        }
        return $value;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ClaimExaminer $model)
    {
        $field = [
            DB::raw("CONCAT_WS(' ', users.first_name,users.middle_name,users.last_name) as full_name"),
            "users.email",
            "users.mobile as phone_no",
            "claim_examiners.id",
            "claim_examiners.is_active",
        ];
        $model = ClaimExaminer::select($field)->leftJoin('users', function($join) {
            $join->on('claim_examiners.user_id', '=', 'users.id');
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

        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('claimexaminer-table')
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
        return 'ClaimExaminer_' . date('YmdHis');
    }
}
