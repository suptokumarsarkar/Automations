@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Update Category'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i>
                        {{\App\CentralLogics\translate('Update Category')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.categoryEditPost')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$admin['id']}}">
                    <div class="row">
                        <div class="col-12">


                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="name">{{\App\CentralLogics\translate('name')}}</label>
                                        <input type="text" name="category" id="name" maxlength="255"
                                               value="{{$admin['category']}}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="parentId">{{\App\CentralLogics\translate('parent')}}</label>
                                        <select name="parentId" id="parentId" class="form-control">
                                            <option value="0">ROOT</option>
                                            @foreach($category as $parent)
                                                <option value="{{$parent['id']}}" @if($admin['parentId'] == $parent['id']) selected @endif>{{$parent['category']}}</option>
                                            @endforeach
                                        </select>
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
