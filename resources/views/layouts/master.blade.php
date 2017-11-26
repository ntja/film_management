<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="en"> <![endif]-->
<html lang="en">

<head>	
    <title>@yield('header-title')</title>
     <!-- META SECTION -->
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <!--[if IE]>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <![endif]-->
    <meta name="description" content="">
    <meta name="author" content="Film Management">	
	<meta name="keywords" content="Movies, Action, Drama, Science Fiction ...">    	
	
    <!-- END META SECTION -->
	@yield('meta')    
      <!-- =-=-=-=-=-=-= Mobile Specific =-=-=-=-=-=-= -->
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <!-- =-=-=-=-=-=-= Bootstrap CSS Style =-=-=-=-=-=-= -->
      <link rel="stylesheet" href="{{asset('public/css/bootstrap.css')}}">
	  <link rel="stylesheet" href="{{asset('public/assets/css/light-bootstrap.css')}}">
      <!-- =-=-=-=-=-=-= Template CSS Style =-=-=-=-=-=-= -->
      <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
      <!-- =-=-=-=-=-=-= Font Awesome =-=-=-=-=-=-= -->
      <link rel="stylesheet" href="{{asset('public/css/font-awesome.css')}}" type="text/css">      
	  
	@yield('header-styles')
	
	@yield('header-scripts')
	 
    </head>

    <body data-base-url="<?php echo URL::to('/'); ?>">        
       
		@yield('content')  
		
		<!-- =-=-=-=-=-=-= JQUERY =-=-=-=-=-=-= -->
      <script src="{{asset('public/js/jquery.min.js')}}"></script>
      <!-- Bootstrap Core Css  -->
      <script src="{{asset('public/js/bootstrap.min.js')}}"></script>	  
        @yield('scripts')    
    </body>
</html>