@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', 'Add Order')
{{-- vendor styles --}}
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
@endsection
{{-- page styles --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-invoice.css') }}">
@endsection

@section('content')
    <!-- View Page -->
    <section class="invoice-edit-wrapper">
        <div class="row">
            <div class="col-xl-9 col-md-8 col-12">
                <div class="card">
                    <div class="card-body pb-0 mx-25">
                        <!-- header section -->
                        <div class="row mx-0">
                            <div class="col-xl-4 col-md-12 d-flex align-items-center pl-0">
                                <h6 class="invoice-number mb-0 mr-75">Order#</h6>
                                <input type="text" class="form-control pt-25 w-50" value="{{ $last_id }}" readonly>
                            </div>
                        </div>
                        <hr>
                        <!-- order address and contact -->
                        <div class="row invoice-info">
                            <div class="col-lg-12 col-md-12 mt-25">
                                <h6 class="invoice-to">Order To</h6>
                                <fieldset class="invoice-address form-group">
                                    <div class="form-group">
                                        <select class="select2 form-control customer_select" name="customer">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    data-address="{{ $customer->address }}"
                                                    data-phone="{{ $customer->phone }}">
                                                    {{ $customer->first_name . ' ' . $customer->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 mt-25">
                                        <fieldset class="invoice-address form-group">
                                            <textarea class="form-control" rows="4" id="customer_address" readonly></textarea>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-6 col-md-12 mt-25">
                                        <fieldset class="invoice-address form-group">
                                            <input type="text" class="form-control" id="customer_phone" readonly>
                                        </fieldset>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="card-body pt-50">
                        <!-- product details table-->
                        <div class="invoice-product-details ">
                            <form class="form" method="POST" action="{{ asset('add-order') }}">
                                @csrf
                                <input type="hidden" name="customer_id" id="customer_id_input">
                                <div class="row mb-50">
                                    <div class="col-3 col-md-3 invoice-item-title">Item</div>
                                    <div class="col-3 col-md-3 invoice-item-title">Cost</div>
                                    <div class="col-3 col-md-3 invoice-item-title text-left">Quantity</div>
                                </div>
                                <div class="invoice-item d-flex border rounded mb-1">
                                    <div class="invoice-item-filed row pt-1 px-2">
                                        <div class="col-12 col-md-4 form-group">
                                            <fieldset class="invoice-address form-group">
                                                <div class="form-group">
                                                    <select class="select2 form-control topping_select" name="topping_id">
                                                        <option value="0" data-price="0" selected>Select Topping</option>
                                                        @foreach ($toppings as $topping)
                                                            <option value="{{ $topping->id }}"
                                                                data-price="{{ $topping->topping_price }}">
                                                                {{ $topping->topping_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-4 col-12 form-group">
                                            <input type="number" class="form-control" placeholder="0" id="topping_price"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 col-12 form-group">
                                            <input type="number" class="form-control" name="topping_qty" id="topping_qty"
                                                placeholder="0">
                                        </div>

                                    </div>
                                </div>

                                <!-- total -->
                                <hr>
                                <div class="invoice-subtotal pt-50">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-7 offset-lg-7 col-12">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                                    <span class="invoice-subtotal-title">Total</span>
                                                    <h6 class="invoice-subtotal-value mb-0" id="order_total"></h6>
                                                </li>
                                                <li class="list-group-item py-0 border-0 mt-25">
                                                    <hr>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- action  -->
                                <div class="invoice-action-btn mb-1">
                                    <button type="submit" class="btn btn-light-primary btn-block">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
    <script src="{{ asset('js/scripts/pages/app-invoice.js') }}"></script>
    <script src="{{ asset('js/scripts/forms/select/form-select2.js') }}"></script>

    <script>
        $('.customer_select').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            console.log($("option:selected", this).data('address'));
            console.log($("option:selected", this).data('phone'));

            $('#customer_id_input').val($("option:selected", this).val())
            $('#customer_address').val($("option:selected", this).data('address'))
            $('#customer_phone').val($("option:selected", this).data('phone'))
        });
        $('.topping_select').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            console.log($("option:selected", this).data('price'));
            $('#topping_price').val($("option:selected", this).data('price'))
        });

        $('body').on('keyup', '#topping_qty', function() {
            var total = $(this).val() * $('#topping_price').val()
            $('#order_total').text(total)
            console.log(total)
        });
    </script>
@endsection
