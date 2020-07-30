<?php  
require_once "Model.php";

class AsistenciasModel extends Model {
	     
    public function __construct(){ 
        parent::__construct(); 
    } 

    public function numero_ingresos_sin_agenda($grupo_id, $user_id){ 
		$sql = "SELECT COUNT(A.id) 
				FROM grupos_horarios GH, asistencias A 
				WHERE 
					GH.grupo_id=$grupo_id AND 
					GH.id=A.grupo_horario_id AND 
					A.user_id=$user_id AND 
					con_agenda=0 ";
        $result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado;
    }

	public function minutos_perdidos_por_tardanzas($grupo_id, $user_id){ 
		$sql = "SELECT SUM(A.diferencia_ingreso) 
				FROM grupos_horarios GH, asistencias A
				WHERE 
					GH.grupo_id=$grupo_id AND
				    GH.id=A.grupo_horario_id AND
				    A.user_id=$user_id AND
				    A.diferencia_ingreso<0 ";
        $result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado;
    }

	public function numero_de_tardanzas($grupo_id, $user_id){ 
		$sql = "SELECT COUNT(*) 
				FROM grupos_horarios GH, asistencias A
				WHERE 
					GH.grupo_id=$grupo_id AND
				    GH.id=A.grupo_horario_id AND
				    A.user_id=$user_id AND
				    A.diferencia_ingreso<0 ";
        $result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado;
    }

    public function numero_de_justificaciones($grupo_id, $user_id, $motivo){ //la variable $motivo recibe los siguietes valores: FALTA, TARDANZA
		$sql = "SELECT COUNT(*) 
				FROM grupos_horarios GH, justificaciones J 
				WHERE 
					GH.grupo_id=$grupo_id AND
				    GH.id=J.grupo_horario_id AND
				    J.user_id=$user_id AND
				    J.motivo_de_justificacion='$motivo' ";
        $result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado;
    }

    public function numero_total_de_asistencias_de_un_usuario_a_un_grupo($grupo_id, $user_id){
		$sql = "SELECT COUNT(A.id) 
				FROM grupos_horarios GH, asistencias A 
				WHERE 
					GH.grupo_id=$grupo_id AND
				    GH.id=A.grupo_horario_id AND
				    A.user_id=$user_id ";
        $result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado;
    }

    public function numero_total_de_asistencias_a_un_grupo($grupo_id){
		$sql = "SELECT COUNT(GH.id) 
				FROM grupos_horarios GH 
				WHERE 
					GH.grupo_id=$grupo_id ";
        $result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado; 
    }


	public function cambiar_asistencia($asistencia, $usuario){
		$user_id = $asistencia[0]['user_id'];
		$grupo_horario_id = $asistencia[0]['grupos_horarios_id'];
		$con_agenda = $asistencia[0]['con_agenda'];
		$fecha = $asistencia[0]['fecha'];
		$hora_de_ingreso = $asistencia[0]['hora_ingreso'];
		$hora_de_ingreso_real = $asistencia[0]['hora_ingreso_real'];
		$tolerancia_ingreso = $asistencia[0]['minutos_de_tolerancia'];
		$diferencia_ingreso = $asistencia[0]['diferencia_ingreso'];
		$justificado = $asistencia[0]['justificado'];
		$hora_de_salida = $asistencia[0]['hora_salida'];

		if($diferencia_ingreso>=0){
            $sql ="UPDATE asistencias SET con_agenda=$con_agenda, hora_de_ingreso_real ='$hora_de_ingreso_real', diferencia_ingreso='$diferencia_ingreso', modified =NOW(), condicion = 'P', usuario = '$usuario' WHERE user_id ='$user_id' AND grupo_horario_id = '$grupo_horario_id' and fecha = '$fecha' ";
        }else{
            $sql ="UPDATE asistencias SET con_agenda=$con_agenda, hora_de_ingreso_real ='$hora_de_ingreso_real', diferencia_ingreso='$diferencia_ingreso', modified =NOW(), condicion = 'T', usuario = '$usuario' WHERE user_id ='$user_id' AND grupo_horario_id = '$grupo_horario_id' and fecha = '$fecha' ";
        }

		$insert = $this->conexion->query($sql); 

		if($insert) return true;
		else return false;
		
		parent::cerrar();
	}

