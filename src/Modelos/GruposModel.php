<?php  
require_once "Model.php"; 

class GruposModel extends Model {
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function grupos_por_periodo($periodo_id){
        $sql = "
	        SELECT GR.id,GR.comentario, N.nivel, G.grado, S.seccion, A.ambiente 
			FROM  grupos GR, nivels N, grados G, seccions S, ambientes A 
			WHERE 
				GR.periodo_id=$periodo_id AND 
			    GR.nivel_id=N.id AND
			    GR.grado_id=G.id AND
			    GR.seccion_id=S.id AND
			    GR.ambiente_id=A.id
        ";
        	 
        $result = $this->conexion->query($sql); 
         
        $grupos = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $grupos; 
    }
    
    public function mdl_mostrar_grupos(){
        $sql = "
	        SELECT * FROM  grupos ";
        	 
        $result = $this->conexion->query($sql); 
         
        $grupos = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $grupos; 
    }
    
    /*=============================================
	MOSTRAR GRUPOS POR PERIODOS Y NIVEL
	=============================================*/
    public function mdlVerGruposPorPeriodoNivel($vPeriodo,$vNivel){
         
        $sql = "SELECT g.*, s.seccion AS secion FROM grupos g,seccions s where periodo_id = '$vPeriodo' 
        AND nivel_id = '$vNivel' AND g.seccion_id = s.id;";
         
        $result = $this->conexion->query($sql);         
        $resultad = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar(); 
        return $resultad; 
    }

} 

?> 
