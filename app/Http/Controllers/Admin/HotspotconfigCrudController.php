<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HotspotconfigRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class HotspotconfigCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class HotspotconfigCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }    
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Hotspotconfig::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/hotspotconfig');
        CRUD::setEntityNameStrings('hotspotconfig', 'hotspotconfigs');
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
        CRUD::setValidation(HotspotconfigRequest::class);

        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)',
   
        ]);
        CRUD::addField([   // CustomHTML
            'name'  => 'config_info',
            'type'  => 'custom_html',
            'value' => '<div class="mb-0 mt-3 alert alert-success bg-teal" role="alert">Main refers to the built in portal profiles and Remote refers to custom html portal.</div>',
            'tab'   => 'Main',
        ]);        
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
            'hint' => 'This is the name of the hotspot configuration.',
            'tab' => 'Main',
            'attributes' => [
                'required' => true,
                'minlength' => 3,
                'maxlength' => 190
            ]             
        ]);
        // CRUD::addField([
        //     'name' => 'enable_radius',
        //     'type' => 'boolean',
        //     'label' => 'Enable Radius',
        //     'default' => true,
        //     'tab' => 'Main'
        // ]);

        CRUD::addField([
            'name' => 'adapter_id',
            'type' => 'select',
            'label' => 'Hotspot Interface',
            'entity' => 'adapter',
            'attribute' => 'name',
            'hint' => 'Select what interface for your hotspot service.',
            'allows_null' => false,
            'tab' => 'Main',
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('type','!=', 'tun')->where('type','!=', 'ppp')->where('status', 'unassigned')->get();
            }),
            'attributes' => [
                'required' => true
            ]                        
        ]); 
        CRUD::addField([
            'name' => 'clientportal_id',
            'type' => 'select',
            'label' => 'Client Portal',
            'entity' => 'clientportal',
            'attribute' => 'name',
            'hint' => 'Select your portal profile.',
            'allows_null' => false, 
            'tab' => 'Main', 
            'attributes' => [
                'required' => true
            ]                      
        ]);         

        CRUD::addField([
            'name' => 'shared_user',
            'type' => 'toggle2',
            'label' => 'Enable Shared User',
            'hint' => 'Enable disable shared user on different Hotspot',
            'tab' => 'Main',
            'default' => false
        ]);

        // CRUD::addField([
        //     'name' => 'type',
        //     'type' => 'toggle',
        //     'label' => 'Hotspot Web Portal',
        //     'hint' => 'Main uses built in portal profiles, while custom uses custom html portal.',
        //     'inline' => true,
        //     'tab' => 'Main',
        //     'options' => [
        //         0 => 'main',
        //         1 => 'custom'
        //     ],
        //     'hide_when' => [
        //         0 => ['custom_portal'],
        //         1 => ['clientportal_id']
        //         ],
        //     'default' => 0, 
        // ]);         
                        

                                                        
        CRUD::addField([
            'name' => 'custom_portal',
            'type' => 'toggle',
            'label' => 'Enable Custom Portal',
            'hint' => 'For full custom portal, idicate the source of your html if this is enabled.',
            'inline' => true,
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['html_directory'],
                1 => ['clientportal_id']
                ],
            'default' => 0,
            'tab' => 'Main', 
        ]); 

        CRUD::addField([
            'name' => 'html_directory',
            'type' => 'text',
            'label' => 'Portal Html Directory',
            'hint' => 'This is the directory of the custom html to be used.',
            'default' => '/hotspot',
            'tab' => 'Main',
            'attributes' => [
                'minlength' => 5,
                'maxlength' => 255
            ]             
        ]);
        
        CRUD::addField([
            'name' => 'enable_ttl_1',
            'type' => 'toggle',
            'label' => 'Enable TTL Change',
            'inline' => true,
            'hint' => 'This is used to allow changing ttl value.',
            'tab' => 'Main',
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['ttl_value'],
                ],
            'default' => 0,          
        ]); 
        CRUD::addField([
            'name' => 'ttl_value',
            'type' => 'number',
            'label' => 'TTL Value',
            'hint' => 'Set this to 1 to enable anti-thetering feature.',
            'default' => 0,
            'tab' => 'Main',
            'attributes' => [
                'min' => 0,
                'max' => 65000
            ]             
        ]);         
        
        CRUD::addField([
            'name' => 'autodelete_expired',
            'type' => 'toggle',
            'label' => 'Enable Delete Expired Users',
            'hint' => 'This option delete expired users automatically.',
            'inline' => true,
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['autodelete_delay'],
                ],
            'default' => 0,
            'tab' => 'Main',
        ]); 
        CRUD::addField([
            'name' => 'autodelete_delay',
            'type' => 'number',
            'label' => 'Delete Delay',
            'hint' => 'Delay before deleting expired users',
            'default' => 60,
            'tab' => 'Main',
            'attributes' => [
                'min' => 1,
                'max' => 65000
            ]            
        ]);                         

        CRUD::addField([
            'name' => 'na_id',
            'type' => 'select',
            'label' => 'Nas ID',
            'entity' => 'nas',
            'attribute' => 'shortname',
            'allows_null' => false,
            'tab' => 'Advanced',              
        ]); 

        CRUD::addField([
            'name' => 'hs_uamport',
            'type' => 'number',
            'label' => 'Hotspot Service Port',
            'default' => 3991,
            'tab' => 'Advanced', 
        ]);                         
        CRUD::addField([
            'name' => 'hs_uamuiport',
            'type' => 'number',
            'label' => 'Hotspot Service UI Port',
            'default' => 4991,
            'tab' => 'Advanced', 
        ]); 
        CRUD::addField([
            'name' => 'hs_network', //10.1.0.0
            'type' => 'text',
            'label' => 'Hotspot Network',
            'default' => '10.1.0.0',
            'attributes' => [
                'placeholder' => 'Network IP',
                'maxlength' => 32,
                'minlength' => 6,
                'pattern' => '^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$'
            ],            
            'tab' => 'Advanced', 
        ]); 
        CRUD::addField([
            'name' => 'hs_uamlisten', //10.1.0.1
            'type' => 'text',
            'label' => 'Hotspot Service IP',
            'default' => '10.1.0.1',
            'attributes' => [
                'placeholder' => 'Listen IP',
                'maxlength' => 32,
                'minlength' => 6,
                'pattern' => '^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$'
            ],            
            'tab' => 'Advanced', 
        ]);                                  
        CRUD::addField([
            'name' => 'hs_netmask',
            'type' => 'text',
            'label' => 'Hotspot Netmask',
            'default' => '255.255.255.0',
            'attributes' => [
                'placeholder' => 'Netmask',
                'maxlength' => 32,
                'minlength' => 6,
                'pattern' => '^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$'
            ],            
            'tab' => 'Advanced', 
        ]); 
                       
        CRUD::addField([
            'name' => 'hs_dns1',
            'type' => 'text',
            'label' => 'Hotspot DNS1',
            'default' => '10.1.0.1',
            'attributes' => [
                'placeholder' => 'Primary DNS',
                'maxlength' => 32,
                'minlength' => 6,
                'pattern' => '^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$'
            ],            
            'tab' => 'Advanced', 
        ]); 
        CRUD::addField([
            'name' => 'hs_dns2',
            'type' => 'text',
            'label' => 'Hotspot DNS2',
            'default' => '208.67.220.220',
            'attributes' => [
                'placeholder' => 'Secondary DNS',
                'maxlength' => 32,
                'minlength' => 6,
                'pattern' => '^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$'
            ],            
            'tab' => 'Advanced', 
        ]);
        CRUD::addField([
            'name' => 'hs_uamallow',
            'type' => 'table',
            'label' => 'Allow Host',
            'hint' => 'Walled garden by Host name',
            'tab' => 'Advanced', 
            'columns'         => [
                'host'  => 'Host',
            ],
            'max' => 32, // maximum rows allowed in the table
            'min' => 0, // minimum rows allowed in the table            
        ]);        
        
        CRUD::addField([
            'name' => 'hs_uamdomains',
            'type' => 'table',
            'label' => 'Allow Domain',
            'hint' => 'Walled garden by domain name',
            'tab' => 'Advanced', 
            'columns'         => [
                'domain'  => 'Domain',
            ],
            'max' => 32, // maximum rows allowed in the table
            'min' => 0, // minimum rows allowed in the table            
        ]); 
        CRUD::addField([
            'name' => 'enable_squid',
            'type' => 'toggle',
            'label' => 'Enable Squid Cache',
            'inline' => true,
            'tab' => 'Advanced', 
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['hs_postauth_proxy','hs_postauth_proxyport'],
                ],
            'default' => 0, 
        ]);                         
        CRUD::addField([
            'name' => 'hs_postauth_proxy',
            'type' => 'text',
            'label' => 'Post Auth Proxy',
            'tab' => 'Advanced', 
            'default' => 'myhotspot.com' // dns to itself
        ]); 
        CRUD::addField([
            'name' => 'hs_postauth_proxyport',
            'type' => 'number',
            'label' => 'Post Auth Proxy Port',
            'tab' => 'Advanced', 
            'default' => 3128
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
    public function update(){
        $this->crud->addField(['type' => 'hidden', 'name' => 'type']);
        $custom_portal = $this->crud->getRequest()->get('custom_portal');
        if($custom_portal){
            $this->crud->getRequest()->request->add(['type'=> true]);    
        } else {
            $this->crud->getRequest()->request->add(['type'=> false]); 
        }
        $response = $this->traitUpdate();
        // do something after save
        return $response;
    }     

    public function store(){
        $this->crud->addField(['type' => 'hidden', 'name' => 'type']);
        $custom_portal = $this->crud->getRequest()->get('custom_portal');
        if($custom_portal){
            $this->crud->getRequest()->request->add(['type'=> true]);    
        } else {
            $this->crud->getRequest()->request->add(['type'=> false]); 
        }
        $response = $this->traitStore();
        // do something after save
        return $response;
    }
}
