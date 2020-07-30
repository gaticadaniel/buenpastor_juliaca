<?php  
require_once "Model.php"; 

class HorariosModel extends Model {
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

   /*=============================================
	MOSTRAR HORARIOS
	=============================================*/

    public function mdlVerHorariosyNiveles($valor){
      $sql = "SELECT h.*, n.nivel FROM horarios h INNER JOIN nivels n ON h.nivel_id = n.id;";
      if($valor != null){
        $sql = "SELECT h.*, n.nivel FROM horarios h INNER JOIN nivels n ON h.nivel_id = n.id where h.id = $valor ;";
      }
         
        $result = $this->conexion->query($sql); 
         
        $asistencia = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $asistencia; 
    }
    
    /*=============================================
	MOSTRAR NIVELES
	=============================================*/

	 public function mdlMostrarNiveles(){
        
        $sql = "SELECT * from nivels";
         
        $result = $this->conexion->query($sql); 
         
        $asistencia = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $asistencia; 
    }
    
    /*=============================================
	MOSTRAR HorarioS
	=============================================*/

    public function mdlMostrarHorarios($valor){
        $sql = "SELECT * from horarios";
        if($valor != null){
            $sql = "SELECT * from horarios where id = $valor";
        }
         
        $result = $this->conexion->query($sql); 
         
        $asistencia = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $asistencia; 
    }
    public function mdlMostrarHorariosPorNivel($valor){
        $sql = "SELECT * from horarios where nivel_id = $valor";
//        if($valor == null){
//            $sql = "SELECT * from horarios";
//        }   
        $result = $this->conexion->query($sql);  
        $asistencia = $result->fetch_all(MYSQLI_ASSOC);  
        parent::cerrar();
        return $asistencia; 
    }
    
    /*=============================================
	REGISTRAR HORARIO
	=============================================*/
	 public function mdlRegistrarhorario($datos){
        
        $idNivel=$datos['idNivel'];
		$denominacion=$datos['denominacion'];
		$horaIngreso=$datos['horaIngreso'];
		$minutosantesi=$datos['minutosantesi'];
		$minutostoleranciai=$datos['minutostoleranciai'];
		$minutostodespuesi=$datos['minutostodespuesi'];
		$horaSalida=$datos['horaSalida'];
		$minutostoantess=$datos['minutostoantess'];
		$minutostotolerancias=$datos['minutostotolerancias'];
		$minutostodespuess=$datos['minutostodespuess'];
		$usuario=$datos['usuario'];

		$sql ="INSERT INTO horarios (nivel_id, denominacion, hora_ingreso, minutos_antes_ingreso, minutos_de_tolerancia, minutos_despues_ingreso, hora_salida, minutos_antes_salida, minutos_de_tolerancia_2, minutos_despues_salida, created, modified, usuario) 
        
        VALUES ($idNivel, '$denominacion', '$horaIngreso', '$minutosantesi', '$minutostoleranciai', '$minutostodespuesi', '$horaSalida', '$minutostoantess', '$minutostotolerancias', '$minutostodespuess', NOW(), NOW(), '$usuario') ";

		$insert = $this->conexion->query($sql); 

		if($insert){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
    }
    
    /*=============================================
	MODIFICAR HORARIO
	=============================================*/
	 public function mdlModificarhorario($datos){
        
        $idNivel=$datos['idNivel'];
		$denominacion=$datos['denominacion'];
		$idhorario=$datos['idhorario'];
		$horaIngreso=$datos['horaIngreso'];
		$minutosantesi=$datos['minutosantesi'];
		$minutostoleranciai=$datos['minutostoleranciai'];
		$minutostodespuesi=$datos['minutostodespuesi'];
		$horaSalida=$datos['horaSalida'];
		$minutostoantess=$datos['minutostoantess'];
		$minutostotolerancias=$datos['minutostotolerancias'];
		$minutostodespuess=$datos['minutostodespuess'];
		$usuario=$datos['usuario'];

         
		$sql ="UPDATE horarios SET nivel_id=$idNivel, denominacion='$denominacion', hora_ingreso='$horaIngreso', minutos_antes_ingreso='$minutosantesi', minutos_de_tolerancia='$minutostoleranciai', minutos_despues_ingreso='$minutostodespuesi', hora_salida='$horaSalida', minutos_antes_salida='$minutostoantess', minutos_de_tolerancia_2='$minutostotolerancias', minutos_despues_salida='$minutostodespuess', modified= NOW(), 
        usuario='$usuario' WHERE id=$idhorario";

		$update = $this->conexion->query($sql); 

		if($update){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
    }
    
    /*=============================================
	ELIMINAR HORARIO
	=============================================*/
    public function mdlEliminarhorario($valor){

		$sql = "DELETE FROM horarios WHERE id = $valor";

        $result = $this->conexion->query($sql); 
        
        parent::cerrar();

		if($result){
			return "ok";
		}else{
			return "error";	
		}
	}

} 
