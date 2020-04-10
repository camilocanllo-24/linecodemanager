<!-- Navbar -->
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark fixed-top" role="navigation">
    <a class="navbar-brand" href="/isps">
    <img src="img/icono.png" width="30" height="30" alt="">
            {{ Auth::user()->agency->isp->nombre }}
    </a>
    <a class="navbar-brand" href="/users">
    {{ Auth::user()->nombres }}
    </a>
    <div class="container">
        <div class="navbar-wrapper">
            @yield('breadcrumb')
        </div>
        <div class="collapse navbar-collapse ">
                    <a  href="#" id="navbar-full" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="img/home.png" alt="" width="50" height="50">
                        <p class="d-lg-none d-md-block">
                            Menu
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu  fixed-top" aria-labelledby="navbarDropdown">
                        <div class="container">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="thumbnail">
                                      <a href="/home">
                                        <img src="img/home.png" alt="" width="150" height="150">
                                        <p class="caption">Hinicio</p> </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="thumbnail">
                                        <a href="/products">
                                        <img src="img/productos.png" alt="Productos" width="150" height="150">
                                        <p class="caption">Productos</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="thumbnail">
                                        <a href="/home">
                                        <img src="img/comprar.png" alt="" width="150" height="150">
                                        <p class="caption">Vender</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="thumbnail">
                                        <a href="/home">
                                        <img src="img/ordenes.png" alt="" width="150" height="150">
                                        <p class="caption">órdenes</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="thumbnail">
                                        <a href="/home">
                                        <img src="img/menu.png" alt="" width="150" height="150">
                                        <p class="caption">Menu</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>

        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <p class="d-lg-none d-md-block">
                            Cuenta
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">Perfil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
