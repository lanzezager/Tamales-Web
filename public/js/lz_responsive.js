 $(document).ready(function(){
      $("#movil_boton_derecha").click(function(){
        $("#movil_boton_derecha").css("visibility", "hidden");
        $("#movil_boton_izquierda").css("visibility", "visible");
        $("#sidebar_menu_lz").css("margin-left","0%");        
      }); 

      $("#movil_boton_izquierda").click(function(){
        $("#movil_boton_izquierda").css("visibility", "hidden");
        $("#movil_boton_derecha").css("visibility", "visible");
        $("#sidebar_menu_lz").css("margin-left","-100%"); 
        
      }); 
 });