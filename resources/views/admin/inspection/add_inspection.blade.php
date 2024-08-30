@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Inspection")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Add Inspection</h4>
      <div>
        <a href="{{ url("admin/inspections/" . Request()->segment(3)) }}" class="btn btn-white">Back</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <form id="inspection_form" action="{{ url("admin/add_inspection/" . Request()->segment(3)) }}" method="post"
          enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Date</label>
                <input type="text" class="form-control" name="inspection_date" id="inspection_date"
                  value="{{ date("d-m-Y") }}" placeholder="Select Date" autocomplete="off">
                @if ($errors->has("inspection_date"))
                  <small style="color: red">{{ $errors->first("inspection_date") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Odometer Reading</label>
                <input type="text" class="form-control" name="inspection_odometer"
                  value="{{ old("inspection_odometer") }}" placeholder="Enter Odometer Reading" autocomplete="off">
                @if ($errors->has("inspection_odometer"))
                  <small style="color: red">{{ $errors->first("inspection_odometer") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Inspected By</label>
                <input type="text" class="form-control" name="inspection_inspected"
                  value="{{ old("inspection_inspected") }}" placeholder="Enter Inspected By" autocomplete="off">
                @if ($errors->has("inspection_inspected"))
                  <small style="color: red">{{ $errors->first("inspection_inspected") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Inspection Frequency</label>
                <input type="text" class="form-control" name="inspection_frequency"
                  value="{{ old("inspection_frequency") }}" placeholder="Enter Inspection Frequency" autocomplete="off">
                @if ($errors->has("inspection_frequency"))
                  <small style="color: red">{{ $errors->first("inspection_frequency") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Next Inspection</label>
                <input type="text" class="form-control" name="inspection_ninspection"
                  value="{{ old("inspection_ninspection") }}" placeholder="Enter Next Inspection" autocomplete="off">
                @if ($errors->has("inspection_ninspection"))
                  <small style="color: red">{{ $errors->first("inspection_ninspection") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="inspection_notes" placeholder="Enter Notes" autocomplete="off">{{ old("inspection_notes") }}</textarea>
                @if ($errors->has("inspection_notes"))
                  <small style="color: red">{{ $errors->first("inspection_notes") }}</small>
                @endif
              </div>
            </div>
          </div>
          <div class="reset-button">
            <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection
@section("custom_script")
  <script>
    $(function() {
      $('#inspection_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
