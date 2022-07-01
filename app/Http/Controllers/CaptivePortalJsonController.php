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

// use League\Fractal\Manager;
// use League\Fractal\Resource\Collection;

class CaptivePortalJsonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jsonRootController()
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
    public function jsonCheckController(Request $request)
    {
        return Redirect::to($request->loginurl);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function jsonSessionController(Request $request)
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
            case 'success':     return Redirect::to('/login'); break; // If login successful
            case 'failed':      return Redirect::to('/login'); break; // If login failed
            case 'logoff':      return Redirect::to('/login'); break; // If logout successful
            case 'already':     return Redirect::to('/already'); break; // If tried to login while already logged in
            case 'notyet':      return Redirect::to('/login'); break; // If not logged in yet
            case 'smartclient': dd('smartclient'); break; // If login from smart client
            case 'popup1':      dd('popup1'); break; // If requested a logging in pop up window
            case 'popup2':      dd('popup2'); break; // If requested a success pop up window
            case 'popup3':      dd('popup3'); break; // If requested a logout pop up window
            default: return Redirect::to('/'); // Default: It was not a form request
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function jsonLoginController(Request $request)
    {
        $session = session()->get('mysession', 'nosession');
        //if($session != 'nosession'){
            $portalvariables = $this->getPortalVariables();
            return $portalvariables;// force same login page after login
            // value passed as array
        // } else {
        //     return Redirect::to('/');// get session
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function jsonLogoffController()
    {
        $session = session('mysession', 'nosession');
        return view('myhotspot.logoff', $session);
    }
    public function alreadyController()
    {
    //function add time here
    return Redirect::to('/login');
    }
    public function jsonFailedController()
    {
        $session = session('mysession', 'nosession');
        return view('myhotspot.failed',$session);
    }

    protected function getPortalVariables(){
        $clientportal_id = Hotspotconfig::where('type',false)->pluck('clientportal_id')->first();

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

        foreach($clientportal_buttons as $key => $value){
            $sdata = Satellite::select([
                'btncolor',
                'btntext',
                'token',
                'ip',
                'service_default',
                'package_default',
                'enable_generate',
                'redirect_after',
                'enable_time',
                'enable_data',
                'enable_charging',
                'status'
                ])->where('id',$value)->get()->toArray();
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
        $clientportal_banner = $cdata[0]['banners'];
        $clientportal_bannerinterval = $cdata[0]['banner_interval'];
        $clientportal_bannerenable = $cdata[0]['enable_banner'];
        $data = [
            'mytitle' => $clientportal_title,
            'myfooter' => $clientportal_footer,
            'myfooterurl' => $clientportal_footerurl,
            'mybuttons' => $satellite_buttons,
            'mybuttoncolors' => $satellite_btn_colors,
            //'myapis' => $satellite_apis,
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
            'mydefaultpackages' => $satellite_defaultservices,
            'mydefaultservices' => $satellite_defaultpackages,
            'mygenerateenables' => $satellite_generateenables,
            'myredirects' => $satellite_redirects,
            'mytimeenables' => $satellite_timeenables,
            'mydataenables' => $satellite_dataenables,
            'mychargeenables' => $satellite_chargeenables,
            'mybannerenable' => $clientportal_bannerenable,
            'mybanners' => json_decode($clientportal_banner),
            'mybannerinterval' => $clientportal_bannerinterval,
            'mypresoundenable' => $clientportal_presoundenable,
            'mypresounddir' => $clientportal_presounddir,
            'myactvsoundenable' => $clientportal_actvsoundenable,
            'myactvsounddir' => $clientportal_actsounddir,
            'mypostsoundenable' => $clientportal_postsoundenable,
            'mypostsounddir' => $clientportal_postsounddir,
            'enable_chat' => $clientportal_chatenable,
            'enable_eloading' => $clientportal_eloadenable,
            'eload_btntext' => $clientportal_eloadtext,
            'mybackgroundimage' => "/".$clientportal_bgimage,
            'mybackgroundenable' => $clientportal_bgenable,
            'mybackgroundcolor' => $clientportal_bgcolor,
        ];

        return $data;
    }
}
