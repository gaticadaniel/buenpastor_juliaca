<?php
if($_POST['control'] != ''){
	
	switch ($_POST['control']) {

		case 'Cuentas_por_grupo':
			$vista = "../../src/Vistas/caja/cuentas_por_grupo.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			if(isset($_POST['accion']))
				$accion = $_POST['accion'];
			else
				$accion = "Periodos";
			
			//BUSCAMOS PERIODOS ACTIVOS
			if($accion=="Periodos"){
				require_once "../Modelos/PeriodosModel.php";
				$objPeriodos = new PeriodosModel();
				$periodos = $objPeriodos->get_periodos();
				$_SESSION['periodos']= $periodos;
				$_SESSION['periodo_id']=null;
				$_SESSION['grupos']=null;
				$_SESSION['grupo_id']=null;
				$_SESSION['alumnos']=null;
			}
			
			//BUSCAMOS GRUPOS QUE CORRESPONDAN AL PERIODO SELECCIONADO
			if($accion=="Grupos"){
				$periodo_id = $_POST['periodo_id'];
				require_once "../Modelos/GruposModel.php";
				$objGrupos = new GruposModel();
				$grupos = $objGrupos->grupos_por_periodo($periodo_id);
				$_SESSION['periodo_id']= $periodo_id;
				$_SESSION['grupos']= $grupos;
				$_SESSION['grupo_id']=null;
				$_SESSION['alumnos']=null;
			}

			//BUSCAMOS ESTUDIANTES QUE CORRESPONDAN AL PERIODO Y GRUPO SELECCIONADO
			if($accion=="Listado"){
				$grupo_id = $_POST['grupo_id'];

				//BUSCAMOS LAS SUBCUENTAS DESIGNADAS PARA EL GRUPO
				require_once "../Modelos/GruposSubcuentasModel.php";
				$objGrupoSubcuenta = new GruposSubcuentasModel();
				$subCuentas = $objGrupoSubcuenta->subcuentas_por_grupo($grupo_id);

				//BUSCAMOS ESTUDIANTES DEL GRUPO
				require_once "../Modelos/UsersModel.php";
				$objUser = new UsersModel();
				$alumnos = $objUser->buscar_por_grupo($grupo_id,"Alumno",4);
				
				//BUSCAMOS LAS DEUDAS DE CADA ESTUDIANTE
				require_once "../Modelos/DeudasModel.php";
				for ($i=0; $i < count($alumnos); $i++) { 
					$objDeuda = new DeudasModel();
					$alumnos[$i]['deudas']=$objDeuda->deudas_por_grupo_y_usuario($alumnos[$i]['id'], $grupo_id);
				}

				//SUBIMOS TODOS LOS DATOS A SESSION
				$_SESSION['subCuentas']=$subCuentas;
				$_SESSION['grupo_id']= $grupo_id;
				$_SESSION['alumnos']=$alumnos;


			}
			
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'Cierre':
			$vista = "../../src/Vistas/caja/cierre_de_caja.php";
			session_start();
			$_SESSION['vista'] = $vista;

			//FUNCIONA EN BASE A LA VARIABLE subcontrol
			$subcontrol = "NoDefinido";
			if(isset($_POST['subcontrol'])){
				$subcontrol=$_POST['subcontrol'];
			}

			//BUSCAMOS INGRESOS PENDIENTES DE CIERRE
			if ($subcontrol=="NoDefinido"){
				//BUSCAMOS LOS INGRESOS PENDIENTES DE CIERRE
				require_once "../Modelos/VouchersModel.php";
				$objVoucher = new VouchersModel();
				$series_de_vouchers_pendientes=$objVoucher->series_de_vouchers_pendientes_de_cierre();
				$_SESSION['series_de_vouchers_pendientes'] = $series_de_vouchers_pendientes;

				//BUSCAMOS LOS RECIBOS INTERNOS FISICOS PENDIENTES DE CIERRE
				require_once "../Modelos/RecibosInternosModel.php";
				$objRif = new RecibosInternosModel();
				$series_de_rifs_pendientes=$objRif->series_de_rifs_pendientes_de_cierre();
				$_SESSION['series_de_rifs_pendientes'] = $series_de_rifs_pendientes;

				//BUSCAMOS LOS RECIBOS INTERNOS ELECTRONICOS PENDIENTES DE CIERRE
				require_once "../Modelos/IngresosModel.php";
				$objRie = new IngresosModel();
				$series_de_ries_pendientes=$objRie->series_de_ries_pendientes_de_cierre();
				$_SESSION['series_de_ries_pendientes'] = $series_de_ries_pendientes;

				//eliminamos datos temporales
				$_SESSION['indice_series_de_ries'] = null;
				$_SESSION['fechas_pendientes_ries'] = null;
				$_SESSION['indice_fecha_rie'] = null;
				$_SESSION['ries_pendientes'] = null;

			} elseif ($subcontrol=="serie") {
				//BUSCAMOS FECHAS PENDIENTES DE CIERRE PARA LOS RIES
				$indice_series_de_ries = $_POST['indice_series_de_ries'];
				$series_de_ries_pendientes = $_SESSION['series_de_ries_pendientes'];
				require_once "../Modelos/IngresosModel.php";
				$objIngresos = new IngresosModel();
				$fechas_pendientes_ries=$objIngresos->fechas_pendientes_cierre($series_de_ries_pendientes[$indice_series_de_ries]['serie']);
				$_SESSION['indice_series_de_ries'] = $indice_series_de_ries;
				$_SESSION['fechas_pendientes_ries'] = $fechas_pendientes_ries;
				
				//eliminamos datos temporales
				$_SESSION['indice_fecha_rie'] = null;
				$_SESSION['ries_pendientes'] = null;

			} elseif ($subcontrol=="fecha") {
				//BUSCAMOS FECHAS PENDIENTES DE CIERRE PARA EL STAND ELEGIDO
				$indice_fecha_rie = $_POST['indice_fecha_rie'];
				$fechas_pendientes_ries = $_SESSION['fechas_pendientes_ries'];
				$indice_series_de_ries = $_SESSION['indice_series_de_ries'];
				$series_de_ries_pendientes = $_SESSION['series_de_ries_pendientes'];
				
				require_once "../Modelos/IngresosModel.php";
				$objIngresos = new IngresosModel();
				$ries_pendientes=$objIngresos->ingresos_pendientes_de_cierre_por_serie_y_fecha($series_de_ries_pendientes[$indice_series_de_ries]['serie'], $fechas_pendientes_ries[$indice_fecha_rie]['fecha']);

				$_SESSION['indice_fecha_rie'] = $indice_fecha_rie;
				$_SESSION['ries_pendientes'] = $ries_pendientes;

			} elseif ($subcontrol=="Cerrar") {
				//EFECTUAMOS CIERRE DE CAJA
				$cierre['username_cajero'] = $_POST['username_cajero'];
				$cierre['stand_id'] = $_POST['stand_id'];
				$cierre['fecha'] = $_POST['fecha'];
				$cierre['hora'] = $_POST['hora'];
				$cierre['monto'] = $_POST['monto'];
				$cierre['comentario'] = $_POST['comentario'];
				$cierre['username'] = $username = $_SESSION['user'][0]['username'];
				
				require_once "../Modelos/CierresModel.php";
				$objCierre = new CierresModel();
				if($objCierre->guardar_cierre($cierre)){
					$id = $objCierre->ultimo_id();
					if(count($id)==1){
						require_once "../Modelos/BoletasModel.php";
						$objBoletas = new BoletasModel();
						for ($i=0; $i < count($_SESSION['boletas_pendientes']); $i++) { 
							$objBoletas->cerrar_boleta($_SESSION['boletas_pendientes'][$i]['id'],$id[0]['id']);
						}
						//eliminamos datos temporales
						$_SESSION['stand_id']=null;
						$_SESSION['fechas_pendientes']=null;
						$_SESSION['fecha_id']=null;
						$_SESSION['usuarios_pendientes']=null;
						$_SESSION['usuario_id']=null;
						$_SESSION['boletas_pendientes']=null;
					}
				}

			} elseif ($subcontrol=="AnularBoleta") {
				//ANULAMOS BOLETA
				$idBoleta = $_POST['idBoleta'];
				$idDeuda = $_POST['idDeuda'];
				$username = $_SESSION['user'][0]['username'];
				require_once "../Modelos/BoletasModel.php";
				$objBoletas = new BoletasModel();
				if($objBoletas->anular_boleta_por_id($idBoleta)){
					//SI SE ANULÓ LA BOLETA ENTONCES PROCEDEMOS A CAMBIAR EL ESTADO DE LA DEUDA: CANCELADO A 0
					require_once "../Modelos/DeudasModel.php";
					$objDeudas = new DeudasModel();
					$objDeudas->anular_cancelado($idDeuda, $username);
				}
				//ACTUALIZAMOS LISTA DE BOLETAS
				$boletas_pendientes=$objBoletas->boletas_pendientes_stand_fecha_usuario($_SESSION['stand_id'], $_SESSION['fecha_id'], $_SESSION['usuario_id']);
				$_SESSION['boletas_pendientes'] = $boletas_pendientes;
				
			}

			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'AnularBoleta':
			$vista = "../../src/Vistas/caja/resumen_diario.php";
			session_start();
			$_SESSION['vista'] = $vista;

			$idBoleta = $_POST['idBoleta'];
			$idDeuda = $_POST['idDeuda'];
			$username = $_SESSION['user'][0]['username'];
			
			//ANULAMOS LA BOLETA
			require_once "../Modelos/BoletasModel.php";
			$objBoletas = new BoletasModel();
			if($objBoletas->anular_boleta_por_id($idBoleta)){
				//SI SE ANULÓ LA BOLETA ENTONCES PROCEDEMOS A CAMBIAR EL ESTADO DE LA DEUDA: CANCELADO A 0
				require_once "../Modelos/DeudasModel.php";
				$objDeudas = new DeudasModel();
				$objDeudas->anular_cancelado($idDeuda, $username);
			}
			
			//VOLVEMOS A CARGAR LOS DATOS DE LOS STANDS Y BOLETAS
			$fecha=$_SESSION['fechaSistema'];
			require_once "../Modelos/StandsModel.php";
			$objStands = new StandsModel();
			$stands = $objStands->stands_por_fecha_usuario($fecha, $username);
			$_SESSION['stands_por_fecha']=$stands;
			require_once "../Modelos/BoletasModel.php";
			$objBoletas = new BoletasModel();
			$boletas = $objBoletas->boletas_por_fecha_y_usuario($fecha, $username);
			$_SESSION['boletas_por_fecha']=$boletas;

			header("Location: ../../src/Vistas/vista.php");
			break;
			case 'Resumen':

				$vista = "../../src/Vistas/caja/resumen.php";
				session_start(); 
				$hoy = getdate();
				$_SESSION['vista'] = $vista;
	
				$_POST['f_dia'];
				$_POST['f_mes'];
	
				 
				$s_mes="";
				$s_anio=$hoy['year'];
				
				if(isset($_POST['f_mes'])){
					
				 
                    
					if($_POST['f_mes'] =="X")
					{
						$s_mes="";
					}else{ 
						$s_mes=str_pad($_POST['f_mes'], 2, "0", STR_PAD_LEFT) ;
					}
	
					$fecha=$s_anio.'-'.$s_mes ;
	 
				}else{ 
					 
					$fecha=$hoy['year'] .'-'.$hoy['mon'] ;
	
					 
				} 
				 
				$_SESSION['f_mes']= $s_mes;
	 
				require_once "../Modelos/BoletasModel.php" ;
				$objComprobantes = new BoletasModel();
				$comprobantes = $objComprobantes->comprobantes_por_fecha($fecha);
				$_SESSION['comprobantes']=$comprobantes;
				$data= "s_mes=".$s_mes;
				$data = urlencode($data);
	
				header("Location: ../../src/Vistas/vista.php");
	
		break;
		case 'Diario':

			$vista = "../../src/Vistas/caja/resumen_diario.php";
			session_start(); 
			$hoy = getdate();
			$_SESSION['vista'] = $vista;

			$_POST['f_dia'];
			$_POST['f_mes'];

			$s_dia="";
			$s_mes="";
			$s_anio=$hoy['year'];
			
			if(isset($_POST['f_dia'])){
				
				if($_POST['f_dia'] =="X")
				{
					$s_dia="";
				}else{
					$s_dia=str_pad($_POST['f_dia'], 2, "0", STR_PAD_LEFT) ;
				}
				if($_POST['f_mes'] =="X")
				{
					$s_mes="";
				}else{ 
					$s_mes=str_pad($_POST['f_mes'], 2, "0", STR_PAD_LEFT) ;
				}

				$fecha=$s_anio.'-'.$s_mes.'-'.$s_dia;
 
			}else{ 
				 
				$fecha=$hoy['year'] .'-'.$hoy['mon'].'-'.$hoy['mday'];

				 
            } 
            
            $_SESSION['f_dia']= $s_dia;
            $_SESSION['f_mes']= $s_mes;

			//$fecha=$hoy['mday'].'/'.$hoy['mon'].'/'.$hoy['year'];
			
			 
		  
			/*require_once "../Modelos/StandsModel.php";
			$objStands = new StandsModel();
			$stands = $objStands->stands_por_fecha_usuario($fecha, $username);
			$_SESSION['stands_por_fecha']=$stands;

			require_once "../Modelos/BoletasModel.php";
			$objBoletas = new BoletasModel();
			$boletas = $objBoletas->boletas_por_fecha_y_usuario($fecha, $username);
			$_SESSION['boletas_por_fecha']=$boletas;*/

			require_once "../Modelos/BoletasModel.php" ;
			$objComprobantes = new BoletasModel();
			$comprobantes = $objComprobantes->comprobantes_por_fecha($fecha);
			$_SESSION['comprobantes']=$comprobantes;
            $data="s_dia=".$s_dia."&s_mes=".$s_mes;
            $data = urlencode($data);

			header("Location: ../../src/Vistas/vista.php");

		break;

		case 'FijarFecha':
			$vista = "../../src/Vistas/caja/buscar.php";
			session_start();
			$_SESSION['vista'] = $vista;

			$fecha_boleta = $_POST['fecha_boleta'];
			$_SESSION['fechaSistema'] = $fecha_boleta;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'Emitir':
			$vista = "../../src/Vistas/caja/buscar.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			if (isset($_SESSION['comprobantesInternos'])){
				if (count($_SESSION['comprobantesInternos'])==0){
					$_SESSION['alerta'] = "ERROR";
					$_SESSION['mensaje'] = "No tiene comprobantes autorizados";
				}
			} else {
				$_SESSION['error'] = "ERROR";
				$_SESSION['mensaje'] = "Ud. no está autorizado para emitir comprobantes";
			}

			if(!isset($_POST['condicion'])){
				require_once "../Modelos/PeriodosModel.php";
				$objPeriodos = new PeriodosModel();
				$periodos = $objPeriodos->get_periodos();
				$_SESSION['condicion']="por_dni";
				$_SESSION['periodos']= $periodos;
				$_SESSION['periodo_id']=null;
				$_SESSION['grupos']=null;
				$_SESSION['grupo_id']=null;
				$_SESSION['alumnosCaja']=null;

			}elseif($_POST['condicion']=='por_dni'){
				require_once "../Modelos/UsersModel.php";
				$objUsers= new UsersModel();
				$alumnosCaja= $objUsers->buscar_por_dni_rol($_POST['dni'],"Alumno");
				$_SESSION['condicion']="por_dni";
				$_SESSION['alumnosCaja']= $alumnosCaja;
				$_SESSION['periodo_id']=null;
				$_SESSION['grupos']=null;
				$_SESSION['grupo_id']=null;

			}elseif($_POST['condicion']=='por_nombres'){
				require_once "../Modelos/UsersModel.php";
				$objUsers= new UsersModel();
				$alumnosCaja = $objUsers->buscar_por_nombres_y_role($_POST['apellido_paterno'],$_POST['apellido_materno'],$_POST['nombres'],"Alumno");
				$_SESSION['condicion']="por_nombre";
				$_SESSION['alumnosCaja']= $alumnosCaja;
				$_SESSION['periodo_id']=null;
				$_SESSION['grupos']=null;
				$_SESSION['grupo_id']=null;

			}elseif($_POST['condicion']=='por_periodo'){
				require_once "../Modelos/GruposModel.php";
				$objGrupos = new GruposModel();
				$grupos = $objGrupos->grupos_por_periodo($_POST['periodo_id']);
				$_SESSION['condicion']="por_periodo";
				$_SESSION['grupos']= $grupos;
				$_SESSION['periodo_id']= $_POST['periodo_id'];
				$_SESSION['grupo_id']=null;
				$_SESSION['alumnosCaja']=null;

			}elseif($_POST['condicion']=='por_grupo'){
				$_SESSION['grupo_id']= $_POST['grupo_id'];
				require_once "../Modelos/UsersModel.php";
				$objUsers = new UsersModel();
				$alumnosCaja = $objUsers->buscar_por_grupo_rol($_POST['grupo_id'],"Alumno");
				$_SESSION['condicion']="por_periodo";
				$_SESSION['alumnosCaja']= $alumnosCaja;
				
			}
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'CambiarVista':
			$vista = "../../src/Vistas/caja/".$_POST['vista'];
			session_start();
			$_SESSION['vista'] = $vista;
			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'EstadoDeCuenta':
			$vista = "../../src/Vistas/caja/estado_de_cuenta.php";
			session_start();
			$_SESSION['vista'] = $vista;

			//BUSCAMOS CUENTAS QUE NO TENGAN QUE VER CON EL CONTRATO DE TODO EL AÑO A ESTAS LAS LLAMAMOS CUENTAS LIBRES
			require_once "../Modelos/CuentasModel.php";
			$objCuentas = new CuentasModel();
			$cuentasLibres = $objCuentas->cuentas_libres();
			$_SESSION['cuentasLibres'] = $cuentasLibres;
			
			//ARMAMOS EL ESTADO DE CUENTA DEL ALUMNO: EMPEZAMOS BUSCAMOS LAS DEUDAS DEL ALUMNO
			$llave = $_POST['llave'];
			require_once "../Modelos/DeudasModel.php";
			$objDeudas = new DeudasModel();
			$deudas = $objDeudas->deuda_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);

			//POR CADA DEUDA BUSCAMOS LOS INGRESOS REGISTRADOS
			require_once "../Modelos/IngresosModel.php";
			require_once "../Modelos/RegistrosDeVentasModel.php";
			require_once "../Modelos/ComprobantesModel.php";
			for ($i=0; $i < count($deudas); $i++) { 
				$objIngreso3 = new IngresosModel();
				$ingresos = $objIngreso3->ingresos_por_deuda_y_usuario($deudas[$i]['id'], $_SESSION['alumnosCaja'][$llave]['id']);
				$deudas[$i]['ingresos']=$ingresos;
				//POR CADA INGRESO BUSCAMOS SI TIENE REGISTROS DE VENTA
				for ($j=0; $j < count($deudas[$i]['ingresos']); $j++ ){
					$deudas[$i]['ingresos'][$j]['tipo1']="externo";
					if($deudas[$i]['ingresos'][$j]['registrodeventa_id']=="" ) {
						$deudas[$i]['ingresos'][$j]['registrodeventa'] = array();
						$objComprobante = new ComprobantesModel();
						if($objComprobante->si_el_comprobante_es_interno($deudas[$i]['ingresos'][$j]['serie']) ){
							$deudas[$i]['ingresos'][$j]['tipo1']="interno";
						}
					} 
					else {
						$objRegistrosDeVentas = new RegistrosDeVentasModel();
						$registroDeVenta = $objRegistrosDeVentas->registro_de_venta_por_deuda($deudas[$i]['ingresos'][$j]['registrodeventa_id']);
						$deudas[$i]['ingresos'][$j]['registrodeventa'] = $registroDeVenta;	
					}
				}
			}
			$_SESSION['llave'] = $llave;
			$_SESSION['deudas'] = $deudas;
			
			//GENERAMOS EL LISTADO DE LOS COMPROBANTES ANTIGUOS DE VALOR OFICIAL EMITIDOS AL ESTUDIANTE DE LA TABLA INGRESOS
			$objIngresos = new IngresosModel();
			$ingresos_antiguos = $objIngresos->ingresos_externos_antiguos_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);
			if (count($ingresos_antiguos)>0 ) {
				for ($i=0; $i <count($ingresos_antiguos) ; $i++) { 
					$ingresos_antiguos[$i]['cliente'][0]['dni'] = $_SESSION['alumnosCaja'][$llave]['dni'];
					$ingresos_antiguos[$i]['cliente'][0]['nombres'] = $_SESSION['alumnosCaja'][$llave]['nombres'];
					$ingresos_antiguos[$i]['cliente'][0]['apellido_paterno'] = $_SESSION['alumnosCaja'][$llave]['apellido_paterno'];
					$ingresos_antiguos[$i]['cliente'][0]['apellido_materno'] = $_SESSION['alumnosCaja'][$llave]['apellido_materno'];
				}
			}
			$_SESSION['ingresos_antiguos'] = $ingresos_antiguos;
			
			//GENERAMOS EL LISTADO DE LOS COMPROBANTES DE VALOR OFICIAL EMITIDOS AL ESTUDIANTE DE LA TABLA REGISTRO DE VENTAS				require_once "../Modelos/RegistrosDeVentasModel.php";
			require_once "../Modelos/PersonasJuridicasModel.php";
			require_once "../Modelos/UsersModel.php";
			
			$objRv = new RegistrosDeVentasModel();
			$registrosDeVentas = $objRv->rv_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);
			if (count($registrosDeVentas )>0 ) {
				for ($i=0; $i <count($registrosDeVentas) ; $i++) { 
					if ($registrosDeVentas[$i]['personajuridica_id']!="") {
						$objPj = new PersonasJuridicasModel();
						$cliente = $objPj->buscar_por_id($registrosDeVentas[$i]['personajuridica_id']);
						$registrosDeVentas[$i]['cliente']=$cliente;
					}
					if ($registrosDeVentas[$i]['user_id']!="") {
						$objUsers = new UsersModel();
						$cliente = $objUsers->buscar_por_id($registrosDeVentas[$i]['user_id']);
						$registrosDeVentas[$i]['cliente']=$cliente;
					}
				}
			}
			$_SESSION['registrosDeVentas'] = $registrosDeVentas;
			

			// LIMPIAMOS LA SESION
			$_SESSION['indice_cuenta_libre'] = null;
			$_SESSION['indice_subcuenta_libre'] = null;
			$_SESSION['indice_comprobante_interno'] = null;
			$_SESSION['indice_comprobante_interno2'] = null;
			$_SESSION['rifs'] = null;
			$_SESSION['indice_rif']=null;
			$_SESSION['indice_rif2']=null;
			$_SESSION['vouchers'] = null;
			$_SESSION['indice_voucher']=null;
			$_SESSION['indice_voucher2']=null;
			$_SESSION['registrarPagosVarios']=null;

			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'PagosVarios':
			$vista = "../../src/Vistas/caja/estado_de_cuenta.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$accion = $_POST['accion'];

			if($accion=="Cuentas"){
				$indice_cuenta_libre = $_POST['indice_cuenta_libre'];
				$cuentasLibres=$_SESSION['cuentasLibres'];
				require_once "../Modelos/SubCuentasModel.php";
				$objSubCuentas = new SubCuentasModel();
				$subCuentasLibres = $objSubCuentas->subcuentas_por_cuenta($cuentasLibres[$indice_cuenta_libre]['id']);
				$_SESSION['indice_cuenta_libre'] = $indice_cuenta_libre;
				$_SESSION['subCuentasLibres'] = $subCuentasLibres;
				$_SESSION['indice_subcuenta_libre'] = null;
				$_SESSION['indice_comprobante_interno'] = null;
				$_SESSION['rifs'] = null;
				$_SESSION['indice_rif']=null;
				$_SESSION['vouchers'] = null;
				$_SESSION['indice_voucher']=null;
				$_SESSION['registrarPagosVarios']=null;

			}
			if($accion=="subCuenta"){
				$indice_subcuenta_libre=$_POST['indice_subcuenta_libre'];
				$_SESSION['indice_subcuenta_libre'] = $indice_subcuenta_libre;
				$_SESSION['indice_comprobante_interno'] = null;
				$_SESSION['rifs'] = null;
				$_SESSION['indice_rif']=null;
				$_SESSION['vouchers'] = null;
				$_SESSION['indice_voucher']=null;
				$_SESSION['registrarPagosVarios']=null;
			}
			if ($accion=="comprobante_interno") {
				$indice_comprobante_interno=$_POST['indice_comprobante_interno'];
				$comprobantesInternos = $_SESSION['comprobantesInternos'];
				$_SESSION['indice_comprobante_interno'] = $indice_comprobante_interno;
				
				if($comprobantesInternos[$indice_comprobante_interno]['tipo2']=="fisico"){
					//buscamos en la tabla RECIBOSINTERNOS y los presentamos en la vista
					require_once "../Modelos/RecibosInternosModel.php";
					$objRecibosInternos = new RecibosInternosModel();
					$rifs = $objRecibosInternos->rif_cerrados_con_saldo_mayor_a_cero_para_alumnos();
					if(count($rifs)==0) $_SESSION['mensaje']="No hay RIF por registrar";
					$_SESSION['rifs']=$rifs;
				}
				if($comprobantesInternos[$indice_comprobante_interno]['tipo2']=="electronico"){
					//regresamos a la vista para pedir monto
				}
				if($comprobantesInternos[$indice_comprobante_interno]['tipo2']=="bancarizado"){
					//buscamos en la tabla VOUCHERS y los presentamos en la vista
					require_once "../Modelos/VouchersModel.php";
					$objVouchers = new VouchersModel();
					$vouchers = $objVouchers->vouchers_cerrados_con_saldo_mayor_a_cero_para_alumnos();
					if(count($vouchers)==0) $_SESSION['mensaje']="No hay Vouchers por registrar";
					$_SESSION['vouchers']=$vouchers;
					
				}
				$_SESSION['id_comprobante_interno']=$id_comprobante_interno;
				$_SESSION['registrarPagosVarios']=null;
				$_SESSION['indice_rif']=null;
			}
			if ($accion=='rif') {
				$registrarPagosVarios = FALSE;
				$indice_rif = $_POST['indice_rif'];
				$rifs=$_SESSION['rifs'];
				$subCuentasLibres = $_SESSION['subCuentasLibres'];
				$indice_subcuenta_libre = $_SESSION['indice_subcuenta_libre'];
				if ($rifs[$indice_rif]['saldo']>$subCuentasLibres[$_SESSION['indice_subcuenta_libre']]['monto']) {
					$registrarPagosVarios = TRUE;
				} else {
					$registrarPagosVarios = TRUE;						
					$alerta = 'El monto del RIF no es suficiente ';
					$_SESSION['alerta'] = $alerta;
				}
				$_SESSION['registrarPagosVarios']=$registrarPagosVarios;
				$_SESSION['indice_rif'] = $indice_rif;
			}
			if ($accion=='voucher') {
				$registrarPagosVarios = FALSE;
				$indice_voucher = $_POST['indice_voucher'];
				$vouchers=$_SESSION['vouchers'];
				$subCuentasLibres = $_SESSION['subCuentasLibres'];
				$indice_subcuenta_libre = $_SESSION['indice_subcuenta_libre'];
				if ($vouchers[$indice_voucher]['saldo']>=$subCuentasLibres[$_SESSION['indice_subcuenta_libre']]['monto']) {
					$registrarPagosVarios = TRUE;
				} else {
					$registrarPagosVarios = TRUE;						
					$alerta = 'El monto del VOUCHER no es suficiente ';
					$_SESSION['alerta'] = $alerta;
				}
				$_SESSION['registrarPagosVarios']=$registrarPagosVarios;
				$_SESSION['indice_voucher'] = $indice_voucher;
			}

			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'PrepararComprobante':
			$vista = "../../src/Vistas/caja/emitir_boleta.php";
			session_start();
			$_SESSION['vista'] = $vista;

			$accion = $_POST['accion'];
			$llave = $_SESSION['llave'];
			//DATOS NECESARIOS PARA PREPARAR EL COMPROBANTE
			if ($accion == "ingresos") {
				require_once "../Modelos/IngresosModel.php";
				$detalle = array();
				$detalle = $_POST['item'];

				//RECUPERAMOS LOS INGRESOS QUE CONFORMAN EL DETALLE
				for ($i=0; $i < count($detalle) ; $i++) { 
					$objIngresos = new IngresosModel();
					$temporal = $objIngresos->ingresos_por_id($detalle[$i]);
					$detalles[$i] = $temporal[0]; 
				}
				$_SESSION['detalles'] = $detalles;
				
				//RECUPERAMOS LA LISTA DE COMPROBANTES EMITIDOS
				require_once "../Modelos/RegistrosDeVentasModel.php";
				$objRv = new RegistrosDeVentasModel();
				$registrosDeVentas = $objRv->rv_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);
				$_SESSION['registrosDeVentas'] = $registrosDeVentas;
				
				$_SESSION['indice_comprobante_externo'] = NULL;
				$_SESSION['indice_cliente'] = NULL;
			}
			
			if ($accion == "ElegirComprobante") {
				$indice_comprobante_externo = $_POST['indice_comprobante_externo'];
				$_SESSION['indice_comprobante_externo'] = $indice_comprobante_externo;
				
				//DE ACUERDO AL CODIGO DE SUNAT DEL COMPROBANTE ELABORAMOS LA LISTA DE CLIENTES
				
				// codigo_sunat=01    PARA FACTURA
				$comprobantesExternos = $_SESSION['comprobantesExternos'];
				if ($comprobantesExternos[$indice_comprobante_externo]['codigo_sunat']=="01") {
					//buscamos datos de las personas jurídicas que se usaron en facturas emitidas
					require_once "../Modelos/PersonasJuridicasModel.php";
					$objPersonasJuridicas = new PersonasJuridicasModel();
					$clientes = $objPersonasJuridicas->personas_juridicas_relacionadas_al_estudiante($_SESSION['alumnosCaja'][$llave]['id']);
					$_SESSION['clientes']=$clientes;
				}
				
				// codigo_sunat=03		PARA BOLETAS
				$comprobantesExternos = $_SESSION['comprobantesExternos'];
				if ($comprobantesExternos[$indice_comprobante_externo]['codigo_sunat']=="03") {
					// buscar los datos del alumno, de los padres y/o apoderado
					$llave = $_SESSION['llave'];
					require_once "../Modelos/UsersModel.php";
					$objPadre = new UsersModel();
					$objMadre = new UsersModel();
					$objApoderado = new UsersModel();
					$padre = $objPadre->buscar_por_dni($_SESSION['alumnosCaja'][$llave]['padre']);
					$madre = $objMadre->buscar_por_dni($_SESSION['alumnosCaja'][$llave]['madre']);
					$apoderado= $objApoderado->buscar_por_dni($_SESSION['alumnosCaja'][$llave]['apoderado']);
					
					$clientes[0] = $_SESSION['alumnosCaja'][$llave];
					$clientes[1] = $apoderado[0];
					$clientes[2] = $padre[0];
					$clientes[3] = $madre[0];

					$_SESSION['clientes']=$clientes;
				}
				$_SESSION['indice_cliente']=NULL;
			}

			if ($accion == "ElegirCliente") {
				$indice_cliente = $_POST['indice_cliente'];
				$_SESSION['indice_cliente'] = $indice_cliente;
			}
			
			if ($accion == "ActualizarDatos") {
				$direccion= $_POST['direccion'];
				$telefono = $_POST['telefono'];
				$email= $_POST['email'];
				$indice_cliente = $_SESSION['indice_cliente'];
				$clientes = $_SESSION['clientes'];
				require_once "../Modelos/UsersModel.php";
				$objUsers = new UsersModel();
				if( $objUsers->actualizar_direccion_telefono_email_con_el_dni($clientes[$indice_cliente]['dni'], $direccion, $telefono, $email) ){
					$clientes[$indice_cliente]['email'] = $email;
					$clientes[$indice_cliente]['direccion'] = $direccion;
					$clientes[$indice_cliente]['movistar'] = $telefono;
					$_SESSION['mensaje'] = "Los datos se actualizaron correctamente";
				} else $_SESSION['error'] = "Los datos no se actualizaron";
				$_SESSION['clientes'] = $clientes;
			}

			if ($accion == "GuardarPersonaJuridica") {
				$modo = $_POST['modo'];	
				if ($modo=="nuevo") {
					$personaJuridica['ruc'] = $_POST['ruc'];	
				} else {
					$clientes = $_SESSION['clientes'];
					$indice_cliente = $_SESSION['indice_cliente'];
					$personaJuridica['ruc'] = $clientes[$indice_cliente]['ruc'];
				}
				
				$personaJuridica['razon_social'] = $_POST['razon_social'];
				$personaJuridica['direccion'] = $_POST['direccion'];
				$personaJuridica['telefono'] = $_POST['telefono'];
				$personaJuridica['ubigeo'] = $_POST['ubigeo'];
				$personaJuridica['email'] = $_POST['email'];
				$personaJuridica['username'] = $_SESSION['user'][0]['username'];
				
				require_once "../Modelos/PersonasJuridicasModel.php";
				$objPj = new PersonasJuridicasModel();
				$resultado = FALSE;
				
				if ($modo=="nuevo") {
					if ($objPj->guardar_persona_juridica($personaJuridica ) ) {
						$_SESSION['mensaje'] = "Guardado correctamente";
						$resultado = TRUE;
					} else $_SESSION['error'] = "No se ha logrado guardar";	
				}
				if ($modo=="actualizar") {
					
					if ($objPj->actualizar_por_ruc($personaJuridica ) ) {
						$_SESSION['mensaje'] = "Actualizado correctamente";
						$resultado = TRUE;
					} else $_SESSION['error'] = "No se ha logrado actualizar";	
				}
				if ($resultado) {
					$objPj1 = new PersonasJuridicasModel();
					$personaJuridica = $objPj1->buscar_por_ruc($personaJuridica['ruc']);
					$_SESSION['clientes'] = $personaJuridica;
				}		
			}

			if ($accion == "BuscarRuc") {
				$ruc = $_POST['ruc'];
				
				require_once "../Modelos/PersonasJuridicasModel.php";
				$objPj = new PersonasJuridicasModel();
				$personaJuridica = $objPj->buscar_por_ruc($ruc);
				if (count($personaJuridica)==1) {
					$_SESSION['clientes'] = $personaJuridica;
					$_SESSION['mensaje'] = "Encontrado";
				} else {
					 $_SESSION['alerta'] = "No hay coincidencias";
					 $_SESSION['clientes'] = null;
					 $_SESSION['indice_cliente'] =null;
				}
			}
			
			header("Location: ../../src/Vistas/vista.php"); 
			break;

		case 'GuardarComprobante':
			$vista = "../../src/Vistas/caja/emitir_boleta.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			//SACAMOS VARIABLES DE LA SESION PARA ARMAR EL COMPROBANTE
			$indice_cliente = $_SESSION['indice_cliente'];
			$clientes = $_SESSION['clientes'];
			$comprobantesExternos = $_SESSION['comprobantesExternos'];
			$indice_comprobante_externo = $_SESSION['indice_comprobante_externo'];
			
			//ARMAMOS EL ARRAY PARA GUARDAR EL COMPROBANTE
			$registroDeVenta['personajuridica_id'] = NULL;
			$registroDeVenta['user_id'] = NULL;
			
			if ($comprobantesExternos[$indice_comprobante_externo]['codigo_sunat'] == "01" ) 	// aqui se registra el id de la persona jurídica si el codigo_sunat 01
				$registroDeVenta['personajuridica_id'] = $clientes[$indice_cliente]['id'];	

			if ($comprobantesExternos[$indice_comprobante_externo]['codigo_sunat'] == "03" ) 	// aqui se registra el id de la persona si el codigo_sunat 03
				$registroDeVenta['user_id'] = $clientes[$indice_cliente]['id'];	
			
			$registroDeVenta['comprobante_id'] = $comprobantesExternos[$indice_comprobante_externo]['id'];
			$registroDeVenta['serie'] = $comprobantesExternos[$indice_comprobante_externo]['serie'];
