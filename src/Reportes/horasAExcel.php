<?php
    require_once "../Controladores/ReporteControl.php";
    $dni = $_GET["dnia"];
    $fechainicio = $_GET["fechai"];
    $fechafin = $_GET["fechaf"];
    
    header('Expires: 0');
    header('Cache-control: private');
    header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
	header("Cache-Control: cache, must-revalidate"); 
	header('Content-Description: File Transfer');
	header('Last-Modified: '.date('D, d M Y H:i:s'));
	header("Pragma: public"); 
	header('Content-Disposition:; filename="Reporte.xls"');
	header("Content-Transfer-Encoding: binary");
?>

<div class="box">
 
  <table border='1' class="table table-bordered table-striped dt-responsive">
         
    <thead >
         
      <tr border='3'>
           
           <th ROWSPAN='2' style="width:10px; padding: 25px ;">#</th>
           <th ROWSPAN='2' id="ctablec">Apellidos y Nombres</th>
           <th ROWSPAN='2' id="ctablec">Fecha</th>
           <th ROWSPAN='2' id="ctablec">Hora Entrada</th>
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
        $horarios = $objHorarios->ctrVerHorasAsistencia($dni,$fechainicio,$fechafin);
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
                  <td>'.$value["hora_de_ingreso_real"].'</td> 
                  <td>'.$value["hora_de_salida"].'</td> 
                  <td>'.$value["hora_de_salida_real"].'</td> 
                  <td>'.$value["diferencia_ingreso"].'</td> ';
            
             $mt+=$value["diferencia_ingreso"];
              if($value["condicion"]=="P"){
                  echo '<td>'.$value["condicion"].'</td>';
                  $cp+=1;
              }else{
                  echo '<td></td>';
              }
             if($value["condicion"]=="T"){
                  echo '<td>'.$value["condicion"].'</td>';
                 $ct+=1;
              }else{
                  echo '<td></td>';
              }
             if($value["condicion"]=="F"){
                  echo '<td>'.$value["condicion"].'</td>';
                 $cf+=1;
              }else{
                  echo '<td></td>';
                }
              echo' </tr>';
                
        }
        ?> 
        <tr>
                  <td colspan="7" style="text-align: right; ">Total</td>
                  <td><?php echo $mt; ?></td>
                  <td><?php echo $cp; ?></td>
                  <td><?php echo $ct; ?></td>
                  <td><?php echo $cf; ?></td>
        </tr>

    </tbody>

  </table>
</div>
<!--<link rel="stylesheet" href="../../dist/css/tablas.css">-->
