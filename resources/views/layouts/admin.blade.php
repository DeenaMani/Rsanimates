@php $setting = \App\Models\Setting::find(1); @endphp
<!DOCTYPE html>
<html lang="en">
    <!-- begin::Head -->
    <head>
        <base href="">
        <meta charset="utf-8" />
        <title>{{ @$title ? $title : "Dashboard"}} |  {{$setting->company_name}} </title>
        <meta name="description" content="Updates and statistics">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin::Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

        <!--end::Fonts -->

        <!--begin::Global Theme Styles(used by all pages) -->
        <link href="{{ url('public/admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/admin/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

        <!--end::Global Theme Styles -->

        <!--begin::Layout Skins(used by all pages) -->
        <link href="{{ url('public/admin/css/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/admin/css/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/admin/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/admin/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css" />

        <!--end::Layout Skins -->
        <link rel="shortcut icon" href="{{ URL::to('/') }}/public/images/{{$setting->company_fav}}" />
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

        <!-- begin:: Page -->

        <!-- begin:: Header Mobile -->
        <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
            <div class="kt-header-mobile__logo">
                <a href="{{ url::to('/') }}/admin">
                    <img alt="Logo" src="{{ url::to('/') }}/public/images/{{$setting->company_fav}}"  style="height: 20px" />
                </a>
            </div>
            <div class="kt-header-mobile__toolbar">
                <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
                <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
                <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
            </div>
        </div>

        <!-- end:: Header Mobile -->
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

                <!-- begin:: Aside -->

                <!-- Uncomment this to display the close button of the panel
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
-->
                <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

                    <!-- begin:: Aside -->
                    <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
                        <div class="kt-aside__brand-logo">
                            <a href="{{url('admin')}}">
                                <img alt="Logo" src="{{ url::to('/') }}/public/images/{{$setting->image_name}}" style="height: 20px" height="40" />
                            </a>
                        </div>
                        <div class="kt-aside__brand-tools">
                            <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
                                <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) " />
                                            <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) " />
                                        </g>
                                    </svg></span>
                                <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero" />
                                            <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) " />
                                        </g>
                                    </svg></span>
                            </button>

                            <!--
            <button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
            -->
                        </div>
                    </div>

                    <!-- end:: Aside -->

                    <!-- begin:: Aside Menu -->
                    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                        <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
                            <ul class="kt-menu__nav ">


                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/dashboard') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-dashboard"></i><span class="kt-menu__link-text">Dashboard</span></a></li>
                                
                                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon-list"></i><span class="kt-menu__link-text">Home</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                 <ul class="kt-menu__subnav">
                                   
                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/futures') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-list"></i><span class="kt-menu__link-text">Futures</span></a></li>

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/clients') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-list"></i><span class="kt-menu__link-text">Clients</span></a></li> 

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/banner') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-list"></i><span class="kt-menu__link-text">Banner</span></a></li>
                                
                                        </ul>
                                    </div>
                                </li>

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/about') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-list"></i><span class="kt-menu__link-text">About Us</span></a></li> 

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/service') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-list"></i><span class="kt-menu__link-text">Service</span></a></li> 

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/servicelist') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-list"></i><span class="kt-menu__link-text">Service List</span></a></li> 

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/contact') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-list"></i><span class="kt-menu__link-text">Contact Us</span></a></li> 

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/customer') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-user"></i><span class="kt-menu__link-text">Users</span></a></li>

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/setting') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-settings-1"></i><span class="kt-menu__link-text">Setting</span></a></li>

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/profile') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-profile"></i><span class="kt-menu__link-text">My Profile</span></a></li>

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{ url('admin/change_password') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-lock"></i><span class="kt-menu__link-text">Change Password</span></a></li>

                                <li class="kt-menu__item " aria-haspopup="true"><a href="{{url('/logout')}}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-logout"></i><span class="kt-menu__link-text">Log Out</span></a></li>

                                 
                                
                            </ul>
                        </div>
                    </div>

                    <!-- end:: Aside Menu -->
                </div>

                <!-- end:: Aside -->
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                    <!-- begin:: Header -->
                    <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

                        <!-- begin:: Header Menu -->

                        <!-- Uncomment this to display the close button of the panel
<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
-->
                        <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
                                <ul class="kt-menu__nav ">
                                    
                                </ul>
                            </div>
                        </div>

                        <!-- end:: Header Menu -->

                        <!-- begin:: Header Topbar -->
                        <div class="kt-header__topbar">

              
                       


                            <!--begin: User Bar -->
                            <div class="kt-header__topbar-item kt-header__topbar-item--user">
                                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                                    <div class="kt-header__topbar-user">
                                        <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                                        <span class="kt-header__topbar-username kt-hidden-mobile">{{ Session::get('admin_name') }}</span>
                                        <!-- <img class="kt-hidden" alt="Pic" src="{{ URL::to('/')}}public/admin/media/users/300_25.jpg" /> -->

                                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">A</span>
                                    </div>
                                </div>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

                                    <!--begin: Head -->
                                    <!-- <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(urls/media/misc/bg-1.jpg)">
                                        <div class="kt-user-card__avatar">
                                            <img class="kt-hidden" alt="Pic" src="{{ URL::to('/')}}public/admin/media/users/300_25.jpg" /> 

                                            use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) 
                                             <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success"></span>
                                        </div>
                                        <div class="kt-user-card__name">
                                            Admin
                                        </div>
                                    </div> -->

                                    <!--end: Head -->

                                    <!--begin: Navigation -->
                                    <div class="kt-notification">
                                        <a href="{{ url('admin/profile') }}" class="kt-notification__item">
                                            <div class="kt-notification__item-icon">
                                                <i class="flaticon2-calendar-3 kt-font-success"></i>
                                            </div>
                                            <div class="kt-notification__item-details">
                                                <div class="kt-notification__item-title kt-font-bold">
                                                    My Profile
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    Account settings and more
                                                </div>
                                            </div>
                                        </a>
                                        
                                        <div class="kt-notification__custom kt-space-between">
                                            <a href="{{url('/destory')}}"  class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
                                            
                                        </div>
                                    </div>

                                    <!--end: Navigation -->
                                </div>
                            </div>

                            <!--end: User Bar -->
                        </div>

                        <!-- end:: Header Topbar -->
                    </div>

                    <!-- end:: Header -->
                   

                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                        <!-- begin:: Content Head -->
                        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
                            <div class="kt-container  kt-container--fluid ">
                                <div class="kt-subheader__main">
                                    <h3 class="kt-subheader__title">{{$title}}</h3>
                                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                                    <span class="kt-subheader__desc">Home</span>
                                    
                                    
                                </div>
                                
                            </div>
                        </div>
                     @yield('content')
                 </div>
                    <!-- end:: Footer -->
                </div>
            </div>
        </div>

        <!-- end:: Page -->

  
        <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>

        <!-- end::Scrolltop -->


        <!-- begin::Global Config(global config for global JS sciprts) -->
        <script>
            var KTAppOptions = {
                "colors": {
                    "state": {
                        "brand": "#5d78ff",
                        "dark": "#282a3c",
                        "light": "#ffffff",
                        "primary": "#5867dd",
                        "success": "#34bfa3",
                        "info": "#36a3f7",
                        "warning": "#ffb822",
                        "danger": "#fd3995"
                    },
                    "base": {
                        "label": [
                            "#c5cbe3",
                            "#a1a8c3",
                            "#3d4465",
                            "#3e4466"
                        ],
                        "shape": [
                            "#f0f3ff",
                            "#d9dffa",
                            "#afb4d4",
                            "#646c9a"
                        ]
                    }
                }
            };
        </script>

        <!-- end::Global Config -->

        <!--begin::Global Theme Bundle(used by all pages) -->
        <script src="{{ url('public/admin/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/admin/js/scripts.bundle.js') }}" type="text/javascript"></script>

        <!--end::Global Theme Bundle -->
        <script src="{{ url('public/admin/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $('#datatables').DataTable({
                //"language": {"url": b_url+"urls/js/"+base_lang +".json"}
            });
        </script>
        @stack('scripts')
       

    </body>


    <!-- end::Body -->
</html>