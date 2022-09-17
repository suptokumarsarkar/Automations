@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Update Movie'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i
                            class="tio-add-circle-outlined"></i> {{\App\CentralLogics\translate('Editing a Movie')}}
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.movie.editMoviePost', $movie['id'])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{\App\CentralLogics\translate('title')}}</label>
                                <input type="text" name="title" class="form-control" maxlength="255"
                                       placeholder="{{\App\CentralLogics\translate('title')}}" value="{{$movie['title']}}" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{\App\CentralLogics\translate('publish_date')}}</label>
                                <input type="date" name="publish_date" class="form-control" maxlength="255"  value="{{$movie['publish_date']}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="input-label"
                                       for="">{{\App\CentralLogics\translate('description')}}</label>
                                <textarea name="description" rows="10" class="form-control"
                                          required>{{$movie['description']}}</textarea>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label"
                                       for="">{{\App\CentralLogics\translate('download_link')}}</label>
                                <input type="text" step="any" name="download_link" class="form-control" value="{{$movie['download_link']}}">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('watch_link')}}</label>
                                <input type="text" step="any" name="watch_link" class="form-control" value="{{$movie['watch_link']}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('category')}}</label>
                                <select name="category[]" multiple required>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"  {{in_array($category->id,json_decode($movie['category'])) ? 'selected':''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('tags')}}</label>
                                <input type="text" step="any" value="{{$movie['tags']}}" name="tags" id="selectize_tags"
                                       required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('rating')}}</label>
                                <input type="text" class="form-control" value="{{$movie['popular']}}" name="popular"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>{{\App\CentralLogics\translate('Thumbnail')}}</label><small style="color: red">*
                                    ( {{\App\CentralLogics\translate('ratio')}} 1:1 )</small>
                                <div class="custom-file">
                                    <input type="file" name="thumbnail" id="customFileEg1" class="custom-file-input"
                                           value="{{ old('image') }}"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label"
                                           for="customFileEg1">{{\App\CentralLogics\translate('Choose File')}}</label>
                                </div>
                                <div class="text-center mt-2">
                                    <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer1"
                                         src="{{asset('storage/app/public/movie/'. $movie['thumbnail'])}}"
                                         alt="branch image"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">

                            <div class="form-group">
                                <label>{{\App\CentralLogics\translate('Banner')}}</label><small style="color: red">*
                                    ( {{\App\CentralLogics\translate('ratio')}} 1:1 )</small>
                                <div class="custom-file">
                                    <input type="file" name="banner" id="customFileEg2" class="custom-file-input"
                                           value="{{ old('image') }}"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label"
                                           for="customFileEg2">{{\App\CentralLogics\translate('Choose File')}}</label>
                                </div>
                                <div class="text-center mt-2">
                                    <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer2"
                                         src="{{asset('storage/app/public/movie/'. $movie['banner'])}}"
                                         alt="branch image"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{\App\CentralLogics\translate('submit')}}</button>
                </form>
            </div>


        </div>
    </div>

@endsection

@push('script_2')
    <link rel="stylesheet" href="{{asset('public/dist/css/selectize.css')}}">
    <script src="{{asset('public/dist/js/standalone/selectize.js')}}"></script>
    <script>
        $("select").selectize();
        $("#selectize_tags").selectize({
            delimiter: ',',
            valueField: 'value',
            labelField: 'value',
            options: [
                    @foreach(\App\CentralLogics\Helpers::get_tags() as $tag)
                {
                    value: '{{$tag}}'
                },
                @endforeach
            ],
            persist: false,
            create: function (input) {
                return {
                    value: input,
                    text: input
                }
            }
        });

        function readURL(input, id1) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(id1).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this, '#viewer1');
        });
        $("#customFileEg2").change(function () {
            readURL(this, '#viewer2');
        });
    </script>

@endpush
