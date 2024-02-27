 @php
           $users = \App\Users::find(\Auth::user()->id);
            $setting = \App\Setting::find(1);
 @endphp


<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="advanced search custom, agency, agent, business, clean, corporate, directory, google maps, homes, listing, membership packages, property, real estate, real estate agent, realestate agency, realtor">
<meta name="description" content="FindHouse - Real Estate HTML Template">
<meta name="CreativeLayers" content="ATFN">
<!-- css file -->
<link rel="stylesheet" href="{{url('/')}}/public/css/bootstrap.min.css">
<link rel="stylesheet" href="{{url('/')}}/public/css/style.css">
<link rel="stylesheet" href="{{url('/')}}/public/css/dashbord_navitaion.css">
<!-- Responsive stylesheet -->
<link rel="stylesheet" href="{{url('/')}}/public/css/responsive.css">
 @stack('styles')
<!-- Title -->
<title>Astra - {{$setting->company_name}}</title>
<!-- Favicon -->
 <link rel="shortcut icon" href="{{ URL::to('/') }}/public/images/setting/{{$setting->company_fav}}" />

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="wrapper">
	<div class="preloader"></div>

	<!-- Main Header Nav -->
	<header class="header-nav menu_style_home_one style2 menu-fixed main-menu">
		<div class="container-fluid p0">
		    <!-- Ace Responsive Menu -->
		    <nav>
		        <!-- Menu Toggle btn-->
		        <div class="menu-toggle">
		             <img class="nav_logo_img img-fluid" src="{{url('/')}}/public/images/setting/{{$setting->image_name}}" alt="{{$setting->company_name}}" height="100" width="100">
		            <button type="button" id="menu-btn">
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		            </button>
		        </div>
		       <!--  <a href="#" class="navbar_brand float-left dn-smd">
		            <img class="nav_logo_img img-fluid" src="{{url('/')}}/public/images/setting/{{$setting->image_name}}" alt="{{$setting->company_name}}" height="100" width="100">
		            <span>{{$setting->company_name}}</span>
		        </a> -->
		        <!-- Responsive Menu Structure-->
		        <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
		        <ul id="respMenu" class="ace-responsive-menu text-right" data-menu-style="horizontal">
		        	<li class="">
		        		<a class="dropdown-item" href="{{url('/')}}">Back To Home</a>
		        	</li>
		           
	                <li class="user_setting">
						<div class="dropdown">
	                		<a class="btn dropdown-toggle" href="#" data-toggle="dropdown"><img src="{{ URL::to('/')}}/public/images/users/{{$users->profile_image}}" alt="" width="40" height="40" > <span class="dn-1199"> {{$users->name}}</span></a>
						    <div class="dropdown-menu">
						    	<div class="user_set_header">
						    		 <img src="{{ URL::to('/')}}/public/images/users/{{$users->profile_image}}" alt="" width="100" height="100" >
							    	<p> {{$users->name}}<br><span class="address"> {{$users->email}}</span></p>
						    	</div>
						    	<div class="user_setting_content">
									<a class="dropdown-item active" href="{{url('/user/myprofile')}}">My Profile</a>
									<a class="dropdown-item" href="{{url('/user/change_password')}}">Change Password</a>
									<a class="dropdown-item" href="{{url('/logout')}}">Log out</a>
						    	</div>
						    </div>
						</div>
			        </li>
		        </ul>
		    </nav>
		</div>
	</header>

	<!-- Main Header Nav For Mobile -->
	<div id="page" class="stylehome1 h0">
		<div class="mobile-menu">
			<div class="header stylehome1">
				<div class="main_logo_home2 text-center">
		            <img class="nav_logo_img img-fluid" src="{{url('/')}}/public/images/setting/{{$setting->image_name}}" alt="{{$setting->company_name}}" height="100" width="100">
		            <span>{{$setting->company_name}}</span>
				</div>
				<ul class="menu_bar_home2">
	                <li class="list-inline-item list_s"><a href="page-register.html"><span class="flaticon-user"></span></a></li>
					<li class="list-inline-item"><a href="#menu"><span></span></a></li>
				</ul>
			</div>
		</div>

	</div>

    <div class="dashboard_sidebar_menu dn-992">
	    <ul class="sidebar-menu">
	   		<li class="header"> <img class="nav_logo_img img-fluid" src="{{url('/')}}/public/images/setting/{{$setting->image_name}}" alt="{{$setting->company_name}}" height="100" width="150">
		            <!-- <span>{{$setting->company_name}}</span> -->
	   		<li class="title"><span>User</span></li>
	    	<li class="treeview"><a href="#"><i class="flaticon-layers"></i><span> Dashboard</span></a></li>
	      	<li class="treeview"><a href="{{url('/user/myprofile')}}"><i class="flaticon-user"></i><span>My Profile</span></a></li>
	      	<li class="treeview"><a href="{{url('/user/mybooking')}}"><i class="flaticon-layers"></i><span>My Booking</span></a></li>
	        <li class="treeview"><a href="{{url('/user/myfavorite')}}"><i class="flaticon-envelope"></i><span>My Favorite</span></a></li>
	        <li class="treeview"><a href="{{url('/user/evault')}}"><i class="flaticon-user"></i><span>E-vault</span></a></li> 
	        <li class="treeview"><a href="{{url('/user/change_password')}}"><i class="flaticon-user"></i><span>Change Password</span></a></li>
	      	<li class="treeview"><a href="{{url('/logout')}}"><i class=" flaticon-logout"></i><span>Logout</span></a></li>
	   		
	    </ul>
    </div>

     @yield('content')


<a class="scrollToHome" href="#"><i class="flaticon-arrows"></i></a>
</div>
<!-- Wrapper End -->
<script type="text/javascript" src="{{url('/')}}/public/js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/jquery-migrate-3.0.0.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/popper.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/jquery.mmenu.all.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/ace-responsive-menu.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/chart.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/chart-custome.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/snackbar.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/simplebar.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/parallax.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/scrollto.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/jquery-scrolltofixed-min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/jquery.counterup.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/wow.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/progressbar.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/slider.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/timepicker.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/wow.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/dashboard-script.js"></script>
<!-- Custom script for all pages --> 
<script type="text/javascript" src="{{url('/')}}/public/js/script.js"></script>


 @stack('scripts')

</body>
</html>