<aside class="main-sidebar">
  <div class="sidebar">
    <ul class="sidebar-menu">
      <li @if (isset($set) && $set == "dashboard") class="active" @endif>
        <a href="{{ url("admin/dashboard") }}"><i class="lni lni-home"></i><span>Dashboard</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>
      @if (in_array("1", Request()->modules))
        <li class="treeview @if (isset($set) && ($set == "customers" || $set == "add_customer" || $set == "edit_customer")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-customer"></i><span>Clients</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) && ($set == "customers" || $set == "add_customer" || $set == "edit_customer")) menu-open @endif">
            <li><a href="{{ url("admin/add_customer") }}">Add Client</a></li>
            <li><a href="{{ url("admin/customers") }}">List</a></li>
          </ul>
        </li>
      @endif
      @if (in_array("14", Request()->modules))
        <li class="treeview @if (isset($set) && ($set == "purchase_request" || $set == "add_purchase_request" || $set == "edit_customer")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-customer"></i><span>Procurement</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) && ($set == "customers" || $set == "add_purchase_request" || $set == "edit_customer")) menu-open @endif">
            <li><a href="{{ url("admin/purchase_request") }}">Purchase Request </a></li>
            <li><a href="{{ url("admin/consumables_order") }}">Consumables </a></li>
          </ul>
        </li>
      @endif
      @if (in_array("2", Request()->modules))
        <li class="treeview @if (isset($set) &&
                ($set == "staffs" ||
                    $set == "add_staff" ||
                    $set == "edit_staff" ||
                    $set == "certificates" ||
                    $set == "safety_inductions" ||
                    $set == "safety_licences" ||
                    $set == "timesheets" ||
                    $set == "edit_timesheet" ||
                    $set == "attendances" ||
                    $set == "edit_attendance" ||
                    $set == "leave_requests")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-users"></i><span>Staffs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) &&
                  ($set == "staffs" ||
                      $set == "add_staff" ||
                      $set == "edit_staff" ||
                      $set == "certificates" ||
                      $set == "safety_inductions" ||
                      $set == "safety_licences" ||
                      $set == "timesheets" ||
                      $set == "edit_timesheet" ||
                      $set == "attendances" ||
                      $set == "edit_attendance" ||
                      $set == "leave_requests")) menu-open @endif">
            <li><a href="{{ url("admin/add_staff") }}">Add Staff</a></li>
            <li><a href="{{ url("admin/staffs") }}">Staff List</a></li>
            <li><a href="{{ url("admin/certificates") }}">Certificates</a></li>
            <li><a href="{{ url("admin/safety_inductions") }}">Safety Inductions</a></li>
            <li><a href="{{ url("admin/safety_licences") }}">Safety Licence/Tickets</a></li>
            @if (in_array("12", Request()->modules))
              <li><a href="{{ url("admin/timesheets") }}">Timesheets</a></li>
            @endif
            @if (in_array("13", Request()->modules))
              <li><a href="{{ url("admin/attendances") }}">Attendances</a></li>
            @endif
            @if (in_array("14", Request()->modules))
              <li><a href="{{ url("admin/leave_requests") }}">Leave Requests</a></li>
            @endif
          </ul>
        </li>
      @endif
      @if (in_array("3", Request()->modules))
        <li class="treeview @if (isset($set) && ($set == "services" || $set == "add_service" || $set == "edit_service")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-briefcase-alt"></i><span>Services</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) && ($set == "services" || $set == "add_service" || $set == "edit_service")) menu-open @endif">
            <li><a href="{{ url("admin/add_service") }}">Add Service</a></li>
            <li><a href="{{ url("admin/services") }}">List</a></li>
          </ul>
        </li>
      @endif
      @if (in_array("4", Request()->modules))
        <li class="treeview @if (isset($set) && ($set == "activities" || $set == "add_activity" || $set == "edit_activity")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-hammer"></i><span>Activities</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) && ($set == "activities" || $set == "add_activity" || $set == "edit_activity")) menu-open @endif">
            <li><a href="{{ url("admin/add_activity") }}">Add Activity</a></li>
            <li><a href="{{ url("admin/activities") }}">List</a></li>
          </ul>
        </li>
      @endif
      @if (in_array("5", Request()->modules))
        <li class="treeview @if (isset($set) && ($set == "bookings" || $set == "add_booking" || $set == "edit_booking")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-briefcase"></i><span>Jobs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) && ($set == "bookings" || $set == "add_booking" || $set == "edit_booking")) menu-open @endif">
            <li><a href="{{ url("admin/add_booking") }}">Add Job</a></li>
            <li><a href="{{ url("admin/bookings") }}">List</a></li>
          </ul>
        </li>
      @endif
      @if (in_array("6", Request()->modules))
        <li @if (isset($set) && $set == "calendar") class="active" @endif>
          <a href="{{ url("admin/calendar") }}"><i class="lni lni-calendar"></i><span>Calendar</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
      @endif
      @if (in_array("7", Request()->modules) || in_array("8", Request()->modules))
        <li class="treeview @if (isset($set) && ($set == "assets" || $set == "add_asset")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-invest-monitor"></i><span>Assets</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) && ($set == "assets" || $set == "add_asset")) menu-open @endif">
            @if (in_array("7", Request()->modules))
              <li><a href="{{ url("admin/add_asset") }}">Add Asset</a></li>
            @endif
            @if (in_array("8", Request()->modules))
              <li><a href="{{ url("admin/assets") }}">List</a></li>
            @endif
          </ul>
        </li>
      @endif
      @if (in_array("15", Request()->modules))
        <li class="treeview @if (isset($set) && ($set == "vehicles" || $set == "add_vehicle" || $set == "edit_vehicle")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-car-alt"></i><span>Vehicles</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) && ($set == "vehicles" || $set == "add_vehicle" || $set == "edit_vehicle")) menu-open @endif">
            <li><a href="{{ url("admin/add_vehicle") }}">Add Vehicle</a></li>
            <li><a href="{{ url("admin/vehicles") }}">List</a></li>
          </ul>
        </li>
      @endif
      @if (Auth::guard("admin")->user()->admin_role == 1)
        <li class="treeview @if (isset($set) && ($set == "users" || $set == "add_user" || $set == "edit_user")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-user"></i><span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) && ($set == "users" || $set == "add_user" || $set == "edit_user")) menu-open @endif">
            <li><a href="{{ url("admin/add_user") }}">Add User</a></li>
            <li><a href="{{ url("admin/users") }}">List</a></li>
          </ul>
        </li>
      @endif
      <li class="treeview @if (isset($set) &&
              ($set == "trainings" ||
                  $set == "equipments" ||
                  $set == "consumables" ||
                  $set == "locations" ||
                  $set == "departments" ||
                  $set == "manufacturers" ||
                  $set == "models")) active @endif">
        <a href="javascript:void(0)">
          <i class="lni lni-cog"></i><span>Master</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu @if (isset($set) &&
                ($set == "trainings" ||
                    $set == "equipments" ||
                    $set == "consumables" ||
                    $set == "locations" ||
                    $set == "departments" ||
                    $set == "manufacturers" ||
                    $set == "models")) menu-open @endif">
          <li><a href="{{ url("admin/trainings") }}">Trainings</a></li>
          <li><a href="{{ url("admin/equipments") }}">Equipments</a></li>
          <li><a href="{{ url("admin/consumables") }}">Consumables</a></li>
          <li><a href="{{ url("admin/locations") }}">Locations</a></li>
          <li><a href="{{ url("admin/departments") }}">Departments</a></li>
          <li><a href="{{ url("admin/manufacturers") }}">Manufacturers</a></li>
          <li><a href="{{ url("admin/models") }}">Models</a></li>
          <li><a href="{{ url("admin/supplier") }}">Supplier</a></li>
        </ul>
      </li>
    </ul>
  </div>
</aside>
