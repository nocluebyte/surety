<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\SettingRequest;
use App\Models\Country;
use App\Models\State;
use Nsure\Helper\Facades\AppHelper;
use Illuminate\Support\Facades\File;
use Sentinel;
use DB;

class SettingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->common = new CommonController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::get();
        $user = Sentinel::getUser();
        foreach ($settings as $key => $setting) {
            if($setting->name == "allow_ip_for_tv_display") {
                $setting->value = json_decode($setting->value);
            }
            $settingsArray[$setting->name] = $setting->value;

        }
        $country = $settings->where('name', 'country')->first();
        $country_id = $country ? $country->value : 0;
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states']    =  $this->common->getStates($country_id);
        $this->data['msme_types'] = Config('srtpl.msme_types');
        $this->data['settings']  = $settingsArray ?? '';
        $this->data['user']  = $user;
        return view('settings.setting', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {
        $input = $request->except('_token','prints', 'is_proposal_auto_save');
        $prints = $request->prints ?? [];
        if (count($input) > 0) {
             foreach ($input as $field => $value) {
                if(is_array($value)) {
                    $value = json_encode($value);
                }
                if ($field == 'country_id') {
                    $field = 'country';
                }
                if ($field == 'state_id') {
                    $field = 'state';
                }
                $data = [
                    'name' => $field,
                    'title' => ucwords(str_replace("_", " ", $field)),
                    'value' => $value
                ];
                Setting::updateOrCreate(['name' => $field], $data);

                if($field == 'logo'){
                    $this->uploadLogoImage($request);
                }

                if ($field == 'favicon') {
                    $this->uploadFaviconImage($request);
                }
                if($field == 'print_logo'){
                    $this->uploadPrintLogoImage($request);
                }
            }
        }
        if (count($prints) > 0) {
            $print_field = 'print_description';
            $print_data = [
                'name' => $print_field,
                'title' => ucwords(str_replace("_", " ", $print_field)),
                'value' => json_encode($prints)
            ];
            Setting::updateOrCreate(['name' => $print_field], $print_data);
        }

        $isProposalAutoSave = [
            'name' => 'is_proposal_auto_save',
            'title' => ucwords(str_replace("_", " ", 'is_proposal_auto_save')),
            'value' => isset($request->is_proposal_auto_save) ? 'Yes' : 'No',
        ];
        Setting::updateOrCreate(['name' => 'is_proposal_auto_save'], $isProposalAutoSave);

        return back()->with('success', __('settings.update_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Setting::find($id);
        $this->data['setting'] = $setting;

        return response()->json(['html' => view('settings.form', $this->data)->render()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploadLogoImage($request)
    {
        if ($request->hasFile('logo')) {
            $store_path = 'uploads/Setting/Logo/';
            $logo_name = AppHelper::getUniqueFilename($request->file('logo'), AppHelper::getImagePath($store_path));
            $request->file('logo')->move(AppHelper::getImagePath($store_path), $logo_name);
            $settings['value'] = $store_path.$logo_name;

            Setting::where('name', 'logo')->update($settings);      
        }
    }

    public function uploadFaviconImage($request)
    {
        if ($request->hasFile('favicon')) {
            $store_path = 'uploads/Setting/Favicon/';
            $favicon_name = AppHelper::getUniqueFilename($request->file('favicon'), AppHelper::getImagePath($store_path));
            $request->file('favicon')->move(AppHelper::getImagePath($store_path), $favicon_name);
            $settings['value'] = $store_path.$favicon_name;

            Setting::where('name', 'favicon')->update($settings);      
        }
    }

    public function sessionDelete($type)
    {

        DB::table('sessions')->delete();
        // DB::table('sessions')->where('platform',$type)->delete();

        return response()->json([
                'success' => true,
                'message' => __('common.delete_success'),
            ], 200);

    }
    public function uploadPrintLogoImage($request)
    {
        if ($request->hasFile('print_logo')) {
            $store_path = '/uploads/Setting/Print_logo/';
            $logo_name = AppHelper::getUniqueFilename($request->file('print_logo'), AppHelper::getImagePath($store_path));
            $request->file('print_logo')->move(AppHelper::getImagePath($store_path), $logo_name);
            $upload_path = 'uploads/Setting/Print_logo/';
            $settings['value'] = $upload_path.$logo_name;
            Setting::where('name', 'print_logo')->update($settings);
        }
    }
}
