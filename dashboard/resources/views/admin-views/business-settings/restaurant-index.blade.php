@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Settings'))

@push('css_or_js')
    <style>
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #377dff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #banner-image-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #banner-image-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }


        }

        @media (max-width: 375px) {
            #banner-image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

        }

        @media (max-width: 500px) {
            #banner-image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }


        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{\App\CentralLogics\translate('restaurant Setup')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row">
            <div class="col-md-8 mb-3 mt-3">
                <div class="card">
                    <div class="card-body" style="padding-bottom: 12px">
                        <div class="row">
                            @php($config=\App\CentralLogics\Helpers::get_business_settings('maintenance_mode'))
                            <div class="col-6">
                                <h5>
                                    <i class="tio-settings-outlined"></i>
                                    {{\App\CentralLogics\translate('maintenance_mode')}}
                                </h5>
                            </div>
                            <div class="col-6">
                                <label class="switch ml-3 float-right">
                                    <input type="checkbox" class="status" onclick="maintenance_mode()"
                                        {{isset($config) && $config?'checked':''}}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4  mb-3 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center"><i class="tio-money"></i> {{\App\CentralLogics\translate('Currency Symbol Position')}}</h5>
                        <i class="tio-dollar"></i>
                    </div>
                    <div class="card-body">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('currency_symbol_position'))
                        <div class="form-row">
                            <div class="col-sm mb-2 mb-sm-0">
                                <!-- Custom Radio -->
                                <div class="form-control">
                                    <div class="custom-control custom-radio custom-radio-reverse"
                                         onclick="currency_symbol_position('{{route('admin.business-settings.currency-position',['left'])}}')">
                                        <input type="radio" class="custom-control-input"
                                               name="projectViewNewProjectTypeRadio"
                                               id="projectViewNewProjectTypeRadio1" {{(isset($config) && $config=='left')?'checked':''}}>
                                        <label class="custom-control-label media align-items-center"
                                               for="projectViewNewProjectTypeRadio1">
                                            <i class="tio-agenda-view-outlined text-muted mr-2"></i>
                                            <span class="media-body">
                                               {{\App\CentralLogics\Helpers::currency_symbol()}} {{\App\CentralLogics\translate('Left')}}
                                              </span>
                                        </label>
                                    </div>
                                </div>
                                <!-- End Custom Radio -->
                            </div>

                            <div class="col-sm mb-2 mb-sm-0">
                                <!-- Custom Radio -->
                                <div class="form-control">
                                    <div class="custom-control custom-radio custom-radio-reverse"
                                         onclick="currency_symbol_position('{{route('admin.business-settings.currency-position',['right'])}}')">
                                        <input type="radio" class="custom-control-input"
                                               name="projectViewNewProjectTypeRadio"
                                               id="projectViewNewProjectTypeRadio2" {{(isset($config) && $config=='right')?'checked':''}}>
                                        <label class="custom-control-label media align-items-center"
                                               for="projectViewNewProjectTypeRadio2">
                                            <i class="tio-table text-muted mr-2"></i>
                                            <span class="media-body">
                                        Right {{\App\CentralLogics\Helpers::currency_symbol()}}
                                      </span>
                                        </label>
                                    </div>
                                </div>
                                <!-- End Custom Radio -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <center>
                    <h4><i class="tio-settings"></i>{{\App\CentralLogics\translate('General settings form')}}</h4>
                    <hr>
                </center>
                <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                    <form action="{{route('admin.business-settings.update-setup')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf


                        @php($logo=\App\Model\BusinessSetting::where('key','logo')->first()->value)
                        <div class="form-group mt-3">
                            <label>{{\App\CentralLogics\translate('logo')}}</label><small style="color: red">*
                                ( {{\App\CentralLogics\translate('ratio')}} 3:1 )</small>
                            <div class="custom-file">
                                <input type="file" name="logo" id="customFileEg1" class="custom-file-input"
                                       accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label"
                                       for="customFileEg1">{{\App\CentralLogics\translate('choose')}} {{\App\CentralLogics\translate('file')}}</label>
                            </div>
                            <hr>
                            <center>
                                <img style="height: 100px;border: 1px solid; border-radius: 10px;" id="viewer"
                                     onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                     src="{{asset('storage/app/public/restaurant/'.$logo)}}" alt="logo image"/>
                            </center>
                        </div>
                        <hr>
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{\App\CentralLogics\translate('submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script>
        @php($time_zone=\App\Model\BusinessSetting::where('key','time_zone')->first())
        @php($time_zone = $time_zone->value ?? null)
        $('[name=time_zone]').val("{{$time_zone}}");

        @php($language=\App\Model\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        let language = <?php echo($language); ?>;
        $('[id=language]').val(language);

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
        $("#language").on("change", function () {
            $("#alert_box").css("display", "block");
        });
    </script>

    <script>
        @if(env('APP_MODE')=='demo')
        function maintenance_mode() {
            toastr.info('{{\App\CentralLogics\translate('Disabled for demo version!')}}')
        }
        @else
        function maintenance_mode() {
            Swal.fire({
                title: '{{\App\CentralLogics\translate('Are you sure?')}}',
                text: '{{\App\CentralLogics\translate('Be careful before you turn on/off maintenance mode')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: '{{route('admin.business-settings.maintenance-mode')}}',
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            toastr.success(data.message);
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                } else {
                    location.reload();
                }
            })
        };
        @endif

        function currency_symbol_position(route) {
            $.get({
                url: route,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    toastr.success(data.message);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        $(document).on('ready', function () {
            @php($country=\App\CentralLogics\Helpers::get_business_settings('country')??'BD')
            $("#country option[value='{{$country}}']").attr('selected', 'selected').change();
        })
    </script>

    <script>
        $('#shipping_by_distance_status').on('click',function(){
            $("#delivery_charge").prop('disabled', true);
            $("#min_shipping_charge").prop('disabled', false);
            $("#shipping_per_km").prop('disabled', false);
        });

        $('#default_delivery_status').on('click',function(){
            $("#delivery_charge").prop('disabled', false);
            $("#min_shipping_charge").prop('disabled', true);
            $("#shipping_per_km").prop('disabled', true);
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#phone_verification_on").click(function () {
                if ($('#email_verification_on').prop("checked") == true) {
                    $('#email_verification_off').prop("checked", true);
                    $('#email_verification_on').prop("checked", false);
                    const message = "{{\App\CentralLogics\translate('Both Phone & Email verification can not be active at a time')}}";
                    toastr.info(message);
                }
            });
            $("#email_verification_on").click(function () {
                if ($('#phone_verification_on').prop("checked") == true) {
                    $('#phone_verification_off').prop("checked", true);
                    $('#phone_verification_on').prop("checked", false);
                    const message = "{{\App\CentralLogics\translate('Both Phone & Email verification can not be active at a time')}}";
                    toastr.info(message);
                }
            });
        });
    </script>
@endpush
