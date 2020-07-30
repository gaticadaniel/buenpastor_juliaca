<?php  
require_once "Model.php"; 

class RegistrosDeVentasModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

	//SELECCIONA LOS RECIBOS QUE TIENEN SALDO
    public function registro_de_venta_por_deuda($registrodeventa_id){
        $result = $this->conexion->query("SELECT * FROM registro_ventas WHERE anulado=0 AND id=$registrodeventa_id"); 
        $registroDeVenta = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $registroDeVenta; 
    }

    public function rv_por_usuario($user_id){
	    $result = $this->conexion->query("SELECT DISTINCT RV.* FROM registro_ventas RV, ingresos I, users U WHERE RV.anulado=0 AND RV.id=I.registrodeventa_id AND I.user_id=U.id AND U.id=$user_id ORDER BY RV.fecha DESC " ); 
        $registroDeVenta = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $registroDeVenta; 
    }

   public function obtener_ultimo_correlativo($serie){
		$sql = "SELECT MAX(correlativo) FROM registro_ventas WHERE serie='$serie'";
        $result = $this->conexion->query($sql); 
        $correlativo = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $correlativo; 
    }

	public function guardar_registro_factura($registroDeVenta){
		$personajuridica_id = $registroDeVenta['personajuridica_id'];
		$user_id = $registroDeVenta['user_id'];
		$comprobante_id = $registroDeVenta['comprobante_id'];
		$serie = $registroDeVenta['serie'];
		$correlativo = $registroDeVenta['correlativo'];
//		$fecha = $registroDeVenta['fecha'];				USAR LA FUNCION NOW()
		$total_gravado = $registroDeVenta['total_gravado'];
		$total_inafecto = $registroDeVenta['total_inafecto'];
		$total_exonerado = $registroDeVenta['total_exonerado'];
		$total_gratuito = $registroDeVenta['total_gratuito'];
		$total_exportacion = $registroDeVenta['total_exportacion'];
		$total_descuento = $registroDeVenta['total_descuento'];
		$subtotal = $registroDeVenta['subtotal'];
		$por_igv = $registroDeVenta['por_igv'];
		$total_igv = $registroDeVenta['total_igv'];
		$total_isc = $registroDeVenta['total_isc'];
		$total_otr_imp = $registroDeVenta['total_otr_imp'];
		$total = $registroDeVenta['total'];
		$anulado = $registroDeVenta['anulado'];
		$username = $registroDeVenta['username'];
			
		$sql ="INSERT INTO registro_ventas (personajuridica_id, comprobante_id, serie, correlativo, fecha, total_gravado, total_inafecto, total_exonerado, total_gratuito, total_exportacion, total_descuento, subtotal, por_igv, total_igv, total_isc, total_otr_imp, total, anulado, created, modified, username) 
						VALUES ( $personajuridica_id , $comprobante_id, '$serie', $correlativo, NOW(), $total_gravado, $total_inafecto, $total_exonerado, $total_gratuito, $total_exportacion, $total_descuento, $subtotal, $por_igv, $total_igv, $total_isc, $total_otr_imp, $total, $anulado, NOW(), NOW(), '$username') ";
		$insert = $this->conexion->query($sql); 
		if($insert) return true;
		else return false;
		parent::cerrar();
	} 

	public function guardar_registro_boleta($registroDeVenta){
		$personajuridica_id = $registroDeVenta['personajuridica_id'];
		$user_id = $registroDeVenta['user_id'];
		$comprobante_id = $registroDeVenta['comprobante_id'];
		$serie = $registroDeVenta['serie'];
		$correlativo = $registroDeVenta['correlativo'];
//		$fecha = $registroDeVenta['fecha'];				USAR LA FUNCION NOW()
		$total_gravado = $registroDeVenta['total_gravado'];
		$total_inafecto = $registroDeVenta['total_inafecto'];
		$total_exonerado = $registroDeVenta['total_exonerado'];
		$total_gratuito = $registroDeVenta['total_gratuito'];
		$total_exportacion = $registroDeVenta['total_exportacion'];
		$total_descuento = $registroDeVenta['total_descuento'];
		$subtotal = $registroDeVenta['subtotal'];
		$por_igv = $registroDeVenta['por_igv'];
		$total_igv = $registroDeVenta['total_igv'];
		$total_isc = $registroDeVenta['total_isc'];
		$total_otr_imp = $registroDeVenta['total_otr_imp'];
		$total = $registroDeVenta['total'];
		$anulado = $registroDeVenta['anulado'];
		$username = $registroDeVenta['username'];
			
		$sql ="INSERT INTO registro_ventas (user_id, comprobante_id, serie, correlativo, fecha, total_gravado, total_inafecto, total_exonerado, total_gratuito, total_exportacion, total_descuento, subtotal, por_igv, total_igv, total_isc, total_otr_imp, total, anulado, created, modified, username) 
						VALUES ( $user_id , $comprobante_id, '$serie', $correlativo, NOW(), $total_gravado, $total_inafecto, $total_exonerado, $total_gratuito, $total_exportacion, $total_descuento, $subtotal, $por_igv, $total_igv, $total_isc, $total_otr_imp, $total, $anulado, NOW(), NOW(), '$username') ";
		$insert = $this->conexion->query($sql); 
		if($insert) return true;
		else return false;
		parent::cerrar();
	} 

	public function buscar_id_de_registro_por_serie_y_correlativo($serie, $correlativo){
	    $result = $this->conexion->query("SELECT id FROM registro_ventas WHERE serie='$serie' AND correlativo=$correlativo "); 
        $idRegistroDeVenta = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $idRegistroDeVenta; 
    }
	
} 
?> 