@extends('admin.master')
@section('content')
@section('title','Edit Role')
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
                        <li><a href="{{URL::to('viewRole')}}"><i></i>
                                <span id="Label65">Click For Role List</span>
                            </a>
                        </li>
                        <li class="active">Edit Role</li>
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
						<form role="form" method="post" action="{!! route('updateRole.update',$value->id) !!}">
						<div class="box-body">
							<input type="hidden" value="{!! csrf_token() !!}" name="_token">
							<input type="hidden" value="put" name="_method">
							<div class="row">
							<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInput">Role Name<span class="validateRq">*</span></label>
								<input type="text" class="form-control" id="name" placeholder="Enter Role name" name="name" value="{!! $value->role_name !!}">
							</div>
							</div>
							</div>
							<div class="box-footer">
								<button type="submit" class="action-button" style=" margin-left: -7px;">Update</button>
							</div>
						</form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection


