@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', 'Toppings')
{{-- vendor style --}}
@section('vendor-styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
@endsection
{{-- page style --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-invoice.css') }}">
@endsection

@section('content')



    <section class="invoice-list-wrapper">
        <section>
            @if (session('success'))
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
        <div class="row err-div" style="display: none">
            <div class="col-12">
                <div class="alert alert-danger mb-2" role="alert">
                    <span class="err-text"></span>
                </div>
            </div>
        </div>
        <!-- add topping button-->
        <button type="button" class="btn btn-primary glow invoice-create topping-modal-btn" data-toggle="modal"
            data-target="#inlineForm">Add
            New Topping</button>
        <!-- exit edit -->
        <button type="button" class="btn btn-warning finish-edit-btn" style="display: none">Exit Edit</button>
        <!--add topping form Modal -->
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add New Topping</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form action="{{ asset('add-new-topping') }}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <label for="top_name">Topping Name: </label>
                            <div class="form-group">
                                <input type="text" name="top_name" id="top_name" placeholder="Topping Name"
                                    class="form-control">
                            </div>

                            <label for="top_price">Topping Price: </label>
                            <div class="form-group">
                                <input type="number" name="top_price" id="top_price" placeholder="Topping Price"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive pt-1 topping-view-body">
            <table class="table invoice-data-table dt-responsive nowrap" id="toppings-table" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>
                            <span class="align-middle">#</span>
                        </th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($toppings as $top)
                        <tr>
                            <td></td>
                            <td>{{ $top->id }}</td>
                            <td>{{ $top->topping_name }}</td>
                            <td>{{ $top->topping_price }}</td>
                            <td>
                                {{-- href="{{asset('edit-topping/'.$top->id)}}" --}}
                                @if (is_null($top->deleted_at))
                                    <a type="button" id="edit-btn"><i class='bx bx-edit-alt'></i></a>
                                    <a href="{{ asset('delete-topping/' . $top->id) }}"><i class='bx bx-x'></i></a>
                                @else
                                    <a href="{{ asset('enable-topping/' . $top->id) }}"
                                        class='btn btn-info glow invoice-create' role='button'
                                        aria-pressed='true'>Return</a>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="table-responsive pt-1 topping-edit-body" style="display: none">
            <table class="table invoice-data-table dt-responsive nowrap" id="toppings-table" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>
                            <span class="align-middle">#</span>
                        </th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($toppings as $top)
                        <tr>
                            <td></td>
                            <td>{{ $top->id }}</td>
                            <td>
                                <input type="text" id="top_edit_name_{{ $top->id }}" placeholder="Topping Name"
                                    class="form-control" value="{{ $top->topping_name }}">
                            </td>
                            <td><input type="number" id="top_edit_price_{{ $top->id }}" placeholder="Topping Price"
                                    class="form-control" value="{{ $top->topping_price }}"></td>
                            <td>
                                {{-- href="{{asset('edit-topping/'.$top->id)}}" --}}
                                <button type="button" class="btn btn-success update_edit"
                                    id="update_edit_{{ $top->id }}" data-id="{{ $top->id }}">Update</button>
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
    <script src="{{ asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
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
            $('.topping-edit-body').css('display', 'none');
        });
        $("body").on('click', '#edit-btn', function() {
            $('.topping-modal-btn').css('display', 'none');
            $('.finish-edit-btn').css('display', 'block');
            $('.topping-edit-body').css('display', 'block');
            $('.topping-view-body').css('display', 'none');
        });
        $("body").on('click', '.finish-edit-btn', function() {
            $('.topping-modal-btn').css('display', 'block');
            $('.finish-edit-btn').css('display', 'none');
            $('.topping-edit-body').css('display', 'none');
            $('.topping-view-body').css('display', 'block');
        });

        $("body").on('click', '.update_edit', function(e) {
            var top_id = $(this).data('id');
            var new_top_name = $('#top_edit_name_' + top_id).val();
            var new_top_price = $('#top_edit_price_' + top_id).val();
            jQuery.ajax({
                url: "{{ asset('/edit-topping') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    top_id: top_id,
                    new_top_name: new_top_name,
                    new_top_price: new_top_price
                },
                success: function(result) {
                    if (result.status == "success") {
                        window.location.reload();
                    } else {
                        $('.err-div').css('display', 'block');
                        $('.err-text').text(result.msg)
                    }
                    console.log(result);
                }
            });
        });
    </script>
@endsection
