@extends('layouts.master')

@section('header-title')
    Create Film
@stop

@section('header-styles')
   <!-- CUSTOM STYLES -->   
   <link rel="stylesheet" href="{{asset('js/dropzone/dropzone.min.css')}}">
@stop

@section('content')
	<div class="main-panel">		
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Create Film</h4>
                            </div>
                            <div class="content">
                                <form>                                   
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Film Title</label>
                                                <input type="text" class="form-control" placeholder="Film Title" name="name" id="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Release Date</label>
                                                <input type="date" class="form-control" placeholder="Release Date" name="release_date" id="release_date" required>
                                            </div>
                                        </div>
                                    </div>                                   

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input type="text" class="form-control" placeholder="Ticket Price" name="price" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <input type="text" class="form-control" placeholder="Country" name="country" id="country" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="rating">Rating</label>
                                                <select class="form-control required" name="rating" id="rating" required>													
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
                                            </div>
                                        </div>
                                    </div>
									 <div class="row">                                        
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Genres</label>
                                                <select class="form-control required" name="genres" id="genres" required>													
												</select>
                                            </div>
                                        </div>
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Photo</label>
                                                <input type="file" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea rows="5" class="form-control" value="" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right">Create</button>
                                    <div class="clearfix"></div>
                                </form>
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