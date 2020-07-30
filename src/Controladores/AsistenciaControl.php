<?php
if($_POST['control'] != ''){
	
	switch ($_POST['control']) {

		case 'Ingreso':
			$vista = "../../src/Vistas/asistencia/registrar_ingreso.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			$_SESSION['asistencia']=null;
			$_SESSION['acumulado']=null;
			
			//ESPERAR A QUE LA VISTA NOS ENVIE: dni, fecha, hora, tipo de registro=INGRESO; DEL USUARIO A REGISTRAR SU ASISTENCIA
			if(isset($_POST['dni'])){
				$dni = $_POST['dni'];
				$fecha = $_POST['fecha'];
				$hora = $_POST['hora'];
				$tipo = $_POST['tipo'];
				$agenda = $_POST['agenda'];
				
				//VERIFICAR SI EXISTE PROGRAMADO UN CONTROL DE ASISTENCIA Y SI LA HORA DE MARCADO CUMPLE CON LOS REQUISITOS DEL CONTROL DE ASISTENCIA
				require_once "../Modelos/AsistenciasModel.php";
				$objAsistencias = new AsistenciasModel();
				$asistencia = $objAsistencias->verificar_si_se_puede_registrar_asistencia($dni, $fecha, $hora);
				
				
				if(count($asistencia)==1){// SI ES 1 ENTONCES ES POSIBLE REGISTRAR ASISTENCIA
					
					//VERIFICAMOS SI YA SE HA REGISTRADO UN MARCADO DE ASISTENCIA	
					$regAsistencias = new AsistenciasModel();
					$registro_asistencia = $regAsistencias->verificar_si_existe_asistencia_realizada($asistencia[0]['user_id'], $asistencia[0]['grupos_horarios_id'], $fecha);
					if (count($registro_asistencia)==0) { // SI ES 0 ENTONCES NO SE REGISTRO ASISTENCIA Y ES POSIBLE REGISTRAR
						$asistencia[0]['con_agenda']=$agenda;
						$asistencia[0]['fecha']=$fecha;
						$asistencia[0]['hora_ingreso_real']=$hora;
						$asistencia[0]['justificado']=0;
						$asistencia[0]['diferencia_ingreso']+=$asistencia[0]['minutos_de_tolerancia'];

						$usuario=$_SESSION['user'][0]['username'];
						$recAsistencia = new AsistenciasModel();

						if($recAsistencia->cambiar_asistencia($asistencia, $usuario)){ //Guardamos los datos de asistencia.
							$_SESSION['asistencia']=$asistencia;
							//BUSCAR OTROS DATOS PARA SU VISUALIZACIÓN EN PANTALLA
							
							//reporte de faltas acumuladas: justificadas e injustificadas
							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_total_de_asistencias_a_un_grupo($asistencia[0]['grupo_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['ideal_asistencias']=$valor;
								}
							}
							
							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_total_de_asistencias_de_un_usuario_a_un_grupo($asistencia[0]['grupo_id'], $asistencia[0]['user_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['asistencias_acumuladas']=$valor;
								}
							}

							$acumulado['faltas_acumuladas']=$acumulado['ideal_asistencias']-$acumulado['asistencias_acumuladas'];

							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_de_justificaciones($asistencia[0]['grupo_id'], $asistencia[0]['user_id'], "FALTA") as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['faltas_justificadas']=$valor;
								}
							}

							$acumulado['faltas_injustificadas']=$acumulado['faltas_acumuladas']-$acumulado['faltas_justificadas'];
							
							//reporte de tardanzas acumuladas: justificadas, injustificadas y minutos perdidos acumulados por tardanza
							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_de_tardanzas($asistencia[0]['grupo_id'], $asistencia[0]['user_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['tardanzas_acumuladas']=$valor;
								}
							}

							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_de_justificaciones($asistencia[0]['grupo_id'], $asistencia[0]['user_id'], "TARDANZA") as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['tardanzas_justificadas']=$valor;
								}
							}

							$acumulado['tardanzas_injustificadas']=$acumulado['tardanzas_acumuladas']-$acumulado['tardanzas_justificadas'];

							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->minutos_perdidos_por_tardanzas($asistencia[0]['grupo_id'], $asistencia[0]['user_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['minutos_perdidos']=$valor;
								}
							}
							
							//reporte de uso de agenda: sin agenda y con agenda
							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_ingresos_sin_agenda($asistencia[0]['grupo_id'], $asistencia[0]['user_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['sin_agenda']=$valor;
								}
							}

							$acumulado['con_agenda']=$acumulado['asistencias_acumuladas']-$acumulado['sin_agenda'];
							
							//reporte de deudas
							require_once "../Modelos/DeudasModel.php";
							$objDeuda = new DeudasModel();
							$acumulado['deudas_pendientes']=$objDeuda->deudas_pendientes_por_usuario($asistencia[0]['user_id']);
							$_SESSION['acumulado']=$acumulado;
						}
					} else {
						$_SESSION['mensaje']="YA SE REGISTRO SU ASISTENCIA";
						$_SESSION['comentario']="FECHA: ".$registro_asistencia[0]['fecha']." HORA: ".$registro_asistencia[0]['hora_de_ingreso_real'];
					}
					
				} else {
					$_SESSION['mensaje']="IMPOSIBLE REGISTRAR ASISTENCIA";
					$_SESSION['comentario']="No tiene actividades programadas";
				}
				
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'Salida':
			$vista = "../../src/Vistas/asistencia/registrar_salida.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			$_SESSION['registro_de_ingreso']=null;
			$_SESSION['acumulado']=null;
			
			//ESPERAR A QUE LA VISTA NOS ENVIE: dni, fecha, hora, tipo de registro=SALIDA; DEL USUARIO A REGISTRAR SU ASISTENCIA
			if(isset($_POST['dni'])){
				$dni = $_POST['dni'];
				$fecha = $_POST['fecha'];
				$hora = $_POST['hora'];
				$tipo = $_POST['tipo'];
				
				//VERIFICAR SI EXISTE PROGRAMADO UN CONTROL DE ASISTENCIA Y SI LA HORA DE MARCADO CUMPLE CON LOS REQUISITOS DEL CONTROL DE ASISTENCIA
				require_once "../Modelos/AsistenciasModel.php";
				$objAsistencias = new AsistenciasModel();
				$registro_de_ingreso = $objAsistencias->buscar_registro_de_ingreso($dni, $fecha, $hora);
				
				
				if(count($registro_de_ingreso)==1){// SI ES 1 ENTONCES ES POSIBLE REGISTRAR LA MARCACION DE SALIDA
					
					//VERIFICAMOS SI YA SE HA REGISTRADO UN MARCADO DE SALIDA
					$existe_salida = TRUE;
					if ($registro_de_ingreso[0]['hora_de_salida_real']=="" and $registro_de_ingreso[0]['diferencia_salida']=="")
						$existe_salida = FALSE;
					
					if (!$existe_salida) { // SI ES FALSE ENTONCES NO SE REGISTRO LA SALIDA
						$registro_de_ingreso[0]['fecha']=$fecha;
						$registro_de_ingreso[0]['hora_salida_real']=$hora;
						$registro_de_ingreso[0]['diferencia_salida']=$registro_de_ingreso[0]['diferencia_de_salida']+$registro_de_ingreso[0]['minutos_de_tolerancia_2'];

						$usuario=$_SESSION['user'][0]['username'];
						$recAsistencia = new AsistenciasModel();

						if($recAsistencia->actualizar_salida($registro_de_ingreso, $usuario)){ //Guardamos los datos de asistencia.
							$_SESSION['registro_de_ingreso']=$registro_de_ingreso;

							//BUSCAR OTROS DATOS PARA SU VISUALIZACIÓN EN PANTALLA
							
							//reporte de faltas acumuladas: justificadas e injustificadas
							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_total_de_asistencias_a_un_grupo($registro_de_ingreso[0]['grupo_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['ideal_asistencias']=$valor;
								}
							}
							
							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_total_de_asistencias_de_un_usuario_a_un_grupo($registro_de_ingreso[0]['grupo_id'], $registro_de_ingreso[0]['user_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['asistencias_acumuladas']=$valor;
								}
							}

							$acumulado['faltas_acumuladas']=$acumulado['ideal_asistencias']-$acumulado['asistencias_acumuladas'];

							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_de_justificaciones($registro_de_ingreso[0]['grupo_id'], $registro_de_ingreso[0]['user_id'], "FALTA") as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['faltas_justificadas']=$valor;
								}
							}

							$acumulado['faltas_injustificadas']=$acumulado['faltas_acumuladas']-$acumulado['faltas_justificadas'];
							
							//reporte de tardanzas acumuladas: justificadas, injustificadas y minutos perdidos acumulados por tardanza
							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_de_tardanzas($registro_de_ingreso[0]['grupo_id'], $registro_de_ingreso[0]['user_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['tardanzas_acumuladas']=$valor;
								}
							}

							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_de_justificaciones($registro_de_ingreso[0]['grupo_id'], $registro_de_ingreso[0]['user_id'], "TARDANZA") as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['tardanzas_justificadas']=$valor;
								}
							}

							$acumulado['tardanzas_injustificadas']=$acumulado['tardanzas_acumuladas']-$acumulado['tardanzas_justificadas'];

							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->minutos_perdidos_por_tardanzas($registro_de_ingreso[0]['grupo_id'], $registro_de_ingreso[0]['user_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['minutos_perdidos']=$valor;
								}
							}
							
							//reporte de uso de agenda: sin agenda y con agenda
							$objAsistencias = new AsistenciasModel();
							foreach ($objAsistencias->numero_ingresos_sin_agenda($registro_de_ingreso[0]['grupo_id'], $registro_de_ingreso[0]['user_id']) as $key => $value) {
								foreach ($value as $llave => $valor) {
									$acumulado['sin_agenda']=$valor;
								}
							}

							$acumulado['con_agenda']=$acumulado['asistencias_acumuladas']-$acumulado['sin_agenda'];
							
							//reporte de deudas
							require_once "../Modelos/DeudasModel.php";
							$objDeuda = new DeudasModel();
							$acumulado['deudas_pendientes']=$objDeuda->deudas_pendientes_por_usuario($registro_de_ingreso[0]['user_id']);
							$_SESSION['acumulado']=$acumulado;
						}
					} else {
						$_SESSION['mensaje']="YA SE REGISTRO SU SALIDA";
						$_SESSION['comentario']="FECHA: ".$fecha." HORA: ".$registro_de_ingreso[0]['hora_de_salida_real'];
					}
					
				} else {
					$_SESSION['mensaje']="IMPOSIBLE REGISTRAR SALIDA";
					$_SESSION['comentario']="La hora de salida (".$hora.") no corresponde a su horario de trabajo o No tiene INGRESO registrado";
				}
				
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'Reporte_grupal':
			$vista = "../../src/Vistas/asistencia/reporte_grupal.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			if (isset($_POST['subcontrol'])) $subcontrol=$_POST['subcontrol']; else $subcontrol='RG_ElegirPeriodos';
			
			switch ($subcontrol) {
				case 'RG_ElegirPeriodos':
					require_once "../Modelos/PeriodosModel.php";
					$busquedaPeriodos = new PeriodosModel();
					$periodos = $busquedaPeriodos->get_periodos();
					$_SESSION['rg_periodos']= $periodos;
					$_SESSION['rg_periodo_id']=null;
					$_SESSION['rg_grupos']=null;
					$_SESSION['rg_grupo_id']=null;
					$_SESSION['rg_fechas']=null;
					$_SESSION['rg_alumnos']=null;
					header("Location: ../../src/Vistas/vista.php");
					break;
				
				case 'RG_ElegirGrupo':
					require_once "../Modelos/GruposModel.php";
					$busquedaGrupos = new GruposModel();
					$grupos = $busquedaGrupos->grupos_por_periodo($_POST['periodo_id']);
					$_SESSION['rg_grupos']= $grupos;
					$_SESSION['rg_periodo_id']= $_POST['periodo_id'];
					$_SESSION['rg_grupo_id']=null;
					$_SESSION['rg_fechas']=null;
					$_SESSION['rg_alumnos']=null;
					header("Location: ../../src/Vistas/vista.php");
					break;

				case 'RG_ElegirFecha':
					require_once "../Modelos/GruposHorariosModel.php";
					$busquedaFechas = new GruposHorariosModel();
					$fechas = $busquedaFechas->fechas_por_grupo($_POST['grupo_id']);
					$_SESSION['rg_grupo_id']=$_POST['grupo_id'];
					$_SESSION['rg_fechas']=$fechas;
					$_SESSION['rg_alumnos']=null;
					header("Location: ../../src/Vistas/vista.php");
					break;
					
				case 'RG_Lista':
					require_once "../Modelos/UsersModel.php";
					$busqueda = new UsersModel();
					$alumnos = $busqueda->buscar_por_grupo($_SESSION['rg_grupo_id'],"Alumno",4);
					$_SESSION['rg_alumnos']= $alumnos;
					$_SESSION['rg_fecha_id']=$_POST['fecha_id'];
					header("Location: ../../src/Vistas/vista.php");
					break;					

				default:
					session_start();
					session_destroy();
					header("Location: ../");
					break;
			}
			break;
            
        case 'Horario':
			$vista = "../../src/Vistas/asistencia/horario.php";
			session_start();
			$_SESSION['vista'] = $vista;
			header("Location: ../../src/Vistas/vista.php");
			break;
            
        case 'GrupoHorario':
			$vista = "../../src/Vistas/asistencia/grupoHorario.php";
			session_start();
			$_SESSION['vista'] = $vista;
            require_once "../Modelos/PeriodosModel.php";
			$busquedaPeriodos = new PeriodosModel();
			$periodos = $busquedaPeriodos->get_periodos();
			$_SESSION['p4periodos']= $periodos;
			$_SESSION['p4periodo_id']=null;
			$_SESSION['p4grupos']=null;
			$_SESSION['p4grupo_id']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;
            
        case 'ElegirGrupoHorarios':
			$vista = "../../src/Vistas/asistencia/grupoHorario.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/GruposModel.php";
			$busquedaGrupos = new GruposModel();
			$grupos = $busquedaGrupos->grupos_por_periodo($_POST['periodo_id']);
			$_SESSION['p4grupos']= $grupos;
			$_SESSION['p4periodo_id']= $_POST['periodo_id'];
			$_SESSION['p4grupo_id']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;
            
        case 'ElegirGrupoH':
			$vista = "../../src/Vistas/asistencia/grupoHorario.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['p4grupo_id']= $_POST['grupo_id'];
			$_SESSION['idGrupo']= $_POST['grupo_id'];
			require_once "../Modelos/GruposHorariosModel.php";
			header("Location: ../../src/Vistas/vista.php");
			break;
            
        case 'TelefonoPadres':
			$vista = "../../src/Vistas/asistencia/telefonoPadres.php";
			session_start();
			$_SESSION['vista'] = $vista;
			header("Location: ../../src/Vistas/vista.php");
			break;
        
        case 'AsistenciaFechas':
			$vista = "../../src/Vistas/asistencia/fechas.php";
			session_start();
			$_SESSION['vista'] = $vista;
			header("Location: ../../src/Vistas/vista.php");
			break;
            
        case 'AsistenciaHoras':
			$vista = "../../src/Vistas/asistencia/horas.php";
			session_start();
			$_SESSION['vista'] = $vista;
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