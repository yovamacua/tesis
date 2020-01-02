var tabla;
//Función que se ejecuta al inicio
function init(){

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
 $("#asignar_roles").on("submit",function(e)
 {
   guardaryeditar(e);
 })

   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("asignar_roles");
   });
}

//Función Listar
function cancelar(){

 window.location.replace("usuarios.php");
}



 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#asignar_roles")[0]);

   $.ajax({
     url: "../ajax/roles.php?op=asignar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,

       success: function(datos)
       {
      console.log(datos);
       $('#asignar_roles')[0].reset();
       $('#resultados_ajax').html(datos);
      

       }

   });

}

init();