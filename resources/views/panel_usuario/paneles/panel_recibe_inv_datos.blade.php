
@include('panel_usuario.common.success')
@include('panel_usuario.common.errors')

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

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
	
	#parte_datos{
		overflow: hidden;
		visibility: hidden;
	}

</style>

<div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" >
	<a href="/panel_usuario/market/r_inventario" class="btn btn-outline-secondary btn-sm" style="margin-right:15px; margin-top: -8px;"><span data-feather="chevron-left"></span>Regresar</a>
	
	@if($nvo=='nvo')
		<h1 class="h2 text-left" id="titu">Nuevo Recibo</h1>
		@section('cambio','')
		@section('valor_total',0)
		@section('acti','/panel_usuario/market/r_inventario')

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
		@section('cambio',$monto_recibido)
		@section('valor_total',$monto_recibido)
		@section('observacion',$observacion)

		@if($editar=='editar')
			<h1 class="h2 text-left" id="titu">Editar Recibo</h1>
			@section('editar','')
			@section('editar2','')
			@section('acti','/panel_usuario/market/r_inventario/'.$r_inventario->id)
			@section('tipo_form',2);
			@section('supervis',$usuario->nombre_s.' '.$usuario->apellido_s)
			@section('supervis_id',$usuario->id)
		@else
			<h1 class="h2 text-left" id="titu" >Detalle Recibo</h1>
			@section('receptor_id',$receptor[0])
			@section('receptor',$receptor[1])
			@section('supervis',$usuario->nombre_s.' '.$usuario->apellido_s)
			@section('supervis_id',$usuario->id)
			@section('editar','readonly')
			@section('editar2','disabled')
			@section('tipo_form',3);
		@endif

	@endif
</div>
<div id="muestra_errores"></div>
@if(strlen($parte_sel_dis)<1)
<div id="parte_seleccion" {{$parte_sel_dis}} >
	<h5>Selecciona la Entrega a Recibir</h5>
	<div class="form-row">
		<div class="form-group col" style="max-width: 750px;max-height: 250px; overflow: auto;">
			<div class="table-responsive" style="margin-top: 15px;">
				<table class="table table-striped table-sm table-bordered " id="entregas">
					<thead>
						<tr>
							<th>ID</th>
							<th>Sucursal</th>
							<th>Valor Entrega</th>
							<th>Observacion</th>
							<th>Seleccionar</th>							
						</tr>
					</thead>
					<tbody id="tabla_entregas" class="btn-group-toggle" data-toggle="buttons">						
						@foreach($lista_entregas as $entrega)
							<tr id="id_fila_{{$entrega['id']}}">
								<td scope="row" >{{$entrega['id']}}</td>
								<td class="market">
									@foreach($markets as $market)
										@if($entrega['id_market']==$market[0])
											{{$market[1]}}									
										@endif
									@endforeach
								</td>
								<td class="valor_entrega">{{($entrega['valor_mercancia']+$entrega['cambio_entregado'])}}</td>
								<td class="observacion">{{$entrega['observacion']}}</td>							
								<td class="accion">
									<div class="btn-group btn-group-toggle sel_button"  id="sel_tag_{{$entrega['id']}}" sucursal="{{$entrega['id_market']}}">
										<label class="btn btn-sm btn-outline-primary" >
											<input type="radio" name="sel_entrega"  autocomplete="off" >
											<div  id="sel_icon_{{$entrega['id']}}"><i class="fas" style="width: 1em;"></i></div>
										</label>
									</div>
								</td>								
							</tr>
						@endforeach						
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<button type="button" disabled="true" class="btn btn-secondary" id="continuar">Continuar</button>
	
</div>
@endif

