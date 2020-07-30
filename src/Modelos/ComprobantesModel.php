<?php  
require_once "Model.php"; 

class ComprobantesModel extends Model{
	     
    public function __construct(){ 
        parent::__construct(); 
    } 

	public function stands_pendientes_de_cierre(){
		$sql = "SELECT * FROM stands WHERE id IN (SELECT DISTINCT stand_id FROM boletas WHERE cierre_id IS NULL)";
        $result = $this->conexion->query($sql); 
        $stands = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $stands; 
    }
    public function stands_por_fecha_usuario($fecha, $username){
        $sql = "SELECT DISTINCT S.* FROM boletas B, stands S WHERE B.fecha='$fecha' AND B.username='$username' AND B.stand_id=S.id";
        $result = $this->conexion->query($sql); 
        $stands = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $stands; 
    }

    public function stands_cerrados(){
        $sql = "SELECT * FROM stands WHERE abierto=0";
        $result = $this->conexion->query($sql); 
        $stands = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $stands; 
    }

    public function stands_abiertos(){
        $sql = "SELECT * FROM stands WHERE abierto=1";
        $result = $this->conexion->query($sql); 
        $stands = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $stands; 
    }

	public function abrir_stand($stand_id, $username){
		$sql ="UPDATE stands SET abierto=1, modified=now(), username='$username' WHERE id=$stand_id ";
		$update = $this->conexion->query($sql); 
		if($update) return true;
		else return false;
		parent::cerrar();
	} 

	public function cerrar_stand($stand_id, $username){
		$sql ="UPDATE stands SET abierto=0, modified=now(), username='$username' WHERE id=$stand_id ";
		$update = $this->conexion->query($sql); 
		if($update) return true;
		else return false;
		parent::cerrar();
	} 

	public function incrementar_numeracion($stand_id, $username){
		$sql ="UPDATE stands SET numero=numero+1, username='$username', modified=now() WHERE id=$stand_id ";
		$update = $this->conexion->query($sql); 
		if($update) return true;
		else return false;
		parent::cerrar();
	} 
	
	public function buscar_numero($stand_id){
        $sql = "SELECT numero FROM stands WHERE id=$stand_id ";
        $result = $this->conexion->query($sql); 
        $stand = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $stand; 
    }
    
    public function comprobantes_activos_por_usuario($user_id, $tipo1){
        $sql = "SELECT * FROM comprobantes WHERE estado=1 AND user_id=$user_id AND tipo1='$tipo1'";
        $result = $this->conexion->query($sql); 
        $comprobantes = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $comprobantes; 
    }

    public function si_el_comprobante_es_interno($serie){
        $sql = "SELECT * FROM comprobantes WHERE serie='$serie' AND tipo1='interno'";
        $result = $this->conexion->query($sql); 
        $comprobantes = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        if(count($comprobantes)==1) return TRUE;
		else return FALSE;
    }

} 
?> 