//			$registroDeVenta['correlativo'] =  // se requiere buscar en la base de datos
//			$registroDeVenta['fecha'] =  Se guardará al momento de registrar el comprobante en la base de datos
			$registroDeVenta['total_gravado'] = $_POST['total_gravado'];
			$registroDeVenta['total_inafecto'] = $_POST['total_inafecto'];
			$registroDeVenta['total_exonerado'] = $_POST['total_exonerado'];
			$registroDeVenta['total_gratuito'] = $_POST['total_gratuito'];
			$registroDeVenta['total_exportacion'] = $_POST['total_exportacion'];
			$registroDeVenta['total_descuento'] = $_POST['total_descuento'];
			$registroDeVenta['subtotal'] = $_POST['subtotal'];
			$registroDeVenta['por_igv'] = $_POST['por_igv'];
			$registroDeVenta['total_igv'] = $_POST['total_igv'];
			$registroDeVenta['total_isc'] = $_POST['total_isc'];
			$registroDeVenta['total_otr_imp'] = $_POST['total_otr_imp'];
			$registroDeVenta['total'] = $_POST['total'];
			$registroDeVenta['anulado'] = 0;
			$registroDeVenta['username'] = $_SESSION['user'][0]['username'];
			
			//Buscamos el correlativo para esta serie
			$iniciar_en = 1;
			if ($registroDeVenta['serie']=='FE01' ) $iniciar_en = 1;
			if ($registroDeVenta['serie']=='BE01' ) $iniciar_en = 6382;
			 
			require_once "../Modelos/RegistrosDeVentasModel.php";
			$objRv = new RegistrosDeVentasModel();
			$temporal1 = $objRv->obtener_ultimo_correlativo($registroDeVenta['serie']);
			 
			if ($temporal1[0]['MAX(correlativo)']=='') $registroDeVenta['correlativo']=$iniciar_en; 
			else $registroDeVenta['correlativo'] = $temporal1[0]['MAX(correlativo)']+1;

			//GUARDAMOS EL REGISTRO DE VENTA DE ACUERDO AL codigo_sunat
			$objRv2 = new RegistrosDeVentasModel();

			if ($comprobantesExternos[$indice_comprobante_externo]['codigo_sunat'] == "01") { //facturas
				if( $objRv2->guardar_registro_factura($registroDeVenta) ) {
					$_SESSION['alerta']="La FACTURA se REGISTRÓ correctamente";
					$estado = TRUE;					
				} else {
					$_SESSION['error']="La FACTURA NO se guardó";
					$estado = FALSE;
				} 			
			}
			
			if ($comprobantesExternos[$indice_comprobante_externo]['codigo_sunat'] == "03") { //boletas
				if( $objRv2->guardar_registro_boleta($registroDeVenta) ) {
					$_SESSION['mensaje']="La BOLETA se REGISTRÓ correctamente";
					$estado = TRUE;					
				} else {
					$_SESSION['error']="La BOLETA NO se guardó";
					$estado = FALSE;
				} 			
			}
			
			//SI EL COMPROBANTE SE HA GUARDADO CORRECTAMENTE NECESITAMOS REGISTRAR SU ID EN LA TABLA INGRESOS
			
			//buscamos el id del comprobante
			if ($estado) {
				$objRv3 = new RegistrosDeVentasModel();
				$temporal2 = $objRv3->buscar_id_de_registro_por_serie_y_correlativo($registroDeVenta['serie'], $registroDeVenta['correlativo']);
				$registroDeVenta['id'] = $temporal2[0]['id'];
				
				//actualizamos el campo registrodeventa_id de los ingresos relacionados
				require_once "../Modelos/IngresosModel.php";
				$objIngresos = new IngresosModel();
				$detalles = $_SESSION['detalles'];
				$contador=0;
				for ($i=0; $i < count($detalles) ; $i++) { 
					if ($objIngresos->actualizar_registrodeventa_id( $detalles[$i]['id'], $registroDeVenta['id'] ) ) {
						$contador++;
					}
				}
				if ($contador == count($detalles)) {
					$_SESSION['mensaje'] = "Los ingresos se actualizaron correctamente";
					
					$_SESSION['clientes']=null;
					$_SESSION['indice_cliente']=null;
					$_SESSION['detalles']=null;
					$_SESSION['indice_comprobante_externo']=null;

					//ARMAMOS EL ESTADO DE CUENTA DEL ALUMNO: EMPEZAMOS BUSCAMOS LAS DEUDAS DEL ALUMNO
					$llave = $_SESSION['llave'];
					require_once "../Modelos/DeudasModel.php";
					$objDeudas = new DeudasModel();
					$deudas = $objDeudas->deuda_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);
		
					//POR CADA DEUDA BUSCAMOS LOS INGRESOS REGISTRADOS
					require_once "../Modelos/IngresosModel.php";
					require_once "../Modelos/RegistrosDeVentasModel.php";
					require_once "../Modelos/ComprobantesModel.php";
					for ($i=0; $i < count($deudas); $i++) { 
						$objIngreso3 = new IngresosModel();
						$ingresos = $objIngreso3->ingresos_por_deuda_y_usuario($deudas[$i]['id'], $_SESSION['alumnosCaja'][$llave]['id']);
						$deudas[$i]['ingresos']=$ingresos;
						//POR CADA INGRESO BUSCAMOS SI TIENE REGISTROS DE VENTA
						for ($j=0; $j < count($deudas[$i]['ingresos']); $j++ ){
							$deudas[$i]['ingresos'][$j]['tipo1']="externo";
							if($deudas[$i]['ingresos'][$j]['registrodeventa_id']=="" ) {
								$deudas[$i]['ingresos'][$j]['registrodeventa'] = array();
								$objComprobante = new ComprobantesModel();
								if($objComprobante->si_el_comprobante_es_interno($deudas[$i]['ingresos'][$j]['serie']) ){
									$deudas[$i]['ingresos'][$j]['tipo1']="interno";
								}
							} 
							else {
								$objRegistrosDeVentas = new RegistrosDeVentasModel();
								$registroDeVenta = $objRegistrosDeVentas->registro_de_venta_por_deuda($deudas[$i]['ingresos'][$j]['registrodeventa_id']);
								$deudas[$i]['ingresos'][$j]['registrodeventa'] = $registroDeVenta;	
							}
						}
					}
					$_SESSION['deudas'] = $deudas;
					
					//ACTUALIZAMOS EL LISTADO DE LOS COMPROBANTES DE VALOR OFICIAL EMITIDOS AL ESTUDIANTE DE LA TABLA REGISTRO DE VENTAS
					require_once "../Modelos/PersonasJuridicasModel.php";
					require_once "../Modelos/UsersModel.php";
					
					$objRv = new RegistrosDeVentasModel();
					$registrosDeVentas = $objRv->rv_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);
					if (count($registrosDeVentas )>0 ) {
						for ($i=0; $i <count($registrosDeVentas) ; $i++) { 
							if ($registrosDeVentas[$i]['personajuridica_id']!="") {
								$objPj = new PersonasJuridicasModel();
								$cliente = $objPj->buscar_por_id($registrosDeVentas[$i]['personajuridica_id']);
								$registrosDeVentas[$i]['cliente']=$cliente;
							}
							if ($registrosDeVentas[$i]['user_id']!="") {
								$objUsers = new UsersModel();
								$cliente = $objUsers->buscar_por_id($registrosDeVentas[$i]['user_id']);
								$registrosDeVentas[$i]['cliente']=$cliente;
							}
						}
					}
					$_SESSION['registrosDeVentas'] = $registrosDeVentas;

										
				} else {
					$_SESSION['mensaje'] = "Los ingresos NO SE actualizaron correctamente";
				}
			}

			header("Location: ../../src/Vistas/vista.php"); 
			break;
			
		case 'GuardarBoleta':
			$vista = "../../src/Vistas/caja/emitir_boleta.php";
			session_start();
			$_SESSION['vista'] = $vista;

			$llave = $_SESSION['llave'];
			$llave_deuda = $_POST['llave_deuda'];
			$cobro = $_POST['cobro'];
			$descuento = $_POST['descuento'];
			$totalBoletas = $_POST['total_boletas']; // suma del total de las boletas correspondientes a esta deuda.
			$efectivo = $_POST['efectivo'];
			$saldo = $_POST['saldo'];
			
			//DATOS PARA LA BOLETA INTERNA
			$boleta['stand_id']=$_SESSION['standAbiertos'][0]['id'];
			$boleta['user_id']=$_SESSION['alumnosCaja'][$llave]['id'];
			$boleta['serie']=$_SESSION['standAbiertos'][0]['serie'];
			$boleta['correlativo']=$_SESSION['standAbiertos'][0]['numero'];
			$boleta['fecha']=$_POST['fecha'];
			$boleta['hora']=$_POST['hora'];
			
			$boleta['deuda_id']=$_SESSION['deudas'][$llave_deuda]['id'];
			
			if($efectivo>=$saldo){
				$boleta['monto']=$cobro - $totalBoletas;
				$boleta['descuento']=$descuento;
				$boleta['cancelado']=1; // para actualizar el estado de la DEUDA
			}
			if($efectivo<$saldo){
				$boleta['monto']=$efectivo;
				$boleta['descuento']=0;
				$boleta['cancelado']=0; // para actualizar el estado de la DEUDA
			}

			$boleta['total']=$boleta['monto']-$boleta['descuento'];
			$boleta['efectivo']=$efectivo;
			$boleta['vuelto']=$boleta['efectivo']-$boleta['total'];
			$boleta['username']=$_SESSION['user'][0]['username'];
			$boleta['comentario']=$_SESSION['deudas'][$llave_deuda]['comentario'];;
			$boleta['anulado']=0;
			$boleta['observacion']="Ninguno";
			$boleta['detalle']=$_SESSION['deudas'][$llave_deuda]['detalle'];
			$boleta['subcuenta_id']=$_SESSION['deudas'][$llave_deuda]['subcuenta_id'];
			$boleta['titulo']=$_SESSION['standAbiertos'][0]['punto_de_venta'];

			//GENERAMOS LA BOLETA ELECTRONICA
			if ($boleta['titulo']=="BOLETA ELECTRONICA") {
				$boleta['dni']=$_SESSION['alumnosCaja'][$llave]['dni'];
				$boleta['usuario']=$_SESSION['alumnosCaja'][$llave]['apellido_paterno']." ".$_SESSION['alumnosCaja'][$llave]['apellido_materno']." ".$_SESSION['alumnosCaja'][$llave]['nombres'];
				$boleta['serie']=$_SESSION['standAbiertos'][0]['serie'];
				$boleta['correlativo']=$_SESSION['standAbiertos'][0]['numero'];

				require_once "../Modelos/BoletasElectronicasModel.php";
				$objBoletaElectronica = new BoletasElectronicasModel();
				$objBoletaElectronica->guardar_boleta_electronica($boleta);
			}

			//GUARDAMOS LA BOLETA EN NUESTRO SISTEMA INTERNO.
			require_once "../Modelos/BoletasModel.php";
			$objBoletas = new BoletasModel();
			if($objBoletas->guardar_boleta($boleta)){
				//ACTUALIZA NUMERO CORRELATIVO PARA LA SIGUIENTE BOLETA EN LA SESSION Y BD.
				require_once "../Modelos/StandsModel.php";
				$objStands = new StandsModel();
				if( $objStands->incrementar_numeracion($boleta['stand_id'],$boleta['username']) ){
					$objStand1 = new StandsModel();
					$nuevoStand = $objStand1->buscar_numero($boleta['stand_id']);
					$_SESSION['standAbiertos'][0]['numero']=$nuevoStand[0]['numero'];
				}

				//ACTUALIZO ESTADO DE LA DEUDA: SE CANCELO O NO $BOLETA['CANCELADO']
				require_once "../Modelos/DeudasModel.php";
				if($boleta['cancelado']==1){
					$objDeuda = new DeudasModel();
					$objDeuda->cancelar_deuda($boleta['deuda_id'], $boleta['username']);
					
					//SI LA CUENTA QUE SE CANCELO ES DE UNA MATRICULA ENTONCES ACTUALIZAMOS EL ESTADO DE LA MATRICULA A 4
					if ($_SESSION['deudas'][$llave_deuda]['cuenta']=="Matricula") {
						require_once "../Modelos/MatriculasModel.php";
						$objMatricula = new MatriculasModel();
						$objMatricula->actualizar_paso_matricula(4, $_SESSION['deudas'][$llave_deuda]['matricula_id']);
					}
				}
				
				//ACTUALIZO ESTADO DE CUENTA DEL ESTUDIANTE
				$objDeudas = new DeudasModel();
				$deudas = $objDeudas->deuda_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);
	
				for ($i=0; $i < count($deudas); $i++) { 
					$objBoletas1 = new BoletasModel();
					$boletas = $objBoletas1->boletas_por_deuda_y_usuario($deudas[$i]['id'], $boleta['user_id']);
					$deudas[$i]['boletas']=$boletas;
				}
				$_SESSION['deudas'] = $deudas;
				$_SESSION['boleta'] = $boleta;
			} else echo "NO SE GUARDO";

			header("Location: ../../src/Vistas/vista.php"); 
			break;

		case 'GuardarOtrosPagos':
			$vista = "../../src/Vistas/caja/emitir_boleta.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			//GUARDAMOS LA NUEVA DEUDA ADQUIRIDA
			$llave = $_SESSION['llave'];
			$username = $_SESSION['user'][0]['username'];
			$otrasCuentas=$_SESSION['otrasCuentas'];
			for ($i=0; $i < count($otrasCuentas); $i++) {
				if($otrasCuentas[$i]['id']==$_SESSION['id_otra_cuenta'])
					$deuda['cuenta']=$otrasCuentas[$i]['cuenta'];
			}
			$OtrasSubCuentas=$_SESSION['OtrasSubCuentas'];
			for ($i=0; $i < count($OtrasSubCuentas); $i++) {
				if($OtrasSubCuentas[$i]['id']==$_SESSION['id_otra_subcuenta']) {
					$deuda['subcuenta_id']=$OtrasSubCuentas[$i]['id'];
					$deuda['detalle']=$OtrasSubCuentas[$i]['subcuenta'];
					$deuda['monto']=$OtrasSubCuentas[$i]['monto'];
				}
			}
			$deuda['fecha_de_cobro']=$_POST['fecha'];
			$deuda['fecha_vencimiento']=$_POST['fecha'];
			$deuda['descuento_pago_oportuno']=0;
			
			require_once "../Modelos/DeudasModel.php";
			$objDeudas = new DeudasModel();
			// INSERTAMOS EL VALOR DE 0 PARA matricula_id INDICANDO QUE NO PERTENECE A UNA CUENTA DE GRUPO SINO CUENTAS LIBRES
			if ($objDeudas->insertar($_SESSION['alumnosCaja'][$llave]['id'], $deuda, $username,0,"")){
				$objDeudas1 = new DeudasModel();
				$deudaId=$objDeudas1->buscar_id($_SESSION['alumnosCaja'][$llave]['id'], $deuda, $username,0);
				if(count($deudaId)==1){
					$deuda['id']=$deudaId[0]['id'];

					//PREPARAMOS LOS DATOS PARA GENERAR LA BOLETA
					$efectivo = $_POST['efectivo_otro_pago'];
					
					$boleta['stand_id']=$_SESSION['standAbiertos'][0]['id'];
					$boleta['user_id']=$_SESSION['alumnosCaja'][$llave]['id'];
					$boleta['serie']=$_SESSION['standAbiertos'][0]['serie'];
					$boleta['correlativo']=$_SESSION['standAbiertos'][0]['numero'];
					$boleta['fecha']=$_POST['fecha'];
					$boleta['hora']=$_POST['hora'];
					$boleta['deuda_id']=$deuda['id'];
					$boleta['monto']=$deuda['monto'];
					$boleta['descuento']=$deuda['descuento_pago_oportuno'];
					$boleta['cancelado']=1; // para actualizar el estado de la DEUDA
					$boleta['total']=$boleta['monto']-$boleta['descuento'];
					$boleta['efectivo']=$efectivo;
					$boleta['vuelto']=$boleta['efectivo']-$boleta['total'];
					$boleta['username']=$_SESSION['user'][0]['username'];
					$boleta['comentario']="";
					$boleta['anulado']=0;
					$boleta['observacion']="Ninguno";
					$boleta['detalle']=$deuda['detalle'];
					$boleta['titulo']=$_SESSION['standAbiertos'][0]['punto_de_venta'];
					
					//GENERAMOS LA BOLETA ELECTRONICA
					if ($boleta['titulo']=="BOLETA ELECTRONICA") {
						$boleta['dni']=$_SESSION['alumnosCaja'][$llave]['dni'];
						$boleta['usuario']=$_SESSION['alumnosCaja'][$llave]['apellido_paterno']." ".$_SESSION['alumnosCaja'][$llave]['apellido_materno']." ".$_SESSION['alumnosCaja'][$llave]['nombres'];
		
						require_once "../Modelos/BoletasElectronicasModel.php";
						$objBoletaElectronica = new BoletasElectronicasModel();
						$objBoletaElectronica->guardar_boleta_electronica($boleta);
					}
					
					//GUARDAMOS LA BOLETA
					require_once "../Modelos/BoletasModel.php";
					$objBoletas = new BoletasModel();
					if($objBoletas->guardar_boleta($boleta)){

						//ACTUALIZA NUMERO CORRELATIVO PARA LA SIGUIENTE BOLETA EN LA SESSION Y BD.
						require_once "../Modelos/StandsModel.php";
						$objStands = new StandsModel();
						if( $objStands->incrementar_numeracion($boleta['stand_id'], $boleta['username']) ){
							$objStand1 = new StandsModel();
							$nuevoStand = $objStand1->buscar_numero($boleta['stand_id']);
							$_SESSION['standAbiertos'][0]['numero']=$nuevoStand[0]['numero'];
						}
		
						//ACTUALIZO ESTADO DE LA DEUDA: SE CANCELO O NO $BOLETA['CANCELADO']
						require_once "../Modelos/DeudasModel.php";
						if($boleta['cancelado']==1){
							$objDeuda = new DeudasModel();
							$objDeuda->cancelar_deuda($boleta['deuda_id'],$boleta['username']);
						}
						
						//ACTUALIZO ESTADO DE CUENTA DEL ESTUDIANTE
						$objDeudas = new DeudasModel();
						$deudas = $objDeudas->deuda_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);
			
						for ($i=0; $i < count($deudas); $i++) { 
							$objBoletas1 = new BoletasModel();
							$boletas = $objBoletas1->boletas_por_deuda_y_usuario($deudas[$i]['id'], $boleta['user_id']);
							$deudas[$i]['boletas']=$boletas;
						}
						$_SESSION['deudas'] = $deudas;
						$_SESSION['boleta'] = $boleta;
						$_SESSION['id_otra_cuenta']=null;
						$_SESSION['id_otra_subcuenta']=null;
					} else echo "NO SE GUARDO";
				}
			}
			header("Location: ../../src/Vistas/vista.php");  
			break;

		case 'RegistrarIngresoLibre':	
			//INDICAMOS LA SIGUIENTE VISTA Y CAPTURAMOS LA SESSION.			
			$vista = "../../src/Vistas/caja/estado_de_cuenta.php";
			session_start();
			$_SESSION['vista'] = $vista;

			//RECIBIREMOS LAS VARIABLES A TRAVÉS DEL MÉTODO POST
			$accion = $_POST['accion']; // opciones: rie, voucher, rif
			$hora = $_POST['hora'];
			$fecha = $_POST['fecha'];

			//RECUPERAMOS DE LA SESION LAS VARIABLES NECESARIAS
			$llave = $_SESSION['llave'];
			$cuentasLibres = $_SESSION['cuentasLibres'];
			$indice_cuenta_libre = $_SESSION['indice_cuenta_libre'];
			$subCuentasLibres=$_SESSION['subCuentasLibres'];
			$indice_subcuenta_libre = $_SESSION['indice_subcuenta_libre'];
			$comprobantesInternos = $_SESSION['comprobantesInternos'];
			$indice_comprobante_interno = $_SESSION['indice_comprobante_interno'];
			
			//GENERAMOS EL ARRAY DE LA DEUDA
			$deuda['id']=NULL;
			$deuda['user_id'] = $_SESSION['alumnosCaja'][$llave]['id'];
			$deuda['matricula_id'] = 0; // ponemos 0 porque no pertenece a ninguna cuenta de grupo
			$deuda['cuenta']=$cuentasLibres[$indice_cuenta_libre]['cuenta'];
			$deuda['subcuenta_id']=$subCuentasLibres[$indice_subcuenta_libre]['id'];
			$deuda['detalle']=$subCuentasLibres[$indice_subcuenta_libre]['subcuenta'];
			$deuda['fecha_de_cobro']=$fecha;
			$deuda['monto']=$subCuentasLibres[$indice_subcuenta_libre]['monto'];
			$deuda['fecha_vencimiento']=$fecha;
			$deuda['descuento_pago_oportuno']=0;
			$deuda['cancelado']=0;
			$deuda['comentario'] = '';
			$deuda['username'] = $_SESSION['user'][0]['username'];
			
			//GENERAMOS EL ARRAY DEL INGRESO
			$ingreso['cierre_id'] = NULL;
			$ingreso['comprobante_id'] = $comprobantesInternos[$indice_comprobante_interno]['id'];
			$ingreso['recibointerno_id'] = NULL;
			$ingreso['voucher_id'] = NULL;
			$ingreso['user_id'] = $_SESSION['alumnosCaja'][$llave]['id'];;
			$ingreso['serie'] = $comprobantesInternos[$indice_comprobante_interno]['serie'];
			$ingreso['correlativo'] = NULL;
			$ingreso['fecha'] = $fecha;
			$ingreso['hora'] = $hora;
			$ingreso['deuda_id'] = $deuda['id'];
			$ingreso['detalle'] = $deuda['detalle'];
			$ingreso['monto'] = $deuda['monto'];
			$ingreso['descuento'] = $deuda['descuento_pago_oportuno'];
			$ingreso['total'] = $deuda['monto']-$deuda['descuento_pago_oportuno'];
			$ingreso['efectivo'] = NULL;
			$ingreso['vuelto'] = NULL;
			$ingreso['comentario'] = NULL;
			$ingreso['observacion'] = NULL;
			$ingreso['anulado'] = 0;
			$ingreso['username'] = $_SESSION['user'][0]['username'];;
				
			if ($accion == 'rif') {
				$rifs = $_SESSION['rifs'];
				$indice_rif = $_SESSION['indice_rif'];
				
				$ingreso['cierre_id'] = $rifs[$indice_rif]['cierre_id'];
				$ingreso['recibointerno_id'] = $rifs[$indice_rif]['id'];
				$ingreso['correlativo'] = $rifs[$indice_rif]['correlativo'];
				$ingreso['fecha'] = $rifs[$indice_rif]['fecha'];
				$ingreso['hora'] = $rifs[$indice_rif]['hora'];
				$ingreso['efectivo'] = $rifs[$indice_rif]['saldo'];
				
				//Calculamos el vuelto para ver si la deuda se logra cancelar o no
				if ($rifs[$indice_rif]['saldo']>=$ingreso['total']) {
					$ingreso['vuelto'] = $rifs[$indice_rif]['saldo']-$ingreso['total']; // el vuelto es el nuevo saldo del rif
					$deuda['cancelado']=1;	
				} else {
					$ingreso['monto'] = $rifs[$indice_rif]['saldo'];
					$ingreso['descuento'] = 0;
					$ingreso['total'] = $rifs[$indice_rif]['saldo'];
					$ingreso['efectivo'] = $rifs[$indice_rif]['saldo'];
					$ingreso['vuelto'] = 0;
					
				}
				$rifs[$indice_rif]['saldo']=$ingreso['vuelto']; //PARA ACTUALIZAR EL SALDO DEL RIF
			}
			
			if ($accion == 'voucher') {
				$vouchers = $_SESSION['vouchers'];
				$indice_voucher = $_SESSION['indice_voucher'];

				$ingreso['cierre_id'] = $vouchers[$indice_voucher]['cierre_id'];
				$ingreso['voucher_id'] = $vouchers[$indice_voucher]['id'];
				$ingreso['correlativo'] = $vouchers[$indice_voucher]['operacion'];
				$ingreso['fecha'] = $vouchers[$indice_voucher]['fecha'];
				$ingreso['hora'] = $vouchers[$indice_voucher]['hora'];
				$ingreso['efectivo'] = $vouchers[$indice_voucher]['saldo'];
				
				//Calculamos el vuelto para ver si la deuda se logra cancelar o no
				if ($vouchers[$indice_voucher]['saldo']>=$ingreso['total']) {
					$ingreso['vuelto'] = $vouchers[$indice_voucher]['saldo']-$ingreso['total']; // el vuelto es el nuevo saldo del rif
					$deuda['cancelado']=1;	
				} else {
					$ingreso['monto'] = $vouchers[$indice_voucher]['saldo'];
					$ingreso['descuento'] = 0;
					$ingreso['total'] = $vouchers[$indice_voucher]['saldo'];
					$ingreso['efectivo'] = $vouchers[$indice_voucher]['saldo'];
					$ingreso['vuelto'] = 0;
				}
				$vouchers[$indice_voucher]['saldo']=$ingreso['vuelto']; // PARA ACTUALIZAR EL SALDO DEL VOUCHER
			}
						
			if ($accion == 'rie') {
				//GENERAMOS DATOS
				$ingreso['efectivo'] = $_POST['efectivo_otro_pago'];

				//Calculamos el vuelto para ver si la deuda se logra cancelar o no
				if ($ingreso['efectivo']>=$ingreso['total']) {
					$ingreso['vuelto'] = $ingreso['efectivo'] - $ingreso['total']; // el vuelto es el nuevo saldo del rie
					$deuda['cancelado']=1;	
				} else {
					$ingreso['vuelto'] = 0;
				}
			}			

			//GUARDAMOS LA DEUDA Y EL INGRESO RESPECTIVO
			require_once "../Modelos/DeudasModel.php";
			
			//BUSCAMOS EL ID PARA REGISTRAR LA DEUDA
			$objDeudaId = new DeudasModel();
			$temporal = $objDeudaId->solicitar_id();			
			$deuda['id'] = $temporal[0]['MAX(id)']+1;
			$objDeuda = new DeudasModel();

			if ($objDeuda->guardar_deuda($deuda)){ // INSERTAMOS LA DEUDA
				//AHORA GUARDAMOS EL INGRESO
				require_once "../Modelos/IngresosModel.php";
				$ingreso['deuda_id']=$deuda['id'];

				if ($accion=='rie') {
					//BUSCAMOS EL CORRELATIVO MAYOR DE ESTE COMPROBANTE
					$objIngreso = new IngresosModel();
					$temporal2 = $objIngreso->obtener_ultimo_correlativo($ingreso['serie']);
					 
					if ($temporal2[0]['MAX(correlativo)']=='') $ingreso['correlativo']=1; 
					else $ingreso['correlativo'] = $temporal2[0]['MAX(correlativo)']+1;

					$objIngreso2 = new IngresosModel();
					
					if( $objIngreso2->guardar_ingreso_desde_rie($ingreso) ) {
						$_SESSION['mensaje']="El INGRESO se GUARDÓ";
					} else $_SESSION['error']="El INGRESO NO se guardó";
					
				}
				if ($accion == 'rif') {	//actualizamos el saldo del rif
					$objIngreso2 = new IngresosModel();
					if( $objIngreso2->guardar_ingreso_desde_rif($ingreso) ) {
						require_once "../Modelos/RecibosInternosModel.php";
						$objRif = new RecibosInternosModel();
						if ($objRif->actualizar_saldo($rifs[$indice_rif]['id'], $rifs[$indice_rif]['saldo'])) {
							$_SESSION['mensaje']="El RIF se ACTUALIZÓ.";
						} else {
							$_SESSION['error']="El RIF NO se ACTUALIZÓ.";
						}
					} else $_SESSION['error']="El INGRESO NO se GUARDÓ";
				}
				if ($accion == 'voucher') {	//actualizamos el saldo del rif
					$objIngreso2 = new IngresosModel();
					if( $objIngreso2->guardar_ingreso_desde_voucher($ingreso) ) {
						require_once "../Modelos/VouchersModel.php";
						$objVoucher = new VouchersModel();
						if ($objVoucher->actualizar_saldo($vouchers[$indice_voucher]['id'], $vouchers[$indice_voucher]['saldo'])) {
							$_SESSION['mensaje']="El VOUCHER se ACTUALIZÓ.";
						} else {
							$_SESSION['error']="El VOUCHER NO se ACTUALIZÓ.";
						}
					} else $_SESSION['error']="El INGRESO no se GUARDÓ";
				}
					
				//ARMAMOS EL ESTADO DE CUENTA DEL ALUMNO: EMPEZAMOS BUSCAMOS LAS DEUDAS DEL ALUMNO
				$objDeuda3 = new DeudasModel();
				$deudas = $objDeuda3->deuda_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);
	
				//POR CADA DEUDA BUSCAMOS LOS INGRESOS REGISTRADOS
				require_once "../Modelos/RegistrosDeVentasModel.php";
				require_once "../Modelos/ComprobantesModel.php";
				for ($i=0; $i < count($deudas); $i++) { 
					$objIngreso3 = new IngresosModel();
					$ingresos = $objIngreso3->ingresos_por_deuda_y_usuario($deudas[$i]['id'], $_SESSION['alumnosCaja'][$llave]['id']);
					$deudas[$i]['ingresos']=$ingresos;
					//POR CADA INGRESO BUSCAMOS SI TIENE REGISTROS DE VENTA
					for ($j=0; $j < count($deudas[$i]['ingresos']); $j++ ){
						$deudas[$i]['ingresos'][$j]['tipo1']="externo";
						if($deudas[$i]['ingresos'][$j]['registrodeventa_id']=="" ) {
							$deudas[$i]['ingresos'][$j]['registrodeventa'] = array();
							$objComprobante = new ComprobantesModel();
							if($objComprobante->si_el_comprobante_es_interno($deudas[$i]['ingresos'][$j]['serie']) ){
								$deudas[$i]['ingresos'][$j]['tipo1']="interno";
							}
						} 
						else {
							$objRegistrosDeVentas = new RegistrosDeVentasModel();
							$registroDeVenta = $objRegistrosDeVentas->registro_de_venta_por_deuda($deudas[$i]['ingresos'][$j]['registrodeventa_id']);
							$deudas[$i]['ingresos'][$j]['registrodeventa'] = $registroDeVenta;	
						}
					}
				}

				// FIN DE ESTADO DE CUENTA
	
				$_SESSION['deudas'] = $deudas;
