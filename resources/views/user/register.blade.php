@extends('layouts.master')

@section('header-title')
    Film Management | {{__('Register')}}
@stop

@section('header-styles')
   <!-- CUSTOM STYLES -->

@stop

@section('content')

	<div class="container" style="margin-top:30px">		
	<div class="row">
		<div class="col-md-4 col-md-offset-4"  id="signupbox">
			<div class="response-message"></div>
			<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><strong>Sign up </strong></h3>			  
			</div>
		  
		  <div class="panel-body">
		   <!-- {!! Form::open(['url' => 'register']) !!} -->
		   <form method="post" id="register">
			<div style="margin-bottom: 12px" class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input id="full_name" type="text" class="form-control" name="full_name"  value="{{old('full_name')}}"  placeholder="user full name" required>
			</div>			
			<div style="margin-bottom: 12px" class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				<input id="email" type="email" class="form-control" name="email"  value="{{old('email')}}" placeholder="email" required>
			</div>
				<div style="margin-bottom: 12px" class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="password" type="password" class="form-control" name="password" placeholder="password" required>
				</div>  
				
			  <button type="button" id="submit_btn" class="btn btn-info">Sign Up</button>
			  
			  <hr style="margin-top:10px;margin-bottom:10px;" >
			  
				<div class="form-group">       
					<div style="font-size:85%">
						Already have an account! 
					<a href="<?php echo URL::to('/login') ?>">
						Sign in Here
					</a>
				</div>
				
				</div> 
			<!-- {!! Form::close() !!} -->
		  </div>
		</div>
	</div>
	</div>		
</div>
@section('scripts')	
	<script src="{{asset('public/js/jquery.validate.js')}}"></script>
	<script src="{{asset('public/js/custom/config.js')}}"></script>
	<script src="{{asset('public/js/custom/functions.js')}}"></script>
	<script src="{{asset('public/js/custom/register.js')}}"></script>
@stop

@stop 