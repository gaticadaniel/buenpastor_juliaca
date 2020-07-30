<?php  
require_once "Model.php";

class DeudasModel extends Model {
	     
    public function __construct(){ 
        parent::__construct(); 
    } 

	public function get_datos_comprobante($rv_id){
		$sql = " SELECT DISTINCT '20406231594'                              empresa_ruc, 
		'ASOC.EDUC.DE G.N.E.COL.DE CIEN.BUEN PAST' EMPRESA_RAZON_SOCIAL, 
'JR. SAN MARTIN NRO. 421 INT. 02 CERCADO (COSTADO DE LA TELEFONICA) PUNO - SAN ROMAN - JULIACA' 
								   EMPRESA_DIRECCION, 
''                                         CLIENTE_RUC, 
U.dni                                      AS cliente_dni, 
concat(U.nombres,' ',U.apellido_paterno,' ', U.apellido_materno)                                  AS cliente_nombre, 
''                                         CLIENTE_CODIGO_UBIGEO,  
''                                         CLIENTE_DEPARTAMENTO, 
''                                         CLIENTE_PROVINCIA, 
''                                         CLIENTE_DISTRITO, 
U.direccion                                AS cliente_direccion, 
rv.serie, 
LPAD(rv.correlativo,8,'0')                 AS numeracion, 
DATE_FORMAT(rv.fecha, '%Y-%m-%d')          AS fecha_documento, 
rv.id                                      AS id_documento, 
''                                         motivo, 
rv.comprobante_id                          comprobante_id, 
rv.total_gravado                           AS total_gravadas, 
rv.total_gratuito                          AS total_gratuitas, 
rv.total_exonerado                         AS total_exoneradas, 
rv.total_inafecto                          AS total_inafecta, 
rv.total_otr_imp                           AS total_otr_imp, 
rv.total_descuento                         AS total_descueto, 
rv.total                                   AS total, 
rv.total_igv                               AS total_igv 
FROM   ingresos I, 
registro_ventas rv, 
users U 
WHERE  rv.id = I.registrodeventa_id 
AND I.user_id = U.id 
AND rv.id  =$rv_id ";
        $result = $this->conexion->query($sql); 
        $rv = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $rv; 
	}
	

	public function get_datos_comprobante_det($rv_id){
		$sql = "  SELECT '1'     CANTIDAD, 
		total   AS total, 
		total   AS precio, 
		'0'     igv, 
		'30'    tipo_igv, 
		detalle AS detalle, 
		id      AS codigo_detalle, 
		monto   AS precio_sin_igv 
 FROM   ingresos 
 WHERE  registrodeventa_id =  $rv_id ";
        $result = $this->conexion->query($sql); 
        $rv = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $rv; 
	}

    public function deudas_por_grupo_y_usuario($user_id, $grupo_id){
		$sql = "SELECT D.*
				FROM deudas D, subcuentas SC, grupos_subcuentas GSC, grupos G 
				WHERE
					D.user_id=$user_id AND
				    D.subcuenta_id=SC.id AND
					SC.activo=1 AND
				    SC.id=GSC.subcuenta_id AND
				    GSC.activo=1 AND
				    GSC.grupo_id=G.id AND
				    G.id=$grupo_id
				ORDER BY
					D.fecha_de_cobro";
        $result = $this->conexion->query($sql); 
        $deudas = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $deudas; 
    }

    public function deudas_pendientes_por_usuario($user_id){
		$sql = "SELECT detalle, fecha_vencimiento FROM deudas WHERE user_id=$user_id AND activo=1 AND cancelado=0 ORDER BY fecha_vencimiento";
        $result = $this->conexion->query($sql); 
        $deudas = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $deudas; 
    }

