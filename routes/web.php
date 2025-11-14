<?php

use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BeneficiaryDashbordController;
use App\Http\Controllers\ClaimExaminerDashbordController;
use App\Http\Controllers\ContractorWiseReportController;
use App\Http\Controllers\BondTypeWiseReportController;
use App\Http\Controllers\BeneficiaryWiseReportController;
use App\Http\Controllers\GeneralDashboardController;
use App\Http\Controllers\ProjectDetailsWiseReportController;
use App\Http\Controllers\TenderWiseReportController;
use App\Http\Controllers\PrincipleController;
use App\Http\Controllers\SuperAdminDashbordController;
use App\Http\Controllers\UnderWriterDashbordController;
use App\Models\Principle;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\TenureController;
use App\Http\Controllers\NbiController;
use App\Http\Controllers\InvocationReasonController;
use App\Http\Controllers\RecoveryController;
use App\Http\Controllers\ContractorDashbordController;
use App\Http\Controllers\ScriptController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Run database migrations
Route::get('/db-migration', function () {
    Artisan::call('migrate');
    echo 'Migrated successfully.';
});

Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	Artisan::call('route:clear');
	Artisan::call('view:clear');
	echo 'All clear done successfully.';
});

Route::get('{any}/decryptID', function ($any) {
    $segments = explode('/', $any);
    $updatedSegments = collect($segments)->map(function ($segment) {
        try {
            return decryptId($segment);
        } catch (\Exception $e) {
            return $segment;
        }
    });

    $decryptedUrl = url(implode('/', $updatedSegments->toArray()));
    dd($decryptedUrl);
    return redirect($decryptedUrl);
})->where('any', '.*');

// Run user seeder
Route::get('/user-seed', function () {
    Artisan::call('db:seed', ['--class' => SentinelDatabaseSeeder::class]);
    echo 'Seeding successfully.';
});

// Run series seeder
Route::get('/series-seed', function () {
    Artisan::call('db:seed', ['--class' => SeriesSeeder::class]);
    echo 'Seeding successfully.';
});

// Run Role seeder
Route::get('/role-seed', function () {
    Artisan::call('db:seed', ['--class' => RoleSeeder::class]);
    echo 'Role Seeding Successfull';
});

