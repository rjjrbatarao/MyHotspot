<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PppoeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;

/**
 * Class PppoeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PppoeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Pppoe::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pppoe');
        CRUD::setEntityNameStrings('pppoe', 'pppoes');
        
    }

    public function fetchPppoeaccount(){
        return $this->fetch('App\Models\Pppoeaccount');
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
        CRUD::addButtonFromView('line', 'line_reset', 'line_reset', 'beginning');
        CRUD::addButtonFromView('line', 'line_stop', 'line_stop', 'beginning');
        CRUD::addButtonFromView('line', 'line_enable', 'line_enable', 'beginning');
        CRUD::enableExportButtons();
        $this->addCustomCrudFilters();
        CRUD::addColumn([
            'name' => 'user',
            'type' => 'text',
            'label' => 'User',
        ]);
        CRUD::addColumn([
            'name' => 'secret',
            'type' => 'text',
            'label' => 'Secret',           
        ]);        
        CRUD::addColumn([
            'name' => 'pppoeprofile_id',
            'type' => 'select',
            'label' => "Profile",
            'entity' => 'pppoeprofile',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('pppoeprofile/'.$related_key.'/show');
                },
            ],                                  
           ]);
        CRUD::addColumn([
            'name' => 'pppoeaccount_id',
            'type' => 'select',
            'label' => "Account",
            'entity' => 'pppoeaccount',
            'attribute' => 'first_name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('pppoeaccount/'.$related_key.'/show');
                },
            ],                                  
           ]);           
        CRUD::addColumn([
            'name' => 'status',
            'type' => 'text',
            'label' => 'Status',
            'wrapper' => [
                'element' => 'span',
                'class' => function ($crud, $column, $entry, $related_key) {
                    if ($column['text'] == 'unused') {
                        return 'badge badge-danger';
                    } else if($column['text'] == 'active'){
                        return 'badge badge-success';
                    } else {
                        return 'badge badge-warning';
                    }
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
        CRUD::setValidation(PppoeRequest::class);
        /*
        CRUD::addSaveAction([
            'name' => 'save_action_one',
            'redirect' => function($crud, $request, $itemId) {
                return $crud->route;
            }, // what's the redirect URL, where the user will be taken after saving?
            // OPTIONAL:
            'button_text' => 'Custom save message', // override text appearing on the button
            // You can also provide translatable texts, for example:
            // 'button_text' => trans('backpack::crud.save_action_one'),
            'visible' => function($crud) {
                return true;
            }, // customize when this save action is visible for the current operation
            'referrer_url' => function($crud, $request, $itemId) {
                return $crud->route;
            }, // override http_referrer_url
            'order' => 1, // change the order save actions are in 
        ]);
        */
        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
        ]);         
        CRUD::addField([
            'name' => 'user',
            'type' => 'text',
            'label' => "<span style='color:red'>* </span> User",
            'default' => Str::random(6),
            'hint' => 'Unique PPP username, must be in length 6 or more',
            'attributes' => [
                'placeholder' => 'PPPoE user',
                'required' => true,
                'maxlength' => 32,
                'minlength' => 6
            ]
        ]);

        CRUD::addField([
            'name' => 'secret',
            'type' => 'text',
            'label' => "<span style='color:red'>* </span> Secret",
            'default' => Str::random(8),
            'hint' => 'Secure PPP password, must be in length 6 or more',
            'attributes' => [
                'placeholder' => 'PPPoE secret',
                'required' => true,
                'maxlength' => 32,
                'minlength' => 6
            ]
        ]); 

        CRUD::addField([
            'name' => 'ip',
            'type' => 'text',
            'label' => "IPaddress (optional)",
            'hint' => 'PPP static ipaddress of the client otherwise automatically assigned',
            'attributes' => [
                'placeholder' => 'PPPoE ip',
                'maxlength' => 32,
                'minlength' => 6,
                'pattern' => '^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$'
            ],
            'allows_null' => true,
        ]);   

        CRUD::addField([
            'name' => 'pppoeprofile_id',
            'type' => 'select',
            'label' => "<span style='color:red'>* </span> Profile",
            'hint' => 'Choose PPPoE profile created from PPPoE Profile page.',
            'entity' => 'pppoeprofile',
            'attribute' => 'name',                                 
           ]);
        
           CRUD::addField([
            'name' => 'pppoeaccount_id',
            'type' => 'relationship',
            'label' => "<span style='color:red'>* </span> Account",
            'hint' => 'Choose PPPoE account created from PPPoE account page.',
            'entity' => 'pppoeaccount',
            'attribute' => 'first_name',
            'allows_null' => true,
            'inline_create' => true,                                
           ]);

        CRUD::addField([
            'name' => 'credit',
            'type' => 'number',
            'label' => "<span style='color:red'>* </span> Credit",
            'hint' => 'Credit points or monetary value',
            'default' => 300,
            'attributes' => [
                'placeholder' => 'PPPoE credit',
                'required' => true
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

    protected function addCustomCrudFilters()
    {
        CRUD::filter('text_name')
                ->type('text')
                ->label('Name')
                ->whenActive(function ($value) {
                    CRUD::addClause('where', 'name', 'LIKE', "%$value%");
                });
        CRUD::addfilter([
           'name' => 'pppoeprofile_id',
           'type' => 'select2',
           'label' => 'Profile'
        ], function(){
            return \App\Models\Clientprofile::all()->pluck('name', 'id')->toArray();
        }, function($value){
            CRUD::addClause('where', 'pppoeprofile_id', 'LIKE', "%$value%");
        });
        CRUD::addfilter([
            'name' => 'text_status',
            'type' => 'dropdown',
            'label' => 'Status'
            ],[
                'active' => 'active',
                'unused' => 'unused',
                'paused' => 'paused'
            ], function($value){
                CRUD::addClause('where', 'status', 'LIKE', "%$value%");
        });                
        CRUD::addFilter([
            'name' => 'date_range',
            'type' => 'date_range',
            'label' => 'Date range',
            'date_range_options' => [
                'timePicker' => true,
                'locale' => ['format' => 'YYYY-MM-DD HH:mm:ss']
            ]            
            ],
            false,
            function($value){
                $dates = json_decode($value);
                CRUD::addClause('where', 'created_at', '>=', $dates->from);
                CRUD::addClause('where', 'created_at', '<=', $dates->to. '23:59:59');
        });  
    }
    
    public function lineReset(PppoeRequest $request){
        //return back()->withInput(); // redirect back
        echo $request->route('id');
    }
    public function lineStop(PppoeRequest $request){
        //return back()->withInput(); // redirect back
        echo $request->route('id');
    }
    public function lineEnable(PppoeRequest $request){
        //return back()->withInput(); // redirect back
        echo $request->route('id');
    }        
}
