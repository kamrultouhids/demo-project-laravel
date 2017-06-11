@extends('admin.master')
@section('content')
@section('title','Add User')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ol class="breadcrumb admin-header">
                        <li><a href=""><i class="fa fa-home"></i>
                                <span id="Label65">Dashboard</span>
                            </a>
                        </li>
                        <li><a href="{{URL::to('view-user')}}"><i></i>
                                <span id="Label65">Click For User List</span>
                            </a>
                        </li>
                      
                        <li class="active">Add User</li>
						
                    </ol>
                </div>
                <div class="panel-body" style="height: auto; min-height: 500px;">
                        @if($errors->any())
							<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
									@foreach($errors->all() as $error)
										<strong>{!! $error !!}</strong><br>
									@endforeach
							</div>
						@endif
						@if(session()->has('success'))
							<div class="alert alert-success">
								<p>{!! session()->get('success') !!}</p>
							</div>
						@endif
						<form role="form" method="post" action="{!! route('add_user.store') !!}" enctype="multipart/form-data">
							<div class="box-body">
								<input type="hidden" value="{!! csrf_token() !!}" name="_token">
							<div class="col-md-4">
								<div class="form-group">
									<label>Select Role<span class="validateRq">*</span></label>
									<select name="role_id" class="form-control select2" style="width: 100%;">
										<option >--- Select Role ---</option>
										@foreach($data as $value)
											<option value="{!! $value->id !!}" @if($value->id == old('role_id')) {{"selected"}} @endif>{!! $value->role_name !!}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
								  <label for="exampleInput">Name<span class="validateRq">*</span></label>
								  <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{!! old('name') !!}">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
								  <label for="exampleInput">Email<span class="validateRq">*</span></label>
								  <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="{!! old('email')!!}">
								</div>
							</div>
							<div class="col-md-4">		
								<div class="form-group">
									<label for="password">password<span class="validateRq">*</span></label>
									<input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="password_confirmation">Password Confirmation<span class="validateRq">*</span></label>
									<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Enter confirmation password">
								</div>
							</div>
							<div class="col-md-4">	
								<div class="form-group">
									<label for="picture">Picture<span class="validateRq">*</span></label>
									<input type="file" name="picture" id="picture" class="form-control">
								</div>
							</div>
							</div>
							<div class="box-footer">
								<button type="submit" style="margin-left: 16px;" class="action-button">Save</button>
							</div>
						</form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

