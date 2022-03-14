jQuery(document).ready(function() {

		$('#metodo_pago').change(function(){
			var val= $('#metodo_pago').val();
			//console.log(val);
			if((val)>1){
				$('#digitos_tarjeta_row').css("visibility", "visible");
				$('#digitos_tarjeta_row').css("height", "20px");
				$('#digitos_tarjeta_row').css("position", "relative");
			}else{
				$('#digitos_tarjeta_row').css("visibility", "hidden");
				$('#digitos_tarjeta_row').css("height", "0px");
				$('#digitos_tarjeta_row').css("position", "fixed");
			}
		});

		$('#pagar').click(function() {
			var filas = [];
			$('#tabla_items_compra tbody tr').each(function() {
				var id=$(this).attr('id');
				id=id.substring(8,id.length);
				var num = $(this).find('td').eq(0).text();
				var nombre = $(this).find('td').eq(1).text();
				var precio_u= $(this).find('td').eq(2).text();
				var cantidad = $(this).find('td').eq(3).text();
				var importe = $(this).find('td').eq(4).text();
				
				var fila = {
					num,
					id,
					nombre,
					precio_u,
					cantidad,
					importe
				};

				filas.push(fila);
			});

			var string_j = JSON.stringify(filas);

			$('#lista_compra').val(string_j);

			console.log(string_j);
			//alert(string_j);

		});
});