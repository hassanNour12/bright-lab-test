@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Orders')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
{{-- <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.checkboxes.css')}}"> --}}
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
@endsection
{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

@section('content')



<section class="invoice-list-wrapper">
    <div class="table-responsive">
      <table class="table invoice-data-table dt-responsive nowrap" id="orders-table" style="width:100%">
        <thead>
          <tr>
            <th></th>
            <th>
              <span class="align-middle">Order#</span>
            </th>
            <th>Customer</th>
            <th>Topping</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Last Status</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $o)
              <tr>
                <td></td>
                <td>
                  <a href="{{asset('view-order/'.$o['id'])}}">{{$o['id']}}</a>
                  
                </td>
                <td>{{$o["customer_name"]}}</td>
                <td>{{$o["topping_name"]}}</td>
                <td>{{$o["topping_qty"]}}</td>
                <td>{{$o["topping_total"]}}</td>
                <td>
                  @if ($o["status"] == "New")
                    <div class="badge badge-pill badge-glow badge-info mr-1 mb-1">{{$o["status"]}}</div>
                  @elseif($o["status"] == "Deleted")
                    <div class="badge badge-pill badge-glow badge-danger mb-1">{{$o["status"]}}</div>
                  @elseif($o["status"] == "Updated")
                    <div class="badge badge-pill badge-glow badge-primary mr-1 mb-1">{{$o["status"]}}</div>
                  @elseif($o["status"] == "Synced")
                    <div class="badge badge-pill badge-glow badge-success mr-1 mb-1">{{$o["status"]}}</div>
                  @else
                    <div class="badge badge-pill badge-glow badge-warning mr-1 mb-1">{{$o["status"]}}</div>
                  @endif
                  
                </td>
                <td>{{$o["date"]}}</td>
                <td>
                  @if ($o["status"] == "Deleted")
                    <a href="{{ asset('enable-order/' . $o['id']) }}"
                      class='btn btn-info glow invoice-create' role='button'
                      aria-pressed='true'>Return</a>
                  @else
                      <a href="{{asset('edit-order/'.$o['id'])}}"><i class='bx bx-edit-alt'></i></a>
                      <a href="{{asset('delete-order/'.$o['id']) }}"><i class='bx bx-x'></i></a>
                  @endif
                  
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>







@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
{{-- <script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script> --}}
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
