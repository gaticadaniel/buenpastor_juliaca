<?php
require_once "../Modelos/HorariosModel.php";
require_once "../Modelos/AsistenciasModel.php";

class ControladorReportes{
    
    /*=============================================
    MOSTRAR HORARIOS Y NIVELES
    =============================================*/
     public function ctrVerHorasAsistencia($dni,$apeP,$apeM,$nombre,$fechainicio,$fechafin){
      
        $objHoras = new AsistenciasModel();
        $resultadoHoras = $objHoras->mdlVerHorasAsistencia($dni,$apeP,$apeM,$nombre,$fechainicio,$fechafin);    
	   return $resultadoHoras;
  
     }
    
    
}