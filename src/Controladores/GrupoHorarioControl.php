<?php
    require_once "../Modelos/AsistenciasModel.php";
    require_once "../Modelos/PeriodosModel.php";
    require_once "../Modelos/GruposModel.php";
    require_once "../Modelos/GruposHorariosModel.php";
    require_once "../Modelos/UsersModel.php";

class ControladorGrupoHorario{
	/*=============================================
	MOSTRAR PERIODOS
	=============================================*/
    public function ctrMostrarPeriodos($valor){     
        $objPeriodo = new PeriodosModel();
        if($valor != null){
            $periodos = $objPeriodo->get_periodos_por_id($valor);
        }else{ 
            $periodos = $objPeriodo->get_periodos();
        }
		return $periodos;
	}
    
    /*=============================================
	MOSTRAR GRUPOS
	=============================================*/
    public function ctrMostrarGruposporPeriodo($valor1){
        $objGrupos = new GruposModel(); 
        $grupos = $objGrupos->grupos_por_periodo($valor1);
		return $grupos;
	}
    
    /*=============================================
	MOSTRAR GRUPOS DE HORARIOS
	=============================================*/
    public function ctrMostrarGrupoHorariosPorGrupo($id){
        $objGrupoHorario = new GruposHorariosModel();    
        $grupohorarios = $objGrupoHorario->mdlMostrarGrupoHorariosPorGrupo($id);
		return $grupohorarios;
	}
    public function ctrMostrarGrupoH_por_id($valor){
        $objHorariosGrupos = new GruposHorariosModel();
        $grupohorarios = $objHorariosGrupos->mdlMostrarGrupoH_por_id($valor);
		return $grupohorarios;
	}
    
    /*=============================================
	MOSTRAR CHECKBOX DE GRUPOS
	=============================================*/
    public function ctrMostrarCheckGrupos($vPeriodo,$vNivel){
        $gChecks = new GruposHorariosModel();
        $gruposcheck = $gChecks->mdlMostrarCheckGrupo($vPeriodo,$vNivel);
		return $gruposcheck;
	} 
    
    /*=============================================
	MOSTRAR Grupos por periodo y nivel
	=============================================*/
    public function ctrVerGruposPorPeriodoNivel($vPeriodo,$vNivel){
        $gruposnil = new GruposHorariosModel();
        $gruposnivelp = $gruposnil->mdlVerGruposPorPeriodoNivel($vPeriodo,$vNivel);
		return $gruposnivelp;
	}
    
    /*=============================================
	CREAR GRUPO HORARIO
	=============================================*/
    public function ctrCrearGrupoHorario(){

		if(isset($_POST["ngHorario"]) and isset($_POST["grupos"]) ){
            
          $grupos = $_POST['grupos'];
          $horarioId = $_POST['ngHorario'];
          $fecha = $_POST['fecha'];
          $usuario=$_SESSION['user'][0]['username'];
          $datos = array("ngHorario" => $horarioId, "fecha" => $fecha,
          "usuario" => $usuario); $respuesta=false;
          $registro = new GruposHorariosModel();
          
          foreach($grupos as $grupo){
            $validacion = new GruposHorariosModel();
            $validado=$validacion->mdlVerificarRedundancia($grupo,$fecha,$horarioId); 
          //si el resultado es igual a 0 aun no se ha registrado ese grupo horario e iniciara a registrarlo, de lo contrario lo ignorara
            if(count($validado)==0){
              $respuesta = $registro->mdlRegistrarGrupoHorario($grupo,$datos);
            // Registra la asistencias de las matriculas segun el grupo 
              $datosmatricula = new AsistenciasModel();            
              $matriculados = $datosmatricula->obtener_datos_para_crear_asistencia($grupo,$fecha,$horarioId);
              foreach ($matriculados as $matricula){
                $registrarMatricula = new AsistenciasModel();
                $registrarMatricula->registrar_asistencias($matricula,$fecha,$usuario);
              }    
            }else{
             echo'<script>

				swal({
				  icon: "warning",
				  title: "¡Algunos grupos/horarios no se registraron!",
                  text: "probablemente ya existan, eliminelos e intente nuevamente",
                });

			   </script>';   
            }  

          }
            
            if($respuesta){
                    
              echo'<script>

				swal({
                  type: "success",
				  title: "Los grupos/horarios han sido registrados correctamente",
				  showConfirmButton: true,
				  confirmButtonText: "Cerrar"
				  }).then((result) => {
				    if (result.value) {

                            window.location = "vista.php";
                        }
				    })

               </script>';

            }else{
                    
              echo'<script>

				swal({
				  type: "error",
				  title: "¡Los grupos/horarios no puede ser creados!",
                  text: "Asegurese que los datos no se dupliquen",
				  showConfirmButton: true,
				  confirmButtonText: "Cerrar",
				  closeOnConfirm: false
				  }).then((result) => {
				    if (result.value) {
				            window.location = "vista.php";
				        }
                    })

			   </script>';
                    
            }
		}
	}
    
    
    
    
    