//				$_SESSION['ingresos'] = $ingresos;
				
				$_SESSION['indice_cuenta_libre'] = NULL;
				$_SESSION['subCuentasLibres'] = NULL;
				$_SESSION['indice_subcuenta_libre'] = NULL;
				$_SESSION['indice_comprobante_interno'] = NULL;
				$_SESSION['rifs'] = NULL;
				$_SESSION['indice_rif'] = NULL;
				$_SESSION['vouchers'] = NULL;
				$_SESSION['indice_voucher'] = NULL;
					
			} else {
				$_SESSION['error']="No se registró la DEUDA";
			}
			
			header("Location: ../../src/Vistas/vista.php");  
			break;

		case 'ElegirIngreso':
			$vista = "../../src/Vistas/caja/estado_de_cuenta.php";
			session_start();
			$_SESSION['vista'] = $vista;
			$accion = $_POST['accion'];

			if ($accion=="comprobante_interno") {
				$indice_comprobante_interno2=$_POST['indice_comprobante_interno2'];
				$comprobantesInternos = $_SESSION['comprobantesInternos'];
				$_SESSION['indice_comprobante_interno2'] = $indice_comprobante_interno2;
				
				if($comprobantesInternos[$indice_comprobante_interno2]['tipo2']=="fisico"){
					//buscamos en la tabla RECIBOSINTERNOS y los presentamos en la vista
					require_once "../Modelos/RecibosInternosModel.php";
					$objRecibosInternos = new RecibosInternosModel();
					$rifs = $objRecibosInternos->rif_cerrados_con_saldo_mayor_a_cero_para_alumnos();
					if(count($rifs)==0) $_SESSION['mensaje']="No hay RIF por registrar";
					$_SESSION['rifs']=$rifs;
				}
				if($comprobantesInternos[$indice_comprobante_interno2]['tipo2']=="electronico"){
					//regresamos a la vista para pedir monto
				}
				if($comprobantesInternos[$indice_comprobante_interno2]['tipo2']=="bancarizado"){
					//buscamos en la tabla VOUCHERS y los presentamos en la vista
					require_once "../Modelos/VouchersModel.php";
					$objVouchers = new VouchersModel();
					$vouchers = $objVouchers->vouchers_cerrados_con_saldo_mayor_a_cero_para_alumnos();
					if(count($vouchers)==0) $_SESSION['mensaje']="No hay Vouchers por registrar";
					$_SESSION['vouchers']=$vouchers;
					
				}
				$_SESSION['registrarPagoProgramado']=null;
				$_SESSION['indice_rif2']=null;
				$_SESSION['indice_voucher2']=null;
			}
			if ($accion=='rif') {
				$registrarPagoProgramado = FALSE;
				$indice_rif2 = $_POST['indice_rif2'];
				$montoPagoProgramado = $_POST['montoPagoProgramado'];
				$rifs=$_SESSION['rifs'];
				if ($rifs[$indice_rif2]['saldo']>$montoPagoProgramado) {
					$registrarPagoProgramado = TRUE;
				} else {
					$registrarPagoProgramado = TRUE;						
					$alerta = 'El monto del RIF no es suficiente ';
					$_SESSION['alerta'] = $alerta;
				}
				$_SESSION['registrarPagoProgramado']=$registrarPagoProgramado;
				$_SESSION['indice_rif2'] = $indice_rif2;
			}
			if ($accion=='voucher') {
				$registrarPagoProgramado = FALSE;
				$indice_voucher2 = $_POST['indice_voucher2'];
				$montoPagoProgramado = $_POST['montoPagoProgramado'];
				$vouchers=$_SESSION['vouchers'];
				if ($vouchers[$indice_voucher2]['saldo']>=$montoPagoProgramado ) {
					$registrarPagoProgramado = TRUE;
				} else {
					$registrarPagoProgramado = TRUE;						
					$alerta = 'El monto del VOUCHER no es suficiente ';
					$_SESSION['alerta'] = $alerta;
				}
				$_SESSION['registrarPagoProgramado']=$registrarPagoProgramado;
				$_SESSION['indice_voucher2'] = $indice_voucher2;
			}

			header("Location: ../../src/Vistas/vista.php");
			break;

		case 'RegistrarIngreso':
			//INDICAMOS LA SIGUIENTE VISTA Y CAPTURAMOS LA SESSION.			
			$vista = "../../src/Vistas/caja/estado_de_cuenta.php";
			session_start();
			$_SESSION['vista'] = $vista;

			//RECIBIREMOS LAS VARIABLES A TRAVÉS DEL MÉTODO POST
			$accion = $_POST['accion']; // opciones: rie, voucher, rif
			
			$indice_deuda = $_POST['indice_deuda'];
			$montoPagoProgramado = $_POST['montoPagoProgramado'];
			$descuento = $_POST['descuento'];
			$adelanto = $_POST['adelanto'];
			
			$hora = $_POST['hora'];
			$fecha = $_POST['fecha'];

			//RECUPERAMOS DE LA SESION LAS VARIABLES NECESARIAS
			$deudas = $_SESSION['deudas'];
			$llave = $_SESSION['llave'];
			$comprobantesInternos = $_SESSION['comprobantesInternos'];
			$indice_comprobante_interno2 = $_SESSION['indice_comprobante_interno2'];
			
			//GENERAMOS EL ARRAY DEL INGRESO
			$ingreso['cierre_id'] = NULL;
			$ingreso['comprobante_id'] = $comprobantesInternos[$indice_comprobante_interno2]['id'];
			$ingreso['recibointerno_id'] = NULL;
			$ingreso['voucher_id'] = NULL;
			$ingreso['user_id'] = $_SESSION['alumnosCaja'][$llave]['id'];;
			$ingreso['serie'] = $comprobantesInternos[$indice_comprobante_interno2]['serie'];
			$ingreso['correlativo'] = NULL;
			$ingreso['fecha'] = $fecha;
			$ingreso['hora'] = $hora;
			$ingreso['deuda_id'] = $deudas[$indice_deuda]['id'];
			$ingreso['detalle'] = $deudas[$indice_deuda]['detalle'];
			$ingreso['monto'] = NULL;
			$ingreso['descuento'] = $descuento;
			$ingreso['total'] = NULL;
			$ingreso['efectivo'] = NULL;
			$ingreso['vuelto'] = NULL;
			$ingreso['comentario'] = NULL;
			$ingreso['observacion'] = NULL;
			$ingreso['anulado'] = 0;
			$ingreso['username'] = $_SESSION['user'][0]['username'];;
				
			if ($accion == 'rif') {
				$rifs = $_SESSION['rifs'];
				$indice_rif2 = $_SESSION['indice_rif2'];
				
				$ingreso['cierre_id'] = $rifs[$indice_rif2]['cierre_id'];
				$ingreso['recibointerno_id'] = $rifs[$indice_rif2]['id'];
				$ingreso['correlativo'] = $rifs[$indice_rif2]['correlativo'];
				$ingreso['fecha'] = $rifs[$indice_rif2]['fecha'];
				$ingreso['hora'] = $rifs[$indice_rif2]['hora'];
				$ingreso['efectivo'] = $rifs[$indice_rif2]['saldo'];
				
				//Calculamos el vuelto para ver si la deuda se logra cancelar o no
				if ($ingreso['efectivo']>=$montoPagoProgramado ) {
					
					$ingreso['monto'] = $deudas[$indice_deuda]['monto'] - $adelanto;
					$ingreso['total'] = $ingreso['monto'] - $ingreso['descuento'];
					$ingreso['vuelto'] = $ingreso['efectivo'] - $ingreso['total']; // el vuelto es el nuevo saldo del rif
					$deudas[$indice_deuda]['cancelado']=1; // cancelamos la deuda	

				} else {
					$ingreso['monto'] = $ingreso['efectivo'];
					$ingreso['descuento'] = 0;
					$ingreso['total'] = $ingreso['monto'] - $ingreso['descuento'];
					$ingreso['vuelto'] = 0; // el vuelto es el nuevo saldo del rif
					$deudas[$indice_deuda]['cancelado']=0; // no se cancelamos la deuda	
				}
				$rifs[$indice_rif2]['saldo']=$ingreso['vuelto']; //PARA ACTUALIZAR EL SALDO DEL RIF
			}
			
			if ($accion == 'voucher') {
				$vouchers = $_SESSION['vouchers'];
				$indice_voucher2 = $_SESSION['indice_voucher2'];

				$ingreso['cierre_id'] = $vouchers[$indice_voucher2]['cierre_id'];
				$ingreso['voucher_id'] = $vouchers[$indice_voucher2]['id'];
				$ingreso['correlativo'] = $vouchers[$indice_voucher2]['operacion'];
				$ingreso['fecha'] = $vouchers[$indice_voucher2]['fecha'];
				$ingreso['hora'] = $vouchers[$indice_voucher2]['hora'];
				$ingreso['efectivo'] = $vouchers[$indice_voucher2]['saldo'];
				
				//Calculamos el vuelto para ver si la deuda se logra cancelar o no
				if ($ingreso['efectivo']>=$montoPagoProgramado ) {
					
					$ingreso['monto'] = $deudas[$indice_deuda]['monto'] - $adelanto;
					$ingreso['total'] = $ingreso['monto'] - $ingreso['descuento'];
					$ingreso['vuelto'] = $ingreso['efectivo'] - $ingreso['total']; // el vuelto es el nuevo saldo del voucher
					$deudas[$indice_deuda]['cancelado']=1; // cancelamos la deuda	

				} else {
					$ingreso['monto'] = $ingreso['efectivo'];
					$ingreso['descuento'] = 0;
					$ingreso['total'] = $ingreso['monto'] - $ingreso['descuento'];
					$ingreso['vuelto'] = 0; // el vuelto es el nuevo saldo del rif
					$deudas[$indice_deuda]['cancelado']=0; // no se cancelamos la deuda	
				}
				$vouchers[$indice_voucher2]['saldo']=$ingreso['vuelto']; //PARA ACTUALIZAR EL SALDO DEL voucher
			}
						
			if ($accion == 'rie') {
				//GENERAMOS DATOS
				$ingreso['efectivo'] = $_POST['efectivo2'];

				//Calculamos el vuelto para ver si la deuda se logra cancelar o no
				if ($ingreso['efectivo']>=$montoPagoProgramado ) {
					
					$ingreso['monto'] = $deudas[$indice_deuda]['monto'] - $adelanto;
					$ingreso['total'] = $ingreso['monto'] - $ingreso['descuento'];
					$ingreso['vuelto'] = $ingreso['efectivo'] - $ingreso['total']; // el vuelto es el nuevo saldo del voucher
					$deudas[$indice_deuda]['cancelado']=1; // cancelamos la deuda	

				} else {
					$ingreso['monto'] = $ingreso['efectivo'];
					$ingreso['descuento'] = 0;
					$ingreso['total'] = $ingreso['monto'] - $ingreso['descuento'];
					$ingreso['vuelto'] = 0; 
					$deudas[$indice_deuda]['cancelado']=0; // no se cancelamos la deuda	
				}
			}			

			// GUARDAMOS EL INGRESO, ACTUALIZAMOS EL RIF O VOUCHER Y ACTUALIZAMOS LA DEUDA
			require_once "../Modelos/IngresosModel.php";
			require_once "../Modelos/DeudasModel.php";

			$deudaCancelada = FALSE; // Esta variable la usaremos si se cancela una cuenta de matrícula						

			if ($accion == 'rie') {
				//buscamos el correlativo mayor para este comprobante
				$objIngreso = new IngresosModel();
				$temporal2 = $objIngreso->obtener_ultimo_correlativo($ingreso['serie']);
				 
				if ($temporal2[0]['MAX(correlativo)']=='') $ingreso['correlativo']=1; 
				else $ingreso['correlativo'] = $temporal2[0]['MAX(correlativo)']+1;

				$objIngreso2 = new IngresosModel();
				if( $objIngreso2->guardar_ingreso_desde_rie($ingreso) ) {
					$_SESSION['mensaje']="El INGRESO se REGISTRÓ correctamente";
					
					//ACTUALIZAMOS EL ESTADO DE LA DEUDA SI ESTA SE HA CANCELADO
					if($deudas[$indice_deuda]['cancelado']==1){
						$deudaCancelada = TRUE;
						$objDeuda = new DeudasModel();
						if ($objDeuda->cancelar_deuda($deudas[$indice_deuda]['id'], $ingreso['username'])) $_SESSION['mensaje']="La Deuda se CANCELÓ correctamente";
						else $_SESSION['error']="La DEUDA NO se CANCELÓ correctamente";
					}
				} else $_SESSION['error']="El INGRESO no se registró";
			}

			if ($accion == 'rif') {
				$objIngreso2 = new IngresosModel();
				if( $objIngreso2->guardar_ingreso_desde_rif($ingreso) ) {
					$_SESSION['mensaje']="El INGRESO se registró correctamente";

					//ACTUALIZAMOS EL SALDO DEL RIF
					require_once "../Modelos/RecibosInternosModel.php";
					$objRif = new RecibosInternosModel();
					if ($objRif->actualizar_saldo($rifs[$indice_rif2]['id'], $rifs[$indice_rif2]['saldo'])) {
						$_SESSION['mensaje']="El RIF se ACTUALIZÓ correctamente.";
	
						//ACTUALIZAMOS EL ESTADO DE LA DEUDA SI ESTA SE HA CANCELADO
						if($deudas[$indice_deuda]['cancelado']==1){
							$deudaCancelada = TRUE;
							$objDeuda = new DeudasModel();
							if ($objDeuda->cancelar_deuda($deudas[$indice_deuda]['id'], $ingreso['username'])) $_SESSION['mensaje']="La Deuda se CANCELÓ correctamente";
							else $_SESSION['mensaje']="La DEUDA NO se CANCELÓ correctamente";
						}
					} else {
						$_SESSION['error']="El RIF NO se ACTUALIZÓ correctamente.";
					}
															
				} else $_SESSION['error']="El INGRESO no se registró";
			}

			if ($accion == 'voucher') {
				$objIngreso2 = new IngresosModel();
				if( $objIngreso2->guardar_ingreso_desde_voucher($ingreso) ) {
					$_SESSION['mensaje']="El INGRESO se registró correctamente";

					//ACTUALIZAMOS EL SALDO DEL VOUCHER
					require_once "../Modelos/VouchersModel.php";
					$objVoucher = new VouchersModel();
					if($objVoucher->actualizar_saldo($vouchers[$indice_voucher2]['id'], $vouchers[$indice_voucher2]['saldo'])) {
						$_SESSION['mensaje']="El VOUCHER se ACTUALIZÓ correctamente.";
	
						//ACTUALIZAMOS EL ESTADO DE LA DEUDA SI ESTA SE HA CANCELADO
						if($deudas[$indice_deuda]['cancelado']==1){
							$deudaCancelada = TRUE;
							$objDeuda = new DeudasModel();
							if ($objDeuda->cancelar_deuda($deudas[$indice_deuda]['id'], $ingreso['username'])) $_SESSION['mensaje']="La DEUDA se CANCELÓ correctamente";
							else $_SESSION['error']="La DEUDA NO se ACTUALIZÓ correctamente";
						}
					} else {
						$_SESSION['error']="El VOUCHER NO se ACTUALIZÓ correctamente.";
					}
															
				} else $_SESSION['error']="El INGRESO DE VOUCHER no se registró";
			}

			//SI LA CUENTA QUE SE CANCELO ES DE UNA MATRICULA ENTONCES ACTUALIZAMOS EL ESTADO DE LA MATRICULA A 4
			if ($deudaCancelada) {
				if ($deudas[$indice_deuda]['cuenta']=="Matricula") {
					require_once "../Modelos/MatriculasModel.php";
					$objMatricula = new MatriculasModel();
					$objMatricula->actualizar_paso_matricula(4, $deudas[$indice_deuda]['matricula_id']);
				}
			}

			//ARMAMOS EL ESTADO DE CUENTA DEL ALUMNO: EMPEZAMOS BUSCAMOS LAS DEUDAS DEL ALUMNO
			$objDeuda3 = new DeudasModel();
			$deudas = $objDeuda3->deuda_por_usuario($_SESSION['alumnosCaja'][$llave]['id']);

			//POR CADA DEUDA BUSCAMOS LOS INGRESOS REGISTRADOS
			require_once "../Modelos/RegistrosDeVentasModel.php";
			require_once "../Modelos/ComprobantesModel.php";
			for ($i=0; $i < count($deudas); $i++) { 
				$objIngreso3 = new IngresosModel();
				$ingresos = $objIngreso3->ingresos_por_deuda_y_usuario($deudas[$i]['id'], $_SESSION['alumnosCaja'][$llave]['id']);
				$deudas[$i]['ingresos']=$ingresos;
				//POR CADA INGRESO BUSCAMOS SI TIENE REGISTROS DE VENTA
				for ($j=0; $j < count($deudas[$i]['ingresos']); $j++ ){
					$deudas[$i]['ingresos'][$j]['tipo1']="externo";
					if($deudas[$i]['ingresos'][$j]['registrodeventa_id']=="" ) {
						$deudas[$i]['ingresos'][$j]['registrodeventa'] = array();
						$objComprobante = new ComprobantesModel();
						if($objComprobante->si_el_comprobante_es_interno($deudas[$i]['ingresos'][$j]['serie']) ){
							$deudas[$i]['ingresos'][$j]['tipo1']="interno";
						}
					} 
					else {
						$objRegistrosDeVentas = new RegistrosDeVentasModel();
						$registroDeVenta = $objRegistrosDeVentas->registro_de_venta_por_deuda($deudas[$i]['ingresos'][$j]['registrodeventa_id']);
						$deudas[$i]['ingresos'][$j]['registrodeventa'] = $registroDeVenta;	
					}
				}
			}

			//FIN DE LA GENERACION DEL ESTADO DE CUENTA
			
			$_SESSION['deudas'] = $deudas;
			$_SESSION['indice_comprobante_interno2'] = NULL;
			$_SESSION['rifs'] = NULL;
			$_SESSION['indice_rif2'] = NULL;
			$_SESSION['vouchers'] = NULL;
			$_SESSION['indice_voucher2'] = NULL;
			
			header("Location: ../../src/Vistas/vista.php");  
			break;


		case 'Abrir_Cerrar':
			$vista = "../../src/Vistas/caja/abrir_cerrar.php";
			session_start();
			$_SESSION['vista'] = $vista;
			
			require_once "../Modelos/StandsModel.php";
			
			if(isset($_POST['accion'])){
				if($_POST['accion']=="Abrir"){
					$objStand = new StandsModel();
					if($objStand->abrir_stand($_POST['stand_id'],$_SESSION['user'][0]['username'])){
						echo "abierto";
					} else {
						echo "no se pudo";
					}
					
				}
				if($_POST['accion']=="Cerrar"){
					$objStand = new StandsModel();
					$objStand->cerrar_stand($_POST['stand_id'],$_SESSION['user'][0]['username']);

					//RESETEAMOS LA FECHA DEL SISTEMA
					date_default_timezone_set('America/Lima');
					setlocale(LC_TIME, "Spanish");		
					$hoy = strftime("%Y-%m-%d"); // FECHA PARA EL CALCULO DE TODAS LAS OPERACIONES
					$_SESSION['fechaSistema'] = $hoy;
				}
			}
			$objStandA = new StandsModel();
			$objStandC = new StandsModel();
			$standCerrados = $objStandA->stands_cerrados();
			$standAbiertos = $objStandC->stands_abiertos();
			$_SESSION['standAbiertos'] = $standAbiertos;
			$_SESSION['standCerrados'] = $standCerrados;
			
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