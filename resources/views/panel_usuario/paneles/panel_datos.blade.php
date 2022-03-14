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

@include('panel_usuario.common.success')
@include('panel_usuario.common.errors')

@if($editar=='readonly')
	@section('activa_control','disabled')
	@section('default_mesg','Detalle Usuario')
@else
	@section('activa_control','')
	@section('default_sel','disabled selected hidden')
	@section('default_mesg','Editar Usuario')
@endif

<div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	@if($zona_2=='datos')
		<h1 class="h2 text-left">Mis Datos</h1>
	@else
		<a href="/panel_usuario/usuarios" class="btn btn-outline-secondary btn-sm" style="margin-right:15px; margin-top: -8px;"><span data-feather="chevron-left"></span>Regresar</a>
		<h1 class="h2 text-left">@yield('default_mesg')</h1>
	@endif
</div>



@if(in_array('Inactivo',$usuario_puesto))
	@section('activa_check','')
@else
	@section('activa_check','checked')
@endif

@foreach($usuario_puesto as $puesto)
	@switch($puesto)
		@case('Gerente')
			@section('cus_check_1','checked')
			@section('sel_1','selected')
		@break

		@case('Supervisor')
			@section('cus_check_2','checked')
			@section('sel_1','selected')
		@break

		@case('Vendedor')
			@section('cus_check_3','checked')
			@section('sel_1','selected')
		@break

		@case('Operativo')
			@section('cus_check_4','checked')
			@section('sel_1','selected')
		@break

		@case('Cliente')
			@section('sel_2','selected')			
		@break		
	@endswitch		
@endforeach

<form class ="form-group" method="POST" action="/panel_usuario/usuarios/{{$usuario_query->hash_user}}" enctype="multipart/form-data">
	@if($editar!='readonly')
		@method('PUT')
	@endif

	@csrf 
	<div class="form-row">
		<div class="form-group col" style="max-width: 450px">
			<div class="form-row">
				<div class="form-group col">
					<label>Nombre de Usuario</label>
					<input type="text" value="{{$usuario_query->name}}" name="name" placeholder="" maxlength="50" class="form-control" style="max-width:420px; min-width:390px; " readonly>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col" style="max-width: 220px">
					<label>Nombre(s)</label>
					<input type="text" value="{{$usuario_query->nombre_s}}" name="nombre_s" placeholder="" maxlength="50" class="form-control" style="max-width:200px; min-width:150px; " {{$editar}}>
				</div>
				<div class="form-group col" style="max-width: 220px">
					<label>Apellido(s)</label>
					<input type="text" value="{{$usuario_query->apellido_s}}" name="apellido_s" placeholder="" maxlength="50" class="form-control" style="max-width:200px; min-width:150px; " {{$editar}}>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col" style="max-width: 220px">
					<label>Domicilio</label>
					<input type="text" value="{{$usuario_query->domicilio}}" name="domicilio" placeholder="" maxlength="80" class="form-control" style="max-width:200px; min-width:150px; " {{$editar}}>
				</div>
				<div class="form-group col" style="max-width: 220px">
					<label>Teléfono</label>
					<input type="text" value="{{$usuario_query->telefono}}" name="telefono" placeholder="" maxlength="20" class="form-control" style="max-width:200px; min-width:150px; " {{$editar}}>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col" style="max-width: 220px">
					<label>Email</label>
					<input type="text" value="{{$usuario_query->email}}" name="email" placeholder="" maxlength="100" class="form-control" style="max-width:200px; min-width:150px; " readonly>
				</div>
				<div class="form-group col" style="max-width: 220px">
					<label>Tipo Usuario</label>
					<select name="tipo_usuario" class="form-control" style="max-width:200px; min-width:150px; " @yield('activa_control') onchange="bloquea_opc()" id="tipo_usr">
						<option value="0" @yield('default_sel')>Selecciona Una</option>
						<option value="6" @yield('sel_1')>Empleado</option>
						<option value="7" @yield('sel_2')>Cliente</option>
					</select>
				</div>
			</div>

			<!-- -->

			<div class="form-row" >
				<div class="form-group col" style="max-width: 220px">
					<label class="d-block" >Puesto</label>
					<div class="dlk-radio btn-group " style="max-width:185px; min-width:150px;">
						<label class="btn btn-secondary ">
							<input name="gerente" id="ger" class="form-control" type="checkbox" value="2" @yield('cus_check_1') @yield('activa_control')>
							<i class="fa fa-check glyphicon glyphicon-ok"></i>
							Gerente
						</label>
						<label class="btn btn-secondary ">
							<input name="supervisor" id="sup" class="form-control" type="checkbox" value="3" @yield('cus_check_2') @yield('activa_control')>
							<i class="fa fa-check glyphicon glyphicon-ok"></i>
							Supervisor
						</label>
						<label class="btn btn-outline-secondary ">
							<input name="vendedor" id="ven" class="form-control" type="checkbox" value="4" @yield('cus_check_3') @yield('activa_control')>
							<i class="fa fa-check glyphicon glyphicon-ok"></i>
							Vendedor
						</label>
						<label class="btn btn-outline-secondary ">
							<input name="operativo" id="ope" class="form-control" type="checkbox" value="5" @yield('cus_check_4') @yield('activa_control')>
							<i class="fa fa-check glyphicon glyphicon-ok"></i>
							Operativo
						</label>
					</div>
				</div>
			</div>
			<!-- -->
			<div class="form-row">
				<div class="form-group col">
					<label class="d-block">Acceso</label>
					<input type="checkbox" name="activo" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="outline-primary" data-offstyle="outline-danger" style="margin-bottom: 10px;"  @yield('activa_control') @yield('activa_check')>
				</div>
			</div>
		</div>
		<div class="form-group col" style="max-width: 415px">
			<div class="form-row">
				<div class="form-group col">
					<label class="d-block ">Foto</label>
					<img class="img-fluid rounded border d-block" id="imagen_preview" src="\images\users\{{$usuario_query->foto}}" style="width:auto; max-width:400px; min-height:300px; max-height:333px; margin-bottom: 10px;" />
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col">
					<div class="custom-file " style="max-width:392px; min-width:250px; margin-bottom:10px;" >
					<input type="file" class="custom-file-input" id="CustomFile" name="foto" {{$editar_file}} accept="image/*" onchange="carga_pic_lz(this)">
					<label class="custom-file-label" for="CustomFile" data-browse="Elegir">Seleccionar Archivo...</label>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-row" style="max-width: 450px">
		<div class="form-group col">
			@if(!$editar=='readonly')
				<button type="submit" class="btn btn-primary btn-lg d-block">Actualizar</button>
			@endif
		</div>
	</div>
