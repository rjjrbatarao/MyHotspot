<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PppoeprofileRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PppoeprofileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PppoeprofileCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Pppoeprofile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pppoeprofile');
        CRUD::setEntityNameStrings('pppoeprofile', 'pppoeprofiles');
        
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
        CRUD::enableBulkActions();
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
        CRUD::setValidation(PppoeprofileRequest::class);
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
            'hint' => 'Note: Profile name must be unique.',
            'attributes' => [
                'placeholder' => 'Profile name',
                'required' => true
              ],       
            'tab' => 'Main'                               
           ]);
          
        /*
        CRUD::addField([
            'name' => 'auth',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span> Authentication',
            'options' => ['pap' => 'pap', 'chap' => 'chap'],
            'hint' => 'CHAP authentication is more secure than PAP.',
            'allows_null' => false,
            'default' => 'chap',
            'tab' => 'Main'                             
           ]);
        */
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

        CRUD::addField([
            'name' => 'rate_id',
            'type' => 'select',
            'label' => "<span style='color:red'>* </span>PPPoE Rate",
            'entity' => 'rate',
            'hint' => 'Choose rate created from Global Rate page.',
            'attribute' => 'name',
            'tab' => 'Main',
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('service', 'pppoe')->get();
            }),                                           
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
}
