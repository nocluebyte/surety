<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\
{
    CountryRating,
    SectorRating,
    UwViewRating,
    OtherContractorInformation,
};
use App\Http\Requests\RatingRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RatingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:rating.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:rating.edit', ['only' => ['edit', 'update']]);

        $this->common = new CommonController();
        $this->title = trans("rating.rating");
        view()->share('title', $this->title);
    }

    public function index()
    {
        $countryRating = CountryRating::get();
        $this->data['countryRating'] = $countryRating;
        $this->data['country_weightage'] = $countryRating->where('slug', 'country-weightage')->first();

        $sectorsRating = SectorRating::get();
        $this->data['sectorsRating'] = $sectorsRating;
        $this->data['sectors_weightage'] = $sectorsRating->where('slug', 'sectors-weightage')->first();

        $uwViewRating = UwViewRating::get();
        $this->data['uwViewRating'] = $uwViewRating;
        $this->data['uw_weightage'] = $uwViewRating->where('slug', 'uwview-weightage')->first();

        $this->data['oci_date_of_est'] = OtherContractorInformation::where('name','date_of_est')->get();
        $this->data['oci_employee'] = OtherContractorInformation::where('name', 'employee')->get();
        $this->data['oci_weightage'] = OtherContractorInformation::where('name', 'oci_weightage')->first();

        return view('rating.index', $this->data);
    }

    public function store(RatingRequest $request)
    {
        $input = $request->validated();

        if (isset($input['countryRatings']) && count($input['countryRatings'])  > 0) {
            DB::table('country_ratings')->truncate();
            foreach ($input['countryRatings'] as $row) {
                $countryArr =
                    [
                        'name' => $row['name'],
                        'slug' => Str::slug($row['name']),
                        'financial' => $row['financial'],
                        'non_financial' => $row['non_financial'] ?? '',

                    ];
                    CountryRating::create($countryArr);
            }
        }

        if (isset($input['sectorRatings']) && count($input['sectorRatings'])  > 0) {
            DB::table('sector_ratings')->truncate();
            foreach ($input['sectorRatings'] as $row) {
                $sectorsArr =
                    [
                        'name' => $row['name'],
                        'slug' => Str::slug($row['name']),
                        'financial' => $row['financial'],
                        'non_financial' => $row['non_financial'] ?? '',

                    ];
                    SectorRating::create($sectorsArr);
            }
        }

        if (isset($input['dateEst']) && count($input['dateEst'])  > 0) {
            DB::table('other_contractor_informations')->truncate();
            foreach ($input['dateEst'] as $row) {
                $dateEstArr =
                    [
                        'name' => 'date_of_est',
                        'slug' => 'date_of_est',
                        'from' => $row['from'] ?? '',
                        'to' => $row['to'] ?? '',
                        'financial' => $row['financial'] ?? '',
                        'non_financial' => $row['non_financial'] ?? '',
                    ];
                    OtherContractorInformation::create($dateEstArr);
            }

            foreach ($input['ociEmployeeDetail'] as $row) {
                $ociEmployeeDetail =
                [
                    'name' => 'employee',
                    'slug' => 'employee',
                    'from' => $row['from'],
                    'to' => $row['to'],
                    'financial' => $row['financial'],
                    'non_financial' => $row['non_financial'],
                ];
                OtherContractorInformation::create($ociEmployeeDetail);
            }
            OtherContractorInformation::create(['name'=>'oci_weightage','slug'=>'oci_weightage','financial'=>$input['oci_weightage']['financial'],'non_financial'=>$input['oci_weightage']['non_financial']]);
        }

        if (isset($input['uwViewDetail']) && count($input['uwViewDetail'])  > 0) {
            DB::table('uw_view_ratings')->truncate();
            foreach ($input['uwViewDetail'] as $row) {
                $uwViewArr =
                    [
                        'name' => $row['name'],
                        'slug' => Str::slug($row['name']),
                        'financial' => $row['financial'],
                        'non_financial' => $row['non_financial'] ?? '',

                    ];
                    UwViewRating::create($uwViewArr);
            }
        }

        return redirect()->route('rating.index')->with('success', __('common.update_success'));
    }
}
