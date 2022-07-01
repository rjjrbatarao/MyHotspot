<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IfacebondingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Bondingethernet;
use App\Models\Bondingwlan;
use App\Models\Bondingvlan;
use App\Models\Ifaceethernet;
use App\Models\Ifacewlan;
use App\Models\Ifacevlan;
/**
 * Class IfacebondingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class IfacebondingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }    
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation { bulkDelete as traitBulkDelete; }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Ifacebonding::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/ifacebonding');
        CRUD::setEntityNameStrings('ifacebonding', 'ifacebondings');
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
            'name' => 'iftype',
            'type' => 'text',
            'label' => 'If-Type'
        ]);       
        CRUD::addColumn([
            'name' => 'ifname',
            'type' => 'text',
            'label' => 'Bd-Name'
        ]);
        CRUD::addColumn([
            'name' => 'status',
            'type' => 'text',
            'label' => 'Bd-Status'
        ]);                    
        CRUD::column('bondingethernets')
                ->type('select_multiple')
                ->label('Eth-Iface')
                ->entity('bondingethernets')
                ->attribute('ifname')
                ->model('App\Models\Ifaceethernet')
                ->wrapper([
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('ifaceethernet/'.$related_key.'/show');
                    },
                ]);
        CRUD::column('bondingvlans')
                ->type('select_multiple')
                ->label('Vln-Iface')
                ->entity('bondingvlans')
                ->attribute('ifname')
                ->model('App\Models\Ifacevlan')
                ->wrapper([
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('ifacevlan/'.$related_key.'/show');
                    },
                ]);                
        CRUD::column('bondingwlans')
                ->type('select_multiple')
                ->label('Wln-Iface')
                ->entity('bondingwlans')
                ->attribute('ifname')
                ->model('App\Models\Ifacewlan')
                ->wrapper([
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('ifacewlan/'.$related_key.'/show');
                    },
                ]);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    protected function setupShowOperation(){
        $this->setupListOperation();
    }
    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(IfacebondingRequest::class);
        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
        ]);        
        CRUD::addField([
            'name' => 'ifname',
            'type' => 'text',
            'label' => 'Name',
            'default' => 'bond1',
            'attributes' => [
                'placeholder' => 'Bridge name',
                'required' => true,
                'maxlength' => 32,
                'minlength' => 3
              ],            
        ]);  
               
        CRUD::addField([
            'name' => 'bondingethernets',
            'type' => 'select2_multiple',
            'label' => 'Ethernet Slaves',
            'entity' => 'bondingethernets',
            'attribute' => 'ifname',
            'model' => 'App\Models\Ifaceethernet',
            'allows_null' => true,
            'pivot' => true,
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ],
            'options'   => (function ($query) {
                return $query->orderBy('ifname', 'ASC')->where('status', 'unassigned')->get();
            }),            
        ]);
        CRUD::addField([
            'name' => 'bondingvlans',
            'type' => 'select2_multiple',
            'label' => 'Vlan Slaves',
            'entity' => 'bondingvlans',
            'attribute' => 'ifname',
            'model' => 'App\Models\Ifacevlan',
            'allows_null' => true,
            'pivot' => true,
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ],
            'options'   => (function ($query) {
                return $query->orderBy('ifname', 'ASC')->where('status', 'unassigned')->get();
            }),            
        ]);        
        CRUD::addField([
            'name' => 'bondingwlans',
            'type' => 'select2_multiple',
            'label' => 'Wlan Slaves',
            'entity' => 'bondingwlans',
            'attribute' => 'ifname',
            'model' => 'App\Models\Ifacewlan',
            'allows_null' => true,
            'pivot' => true,
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ],
            'options'   => (function ($query) {
                return $query->orderBy('ifname', 'ASC')->where('status', 'unassigned')->get();
            }),            
        ]);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
        CRUD::replaceSaveActions(
            [
                'name' => 'Save', 
                'visible' => function($crud) {
                    return true;
                },
                'redirect' => function($crud, $request, $itemId) {
                    $ethernet_ids = Bondingethernet::assigned($itemId)->pluck('ifaceethernet_id');
                    $wlan_ids = Bondingwlan::assigned($itemId)->pluck('ifacewlan_id');
                    $vlan_ids = Bondingvlan::assigned($itemId)->pluck('ifacevlan_id');
                    $count = 0;
                    if($ethernet_ids->isNotEmpty()){
                        foreach ($ethernet_ids as $id=>$value) {
                            $count++;
                        }
                    }                    
                    if($wlan_ids->isNotEmpty()){
                        foreach ($wlan_ids as $id=>$value) {
                            $count++;
                        }
                    } 
                    if($vlan_ids->isNotEmpty()){
                        foreach ($vlan_ids as $id=>$value) {
                            $count++;
                        }
                    }
                    if($ethernet_ids->isNotEmpty() == false && $wlan_ids->isNotEmpty() == false && $vlan_ids->isNotEmpty() == false){
                        \Alert::add('error', 'No slave set for the bonding. Add atleast 2 on any interfaces to enable the bonding')->flash();
                    }  else {
                        if($count <= 1){
                            \Alert::add('error', 'Add 1 more on any interfaces to enable the bonding')->flash();
                        } else {
                            if($ethernet_ids->isNotEmpty()){
                                foreach ($ethernet_ids as $id=>$value) {
                                    Ifaceethernet::where('id', $value)->update(['status' => 'assigned']);
                                }
                            }                    
                            if($wlan_ids->isNotEmpty()){
                                foreach ($wlan_ids as $id=>$value) {
                                    Ifacewlan::where('id', $value)->update(['status' => 'assigned']);
                                }
                            } 
                            if($vlan_ids->isNotEmpty()){
                                foreach ($vlan_ids as $id=>$value) {
                                    Ifacevlan::where('id', $value)->update(['status' => 'assigned']);
                                }
                            }                            
                            
                        }
                    }                  
                    return $crud->route;
                },
            ],
        );        
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
        $ethernet_ids = $this->crud->getRequest()->get('bondingethernets');
        $wlan_ids = $this->crud->getRequest()->get('bondingwlans');
        $vlan_ids = $this->crud->getRequest()->get('bondingvlans');
        $count = 0;

        if(empty($ethernet_ids) && empty($wlan_ids) && empty($vlan_ids)){
            \Alert::add('error', 'No slave set for the bonding. Add atleast 2 on any interfaces to enable the bonding')->flash();
            return redirect()->back()->withInput();
        } else {
            if(!empty($ethernet_ids)){
                 foreach ($ethernet_ids as $id=>$value) {
                     $count++;
                 }
             }                    
             if(!empty($wlan_ids)){
                 foreach ($wlan_ids as $id=>$value) {
                     $count++;
                 }
             } 
             if(!empty($vlan_ids)){
                 foreach ($vlan_ids as $id=>$value) {
                     $count++;
                 }
             }
             if($count <= 1){
                \Alert::add('error', 'Add atleast 2 on any interfaces to enable the bonding')->flash();
                return redirect()->back()->withInput();
             }
        }
        $response = $this->traitStore();
        // do something after save
        return $response;
    }
    
    public function destroy($id)
    {       
        $this->crud->hasAccessOrFail('delete');
        $this->resetStatus($id);
        return $this->crud->delete($id);
    }
    
    public function bulkDelete()
    {
        $this->crud->hasAccessOrFail('create');
        $entries = request()->input('entries');
        foreach ($entries as $key => $id) {
            $this->resetStatus($id);
        }  
        $response = $this->traitBulkDelete();

        return $response;   
    }

    public function resetStatus($id){
        $ethernet_ids = Bondingethernet::assigned($id)->pluck('ifaceethernet_id');
        $wlan_ids = Bondingwlan::assigned($id)->pluck('ifacewlan_id');
        $vlan_ids = Bondingvlan::assigned($id)->pluck('ifacevlan_id');

        if($ethernet_ids->isNotEmpty()){
            foreach ($ethernet_ids as $vid=>$value) {
                Ifaceethernet::where('id', $value)->update(['status' => 'unassigned']);
            }
        } 
        if($wlan_ids->isNotEmpty()){
            foreach ($wlan_ids as $vid=>$value) {
                Ifacewlan::where('id', $value)->update(['status' => 'unassigned']);
            }
        } 
        if($vlan_ids->isNotEmpty()){
            foreach ($vlan_ids as $vid=>$value) {
                Ifacevlan::where('id', $value)->update(['status' => 'unassigned']);
            }
        } 
    }

}
