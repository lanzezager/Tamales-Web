jQuery(document).ready(function() {

	$('#enviar').click(function(e) {

		e.preventDefault();
		$('#muestra_errores').html('');

		var encabezado="<div class='alert alert-danger'><ul style='margin-bottom: 0px;'>";
		var pie="</ul></div>";
		var fila ="";
		var errores_mostrar="";
		var existe_error=0;


		if(($('#mercado').hasClass('is-valid'))==true){
			$('#mercado').removeClass('is-valid');
		}
		if(($('#mercado').hasClass('is-invalid'))==true){
			$('#mercado').removeClass('is-invalid');
		}

		if(($('#usr').hasClass('is-valid'))==true){
			$('#usr').removeClass('is-valid');
		}
		if(($('#usr').hasClass('is-invalid'))==true){
			$('#usr').removeClass('is-invalid');
		}

		if(($('#sel_empleados').hasClass('is-valid'))==true){
			$('#sel_empleados').removeClass('is-valid');
		}
		if(($('#sel_empleados').hasClass('is-invalid'))==true){
			$('#sel_empleados').removeClass('is-invalid');
		}

		if(($('#cambio').hasClass('is-valid'))==true){
			$('#cambio').removeClass('is-valid');
		}
		if(($('#cambio').hasClass('is-invalid'))==true){
			$('#cambio').removeClass('is-invalid');
		}

		if($('#mercado').val()<=0){
			fila="<li>Debe seleccionar la Sucursal a la que se le entregará el inventario</li>";
			errores_mostrar=errores_mostrar+fila;
			$('#mercado').addClass('is-invalid');
			existe_error=1;
		}else{
			$('#mercado').addClass('is-valid');
		}

		var filas = [];
		$('#tabla_productos_entrega tbody tr').each(function() {
			var prod_id = $(this).find('td').eq(0).text();
			var nombre = $(this).find('td').eq(1).text();
			var precio_u= $(this).find('td').eq(2).text();
			var cantidad = $(this).find('td').eq(3).text();
			var valor = $(this).find('td').eq(4).text();

			var fila = {
				prod_id,
				nombre,
				precio_u,
				cantidad,
				valor
			};

			filas.push(fila);
		});

		var token=$('#token').val();
		var ruta="/panel_usuario/market/e_inventario";
		var string_j = JSON.stringify(filas);

		$('#lista_productos').val(string_j);
		//console.log(string_j);

		if(filas.length<=0){
			fila="<li>Debe seleccionar por lo menos un producto para entregar</li>";
			errores_mostrar=errores_mostrar+fila;
			$('#usr').addClass('is-invalid');
			existe_error=1;
		}else{
			$('#usr').addClass('is-valid');
		}

		if($('#sel_empleados').val()<=0){
			fila="<li>Debe seleccionar el empleado al que se le están entregando los productos</li>";
			errores_mostrar=errores_mostrar+fila;
			$('#sel_empleados').addClass('is-invalid');
			existe_error=1;
		}else{
			$('#sel_empleados').addClass('is-valid');
		}

		if($('#cambio').val()<=0){
			fila="<li>Debe ingresar la cantidad de efectivo que se le entregará al empleado</li>";
			errores_mostrar=errores_mostrar+fila;
			$('#cambio').addClass('is-invalid');
			existe_error=1;
		}else{
			$('#cambio').addClass('is-valid');
		}

		if(existe_error==1){
			errores_mostrar=encabezado+errores_mostrar+pie;
			$('#muestra_errores').html(errores_mostrar);
		}else{
			$("#form_guarda_e_inventario").submit();
		}

			//console.log(filas);
			//console.log(token);			
			//alert(string_j);
			//alert("Hola");			
			
	/*		
			$.ajax({
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
				
		   
			}); 
			*/

	});
});