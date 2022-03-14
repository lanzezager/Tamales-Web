@extends('layouts.app')

@section('encabezado_opc')
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/dashboard_pdv.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/dash_responsive_pdv.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/pdv_view.css')}}">
   
@endsection

@section('titulo','Punto de Venta')

@section('contenido')
@include('pdv.modal_pagar')

    <div id="botones_menu">
        <a href="#" class="btn btn btn-outline-secondary movil_boton" id="movil_boton_derecha" ><span data-feather="arrow-left-circle" style="height: 24px; width: 24px;"></a>
        <a href="#" class="btn btn btn-outline-secondary movil_boton" id="movil_boton_izquierda" ><span data-feather="arrow-right-circle" style="height: 24px; width: 24px;"></a>
    </div>

	<div class="container-fluid clearfix">	
        <div class="pt-2 mb-2 justify-content-start align-items-center border-bottom titulo_main" style="top:55px;  position: fixed; z-index: 1000; background-color: #fff; width:100%;">
                <h2 class="h3 text-left" style="margin-left: 15px;">Sucursal: {{$sucursal[0]->nombre}} E_{{$num_entrega}}</h2>

            </div>       
		<div role="main" id="panel" class="col-md-9 col-lg-10 px-4 overflow-auto" style="margin-left: -15px; width: 80%;  max-width: 110%; top:20px;" >
            @include('pdv.panel_pdv')			
		</div>	    	
	@include('pdv.sidebar_panel_u')	    
	</div>    
@endsection

@section('script_opc_final')
    <script>
        $("input[type='number']").inputSpinner();
    </script>
    <script type="text/javascript">
        window.products = @json($productos);
    </script>
    <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script type="text/javascript" src="{{ asset('/js/filtro_enteros.js') }}"></script>
    <script src="{{ asset('/js/lz_responsive_pdv.js') }}"></script>
    <script src="{{ asset('/js/j_add_items_al_carrito_pdv.js') }}"></script>
    <script src="{{ asset('/js/j_add_confirma_pago.js') }}"></script>
    <script src="{{ asset('/js/j_lista_items_compra.js') }}"></script>
@endsection