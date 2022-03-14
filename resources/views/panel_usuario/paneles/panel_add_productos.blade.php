
@include('panel_usuario.common.success')
@include('panel_usuario.common.errors')

@switch($msg)
	@case('nvo')
		@section('tittle','Nuevo')
		@section('action_form','/panel_usuario/productos')
	@break

	@case('edit')
		@section('tittle','Editar')
		@section('action_form','/panel_usuario/productos/'.$producto->id)
	@break

	@case('show')
		@section('tittle','Detalle')
	@break
@endswitch

<div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	@yield('back_buttonn')<a href="/panel_usuario/productos" class="btn btn-outline-secondary btn-sm" style="margin-right:15px; margin-top: -8px;"><span data-feather="chevron-left"></span>Regresar</a>	
	<h1 class="h2">@yield('tittle') Producto</h1>
</div>

@if($modo_edit=='on')
	@section('activa_prod','')
@else
	@section('activa_prod','readonly')
	@section('activa_prod_2','disabled')
@endif

@if($nvo=='on')
	@section('default_sel','disabled selected hidden')

	@section('nombre','')
	@section('descripcion','')
	@section('precio','')
	@section('existencias','')
	@section('id_categoria','')
	@section('activo','')
	@section('imagen','default.png')
@else
	@switch($producto->id_categoria)
		@case(1)
			@section('sel_1','selected')
		@break

		@case(2)
			@section('sel_2','selected')
		@break

		@case(3)
			@section('sel_3','selected')
		@break

		@case(4)
			@section('sel_4','selected')
		@break

		@case(5)
			@section('sel_5','selected')
		@break

		@case(6)
			@section('sel_6','selected')
		@break
	@endswitch

	@if($producto->activo==1)
		@section('produ_activo','checked')
	@else
		@section('produ_activo','')
	@endif

	@section('nombre',$producto->nombre)
	@section('descripcion',$producto->descripcion)
	@section('precio',$producto->precio)
	@section('existencias',$producto->existencias)
	@section('id_categoria',$producto->id_categoria)
	@section('activo',$producto->activo)
	@section('imagen',$producto->imagen)
	
	@if($producto->id_categoria==6)
		@section('items',$producto->items_combo)
		@section('vig_desde',$producto->vig_desde)
		@section('vig_hasta',$producto->vig_hasta)
	@endif
	
@endif

