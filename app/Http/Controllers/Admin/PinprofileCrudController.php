<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PinprofileRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PinprofileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PinprofileCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Pinprofile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pinprofile');
        CRUD::setEntityNameStrings('pinprofile', 'pinprofiles');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

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
        CRUD::setValidation(PinprofileRequest::class);
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
            'hint' => 'Profile name for your gpios.',
            'tab' => 'Main',
            'attributes' => [
                'Placeholder' => 'Profile Name',
                'required' => true,
            ]              
        ]);        

        CRUD::addField([
            'name' => 'signal_pin',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Signal Pin',
            'hint' => 'Signal pin for coinslot.',
            'tab' => 'Pinout',
            'attributes' => [
                'Placeholder' => 'Coinslot Sinal Pin',
                'required' => true,
                'min' => 0,
                'max' => 999999,
            ]            
        ]);
        CRUD::addField([
            'name' => 'charging_pin',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Charging Pin',
            'hint' => 'Charging pin for coinslot.',
            'tab' => 'Pinout',
            'attributes' => [
                'Placeholder' => 'Charging Pin',
                'required' => true,
                'min' => 0,
                'max' => 999999,
            ]            
        ]);        
        CRUD::addField([
            'name' => 'coincut_pin',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Coincut Pin',
            'hint' => 'Coincut aka solenoid cut for coinslot.',
            'tab' => 'Pinout',
            'attributes' => [
                'Placeholder' => 'Coin Disable Pin',
                'required' => true,
                'min' => 0,
                'max' => 999999,
            ]            
        ]);
        CRUD::addField([
            'name' => 'button_pin',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Button Pin',
            'hint' => 'Button queue/cancel pin',
            'tab' => 'Pinout',
            'attributes' => [
                'Placeholder' => 'Button Queue & Cancel Pin',
                'required' => true,
                'min' => 0,
                'max' => 999999,
            ]
        ]);        
        CRUD::addField([
            'name' => 'coincut_logic',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span> Coincut Logic',
            'hint' => 'Coin Acceptor normally HIGH or LOW.',
            'tab' => 'Pinout',
            'options' => [
                'high' => 'high',
                'low' => 'low'
            ],
            'allows_null' => false,
            'default' => 'high',            
        ]);
        CRUD::addField([
            'name' => 'billacceptor_pin',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Bill Acceptor Pin',
            'hint' => 'Bill acceptor signal pin',
            'tab' => 'Pinout',
            'attributes' => [
                'Placeholder' => 'Bill Sinal Pin',
                'required' => true,
                'min' => 0,
                'max' => 999999,
            ]            
        ]);        
        CRUD::addField([
            'name' => 'billcut_pin',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Billcut Pin',
            'hint' => 'Billcut aka solenoid cut for coinslot.',
            'tab' => 'Pinout',
            'attributes' => [
                'Placeholder' => 'Bill Disable Pin',
                'required' => true,
                'min' => 0,
                'max' => 999999,
            ]            
        ]);        
        CRUD::addField([
            'name' => 'billcut_logic',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span> Billcut Logic',
            'hint' => 'Bill acceptor normally HIGH or LOW.',
            'tab' => 'Pinout',
            'options' => [
                'high' => 'high',
                'low' => 'low'
            ],
            'allows_null' => false,
            'default' => 'high',            
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
        $coincut = $this->crud->getRequest()->get('coincut_pin');
        $button = $this->crud->getRequest()->get('button_pin');
        $charging = $this->crud->getRequest()->get('charging_pin');
        $signal = $this->crud->getRequest()->get('signal_pin');        
        $pin_array = array($signal, $coincut, $button, $charging);
        $unique_array = array_unique($pin_array);        
        if(sizeof($pin_array) != sizeof($unique_array)){
            \Alert::add('error', 'Duplicate Pin is prohibited. Please check pins for same value.')->flash();
            return redirect()->back()->withInput();              
        }        
        $response = $this->traitStore();
        // do something after save
        return $response;    
    }
}
