<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DeviceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Device;

/**
 * Class DeviceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DeviceCrudController extends CrudController
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

    protected function storeDevices(){
        $data = shell_exec('sudo nmcli --terse dev');
        $darray = explode("\n",trim($data));
        $narray = array();
        foreach($darray as $key => $value){
          array_push($narray,explode(":",trim($darray[$key])));
          $device = Device::where('name', $narray[$key][0])->pluck('name','id')->first();
          if(empty($device)){
            Device::create([
                'name' => $narray[$key][0],
                'type' => $narray[$key][1],
                'state' => $narray[$key][2],
                'connection' => $narray[$key][3],
            ]);
          } 
        }        
    }

    protected function cleanDevices(){ // make this as button for cleanup
        $data = shell_exec('sudo nmcli --terse dev');
        $darray = explode("\n",trim($data));
        $narray = array();
        $carray = array();
        foreach($darray as $key => $value){
          array_push($narray,explode(":",trim($darray[$key]))); 
          array_push($carray,$narray[$key][0]);
        }    
        $devices = Device::pluck('name')->toArray();
        $nonexist = array_diff($devices,$carray);
        if(isset($nonexist)){
            foreach($devices as $value){
                Device::where('name',$value)->delete();
            }
        }        
    }

    public function setup()
    {
        CRUD::setModel(\App\Models\Device::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/device');
        CRUD::setEntityNameStrings('device', 'devices');
        //CRUD::denyAccess('create');
        $this->storeDevices();
        //$this->cleanDevices();
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
        CRUD::setValidation(DeviceRequest::class);

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
}
