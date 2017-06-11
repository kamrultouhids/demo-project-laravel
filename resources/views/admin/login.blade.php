<!DOCTYPE html>
<html >
    <head>
	    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/bootstrap/css/bootstrap.min.css') !!}">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/css/AdminLTE.css') !!}">
		<!-- iCheck -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/iCheck/square/blue.css') !!}">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
    </head>
	<style>
	.error{ color:red}
	
	<!--For loader image-->
	.no-js #loader { display: none;  }
	.js #loader { display: block; position: absolute; left: 100px; top: 0; }
	.se-pre-con {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url({!! asset('public/admin_assets/img/Preloader_8.gif')!!}) center no-repeat #fff;
		
	}
	</style>
	<script>
	  function loading_image()
	  {
		// Animate loader off screen
		$(".se-pre-con").fadeIn("slow");
	  }
	</script>
    <body class="hold-transition login-page" >
	   <div class="se-pre-con" style="display:none"></div>
		<div class="login-box" >
		  <div class="login-logo">
			<img src="{!! asset('public/admin_assets/img/rab_logo.jpg') !!}" height="88" width="auto" style="margin-top: 25px"/>
		  </div><!-- /.login-logo -->
		  <div class="login-box-body">
			<p class="login-box-msg"></p>
		     {!! Form::open(['url' => 'login']) !!}

			  <!--Validation MSg-->
			    @if($errors->any())
				  <div class="alert alert-danger alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					  @foreach($errors->all() as $error)
						  <strong>{!! $error !!}</strong><br>
					  @endforeach
				  </div>
				@endif
			  <!--End Validation MSg-->

			  @if(session()->has('Erorr_message'))
				  <div class="alert alert-danger">
					  <p>{!! session()->get('Erorr_message') !!}</p>
				  </div>
			   @endif

			  @if(session()->has('success_message'))
				  <div class="alert alert-success">
					  <p>{!! session()->get('success_message') !!}</p>
				  </div>
			   @endif

			  
				  
			  <div class="form-group has-feedback">
				 <input type="text" name="userEmail" class="form-control" placeholder="User Email" value="{!! old('userEmail') !!}">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			  </div>
			  <div class="form-group has-feedback">
				 <input type="password" name="userPassword" class="form-control" placeholder="Password"/>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			  </div>
			  <div class="row">
				<div class="col-xs-8">
				<!--
				  <div class="checkbox icheck">
					<label>
					  <input type="checkbox"> Remember Me
					</label>
				  </div>
				  -->
				</div><!-- /.col -->
				<div class="col-xs-4">
					  <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="loading_image()">logIn</button>
				</div><!-- /.col -->
			  </div>
		  {!! Form::close() !!}

			<!--<a href="#">I forgot my password</a><br>-->
			

		  </div><!-- /.login-box-body -->
		</div><!-- /.login-box -->
	
	
	
	


		<!-- jQuery 2.1.4 -->
		<script src="{!! asset('public/admin_assets/plugins/jQuery/jQuery-2.1.4.min.js') !!}"></script>
		<!-- Bootstrap 3.3.5 -->
		<script src="{!! asset('public/admin_assets/bootstrap/js/bootstrap.min.js') !!}"></script>
		<!-- iCheck -->
		<script src="{!! asset('public/admin_assets/plugins/iCheck/icheck.min.js') !!}"></script>
		<!-- For loader images-->
	    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
		<script>
		  $(function () {
			$('input').iCheck({
			  checkboxClass: 'icheckbox_square-blue',
			  radioClass: 'iradio_square-blue',
			  increaseArea: '20%' // optional
			});
		  });
		</script>
    
    </body>
</html>