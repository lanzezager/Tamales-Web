@include('panel_usuario.common.errors')
@include('panel_usuario.common.success')
<div class="row overflow-hidden" id="lista_items">
	@foreach($productos as $producto)
		<div class="col-sm-2 ficha_venta">
			<div class="card ficha_item" style="width: 10rem;  overflow: hidden;" id="{{$producto['id_producto']}}" nombre="{{$producto['nombre']}}" precio_u="{{$producto['precio_u']}}" existencias="{{$producto['existencias']}}" >
				@switch($producto['id_categoria'])
					@case(1)
						<div class="card-header text-white text-center" style="height:4rem; display: table; width: 100%; z-index: 10; background-color: #ea5b2d;">
							<div class="align-middle" style="display: table-cell;vertical-align: middle;">{{$producto['nombre']}}</div>
						</div>
					@break

					@case(2)
						<div class="card-header text-white text-center" style="height:4rem; display: table; width: 100%; z-index: 10; background-color: #4e75e5;">
							<div class="align-middle" style="display: table-cell;vertical-align: middle;">{{$producto['nombre']}}</div>
						</div>
					@break

					@case(3)
						<div class="card-header text-white text-center" style="height:4rem; display: table; width: 100%; z-index: 10; background-color: #8e35e2;">
							<div class="align-middle" style="display: table-cell;vertical-align: middle;">{{$producto['nombre']}}</div>
						</div>
					@break

					@case(4)
						<div class="card-header text-white text-center" style="height:4rem; display: table; width: 100%; z-index: 10; background-color: #dc71d9;">
							<div class="align-middle" style="display: table-cell;vertical-align: middle;">{{$producto['nombre']}}</div>
						</div>
					@break

					@case(5)
						<div class="card-header text-white text-center" style="height:4rem; display: table; width: 100%; z-index: 10; background-color: #79b3e2;">
							<div class="align-middle" style="display: table-cell;vertical-align: middle;">{{$producto['nombre']}}</div>
						</div>
					@break

					@case(6)
						<div class="card-header text-white text-center" style="height:4rem; display: table; width: 100%; z-index: 10; background-color: #ece94d;">
							<div class="align-middle" style="display: table-cell;vertical-align: middle; color: #3a3a3a;">{{$producto['nombre']}}</div>
						</div>
					@break
				@endswitch					
				
				<img class="card-img-top" src="/images/productos/{{$producto['imagen']}}" alt="Card image cap" style="width:auto; height:8rem;  overflow: hidden; z-index: 9;" data-toggle="tooltip" data-placement="right" title="{{$producto['descripcion']}}" />
				<ul class="list-group list-group-flush" style="z-index: 10;">
					<li class="list-group-item">
						<div>
							<div class="text-center" style="width:50%; display: inline; float: left; border-right: 2px solid; border-color: #cdcdcd;  display: inline;">
								${{$producto['precio_u']}}
							</div>
							<div class="text-center" style="width:50%;  display: inline; float: right;" id="tope_existencias_{{$producto['id_producto']}}">X{{$producto['existencias']}}</div>
						</div>
					</li>
				</ul>	
			</div>
		</div>
	@endforeach
</div>