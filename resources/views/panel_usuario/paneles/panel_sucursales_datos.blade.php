
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
	<a href="/panel_usuario/market/sucursales" class="btn btn-outline-secondary btn-sm" style="margin-right:15px; margin-top: -8px;"><span data-feather="chevron-left"></span>Regresar</a>
	@if($nvo=='nvo')
		<h1 class="h2 text-left">Nueva Sucursal</h1>

		@section('nombre','')
		@section('direccion','')
		@section('telefono','')
		@section('ubicacion','')

		@section('acti','/panel_usuario/market/sucursales')
	@else
		
		@section('nombre',$markets->nombre)
		@section('direccion',$markets->direccion)
		@section('telefono',$markets->telefono)
		@section('ubicacion_link','<iframe src="'.$markets->ubicacion.'" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>')
		@section('ubicacion',$markets->ubicacion)
		@section('supervis',$superv)
		@section('supervis_id',$superv_id)
		@section('encarga',$encarg)
		@section('encarga_id',$encarg_id)

		@if($editar=='editar')
			<h1 class="h2 text-left">Editar Sucursal</h1>
			@section('editar','')
			@section('editar2','')
			@section('acti','/panel_usuario/market/sucursales/'.$markets->id)
		@else
			<h1 class="h2 text-left">Detalle Sucursal</h1>
			@section('editar','readonly')
			@section('editar2','disabled')
		@endif

	@endif
</div>

