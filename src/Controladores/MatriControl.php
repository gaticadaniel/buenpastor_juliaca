<?php
if($_POST['control'] != ''){
	
	switch ($_POST['control']) {

		case 'BuscarAlumno':
			$vista = "../../src/Vistas/matricula/buscarAlumno.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['dniAlumno'])){
				require_once "../Modelos/UsersModel.php";
				$busqueda = new UsersModel();
				$busquedaPadre = new UsersModel();
				$busquedaMadre = new UsersModel();
				$busquedaApoderado = new UsersModel();
				//$rol = "Alumno";
				$alumnoMatricula = $busqueda->buscar_por_dni($_POST['dniAlumno']);
				if(count($alumnoMatricula)>1){
					$_SESSION['mensaje'] = "ADVERTENCIA";
					$_SESSION['comentario'] = "Existen ".count($alumnoMatricula)." usuarios registrados con el mismo DNI";
				}
				if(count($alumnoMatricula)==0){
					$_SESSION['dniAlumno']=$_POST['dniAlumno'];
					$_SESSION['mensaje'] = "ALUMNO NUEVO";
					$_SESSION['comentario'] = "Puede ingresar sus datos";
				}
				if(count($alumnoMatricula)==1){
					if($alumnoMatricula[0]['role']=="Alumno"){
						$_SESSION['mensaje'] = "ALUMNO ENCONTRADO";
						$_SESSION['comentario'] = "Puede actualizar sus datos";
						$padreMatricula = $busquedaPadre->buscar_por_dni($alumnoMatricula[0]['padre']);
						$madreMatricula = $busquedaMadre->buscar_por_dni($alumnoMatricula[0]['madre']);
						$apoderadoMatricula = $busquedaApoderado->buscar_por_dni($alumnoMatricula[0]['apoderado']);
						$_SESSION['alumnoMatricula'] = $alumnoMatricula;
						$_SESSION['padreMatricula'] = $padreMatricula;
						$_SESSION['madreMatricula'] = $madreMatricula;
						$_SESSION['apoderadoMatricula'] = $apoderadoMatricula;
					} else {
						$_SESSION['mensaje'] = "ADVERTENCIA";
						$_SESSION['comentario'] = "El DNI ".$_POST['dniAlumno']." ya ha sido registrado con el rol ".$alumnoMatricula[0]['role'];
					}
				}
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'BuscarPadre':
			$vista = "../../src/Vistas/matricula/buscarPadre.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['dniPadre'])){
				require_once "../Modelos/UsersModel.php";
				$busqueda = new UsersModel();
				//$rol = "Alumno";
				$padreMatricula = $busqueda->buscar_por_dni($_POST['dniPadre']);
				if(count($padreMatricula)>1){
					$_SESSION['mensaje'] = "ADVERTENCIA";
					$_SESSION['comentario'] = "Existen ".count($padreMatricula)." usuarios registrados con el mismo DNI";
				}
				if(count($padreMatricula)==0){
					$_SESSION['dniPadre']=$_POST['dniPadre'];
					$_SESSION['mensaje'] = "NUEVO PADRE DE FAMILIA";
					$_SESSION['comentario'] = "Puede ingresar sus datos";
				}
				if(count($padreMatricula)==1){
					if($padreMatricula[0]['role']=="Padre"){
						$_SESSION['mensaje'] = "PADRE DE FAMILIA ENCONTRADO";
						$_SESSION['comentario'] = "Puede actualizar sus datos";
						$_SESSION['padreMatricula'] = $padreMatricula;
					} else {
						$_SESSION['mensaje'] = "ADVERTENCIA";
						$_SESSION['comentario'] = "El DNI ".$_POST['dniPadre']." ya ha sido registrado con el rol ".$padreMatricula[0]['role'];
					}
				}
				
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'BuscarMadre':
			$vista = "../../src/Vistas/matricula/buscarMadre.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['dniMadre'])){
				require_once "../Modelos/UsersModel.php";
				$busqueda = new UsersModel();
				$madreMatricula = $busqueda->buscar_por_dni($_POST['dniMadre']);
				if(count($madreMatricula)>1){
					$_SESSION['mensaje'] = "ADVERTENCIA";
					$_SESSION['comentario'] = "Existen ".count($madreMatricula)." usuarios registrados con el mismo DNI";
				}
				if(count($madreMatricula)==0){
					$_SESSION['dniMadre']=$_POST['dniMadre'];
					$_SESSION['mensaje'] = "NUEVA MADRE";
					$_SESSION['comentario'] = "Puede ingresar sus datos";
				}
				if(count($madreMatricula)==1){
					if($madreMatricula[0]['role']=="Madre"){
						$_SESSION['mensaje'] = "DATOS DE LA MADRE ENCONTRADOS";
						$_SESSION['comentario'] = "Puede actualizar sus datos";
						$_SESSION['madreMatricula'] = $madreMatricula;
					} else {
						$_SESSION['mensaje'] = "ADVERTENCIA";
						$_SESSION['comentario'] = "El DNI ".$_POST['dniMadre']." ya ha sido registrado con el rol ".$madreMatricula[0]['role'];
					}
				}
				
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'BuscarApoderado':
			$vista = "../../src/Vistas/matricula/buscarApoderado.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['dniApoderado'])){
				require_once "../Modelos/UsersModel.php";
				$busqueda = new UsersModel();
				$apoderadoMatricula = $busqueda->buscar_por_dni($_POST['dniApoderado']);
				if(count($apoderadoMatricula)>1){
					$_SESSION['mensaje'] = "ADVERTENCIA";
					$_SESSION['comentario'] = "Existen ".count($apoderadoMatricula)." usuarios registrados con el mismo DNI";
				}
				if(count($apoderadoMatricula)==0){
					$_SESSION['dniApoderado']=$_POST['dniApoderado'];
					$_SESSION['mensaje'] = "NUEVO APODERADO";
					$_SESSION['comentario'] = "Puede ingresar sus datos";
				}
				if(count($apoderadoMatricula)==1){
					if($apoderadoMatricula[0]['role']=="Madre" or $apoderadoMatricula[0]['role']=="Padre" or $apoderadoMatricula[0]['role']=="Apoderado"){
						$_SESSION['mensaje'] = "DATOS DEL APODERADO ENCONTRADOS";
						$_SESSION['comentario'] = "Puede actualizar sus datos";
						$_SESSION['apoderadoMatricula'] = $apoderadoMatricula;
					} else {
						$_SESSION['mensaje'] = "ADVERTENCIA";
						$_SESSION['comentario'] = "El DNI ".$_POST['dniApoderado']." ya ha sido registrado con el rol ".$apoderadoMatricula[0]['role'];
					}
				}
				
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'GuardarAlumno':
			$vista = "../../src/Vistas/matricula/buscarPadre.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['estado'])) $_POST['estado']="1";
			else $_POST['estado']="0";
			$alumnoNuevo = $_POST;

			require_once "../Modelos/UsersModel.php";
			$userModel = new UsersModel();
			
			if($alumnoNuevo['control1']=="INSERTAR"){
				if($userModel->insertar($alumnoNuevo)){
					$_SESSION['mensaje'] = "SE GUARDÓ CORRECTAMENTE";
					$_SESSION['comentario'] = "Ahora inserte DNI del Padre de Familia";
				} else {
					$_SESSION['mensaje'] = "ERROR: DATOS DEL ALUMNO NO GUARDADOS";
					$_SESSION['comentario'] = "Por favor intente otra vez";
					$vista = "../../src/Vistas/matricula/buscarAlumno.php";
					$_SESSION['vista'] = $vista;
				}
			} elseif ($alumnoNuevo['control1']=="MODIFICAR") {
				if($userModel->modificar($alumnoNuevo)){
					$_SESSION['mensaje'] = "SE MODIFICÓ CORRECTAMENTE";
					$_SESSION['comentario'] = "Ahora inserte DNI del Padre de Familia";
				} else {
					$_SESSION['mensaje'] = "ERROR, NO SE GUARDARON LAS MODIFICACIONES";
					$_SESSION['comentario'] = "Por favor intente otra vez.";
					$vista = "../../src/Vistas/matricula/buscarAlumno.php";
					$_SESSION['vista'] = $vista;
				}
			}
			$_SESSION['alumnoMatri']=$alumnoNuevo;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'GuardarPadre':
			$vista = "../../src/Vistas/matricula/buscarMadre.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['estado'])) $_POST['estado']="1";
			else $_POST['estado']="0";
			$padreFamilia = $_POST;

			require_once "../Modelos/UsersModel.php";
			$userModel = new UsersModel();
			$userModel1 = new UsersModel();
			
			if($padreFamilia['control1']=="INSERTAR"){
				if($userModel->insertar($padreFamilia)){
					$userModel1->registrarPadre($_SESSION['alumnoMatri']['dni'],"padre",$padreFamilia['dni']);
					$_SESSION['mensaje'] = "DATOS DEL PADRE SE GUARDARON CORRECTAMENTE";
					$_SESSION['comentario'] = "Ahora inserte DNI de la Madre de Familia";
				} else {
					$_SESSION['mensaje'] = "ERROR: DATOS DEL PADRE DE FAMILIA NO GUARDADOS";
					$_SESSION['comentario'] = "Por favor intente otra vez";
					$vista = "../../src/Vistas/matricula/buscarPadre.php";
					$_SESSION['vista'] = $vista;
				}
			} elseif ($padreFamilia['control1']=="MODIFICAR") {
				if($userModel->modificar($padreFamilia)){
					$userModel1->registrarPadre($_SESSION['alumnoMatri']['dni'],"padre",$padreFamilia['dni']);
					$_SESSION['mensaje'] = "DATOS DEL PADRE SE MODIFICARON CORRECTAMENTE";
					$_SESSION['comentario'] = "Ahora inserte DNI de la Madre de Familia";
				} else {
					$_SESSION['mensaje'] = "ERROR, NO SE GUARDARON LAS MODIFICACIONES";
					$_SESSION['comentario'] = "Por favor intente otra vez.";
					$vista = "../../src/Vistas/matricula/buscarPadre.php";
					$_SESSION['vista'] = $vista;
				}
			}
			$_SESSION['padreMatri']=$padreFamilia;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'GuardarMadre':
			$vista = "../../src/Vistas/matricula/buscarApoderado.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['estado'])) $_POST['estado']="1";
			else $_POST['estado']="0";
			$madreFamilia = $_POST;

			require_once "../Modelos/UsersModel.php";
			$userModel = new UsersModel();
			$userModel1 = new UsersModel();
			
			if($madreFamilia['control1']=="INSERTAR"){
				if($userModel->insertar($madreFamilia)){
					$userModel1->registrarPadre($_SESSION['alumnoMatri']['dni'],"madre",$madreFamilia['dni']);
					$_SESSION['mensaje'] = "LOS DATOS DE LA MADRE SE GUARDARON CORRECTAMENTE";
					$_SESSION['comentario'] = "Ahora inserte DNI del Apoderado";
				} else {
					$_SESSION['mensaje'] = "ERROR: LOS DATOS DE LA MADRE NO SE GUARDARON";
					$_SESSION['comentario'] = "Por favor intente otra vez";
					$vista = "../../src/Vistas/matricula/buscarMadre.php";
					$_SESSION['vista'] = $vista;
				}
			} elseif ($madreFamilia['control1']=="MODIFICAR") {
				if($userModel->modificar($madreFamilia)){
					$userModel1->registrarPadre($_SESSION['alumnoMatri']['dni'],"madre",$madreFamilia['dni']);
					$_SESSION['mensaje'] = "LOS DATOS DE LA MADRE SE MODIFICARON CORRECTAMENTE";
					$_SESSION['comentario'] = "Ahora inserte DNI del Apoderado";
				} else {
					$_SESSION['mensaje'] = "ERROR, NO SE GUARDARON LAS MODIFICACIONES DE LA MADRE";
					$_SESSION['comentario'] = "Por favor intente otra vez.";
					$vista = "../../src/Vistas/matricula/buscarMadre.php";
					$_SESSION['vista'] = $vista;
				}
			}
			$_SESSION['madreMatri']=$madreFamilia;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'GuardarApoderado':
			$vista = "../../src/Vistas/matricula/resumen.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['estado'])) $_POST['estado']="1";
			else $_POST['estado']="0";
			$apoderado = $_POST;

			require_once "../Modelos/UsersModel.php";
			$userModel = new UsersModel();
			$userModel1 = new UsersModel();
			
			if($apoderado['control1']=="INSERTAR"){
				if($userModel->insertar($apoderado)){
					$userModel1->registrarPadre($_SESSION['alumnoMatri']['dni'],"apoderado",$apoderado['dni']);
					$_SESSION['mensaje'] = "DATOS DEL APODERADO GUARDADOS CORRECTAMENTE";
					$_SESSION['comentario'] = "Seleccione GRUPO";
				} else {
					$_SESSION['mensaje'] = "ERROR: LOS DATOS DEL APODERADO NO SE GUARDARON";
					$_SESSION['comentario'] = "Por favor intente otra vez";
					$vista = "../../src/Vistas/matricula/buscarApoderado.php";
					$_SESSION['vista'] = $vista;
				}
			} elseif ($apoderado['control1']=="MODIFICAR") {
				if($userModel->modificar($apoderado)){
					$userModel1->registrarPadre($_SESSION['alumnoMatri']['dni'],"apoderado",$apoderado['dni']);
					$_SESSION['mensaje'] = "DATOS DEL APODERADO SE MODIFICARON CORRECTAMENTE";
					$_SESSION['comentario'] = "Seleccione GRUPO";
				} else {
					$_SESSION['mensaje'] = "ERROR: NO SE MODIFICARON LOS DATOS DEL APODERADO";
					$_SESSION['comentario'] = "Por favor intente otra vez.";
					$vista = "../../src/Vistas/matricula/buscarApoderado.php";
					$_SESSION['vista'] = $vista;
				}
			}
			$_SESSION['apoderadoMatri']=$apoderado;
			header("Location: ../../src/Vistas/vista.php");
			break;

		default:
			session_start();
			session_destroy();
			header("Location: ../");
			break;
	}
}
?>