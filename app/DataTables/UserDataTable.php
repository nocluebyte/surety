<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder;
use Sentinel;
use Activation;
use DB;

class UserDataTable extends DataTable
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

                $except = config('srtpl.users_form_role_except');

                if (!in_array($row->role,$except)) {
                   return  getStatusHtml($row);
                }
               
                return getStatusHtml($row,   "disabled");
                
   
            })->editColumn('name',function ($row) {
                $user = Sentinel::getUser();
                if ($user->hasAnyAccess(['users.view', 'users.superadmin'])) {
                        return '<a href="' .route('users.show', [encryptId($row->id)]) . '"  class="navi-link">' .
                        '<span class="navi-text">' .$row->name . '</span>' .
                    '</a>';
                } else{
                    return $row->name;
                }
            })->editColumn('email', function ($row) {
                $userPer = Sentinel::findById($row->id);
                $per = '';
                if($userPer->hasAnyAccess(['users.superadmin'])){
                    $per = '<span class="badge text-blue font-weight-bolder">S</span>';
                }
                return $row->email.' '.$per;
            })
            ->editColumn('role', function ($row) {
                $user = Sentinel::getUser();
                if($user->hasAnyAccess(['roles.edit', 'users.superadmin'])){
                    return '<a href="' .route('roles.edit', [encryptId($row->roles_id)]) . '"  class="navi-link" target="_blank">' .
                                '<span class="navi-text">' .$row->role . '</span>' .
                            '</a>';
                } else {
                    return $row->role;
                }
            })
            ->editColumn('emp_type', function ($row) {
                if($row->emp_type == 'non-employee'){
                    return 'Non Employee';
                } else if($row->emp_type == 'employee'){
                    return 'Employee';
                }
                //return $orders->user->firstname.' '.$orders->user->lastname;
            })->rawColumns(['action','is_active','email','name', 'role'])
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('id', 'desc');
            });;
    }

    public function checkrights($row)
    {
        // $user = Sentinel::getUser();
        $menu = '';
        $editurl = route('users.edit', [$row->id]);
        $deleteurl = route('users.destroy', [$row->id]);
        $menu .= '<td class="text-center">
                    <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                    <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ki ki-bold-more-hor"></i>
                    </a>
                    <div class="dropdown-menu m-0 dropdown-menu-right" style="">
                        <ul class="navi navi-hover">';   
        
        $menu .= '<li class="navi-item"><a href="' . $editurl . '" class="navi-link">' .
                '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';


        $menu .= getInfoHtml($row);

        /* $menu .= '<li class="navi-item"><a href="' . $deleteurl . '" class="delete-confrim navi-link">' .
                '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
            '</a></li>'; */

        $menu .= "</ul></div></div></td>";

        return $menu;
    }

    public function changeStatus($row) {
        $statusHtml = "";
        $url = route('common.change-status', [encryptId($row->id)]);
        $table = "dataTableBuilder";
        if (strtoupper($row->is_active) == 'YES' && $row->is_active !== NULL) {
            $statusHtml = '<div class="text-center">
                <span class="switch switch-icon switch-md">
                    <label>
                        <input type="checkbox" class="change-status" id="status_' . $row->id . '" name="status_' . $row->id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $row->id . '"  checked>
                        <span></span>
                    </label>
                </span>
                </div>';
        } else {
            $statusHtml = '
                    <div class="text-center">
                        <span class="switch switch-icon switch-md">
                            <label>
                                <input type="checkbox" class="change-status" id="status_' . $row->id . '" name="status_' . $row->id . '" data-url="' . $url . '" value="' . $row->id . '" data-table="' . $table . '">
                                <span></span>
                            </label>
                        </span>
                    </div>';
        }
        return $statusHtml;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $fields = [
            DB::raw('(
            CASE 
            WHEN roles.slug = "beneficiary" THEN beneficiaries.company_name 
            WHEN roles.slug = "contractor" THEN principles.company_name
            ELSE CONCAT(users.first_name, " ", users.last_name) END) as name
            '),
            "users.*",
            "roles.name as role",
            "roles.id as role_id"
        ];

        $models = User::with(['getFullName', 'usersRole.roleName'])
            ->select($fields)
            ->leftjoin("role_users", function ($join) {
                $join->on("role_users.user_id", "=", "users.id");
            })
            ->leftjoin("roles", function ($join) {
                $join->on("role_users.role_id", "=", "roles.id");
            })
            ->leftjoin('beneficiaries', 'users.id', '=', 'beneficiaries.user_id')
            ->leftJoin('principles', 'users.id', '=', 'principles.user_id');

        if (request()->get('name', false)) {
            $models->whereHas('getFullName', function ($q) {
                $q->where(DB::raw('CASE 
                WHEN roles.slug = "beneficiary" THEN beneficiaries.company_name 
                WHEN roles.slug = "contractor" THEN principles.company_name
                ELSE CONCAT(first_name," ",last_name) END'), 'like', "%" . request()->get("name") . "%");
            });
        }
        if (request()->get('email', false)) {
            $models->where('users.email', 'like', "%" . request()->get("email") . "%");
        }
        if (request()->get('role', false)) {
            $models->whereHas('usersRole.roleName', function ($q) {
                $q->where('name', 'like', "%" . request()->get("role") . "%");
            });
        }
        $model->orderByDesc('id');
        return $this->applyScopes($models);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('user-table')
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
    //     return 'User_' . date('YmdHis');
    // }
}
