@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Edit Supplier")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Edit Supplier</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="leave_form" action="{{ url("admin/edit_supplier/" . $supplier->id) }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Supplier Name</label>
                    <input type="text" class="form-control" name="supplier_name" value="{{ $supplier->supplier_name }}"
                      placeholder="Enter Supplier Name" autocomplete="off">
                    @if ($errors->has("supplier_name"))
                      <small style="color: red">{{ $errors->first("supplier_name") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $supplier->email }}"
                      placeholder="Enter Email" autocomplete="off">
                    @if ($errors->has("email"))
                      <small style="color: red">{{ $errors->first("email") }}</small>
                    @endif
                  </div>
                </div>
                
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" value="{{ $supplier->address }}"
                      placeholder="Enter Address" autocomplete="off">
                    @if ($errors->has("address"))
                      <small style="color: red">{{ $errors->first("address") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">State</label>
                    <input type="text" class="form-control" name="state" value="{{ $supplier->state }}"
                      placeholder="Enter State Name" autocomplete="off">
                    @if ($errors->has("state"))
                      <small style="color: red">{{ $errors->first("state") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Country</label>
                    <input type="text" class="form-control" name="county" value="{{ $supplier->county }}"
                      placeholder="Enter Country Name" autocomplete="off">
                    @if ($errors->has("country"))
                      <small style="color: red">{{ $errors->first("country") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Postal Code</label>
                    <input type="number" class="form-control" name="post_code" value="{{ $supplier->post_code }}"
                      placeholder="Enter Postal Code" autocomplete="off">
                    @if ($errors->has("post_code"))
                      <small style="color: red">{{ $errors->first("post_code") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="number" class="form-control" name="phone" value="{{ $supplier->phone }}"
                      placeholder="Enter Phone Number" autocomplete="off">
                    @if ($errors->has("phone"))
                      <small style="color: red">{{ $errors->first("phone") }}</small>
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
@section("custom_script")
@endsection
