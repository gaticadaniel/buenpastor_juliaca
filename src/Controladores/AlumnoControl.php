<?php
if($_POST['control'] != ''){
	
	switch ($_POST['control']) {

		case 'Buscar':
			$vista = "../../src/Vistas/Alumno/buscar.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/UsersModel.php";
			$busqueda = new UsersModel();
			if($_POST['condicion']=='por_dni'){
				$resultado = $busqueda->buscar_por_dni($_POST['dni']);
			}
			if($_POST['condicion']=='por_nombres'){
				$resultado = $busqueda->buscar_por_nombres($_POST['apellido_paterno'],$_POST['apellido_materno'],$_POST['nombres']);
			}
			$_SESSION['resultado'] = $resultado;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'Ver':
			echo $_POST['llave'];
			$vista = "../../src/Vistas/Alumno/ver.php";
			session_start();
			$_SESSION['vista'] = $vista;

			break;

		case 'Editar':
			$llave = $_POST['llave'];
			$vista = "../../src/Vistas/Alumno/editar.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['llave'] = $llave;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'Nuevo':
			$vista = "../../src/Vistas/Alumno/nuevo.php";
			session_start();
			$_SESSION['vista'] = $vista;
			header("Location: ../../src/Vistas/vista.php");

			break;

		case 'Prueba':
			session_start();
//			$_SESSION['vista'] = $vista;
//			header("Location: ../../src/Vistas/vista.php");
//			echo "hola";
//			echo $_POST['apellido_paterno'];
			foreach($_POST as $key => $value){ 
//				$asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
//				eval($asignacion); 
				echo $key." - ".$value."</br>";
			}
//			print_r($asignacion);
			break;

		default:
			session_start();
			session_destroy();
			header("Location: ../");
			break;
	}
}
?>