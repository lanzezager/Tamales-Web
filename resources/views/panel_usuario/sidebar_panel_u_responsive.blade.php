<div id="sidebar_menu_lz" class="col-md-2  d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
      <ul class="nav flex-column">
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
                <a class="nav-link  @yield('active_sucursales')" href="/panel_usuario/market/sucursales">
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
          </li>  <!--       
           <li class="nav-item">
            <a class="nav-link @yield('active_ajustes')" href="/panel_usuario/ajustes">
               <span data-feather="settings"></span>
              Ajustes              
            </a>
          </li> -->
        </ul>
    </div> 
  </div>