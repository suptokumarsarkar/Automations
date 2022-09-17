@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Add App'))

@push('css_or_js')

    <style>

        .master_div {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .master_div_left_input_row {
            flex-basis: 95%;
            display: flex;
        }

        .master_div_left_input_box {
            width: 100%;
        }

        .master_div_left_input_box input {
            width: 98%;
        }

        .master_div_left_input_box label {
            color: #000;
        }

        .master_div_right_cross_icon_row {
            flex-basis: 5%;
            display: flex;
            justify-content: end;
            margin-top: 30px;
        }

        .master_div_right_cross_icon_row i {
            font-size: 22px;
            color: #ea4e4e;
        }

        @media only screen and (max-width: 600px) {
            .master_div_left_input_row {
                flex-direction: column;
                max-width: 90%;
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
                    <h1 class="page-header-title"><i class="tio-edit"></i>
                        {{\App\CentralLogics\translate('Add App')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.appsAddPost')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">


                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="id">{{\App\CentralLogics\translate('App Id')}}</label>
                                        <input type="text" name="AppId" id="id" maxlength="255"
                                               value=""
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="name">{{\App\CentralLogics\translate('App Name')}}</label>
                                        <input type="text" name="AppName" id="name" maxlength="255"
                                               value=""
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="status">{{\App\CentralLogics\translate('Status')}}</label>
                                        <select type="text" name="status" id="status"
                                               class="form-control">
                                            <option value="1">{{\App\CentralLogics\translate('Active')}}</option>
                                            <option value="0">{{\App\CentralLogics\translate('Inactive')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="customFileEg1">{{\App\CentralLogics\translate('Icon')}}</label><small
                                            style="color: red">*
                                            ( {{\App\CentralLogics\translate('ratio')}} 1:1 )</small>
                                        <div class="custom-file">
                                            <input type="file" name="AppLogo" id="customFileEg1"
                                                   class="custom-file-input"
                                                   value="{{ old('image') }}"
                                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                            <label class="custom-file-label"
                                                   for="customFileEg1">{{\App\CentralLogics\translate('Choose File')}}</label>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img style="height: 200px;border: 1px solid; border-radius: 10px;"
                                                 id="viewer1"
                                                 src="{{asset('public/assets/admin/img/400x400/img2.png')}}"
                                                 alt="App Icon"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12  col-sm-6">

                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="name">{{\App\CentralLogics\translate('description')}}</label>
                                        <textarea name="AppDescription" id="name" maxlength="255"
                                                  class="form-control" style="height: 249px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h2 style="margin-top: 20px;">
                                <a href="javascript:void(0)" class="btn btn-success" onclick="addInput()"
                                   style="float:right;">{{\App\CentralLogics\translate("Add Input")}}</a>
                                {{\App\CentralLogics\translate('App Info')}}
                            </h2>
                            <div class="appInfo">
                            </div>

                            <button type="submit"
                                    class="btn btn-primary mt-2">{{\App\CentralLogics\translate('add')}}</button>
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
            readURL(this, 'viewer1');
        });
        $("#customFileEg2").change(function () {
            readURL(this, 'viewer2');
        });


        let lastId = 0;

        function addInput() {
            let html = `
                            <div class="master_div" id="az` + lastId + `">
                                <div class="master_div_left_input_row">
                                    <div class="master_div_left_input_box">
                                        <label for="">{{\App\CentralLogics\translate('name')}}</label>
                                        <input type="text" name="AppInfo[` + lastId + `]" class="form-control">
                                    </div>
                                    <div class="master_div_left_input_box">
                                        <label for="">{{\App\CentralLogics\translate('value')}}</label>
                                        <input type="text" name="AppInfoValue[` + lastId + `]" class="form-control">
                                    </div>
                                </div>
                                <div class="master_div_right_cross_icon_row" onclick="dataCloser(` + lastId + `)">
                                    <i class="tio-remove-circle"></i>
                                </div>
                            </div>`;

            $(".appInfo").append(html);
            lastId++;
        }

        addInput();

        function dataCloser(id) {
            $("#az" + id).remove();
        }
    </script>
@endpush
