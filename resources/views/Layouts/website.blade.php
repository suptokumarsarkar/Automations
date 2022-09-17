<!doctype html>
<html lang="{{app()->getLocale()??"en"}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

@if(\App\Logic\Helpers::hasSeoData())
    @includeIf('Website.Components.SeoData')
    @else
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
    @endif


    <link rel="icon" href="{{\App\Logic\Settings::getLogo()}}">

    @stack('headerScript')
    @stack('style')
</head>
<body>
@yield('content')

@stack('footerScript')
@stack('MasterScript')
</body>
</html>
