<!doctype html>
<html lang="tr">

<head>

    <meta charset="utf-8" />
    <title>Yönetim Paneli Girişi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Yönetim Panel Girişi" name="description" />
    <meta content="Egemen KIRKAPLAN" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="">

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/libs/toastr/build/toastr.min.css') }}">
    <style>
        .auth-form-group-custom label.error {
            position: absolute !important;
            bottom: -27px !important;
            left: 0 !important;
            top: unset !important;
        }
    </style>
</head>

<body class="auth-body-bg">
<div class="home-btn d-none d-sm-block">
    <a href="index.html"><i class="mdi mdi-home-variant h2 text-white"></i></a>
</div>
<div>
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-lg-4">
                <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                    <div class="w-100">
                        <div class="row justify-content-center">
                            <div class="col-lg-9">
                                <div>
                                    <div class="text-center">
                                        <div>
                                            <a href="" class="logo"><img src="{{ asset('backend/assets/images/logo-innnoviz.png') }}" height="20" alt="logo"></a>
                                        </div>

                                        <h4 class="font-size-18 mt-4">Tekrar Hoş Geldiniz</h4>
                                        <p class="text-muted">Giriş Yapmak İçin Aşağıdaki Bilgileri Doldurunuz.</p>
                                    </div>

                                    <div class="p-2 mt-5">
                                        <form class="form-horizontal" id="loginForm" action="">
                                            @csrf
                                            <div class="form-group auth-form-group-custom mb-4">
                                                <i class="ri-user-2-line auti-custom-input-icon"></i>
                                                <label for="email">E-Posta Adresiniz</label>
                                                <input type="email" class="form-control" id="email" placeholder="E-Posta Adresiniz" name="email">
                                            </div>

                                            <div class="form-group auth-form-group-custom mb-4">
                                                <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                <label for="password">Şifreniz</label>
                                                <input type="password" class="form-control" id="password" placeholder="Şifreniz" name="password">
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="rememberMe" value="1" id="customControlInline">
                                                <label class="custom-control-label" for="customControlInline">Beni Hatırla</label>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <button class="btn btn-primary w-md waves-effect waves-light" id="loginButton" onclick="send()" type="button">Giriş Yap</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="mt-5 text-center">
                                        <p>© 2021 Vue Laravel Blog. Crafted with <i class="mdi mdi-heart text-danger"></i> by Egemen KIRKAPLAN</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="authentication-bg">
                    <div class="bg-overlay"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- JAVASCRIPT -->
<script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/toastr/build/toastr.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/pages/toastr.init.js') }}"></script>
<script src="{{ asset('backend/assets/js/app.js') }}"></script>
<script src="{{ asset('backend/assets/libs/validate/validate.min.js') }}"></script>
<script>
    function send() {
        $("#loginForm").submit();
    }

    $(document).keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $("#loginForm").submit();
        }
    });

    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8,
            },
        },
        messages: {
            email: {
                required: "E-Posta Adresi Girmediniz",
                email: "Doğru Bir E-Posta Adresi Giriniz",
            },
            password: {
                required: "Şifrenizi Girmediniz",
                minlength: "Şifre En Az 8 Karakterden Oluşur",
            },
        },
        submitHandler: function (form) {
            $("#loginButton").prop('disabled', true);
            $.ajax({
                url: "{{ route('panel.auth.login.process') }}",
                method: "POST",
                data: $("#loginForm").serialize(),
                success: function (res) {
                    if (parseInt(res.statusCode) > 0) {
                        toastr.success(res.statusMessage);
                        setTimeout(function () {
                            window.location.href = "{{ route('panel.home.index') }}";
                        }, 1900)
                    } else {
                        toastr.error(res.statusMessage);
                        $("#password").val(null);
                        $("#loginButton").prop('disabled', false);
                    }
                }
            });
        }
    });
</script>
</body>
</html>
