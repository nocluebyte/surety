<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{Setting,Year,Location};
use View;
use Session;
use Illuminate\Support\Facades\Schema;
use Cache;
use Config;
use Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('settings')) {
            $setting = Setting::first();
            $setting_project_title = Setting::where('name', 'project_title')->first();
            $project_title = $setting_project_title->value ?? '';
            $setting_tag_line = Setting::where('name', 'tag_line')->first();
            $tag_line = $setting_tag_line->value ?? '';
            $setting_logo = Setting::where('name', 'logo')->first();
            $logo = $setting_logo->value ?? '';
            $print_logo = $setting?->firstWhere('name','print_logo')->value ?? '';
            $setting_favicon = Setting::where('name', 'favicon')->first();
            $favicon = $setting_favicon->value ?? '';
            $initial_fd_validity = Setting::where('name', 'initial_fd_validity')->pluck('value')->first() ?? 1;
            $setting_copyright_name = Setting::where('name', 'copyright_name')->first();
            $copyright_name = $setting_copyright_name->value ?? '';
            $proposal_auto_save = Setting::where('name', 'proposal_auto_save_duration')->pluck('value')->first();
            $is_proposal_auto_save = Setting::where('name', 'is_proposal_auto_save')->pluck('value')->first();
            view()->share('proposal_auto_save_duration', $proposal_auto_save);
            view()->share('is_proposal_auto_save', $is_proposal_auto_save);
            view()->share('initial_fd_validity', $initial_fd_validity);
            view()->share('setting', $setting);
            view()->share('project_title', $project_title);
            view()->share('tag_line', $tag_line);
            view()->share('logo', $logo);
            view()->share('favicon', $favicon);
            view()->share('print_logo', $print_logo);
            view()->share('copyright_name',$copyright_name);
            /*$cached_settings = Cache::remember('settings', 3600, function () {
                return Setting::pluck('value', 'name')->toArray();
            });*/
            $cached_settings=Setting::pluck('value', 'name')->toArray();
            Config::set('srtpl.settings', $cached_settings);

            $settingTag = Setting::where('name','tag_line')->first();
            view()->share('settingTag', $settingTag);

            $session_timeout = Setting::where('name','session_expire_time')->first()->value ?? 120;
            \Config::set('session.lifetime',$session_timeout);
        }

        if (Schema::hasTable('years')) {
            $year = Year::get();
            view()->share('header_year', $year);
        }
           
        if (Schema::hasTable('locations')) {
            $location = Location::where('is_active','Yes')->get();
            view()->share('header_location', $location);
        }
    }
}
