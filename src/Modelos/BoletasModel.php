<?php  
require_once "Model.php";

class BoletasModel extends Model {
	     
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
	
	public function comprobantes_por_fecha($fecha){
		$sql = "SELECT id,personajuridica_id,user_id,comprobante_id,serie,correlativo,DATE_FORMAT(fecha, '%d/%m/%Y') fecha,total_gravado,total_inafecto,total_exonerado,total_gratuito,total_exportacion,total_descuento,subtotal,por_igv,total_igv,total_isc,total_otr_imp,total,anulado,created,modified,username FROM registro_ventas WHERE fecha like '%$fecha%' ";
		//$sql = "SELECT * FROM registro_ventas  ";
        $result = $this->conexion->query($sql); 
        $comprobante = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $comprobante; 
    }

    public function comprobantes_por_mes($mes){
		$sql = "SELECT id,personajuridica_id,user_id,comprobante_id,serie,correlativo,DATE_FORMAT(fecha, '%d/%m/%Y') fecha,total_gravado,total_inafecto,total_exonerado,total_gratuito,total_exportacion,total_descuento,subtotal,por_igv,total_igv,total_isc,total_otr_imp,total,anulado,created,modified,username FROM registro_ventas WHERE fecha like '%$mes%' ";
		//$sql = "SELECT * FROM registro_ventas  ";
        $result = $this->conexion->query($sql); 
        $comprobante = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $comprobante; 
    }

	public function guardar_boleta($boleta){
		$stand_id = $boleta['stand_id'];
		$user_id = $boleta['user_id'];
		$serie = $boleta['serie'];
		$correlativo = $boleta['correlativo'];
		$fecha = $boleta['fecha'];
		$hora = $boleta['hora'];
		$deuda_id = $boleta['deuda_id'];
		$detalle = $boleta['detalle'];
		$monto = $boleta['monto'];
		$descuento = $boleta['descuento'];
		$total = $boleta['total'];
		$efectivo = $boleta['efectivo'];
		$vuelto = $boleta['vuelto'];
		$username = $boleta['username'];
		$comentario = $boleta['comentario'];
		$anulado = $boleta['anulado'];
		$observacion = $boleta['observacion'];

		$sql ="INSERT INTO boletas (stand_id, user_id, serie, correlativo, fecha, hora, deuda_id, detalle, monto, descuento, total, efectivo, vuelto, comentario, username, created, modified, anulado, observacion ) 
		VALUES ($stand_id, $user_id, '$serie', $correlativo, '$fecha', '$hora', $deuda_id, '$detalle', $monto, $descuento, $total, $efectivo, $vuelto ,'$comentario', '$username', NOW(), NOW(), $anulado, '$observacion' ) ";

		$insert = $this->conexion->query($sql); 

		if($insert) return true;
		else return false;
		
		parent::cerrar();
	} 

    public function boletas_por_deuda_y_usuario($deuda_id, $user_id){
		$sql = "SELECT * FROM boletas WHERE user_id=$user_id AND deuda_id=$deuda_id AND anulado=0";
        $result = $this->conexion->query($sql); 
        $boletas = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $boletas; 
    }
} 
?> 
