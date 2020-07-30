<?php
    require_once "../Modelos/GruposModel.php";
    session_start();
/*=============================================
MOSTRAR GRUPO AL SELECCIONAR PERIODO
=============================================*/	
class AjaxMostrarGrupos{
    
	public $periodoId;
	public function ajaxGruposporPeriodo(){
		$valor = $this->periodoId;
        $editHorario = new GruposModel();
        $html="<option value='' >Seleccione Grupo</option>";
        $respuesta = $editHorario->grupos_por_periodo($valor);
        foreach ($respuesta as $key => $value) {          
          $html.='<option value="'.$value["id"].'">'.$value["comentario"].'</option>';    
        }
		echo $html;
	}
}

if(isset($_POST["PeriodoId"])){
	$selec = new AjaxMostrarGrupos();
	$selec -> periodoId = $_POST["PeriodoId"];
	$selec -> ajaxGruposporPeriodo();
}

/*=============================================
ENVIAR DATOS POR POST PARA CARGAR LAS ASISTENCIAS
=============================================*/	
if(isset($_POST["PeriodoId"]) and isset($_POST["GrupoId"])){
    
    $idP = $_POST["PeriodoId"];
    $_SESSION['PerId']=$idP;
    $idG = $_POST["GrupoId"];
    $_SESSION['GrupId']=$idG;
    echo "llegaron las variables :".$idP." ++ ".$idG;
}



