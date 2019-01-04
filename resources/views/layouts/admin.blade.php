<!DOCTYPE html>
<html lang="en" dir="ltr"  class="h-100">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/app.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

</head>
<body class="h-100">
<div class="container-fluid  h-100">
    <div class="row main-container  h-100">
        <div class="col-2 sidebar pl-0 pr-0  h-100">
            @include('inc.admin.sidebar')
        </div>
        <div class="col-10 main-content">
            @include('inc.admin.header')
            @yield('content')
        </div>
    </div>


</div>
<script src="/js/app.js"></script>
@section('scripts')

@show
</body>
</html>