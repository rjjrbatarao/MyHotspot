<?php

namespace App\Http\Controllers\Admin;

use Linfo\Linfo;
use App\Models\Profile;
use App\Models\Voucher;
use Illuminate\Support\Str;
use App\Http\Requests\ClientRequest;
use Backpack\Settings\app\Models\Setting;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Noodlehaus\Config;
use Noodlehaus\Parser\Json;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use App\Models\Ordernumber;

use plugowski\iptables\IptablesService;
use plugowski\iptables\Table\Table;
use plugowski\iptables\Table\TableFactory;
use plugowski\iptables\Command;

use MessagePack\MessagePack;

/**
 * Class ClientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;    
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Client::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client');
        CRUD::setEntityNameStrings('client', 'clients');
        CRUD::addButtonFromView('bottom', 'bulk_export', 'bulk_export', 'end');

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
        CRUD::addButtonFromView('top', 'bulk_generate', 'bulk_generate', 'end');
        $this->addCustomCrudFilters();
        CRUD::addColumn([
            'name' => 'username',
            'type' => 'text',
            'label' => 'Username',
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
            'attributes' => [
                'required' => true
            ],                                             
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
        CRUD::addColumn([
            'name' => 'credit',
            'type' => 'number',
            'label' => 'Credit'
        ]);
        CRUD::addColumn([
            'name' => 'limit-uptime',
            'type' => 'number',
            'label' => 'Limit-uptime'
        ]);
        CRUD::addColumn([
            'name' => 'limit-bytes',
            'type' => 'number',
            'label' => 'Limit-bytes'
        ]);
        CRUD::addColumn([
            'name' => 'ip',
            'type' => 'text',
            'label' => 'IP'
        ]);
        CRUD::addColumn([
            'name' => 'mac',
            'type' => 'text',
            'label' => 'Mac'
        ]); 
        CRUD::addColumn([
            'name' => 'cookie',
            'type' => 'text',
            'label' => 'Cookie'
        ]);                                                     
        // CRUD::addColumn([
        //     'name' => 'voucher',
        //     'type' => 'checkbox',
        //     'label' => 'Voucher'
        // ]);
        
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

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClientRequest::class);
        CRUD::addField([
            'name' => 'comment',
            'type' => 'textarea',
            'label' => ' Comment (optional)'
        ]);  
        CRUD::addField([
            'label' => 'Account',
            'name' => 'account',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                0 => 'voucher',
                1 => 'membership'
            ],
            'hide_when' => [
                0 => ['password'],
                ],
            'default' => 0
        ]);
 
        CRUD::addField([
            'name' => 'username',
            'type' => 'text',
            'label' => "<span style='color:red'>* </span> Username",
            'default' => $this->generateRandomString("5"),
            'hint' => 'Unique hotspot usename, must be in length 6 or more',
            'attributes' => [
                'placeholder' => 'Username code',
                'required' => true,
                'maxlength' => 32,
                'minlength' => 6
              ],                                      
           ]);
           
        CRUD::addField([   // view
            'name' => 'password',
            'type' => 'text',
            'label' => 'Password',
            'default' => $this->generateRandomString("5"),
            'hint' => 'Set this for membership or none for voucher',
        ]);      
        
       CRUD::addField([
            'name' => 'clientprofile_id',
            'type' => 'select',
            'label' => "<span style='color:red'>* </span> Profile",
            'hint' => 'Choose Hotspot profile created from Hotspot Profile page.',
            'entity' => 'clientprofile',
            'attribute' => 'name',                                 
           ]); 
       CRUD::addField([
            'name' => 'limit-uptime',
            'type' => 'number',
            'label' => "<span style='color:red'>* </span> Limit-uptime (s)",
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
            'label' => "<span style='color:red'>* </span> Limit-bytes (MB)",
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
            'label' => '<span style="color:red">* </span> Credit',
            'hint' => 'Credit points or monetary value',
            'default' => 5,
            'attributes' => [
                'min' => 1
            ]
        ]);
                   
        //CRUD::setFromDb(); // all fields                                
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

    public function store()
    {   
        $account = $this->crud->getRequest()->get('account');
        if($account == 0){
            $reference_number = IdGenerator::generate(['table' => 'ordernumbers','field'=>'reference_number', 'length' => 7, 'prefix' => date('ym')]);
            $batch_create = Ordernumber::create([
                'reference_number' => $reference_number
            ]);
            if($batch_create){
                \Alert::add('success', 'Order '.$reference_number.' created')->flash();           
                $batch_id = Ordernumber::where('reference_number', $reference_number)->pluck('id')->first();
                if($batch_id){
                    $voucher_create = Voucher::create([
                        'name' =>  $this->crud->getRequest()->get('username'),
                        'credit' =>  $this->crud->getRequest()->get('credit'),
                        'limit-uptime' =>  $this->crud->getRequest()->get('limit-uptime'),
                        'limit-bytes' =>  $this->crud->getRequest()->get('limit-bytes'),
                        'clientprofile_id' => $this->crud->getRequest()->get('clientprofile_id'),
                        'created_by' => Auth::user()->name,
                        'created_from' => 'admin', 
                        'ordernumber_id'=> $batch_id
                        ]);
                    if($voucher_create){
                        \Alert::add('success', 'Voucher '.$this->crud->getRequest()->get('username').' created')->flash(); 
                    }
                } else {
                    \Alert::add('error', 'Order Id not found')->flash();
                    return redirect()->back()->withInput();
                }            
            } else {
                \Alert::add('error', 'Order not created')->flash();
                return redirect()->back()->withInput();            
            }
        }
        $response = $this->traitStore();
        // do something after save
        return $response;  
    }


    protected function addCustomCrudFilters()
    {
        CRUD::filter('text_username')
                ->type('text')
                ->label('Username')
                ->whenActive(function ($value) {
                    CRUD::addClause('where', 'username', 'LIKE', "%$value%");
                });
        CRUD::addfilter([
           'name' => 'clientprofile_id',
           'type' => 'select2',
           'label' => 'Profile'
        ], function(){
            return \App\Models\Clientprofile::all()->pluck('name', 'id')->toArray();
        }, function($value){
            CRUD::addClause('where', 'clientprofile_id', 'LIKE', "%$value%");
        });
        CRUD::addfilter([
            'name' => 'text_status',
            'type' => 'dropdown',
            'label' => 'Status'
            ],[
                'active' => 'active',
                'unused' => 'unused',
                'paused' => 'paused'
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

    public function bulkExport() 
    {
        $this->crud->hasAccessOrFail('create');

        $entries = request()->input('entries');
        $clonedEntries = [];

        foreach ($entries as $key => $id) {
            if ($entry = $this->crud->model->find($id)) {
                $clonedEntries[] = $entry;
            }
        }        

        return $clonedEntries;
    }

//   laravel system information 

    protected $linfoSettings = [
        'show' => [
            'kernel' => true,
            'os' => true,
            'ram' => true,
            'mounts' => true,
            'webservice' => true,
            'phpversion' => true,
            'uptime' => true,
            'cpu' => true,
            'distro' => true,
            'model' => true,
            'virtualization' => true,

            'duplicate_mounts' => false,
            'mounts_options' => false,
        ],
    ];

    /**
     * Get CPU string.
     *
     * @access protected
     * @param  array  $cpus (default: array())
     * @return string
     */
    protected function getCPUString($cpus = [])
    {
        if (empty($cpus)) {
            return  '';
        }

        $cpuStrings = [];

        foreach ($cpus as $cpu) {
            $model = $cpu['Model'];
            $model = str_replace('(R)', '®', $model);
            $model = str_replace('(TM)', '™', $model);
            array_push($cpuStrings, $model);
        }

        $cpuStrings = array_unique($cpuStrings);

        return trim(implode(' / ', $cpuStrings));
    }

    /**
     * Get disk space string.
     *
     * @access protected
     * @param  array  $mounts (default: array())
     * @return string
     */
    protected function getDiskSpace($mounts = [])
    {
        $total = $free = 0;

        if (empty($mounts)) {
            return compact('total', 'free');
        }

        foreach ($mounts as $mount) {
            $total += $mount['size'];
            $free += $mount['free'];
        }

        return compact('total', 'free');
    }

    /**
     * Get Distro string.
     *
     * @access protected
     * @param  array  $distro (default: array())
     * @return string
     */

    protected function getDistroString($distro = [])
    {
        if (! empty($distro)) {
            return implode(' ', array_values($distro));
        }

        return '';
    }

    private function ifExists($object)
    {
        return ! empty($object) ? $object : null;
    }

    public function bulkGenerate()
    {
        //echo Setting::get('contact_email'); // settings test
        /******* firewalling test ******/
        $command = new Command(Table::TABLE_MANGLE);
        $cmd = $command->setSource('10.0.0.1')
        //->setOptions('test data asdsad asdasd')
        ->setDestination('10.0.0.2')
        ->replaceRule('INPUT', 1);
        //dd($cmd);
        /******* configurator test ******/
        // chilli config 
        // note: changes settings on wlan0 folder instead
        $conf = Config::load(__DIR__ . '/config/chilli0.properties');
        $wan_interface = $conf->get('HS_WANIF');
        $lan_interface = $conf->get('HS_LANIF');
        $uam_format = $conf->get('HS_UAMFORMAT');
        $uam_homepage = $conf->get('HS_UAMHOMEPAGE');
        #$conf['HS_UAMFORMAT'] = str_replace("$","\\",$uam_format);
        #$conf['HS_UAMHOMEPAGE'] = str_replace("$","\\",$uam_format);
        $conf['HS_LANIF'] = 'wlan0';

        $conf->toFile(__DIR__ . '/config/chilli1.properties');
        
        // pppd ppp-server-options iface, local, remote changeable
        $conf_ppp = Config::load(__DIR__ . '/config/ppp0.properties');
        $conf_ppp['command'] = 'pppoe-server -C isp -L 192.168.1.1 -R 192.168.1.10 -N 250 -p /etc/ppp/allip -I wlan0';
        $conf_ppp->toFile(__DIR__ . '/config/ppp1.properties');
        
        // supervisor wifi-fix.conf changeable ap name startup
        $conf_ap = Config::load(__DIR__ . '/config/ap0.ini');
        $conf_ap['program:start_ap.command'] = 'nmcli con up My-Hotspot';
        $conf_ap->toFile(__DIR__ . '/config/ap1.ini');        

        
        /******* laravel system information *********/
        $linfo = new Linfo;
        $linfo->__construct($this->linfoSettings);
        $parser = $linfo->getParser();
        $os = $this->ifExists($parser->getOS());
        $kernel = $this->ifExists($parser->getKernel());
        $arc = $this->ifExists($parser->getCPUArchitecture());
        $webserver = $this->ifExists($parser->getWebService());
        $php = $this->ifExists($parser->getPhpVersion());
        $CPUs = $this->ifExists($parser->getCPU());
        $cpu = $this->getCPUString($CPUs);
        $cpu_count = count($CPUs);

        $model = $this->ifExists($parser->getModel());

        $memory = $this->ifExists($parser->getRam());
        $ram = [
            'total' => (int) $this->ifExists($memory['total']),
            'free' => (int) $this->ifExists($memory['free']),
        ];

        $swap = [
            'total' => (int) $this->ifExists($memory['swapTotal']),
            'free' => (int) $this->ifExists($memory['swapFree']),
        ];
        
        $disk = $this->getDiskSpace($parser->getMounts());

        $distro = '';
        if (method_exists($parser, 'getDistro')) {
            $distro = $this->getDistroString(
                $this->ifExists($parser->getDistro())
            );
        }

        $uptime = $booted_at = null;

        $systemUptime = $this->ifExists($parser->getUpTime());

        if (! empty($systemUptime['text'])) {
            $uptime = $systemUptime['text'];
        }

        if (! empty($systemUptime['bootedTimestamp'])) {
            $booted_at = date('Y-m-d H:i:s', $systemUptime['bootedTimestamp']);
        }

        $results['server']['information'] = compact(
            'os', 'distro', 'kernel', 'arc', 'webserver', 'php', 'cpu', 'cpu_count', 'model', 'swap', 'ram', 'disk', 'uptime', 'booted_at'
        );       
        
        //********** messagepack sample **********
        $packed = MessagePack::pack($results);

        return $results;
    }
}
