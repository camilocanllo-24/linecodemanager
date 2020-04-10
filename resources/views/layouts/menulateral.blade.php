<div class="sidebar" data-color="orange" data-background-color="red" data-image="{{ asset('img/sidebar-3.jpg') }}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="icon">
        <a href="http://www.linecodemanager.com" class="simple-text logo-mini">
            v1
        </a>
        <a href="http://www.linecodemanager.com" class="simple-text logo-normal">
            {{ Auth::user()->agency->isp->nombre }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img
                    src="https://icons-for-free.com/download-icon-anonymous+app+contacts+open+line+profile+user+icon-1320183042822068474_48.png"/>
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
          <span>
            {{ Auth::user()->nombres }}
            <b class="caret"></b>
          </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.edit', Auth::user()->id) }}">
                                <span class="sidebar-mini"> EP </span>
                                <span class="sidebar-normal"> Editar Perfil </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item {{ (Request::is('home') || Request::is('/')) ? 'active' : '' }}">

                <a class="nav-link" href="/home">

                    <img src="img/home.png" alt="" width="200px" height="180px">
                    <p>Inicio</p>
                </a>
            </li>

            @if (Auth::user()->isSuperAdmin())
                <li class="nav-item {{ (Request::is('isps*') || Request::is('agencies*')) ? 'active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#businessMenu">

                        <img src="img/empresas.png"  alt="Gestión Empresas" width="250px" height="180px">
                        <p>
                             Gestión Empresas
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ (Request::is('isps*') || Request::is('agencies*')) ? 'show' : '' }}"
                         id="businessMenu">
                        <ul class="nav">
                            <li class="nav-item {{ (Request::is('isps*')) ? 'active' : '' }}">
                                <a class="nav-link" href="/isps">
                                    <span class="sidebar-mini">I</span>
                                    <span class="sidebar-normal">ISPs</span>
                                </a>
                            </li>
                            <li class="nav-item {{ (Request::is('agencies*')) ? 'active' : '' }}">
                                <a class="nav-link" href="/agencies">
                                    <span class="sidebar-mini">A</span>
                                    <span class="sidebar-normal">Agencias</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif


            <li class="nav-item {{ (Request::is('users*')
             || Request::is('subscribers*')
             || Request::is('nas*')
             || Request::is('services*')
             || Request::is('olts*')
             || Request::is('plans*'))
             || Request::is('tickets*')
             || Request::is('inventories*')
             || Request::is('payments*')
              ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#agencyMenu">
                    <img src="img/crecimiento.png" alt="" width="180px" height="180px">
                    <p> Gestión Agencia
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ (Request::is('users*')
                    || Request::is('subscribers*')
                    || Request::is('nas*')
                    || Request::is('services*')
                    || Request::is('olts*')
                    || Request::is('plans*'))
                    || Request::is('tickets*')
                    || Request::is('inventories*')
                    || Request::is('payments*')
                     ? 'show' : '' }}" id="agencyMenu">
                    <ul class="nav">
                        @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                            <li class="nav-item {{ (Request::is('users*')) ? 'active' : '' }}">
                                <a class="nav-link" href="/users">
                                    <img src="img/users.png" alt="" width="100px" height="100px">
                                    <span class="sidebar-normal">Usuarios</span>
                                </a>
                            </li>
                        @endif

                        @if (!Auth::user()->isTecnico())
                            <li class="nav-item {{ (Request::is('subscribers*')) ? 'active' : '' }}">
                                <a class="nav-link" href="/subscribers">
                                    <img src="img/productos.png" alt="" width="100px" height="100px">
                                    <span class="sidebar-normal">Productos</span>
                                </a>
                            </li>


                            <li class="nav-item {{ (Request::is('services*')) ? 'active' : '' }}">
                                <a class="nav-link" href="/services">
                                    <span class="sidebar-mini"><i class="material-icons">tv</i></span>
                                    <span class="sidebar-normal">Servicios</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item {{ (Request::is('tickets*')) ? 'active' : '' }}">
                            <a class="nav-link" href="/tickets">
                                <span class="sidebar-mini"><i class="material-icons">assignment</i></span>
                                <span class="sidebar-normal">Tickets</span>
                            </a>
                        </li>

                        @if (Auth::user()->isSuperAdmin())
                        <!--subcategorias de inventario-->
                            <li class="nav-item {{ (Request::is('inventories*') || Request::is('type__a_materials*')) ? 'active' : '' }}">
                                <a class="nav-link" data-toggle="collapse" href="#type__a_materials">
                                    <i class="material-icons">assignment</i>
                                    <p> Inventario
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse {{ (Request::is('inventories*') || Request::is('type__a_materials*')) ? 'show' : '' }}"
                                     id="type__a_materials">
                                    <ul class="nav">
                                        <li class="nav-item {{(Request::is('inventories*')) ? 'active' : '' }}">
                                            <a class="nav-link" href="/inventories">
                                                <span class="sidebar-mini"><i class="material-icons">assignment</i></span>
                                                <span class="sidebar-normal">Inventario</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (Request::is('type__a_materials*')) ? 'active' : '' }}">
                                            <a class="nav-link" href="/type__a_materials">
                                                <span class="sidebar-mini"><i class="material-icons">assignment</i></span>
                                                <span class="sidebar-normal">Salida</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif


                        @if (!Auth::user()->isTecnico())
                            <li class="nav-item {{ (Request::is('payments*')) ? 'active' : '' }}">
                                <a class="nav-link" href="/payments">
                                    <span class="sidebar-mini"><i class="material-icons">attach_money</i></span>
                                    <span class="sidebar-normal">Pagos</span>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->isSuperAdmin())
                            <li class="nav-item {{ (Request::is('plans*')) ? 'active' : '' }}">
                                <a class="nav-link" href="/plans">
                                    <span class="sidebar-mini"><i class="material-icons">attach_money</i></span>
                                    <span class="sidebar-normal">Planes</span>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->isSuperAdmin())
                            <li class="nav-item {{ (Request::is('nas*')) ? 'active' : '' }}">
                                <a class="nav-link" href="/nas">
                                    <span class="sidebar-mini"><i class="material-icons">router</i></span>
                                    <span class="sidebar-normal">NAS</span>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->isSuperAdmin())
                            <li class="nav-item {{ (Request::is('olts*')) ? 'active' : '' }}">
                                <a class="nav-link" href="/olts">
                                    <span class="sidebar-mini"><i class="material-icons">memory</i></span>
                                    <span class="sidebar-normal">OLTs</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>

