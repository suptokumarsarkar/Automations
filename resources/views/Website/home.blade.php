@extends('Layouts.website')
@section('title', 'LightNit Automation and Fast Task Manager')
@section('description', "This is an automation Project")

@push('headerScript')
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <!--======= Font Asesome cdn Link =======-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="{{asset('public/css/slick.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/style.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/style2.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/responsive.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/responsive2.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/feature_style.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/blog.style.css' . App\Logic\Helpers::production("version"))}}">

    <link rel="stylesheet" href="{{asset('public/css/jobs_style.css' . App\Logic\Helpers::production("version"))}}">
    <link rel="stylesheet" href="{{asset('public/css/jobs_responsive.css' . App\Logic\Helpers::production("version"))}}">
@endpush
@section("content")
    {!! App\Logic\Notification::get('top')  !!}

    {{--Include Header--}}
    @includeIf('Website.Components.Common.HeaderMenu')

    {{--Include About--}}
    @includeIf('Website.Components.Explore.SaveTimeBanner')

    {{--Include About--}}
    @includeIf('Website.Components.Home.About')

    {{--Include Show--}}
    @includeIf('Website.Components.Products.Show')

    {{--Include Automation--}}
    @includeIf('Website.Components.Home.Automation')

    {{--Include Customer--}}
    @includeIf('Website.Components.Home.Customer')


    {{--Include Subscribe--}}
    @includeIf('Website.Components.Blogs.SubscribeFullBanner')

    {{--Include FindSection--}}
    @includeIf('Website.Components.Home.FindSection')

    {{--Include Apps--}}
    @includeIf('Website.Components.Home.Apps')

    {{--Include Plan--}}
    @includeIf('Website.Components.Home.Plan')


    {{--Include Footer--}}
    @includeIf('Website.Components.Common.Footer')

    {!! App\Logic\Notification::get('bottom')  !!}

@endsection



@push('footerScript')
    <script src="{{asset('public/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/js/slick.min.js')}}"></script>
    <script src="{{asset('public/js/fontawsome.js')}}"></script>
    <script src="{{asset('public/js/script.js'. App\Logic\Helpers::production("version"))}}"></script>
    <script src="{{asset('public/js/slider.js'. App\Logic\Helpers::production("version"))}}"></script>
@endpush
