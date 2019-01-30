<!DOCTYPE html>
<html lang="en" dir="ltr"  class="h-100">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/vendor/vendor.bundle.base.css" />
    <link rel="stylesheet" href="/css/vendor/vendor.bundle.addons.css" />
    <link rel="stylesheet" href="/css/vendor/materialdesignicons.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    @section('links')

    @show
</head>
<body>
<div class="container-scroller">

    @include('inc.admin.header')
    <div class="container-fluid page-body-wrapper">
        @include('inc.admin.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    @yield('content')
                </div>
            </div>


        </div>
    </div>

</div>
{{--<script src="/js/app.js"></script>--}}
<script src="/js/vendor/vendor.bundle.base.js"></script>
{{--<script src="/js/vendor/vendor.bundle.addons.js"></script>--}}
<script src="/js/vendor/off-canvas.js"></script>
<script src="/js/vendor/misc.js"></script>
@section('scripts')

@show
</body>
</html>