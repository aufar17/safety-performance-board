<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png"
        href="{{ url('https://www.ifpusa.com/wp-content/uploads/2021/11/KYB%20DRUPAL%20LOGO.png') }}">
    <title>
        Kayaba Indonesia
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Host+Grotesk:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />


</head>

<style>
    .otp-input {
        width: 40px;
        height: 50px;
        font-size: 24px;
        text-align: center;
        margin: 5px;
        border: 2px solid #ced4da;
        border-radius: 8px;
    }

    .otp-input:focus {
        border-color: #007bff;
        outline: none;
    }

    footer.footer {
        position: sticky;
        bottom: 0;
        background: white;
        z-index: 1000;
    }

    @media (max-height: 500px) {

        footer.footer {
            display: none;
        }
    }
</style>

<body class="d-flex flex-column min-vh-100">
    <main class="d-flex flex-grow-1 align-items-center justify-content-center">
        <section class="flex-grow-1">
            <div class="page-header min-vh-75">
                <div class="wrapper">
                    <div class="title text-center mb-4">
                        <img src="{{ asset('img/logo.png') }}" alt="">
                    </div>
                    @if (session('error'))
                    <div class="alert alert-danger text-dark text-center">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if ($errors->has('captcha'))
                    <div class="alert alert-danger text-dark text-center">Captcha tidak sesuai</div>
                    @endif
                    <div class="row no-gutters d-flex flex-column align-items-center">
                        <div class="container-main shadow-lg">
                            <div class="bottom w-100">
                                <header class="mb-4">SIGN IN</header>
                                <form action="{{ route('login-post') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-4">
                                        <input type="text" class="form-control" id="exampleInputUsername1"
                                            placeholder="" name="npk" />
                                        <label for="exampleInputUsername1" class="form-label">Username</label>
                                    </div>
                                    <div class="form-group mb-4">
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            name="password" placeholder="" />
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                    </div>
                                    <div class="captcha-container text-center mb-4">
                                        <img src="{{ route('captcha') }}?_={{ time() }}" id="captcha-img"
                                            class="img-fluid w-50 rounded border captcha-img">
                                        <button type="button" class="btn btn-warning mx-3" id="refresh-captcha">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="exampleInputCaptcha1" name="captcha"
                                            placeholder="" />
                                        <label for="exampleInputCaptcha1" class="form-label">Captcha</label>
                                    </div>
                                    <button type="submit" class="btn btn-login w-100 mt-3">Submit</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </section>
    </main>

    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <footer class="footer text-center mt-auto py-3">
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto text-center">
                    <p class="mb-0 text-secondary">
                        Copyright © <script>
                            document.write(new Date().getFullYear())
                        </script> PT Kayaba Indonesia
                    </p>
                </div>
            </div>
        </div>
    </footer>


    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script>
        {{ asset('js/modal-otp.js') }}
    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
        let captchaImg = document.getElementById("captcha-img");
        let refreshBtn = document.getElementById("refresh-captcha");

        refreshBtn.addEventListener("click", function () {
            captchaImg.src = "{{ url('captcha') }}?_=" + new Date().getTime(); 
        });
    });
    </script>
    <script>
        window.addEventListener('resize', function () {
            const footer = document.querySelector('footer.footer');
            if (window.innerHeight < 500) {
                footer.style.display = 'none';
            } else {
                footer.style.display = 'block';
            }
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>



</body>

</html>