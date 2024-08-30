@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Edit Client")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white">Edit Client</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="customer_form" action="{{ url("admin/edit_customer/" . Request()->segment(3)) }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="customer_name" value="{{ $customer->customer_name }}"
                      placeholder="Enter Name" autocomplete="off">
                    @if ($errors->has("customer_name"))
                      <small style="color: red">{{ $errors->first("customer_name") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="customer_address"
                      value="{{ $customer->customer_address }}" placeholder="Enter Address" autocomplete="off">
                    @if ($errors->has("customer_address"))
                      <small style="color: red">{{ $errors->first("customer_address") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Contact Person</label>
                    <input type="text" class="form-control" name="customer_person"
                      value="{{ $customer->customer_person }}" placeholder="Enter Contact Person" autocomplete="off">
                    @if ($errors->has("customer_person"))
                      <small style="color: red">{{ $errors->first("customer_person") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="customer_email"
                      value="{{ $customer->customer_email }}" placeholder="Enter Email" autocomplete="off">
                    @if ($errors->has("customer_email"))
                      <small style="color: red">{{ $errors->first("customer_email") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="customer_phone"
                      value="{{ $customer->customer_phone }}" placeholder="Enter Phone" autocomplete="off">
                    @if ($errors->has("customer_phone"))
                      <small style="color: red">{{ $errors->first("customer_phone") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Comments</label>
                    <textarea class="form-control" name="customer_comments" placeholder="Enter Comments" autocomplete="off">{{ $customer->customer_comments }}</textarea>
                    @if ($errors->has("customer_comments"))
                      <small style="color: red">{{ $errors->first("customer_comments") }}</small>
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
      </div>
    </div>
  </section>
@endsection
