<div class="modal-header">
  <h4 class="modal-title">Schedule Details</h4>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <table class="table">
    <tbody>
      <tr>
        <th>Service</td>
        <td>{{ $booking->service_name }}</td>
      </tr>
      <tr>
        <th>Client</td>
        <td>{{ $booking->customer_name }}</td>
      </tr>
      <tr>
        <th>Start Date</td>
        <td>{{ date("d M Y h:i A", strtotime($booking->booking_start)) }}</td>
      </tr>
      <tr>
        <th>End Date</td>
        <td>{{ date("d M Y h:i A", strtotime($booking->booking_end)) }}</td>
      </tr>
      <tr>
        <th>Activities</td>
        <td>{{ $activities }}</td>
      </tr>
      <tr>
        <th>Technicians</td>
        <td>{{ $staffs }}</td>
      </tr>
      <tr>
        <th>Location</td>
        <td><a href="{{ $booking->booking_llink }}" target="_blank">{{ $booking->booking_lname }}</a></td>
      </tr>
      <tr>
        <th>Instructions</td>
        <td>{{ $booking->booking_instruction }}</td>
      </tr>
    </tbody>
  </table>
</div>
