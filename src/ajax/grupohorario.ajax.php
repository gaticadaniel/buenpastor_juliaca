<?php

require_once "../Controladores/GrupoHorarioControl.php";
require_once "../Controladores/HorarioControl.php";
require_once "../Modelos/GruposModel.php";
session_start();
/*=============================================
Mostrar grupo al seleccionar periodo
=============================================*/
if(isset($_POST["sPeriodoId"]) ){
	$selecGrupo = new AjaxSGrupo();
	$selecGrupo -> sPeriodoId = $_POST["sPeriodoId"];
	$selecGrupo -> ajaxMostrarGrupo();
}
class AjaxSGrupo{
	public $sPeriodoId;
    
	public function ajaxMostrarGrupo(){
        
		$valorp = $this->sPeriodoId;
        $objGrupos = new ControladorGrupoHorario();
        $respuesta = $objGrupos->ctrMostrarGruposporPeriodo($valorp);
        $htmls='<option value="0" >Seleccione un Grupo</option>';
            
        foreach ($respuesta as $key => $value) {        
          $htmls.= '<option value='.$value["id"].'>'.utf8_encode($value["comentario"])." - ".
              utf8_encode($value["seccion"]).'</option>';   
        }
        
      echo $htmls;
    }
}

/*=============================================
Mostrar grupo al seleccionar periodo y grupo 
=============================================*/
if(isset($_POST["tPeriodoId"]) and isset($_POST["tNivelId"])){
	$selecGrupo = new AjaxGruposNivel();
	$selecGrupo -> tPeriodoId = $_POST["tPeriodoId"];
	$selecGrupo -> tNivelId = $_POST["tNivelId"];
	$selecGrupo -> ajaxVerGruposporNivel();
}
class AjaxGruposNivel{
	public $tPeriodoId;
	public $tNivelId;
    
	public function ajaxVerGruposporNivel(){
        
		$valorperiodo = $this->tPeriodoId;
		$valornivel = $this->tNivelId;
        $objGrupos = new GruposModel();
        $respuesta = $objGrupos->mdlVerGruposPorPeriodoNivel($valorperiodo,$valornivel);
        $htmls='<option value="0" >Seleccione un Grupo</option>';
            
        foreach ($respuesta as $key => $value) {        
          $htmls.= '<option value='.$value["id"].'>'.utf8_encode($value["comentario"])." - ".utf8_encode($value["secion"]).'</option>';   
        }
        
      echo $htmls;
    }
}

/*=============================================
MOSTRAR GRUPOS HORARIOS AL SELECCIONAR UN ID PERIODO Y GRUPO
=============================================*/
if(isset($_POST["idPeriodoG"]) ){
	$idP = $_POST["idPeriodoG"];
    $_SESSION['idPeriodo']=$idP;
}

if(isset($_POST["idGrupoL"]) ){
	$idG = $_POST["idGrupoL"];
    $_SESSION['idGrupo']=$idG;
}

/*=============================================
MOSTAR CHECKBOX DE GRUPO AL SELECCIONAR PERIODO O NIVEL (MODAL)
=============================================*/
if(isset($_POST["idPeriodo"]) and isset($_POST["idNivel"])){
	$seleccion = new AjaxChecboxGrupo();
	$seleccion -> idPeriodo = $_POST["idPeriodo"];
	$seleccion -> idNivel = $_POST["idNivel"];
	$seleccion -> ajaxSeleccionGrupoChecks();
}

class AjaxChecboxGrupo{
  public $idPeriodo;
  public $idNivel;
    
  public function ajaxSeleccionGrupoChecks(){
    $vPeriodo = $this->idPeriodo;
    $vNivel = $this->idNivel;
    $objchecks = new ControladorGrupoHorario();
    $respuesta = $objchecks->ctrMostrarCheckGrupos($vPeriodo,$vNivel);
        $htmls= "";
            
        foreach ($respuesta as $key => $value) {        
            $htmls.= '<label class="col-xs-6" > <input type="checkbox" name="grupos[]" value="'.$value["id"].'" />'.$value["comentario"].'</label> ';    
        }
	
	   echo $htmls;

    }
}
/*=============================================
MOSTRAR GRUPOS AL SELECCIONAR UN PERIODO POR ID
=============================================*/
if(isset($_POST["idPeriodoG"]) ){
	$seleccionar = new AjaxGrupoporPeriodo();
	$seleccionar -> idPeriodoG = $_POST["idPeriodoG"];
	$seleccionar -> ajaxSeleccionGrupoPeriodo();
}
class AjaxGrupoporPeriodo{
  public $idPeriodoG;
  public function ajaxSeleccionGrupoPeriodo(){
        
	$valorPeriodo = $this->idPeriodoG;
    $objGrupo = new GruposModel();
    $respuesta = $objGrupo->grupos_por_periodo($valorPeriodo);
    $html= "<option value='' >Seleccione Grupo</option>";            
     foreach ($respuesta as $key => $value) {        
      $html.= '<option value='.$value["id"].'>'.$value["comentario"].'</option>';   
     }
      echo $html;
    }
}











class AjaxGrupoHorarios{

	/*=============================================
	EDITAR Horario
	=============================================*/	

	public $idGrupoHorario;

	public function ajaxEditarGrupoHorario(){

		$valor = $this->idGrupoHorario;
        $objAsistencias = new ControladorGrupoHorario();
        $respuesta = $objAsistencias->ctrMostrarGrupoH_por_id($valor);
        
		echo json_encode($respuesta);

	}
	
}

/*=============================================
EDITAR Horario
=============================================*/
if(isset($_POST["idGrupoHorario"])){

	$editar = new AjaxGrupoHorarios();
	$editar -> idGrupoHorario = $_POST["idGrupoHorario"];
	$editar -> ajaxEditarGrupoHorario();

}

class AjaxHorario{
	public $nivelId;
    
	public function ajaxSeleccionHorario(){
        
		$valorNivel = $this->nivelId;
        $objhorario = new ControladorHorarios();
        $respuesta = $objhorario->ctrMostrarhorariosPorNivel($valorNivel);
        $htmls="<option value='' >Selecionar Horario</option>";
            
        foreach ($respuesta as $key => $value) {        
          $htmls.= '<option value='.$value["id"].'>'.$value["denominacion"].'</option>';   
        }
      echo $htmls;

    }
}

/*=============================================
Selecionar Periodo
=============================================*/
if(isset($_POST["nivelId"]) ){
	$selecthorario = new AjaxHorario();
	$selecthorario -> nivelId = $_POST["nivelId"];
	$selecthorario -> ajaxSeleccionHorario();
}