<form class ="form-group" method="POST" action="@yield('action_form')" enctype="multipart/form-data">
	@if($msg=='edit')
		@method('PUT')
	@else
	
	@endif

	@csrf 
	<div class ="form-row">
		<div class="form-group col" style="max-width: 450px">
			<div class ="form-row">
				<div class="form-group col">
					<label class="d-block">Nombre</label>
					<input type="text" value="@yield('nombre')" name="nombre" placeholder="" maxlength="34" class="form-control d-block" style="max-width:422px;" @yield('activa_prod')>
				</div>
			</div>
			<div class ="form-row">
				<div class="form-group col">
					<label class="d-block">Descripción</label>
					<input type="text" value="@yield('descripcion')" name="descripcion" placeholder="" maxlength="255" class="form-control d-block" style="max-width:422px;" @yield('activa_prod')>
				</div>
			</div>
			<div class ="form-row">
				<div class="form-group col">
					<label>Precio</label>
					<div class="input-group" style="  width:150px;">
						<div class="input-group-prepend">
							<span class="input-group-text"><span data-feather="dollar-sign"></span></span>
						</div>
						<input type="text" class="form-control" id="costo" value="@yield('precio')" name="precio" placeholder="" onkeypress="return filterFloat(event,this,'decimal');" onpaste="return false" @yield('activa_prod')>
					</div>
				</div>
				<div class="form-group col">
					<!-- <label>Existencias</label>
					<div style="width:150px; ">
						<input type="number" value="@yield('existencias')" min="0" max="999" step="1" name="existencias" placeholder="0" class="form-control" @yield('activa_prod_2')>
					</div> -->
					<label>Categoría</label>
						<select name="id_categoria" class="form-control" style="width:151px;" @yield('activa_prod_2') id="catego_prod" >
							<option value="0" @yield('default_sel')>Selecciona Una</option>
							@foreach($catego_produ as $catego)
								<option value="{{$catego->id}}" 
								@if($nvo!='on')
									@if($producto->id_categoria==$catego->id)
										selected
									@endif
								@endif	

									>{{$catego->descripcion}}</option>
							@endforeach
							<!-- <option value="1" @yield('sel_1')>Comida</option>
							<option value="2" @yield('sel_2')>Bebida</option>
							<option value="3" @yield('sel_3')>Postre</option>
							<option value="4" @yield('sel_4')>Golosina</option> -->
						</select>
				</div>
			</div>
				<div id="fila_combo">
					<div class ="form-row">
						<div class="form-group col">
							<label class="d-block">Items</label>
							<input type="text" value="@yield('items')" name="items" placeholder="" maxlength="100" class="form-control d-block" aria-describedby="HelpBlock" style="max-width:422px;" @yield('activa_prod')>
							<small id="HelpBlock" class="form-text text-muted"> Ingrese el id de los productos que conformaran el paquete separados por una coma</small>
						</div>					
					</div>
					<div class ="form-row">
						<div class="form-group col">
							<label class="d-block">Vigencia</label>
							<input type="date" name="combo_desde" value="@yield('vig_desde')" class="form-control d-block" aria-describedby="HelpBlock_fd" @yield('activa_prod')>
							<small id="HelpBlock_fd" class="form-text text-muted"> Desde</small>
						</div>
						<div class="form-group col">

							<input type="date" name="combo_hasta" value="@yield('vig_hasta')" class="form-control d-block" aria-describedby="HelpBlock_fh" @yield('activa_prod') style="margin-top: 2.15em;">
							<small id="HelpBlock_fh" class="form-text text-muted"> Hasta</small>
						</div>				
					</div>	
				</div>
					
				<div class ="form-row">
					<div class="form-group col">
						<label class="d-block">Disponibilidad</label>
						<input type="checkbox" name="activo" data-toggle="toggle" data-on="Activada" data-off="Desactivada" data-onstyle="outline-primary" data-offstyle="outline-secondary" style="margin-bottom: 10px;" @yield('activa_prod_2') @yield('produ_activo')>
					</div>					
				</div>	
		</div>
		<div class="form-group col" style="max-width: 450px">
			<label class="d-block">Imagen</label>
			<img class="img-fluid rounded border d-block" id="imagen_preview" src="/images/productos/@yield('imagen')" style="width:auto; max-width:280px; min-height:225px; max-height:333px; margin-bottom: 1rem;"/>
			<div class="custom-file " style="width:310px;" >
				<input type="file" class="custom-file-input" id="CustomFile" name="imagen" accept="image/*" onchange="carga_pic_lz(this)" @yield('activa_prod_2')>
				<label class="custom-file-label" for="CustomFile" data-browse="Elegir">Seleccionar Archivo...</label>
			</div>
		</div>
	</div>

	@if($modo_edit=='on')
		<div class ="form-row" style="max-width: 450px">
			<div class="form-group col">
				<button type="submit" class="btn btn-primary btn-lg">Guardar</button>
			</div>
		</div>
	@else

	@endif
</form>

@section('script_opc_final')
	<script type="text/javascript">
		$(document).ready(lanzar_inicio);

		function lanzar_inicio () {
			bsCustomFileInput.init();
			/*$("#data_menos_boton").html("-");
			$("#data_mas_boton").html(`+`);*/

			if($('#catego_prod').val()==6){
				console.log('Max Combo');
				$('#fila_combo').css("visibility", "visible");
				$('#fila_combo').css("height", "20px");
				$('#fila_combo').css("position", "relative");
				$('#fila_combo').css("display", "contents");
			}else{
				$('#fila_combo').css("visibility", "hidden");
				$('#fila_combo').css("height", "0px");
				$('#fila_combo').css("position", "fixed");
				$('#fila_combo').css("display", "block");
			}

		}

		$('#catego_prod').change(function(){
			if($('#catego_prod').val()==6){
				console.log('Max Combo');
				$('#fila_combo').css("visibility", "visible");
				$('#fila_combo').css("height", "20px");
				$('#fila_combo').css("position", "relative");
				$('#fila_combo').css("display", "contents");
			}else{
				$('#fila_combo').css("visibility", "hidden");
				$('#fila_combo').css("height", "0px");
				$('#fila_combo').css("position", "fixed");
				$('#fila_combo').css("display", "block");
			}
		});
	</script>
	<!-- Script inferior sirve para el selector de unidades -->
	<script>
    	$("input[type='number']").inputSpinner();
	</script>
	
	<script type="text/javascript" src="{{ asset('/js/filtro_decimales.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/widget_preview_pic.js') }}"></script>
@endsection