<form class ="form-group" method="POST" action="@yield('acti')" enctype="multipart/form-data" name="env_info" id="form_guarda_sucursal">
	
	@if($nvo!='nvo')
		@if($editar=='editar')
			@method('PUT')
		@endif
	@endif

	@csrf

	<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">

	<div class="form-row">
		<div class="form-group col" style="max-width: 450px">
			<div class="form-row">
				<div class="form-group col">
					<label>Nombre</label>
					<input type="text" value="@yield('nombre')" name="nombre" placeholder="" maxlength="30" class="form-control" style="max-width:420px; min-width:390px;" @yield('editar')>
				</div>
			</div>			
			<div class="form-row">
				<div class="form-group col" style="max-width: 220px">
					<label>Domicilio</label>
					<input type="text" value="@yield('direccion')" name="domicilio" placeholder="" maxlength="80" class="form-control" style="max-width:200px; min-width:150px;" @yield('editar')>
				</div>
				<div class="form-group col" style="max-width: 220px">
					<label>Teléfono</label>
					<input type="text" value="@yield('telefono')" name="telefono" placeholder="" maxlength="20" class="form-control" style="max-width:200px; min-width:150px;" @yield('editar')>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col" style="max-width: 220px">
					<label>Encargado</label>
					<select name="encargado" class="form-control" style="max-width:200px; min-width:150px; " @yield('editar2')  >
						@if($nvo=='nvo')
							<option value="0" disabled selected hidden>Selecciona Uno</option>
						@else
							<option value="@yield('encarga_id')"  selected hidden>@yield('encarga')</option>
						@endif
						@foreach($encargados as $encargado)
							<option value="{{$encargado[0]}}" >{{$encargado[1]}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col" style="max-width: 220px">
					<label>Supervisor</label>
					<select name="supervisor" class="form-control" style="max-width:200px; min-width:150px; " @yield('editar2')  >
						@if($nvo=='nvo')
							<option value="0" disabled selected hidden>Selecciona Uno</option>
						@else
							<option value="@yield('supervis_id')"  selected hidden>@yield('supervis')</option>
						@endif

						@foreach($supervisores as $supervisor)
							<option value="{{$supervisor[0]}}" >{{$supervisor[1]}}</option>
						@endforeach
					</select>
				</div>
			</div>
		<!--	<label class="d-block">Coordenadas</label> -->
			<div class="form-row">				
				<div class="form-group col" style="max-width: 450px">
					<label >Enlace Google Maps</label>
					<input type="text" value="@yield('ubicacion_link')" name="ubicacion" placeholder="" maxlength="9999" class="form-control" style="max-width:420px; min-width:390px; " @yield('editar')>
				</div>
			<!--	<div class="form-group col" style="max-width: 220px">
					<label>Longitud</label>
					<input type="text" value="" name="telefono" placeholder="" maxlength="80" class="form-control" style="max-width:200px; min-width:150px; " {{$editar}}>
				</div> -->
			</div>

		</div>
		<div class="form-group col" style="max-width: 450px;">
			<div class="form-row" style="max-width: 450px;">
				<label class="d-block" style="width: 300px;">Empleados</label>
				<select name="tipo_usuario" class="d-block form-control" style="max-width:200px; min-width:150px; " @yield('editar2')  id="usr">
					<option value="0" disabled selected hidden>Seleccionar</option>
					@if(count($empleados)>0)
						@foreach($empleados as $empleado)
							<option value="{{$empleado[0]}}" @yield('sel_1')>{{$empleado[1]}}</option>
						@endforeach
					@endif
				</select>
				<button type="button" class="btn btn-sm btn-outline-secondary d-block" id="add_emplead" style="margin-left: 10px;" onclick="add_empleado(this)" @yield('editar2')><span data-feather="plus"></span>Añadir</button>
			</div>
			<div class="form-row" style="max-width: 450px">
				<div class="table-responsive" style="margin-top: 15px;">
					<table class="table table-striped table-sm table-bordered table-hover" id="tabla_empleados">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nombre</th>
								<th>Acción</th>								
							</tr>
						</thead>
						<tbody id="tabla_empleado">
							@if($nvo=='nvo')
							@else
								@foreach($emplead as $empi)
									<tr id="id_fila_{{$empi[0]}}">
									<td scope="row" >{{$empi[0]}}</td>
									<td class="nombre_empleado">{{$empi[1]}}</td>
									<td class="accion"><button type="button" class="btn btn-sm btn-outline-secondary borrar_emple" id="{{$empi[0]}}" @yield('editar2')><span data-feather="x" data-toggle="tooltip" data-placement="top" title="Eliminar de la Lista"></span></button></td>
							   		</tr>
								@endforeach
							@endif
							<!-- <tr>
								<th scope="row" class="id_empleado"></th>
								<td class="nombre_empleado"></td>
								<td class="puesto_empleado"></td>
							</tr> -->
						</tbody>
					</table>
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
	<div class="form-row" style="max-width: 450px">
		<div class="form-group col">			
   			<iframe src="@yield('ubicacion')" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
		</div>
	</div>

	<input type="text" name="lista_empleados" style="visibility: hidden" id="lista_empleados">
</form>



@section('script_opc_final')
      <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
      </script>
<script type="text/javascript">
	jQuery(document).ready(function() {

		$('#enviar').click(function() {
			var filas = [];
			$('#tabla_empleados tbody tr').each(function() {
				var emp_id = $(this).find('td').eq(0).text();
				var nombre = $(this).find('td').eq(1).text();
				var puesto = $(this).find('td').eq(2).text();
				
				var fila = {
					emp_id,
					nombre,
					puesto
				};
				filas.push(fila);
			});
			var token=$('#token').val();
			var ruta="/panel_usuario/market/sucursales";
			var string_j = JSON.stringify(filas);

			$('#lista_empleados').val(string_j);

			//console.log(filas);
			//console.log(token);
			console.log(string_j);
			//alert(string_j);

	/*		$.ajax({
				url: ruta,
				headers:{'X-CSRF-Token': token},
				type: "POST",
				dataType : 'json',
				data: {
					valores:filas				
				},
				
				
				success: function(data) { 
					//alert(data);
					console.log('exito');
				},

				error: function(data){
					console.log('algo falló');
				},
				
		   
			}); */

		});
	});
</script>

<script type="text/javascript">
	/*$(document).on('click', '.borrar_emple', function (event) {
    	event.preventDefault();
    	var index=$('.borrar_emple').attr('id');
    	$("#id_fila_" + index).remove();
	});*/

	$(document).ready(function(){
      $('body #tabla_empleados').on('click', 'button', function(){
        //event.preventDefault();
    	var index=$(this).attr('id');
    	console.log(index);
    	$("#id_fila_" + index).remove();

      })
    })
</script>

<script type="text/javascript">
	
	function add_empleado() {
		var nvo_nom=document.getElementById("usr").value;
		var tabla = document.getElementById("tabla_empleado").innerHTML;
		var emp = @json($empleados);
		var count = Object.keys(emp).length;
		
		var i=0;
		var id="",nom="";

		//console.log(emp);

		if(nvo_nom!='0'){
			while(i<count){
				if(emp[i][0]==nvo_nom){
					id=emp[i][0];
					nom=emp[i][1];
					i=count+1;
				}
				i++;
			}

			if(document.getElementById("id_fila_"+id)==null){
				
				var linea='<tr id="id_fila_'+id+'">'+
									'<td scope="row" >'+id+'</td>'+
									'<td class="nombre_empleado">'+nom+'</td>'+
									'<td class="accion"><button type="button" class="btn btn-sm btn-outline-secondary borrar_emple" id="'+id+'"><span data-feather="x" data-toggle="tooltip" data-placement="top" title="Eliminar de la Lista">X</span></button></td>'+
							   '</tr>';
				document.getElementById("tabla_empleado").innerHTML=tabla+linea;
			
			}else{
				console.log('ya existe id');
			}
		}
	}


</script>
@endsection