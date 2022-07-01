<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdapterRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Adapter;
use App\Models\Device;
/**
 * Class AdapterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdapterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }

    protected function storeAdapters(){
        $data = shell_exec('sudo nmcli --terse con');
        $darray = explode("\n",trim($data));
        $narray = array();
        foreach($darray as $key => $value){
          array_push($narray,explode(":",trim($darray[$key])));
          $device = Adapter::where('name', $narray[$key][0])->pluck('name','id')->first();
          if(empty($device)){
            Adapter::create([
                'name' => $narray[$key][0],
                'uuid' => $narray[$key][1],
                'type' => $narray[$key][2],
                'device_id' => Device::where('connection', $narray[$key][0])->pluck('id')->first(),
            ]);
          } 
        }        
    }

    protected function cleanAdapters(){ // make this as button for cleanup
        $data = shell_exec('sudo nmcli --terse con');
        $darray = explode("\n",trim($data));
        $narray = array();
        $carray = array();
        foreach($darray as $key => $value){
          array_push($narray,explode(":",trim($darray[$key]))); 
          array_push($carray,$narray[$key][0]);
        }    
        $devices = Adapter::pluck('name')->toArray();
        $nonexist = array_diff($devices,$carray);
        if(isset($nonexist)){
            foreach($devices as $value){
                Adapter::where('name',$value)->delete();
            }
        }        
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Adapter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/adapter');
        CRUD::setEntityNameStrings('adapter', 'adapters');
        $this->storeAdapters();
        //CRUD::denyAccess('create');
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
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name'
        ]);
        CRUD::addColumn([
            'name' => 'status',
            'type' => 'text',
            'label' => 'Status'
        ]);        
        CRUD::addColumn([
            'name' => 'type',
            'type' => 'text',
            'label' => 'Type'
        ]);
        CRUD::addColumn([
            'name' => 'mode',
            'type' => 'text',
            'label' => 'Mode'
        ]);

        CRUD::addColumn([
            'name' => 'device_id',
            'type' => 'select',
            'label' => "Device",
            'entity' => 'device',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('device/'.$related_key.'/show');
                },
            ],
        ]);
        CRUD::addColumn([
            'name' => 'uuid',
            'type' => 'text',
            'label' => 'Uuid'
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
        CRUD::setValidation(AdapterRequest::class);

        CRUD::setFromDb(); // fields

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
        \Alert::success('New interface created for this entry.')->flash();
        return \Redirect::to($this->crud->route);       
    }
}
