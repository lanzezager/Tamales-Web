<nav class="col-md-2 d-none d-md-block bg-light sidebar" >
      <div class="sidebar-sticky">
        <ul class="nav flex-column" id="accordion">
          <li class="nav-item">
            <a class="nav-link @yield('active_inicio')" href="/panel_usuario">
              <span data-feather="home"></span>
              Inicio<span class="sr-only">(current)
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @yield('active_datos')" href="/panel_usuario/datos" id="datos">
              <span data-feather="user"></span>
             Mis Datos
            </a>
          </li>
          <li class="nav-item" id="item_padre">
            <a class="nav-link collapsed @yield('active_pdv')" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              <span data-feather="shopping-bag"></span>
              Market
            </a>
            <div id="collapseOne" class="collapse @yield('expand_collapse')">
            <ul class="nav flex-column" >
              <li class="nav-item d-block" style="margin-left: 1em">
                <a class="nav-link @yield('active_pdv')" href="/pdv">
                  <span data-feather="shopping-cart"></span>
                  Punto de Venta
                </a>
              </li>
              <li class="nav-item d-block" style="margin-left:1em">
                <a class="nav-link @yield('active_e_inv')" href="/panel_usuario/market/e_inventario">
                  <span data-feather="box"></span>
                  Entrega de Inventario
                </a>
              </li>
              <li class="nav-item d-block" style="margin-left: 1em"> 
                <a class="nav-link @yield('active_r_inv')" href="/panel_usuario/market/r_inventario">
                  <span data-feather="box"></span>
                  Recibo de Inventario
                </a>
              </li>
               <li class="nav-item d-block" style="margin-left: 1em"> 
                <a class="nav-link @yield('active_sucursales')" href="/panel_usuario/market/sucursales">
                  <span data-feather="map-pin"></span>
                  Sucursales
                </a>
              </li>
            </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link @yield('active_pedidos')" href="/panel_usuario/pedidos">
              <span data-feather="truck"></span>
              Pedidos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @yield('active_productos')" href="/panel_usuario/productos">
              <span data-feather="package"></span>
              Productos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @yield('active_usuarios')" href="/panel_usuario/usuarios">
               <span data-feather="users"></span>
              Usuarios              
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  @yield('active_estadistica')" href="/panel_usuario/estadisticas" id="estadistica">
               <span data-feather="bar-chart-2"></span>
              Ventas         
            </a>
          </li>   <!--        
           <li class="nav-item">
            <a class="nav-link @yield('active_ajustes')" href="/panel_usuario/ajustes">
               <span data-feather="settings"></span>
              Ajustes              
            </a>
          </li>-->
        </ul>
        <!--
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="d-flex align-items-center text-muted" href="#">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li>
        </ul>
        -->
      </div>
    </nav>