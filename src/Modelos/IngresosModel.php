<?php  
require_once "Model.php";

class IngresosModel extends Model {
	     
    public function __construct(){ 
        parent::__construct(); 
    } 

	public function cerrar_boleta($idBoleta, $cierre_id){
		$sql ="UPDATE boletas SET cierre_id=$cierre_id, modified=now() WHERE id=$idBoleta";
		$update = $this->conexion->query($sql); 
		if($update) 
			$resutado=true;
		else 
			$resultado=false;
		parent::cerrar();
		return $resultado;
	} 

    public function usernames_con_boletas_pendientes_de_cierre(){
		$sql = "SELECT DISTINCT username FROM boletas WHERE cierre_id IS NULL";
        $result = $this->conexion->query($sql); 
        $username = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $username; 
    }

    public function boletas_pendientes_stand_fecha_usuario($stand_id, $fecha_id, $usuario_id){
		$sql = "SELECT B.*, S.serie_maquina, U.nombres, U.apellido_paterno, U.apellido_materno FROM boletas B, stands S, users U WHERE B.cierre_id IS NULL AND B.stand_id=$stand_id AND B.fecha='$fecha_id' AND B.username='$usuario_id' AND B.stand_id=S.id AND B.user_id=U.id";
        $result = $this->conexion->query($sql); 
        $username = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $username; 
    }

    public function usuarios_pendientes_por_stand_y_fecha($stand_id, $fecha_id){
		$sql = "SELECT DISTINCT username FROM boletas WHERE cierre_id IS NULL AND stand_id=$stand_id AND fecha='$fecha_id'";
        $result = $this->conexion->query($sql); 
        $username = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $username; 
    }

    public function fechas_pendientes_cierre_por_stand($stand_id){
		$sql = "SELECT DISTINCT fecha FROM boletas WHERE cierre_id IS NULL AND stand_id=$stand_id ORDER BY fecha ASC";
        $result = $this->conexion->query($sql); 
        $fechas = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $fechas; 
    }

	public function anular_boleta_por_id($idBoleta){
		$sql ="UPDATE boletas SET anulado=1, modified=now() WHERE id=$idBoleta";
		$update = $this->conexion->query($sql); 
		if($update) return true;
		else return false;
		parent::cerrar();
	} 

    public function boletas_por_fecha_y_usuario($fecha, $username){
		$sql = "SELECT * FROM boletas WHERE fecha='$fecha' AND username='$username' ";
        $result = $this->conexion->query($sql); 
        $boletas = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $boletas; 
    }

	public function guardar_ingreso_desde_voucher($ingreso){
		$cierre_id = $ingreso['cierre_id'];
		$comprobante_id = $ingreso['comprobante_id'];
		$voucher_id = $ingreso['voucher_id'];
		$user_id = $ingreso['user_id'];
		$serie = $ingreso['serie'];
		$correlativo = $ingreso['correlativo'];
		$fecha = $ingreso['fecha'];
		$hora = $ingreso['hora'];
		$deuda_id = $ingreso['deuda_id'];
		$detalle = $ingreso['detalle'];
		$monto = $ingreso['monto'];
		$descuento = $ingreso['descuento'];
		$total = $ingreso['total'];
		$efectivo = $ingreso['efectivo'];
		$vuelto = $ingreso['vuelto'];
		$comentario = $ingreso['comentario'];
		$observacion = $ingreso['observacion'];
		$anulado = $ingreso['anulado'];
		$username = $ingreso['username'];

		$sql ="INSERT INTO ingresos (cierre_id, comprobante_id, voucher_id, user_id, serie, correlativo, fecha, hora, deuda_id, detalle, monto, descuento, total, efectivo, vuelto, comentario, observacion, anulado, created, modified, username) 
							VALUES ($cierre_id, $comprobante_id, $voucher_id, $user_id, '$serie', $correlativo, '$fecha', '$hora', $deuda_id, '$detalle', $monto, $descuento, $total, $efectivo, $vuelto ,'$comentario', '$observacion', $anulado, NOW(), NOW(), '$username') ";
		$insert = $this->conexion->query($sql); 
		if($insert) return true;
		else return false;
		parent::cerrar();
	} 

