@extends('layouts.master')

@section('header-title')
    List of Films
@stop

@section('header-styles')
   <!-- CUSTOM STYLES -->   

@stop

@section('content')
	<div class="main-panel">		
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">List of Films</h4>
                            </div>
							<div class="row"><div class="col-md-8"><div class="form-group"><a href="<?php echo url('/film/create');?>" class="btn btn-info btn-sm pull-left">Add a film</a></div></div></div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                    	<th>Name</th>
                                    	<th width="40%">description</th>
                                    	<th>Country</th>
                                    	<th>Ticket Price</th>
										<th>Release Date</th>
										<th>Rating</th>
										<th>Photo</th>
                                    </thead>
                                    <tbody id="film_list">                                                                                                                      
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>                    
                </div>
				<div class="row">
					<div class="col-md-12 text-right">
						<ul class="pagination">                  
						</ul>
					</div>
				</div>
        </div>
            </div>
        </div>        
    </div>
@section('scripts')
	<script src="{{asset('public/js/custom/config.js')}}"></script>
	<script src="{{asset('public/js/custom/film/list.js')}}"></script>
@stop

@stop 