    public function verificar_si_existe_asistencia_realizada($user_id, $grupo_horario_id, $fecha){
		$sql = "SELECT * FROM asistencias WHERE user_id=$user_id AND grupo_horario_id=$grupo_horario_id AND fecha='$fecha' AND condicion != 'F' ";
        $result = $this->conexion->query($sql); 
        $asistencia = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $asistencia; 
    }
    // se debe cambiar la consulta para registrar grupos horarios
    public function verificar_si_se_puede_registrar_asistencia($dni, $fecha, $hora){
		$sql = "SELECT U.id AS user_id, U.dni, U.apellido_paterno, U.apellido_materno, U.nombres, M.paso, G.comentario, 
	G.id AS grupo_id, GH.id AS grupos_horarios_id, H.denominacion, A.hora_de_ingreso AS hora_ingreso, A.tolerancia_ingreso AS minutos_de_tolerancia, 
	TIME_TO_SEC(TIMEDIFF(A.hora_de_ingreso, '$hora')) DIV 60 AS diferencia_ingreso, A.hora_de_salida AS hora_salida 
	FROM users U, matriculas M, grupos G, grupos_horarios GH, horarios H, asistencias A
		WHERE U.dni='$dni' AND
			U.id=M.user_id AND
			M.paso=4 AND
			M.grupo_id=G.id AND
			G.activo=1 AND
			G.id=GH.grupo_id AND
			A.fecha='$fecha' AND
			GH.horario_id=H.id AND
            A.grupo_horario_id = GH.id AND
			U.id = A.user_id AND
			H.minutos_antes_ingreso >= TIME_TO_SEC(TIMEDIFF(A.hora_de_ingreso, '$hora')) DIV 60 AND
			H.minutos_despues_ingreso >= -TIME_TO_SEC(TIMEDIFF(A.hora_de_ingreso, '$hora')) DIV 60";
        $result = $this->conexion->query($sql); 
        $asistencia = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $asistencia; 
    }

    public function buscar_registro_de_ingreso($dni, $fecha, $hora){
		$sql = "SELECT A.id AS asistencia_id, A.hora_de_salida_real, A.diferencia_salida, U.id AS user_id, U.dni, U.apellido_paterno, U.apellido_materno, U.nombres, G.comentario, 
					   G.id AS grupo_id, GH.id AS grupos_horarios_id, H.denominacion, A.hora_de_salida as hora_salida,
				       H.minutos_antes_salida, H.minutos_de_tolerancia_2, H.minutos_despues_salida,
					   TIME_TO_SEC(TIMEDIFF(A.hora_de_salida, '$hora')) DIV 60 AS diferencia_de_salida  
				FROM users U, matriculas M, grupos G, grupos_horarios GH, horarios H, asistencias A 
				WHERE U.dni='$dni' AND
					U.id=M.user_id AND
				    M.paso=4 AND
				    M.grupo_id=G.id AND
				    G.activo=1 AND
				    G.id=GH.grupo_id AND
				    GH.fecha='$fecha' AND
				    GH.horario_id=H.id AND
				    H.minutos_antes_salida >= TIME_TO_SEC(TIMEDIFF(A.hora_de_salida, '$hora')) DIV 60 AND
				    H.minutos_despues_salida >= -TIME_TO_SEC(TIMEDIFF(A.hora_de_salida, '$hora')) DIV 60 AND
				    GH.id=A.grupo_horario_id AND
				    A.user_id=U.id AND
				    A.fecha='$fecha'";
        $result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado; 
    }

