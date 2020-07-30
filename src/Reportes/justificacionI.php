<?php
    require_once "../Controladores/GrupoHorarioControl.php";
    require_once "../Controladores/ReporteControl.php";
    $periodoId = $_POST["jPeriodo"];
    $grupoId = $_POST["jiGrupo"];
    $condicion = $_POST["condicioni"];
    $fecha = $_POST["fecha"];
    $horario = $_POST["horario"];

?>
 
<table class="table table-bordered table-striped dt-responsive tablas0" style="width: 100%;">
         
    <thead>
         
        <tr>
           
            <th style="width:10px">#</th>
            <th>Nombre</th>
            <th>Dni Alumno</th>
            <th>Apoderado</th>
            <th>Num. Celular</th>
            <th style="width:10px">Condicion</th>
            <th>Envio Mensaje</th>
           
        </tr> 

    </thead>

    <tbody>
      <?php
		$obJustificaciones = new ControladorReportes();        
        $justificacion = $obJustificaciones->ctrMostrarAsistencias(1,$periodoId,$grupoId,$condicion,$fecha,$horario);
         foreach ($justificacion as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.utf8_encode($value["apePat"]." ".$value["apeMat"]." ".$value["nombreal"]).'</td>
                  <td>'.$value["dni"].'</td>             
                  <td>'.utf8_encode($value["apePa"]." ".$value["apeMa"]." ".$value["nombreap"]).'</td> 
                  <td>'.$value["movistar"]." - ".$value["rpm"]." - ".$value["claro"]." - ".$value["otro"]." - ".$value["fijo"]. '</td>';
          if($value["condicion"]=="P"){
            echo '<td class="cp">'.$value["condicion"].'</td>';
            echo '<td>
            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
            <span class="input-group-addon"><i class="fa fa-send"></i></span>
            </td>';}
             
          if($value["condicion"]=="T"){
            echo '<td class="c"> <span class="ct btnJusticar" condicion="T" idA="'.$value["idA"].'">'.$value["condicion"].'</span>
            </td>';
              
            echo '<td>
            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
            <span class="input-group-addon"><i class="fa fa-send"></i></span>
            </td>';}
             
          if($value["condicion"]=="FJ"){
            echo '<td class="c"> <span class="cfj btnJusticar" condicion="FJ" idA="'.$value["idA"].'">'.$value["condicion"].'</span>
            <span class="comentario btnComentario" idCom="'.$value["idA"].'" data-toggle="modal" data-target="#modalComentario" ><i class="fa fa-comment-o"></i>
            <input type="hidden" class="form-control input-lg" id="idComent" name="idComent" value=""> </span>
            </td>';
         
            echo '<td>
            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
            <span class="input-group-addon"><i class="fa fa-send"></i></span>
            </td>';}   
          if($value["condicion"]=="TJ"){
            echo '<td class="c"> <span class="ctj btnJusticar" condicion="TJ" idA="'.$value["idA"].'">'.$value["condicion"].'</span>
            <span class="comentario btnComentario" idCom="'.$value["idA"].'" data-toggle="modal" data-target="#modalComentario" ><i class="fa fa-comment-o"></i></span>
            <input type="hidden" class="form-control input-lg" id="idComent" name="idComent" value=""></span>
            </td>';
              
            echo '<td>
            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
            <span class="input-group-addon"><i class="fa fa-send"></i></span>
            </td>';}
             
             
          if($value["condicion"]=="F"){
            echo '<td class="c"> <span class="cf btnJusticar" condicion="F" idA="'.$value["idA"].'">'.$value["condicion"].'</span> </td>';
              
            echo '<td>
            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
            <span class="input-group-addon"><i class="fa fa-send"></i></span>
            </td>';}
          
           
          echo '</tr>';
        }
        ?> 
    </tbody>

</table>

<!--by Pantigoso-->
  <div class="signos">
   <ul class="leyenda">
      <ol> <span class="cp">P </span>: Puntual</ol>
      <ol> <span class="ct">T </span>: Tarde</ol>
      <ol> <span class="ctj">TJ </span>:  Tarde Justificada</ol>
      <ol> <span class="cf">F </span>: Falta</ol>
      <ol> <span class="cfj">FJ </span>: Falta Justificada</ol>
   </ul>  
  </div>

<!--=====================================
MODAL AGREGAR Horario
======================================-->

<div id="modalComentario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#04C0EE; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Justificacion</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA LA JUSTIFICACION -->
            
            <div class="form-group">
            
             <label> Ingrese el asunto de la justificacion </label>
            
            <textarea class="form-control" name="justificacion" id="justificacion" placeholder="Ingrese una justitifacion"></textarea>
            
<!--            <input type="text" class="form-control" name="justificacion"  placeholder="Enter ..."> -->
           
            </div>
            
            
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardarComentario()">Guardar Justificacion</button>

        </div>
      
      <?php
        $objJustificacion = new ControladorReportes();
        $objJustificacion->ctrJustificar();
       ?>

    </div>

  </div>

</div>


<script type="text/javascript">

$(".tablas0").DataTable({

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
    
/*=============================================
JUSTIFICAR ASISTENCIA
=============================================*/
$(".tablas0").on("click", "td .btnJusticar", function(){
var condicion = $(this).attr("condicion");
	var idAsistencia = $(this).attr("idA");

	var datos = new FormData();
    
    if(condicion == "F"){
      datos.append("condicion", "FJ");
  	  datos.append("idAsistencia", idAsistencia);
    }
    if(condicion == "T"){
      datos.append("condicion", "TJ");
  	  datos.append("idAsistencia", idAsistencia);  
    }
    if(condicion == "FJ"){
      datos.append("condicion", "F");
  	  datos.append("idAsistencia", idAsistencia);
    }
    if(condicion == "TJ"){
      datos.append("condicion", "T");
  	  datos.append("idAsistencia", idAsistencia);  
    }

  	$.ajax({

	  url:"../ajax/asistencias.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      }

  	})

  	
  	if(condicion == "T"){
  		$(this).parent().html('<span class="ctj btnJusticar" condicion="TJ" idA="'+idAsistencia+'">TJ</span><span class="comentario btnComentario" idCom="'+idAsistencia+'" data-toggle="modal" data-target="#modalComentario" ><i class="fa fa-comment-o"></i> <input type="hidden" class="form-control input-lg" id="idComent" name="idComent" value="">  </span>');
  	}
    
    if(condicion == "TJ"){
  		$(this).parent().html('<span class="ct btnJusticar" condicion="T" idA="'+idAsistencia+'">T</span>');
  	}
  	if(condicion == "F"){
  		$(this).parent().html('<span class="cfj btnJusticar" condicion="FJ" idA="'+idAsistencia+'">FJ</span><span class="comentario btnComentario" idCom="'+idAsistencia+'" data-toggle="modal" data-target="#modalComentario" ><i class="fa fa-comment-o"></i> <input type="hidden" class="form-control input-lg" id="idComent" name="idComent" value=""> </span>');
  	}
    
    if(condicion == "FJ"){
  		$(this).parent().html('<span class="cf btnJusticar" condicion="F" idA="'+idAsistencia+'">F</span>');
  	}
    
  	else{
  	}

})
    
$(".tablas0").on("click", "td .btnComentario", function(){

	var idAsis = $(this).attr("idCom");
    
    var datosC = new FormData();
    datosC.append("idAsis", idAsis);

	$.ajax({
        url:"../ajax/asistencias.ajax.php",
        method: "POST",
		data: datosC,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
            $("#justificacion").html(respuesta[0]["justificado"]);
            $("#justificacion").val(respuesta[0]["justificado"]);
            $("#idComent").html(respuesta[0]["id"]);
            $("#idComent").val(respuesta[0]["id"]);
		}
	});

})

function guardarComentario(){
    var comentario = document.getElementById("justificacion").value;
    var idCom = document.getElementById("idComent").value;
    
    console.log(comentario);
    console.log(idCom);
    
    var datosGC = new FormData();
    datosGC.append("idCome", idCom);
    datosGC.append("comentarioG", comentario);

	$.ajax({
        url:"../ajax/asistencias.ajax.php",
        method: "POST",
		data: datosGC,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
            console.log(respuesta[0]["justificado"]);
		}
	});
}
</script>