	public function insertar($user_id, $pago, $username, $matricula_id, $comentario){

		$cuenta=$pago['cuenta'];
		$subcuenta_id=$pago['subcuenta_id'];
		$detalle=$pago['detalle'];
		$fecha_de_cobro=$pago['fecha_de_cobro'];
		$monto=$pago['monto'];
		$fecha_vencimiento=$pago['fecha_vencimiento'];
		$descuento_pago_oportuno=$pago['descuento_pago_oportuno'];

		$sql ="INSERT INTO deudas (user_id, cuenta, subcuenta_id, detalle, fecha_de_cobro, monto, fecha_vencimiento, descuento_pago_oportuno, activo, cancelado, username, created, modified, matricula_id, comentario ) 
		VALUES ($user_id, '$cuenta', $subcuenta_id, '$detalle', '$fecha_de_cobro', $monto, '$fecha_vencimiento', $descuento_pago_oportuno, 1, 0, '$username', NOW(), NOW(), $matricula_id, '$comentario') ";

		$insert = $this->conexion->query($sql); 
		if($insert) return true;
		else return false;
		parent::cerrar();
	}

	public function buscar_id($user_id, $pago, $username, $matricula_id){

		$cuenta=$pago['cuenta'];
		$detalle=$pago['detalle'];
		$fecha_de_cobro=$pago['fecha_de_cobro'];
		$monto=$pago['monto'];
		$fecha_vencimiento=$pago['fecha_vencimiento'];
		$descuento_pago_oportuno=$pago['descuento_pago_oportuno'];

		$sql ="SELECT id 
				FROM deudas 
				WHERE user_id=$user_id AND
					  cuenta='$cuenta' AND
					  detalle='$detalle' AND
					  fecha_de_cobro='$fecha_de_cobro' AND
					  monto=$monto AND
					  fecha_vencimiento='$fecha_vencimiento' AND
					  descuento_pago_oportuno=$descuento_pago_oportuno AND
					  activo=1 AND
					  cancelado=0 AND
					  matricula_id=$matricula_id AND
					  username='$username'";

        $result = $this->conexion->query($sql); 
        $id = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $id; 
	}

    public function deuda_por_usuario($user_id){
		$sql = "SELECT * FROM deudas WHERE user_id=$user_id AND activo=1 ORDER BY fecha_de_cobro";
        $result = $this->conexion->query($sql); 
        $deudas = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $deudas; 
    }
	
	public function cancelar_deuda($deuda_id, $username){
		$sql ="UPDATE deudas SET cancelado=1, modified=now(), username='$username' WHERE id=$deuda_id ";
		$update = $this->conexion->query($sql); 
		if($update) return true;
		else return false;
		parent::cerrar();
	} 

	public function anular_cancelado($deuda_id, $username){
		$sql ="UPDATE deudas SET cancelado=0, modified=now(), username='$username' WHERE id=$deuda_id ";
		$update = $this->conexion->query($sql); 
		if($update) return true;
		else return false;
		parent::cerrar();
	} 

    public function solicitar_id(){
		$sql = "SELECT MAX(id) FROM deudas";
        $result = $this->conexion->query($sql); 
        $nuevoId = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $nuevoId; 
    }

    public function guardar_deuda($deuda){
			
		$id = $deuda['id'];
		$user_id = $deuda['user_id'];
		$cuenta = $deuda['cuenta'];
		$subcuenta_id = $deuda['subcuenta_id'];
		$detalle = $deuda['detalle'];
		$fecha_de_cobro = $deuda['fecha_de_cobro'];
		$monto = $deuda['monto'];
		$fecha_vencimiento = $deuda['fecha_vencimiento'];
		$descuento_pago_oportuno = $deuda['descuento_pago_oportuno'];
		$username = $deuda['username'];
		$matricula_id = $deuda['matricula_id'];
		$comentario = $deuda['comentario'];
		$cancelado = $deuda['cancelado'];

		$sql ="INSERT INTO deudas (id, user_id, cuenta, subcuenta_id, detalle, fecha_de_cobro, monto, fecha_vencimiento, descuento_pago_oportuno, activo, cancelado, username, created, modified, matricula_id, comentario ) 
		VALUES ($id, $user_id, '$cuenta', $subcuenta_id, '$detalle', '$fecha_de_cobro', $monto, '$fecha_vencimiento', $descuento_pago_oportuno, 1, $cancelado, '$username', NOW(), NOW(), $matricula_id, '$comentario') ";

		$insert = $this->conexion->query($sql); 
		if($insert) return true;
		else return false;
		parent::cerrar();
	}
    	
}
?> 