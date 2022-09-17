@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('All Movies'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i
                            class="tio-add-circle-outlined"></i> {{\App\CentralLogics\translate('All Movies')}}
                    </h1>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="card">
                <div class="card-header flex-between">
                    <div class="flex-start">
                        <h5 class="card-header-title">{{\App\CentralLogics\translate('Movies')}}</h5>
                        <h5 class="card-header-title text-primary mx-1">({{ $addons->total() }})</h5>
                    </div>
                    <div>
                        <form action="{{url()->current()}}" method="GET">
                            <div class="input-group">
                                <input id="datatableSearch_" type="search" name="search"
                                       class="form-control"
                                       placeholder="{{\App\CentralLogics\translate('Search')}}" aria-label="Search"
                                       value="{{$search}}" required autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text"><i class="tio-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th>{{\App\CentralLogics\translate('#')}}</th>
                            <th style="width: 20%">{{\App\CentralLogics\translate('thumbnail')}}</th>
                            <th style="width: 30%">{{\App\CentralLogics\translate('title')}}</th>
                            <th style="width: 50%">{{\App\CentralLogics\translate('tags')}}</th>
                            <th style="width: 10%">{{\App\CentralLogics\translate('action')}}</th>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($addons as $key=>$category)
                            <tr>
                                <td>{{$addons->firstitem()+$key}}</td>
                                <td>
                                    <img src="{{asset('storage/app/public/movie/'.$category->thumbnail)}}" style="width: 100px" alt="Icon">
                                </td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{$category['title']}}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{$category['tags']}}
                                    </span>
                                </td>
                                <td>
                                    <!-- Dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="tio-settings"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                               href="{{route('admin.movie.edit',[$category['id']])}}">{{\App\CentralLogics\translate('edit')}}</a>
                                            <a class="dropdown-item" href="javascript:"
                                               onclick="form_alert('category-{{$category['id']}}','{{\App\CentralLogics\translate("Want to delete this")}}')">{{\App\CentralLogics\translate('delete')}}</a>
                                            <form action="{{route('admin.movie.delete',[$category['id']])}}"
                                                  method="post" id="category-{{$category['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        </div>
                                    </div>
                                    <!-- End Dropdown -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <hr>
                    <table>
                        <tfoot>
                        {!! $addons->links() !!}
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
        <!-- End Table -->
    </div>
    </div>

@endsection

@push('script_2')
    <script>
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
    </script>

@endpush
