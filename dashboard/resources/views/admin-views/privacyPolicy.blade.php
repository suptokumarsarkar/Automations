@extends('layouts.admin.app')

@section('title', \App\CentralLogics\translate('Privacy Policy'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .lang_form label {
            display: block;
        }

        .lang_form label input {
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
                        {{\App\CentralLogics\translate('Privacy Policy')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.privacyPolicyPost')}}"  onsubmit="checkEvent(event)" id="postForm" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group lang_form">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{\App\CentralLogics\translate('Privacy Policy')}}</label>
                                @php
                                    $privacyPolicy = \App\WebSetting::WHERE("key", 'privacyPolicy')->first() ? \App\WebSetting::WHERE("key", 'privacyPolicy')->first()->value : "";
                                @endphp
                                <textarea name="data[privacyPolicy]" style="display:none;" id="postsContent" cols="30"
                                          rows="10"></textarea>
                                <div id="editor">
                                    {!! $privacyPolicy !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                            class="btn btn-primary mt-2 rajsubmit">{{\App\CentralLogics\translate('update')}}</button>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>
@endsection
@push('script_2')

<link rel="stylesheet"
      href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js"></script>

    <!-- Core build with no theme, formatting, non-essential modules -->
    <link href="https://cdn.quilljs.com/1.0.5/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.0.5/quill.min.js" type="text/javascript"></script>
    <script>
        let quill;
        $(document).ready(function () {
            quill = new Quill('#editor', {
                modules: {
                    syntax: !0,
                    toolbar: [
                        [{
                            font: []
                        }, {
                            size: []
                        }],
                        ["bold", "italic", "underline", "strike"],
                        [{
                            color: []
                        }, {
                            background: []
                        }],
                        [{
                            script: "super"
                        }, {
                            script: "sub"
                        }],
                        [{
                            header: "1"
                        }, {
                            header: "2"
                        }, "blockquote", "code-block"],
                        [{
                            list: "ordered"
                        }, {
                            list: "bullet"
                        }, {
                            indent: "-1"
                        }, {
                            indent: "+1"
                        }],
                        ["direction", {
                            align: []
                        }],
                        ["link", "image", "video", "formula"],
                        ["clean"]
                    ]
                },
                theme: 'snow'
            });

        });
        function checkEvent(event){
            event.preventDefault();
            $("#postsContent").val($("#editor div").html());

            let data = new FormData($("#postForm")[0]);

            $.ajax({
                url: '{{route('admin.privacyPolicyPost')}}',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                beforeSend:function(){
                    $(".rajsubmit").html('Proccessing...');
                    $(".rajsubmit").attr('disabled', 'disabled');
                },
                success: function(r) {
                    window.location = '{{route('admin.privacyPolicy')}}';
                },
                error: function(r) {

                    $(".rajsubmit").html('Update');
                    $(".rajsubmit").attr('disabled', '');
                    toastr.error('Something Went Wrong', Error, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });


        }
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
    </script>
@endpush
