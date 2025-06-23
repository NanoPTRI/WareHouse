<style>
    .sidebar-dark-white .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-white .nav-sidebar>.nav-item>.nav-link.active{
        background-color: rgba(0,0,0,.1);
        color: #212529;
    }
    [class*=sidebar-light-] .nav-sidebar>.nav-item>.nav-link.active{
        box-shadow: none;
    }
</style>
<li class="nav-header">Admin</li>
<!-- Nav Item -->
<li class="nav-item ">
    <a href="{{route('admin.index')}}" class="nav-link  {{ Request::is('Admin') ? 'active' : ''}}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item ">
    <a href="{{route('admin.transaction.index')}}" class="nav-link {{ Request::is('Admin/Transaction') ? 'active' : ''}}">
        <i class="nav-icon fas fa-users"></i>
        <p>Transaction</p>
    </a>
</li>
<li class="nav-item ">
    <a href="{{route('admin.transaction.running')}}" class="nav-link {{ Request::is('Admin/Transaction/running*') ? 'active' : ''}}">
        <i class="nav-icon fas fa-users"></i>
        <p>Transaction Running</p>
    </a>
</li>
<li class="nav-item ">
    <a href="{{route('admin.pallet.index')}}" class="nav-link {{ Request::is('Admin/pallet*') ? 'active' : ''}}">
        <i class="nav-icon fas fa-users"></i>
        <p>Pallet</p>
    </a>
</li>
<li class="nav-item ">
    <a href="{{route('admin.user.index')}}" class="nav-link {{ Request::is('Admin/user*') ? 'active' : ''}}">
        <i class="nav-icon fas fa-users"></i>
        <p>User</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('logout')}}" class="nav-link {{ Request::is('Others/Logout*') ? 'active' : ''}}">
        <i class="nav-icon fas fa-share-square"></i>
        <p>Logout</p>
    </a>
</li>
