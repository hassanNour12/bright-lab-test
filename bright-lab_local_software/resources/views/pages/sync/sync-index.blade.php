@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', 'Sync')
{{-- vendor style --}}
@section('vendor-styles')

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
            @elseif(session('email_failed'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning mb-2" role="alert">
                        {{ session('email_failed') }}
                    </div>
                </div>
            </div>
            @endif
        </section>
        <div class="invoice-create-btn mb-1 text-center">
            <button type="button" class="btn btn-danger glow invoice-create" data-toggle="modal"
            data-target="#inlineForm">Sync Data</button>
        </div>
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Please Verify Your Identity to continue the proccess</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form action="{{ route('sync-data') }}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <label for="email">Email: </label>
                            <div class="form-group">
                                <input type="text" name="email" id="email" placeholder="Email"
                                    class="form-control">
                            </div>

                            <label for="password">Password: </label>
                            <div class="form-group">
                                <input type="password" name="password" id="password" placeholder="Password"
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
                                <span class="d-none d-sm-block">Verify Your Identity</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')

@endsection
{{-- page scripts --}}
@section('page-scripts')
    <script src="{{ asset('js/scripts/pages/app-invoice.js') }}"></script>
@endsection
