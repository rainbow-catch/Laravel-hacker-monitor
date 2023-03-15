<!doctype html>
<html class="fixed">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <meta name="keywords" content="Xor PREMIUM" />
    <meta name="description" content="Third level security">
    <meta name="author" content="SoftwareRG">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="library/DataTables/datatables.css" />
    <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="assets/vendor/modernizr/modernizr.js"></script>

</head>
<body style="background-color:#F3ECEA;">
<section  class="body-sign">
    <div class="center-sign">
        <div class="panel text-black-50" style="padding-left: 10px; padding-right: 10px;">
            <div class="panel-body" style="padding: 20px;">
                <form action="{{ route('ftplogin') }}" method="POST">
                    @csrf
                    <div class="form-group text-center mb-5 mt-5">
                        <h2>FTP Login</h2>
                        <h6>Sign in to your account to continue.</h6>
                    </div>
                    <div class="form-group mb-lg mt-lg">
                        <label>Address</label>
                        <div class="input-group input-group-icon">
                            <input id ="address" type="text" class="form-control input-lg @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus
                                placeholder="Domain or IP hosting"/>
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                        <i class="fa fa-desktop"></i>
                                </span>
                            </span>
                            {{--@error('email')--}}
                            {{--<strong>{{ $message }}</strong>--}}
                            {{--@enderror--}}
                        </div>
                    </div>
                    <div class="form-group mb-lg">
                        <label>Username</label>
                        <div class="input-group input-group-icon">
                            <input id ="username" type="text" class="form-control input-lg @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" />
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                        <i class="fa fa-user"></i>
                                </span>
                            </span>
                            {{--@error('email')--}}
                            {{--<strong>{{ $message }}</strong>--}}
                            {{--@enderror--}}
                        </div>
                    </div>
                    <div class="form-group mb-lg">
                        <div class="clearfix">
                            <label class="pull-left">Password</label>
                        </div>
                        <div class="input-group input-group-icon">
                            <input name="password" id="password" type="password" class="form-control input-lg @error('password') is-invalid @enderror" required autocomplete="current-password" />
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </span>
                            {{--@error('password')--}}
                            {{--<strong>{{ $message }}</strong>--}}
                            {{--s                            @enderror--}}
                        </div>
                    </div>

                    <!--
                    <div class="row mb-lg">
                        <div class="col-sm-8">
                            <div class="checkbox-custom checkbox-default">
                                <input id="RememberMe" name="rememberme" type="checkbox"/>
                                <label for="RememberMe">Remember Me</label>
                            </div>
                        </div>
                    </div>
                    -->

                    <div class="row mt-5 mb-5">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary col-sm-12" style="font-size: 20px;">{{ __('Log In') }}</button>
                        </div>
                    </div>
                    <!--
                        <span class="mt-lg mb-lg line-thru text-center text-uppercase">
                            <span>or</span>
                        </span>

                        <div class="mb-xs text-center">
                            <a class="btn btn-facebook mb-md ml-xs mr-xs">Connect with <i class="fa fa-facebook"></i></a>
                            <a class="btn btn-twitter mb-md ml-xs mr-xs">Connect with <i class="fa fa-twitter"></i></a>
                        </div>

                        <p class="text-center">Don't have an account yet? <a href="pages-signup.html">Sign Up!</a></p>
                    -->
                     <div class="mb-xs text-center">
                            <a href="https://www.facebook.com/SoftwareRG.Oficial" target="_blank" class="btn btn-facebook mb-md ml-xs mr-xs">FACEBOOK <i class="fa fa-facebook"></i></a>
                            <a href="https://api.whatsapp.com/send?phone=593998732257&text=Hello%20I%20want%20more%20information%20about%20the%20AntiHack%20%F0%9F%91%8D" target="_blank" class="btn btn-twitter mb-md ml-xs mr-xs">WhatsApp <i class="fa fa-whatsapp"></i></a>
                        </div>

                       <!-- <p class="text-center">Don't have an account yet? <a href="pages-signup.html">Sign Up!</a></p> -->
                </form>
            </div>
        </div>

        <p class="text-center text-muted mt-md mb-md">&copy; SoftwareRG All rights reserved.</p>
    </div>

</section>

<!-- end: page -->

<!-- Vendor -->
<script src="assets/vendor/jquery/jquery.js"></script>


<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="assets/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="assets/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="assets/javascripts/theme.init.js"></script>
@if(Session::has('message'))
    <script>
        $(function(){
            toastr.warning("{{ Session::get('message') }}");
        })
    </script>
@endif
</body>
</html>
