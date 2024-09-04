@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Calendar")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white">Calendar</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="card panel-bd">
          <div class="card-body">
            <div id='calendar'></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div id="bookingDetailModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
      </div>
    </div>
  </div>
@endsection
@section("custom_script")
  <script>
    $(document).ready(function() {

      var SITEURL = "{{ url("/") }}";

      var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: SITEURL + "/admin/calendar",
        displayEventTime: true,
        editable: false,
        timeFormat: 'H:mm',
        eventRender: function(event, element, view) {
          event.allDay = event.allDay === 'true';
        },
        selectable: false,
        eventClick: function(event, jsEvent) {
          var clickTimeout;
          var booking_id = event.id;
          var csrf = "{{ csrf_token() }}";

          // Custom double-click detection
          if (jsEvent.detail === 1) { // Single click
            clickTimeout = setTimeout(function() {
              $.ajax({
                url: "{{ url("admin/booking_detail") }}",
                type: "post",
                data: {
                  booking_id: booking_id,
                  _token: csrf
                },
                success: function(data) {
                  $(".modal-content").html(data);
                  $('#bookingDetailModal').modal('show');
                }
              });
            }, 200); // 200ms delay to differentiate between single and double click
          } else if (jsEvent.detail === 2) { // Double click
            clearTimeout(clickTimeout);
            window.location = "/admin/view_booking/" + booking_id
          }
        }
      });
    });
  </script>

@endsection
