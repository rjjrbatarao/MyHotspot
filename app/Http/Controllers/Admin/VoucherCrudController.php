<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VoucherRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Illuminate\Support\Str;
use App\Models\Ordernumber;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
/**
 * Class VoucherCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VoucherCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Voucher::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/voucher');
        CRUD::setEntityNameStrings('voucher', 'vouchers');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setCase($case,$data){
        if($case == "uppercase"){
            return strtoupper($data);
        } else if($case == "lowercase"){
            return strtolower($data);
        } else {
            return $data;
        }
    }
    protected function generateRandomString($credit){
        $all = \App\Models\Clientprofile::all();
        $length = $all->pluck('length')->first() ?: 6;
        $options = $all->pluck('credit_affix')->first();
        $prefix = $all->pluck('prefix')->first();
        $suffix = $all->pluck('suffix')->first();
        $case = $all->pluck('case')->first();
        $temp = Str::random($length);
        $random = "";
        if($options == "prefix"){
            $random = $credit . $prefix . $temp;
            $random = substr($random,0,$length);
            if($suffix){
                $random = substr_replace($random, $suffix,-strlen($suffix));
                return $this->setCase($case,$random);
            } else {
                return $this->setCase($case,$random);
            }
        } else if($options == "suffix"){
            $random = $credit . $prefix . $temp;
            $random = substr($random,0,$length);
            if($suffix){
                $random = substr_replace($random, $suffix,-strlen($suffix) - 1);
                $random = $random . $credit;
                return $this->setCase($case,$random);
            } else {
                $random = substr_replace($random, $credit, -strlen($credit));
                return $this->setCase($case,$random);
            }            
        } else {
            $random = $prefix . $temp;
            $random = substr($random,0,$length);
            if($suffix){
                $random = substr_replace($random, $suffix, -strlen($suffix));
                return $this->setCase($case,$random);
            } else {
                return $this->setCase($case,$random);
            }
        }
    }

    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Voucher'
        ]);     
        CRUD::addColumn([
            'name' => 'clientprofile_id',
            'type' => 'select',
            'label' => "Profile",
            'entity' => 'clientprofile',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('clientprofile/'.$related_key.'/show');
                },
            ],                                  
           ]); 
           CRUD::addColumn([
            'name' => 'ordernumber_id',
            'type' => 'select',
            'label' => "Order Number",
            'entity' => 'ordernumber',
            'attribute' => 'reference_number',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('ordernumber/'.$related_key.'/show');
                },
            ],                                  
           ]);
        CRUD::addColumn([
            'name' => 'created_by',
            'type' => 'text',
            'label' => 'By'
        ]);
        CRUD::addColumn([
            'name' => 'created_from',
            'type' => 'text',
            'label' => 'From',
            'wrapper' => [
                'element' => 'span',
                'class' => function ($crud, $column, $entry, $related_key) {
                    if ($column['text'] == 'retailer') {
                        return 'badge badge-primary';
                    } else if($column['text'] == 'admin'){
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
        CRUD::setValidation(VoucherRequest::class);
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
        ]); 

        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => '<span style="color:red">* </span> Voucher',
            'hint' => 'Voucher code to make',
            'attributes' => [
                'required' => true,
                'max-length' => 32,
                'min-length' => 6
            ],
            'default' => $this->generateRandomString("5")
        ]);
        
        CRUD::addField([
            'name' => 'clientprofile_id',
            'type' => 'select',
            'label' => '<span style="color:red">* </span> Profile',
            'hint' => 'Choose Hotspot profile created from Hotspot Profile page.',
            'entity' => 'clientprofile',
            'attribute' => 'name',
            'allows_null' => false, 
            'attributes' => [
                'required' => true
            ]                                  
           ]); 
        CRUD::addField([
            'name' => 'limit-uptime',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Limit-uptime (s)',
            'default' => 3600,
            'hint' => 'Time limit in seconds, 1minute = 1 x 60s',
            'attributes' => [
                'placeholder' => 'Limit uptime in seconds',
                'required' => true
              ],            
           ]);
       CRUD::addField([
            'name' => 'limit-bytes',
            'type' => 'number',
            'label' => '<span style="color:red">* </span> Limit-bytes (MB)',
            'default' => 0,
            'hint' => 'Data limit in MegaBytes, 500MB = 500 x 1MB',
            'attributes' => [
                'placeholder' => 'Limit bytes in MB',
                'required' => true
              ],                        
           ]);           
        CRUD::addField([
            'name' => 'credit',
            'type' => 'number',
            'label' => '<span style="color:red">* </span>  Credit',
            'hint' => 'Credit points or monetary value',
            'default' => 5,
            'attributes' => [
                'min' => 1
            ]            
        ]);
        CRUD::addField([
            'name' => 'created_by',
            'type' => 'text',
            'label' => '<span style="color:red">* </span> By',
            'hint' => 'Created by the user(name)',
            'default' =>  Auth::user()->name
        ]);       
        CRUD::addField([
            'name' => 'created_from',
            'type' => 'select_from_array',
            'label' => '<span style="color:red">* </span> From',
            'hint' => 'The voucher created from',
            'options' => [
                'retailer' => 'retailer',
                'admin' => 'admin',
                'satellite' => 'satellite'
            ],
            'default' => 'admin'
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
        $clientprofile_id = $this->crud->getRequest()->get('clientprofile_id');
        $this->crud->addField(['type' => 'hidden', 'name' => 'ordernumber_id']);
        $reference_number = IdGenerator::generate(['table' => 'ordernumbers','field'=>'reference_number', 'length' => 7, 'prefix' => date('ym')]);
        $batch_create = Ordernumber::create([
            'reference_number' => $reference_number
        ]);
        if(empty($clientprofile_id)){
            \Alert::add('error', 'No client profile selected. Please create and select one.')->flash();
            return redirect()->back()->withInput(); 
        }
        if($batch_create){
           \Alert::add('success', 'Order '.$reference_number.' created')->flash(); 
           $batch_id = Ordernumber::where('reference_number', $reference_number)->pluck('id')->first();
           if($batch_id){
            $this->crud->getRequest()->request->add(['ordernumber_id'=> $batch_id]);
            $client_create = Client::create([
                'username' =>  $this->crud->getRequest()->get('name'),
                'credit' =>  $this->crud->getRequest()->get('credit'),
                'limit-uptime' =>  $this->crud->getRequest()->get('limit-uptime'),
                'limit-bytes' =>  $this->crud->getRequest()->get('limit-bytes'),
                'clientprofile_id' => $this->crud->getRequest()->get('clientprofile_id'),
                'account' => 0,
                'status' => 'unused'
                ]);
            if($client_create){
                \Alert::add('success', 'Client '.$this->crud->getRequest()->get('name').' created')->flash(); 
            }            
           } else {
            \Alert::add('error', 'Order Id not found')->flash();
            return redirect()->back()->withInput(); 
           }
        } else {
            \Alert::add('error', 'Order not created')->flash();
            return redirect()->back()->withInput(); 
        }
        
        $response = $this->traitStore();
        // do something after save
        return $response;    
    }
}
