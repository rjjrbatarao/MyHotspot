<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IfacevlanRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


use App\Models\Ifacevlan;
/**
 * Class IfacevlanCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class IfacevlanCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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

    protected function storeVlans(){
        $data = shell_exec('sudo nmcli --terse dev');
        $darray = explode("\n",trim($data));
        $narray = array();
        foreach($darray as $key => $value){
          array_push($narray,explode(":",trim($darray[$key])));
          $device = Ifacevlan::where('ifname', $narray[$key][0])->pluck('ifname','id')->first();
          if(empty($device) && $narray[$key][1] == "vlan"){
            Ifacevlan::create([
                'ifname' => $narray[$key][0],
                'status_main' => $narray[$key][2],
            ]);
          } 
        }        
    }

    public function setup()
    {
        CRUD::setModel(\App\Models\Ifacevlan::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/ifacevlan');
        CRUD::setEntityNameStrings('ifacevlan', 'ifacevlans');
        $this->storeVlans();
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
        CRUD::setValidation(IfacevlanRequest::class);

        CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
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

    }
}
