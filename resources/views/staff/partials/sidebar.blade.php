<aside class="main-sidebar">
  <div class="sidebar">
    <ul class="sidebar-menu">
      <li @if (isset($set) && $set == "dashboard") class="active" @endif>
        <a href="{{ url("staff/dashboard") }}"><i class="lni lni-home"></i><span>Dashboard</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>
      <li @if (isset($set) && $set == "bookings") class="active" @endif>
        <a href="{{ url("staff/bookings") }}"><i class="fa fa-tasks"></i><span>Jobs</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>
      <li class="treeview @if (isset($set) && ($set == "timesheets" || $set == "add_timesheet" || $set == "edit_timesheet")) active @endif">
        <a href="javascript:void(0)">
          <i class="fa fa-book"></i><span>Timesheets</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu @if (isset($set) && ($set == "timesheets" || $set == "add_timesheet" || $set == "edit_timesheet")) menu-open @endif">
          <li><a href="{{ url("staff/add_timesheet") }}">Add Timesheet</a></li>
          <li><a href="{{ url("staff/timesheets") }}">List</a></li>
        </ul>
      </li>
        <li class="treeview @if (isset($set) && ($set == "purchase_request" || $set == "add_purchase_request" || $set == "edit_customer")) active @endif">
          <a href="javascript:void(0)">
            <i class="lni lni-customer"></i><span>Procurement</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu @if (isset($set) && ($set == "customers" || $set == "add_purchase_request" || $set == "edit_customer")) menu-open @endif">
            <li><a href="{{ url("staff/purchase_request") }}">Purchase Request </a></li>
            <li><a href="{{ url("staff/add_purchase_request") }}">Add Purchase Request </a></li>
          </ul>
        </li>
      <li class="treeview @if (isset($set) && ($set == "attendances" || $set == "add_attendance" || $set == "edit_attendance")) active @endif">
        <a href="javascript:void(0)">
          <i class="fa fa-bell"></i><span>Attendances</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu @if (isset($set) && ($set == "attendances" || $set == "add_attendance" || $set == "edit_attendance")) menu-open @endif">
          <li><a href="{{ url("staff/add_attendance") }}">Add Attendance</a></li>
          <li><a href="{{ url("staff/attendances") }}">List</a></li>
        </ul>
      </li>
      <li class="treeview @if (isset($set) && ($set == "leaves" || $set == "add_leave" || $set == "edit_leave")) active @endif">
        <a href="javascript:void(0)">
          <i class="fa fa-list"></i><span>Leaves</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu @if (isset($set) && ($set == "leaves" || $set == "add_leave" || $set == "edit_leave")) menu-open @endif">
          <li><a href="{{ url("staff/add_leave") }}">Add Leave</a></li>
          <li><a href="{{ url("staff/leaves") }}">List</a></li>
        </ul>
      </li>
      @if (Auth::guard("staff")->user()->staff_role == 1)
        <li @if (isset($set) && $set == "leave_requests") class="active" @endif>
          <a href="{{ url("staff/leave_requests") }}"><i class="fa fa-bitbucket"></i><span>Leave Requests</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
      @endif
      <li @if (isset($set) && $set == "assets") class="active" @endif>
        <a href="{{ url("staff/assets") }}"><i class="fa fa-cubes"></i><span>Assets</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>
    </ul>
  </div>
</aside>
