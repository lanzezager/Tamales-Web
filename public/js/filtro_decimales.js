function filterFloat(evt,input,tipo){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
    	if(filter(tempValue,tipo)=== false){
    		return false;
    	}else{       
    		return true;
    	}
    }else{
    	if(key == 8 || key == 13 || key == 0) {     
    		return true;              
    	}else if(key == 46){
    		if(filter(tempValue,tipo)=== false){
    			return false;
    		}else{       
    			return true;
    		}
    	}else{
    		return false;
    	}
    }
}

function filter(__val__,type){

    var preg;

    if(type=='decimal'){
       preg = /^([0-9]+\.?[0-9]{0,2})$/;
    }

    if(type=='entero'){
        preg = /^([0-9]+)$/; 
    }

	 
	if(preg.test(__val__) === true){
		return true;
	}else{
		return false;
	}

}