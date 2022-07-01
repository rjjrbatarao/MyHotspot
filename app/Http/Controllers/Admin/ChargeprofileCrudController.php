<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChargeprofileRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ChargeprofileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChargeprofileCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
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
        CRUD::setModel(\App\Models\Chargeprofile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/chargeprofile');
        CRUD::setEntityNameStrings('chargeprofile', 'chargeprofiles');
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
        CRUD::setValidation(ChargeprofileRequest::class);
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
           ]);     
 
        CRUD::addField([
            'name' => 'rate_id',
            'type' => 'relationship',
            'label' => "<span style='color:red'>* </span>Charge Rate",
            'hint' => 'Choose rate created from Global Rate page.',
            'entity' => 'rate',
            'attribute' => 'name', 
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('type', 'time')->where('service', 'charge')->get();
            }),
            'attributes' => [
                'required' => true
            ],
            'allows_null' => false,
            //'inline_create' => true,
            //'ajax' => true, 
            'wrapperAttributes'    => ['class' => 'form-group col-md-12'],                                        
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
