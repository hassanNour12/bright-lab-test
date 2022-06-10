@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','View Customer')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

@section('content')


<section class="invoice-list-wrapper">
    <section id="multiple-column-form">
        <div class="row match-height">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Customer Data</h4>
              </div>
              <div class="card-body">
                <form class="form">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-label-group">
                          <input type="text" id="first-name" class="form-control" placeholder="First Name"
                            name="fname" value="{{$customer->first_name}}" readonly>
                          <label for="first-name">First Name</label>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-label-group">
                          <input type="text" id="last-name" class="form-control" placeholder="Last Name"
                            name="lname" value="{{$customer->last_name}}" readonly>
                          <label for="last-name">Last Name</label>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-label-group">
                          <input type="email" id="email" class="form-control" name="email"
                            placeholder="Email" value="{{$customer->email}}" readonly>
                          <label for="email">Email</label>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-label-group">
                          <input type="text" id="phNumber" class="form-control" name="phNumber"
                            placeholder="Phone Number" value="{{$customer->phone}}" readonly>
                          <label for="phNumber">Phone Number</label>
                        </div>
                      </div>
                      <div class="col-md-12 col-12">
                        <div class="form-label-group">
                          <input type="text" id="address" class="form-control" name="address"
                            placeholder="Address" value="{{$customer->address}}" readonly>
                          <label for="address">Address</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
</section>
@endsection


{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap4.min.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>

<script>
    
</script>
@endsection
