<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChargeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;
/**
 * Class ChargeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChargeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Charge::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/charge');
        CRUD::setEntityNameStrings('charge', 'charges');
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
        $this->addCustomCrudFilters();
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name'
        ]);
        CRUD::addColumn([
            'name' => 'credit',
            'type' => 'number',
            'label' => 'Credit'
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
        CRUD::setValidation(ChargeRequest::class);
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)',
        ]);         
        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "<span style='color:red'>* </span> Name",
            'default' => Str::uuid(),
            'hint' => 'Unique uuid or random reference code.',
            'attributes' => [
                'placeholder' => 'Reference name',
                'required' => true
            ]
        ]);
          
        CRUD::addField([
            'name' => 'chargeprofile_id',
            'type' => 'select',
            'label' => "<span style='color:red'>* </span> Profile",
            'hint' => 'Choose profile created from Charge profile page.',
            'entity' => 'chargeprofile',
            'attribute' => 'name',
            'attributes' => [
                'required' => true
            ],                                 
           ]);

        CRUD::addField([
            'name' => 'credit',
            'type' => 'number',
            'label' => "<span style='color:red'>* </span> Credit",
            'hint' => 'Credit point or monetary value',
            'attributes' => [
                'placeholder' => 'Credits',
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
           'name' => 'chargeprofile_id',
           'type' => 'select2',
           'label' => 'Profile'
        ], function(){
            return \App\Models\Chargeprofile::all()->pluck('name', 'id')->toArray();
        }, function($value){
            CRUD::addClause('where', 'chargeprofile_id', 'LIKE', "%$value%");
        });
        CRUD::addfilter([
            'name' => 'text_status',
            'type' => 'dropdown',
            'label' => 'Status'
            ],[
                'active' => 'active',
                'unused' => 'unused',
                'paused' => 'stopped'
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
}
