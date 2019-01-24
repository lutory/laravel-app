<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Stylesheets
    ============================================= -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/front/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/front/style.css" type="text/css" />
    <link rel="stylesheet" href="/css/front/dark.css" type="text/css" />
    <link rel="stylesheet" href="/css/front/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="/css/front/animate.css" type="text/css" />
    <link rel="stylesheet" href="/css/front/magnific-popup.css" type="text/css" />

    <link rel="stylesheet" href="/css/front/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Document Title
    ============================================= -->
    <title>Blog - Grid 3 Columns | Canvas</title>

</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    @include('inc.front.header')
    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">
                    @yield('content')
            </div>
        </div>
    </section>
    @include('inc.front.footer')
</div>
<!-- Go To Top
	============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>
<!-- External JavaScripts
	============================================= -->
<script type="text/javascript" src="/js/front/jquery.js"></script>
<script type="text/javascript" src="/js/front/plugins.js"></script>

<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="/js/front/functions.js"></script>
@section('scripts')

@show
</body>
</html>