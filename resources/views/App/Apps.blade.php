@extends('App.Index')
@section('title', 'LightNit App')
@section('description', "This is an automation Project")

@push('headerScript')
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <!--======= Font Asesome cdn Link =======-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="{{asset('public/css/app/style.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/app/responsive.css' . App\Logic\Helpers::production("version"))}}">
@endpush
@section("content")
    {!! App\Logic\Notification::get('top')  !!}

    {{--Include Header--}}
    @includeIf('App.Components.Warning')

    {{--Include Header--}}
    @includeIf('App.Components.Header')

    {{--Include Body--}}
    @includeIf('App.Components.Body')

    {!! App\Logic\Notification::get('bottom')  !!}

@endsection



@push('footerScript')
    <script src="{{asset('public/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/js/slick.min.js')}}"></script>
    <script src="{{asset('public/js/script.js'. App\Logic\Helpers::production("version"))}}"></script>
    <script src="{{asset('public/js/app/body.js'. App\Logic\Helpers::production("version"))}}"></script>
    <script src="{{asset('public/js/slider.js'. App\Logic\Helpers::production("version"))}}"></script>
@endpush
