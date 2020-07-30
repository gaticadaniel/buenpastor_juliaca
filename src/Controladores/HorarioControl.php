<?php
require_once "../Modelos/HorariosModel.php";

class ControladorHorarios{
    
    /*=============================================
    MOSTRAR HORARIOS Y NIVELES
    =============================================*/
     public function ctrVerHorariosyNiveles($valor){
      
        $objHorario = new HorariosModel();
        $resultado = $objHorario->mdlVerHorariosyNiveles($valor);    
	   return $resultado;
  
     }
    
    /*=============================================
	MOSTRAR NIVELES
	=============================================*/
	 public function ctrMostrarNiveles(){
         $objNivel = new HorariosModel();
         $resultado = $objNivel->mdlMostrarNiveles();    
       return $resultado;

	}
    
	/*=============================================
	MOSTRAR HORARIOS
	=============================================*/
	 public function ctrMostrarhorarios($valor){
         $objHorario = new HorariosModel();
         $respuesta = $objHorario->mdlMostrarHorarios($valor);    
		return $respuesta;

	}
    public function ctrMostrarhorariosPorNivel($valor){
         $objHorarioN = new HorariosModel();
         $respuesta = $objHorarioN->mdlMostrarHorariosPorNivel($valor);    
		return $respuesta;

	}
    
    
    /*=============================================
	CREAR HORARIO
	=============================================*/
     public function ctrCrearhorario(){

		if(isset($_POST["denominacion"])){

            $datos = array("idNivel" => $_POST["nuevoNivel"],
                    "denominacion" => $_POST["denominacion"],
				    "horaIngreso" => $_POST["horaIngreso"],
				    "minutosantesi" => $_POST["mantesi"],
				    "minutostoleranciai" => $_POST["mtoleranciai"],
				    "minutostodespuesi" => $_POST["mdespuesi"],
				    "horaSalida" => $_POST["horaSalida"],
				    "minutostoantess" => $_POST["mantess"],
				    "minutostotolerancias" => $_POST["mtolerancias"],
				    "minutostodespuess" => $_POST["mdespuess"],
				    "usuario" => $_SESSION['user'][0]['username']);
            
            $objHorario = new HorariosModel();
            $respuesta = $objHorario->mdlRegistrarhorario($datos);

				if($respuesta){

					echo'<script>

						swal({
							  type: "success",
							  title: "El horario ha sido guardado correctamente",
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
						  title: "¡El horario no puede ser creado!",
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
	EDITAR horario
	=============================================*/
    public function ctrEditarHorario(){
        
        if(isset($_POST["editdenominacion"])){

            $datos = array("idNivel" => $_POST["editnuevoNivel"],
                    "idhorario" => $_POST["idhorario"],
                    "denominacion" => $_POST["editdenominacion"],
				    "horaIngreso" => $_POST["edithoraIngreso"],
				    "minutosantesi" => $_POST["editmantesi"],
				    "minutostoleranciai" => $_POST["editmtoleranciai"],
				    "minutostodespuesi" => $_POST["editmdespuesi"],
				    "horaSalida" => $_POST["edithoraSalida"],
				    "minutostoantess" => $_POST["editmantess"],
				    "minutostotolerancias" => $_POST["editmtolerancias"],
				    "minutostodespuess" => $_POST["editmdespuess"],
				    "usuario" => $_SESSION['user'][0]['username']);
            
            $editHorario = new HorariosModel();
            $respuesta = $editHorario->mdlModificarhorario($datos);

				if($respuesta){

					echo'<script>

						swal({
							  type: "success",
							  title: "El horario ha sido modificado correctamente",
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
						  title: "¡El horario no puede ser modificado!",
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
	ELIMINAR HORARIO
	=============================================*/
    public function ctrEliminarhorario(){

		if(isset($_GET["idhorario"])){

            $valor = $_GET["idhorario"];
            $borrarHorario = new HorariosModel();
            $respuesta = $borrarHorario->mdlEliminarhorario($valor);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El horario ha sido borrado correctamente",
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
						  title: "¡El horario no puede ser eliminado!",
                          text: "Revise si otra tabla esta utilizando la información",
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
    
}