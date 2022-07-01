<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RateCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Rate::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/rate');
        CRUD::setEntityNameStrings('rate', 'rates');
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
            'name' => 'service',
            'type' => 'text',
            'label' => 'Service',
            'wrapper' => [
                'element' => 'span',
                'class' => function($crud, $column, $entry, $related_key){
                    if($column['text'] == 'hotspot'){
                        return 'badge badge-success';
                    } else if($column['text'] == 'pppoe'){
                        return 'badge badge-warning';
                    } else {
                        return 'badge badge-info';
                    }
                }
            ]            
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
        CRUD::setValidation(RateRequest::class);

        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
        ]);        
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "<span style='color:red'>* </span> Name",
            'attributes' => [
                'placeholder' => 'Rate name',
                'required' => true
              ],
            'tab' => 'Main'                                      
        ]);
        
        CRUD::addField([
            'name' => 'type',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span> Package',
            'hint' => 'Time or data pakage',
            'options' => ['time' => 'time', 'data' => 'data'],
            'allows_null' => false,
            'default' => 'time',
            'tab' => 'Main' 
        ]);        
        /*
        CRUD::addField([
            'name' => 'pricing',
            'label' => 'Pricing',
            'type' => 'table2',
            'entity_singular' => 'price',
            'columns' => [
                'price_name' => 'Price (₱)',
                'value_name' => 'Value (s/MB)',
                'expiry_name' => 'Expiry (d)'
            ],
            'max' => 99999,
            'min' => 0,
        ]);
        */
        CRUD::addField([
            'name' => 'service',
            'type' => 'select2_from_array',
            'label' => 'Service Type',
            'allows_null' => false,
            'options' => [
                'hotspot' => 'hotspot',
                'charge' => 'charge',
                'pppoe' => 'pppoe',
            ],
            'default' => 'hotspot',
            'tab' => 'Main'
        ]);        
        CRUD::addField([   // CustomHTML
                'name'  => 'rates_info',
                'type'  => 'custom_html',
                'value' => '<div class="mb-0 mt-3 alert alert-info" role="alert">Fill according to selected Package type where time is in s(second/s) or data in MB(megabyte/s). Bandwidth is ignored when charge is used.</div>',
                'tab'   => 'Rates',
            ]);       
        CRUD::addField([ // Table
            'name'            => 'pricing',
            'label'           => 'Pricing',
            'type'            => 'repeatable',
            'entity_singular' => 'price', // used on the "Add X" button
            'tab' => 'Rates',
            'inline' => true,
            'fields'         => [
                [
                    'label' => 'Price(₱)',
                    'name' => 'price_name',
                    'type' => 'number',
                    'wrapper' => ['class' => 'form-group col-md-2'],
                    'default' => 1,
                    'attributes' => [
                        'placeholder' => 'Price',
                        'required' => true
                      ],                    
                ],
                [
                    'label' => 'Value(s/MB)',
                    'name' => 'value_name',
                    'type' => 'number',
                    'wrapper' => ['class' => 'form-group col-md-2'],
                    'default' => 60,
                    'attributes' => [
                        'placeholder' => 'Value',
                        'required' => true
                      ],                    
                ],
                [
                    'label' => 'Expiry(m)',
                    'name' => 'expiry_name',
                    'type' => 'number',
                    'wrapper' => ['class' => 'form-group col-md-2'],
                    'default' => 99999999,
                    'attributes' => [
                        'placeholder' => 'Expiry',
                        'required' => true
                      ],                    
                ],
                    [
                    'label' => 'BW Up (bps)',
                    'name' => 'bwup_name',
                    'type' => 'number',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                    'default' =>  2048000,
                    'attributes' => [
                        'placeholder' => 'bps',
                        'required' => true
                      ],                    
                ],
                [
                    'label' => 'BW Down (bps)',
                    'name' => 'bwdown_name',
                    'type' => 'number',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                    'default' =>  2048000,
                    'attributes' => [
                        'placeholder' => 'bps',
                        'required' => true
                      ],                    
                ]                                            
            ],           
            'max' => 999999, // maximum rows allowed in the table
            'min' => 0, // minimum rows allowed in the table
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
        $package = $this->crud->getRequest()->get('type');
        $service = $this->crud->getRequest()->get('service');

        if($package == 'data' && $service == 'charge'){
            \Alert::add('error', 'Invalid, cannot set charge rate to data as package. Choose time instead.')->flash();
            return redirect()->back()->withInput();            
        }

        $response = $this->traitStore();
        // do something after save
        return $response;          
    }
}
