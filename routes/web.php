<?php

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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

use App\Models\Device;
use App\Models\Hotspotconfig;
use App\Models\Clientportal;
use App\Models\Clientprofile;
use App\Models\Satellite;
use App\Models\Rate;

Route::get('/', 'CaptivePortalController@rootController');
Route::get('/check', 'CaptivePortalController@checkController');
Route::get('/session', 'CaptivePortalController@sessionController');
Route::get('/logoff', 'CaptivePortalController@logoffController');
Route::get('/status', 'CaptivePortalController@statusController');
Route::get('/login', 'CaptivePortalController@loginController');
Route::get('/failed', 'CaptivePortalController@failedController');
Route::get('/already', 'CaptivePortalController@alreadyController');

Route::get('/json', 'CaptivePortalJsonController@jsonRootController');
Route::get('/json/check', 'CaptivePortalJsonController@jsonCheckController');
Route::get('/json/session', 'CaptivePortalJsonController@jsonSessionController');
Route::get('/json/status', 'CaptivePortalController@jsonStatusController');
Route::get('/json/login', 'CaptivePortalJsonController@jsonLoginController');
Route::get('/json/failed', 'CaptivePortalJsonController@jsonFailedController');
Route::get('/json/already', 'CaptivePortalJsonController@jsonAlreadyController');

// below are debug routes
Route::get('/mysession', function(Request $request){
    $session = session('mysession', 'nosession');
    $uamsecret = "@secret!23";
    $agent = new Agent();
    $device = $agent->device();
    $platform = $agent->platform();
    $browser = $agent->browser();
    echo $device;
    echo $platform;
    echo $browser;
    dd($session);
});

Route::get('/removesession', function(){
    $session = session()->forget('mysession');
    session()->save();
    dd($session);
});


Route::get('/fetch',function(){
$chilli_query = "";
dd(exec($chilli_query));
});


Route::get('/pause', function () {
    $input = array(4, "4", "3", 4, 3, "3");
    $result = array_unique($input);
    if(sizeof($input) == sizeof($result)){
        echo "no duplicates";
    } else {
        echo "found duplicates";
    }    
    //return view('myhotspot.pause');
});



