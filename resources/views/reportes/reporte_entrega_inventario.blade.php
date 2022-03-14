<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<title>Prueba PDF</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		 <!-- Fonts -->
	    <link rel="dns-prefetch" href="//fonts.gstatic.com">   

	    <!-- Styles -->
	    <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}" >
	    <link rel="stylesheet" href="{{ asset('/css/bootstrap4-toggle.css') }}">

	    <style type="text/css">
	    	.encabezado_1{
	    		border: solid; 
	    		border-width: 2px; 
	    		border-radius: 5px; 
	    		border-color: rgb(120, 120, 120); 
	    		background-color:rgb(120, 120, 120);
	    	}

	    	.encabezado_2{
	    		background-color:rgb(120, 120, 120); 
	    		color:white;
	    		font-weight: bold;
	    	}

	    	.encabezado_3{
	    		border: solid; 
	    		border-width: 2px; 
	    		border-radius: 5px; 
	    		border-color: rgb(120, 120, 120);
	    	}

	    	.contenido_2{
	    		background-color:rgb(255, 255, 255);
	    	}

	    	.borde_1{
	    		border: solid; 
	    		border-width: 2px;
	    		border-color: rgb(120, 120, 120);
	    	}

	    	body{
	    		font-size: 14px;
	    	}
	    </style>    


	</head>
	<body>
		<table class="table table-borderless" >
			<thead></thead>
			<tbody>
				<tr>
					<td class="align-middle" colspan="3"><h3 class="text-center ">Factura de Entrega de Inventario</h3></td>
					<td style="width: 25%">
						<div class="encabezado_1">
							<div class="text-center encabezado_2">
								Fecha
							</div>
							<div class="text-center contenido_2">
								{{$fecha}}
							</div>
							<div class="text-center encabezado_2">
								Folio Factura
							</div>
							<div class="text-center contenido_2">
								{{$folio}}
							</div>
							<div class="text-center encabezado_2">
								Sucursal
							</div>
							<div class="text-center contenido_2">
								{{$sucursal}}
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div class="text-center encabezado_3" style="padding-bottom: -17px">
							<table class="table table-striped table-sm" id="tabla_productos_entrega">
								<thead class="contenido_2">
									<tr>
										<th class="encabezado_2" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">ID</th>
										<th class="encabezado_2" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">Nombre</th>
										<th class="encabezado_2" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">Precio Unitario</th>
										<th class="encabezado_2" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">Cantidad</th>
										<th class="encabezado_2" style="border: solid; border-width: 0px 0px 2px 0px; border-color: rgb(120, 120, 120);">Total</th>							
									</tr>
								</thead>
								<tbody>
									@foreach($productos as $prod)
										<tr>
											<td scope="row" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">{{$prod['id_producto']}}</td>
											<td class="nombre text-left" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">{{$prod['nombre']}}</td>
											<td class="precio_unitario" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">{{$prod['precio_u']}}</td>
											<td class="cantidad" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">{{$prod['cantidad']}}</td>
											<td class="total" style="border: solid; border-width: 0px 0px 2px 0px; border-color: rgb(120, 120, 120);">{{$prod['valor']}}</td>
										</tr>
									@endforeach
										<tr>
											<td colspan="4" class="text-right" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">Valor Mercancía</td>
											<td style="border: solid; border-width: 0px 0px 2px 0px; border-color: rgb(120, 120, 120); background-color: rgb(110, 110, 110); color: white;">{{$gran_total}}</td>
										</tr>	
										<tr>
											<td colspan="4" class="text-right" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">Cambio Entregado</td>
											<td style="border: solid; border-width: 0px 0px 2px 0px; border-color: rgb(120, 120, 120); background-color: rgb(90, 90, 90); color: white;">{{$cambio}}</td>
										</tr>
										<tr>
											<td colspan="4" class="text-right" style="border: solid; border-width: 0px 2px 2px 0px; border-color: rgb(120, 120, 120);">Valor Total Entregado</td>
											<td style="border: solid; border-width: 0px 0px 2px 0px; border-color: rgb(120, 120, 120); background-color: rgb(65, 65, 65); color: white; font-weight: bold;">{{$val_tot_final}}</td>
										</tr>							
								</tbody>
							</table>
						</div>
					</td>					
				</tr>
				<tr>
					<td colspan="4">
						<div class="encabezado_1" >
							<div class="text-center encabezado_2">
								Observación
							</div>
							<div class="text-left contenido_2" style="padding-left: 5px;">
								{{$observacion}}
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="encabezado_1">
							<div class="text-center encabezado_2">
								Supervisor que Entrega
							</div>
							<div class="text-center contenido_2">
								{{$supervisor}}
							</div>
							<div class="text-center encabezado_2">
								Firma
							</div>
							<div class="text-center contenido_2" style="height: 75px;">
								
							</div>
						</div>
					</td>
					<td colspan="2">
						<div class="encabezado_1">
							<div class="text-center encabezado_2">
								Personal que Recibe
							</div>
							<div class="text-center contenido_2">
								{{$receptor}}
							</div>
							<div class="text-center encabezado_2">
								Firma
							</div>
							<div class="text-center contenido_2" style="height:75px;">
								
							</div>
						</div>
					</td>				
				</tr>								
			</tbody>
		</table>
		
		 <!-- Scripts --> 
	    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
	    <!--<script src="{{ asset('/js/app.js') }}" ></script>-->
	    <script>window.jQuery || document.write('{{ asset('/js/jquery-slim.min.js') }}"><\/script>')</script>    
	    <script src="{{ asset('/js/bootstrap.bundle.js') }}" ></script>
	    <script src="{{ asset('/js/bootstrap4-toggle.js') }}" ></script>    
	    <script src="{{ asset('/js/bs-custom-file-input.js') }}"></script>
	    <script src="{{ asset('/js/numer_input_spinner.js') }}"></script>
	    <script src="{{ asset('/js/lz_responsive.js') }}"></script>
	    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
	    <script>
	        feather.replace()
	    </script>      
	</body>
</html>