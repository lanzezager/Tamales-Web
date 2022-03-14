
@include('panel_usuario.common.success')
@include('panel_usuario.common.errors')

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
	.dlk-radio input[type="radio"],
	.dlk-radio input[type="checkbox"] 
	{
		margin-left:-99999px;
		display:none;
	}
	.dlk-radio input[type="radio"] + .fa ,
	.dlk-radio input[type="checkbox"] + .fa {
		opacity:0.0
	}
	.dlk-radio input[type="radio"]:checked + .fa,
	.dlk-radio input[type="checkbox"]:checked + .fa{
		opacity:1
	}
</style>

<div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<a href="/panel_usuario/market/e_inventario" class="btn btn-outline-secondary btn-sm" style="margin-right:15px; margin-top: -8px;"><span data-feather="chevron-left"></span>Regresar</a>
	
	@if($nvo=='nvo')
		<h1 class="h2 text-left">Nueva Entrega</h1>
		@section('cambio','')
		@section('valor_total',0)
		@section('acti','/panel_usuario/market/e_inventario')

		@if($us_sup==0)

		@else
			
			@section('supervis',$usuario->nombre_s.' '.$usuario->apellido_s)
			@section('supervis_id',$usuario->id)
			@section('editar3','disabled')
		@endif

		@section('tipo_form',1);
	@else	
		@section('market_id',$sucursal[0])
		@section('market_name',$sucursal[1])		
		@section('cambio',$cambio_entregado)
		@section('valor_total',$val_tot_final)
		@section('observacion',$observacion)

		@if($editar=='editar')
			<h1 class="h2 text-left">Editar Entrega</h1>
			@section('editar','')
			@section('editar2','')
			@section('acti','/panel_usuario/market/e_inventario/'.$e_inventario->id)
			@section('tipo_form',2);
			@section('supervis',$usuario->nombre_s.' '.$usuario->apellido_s)
			@section('supervis_id',$usuario->id)
		@else
			<h1 class="h2 text-left">Detalle Entrega</h1>
			@section('receptor_id',$receptor[0])
			@section('receptor',$receptor[1])
			@section('supervis_id',$supervisor[0])
			@section('supervis',$supervisor[1])
			@section('editar','readonly')
			@section('editar2','disabled')
			@section('tipo_form',3);
		@endif

	@endif
</div>



