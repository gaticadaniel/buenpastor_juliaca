<?php
    require_once "../Modelos/AsistenciasModel.php";
    require_once "../Controladores/GrupoHorarioControl.php";
  setlocale(LC_ALL,"es_PE");
    $periodoId = $_POST["fPeriodoId"];
    $grupoId = $_POST["fGrupo"];
    $fechainicio = $_POST["fechai"];
    $fechafin = $_POST["fechaf"];
    $objMatriculados = new AsistenciasModel();            
    $respuesta = $objMatriculados->mdlVerMatriculadosPeriodo($periodoId,$grupoId);
    $range= ((strtotime($fechafin)-strtotime($fechainicio))+(24*60*60)) /(24*60*60);
?>
 
<table class="table table-bordered table-striped tablasf" style="width: 100%;">
         
    <thead>
         
      <tr role="row">
        
        <th style="width:10px">#</th>
        <th style='width:150px'>Nombre</th>
        <?php
          for($i=0;$i<$range;$i++){
            echo utf8_decode("<th style='width:10px'>".strftime("%a %d",strtotime($fechainicio)+($i*(24*60*60)))."</th>");
          }
        ?>   
      </tr> 

    </thead>

    <tbody>
      <?php
		foreach($respuesta as $key => $al){
              
            echo '<tr>';
              echo '<td>'.($key+1).'</td>';
              echo '<td>'.$al["apePa"]." ".$al["apeMa"]." ".$al["nombres"].'</td>';
              for($i=0;$i<$range;$i++){
                $date_at= date("Y-m-d",strtotime($fechainicio)+($i*(24*60*60)));
                $objFechas = new AsistenciasModel();            
                $asistenci = $objFechas->mdlAsistenciaPorUserId($al["user_id"],$date_at); 
                if($asistenci!=null){
                    
                 if($asistenci[0]["condicion"]=="P"){
                  echo '<td class="cp" >'.$asistenci[0]["condicion"].'</td>';}
                 if($asistenci[0]["condicion"]=="T"){
                  echo '<td class="ct">'.$asistenci[0]["condicion"].'</td>';}
                 if($asistenci[0]["condicion"]=="F"){
                  echo '<td class="cf">'.$asistenci[0]["condicion"].'</td>';}  

                }else{echo "<td></td>";}
                  
              }
            echo '</tr>';

           }
        ?> 
    </tbody>
    
    <tfoot>
         
      <tr>
        
        <th style="width:10px">#</th>
        <th style='width:150px'>Nombre</th>
        <?php
          for($i=0;$i<$range;$i++){
            echo utf8_decode("<th style='width:10px'>".strftime("%a %d",strtotime($fechainicio)+($i*(24*60*60)))."</th>");
          }
        ?>   
      </tr> 

    </tfoot>

</table>


<script type="text/javascript">

$(".tablasf").DataTable({

    "scrollX": true,
    ordering: false,

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