	public function guardar_ingreso_desde_rif($ingreso){
		$cierre_id = $ingreso['cierre_id'];
		$comprobante_id = $ingreso['comprobante_id'];
		$recibointerno_id = $ingreso['recibointerno_id'];
		$user_id = $ingreso['user_id'];
		$serie = $ingreso['serie'];
		$correlativo = $ingreso['correlativo'];
		$fecha = $ingreso['fecha'];
		$hora = $ingreso['hora'];
		$deuda_id = $ingreso['deuda_id'];
		$detalle = $ingreso['detalle'];
		$monto = $ingreso['monto'];
		$descuento = $ingreso['descuento'];
		$total = $ingreso['total'];
		$efectivo = $ingreso['efectivo'];
		$vuelto = $ingreso['vuelto'];
		$comentario = $ingreso['comentario'];
		$observacion = $ingreso['observacion'];
		$anulado = $ingreso['anulado'];
		$username = $ingreso['username'];

		$sql ="INSERT INTO ingresos (cierre_id, comprobante_id, recibointerno_id, user_id, serie, correlativo, fecha, hora, deuda_id, detalle, monto, descuento, total, efectivo, vuelto, comentario, observacion, anulado, created, modified, username) 
							VALUES ($cierre_id, $comprobante_id, $recibointerno_id, $user_id, '$serie', $correlativo, '$fecha', '$hora', $deuda_id, '$detalle', $monto, $descuento, $total, $efectivo, $vuelto ,'$comentario', '$observacion', $anulado, NOW(), NOW(), '$username') ";
		$insert = $this->conexion->query($sql); 
		if($insert) return true;
		else return false;
		parent::cerrar();
	} 

	public function guardar_ingreso_desde_rie($ingreso){
		$comprobante_id = $ingreso['comprobante_id'];
		$user_id = $ingreso['user_id'];
		$serie = $ingreso['serie'];
		$correlativo = $ingreso['correlativo'];
		$fecha = $ingreso['fecha'];
		$hora = $ingreso['hora'];
		$deuda_id = $ingreso['deuda_id'];
		$detalle = $ingreso['detalle'];
		$monto = $ingreso['monto'];
		$descuento = $ingreso['descuento'];
		$total = $ingreso['total'];
		$efectivo = $ingreso['efectivo'];
		$vuelto = $ingreso['vuelto'];
		$comentario = $ingreso['comentario'];
		$observacion = $ingreso['observacion'];
		$anulado = $ingreso['anulado'];
		$username = $ingreso['username'];

		$sql ="INSERT INTO ingresos (comprobante_id, user_id, serie, correlativo, fecha, hora, deuda_id, detalle, monto, descuento, total, efectivo, vuelto, comentario, observacion, anulado, created, modified, username) 
							VALUES ($comprobante_id, $user_id, '$serie', $correlativo, '$fecha', '$hora', $deuda_id, '$detalle', $monto, $descuento, $total, $efectivo, $vuelto ,'$comentario', '$observacion', $anulado, NOW(), NOW(), '$username') ";
		$insert = $this->conexion->query($sql); 
		if($insert) return true;
		else return false;
		parent::cerrar();
	} 
	
    public function ingresos_por_deuda_y_usuario($deuda_id, $user_id){
		$sql = "SELECT * FROM ingresos WHERE user_id=$user_id AND deuda_id=$deuda_id AND anulado=0";
        $result = $this->conexion->query($sql); 
        $ingresos = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $ingresos; 
    }

    public function obtener_ultimo_correlativo($serie){
		$sql = "SELECT MAX(correlativo) FROM ingresos WHERE serie='$serie'";
        $result = $this->conexion->query($sql); 
        $correlativo = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $correlativo; 
    }

    public function ingresos_por_id($id){
		$sql = "SELECT * FROM ingresos WHERE id=$id AND anulado=0";
        $result = $this->conexion->query($sql); 
        $ingresos = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $ingresos; 
    }
      
	public function actualizar_registrodeventa_id( $id, $registroDeVenta_id) {
		$sql ="UPDATE ingresos SET registrodeventa_id=$registroDeVenta_id WHERE id=$id";
		$update = $this->conexion->query($sql); 
		if($update) return true;
		else return false;
		parent::cerrar();
	} 	

	public function ingresos_externos_antiguos_por_usuario($user_id){
		$sql = "SELECT * FROM ingresos WHERE user_id=$user_id AND comprobante_id IN (SELECT id FROM comprobantes WHERE tipo1='externo') ORDER BY ingresos.fecha DESC";
        $result = $this->conexion->query($sql); 
        $ingresos = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $ingresos; 
    }

	public function series_de_ries_pendientes_de_cierre(){
		$sql = "SELECT DISTINCT comprobante_id, serie, username FROM ingresos WHERE cierre_id IS NULL";
        $result = $this->conexion->query($sql); 
        $recibosInternos = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $recibosInternos; 
    }

    public function fechas_pendientes_cierre($serie){
		$sql = "SELECT DISTINCT fecha FROM ingresos WHERE cierre_id IS NULL AND serie='$serie' ORDER BY fecha ASC";
        $result = $this->conexion->query($sql); 
        $fechas = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $fechas; 
    }

    public function ingresos_pendientes_de_cierre_por_serie_y_fecha($serie, $fecha){
		$sql = "SELECT * FROM ingresos WHERE serie='$serie' AND fecha='$fecha' AND cierre_id IS NULL";
        $result = $this->conexion->query($sql); 
        $username = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $username; 
    }
} 
?> 