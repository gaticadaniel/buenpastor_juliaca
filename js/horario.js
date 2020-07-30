/*=============================================
EDITAR HORARIO
=============================================*/
$(".btnEditarHorario").click(function(){

  var idHorario = $(this).attr("idHorario"); 
  var datos = new FormData();
  datos.append("idHorario", idHorario);

	$.ajax({
		url:"../ajax/horarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
            $("#idhorario").val(respuesta[0]["id"]);
            $("#editnuevoNivel").val(respuesta[0]["nivel_id"]);
            $("#editnuevoNivel").html(respuesta[0]["nivel"]);
			$("#editdenominacion").val(respuesta[0]["denominacion"]);
			$("#edithoraIngreso").val(respuesta[0]["hora_ingreso"]);
			$("#editmantesi").val(respuesta[0]["minutos_antes_ingreso"]);
			$("#editmtoleranciai").val(respuesta[0]["minutos_de_tolerancia"]);
			$("#editmdespuesi").val(respuesta[0]["minutos_despues_ingreso"]);
			$("#edithoraSalida").val(respuesta[0]["hora_salida"]);
			$("#editmantess").val(respuesta[0]["minutos_antes_salida"]);
			$("#editmtolerancias").val(respuesta[0]["minutos_de_tolerancia_2"]);
			$("#editmdespuess").val(respuesta[0]["minutos_despues_salida"]);

		}
	});
});
/*=============================================
ELIMINAR HORARIO
=============================================*/
$(".btnEliminarHorario").click(function(){

  var idHorario = $(this).attr("idHorario");
 console.log("el id de eliminacion es :: ", idHorario);
  swal({
    title: '¿Está seguro de borrar el horario?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar horario!'
  }).then((result)=>{

    if(result.value){

      window.location = "vista.php?idhorario="+idHorario;

    }

  })

});

/*=============================================
Data Table
=============================================*/

$(".tablas").DataTable({

	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	}

});
