
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
		
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/bootstrap/css/bootstrap.min.css') !!}">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/css/AdminLTE.css') !!}">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/css/skins/_all-skins.min.css') !!}">
		<!-- iCheck -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/iCheck/flat/blue.css') !!}">
		<!-- Morris chart -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/morris/morris.css') !!}">
		<!-- jvectormap -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') !!}">
		<!-- Date Picker -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/datepicker/datepicker3.css') !!}">
		<!-- Daterange picker -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/daterangepicker/daterangepicker-bs3.css') !!}">
		<!-- bootstrap wysihtml5 - text editor -->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') !!}">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		
		<!-- time picker-->
		<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.css') !!}">
         <!-- sweetalert -->
	    <script src="{!! asset('public/admin_assets/sweetalert/sweetalert-dev.js') !!}"></script>
	    <link rel="stylesheet" href="{!! asset('public/admin_assets/sweetalert/sweetalert.css') !!}">
	    <!--.......................-->

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		 
		  <!-- jQuery 2.1.4 -->
		<script src="{!! asset('public/admin_assets/plugins/jQuery/jQuery-2.1.4.min.js') !!}"></script>
		


				
	
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
		background: url({!! asset('public/admin_assets/img/ring.gif')!!}) center no-repeat rgba(0, 0, 0, 0.2);
		
	}
	.action-button {
			width: 100px;
			background: #27AE60;
			font-weight: bold;
			color: white;
			border: 0 none;
			border-radius: 1px;
			cursor: pointer;
			padding: 10px 5px;
			margin: 10px 5px;
			text-align: center;
	}
	.actionDanger {
		width: 100px;
		background: #dd4b39;
		font-weight: bold;
		color: white;
		border: 0 none;
		border-radius: 1px;
		cursor: pointer;
		padding: 10px 5px;
		margin: 10px 5px;
		text-align: center;
	}
	.validateRq
	{
		color:red !important;
	}
	</style>
		
    </head>
    <body class="hold-transition skin-blue sidebar-mini" onload="addMenuClass()">
	
	<!--for loading images-->
	<div class="se-pre-con" style="display:none"></div>

    <div class="wrapper">
		
      <header class="main-header">
        <!-- Logo -->
        <a href="{{URL::to('admin_home')}}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <!-- <span class="logo-mini"><img src="{!! asset('public/admin_assets/img/logo.png') !!}" height="38" width="auto"/></span> -->
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">RAB<!--<img src="{!! asset('public/admin_assets/img/logo.png') !!}" height="38" width="auto"/>--></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

				<span style="color:#FFFFFF; font-size: 20px;">Case Management System</span>


			<div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{!! asset('public/admin_assets/img/logo.png') !!}" class="user-image" alt="User Image">
                  <span class="hidden-xs">  <?php echo $admin_name=Session::get('admin_name'); ?> </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{!! asset('public/admin_assets/img/logo.png') !!}" class="img-circle" alt="User Image">
                    <p>

                     
                    </p>
                  </li>
        		  <!-- Menu Footer-->
					<li class="user-footer">
					   <div class="pull-left">
							<a href=""  class="btn btn-default btn-flat">Profile</a>
						  
						</div>
						<div class="pull-right">
							<a href="{{URL::to('/logout')}}" class="btn btn-default btn-flat">Log Out</a>
						</div>
					</li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
	  
	  
        
            <!-- Left side column. contains the logo and sidebar -->
              <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                         
			        <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="">
                            <a href="{{URL::to('admin_home')}}">
                                <i class="fa fa-dashboard"></i> <span>Home  </span>
                            </a>
                        </li>
						

				
						<?php
							$role_id = session('logged_session_data.role_id');
							$query_result=DB::table('menu_info')
									->select(DB::raw('DISTINCT(`menu_info`.`ModuleID`),`module_info`.`ModuleName`'))
									->join('module_info', 'menu_info.ModuleID', '=', 'module_info.ModuleID')
									->join('user_permission', 'menu_info.menu_id', '=', 'user_permission.menu_id')
									->where('role_id', '=', $role_id)
									->where('parent', '=', '0')
									->orderBy('ModuleID','asc')
									->get();
						if ($query_result) {
								foreach ($query_result as $result){


						?>
								<li class="treeview">
								<a href="#">
													<i class="fa fa-share"></i> <span><?php echo $result->ModuleName ?></span>
													<i class="fa fa-angle-left pull-right"></i>
												  </a>
								<ul class="treeview-menu">
								<?php
									/* Section Strat */
								$role_id = session('logged_session_data.role_id');
								$section_result=DB::table('menu_info')
												->select(DB::raw('DISTINCT(`menu_info`.`menu_section_name`),`menu_info`.`menu_url`'))
												->join('user_permission', 'menu_info.menu_id', '=', 'user_permission.menu_id')
												->where('parent', '=', '0')
												->where('role_id', '=', $role_id)
												->where('ModuleID', '=', $result->ModuleID)
												->groupBy('menu_section_name')
												->orderBy('menu_info.menu_id')
												->get(); 
									
								
								foreach ($section_result as $secton){

									if (!empty($secton->menu_section_name)) { 
									?>
										<li class="">
										 <a href="#"><i class="fa fa-angle-double-right "></i><?php echo $secton->menu_section_name; ?><i class="fa fa-angle-left pull-right"></i></a>
										<ul class="treeview-menu">
										<?php
										/* Menu Url Start */
										
											$role_id = session('logged_session_data.role_id');
											$Menu_result=DB::table('menu_info')
												->join('user_permission', 'menu_info.menu_id', '=', 'user_permission.menu_id')
												->where('parent', '=', '0')
												->where('role_id', '=', $role_id)
												->where('ModuleID', '=', $result->ModuleID)
												->where('menu_section_name', '=', $secton->menu_section_name)
												->whereNotNull('menu_section_name')
												->get();

									foreach ($Menu_result as $MenuUrl){ ?>
											<li><a href="{!! route($MenuUrl->menu_url) !!}"><i class="fa fa-circle-o"></i><?php echo $MenuUrl->menu_name;?></a></li>


									<?php } ?>
										</ul>
										</li>
									<?php
									}  else {
										//When Section Name Empty
										$role_id = session('logged_session_data.role_id');
										$Menu_result=DB::table('menu_info')
												->join('user_permission', 'menu_info.menu_id', '=', 'user_permission.menu_id')
												->where('parent', '=', '0')
												->where('role_id', '=', $role_id)
												->where('ModuleID', '=', $result->ModuleID)
												->whereNull('menu_section_name')
												->get();

										foreach ($Menu_result as $MenuUrl){ ?>
											<li><a href="{!! route($MenuUrl->menu_url) !!}"><i class="fa fa-circle-o"></i><?php echo $MenuUrl->menu_name;?></a></li>
									<?php
										}
									
									}
								}
									
										?>
								</ul>
								</li>
								<?php  } }?>
				
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
             <div class="content-wrapper">
                <!-- Content Header (Page header) -->
					
                <!-- Main content -->
					@yield('content')

               <!-- /.content -->
			 
            </div><!-- /.right-side -->
			
			
			  <footer class="main-footer">
				<div class="pull-right hidden-xs">
				  <b>Version</b> 0.0.1
				</div>
				<strong>Copyright &copy;<?php echo date('Y');?> <a href="#">Rapid Action Battalion(RAB)</a>.</strong> All rights reserved.
			  </footer>
			  
        </div><!-- ./wrapper -->

            <!-- For loader images-->
	        <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
			<!-- Bootstrap 3.3.5 -->
			<script src="{!! asset('public/admin_assets/bootstrap/js/bootstrap.min.js') !!}"></script>
			<!-- DataTables -->
			<script src="{!! asset('public/admin_assets/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
			<script src="{!! asset('public/admin_assets/plugins/datatables/dataTables.bootstrap.min.js') !!}"></script>
			<!-- SlimScroll -->
			<script src="{!! asset('public/admin_assets/plugins/slimScroll/jquery.slimscroll.min.js') !!}"></script>
			<!-- FastClick -->
			<script src="{!! asset('public/admin_assets/plugins/fastclick/fastclick.min.js') !!}"></script>
			<!-- AdminLTE App -->
			<script src="{!! asset('public/admin_assets/js/app.min.js') !!}"></script>
			<!-- AdminLTE for demo purposes -->
	<script src="{!! asset('public/admin_assets/js/demo.js') !!}"></script>
	<!--TIme picker js-->
	<script src="{!! asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')!!}"></script>
	<script src="{!! asset('public/admin_assets/js/RGraph.svg.common.core.js') !!}"></script>
	<script src="{!! asset('public/admin_assets/js/RGraph.svg.common.tooltips.js') !!}"></script>

         
			<!-- jquery-validator -->
			    
			<script type="text/javascript" src="{!! asset('public/admin_assets/plugins/jquery-validator/jquery-validator.1.15.0.js')!!}"></script>
			<script type="text/javascript" src="{!! asset('public/admin_assets/plugins/jquery-validator/jquery-additional-method.1.15.0.min.js')!!}"></script>
	
		   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

		   <script src="{!! asset('public/admin_assets/plugins/datepicker/bootstrap-datepicker.js')!!}"></script>
	  


		<script>

			function addMenuClass(){

				var url  = window.location.href;
				var menu = '.sidebar';
				var navItem = $(menu).find("[href='" + url + "']");
				navItem.closest('li').addClass('active');
				navItem.parents('li.treeview').addClass('active');
				navItem.closest('ul.treeview-menu').css('display', 'block');

			}


			$('body').find(".dateField").datepicker({format: 'dd/mm/yyyy',todayHighlight: true}).on('changeDate', function(e){
				$(this).datepicker('hide');
			});


		</script>
			  
	
    </body>
</html>