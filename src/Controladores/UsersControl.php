<?php
if($_POST['control'] != ''){
	
	switch ($_POST['control']) {

		case 'validar':
			
			// DATOS QUE SE ESPERA
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			//MENSAJES A PRODUCIR
			$mensaje=null;
			$alerta=null;
			$error=null;
			
			require_once "../Modelos/UsersModel.php";
			$usuario = new UsersModel();
			$usuarioValidado = $usuario->validar($username,$password);

			// SI ENCUENTRA UN SOLO USUARIO Y ÉSTE ES VÁLIDO
			if(count($usuarioValidado)==1){
				session_start();
				$vista = "../../src/Vistas/Users/index.php";
				$_SESSION['user'] = $usuarioValidado;
				$_SESSION['vista'] = $vista;
				
				require_once "../Modelos/RolsModel.php";
				require_once "../Modelos/ModulosModel.php";
				require_once "../Modelos/OpcionsModel.php";
				
				//SELECCIONAMOS TODOS LOS ROLES DEL USUARIO
				$roles = new RolsModel();
				$rolesUsuario = $roles->get_rols($usuarioValidado['0']['id']);
				
				//SI SE ENCUENTRAN ROLES
				if(count($rolesUsuario)>0){
					$rolPredeterminado=0;
					$contadorModulosPredeterminados=0;
					
					// BUSCAMOS LOS MÓDULOS PARA CADA ROL
					for($i=0;$i<count($rolesUsuario);$i++){
						// SI EL ROL ES EL PREDETERMINADO
						if ($rolesUsuario[$i]['predeterminado']==1) {
							$contadorModulosPredeterminados++;
							$rolPredeterminado=$i;
						}
						// BUSCAMOS LOS MODULOS QUE CORRESPONDEN AL ROL Y LO GUARDAMOS EN $modulosRol
						$modulos = new ModulosModel();
						$modulosRol = $modulos->get_modulos($rolesUsuario[$i]['id'],$usuarioValidado['0']['id']);
						
						// SI SE ENCUENTRAN MODULOS PARA EL ROL
						if(count($modulosRol>0)){
							
							for($j=0;$j<count($modulosRol);$j++){
								// BUSCAMOS LAS OPCIONES PARA CADA MODULO
								$opcions = new OpcionsModel();
								$opcionsModulo = $opcions->get_opcions($modulosRol[$j]['id'],$usuarioValidado['0']['id']);
								// SI SE ENCUENTRAN OPCIONES PARA EL MODULO
								if(count($opcionsModulo)>0){
									$modulosRol[$j]['opcions']=$opcionsModulo;
								} else {
									$modulosRol[$j]['opcions']=array();
								}
								
							}
							$rolesUsuario[$i]['modulos']=$modulosRol;
						} else { // SI NO SE ENCUENTRA NINGÚN MÓDULO ASIGNADO AL ROL
							$rolesUsuario[$i]['modulos'] = array ();
							$alerta='NO TIENES MÓDULOS ASIGNADOS AL ROL';
						} 
					} 
					
					if ($contadorModulosPredeterminados>1) {
						$alerta = "Tiene mas de un módulo predeterminado";
					}
					$_SESSION['rolActivo'] = $rolPredeterminado;
				} else { // SINO ENCUENTRA NINGUN ROL
					$rolesUsuario=array();
					$mensaje = "No tiene roles asignados, póngase en contacto con el administrador del sistema: administrador@buenpastor.edu.pe";
				}

				$_SESSION['menu'] = $rolesUsuario;
				
				//INICIALIZANDO FECHA DE SISTEMA
				date_default_timezone_set('America/Lima');
				setlocale(LC_TIME, "Spanish");		
				$hoy = strftime("%Y-%m-%d"); // FECHA PARA EL CALCULO DE TODAS LAS OPERACIONES
				$_SESSION['fechaSistema'] = $hoy;
				
				//BUSCAMOS OPCIONES PARA LA EMISIÓN DE COMPROBANTES DE PAGO
				require_once "../Modelos/ComprobantesModel.php";
				
				// buscamos comprobantes internos
				$comprobantes1 = new ComprobantesModel();
				$comprobantesInternos = $comprobantes1->comprobantes_activos_por_usuario($usuarioValidado['0']['id'],'interno');
				$_SESSION['comprobantesInternos'] = $comprobantesInternos;

				// buscamos comprobantes externos
				$comprobantes2 = new ComprobantesModel();
				$comprobantesExternos = $comprobantes2->comprobantes_activos_por_usuario($usuarioValidado['0']['id'],'externo');
				$_SESSION['comprobantesExternos'] = $comprobantesExternos;
								
			} else { // SI EL USUARIO NO ES VÁLIDO
				$error= "Usuario o Contraseña no válidos";
				session_destroy();
				header("Location: ../../index.php?error=".$error);
				break;
			}

			$_SESSION['mensaje'] = $mensaje;
			$_SESSION['alerta'] = $alerta;
			$_SESSION['error'] = $error;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'salir':
			session_start();
			if(isset($_SESSION['standAbiertos'])){
				if(count($_SESSION['standAbiertos'])==1){
					require_once "../Modelos/StandsModel.php";
					$objStand = new StandsModel();
					$objStand->cerrar_stand($_SESSION['standAbiertos'][0]['id'],$_SESSION['user'][0]['username']);
				}
			}
			session_destroy();
			header("Location: ../../index.php");
			break;

		case 'cambiarRol':
			$nuevoRol = $_POST['nuevoRol'];
			session_start();
			$_SESSION['rolActivo'] = $nuevoRol;
			$vista = "../../src/Vistas/Users/index.php";
			$_SESSION['vista'] = $vista;
			header("Location: ../../src/Vistas/vista.php");
			
			break;

		default:
			session_start();
			$_SESSION = array();
			session_destroy();
			header("Location: ../");
			break;
	}
}
?>