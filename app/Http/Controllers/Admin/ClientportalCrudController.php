<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientportalRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Satellite;
/**
 * Class ClientportalCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientportalCrudController extends CrudController
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
    public function setup()
    {
        CRUD::setModel(\App\Models\Clientportal::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/clientportal');
        CRUD::setEntityNameStrings('clientportal', 'clientportals');
        //CRUD::denyAccess('list');
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
            'name' => 'enable_trial',
            'type' => 'boolean',
            'label' => 'Trial Enabled',
            'wrapper' => [
                'element' => 'span',
                'class' =>  function ($crud, $column, $entry, $related_key) {
                    if($column['text'] == 'Yes'){
                        return 'badge badge-success';
                    }else{
                        return 'badge badge-warning';
                    }
                }
            ]
        ]); 
        CRUD::addColumn([
            'name' => 'enable_eloading',
            'type' => 'boolean',
            'label' => 'Eloading Enabled',
            'wrapper' => [
                'element' => 'span',
                'class' =>  function ($crud, $column, $entry, $related_key) {
                    if($column['text'] == 'Yes'){
                        return 'badge badge-success';
                    }else{
                        return 'badge badge-warning';
                    }
                }
            ]            
        ]); 
        CRUD::addColumn([
            'name' => 'enable_chat',
            'type' => 'boolean',
            'label' => 'Chat Enabled',
            'wrapper' => [
                'element' => 'span',
                'class' =>  function ($crud, $column, $entry, $related_key) {
                    if($column['text'] == 'Yes'){
                        return 'badge badge-success';
                    }else{
                        return 'badge badge-warning';
                    }
                }
            ]            
        ]); 
        CRUD::addColumn([
            'name' => 'enable_banner',
            'type' => 'boolean',
            'label' => 'Banner Enabled',
            'wrapper' => [
                'element' => 'span',
                'class' =>  function ($crud, $column, $entry, $related_key) {
                    if($column['text'] == 'Yes'){
                        return 'badge badge-success';
                    }else{
                        return 'badge badge-warning';
                    }
                }
            ]            
        ]); 
        CRUD::addColumn([
            'name' => 'enable_bgimage',
            'type' => 'boolean',
            'label' => 'BgImage Enabled',
            'wrapper' => [
                'element' => 'span',
                'class' =>  function ($crud, $column, $entry, $related_key) {
                    if($column['text'] == 'Yes'){
                        return 'badge badge-success';
                    }else{
                        return 'badge badge-warning';
                    }
                }
            ]            
        ]); 
        CRUD::addColumn([
            'name' => 'enable_terms',
            'type' => 'boolean',
            'label' => 'Terms Enabled',
            'wrapper' => [
                'element' => 'span',
                'class' =>  function ($crud, $column, $entry, $related_key) {
                    if($column['text'] == 'Yes'){
                        return 'badge badge-success';
                    }else{
                        return 'badge badge-warning';
                    }
                }
            ]            
        ]); 
               
        CRUD::addColumn([
            'name' => 'trial_uptime',
            'type' => 'text',
            'label' => 'Trial Uptime'
        ]);                  
        CRUD::addColumn([
            'name' => 'bgimage',
            'type' => 'image',
            'label' => 'BgImage',
            'upload' => true,
            'prefix' => 'storage/',
        ]);                  
        CRUD::addColumn([
            'name' => 'banners',
            'type' => 'text',
            'label' => 'Banners',
            'wrapper' => [
                'element' => 'div',
                'class' => 'overflow-auto'
            ]
        ]);
        CRUD::addColumn([
            'name' => 'title',
            'type' => 'text',
            'label' => 'Title'
        ]);
        CRUD::addColumn([
            'name' => 'footer',
            'type' => 'text',
            'label' => 'Footer'
        ]); 
        CRUD::addColumn([
            'name' => 'footer_url',
            'type' => 'text',
            'label' => 'Footer_url'
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
        CRUD::setValidation(ClientportalRequest::class);
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
        ]);  
        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
            'hint' => 'Name of the portal profile.',
            'attributes' => [
                'required' => true
            ],
            'tab' => 'Main',
        ]);
       
        CRUD::addField([
            'name' => 'status',
            'type' => 'text',
            'label' => 'Status',
            'default' => 'unassigned',
            'tab' => 'Main',
        ]);   
        CRUD::addField([
            'name' => 'enable_membership',
            'type' => 'toggle2',
            'hint' => 'If membership enabled, users can login with password',
            'label' => 'Enable Membership',
            'hint' => 'Allow users to login with username and password in portal',
            'tab' => 'Main',
        ]); 

        CRUD::addField([
            'name' => 'enable_chat',
            'type' => 'toggle2',
            'label' => 'Enable Chat',
            'hint' => 'Enable this for chat feature from portal',
            'inline' => true,
            'tab' => 'Main',         
        ]);        

        CRUD::addField([
            'name' => 'enable_trial',
            'type' => 'toggle',
            'label' => 'Enable Trial',
            'hint' => 'If you want trial for your vistors.',
            'inline' => true,
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['trial_btntext','trial_uptime'],
                ],
            'default' => 0,
            'tab' => 'Main',            
        ]);

        CRUD::addField([
            'name' => 'trial_btntext',
            'type' => 'text',
            'hint' => 'Trial button name on the portal',
            'label' => 'Trial Button Text',
            'default' => 'Trial',
            'tab' => 'Main',
        ]);

        CRUD::addField([
            'name' => 'trial_uptime',
            'type' => 'number',
            'label' => 'Trial Uptime',
            'hint' => 'Trial time limit for visitors.',
            'default' => 30,
            'tab' => 'Main',
        ]);

        CRUD::addField([
            'name' => 'enable_presound',
            'type' => 'toggle',
            'label' => 'Enable Start Sound',
            'hint' => 'Enable disable start sound.',
            'inline' => true,
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['presound_dir'],
                ],
            'default' => 0,
            'tab' => 'Sounds',            
        ]);

        CRUD::addField([
            'name' => 'presound_dir',
            'type' => 'text',
            'label' => 'Start Sound',
            'hint' => 'This is sound played on viewing the page.',
            'default' => '\uploads\presound.mp3',
            'tab' => 'Sounds',
        ]);

        CRUD::addField([
            'name' => 'enable_actvsound',
            'type' => 'toggle',
            'label' => 'Enable Active Sound',
            'hint' => 'Enable disable active sound',
            'inline' => true,
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['actvsound_dir'],
                ],
            'default' => 0,
            'tab' => 'Sounds',            
        ]);

        CRUD::addField([
            'name' => 'actvsound_dir',
            'type' => 'text',
            'hint' => 'This is sound played while you were in insert coin.',
            'label' => 'Active Sound',
            'default' => '\uploads\actvsound.mp3',
            'tab' => 'Sounds',
        ]);

        CRUD::addField([
            'name' => 'enable_postsound',
            'type' => 'toggle',
            'label' => 'Enable End Sound',
            'hint' => 'Enable disable final sound',
            'inline' => true,
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['postsound_dir'],
                ],
            'default' => 0,
            'tab' => 'Sounds',            
        ]);

        CRUD::addField([
            'name' => 'postsound_dir',
            'type' => 'text',
            'label' => 'End Sound',
            'hint' => 'This is sound played on successful transaction',
            'default' => '\uploads\postsound.mp3',
            'tab' => 'Sounds',
        ]);   

        CRUD::addField([
            'name' => 'enable_terms',
            'type' => 'toggle',
            'label' => 'Enable Terms',
            'hint' => 'Enable disable terms on the portal.',
            'inline' => true,
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['usage_terms'],
                ],
            'default' => 0,
            'tab' => 'Main',                         
        ]);

        CRUD::addField([
            'name' => 'usage_terms',
            'type' => 'wysiwyg',
            'label' => 'Usage Terms',
            'hint' => 'Set this to your own terms and conditions',
            'tab' => 'Main',
        ]);   
        
        CRUD::addField([
            'name' => 'enable_eloading',
            'type' => 'toggle',
            'label' => 'Enable Eloading',
            'hint' => 'Enable for eloading service',
            'inline' => true,
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['eloadingprofile_id', 'eload_btntext'],
                ],
            'default' => 0,
            'tab' => 'Main',                         
        ]);

        CRUD::addField([
            'name' => 'eloadingprofile_id',
            'type' => 'select',
            'label' => "<span style='color:red'>* </span> Profile",
            'hint' => 'Choose Eloading profile created from Eloading Profile page.',
            'entity' => 'eloadingprofile',
            'attribute' => 'name',
            'tab' => 'Main',
        ]);

        CRUD::addField([
            'name' => 'eload_btntext',
            'type' => 'text',
            'label' => 'Eload Button Text',
            'hint' => 'Button text shown on the portal for eloading',
            'default' => 'Eload',
            'tab' => 'Main',
        ]);  

        CRUD::addField([
            'name' => 'enable_bgimage',
            'type' => 'toggle',
            'label' => 'Background Image',
            'inline' => true,
            'hint' => 'Enable disable background image, if disabled you will have to choose color for background.',
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['bgimage'],
                1 => ['bgcolor']
                ],
            'default' => 0,
            'tab' => 'Main',                          
        ]); 
        
        CRUD::addField([
            'name' => 'bgimage',
            'type' => 'image',
            'label' => 'Background Image',
            'hint' => 'Select background not more than 2mb',
            'upload'    => true,
            'prefix' => 'storage/',
            'tab' => 'Main',
        ]); 
               
        CRUD::addField([
            'name' => 'bgcolor',
            'type' => 'color_picker',
            'label' => 'Background Color',
            'hint' => 'Select color as background.',
            'default' => '#000000',
            'tab' => 'Main',
            'color_picker_options' => [
                'customClass' => 'custom-class',
                'horizontal' => true,
                'extensions' => [
                    [
                        'name' => 'swatches', // extension name to load
                        'options' => [ // extension options
                            'colors' => [
                                'primary' => '#337ab7',
                                'success' => '#5cb85c',
                                'info' => '#5bc0de',
                                'warning' => '#f0ad4e',
                                'danger' => '#d9534f'
                            ],
                            'namesAsValues' => false
                        ]
                    ]
                ]
            ]            
        ]); 
        
        CRUD::addField([
            'name' => 'enable_banner',
            'type' => 'toggle',
            'label' => 'Enable Banners',
            'hint' => 'Enable banner in the portal',
            'inline' => true,
            'hint' => 'Enable disable banner in portal',
            'options' => [
                0 => 'disabled',
                1 => 'enabled'
            ],
            'hide_when' => [
                0 => ['banners','banner_interval'],
                ],
            'default' => 0,
            'tab' => 'Banners',                       
        ]);
        CRUD::addField([
            'name' => 'banner_interval',
            'type' => 'number',
            'label' => 'Banner Switch Interval',
            'default' => 3000,
            'hint' => 'Banner transition to next banner in milliseconds',
            'tab' => 'Banners',
        ]);         
        CRUD::addField([
            'name' => 'banners',
            'type' => 'repeatable',
            'label' => 'Banners',
            'hint' => 'Set your banner and text.',
            'inline' => true,
            'tab' => 'Banners',
            'fields' => [
                [
                    'label' => 'Text',
                    'name' => 'text',
                    'type' => 'textarea',
                    'wrapper' => [
                        'class' => 'form-group col-md-6'
                    ],
                    'attributes' => [
                        'placeholder' => 'Text',
                    ]
                ],
                [
                    'name' => 'image',
                    'type' => 'image',
                    'label' => 'Image',
                    'wrapper' => [
                        'class' => 'form-group col-md-6'
                    ],                    
                    'crop' => false,
                    'aspect_ratio' => 1,
                ]                    
            ]
        ]);
                 

        CRUD::addField([
            'name' => 'title',
            'type' => 'text',
            'label' => 'Portal Title',
            'default' => 'MyHotspot',
            'hint' => 'This is the html title text in portal',
            'tab' => 'Html',
        ]);
        CRUD::addField([
            'name' => 'footer',
            'type' => 'text',
            'label' => 'Portal Footer',
            'hint' => 'This is the html footer text in portal',
            'default' => 'Myhotspot',
            'tab' => 'Html',
        ]);
        CRUD::addField([
            'name' => 'footer_url',
            'type' => 'url',
            'label' => 'Footer URL',
            'hint' => 'This is the html footer url redirect in portal.',
            'default' => 'http://facebook.com/myhotspot',
            'tab' => 'Html',
        ]);        

                                                                                                  
        CRUD::addField([
            'name'  => 'btn_satellite',
            'label' => "Satellite Buttons",
            'type'  => 'select_and_order',
            'hint' => 'Select and rearrange vendo buttons in portal accordingly',
            'options' => Satellite::get()->pluck('btntext','id')->toArray(),
            'tab' => 'Buttons',
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
        $response = $this->traitStore();
        // do something after save
        return $response;         
    }
}
