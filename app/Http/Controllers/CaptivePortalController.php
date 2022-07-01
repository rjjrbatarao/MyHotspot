<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

use App\Models\Device;
use App\Models\Hotspotconfig;
use App\Models\Clientportal;
use App\Models\Clientprofile;
use App\Models\Satellite;
use App\Models\Rate;

class CaptivePortalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rootController()
    {
        $url = url()->current();
        return Redirect::to($url.':3991/status');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkController(Request $request)
    {
        return Redirect::to($request->loginurl);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sessionController(Request $request)
    {
        $session = $request->all();
        if(isset($session['challenge'])){
            $uamsecret = "@secret!23";
            $hexchal = pack ("H32", $session['challenge']);
            $challenge = md5($hexchal . $uamsecret);
            $session['challenge'] = $challenge; //set new challenge for chap login
        }
        $request->session()->put('mysession',  $session);
        switch($session['res']) {
            case 'success':     return Redirect::to('/status'); break; // If login successful
            case 'failed':      return Redirect::to('/login'); break; // If login failed
            case 'logoff':      return Redirect::to('/logoff'); break; // If logout successful
            case 'already':     return Redirect::to('/already'); break; // If tried to login while already logged in
            case 'notyet':      return Redirect::to('/login'); break; // If not logged in yet
            case 'smartclient': dd('smartclient'); break; // If login from smart client
            case 'popup1':      dd('popup1'); break; // If requested a logging in pop up window
            case 'popup2':      dd('popup2'); break; // If requested a success pop up window
            case 'popup3':      dd('popup3'); break; // If requested a logout pop up window
            default: return Redirect::to('/'); // Default: It was not a form request
        }
    }


    protected function clearSession(){
        $session = session()->forget('mysession');
        session()->save();        
    }

    public function loginController(Request $request)
    {
        $session = session()->get('mysession', 'nosession');
        if($session != 'nosession'){
            $portalvariables = $this->getPortalVariables();
            if(isset($portalvariables)){
                $this->clearSession();            
                if($session['res'] == 'failed' || $session['res'] == 'notyet'){
                    return view('myhotspot.login', array_merge($session,$portalvariables));
                } else {
                    return Redirect::to('/');
                }
            } else {
                return view('myhotspot.nohotspot');
            }
        } else {
            return Redirect::to('/');// get session
        }
    }

    public function statusController(Request $request)
    {
        $session = session()->get('mysession', 'nosession');
        if($session != 'nosession'){
            $portalvariables = $this->getPortalVariables();
            $this->clearSession();
            if($session['res'] == 'success' || $session['res'] == 'already'){
                return view('myhotspot.status', array_merge($session,$portalvariables));
            } else {
                return Redirect::to('/');
            }
        } else {
            return Redirect::to('/');// get session
        }        
    }
    public function logoffController()
    {   
        return Redirect::to('/login');
    }
    public function alreadyController(Request $request)
    {
    return Redirect::to('/status');
    }
    public function failedController()
    {
        $session = session('mysession', 'nosession');
        return view('myhotspot.failed',$session);
    }

    protected function getPortalVariables(){
        $server_host = request()->getHost();
        $hdata = Hotspotconfig::select([
            'clientportal_id',
            'hs_uamport',
            'hs_uamlisten'
        ])->where('type',false)->where('hs_uamlisten',$server_host)->get()->toArray();        
        $clientportal_id = $hdata[0]['clientportal_id'];
        $hotspot_uamport = $hdata[0]['hs_uamport'];
        $hotspot_uamip = $hdata[0]['hs_uamlisten'];

        $clientportal_buttons = Clientportal::where('id',$clientportal_id)->pluck('btn_satellite')->first();

      
        $satellite_btn_colors = array();
        $satellite_apis = array();
        $satellite_buttons = array();
        $satellite_ips = array();
        $satellite_defaultpackages = array();
        $satellite_defaultservices = array();
        $satellite_generateenables = array();
        $satellite_redirects = array();
        $satellite_timeenables = array();
        $satellite_dataenables = array();
        $satellite_chargeenables = array();
        $satellite_states = array();

        if(isset($clientportal_buttons)){
            foreach($clientportal_buttons as $key => $value){
                $sdata = Satellite::select([
                    'btncolor',
                    'btntext',
                    'token',
                    'ip',
                    'mode',
                    'service_default',
                    'package_default',
                    'enable_generate',
                    'redirect_after',
                    'enable_time',
                    'enable_data',
                    'enable_charging',
                    'status'
                    ])->where('id',$value)->get()->toArray();
                if($sdata[0]['mode'] == 'main'){
                    $sdata[0]['ip'] = $server_host;
                }
                array_push($satellite_buttons,$sdata[0]['btntext']);
                array_push($satellite_apis,$sdata[0]['token']);
                array_push($satellite_btn_colors,$sdata[0]['btncolor']);
                array_push($satellite_ips,$sdata[0]['ip']);
                array_push($satellite_defaultservices,$sdata[0]['service_default']);
                array_push($satellite_defaultpackages,$sdata[0]['package_default']);
                array_push($satellite_generateenables,$sdata[0]['enable_generate']);
                array_push($satellite_redirects,$sdata[0]['redirect_after']);
                array_push($satellite_timeenables,$sdata[0]['enable_time']);
                array_push($satellite_dataenables,$sdata[0]['enable_data']);
                array_push($satellite_chargeenables,$sdata[0]['enable_charging']);
                array_push($satellite_states,$sdata[0]['status']);
            }
        }

        if(isset($clientportal_id)){
            $cdata = Clientportal::select([
                'enable_bgimage',
                'bgimage',
                'bgcolor',
                'title',
                'footer',
                'footer_url',
                'enable_trial',
                'trial_btntext',
                'enable_terms',
                'usage_terms',
                'enable_membership',
                'enable_chat',
                'enable_eloading',
                'eload_btntext',
                'enable_presound',
                'presound_dir',
                'enable_actvsound',
                'actvsound_dir',
                'enable_postsound',
                'postsound_dir',
                'enable_banner',
                'banners',
                'banner_interval',
                ])->where('id',$clientportal_id)->get()->toArray();
            
            $clientportal_bgenable = $cdata[0]['enable_bgimage'];
            $clientportal_bgimage = $cdata[0]['bgimage'];
            $clientportal_bgcolor = $cdata[0]['bgcolor'];
            $clientportal_title = $cdata[0]['title'];
            $clientportal_footer = $cdata[0]['footer'];
            $clientportal_footerurl = $cdata[0]['footer_url'];
            $clientportal_trialenable = $cdata[0]['enable_trial'];
            $clientportal_trialtext = $cdata[0]['trial_btntext'];
            $clientportal_termsenable = $cdata[0]['enable_terms'];
            $clientportal_termstext = $cdata[0]['usage_terms'];
            $clientportal_membershipenable = $cdata[0]['enable_membership'];
            $clientportal_chatenable = $cdata[0]['enable_chat'];
            $clientportal_eloadenable = $cdata[0]['enable_eloading'];
            $clientportal_eloadtext = $cdata[0]['eload_btntext'];
            $clientportal_presoundenable = $cdata[0]['enable_presound'];
            $clientportal_presounddir = $cdata[0]['presound_dir'];
            $clientportal_actvsoundenable = $cdata[0]['enable_actvsound'];
            $clientportal_actsounddir = $cdata[0]['actvsound_dir'];
            $clientportal_postsoundenable = $cdata[0]['enable_postsound'];
            $clientportal_postsounddir = $cdata[0]['postsound_dir'];
            $clientportal_banner = json_decode($cdata[0]['banners']);
            $clientportal_bannerinterval = $cdata[0]['banner_interval'];
            $clientportal_bannerenable = $cdata[0]['enable_banner'];


            $data = [
                'mytitle' => $clientportal_title,
                'myfooter' => $clientportal_footer,
                'myfooterurl' => $clientportal_footerurl,
                'mybuttons' => $satellite_buttons,
                'mybuttoncolors' => $satellite_btn_colors,
                'myips' => $satellite_ips,
                'mystates' => $satellite_states,
                'mytrialenable' => $clientportal_trialenable,
                'mytrialtext' => $clientportal_trialtext,    
                'mytermsenable' => $clientportal_termsenable,
                'mytermstext' => $clientportal_termstext,   
                'mymembershipenable' => $clientportal_membershipenable,
                'mydatarates' => [],
                'mytimerates' => [],
                'mychargerates' => [],
                'mydefaultpackages' => $satellite_defaultpackages,
                'mydefaultservices' => $satellite_defaultservices,
                'mygenerateenables' => $satellite_generateenables,
                'myredirects' => $satellite_redirects,
                'mytimeenables' => $satellite_timeenables,
                'mydataenables' => $satellite_dataenables,
                'mychargeenables' => $satellite_chargeenables,
                'mybannerenable' => $clientportal_bannerenable,
                'mybanners' => $clientportal_banner,
                'mybannerinterval' => $clientportal_bannerinterval,
                'mypresoundenable' => $clientportal_presoundenable,
                'mypresounddir' => $clientportal_presounddir,
                'myactvsoundenable' => $clientportal_actvsoundenable,
                'myactvsounddir' => $clientportal_actsounddir,
                'mypostsoundenable' => $clientportal_postsoundenable,
                'mypostsounddir' => $clientportal_postsounddir,
                'mychatenable' => $clientportal_chatenable,
                'myeloadingenable' => $clientportal_eloadenable,
                'myeloadtext' => $clientportal_eloadtext,
                'mybackgroundimage' => "/".$clientportal_bgimage,
                'mybackgroundenable' => $clientportal_bgenable,
                'mybackgroundcolor' => $clientportal_bgcolor,
                'myuamport' => $hotspot_uamport,
                'myuamip' => $hotspot_uamip
            ];
    
            return $data;
        }
        
    }
}