</form>

<!-- 
			<div class="container">
				<div class="row">
					<h2>simple radio switch based only on CSS<br />
						<small>inspired by tonetlds work, but this solution uses :checked state and NOT relay on "active" class added by js to .btn element.</small>
					</h2>
				</div>
				<div class="well well-sm text-center">
					<h3>Radio:</h3>
					<div class="dlk-radio btn-group">
						<label class="btn btn-success">
							<input name="choices[1]" class="form-control" type="radio" value="1">
							<i class="fa fa-check glyphicon glyphicon-ok"></i>
						</label>
						<label class="btn btn-default">
							<input name="choices[1]" class="form-control" type="radio" value="2" defaultchecked="checked">
							<i class="fa fa-times glyphicon glyphicon-remove"></i>
						</label>
						<label class="btn btn-info">
							<input name="choices[1]" class="form-control" type="radio" value="3" defaultchecked="checked">
							<i class="fa fa-check glyphicon glyphicon-ok"></i>
						</label>
						<label class="btn btn-warning">
							<input name="choices[1]" class="form-control" type="radio" value="4" defaultchecked="checked">
							<i class="fa fa-times glyphicon glyphicon-remove"></i> can be labeled
						</label>
						<label class="btn btn-danger">
							<input name="choices[1]" class="form-control" type="radio" value="0" defaultchecked="checked">
							<i class="fa fa-check glyphicon glyphicon-remove"></i>
						</label>
					</div>
				</div>
				<br />-->

@section('script_opc_final')
	<script type="text/javascript">
		$(document).ready(function () {
			bsCustomFileInput.init()
		})
	</script>

	<script type="text/javascript" src="{{ asset('/js/widget_preview_pic.js') }}"></script>

	<script type="text/javascript">
		function bloquea_opc() {
			var x = document.getElementById("tipo_usr").value;

			if(x==7){
				document.getElementById("ger").disabled = true;
				document.getElementById("sup").disabled = true;
				document.getElementById("ven").disabled = true;
				document.getElementById("ope").disabled = true;

				document.getElementById("ger").checked = false;
				document.getElementById("sup").checked = false;
				document.getElementById("ven").checked = false;
				document.getElementById("ope").checked = false;
			}else{
				document.getElementById("ger").disabled = false;
				document.getElementById("sup").disabled = false;
				document.getElementById("ven").disabled = false;
				document.getElementById("ope").disabled = false;
			}
			//console.log('El texto seleccionado es:'+ x);
		}
	</script>
@endsection