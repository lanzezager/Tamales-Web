(function(){
			function filePreview(input){
				if (input.files && input.files[0]){
					var reader = new FileReader();

					reader.onload = function(e){
						//$('#imagePreview').html("<img src='"+e.target.result+"' />");
						//$('#imagen_preview').src(e.target.result);
						document.getElementById("imagen_preview").src=e.target.result;
					}

					reader.readAsDataURL(input.files[0]);
				}
			}

			$('#CustomFile').change(function(el){
				if(LimitAttach(this,1))
					filePreview(this);
			});
		})();

function LimitAttach(tField,iType) {
			file=tField.value;
			if (iType==1) {
				extArray = new Array(".jpeg",".jpe",".gif",".jpg",".png",".bmp");
			}	
			allowSubmit = false;
			if (!file) return false;
			while (file.indexOf("\\") != -1) file = file.slice(file.indexOf("\\") + 1);
			ext = file.slice(file.indexOf(".")).toLowerCase();
			for (var i = 0; i < extArray.length; i++) {
				if (extArray[i] == ext) {
					allowSubmit = true;
					break;
				}
			}
			if (allowSubmit) {
				return true
			} else {
				tField.value="";
				alert("Usted sólo puede subir archivos con extensiones " + (extArray.join(" ")) + "\n Reiniciando Formulario");
				return false;
				setTimeout("location.reload()",2000);
			}
		}			