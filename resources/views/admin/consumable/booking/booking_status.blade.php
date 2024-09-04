<div class="modal-header">
  {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
  <h4 class="modal-title">Status</h4>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ url("admin/add_booking_status") }}" method="post">
  @csrf
  <input type="hidden" name="booking_id" value="{{ $booking->booking_id }}">
  <div class="modal-body">
    <div class="form-group">
      <label for="status">Status</label>
      <select name="status" id="status" class="form-control selectbox" style="width: 100%;">
        <option value="">Select</option>
        <option value="1" {{ $booking->booking_status == 1 ? "selected" : "" }}>Pending</option>
        <option value="2" {{ $booking->booking_status == 2 ? "selected" : "" }}>Cancelled</option>
        <option value="3" {{ $booking->booking_status == 3 ? "selected" : "" }}>Incomplete</option>
        <option value="4" {{ $booking->booking_status == 4 ? "selected" : "" }}>Report Pending</option>
        <option value="5" {{ $booking->booking_status == 5 ? "selected" : "" }}>Completed</option>
        <option value="6" {{ $booking->booking_status == 6 ? "selected" : "" }}>Rescheduled </option>
        <option value="7" {{ $booking->booking_status == 7 ? "selected" : "" }}>Client Postponded</option>
        <option value="8" {{ $booking->booking_status == 8 ? "selected" : "" }}>Invoiced</option>
      </select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" name="submit" class="btn btn-primary" value="submit">Submit</button>
  </div>
</form>
<script>
  $('.selectbox').select2({
    theme: "bootstrap",
    placeholder: "Select"
  });
</script>
