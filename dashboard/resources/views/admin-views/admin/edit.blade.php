@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Update Admin'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i>
                        {{\App\CentralLogics\translate('Update Admin')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.adminEditPost')}}" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$admin['id']}}">
                    @csrf
                    <div class="row">
                        <div class="col-12">


                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('first_name')}}</label>
                                        <input type="text" name="f_name" maxlength="255"
                                               value="{{$admin['f_name']}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('last_name')}}</label>
                                        <input type="text" name="l_name" value="{{$admin['l_name']}}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('Status')}}</label>
                                        <select name="status"
                                               class="form-control">
                                            <option value="1" @if($admin['status'] == 1) selected @endif>{{\App\CentralLogics\translate('active')}}</option>
                                            <option value="0" @if($admin['status'] == 0) selected @endif>{{\App\CentralLogics\translate('inactive')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('email')}}</label>
                                        <input type="text" name="email" value="{{$admin['email']}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{\App\CentralLogics\translate('phone')}}</label>
                                        <input type="text" name="phone" value="{{$admin['phone']}}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn btn-primary mt-2">{{\App\CentralLogics\translate('Update')}}</button>
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
