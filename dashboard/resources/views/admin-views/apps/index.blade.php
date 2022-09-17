@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Apps List'))

@push('css_or_js')
    <style>

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .switch .slider {
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

        .switch .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .switch input:checked + .slider {
            background-color: #2196F3;
        }

        .switch input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        .switch input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .switch .slider.round {
            border-radius: 34px;
        }

        .switch .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <a href="{{route('admin.appsAdd')}}" class="btn btn-success"
                       style="float: right;">{{\App\CentralLogics\translate('Add App')}}</a>
                    <h1 class="page-header-title"><i
                            class="tio-add-circle-outlined"></i> {{\App\CentralLogics\translate('Apps List')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            @php($language = \App\Model\BusinessSetting::where('key', 'language')->first())
            @php($language = $language->value ?? null)
            @php($default_lang = 'en')


            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header flex-between">
                        <div class="flex-start">
                            <h5 class="card-header-title">{{\App\CentralLogics\translate("All Apps")}}</h5>
                            <h5 class="card-header-title text-primary mx-1">({{ $customers->total() }})</h5>
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
                        <table
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{\App\CentralLogics\translate('#')}}</th>
                                <th style="width: 20%">{{\App\CentralLogics\translate('Icon')}}</th>
                                <th style="width: 10%">{{\App\CentralLogics\translate('Name')}}</th>
                                <th style="width: 25%">{{\App\CentralLogics\translate('Description')}}</th>
                                <th style="width: 10%">{{\App\CentralLogics\translate('Status')}}</th>
                                <th style="width: 10%">{{\App\CentralLogics\translate('Actions')}}</th>
                            </tr>

                            </thead>

                            <tbody>
                            @foreach($customers as $key=>$customer)
                                <tr>
                                    <td width="5%">{{$customers->firstitem()+$key}}</td>

                                    <td width="25%">
                                        <img src="{{$customer->getLogo()}}" style="width: 60px" alt="">
                                    </td>
                                    <td width="25%">
                                        {{$customer['AppName']}}
                                    </td>
                                    <td width="30%">
                                    <span class="d-block font-size-sm text-body">
                                       {{$customer['AppDescription']}}
                                    </span>
                                    </td>

                                    <td width="25%">
                                        <label class="switch">
                                            <input type="checkbox" onchange="chd421s('{{$customer->id}}')" {{$customer->getStatus() ? 'checked' : ''}}>
                                            <span class="slider round"></span>
                                        </label>
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
                                                   href="{{route('admin.appsEdit',[$customer['id']])}}">{{\App\CentralLogics\translate('edit')}}</a>
                                                <a class="dropdown-item" href="javascript:"
                                                   onclick="form_alert('category-{{$customer['id']}}','{{\App\CentralLogics\translate("Want to delete this")}}')">{{\App\CentralLogics\translate('delete')}}</a>
                                                <form action="{{route('admin.appsDeletePost',[$customer['id']])}}"
                                                      method="post" id="category-{{$customer['id']}}">
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
                            {!! $customers->links() !!}
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
        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            // var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            var datatable = $('.table').DataTable({
                "paging": false
            });

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });


            $('#column3_search').on('change', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

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

        function chd421s(id)
        {
            $.ajax({
                url: '{{route('admin.updateStatus')}}',
                type: 'POST',
                data: 'updateStatus='+id+'&_token={{csrf_token()}}'
            });
        }
    </script>
@endpush
