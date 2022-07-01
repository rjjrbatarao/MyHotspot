<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('client', 'ClientCrudController');
    Route::post('client/bulk-export', 'ClientCrudController@bulkExport');
    Route::get('client/bulk-generate', 'ClientCrudController@bulkGenerate');
    Route::crud('rate', 'RateCrudController');
    Route::crud('sale', 'SaleCrudController');
    Route::crud('clientprofile', 'ClientprofileCrudController');
    Route::crud('chargeprofile', 'ChargeprofileCrudController');
    Route::crud('pppoeprofile', 'PppoeprofileCrudController');
    Route::crud('charge', 'ChargeCrudController');
    Route::crud('pppoe', 'PppoeCrudController');
    Route::crud('satellite', 'SatelliteCrudController');
    Route::get('satellite/{id}/line-restart', 'SatelliteCrudController@lineRestart');
    Route::get('pppoe/{id}/line-reset', 'PppoeCrudController@lineReset');
    Route::get('pppoe/{id}/line-stop', 'PppoeCrudController@lineStop');
    Route::get('pppoe/{id}/line-enable', 'PppoeCrudController@lineEnable');
    Route::crud('map', 'MapCrudController');
    Route::crud('clientportal', 'ClientportalCrudController');
    Route::crud('about', 'AboutCrudController');
    Route::crud('adapter', 'AdapterCrudController');
    Route::crud('ifacebridge', 'IfacebridgeCrudController');
    Route::crud('ifaceethernet', 'IfaceethernetCrudController');
    Route::crud('ifacevlan', 'IfacevlanCrudController');
    Route::crud('ifacetun', 'IfacetunCrudController');
    Route::crud('ifacewlan', 'IfacewlanCrudController');
    Route::crud('ifacebonding', 'IfacebondingCrudController');
    Route::crud('ifaceppp', 'IfacepppCrudController');
    Route::crud('device', 'DeviceCrudController');
    Route::crud('hotspotconfig', 'HotspotconfigCrudController');
    Route::crud('pppoeconfig', 'PppoeconfigCrudController');
    Route::crud('generalconfig', 'GeneralconfigCrudController');
    Route::crud('iptablefilter', 'IptablefilterCrudController');
    Route::crud('iptablenat', 'IptablenatCrudController');
    Route::crud('iptablemangle', 'IptablemangleCrudController');
    Route::crud('iptableraw', 'IptablerawCrudController');
    Route::crud('api_token', 'Api_tokenCrudController');
    Route::crud('pinprofile', 'PinprofileCrudController');
    Route::crud('na', 'NaCrudController');
    Route::crud('radacct', 'RadacctCrudController');
    Route::crud('radcheck', 'RadcheckCrudController');
    Route::crud('radgroupcheck', 'RadgroupcheckCrudController');
    Route::crud('radgroupreply', 'RadgroupreplyCrudController');
    Route::crud('radpostauth', 'RadpostauthCrudController');
    Route::crud('radreply', 'RadreplyCrudController');
    Route::crud('radusergroup', 'RadusergroupCrudController');
    Route::crud('pppoeaccount', 'PppoeaccountCrudController');
    Route::crud('voucher', 'VoucherCrudController');
    Route::crud('ordernumber', 'OrdernumberCrudController');
    Route::crud('eloadingconfig', 'EloadingconfigCrudController');
    Route::crud('eloadingprofile', 'EloadingprofileCrudController');
}); // this should be the absolute last line of this file