<!DOCTYPE html>
<html lang="en">
<!-- head -->
<head>
<link rel="stylesheet" href="{{ URL::asset('/css/style.css') }}" />

@include('header')

</head>
<!-- end head -->

<body>
<!-- wrapper -->
<div id="wrapper">
@yield('content')
</div>
<!-- end wrapper -->

<!-- footer -->
@include('footer')
<!-- end footer -->
</body>

</html>