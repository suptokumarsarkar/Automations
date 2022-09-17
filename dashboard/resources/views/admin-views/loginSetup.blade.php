@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Login Setup'))

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
                        {{\App\CentralLogics\translate('Update Login Setup')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.loginSetupPost')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">

                            <div class="form-group lang_form">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{\App\CentralLogics\translate('Active Third Party')}}</label>
                                <label for="google">
                                    <input type="checkbox" {{\App\CentralLogics\Extra::isActive3rdPartyLogin('google') ? 'checked' : ''}} id="google" name="active[google]"> <span>{{\App\CentralLogics\translate('Google OAuth')}}</span>
                                </label>
                                <label for="facebook">
                                    <input type="checkbox" {{\App\CentralLogics\Extra::isActive3rdPartyLogin('facebook') ? 'checked' : ''}} id="facebook" name="active[facebook]"> <span>{{\App\CentralLogics\translate('Facebook OAuth')}}</span>
                                </label>
                                <label for="microsoft">
                                    <input type="checkbox" {{\App\CentralLogics\Extra::isActive3rdPartyLogin('microsoft') ? 'checked' : ''}} id="microsoft" name="active[microsoft]"> <span>{{\App\CentralLogics\translate('Microsoft OAuth')}}</span>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Google Client Id')}}</label>
                                        @php
                                            $googleOAuthKey = \App\WebSetting::WHERE("key", 'googleClientId')->first() ? \App\WebSetting::WHERE("key", 'googleClientId')->first()->value : "";
                                        @endphp
                                        <input type="text" name="key[googleClientId]" value="{{$googleOAuthKey}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Facebook App Id')}}</label>
                                        @php
                                            $facebookAppId = \App\WebSetting::WHERE("key", 'facebookAppId')->first() ? \App\WebSetting::WHERE("key", 'facebookAppId')->first()->value : "";
                                        @endphp
                                        <input type="text" name="key[facebookAppId]" value="{{$facebookAppId}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Microsoft Client Id')}}</label>
                                        @php
                                            $microsoftClientId = \App\WebSetting::WHERE("key", 'microsoftClientId')->first() ? \App\WebSetting::WHERE("key", 'microsoftClientId')->first()->value : "";
                                        @endphp
                                        <input type="text" name="key[microsoftClientId]" value="{{$microsoftClientId}}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
{{--                            <div class="row">--}}
{{--                                <div class="col-12">--}}
{{--                                    <div class="form-group lang_form">--}}
{{--                                        <label class="input-label"--}}
{{--                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Facebook OAuth Key')}}</label>--}}
{{--                                        <input type="text" name="key[facebookOAuthKey]" value=""--}}
{{--                                               class="form-control">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
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
