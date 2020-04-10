<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/icono.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/icono.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>
        Iniciar sesión | linecode manager
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('css/material-dashboard.min.css?v=2.1.0') }}" rel="stylesheet"/>
</head>
<body class="off-canvas-sidebar">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="{{ url('/login') }}">Bienvenido a Line code Manager</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item  active ">
                    <a href="{{ url('/login') }}" class="nav-link">
                        <i class="material-icons">login</i> Inicia sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
<div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black"
         style="background-image: url({{ asset('img/Urabá-25.png') }}); background-size: cover; background-position: top center;">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                    <form class="form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="card card-login card-hidden">
                            <div class="card-header card-header-info text-center">
                                <h4 class="card-title">Iniciar sesión</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-description text-center">LINE CODE</p>
                                <div class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                              <i class="material-icons">email</i>
                                            </span>
                                        </div>
                                        <input type="email" name="email" class="form-control" placeholder="Email..." value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                </div>
                                <div class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                              <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input type="password" name="password" class="form-control" placeholder="Contraseña..." required autocomplete="current-password">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer justify-content-center">
                                <button type="submit" class="btn btn-info">Iniciar sesión</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <nav class="float-left">
                    <ul>
                        <li>
                            <a href="https://www.redingecor.com">
                                LINECODE
                            </a>
                        </li>
                        <li>
                            <a href="https://www.redingecor.com">
                                Acerca de
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright float-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    , hecho 100% con <i class="material-icons">favorite</i> por
                    <a href="https://www.linecode.com" target="_blank">Linecode</a>.
                </div>
            </div>
        </footer>
    </div>
</div>
<!--   Core JS Files   -->
<script src="{{ asset('js/core/jquery.min.js') }}"></script>
<script src="{{ asset('js/core/popper.min.js') }}"></script>
<script src="{{ asset('js/core/bootstrap-material-design.min.js') }}"></script>
<script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<script async defer src="{{ asset('js/buttons.js') }}"></script>
<!-- Chartist JS -->
<script src="{{ asset('js/plugins/chartist.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('js/material-dashboard.min.js?v=2.1.0') }}" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        md.checkFullPageBackgroundImage();
        setTimeout(function () {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);
    });
</script>
</body>
</html>
