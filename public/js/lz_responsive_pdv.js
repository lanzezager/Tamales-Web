 $(document).ready(function(){
      $("#movil_boton_derecha").click(function(){
        $("#movil_boton_derecha").css("visibility", "hidden");
        $("#movil_boton_izquierda").css("visibility", "visible");
        //$("#barra_venta").css("right:","0px");  
        $('#barra_venta')[0].style.setProperty('right', '0px', 'important');      
      }); 

      $("#movil_boton_izquierda").click(function(){
        $("#movil_boton_izquierda").css("visibility", "hidden");
        $("#movil_boton_derecha").css("visibility", "visible");
        //$("#barra_venta").css("right:","-200px"); 
        $('#barra_venta')[0].style.setProperty('right', '-200px', 'important');
        
      }); 
 });