var tabla;
//Función que se ejecuta al inicio
function init(){

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
 $("#asignar_form").on("submit",function(e)
 {
   guardaryeditar(e);
 })

   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("asignar Perfil");
   });
}

//Función Listar
function cancelar(){

 window.location.replace("perfilese.php");
}



 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#asignar_form")[0]);

   $.ajax({
     url: "../controlador/perfiles.php?op=asignar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,

       success: function(datos)
       {
      console.log(datos);
       $('#asignar_form')[0].reset();
       $('#resultados_ajax').html(datos);
      

       }

   });

}

init();