<form class ="form-group" method="POST" action="@yield('acti')" enctype="multipart/form-data" name="env_info" id="form_guarda_e_inventario">
	
	@if($nvo!='nvo')
		@if($editar=='editar')
			@method('PUT')
		@endif
	@endif

	@csrf

	<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
	<input type="hidden" name="tipo_form" value="@yield('tipo_form')" id="tipo_form">
	<input type="hidden" name="receptor" value="{{$receptor[0]}}" id="receptor">	
	<div id="muestra_errores"></div>
	
	<div class="form-row">
		<div class="form-group col" style="max-width: 900px">
			<div class="form-row">
				<div class="form-group col" style="max-width: 220px">
					<label>Sucursal</label>
					<select name="sucursal" class="form-control" style="max-width:200px; min-width:150px; " @yield('editar2') id="mercado">
						@if(($nvo=='nvo')||($editar=='editar'))
							<option value="0" disabled selected hidden>Selecciona Uno</option>
							@foreach($markets as $market)
								@if($sucursal[0]==$market[0])
									<option value="{{$market[0]}}" selected>{{$market[1]}}</option>
								@else
									<option value="{{$market[0]}}" >{{$market[1]}}</option>
								@endif
							@endforeach
						@else
							<option value="@yield('market_id')"  selected hidden>@yield('market_name')</option>
						@endif						
					</select>
				</div>				
			</div>
		
			<div class="form-row" style="max-width: 900px;">
				<div class="form-group col" style="max-width: 340px">
					<label class="d-block" style="width: 300px;">Productos</label>
					<select name="tipo_usuario" class="d-block form-control" style="max-width:320px; min-width:150px; " @yield('editar2')  id="usr">
						<option value="0" disabled selected hidden>Seleccionar</option>
							@if(($nvo=='nvo')||($editar=='editar'))
								@foreach($productos as $producto)
									<option value="{{$producto->id}}" @yield('sel_1')>{{$producto->nombre}}</option>
								@endforeach	
							@endif
					</select>
				</div>
				<div class="form-group col" style="max-width:170px">
					<label>Existencias</label>
					<div style="width:150px; ">
						<input type="number" value="0" min="0" max="999" step="1" name="existencias" placeholder="0" class="form-control" id="cantidad" @yield('editar2')>
					</div> 
				</div>
				<div class="form-group col" style="max-width: 220px">
					<button type="button" class="btn  btn-outline-secondary d-block" id="add_emplead" style="margin-top: 31px;" onclick="add_productos(this)" @yield('editar2')><span data-feather="plus"></span> Añadir</button>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col" style="max-width: 900px">
					<div class="table-responsive" style="margin-top: 15px;">
						<table class="table table-striped table-sm table-bordered table-hover" id="tabla_productos_entrega">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nombre</th>
									<th>Precio Unitario</th>
									<th>Cantidad</th>
									<th>Total</th>	
									<th>Acción</th>								
								</tr>
							</thead>
							<tbody id="tabla_productos">
								@if($nvo=='nvo')
								@else
									@foreach($productos_e as $prod)
									<tr id="id_fila_{{$prod['id_producto']}}">
										<td scope="row" >{{$prod['id_producto']}}</td>
										<td class="nombre_producto">{{$prod['nombre']}}</td>
										<td class="precio_producto">{{$prod['precio_u']}}</td>
										<td class="cantidad_producto">{{$prod['cantidad']}}</td>
										<td id="valor_total_{{$prod['id_producto']}}">{{$prod['valor']}}</td>
										<td class="accion"><button type="button" @yield('editar2') class="btn btn-sm btn-outline-secondary borrar_emple" id="{{$prod['id_producto']}}"><span data-feather="x" data-toggle="tooltip" data-placement="top" title="Eliminar de la Lista">X</span></button></td>
									</tr>
									@endforeach
								@endif								
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="form-row">				
				<div class="form-group col" style="max-width:350px;">				
					<label>Supervisor que Entrega</label>
					<select name="supervisor" class="form-control" style="max-width:370px; min-width:280px;" @yield('editar2')>
						@if(($nvo=='nvo')||($editar=='editar'))
							@if($us_sup==0)
								<option value="0" disabled selected hidden>Selecciona Uno</option>
							@else
								<option value="@yield('supervis_id')" selected="selected">@yield('supervis')</option>
							@endif
							@if($supervisores != 'nada')
								@foreach($supervisores as $supervisor)
									<option value="{{$supervisor[0]}}" >{{$supervisor[1]}}</option>
								@endforeach
							@endif
						@else
							<option value="@yield('supervis_id')" selected="selected">@yield('supervis')</option>
						@endif
					</select>
				</div>
				<div class="form-group col" style="max-width:350px;">				
					<label>Empleado que Recibe</label>
					<select name="receptor" class="form-control" style="max-width:370px; min-width:280px;" @yield('editar2') id="sel_empleados">
						@if($nvo=='nvo')
							<option value="0" disabled selected hidden>Primero Elija la Sucursal</option>
						@else
							@if($editar=='editar')
							@else
								<option value="@yield('receptor_id')"  selected hidden>@yield('receptor')</option>
							@endif
						@endif						
					</select>
				</div>
				<div class="form-group col" style="max-width: 160px;">
					<label>Cambio Entregado</label>
					<div class="input-group" style="  width:150px;">
						<div class="input-group-prepend">
							<span class="input-group-text"><span data-feather="dollar-sign"></span></span>
						</div>
						<input type="text" class="form-control" id="cambio" value="@yield('cambio')" name="cambio" placeholder="" onkeypress="return filterFloat(event,this,'decimal');" onpaste="return false" @yield('editar')>
					</div>	
				</div>
				<div class="form-group col" style="max-width: 220px">
					<label>Valor Total Entregado</label>
					<div class="input-group" style="  width:150px;">
						<div class="input-group-prepend">
							<span class="input-group-text"><span data-feather="dollar-sign"></span></span>
						</div>
						<input type="text" class="form-control" id="gran_total" value="@yield('valor_total')" name="gran_total" placeholder="" onkeypress="return filterFloat(event,this,'decimal');" onpaste="return false" readonly>
					</div>	
				</div>		
			</div>
			<div class="form-row">
				<div class="form-group col" style="max-width: 900px">
					<label >Observaciones</label>
					<input id="observaciones" type="text" value="@yield('observacion')" name="observacion" placeholder="" maxlength="9999" class="form-control" style="max-width:900px; min-width:390px; " @yield('editar')>
				</div>
			</div>
		</div>		
	</div>

	<div class="form-row" style="max-width: 450px">
		<div class="form-group col">
			@if($editar=='editar'||$nvo=='nvo')
				<button type="submit" class="btn btn-primary btn-lg d-block" id="enviar">Guardar</button>
			@endif
		</div>
	</div>
	<input type="text" name="lista_productos" style="visibility: hidden" id="lista_productos">
</form>

@section('script_opc_final')
	<script type="text/javascript">
		$(function () {
	    	$('[data-toggle="tooltip"]').tooltip()
	    })
	</script>
	<!-- Script inferior sirve para el selector de unidades -->
	<script>
	    $("input[type='number']").inputSpinner();
	</script>

	<script type="text/javascript" src="{{ asset('/js/filtro_decimales.js') }}"></script>	
	<script type="text/javascript" src="{{ asset('/js/j_exporta_productos_entrega_inv.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/j_entrega_inv.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/j_add_productos_entrega_inv.js') }}"></script>	

	<script type="text/javascript">
		if(($("#tipo_form").val())<3){
			try{
				window.emple = @json($empleados_market);
			}catch{}
		}	
		window.products = @json($productos);

		/*$("#cambio").click(function(){
  			var cant = $(this).val();
			$(this).val(cant);
		}); */

	</script>
@endsection

