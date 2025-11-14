<?php

namespace App\Http\Controllers;

use App\Models\ClaimExaminer;
use App\Models\DocumentType;
use App\Models\FileSource;
use App\Models\InvocationReason;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Role, User, AccountType, AdditionalBond};
use App\Models\{Country, State,Attribute,Type};
use App\Models\{Industry, LeadSource, LeadStatus, MinistryType, ProposalAdditionalBonds};
use App\Models\{Location,Color, HsnCode, Category, YearWiseScope,StoreItemOpening,SalesOrder, InsuranceCompanies, Agent, Broker, RelevantApproval, FacilityType, ProjectType, BankingLimitCategory, TradeSector, UnderWriter, Principle, BidBond, FinancingSources, BondTypes, Beneficiary, TypeOfEntity, EstablishmentType, Proposal, Designation, DMS, Employee, RelationshipManager,ReInsuranceGrouping,Currency,WorkType,IssuingOfficeBranch, PrincipleType, AdverseInformation, Blacklist, RejectionReason, BondPoliciesIssueChecklist, BondPoliciesIssue, Year, PerformanceBond, AdvancePaymentBond, RetentionBond, MaintenanceBond, Bonds, Agency, AgencyRating, ProjectDetail, TypeofForeClosure, InvocationNotification};
use App\Models\Section;
use App\Models\Item;
use App\Models\ItemSubCategory;
use App\Models\Account;
use App\Models\Penalty;
use App\Models\Store;
use App\Models\Setting;
use App\Models\Shift;
use App\Models\IssueItem;
use App\Models\ReturnItem;
use App\Models\{TypeOfGrade, RmCategory, Tender, Tenure};
use Carbon\Carbon;
use DB;
use Firebase;
use Sentinel;
use Schema;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Exceptions\MailTemplateException;
use URL;

