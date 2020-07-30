<?php

require_once "../Controladores/HorarioControl.php";

/*=============================================
EDITAR Horario
=============================================*/	
class AjaxHorarios{
    
	public $idHorario;
	public function ajaxEditarHorario(){
		$valor = $this->idHorario;
        $editHorario = new ControladorHorarios();
        $respuesta = $editHorario->ctrVerHorariosyNiveles($valor);
		echo json_encode($respuesta);

	}
	
}

if(isset($_POST["idHorario"])){
	$editar = new AjaxHorarios();
	$editar -> idHorario = $_POST["idHorario"];
	$editar -> ajaxEditarHorario();
}

