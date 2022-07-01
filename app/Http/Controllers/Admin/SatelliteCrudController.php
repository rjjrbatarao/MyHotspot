<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SatelliteRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Api_token;
use App\Models\Satellite;
use Carbon\Carbon;
use App\User;
/**
 * Class SatelliteCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SatelliteCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    
    
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Satellite::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/satellite');
        CRUD::setEntityNameStrings('satellite', 'satellites');
    }


    public function fetchPinprofile(){
        return $this->fetch('App\Models\Pinprofile');
    }

    // public function fetchTimeprofile(){
    //     return $this->fetch('App\Models\Clientprofile');
    // }

    // public function fetchDataprofile(){
    //     return $this->fetch('App\Models\Clientprofile','dataprofile');
    // }

    public function fetchChargeprofile(){
        return $this->fetch('App\Models\Chargeprofile');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns
        CRUD::addButtonFromView('line', 'lineRestart', 'line_restart', 'beginning');
        CRUD::enableBulkActions();
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name'
        ]);
       
        CRUD::addColumn([
            'name' => 'mode',
            'type' => 'text',
            'label' => 'Mode',
            'wrapper' => [
                'element' => 'span',
                'class' => function($crud, $column, $entry, $related_key){
                    if($column['text'] == 'main'){
                        return 'badge badge-success';
                    } else {
                        return 'badge badge-info';
                    }
                }
            ]            
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'type' => 'text',
            'label' => 'Link',
            'wrapper' => [
                'element' => 'span',
                'class' => function($crud, $column, $entry, $related_key){
                    if($column['text'] == 'up'){
                        return 'badge badge-success';
                    } else {
                        return 'badge badge-danger';
                    }
                }
            ]
        ]);                

        CRUD::addColumn([
            'name' => 'status_main',
            'type' => 'text',
            'label' => 'Status',
            'wrapper' => [
                'element' => 'span',
                'class' => function($crud, $column, $entry, $related_key){
                    if($column['text'] == 'assigned'){
                        return 'badge badge-success';
                    } else {
                        return 'badge badge-error';
                    }
                }
            ]            
        ]);          
          
        CRUD::addColumn([
            'name' => 'btntext',
            'type' => 'text',
            'label' => 'Button Name'
        ]);

        CRUD::addColumn([
            'name' => 'btncolor',
            'type' => 'text',
            'label' => 'Button Color',
            'wrapper' => [
                'element' => 'span',
                'class' => 'badge badge-success',
                'style' => function($crud, $column, $entry, $related_key){
                    return 'background-color:'.$column['text'];
                }
            ]
        ]);

        CRUD::addColumn([
            'name' => 'timeprofile_id',
            'type' => 'select',
            'label' => "Time Profile",
            'entity' => 'timeprofile',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('clientprofile/'.$related_key.'/show');
                },
            ],                                  
           ]); 
        CRUD::addColumn([
            'name' => 'dataprofile_id',
            'type' => 'select',
            'label' => "Data Profile",
            'entity' => 'dataprofile',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('clientprofile/'.$related_key.'/show');
                },
            ],                                  
           ]); 
        CRUD::addColumn([
            'name' => 'chargeprofile_id',
            'type' => 'select',
            'label' => "Charge Profile",
            'entity' => 'chargeprofile',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('chargeprofile/'.$related_key.'/show');
                },
            ],                                  
           ]); 
        CRUD::addColumn([
            'name' => 'pinprofile_id',
            'type' => 'select',
            'label' => "Gpio Profile",
            'entity' => 'pinprofile',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('pinprofile/'.$related_key.'/show');
                },
            ],                                  
           ]);                                            
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {

        CRUD::setValidation(SatelliteRequest::class);
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
        ]);  
        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => '<span style="color:red">* </span> Name',
            'hint' => 'Any name for your sattelite vendo.',
            'tab' => 'Main',
            'attributes' => [
                'Placeholder' => 'Satellite Name',
                'required' => true,
            ]              
        ]);
       
        CRUD::addField([
            'name' => 'mode',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span> Mode',
            'hint' => 'Set satellite device.',
            'options' => ['main' => 'main', 'remote' => 'remote'],
            'allows_null' => false,
            'default' => 'remote',
            'tab' => 'Main' 
        ]);   
        /*      
        CRUD::addField([
            'name' => 'status',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span> Status',
            'hint' => 'Satellite vendo status.',
            'options' => [
                'down' => 'down',
                'active' => 'active',
                'idle' => 'idle',
                'charging' => 'charging',
            ],
            'allows_null' => false,
            'default' => 'high',              
            'tab' => 'Main',
            'attributes' => [
                'Placeholder' => 'Satellite Status',
                'required' => true,
            ]              
        ]); 
        */
        CRUD::addField([
            'name' => 'btntext',
            'type' => 'text',
            'label' => '<span style="color:red">* </span> Button Text',
            'hint' => 'Button text shown in portal.',
            'tab' => 'Main',
            'attributes' => [
                'Placeholder' => 'Buttob Name',
                'required' => true,
            ],
            'default' => 'Autologin'          
        ]);

        CRUD::addField([
            'name' => 'btncolor',
            'type' => 'color_picker',
            'label' => '<span style="color:red">* </span> Button Color',
            'default' => '#009688',
            'tab' => 'Main',
            'color_picker_options' => [
                'customClass' => 'custom-class',
                'horizontal' => true,
                'extensions' => [
                    [
                        'name' => 'swatches', // extension name to load
                        'options' => [ // extension options
                            'colors' => [
                                'primary' => '#337ab7',
                                'success' => '#5cb85c',
                                'info' => '#5bc0de',
                                'warning' => '#f0ad4e',
                                'danger' => '#d9534f'
                            ],
                            'namesAsValues' => false
                        ]
                    ]
                ]
            ]            
        ]); 
        CRUD::addField([
            'name' => 'progress_time',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Progress Timeout',
            'hint' => 'Time in portal popup',
            'default' => 60,
            'attributes' => [
                'required' => true,
                'min' => 10,
                'max' => 9999999
            ],
            'tab' => 'Main',
        ]);
        /*
        CRUD::addField([
            'name' => 'case',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span> Voucher Case',
            'hint' => 'Voucher generated in uppercase, lowercase, or disabled.',
            'options' => [
                'disabled' => 'disabled',
                'uppercase' => 'uppercase',
                'lowercase' => 'lowercase',
            ],
            'allows_null' => false,
            'default' => 'disabled',             
            'tab' => 'Main',
            'attributes' => [
                'Placeholder' => 'Voucher Code Case',
                'required' => true,
            ]            
        ]); */
        CRUD::addField([
            'name' => 'enable_time',
            'type' => 'toggle',
            'label' => 'Enable Time',
            'inline' => true,
            'hint' => 'Enable disable time package in portal.',
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['timeprofile_id'],
                ],
            'default' => 1,
            'tab' => 'Profile',           
        ]);         
        CRUD::addField([
            'name' => 'timeprofile_id',
            'type' => 'relationship',
            'label' => '<span style="color:red">* </span> Hotspot Time Profile',
            'entity' => 'timeprofile',
            'attribute' => 'name',
            'tab' => 'Profile',
            'hint' => 'Hotspot Profile used when satellite is in use.'  ,
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('type', 'time')->get();
            }),
            
            ]);
        
        CRUD::addField([
            'name' => 'enable_data',
            'type' => 'toggle',
            'label' => 'Enable Data',
            'inline' => true,
            'hint' => 'Enable disable data package in portal.',
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['dataprofile_id'],
                ],
            'default' => 1,
            'tab' => 'Profile',           
        ]);         
        CRUD::addField([
            'name' => 'dataprofile_id',
            'type' => 'relationship',
            'label' => '<span style="color:red">* </span> Hotspot Data Profile',
            'entity' => 'dataprofile',
            'attribute' => 'name',
            'tab' => 'Profile',
            'hint' => 'Hotspot Profile used when satellite is in use.'  ,
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('type', 'data')->get();
            }),  
                               
        ]);         

        CRUD::addField([
            'name' => 'enable_charging',
            'type' => 'toggle',
            'label' => 'Enable Charging',
            'inline' => true,
            'hint' => 'Enable disable charge package in portal.',
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['chargeprofile_id'],
                ],
            'default' => 0,
            'tab' => 'Profile',           
        ]);        
        CRUD::addField([
            'name' => 'chargeprofile_id',
            'type' => 'relationship',
            'label' => '<span style="color:red">* </span> Charge Profile',
            'entity' => 'chargeprofile',
            'attribute' => 'name',
            'tab' => 'Profile',
            'hint' => 'Charging Profile used when satellite is in use.',
            'allows_null' => false,
            'inline_create' => true,
            'ajax' => true, 
            'wrapperAttributes'    => ['class' => 'form-group col-md-12'],             
        ]);  
        /*
        CRUD::addField([
            'label' => '<span style="color:red">* </span> Gpio Profile',
            'name' => 'pinprofile_id',
            'type' => 'select',
            'allows_null' => false,
            'tab' => 'Profile',
        ]);
        */

        
        CRUD::addField([
            'name' => 'pinprofile_id',
            'type' => 'relationship',
            'label' => '<span style="color:red">* </span> Gpio Profile',
            'entity' => 'pinprofile',
            'attribute' => 'name',
            'tab' => 'Profile',
            'hint' => 'Pins used by satellite',
            'allows_null' => false,
            'inline_create' => true,
            'ajax' => true, 
            'wrapperAttributes'    => ['class' => 'form-group col-md-12'],           
            'attributes' => [
                'required' => true
            ]
            ]); 
        
        CRUD::addField([
            'name' => 'enable_generate',
            'type' => 'toggle',
            'label' => 'Enable Generate Voucher',
            'tab' => 'Profile',
            'inline' => true,
            'hint' => 'Enable disable generate switch in portal. If disabled the default will be autologin.',
            'default' => 1,
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['service_default'],
                ],
            'default' => 0            
        ]);         
        CRUD::addField([
            'name' => 'service_default',
            'type' => 'radio',
            'label' => 'Default Service',
            'tab' => 'Profile',
            'inline' => true,
            'hint' => 'Select default service in portal.',
            'default' => 1,
            'options' => [
                0 => 'Generate',
                1 => 'Autologin'
            ]
        ]); 
        CRUD::addField([
            'name' => 'package_default',
            'type' => 'radio',
            'label' => 'Default Package',
            'tab' => 'Profile',
            'inline' => true,
            'hint' => 'Select default package in portal.',
            'default' => 0,
            'options' => [
                0 => 'Time',
                1 => 'Data',
                2 => 'Charge'
            ]
        ]); 



        
        CRUD::addField([
            'name' => 'firmware',
            'type' => 'text',
            'label' => 'Firmware (Optional)',
            'hint' => 'Firmware version of device.',
            'tab' => 'Info (optional)',
            'default' => 'unknown',
            'attributes' => [
                'Placeholder' => 'Optional Field',
            ]
        ]);
        CRUD::addField([
            'name' => 'device',
            'type' => 'text',
            'label' => 'Device (Optional)',
            'hint' => 'Device type.',
            'default' => 'unknown',
            'tab' => 'Info (optional)',
            'attributes' => [
                'Placeholder' => 'Optional Field',
            ]            
        ]);
        CRUD::addField([
            'name' => 'token',
            'type' => 'text',
            'label' => '<span style="color:red">* </span> Token',
            'hint' => 'Api token to be used by device.',
            'tab' => 'Api',
            'default' => Str::random(32),
            'attributes' => [
                'Placeholder' => 'Api Token',
                'required' => true,
                'maxlength' => 64,
                'minlength' => 32
            ]            
        ]);
        CRUD::addField([
            'name' => 'key',
            'type' => 'text',
            'label' => '<span style="color:red">* </span> Key',
            'hint' => 'Api encryption key to be used by device.',
            'tab' => 'Api',
            'default' => Str::random(24),
            'attributes' => [
                'Placeholder' => 'Api Token',
                'required' => true,
                'maxlength' => 32,
                'minlength' => 6
            ]
        ]);                                                           
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function update(){
        $mode = $this->crud->getRequest()->get('mode');
        if($mode == 'main'){
            Satellite::where('mode', 'main')->update([
                'mode' => 'remote',
                'status' => 'down'
            ]);
            $this->crud->addField(['type' => 'hidden', 'name' => 'status']);
            $this->crud->getRequest()->request->add(['status'=> 'up']);            
        }
        $response = $this->traitUpdate();
        // do something after save
        return $response;        
    }

    public function store(){
        #check if enable_hotspot or enable_charging is true or false else error
        $enable_time = $this->crud->getRequest()->get('enable_time');
        $enable_data = $this->crud->getRequest()->get('enable_data');
        $enable_charging = $this->crud->getRequest()->get('enable_charging');
        $time_profile = $this->crud->getRequest()->get('timeprofile_id');
        $data_profile = $this->crud->getRequest()->get('dataprofile_id');
        $charge_profile = $this->crud->getRequest()->get('chargeprofile_id');
        $pinprofile = $this->crud->getRequest()->get('pinprofile_id');
        $token = $this->crud->getRequest()->get('token');
        $mode = $this->crud->getRequest()->get('mode');
        $package_default = $this->crud->getRequest()->get('package_default');


        if($mode == 'main'){
            Satellite::where('mode', 'main')->update([
                'mode' => 'remote',
                'status' => 'down'
            ]); 
            $this->crud->addField(['type' => 'hidden', 'name' => 'status']);
            $this->crud->getRequest()->request->add(['status'=> 'up']); 
        }

        if($enable_time == false && $package_default == 0){
            \Alert::add('error', 'Time is not enabled select other package as default selected in portal.')->flash();
            return redirect()->back()->withInput();              
        }

        if($enable_data == false && $package_default == 1){
            \Alert::add('error', 'Data is not enabled select other package as default selected in portal.')->flash();
            return redirect()->back()->withInput();         
        }

        if($enable_charging == false && $package_default == 2){
            \Alert::add('error', 'Charge is not enabled select other package as default selected in portal.')->flash();
            return redirect()->back()->withInput();            
        }

        if($enable_time == false && $enable_charging == false && $enable_data == false){
            \Alert::add('error', 'Enable atleast 1 enabled in profiles')->flash();
            return redirect()->back();  
        }

        if($enable_time == true && !isset($time_profile)){
            \Alert::add('error', 'Please select a Time profile.')->flash();
            return redirect()->back()->withInput();              
        }
        if($enable_data == true && !isset($data_profile)){
            \Alert::add('error', 'Please select a Data profile.')->flash();
            return redirect()->back()->withInput();             
        }
        if($enable_charging == true && !isset($charge_profile)){
            \Alert::add('error', 'Please select a Charge profile.')->flash();
            return redirect()->back()->withInput();              
        }
        if($enable_time == false && !isset($time_profile)){
            $this->crud->getRequest()->request->add(['timeprofile_id'=> 0]);
        }
        if($enable_data == false && !isset($data_profile)){
            $this->crud->getRequest()->request->add(['dataprofile_id'=> 0]);
        }
        if($enable_charging == false && !isset($charge_profile)){
            $this->crud->getRequest()->request->add(['chargeprofile_id'=> 0]);
        }

        if(!isset($pinprofile)){
            \Alert::add('error', 'Please select a Pin profile.')->flash();
            return redirect()->back()->withInput();             
        }

        if($token){
            $this->saveToken($token);
        } else {
            \Alert::add('error', 'Token value is invalid!')->flash();
            return redirect()->back()->withInput();             
        }
        
        $response = $this->traitStore();
        // do something after save
        return $response;        
    }

    private function saveToken($token){
        Api_token::create([
            'user_id' => AUTH::id(),
            'token' => $token,
            'expired_at' => Carbon::now()->addYears(config('multiple-tokens-auth.token.life_length')/365)
        ]);
    }

    public function destroy($id)
    {       
        $this->crud->hasAccessOrFail('delete');
        $this->deleteToken($id);
        return $this->crud->delete($id);
    }

    private function deleteToken($id){
        $satellite_token = Satellite::select('token')->where('id' , $id)->pluck('token')->first();
        if($satellite_token){
            Api_token::where('token', $satellite_token)->delete();
        } else {
            \Alert::add('warning', 'Token already deleted')->flash();
        }
    }

    public function lineRestart($id){
        
        $data = Satellite::select([
            'name',
            'mode'
        ])->where('id', $id)->get()->first();

        if($data->mode == 'remote'){
            \Alert::add('success', 'Vendo remote '.$data->name.' successfully restarted')->flash();
        } else {
            \Alert::add('success', 'Vendo main '.$data->name.' successfully restarted')->flash();
        }
        
        return redirect()->back();
    }
}
