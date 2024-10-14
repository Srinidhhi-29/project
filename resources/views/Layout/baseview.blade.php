<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAsk  manager  @yield('title')</title>
    @include('Layout.css')
    @yield('style')
</head>
<body>
   @yield('content')
   @include('Layout.js')
   @yield('customjs') 
</body>
</html>