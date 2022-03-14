@switch($zona)
    @case('inicio')
      @include('panel_usuario.paneles.panel_inicio')
    @break
    
    @case('datos')
      @include('panel_usuario.paneles.panel_datos')
    @break

    @case('pdv')
      @section('active_pdv','active')
    @break

    @case('entrega_inventario')
      @include('panel_usuario.paneles.panel_entrega_inv')
    @break

    @case('entrega_inventario_datos')
      @include('panel_usuario.paneles.panel_entrega_inv_datos')
    @break

    @case('entrega_inventario_vistazo')
      @include('panel_usuario.paneles.panel_entrega_inv_datos')
    @break

    @case('entrega_inventario_editar')
      @include('panel_usuario.paneles.panel_entrega_inv_datos')
    @break

    @case('recibe_inventario')
      @include('panel_usuario.paneles.panel_recibe_inv')
    @break

    @case('recibe_inventario_datos')
      @include('panel_usuario.paneles.panel_recibe_inv_datos')
    @break

    @case('recibe_inventario_vistazo')
      @include('panel_usuario.paneles.panel_recibe_inv_datos')
    @break

    @case('recibe_inventario_editar')
      @include('panel_usuario.paneles.panel_recibe_inv_datos')
    @break
    
    @case('sucursales')
      @include('panel_usuario.paneles.panel_sucursales')
    @break

    @case('sucursales_datos')
      @include('panel_usuario.paneles.panel_sucursales_datos')
    @break

    @case('pedidos')
      @include('panel_usuario.paneles.panel_pedidos')
    @break

    @case('productos')
      @include('panel_usuario.paneles.panel_productos')
    @break

    @case('add_productos')
      @include('panel_usuario.paneles.panel_add_productos')
    @break

    @case('usuarios')
      @include('panel_usuario.paneles.panel_usuarios')
    @break

    @case('estadisticas')
      @include('panel_usuario.paneles.panel_est')
    @break

    @case('ajustes')
      @include('panel_usuario.paneles.panel_ajustes')
    @break

    @default
    @break
  @endswitch

  