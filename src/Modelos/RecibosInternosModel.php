<?php  
require_once "Model.php"; 

class RecibosInternosModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

	//SELECCIONA LOS RECIBOS QUE TIENEN SALDO
    public function rif_cerrados_con_saldo_mayor_a_cero_para_alumnos(){
        $result = $this->conexion->query("SELECT * FROM recibosinternos WHERE saldo>0 AND ingresos_alumno=1 AND anulado=0 AND cierre_id IS NOT NULL"); 
        $recibosInternos = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $recibosInternos; 
    }

    public function actualizar_saldo($id, $saldo){
        $sql = "UPDATE recibosinternos SET saldo = $saldo WHERE id = $id "; 
		$update = $this->conexion->query($sql); 
		if($update) return true;
		else return false;
		parent::cerrar();
    }

	public function series_de_rifs_pendientes_de_cierre(){
		$sql = "SELECT DISTINCT serie FROM recibosinternos WHERE cierre_id IS NULL";
        $result = $this->conexion->query($sql); 
        $recibosInternos = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $recibosInternos; 
    }

} 
?> 