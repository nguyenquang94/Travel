<!DOCTYPE html>
<html lang="en-us" id="extr-page">
    <head>
        @include("layouts.partials.htmlheader")
    </head>
    
    <body class="animated fadeInDown">

        <header id="header">

            <div id="logo-group">
                <span id="logo"><b>TIS</b></span>
            </div>

            <span id="extr-page-header-space"> <span class="hidden-mobile hiddex-xs">{{ trans('auth.login.needanaccount')}}</span> <a href="{{ url('register')}}" class="btn btn-danger">{{ trans('auth.login.createaccount')}}</a> </span>

        </header>

        <div id="main" role="main">

            <!-- MAIN CONTENT -->
            <div id="content" class="container">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
                        <h1 class="txt-color-red login-header-big">{{ trans('auth.login.info.tis_info.name')}}</h1>
                        <div class="hero">

                            <div class="pull-left login-desc-box-l">
                                <h4 class="paragraph-header">{{ trans('auth.login.info.tis_info.description')}}</h4>
                                <div class="login-app-icons">
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm">{{ trans('auth.login.info.tis_info.link1')}}</a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm">{{ trans('auth.login.info.tis_info.link2')}}</a>
                                </div>
                            </div>
                            
                            <img src="{{ asset('sa/img/demo/iphoneview.png') }}" class="pull-right display-image" alt="" style="width:210px">

                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <h5 class="about-heading">{{ trans('auth.login.info.tis_info.info1.text')}}</h5>
                                <p>
                                    {{ trans('auth.login.info.tis_info.info1.description')}}
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <h5 class="about-heading">{{ trans('auth.login.info.tis_info.info2.text')}}</h5>
                                <p>
                                    {{ trans('auth.login.info.tis_info.info2.description')}}
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="well no-padding">
                            <form method="POST" action="{{ url('/login') }}" id="login-form" class="smart-form client-form">
                                <header>
                                    {{ trans('auth.login.login_box.title')}}
                                </header>

                                <fieldset>
                                    {{ csrf_field() }}
                                    <section>
                                        <label class="label">{{ trans('auth.login.login_box.email')}}</label>
                                        <label class="input"> <i class="icon-append fa fa-user"></i>
                                            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                                            <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> {{ trans('auth.login.login_box.email_hint')}}</b></label>
                                    </section>

                                    <section>
                                        <label class="label">{{ trans('auth.login.login_box.password')}}</label>
                                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                                            <input type="password" name="password" required>
                                            <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> {{ trans('auth.login.login_box.password_hint')}}</b> </label>
                                        <div class="note">
                                            <a href="forgotpassword.html">{{ trans('auth.login.login_box.forgot_password')}}</a>
                                        </div>
                                    </section>

                                    <section>
                                        <label class="checkbox">
                                            <input type="checkbox" name="remember" checked="">
                                            <i></i>{{ trans('auth.login.login_box.remember_me')}}</label>
                                    </section>
                                </fieldset>
                                <footer>
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('auth.login.login_box.login_button')}}
                                    </button>
                                </footer>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--================================================== -->  

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <script src="js/plugin/pace/pace.min.js"></script>

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script> if (!window.jQuery) { document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');} </script>

        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script> if (!window.jQuery.ui) { document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script>

        <!-- IMPORTANT: APP CONFIG -->
        <script src="js/app.config.js"></script>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events         
        <script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

        <!-- BOOTSTRAP JS -->       
        <script src="js/bootstrap/bootstrap.min.js"></script>

        <!-- JQUERY VALIDATE -->
        <script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>
        
        <!-- JQUERY MASKED INPUT -->
        <script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>
        
        <!--[if IE 8]>
            
            <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
            
        <![endif]-->

        <!-- MAIN APP JS FILE -->
        <script src="js/app.min.js"></script>

        <script type="text/javascript">
            runAllForms();

            $(function() {
                // Validation
                $("#login-form").validate({
                    // Rules for form validation
                    rules : {
                        email : {
                            required : true,
                            email : true
                        },
                        password : {
                            required : true,
                            minlength : 3,
                            maxlength : 20
                        }
                    },

                    // Messages for form validation
                    messages : {
                        email : {
                            required : 'Please enter your email address',
                            email : 'Please enter a VALID email address'
                        },
                        password : {
                            required : 'Please enter your password'
                        }
                    },

                    // Do not change code below
                    errorPlacement : function(error, element) {
                        error.insertAfter(element.parent());
                    }
                });
            });
        </script>

    </body>
</html>