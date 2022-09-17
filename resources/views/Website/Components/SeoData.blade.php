@php($seoData = \App\Logic\Helpers::getSeoData())

<title>{{$seoData->title}}</title>
<meta name="description" content="{{$seoData->description}}">
<meta name="keywords" content="{{$seoData->keywords}}">


<!--  Essential META Tags -->
<meta property="og:title" content="{{$seoData->title}}">
<meta property="og:type" content="{{$seoData->type}}" />
<meta property="og:image" content="{{\App\Logic\Settings::getLogo()}}">
<meta property="og:url" content="{{url($seoData->slug)}}">
<meta name="twitter:card" content="summary_large_image">

<!--  Non-Essential, But Recommended -->
<meta property="og:description" content="{{$seoData->description}}">
<meta property="og:site_name" content="{{\App\Logic\Settings::getSiteName()}}">
<meta name="twitter:image:alt" content="{{$seoData->title}}">

<!--  Non-Essential, But Required for Analytics -->
<meta property="fb:app_id" content="{{\App\Logic\Settings::fastGet('facebookAppId')}}" />
