<?php
define('AES_256_CBC', 'aes-256-cbc');
use App\User;
use Illuminate\Http\Request;
use App\Models\Satellite;
use App\Models\Clientprofile;
use App\Models\Chargeprofile;
use App\Models\Rate;

Route::middleware('auth:api')->get('/node/set/user', function (Request $request) {
$secret = Satellite::where('token',$request->api_token)->pluck('key')->first();
$md5_key = md5($secret);      
$parts = explode(":",$request->data);
$hmac_signature = hash_hmac('sha256',$parts[2],$md5_key);
if($hmac_signature == $parts[1]){
    $decrypted = openssl_decrypt($parts[2], AES_256_CBC, $md5_key, 0, $parts[0]);
    return [
        'success' => true,
        'token' => $request->api_token,
        'data' => $request->data,
        'decrypted' => json_decode($decrypted,true)
        ];    
} else {
    abort(404);
}
});

// this should be placed in scheduler with ping
Route::middleware('auth:api')->get('/node/set/status', function (Request $request) {
// set satellite link up here
    return [
        'success' => true
    ];
});

Route::middleware('auth:api')->get('/node/get/info', function (Request $request) {
$secret = Satellite::where('token',$request->api_token)->pluck('key')->first();
$md5_key = md5($secret);
$parts = explode(":",$request->data);
$hmac_signature = hash_hmac('sha256',$parts[2],$md5_key);

if($hmac_signature == $parts[1]){ 
    $sdata = Satellite::select([
        'enable_time',
        'enable_data',
        'enable_charging',
        'timeprofile_id',
        'dataprofile_id',
        'chargeprofile_id',
        'progress_time'
    ])->where('token',$request->api_token)->get()->toArray();
    $satellite_timeenables = $sdata[0]['enable_time'];
    $satellite_dataenables = $sdata[0]['enable_data'];
    $satellite_chargeenables = $sdata[0]['enable_charging'];
    $satellite_timeprofileid = $sdata[0]['timeprofile_id'];
    $satellite_dataprofileid = $sdata[0]['dataprofile_id'];
    $satellite_chargeprofilid = $sdata[0]['chargeprofile_id'];
    $satellite_progresstime = $sdata[0]['progress_time'];
    $rate_timeid = Clientprofile::where('id',$satellite_timeprofileid)->pluck('rate_id')->first();
    $rate_dataid = Clientprofile::where('id',$satellite_dataprofileid)->pluck('rate_id')->first();
    $rate_chargeid = Chargeprofile::where('id',$satellite_chargeprofilid)->pluck('rate_id')->first();
    
    $timerates = Rate::where('id',$rate_timeid)->pluck('pricing')->first();
    $datarates = Rate::where('id',$rate_dataid)->pluck('pricing')->first();
    $chargerates = Rate::where('id',$rate_chargeid)->pluck('pricing')->first();
    
    $data = [
        'mytimerates' => json_decode($timerates, true),
        'mydatarates' => json_decode($datarates, true),
        'mychargerates' => json_decode($chargerates, true),
        'mytimeenable' => $satellite_timeenables,
        'mydateenable' => $satellite_dataenables,
        'mychargeenable' => $satellite_chargeenables, 
        'myprogresstime' => $satellite_progresstime         
    ];
        return [
            'success' => true,
            'data' => $data
            ];
} else {
    abort(404);// abort hackers
}
});