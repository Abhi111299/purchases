<li class="nav-item">
  <a class="nav-link @if (Request()->segment(2) == "trip_logs") active @endif"
    href="{{ url("admin/trip_logs/" . Request()->segment(3)) }}" style="cursor: pointer;">Trip Log</a>
</li>
<li class="nav-item">
  <a class="nav-link @if (Request()->segment(2) == "fuel_logs") active @endif"
    href="{{ url("admin/fuel_logs/" . Request()->segment(3)) }}" style="cursor: pointer;">Fuel Log</a>
</li>
<li class="nav-item">
  <a class="nav-link @if (Request()->segment(2) == "insurances") active @endif"
    href="{{ url("admin/insurances/" . Request()->segment(3)) }}" style="cursor: pointer;">Insurance</a>
</li>
<li class="nav-item">
  <a class="nav-link @if (Request()->segment(2) == "service_logs") active @endif"
    href="{{ url("admin/service_logs/" . Request()->segment(3)) }}" style="cursor: pointer;">Service
    Log
  </a>
</li>
<li class="nav-item">
  <a class="nav-link @if (Request()->segment(2) == "cleaning_logs") active @endif"
    href="{{ url("admin/cleaning_logs/" . Request()->segment(3)) }}" style="cursor: pointer;">Cleaning
    Log</a>
</li>
<li class="nav-item">
  <a class="nav-link @if (Request()->segment(2) == "repair_logs") active @endif"
    href="{{ url("admin/repair_logs/" . Request()->segment(3)) }}" style="cursor: pointer;">Repair Log
  </a>
</li>
<li class="nav-item">
  <a class="nav-link @if (Request()->segment(2) == "accidents") active @endif"
    href="{{ url("admin/accidents/" . Request()->segment(3)) }}" style="cursor: pointer;">Accident His
    tory</a>
</li>
<li class="nav-item">
  <a class="nav-link @if (Request()->segment(2) == "inspections") active @endif"
    href="{{ url("admin/inspections/" . Request()->segment(3)) }}" style="cursor: pointer;">Inspections
  </a>
</li>
