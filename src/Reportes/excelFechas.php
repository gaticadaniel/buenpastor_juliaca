<?php

require_once "../Modelos/AsistenciasModel.php";
setlocale(LC_ALL,"es_PE");
  $periodoid = $_GET["periodo"];
  $grupoid = $_GET["grupo"];
  $fechainicio = $_GET["fechai"];
  $fechafin = $_GET["fechaf"];
  $objMatriculas = new AsistenciasModel();            
  $respuesta = $objMatriculas->mdlVerMatriculadosPeriodo($periodoid,$grupoid);
  $range= ((strtotime($fechafin)-strtotime($fechainicio))+(24*60*60)) /(24*60*60);

    header('Expires: 0');
    header('Cache-control: private');
    header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
	header("Cache-Control: cache, must-revalidate"); 
	header('Content-Description: File Transfer');
	header('Last-Modified: '.date('D, d M Y H:i:s'));
	header("Pragma: public"); 
	header('Content-Disposition:; filename="Reporte.xls"');
	header("Content-Transfer-Encoding: binary");

    echo utf8_decode("<table border='1'> 
        <tr> 
		<td ROWSPAN='2' style='padding-bottom:10px; font-weight:bold; border:1px solid #eee;'>Nombre del estudiante</td>");
    
    
    for($i=0;$i<$range;$i++){
        
        echo utf8_decode("<td ROWSPAN='2' style='font-weight:bold; width:38px; border:1px solid #eee;'>".strftime("%a %d",strtotime($fechainicio)+($i*(24*60*60)))."</td>"); 
    }
    echo "<td colspan='4' style='font-weight:bold; width:150px; text-align:center; border:1px solid #eee;'>Totales</td>";
    echo "</tr>";
    echo "<tr>";
    for($i=0;$i<4;$i++){
        echo "<td style='font-weight:bold; text-align:center; border:1px solid #eee;'>T</td>";
        
        if($i=1){
            echo "<td style='font-weight:bold; text-align:center; border:1px solid #eee;'>E</td>";
        }
        if($i=2){
            echo "<td style='font-weight:bold; text-align:center; border:1px solid #eee;'>I</td>";
        }
        if($i=3){
            echo "<td style='font-weight:bold; text-align:center; border:1px solid #eee;'>P</td>";
        }
    }
    echo "</tr>";

   foreach ($respuesta as $row => $item){
 
       echo utf8_decode("<tr> 
         <td style='border:1px solid #eee;'>".$item["nombres"]."</td>");
       
       for($i=0;$i<$range;$i++){
            $date_at= date("Y-m-d",strtotime($fechainicio)+($i*(24*60*60)));
            $objAsistencia = new AsistenciasModel();            
            $asistenci = $objAsistencia->mdlAsistenciaPorUserId($item["user_id"],$date_at); 
            if($asistenci!=null){
              echo "<td style='text-align:center;'>".$asistenci[0]["condicion"]."</td>";

            }else{echo "<td></td>";}          
       } 
       
       for($i=0;$i<4;$i++){
            $objAsistencia = new AsistenciasModel();            
            $asistenci = $objAsistencia->mdlContarAsistencia($item["user_id"],$fechainicio,$fechafin,"T"); 
           
            echo "<td style='text-align:center;'>".$asistenci[0]["C"]."</td>";
        if($i=1){
            $objAsistencia = new AsistenciasModel(); 
            $asistenci = $objAsistencia->mdlContarAsistencia($item["user_id"],$fechainicio,$fechafin,"E"); 
            echo "<td style='text-align:center;'>".$asistenci[0]["C"]."</td>";
        }
        if($i=2){
            $objAsistencia = new AsistenciasModel();  
            $asistenci = $objAsistencia->mdlContarAsistencia($item["user_id"],$fechainicio,$fechafin,"F"); 
            echo "<td style='text-align:center;'>".$asistenci[0]["C"]."</td>";
        }
        if($i=3){
            $objAsistencia = new AsistenciasModel(); 
            $asistenci = $objAsistencia->mdlContarAsistencia($item["user_id"],$fechainicio,$fechafin,"P"); 
            echo "<td style='text-align:center;'>".$asistenci[0]["C"]."</td>";
        }
                    
       }
       
       
   }
    
    echo "</tr>";
    echo "</table>";

?>

			
