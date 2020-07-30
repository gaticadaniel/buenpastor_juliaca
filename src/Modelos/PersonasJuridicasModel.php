<?php  
require_once "Model.php"; 

class PersonasJuridicasModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function personas_juridicas_relacionadas_al_estudiante($user_id){
        	
        $sql = "SELECT PJ.* FROM personasjuridicas PJ, registro_ventas RV, ingresos I WHERE PJ.id=RV.personajuridica_id AND RV.id=I.registrodeventa_id AND I.user_id=$user_id ";
        $result = $this->conexion->query($sql); 
        $respuesta = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $respuesta; 
    }

	public function guardar_persona_juridica($personaJuridica) {

		$ruc = $personaJuridica['ruc'];
		$razon_social = $personaJuridica['razon_social'];
		$direccion = $personaJuridica['direccion'];
		$telefono = $personaJuridica['telefono'];
		$ubigeo = $personaJuridica['ubigeo'];
		$email = $personaJuridica['email'];
		$username = $personaJuridica['username'];

		$sql ="INSERT INTO personasjuridicas (ruc, razon_social, direccion, telefono, email, ubigeo, created, modified, username ) 
		VALUES ($ruc, '$razon_social', '$direccion', $telefono, '$email', $ubigeo, NOW(), NOW(), '$username') ";

		$insert = $this->conexion->query($sql); 

		if($insert){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
	} 
    
    public function buscar_por_ruc($ruc){
        	
        $sql = "SELECT * FROM personasjuridicas WHERE ruc=$ruc ";
        $result = $this->conexion->query($sql); 
        $respuesta = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $respuesta; 
    }
	
	public function actualizar_por_ruc($personaJuridica){

		$ruc = $personaJuridica['ruc'];
		$razon_social = $personaJuridica['razon_social'];
		$direccion = $personaJuridica['direccion'];
		$telefono = $personaJuridica['telefono'];
		$ubigeo = $personaJuridica['ubigeo'];
		$email = $personaJuridica['email'];
		$username = $personaJuridica['username'];

		$sql ="UPDATE personasjuridicas SET razon_social='$razon_social', direccion='$direccion', telefono=$telefono, ubigeo=$ubigeo, email='$email', modified=now(), username='$username' WHERE ruc='$ruc' ";

		$update = $this->conexion->query($sql);
		 
		if($update) return true;
		else return false;
		parent::cerrar();
	} 

	public function buscar_por_id($personajuridica_id){
			
		$sql ="SELECT * FROM personasjuridicas WHERE id=$personajuridica_id ";
		
		$result = $this->conexion->query($sql); 
		
		$user = $result->fetch_all(MYSQLI_ASSOC);
		
		parent::cerrar();
		
		return $user;
	} 

} 
?> 
