<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-title">ADMINISTRATION</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>
<!--<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-wrench"></i> Advanced</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon la la-terminal'></i> Logs</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon la la-cog'></i> <span>Settings</span></a></li>
    </ul>
</li> -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-wrench"></i> Hotspot</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('client') }}'><i
                    class='nav-icon la la-user'></i>Clients</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('voucher') }}'><i
                    class='nav-icon la la-question '></i> Vouchers</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('ordernumber') }}'><i
                    class='nav-icon la la-question'></i> Reference</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('clientprofile') }}'><i
                    class='nav-icon la la-cogs'></i> <span>Profiles</span></a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('clientportal') }}'><i
                    class='nav-icon la la-cubes'></i> <span>Portal</span></a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('hotspotconfig') }}'><i
                    class='nav-icon la la-question'></i> Config</a></li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-battery"></i> Charging</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('charge') }}'><i
                    class='nav-icon la la-battery'></i> <span> Clients</span></a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('chargeprofile') }}'><i
                    class='nav-icon la la-cogs'></i> <span> Profile</span></a></li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-street-view"></i> Eloading</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item ml-3'><a class='nav-link font-weight-light'
                href='{{ backpack_url('eloadingprofile') }}'><i class='nav-icon la la-question'></i> Profiles</a>
        </li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light'
                href='{{ backpack_url('eloadingconfig') }}'><i class='nav-icon la la-question'></i> Configs</a></li>
    </ul>
</li>


<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-street-view"></i> PPPoE</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('pppoe') }}"><i
                    class="nav-icon la la-user"></i> <span>Clients</span></a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('pppoeprofile') }}'><i
                    class='nav-icon la la-cogs'></i> <span>Profiles</span></a></li>
        <li class='nav-item ml-3'><a class='nav-link' href='{{ backpack_url('pppoeaccount') }}'><i
                    class='nav-icon la la-question'></i> Accounts</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('pppoeconfig') }}'><i
                    class='nav-icon la la-question'></i> Config</a></li>
    </ul>
</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('satellite') }}"><i class="nav-icon la la-user"></i>
        <span>Satellite</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('pinprofile') }}'><i
            class='nav-icon la la-question'></i> Gpios</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('api_token') }}'><i
            class='nav-icon la la-question'></i> Api Tokens</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('sale') }}'><i class='nav-icon la la-question'></i>
        Sales</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('rate') }}'><i class='nav-icon la la-cubes'></i>
        <span>Global Rate</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('generalconfig') }}'><i
            class='nav-icon la la-question'></i> Generalconfigs</a></li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('user') }}"><i
                    class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('role') }}"><i
                    class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('permission') }}"><i
                    class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon la la-cog'></i>
        <span>Settings</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon la la-terminal'></i>
        Logs</a></li>
<li class="nav-title">MISC</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Radius</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item ml-3'><a class='nav-link' href='{{ backpack_url('na') }}'><i
                    class='nav-icon la la-question'></i>
                Nas</a></li>
        <li class='nav-item ml-3'><a class='nav-link' href='{{ backpack_url('radacct') }}'><i
                    class='nav-icon la la-question'></i>
                Radaccts</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('radcheck') }}'><i
                    class='nav-icon la la-question'></i> Radchecks</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('radgroupcheck') }}'><i
                    class='nav-icon la la-question'></i> Radgroupchecks</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('radgroupreply') }}'><i
                    class='nav-icon la la-question'></i> Radgroupreplies</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('radpostauth') }}'><i
                    class='nav-icon la la-question'></i> Radpostauths</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('radreply') }}'><i
                    class='nav-icon la la-question'></i> Radreplies</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('radusergroup') }}'><i
                    class='nav-icon la la-question'></i> Radusergroups</a></li>
    </ul>
</li>


<li class="nav-title">NETWORK</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('adapter') }}'><i class='nav-icon la la-question'></i>
        Adapters</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('device') }}'><i class='nav-icon la la-wechat'></i>
        <span>Devices</span> <span class="badge badge-warning">New</span></a></li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Interfaces</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('ifacebridge') }}'><i
                    class='nav-icon la la-question'></i> Bridges</a></li>
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('ifacebonding') }}"><i
                    class="nav-icon la la-key"></i> <span>Bonding</span></a></li>
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('ifacevlan') }}"><i
                    class="nav-icon la la-key"></i> <span>Vlan</span></a></li>
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('ifaceethernet') }}"><i
                    class="nav-icon la la-user"></i> <span>Ethernet</span></a></li>
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('ifacewlan') }}"><i
                    class="nav-icon la la-key"></i> <span>Wifi</span></a></li>
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('ifacetun') }}"><i
                    class="nav-icon la la-key"></i> <span>Tun</span></a></li>
        <li class="nav-item ml-3"><a class="nav-link font-weight-light" href="{{ backpack_url('ifaceppp') }}"><i
                    class="nav-icon la la-key"></i> <span>PPP</span></a></li>

    </ul>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Firewall</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('iptablefilter') }}'><i
                    class='nav-icon la la-question'></i> Filter</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('iptablenat') }}'><i
                    class='nav-icon la la-question'></i> Nat</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('iptablemangle') }}'><i
                    class='nav-icon la la-question'></i> Mangle</a></li>
        <li class='nav-item ml-3'><a class='nav-link font-weight-light' href='{{ backpack_url('iptableraw') }}'><i
                    class='nav-icon la la-question'></i> Raw</a></li>
    </ul>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('chat') }}'><i class='nav-icon la la-wechat'></i>
        <span>Queue</span> <span class="badge badge-warning">new</span></a></li>
<li class="nav-title">TOOLS</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}\"><i
            class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<!--<li class='nav-item'><a class='nav-link' href='{{ backpack_url('netwatch') }}'><i class='nav-icon la la-television'></i> Netwatch <span class="badge badge-warning">up</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('remote') }}'><i class='nav-icon la la-random'></i> Remote</a></li> -->
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('chat') }}'><i class='nav-icon la la-wechat'></i>
        <span>Chats</span> <span class="badge badge-warning">new</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('scheduler') }}'><i class='nav-icon la la-clock'></i>
        Scheduler</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('map') }}'><i class='nav-icon la la-map'></i> Maps</a>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('about') }}'><i class='nav-icon la la-question'></i>
        About <span class="badge badge-warning">update</span></a></li>
