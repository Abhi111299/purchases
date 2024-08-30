<div class="modal-header">
  <h4 class="modal-title">Status</h4>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ url("admin/add_leave_requests_status") }}" method="post">
  @csrf
  <input type="hidden" name="leave_id" value="{{ $leave->leave_id }}">
  <div class="modal-body">
    <div class="form-group">
      <label for="status">Status</label>
      <select name="status" id="status" class="form-control selectbox" style="width: 100%;">
        <option value="">Select</option>
        <option value="1" {{ $leave->leave_status == 1 ? "selected" : "" }}>Pending</option>
        <option value="2" {{ $leave->leave_status == 2 ? "selected" : "" }}>Approved</option>
        <option value="3" {{ $leave->leave_status == 3 ? "selected" : "" }}>Rejected</option>
      </select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" name="submit" class="btn btn-add" value="submit">Submit</button>
  </div>
</form>
<script>
  $('.selectbox').select2({
    theme: "bootstrap",
    placeholder: "Select"
  });
</script>