<div id="parte_datos" {{$parte_dat_vis}}>
	<form class ="form-group" method="POST" action="@yield('acti')" enctype="multipart/form-data" name="env_info" id="form_guarda_r_inventario">

		@if($nvo!='nvo')
		@if($editar=='editar')
		@method('PUT')
		@endif
		@endif

		@csrf

		<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">

		<input type="hidden" name="tipo_form" value="@yield('tipo_form')" id="tipo_form">
		<input type="hidden" name="receptor" value="{{$receptor[0]}}" id="receptor">

		<div class="form-row">
			<div class="form-group col" style="max-width: 900px">
				<div class="form-row">
					<div class="form-group col" style="max-width: 220px">
						<label>Sucursal</label>
						<input id="mercado" type="text" value="{{$nom_mark}}" class="form-control" name="sucursal" placeholder="" maxlength="100" style="max-width:200px; min-width:150px;" readonly="true">
						<input type="hidden" name="id_entrega" value="{{$id_entrega ?? '' }}" id="id_entrega">
					<!--	<select name="sucursal" class="form-control" style="max-width:200px; min-width:150px; " @yield('editar2') id="mercado">
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
						</select> -->
					</div>				
				</div>
				<!--
				<div class="form-row" style="max-width: 900px;">
					<div class="form-group col" style="max-width: 340px">
						<label class="d-block" style="width: 300px;">Productos</label>
						<select name="tipo_usuario" class="d-block form-control" style="max-width:320px; min-width:150px; " @yield('editar2')  id="usr">
							<option value="0" disabled selected hidden>Seleccionar</option>
							@if(($nvo=='nvo')||($editar=='editar123'))
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
				</div> -->

				<div class="form-row">
					<div class="form-group col" style="width: 900px; flex-wrap: nowrap;" >
						<div class="table-responsive" style="max-width: 1920px; overflow:auto; margin-top: 15px;">
							<label>Productos Entregados</label>
							<table class="table table-striped table-sm table-bordered table-hover" id="tabla_productos_recibo">
								<thead>
									<tr>
										<th class="text-center align-middle">ID</th>
										<th class="text-center align-middle">Nombre</th>
										<th class="text-center align-middle">Precio Unitario</th>
										<th class="text-center align-middle">Cantidad Entregada</th>
										<th class="text-center align-middle">Valor Total</th>
										<th class="text-center align-middle">Sobrante Virtual</th>
										<th class="text-center align-middle">Sobrante Real</th>
										<th class="text-center align-middle">Justificación</th>							
									</tr>
								</thead>
								<tbody id="tabla_productos" total="{{$cont_prod ?? ''}}">
									
									@if($nvo=='nvo')
									@else
										@if($editar=='')
											@foreach($productos as $prod)
												<tr id="id_fila_{{$prod['id']}}">
													<td scope="row" >{{$prod['id']}}</td>
													<td class="align-middle nombre_producto">{{$prod['nombre']}}</td>
													<td class="text-center align-middle precio_producto">{{$prod['precio_u']}}</td>
													<td class="text-center align-middle cantidad_producto">{{$prod['cantidad']}}</td>
													<td class="text-center align-middle" id="valor_total">{{$prod['valor_tot']}}</td>
													<td class="text-center align-middle restante_virtual">{{$prod['restante_virtual']}}</td>
													<td class="text-center align-middle sobrante_real">{{$prod['sobrante_real']}}</td>
													<td class="text-center align-middle justificacion">{{$prod['justificacion']}}</td>
												</tr>
											@endforeach
										@else
											@foreach($productos as $prod)
												<tr id="id_fila_{{$prod['id']}}" precio_u="{{$prod['precio_u']}}" res_vir="{{$prod['restante_virtual']}}">
													<td class="text-center align-middle" scope="row" >{{$prod['contador']}}</td>
													<td class="align-middle nombre_producto">{{$prod['nombre']}}</td>
													<td class="text-center align-middle precio_producto">{{$prod['precio_u']}}</td>
													<td class="text-center align-middle cantidad_producto">{{$prod['cantidad']}}</td>
													<td class="text-center align-middle" id="valor_total">{{$prod['valor_tot']}}</td>
													<td class="text-center align-middle restante_virtual" id="restante_virtual_{{$prod['contador']}}">{{$prod['restante_virtual']}}</td>
													<td class="text-center align-middle sobrante_real"><input id='restante_real_{{$prod['contador']}}' type='text' value='{{$prod['sobrante_real']}}' name='restante_real' placeholder='' onkeypress='return filterFloat(event,this,"entero");' onpaste='return false' maxlength='4' class='form-control restante_real' style='max-width:100px; min-width:50px;'></td>
													<td class="text-center align-middle justificacion"><input id='comentario_prod_{{$prod['contador']}}' type='text' value='{{$prod['justificacion']}}' name='comentario_prod' placeholder=''  maxlength='100' class='comentarios form-control' style='max-width:200px; min-width:150px;'></td>
												</tr>
											@endforeach
										@endif
									@endif
																
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="form-row">				
					<div class="form-group col" style="max-width:350px;">				
						<label>Supervisor que Recibe</label>
						<select name="supervisor" class="form-control" style="max-width:370px; min-width:280px;" @yield('editar2') id="supervisor_r">
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
						<label>Empleado que Entrega</label>
						<select name="emisor" class="form-control" style="max-width:370px; min-width:280px;" @yield('editar2') id="sel_empleados">
							@if($nvo=='nvo')
								<option value="0" disabled selected hidden>Primero Elija la Sucursal</option>
							@else
								@if($editar=='editar')
									@foreach($users_valid as $empleado_entrega)
										@if($empleado_entrega->emp_entr==1)
											<option value="{{$empleado_entrega->id}}" selected>{{$empleado_entrega->nombre}}</option>
										@else
											<option value="{{$empleado_entrega->id}}">{{$empleado_entrega->nombre}}</option>
										@endif
									@endforeach
								@else
									<option value="@yield('receptor_id')"  selected hidden>@yield('receptor')</option>
								@endif
							@endif						
						</select>
					</div>
					<div class="form-group col" style="max-width: 160px;">
						<label>Efectivo Recibido</label>
						<div class="input-group" style="  width:150px;">
							<div class="input-group-prepend">
								<span class="input-group-text"><span data-feather="dollar-sign"></span></span>
							</div>
							<input type="text" class="form-control" id="cambio" value="@yield('cambio')" name="cambio" placeholder="" onkeypress="return filterFloat(event,this,'decimal');" onpaste="return false" @yield('editar')>
						</div>	
					</div>
					<div class="form-group col" style="max-width: 220px">
						<label>Efectivo Total Virtual</label>
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
				<button type="button" class="btn btn-primary btn-lg d-block" id="enviar" >Guardar</button>
				@endif
			</div>
		</div>
		<input type="text" name="lista_productos" style="visibility: hidden" id="lista_productos">
	</form>