Route::get('/setattendance', function () {
    Artisan::call('command:setAttendance');
    echo 'atttendance Cron Command Run successfully.';
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', ['as' => 'auth.login.form', 'uses' => 'Auth\SessionController@getLogin']);
Route::post('/', function () {
    return  ['status' => 'fail', 'message' => 'You are not authorise'];
});
Route::post('login', [SessionController::class, 'postLogin'])->name('auth.login.attempt');
Route::any('logout', [SessionController::class, 'getLogout'])->name('auth.logout');

// Password Reset
Route::get('password/reset/{code}', 'Auth\PasswordController@getReset')->name('auth.password.reset.form');
Route::post('password/reset/{code}', 'Auth\PasswordController@postReset')->name('auth.password.reset.attempt');
Route::get('password/reset', 'Auth\PasswordController@getRequest')->name('auth.password.request.form');
Route::post('password/reset', 'Auth\PasswordController@postRequest')->name('auth.password.request.attempt');


Route::post('/change-status/{id}', [CommonController::class,'changeStatus'])->name('common.change-status');
Route::post('/change-inactive-status/{id}', [CommonController::class,'changeInactiveStatus'])->name('common.change-inactive-status');
Route::match(['get','post'], 'get-info', [CommonController::class,'getInfoData'])->name('get-info');
Route::match(['post', 'put'], 'get-states', [CommonController::class, 'getStates'])->name('get-states');
Route::get('get-countries', [CommonController::class,'getCountries'])->name('get-countries');
Route::post('/change-display/{id}', 'YearController@changeDisplay')->name('common.change-displayed');
Route::match(['post', 'put'], 'get-beneficiary-project-details', [CommonController::class, 'getProjectDetails'])->name('get-beneficiary-project-details');
Route::match(['post', 'put'], 'get-tender-details', [CommonController::class, 'getTender'])->name('get-tender-details');
Route::match(['post', 'put'], 'get-beneficiary-details', [CommonController::class, 'getBeneficiary'])->name('get-beneficiary-details');
// Route::get('get-currency-symbol/{id}', [CommonController::class,'getCurrencySymbol'])->name('getCurrencySymbol');
Route::get('get-currency-symbol/{id}', [CommonController::class,'getCurrencySymbol'])->name('getCurrencySymbol');


// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/master-page', [DashboardController::class, 'masterPages'])->name('masterPages');
//superadmin Dashboard
Route::get('/admin-dashboard', SuperAdminDashbordController::class)->name('dashboard.superadmin');
//contractor Dashboard
Route::get('/contractor-dashboard', ContractorDashbordController::class)->name('dashboard.contractor');
//underwriter Dashboard
Route::get('/underwriter-dashboard', UnderWriterDashbordController::class)->name('dashboard.underwriter');
//claim-examiner Dashboard
Route::get('/claim-examiner-dashboard', ClaimExaminerDashbordController::class)->name('dashboard.claim-examiner');
//claim-examiner Dashboard
Route::get('/beneficiary-dashboard', BeneficiaryDashbordController::class)->name('dashboard.beneficiary');
//general Dashboard (non-team member)
Route::get('/general-dashboard', GeneralDashboardController::class)->name('dashboard.general');


// Logs
Route::get('/logs', [DashboardController::class, 'logs'])->name('logs');
Route::post('/loadmore-logs', [DashboardController::class, 'loadMoreLogs'])->name('loadmore.logs');

// Global Search
Route::get('/search', 'SearchController@index')->name('search.index');

// Reports
Route::get('reports', ReportController::class)->name('reports');

//customer wise report 

Route::group(['prefix'=>'report'],function(){
    Route::get('contractor-wise-report',[ContractorWiseReportController::class,'index'])->name('report.contractor-wise.index');
     Route::post('contractor-wise-report-show',[ContractorWiseReportController::class,'show'])->name('report.contractor-wise.show');
     Route::get('contractor-wise-report-datalist',[ContractorWiseReportController::class,'datalist'])->name('report.contractor-wise.datalist');
    Route::get('contractor-wise-report-excel', [ContractorWiseReportController::class, 'excel'])->name('report.contractor-wise-report-excel');

    Route::get('bond-type-wise-report', [BondTypeWiseReportController::class, 'index'])->name('report.bond-type-wise.index');
    Route::post('bond-type-wise-report-show', [BondTypeWiseReportController::class, 'show'])->name('report.bond-type-wise.show');
    Route::get('bond-type-wise-report-datalist',[BondTypeWiseReportController::class,'datalist'])->name('report.bond-type-wise.datalist');
    Route::get('bond-type-wise-report-excel', [BondTypeWiseReportController::class, 'excel'])->name('report.bond-type-wise-report-excel');

    Route::get('beneficiary-wise-report', [BeneficiaryWiseReportController::class, 'index'])->name('report.beneficiary-wise.index');
    Route::post('beneficiary-wise-report-show', [BeneficiaryWiseReportController::class, 'show'])->name('report.beneficiary-wise.show');
    Route::get('beneficiary-wise-report-datalist',[BeneficiaryWiseReportController::class,'datalist'])->name('report.beneficiary-wise.datalist');
    Route::get('beneficiary-wise-report-excel', [BeneficiaryWiseReportController::class, 'excel'])->name('report.beneficiary-wise-report-excel');

    Route::get('project-details-wise-report', [ProjectDetailsWiseReportController::class, 'index'])->name('report.project-details-wise.index');
    Route::post('project-details-wise-report-show', [ProjectDetailsWiseReportController::class, 'show'])->name('report.project-details-wise.show');
    Route::get('project-details-wise-report-datalist',[ProjectDetailsWiseReportController::class,'datalist'])->name('report.project-details-wise.datalist');
    Route::get('project-details-wise-report-excel', [ProjectDetailsWiseReportController::class, 'excel'])->name('report.project-details-wise-report-excel');

    Route::get('tender-wise-report', [TenderWiseReportController::class, 'index'])->name('report.tender-wise.index');
    Route::post('tender-wise-report-show', [TenderWiseReportController::class, 'show'])->name('report.tender-wise.show');
    Route::get('tender-wise-report-datalist',[TenderWiseReportController::class,'datalist'])->name('report.tender-wise.datalist');
    Route::get('tender-wise-report-excel', [TenderWiseReportController::class, 'excel'])->name('report.tender-wise-report-excel');
});

//

// User
Route::resource('users', \UserController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('/auto-login/{id}/{type?}', [UserController::class,'autologin'])->name('user.auto-login');
Route::get('/get-employee', [UserController::class, 'getEmployeeData'])->name('getEmployeeData');

// Role
Route::resource('roles', \RoleController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('/get-role-permission', [RoleController::class, 'getRolePermission'])->name('getRolePermissions');
Route::get('/get-users-list', [RoleController::class, 'getUsersList'])->name('role.getUsersList');

// Setting
Route::resource('settings', SettingController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::delete('/session-delete/{type?}', 'SettingController@sessionDelete')->name('session-delete');

Route::post('/change-status-team/{id}', [CommonController::class, 'changeStatusTeam'])->name('common.change-status-team');
Route::post('/change-status-blacklist/{id}', [CommonController::class, 'changeStatusBlacklist'])->name('common.change-status-blacklist');

// Profile

// Route::get('profile', 'ProfileController@index')->name('profile.index');
Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('profile/update', 'ProfileController@update')->name('profile.update');
Route::get('profile/change_password', 'ProfileController@change_password')->name('profile.change_password');
Route::post('profile/update-password', 'ProfileController@update_password')->name('profile.update-password');

// ----------------------------- Start Master ----------------------------------

Route::resource('financing_sources', FinancingSourcesController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('bond_types', BondTypesController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('insurance_companies', InsuranceCompaniesController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('check-duplicate-email/{id?}', 'InsuranceCompaniesController@checkUniqueField')->name('insurance_companies.checkUniqueField');
Route::resource('file_source', FileSourceController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('designation', DesignationController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('principle_type', PrincipleTypeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('document_type', DocumentTypeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('re-insurance-grouping', ReInsuranceGroupingController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('trade_sector', TradeSectorController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('agent', AgentController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('broker', BrokerController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('underwriter', UnderWriterController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('principle', PrincipleController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('get-contractor-detail-by-id', 'PrincipleController@getContractorDetailById')->name('getContractorDetailById');
Route::resource('beneficiary', BeneficiaryController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('employee', EmployeeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('relationship_manager', RelationshipManagerController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('group', GroupController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('contractor-name-group', 'GroupController@getContractorGroup')->name('contractor-name-group');
Route::resource('project-details', ProjectDetailController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('get-project-detail-currency', 'ProjectDetailController@getProjectDetailCurrencySymbol')->name('getProjectDetailCurrencySymbol');

Route::get('bond', BondController::class)->name('bond.index');
Route::post('get-proposal-additional-bonds', 'CommonController@getProposalAdditionalBonds')->name('get-proposal-additional-bonds');
Route::get('get-additional-bond-detail', 'CommonController@getAdditionalBondDetail')->name('getAdditionalBondDetail');

Route::resource('proposals', ProposalController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('get-tender-data', 'ProposalController@getTenderData')->name('getTenderData');
Route::get('get-contractor-data', 'ProposalController@getContractorData')->name('getContractorData');
Route::post('proposal-case-create', 'ProposalController@proposalCaseCreate')->name('proposalCaseCreate');
Route::get('get-beneficiary-data', 'ProposalController@getBeneficiaryData')->name('getBeneficiaryData');
Route::get('get-proposal-project-details', 'ProposalController@getProjectDetails')->name('getProjectDetails');
Route::get('issue-bond-pdf/{id}','ProposalController@pdfExport')->name('issue-bond-pdf');
Route::get('get-proposal-agency-rating', 'ProposalController@getRatingDetails')->name('getProposalRatingDetails');
Route::get('get-proposal-rating-remarks', 'ProposalController@getRatingRemarks')->name('getProposalRatingRemarks');

Route::get('check-duplicate-pan-number/{id?}', 'CommonController@checkUniquePanNumber')->name('common.checkUniquePanNumber');
Route::delete('dms-remove-attachment', 'CommonController@removeDmsAttachment')->name('removeDmsAttachment');
Route::get('dMSDocument/{id?}', 'CommonController@dMSDocument')->name('dMSDocument');
Route::get('AutoFetchdMSDocument', 'CommonController@AutoFetchdMSDocument')->name('AutoFetchdMSDocument');

Route::get('check-duplicate-email/{id?}', 'CommonController@checkUniqueEmail')->name('common.checkUniqueEmail');

Route::resource('relevant_approval', RelevantApprovalController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::resource('facility_type', FacilityTypeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::resource('project_type', ProjectTypeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::resource('banking_limit_categories', BankingLimitCategoryController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::resource('type_of_entities', TypeOfEntityController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::resource('establishment_types', EstablishmentTypeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::resource('ministry_types', MinistryTypeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::resource('bond_policies_issue', BondPoliciesIssueController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('bond-policies-issue-checklist/{bond_id}', 'BondPoliciesIssueController@bondPoliciesIssueChecklist')->name('bondPoliciesIssueChecklist');
Route::post('store-bond-policies-checklist', 'BondPoliciesIssueController@bondPoliciesChecklistStore')->name('bondPoliciesChecklistStore');
Route::post('update-bond-number', 'BondPoliciesIssueController@updateBondNumber')->name('updateBondNumber');

Route::get('bond-fore-closure', 'BondForeClosureController@create')->name('createBondForeClosure');
Route::post('bond-fore-closure-store', 'BondForeClosureController@store')->name('bondForeClosureStore');
Route::get('bond-cancellation', 'BondCancellationController@create')->name('createBondCancellation');
Route::post('bond-cancellation-store', 'BondCancellationController@store')->name('bondCancellationStore');

Route::resource('bond-progress', BondProgressController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::get('check-duplicate-field/{id?}', 'CommonController@checkUniqueField')->name('common.checkUniqueField');
Route::get('check-duplicate-mobile/{id?}', 'CommonController@checkUniqueMobile')->name('common.checkUniqueMobile');

Route::resource('tender', TenderController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('get-project-details', 'TenderController@getProjectDetailsData')->name('getProjectDetailsData');
Route::get('tender-import', 'TenderController@import')->name('tender_import');
Route::post('tender-data-import', 'TenderController@TenderImportFiles')->name('tender_data_import');
Route::post('tender-import-error-export', 'TenderController@tenderImportErrorExport')->name('tenderImportErrorExport');

Route::resource('work-type', WorkTypeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('reason', ReasonController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('uw-view', UwViewController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('issuing-office-branch', IssuingOfficeBranchController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('issuing-office-branch-import', 'IssuingOfficeBranchController@import')->name('issuing_office_branch_import');
Route::post('issuing-office-branch-data-import', 'IssuingOfficeBranchController@IssuingOfficeBranchImportFiles')->name('issuing_office_branch_data_import');
Route::post('issuing-office-branch-import-error-export', 'IssuingOfficeBranchController@issuingOfficeBranchImportErrorExport')->name('issuingOfficeBranchImportErrorExport');
Route::resource('additional-bond', AdditionalBondController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('rejection-reason', RejectionReasonController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('adverse-information', AdverseInformationController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('adverse-info-inactive-reason', 'AdverseInformationController@adverseInfoInactiveReason')->name('adverseInfoInactiveReason');
Route::resource('blacklist', BlacklistController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('blacklist-inactive-reason', 'BlacklistController@blacklistInactiveReason')->name('blacklistInactiveReason');
Route::resource('agency', AgencyController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('agency-rating', AgencyRatingController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('letter-of-award', LetterOfAwardController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('type-of-foreclosure', TypeofForeClosureController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('rating', RatingController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

// Other Master
Route::resource('country', CountryController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('state', StateController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('location', LocationController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('location/changeLocation/{id}', 'LocationController@changeLocation')->name('location.changeLocation');
Route::resource('smtp-configuration', SmtpConfigurationController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::resource('mail-template', MailTemplateController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('hsn-code', HsnCodeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);


// Year Master
Route::resource('year', YearController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::match(['get', 'post'], 'years/changeYear/{id}','YearController@changeYear')->name('years.changeYear');
Route::post('/change-default/{id}', 'YearController@changeDefault')->name('common.change-default');

//invocation

Route::resource('invocation-reason', InvocationReasonController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

// ----------------------------- End Master ----------------------------------

//cases

Route::post('beneficiary-initiate-review',[BeneficiaryController::class,'initiateReview'])->name('beneficiary.initiateReview');
Route::get('beneficiary-import', 'BeneficiaryController@import')->name('beneficiary_import');
Route::post('beneficiary-data-import', 'BeneficiaryController@BeneficiaryImportFiles')->name('beneficiary_data_import');
Route::post('beneficiary-import-error-export', 'BeneficiaryController@beneficiaryImportErrorExport')->name('beneficiaryImportErrorExport');

Route::post('principle-initiate-review',[PrincipleController::class,'initiateReview'])->name('principle.initiateReview');

Route::get('adverse-information-description/{id}',[PrincipleController::class,'adverseInformationDescription'])->name('principle.adverseInformationDescription');
Route::get('get-agency-rating', 'PrincipleController@getRatingDetails')->name('getRatingDetails');
Route::get('get-rating-remarks', 'PrincipleController@getRatingRemarks')->name('getRatingRemarks');
Route::get('principle-import', 'PrincipleController@import')->name('principle_import');
Route::post('principle-data-import', 'PrincipleController@PrincipleImportFiles')->name('principle_data_import');
Route::post('principle-import-error-export', 'PrincipleController@principleImportErrorExport')->name('principleImportErrorExport');
Route::get('principle-dms-attachment-download/{id}',[PrincipleController::class,'principleDmsattachmentdownload'])->name('principleDmsattachmentdownload');
Route::get('principle-dms-attachment-comment/{id}',[PrincipleController::class,'principleDmsAttachmentComment'])->name('principleDmsAttachmentComment.get');
Route::post('principle-dms-attachment-comment',[PrincipleController::class,'principleDmsAttachmentStoreComment'])->name('principleDmsAttachmentStoreComment.post');
Route::get('principle-dms-attachment-comment-log/{id}',[PrincipleController::class,'principleDmsAttachmentCommentLog'])->name('principleDmsAttachmentCommentLog');
Route::put('principle-dms-update/{id}','PrincipleController@principleDmsUpdate')->name('principle-dms-update');

Route::get('cases',[CasesController::class,'index'])->name('cases.index');
Route::get('cases-dms-mail/{id}',[CasesController::class,'caseDmsMail'])->name('cases.caseDmsMail')->middleware('encryptUrl');
Route::post('cases-dms-mail-send',[CasesController::class,'sendcaseDmsMail'])->name('cases.sendcaseDmsMail');
Route::post('cases-cancel',[CasesController::class,'caseCancel'])->name('cases.caseCancel');
Route::post('cases-assign-underwriter',[CasesController::class,'caasesAssignUnderwriter'])->name('cases.assignUnderwriter');
Route::get('cases/{id}',[CasesController::class,'show'])->name('cases.show')->middleware('encryptUrl');
Route::post('add-dms-attachment',[CasesController::class,'dmsattachment'])->name('cases.dmsattachment');
Route::get('dms-attachment-download/{id}',[CasesController::class,'dmsattachmentdownload'])->name('cases.dmsattachmentdownload');
Route::get('dms-attachment-comment/{id}',[CasesController::class,'dmsAttachmentComment'])->name('cases.dmsAttachmentcomment.get');
Route::post('dms-attachment-comment',[CasesController::class,'dmsAttachmentStoreComment'])->name('cases.dmsAttachmentcomment.post');
Route::get('dms-attachment-comment-log/{id}',[CasesController::class,'dmsAttachmentCommentLog'])->name('cases.dmsAttachmentCommentLog');
Route::post('store-cases-action-plan/{id}', 'CasesController@storeCasesActionPlan')->name('store-cases-action-plan');
//for cases-action-plan store financial details
Route::post('store-cases-action-plan-financials/{id}', 'CasesController@storeCasesActionPlanFinancials')->name('store-cases-action-plan-financials');
Route::post('store-cases-parameter/{id}', 'CasesController@storeCasesParameter')->name('store-cases-parameter');
Route::resource('currency', CurrencyController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::post('save-anaysis','CasesController@saveAnaysis')->name('save-anaysis');
Route::get('action-plan-data', 'CasesController@actionPlanData')->name('action-plan-data');
Route::post('transfer-underwriter', 'CasesController@transferUnderwriter')->name('transfer-underwriter');
Route::put('dms-update/{id}','CasesController@dmsUpdate')->name('dms-update');
Route::resource('dms', DmsController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::post('proposals-status/{id}/{tender_evaluation_id?}', 'ProposalController@
change_status')->name('proposals-status');
Route::get('get-soure', 'CommonController@getSoure')->name('get-soure');
Route::post('tender-evaluation-store', 'CasesController@tenderEvaluationStore')->name('tender-evaluation-store');
Route::get('tender-evaluation/{proposal_id}', 'ProposalController@tenderEvaluation')->name('tender-evaluation');
Route::post('decision-store', 'CasesController@decisionStore')->name('decision-store');
Route::post('synopsis-store', 'CasesController@synopsisStore')->name('synopsis-store');
Route::post('project-details-store', 'CasesController@projectDetailsStore')->name('project-details-store');
Route::get('calculate-rating', 'CasesController@calculateRating')->name('calculateRating');
Route::get('proposal-rejection-reason/{proposal_id}/{key?}', 'ProposalController@proposalRejectionReason')->name('proposal-rejection-reason');
Route::get('get-rejection-reason-data', 'ProposalController@getRejectionReasonData')->name('getRejectionReasonData');
Route::get('fetch-rejection-reason', 'ProposalController@getTenderEvaluationRejectionData')->name('getTenderEvaluationRejectionData');
Route::post('send-intermediary-latter-for-sign', 'ProposalController@sendIntermediaryLatterForSign')->name('sendIntermediaryLatterForSign');

// Tenure
Route::resource('tenure', TenureController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('nbi', NbiController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::post('nbi-status-change','NbiController@nbiStatusChange')->name('nbi-status-change');
Route::get('nbi-export/{id}','NbiController@export')->name('nbi-export');
Route::get('nbi-pdf/{id}','NbiController@pdfExport')->name('nbi-pdf');
Route::post('terminate-proposal', 'NbiController@terminateProposal')->name('terminateProposal');

Route::resource('premium', PremiumController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('get-proposal-by-bond', 'PremiumController@getProposalbyBond')->name('getProposalbyBond');
Route::get('get-proposal-detail', 'PremiumController@getProposalId')->name('getProposalId');
Route::resource('invocation-notification', InvocationNotificationController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('bond-invocation-notification/{proposal_id}', 'InvocationNotificationController@create')->name('bondInvocationNotification');
Route::get('get-proposal-list', 'InvocationNotificationController@getProposalList')->name('getProposalList');
Route::post('invocation-payout/{id}', 'InvocationNotificationController@invocationPayout')->name('invocationPayout');
Route::post('invocation-claim-examiner/{id}', 'InvocationNotificationController@invocationClaimExaminer')->name('invocationClaimExaminer');
Route::post('invocation-action-plan/{id}', 'InvocationNotificationController@invocationActionplan')->name('invocationActionplan');
Route::post('invocation-notification-dms', 'InvocationNotificationController@dmsattachment')->name('invocationNotification.dmsattachment');
Route::get('dmsattachmentdownload/{id}', 'InvocationNotificationController@dmsattachmentdownload')->name('invocationNotification.dmsattachmentdownload');
Route::get('invocation-dms-attachment-comment/{id}','InvocationNotificationController@dmsAttachmentComment')->name('invocationNotification.dmsAttachmentcomment.get');
Route::post('invocation-dms-attachment-comment','InvocationNotificationController@dmsAttachmentStoreComment')->name('invocationNotification.dmsAttachmentcomment.post');
Route::get('invocation-dms-attachment-comment-log/{id}','InvocationNotificationController@dmsAttachmentCommentLog')->name('invocationNotification.dmsAttachmentCommentLog');
Route::put('invocation-update/{id}','InvocationNotificationController@dmsUpdate')->name('invocationNotification.dmsupdate');

Route::post('invocation-cancellelation/{id}', 'InvocationNotificationController@invocationCancellelation')->name('invocationCancellelation');

Route::resource('invocation-claims', InvocationClaimsController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::resource('recovery', RecoveryController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);
Route::get('get-recovery-data', [RecoveryController::class,'getRecovery'])->name('getRecovery');
Route::get('get-bond-data', 'InvocationNotificationController@getBondData')->name('getBondData');
Route::get('check-claim-examiner-approved-limit/{invocationData}', 'InvocationNotificationController@checkClaimExaminerApprovedLimit')->name('checkClaimExaminerApprovedLimit');

Route::resource('claim-examiner', ClaimExaminerController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy', 'edit']);

Route::get('/secure-file/{path}', [CommonController::class, 'secureFileShow'])->where('path', '.*')->name('secure-file')->middleware('encryptUrl');
Route::get('filter-letter-of-award-details', [CommonController::class, 'filterLetterOfAwardDetails'])->name('filterLetterOfAwardDetails')->middleware('encryptUrl');

Route::get('get-team-member', [CommonController::class, 'getTeamMemberByType'])->name('getTeamMemberByType');

Route::get('get-detail-by-team-member', [CommonController::class, 'getDetailByTeamMember'])->name('getDetailByTeamMember');

Route::get('run-script', [ScriptController::class, 'runScript'])->middleware('sentinel.auth');
Route::get('get-contractor-detail', 'PrincipleController@getContractorDetail')->name('getContractorDetail');
Route::post('ckeditor-upload', [CommonController::class,'ckeditorUpload']);
// Route::middleware(['encryptUrl'])->group(function () {
    
// });