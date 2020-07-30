<?php
if($_POST['control'] != ''){
	
	switch ($_POST['control']) {

		case 'Matriculados':
			$vista = "../../src/Vistas/matricula/matriculados.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/PeriodosModel.php";
			$busquedaPeriodos = new PeriodosModel();
			$periodos = $busquedaPeriodos->get_periodos();
			$_SESSION['p5periodos']= $periodos;
			$_SESSION['p5periodo_id']=null;
			$_SESSION['p5grupos']=null;
			$_SESSION['p5grupo_id']=null;
			$_SESSION['p5alumnos']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ElegirGrupoP5':
			$vista = "../../src/Vistas/matricula/matriculados.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/GruposModel.php";
			$busquedaGrupos = new GruposModel();
			$grupos = $busquedaGrupos->grupos_por_periodo($_POST['periodo_id']);
			$_SESSION['p5grupos']= $grupos;
			$_SESSION['p5periodo_id']= $_POST['periodo_id'];
			$_SESSION['p5grupo_id']=null;
			$_SESSION['p5alumnos']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ListarAlumnosP5':
			$vista = "../../src/Vistas/matricula/matriculados.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['p5grupo_id']= $_POST['grupo_id'];
			require_once "../Modelos/UsersModel.php";
			$busqueda = new UsersModel();
			$alumnos = $busqueda->buscar_por_grupo($_POST['grupo_id'],"Alumno",4);
			$_SESSION['p5alumnos']= $alumnos;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'PagoPendiente':
			$vista = "../../src/Vistas/matricula/p4alumnos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/PeriodosModel.php";
			$busquedaPeriodos = new PeriodosModel();
			$periodos = $busquedaPeriodos->get_periodos();
			$_SESSION['p4periodos']= $periodos;
			$_SESSION['p4periodo_id']=null;
			$_SESSION['p4grupos']=null;
			$_SESSION['p4grupo_id']=null;
			$_SESSION['p4alumnos']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ElegirGrupoP4':
			$vista = "../../src/Vistas/matricula/p4alumnos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/GruposModel.php";
			$busquedaGrupos = new GruposModel();
			$grupos = $busquedaGrupos->grupos_por_periodo($_POST['periodo_id']);
			$_SESSION['p4grupos']= $grupos;
			$_SESSION['p4periodo_id']= $_POST['periodo_id'];
			$_SESSION['p4grupo_id']=null;
			$_SESSION['p4alumnos']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ListarAlumnosP4':
			$vista = "../../src/Vistas/matricula/p4alumnos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['p4grupo_id']= $_POST['grupo_id'];
			require_once "../Modelos/UsersModel.php";
			$busqueda = new UsersModel();
			$alumnos = $busqueda->buscar_por_grupo($_POST['grupo_id'],"Alumno",3);
			$_SESSION['p4alumnos']= $alumnos;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'Paso3':
			$vista = "../../src/Vistas/matricula/p3alumnos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/PeriodosModel.php";
			$busquedaPeriodos = new PeriodosModel();
			$periodos = $busquedaPeriodos->get_periodos();
			$_SESSION['p3periodos']= $periodos;
			$_SESSION['p3periodo_id']=null;
			$_SESSION['p3grupos']=null;
			$_SESSION['p3grupo_id']=null;
			$_SESSION['p3alumnos']=null;
			$_SESSION['p3llave']=null;
			$_SESSION['p3padre']=null;
			$_SESSION['p3madre']=null;
			$_SESSION['p3apoderado']=null;
			$_SESSION['p3firmantes']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ElegirGrupoP3':
			$vista = "../../src/Vistas/matricula/p3alumnos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/GruposModel.php";
			$busquedaGrupos = new GruposModel();
			$grupos = $busquedaGrupos->grupos_por_periodo($_POST['periodo_id']);
			$_SESSION['p3grupos']= $grupos;
			$_SESSION['p3periodo_id']= $_POST['periodo_id'];
			$_SESSION['p3grupo_id']=null;
			$_SESSION['p3alumnos']=null;
			$_SESSION['p3llave']=null;
			$_SESSION['p3padre']=null;
			$_SESSION['p3madre']=null;
			$_SESSION['p3apoderado']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ListarAlumnosP3':
			$vista = "../../src/Vistas/matricula/p3alumnos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['p3grupo_id']= $_POST['grupo_id'];
			require_once "../Modelos/UsersModel.php";
			$busqueda = new UsersModel();
			$alumnos = $busqueda->buscar_por_grupo($_POST['grupo_id'],"Alumno",2);
			$_SESSION['p3alumnos']= $alumnos;
			$_SESSION['p3llave']=null;
			$_SESSION['p3padre']=null;
			$_SESSION['p3madre']=null;
			$_SESSION['p3apoderado']=null;

			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'PagosP3':
			$vista = "../../src/Vistas/matricula/p3pagos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$grupo_id = $_SESSION['p3grupo_id'];
			//RECIBIR LISTA DE CUENTAS INVOLUCRADAS EN EL GRUPO TABLA CUENTAS
			require_once "../Modelos/CuentasModel.php";
			$objetoCuentas = new CuentasModel();
			$cuentas = $objetoCuentas->cuentas_por_grupo($grupo_id);
			$_SESSION['p3cuentas']= $cuentas;
						
			//RECIBIR LISTADO DE PAGOS CLASIFICADOS POR CUENTA TABLA GRUPOS_SUBCUENTAS
			require_once "../Modelos/GruposSubcuentasModel.php";
			$objetoPagos = new GruposSubcuentasModel();
			$pagos = $objetoPagos->subcuentas_por_grupo($grupo_id);
			$_SESSION['p3pagos']= $pagos;

			//RECIBIR LISTADO DE DESCUENTOS CLASIFICADOS POR CUENTA TABLA DESCUENTOS
			require_once "../Modelos/DescuentosModel.php";
			$objetoDescuentos = new DescuentosModel();
			$descuentos = $objetoDescuentos->descuentos_por_grupo($grupo_id);
			for ($i=0; $i < count($descuentos); $i++) { 
				if ($descuentos[$i]['porcentaje']==0) $descuentos[$i]['seleccion']=1;
				else $descuentos[$i]['seleccion']=0;
			}
			$_SESSION['p3descuentos']= $descuentos;
			
			$llave=$_POST['llave'];
			require_once "../Modelos/UsersModel.php";
			$objetoPadre = new UsersModel();
			$objetoMadre = new UsersModel();
			$objetoApoderado = new UsersModel();
			$padre = $objetoPadre->buscar_por_dni_rol($_SESSION['p3alumnos'][$llave]['padre'],"Padre");
			$madre = $objetoMadre->buscar_por_dni_rol($_SESSION['p3alumnos'][$llave]['madre'],"Madre");
			if ($_SESSION['p3alumnos'][$llave]['apoderado']!=$_SESSION['p3alumnos'][$llave]['padre'] and $_SESSION['p3alumnos'][$llave]['apoderado']!=$_SESSION['p3alumnos'][$llave]['madre'])
				$apoderado = $objetoApoderado->buscar_por_dni_rol($_SESSION['p3alumnos'][$llave]['apoderado'],"Apoderado");
			else 
				$apoderado = null;
			$_SESSION['p3llave']= $llave;
			$_SESSION['p3padre']= $padre;
			$_SESSION['p3madre']= $madre;
			$_SESSION['p3apoderado']= $apoderado;
			header("Location: ../../src/Vistas/vista.php"); 
			break;

		case 'CalcularDescuentoP3':
			$vista = "../../src/Vistas/matricula/p3pagos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$cuentas = $_SESSION['p3cuentas'];
			$pagos = $_SESSION['p3pagos'];
			$descuentos = $_SESSION['p3descuentos'];
			
//			echo $_POST['cuenta'];
//			echo $_POST['id'];

			for ($i=0; $i < count($descuentos); $i++) {
				if ($descuentos[$i]['cuenta']==$_POST['cuenta']) {
					if ($descuentos[$i]['id']==$_POST['id']) {
						$descuentos[$i]['seleccion']=1;
						$porcentajeDescuento = $descuentos[$i]['porcentaje'];
					} 
					else $descuentos[$i]['seleccion']=0;
				} 
			}
			$_SESSION['p3descuentos'] = $descuentos;
			
			for ($i=0; $i < count($pagos); $i++) {
				
				if ($pagos[$i]['cuenta']==$_POST['cuenta']) {
					$pagos[$i]['descuento_pago_oportuno']=$pagos[$i]['monto']*($porcentajeDescuento/100);
					print_r ($pagos[$i]);
				} 
			}
			$_SESSION['p3pagos'] = $pagos;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ConfirmarPagosP3':
			$vista = "../../src/Vistas/matricula/p3compromiso.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if ($_POST['seguro']=="OK") $_SESSION['p3pagosConfirmados'] = $vista;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ConfirmarCompromisoP3':
			$vista = "../../src/Vistas/matricula/p3finalizar.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['p3firmantes'] = $_POST['firmantes'];
			header("Location: ../../src/Vistas/vista.php"); 
			break;

		case 'FinalizarP3':
			$vista = "../../src/Vistas/matricula/p3resumen.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			// CONSEGUIMOS EL ID DE MATRICULA DE LA SESIÓN.
			$matricula_id = $_SESSION['p3alumnos'][$_SESSION['p3llave']]['matricula_id'];
			$username = $_SESSION['user'][0]['username'];	
			
			//CONSEGUIMOS DATOS DEL GRUPO PARA EL COMENTARIO = NIVEL, GRADO Y SECCION
			$comentario = "";
			$grupos = $_SESSION['p3grupos'];
			$grupo_id = $_SESSION['p3grupo_id'];
			for ($i=0; $i < count($grupos); $i++) { 
				if($grupos[$i]['id']==$grupo_id)
					$comentario=$grupos[$i]['nivel']."-".$grupos[$i]['grado']."-".$grupos[$i]['seccion'];
			}		

			//Guardamos descuentos de matrícula en la tabla descuentos_matricula
			$descuentos = $_SESSION['p3descuentos'];
			require_once "../Modelos/DescuentosMatriculasModel.php";
			$objetoDescuentosMatriculas = new DescuentosMatriculasModel();
			for ($i=0; $i < count($descuentos); $i++) { 
				if( $descuentos[$i]['seleccion']==1 )
					$objetoDescuentosMatriculas->insertar_descuento_matricula($matricula_id, $descuentos[$i]['id'], $username);
//					echo $matricula_id." ".$descuentos[$i]['id']." ".$username;		
			}
			
			//Guardamos las deudas adquiridas por el estudiante en la tabla deudas
			$deudas = $_SESSION['p3pagos'];
			require_once "../Modelos/DeudasModel.php";
			$objetoDeudas = new DeudasModel();
			for ($i=0; $i < count($deudas); $i++) {
				$objetoDeudas->insertar($_SESSION['p3alumnos'][$_SESSION['p3llave']]['id'], $deudas[$i], $username, $matricula_id, $comentario);		
			}
			
			require_once "../Modelos/MatriculasModel.php";
			$objMatricula = new MatriculasModel();
			if ($objMatricula->actualizar_paso_matricula(3, $matricula_id))
				$_SESSION['p3resultado']="Grabación Paso 3 ...ok";
			else {
				$_SESSION['mensaje'] = "ERROR";
				$_SESSION['comentario'] = "No se guardaron los cambios de la Matrícula Paso 3.";
			}
			header("Location: ../../src/Vistas/vista.php"); 
			break;

		case 'Paso2':
			$vista = "../../src/Vistas/matricula/p2alumnos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/PeriodosModel.php";
			$busquedaPeriodos = new PeriodosModel();
			$periodos = $busquedaPeriodos->get_periodos();
			$_SESSION['p2periodos']= $periodos;
			$_SESSION['p2periodo_id']=null;
			$_SESSION['p2grupos']=null;
			$_SESSION['p2grupo_id']=null;
			$_SESSION['p2alumnos']=null;
			$_SESSION['p2llave']=null;
			$_SESSION['p2padre']=null;
			$_SESSION['p2madre']=null;
			$_SESSION['p2apoderado']=null;
			$_SESSION['p2firmantes']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ElegirGrupo':
			$vista = "../../src/Vistas/matricula/p2alumnos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/GruposModel.php";
			$busquedaGrupos = new GruposModel();
			$grupos = $busquedaGrupos->grupos_por_periodo($_POST['periodo_id']);
			$_SESSION['p2grupos']= $grupos;
			$_SESSION['p2periodo_id']= $_POST['periodo_id'];
			$_SESSION['p2grupo_id']=null;
			$_SESSION['p2alumnos']=null;
			$_SESSION['p2llave']=null;
			$_SESSION['p2padre']=null;
			$_SESSION['p2madre']=null;
			$_SESSION['p2apoderado']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ListarAlumnosP2':
			$vista = "../../src/Vistas/matricula/p2alumnos.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['p2grupo_id']= $_POST['grupo_id'];
			require_once "../Modelos/UsersModel.php";
			$busqueda = new UsersModel();
			$alumnos = $busqueda->buscar_por_grupo($_POST['grupo_id'],"Alumno",1);
			$_SESSION['p2alumnos']= $alumnos;
			$_SESSION['p2llave']=null;
			$_SESSION['p2padre']=null;
			$_SESSION['p2madre']=null;
			$_SESSION['p2apoderado']=null;

			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'CompromisoP2':
			$vista = "../../src/Vistas/matricula/p2compromiso.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$llave=$_POST['llave'];
//			echo $_SESSION['p2alumnos'][$llave]['padre'];
			require_once "../Modelos/UsersModel.php";
			$busqueda1 = new UsersModel();
			$busqueda2 = new UsersModel();
			$busqueda3 = new UsersModel();
			$padre = $busqueda1->buscar_por_dni_rol($_SESSION['p2alumnos'][$llave]['padre'],"Padre");
			$madre = $busqueda2->buscar_por_dni_rol($_SESSION['p2alumnos'][$llave]['madre'],"Madre");
			if ($_SESSION['p2alumnos'][$llave]['apoderado']!=$_SESSION['p2alumnos'][$llave]['padre'] and $_SESSION['p2alumnos'][$llave]['apoderado']!=$_SESSION['p2alumnos'][$llave]['madre'])
				$apoderado = $busqueda3->buscar_por_dni_rol($_SESSION['p2alumnos'][$llave]['apoderado'],"Apoderado");
			else 
				$apoderado = null;
			$_SESSION['p2llave']= $llave;
			$_SESSION['p2padre']= $padre;
			$_SESSION['p2madre']= $madre;
			$_SESSION['p2apoderado']= $apoderado;
			header("Location: ../../src/Vistas/vista.php"); 
			break;

		case 'ConfirmarCompromisoP2':
			$vista = "../../src/Vistas/matricula/p2finalizar.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['p2firmantes'] = $_POST['firmantes'];
			header("Location: ../../src/Vistas/vista.php"); 
			break;

		case 'FinalizarP2':
			$vista = "../../src/Vistas/matricula/p2resumen.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$matricula_id=$_SESSION['p2alumnos'][$_SESSION['p2llave']]['matricula_id'];
			require_once "../Modelos/MatriculasModel.php";
			$objMatricula = new MatriculasModel();
			if ($objMatricula->actualizar_paso_matricula(2, $matricula_id))
				$_SESSION['p2resultado']="Grabación Paso 2 ...ok";
			else {
				$_SESSION['mensaje'] = "ERROR";
				$_SESSION['comentario'] = "No se guardaron los cambios de la Matrícula Paso 2.";
			}
			header("Location: ../../src/Vistas/vista.php"); 
			break;

		case 'Paso1':
			$vista = "../../src/Vistas/matricula/alumno.php";
			session_start();
			$_SESSION['vista'] = $vista;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'CambiarVista':
			$vista = "../../src/Vistas/matricula/".$_POST['vista'];
			session_start();
			$_SESSION['vista'] = $vista;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'BuscarDatos':
			$vista = "../../src/Vistas/matricula/alumno.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['dniAlumno'])){
				require_once "../Modelos/UsersModel.php";
				$busquedaAlumno = new UsersModel();
				$busquedaPadre = new UsersModel();
				$busquedaMadre = new UsersModel();
				$busquedaApoderado = new UsersModel();
				$alumnoMatricula = $busquedaAlumno->buscar_por_dni($_POST['dniAlumno']);
				if(count($alumnoMatricula)>1){
					$_SESSION['mensaje'] = "ADVERTENCIA";
					$_SESSION['comentario'] = "Existen ".count($alumnoMatricula)." usuarios registrados con el mismo DNI";
				} else {
					require_once "../Modelos/PeriodosModel.php";
					$busquedaPeriodos = new PeriodosModel();
					$_SESSION['gruposMatricula']= null;
					$_SESSION['periodoMatri']= null;
					$_SESSION['grupoMatri']= null;
					if(count($alumnoMatricula)==0){
						$_SESSION['dniAlumno']=$_POST['dniAlumno'];
						$periodos = $busquedaPeriodos->get_periodos();
						$_SESSION['periodosMatricula']= $periodos;
//						$_SESSION['mensaje'] = "ALUMNO NUEVO";
//						$_SESSION['comentario'] = "Puede ingresar sus datos";
						$_SESSION['alumnoMatricula'] = null;
						$_SESSION['padreMatricula'] = null;
						$_SESSION['madreMatricula'] = null;
						$_SESSION['apoderadoMatricula'] = null;
						
						$_SESSION['alumnoMatri'] = null;
						$_SESSION['padreMatri'] = null;
						$_SESSION['madreMatri'] = null;
						$_SESSION['apoderadoMatri'] = null;
					}
					if(count($alumnoMatricula)==1){
						if($alumnoMatricula[0]['role']=="Alumno"){
							$periodos = $busquedaPeriodos->periodos_por_id($alumnoMatricula[0]['id']);
							$_SESSION['periodosMatricula']= $periodos;
//							$_SESSION['mensaje'] = "ALUMNO ENCONTRADO";
//							$_SESSION['comentario'] = "Puede actualizar sus datos";
							$padreMatricula = $busquedaPadre->buscar_por_dni($alumnoMatricula[0]['padre']);
							$madreMatricula = $busquedaMadre->buscar_por_dni($alumnoMatricula[0]['madre']);
							$apoderadoMatricula = $busquedaApoderado->buscar_por_dni($alumnoMatricula[0]['apoderado']);
//							print_r($padreMatricula);
							$_SESSION['alumnoMatricula'] = $alumnoMatricula;
							if (count($padreMatricula)==1) $_SESSION['padreMatricula'] = $padreMatricula;
							if (count($madreMatricula)==1) $_SESSION['madreMatricula'] = $madreMatricula;
							if (count($apoderadoMatricula)==1) $_SESSION['apoderadoMatricula'] = $apoderadoMatricula;
							$_SESSION['alumnoMatri'] = null;
							$_SESSION['padreMatri'] = null;
							$_SESSION['madreMatri'] = null;
							$_SESSION['apoderadoMatri'] = null;
							$_SESSION['dniAlumno'] = null;
							$_SESSION['dniPadre'] = null;
							$_SESSION['dniMadre'] = null;
							$_SESSION['dniApoderado'] = null;
						} else {
							$_SESSION['mensaje'] = "ADVERTENCIA";
							$_SESSION['comentario'] = "El DNI ".$_POST['dniAlumno']." ya ha sido registrado con el rol ".$alumnoMatricula[0]['role'];
						}
						$_SESSION['dniAlumno']=null;
						$_SESSION['alumnoMatri']=null;
					}
					//AQUIIIII
				}
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ConfirmarAlumno':
			$vista = "../../src/Vistas/matricula/padre.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['estado'])) $_POST['estado']="1";
			else $_POST['estado']="0";
			$alumno = $_POST;
			$_SESSION['alumnoMatricula']=null;
			$_SESSION['dniAlumno']=null;
			$_SESSION['alumnoMatri']=$alumno;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ConfirmarPadre':
			$vista = "../../src/Vistas/matricula/madre.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['estado'])) $_POST['estado']="1";
			else $_POST['estado']="0";
			$padre = $_POST;
			print_r($_POST['sexo']);
			$_SESSION['alumnoMatri']['padre']=$padre['dni'];
			$_SESSION['padreMatricula']=null;
			$_SESSION['dniPadre']=null;
			$_SESSION['padreMatri']=$padre;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ConfirmarMadre':
			$vista = "../../src/Vistas/matricula/apoderado.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['estado'])) $_POST['estado']="1";
			else $_POST['estado']="0";
			$madre = $_POST;
			$_SESSION['alumnoMatri']['madre']=$madre['dni'];
			$_SESSION['madreMatricula']=null;
			$_SESSION['dniMadre']=null;
			$_SESSION['madreMatri']=$madre;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ConfirmarApoderado':
			$vista = "../../src/Vistas/matricula/periodo.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['estado'])) $_POST['estado']="1";
			else $_POST['estado']="0";
			$apoderado = $_POST;
			$_SESSION['alumnoMatri']['apoderado']=$apoderado['dni'];
			$_SESSION['apoderadoMatricula']=null;
			$_SESSION['dniApoderado']=null;
			$_SESSION['apoderadoMatri']=$apoderado;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'BuscarPadre':
			$vista = "../../src/Vistas/matricula/padre.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['apoderadoMatri']=null;
			$_SESSION['padreMatri']=null;
			if(isset($_POST['dniPadre'])){
				// BUSCAMOS EN LA SESSION PARA EVITAR QUE SE INGRESE UN NUEVO PADRE CON EL DNI DEL ALUMNO O MADRE
				$existeEnSession="NO EXISTE"; 
				if(isset($_SESSION['alumnoMatri'])){
					if($_SESSION['alumnoMatri']['dni']==$_POST['dniPadre']){
						$_SESSION['mensaje'] = "ERROR";
						$_SESSION['comentario'] = "El número de DNI ".$_SESSION['dniPadre']." corresponde al Alumno.";
						$_SESSION['dniPadre']=null;
						$existeEnSession="EXISTE";
					}
				} 
				if (isset($_SESSION['madreMatri'])) {
					if($_SESSION['madreMatri']['dni']==$_POST['dniPadre']){
						$_SESSION['mensaje'] = "ERROR";
						$_SESSION['comentario'] = "El número de DNI ".$_SESSION['dniPadre']." corresponde a la Madre.";
						$_SESSION['dniPadre']=null;
						$existeEnSession="EXISTE";
					}
				} 
				// SI NO EXISTE EN LA SESSIÓN BUSCAMOS EN LA BASE DE DATOS
				if ($existeEnSession=="NO EXISTE"){
					require_once "../Modelos/UsersModel.php";
					$busqueda = new UsersModel();
					$padreMatricula = $busqueda->buscar_por_dni($_POST['dniPadre']);
					if(count($padreMatricula)>1){
						$_SESSION['mensaje'] = "ADVERTENCIA";
						$_SESSION['comentario'] = "Existen ".count($padreMatricula)." usuarios registrados con el mismo DNI";
					}
					if(count($padreMatricula)==0){
						$_SESSION['dniPadre']=$_POST['dniPadre'];
	//					$_SESSION['mensaje'] = "NUEVO PADRE DE FAMILIA";
	//					$_SESSION['comentario'] = "Puede ingresar sus datos";
						$_SESSION['padreMatricula'] = null;
						$_SESSION['padreMatri'] = null;
					}
					if(count($padreMatricula)==1){
						if($padreMatricula[0]['role']=="Padre"){
	//						$_SESSION['mensaje'] = "PADRE DE FAMILIA ENCONTRADO";
	//						$_SESSION['comentario'] = "Puede actualizar sus datos";
							$_SESSION['padreMatricula'] = $padreMatricula;
						} else {
							$_SESSION['mensaje'] = "ADVERTENCIA";
							$_SESSION['comentario'] = "El DNI ".$_POST['dniPadre']." ya ha sido registrado con el rol ".$padreMatricula[0]['role'];
						}
						$_SESSION['dniPadre']=null;
						$_SESSION['padreMatri']=null;
					}
				}
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'BuscarMadre':
			$vista = "../../src/Vistas/matricula/madre.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$_SESSION['apoderadoMatri']=null;
			$_SESSION['madreMatri']=null;
			if(isset($_POST['dniMadre'])){
				// BUSCAMOS EN LA SESSION PARA EVITAR QUE SE INGRESE UNA NUEVA MADRE CON EL DNI DEL ALUMNO O PADRE
				$existeEnSession="NO EXISTE";
				if(isset($_SESSION['alumnoMatri'])){
					if($_SESSION['alumnoMatri']['dni']==$_POST['dniMadre']){
						$_SESSION['mensaje'] = "ERROR";
						$_SESSION['comentario'] = "El número de DNI ".$_SESSION['dniMadre']." corresponde al Alumno.";
						$_SESSION['dniMadre']=null;
						$existeEnSession="EXISTE";
					}
				} 
				if (isset($_SESSION['padreMatri'])) {
					if($_SESSION['padreMatri']['dni']==$_POST['dniMadre']){
						$_SESSION['mensaje'] = "ERROR";
						$_SESSION['comentario'] = "El número de DNI ".$_SESSION['dniMadre']." corresponde al Padre.";
						$_SESSION['dniMadre']=null;
						$existeEnSession="EXISTE";
					}
				} 

				if ($existeEnSession=="NO EXISTE"){
					require_once "../Modelos/UsersModel.php";
					$busqueda = new UsersModel();
					$madreMatricula = $busqueda->buscar_por_dni($_POST['dniMadre']);
					if(count($madreMatricula)>1){
						$_SESSION['mensaje'] = "ADVERTENCIA";
						$_SESSION['comentario'] = "Existen ".count($madreMatricula)." usuarios registrados con el mismo DNI";
					}
					if(count($madreMatricula)==0){
						$_SESSION['dniMadre']=$_POST['dniMadre'];
	//					$_SESSION['mensaje'] = "NUEVO PADRE DE FAMILIA";
	//					$_SESSION['comentario'] = "Puede ingresar sus datos";
						$_SESSION['madreMatricula'] = null;
						$_SESSION['madreMatri'] = null;
					}
					if(count($madreMatricula)==1){
						if($madreMatricula[0]['role']=="Madre"){
	//						$_SESSION['mensaje'] = "PADRE DE FAMILIA ENCONTRADO";
	//						$_SESSION['comentario'] = "Puede actualizar sus datos";
							$_SESSION['madreMatricula'] = $madreMatricula;
						} else {
							$_SESSION['mensaje'] = "ADVERTENCIA";
							$_SESSION['comentario'] = "El DNI ".$_POST['dniMadre']." ya ha sido registrado con el rol ".$madreMatricula[0]['role'];
						}
						$_SESSION['dniMadre']=null;
						$_SESSION['madreMatri']=null;
					}
				}
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'BuscarApoderado':
			$vista = "../../src/Vistas/matricula/apoderado.php";
			session_start();
			$_SESSION['vista'] = $vista;
			if(isset($_POST['dniApoderado'])){
				
				//BUSCAR SI EXISTE EN LAS VARIABLES DE SESSIÓN alumnoMatri, padreMatri y madreMatri
				$existeEnSession="NO EXISTE"; 
				// PARA EVITAR QUE SE INGRESE UN NUEVO APODERADO CON EL DNI DEL ALUMNO
				if(isset($_SESSION['alumnoMatri'])){
					if($_SESSION['alumnoMatri']['dni']==$_POST['dniApoderado']){
						$_SESSION['mensaje'] = "ERROR";
						$_SESSION['comentario'] = "El número de DNI ".$_SESSION['dniApoderado']." corresponde al Alumno.";
						$_SESSION['dniApoderado']=null;
						$existeEnSession="EXISTE";
					}
				} 
				if (isset($_SESSION['madreMatri'])) {
					if($_SESSION['madreMatri']['dni']==$_POST['dniApoderado']){
						$_SESSION['apoderadoMatri'] = $_SESSION['madreMatri'];
						$_SESSION['apoderadoMatri']['accion']="NINGUNA";
						$_SESSION['alumnoMatri']['apoderado']=$_POST['dniApoderado'];
						$_SESSION['dniApoderado']=null;
						$existeEnSession="EXISTE";
					}
				} 
				if (isset($_SESSION['padreMatri']) ) {
					if($_SESSION['padreMatri']['dni']==$_POST['dniApoderado']){
						$_SESSION['apoderadoMatri'] = $_SESSION['padreMatri'];
						$_SESSION['apoderadoMatri']['accion']="NINGUNA";
						$_SESSION['alumnoMatri']['apoderado']=$_POST['dniApoderado'];
						$_SESSION['dniApoderado']=null;
						$existeEnSession="EXISTE";
					}
				} 
				// SI NO EXISTE EN SESION ENTONCES BUSCAMOS EN LA BASE DE DATOS
				if($existeEnSession=="NO EXISTE"){
					require_once "../Modelos/UsersModel.php";
					$busqueda = new UsersModel();
					$apoderadoMatricula = $busqueda->buscar_por_dni($_POST['dniApoderado']);
					if(count($apoderadoMatricula)>1){
						$_SESSION['mensaje'] = "ADVERTENCIA";
						$_SESSION['comentario'] = "Existen ".count($apoderadoMatricula)." usuarios registrados con el mismo DNI";
					}
					if(count($apoderadoMatricula)==0){
						$_SESSION['dniApoderado']=$_POST['dniApoderado'];
//						$_SESSION['mensaje'] = "NUEVO PADRE DE FAMILIA";
//						$_SESSION['comentario'] = "Puede ingresar sus datos";
						$_SESSION['apoderadoMatricula'] = null;
						$_SESSION['apoderadoMatri'] = null;
					}
					if(count($apoderadoMatricula)==1){
						if($apoderadoMatricula[0]['role']=="Madre" or $apoderadoMatricula[0]['role']=="Padre" or $apoderadoMatricula[0]['role']=="Apoderado" ){
	//						$_SESSION['mensaje'] = "PADRE DE FAMILIA ENCONTRADO";
	//						$_SESSION['comentario'] = "Puede actualizar sus datos";
							$_SESSION['apoderadoMatricula'] = $apoderadoMatricula;
						} else {
							$_SESSION['mensaje'] = "ADVERTENCIA";
							$_SESSION['comentario'] = "El DNI ".$_POST['dniApoderado']." ya ha sido registrado con el rol ".$apoderadoMatricula[0]['role'];
						}
						$_SESSION['dniApoderado']=null;
						$_SESSION['apoderadoMatri']=null;
					}
				}
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ConfirmarPeriodo':
			$vista = "../../src/Vistas/matricula/grupo.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			//CONVERTIMOS PERIODO EN ARRAY Y SERA periodoMatri
			$temporal=0;
			foreach ($_SESSION['periodosMatricula'] as $key => $value) {
				foreach ($value as $llave => $valor) {
					if( $llave=='id' and $valor==$_POST['periodo'] ) $temporal=$key;
				}
			}
			foreach ($_SESSION['periodosMatricula'] as $key => $value) {
				if ($key==$temporal) $periodoMatri=$value;
			}
			//FIN RESULTADO periodoMatri			
			
			require_once "../Modelos/GruposModel.php";
			$busqueda = new GruposModel();
			$grupos = $busqueda->grupos_por_periodo($periodoMatri['id']);
			$_SESSION['periodoMatri']=$periodoMatri;
			$_SESSION['gruposMatricula']=$grupos;
			$_SESSION['grupoMatri']=null;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'ConfirmarGrupo':
			$vista = "../../src/Vistas/matricula/finalizar.php";
			session_start();
			$_SESSION['vista'] = $vista;

			//CONVERTIMOS GRUPO EN ARRAY Y SERA grupoMatri
			$temporal=0;
			foreach ($_SESSION['gruposMatricula'] as $key => $value) {
				foreach ($value as $llave => $valor) {
					if( $llave=='id' and $valor==$_POST['grupo_id'] ) $temporal=$key;
				}
			}
			foreach ($_SESSION['gruposMatricula'] as $key => $value) {
				if ($key==$temporal) $grupoMatri=$value;
			}
			//FIN RESULTADO periodoMatri			

			$_SESSION['grupoMatri']=$grupoMatri;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'Finalizar':
			$vista = "../../src/Vistas/matricula/resumen.php";
			session_start();
			$_SESSION['vista'] = $vista;
			require_once "../Modelos/UsersModel.php";
			$userModel = new UsersModel();
			$objPadre = new UsersModel();
			$objMadre = new UsersModel();
			$objApoderado = new UsersModel();
			require_once "../Modelos/MatriculasModel.php";
			$matriculasModel = new MatriculasModel();
			
			if($_SESSION['alumnoMatri']['accion']=="INSERTAR") {
				if($userModel->insertar($_SESSION['alumnoMatri'])) {
					$alumnoNuevo = $userModel->buscar_por_dni_rol($_SESSION['alumnoMatri']['dni'],"Alumno");
					$user_id=$alumnoNuevo[0]['id'];
					$_SESSION['alumnoMatri']="Inserción ...ok";
				} 
			} elseif($_SESSION['alumnoMatri']['accion']=="MODIFICAR") {
				if($userModel->modificar($_SESSION['alumnoMatri'])) {
					$user_id=$_SESSION['alumnoMatri']['id'];
					$_SESSION['alumnoMatri']="Modificación ...ok";
				}
			}
			
			if($_SESSION['padreMatri']['accion']=="INSERTAR") {
				if($objPadre->insertar($_SESSION['padreMatri'])) $_SESSION['padreMatri']=" Inserción ...ok";
			
			} elseif($_SESSION['padreMatri']['accion']=="MODIFICAR") {
				if($objPadre->modificar($_SESSION['padreMatri'])) $_SESSION['padreMatri']="Modificación ...ok";
			}
			
			if($_SESSION['madreMatri']['accion']=="INSERTAR") {
				if($objMadre->insertar($_SESSION['madreMatri'])) $_SESSION['madreMatri']=" Inserción ...ok";
			
			} elseif($_SESSION['madreMatri']['accion']=="MODIFICAR") {
				if($objMadre->modificar($_SESSION['madreMatri'])) $_SESSION['madreMatri']="Modificación ...ok";
			}
				
			if($_SESSION['apoderadoMatri']['accion']=="INSERTAR") {
				if($objApoderado->insertar($_SESSION['apoderadoMatri'])) $_SESSION['apoderadoMatri']=" Inserción ...ok";
				
			} elseif($_SESSION['apoderadoMatri']['accion']=="MODIFICAR") {
				if($objApoderado->modificar($_SESSION['apoderadoMatri'])) $_SESSION['apoderadoMatri']="Modificación ...ok";
				
			} elseif($_SESSION['apoderadoMatri']['accion']=="NINGUNA") {
				$_SESSION['apoderadoMatri']="Registro ...ok";
			}
			
//			echo "USER_ID".$user_id."-".$_SESSION['grupoMatri']['id']."-"."1"."-".$_SESSION['user'][0]['username'];
			if( $matriculasModel->insertar($user_id, $_SESSION['grupoMatri']['id'], 1, $_SESSION['user'][0]['username']) )
				$_SESSION['grupoMatri']=" Inserción ...ok";
			
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