    /*=============================================
	BORRAR GRUPO HORARIO
	=============================================*/
    public function ctrEliminarGrupoHorario(){

        if(isset($_GET["idGrupoHorario"])){

          $datos = $_GET["idGrupoHorario"];
            
          $objborrargrupoh = new GruposHorariosModel();
          $objborrarasistencia = new GruposHorariosModel();
          $objborrarasistencia->mdlEliminarAsistenciaDeUnGrupoHorario($datos);
          $respuesta = $objborrargrupoh->mdlEliminarGrupoHorario($datos);
            
          if($respuesta == "ok"){

            echo'<script>

              swal({
				type: "success",
                title: "El grupo y horario ha sido borrado correctamente",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
                }).then((result) => {
                    if (result.value) {

						window.location = "vista.php";

                    }
                  })

				</script>';

          }else{
                
            echo'<script>

              swal({
				type: "error",
                title: "¡El horario y grupo no puede ser eliminado!",
                text: "Revise si otra tabla lo esta utilizando",
				showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
                  }).then((result) => {
				    if (result.value) {

						window.location = "vista.php";

                    }
                  })

			  	</script>';
                
            }		
		}
	}
    
    /*=============================================
	EDITAR GRUPO HORARIO
	=============================================*/

    public function ctrEditarGrupoHorario(){
        
        if(isset($_POST["idghorario"])){

          $datos = array("editGrupo" => $_POST["editGrupo"],
                "editHorario" => $_POST["editHorario"],
                "editfecha" => $_POST["editfecha"],
                "idghorario" => $_POST["idghorario"],
                "usuario" => $_SESSION['user'][0]['username']);
            
          $objAsistencias = new GruposHorariosModel();
          $respuesta = $objAsistencias->mdlModificargrupohorario($datos);
        
          if($respuesta){

            echo'<script>

              swal({
				 type: "success",
                 title: "El grupo y horario ha sido modificado correctamente",
                 showConfirmButton: true,
                 confirmButtonText: "Cerrar"
			  }).then((result) => {
				if (result.value) {
                                        
				    window.location = "vista.php";

                }
              })

            </script>';

          }else{
                    
            echo'<script>

              swal({
				type: "error",
                title: "¡El grupo y horario no puede ser modificado!",
                text: "Asegurese que los datos sean validos",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
              }).then((result) => {
				if (result.value) {

				    window.location = "vista.php";

				}
              })

			 </script>';
                    
           }
		}
	}
    
    /*=============================================
	MOSTRAR Asistencias
	=============================================*/
    public function ctrMostrarAsistencias($nivel,$periodo,$grupo,$condicion,$fecha){
        
        $objAsis = new UsersModel(); 
        $asistencia = $objAsis->mdlVerTelefonosUsuarios($nivel,$periodo,$grupo,$condicion,$fecha);
		return $asistencia;
	}

}

