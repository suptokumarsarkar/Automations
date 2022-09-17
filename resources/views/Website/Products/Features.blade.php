@extends('Layouts.website')
@section('title', 'Features | LightNit Product')
@section('description', "This is an automation Project")

@push('headerScript')
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <!--======= Font Asesome cdn Link =======-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{asset('public/css/style.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/style2.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/responsive.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/responsive2.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/works.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/works_responsive.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/pricing_style.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/pricing_responsive.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/responsive_style.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/feature_style.css' . App\Logic\Helpers::production("version"))}}">
@endpush
@section("content")
    {!! App\Logic\Notification::get('top')  !!}



    {{--Include Header--}}
    @includeIf('Website.Components.Common.HeaderMenu')


    {{--Include Company--}}
    @includeIf('Website.Components.Home.Company')

    {{--Include Feature--}}
    @includeIf('Website.Components.Home.Feature')

    {{--Include GetStarted--}}
    @includeIf('Website.Components.Products.GetStarted')

    {{--Include Point--}}
    @includeIf('Website.Components.Products.Point')


    {{--Include Video--}}
    @includeIf('Website.Components.Products.Video')

    {{--Include SecurityTrust--}}
    @includeIf('Website.Components.Products.SecurityTrust')

    {{--Include Apps--}}
    @includeIf('Website.Components.Home.Apps')

    {{--Include Help--}}
    @includeIf('Website.Components.Home.Help')

    {{--Include Find--}}
    @includeIf('Website.Components.Home.FindSection')

    {{--Include Banner--}}
    @includeIf('Website.Components.Products.Banner')

    {{--Include Footer--}}
    @includeIf('Website.Components.Common.SortFooter')

    {!! App\Logic\Notification::get('bottom')  !!}

@endsection



@push('footerScript')
    <script src="{{asset('public/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/js/fontawsome.js')}}"></script>
    <script src="{{asset('public/js/script.js'. App\Logic\Helpers::production("version"))}}"></script>
    <script src="{{asset('public/js/findsection.js'. App\Logic\Helpers::production("version"))}}"></script>
@endpush
