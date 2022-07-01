<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IfaceethernetRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Ifaceethernet;

/**
 * Class IfaceethernetCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class IfaceethernetCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;


    protected function storeEthernets(){
        $data = shell_exec('sudo nmcli --terse dev');
        $darray = explode("\n",trim($data));
        $narray = array();
        foreach($darray as $key => $value){
          array_push($narray,explode(":",trim($darray[$key])));
          $device = Ifaceethernet::where('ifname', $narray[$key][0])->pluck('ifname','id')->first();
          if(empty($device) && $narray[$key][1] == "ethernet"){
            Ifaceethernet::create([
                'ifname' => $narray[$key][0],
                'status_main' => $narray[$key][2],
            ]);
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
        CRUD::setModel(\App\Models\Ifaceethernet::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/ifaceethernet');
        CRUD::setEntityNameStrings('ifaceethernet', 'ifaceethernets');
        $this->storeEthernets();
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
        CRUD::setValidation(IfaceethernetRequest::class);

        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'ifname',
            'type' => 'text',
            'label' => 'Name',
            'attributes' => [
                'placeholder' => 'Interface name',
                'required' => true,
                'maxlength' => 32,
                'minlength' => 4
              ],            
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
