<?php
    require_once "../Controladores/ReporteControl.php";
    $dni = $_POST["dniH"];
    $apeP = $_POST["apePH"];
    $apeM = $_POST["apeMH"];
    $nombre = $_POST["nombreH"];
    $fechainicio = $_POST["fechaInicial"];
    $fechafin = $_POST["fechaFinal"];
?>


 
  <table class="table table-bordered table-striped dt-responsive tablasH" style="width: 100%;">
         
    <thead>
         
      <tr>
           
           <th ROWSPAN='2' style="width:10px; padding: 25px ;">#</th>
           <th ROWSPAN='2' id="ctablec">Apellidos y Nombres</th>
           <th ROWSPAN='2' id="ctablec">Fecha</th>
           <th ROWSPAN='2' id="ctablec">Hora Entrada</th>
           <th ROWSPAN='2' id="ctablec">Tolerancia Entrada</th>
           <th ROWSPAN='2' id="ctablec">Hora Ingreso Real</th>
           <th ROWSPAN='2' id="ctablec">Hora Salida</th>
           <th ROWSPAN='2' id="ctablec">Hora Salida Real</th>
           <th ROWSPAN='2' id="ctablec">Minutos Tarde</th>
           <th colspan="3" id="ctable">Condicion</th>
           
      </tr> 
      <tr>
           <th>Puntual</th>
           <th>Tarde</th>
           <th>Falta</th>
      </tr>


    </thead>

    <tbody>
        <?php
        
		$objHorarios = new ControladorReportes();
        $horarios = $objHorarios->ctrVerHorasAsistencia($dni,$apeP,$apeM,$nombre,$fechainicio,$fechafin);
        $cp=0;
        $ct=0;
        $cf=0;
        $mt=0;
         foreach ($horarios as $key => $value){
         
          echo ' <tr>
            <td>'.($key+1).'</td>
            <td>'.$value["apellido_paterno"]." ".$value["apellido_materno"]." ".$value["nombres"].'</td>
            <td>'.$value["fecha"].'</td>             
            <td>'.$value["hora_de_ingreso"].'</td> 
            <td>'.$value["tolerancia_ingreso"].'</td> 
            <td>'.$value["hora_de_ingreso_real"].'</td> 
            <td>'.$value["hora_de_salida"].'</td> 
            <td>'.$value["hora_de_salida_real"].'</td>';
             if($value["diferencia_ingreso"]<0){
                echo '<td>'.-($value["diferencia_ingreso"]).'</td> ';
                      $mt+=$value["diferencia_ingreso"];
                  }else{
                echo '<td>0</td> ';
                  }
             
              if($value["condicion"]=="P"){
                  echo '<td class="cp">'.$value["condicion"].'</td>';
                  $cp+=1;
              }else{
                  echo '<td></td>';
              }
             if($value["condicion"]=="T"){
                  echo '<td class="ct">'.$value["condicion"].'</td>';
                 $ct+=1;
              }else{
                  echo '<td></td>';
              }
             if($value["condicion"]=="F"){
                  echo '<td class="cf">'.$value["condicion"].'</td>';
                 $cf+=1;
              }else{
                  echo '<td></td>';
                }
              echo' </tr>';

                
        }
        ?> 


    </tbody>

  </table>


<script type="text/javascript">

$(".tablasH").DataTable({
//    "paging":   false,
//    "ordering": false,
//    "info":     false,
    
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
