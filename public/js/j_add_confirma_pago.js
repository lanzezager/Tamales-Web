$(document).ready(function(){
          $("#btn_pagar").click(function(){

            var tabla= '';
            var importe_total=0;
            var num=0;

            $(".item_compra").each(function(){
                var id=$(this).attr('id');
                id=id.substring(5,id.length);
                var produ =window.products;
                var count = Object.keys(produ).length;
                var i=0;
                
                //console.log(produ);
                //console.log(id);

                while(i<count){
                    if(produ[i].id_producto==id){
                        var nombre=produ[i].nombre;
                        var precio_u=produ[i].precio_u;
                        var cantidad=$('#item_existencias_'+id).val();                        
                        var costo=0;
                        costo=(Number(cantidad)*Number(precio_u)).toFixed(2);
                        num=(Number(num)+Number(1));
                        var linea='<tr id="id_fila_'+id+'">'+
                                    '<td class="text-center num">'+num+'</td>'+
                                    '<td class="nombre">'+nombre+'</td>'+
                                    '<td class="text-center precio_u">$'+precio_u+'</td>'+
                                    '<td class="text-center cantidad">'+cantidad+'</td>'+
                                    '<td class="text-center importe">$'+costo+'</td>'+
                               '</tr>';
                        
                        tabla=tabla+linea;
                        importe_total=(Number(importe_total)+Number(costo)).toFixed(2);
                        i=count+1;
                    }
                    i++;
                }
                //console.log(tabla);
            });

            $('#tabla_items').html(tabla);
            $('#gran_total_modal').val(importe_total);
          });       
        });     