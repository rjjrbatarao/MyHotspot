<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\IfacebridgeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Bridgeethernet;
use App\Models\Bridgewlan;
use App\Models\Bridgevlan;
use App\Models\Bridgetun;
use App\Models\Bridgebonding;
use App\Models\Ifaceethernet;
use App\Models\Ifacewlan;
use App\Models\Ifacevlan;
use App\Models\Ifacetun;
use App\Models\Ifacebonding;
/**
 * Class IfacebridgeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class IfacebridgeCrudController extends CrudController
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
    //use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Ifacebridge::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/ifacebridge');
        CRUD::setEntityNameStrings('ifacebridge', 'ifacebridges');
        CRUD::denyAccess('update');
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
            'label' => 'Br-Name'
        ]);   
        CRUD::addColumn([
            'name' => 'status',
            'type' => 'text',
            'label' => 'Br-Status'
        ]);                
        CRUD::column('bridgeethernets')
                ->type('select_multiple')
                ->label('Eth-Iface')
                ->entity('bridgeethernets')
                ->attribute('ifname')
                ->model('App\Models\Ifaceethernet')
                ->wrapper([
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('ifaceethernet/'.$related_key.'/show');
                    },
                ]);
        CRUD::column('bridgevlans')
                ->type('select_multiple')
                ->label('Vln-Iface')
                ->entity('bridgevlans')
                ->attribute('ifname')
                ->model('App\Models\Ifacevlan')
                ->wrapper([
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('ifacevlan/'.$related_key.'/show');
                    },
                ]);                
        CRUD::column('bridgewlans')
                ->type('select_multiple')
                ->label('Wln-Iface')
                ->entity('bridgewlans')
                ->attribute('ifname')
                ->model('App\Models\Ifacewlan')
                ->wrapper([
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('ifacewlan/'.$related_key.'/show');
                    },
                ]);
        CRUD::column('bridgetuns')
                ->type('select_multiple')
                ->label('Tun-Iface')
                ->entity('bridgetuns')
                ->attribute('ifname')
                ->model('App\Models\Ifacetun')
                ->wrapper([
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('ifacetun/'.$related_key.'/show');
                    },
                ]);
        CRUD::column('bridgebondings')
                ->type('select_multiple')
                ->label('Bnd-Iface')
                ->entity('bridgebondings')
                ->attribute('ifname')
                ->model('App\Models\Ifacebonding')
                ->wrapper([
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('Ifacebonding/'.$related_key.'/show');
                    },
                ]);                                                        
        //CRUD::enableDetailsRow();
        //CRUD::setDetailsRowView('vendor.backpack.crud.details_row.ifacebridge');
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

    public function setupShowOperation()
    {
        $this->setupListOperation();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(IfacebridgeRequest::class);
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
        ]);         
        CRUD::addField([
            'name' => 'ifname',
            'type' => 'text',
            'label' => 'Name',
            'default' => 'bridge1',
            'attributes' => [
                'placeholder' => 'Bridge name',
                'required' => true,
                'maxlength' => 32,
                'minlength' => 3
              ],            
        ]);
        
        //CRUD::setFromDb(); // fields     
        CRUD::addField([
            'name' => 'bridgeethernets',
            'type' => 'select2_multiple',
            'label' => 'Ethernet Interface',
            'entity' => 'bridgeethernets',
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
            'name' => 'bridgevlans',
            'type' => 'select2_multiple',
            'label' => 'Vlan Interface',
            'entity' => 'bridgevlans',
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
            'name' => 'bridgewlans',
            'type' => 'select2_multiple',
            'label' => 'Wlan Interface',
            'entity' => 'bridgewlans',
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
        CRUD::addField([
            'name' => 'bridgetuns',
            'type' => 'select2_multiple',
            'label' => 'Tunnel Interface',
            'entity' => 'bridgetuns',
            'attribute' => 'ifname',
            'model' => 'App\Models\Ifacetun',
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
            'name' => 'bridgebondings',
            'type' => 'select2_multiple',
            'label' => 'Bonding Interface',
            'entity' => 'bridgebondings',
            'attribute' => 'ifname',
            'model' => 'App\Models\Ifacebonding',
            'allows_null' => true,
            'pivot' => true,
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ],
            'options'   => (function ($query) {
                return $query->orderBy('ifname', 'ASC')->where('status', 'unassigned')->get();
            }),            
        ]);
        
        CRUD::replaceSaveActions(
            [
                'name' => 'Save', 
                'visible' => function($crud) {
                    return true;
                },
                'redirect' => function($crud, $request, $itemId) {
                    $ethernet_ids = Bridgeethernet::assigned($itemId)->pluck('ifaceethernet_id');
                    $wlan_ids = Bridgewlan::assigned($itemId)->pluck('ifacewlan_id');
                    $vlan_ids = Bridgevlan::assigned($itemId)->pluck('ifacevlan_id');
                    $tun_ids = Bridgetun::assigned($itemId)->pluck('ifacetun_id');
                    $bonding_ids = Bridgebonding::assigned($itemId)->pluck('ifacebonding_id');
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
                    if($tun_ids->isNotEmpty()){
                        foreach ($tun_ids as $id=>$value) {
                            Ifacetun::where('id', $value)->update(['status' => 'assigned']);
                        }
                    }                     
                    if($bonding_ids->isNotEmpty()){
                        foreach ($bonding_ids as $id=>$value) {
                            Ifacebonding::where('id', $value)->update([
                                'status' => 'assigned'
                            ]);
                        }
                    }
                    if($ethernet_ids->isNotEmpty() == false && $wlan_ids->isNotEmpty() == false && $vlan_ids->isNotEmpty() == false && $tun_ids->isNotEmpty() == false && $bonding_ids->isNotEmpty() == false){
                        \Alert::add('error', 'No slave set for the bridge. Add atleast 1 on any interfaces to enable the bridge')->flash();
                    } else {

                    }                   
                    return $crud->route;
                },
            ],
        );        
        
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

    // public function update(){
    //     $ethernet_ids = Bridgeethernet::assigned($itemId)->pluck('ifaceethernet_id');
    //     $wlan_ids = Bridgewlan::assigned($itemId)->pluck('ifacewlan_id');
    //     $vlan_ids = Bridgevlan::assigned($itemId)->pluck('ifacevlan_id');
    //     $tun_ids = Bridgetun::assigned($itemId)->pluck('ifacetun_id');
    //     $bonding_ids = Bridgebonding::assigned($itemId)->pluck('ifacebonding_id');
    //     dd($this->crud->getRequest());
    //     if($ethernet_ids->isNotEmpty() == false && $wlan_ids->isNotEmpty() == false && $vlan_ids->isNotEmpty() == false && $tun_ids->isNotEmpty() == false && $bonding_ids->isNotEmpty() == false){
    //         \Alert::add('error', 'No slave set for the bridge. Add atleast 1 on any interfaces to enable the bridge')->flash();
    //         return $crud->route;
    //     }
    // }
  
    public function store(){
        $ethernet_ids = $this->crud->getRequest()->get('bridgeethernets');
        $wlan_ids = $this->crud->getRequest()->get('bridgewlans');
        $vlan_ids = $this->crud->getRequest()->get('bridgevlans');
        $tun_ids = $this->crud->getRequest()->get('bridgetuns');
        $bonding_ids = $this->crud->getRequest()->get('bridgebondings');
        if(empty($ethernet_ids) && empty($wlan_ids) && empty($vlan_ids) && empty($tun_ids) && empty($bonding_ids)){
            \Alert::add('error', 'No slave set for the bridge. Add atleast 1 on any interfaces to enable the bridge')->flash();
            return redirect()->back()->withInput();
        }
        $response = $this->traitStore();
        // do something after save
        return $response;
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

    public function destroy($id)
    {       
        $this->crud->hasAccessOrFail('delete');
        $this->resetStatus($id);
        return $this->crud->delete($id);
    }
    
    public function resetStatus($id){
        $ethernet_ids = Bridgeethernet::assigned($id)->pluck('ifaceethernet_id');
        $wlan_ids = Bridgewlan::assigned($id)->pluck('ifacewlan_id');
        $vlan_ids = Bridgevlan::assigned($id)->pluck('ifacevlan_id');
        $tun_ids = Bridgetun::assigned($id)->pluck('ifacetun_id');
        $bonding_ids = Bridgebonding::assigned($id)->pluck('ifacebonding_id');
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
        if($tun_ids->isNotEmpty()){
            foreach ($tun_ids as $vid=>$value) {
                Ifacetun::where('id', $value)->update(['status' => 'unassigned']);
            }
        }                     
        if($bonding_ids->isNotEmpty()){
            foreach ($bonding_ids as $vid=>$value) {
                Ifacebonding::where('id', $value)->update(['status' => 'unassigned']);
            }
        }      
    }
}
