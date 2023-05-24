<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use LengthException;

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
        Schema::defaultStringLength(191);
        view()->composer('*', function($view)
        {
            $setting = Cache::rememberForever('webSetting', function() {
                
                $checkcondition = DB::table('web_settings')->where('status', 'active')->get();
                $getSetting = DB::table('web_settings')->select('data')->where('status', 'active')->get()->toArray();
              
                if($checkcondition != NULL){
                    if($getSetting == ['contactInfo'])
                    {
                        $setting['contactInfo'] = json_decode($getSetting[0]->data);
                        return $setting;
                    }
                    if($getSetting == ['socialLinks'])
                    {
                        $setting['socialLinks'] = json_decode($getSetting[1]->data);
                        return $setting;
                    }
                    if($getSetting == ['logo'])
                    {
                        $setting['logo'] = json_decode($getSetting[2]->data);
                        return $setting;
                    }
                    if($getSetting == ['favicon'])
                    {
                        $setting['favicon'] = json_decode($getSetting[3]->data);
                        return $setting;
                    }
                }
            });
            $view->with('setting', $setting);
        });
    }
}
