@php $setting = \App\Models\Setting::find(1); @endphp
<!DOCTYPE html>
<html lang="en">
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>Admin Login</title>
        <meta name="description" content="Login page example">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--begin::Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

        <!--end::Fonts -->

        <!--begin::Page Custom Styles(used by this page) -->
        <link href="{{url('/')}}/public/admin/css/pages/login/login-2.css" rel="stylesheet" type="text/css" />

        <!--end::Page Custom Styles -->

        <!--begin::Global Theme Styles(used by all pages) -->
        <link href="{{url('/')}}/public/admin/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="{{url('/')}}/public/admin/css/style.bundle.css" rel="stylesheet" type="text/css" />

        <!--end::Global Theme Styles -->

        <!--end::Layout Skins -->
        <link rel="shortcut icon" href="{{url('/')}}/public/admin/media/logos/favicon.ico" />
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

        <!-- begin:: Page -->
        <div class="kt-grid kt-grid--ver kt-grid--root">
            <div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url({{url('/')}}/public/admin/media/bg/bg-1.jpg);">
                    <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                        <div class="kt-login__container">
                            <div class="kt-login__logo">
                                <a href="#">
       
                                    <img alt="Logo" src="{{ url('/') }}/public/images/{{$setting->image_name}}" height="40px;" />
                                </a>
                            </div>
                            <div class="kt-login__signin">
                                <div class="kt-login__head">
                                    <h3 class="kt-login__title">Sign In To Admin</h3>
                                </div>
                                <form method="post" class="kt-form" action="{{ route('admin.check_login') }}" enctype="multipart/form-data" > 
                                    @if(session()->has('error'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('error') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            
                                                @foreach ($errors->all() as $error)
                                                    <p>{{ $error }}</p>
                                                @endforeach
                                            
                                        </div>
                                    @endif

                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
                                    </div>
                                    <div class="input-group">
                                        <input class="form-control" type="password" placeholder="Password" name="password">
                                    </div>
                                    <div class="row kt-login__extra">
                                        <div class="col">
                                            <label class="kt-checkbox">
                                                <input type="checkbox" name="remember" value="1"> Remember me
                                                <span></span>
                                            </label>
                                        </div>
                                        <!-- <div class="col kt-align-right">
                                            <a href="javascript:;" id="kt_login_forgot" class="kt-link kt-login__link">Forget Password ?</a>
                                        </div> -->
                                    </div>
                                    <div class="kt-login__actions">
                                        <button id="kt_login_signin_submit" class="btn btn-pill kt-login__btn-primary">Sign In</button>
                                    </div>
                                </form>
                            </div>
                           
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Page -->

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
        <script src="{{url('/')}}/public/admin/plugins/global/plugins.bundle.js" type="text/javascript"></script>
        <script src="{{url('/')}}/public/admin/js/scripts.bundle.js" type="text/javascript"></script>

        <!--end::Global Theme Bundle -->

        <!--begin::Page Scripts(used by this page) -->
        <!-- <script src="{{url('/')}}/public/admin/js/pages/custom/login/login-general.js" type="text/javascript"></script> -->

        <!--end::Page Scripts -->
    </body>

    <!-- end::Body -->
</html>