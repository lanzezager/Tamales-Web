 

  @switch($zona)
    @case('inicio')
      @section('active_inicio','active')
    @break
    
    @case('datos')
      @if($zona_2=='datos'){
        @section('active_datos','active')
      @else
        @section('active_usuarios','active')
      @endif
    @break

    @case('pdv')
      @section('active_pdv','active')
    @break

    @case('entrega_inventario')
      @section('active_e_inv','active')
      @section('expand_collapse','show')
    @break

    @case('entrega_inventario_datos')
      @section('active_e_inv','active')
      @section('expand_collapse','show')
    @break

     @case('entrega_inventario_vistazo')
      @section('active_e_inv','active')
      @section('expand_collapse','show')
    @break
    
    @case('entrega_inventario_editar')
      @section('active_e_inv','active')
      @section('expand_collapse','show')
    @break

    @case('recibe_inventario')
      @section('active_r_inv','active')
      @section('expand_collapse','show')
    @break

    @case('recibe_inventario_datos')
      @section('active_r_inv','active')
      @section('expand_collapse','show')
    @break

     @case('recibe_inventario_vistazo')
      @section('active_r_inv','active')
      @section('expand_collapse','show')
    @break
    
    @case('recibe_inventario_editar')
      @section('active_r_inv','active')
      @section('expand_collapse','show')
    @break

    @case('sucursales')
      @section('active_sucursales','active')
      @section('expand_collapse','show')
    @break

    @case('sucursales_datos')
      @section('active_sucursales','active')
      @section('expand_collapse','show')
    @break    

    @case('pedidos')
      @section('active_pedidos','active')
    @break

    @case('productos')
      @section('active_productos','active')
    @break

    @case('add_productos')
      @section('active_productos','active')
    @break

    @case('usuarios')
      @section('active_usuarios','active')
    @break

    @case('estadisticas')
      @section('active_estadistica','active')
    @break

    @case('ajustes')
      @section('active_ajustes','active')
    @break
   
    @default
    @break
  @endswitch