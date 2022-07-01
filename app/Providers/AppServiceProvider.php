<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use App\Models\Clientportal;

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
        $this->overrideConfigValues();
        Schema::defaultStringLength(191);

        Blade::directive('footer', function ($expression) {
            $footer = Clientportal::select('footer')->where('status','assigned')->first();
            $response = "";
            if($footer){
                $response = $footer;
            } else {
                $response = "Myhotspot";
            }
            return $response;
        });
        Blade::directive('footer_url', function ($expression) {
            $footer_url = Clientportal::select('footer_url')->where('status','assigned')->first();
            $response = "";
            if($footer_url){
                $response = $footer_url;
            } else {
                $response = "#";
            }
            return $response;
        });
        Blade::directive('title', function ($expression) {
            $title = Clientportal::select('title')->where('status','assigned')->first();
            $response = "";
            if($title){
                $response = $title;
            } else {
                $response = "Myhotspot";
            }
            return $response;
        });
        Blade::directive('terms', function ($expression) {
            $terms = Clientportal::select('usage_terms')->where('status','assigned')->first();
            $response = "";
            if($terms){
                $response = $terms;
            } else {
                $response = "My Terms";
            }
            return $response;
        });
        Blade::directive('trial_text', function ($expression) {
            $trial = Clientportal::select('trial_btntext')->where('status','assigned')->first();
            $response = "";
            if($trial){
                $response = $trial;
            } else {
                $response = "Trial";
            }
            return $response;
        });
        /*
        Blade::directive('ip',function(){
            $session = session('mysession','nosession');
            return $session['ip'];
        }); 
        Blade::directive('mac',function(){
            $session = session('mysession','nosession');
            return $session['mac'];
        });
        Blade::directive('challenge',function(){
            $session = session('mysession','nosession');
            return $session['challenge'];
        });
        Blade::directive('linkorig',function(){
            $session = session('mysession','nosession');
            return $session['userurl'];
        }); 
        Blade::directive('sessionid',function(){
            $session = session('mysession','nosession');
            return $session['sessionid'];
        });
        Blade::directive('status',function(){
            $session = session('mysession','nosession');
            return $session['res'];
        }); 
        */                                                                  
    }

    protected function overrideConfigValues()
    {
        $config = [];
        if (config('settings.skin'))
            $config['backpack.base.skin'] = config('settings.skin');
        config($config);
    }    
}
