<style>
    .bg-orange {
        background: linear-gradient(180deg, #ff7e00, #ff4500) !important;
        /* Màu cam Bootstrap */
        color: #ffffff;
        /* Màu chữ trắng */
    }
</style>
<ul class="navbar-nav bg-orange   sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('chart.index')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-tape"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Icego am </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{asset(route('chart.index'))}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bảng điều khiển</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Thanh quản lý</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('checkin')}}" >
            <i class="fa-solid fa-check"></i>
            <span> Check in</span>
        </a>
        

    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('inout.index')}}" >
            <i class="fa-solid fa-eye"></i>
            <span> Số lần checkin</span>
        </a>
        

    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa-solid fa-list-check"></i>
            <span> Quản lý nhân viên</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý thành viên</h6>
                <a class="collapse-item" href="{{ route('staff.index') }}">Danh sách nhân viên</a>
                <a class="collapse-item" href="{{ route('staff.create') }}">Thêm nhân viên</a>

            </div>

          
        </div>
        
    </li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsemebers"
      aria-expanded="true" aria-controls="ccollapsemebers">
      <i class="fa-solid fa-user-group"></i>
      <span>Quản lý hội viên</span>
  </a>
  <div id="collapsemebers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Quản lý hội viên:</h6>
          <a class="collapse-item" href="{{ route('member.index') }}">Danh sách hội viên</a>
          <a class="collapse-item" href="{{ route('member.create') }}">Thêm hội viên</a>

      </div>
  </div>
  
</li>



    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

   

    <!-- Nav Item - Pages Collapse Menu -->


   

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
