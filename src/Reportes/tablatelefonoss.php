<?php
    require_once "../Controladores/GrupoHorarioControl.php";
    $periodoId = $_POST["tPeriodoId"];
    $grupoId = $_POST["tsGrupo"];
    $condicion = $_POST["condicions"];
    $fecha = $_POST["fecha"];

?>
 
  <table class="table table-bordered table-striped dt-responsive tablas3" style="width: 100%;">
         
    <thead>
         
        <tr>
           
            <th style="width:10px">#</th>
            <th>Nombre</th>
            <th>Dni Alumno</th>
            <th>Apoderado</th>
            <th>Movistar</th>
            <th>Rpm</th>
            <th>Claro</th>
            <th>Otro</th>
            <th>Fijo</th>
            <th>Condicion</th>
           
        </tr> 

    </thead>

    <tbody>
      <?php
		$objAsistencia = new ControladorGrupoHorario();
        $asistenciaI = $objAsistencia->ctrMostrarAsistencias(3,$periodoId,$grupoId,$condicion,$fecha);
            
         foreach ($asistenciaI as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.utf8_encode($value["apePat"]." ".$value["apeMat"]." ".$value["nombreal"]).'</td>
                  <td>'.$value["dni"].'</td>             
                  <td>'.utf8_encode($value["apePa"]." ".$value["apeMa"]." ".$value["nombreap"]).'</td> 
                  <td>'.$value["movistar"].'</td> 
                  <td>'.$value["rpm"].'</td> 
                  <td>'.$value["claro"].'</td> 
                  <td>'.$value["otro"].'</td> 
                  <td>'.$value["fijo"].'</td>';
          if($value["condicion"]=="P"){
            echo '<td class="cp" >'.$value["condicion"].'</td>';}
          if($value["condicion"]=="T"){
            echo '<td class="ct">'.$value["condicion"].'</td>';}
          if($value["condicion"]=="F"){
            echo '<td class="cf">'.$value["condicion"].'</td>';}
             
          echo '</tr>';
        }
        ?>  
    </tbody>

  </table>


<script type="text/javascript">

$(".tablas3").DataTable({

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
</script>