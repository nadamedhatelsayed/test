@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title',env('APP_NAME'))</title>
 
	 <link rel="stylesheet" href="{{asset('assets/admin/vendors/select2/select2.min.css')}}">
	  <!-- Datatables CSS CDN -->
    
 
	 <link rel="stylesheet" href="{{asset('assets/admin/fonts/feather-font/css/iconfont.css')}}">
 
	<link rel="stylesheet" href="{{asset('assets/admin/css/demo_5/style.css')}}">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="{{asset('assets/admin/images/favicon.png')}}" />
  @yield('css')
</head>
<body class="rtl">
	<div class="main-wrapper">
        @include('layouts.partials.header')
		<div class="page-wrapper">
			<div class="page-content">
				@yield('content')
			</div>
			@include('layouts.partials.footer')
		</div>
	</div>
	<!-- core:js -->
	<script src="{{asset('assets/admin/vendors/core/core.js')}}"></script>
 
 	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}"></script>
 
	@yield('js')
</body>
</html>


