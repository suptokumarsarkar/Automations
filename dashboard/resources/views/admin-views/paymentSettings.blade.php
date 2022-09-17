@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Payment Settings'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .lang_form label{
            display: block;
        }
        .lang_form label input{
            margin: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i>
                        {{\App\CentralLogics\translate('Update Payment Gateway')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.paymentSettingsPost')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Paypal Client Id')}}</label>
                                        @php
                                            $paypalClientId = \App\WebSetting::WHERE("key", 'paypalClientId')->first() ? \App\WebSetting::WHERE("key", 'paypalClientId')->first()->value : "";
                                        @endphp
                                        <input type="text" name="data[paypalClientId]" value="{{$paypalClientId}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Stripe Public Key')}}</label>
                                        @php
                                            $stripePublicKey = \App\WebSetting::WHERE("key", 'stripePublicKey')->first() ? \App\WebSetting::WHERE("key", 'stripePublicKey')->first()->value : "";
                                        @endphp
                                        <input type="text" name="data[stripePublicKey]" value="{{$stripePublicKey}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Stripe Private Key')}}</label>
                                        @php
                                            $stripePrivateKey = \App\WebSetting::WHERE("key", 'stripePrivateKey')->first() ? \App\WebSetting::WHERE("key", 'stripePrivateKey')->first()->value : "";
                                        @endphp
                                        <input type="text" name="data[stripePrivateKey]" value="{{$stripePrivateKey}}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn btn-primary mt-2">{{\App\CentralLogics\translate('update')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>
@endsection
@push('script_2')
    <script>
        function readURL(input, viewer_id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#' + viewer_id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this, 'viewer');
        });
        $("#customFileEg2").change(function () {
            readURL(this, 'viewer2');
        });
    </script>
@endpush
