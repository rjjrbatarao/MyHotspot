<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientprofileRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Rate;
/**
 * Class ClientprofileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientprofileCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Clientprofile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/clientprofile');
        CRUD::setEntityNameStrings('clientprofile', 'clientprofiles');
    }

    public function fetchRate(){
        return $this->fetch('App\Models\Rate');
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
        CRUD::enableBulkActions();
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name'
        ]);
        CRUD::addColumn([
            'name' => 'type',
            'type' => 'text',
            'label' => 'Package',
            'wrapper' => [
                'element' => 'span',
                'class' => function($crud, $column, $entry, $related_key){
                    if($column['text'] == 'time'){
                        return 'badge badge-success';
                    } else {
                        return 'badge badge-info';
                    }
                }
            ]
        ]);
        CRUD::addColumn([
            'name' => 'mode',
            'type' => 'text',
            'label' => 'Mode',
            'wrapper' => [
                'element' => 'span',
                'class' => function($crud, $column, $entry, $related_key){
                    if($column['text'] == 'continuous'){
                        return 'badge badge-success';
                    } else {
                        return 'badge badge-info';
                    }
                }
            ]
        ]);      
        CRUD::addColumn([
            'name' => 'case',
            'type' => 'text',
            'label' => 'Case',
            'wrapper' => [
                'element' => 'span',
                'class' => function($crud, $column, $entry, $related_key){
                    if($column['text'] == 'uppercase'){
                        return 'badge badge-success';
                    } else if ($column['text'] == 'lowercase'){
                        return 'badge badge-warning';
                    } else {
                        return 'badge badge-secondary';
                    }
                }
            ]            
        ]); 
        CRUD::addColumn([
            'name' => 'credit_affix',
            'type' => 'text',
            'label' => 'Affix',
            'wrapper' => [
                'element' => 'span',
                'class' => function($crud, $column, $entry, $related_key){
                    if($column['text'] == 'prefix'){
                        return 'badge badge-success';
                    } else if ($column['text'] == 'suffix'){
                        return 'badge badge-warning';
                    } else {
                        return 'badge badge-secondary';
                    }
                }
            ]            
        ]);         
        CRUD::addColumn([
            'name' => 'rate_id',
            'type' => 'select',
            'label' => 'Rate',
            'entity' => 'rate',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('rate/'.$related_key.'/show');
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
        CRUD::setValidation(ClientprofileRequest::class);
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
        ]); 
        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "<span style='color:red'>* </span> Name",
            'hint' => 'Note: Profile name must be unique.',
            'attributes' => [
                'placeholder' => 'Profile name',
                'required' => true
              ],
            'tab' => 'Main'                                      
           ]);
 
        CRUD::addField([
            'name' => 'mode',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span> Mode',
            'hint' => 'Continuous or pausable usage mode.',
            'options' => ['pausable' => 'pausable', 'continuous' => 'continuous'],
            'allows_null' => false,
            'default' => 'continuous',
            'tab' => 'Main' 
        ]);   
        CRUD::addField([
            'name' => 'rate_id',
            'type' => 'relationship',
            'label' => "<span style='color:red'>* </span>Hotspot Rate",
            'hint' => 'Choose rate created from Global Rate page.',
            'entity' => 'rate',
            'attribute' => 'name', 
            'tab' => 'Main',
            'allows_null' => false,
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('service', 'hotspot')->get();
            }),    
            'attributes' => [
                'required' => true
            ],        
            //'inline_create' => true,
            //'ajax' => true, 
            'wrapperAttributes'    => ['class' => 'form-group col-md-12'],                                
           ]);        
        CRUD::addField([
            'name' => 'case',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span>Voucher Case',
            'hint' => 'Choose uppercase, lowercase, or disabled.',
            'options' => ['uppercase' => 'uppercase', 'lowercase' => 'lowercase', 'disabled' => 'disabled'],
            'allows_null' => false,
            'default' => 'disabled',
            'tab' => 'Code'             
        ]);
        CRUD::addField([
            'name' => 'length',
            'type' => 'number',
            'label' => '<span style="color:red">* </span>Voucher length',
            'hint' => 'Voucher length as code + prefixes length if enabled',
            'default' => 6,
            'attributes' => [
                'min' => 6,
                'max' => 32,
            ],
            'tab' => 'Code' 
        ]);         
        CRUD::addField([
            'name' => 'credit_affix',
            'type' => 'select_from_array',
            'label' => 'Credit as Affixes (optional)',
            'hint' => 'Choose credit as prefix, suffix, or disabled.',
            'options' => ['disabled' => 'disabled', 'prefix' => 'prefix', 'suffix' => 'suffix'],
            'allows_null' => false,
            'default' => 'disabled',
            'tab' => 'Affixes (optional)'             
        ]);
        CRUD::addField([
            'name' => 'prefix',
            'type' => 'text',
            'label' => 'Custom Prefix (optional)',
            'hint' => 'Custom prefix, leave blank as disabled',
            'attributes' => [
                'maxlength' => 5,
                'minlength' => 0
            ],
            'allows_null' => true,
            'tab' => 'Affixes (optional)' 
        ]);
        CRUD::addField([
            'name' => 'suffix',
            'type' => 'text',
            'label' => 'Custom Suffix (optional)',
            'hint' => 'Custom suffix, leave blank as disabled',
            'attributes' => [
                'maxlength' => 4,
                'minlength' => 0
            ],
            'allows_null' => true,
            'tab' => 'Affixes (optional)' 
        ]);      
        CRUD::addField([
            'name' => 'enable_rates_bw',
            'type' => 'toggle',
            'label' => 'Use Rates Bandwith',
            'inline' => true,
            'options' => [
                0 => 'no',
                1 => 'yes'
            ],
            'hide_when' => [
                1 => ['bandwidth_up','bandwidth_down'],
                ],
            'default' => 0,
            'tab' => 'Bandwidth',             

        ]);     
        CRUD::addField([
            'name' => 'bandwidth_up',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Upload Speed (bps)',
            'default' => 2048000,
            'hint' => 'Speed in bps 1MB/s = 1 x 102400bps.',
            'attributes' => [
                'placeholder' => 'Upload speed',
                'required' => true
              ],
            'tab' => 'Bandwidth'             
        ]);
        CRUD::addField([
            'name' => 'bandwidth_down',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Download Speed (bps)',
            'default' => 2048000,
            'hint' => 'Speed in bps 1MB/s = 1 x 102400bps.',
            'attributes' => [
                'placeholder' => 'Download speed',
                'required' => true
              ],
            'tab' => 'Bandwidth'             
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

    public function store(){
        $this->crud->addField(['type' => 'hidden', 'name' => 'type']);
        $rate_id = $this->crud->getRequest()->get('rate_id');
        $mode = $this->crud->getRequest()->get('mode');
        $type = Rate::select('type')->where('id',$rate_id)->pluck('type')->first();
        $this->crud->getRequest()->request->add(['type'=> $type]);

        if($mode == 'continuous' && $type == 'data'){
            \Alert::add('error', 'Invalid, cannot set package data as continuous. Set rates expiry instead.')->flash();
            return redirect()->back()->withInput();            
        }

        $response = $this->traitStore();
        // do something after save
        return $response;    
    }
}
