
@extends('admin.master')
@section('content')
@section('title','User Role Permission')
	<script>
		function getrole(select){
		 var selectedString = select.options[select.selectedIndex].value;
			var id = select.options[select.selectedIndex].value;
			var role=$('#role').val();
			if(role!=''){
			$('body').find('#formSubmit').attr('disabled', false);
			}else{
				$('body').find('#formSubmit').attr('disabled', true);
			}
		  
			$.ajax({
					   type:'POST',
					   url: 'get_all_menu_url',
					  data: {role:role, '_token': $('input[name=_token]').val()},
					  
					   success:function(result){
					   // $("#msg").html(data.msg);
					   $('.ShowMember').html(result);
				  }
					});
			

		}
	</script>
	
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
                   
                        <li class="active">Add Role Permission</li>
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
						<form role="form" name="entryform" id="entryform" action="{!! route('addRole.role_permission_relation') !!}" method="POST">
							<input type="hidden" value="{!! csrf_token() !!}" name="_token">
						
							<div class="box-body">
						  
							   <div class="form-group">
								  <label for="role">User Role:</label>
								  <select class="form-control" name="RoleName" id="role" onchange="getrole(this)">
									<option  value="">---------- Select Role--------</option>
									@foreach($data as $value)
									   <option  value="{!! $value->id!!}">{!! $value->role_name!!}</option>
									@endforeach   
								  </select>
								</div>
							    <div class="form-group">
									<div class="ShowMember">
									

									</div>
								</div>
							</div>

							<div class="box-footer">
							  <button type="submit" name="Insert" id="formSubmit" class="action-button" style="width:100px" disabled="disabled"> Save </button>
							</div>
						</form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection



