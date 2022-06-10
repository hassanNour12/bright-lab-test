@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', 'Customers List')
{{-- vendor style --}}
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/dataTables.checkboxes.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
@endsection
{{-- page style --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-invoice.css') }}">
@endsection

@section('content')



    <section class="invoice-list-wrapper">
        <!-- create invoice button-->
        <div class="invoice-create-btn mb-1">
            <a href="{{ route('add-customer-view') }}" class="btn btn-primary glow invoice-create" role="button"
                aria-pressed="true">Add Customer</a>
        </div>

        <div class="table-responsive">
            <table class="table invoice-data-table dt-responsive nowrap customers-table" id="customers-table" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>
                            <span class="align-middle">#</span>
                        </th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Reg. Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </section>







@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
    <script src="{{ asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/responsive.bootstrap4.min.js') }}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
    <script src="{{ asset('js/scripts/pages/app-invoice.js') }}"></script>

    <script>
        $(document).ready(function() {

            // DataTable
            // var table = $('#customers-table').DataTable();
            
            // table.destroy();

            // $('#customers-table').addClass('table');
            // $('#customers-table').addClass('invoice-data-table');
            // $('#customers-table').addClass('dt-responsive');
            // $('#customers-table').addClass('nowrap');

            $('#customers-table').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                order: [[2, 'asc']],
                ajax: "{{ route('get-customers') }}",
                columns: [
                    {
                        data: 'ch1'
                    },
                    {
                        data: 'ch2'
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'fname'
                    },
                    {
                        data: 'lname'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'reg_at'
                    },
                    {
                        data: 'action'
                    },
                ]
            });
        });
    </script>
@endsection