	public function actualizar_salida($registro_de_ingreso, $usuario){
		$hora = $registro_de_ingreso[0]['hora_salida_real'];
		$diferencia = $registro_de_ingreso[0]['diferencia_salida'];
		$asistencia_id = $registro_de_ingreso[0]['asistencia_id'];
		
		$sql ="UPDATE asistencias SET hora_de_salida_real='$hora', diferencia_salida=$diferencia, modified=NOW(), usuario='$usuario' WHERE id=$asistencia_id ";
		$update = $this->conexion->query($sql); 
		if($update) return true;
		else return false;
		parent::cerrar();
	}
    /*=============================================
	OBTIENE LOS ALUMNOS MATRICULADOS PARA GENERAR SU ASISTENCIA
	=============================================*/
    public function obtener_datos_para_crear_asistencia($grupo,$fecha,$horarioId){
		
		$sql ="SELECT M.user_id AS user_id, GH.id AS grupos_horarios_id , H.hora_ingreso, H.minutos_de_tolerancia, H.hora_salida FROM matriculas M, grupos_horarios GH, grupos G, horarios H WHERE G.id = GH.grupo_id AND GH.horario_id = H.id AND M.grupo_id = G.id AND GH.fecha ='$fecha' AND G.id = '$grupo' AND M.paso=4  AND H.id ='$horarioId' ;";
		$result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado; 
	}
    
    public function registrar_asistencias($asistencia,$fecha,$usuario){
		$user_id = $asistencia['user_id'];
		$grupo_horario_id = $asistencia['grupos_horarios_id'];
        $hora_de_ingreso = $asistencia['hora_ingreso'];
		$tolerancia_ingreso = $asistencia['minutos_de_tolerancia'];
		$hora_de_salida = $asistencia['hora_salida'];

		$sql ="INSERT INTO asistencias (user_id, grupo_horario_id, con_agenda, fecha, hora_de_ingreso, tolerancia_ingreso, hora_de_salida, justificado, created, modified, usuario) 
        VALUES ('$user_id', '$grupo_horario_id', 0, '$fecha', '$hora_de_ingreso' , '$tolerancia_ingreso', '$hora_de_salida', 0, NOW(), NOW(), '$usuario') ";

		$insert = $this->conexion->query($sql); 

		if($insert) return true;
		else return false;
		
		parent::cerrar();
	}
    
    /*=============================================
	OBTIENE LOS ALUMNOS MATRICULADOS PARA REPORTE DE ASISTENCIA
	=============================================*/
    public function mdlVerMatriculadosPeriodo($periodo,$grupo){
		
		$sql ="SELECT u.apellido_paterno AS apePa,u.apellido_materno AS apeMa, u.nombres ,m.* FROM matriculas m, grupos g, users u WHERE m.grupo_id = g.id AND grupo_id ='$grupo' AND 
        periodo_id ='$periodo' AND m.paso = 4 AND u.id = m.user_id;";
		$result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado; 
	}
    
    /*=============================================
	OBTENER ASISTENCIA POR MATRICULA Y FECHA
	=============================================*/
    public function mdlAsistenciaPorUserId($usuario,$fecha){
		
		$sql ="SELECT * FROM asistencias WHERE user_id = '$usuario' AND fecha = '$fecha' ";
		$result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado; 
	}
    
    /*=============================================
	OBTENER ASISTENCIA POR MATRICULA Y FECHA
	=============================================*/
    public function mdlContarAsistencia($usuario,$fechai,$fechaf,$condicion){
		
		$sql ="SELECT COUNT(*) AS C FROM asistencias WHERE user_id = '$usuario' AND fecha BETWEEN '$fechai' AND '$fechaf' AND condicion ='$condicion'  ";
		$result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado; 
	}
    
     /*=============================================
	OBTENER ASISTENCIA POR MATRICULA Y FECHA
	=============================================*/
    public function mdlVerHorasAsistencia($dni,$apeP,$apeM,$nombre,$fechai,$fechafin){
		
		$sql ="SELECT u.dni,u.nombres, u.apellido_paterno, u.apellido_materno, a.* FROM asistencias a, users u WHERE u.dni LIKE '%$dni%' AND u.apellido_paterno LIKE '%$apeP%' AND u.apellido_materno LIKE '%$apeM%' AND u.nombres LIKE '%$nombre%' AND fecha 
        BETWEEN '$fechai' AND '$fechafin' AND u.id = a.user_id ORDER BY fecha desc;";
		$result = $this->conexion->query($sql); 
        $resultado = $result->fetch_all(MYSQLI_ASSOC); 
        parent::cerrar();
        return $resultado; 
	}
    
} 
?> 