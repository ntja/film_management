@extends('layouts.master')

@section('header-title')
    Film Item
@stop

@section('header-styles')
   <!-- CUSTOM STYLES -->   

@stop

@section('content')
	<div class="main-panel">		
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
						<div class="response-message"></div>
                       <div class="card">                            
                            <div class="content">
                                <div id="film" data-film="<?php echo $film;?>">                                    
								</div>
                            <hr>
                            <div class="text-left" id="comment">                               
                            </div>
                        </div>
                    </div>                    
                </div>				
        </div>
            </div>
        </div>        
    </div>
@section('scripts')
	<script src="{{asset('public/js/custom/config.js')}}"></script>
	<script src="{{asset('public/js/custom/functions.js')}}"></script>
	<script src="{{asset('public/js/custom/film/item.js')}}"></script>
@stop

@stop 