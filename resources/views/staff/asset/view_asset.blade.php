@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | View Asset")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white">Assets</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12 col-md-4">
        <div class="card">
          @if (!empty($asset->asset_image))
            <div class="card-header"
              style="background-image: url({{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_image) }});height:200px"">
            @else
              <div class="card-header"
                style="background-image: url({{ asset(config("constants.admin_path") . "dist/img/no_image.jpeg") }});height:200px"">
          @endif
          {{-- <div class="card-header-headshot" ></div> --}}
        </div>
        <div class="card-content">
          <div class="card-content-member text-center">
            <h4 class="m-t-2">{{ $asset->asset_name }}</h4>
            <p class="m-t-0">Asset No : {{ $asset->asset_id }}</p>
          </div>
          <div class="card-content-languages">
            <div class="card-content-languages-group">
              <div>
                <h4 style="width: 100px">Method</h4>
              </div>
              <div>
                <ul>
                  <li>{{ $asset->activity_name }}</li>
                </ul>
              </div>
            </div>
            <div class="card-content-languages-group">
              <div>
                <h4 style="width: 100px">Location</h4>
              </div>
              <div>
                <ul>
                  <li>{{ $asset->location_name }}</li>
                </ul>
              </div>
            </div>
            <div class="card-content-languages-group">
              <div>
                <h4 style="width: 100px">Department</h4>
              </div>
              <div>
                <ul>
                  <li>{{ $asset->department_name }}</li>
                </ul>
              </div>
            </div>
            <div class="card-content-languages-group">
              <div>
                <h4 style="width: 100px">Condition</h4>
              </div>
              <div>
                <ul>
                  @if ($asset->asset_condition == 1)
                    Inservice
                  @elseif($asset->asset_condition == 2)
                    Out of service
                  @elseif($asset->asset_condition == 3)
                    Maintenance
                  @elseif($asset->asset_condition == 4)
                    Calibration out
                  @elseif($asset->asset_condition == 5)
                    Repair
                  @elseif($asset->asset_condition == 6)
                    Send for repair
                  @endif
                </ul>
              </div>
            </div>
            <div class="card-content-languages-group">
              <div>
                <h4 style="width: 100px">Manufacture</h4>
              </div>
              <div>
                <ul>
                  <li>{{ $asset->asset_manufacture }}</li>
                </ul>
              </div>
            </div>
            <div class="card-content-languages-group">
              <div>
                <h4 style="width: 100px">Model</h4>
              </div>
              <div>
                <ul>
                  <li>{{ $asset->asset_model }}</li>
                </ul>
              </div>
            </div>
            <div class="card-content-languages-group">
              <div>
                <h4 style="width: 100px">Serial No</h4>
              </div>
              <div>
                <ul>
                  <li>{{ $asset->asset_serial_no }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-8">
      <div class="review-block">
        <div class="row">
          <div class="col-sm-12">
            <div class="review-block-title">Calibration Required</div>
            @if ($asset->asset_crequired == 1)
              <div class="review-block-description">Yes</div>
            @else
              <div class="review-block-description">No</div>
            @endif
          </div>
        </div>
        <hr />
        @if ($asset->asset_crequired == 1)
          <div class="row">
            <div class="col-sm-12">
              <div class="review-block-title">Calibration Date</div>
              <div class="review-block-description">{{ date("d M Y", strtotime($asset->asset_cdate)) }}</div>
            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col-sm-12">
              <div class="review-block-title">Calibration Frequency (in month)</div>
              <div class="review-block-description">{{ $asset->asset_cfrequency }}</div>
            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col-sm-12">
              <div class="review-block-title">Calibration Due Date</div>
              <div class="review-block-description">{{ date("d M Y", strtotime($asset->asset_cdue_date)) }}</div>
            </div>
          </div>
          <hr />
        @endif
        <div class="row">
          <div class="col-sm-12">
            <div class="review-block-title">Accessory Included</div>
            @if ($asset->asset_accessory_include == 1)
              <div class="review-block-description">Yes</div>
            @else
              <div class="review-block-description">No</div>
            @endif
          </div>
        </div>
        <hr />
        @if ($asset->asset_accessory_include == 1)
          @php $accessory_details = json_decode($asset->asset_accessory_details,true); @endphp
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Accessory</th>
                    <th>Model</th>
                    <th>Serial No</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($accessory_details["NAME"] as $key => $accessory_detail)
                    <tr>
                      <td>{{ $accessory_details["NAME"][$key] }}</td>
                      <td>{{ $accessory_details["MODEL"][$key] }}</td>
                      <td>{{ $accessory_details["SERIAL"][$key] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <hr />
        @endif
        <div class="row">
          <div class="col-sm-12">
            <div class="review-block-title">Packing List/Delivery Note</div>
            <div class="review-block-description">
              @if (!empty($asset->asset_packing_file))
                <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_packing_file) }}"
                  target="_blank">Click Here</a> to View Document
              @else
                -
              @endif
            </div>
          </div>
        </div>
        <hr />
        @if ($asset->asset_crequired == 1)
          <div class="row">
            <div class="col-sm-12">
              <div class="review-block-title">Manufacture Calibration</div>
              <div class="review-block-description">
                @if (!empty($asset->asset_manufacture_file))
                  <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_manufacture_file) }}"
                    target="_blank">Click Here</a> to View Document
                @else
                  -
                @endif
              </div>
            </div>
          </div>
          <hr />
        @endif
        <div class="row">
          <div class="col-sm-12">
            <div class="review-block-title">User Manual</div>
            <div class="review-block-description">
              @if (!empty($asset->asset_manual_file))
                <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_manual_file) }}"
                  target="_blank">Click Here</a> to View Document
              @else
                -
              @endif
            </div>
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-sm-12">
            <div class="review-block-title">Supporting Files</div>
            <div class="review-block-description">
              @if (!empty($asset->asset_supporting_file))
                <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_supporting_file) }}"
                  target="_blank">Click Here</a> to View Document
              @else
                -
              @endif
            </div>
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-sm-12">
            <div class="review-block-title">Photographs</div>
            <div class="review-block-description">
              @if (!empty($asset->asset_photographs_file))
                @php $photographs_files = json_decode($asset->asset_photographs_file,true); @endphp
                @foreach ($photographs_files as $photographs_file)
                  <div>
                    <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $photographs_file) }}"
                      target="_blank">Click Here</a> to View Document
                  </div>
                @endforeach
              @else
                -
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
@endsection
