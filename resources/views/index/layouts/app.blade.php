<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="/css/index/app.css">
    <link rel="stylesheet" type="text/css" href="/css/index/menu.css">
    @yield('css')
</head>
<body>
<div class="container-full" id="app">
    @yield('content')
</div>
</body>
<script src="/js/index/app.js"></script>
<script type="text/javascript">

</script>
@yield('script')
</html>