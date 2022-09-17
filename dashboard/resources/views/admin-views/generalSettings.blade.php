@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('General Settings'))

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
                        {{\App\CentralLogics\translate('Update Settings')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.generalSettingsPost')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Website Logo')}}</label>
                                        @php
                                            $logo = \App\Model\BusinessSetting::WHERE("key", 'logo')->first() ? \App\Model\BusinessSetting::WHERE("key", 'logo')->first()->value : "";
                                        @endphp
                                            <div class="custom-file">
                                                <input type="file" name="image" id="customFileEg1"
                                                       class="custom-file-input"
                                                       accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                                       >
                                                <label class="custom-file-label"
                                                       for="customFileEg1">{{\App\CentralLogics\translate('choose')}}</label>
                                            </div>
                                        @if($logo)
                                            <div style="text-align: center; margin-top: 10px;">
                                                <img style="width: 250px;border: 1px solid; border-radius: 10px;"
                                                     id="viewer"
                                                     src="{{asset('storage/app/public/logo/'.$logo)}}"
                                                     alt="Logo"/>
                                            </div>
                                            @else
                                            <div style="text-align: center; margin-top: 10px;">
                                                <img style="width: 250px;border: 1px solid; border-radius: 10px;"
                                                     id="viewer"
                                                     src="{{asset('public/assets/admin/img/900x400/img1.jpg')}}"
                                                     alt="Logo"/>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Dashboard Table Max Post Per Page')}}</label>
                                        @php
                                            $pagination_limit = \App\Model\BusinessSetting::WHERE("key", 'pagination_limit')->first() ? \App\Model\BusinessSetting::WHERE("key", 'pagination_limit')->first()->value : "";
                                        @endphp
                                        <input type="text" name="key[pagination_limit]" value="{{$pagination_limit}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Copyright Text')}}</label>
                                        @php
                                            $copyrightText = \App\WebSetting::WHERE("key", 'copyrightText')->first() ? \App\WebSetting::WHERE("key", 'copyrightText')->first()->value : "";
                                        @endphp
                                        <input type="text" name="data[copyrightText]" value="{{$copyrightText}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Facebook Url')}}</label>
                                        @php
                                            $facebookUrl = \App\WebSetting::WHERE("key", 'facebookUrl')->first() ? \App\WebSetting::WHERE("key", 'facebookUrl')->first()->value : "";
                                        @endphp
                                        <input type="text" name="data[facebookUrl]" value="{{$facebookUrl}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('LinkedIn Url')}}</label>
                                        @php
                                            $linkedinUrl = \App\WebSetting::WHERE("key", 'linkedinUrl')->first() ? \App\WebSetting::WHERE("key", 'linkedinUrl')->first()->value : "";
                                        @endphp
                                        <input type="text" name="data[linkedinUrl]" value="{{$linkedinUrl}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Google Plus Url')}}</label>
                                        @php
                                            $googlePlusUrl = \App\WebSetting::WHERE("key", 'googlePlusUrl')->first() ? \App\WebSetting::WHERE("key", 'googlePlusUrl')->first()->value : "";
                                        @endphp
                                        <input type="text" name="data[googlePlusUrl]" value="{{$googlePlusUrl}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Twitter Url')}}</label>
                                        @php
                                            $twitterUrl = \App\WebSetting::WHERE("key", 'twitterUrl')->first() ? \App\WebSetting::WHERE("key", 'twitterUrl')->first()->value : "";
                                        @endphp
                                        <input type="text" name="data[twitterUrl]" value="{{$twitterUrl}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Youtube Url')}}</label>
                                        @php
                                            $youtubeUrl = \App\WebSetting::WHERE("key", 'youtubeUrl')->first() ? \App\WebSetting::WHERE("key", 'youtubeUrl')->first()->value : "";
                                        @endphp
                                        <input type="text" name="data[youtubeUrl]" value="{{$youtubeUrl}}"
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
