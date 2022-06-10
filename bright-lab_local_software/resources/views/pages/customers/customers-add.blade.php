@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Add Customers')
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
    <section>
        @if(session('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success mb-2" role="alert">
                    {{ session('success') }}
                  </div>
            </div>
        </div>
        @elseif(session('failed'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger mb-2" role="alert">
                    {{ session('failed') }}
                  </div>
            </div>
        </div>
        @endif
    </section>
    <section id="multiple-column-form">
        <div class="row match-height">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Customer Data</h4>
              </div>
              <div class="card-body">
                <form class="form" method="POST" action="{{route('add-new-customer')}}">
                    @csrf
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-label-group">
                          <input type="text" id="first-name" class="form-control" placeholder="First Name"
                            name="fname">
                          <label for="first-name">First Name</label>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-label-group">
                          <input type="text" id="last-name" class="form-control" placeholder="Last Name"
                            name="lname">
                          <label for="last-name">Last Name</label>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-label-group">
                          <input type="email" id="email" class="form-control" name="email"
                            placeholder="Email">
                          <label for="email">Email</label>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-label-group">
                          <input type="text" id="phNumber" class="form-control" name="phNumber"
                            placeholder="Phone Number">
                          <label for="phNumber">Phone Number</label>
                        </div>
                      </div>
                      <div class="col-md-12 col-12">
                        <div class="form-label-group">
                          <input type="text" id="address" class="form-control" name="address"
                            placeholder="Address">
                          <label for="address">Address</label>
                        </div>
                      </div>
                      <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                        <button type="reset" class="btn btn-light-secondary">Reset</button>
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
