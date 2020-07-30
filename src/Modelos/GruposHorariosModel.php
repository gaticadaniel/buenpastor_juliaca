<?php  
require_once "Model.php"; 

class GruposHorariosModel extends Model 
{
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function fechas_por_grupo($grupo_id){
        $sql = "
			SELECT id, fecha FROM grupos_horarios 
			WHERE grupo_id=$grupo_id ORDER BY fecha DESC
        ";
        	 
        $result = $this->conexion->query($sql); 
         
        $fechas = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $fechas; 
    }
    
    /*=============================================
	MOSTRAR GRUPO HORARIOS
	=============================================*/
    public function mdlMostrarGrupoHorariosPorGrupo($idGrupo){
         
        $sql = "SELECT gh.id as id,g.id AS grupo_id, h.id AS horario_id, g.comentario as comentario,h.denominacion as denominacion, gh.fecha as fecha, gh.created as created, gh.modified as modified, gh.usuario as usuario FROM ((grupos_horarios gh INNER JOIN horarios h ON gh.horario_id = h.id) INNER JOIN grupos g ON gh.grupo_id = g.id) WHERE gh.grupo_id = $idGrupo ORDER BY gh.fecha DESC";
         
        $result = $this->conexion->query($sql);         
        $checkbox = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar(); 
        return $checkbox; 
    }
    
    public function mdlMostrarGrupoH_por_id($valor){
        $sql = "SELECT gh.id , g.comentario,h.denominacion, gh.fecha, gh.created, gh.modified, gh.usuario FROM ((grupos_horarios gh INNER JOIN horarios h ON gh.horario_id = h.id) 
        INNER JOIN grupos g ON gh.grupo_id = g.id) ";
        
        if($valor != null){
            $sql = "SELECT gh.id as id, g.comentario as comentario,h.denominacion as denominacion, gh.fecha as fecha, gh.created as created, gh.modified as modified, gh.usuario as usuario FROM ((grupos_horarios gh INNER JOIN horarios h ON gh.horario_id = h.id)
            INNER JOIN grupos g ON gh.grupo_id = g.id) WHERE gh.id = $valor";
        }
         
        $result = $this->conexion->query($sql); 
         
        $asistencia = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $asistencia; 
    }
    
    /*=============================================
	MOSTRAR CHECK GRUPO HORARIOS
	=============================================*/
	 public function mdlMostrarCheckGrupo($vPeriodo,$vNivel){
        $sql = "SELECT * FROM grupos ;";
        if($vNivel != 0){
          $sql = "SELECT * FROM grupos WHERE nivel_id=$vNivel; ";
        }
        if($vPeriodo != 0){
          $sql = "SELECT * FROM grupos WHERE periodo_id=$vPeriodo; ";
        }
        if($vNivel != 0 and $vPeriodo != 0){
          $sql = "SELECT * FROM grupos WHERE nivel_id=$vNivel AND periodo_id=$vPeriodo; ";
        }
         
        $result = $this->conexion->query($sql); 
         
        $asistencia = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $asistencia; 
    }
    
    /*=============================================
	VERIFICAR UE NO EXISTA DUPLICIDAD EN LA MISMA FECHA 
	=============================================*/
	 public function mdlVerificarRedundancia($grupo,$fecha,$horarioId){
		$sql ="SELECT * FROM grupos_horarios WHERE fecha = '$fecha' AND
        grupo_id= $grupo AND horario_id = $horarioId ";
		$result = $this->conexion->query($sql); 
        $asistencia = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $asistencia; 
    }
    /*=============================================
	REGISTRAR GRUPO HORARIO
	=============================================*/

	 public function mdlRegistrarGrupoHorario($grupo,$datos){
        
        $ngHorario=$datos['ngHorario']; $usuario=$datos['usuario']; $fecha=$datos['fecha'];

		$sql ="INSERT INTO grupos_horarios (fecha, grupo_id, horario_id, created, modified, usuario) 
        
        VALUES ('$fecha', '$grupo', '$ngHorario', now(), now(), '$usuario' ) ";
		$insert = $this->conexion->query($sql); 

		if($insert){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
    }
    
    public function mdlEliminarGrupoHorario($datos){
        
		$sql = "DELETE FROM grupos_horarios WHERE id = $datos";
        $result = $this->conexion->query($sql); 
        parent::cerrar();

		if($result){
			return "ok";		
		}else{
			return "error";	
		}

	}
    public function mdlEliminarAsistenciaDeUnGrupoHorario($datos){
        
		$sql = "DELETE FROM asistencias WHERE grupo_horario_id = $datos";
        $result = $this->conexion->query($sql); 
        parent::cerrar();

		if($result){
			return "ok";		
		}else{
			return "error";	
		}

	}
    /*=============================================
	MODIFICAR HORARIO
	=============================================*/

	 public function mdlModificargrupohorario($datos){
        
        $editGrupo=$datos['editGrupo'];
		$editHorario=$datos['editHorario'];
		$editfecha=$datos['editfecha'];
		$idghorario=$datos['idghorario'];
		$usuario=$datos['usuario'];

         
		$sql ="UPDATE grupos_horarios SET fecha='$editfecha', grupo_id='$editGrupo', horario_id='$editHorario', modified= NOW(), 
        usuario='$usuario' WHERE id=$idghorario";

		$update = $this->conexion->query($sql); 

		if($update){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
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