</div>

@section('script_opc_final')
	<script type="text/javascript">		

		$(document).ready(function(){	

			var previo='';
			var id_entrega=0;
			var tot_products=0;

			$('.sel_button').click(function(){
				var index=$(this).attr('id');
				//console.log('previo: '+previo+' actual:'+index);
				var solo_ind_act=index.substring(8,index.length);
				
				//console.log('solo_num: '+solo_ind);
				var uncheck_pic='<i class="fas" style="width: 1em;"></i>';
				var check_pic='<i class="fas fa-check"></i>';			
				$('#sel_icon_'+solo_ind_act).html(check_pic);

				if(previo.length>0){
					var solo_ind_prev=previo.substring(8,previo.length);
					$('#sel_icon_'+solo_ind_prev).html(uncheck_pic);
				}
				previo=index;

				$('#continuar').prop("disabled", false);
			});

			function llenar_campos(id_entrega,response) {
				var marke =@json($markets);
				var entregas =@json($lista_entregas);
				var count = Object.keys(marke).length;
				var count2 = Object.keys(entregas).length;
				var i=0;
				var j=0;
				var mark_id=0;
				
				//console.log('id_entrega_llenar_campos: '+id_entrega);
				//console.log(entregas);
				//console.log(entregas[id_entrega-1].id);
				//console.log(marke);

				while(i<count2){
					if((entregas[i].id)==id_entrega){
						while(j<count){

							if((entregas[i].id_market)==marke[j]['0']){
								//console.log(marke[j]['0']);
								mark_id=marke[j]['0'];
								$('#mercado').val(marke[j]['1']);
								$('#id_entrega').val(id_entrega);
							}
							j++;
						}						
					}
					i++;
				}
				//llena empleados
				if(($("#tipo_form").val())<3){
					//var emple = @json($empleados_market);
					var emple= @json($empleados_market);
					
					$('#sel_empleados').val(0);				
					$("#sel_empleados").empty();
					
					var option = $('<option  selected hidden></option>').attr("value", "0").text("Selecciona Uno");
					$("#sel_empleados").append(option);
					//console.log('Hola :D');
					//console.log(emple);
					var cuenta=Object.keys(emple).length;
					var i=0;
					var numero=0;
					var receptor=$("#receptor").val();

					while(i<cuenta){
						try{
							if((Object.keys(emple[i][""+mark_id+""]).length)!=null){
								//console.log('numero:'+i);
								numero=i;
							}		
						}catch{}
						i++;
					}			

					//console.log(numero);
					var sub_cuenta=Object.keys(emple[numero][""+mark_id+""]).length;
					
					i=0;		

					while(i<sub_cuenta){
						var ide=emple[numero][""+mark_id+""][i].id;
						var nombre=emple[numero][""+mark_id+""][i].nombre;

						if(($("#tipo_form").val())==2){
							if(receptor==ide){
								var option1 = $('<option selected></option>').attr("value", ide).text(nombre);
							}else{
								
								var option1 = $('<option></option>').attr("value", ide).text(nombre);
							}
						}else{
													
							var option1 = $('<option></option>').attr("value", ide).text(nombre);
						}

						$("#sel_empleados").append(option1);
						i++;
					}
				}
				
				//console.log(typeof(response));
				//console.log(response[0].nombre);
				genera_tabla(response);				
			}

			function genera_tabla(response){

				var count = Object.keys(response).length;
				var i=0;
				//console.log(count);
				var tabla= $("#tabla_productos").html();

				var fila="";
				var total=0;
				

				while(i<count){
					var combo= response[i].nombre.includes("Combo");					
					var info= response[i].nombre.includes("info");

					if(info==true){
						var grand_tot=(parseFloat(response[i].suma_venta)+parseFloat(response[i].cambio));
						$("#gran_total").val(grand_tot);
						combo=true;
					}

					if(combo==false){
						tot_products++;
						var fila="<tr id='id_fila_"+response[i].id+"' precio_u='"+response[i].precio_u+"' res_vir='"+response[i].restante_virtual+"' >"+
								 	"<td class='text-center align-middle' scope='row'>"+(i+1)+"</td>"+
								 	"<td class='align-middle nombre_producto'>"+response[i].nombre+"</td>"+
								 	"<td class='text-center align-middle precio_unitario'>$"+response[i].precio_u+"</td>"+
								 	"<td class='text-center align-middle cantidad_entregada'>"+response[i].cantidad+"</td>"+
								 	"<td class='text-center align-middle valor_total'>$"+response[i].valor_tot+"</td>"+
								 	"<td class='text-center align-middle restante_virtual' id='restante_virtual_"+tot_products+"'>"+response[i].restante_virtual+"</td>"+
								  //"<td class='text-center align-middle total_virtual'>$"+response[i].total_virtual+"</td>"+
								 	"<td class='text-center align-middle '><input id='restante_real_"+tot_products+"' type='text' value='' name='restante_real' placeholder='' onkeypress='return filterFloat(event,this,\"entero\");' onpaste='return false' maxlength='4' class='form-control restante_real' style='max-width:100px; min-width:50px;'></td>"+
								  //"<td class='text-center align-middle total_real'><input id='total_real' type='text' value='' name='total_real' placeholder='' maxlength='4' class='form-control' style='max-width:100px; min-width:50px;'></td>"+
								 	"<td class='text-center align-middle '><input id='comentario_prod_"+tot_products+"' type='text' value='' name='comentario_prod' placeholder=''  maxlength='100' class='comentarios form-control' style='max-width:200px; min-width:150px;'></td>"+
								  //"<td class='text-center align-middle accion'></td>"+
								 "</tr>";
						tabla=tabla+fila;
						total=(parseFloat(response[i].valor_tot))+total;
						
					}				

					i++;
				}

				$("#tabla_productos").html(tabla);
				//console.log(total);				
			}

			/*jQuery(document).on( "click", "#enviar", function(){ 
				var i=0;
				while(i<tot_products){
					$('#restante_real_'+(i+1)).removeClass('is-invalid');
					$('#comentario_prod_'+(i+1)).removeClass('is-invalid');
					i++;
				}

			});*/

			//jQuery(document).on( "submit", "#form_guarda_r_inventario", function(e){ 
			$('#enviar').click(function(e){	
				e.preventDefault();
				//alert(tot_products);
				var i=0;
				var errores=[];
				var correctos=[];
				var retorno=true;

				var tipo_valida=$("#titu").html();

				if(tipo_valida.includes("Editar")){
					tot_products=$("#tabla_productos").attr('total');
					//alert("edita :)"+tot_products);
				}

				//console.log(retorno);
				while(i<tot_products){
					var sobrante_virtual=$("#restante_virtual_"+(i+1)).html();
					var sobrante_real= $("#restante_real_"+(i+1)).val();
					var comentario= $("#comentario_prod_"+(i+1)).val();
					//alert(sobrante_virtual);
					if((sobrante_real.length)>0){
						if(sobrante_virtual==sobrante_real){
							correctos.push((i+1));
						}else{
							if((comentario.length)>9){
								correctos.push((i+1));
							}else{
								errores.push((i+1));
							}
						}
					}else{
						errores.push((i+1));
					}

					i++;
				}
				//console.log(errores);
				//console.log(correctos);

				var encabezado="<div class='alert alert-danger'><ul style='margin-bottom: 0px;'>";
				var pie="</ul></div>";
				var fila ="";
				var errores_mostrar;

				if(errores.length>0){					
					var i=0;
					
					fila="<li>Sobrante Real no puede quedar vacío</li>"+
						 "<li>Si Sobrante Real no coincide con Sobrante Virtual se requerirá una justificación de por lo menos 10 caracteres</li>";
					while(i<(errores.length)){
						if(($("#restante_real_"+(errores[i])).val().length)<1){
							if(($('#restante_real_'+errores[i]).hasClass('is-invalid'))==false){
								$('#restante_real_'+errores[i]).addClass('is-invalid');
								retorno=false;
							}else{
							}							
						}else{
							if(($('#restante_real_'+errores[i]).hasClass('is-valid'))==false){
								$('#restante_real_'+errores[i]).addClass('is-valid');
							}else{

							}
						}
						//console.log($("#comentario_prod_"+(errores[i])).val().length);
						if(($("#comentario_prod_"+(errores[i])).val().length)<10){
							if(($('#comentario_prod_'+errores[i]).hasClass('is-invalid'))==false){
								$('#comentario_prod_'+errores[i]).addClass('is-invalid');
								retorno=false;
							}else{

							}
						}else{
							if(($('#comentario_prod_'+errores[i]).hasClass('is-valid'))==false){
								$('#comentario_prod_'+errores[i]).addClass('is-valid');
							}else{

							}
						}
						
						i++;						
					}

					i=0;

					while(i<correctos.length){
						if(($('#restante_real_'+correctos[i]).hasClass('is-invalid'))==true){
							$('#restante_real_'+correctos[i]).removeClass('is-invalid');
						}
						if(($('#comentario_prod_'+correctos[i]).hasClass('is-invalid'))==true){
							$('#comentario_prod_'+correctos[i]).removeClass('is-invalid');
						}
						if(($('#comentario_prod_'+correctos[i]).hasClass('is-valid'))==false){
							$('#comentario_prod_'+correctos[i]).addClass('is-valid');
						}
						if(($('#restante_real_'+correctos[i]).hasClass('is-valid'))==false){
							$('#restante_real_'+correctos[i]).addClass('is-valid');
						}

						//$('#restante_real_'+correctos[i]).addClass('is-valid');
						//$('#comentario_prod_'+correctos[i]).addClass('is-valid');
						i++;
					}

					retorno=false;

				}else{
					var i=0;
					while(i<correctos.length){
						if(($('#restante_real_'+correctos[i]).hasClass('is-invalid'))==true){
							$('#restante_real_'+correctos[i]).removeClass('is-invalid');
						}
						if(($('#comentario_prod_'+correctos[i]).hasClass('is-invalid'))==true){
							$('#comentario_prod_'+correctos[i]).removeClass('is-invalid');
						}
						if(($('#comentario_prod_'+correctos[i]).hasClass('is-valid'))==false){
							$('#comentario_prod_'+correctos[i]).addClass('is-valid');
						}
						if(($('#restante_real_'+correctos[i]).hasClass('is-valid'))==false){
							$('#restante_real_'+correctos[i]).addClass('is-valid');
						}

						//$('#restante_real_'+correctos[i]).removeClass('is-invalid');						
						//$('#comentario_prod_'+correctos[i]).removeClass('is-invalid');
						//$('#restante_real_'+correctos[i]).addClass('is-valid');
						//$('#comentario_prod_'+correctos[i]).addClass('is-valid');						
						i++;
					}

					$('#muestra_errores').html('');	
				}

				errores_mostrar=encabezado+fila;

				if(($('#supervisor_r').hasClass('is-invalid'))==true){
					$('#supervisor_r').removeClass('is-invalid');
				}

				if(($('#supervisor_r').hasClass('is-valid'))==true){
					$('#supervisor_r').removeClass('is-valid');
				}

				if(($('#sel_empleados').hasClass('is-invalid'))==true){
					$('#sel_empleados').removeClass('is-invalid');
				}

				if(($('#sel_empleados').hasClass('is-valid'))==true){
					$('#sel_empleados').removeClass('is-valid');
				}

				if(($('#cambio').hasClass('is-invalid'))==true){
					$('#cambio').removeClass('is-invalid');
				}

				if(($('#cambio').hasClass('is-valid'))==true){
					$('#cambio').removeClass('is-valid');
				}


				if($('#supervisor_r').val()<=0){
					retorno=false;
					var fila1="<li>Debe Seleccionar al Supervisor que Recibirá</li>";
					errores_mostrar=errores_mostrar+fila1;
					$('#supervisor_r').addClass('is-invalid');
				}else{
					$('#supervisor_r').addClass('is-valid');
				}

				if($('#sel_empleados').val()<=0){
					retorno=false;
					var fila1="<li>Debe Seleccionar al Empleado que está realizando la Entrega</li>";
					errores_mostrar=errores_mostrar+fila1;
					$('#sel_empleados').addClass('is-invalid');
				}else{
					$('#sel_empleados').addClass('is-valid');
				}

				//console.log($('#sel_empleados').val()+" <- valor empleados "+retorno);

				if($('#cambio').val().length<=0){
					retorno=false;
					var fila1="<li>Debe de Ingresar el monto de Efectivo Recibido</li>";
					errores_mostrar=errores_mostrar+fila1;
					$('#cambio').addClass('is-invalid');
				}else{
					$('#cambio').addClass('is-valid');
				}

					/*if($('#observaciones').val()<=0){
						retorno=false;
						var fila1="<li></li>";
						errores_mostrar=errores_mostrar+fila1;
					}else{
						
					}*/

				//console.log('super: '+$('#supervisor_r').val());
				//console.log(retorno);

				if(retorno==true){

					var filas = [];
					$('#tabla_productos_recibo tbody tr').each(function() {
						var id=$(this).attr('id');
						id=id.substring(8,id.length);
						var inputs =$("input");
						var sobrante_real = $(this).find(inputs).eq(0).val();
						var justificacion = $(this).find(inputs).eq(1).val();
						var precio_u=$(this).attr('precio_u');
						var sobrante_virtual=$(this).attr('res_vir');
						
						var fila = {
							id,
							precio_u,
							sobrante_virtual,
							sobrante_real,
							justificacion
						};

						filas.push(fila);
					});

					console.log(filas);

					var string_j = JSON.stringify(filas);
					$('#lista_productos').val(string_j);

					$("#form_guarda_r_inventario").submit();
					
				}else{
					errores_mostrar=errores_mostrar+pie;
					$('#muestra_errores').html(errores_mostrar);
					
				}

			});

			jQuery(document).on("keyup",".restante_real", function(){ 
				var id=$(this).attr('id');
				//alert(id);
				$('#'+id).removeClass('is-invalid');
			});

			jQuery(document).on( "keyup", ".comentarios", function(){ 
				var id=$(this).attr('id');
				//alert(id);
				$('#'+id).removeClass('is-invalid');
			});

			$('#continuar').click(function(){
				$('#parte_datos').css("visibility", "visible");
				$('#parte_seleccion').css("display","none");
				id_entrega=previo.substring(8,previo.length);
				//console.log('id_sel: '+id_entrega);

				var token=$('#token').val();
				var ruta="/panel_usuario/market/r_inventario/detalles_entrega";
				var data=id_entrega;

				$.ajax({
					url: ruta,
					headers:{'X-CSRF-Token': token},
					type: "POST",
					dataType : 'json',
					data: {
						data				
					},
					success: function(response,status) { 
						//alert(data);
						//console.log('respuesta: '+response+' status: '+status);

						llenar_campos(id_entrega,response);

					},
					error: function(response, status, error){
						console.log(status+' Sucedio el siguiente error: '+error);
					},	
				});

			});
			 
		});

		
	</script>

	<script type="text/javascript">
		$(function () {
	    	$('[data-toggle="tooltip"]').tooltip()
	    })
	</script>
	<!-- Script inferior sirve para el selector de unidades -->
	<script>
	    $("input[type='number']").inputSpinner();
	</script>

	<!-- <script type="text/javascript" src="{{ asset('/js/filtro_enteros.js') }}"></script> -->
	<script type="text/javascript" src="{{ asset('/js/filtro_decimales.js') }}"></script>
	
	<!--
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
	-->
@endsection