class CommonController extends Controller
{
    public $successStatus = 200;
    public $response_json = [];
    protected $data = [];
    protected $request;

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->request = request();
        $this->response_json['message'] = 'Success';
    }

    /**
     * [changeStatus description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function changeStatus(Request $request, $id)
    {

        $table = $request->table;
        if (Schema::hasColumn($table, 'is_active')) {
            $is_active  = $request->status == 'true' ? 'Yes' : 'No';
            $tableRes = DB::table($table)->where('id', $request->id)->update(['is_active' => $is_active]);
        } else {
            $is_active  = $request->status == 'true' ? 'Active' : 'InActive';
            $tableRes = DB::table($table)->where('id', $request->id)->update(['status' => $is_active]);
        }

        $message = $request->status == 'true' ? __('common.active') : __('common.deactivate');

        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public function changeInactiveStatus(Request $request, $id)
    {
        $table = $request->table;
        if (Schema::hasColumn($table, 'is_active')) {
            $is_active  = $request->status == 'true' ? 'Yes' : 'No';
            $tableRes = DB::table($table)->where('id', $request->id)->update(['is_active' => $is_active]);
        } else {
            $is_active  = $request->status == 'true' ? 'Active' : 'InActive';
            $tableRes = DB::table($table)->where('id', $request->id)->update(['status' => $is_active]);
        }

        // $message = $request->status == 'true' ? __('common.active') : __('common.deactivate');

        $checked = '';
        if($request->status == 'true') {
            return response()->json([
                'success' => true,
                'message' => __('common.active')
            ], 200);
        } else {
            $url = route('common.change-inactive-status', [$id]);
            $statusHtml = '<div class="text-center">
            <span class="switch switch-icon switch-md">
                <label>
                    <input type="checkbox" class="change-inactive-status" id="status_' . $id . '" name="status_' . $id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $id . '" '.$checked.'>
                    <span></span>
                </label>
            </span>
            </div>';
            return $statusHtml;
        }
    }

    public function getItemData($id = null)
    {
        $request = request();
        $id = $request->get('id', $id);
        $item = Item::with(['unitName'])
            ->where('items.id', $id)
            ->get();
        return response()->json($item);
    }

    public function getStates($country_id = null, $state_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $states = State::select('id AS value', 'name AS text')
                ->when($request->country_id, function ($query) use ($request) {
                    $query->where('country_id', $request->country_id);
                })
                ->orderBy('name', 'asc')
                ->get();

            $toReturn = $states;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $country_id = $request->get('country_id', $country_id);
            if ($request->get('factory_country_id')) {
                $country_id = $request->get('factory_country_id');
            }
            $state_id = $request->get('state_id', $state_id);
            $states = State::where('is_active', 'Yes')
                ->when($country_id, function ($query) use ($country_id) {
                    $query->where('country_id', $country_id);
                })
                ->when($state_id, function ($query) use ($state_id) {
                    $query->orWhere('id', $state_id);
                })
                ->orderBy('name')->get();

            $states = $states->pluck('name', 'id')->toArray();

            return $states;
        }
    }
    /**
     * [getCountries description]
     * @param  [type] $country_id [description]
     * @return [type]             [description]
     */
    public function getCountries($country_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $countries = Country::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $countries;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $country_id = $request->get('country_id', $country_id);
            $countries = Country::where('is_active', 'Yes')
                ->when($country_id, function ($sql) use ($country_id) {
                    $sql->orWhere('id', $country_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $countries;
        }
    }

    public function getIndustries($industry_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $industries = Industry::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $industries;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $industry_id = $request->get('industry_id', $industry_id);
            $industries = Industry::where('is_active', 'Yes')
                ->when($industry_id, function ($sql) use ($industry_id) {
                    $sql->orWhere('id', $industry_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $industries;
        }
    }

    public function getLeadSources($lead_source_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $leadSources = LeadSource::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $leadSources;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $lead_source_id = $request->get('lead_source_id', $lead_source_id);
            $leadSources = LeadSource::where('is_active', 'Yes')
                ->when($lead_source_id, function ($sql) use ($lead_source_id) {
                    $sql->orWhere('id', $lead_source_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $leadSources;
        }
    }

    public function getLeadStatuses($lead_status_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $leadStatuses = LeadStatus::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $leadStatuses;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $lead_status_id = $request->get('lead_status_id', $lead_status_id);
            $leadStatuses = LeadStatus::where('is_active', 'Yes')
                ->when($lead_status_id, function ($sql) use ($lead_status_id) {
                    $sql->orWhere('id', $lead_status_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $leadStatuses;
        }
    }

    /**
     * [getInfoData | This method is used to get info data]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getInfoData(Request $request)
    {
        $id = $request->id;
        $table_name = $request->table_name;
        $result = [];

        if($table_name == 'users'){ 
            $addData = DB::table("users")
               // ->select(["u.*", "u.first_name as ufirst_name", "u.last_name as ulast_name"])
                ->where("id", '=', $id)
                ->first();
        } else {
            $addData = DB::table($table_name)
                ->select([$table_name . ".*", "users.first_name as ufirst_name", "users.last_name as ulast_name"])
                ->leftJoin('users', 'users.id', '=', $table_name . ".created_by")
                ->where($table_name . ".id", '=', $id)
                ->first();
        }

        if ($addData) {
            $created_by = "N/A";
            if ($addData->created_by) {
                if($table_name == 'users'){
                    $created_by = DB::table('users')->select(DB::raw("CONCAT(first_name, ' ' ,last_name) as full_name"))->where('id', '=', $addData->created_by)->first()->full_name ?? 'N/A';
                    // $created_by = $addData->first_name . " " . $addData->last_name;
                } else {
                    $created_by = $addData->ufirst_name . " " . $addData->ulast_name;
                }
            }
            $created_at = Carbon::parse($addData->created_at)->format('d/m/Y | h:i:s A');
            /*
            // $addUserAgentData  = $this->getUserAgentAddedBy($addedData);
            // $browser = $addUserAgentData->browser();
            // $version =  $addUserAgentData->version($browser);
            // $platform = $addUserAgentData->platform();
            if(isset($addedData->platform) && $addedData->platform == 1){
                $device = $addedData->user_agent ?? '';
            } else{
                $device =  $browser . ' ' . $version . ' / ' . $platform;
            }
            */
            $ip = $addData->ip ?? 'N/A';
            $result['addData'] = [
                'created_at' => $created_at, 'created_by' => $created_by,  'created_ip' => $ip
            ];
        }

        if($table_name == 'users'){ 
            $updateData = DB::table("users")
               // ->select(["u.*", "u.first_name as ufirst_name", "u.last_name as ulast_name"])
                ->where("id", '=', $id)
                ->first();
        } else {
            $updateData = DB::table($table_name)
                ->select([$table_name . ".*", "users.first_name as ufirst_name", "users.last_name as ulast_name"])
                ->leftJoin('users', 'users.id', '=', $table_name . ".updated_by")
                ->where($table_name . ".id", '=', $id)
                ->first();
        }

        if ($updateData) {
            $updated_by = "N/A"; 
            if ($updateData->updated_by) {
                if($table_name == 'users'){
                    $updated_by = DB::table('users')->select(DB::raw("CONCAT(first_name, ' ' ,last_name) as full_name"))->where('id', '=', $updateData->updated_by)->first()->full_name ?? 'N/A';
                    // $updated_by = $updateData->first_name . " " . $updateData->last_name;
                } else {
                    $updated_by = $updateData->ufirst_name . " " . $updateData->ulast_name;
                }
            }
            $updated_at = Carbon::parse($updateData->updated_at)->format('d/m/Y | h:i:s A');
            // $updateUserAgentData  = $this->getUserAgentUpdatedBy($updatedData);
            // $browser = $updateUserAgentData->browser();
            // $version =  $updateUserAgentData->version($browser);
            // $platform = $updateUserAgentData->platform();
            /*
            if(isset($updatedData->update_platform) && $updatedData->update_platform == 1){
                $upddevice = $updatedData->update_from_user_agent ?? '';
            } else{
                $upddevice =  $browser . ' ' . $version . ' / ' . $platform;
            }
            */
            $update_from_ip = $updateData->update_from_ip ?? 'N/A';
            if ($updateData->updated_by) {
                $result['updateData'] = [
                    'updated_at' => $updated_at, 'updated_by' => $updated_by, 'updated_ip' => $update_from_ip
                ];
            } else {
                $result['updateData'] = [
                    'updated_by' => 'N/A', 'updated_at' => 'N/A', 'updated_ip' => 'N/A'
                ];
            }
        }
        return response()->json($result);
    }

    /**
     * [getItemQuantity description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getItemQuantity(Request $request)
    {   

        $request->request->set('is_qty', true);
        $ctr = new StoreReportController();
        $request->request->add(['is_clossing'=>true]);
        $request->request->add(['item_id'=>$request->id]);        
        $get_qty = $ctr->index($request);
        $totalqty = 0;
        if($get_qty->results->count() > 0){
            $row = $get_qty->results->first();
            $totalqty = $row->stock_qty ?? 0;
        }


        // $storyqty = Store::leftJoin('store_items as si', 'stores.id', '=', 'si.store_id')
        //     ->select(DB::raw('SUM(si.received_qty) as TotalQty'))
        //     ->where('item_id', $request->id)
        //     ->first();

        // $storeItemQty = StoreItemOpening::select('qty as qty')
        //     ->where('item_id', $request->id)
        //     ->first();
        
        // $issueItemqty = IssueItem::select(DB::raw('SUM(qty) as TotalQty'))
        //     ->where('item_id', $request->id)
        //     ->first();
        
        // $totalqty = 0;
        // if ($storyqty && $issueItemqty) {
            
        //     $totalqty = ($storyqty->TotalQty + $storeItemQty->qty) - $issueItemqty->TotalQty;
        // }

        return response()->json($totalqty);
    }

    public function getEmployeeData($id)
    {
        $employee = Employee::with(['DepartmentName'])
            ->where('employees.id', $id)
            ->get();
        return response()->json($employee);
    }

    public function getIssueItemQuantity($id)
    {
        $issueitem = IssueItem::where('issue_items.item_id', $id)
            ->select(DB::raw('SUM(qty) as TotalIssueQty'))
            ->first();
        $returnitem = ReturnItem::where('return_items.item_id', $id)
            ->select(DB::raw('SUM(return_qty) as TotalIssueQty'))
            ->first();
        $totalqty = 0;
        if ($issueitem && $returnitem) {
            
            $totalqty = $issueitem->TotalIssueQty - $returnitem->TotalIssueQty;
        }
        

        return response()->json($totalqty);
    }

    public function getCpodata($cpo_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $cpodata = CylinderPurchaseOrder::select('id AS value', 'cpo_no AS text')->where(['is_active' => 'Yes'])->orderBy('cpo_no', 'asc')->get();

            $toReturn = $cpodata;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $cpo_id = $request->get('cpo_id', $cpo_id);
            $cpodata = CylinderPurchaseOrder::when($cpo_id, function ($sql) use ($cpo_id) {
                $sql->orWhere('id', $cpo_id);
            })
                ->where(['is_active' => 'Yes'])
                ->orderBy('cpo_no', 'ASC')
                ->pluck('cpo_no', 'id')->toArray();
            return $cpodata;
        }
    }

    public function getHsncode($hsncode_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $hsncode = HsnCode::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $hsncode;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $hsncode_id = $request->get('hsncode_id', $hsncode_id);
            $hsncode = HsnCode::select(DB::raw("CONCAT(hsn_code, ' - ', FLOOR(gst), '%') as hsn_code"), 'id')
                ->where('is_active', 'Yes')
                ->when($hsncode_id, function ($sql) use ($hsncode_id) {
                    $sql->orWhere('id', $hsncode_id);
                })
                ->orderBy('hsn_code', 'ASC')
                ->pluck('hsn_code', 'id')->toArray();
            return $hsncode;
        }
    }

    public function getCategory($category_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $category = Category::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $category;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $category_id = $request->get('category_id', $category_id);
            $category = Category::when($category_id, function ($sql) use ($category_id) {
                    $sql->orWhere('id', $category_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $category;
        }
    }

    public function getPoNos($po_no = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $purchase_order = PurchaseOrder::select('id AS value', 'po_number AS text')->orderBy('id', 'asc')->get();
            $this->data = $purchase_order;

            return $this->responseSuccess();
        } else {
            $po_no = $request->get('po_no', $po_no);
            $purchase_order = PurchaseOrder::when($po_no, function ($sql) use ($po_no) {
                //$sql->orWhere('id', $po_no);
            })->orderBy('id', 'ASC')->pluck('po_number', 'id')->toArray();
            return $purchase_order;
        }
    }

    public function getRmCategory($category_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $category = RmCategory::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $category;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $category_id = $request->get('category_id', $category_id);
            $category = RmCategory::where('is_active', 'Yes')
                ->when($category_id, function ($sql) use ($category_id) {
                    $sql->orWhere('id', $category_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $category;
        }
    }

    public function getRole($role_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $role = Role::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $role;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $role_id = $request->get('role_id', $role_id);
            $role = Role::when($role_id, function ($sql) use ($role_id) {
                $sql->orWhere('id', $role_id);
            })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $role;
        }
    }

    public function getPenalty($penalty_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $penalty = Penalty::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $penalty;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $penalty_id = $request->get('penalty_id', $penalty_id);
            $penalty = Penalty::when($penalty_id, function ($sql) use ($penalty_id) {
                $sql->orWhere('id', $penalty_id);
            })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $penalty;
        }
    }

    public function getEmployee($employee_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $employee = Employee::select('id AS value', 'name AS text')->where('is_active', 'Yes')
            ->orderBy('name', 'asc')->get();

            $toReturn = $employee;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $employee_id = $request->get('employee_id', $employee_id);
            $field = [DB::raw("CONCAT(employees.first_name, ' ', employees.last_name) as employee_name"), 'id'];
            $employee = Employee::select($field)
                ->where('is_active', 'Yes')
                ->when($employee_id, function ($sql) use ($employee_id) {
                    $sql->orWhere('id', $employee_id);
                })
                ->orderBy('employee_name', 'ASC')
                ->pluck('employee_name', 'id')->toArray();
            return $employee;
        }
    }

    public function getCustomer($customer_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $customer = Account::select('id AS value', 'company_name AS text')->where(['is_active' => 'Yes', 'object_type' => 'Customer'])->orderBy('person_name', 'asc')->get();

            $toReturn = $customer;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $customer_id = $request->get('customer_id', $customer_id);
            $customer = Account::when($customer_id, function ($sql) use ($customer_id) {
                $sql->orWhere('id', $customer_id);
            })
                ->where(['is_active' => 'Yes', 'object_type' => 'Customer'])
                ->orderBy('company_name', 'ASC')
                ->pluck('company_name', 'id')->toArray();
            return $customer;
        }
    }

    public function getLeads($lead_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $leads = Lead::select('id AS value', 'company_name AS text')->orderBy('company_name', 'asc')->get();

            $toReturn = $leads;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $lead_id = $request->get('lead_id', $lead_id);
            $leads = Lead::when($lead_id, function ($sql) use ($lead_id) {
                $sql->orWhere('id', $lead_id);
            })
                ->orderBy('company_name', 'ASC')
                ->pluck('company_name', 'id')->toArray();
            return $leads;
        }
    }

    public function getSupplier($supplier_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $supplier = Account::select('id AS value', 'company_name AS text')->where(['is_active' => 'Yes', 'object_type' => 'Supplier', 'category' => 'Engraver'])->orderBy('company_name', 'asc')->get();

            $toReturn = $supplier;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $supplier_id = $request->get('supplier_id', $supplier_id);
            $supplier = Account::when($supplier_id, function ($sql) use ($supplier_id) {
                $sql->orWhere('id', $supplier_id);
            })
                ->where(['is_active' => 'Yes', 'object_type' => 'Supplier', 'category' => 'Engraver'])
                ->orderBy('company_name', 'ASC')
                ->pluck('company_name', 'id')->toArray();
            return $supplier;
        }
    }

    public function getTransporter($supplier_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $supplier = Account::select('id AS value', 'company_name AS text')->where(['is_active' => 'Yes', 'object_type' => 'Supplier', 'category' => 'Transporter'])->orderBy('company_name', 'asc')->get();

            $toReturn = $supplier;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $supplier_id = $request->get('supplier_id', $supplier_id);
            $supplier = Account::when($supplier_id, function ($sql) use ($supplier_id) {
                $sql->orWhere('id', $supplier_id);
            })
                ->where(['is_active' => 'Yes', 'object_type' => 'Supplier', 'category' => 'Transporter'])
                ->orderBy('company_name', 'ASC')
                ->pluck('company_name', 'id')->toArray();
            return $supplier;
        }
    }

    public function getSupplierList($supplier_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if($platform == 1) {
            $supplier = Account::select('id AS value', 'company_name AS text')->where(['is_active'=> 'Yes','object_type'=>'Supplier', 'category' => 'Supplier'])->orderBy('company_name', 'asc')->get();

            $toReturn = $supplier;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $supplier_id = $request->get('supplier_id', $supplier_id);
            $supplier = Account::when($supplier_id, function($sql) use($supplier_id) {
                    $sql->orWhere('id', $supplier_id);
                })
                ->select(DB::raw("TRIM(company_name) AS company_name"), 'id')
                ->where(['is_active'=> 'Yes','object_type'=>'Supplier','category' => 'Supplier'])
                ->orderBy('company_name', 'ASC')
                ->pluck('company_name', 'id')->toArray();
            return $supplier;
        }
    }

    public function getLocation($location_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $location = Location::select('id AS value', 'name AS text')->where(['is_active' => 'Yes'])->orderBy('name', 'asc')->get();
            $toReturn = $location;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $location_id = $request->get('location_id', $location_id);
            $location = Location::where(['is_active' => 'Yes'])
                ->when($location_id, function ($sql) use ($location_id) {
                    $sql->orWhere('id', $location_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $location;
        }
    }

    public function getItem($item_id = null, $item_cat_id = null, $item_sub_cat_id = null, $is_returnable = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $items = Item::select('id AS value', 'name AS text')->where(['is_active' => 'Yes'])->orderBy('name', 'asc')->get();

            $toReturn = $items;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $item_id = $request->get('item_id', $item_id);
            $item_cat_id = $request->get('item_cat_id', $item_cat_id);
            $item_sub_cat_id = $request->get('item_sub_cat_id', $item_sub_cat_id);
            $items = Item::when($item_id, function ($sql) use ($item_id) {
                $sql->orWhere('id', $item_id);
            })
                ->when($item_cat_id, function ($sql) use ($item_cat_id) {
                    $sql->orWhere('item_category_id', $item_cat_id);
                })
                ->when($item_sub_cat_id, function ($sql) use ($item_sub_cat_id) {
                    $sql->where('item_sub_category_id', $item_sub_cat_id);
                })
                ->when($is_returnable == 'Yes', function ($sql) {
                    $sql->where('is_returnable', 'Yes');
                })
                ->when($is_returnable == 'No', function ($sql) {
                    $sql->where('is_returnable', 'No');
                })
                ->where(['is_active' => 'Yes'])
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $items;
        }
    }

    public function getAccount($account_id = null, $category = null, $object_type = null, $company_name = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if($platform == 1) {
            $account = Account::select('id AS value', 'company_name AS text')->orderBy('company_name', 'asc')->get();
            $toReturn = $account;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $account_id = $request->get('account_id', $account_id);
            $account = Account::when($account_id, function($sql) use($account_id) {
                    $sql->where('id', $account_id);
                })
                ->when($category, function($sql) use($category) {
                    $sql->where('category', $category);
                })
                ->when($object_type, function($sql) use($object_type) {
                    $sql->where('object_type', $object_type);
                })
                ->when($company_name, function($sql) use($company_name) {
                    $sql->where('company_name', $company_name);
                })
                ->orderBy('company_name', 'ASC')
                ->pluck('company_name', 'id')->toArray();
                
            return $account;
        }
    }

    public function getSoNos($so_no = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $sales_order = SalesOrder::select('id AS value', 'code AS text')->withoutGlobalScope(new YearWiseScope)->orderBy('id', 'asc')->get();

            $toReturn = $sales_order;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $so_no = $request->get('so_no', $so_no);
            $sales_order = SalesOrder::when($so_no, function ($sql) use ($so_no) {
                //$sql->orWhere('id', $so_no);
            })
            ->withoutGlobalScope(new YearWiseScope)
            ->orderBy('id', 'ASC')
            ->pluck('code', 'id')->toArray();
            return $sales_order;
        }
    }

    public function getProNos($pro_no = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $toReturn = Planning::select('id AS value', 'code AS text')->withoutGlobalScope(new YearWiseScope)->where('status','!=','cancelled')->orderBy('id', 'asc')->get();
            $this->data = $toReturn;
            return $this->responseSuccess();
        } else {
            $toReturn = $request->get('toReturn', $pro_no);
            $productons = Planning::when($toReturn, function ($sql) use ($toReturn) {
                //$sql->orWhere('id', $toReturn);
            })
            ->where('status','!=','cancelled')
            ->withoutGlobalScope(new YearWiseScope)
            ->orderBy('id', 'ASC')
            ->pluck('code', 'id')->toArray();
            return $productons;
        }
    }

    public function getTypeByCategory(Request $request)
    {
        $category_id = $request->category_id ?? 0;
        $items = DB::table('rm_category_types')
                    ->join('type_of_grade', function ($join) {
                        $join->on('rm_category_types.type_of_grade_id', '=' ,'type_of_grade.id');
                        $join->where('is_active', 'Yes');
                    })
                    ->when($category_id > 0, function ($sql) use ($category_id) {
                        $sql->orWhere('rm_category_id', $category_id);
                    })
                    ->pluck('type_of_grade.name', 'type_of_grade.id')
                    ->toArray();

        return response()->json($items);
        
    }

    public function getRawMaterialPriceList(Request $request){
        $raw_material_id = $request->raw_material_id;
        if($raw_material_id){
            $category_id = $request->category_id;
            $items = PriceList::with(['priceListSingleSpecification' => function($qry) use($raw_material_id){
                $qry->where('raw_id',$raw_material_id);
            }])->where('category_id', $category_id)->first();
            return $items;
        } 
    }

    public function getCategoryByPriceList($category_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $category = Category::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $category;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $category_id = $request->get('category_id', $category_id);
            $categoryIds = PriceList::pluck('category_id')->toArray();
            $category = Category::where('is_active', 'Yes')
                ->when($category_id, function ($sql) use ($category_id) {
                    $sql->orWhere('id', $category_id);
                })->whereIn('id',$categoryIds)
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $category;
        }
    }

    public function getProductStructures($structure_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if($platform == 1) {
            $product_structures = ProductStructure::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $product_structures;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $structure_id = $request->get('structure_id', $structure_id);
            $product_structures = ProductStructure::when($structure_id, function($sql) use($structure_id) {
                    $sql->orWhere('id', $structure_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $product_structures;
        }
    }

    public function getPipelineCode($pipeline_code_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $pipeline_code = PipelineCode::select('pipeline_code AS value', 'pipeline_code AS text')->where(['is_active' => 'Yes'])->orderBy('pipeline_code', 'asc')->get();
            $toReturn = $pipeline_code;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $pipeline_code_id = $request->get('pipeline_code_id', $pipeline_code_id);
            $pipeline_code = PipelineCode::when($pipeline_code_id, function ($sql) use ($pipeline_code_id) {
                $sql->orWhere('id', $pipeline_code_id);
            })
                ->where(['is_active' => 'Yes'])
                ->orderBy('pipeline_code', 'ASC')
                ->pluck('pipeline_code', 'pipeline_code')->toArray();
            return $pipeline_code;
        }
    }

    public function getColours($colour_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $Colours = Color::select('id AS value', 'name AS text')->where(['is_active' => 'Yes'])->orderBy('name', 'asc')->get();
            $toReturn = $colours;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $colour_id = $request->get('colour_id', $colour_id);
            $colours = Color::when($colour_id, function ($sql) use ($colour_id) {
                $sql->orWhere('id', $colour_id);
            })
                ->where(['is_active' => 'Yes'])
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $colours;
        }
    }

    // get list of user based on sales department employees

    public function getSection($section_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $section = Section::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $section;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $section_id = $request->get('section_id', $section_id);
            $section = Section::where('is_active', 'Yes')
                ->when($section_id, function ($sql) use ($section_id) {
                    $sql->orWhere('id', $section_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $section;
        }
    }

    public function checkPincode(Request $request)
    {
        $pincode = $request->pincode;
        $settings = Setting::where(['name' => 'pincode', 'value' => $pincode])->first();
        if ($settings) {
            return true;
        } else {
            return false;
        }
    }

    // send firebase push notification for android app
    public function send_push_notification($target_tokens, $title = "", $message = "", $notification_type = "", $schedule_date = "", $post_id = "", $payload_location = "", $payload_id = "")
    {
        // dd($message);
        //Send to firebase
        $Firebase = new Firebase();

        //if (isset($this->settingsArray['firebase_apikey']) and $this->settingsArray['firebase_apikey'] != "") {
        // $Firebase->api_key('AAAAnWfrWJ4:APA91bEmwlcBLvglCnCiPUsOM2aliktuMNvL8GWBbKCky_72dTzI3J2wYBqc2MbPusCFHo6ueD8t4bt8qvbxbsqAqkHacKf-Bj0frZqv5JzowyB8pup1AR5gIukMWWaHOLvYqJZASHki');
        $Firebase->api_key('AAAAI7hFxow:APA91bGTaDZVh9yLnaFTrpx5-p42BoUl3CJkPv77MikUkPgNzmUr3Fvpd5nKpJKg1ToTf1_XcuHd_e6LZaDl18ZTzCrX9g4VBoYID5d0MegMCSLN_wAPO7WvR-8sRiBYMI1TYrJjdjEe');
        //} else {
        //    return;
        // }

        if ($title != "") {
            $Firebase->title = $title;
        } else {
            $Firebase->title = 'GPPS';
        }
        $Firebase->body = strip_tags($message);

        $payload_data = array();
        if ($payload_location != "") {
            $payload_data['where'] = $payload_location;
        }
        if ($payload_id != "") {
            $payload_data['id'] = $payload_id;
        }
        //$payload_data['sound'] = 'default';
        /* ==== Make msg arr=======*/
        $message_field = array(
            "title" => $title,
            "body" => $message,
            "notification_type" => $notification_type,
            "schedule_date" => $schedule_date,
            "app_icon" => url('public/uploads'),
            'click_action' => "",
            // "post_id" => $post_id,
            // 'sender_id' => $payload_id,
            // 'color' => "#ffffff",
            // 'sound' => "default",
        );
        // \Log::info($message_field);
        // End
        // if (count($payload_data) > 0) {
        $Firebase->data = $message_field;
        // }
        $inflated_tokens = array();
        if (is_array($target_tokens)) {
            foreach ($target_tokens as $key => $value) {
                $value = json_decode($value);
                if (is_array($value)) {
                    foreach ($value as $key_ => $value_) {
                        $inflated_tokens[] = $value_;
                    }
                }
            }
        } else {
            $target_tokens = json_decode($target_tokens);
            if (is_array($target_tokens)) {
                foreach ($target_tokens as $key_ => $value_) {
                    $inflated_tokens[] = $value_;
                }
            }
        }
        if (count($inflated_tokens) == 0) {
            $inflated_tokens = $target_tokens;
        }
        $info = $Firebase->send($inflated_tokens);
        // dd($info);
        \Log::info($info);
    }

    // get user firebase token
    public function getFirebaseTokens($user_id)
    {
        $firebase_tokens = DB::table('users')
            ->where('id', $user_id)
            ->select('users.firebase_token')
            ->get();
        $firebase_token = $firebase_tokens->pluck('firebase_token')->toArray();

        return $firebase_token;
    }

    public function getRmAttribute($attribute_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $attribute = RmAttribute::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $attribute;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $attribute_id = $request->get('attribute_id', $attribute_id);
            $attribute = RmAttribute::where('is_active', 'Yes')
                ->when($attribute_id, function ($sql) use ($attribute_id) {
                    $sql->orWhere('id', $attribute_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $attribute;
        }
    }

    public function getTypeOfGrade($type_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $type = TypeOfGrade::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $type;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $type_id = $request->get('type_id', $type_id);
            $type = TypeOfGrade::where('is_active', 'Yes')
                ->when($type_id, function ($sql) use ($type_id) {
                    $sql->orWhere('id', $type_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $type;
        }
    }

    // Get Account Company Name

    public function getAccountCompany($account_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $account = Account::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();
            
            $toReturn = $account;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $account_id = $request->get('account_id', $account_id);
            $account = Account::when($account_id, function ($sql) use ($account_id) {
                $sql->orWhere('id', $account_id);
            })
                ->orderBy('company_name', 'ASC')
                ->pluck('company_name', 'id')->toArray();

            return $account;
        }
    }

    public function getProductVersion(Request $request)
    {
        $product_id = $request->product_id;
        $items = ProductVariation::select('id','version_name','variant_id')->where('product_id', $product_id)->get();
        return response()->json($items);
    }

    public function getCpoDetail(Request $request)
    {
        $cpo_id = $request->cpo_id;
        $items = CylinderPurchaseOrder::where('id',$cpo_id)->select('customer_id','product_id','product_version_id','engraver_id')->first();
        return response()->json($items);
    }

    public function getAccountDetail()
    {
        $id = request()->get('id');
        $data = Account::with('officeAddresses','primaryManagedBy','secondaryManagedBy')->where('id', $id)->first();
        if (!empty($data)) {
            return ['status' => 'success', 'data' => $data];
        }
        return ['status' => 'fail'];
    }

    public function getLeadDetail()
    {
        $id = request()->get('id');
        $data = Lead::with(['officeAddresses','leadSingleContactPersons'])->where('id',$id)->first();
        if(!empty($data)){
            return ['status' => 'success','data'=>$data];
        }
        return ['status' => 'fail'];
    }

    public function getMachine($machine_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $machine = Machine::select('id AS value', 'name AS text')->where('type','machine')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();
            $toReturn = $machine;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $machine_id = $request->get('machine_id', $machine_id);
            $machine = Machine::select('id', 'name')->where('type','machine')
                ->where('is_active', 'Yes')
                ->when($machine_id, function ($sql) use ($machine_id) {
                    $sql->orWhere('id', $machine_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $machine;
        }
    }

    public function getCylinderOperator($employee_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $employee = Employee::with(['DepartmentName','processName'])->whereHas('DepartmentName', function($qry){
                $qry->where('name', 'like', ucwords('%Production%'));
            })->whereHas('processName', function($qry){
                $qry->where('name', 'like', ucwords('%Printing%'));
            })->select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $employee;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $employee_id = $request->get('employee_id', $employee_id);
            $role = Employee::with(['DepartmentName','processName'])
            ->whereHas('DepartmentName', function($q)
            {
                return $q->where('name','like',ucwords('%Production%'));
            })->whereHas('processName', function($qry){
                $qry->where('name', 'like', ucwords('%Printing%'));
            })
            ->when($employee_id, function ($sql) use ($employee_id) {
                $sql->orWhere('id', $employee_id);
            })
                ->orderBy('person_name', 'ASC')
                ->pluck('person_name', 'id')->toArray();
            return $role;
        }
    }

    public function getCylinderCode($cylinder_code = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $cylinder_code = Cylinder::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();
            $toReturn = $cylinder_code;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $cylinder_code = $request->get('cylinder_code', $cylinder_code);
            $cylinder_code = Cylinder::where('is_active', 'Yes')
                ->when($cylinder_code, function ($sql) use ($cylinder_code) {
                    $sql->orWhere('id', $cylinder_code);
                })
                ->orderBy('cylinder_code', 'ASC')
                ->pluck('cylinder_code', 'id')->toArray();
            return $cylinder_code;
        }
    }

    public function getPipelineCylinderCode($pipeline_code = null)
    {
        $request = request();
        $pipeline_code = $request->get('pipeline_code', $pipeline_code);
        $cylinder_code = Cylinder::where('is_active', 'Yes')
            ->where('pipeline_code',$pipeline_code)
            ->select('cylinder_code as id', 'cylinder_code AS text','id as cylinderId')
            ->orderBy('cylinder_code', 'ASC')
            ->get();
            //$this->data['cylinder_code'] = $cylinder_code-
        return $cylinder_code;
        
    }

    public function getShift($shift_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $shift = Shift::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();
            
            $toReturn = $shift;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $shift_id = $request->get('shift_id', $shift_id);
            $shift = Shift::select(DB::raw("CONCAT(name,' ', '(', DATE_FORMAT(from_time,'%h:%i %p'),' - ',DATE_FORMAT(to_time,'%h:%i %p'),')') as name"), 'id')->when($shift_id, function ($sql) use ($shift_id) {
                $sql->orWhere('id', $shift_id);
            })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();

            return $shift;
        }
    }

    public function getAllSupplier($supplier_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $supplier = Account::select('id AS value', 'company_name AS text')->where(['is_active' => 'Yes'])->orderBy('company_name', 'asc')->get();

            $toReturn = $supplier;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $supplier_id = $request->get('supplier_id', $supplier_id);
            $supplier = Account::when($supplier_id, function ($sql) use ($supplier_id) {
                $sql->orWhere('id', $supplier_id);
            })
                ->where(['is_active' => 'Yes'])
                ->orderBy('company_name', 'ASC')
                ->pluck('company_name', 'id')->toArray();
            return $supplier;
        }
    }

    // get quotation list
    public function getQuotation($status = null, $account_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $consumer = Quotation::select('id AS value', 'code AS text')->orderBy('customer_name', 'asc')->get();

            $toReturn = $consumer;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $status = $request->get('status', $status);
            $account_id = $request->get('account_id', $account_id);
            $consumer = Quotation::with('firstCategory')->when($status, function ($sql) use ($status) {
                    $sql->where('status', $status);
                })
                ->when($account_id, function ($sql) use ($account_id) {
                    $sql->where('customer_id', $account_id);
                })
                ->orderBy('customer_name', 'ASC')
                ->pluck('code', 'id')
                ->toArray();
            return $consumer;
        }
    }

    public function getTdsSection($tds_section_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $TdsSection = TdsSection::select('id AS value', 'section AS text')->orderBy('section', 'asc')->get();

            $toReturn = $TdsSection;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $tds_section_id = $request->get('tds_section_id', $tds_section_id);
            $TdsSection = TdsSection::where('is_active', 'Yes')
                ->when($tds_section_id, function ($sql) use ($tds_section_id) {
                    $sql->orWhere('id', $tds_section_id);
                })
                ->orderBy('section', 'ASC')
                ->pluck('section', 'id')->toArray();
            return $TdsSection;
        }
    }

    public function getPurchaseOrder($po_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $po_id = PurchaseOrder::select('id AS value', 'po_number AS text')->where(['is_active' => 'Yes'])->orderBy('po_number', 'asc')->get();

            $toReturn = $po_id;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $po_id = $request->get('po_id', $po_id);
            $po_id = PurchaseOrder::when($po_id, function ($sql) use ($po_id) {
                $sql->orWhere('id', $po_id);
            })
                ->orderBy('po_number', 'ASC')
                ->pluck('po_number', 'id')->toArray();
            return $po_id;
        }
    }

    public function accountBalanceData(Request $request, $account_id = null)
    {
        if ($request->ajax()) {
            $account_id = $request->get('account_id');
        }
        $accountResult = [];

        $opening_fields = [DB::raw("accounts.id as account_id"), DB::raw("SUM(CASE WHEN opening_type = 'CR' THEN opening ELSE 0 END) as credit"), DB::raw("SUM(CASE WHEN opening_type = 'DR' THEN opening ELSE 0 END) as debit"),];
        $po_bills_fields = ["account_id", DB::raw("SUM(grand_total) as credit"), DB::raw("'0' as debit"),];
        $payment_from_field = [
            "account_id as account_id",
            DB::raw("'0' AS credit"),
            DB::raw("SUM(amount) AS debit"),
        ];

        $account_opening = DB::table('accounts')
            ->select($opening_fields)
            ->where('id', $account_id)
            ->whereNull('deleted_at')
            ->where('accounts.opening', '>', '0');
        $po_bills = DB::table('purchase_bills')
            ->select($po_bills_fields)
            ->where('account_id', $account_id)
            ->whereNull('deleted_at');
        $payment_from = DB::table('payments')
            ->select($payment_from_field)
            ->where('account_id', $account_id)
            ->whereNull('deleted_at');
        
        $accountLedger = $po_bills->unionAll($payment_from)->unionAll($account_opening);
        $accountResult = DB::table(DB::raw("({$accountLedger->toSql()}) as results"))
            ->select(['account_id', DB::raw("SUM(credit) as credit"), DB::raw("SUM(debit) as debit")])
            ->mergeBindings($accountLedger)
            ->groupBy("account_id")
            ->get()
            ->keyBy("account_id")->toArray();
        // dd($accountResult);
        if (array_key_exists($account_id, $accountResult)) {

            // $debit_data = DebitNote::where('supplier_id',$account_id)->select(DB::raw("SUM(grand_total) as grand_total"))->first(); 

            // $ws_debit_data = CreditNoteWithoutStock::where('account_id',$account_id)->select(DB::raw("SUM(grand_total) as grand_total"))->first();

            // $data = ($accountResult[$account_id]->debit + $debit_data->grand_total  + $ws_debit_data->grand_total) - $accountResult[$account_id]->credit;
            $data = $accountResult[$account_id]->debit - $accountResult[$account_id]->credit;
            if ($data > 0) {
                return "Balance Db : " . format_amount($data, 2);
            }
            return "Balance Cr : " . format_amount(abs($data), 2);
        }
        
        return "Balance : 0.00";
    }

    public function getInwardChallanCode($ic_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if($platform == 1) {
            $inward_challan = InwardChallan::select('id AS value', 'code AS text')->where(['is_active'=> 'Yes'])->orderBy('code', 'asc')->get();

            $toReturn = $inward_challan;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $ic_id = $request->get('ic_id', $ic_id);
            $inward_challan = InwardChallan::when($ic_id, function($sql) use($ic_id) {
                    $sql->orWhere('id', $ic_id);
                })
                ->where(['is_active'=> 'Yes'])
                ->orderBy('code', 'ASC')
                ->pluck('code', 'id')->toArray();
            return $inward_challan;
        }
    }

    public function getCylinderChallanCode($ic_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if($platform == 1) {
            $inward_challan = CylinderInward::select('id AS value', 'code AS text')->where(['is_active'=> 'Yes'])->orderBy('code', 'asc')->get();

            $toReturn = $inward_challan;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $ic_id = $request->get('ic_id', $ic_id);
            $inward_challan = CylinderInward::when($ic_id, function($sql) use($ic_id) {
                    $sql->orWhere('id', $ic_id);
                })
                ->where(['is_active'=> 'Yes'])
                ->orderBy('code', 'ASC')
                ->pluck('code', 'id')->toArray();
            return $inward_challan;
        }
    }

    public function getCylinderOutwardChallanCode($ic_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if($platform == 1) {
            $inward_challan = CylinderOutward::select('id AS value', 'code AS text')->where(['is_active'=> 'Yes'])->orderBy('code', 'asc')->get();

            $toReturn = $inward_challan;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $ic_id = $request->get('ic_id', $ic_id);
            $inward_challan = CylinderOutward::when($ic_id, function($sql) use($ic_id) {
                    $sql->orWhere('id', $ic_id);
                })
                ->where(['is_active'=> 'Yes'])
                ->orderBy('code', 'ASC')
                ->pluck('code', 'id')->toArray();
            return $inward_challan;
        }
    }

    public function getCylinderJobworkOutwardChallanCode($ic_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if($platform == 1) {
            $inward_challan = CylinderJobworkOutward::select('id AS value', 'code AS text')->where(['is_active'=> 'Yes'])->orderBy('code', 'asc')->get();

            $toReturn = $inward_challan;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $ic_id = $request->get('ic_id', $ic_id);
            $inward_challan = CylinderJobworkOutward::when($ic_id, function($sql) use($ic_id) {
                    $sql->orWhere('id', $ic_id);
                })
                ->where(['is_active'=> 'Yes'])
                ->orderBy('code', 'ASC')
                ->pluck('code', 'id')->toArray();
            return $inward_challan;
        }
    }

    public function getCpoCode($cpo_no = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $cpo_no = CylinderPurchaseOrder::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();
            $toReturn = $cpo_no;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $cpo_no = $request->get('cpo_no', $cpo_no);
            $cpo_no = CylinderPurchaseOrder::where('is_active', 'Yes')
                ->when($cpo_no, function ($sql) use ($cpo_no) {
                    $sql->orWhere('id', $cpo_no);
                })
                ->orderBy('cpo_no', 'ASC')
                ->pluck('cpo_no', 'id')->toArray();
            return $cpo_no;
        }
    }

    public function getProductVersionName($product_version = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $product_version = ProductVariation::select('id AS value', 'version_name AS text')->where('is_active', 'Yes')->orderBy('version_name', 'asc')->get();
            $toReturn = $product_version;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $product_version = $request->get('product_version', $product_version);
            $product_version = ProductVariation::where('is_active', 'Yes')
                ->when($product_version, function ($sql) use ($product_version) {
                    $sql->orWhere('id', $product_version);
                })
                ->orderBy('version_name', 'ASC')
                ->pluck('version_name', 'id')->toArray();
            return $product_version;
        }
    }
    
    // get list of all users
    public function getUsers($user_id=0)
    {
        $request = Request();
        $user_id =$request->get('user_id', $user_id);
        $users = User::select(DB::raw("CONCAT(first_name, ' ', last_name) as user_full_name"), 'id')
            ->where('is_active', 'Yes')
            ->when($user_id > 0, function ($sql) use ($user_id) {
                $sql->orWhere('id', $user_id);
            })
            ->orderBy('first_name', 'ASC')
            ->pluck('user_full_name', 'id')
            ->toArray();
            
        return $users;
    }

    public function customerProductList($account_id = null, $sibling = null, $productIds = null)
    {
        $account_id = request()->get('account_id', $account_id);
        if (request()->get('request_page') == 'cylinder') {
            $account_id = request()->get('customer_id');
        }
        $account_ids = [];
        if ($account_id) {
            $account = Account::find($account_id);
            if ($account) {
                $account_ids[] = $account->id;
                $child_accounts = [];
                if ($account->parent_account_id > 0) {
                    $account_ids[] = $account->parent_account_id;
                } else {
                    $child_accounts = Account::where('parent_account_id', $account_id)->pluck('id', 'id')->toArray();
                }
                $sibling_accounts = [];
                if ($sibling) {
                    $parent_account_id = $account->parent_account_id;
                    $sibling_accounts = Account::where('parent_account_id', $parent_account_id)
                        ->where('id', '!=', $account->id)
                        ->pluck('id', 'id')->toArray();
                }
                $account_ids = $account_ids + $child_accounts + $sibling_accounts;
            }
        }
        $productSql = Product::whereIn('account_id', $account_ids)
            ->orderBy('product_name');
        if ($productIds && is_array($productIds)) {
            $productSql->whereIn('id', $productIds);
        }
        $products = $productSql->pluck('product_name', 'id')->toArray();
        $data['products'] = $products;
        $data['account_ids'] = $account_ids;
        return $data;
    }

    public function getItemCategory($item_category_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $itemCategory = ItemCategory::select('id AS value', 'name AS text')->where(['is_active' => 'Yes'])->orderBy('name', 'asc')->get();
            $toReturn = $itemCategory;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $item_category_id = $request->get('item_category_id', $item_category_id);
            $itemCategory = ItemCategory::when($item_category_id, function ($sql) use ($item_category_id) {
                $sql->orWhere('id', $item_category_id);
            })
                ->where(['is_active' => 'Yes'])
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $itemCategory;
        }
    }

    public function getItemSubCategory($item_category_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $subCategory = ItemSubCategory::select('id AS value', 'name AS text')->where(['is_active' => 'Yes'])->orderBy('name', 'asc')->get();
            
            $toReturn = $subCategory;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $item_category_id = $request->get('item_category_id', $item_category_id);
            $subCategory = ItemSubCategory::when($item_category_id, function ($sql) use ($item_category_id) {
                $sql->orWhere('item_category_id', $item_category_id);
            })
                ->where(['is_active' => 'Yes'])
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')
                ->toArray();

            return $subCategory;
        }
    }

    public function getCustomerProductDropdown($customer_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $products = Product::select('id AS value', 'product_name AS text')->where(['is_active' => 'Yes'])->orderBy('product_name', 'asc')->get();
            
            $toReturn = $products;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $customer_id = $request->get('customer_id', $customer_id);
            $products = Product::when($customer_id, function ($sql) use ($customer_id) {
                $sql->orWhere('account_id', $customer_id);
            })
                ->where(['is_active' => 'Yes'])
                ->orderBy('product_name', 'ASC')
                ->pluck('product_name', 'id')
                ->toArray();

            return $products;
        }
    }

    public function getTcsSection($tds_section_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $TdsSection = TcsSection::select('id AS value', 'section AS text')->orderBy('section', 'asc')->get();

            $toReturn = $TdsSection;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $tds_section_id = $request->get('tds_section_id', $tds_section_id);
            $TdsSection = TcsSection::where('is_active', 'Yes')
                ->when($tds_section_id, function ($sql) use ($tds_section_id) {
                    $sql->orWhere('id', $tds_section_id);
                })
                ->orderBy('section', 'ASC')
                ->pluck('section', 'id')->toArray();
            return $TdsSection;
        }
    }

    public function getExpenseType($id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $expenseType = ExpenseType::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $expenseType;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $id = $request->get('id', $id);
            $expenseType = ExpenseType::where('is_active', 'Yes')
                ->when($id, function ($sql) use ($id) {
                    $sql->orWhere('id', $id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $expenseType;
        }
    }

    public function getExpenseStatus($id = null)
    {
        $status = [
            ['value'=> 0,'text'=>'Pending'],
            ['value'=> 1,'text'=>'Approved'],
        ];
        $this->data = $status;
        return $this->responseSuccessWithoutObject();
    }

    public function getPoSources($po_source_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $poSources = PoSource::select('id AS value', 'name AS text')->where(['is_active' => 'Yes'])->orderBy('person_name', 'asc')->get();

            $toReturn = $poSources;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $po_source_id = $request->get('po_source_id', $po_source_id);
            $poSources = PoSource::when($po_source_id, function ($sql) use ($po_source_id) {
                $sql->orWhere('id', $po_source_id);
            })
                ->where(['is_active' => 'Yes'])
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $poSources;
        }
    }

    public function getAccountAddresses($account_id, $object_type = null, $company_name = null)
    {
        $request = request();
        $account_id = $request->get('account_id', $account_id);
        $object_type = $request->get('object_type', $object_type);
        $company_name = $request->get('company_name', $company_name);

        $accountAddressData = DB::table('account_addresses')
            ->join('accounts', 'account_addresses.account_id', '=', 'accounts.id')
            ->join('countries', 'account_addresses.country_id', '=', 'countries.id')
            ->join('states', 'account_addresses.state_id', '=', 'states.id')
            ->select('accounts.company_name as company_name', 'accounts.person_name as person_name', 'accounts.email as email', DB::raw("IF(account_addresses.address_type='office', 'Office', 'Factory') as badge_type"), 'account_addresses.id as id', 'account_addresses.address_line1', 'account_addresses.address_line2', 'countries.name as country', 'states.name as state', 'account_addresses.city', 'account_addresses.pincode', 'account_addresses.mobile')
            ->where('account_addresses.account_id', $account_id)
            ->when($object_type, function($sql) use($object_type) {
                $sql->where('accounts.object_type', $object_type);
            })
            ->when($company_name, function($sql) use($company_name) {
                $sql->where('accounts.company_name', $company_name);
            })
            ->get();
        $accountShipToAddressData = DB::table('account_ship_to_addresses as ship')
            ->join('accounts', 'ship.account_id', '=', 'accounts.id')
            ->join('countries', 'ship.country_id', '=', 'countries.id')
            ->join('states', 'ship.state_id', '=', 'states.id')
            ->select('ship.company_name as company_name', 'accounts.person_name as person_name', 'accounts.email as email', DB::raw("'Shipping' as badge_type"), 'ship.id as id', 'ship.address_line1', 'ship.address_line2', 'countries.name as country', 'states.name as state', 'ship.city', 'ship.pincode', 'ship.mobile')
            ->where('ship.account_id', $account_id)
            ->when($object_type, function($sql) use($object_type) {
                $sql->where('accounts.object_type', $object_type);
            })
            ->when($company_name, function($sql) use($company_name) {
                $sql->where('accounts.company_name', $company_name);
            })
            ->get();
            
        $this->data['accountAddrData'] = $accountAddressData->merge($accountShipToAddressData);

        return $this->data;
    }

    public function getHsnCodeDetails($hsncode_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $hsncode = HsnCode::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $hsncode;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $hsncode_id = $request->get('hsncode_id', $hsncode_id);
            $hsncode = HsnCode::where('id', $hsncode_id)->first();
            
            return $hsncode;
        }
    }

    // Get list of employees with its employee code
    public function getEmployeeWithEmpCode($employee_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $employee = Employee::select('id AS value', 'name AS text')->where('is_active', 'Yes')
                ->orderBy('name', 'asc')->get();

            $toReturn = $employee;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $employee_id = $request->get('employee_id', $employee_id);
            $field = [DB::raw("CONCAT(employee_professionals.employee_code, ' - ', employees.first_name, ' ', COALESCE(employees.middle_name,''), ' ', employees.last_name) as employee_name"), 'employees.id'];
            $employee = Employee::select($field)
                ->leftJoin('employee_professionals', 'employees.id', '=', 'employee_professionals.employee_id')
                // ->where('is_active', 'Yes')
                ->when($employee_id, function ($sql) use ($employee_id) {
                    $sql->orWhere('id', $employee_id);
                })
                ->orderBy('employee_name', 'ASC')
                ->pluck('employee_name', 'id')->toArray();
            return $employee;
        }
    }

    public function getEmployeeWithEmpCodeLoan($employee_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $employee = Employee::select('id AS value', 'name AS text')->where('is_active', 'Yes')
                ->orderBy('name', 'asc')->get();

            $toReturn = $employee;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $employee_id = $request->get('employee_id', $employee_id);
            $field = [DB::raw("CONCAT(employee_professionals.employee_code, ' - ', employees.first_name, ' ', COALESCE(employees.middle_name,''), ' ', employees.last_name) as employee_name"), 'employees.id'];
            $employee = Employee::select($field)
                ->leftJoin('employee_professionals', 'employees.id', '=', 'employee_professionals.employee_id')
                ->where('is_active', 'Yes')
                ->when($employee_id, function ($sql) use ($employee_id) {
                    $sql->orWhere('id', $employee_id);
                })
                ->orderBy('employee_name', 'ASC')
                ->pluck('employee_name', 'id')->toArray();
            return $employee;
        }
    }

    public function getChartAccount($account_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $account = Account::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();

            $toReturn = $account;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $account_id = $request->get('account_id', $account_id);
            $account = Account::whereIN('object_type',['Employee'])->where('is_active', 'Yes')
                ->when($account_id, function ($sql) use ($account_id) {
                    $sql->orWhere('id', $account_id);
                })
                ->orderBy('company_name', 'ASC')
                ->pluck('company_name', 'id')->toArray();

            return $account;
        }
    }

    public function getAccountTypes()
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $accountTypes = AccountType::select('id AS value', 'name AS text')
            ->where(['is_active' => 'Yes'])
            ->orderBy('name', 'asc')->get();

            $toReturn = $accountTypes;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $accountTypes = AccountType::where('is_active', 'Yes')
                            ->orderBy('name', 'ASC')
                            ->pluck('name', 'id')->toArray();
            return $accountTypes;
        }
    }

    public function getAccountName()
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $accountTypes = Account::select('id AS value', 'company_name AS text')
            ->where(['is_active' => 'Yes'])
            ->orderBy('company_name', 'asc')->get();

            $toReturn = $accountTypes;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $accountTypes = Account::where('is_active', 'Yes')
                        ->where('object_type', 'Account')
                        ->where('type_of_head', 'Expense')
                        ->orderBy('company_name', 'ASC')
                        ->pluck('company_name', 'id')
                        ->toArray();
            return $accountTypes;
        }
    }

    public function getEmployeeAccount($id = null)
    {
        $request = request();
        $id = $request->get('id', $id);
        $employee = Account::where(['is_active' => 'Yes'])
        ->when($id, function ($sql) use ($id) {
            $sql->orWhere('id', $id);
        })
        ->select(DB::raw("TRIM(company_name) AS company_name"), 'id')
        ->where(['object_type' => 'Employee','category' => 'Employee'])
        ->orderBy('company_name', 'ASC')
        ->pluck('company_name', 'id')->toArray();
        return $employee;
    }

    public function getSupplierVendorList($supplier_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $supplier = Account::select('id AS value', 'company_name AS text')->where(['is_active' => 'Yes', 'object_type' => 'Supplier'])->whereIn('category',['Supplier','Vendor'])->orderBy('company_name', 'asc')->get();

            $toReturn = $supplier;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $supplier_id = $request->get('supplier_id', $supplier_id);
            $supplier = Account::when($supplier_id, function ($sql) use ($supplier_id) {
                $sql->orWhere('id', $supplier_id);
            })
            ->select(DB::raw("TRIM(company_name) AS company_name"), 'id')
            ->where(['is_active' => 'Yes', 'object_type' => 'Supplier'])
            ->whereIn('category',['Supplier','Vendor'])
            ->orderBy('company_name', 'ASC')
            ->pluck('company_name', 'id')->toArray();
            return $supplier;
        }
    }

    public function getActiveProcess($process_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $process = Process::select('id AS value', 'name AS text')->withoutGlobalScope(new YearWiseScope)->where('is_active', 'Yes')->where('is_active', 'Yes')->orderBy('sequence', 'asc')->get();

            $toReturn = $process;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $process_id = $request->get('process_id', $process_id);
            $process = Process::where('is_active', 'Yes')
                ->when($process_id, function ($sql) use ($process_id) {
                    $sql->orWhere('id', $process_id);
                })
                ->withoutGlobalScope(new YearWiseScope)
                ->where('is_active', 'Yes')
                ->orderBy('sequence', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $process;
        }
    }
    public function getMachineMixture()
    {
        $request = request();
        $id = $request->get('id', false);
        $machine = Machine::when($id, function($sql) use($id) {
                $sql->orWhere('id', $id);
            })
            ->whereNull('mixture_id')
            ->where('is_active','Yes')
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id')->toArray();
        return $machine;
    }
    public function getPlanning($planning_ids=[]){
        $products = Planning::when(!empty($planning_ids), function ($sql) use ($planning_ids) {
                $sql->orWhereIn('id', $planning_ids);
            })
            ->withoutGlobalScope(new YearWiseScope)
            ->orderBy('code', 'ASC')
            ->pluck('code', 'id')->toArray();
        return $products;
    }

    public function getTDSPayableAccountDetail()
    {
        $tdsPayable = Account::where(['company_name' => 'TDS Payable'])->first();
        return $tdsPayable;
    }
    public function getICBatchNo($ic_id = null)
    {
        $request = request();
        $ic_id = $request->get('ic_id', $ic_id);
        $inward_challan = InwardChallan::when($ic_id, function($sql) use($ic_id) {
            $sql->orWhere('id', $ic_id);
        })
        ->whereNotNull('batch_no')
        ->where(['is_active'=> 'Yes'])
        ->orderBy('batch_no', 'ASC')
        ->pluck('batch_no', 'id')->toArray();
        return $inward_challan;
    }

    public function getCustomerSupplier($customer_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $customer = Account::select('id AS value', 'company_name AS text')
            ->where(['is_active' => 'Yes', 'object_type' => ['Customer', 'Supplier']])
            ->orderBy('person_name', 'asc')->get();

            $toReturn = $customer;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $customer_id = $request->get('customer_id', $customer_id);
            $customer = Account::when($customer_id, function ($sql) use ($customer_id) {
                $sql->orWhere('id', $customer_id);
            })
            ->where('is_active', 'Yes')
            ->whereIn('object_type',['Customer', 'Supplier'])
            ->orderBy('company_name', 'ASC')
            ->pluck('company_name', 'id')->toArray();
            return $customer;
        }
    }

    public function getFgRemark($remark_id = null)
    {
        $request = request();
        $remark_id = $request->get('remark_id', $remark_id);
        $remarks = FgRemark::when($remark_id, function ($sql) use ($remark_id) {$sql->orWhere('id', $remark_id);})->where('is_active', 'Yes')->orderBy('remark', 'ASC')->pluck('remark', 'id')
                ->toArray();
        return $remarks;
    }

    public function getTdsSectionAccounts($tds_section_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $TdsSection = Account::leftJoin('account_types', 'account_types.id', '=', 'accounts.account_type_id')
                ->select('accounts.id AS value', 'accounts.company_name AS text')
                ->where('accounts.is_active', 'Yes')
                ->whereIn('account_types.slug', ['tds-payable', 'tds-receivable'])
                ->whereIn('accounts.object_type', ['Account'])
                ->whereIn('accounts.type_of_head', ['Assets', 'Liability'])
                ->where('accounts.section_rate', '>', 0)
                ->orderBy('accounts.company_name', 'ASC')
                ->get();

            $toReturn = $TdsSection;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $tds_section_id = $request->get('tds_section_id', $tds_section_id);
            $TdsSection = Account::leftJoin('account_types', 'account_types.id', '=', 'accounts.account_type_id')
                ->whereIn('account_types.slug', ['tds-payable', 'tds-receivable'])
                ->whereIn('accounts.object_type', ['Account'])
                ->whereIn('accounts.type_of_head', ['Assets', 'Liability'])
                ->where('accounts.is_active', 'Yes')
                ->where('accounts.section_rate', '>', 0)
                ->when($tds_section_id, function ($sql) use ($tds_section_id) {
                    $sql->orWhere('accounts.id', $tds_section_id);
                })
                ->orderBy('accounts.company_name', 'ASC')
                ->pluck('accounts.company_name', 'accounts.id')
                ->toArray();
            return $TdsSection;
        }
    }

    public function getTcsSectionAccounts($tcs_section_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $TcsSection = Account::leftJoin('account_types', 'account_types.id', '=', 'accounts.account_type_id')
                ->select('accounts.id AS value', 'accounts.company_name AS text')
                ->where('accounts.is_active', 'Yes')
                ->whereIn('account_types.slug', ['tcs-payable', 'tcs-receivable'])
                ->whereIn('accounts.object_type', ['Account'])
                ->whereIn('accounts.type_of_head', ['Assets', 'Liability'])
                ->where('accounts.section_rate', '>', 0)
                ->orderBy('accounts.company_name', 'ASC')
                ->get();

            $toReturn = $TcsSection;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $tcs_section_id = $request->get('tcs_section_id', $tcs_section_id);
            $TcsSection = Account::leftJoin('account_types', 'account_types.id', '=', 'accounts.account_type_id')
                ->where('accounts.is_active', 'Yes')
                ->whereIn('account_types.slug', ['tcs-payable', 'tcs-receivable'])
                ->whereIn('accounts.object_type', ['Account'])
                ->whereIn('accounts.type_of_head', ['Assets', 'Liability'])
                ->where('accounts.section_rate', '>', 0)
                ->when($tcs_section_id, function ($sql) use ($tcs_section_id) {
                    $sql->orWhere('accounts.id', $tcs_section_id);
                })
                ->orderBy('accounts.company_name', 'ASC')
                ->pluck('accounts.company_name', 'accounts.id')
                ->toArray();
            return $TcsSection;
        }
    }

    public function getTdsTcsTaxRate(Request $request)
    {
        $tds_type_id = $request->tds_type_id;
        $section_data = Account::where('is_active', 'Yes')
            ->where('id', $tds_type_id)
            ->first();
        $this->data['TdsType'] = $section_data ?? '';

        return $this->data;
    }

    public function udpateProductionRMRate($trans_id){
        ini_set('memory_limit', '-1M');
        $tras = DB::table('production_planning_transections')->where('id', $trans_id)->first();
        $amt=0;
        if($tras){
            $raw_material_id = $tras->raw_material_id;
            $net_weight = $tras->net_weight;
            $results=DB::table('floor_inward_challan_item')->where('raw_material_id', $raw_material_id)->where('return_qty','>',0)->get();
            $json_data = [];
            $trans_total = 0;
            if($results->count() > 0){
                $j=0;
                foreach ($results as $key => $row) {
                    if($net_weight > 0){
                        $return_qty = $row->return_qty;
                        $issue_qty = ($return_qty > $net_weight) ?  $net_weight : $return_qty;
                        $net_weight = ($return_qty > $net_weight) ?  0 : $net_weight - $return_qty;
                        $return_remain_qty = ($issue_qty > $return_qty) ?  0 : $return_qty - $issue_qty;
                        $amt = $amt + ($row->rate * $issue_qty);
                        if($row->opening_id > 0){
                            $json_data[$j] = ['id'=>$row->opening_id,'type'=>'opening','issue_qty'=>$issue_qty];
                        }else{
                            $json_data[$j] = ['id'=>$row->inward_challan_item_id,'type'=>'inward','issue_qty'=>$issue_qty];
                        }
                        $j++;
                        $trans_total += $row->rate * $issue_qty;
                        DB::table('floor_inward_challan_item')->where('id',$row->id)->update(['return_qty'=>$return_remain_qty]);
                    }else{
                        break;
                    }
                }
            }
            $trans_rate = round($trans_total / $tras->net_weight, 2);
            $trans_update = [
                'rate' => $trans_rate,
                'total' => $trans_total,
                'rate_calculated' => '1',
                'raw_material_name' => json_encode($json_data),
            ];
            DB::table('production_planning_transections')->where('id', $tras->id)->update($trans_update);
        }
    }
    public function udpateProductionSoutRate($planning_id, $trans_id,$data)
    {
        ini_set('memory_limit', '-1M');
        $raw_material_id = $data['raw_material_id'] ?? 0;
        $kg = $data['kg'] ?? 0;
        $rate = $data['rate'] ?? 0;
        $sout_rq=$kg;
        if($planning_id > 0 && $raw_material_id > 0){
            $tras = DB::table('production_planning_transections')
            ->where('object_type','wipin')
            ->where('rate_calculated',1)
            ->where('planning_id',$planning_id)
            ->where('raw_material_id',$raw_material_id)
            ->whereNull('deleted_at')
            ->where('sout_remain_qty','>',0)->get();

            if($tras->count() > 0){
                $amt=0;
                foreach ($tras as $key => $row) {
                    if($kg > 0){
                        if(!empty(json_decode($row->raw_material_name))){
                            $inwrd_arr = array_reverse(((array)json_decode($row->raw_material_name)),true);
                            if(count($inwrd_arr) > 0){
                                foreach ($inwrd_arr as $j => $inwrd_row) {
                                    $type = $inwrd_row->type;
                                    $item_id = $inwrd_row->id;
                                    $inwrd_qty = $inwrd_row->issue_qty;
                                    if($type == 'opening'){
                                        $floor_inward = DB::table('floor_inward_challan_item')->where('opening_id', $item_id)->where('is_issue','>',0)->where('qty','>','return_qty')->orderBy('id','desc')->get();
                                    }else{
                                        $floor_inward = DB::table('floor_inward_challan_item')->where('inward_challan_item_id', $item_id)->where('is_issue','>',0)->where('qty','>','return_qty')->orderBy('id','desc')->get();
                                    }
                                    if($floor_inward->count() > 0){
                                        foreach ($floor_inward as $i => $floor) {
                                            if($sout_rq > 0){
                                                $qty = $floor->qty;
                                                $return_qty = $floor->return_qty;
                                                $issue_qty = $qty-$return_qty;
                                                $sout_qty = ($issue_qty > $sout_rq) ? $sout_rq : $issue_qty;
                                                $remain_return_qty = $return_qty + $sout_qty;
                                                // $amt = $amt + ($rate * $sout_qty);
                                                $sout_rq = ($sout_rq > $sout_qty) ? $sout_rq- $sout_qty : 0;
                                                DB::table('floor_inward_challan_item')->where('id', $floor->id)->update(['return_qty' => $remain_return_qty]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $sout_remain_qty = $row->sout_remain_qty;
                        $issue_qty = ($sout_remain_qty > $kg) ?  $kg : $sout_remain_qty;
                        $kg = ($sout_remain_qty > $kg) ?  0 : $kg - $sout_remain_qty;
                        $remain_qty = ($issue_qty > $sout_remain_qty) ?  0 : $sout_remain_qty - $issue_qty;
                        // $amt = $amt + ($row->rate * $issue_qty);
                        $amt = $amt + ($rate * $issue_qty);
                        DB::table('production_planning_transections')->where('id',$row->id)->update(['sout_remain_qty'=>$remain_qty]);
                    }else{
                        break;
                    }
                }
                $update_data = [
                    'sout_remain_qty'=>0,
                    'total'=>$amt,
                ];
                DB::table('production_planning_transections')->where('id',$trans_id)->update($update_data);
            }
        }
    }
    public function udpateProductionOutRate($input,$trans_id){
        ini_set('memory_limit', '-1M');
        $recipe_id = $input['recipe_id'];
        $planning_id = $input['planning_id'];
        $process_id = $input['process_id'];
        $process = DB::table('processes')->where('id', $process_id)->first();
        $wip_fg_increase_rate = $process->wip_fg_increase_rate ?? 0;
        $transField = [DB::raw("SUM(net_weight) as netWt"), DB::raw("SUM(total) AS totalAmt")];
        $issuedRM = DB::table('production_planning_transections')
            ->select($transField)
            ->where('planning_id', $planning_id)
            ->where('process_id', $process_id)
            ->where('recipe_id',$recipe_id)
            ->where('object_type', 'wipin')
            ->where('raw_material_id', '>', '0')
            ->whereNull('deleted_at')
            ->first();
        $rateArr=[];
        if($issuedRM->totalAmt && !empty($input['net_weight'])) {
            $rate = $issuedRM->totalAmt / $issuedRM->netWt;
            //this code comment becuase now per kg fix rate increase
            /*
            $increase_rate = 0;
            if($wip_fg_increase_rate > 0){
                $increase_rate = ($rate * $wip_fg_increase_rate) / 100;
            }*/
            $increase_rate = 0;
            if($wip_fg_increase_rate > 0){
                // $increase_rate = $input['net_weight'] * $wip_fg_increase_rate;
                $increase_rate = $wip_fg_increase_rate;
            }
            $fgRate = round($rate+$increase_rate, 2);
            $rateArr["rate"] = $fgRate;
            $rateArr["total"] = $fgRate * $input['net_weight'];
            DB::table('production_planning_transections')->where('id',$trans_id)->update($rateArr);
        }
    }
    public function transaction_nature($nature_id = null)
    {
        $request = request();
        $nature_id = $request->get('nature_id', $nature_id);
        $transaction_nature = JobworkNature::when($nature_id, function ($sql) use ($nature_id) {$sql->orWhere('id', $nature_id);})
            ->where('is_active', 'Yes')->where('type', 'transaction')->orderBy('name', 'ASC')
            ->pluck('name', 'id')->toArray();
        return $transaction_nature;
    }
    public function process_nature($nature_id = null)
    {
        $request = request();
        $nature_id = $request->get('nature_id', $nature_id);
        $transaction_nature = JobworkNature::when($nature_id, function ($sql) use ($nature_id) {$sql->orWhere('id', $nature_id);})
            ->where('is_active', 'Yes')->where('type', 'process')->orderBy('name', 'ASC')
            ->pluck('name', 'id')->toArray();
        return $transaction_nature;
    }

    public function getAttribute($attribute_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $attribute = Attribute::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $attribute;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $attribute_id = $request->get('attribute_id', $attribute_id);
            $attribute = Attribute::where('is_active', 'Yes')
                ->when($attribute_id, function ($sql) use ($attribute_id) {
                    $sql->orWhere('id', $attribute_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $attribute;
        }
    }

    public function getType($type_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $type = Type::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $type;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $type_id = $request->get('type_id', $type_id);
            $type = Type::where('is_active', 'Yes')
                ->when($type_id, function ($sql) use ($type_id) {
                    $sql->orWhere('id', $type_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $type;
        }
    }

    public function sendMail($template, $email, $otpEmail, $name)
    {
        $smtp_details = get_smtp_details($template);
        if (!empty($smtp_details)) {
            $html = str_replace(['[EMAIL]', '[OTP]', '[NAME]'],[$email, $otpEmail, $name]
            ,$smtp_details->message_body);
            $smtp_details->message_body = $html;

            $transport = (new \Swift_SmtpTransport($smtp_details->host_name, $smtp_details->port))
                ->setUsername($smtp_details->username)
                ->setPassword($smtp_details->password)
                ->setEncryption($smtp_details->encryption);

            $mailer    = new \Swift_Mailer($transport);
            $message   = (new \Swift_Message($smtp_details->subject))
                ->setFrom($smtp_details->username, '')
                ->setTo($email)
                ->setBody($smtp_details->message_body, 'text/html');
            $attachment = ($smtp_details->attachment != '') ? public_path($smtp_details->attachment) : '';

            if ($attachment != '' && file_exists($attachment)) {
                // $message->attach(\Swift_Attachment::fromPath(URL::to($smtp_details->attachment)));
                $attachmentFile =  public_path($smtp_details->attachment);
                $message->attach(\Swift_Attachment::fromPath($attachmentFile));
            }
            $mailer->send($message);
        }
        else {
            throw new MailTemplateException('Mail Template not Found. Please check and try again.');
        }
    }

    public function generateRandumCodeEmail()
    {
        // $rand = substr(md5(microtime()),rand(0,26),6);
        $rand = mt_rand(100000, 999999);
        return $rand;
    }

    public function changeStatusTeam(Request $request, $id)
    {
        $table = $request->table;
        $is_active  = $request->status == 'true' ? 'Yes' : 'No';
        $tableRes = DB::table($table)->where('id', $request->id)->update(['is_active' => $is_active]);

        $model_tableGet = DB::table($table)->where('id', $request->id)->first();
        $user_id =  $model_tableGet->user_id;
        $tableRes = User::where('id',  $user_id)->update(['is_active' => $is_active]);

        $message = $request->status == 'true' ? __('common.active') : __('common.deactivate');

        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public function checkUniqueEmail(Request $request, $id = null)
    {
        $email = $request->email;
        $query = User::where('email', '=', $email);
        if ($id > 0) {
            $query->where('id', '!=', $id);
        }
        $is_exist = $query->get();

        if ($is_exist->count() > 0) {
            return 'false';
        }
        return 'true';
    }

    public function checkUniquePanNumber(Request $request, $id = null)
    {
        $field = $request->input('field');
        $value = trim($request->input('pan_no'));

        $checkField = DB::table($field)
            ->where('pan_no', $value)
            ->whereNull('deleted_at')
            ->when($id, function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })
            ->exists();

        return ($checkField > 0) ? 'false' : 'true';
    }

    public function checkUniqueField(Request $request, $id = null)
    {
        $field = trim($request->input('field'));
        $model = $request->input('model');
        $value  = $request->input($field);
        if($field != ''){
            $checkField = DB::table($model)
            ->where($field,$value)
            ->whereNull('deleted_at')
            ->when($id, function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })
            ->exists();

            return ($checkField > 0) ? 'false' : 'true';
        }
    }

    public function checkUniqueMobile(Request $request, $id = null)
    {
        $roleId = Role::where('slug', $request->input('role'))->value('id');
        $field = trim($request->input('field'));
        $model = $request->input('model');
        $value  = $request->input($field);
        if($field != ''){
            $checkField = DB::table($model)
            ->where($field,$value)
            ->where('roles_id', $roleId)
            ->whereNull('deleted_at')
            ->when($id, function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })
            ->exists();

            return ($checkField > 0) ? 'false' : 'true';
        }
    }

    public function getFinancingSources($financing_sources_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $financing_sources = FinancingSources::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $financing_sources;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $financing_sources_id = $request->get('financing_sources_id', $financing_sources_id);
            $financing_sources = FinancingSources::where('is_active', 'Yes')
                ->when($financing_sources_id, function ($sql) use ($financing_sources_id) {
                    $sql->orWhere('id', $financing_sources_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $financing_sources;
        }
    }

    public function getFacilityType($facility_type_id = null)
    {
        $request = request();

        $facility_type_id = $request->get('facility_type_id', $facility_type_id);
        $facility_types = FacilityType::where('is_active', 'Yes')
            ->when($facility_type_id, function ($sql) use ($facility_type_id) {
                $sql->orWhere('id', $facility_type_id);
            })
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id')->toArray();
        return $facility_types;
    }

    public function getBondTypes($bond_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $bond_types = BondTypes::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $bond_types;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $bond_id = $request->get('bond_id', $bond_id);
            $bond_types = BondTypes::where('is_active', 'Yes')
                ->when($bond_id, function ($sql) use ($bond_id) {
                    $sql->orWhere('id', $bond_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $bond_types;
        }
    }

    public static function IDGenerator($prefix, $model, $length = 4)
    {
        $tableDesc = DB::table($model)->orderBy('id', 'desc')->first() ?? null;

        $id = (!empty($tableDesc)) ? $tableDesc->id + 1 : 1;

        $idNumber = $prefix . "-" . str_pad($id, $length, '0', STR_PAD_LEFT);

        return $idNumber;
    }

    public static function EndorsementIDGenerator($prefix, $length = 4)
    {
        $tableDesc = DB::table('endorsements')->orderBy('id', 'desc')->first() ?? null;

        $id = (!empty($tableDesc)) ? $tableDesc->id + 1 : 1;

        $year = now()->format('Y');

        $idNumber = $prefix.$year. "-" . str_pad($id, $length, '0', STR_PAD_LEFT);

        return $idNumber;
    }

    public function getVersion($id = null, $is_amend = false){       // version
        $maxVersion = DB::table('proposals as p1')->join('proposals as p2', 'p1.code', '=', 'p2.code')->where('p1.id', $id)->max('p2.version');
        if($is_amend){
            $result = $maxVersion + 1;
        } else {
            $result = 1;
        }
        return $result;
    }

    public function getBondCode($prefix, $model, $length = 4)
    {
        $tableDesc = DB::table($model) ?? null;
        $code = $tableDesc->pluck('code');

        $sortedItems = collect($code)->sortByDesc(function ($value) {
            return $value;
        })->values()->all();


        if($tableDesc->get()->count() == 0) {
            $id = 1;
        } else {
            preg_match('/(\d{4})/', $sortedItems[0], $matches);
            $bid_bond_id = str_pad((int) $matches[0], 1, '0', STR_PAD_LEFT);
            $id = $bid_bond_id + 1;
        }

        $idNumber = $prefix . "-" . str_pad($id, $length, '0', STR_PAD_LEFT);

        return $idNumber;
    }
    

    public function getDesignation($designation_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $designation = Designation::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $designation;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $designation_id = $request->get('designation_id', $designation_id);
            $designation = Designation::where('is_active', 'Yes')
                ->when($designation_id, function ($sql) use ($designation_id) {
                    $sql->orWhere('id', $designation_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $designation;
        }
    }

    public function getBankingLimitCategory($banking_limit_category_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $banking_limit_category = BankingLimitCategory::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $banking_limit_category;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $banking_limit_category_id = $request->get('banking_limit_category_id', $banking_limit_category_id);
            $banking_limit_category = BankingLimitCategory::where('is_active', 'Yes')
                ->when($banking_limit_category_id, function ($sql) use ($banking_limit_category_id) {
                    $sql->orWhere('id', $banking_limit_category_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $banking_limit_category;
        }
    }

    public function getAdditionalBonds($additional_bond_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $additionalBonds = AdditionalBond::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();
            $toReturn = $additionalBonds;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $additional_bond_id = $request->get('additional_bond_id', $additional_bond_id);
            $additionalBonds = AdditionalBond::where('is_active', 'Yes')
                ->when($additional_bond_id, function ($sql) use ($additional_bond_id) {
                    $sql->orWhere('id', $additional_bond_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $additionalBonds;
        }
    }

    public function getProposalAdditionalBonds(Request $request)
    {
        $proposal_id = $request->proposal_id;
        $additionalBondData = AdditionalBond::withCount(['bidBond' => function($qry) use($proposal_id){
            $qry->where('proposal_id',$proposal_id);
        },'performanceBond' => function($qry) use($proposal_id){
            $qry->where('proposal_id',$proposal_id);
        },'retentionBond' => function($qry) use($proposal_id){
            $qry->where('proposal_id',$proposal_id);
        },'maintenanceBond' => function($qry) use($proposal_id){
            $qry->where('proposal_id',$proposal_id);
        },'advancePaymentBond' => function($qry) use($proposal_id){
            $qry->where('proposal_id',$proposal_id);
        },'proposalAdditionalBond' => function($qry) use($proposal_id){
            $qry->where('proposal_id',$proposal_id);
        }])
        ->having('bid_bond_count',0)->having('performance_bond_count',0)->having('retention_bond_count',0)->having('maintenance_bond_count',0)->having('advance_payment_bond_count',0)->having('proposal_additional_bond_count','>',0)->get();

        $bondsArr = [];
        if(isset($additionalBondData) && $additionalBondData->count()>0){
            $bondsArr = $additionalBondData->pluck('name','id')->toArray();
        }
        return $bondsArr;
    }

    public function getAdditionalBondDetail(Request $request){
        $proposal_id = $request->proposal_id;
        $additional_bond_id = $request->additional_bond_id;
        if($proposal_id > 0 && $additional_bond_id > 0){
            $additionalBondData = ProposalAdditionalBonds::where(['proposal_id' => $proposal_id,'additional_bond_id' => $additional_bond_id])->first();
            return $additionalBondData;
        }
    }

    public function getProjectType($project_type_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $project_type = ProjectType::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $project_type;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $project_type_id = $request->get('project_type_id', $project_type_id);
            $project_type = ProjectType::where('is_active', 'Yes')
                ->when($project_type_id, function ($sql) use ($project_type_id) {
                    $sql->orWhere('id', $project_type_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $project_type;
        }
    }

    public function getBeneficiary($beneficiary_id = null, $contractor_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $beneficiary = Beneficiary::select('id AS value', 'company_name AS text')->where('is_active', 'Yes')->orderBy('company_name', 'asc')->get();

            $toReturn = $beneficiary;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $beneficiary_id = $request->get('beneficiary_id', $beneficiary_id);
            $beneficiary = Beneficiary::where('beneficiaries.is_active', 'Yes')
                ->when($contractor_id > 0, function ($query) use ($contractor_id) {
                    $query->leftJoin('proposals', 'beneficiaries.id', '=', 'proposals.beneficiary_id')
                    ->where('proposals.contractor_id', $contractor_id);
                })
                ->when($beneficiary_id > 0, function ($sql) use ($beneficiary_id) {
                    $sql->orWhere('beneficiaries.id', $beneficiary_id);
                })
                ->orderBy('beneficiaries.company_name', 'ASC')
                ->pluck('beneficiaries.company_name', 'beneficiaries.id')->toArray();
            return $beneficiary;
        }
    }

    public function getContractor($contractor_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $contractors = Principle::select('id AS value', 'company_name AS text')->where('is_active', 'Yes')->orderBy('company_name', 'asc')->get();

            $toReturn = $contractors;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $contractor_id = $request->get('contractor_id', $contractor_id);
            $field = ['id',DB::raw('(CASE WHEN code is not null THEN CONCAT(code, " | ", company_name) ELSE company_name END) as text')];
            $contractors = Principle::where('is_active', 'Yes')
                ->select($field)
                ->when($contractor_id, function ($sql) use ($contractor_id) {
                    $sql->orWhere('id', $contractor_id);
                })
                ->orderBy('text', 'ASC')
                ->pluck('text', 'id')->toArray();
            return $contractors;
        }
    }

    // public function getJvContractor($contractor_id = null)
    // {
    //     $request = request();

    //     $platform = $request->header('platform');
    //     if ($platform == 1) {
    //         $contractors = Principle::select('id AS value', 'company_name AS text')->where('is_active', 'Yes')->where('is_spv', 'No')->orderBy('company_name', 'asc')->get();

    //         $toReturn = $contractors;
    //         $this->data = $toReturn;

    //         return $this->responseSuccess();
    //     } else {
    //         $contractor_id = $request->get('contractor_id', $contractor_id);
    //         $field = ['id',DB::raw('(CASE WHEN pan_no is not null THEN CONCAT(pan_no, " | ", company_name) ELSE company_name END) as text')];
    //         $contractors = Principle::where('is_active', 'Yes')->where('is_spv', 'No')
    //             ->select($field)
    //             ->when($contractor_id, function ($sql) use ($contractor_id) {
    //                 $sql->orWhere('id', $contractor_id);
    //             })
    //             ->orderBy('text', 'ASC')
    //             ->pluck('text', 'id')->toArray();
    //         return $contractors;
    //     }
    // }
    public function getSpvContractor($contractor_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $contractors = Principle::select('id AS value', 'company_name AS text')->where('is_active', 'Yes')->where('venture_type', 'SPV')->orderBy('company_name', 'asc')->get();

            $toReturn = $contractors;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $contractor_id = $request->get('contractor_id', $contractor_id);
            $field = ['id',DB::raw('(CASE WHEN pan_no is not null THEN CONCAT(company_name, " | ", pan_no) ELSE company_name END) as text')];
            $contractors = Principle::where('is_active', 'Yes')->where('venture_type', 'SPV')
                ->select($field)
                ->when($contractor_id, function ($sql) use ($contractor_id) {
                    $sql->orWhere('id', $contractor_id);
                })
                ->orderBy('text', 'ASC')
                ->pluck('text', 'id')->toArray();
            return $contractors;
        }
    }
    
    // public function getSpvContractor($contractor_id = null)
    // {
    //     $request = request();

    //     $platform = $request->header('platform');
    //     if ($platform == 1) {
    //         $contractors = Principle::select('id AS value', 'company_name AS text')->where('is_active', 'Yes')->where('is_spv', 'Yes')->orderBy('company_name', 'asc')->get();

    //         $toReturn = $contractors;
    //         $this->data = $toReturn;

    //         return $this->responseSuccess();
    //     } else {
    //         $contractor_id = $request->get('contractor_id', $contractor_id);
    //         $field = ['id',DB::raw('(CASE WHEN pan_no is not null THEN CONCAT(pan_no, " | ", company_name) ELSE company_name END) as text')];
    //         $contractors = Principle::where('is_active', 'Yes')->where('is_spv', 'Yes')
    //             ->select($field)
    //             ->when($contractor_id, function ($sql) use ($contractor_id) {
    //                 $sql->orWhere('id', $contractor_id);
    //             })
    //             ->orderBy('text', 'ASC')
    //             ->pluck('text', 'id')->toArray();
    //         return $contractors;
    //     }
    // }
    public function getJvContractor($contractor_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $contractors = Principle::select('id AS value', 'company_name AS text')->where('is_active', 'Yes')->where('venture_type', 'JV')->orderBy('company_name', 'asc')->get();

            $toReturn = $contractors;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $contractor_id = $request->get('contractor_id', $contractor_id);
            $field = ['id',DB::raw('(CASE WHEN pan_no is not null THEN CONCAT(company_name, " | ", pan_no) ELSE company_name END) as text')];
            $contractors = Principle::where('is_active', 'Yes')->where('venture_type', 'JV')
                ->select($field)
                ->when($contractor_id, function ($sql) use ($contractor_id) {
                    $sql->orWhere('id', $contractor_id);
                })
                ->orderBy('text', 'ASC')
                ->pluck('text', 'id')->toArray();
            return $contractors;
        }
    }

    public function getStandAloneContractor($contractor_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $contractors = Principle::select('id AS value', 'company_name AS text')->where('is_active', 'Yes')->where('venture_type', 'Stand Alone')->orderBy('company_name', 'asc')->get();

            $toReturn = $contractors;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $contractor_id = $request->get('contractor_id', $contractor_id);
            $field = ['id',DB::raw('(CASE WHEN pan_no is not null THEN CONCAT(company_name, " | ", pan_no) ELSE company_name END) as text')];
            $contractors = Principle::where('is_active', 'Yes')->where('venture_type', 'Stand Alone')
                ->select($field)
                ->when($contractor_id, function ($sql) use ($contractor_id) {
                    $sql->orWhere('id', $contractor_id);
                })
                ->orderBy('text', 'ASC')
                ->pluck('text', 'id')->toArray();
            return $contractors;
        }
    }

    public function getBondStartDate(){
        $bond_start_period = Setting::where('name', 'bond_start_period')->pluck('value')->first() ?? 0;
        $start_date = Carbon::now()->subDays($bond_start_period)->format('Y-m-d');

        return $start_date;
    }

    public function getEntityType($type_of_entity_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $type_of_entity = TypeOfEntity::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $type_of_entity;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $type_of_entity_id = $request->get('type_of_entity_id', $type_of_entity_id);
            $type_of_entity = TypeOfEntity::where('is_active', 'Yes')
                ->when($type_of_entity_id, function ($sql) use ($type_of_entity_id) {
                    $sql->orWhere('id', $type_of_entity_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $type_of_entity;
        }
    }

    public function getReInsuranceGrouping($id=null){
        $request = request();
        $id = $request->get('re_insurance_grouping_id', $id);
        $ReInsuranceGrouping = ReInsuranceGrouping::where('is_active', 'Yes')
        ->when($id > 0, function ($sql) use ($id) {
            $sql->orWhere('id', $id);
        })
        ->pluck('name', 'id')->toArray();

        return $ReInsuranceGrouping;
    }

    public function getEstablishmentType($establishment_type_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $establishment_type = EstablishmentType::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $establishment_type;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $establishment_type_id = $request->get('establishment_type_id', $establishment_type_id);
            $establishment_type = EstablishmentType::where('is_active', 'Yes')
                ->when($establishment_type_id, function ($sql) use ($establishment_type_id) {
                    $sql->orWhere('id', $establishment_type_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $establishment_type;
        }
    }

    public function getMinistryType($ministry_entity_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $ministry_types = MinistryType::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $ministry_types;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $ministry_entity_id = $request->get('type_of_entity_id', $ministry_entity_id);
            $ministry_types = MinistryType::where('is_active', 'Yes')
                ->when($ministry_entity_id, function ($sql) use ($ministry_entity_id) {
                    $sql->orWhere('id', $ministry_entity_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $ministry_types;
        }
    }

    public function getTender($tender_id = null, $project_details_id = null)
    {
        $request = request();
        $tender_id = $request->get('tender_id', $tender_id);
        $tenderField = ['id',DB::raw('(CASE WHEN code is not null THEN CONCAT(code, " | ", tender_id) ELSE tender_id END) as text')];
        $tender = Tender::when($tender_id > 0, function ($sql) use ($tender_id) {
            $sql->orWhere('id', $tender_id);
        })
        ->when($project_details_id > 0, function ($sql) use ($project_details_id) {
            $sql->orWhere('project_details', $project_details_id);
        })
            ->when(request()->has('project_details_id'), function ($item) {
                $item->where('project_details', request()->project_details_id);
            })
            ->select($tenderField)
            ->where(['is_active' => 'Yes'])
            ->orderBy('id', 'ASC')
            ->pluck('text', 'id')->toArray();
        return $tender;
    }

    public function getTradeSector($trade_sector_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $trade_sector = TradeSector::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $trade_sector;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $trade_sector_id = $request->get('trade_sector_id', $trade_sector_id);
            $trade_sector = TradeSector::where('is_active', 'Yes')
                ->when($trade_sector_id, function ($sql) use ($trade_sector_id) {
                    $sql->orWhere('id', $trade_sector_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $trade_sector;
        }
    }

    public function getUnderWriterOpction($type = null){



           $field  = [
                DB::raw("CONCAT(first_name, ' ', last_name) as user_full_name"),
                DB::raw("CONCAT('Underwriter|',underwriters.id) as underwriter_id") 
                
            ];

            $underwriters = User::select($field)
            ->join('underwriters', 'users.id', '=', 'underwriters.user_id')
            ->where('users.is_active', 'Yes')
            ->whereNull('underwriters.deleted_at')
            ->when(isset($type),function($q)use($type){
                $q->where('underwriters.type',$type);
            })
            ->orderBy(DB::raw("CONCAT(first_name, ' ', last_name)"), 'ASC')
            ->pluck('user_full_name', 'underwriter_id')
            ->toArray();

            $user = User::select([
                DB::raw("CONCAT(first_name, ' ', last_name) as user_full_name"),
                DB::raw("CONCAT('User|',id) as id") 
            ])
            ->where('is_created_directly',1)
            ->where('users.is_active', 'Yes')
            ->pluck('user_full_name','id')
            ->toArray();
            
            $mergedArray = array_merge(['Underwriter'=>$underwriters],['User'=>$user]);

            return $mergedArray;

        // $underWriter = UnderWriter::with('user')
        // ->when(isset($type),function($q)use($type){
        //     $q->where('type',$type);
        // })
        // ->where('is_active','Yes')
        // ->get();
        
        // $underWriter = $underWriter->pluck('user.full_name','id')->toArray();

        return $underWriter;
    }

    public function getInvocationReason(){

        $invocation_reason = InvocationReason::where('is_active','Yes')
        ->orderBy('reason', 'ASC')
        ->pluck('reason', 'id')
        ->toArray();

        return $invocation_reason;
    }

    public function getDocumentTypeOpction(){
        $document_type = DocumentType::pluck('name','id')->toArray();
        
        return $document_type;
    }

    public function getFileSourceOpction(){
        $file_source = FileSource::pluck('name','id')->toArray();
        
        return $file_source;
    }

    public function storeMultipleFiles($request, $repeaterFiles, $fileItem, $model, $model_id, $folder)
    {
        foreach ($repeaterFiles as $item) {
            if ($item instanceof \Illuminate\Http\UploadedFile) {
                $filePath = $this->uploadFile($request, $folder . '/' . $model_id, $fileItem, $item);
                $fileName = basename($filePath);

                $model->dMS()->create([
                    'file_name' => $fileName,
                    'attachment' => $filePath,
                    'attachment_type' => $fileItem,
                    'file_source_id'=>$request->file_source_id ?? null,
                    'document_type_id'=>$request->document_type_id ??  null,
                    'final_submission'=>$request->final_submission ??  'No',
                    'dmsamend_type'=>$request->dmsamend_type ??  null,
                    'dmsamend_id'=>$request->dmsamend_id ??  null,
                    'document_specific_type' => $request->document_specific_type ?? null,
                ]);
            }
        }
    }

    public function uploadFile($request, $folder, $fileItem, $item)
    {
        $uploadFolder = public_path('uploads/' . $folder);
        if (!file_exists($uploadFolder)) {
            mkdir($uploadFolder, 0775, true);
        }

        $fileName = $item->getClientOriginalName();
        $filePath = $item->move($uploadFolder, $fileName);
        return 'uploads/' . $folder . '/' . $fileName;
    }

    public function updateMultipleFiles($request, $repeaterFiles, $fileItem, $model, $model_id, $folder)
    {
        // dd($request->all());
        foreach ($repeaterFiles as $item)
        {
            $existingDoc = $model->dMS()->where('attachment_type', $fileItem)->first();

            $filePath = $this->uploadFile($request, $folder . '/' . $model_id, $fileItem, $item);
            $fileName = basename($filePath);

            // if(isset($existingDoc->attachment)) {
            //     dd('111');
            //     File::delete($existingDoc->attachment);
            //     $existingDoc->update([
            //         'file_name' => $fileName,
            //         'attachment' => $filePath,
            //     ]);
            // } else {
            //     dd('222');
            //     $model->dMS()->create([
            //         'file_name' => $fileName,
            //         'attachment' => $filePath,
            //         'attachment_type' => $fileItem,
            //     ]);
            // }

            $model->dMS()->create([
                'file_name' => $fileName,
                'attachment' => $filePath,
                'attachment_type' => $fileItem,
            ]);
        }
    }

    public function deleteMultipleFileRepeater($relation)
    {
        foreach($relation as $item) {
            $dms_item = DMS::where('dmsable_id', $item->id)->delete();
            foreach($item->dMS->pluck('attachment') as $item1) {
                File::delete($item1);
            };
        }
    }

    public function sendCustomMail($tamplate,$params){
        $smtp_details = get_smtp_details($tamplate);
        if (!empty($smtp_details)) {

            $smtp_details->subject = $params['subject'];
            $smtp_details->message_body = $params['message'];
            

            $transport = (new \Swift_SmtpTransport($smtp_details->host_name, $smtp_details->port))
                ->setUsername($smtp_details->username)
                ->setPassword($smtp_details->password)
                ->setEncryption($smtp_details->encryption);

            $mailer    = new \Swift_Mailer($transport);
            $message   = (new \Swift_Message($smtp_details->subject))
                ->setFrom($smtp_details->username, '')
                ->setTo($params['email'])
                ->setBody($smtp_details->message_body, 'text/html');
            $attachment = ($smtp_details->attachment != '') ? public_path($smtp_details->attachment) : '';

            if ($attachment != '' && file_exists($attachment)) {
                $message->attach(\Swift_Attachment::fromPath(URL::to($smtp_details->attachment)));
            }
            $mailer->send($message);
        }
        else {
            throw new \ErrorException('Mail Template not Found Please check and try again.');
        }
    }
    public function getCurrency($currency_id = null)
    {
        $request = request();
        $platform = $request->header('platform');
        if ($platform == 1) {
            $currencys = Currency::select('id AS value', 'short_name AS text')->where('is_active', 'Yes')->orderBy('short_name', 'asc')->get();
            $this->data = $currencys;
            return $this->responseSuccess();
        } else {
            $currency_id = $request->get('currency_id', $currency_id);
            $currencys = Currency::where('is_active', 'Yes')
                ->when($currency_id, function ($sql) use ($currency_id) {
                    $sql->orWhere('id', $currency_id);
                })
                ->orderBy('short_name', 'ASC')
                ->pluck('short_name', 'id')->toArray();
            return $currencys;
        }
    }
    public function getSoure($source,$id=null)
    {
        $request = Request();
        $source = $request->get('source', $source);
        $users = [];
        if($source !=''){
            $fields = [
                'u.id',
                DB::raw("CONCAT(first_name,' ',last_name) as user_name")
            ];
            $users = DB::table('users as u')
            ->join('roles as r','r.id','u.roles_id')
            ->select($fields)
            ->where('u.is_active', 'Yes')
            ->where('r.slug', $source)
            ->when($id > 0, function ($sql) use ($id) {
                $sql->orWhere('u.id', $id);
            })
            ->whereNull('u.deleted_at')
            ->whereNull('r.deleted_at')
            ->pluck('user_name', 'u.id')
            ->toArray();
        }
        return $users;
    }
    public function getTenure($tenure_id = null)
    {
        $request = request();
        $tenure_id = $request->get('tenure_id', $tenure_id);
        $tenures = Tenure::where('is_active', 'Yes')
            ->when($tenure_id, function ($sql) use ($tenure_id) {
                $sql->orWhere('id', $tenure_id);
            })
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id')->toArray();
        return $tenures;
    }
    public function getWorkType($work_type_id=null){
        $request = request();
        $work_type_id = $request->get('work_type_id', $work_type_id);
        $work_types = WorkType::where('is_active', 'Yes')
            ->when($work_type_id, function ($sql) use ($work_type_id) {
                $sql->orWhere('id', $work_type_id);
            })
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id')->toArray();
        return $work_types;
    }

    public function getProposalByBondType($bond_type,$proposal_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $proposals = Proposal::with('getBondTypeName')
            ->when($bond_type,function($qry) use($bond_type){
               $qry->whereHas('getBondTypeName',function($q) use($bond_type){
                    $q->where('name',$bond_type);
              });
            })
            ->select('id AS value', DB::raw("CONCAT(code, ' - ', full_name) as proposal_name"))->where('is_active', 'Yes')->orderBy('proposal_name', 'asc')->get();

            $toReturn = $proposals;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $proposal_id = $request->get('proposal_id', $proposal_id);
            $proposals = $proposals = Proposal::with('getBondTypeName')
                ->when($bond_type,function($qry) use($bond_type){
                    $qry->whereHas('getBondTypeName',function($q) use($bond_type){
                            $q->where('name',$bond_type);
                    });
                })
                ->when($proposal_id, function ($sql) use ($proposal_id) {
                    $sql->orWhere('id', $proposal_id);
                })
                ->select('id', DB::raw("CONCAT(code) as proposal_name"))
                ->orderBy('proposal_name', 'ASC')
                ->pluck('proposal_name', 'id')->toArray();
            return $proposals;
        }
    }
    public function getIssuingOfficeBranch($issuing_office_branch_id=null){
        $request = request();
        $issuing_office_branch_id = $request->get('issuing_office_branch_id', $issuing_office_branch_id);
        $issuingOfficeBranch = IssuingOfficeBranch::where('is_active', 'Yes')
            ->when($issuing_office_branch_id, function ($sql) use ($issuing_office_branch_id) {
                $sql->orWhere('id', $issuing_office_branch_id);
            })
            ->orderBy('branch_name', 'ASC')
            ->pluck('branch_name', 'id')->toArray();
        return $issuingOfficeBranch;
    }

    public function getPrincipleTypes($principle_types_id=null){
        $request = request();
        $principle_types_id = $request->get('principle_types_id', $principle_types_id);
        $principleTypes = PrincipleType::where('is_active', 'Yes')
            ->when($principle_types_id, function ($sql) use ($principle_types_id) {
                $sql->orWhere('id', $principle_types_id);
            })
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id')->toArray();
        return $principleTypes;
    }

    public function removeDmsAttachment(Request $request){
        $dms_attachment_id = $request->id;
        $dmsAttachment = DMS::find($dms_attachment_id);

        unlink_file($dmsAttachment->attachment);
        $dmsAttachment->delete();
    }

    public function dMSDocument(Request $request, $id = '')
    {
        $attachment_type = $request->attachment_type ?? '';
        $dmsable_type = $request->dmsable_type ?? '';

        $this->data['dms'] = DMS::where('attachment_type', $attachment_type)->where('dmsable_type', $dmsable_type)->where('dmsable_id', $id)->get();

        return response()->json(['html' => view('documentShow', $this->data)->render()]);
    }

    public function AutoFetchdMSDocument(Request $request)
    {
        $attachment_type = $request['attachment_type'] ?? '';
        $dmsable_type = $request['dmsable_type'] ?? '';
        // dd($attachment_type, $dmsable_type, $request->all());

        $this->data['dms'] = DMS::where('attachment_type', $attachment_type)->where('dmsable_type', $dmsable_type)->where('dmsable_id', $request->id)->get();
        // dd($this->data['dms']);

        return response()->json(['html' => view('proposals.autofield.dmsDocumentShow', $this->data)->render()]);
    }

    public function changeStatusBlacklist(Request $request, $id)
    {
        $table = $request->table;
        $is_active_blacklist = $request->status == 'true' ? 'Yes' : 'No';
        $is_active  = $request->status == 'true' ? 'No' : 'Yes';
        $status = $request->status == 'true' ? 'Blacklisted' : 'Approved';
        $tableRes = DB::table($table)->where('id', $request->id)->update(['is_active' => $is_active_blacklist]);

        $model_tableGet = DB::table($table)->where('id', $request->id)->first();

        $contractor = Principle::with('user')->where('id', $model_tableGet->contractor_id)->first();
        $contractorStatus = $contractor->update(['is_active' => $is_active, 'status' => $status]);
        $tableRes = $contractor->user->update(['is_active' => $is_active]);

        $message = $request->status == 'true' ? __('common.active') : __('common.deactivate');

        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public function getRejectionReason($rejection_reason_id = null){
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $rejection_reason = RejectionReason::select('id AS value', 'reason AS text')->where('is_active', 'Yes')->orderBy('reason', 'asc')->get();

            $toReturn = $rejection_reason;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $rejection_reason_id = $request->get('rejection_reason_id', $rejection_reason_id);
            $rejection_reason = RejectionReason::where('is_active', 'Yes')
                ->when($rejection_reason_id, function ($sql) use ($rejection_reason_id) {
                    $sql->orWhere('id', $rejection_reason_id);
                })
                ->orderBy('reason', 'ASC')
                ->pluck('reason', 'id')->toArray();
            return $rejection_reason;
        }
    }

    public function updateBondPolicyIssueAndChecklist($proposal_id, $version){
        $bondChecklist = BondPoliciesIssueChecklist::with('dMS')->where('proposal_id', $proposal_id)->where('version', $version)->where('is_amendment', 0);

        $checklistDms = $bondChecklist->first();
        if(isset($checklistDms->dMS) && $checklistDms->dMS->count() > 0){
            foreach($checklistDms->dMS as $item){
                $item->update(['is_amendment' => '1']);
            }
        }
        $bondChecklist->update(['is_amendment' => '1']);
        BondPoliciesIssue::where('proposal_id', $proposal_id)->where('version', $version)->update(['is_amendment' => '1']);
    }

    public function getInitMonthArray()
    {
        $month_array = [
            '4'=>0,
            '5'=>0,
            '6'=>0,
            '7'=>0,
            '8'=>0,
            '9'=>0,
            '10'=>0,
            '11'=>0,
            '12'=>0,
            '1'=>0,
            '2'=>0,
            '3'=>0
        ];

        return $month_array;
    }

    public function getBond($bond_id = null){
        $bonds = ['bid_bonds' => BidBond::class, 'performance_bonds' => PerformanceBond::class, 'advance_payment_bonds' => AdvancePaymentBond::class, 'retention_bonds' => RetentionBond::class, 'maintenance_bonds' => MaintenanceBond::class];

        $request = request();
        $allBonds = [];

        foreach ($bonds as $key => $item) {
            $platform = $request->header('platform');

            if ($platform == 1) {

                $bond = $item::select('id AS value', 'reason AS text')
                    ->where('is_active', 'Yes')
                    ->orderBy('reason', 'asc')
                    ->get();

                $allBonds = $bond;
            } else {
                $bond_id = $request->get('id');
                $bondType = class_basename($item);

                $bond = $item::where('is_active', 'Yes')
                    ->leftJoin('bonds', function($join) use($key, $bondType){
                        $join->on($key . '.id', '=', 'bonds.bondsable_id')->where('bondsable_type', $bondType)->where('bonds.is_amendment', 0);
                    })
                    ->when($bond_id, function ($sql) use ($bond_id) {
                        $sql->orWhere('id', $bond_id);
                    })
                    ->select($key . '.id', DB::raw("CONCAT(code, '/', version) as bondCode"), 'bonds.bondsable_type', 'bonds.id as bondID')
                    ->orderBy('id', 'ASC')
                    ->where($key . '.is_amendment', 0)
                    ->pluck('bondCode', 'bondID')
                    ->toArray();

                $allBonds[$bondType] = $bond;
            }
        }

        if ($platform == 1) {
            $this->data = $allBonds;
            return $this->responseSuccess();
        } else {
            return $allBonds;
        }
    }

    public function getAgency($agency_id = null){
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $agency = Agency::select('id AS value', 'agency_name AS text')->where('is_active', 'Yes')->orderBy('id', 'asc')->get();

            $toReturn = $agency;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $agency_id = $request->get('agency_id', $agency_id);
            $agency = Agency::where('is_active', 'Yes')
                ->when($agency_id, function ($sql) use ($agency_id) {
                    $sql->orWhere('id', $agency_id);
                })
                ->orderBy('id', 'ASC')
                ->pluck('agency_name', 'id')->toArray();
            return $agency;
        }
    }

    public function getRating($rating_id = null){
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $rating = AgencyRating::select('id AS value', 'rating AS text')->where('is_active', 'Yes')->orderBy('id', 'asc')->get();

            $toReturn = $rating;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $rating_id = $request->get('rating_id', $rating_id);
            $rating = AgencyRating::where('is_active', 'Yes')
                ->when($rating_id, function ($sql) use ($rating_id) {
                    $sql->orWhere('id', $rating_id);
                })
                ->orderBy('id', 'ASC')
                ->pluck('rating', 'id')->toArray();
            return $rating;
        }
    }

    public function getProjectDetails($project_details_id = null, $beneficiary_id = null)
    {
        $request = request();
        $project_details_id = $request->get('project_details', $project_details_id);
        $projectDetailsField = ['id',DB::raw('(CASE WHEN code is not null THEN CONCAT(code, " | ", project_name) ELSE project_name END) as text')];
        $project_details = ProjectDetail::when($project_details_id > 0, function ($sql) use ($project_details_id) {
            $sql->orWhere('id', $project_details_id);
        })
            ->when($beneficiary_id > 0, function ($sql) use ($beneficiary_id) {
                $sql->orWhere('beneficiary_id', $beneficiary_id);
            })
            ->when(request()->has('beneficiary_id'), function ($item) {
                $item->where('beneficiary_id', request()->beneficiary_id);
            })
            ->select($projectDetailsField)
            ->where(['is_active' => 'Yes'])
            ->orderBy('id', 'ASC')
            ->pluck('text', 'id')->toArray();
        return $project_details;
    }

    public function getTypeofForeClosure($type_of_foreclosure_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $type_of_foreclosure = TypeofForeClosure::select('id AS value', 'name AS text')->where('is_active', 'Yes')->orderBy('name', 'asc')->get();

            $toReturn = $type_of_foreclosure;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $type_of_foreclosure_id = $request->get('type_of_foreclosure_id', $type_of_foreclosure_id);
            $type_of_foreclosure = TypeofForeClosure::where('is_active', 'Yes')
                ->when($type_of_foreclosure_id, function ($sql) use ($type_of_foreclosure_id) {
                    $sql->orWhere('id', $type_of_foreclosure_id);
                })
                ->orderBy('name', 'ASC')
                ->pluck('name', 'id')->toArray();
            return $type_of_foreclosure;
        }
    }

    public function getBondNumber($bond_policies_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $bond_policies = BondPoliciesIssue::select('id AS value', 'bond_number AS text')->where('is_active', 'Yes')->orderBy('bond_number', 'asc')->get();

            $toReturn = $bond_policies;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $bond_policies_id = $request->get('bond_policies_id', $bond_policies_id);

            $field = ['id', DB::raw('CONCAT_WS(" | ", bond_policies_issue.reference_no, bond_policies_issue.bond_number) as bondNumber')];
            $bond_policies = BondPoliciesIssue::where('is_active', 'Yes')
                ->when($bond_policies_id, function ($query) use ($bond_policies_id) {
                    // $query->orWhere('id', $bond_policies_id);
                    $query->whereIn('id', $bond_policies_id);
                }, function ($q) {
                    $q->whereHas('proposal', function ($query) {
                        // $query->where('is_bond_foreclosure', 0)->where('is_bond_cancellation', 0)->where('is_invocation_notification', 0)->where('is_amendment', 0)->whereNull('deleted_at');

                        $query->where([
                            'bond_policies_issue.is_amendment' => 0,
                            'proposals.is_issue' => 1,
                            'proposals.is_bond_foreclosure' => 0,
                            'proposals.is_bond_cancellation' => 0,
                            'proposals.is_invocation_notification' => 0
                        ])->whereNull('proposals.deleted_at');
                    });
                })
                ->select($field)
                ->orderBy('id', 'ASC')
                ->pluck('bondNumber', 'id')
                ->toArray();

            return $bond_policies;
        }
    }

    public function getCurrencySymbol($country_id){
        // dd($country_id);
        $currencySymbol = Currency::where('country_id', $country_id)->pluck('symbol')->first();
        return $currencySymbol;
    }

    public function getClaimExaminer($claim_examiner_id = null){
        $field  = [
            DB::raw("CONCAT(first_name, ' ', last_name) as user_full_name"),
            DB::raw("CONCAT('Claim Examiner|',claim_examiners.id) as claim_examiner_id") 
        ];

        $claim_examiner = User::select($field)
        ->join('claim_examiners', 'users.id', '=', 'claim_examiners.user_id')
        ->where('users.is_active', 'Yes')
        ->whereNull('claim_examiners.deleted_at')
        ->orderBy(DB::raw("CONCAT(first_name, ' ', last_name)"), 'ASC')
        ->pluck('user_full_name', 'claim_examiner_id')
        ->toArray();

        $user = User::select([
            DB::raw("CONCAT(first_name, ' ', last_name) as user_full_name"),
            DB::raw("CONCAT('User|',id) as id") 
        ])
        ->where('is_created_directly',1)
        ->where('users.is_active', 'Yes')
        ->pluck('user_full_name','id')
        ->toArray();
        
        $mergedArray = array_merge(['Claim Examiner'=>$claim_examiner],['User'=>$user]);
        return $mergedArray;
    }

    public function secureFileShow($path)
    {
        $user = Sentinel::getUser();
        if (!$user) {
            return redirect('/');
        }
        if(File::exists($path)){

            $filePath = $path;
            $originalFilename = basename($path);

            $mimeType = File::mimeType($filePath); 

            return response()->stream(function () use ($filePath) {
                readfile($filePath, true); 
            }, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $originalFilename . '"',
            ]);

            // return response()->file(public_path($path));
        } else {
            abort(404);
        }
    }
    
    public function getTeamMemberByUserId($role_type,$user_id){

        $team_member_id = null;

        switch ($role_type) {
            case 'contractor':
                $team_member_id = Principle::firstWhere('user_id',$user_id)->id;
                break;

            case 'claim-examiner':
                $team_member_id = ClaimExaminer::firstWhere('user_id',$user_id)->id;
                break;
                
            case 'beneficiary':
                $team_member_id = Beneficiary::firstWhere('user_id',$user_id)->id;
                break;
                
            default:
                
                break;
        }

        return $team_member_id;
    }

    public function getInvocationNumber($invocation_notification_id = null)
    {
        $request = request();

        $platform = $request->header('platform');
        if ($platform == 1) {
            $invocation_notification = InvocationNotification::select('id AS value', 'code AS text')->orderBy('code', 'asc')->get();

            $toReturn = $invocation_notification;
            $this->data = $toReturn;

            return $this->responseSuccess();
        } else {
            $invocation_notification_id = $request->get('invocation_notification_id', $invocation_notification_id);
            $invocation_notification = InvocationNotification::
                when($invocation_notification_id, function ($sql) use ($invocation_notification_id) {
                    $sql->orWhere('id', $invocation_notification_id);
                })
                ->orderBy('code', 'ASC')
                ->pluck('code', 'id')->toArray();
            return $invocation_notification;
        }
    }

    public function filterLetterOfAwardDetails(Request $request)
    {
        $beneficiaries = $this->getBeneficiary(null, $request->contractor_id);
        $project_details = $this->getProjectDetails(null, $request->beneficiary_id);
        $tenders = $this->getTender(null, $request->project_details_id);

        $response = [
            "beneficiaries" => $beneficiaries,
            "project_details" => $project_details,
            "tenders" => $tenders,
        ];

        return $response;
    }
    public function getTeamMemberByType($intermediary_detail_type=null){

        $intermediary_detail_data=null; 

        $intermediary_detail_type = request()->get('type',$intermediary_detail_type);

        switch ($intermediary_detail_type) {
            case 'Broker':
                $intermediary_detail_data = Broker::where('is_active','Yes')->pluck('company_name','id')->toArray();
                break;
            case 'Agent':
                $intermediary_detail_data = Agent::select('agents.id',DB::raw('CONCAT(users.first_name, " ", users.last_name) as name'))
                ->join('users','agents.user_id','=','users.id')
                ->where('agents.is_active','Yes')->pluck('name','id')->toArray();
                break;
        }

        return $intermediary_detail_data;

    }
    public function getDetailByTeamMember($intermediary_detail_id=null,$intermediary_detail_type=null){
        
        $intermediary_detail_id = request()->get('intermediary_detail_id',$intermediary_detail_id);

        $intermediary_detail_type = request()->get('intermediary_detail_type',$intermediary_detail_type);

          switch ($intermediary_detail_type) {
            case 'Broker':
                $intermediary_detail_data = Broker::select('brokers.*')->with('intermediaryDetailsFirst')
                ->join('users','brokers.user_id','users.id')
                ->firstWhere('brokers.id',$intermediary_detail_id)?->intermediaryDetailsFirst;
                break;
            case 'Agent':
                $intermediary_detail_data = Agent::select('agents.*')->with('intermediaryDetailsFirst')->join('users','agents.user_id','users.id')->firstWhere('agents.id',$intermediary_detail_id)?->intermediaryDetailsFirst;
                break;
        }

        return $intermediary_detail_data;


    }
    public function markAsRead($model){
        
        $user = Sentinel::getUser();

        if (!$model->markAsRead()->where('created_by',$user->id)->exists()) {
            $model->markAsRead()->create();
        }
    }

    public function getUserByType($type = null)
    {   
        if (request()->has('type')) {
            $type = request()->get('type');
        }
        
        $data = User::select('users.id', DB::raw('CONCAT_WS(" ", users.first_name, users.middle_name, users.last_name) as user_name'))->where('is_active', 'Yes')
            ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
            ->where('roles.slug', $type)
            ->pluck('user_name', 'users.id')
            ->toArray();

        return $data;
    }

    public function ckeditorUpload(Request $request){
        $file = $request->file('upload');
        $fileName = $file->getClientOriginalName();
        $path = 'uploads/ck_editor';
        $file->move(public_path($path), $fileName);
        $imageUrl = asset($path . '/' . $fileName);

        return response()->json([
            'url' => $imageUrl
        ]);
    }
}
