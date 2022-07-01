<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RadreplyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RadreplyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RadreplyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Radreply::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/radreply');
        CRUD::setEntityNameStrings('radreply', 'radreplies');
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
        CRUD::setValidation(RadreplyRequest::class);

        //CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'username',
            'type' => 'text',
            'label' => 'User Name',
            'attributes' => [
                'required' => true,
                'minlength' => 5,
                'maxlength' => 64
            ]
        ]);
        CRUD::addField([
            'name' => 'attribute',
            'type' => 'select2_from_array',
            'label' => 'Attribute',
            'attributes' => [
                'required' => true,
                'max-length' => 32,
                'min-length' => 4,
            ], 
            'allows_null' => false,
            'options' => [
                'ARAP-Challenge-Response' => 'ARAP-Challenge-Response',
                'ARAP-Features' => 'ARAP-Features',
                'ARAP-Password' => 'ARAP-Password',
                'ARAP-Security' => 'ARAP-Security',
                'ARAP-Security-Data' => 'ARAP-Security-Data',
                'ARAP-Zone-Access' => 'ARAP-Zone-Access',
                'AUTH-Key' => 'AUTH-Key',
                'Access-Accept' => 'Access-Accept',
                'Access-Challenge' => 'Access-Challenge',
                'Access-Period' => 'Access-Period',
                'Access-Reject' => 'Access-Reject',
                'Access-Request' => 'Access-Request',
                'Accounting-Request' => 'Accounting-Request',
                'Accounting-Response' => 'Accounting-Response',
                'Acct-Authentic' => 'Acct-Authentic',
                'Acct-Delay-Time' => 'Acct-Delay-Time',
                'Acct-Input-Gigawords' => 'Acct-Input-Gigawords',
                'Acct-Input-Octets' => 'Acct-Input-Octets',
                'Acct-Input-Packets' => 'Acct-Input-Packets',
                'Acct-Interim-Interval' => 'Acct-Interim-Interval',
                'Acct-Link-Count' => 'Acct-Link-Count',
                'Acct-Multi-Session-Id' => 'Acct-Multi-Session-Id',
                'Acct-Output-Gigawords' => 'Acct-Output-Gigawords',
                'Acct-Output-Octets' => 'Acct-Output-Octets',
                'Acct-Output-Packets' => 'Acct-Output-Packets',
                'Acct-Session-Id' => 'Acct-Session-Id',
                'Acct-Session-Time' => 'Acct-Session-Time',
                'Acct-Status-Type' => 'Acct-Status-Type',
                'Acct-Terminate-Cause' => 'Acct-Terminate-Cause',
                'Acct-Tunnel-Connection' => 'Acct-Tunnel-Connection',
                'Acct-Tunnel-Packets-Lost' => 'Acct-Tunnel-Packets-Lost',
                'Auth-Type' => 'Auth-Type',
                'CHAP-Challenge' => 'CHAP-Challenge',
                'CHAP-Password' => 'CHAP-Password',
                'Callback-Id' => 'Callback-Id',
                'Callback-Number' => 'Callback-Number',
                'Called-Station-Id' => 'Called-Station-Id',
                'Calling-Station-Id' => 'Calling-Station-Id',
                'Change-of-Authorization' => 'Change-of-Authorization',
                'Chargeable-User-Identity' => 'Chargeable-User-Identity',
                'CHAP-Password' => 'CHAP-Password',
                'ChilliSpot-Config' => 'ChilliSpot-Config',
                'ChilliSpot-DHCP-Netmask' => 'ChilliSpot-DHCP-Netmask',
                'ChilliSpot-DHCP-DNS1' => 'ChilliSpot-DHCP-DNS1',
                'ChilliSpot-DHCP-DNS2' => 'ChilliSpot-DHCP-DNS2',
                'ChilliSpot-DHCP-Gateway' => 'ChilliSpot-DHCP-Gateway',
                'ChilliSpot-DHCP-Domain' => 'ChilliSpot-DHCP-Domain',
                'Chillispot-Max-Input-Octets' =>  'Chillispot-Max-Input-Octets',
                'Chillispot-Max-Output-Octets' =>  'Chillispot-Max-Output-Octets',
                'Chillispot-Max-Total-Octets' =>  'Chillispot-Max-Total-Octets',
                'Chillispot-Bandwidth-Max-Up' =>  'Chillispot-Bandwidth-Max-Up',
                'Chillispot-Bandwidth-Max-Down' =>  'Chillispot-Bandwidth-Max-Down',
                'Chillispot-Config' =>  'Chillispot-Config',
                'Chillispot-Lang' =>  'Chillispot-Lang',
                'Chillispot-Version' =>  'Chillispot-Version',
                'Chillispot-UAM-Allowed' =>  'Chillispot-AM-Allowed',
                'Chillispot-MAC-Allowed' =>  'Chillispot-MAC-Allowed',
                'Chillispot-Interval' =>  'Chillispot-Interval',
                'Class' => 'Class',
                'Cleartext-Password' => 'Cleartext-Password',
                'Crypt-Password' => 'Crypt-Password',                
                'Configuration-Token' => 'Configuration-Token',
                'Connect-Info' => 'Connect-Info',
                'DNS-Server-IPv6-Address' => 'DNS-Server-IPv6-Address',
                'DS-Lite' => 'DS-Lite',
                'DS-Lite-Tunnel-Name' => 'DS-Lite-Tunnel-Name',
                'Delegated-IPv6-Prefix' => 'Delegated-IPv6-Prefix',
                'Delegated-IPv6-Prefix-Pool' => 'Delegated-IPv6-Prefix-Pool',
                'Digest-AKA-Auts' => 'Digest-AKA-Auts',
                'Digest-Algorithm' => 'Digest-Algorithm',
                'Digest-Auth-Param' => 'Digest-Auth-Param',
                'Digest-CNonce' => 'Digest-CNonce',
                'Digest-Domain' => 'Digest-Domain',
                'Digest-Entity-Body-Hash' => 'Digest-Entity-Body-Hash',
                'Digest-HA1' => 'Digest-HA1',
                'Digest-Method' => 'Digest-Method',
                'Digest-Nextnonce' => 'Digest-Nextnonce',
                'Digest-Nonce' => 'Digest-Nonce',
                'Digest-Nonce-Count' => 'Digest-Nonce-Count',
                'Digest-Opaque' => 'Digest-Opaque',
                'Digest-Qop' => 'Digest-Qop',
                'Digest-Realm' => 'Digest-Realm',
                'Digest-Response' => 'Digest-Response',
                'Digest-Response-Auth' => 'Digest-Response-Auth',
                'Digest-Stale' => 'Digest-Stale',
                'Digest-URI' => 'Digest-URI',
                'Digest-Username' => 'Digest-Username',
                'EAP-Message' => 'EAP-Message',
                'Error-Cause' => 'Error-Cause',
                'Event-Timestamp' => 'Event-Timestamp',
                'Expire-After' => 'Expire-After',
                'Extended-Type-1' => 'Extended-Type-1',
                'Extended-Type-2' => 'Extended-Type-2',
                'Extended-Type-3' => 'Extended-Type-3',
                'Extended-Type-4' => 'Extended-Type-4',
                'Extended-Vendor-Specific-1' => 'Extended-Vendor-Specific-1',
                'Extended-Vendor-Specific-2' => 'Extended-Vendor-Specific-2',
                'Extended-Vendor-Specific-3' => 'Extended-Vendor-Specific-3',
                'Extended-Vendor-Specific-4' => 'Extended-Vendor-Specific-4',
                'Extended-Vendor-Specific-5' => 'Extended-Vendor-Specific-5',
                'Extended-Vendor-Specific-6' => 'Extended-Vendor-Specific-6',
                'Filter-ID' => 'Filter-ID',
                'Filter-Id' => 'Filter-Id',
                'Framed-AppleTalk-Link' => 'Framed-AppleTalk-Link',
                'Framed-AppleTalk-Network' => 'Framed-AppleTalk-Network',
                'Framed-AppleTalk-Zone' => 'Framed-AppleTalk-Zone',
                'Framed-Compression' => 'Framed-Compression',
                'Framed-IP-Address' => 'Framed-IP-Address',
                'Framed-IP-Netmask' => 'Framed-IP-Netmask',
                'Framed-IPX-Network' => 'Framed-IPX-Network',
                'Framed-IPv6-Address' => 'Framed-IPv6-Address',
                'Framed-IPv6-Pool' => 'Framed-IPv6-Pool',
                'Framed-IPv6-Prefix' => 'Framed-IPv6-Prefix',
                'Framed-IPv6-Route' => 'Framed-IPv6-Route',
                'Framed-Interface-Id' => 'Framed-Interface-Id',
                'Framed-MTU' => 'Framed-MTU',
                'Framed-Management-Protocol' => 'Framed-Management-Protocol',
                'Framed-Pool' => 'Framed-Pool',
                'Framed-Protocol' => 'Framed-Protocol',
                'Framed-Route' => 'Framed-Route',
                'Idle-Timeout' => 'Idle-Timeout',
                'Keep-Alives' => 'Keep-Alives',
                'Login-IP-Host' => 'Login-IP-Host',
                'Login-IPv6-Host' => 'Login-IPv6-Host',
                'Login-LAT-Group' => 'Login-LAT-Group',
                'Login-LAT-Node' => 'Login-LAT-Node',
                'Login-LAT-Port' => 'Login-LAT-Port',
                'Login-LAT-Service' => 'Login-LAT-Service',
                'Login-Service' => 'Login-Service',
                'Login-TCP-Port' => 'Login-TCP-Port',
                'Long-Extended-Type-1' => 'Long-Extended-Type-1',
                'Long-Extended-Type-2' => 'Long-Extended-Type-2',
                'Max-All-Session' => 'Max-All-Session',
                'Message-Authenticator' => 'Message-Authenticator',
                'Mikrotik-Recv-Limit' => 'Mikrotik-Recv-Limit',
                'Mikrotik-Xmit-Limit' => 'Mikrotik-Xmit-Limit',
                'Mikrotik-Group' => 'Mikrotik-Group',
                'Mikrotik-Wireless-Forward' => 'Mikrotik-Wireless-Forward',
                'Mikrotik-Wireless-Skip-Dot1x' => 'Mikrotik-Wireless-Skip-Dot1x',
                'Mikrotik-Wireless-Enc-Algo' => 'Mikrotik-Wireless-Enc-Algo',
                'Mikrotik-Wireless-Enc-Key' => 'Mikrotik-Wireless-Enc-Key',
                'Mikrotik-Rate-Limit' => 'Mikrotik-Rate-Limit',
                'Mikrotik-Realm' => 'Mikrotik-Realm',
                'Mikrotik-Host-IP' => 'Mikrotik-Host-IP',
                'Mikrotik-Mark-Id' => 'Mikrotik-Mark-Id',
                'Mikrotik-Advertise-URL' => 'Mikrotik-Advertise-URL',
                'Mikrotik-Advertise-Interval' => 'Mikrotik-Advertise-Interval',
                'Mikrotik-Recv-Limit-Gigawords' => 'Mikrotik-Recv-Limit-Gigawords',
                'Mikrotik-Xmit-Limit-Gigawords' => 'Mikrotik-Xmit-Limit-Gigawords',
                'MD5-Password' => 'MD5-Password',                
                'MS-ARAP-Challenge' => 'MS-ARAP-Challenge',
                'MS-ARAP-Password-Change-Reason' => 'MS-ARAP-Password-Change-Reason',
                'MS-Acct-Auth-Type' => 'MS-Acct-Auth-Type',
                'MS-Acct-EAP-Type' => 'MS-Acct-EAP-Type',
                'MS-BAP-Usage' => 'MS-BAP-Usage',
                'MS-CHAP-CPW-1' => 'MS-CHAP-CPW-1',
                'MS-CHAP-CPW-2' => 'MS-CHAP-CPW-2',
                'MS-CHAP-Challenge' => 'MS-CHAP-Challenge',
                'MS-CHAP-Domain' => 'MS-CHAP-Domain',
                'MS-CHAP-Error' => 'MS-CHAP-Error',
                'MS-CHAP-LM-Enc-PW' => 'MS-CHAP-LM-Enc-PW',
                'MS-CHAP-MPPE-Keys' => 'MS-CHAP-MPPE-Keys',
                'MS-CHAP-NT-Enc-PW' => 'MS-CHAP-NT-Enc-PW',
                'MS-CHAP-Response' => 'MS-CHAP-Response',
                'MS-CHAP2-CPW' => 'MS-CHAP2-CPW',
                'MS-CHAP2-Response' => 'MS-CHAP2-Response',
                'MS-CHAP2-Success' => 'MS-CHAP2-Success',
                'MS-Filter' => 'MS-Filter',
                'MS-Link-Drop-Time-Limit' => 'MS-Link-Drop-Time-Limit',
                'MS-Link-Utilization-Threshold' => 'MS-Link-Utilization-Threshold',
                'MS-MPPE-Encryption-Policy' => 'MS-MPPE-Encryption-Policy',
                'MS-MPPE-Encryption-Types' => 'MS-MPPE-Encryption-Types',
                'MS-MPPE-Recv-Key' => 'MS-MPPE-Recv-Key',
                'MS-MPPE-Send-Key' => 'MS-MPPE-Send-Key',
                'MS-New-ARAP-Password' => 'MS-New-ARAP-Password',
                'MS-Old-ARAP-Password' => 'MS-Old-ARAP-Password',
                'MS-Primary-DNS-Server' => 'MS-Primary-DNS-Server',
                'MS-Primary-NBNS-Server' => 'MS-Primary-NBNS-Server',
                'MS-RAS-Vendor' => 'MS-RAS-Vendor',
                'MS-RAS-Version' => 'MS-RAS-Version',
                'MS-Secondary-DNS-Server' => 'MS-Secondary-DNS-Server',
                'MS-Secondary-NBNS-Server' => 'MS-Secondary-NBNS-Server',
                'Management-Policy-Id' => 'Management-Policy-Id',
                'Management-Privilege-Level' => 'Management-Privilege-Level',
                'Management-Transport-Protection' => 'Management-Transport-Protection',
                'Message-Authenticator' => 'Message-Authenticator',
                'Mobile-Node-Identifier' => 'Mobile-Node-Identifier',
                'NAS-Filter-Rule' => 'NAS-Filter-Rule',
                'NAS-IP-Address' => 'NAS-IP-Address',                                
                'NAS-IPv6-Address' => 'NAS-IPv6-Address',
                'NAS-Identifier' => 'NAS-Identifier',                                
                'NAS-Port' => 'NAS-Port',
                'NAS-Port-Id' => 'NAS-Port-Id',                                
                'NAS-Port-Type' => 'NAS-Port-Type',
                'PKM-AUTH-Key' => 'PKM-AUTH-Key',                                
                'PKM-CA-Cert' => 'PKM-CA-Cert',
                'PKM-Config-Settings' => 'PKM-Config-Settings',                                
                'PKM-Cryptosuite-List' => 'PKM-Cryptosuite-List',                                
                'PKM-SA-Descriptor' => 'PKM-SA-Descriptor',
                'PKM-SAID' => 'PKM-SAID',                                
                'PKM-SS-Cert' => 'PKM-SS-Cert',                                
                'Password-Retry' => 'Password-Retry',
                'Port-Limit' => 'Port-Limit',                                
                'Proxy-State' => 'Proxy-State',                                
                'Reply-Message' => 'Reply-Message',
                'Route-IPv6-Information' => 'Route-IPv6-Information', 
                'RP-Upstream-Speed-Limit' => 'RP-Upstream-Speed-Limit',
                'RP-Downstream-Speed-Limit' => 'RP-Downstream-Speed-Limit',                               
                'SIP-AOR' => 'SIP-AOR',                                
                'Service-Selection' => 'Service-Selection',
                'Service-Type' => 'Service-Type',                                
                'Session-Timeout' => 'Session-Timeout',      
                'SHA1-Password' => 'SHA1-Password', 
                'Simultaneous-Use' => 'Simultaneous-Use',                      
                'State' => 'State',
                'Stateful-IPv6-Address-Pool' => 'Stateful-IPv6-Address-Pool',                                
                'Termination-Action' => 'Termination-Action',
                'Tunnel-Assignment-ID' => 'Tunnel-Assignment-ID',                                
                'Tunnel-Client-Auth-ID' => 'Tunnel-Client-Auth-ID',
                'Tunnel-Client-Endpoint' => 'Tunnel-Client-Endpoint',                                
                'Tunnel-Link-Reject' => 'Tunnel-Link-Reject',
                'Tunnel-Link-Start' => 'Tunnel-Link-Start',                                
                'Tunnel-Link-Stop' => 'Tunnel-Link-Stop',
                'Tunnel-Medium-Type' => 'Tunnel-Medium-Type',                                
                'Tunnel-Password' => 'Tunnel-Password',
                'Tunnel-Preference' => 'Tunnel-Preference',                                
                'Tunnel-Private-Group-ID' => 'Tunnel-Private-Group-ID',
                'Tunnel-Reject' => 'Tunnel-Reject',                                
                'Tunnel-Server-Auth-ID' => 'Tunnel-Server-Auth-ID',                                
                'Tunnel-Server-Endpoint' => 'Tunnel-Server-Endpoint',                                
                'Tunnel-Start' => 'Tunnel-Start',                                
                'Tunnel-Stop' => 'Tunnel-Stop',                                
                'Tunnel-Type' => 'Tunnel-Type',                                
                'User-Name' => 'User-Name',                                
                'User-Password' => 'User-Password',                        
                'Vendor-Id' => 'Vendor-Id',                                
                'Vendor-Specific' => 'Vendor-Specific',
                'WISPr-Location-ID' => 'WISPr-Location-ID',
                'WISPr-Location-Name' => 'WISPr-Location-Name',
                'WISPr-Logoff-URL' => 'WISPr-Logoff-URL',
                'WISPr-Redirection-URL' => 'WISPr-Redirection-URL',
                'WISPr-Bandwidth-Max-Up' => 'WISPr-Bandwidth-Max-Up',
                'WISPr-Bandwidth-Max-Down' => 'WISPr-Bandwidth-Max-Down',
                'WISPr-Session-Terminate-Time' => 'WISPr-Session-Terminate-Time'                            
            ],
        'default' => 'Reply-Message'
        ]);
        CRUD::addField([
            'name' => 'op',
            'type' => 'select2_from_array',
            'label' => 'Operation',
            'attributes' => [
                'required' => true,
                'max-length' => 2,
            ],
            'allows_null' => false,
            'options' => [
                '=' => '=',
                ':=' => ':=',
                '==' => '==',
                '+=' => '+=',
                '!=' => '!=',
                '>' => '>',
                '>=' => '>=',
                '<' => '<',
                '<=' => '<=',
                '=~' => '=~',
                '!~' => '!~',
                '=*' => '=*',
                '~*' => '~*'
            ],
            'default' => '='
        ]); 
        CRUD::addField([
            'name' => 'value',
            'type' => 'text',
            'label' => 'Value',
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
