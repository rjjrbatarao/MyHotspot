<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GeneralconfigRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class GeneralconfigCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GeneralconfigCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Generalconfig::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/generalconfig');
        CRUD::setEntityNameStrings('generalconfig', 'generalconfigs');
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
        CRUD::setValidation(GeneralconfigRequest::class);

        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' =>'name',
            'label' => 'Name',
            'type' => 'text'
        ]);

        CRUD::addField([
            'name' =>'adapter_id',
            'label' => 'Wan Interface',
            'type' => 'select',
            'entity' => 'adapter',
            'attribute' => 'name',
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('type','!=', 'tun')->where('type','!=', 'ppp')->where('status', 'unassigned')->get();
            }),
            'attributes' => [
                'required' => true
            ],
        ]);

        CRUD::addField([
            'name' =>'ntp_primary',
            'label' => 'NTP Primary',
            'type' => 'text'
        ]);

        CRUD::addField([
            'name' =>'ntp_secondary',
            'label' => 'NTP Secondary',
            'type' => 'text'
        ]);

        CRUD::addField([
            'name' =>'hostname',
            'label' => 'Hostname',
            'type' => 'text'
        ]);

        CRUD::addField([
            'name' =>'advance_mode',
            'label' => 'Advance Mode',
            'type' => 'toggle2',
        ]);

        CRUD::addField([
            'name' =>'license',
            'label' => 'License',
            'type' => 'text'
        ]);
        CRUD::addField([
            'name' =>'email',
            'label' => 'Email',
            'type' => 'text'
        ]);
        CRUD::addField([
            'name' =>'latitude',
            'label' => 'Latitude',
            'type' => 'number',
            'attributes' => [
                'step' => 'any'
            ]
        ]);

        CRUD::addField([
            'name' =>'longtitude',
            'label' => 'Longtitude',
            'type' => 'number',
            'attributes' => [
                'step' => 'any'
            ]            
        ]);

        CRUD::addField([
            'name' =>'zoom',
            'label' => 'Zoom',
            'type' => 'number'
        ]);

        CRUD::addField([
                'label' => 'Enable Remote?',
                'name' => 'enable_remote',
                'type' => 'toggle',
                'inline' => true,
                'options' => [
                    0 => 'no',
                    1 => 'yes'
                ],
                'hide_when' => [
                    0 => ['remote_url'],
                    ],
                'default' => 0
            ]);
            
        CRUD::addField([ 
            'label' => "Remote",
            'type' => 'text',
            'name' => 'remote_url',
            'attributes' => [
                'disabled' => true
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
}
