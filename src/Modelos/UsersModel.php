<?php  
require_once "Model.php"; 

class UsersModel extends Model
{
	public $user;
	public $pass; 
	     
    public function __construct() 
    { 
        parent::__construct(); 
    } 

    public function get_users(){
        	 
        $result = $this->conexion->query('SELECT * FROM users'); 
         
        $users = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar();
        
        return $users; 
    }
	
	public function validar($username, $password){
			
		$this->user = $username;
		$this->pass = $password;
		
		$sql ="SELECT * FROM users WHERE username='$username' and password=md5('$password') ";
		
		$result = $this->conexion->query($sql); 
		
		$user = $result->fetch_all(MYSQLI_ASSOC);
		
		parent::cerrar();
		
		return $user;
	} 

	public function buscar_por_dni($dni){
			
		$sql ="SELECT * FROM users WHERE dni='$dni' ";
		
		$result = $this->conexion->query($sql); 
		
		$user = $result->fetch_all(MYSQLI_ASSOC);
		
		parent::cerrar();
		
		return $user;
	} 

	public function buscar_por_dni_rol($dni,$role){
			
		$sql ="SELECT * FROM users WHERE dni='$dni' AND role='$role'";
		
		$result = $this->conexion->query($sql); 
		
		$user = $result->fetch_all(MYSQLI_ASSOC);
		
		parent::cerrar();
		
		return $user;
	} 

	public function buscar_por_nombres($paterno, $materno, $nombres){
			
		$sql ="SELECT * FROM users WHERE apellido_paterno LIKE '%$paterno%' AND apellido_materno LIKE '%$materno%' AND nombres LIKE '%$nombres%' ";
		
		$result = $this->conexion->query($sql); 
		
		$user = $result->fetch_all(MYSQLI_ASSOC);
		
		parent::cerrar();
		
		return $user;
	} 

	public function buscar_por_nombres_y_role($paterno, $materno, $nombres, $role){
			
		$sql ="SELECT * FROM users WHERE apellido_paterno LIKE '%$paterno%' AND apellido_materno LIKE '%$materno%' AND nombres LIKE '%$nombres%' AND role='$role'";
		
		$result = $this->conexion->query($sql); 
		
		$user = $result->fetch_all(MYSQLI_ASSOC);
		
		parent::cerrar();
		
		return $user;
	} 

	public function buscar_por_grupo($grupo_id, $role, $paso){
			
		$sql ="SELECT U.*, M.id AS matricula_id FROM matriculas M, users U WHERE M.grupo_id=$grupo_id AND M.paso=$paso AND M.user_id=U.id AND U.role='$role' ORDER BY U.apellido_paterno, U.apellido_materno, U.nombres";
		
		$result = $this->conexion->query($sql); 
		
		$user = $result->fetch_all(MYSQLI_ASSOC);
		
		parent::cerrar();
		
		return $user;
	} 

	public function buscar_por_grupo_rol($grupo_id, $role){
			
		$sql ="SELECT U.*, M.id AS matricula_id FROM matriculas M, users U WHERE M.grupo_id=$grupo_id AND M.user_id=U.id AND U.role='$role' ";
		
		$result = $this->conexion->query($sql); 
		
		$user = $result->fetch_all(MYSQLI_ASSOC);
		
		parent::cerrar();
		
		return $user;
	} 

	public function insertar($usuarioNuevo){

		$dni=$usuarioNuevo['dni'];
		$nombres=$usuarioNuevo['nombres'];
		$apellido_paterno=$usuarioNuevo['apellido_paterno'];
		$apellido_materno=$usuarioNuevo['apellido_materno'];
		$sexo=$usuarioNuevo['sexo'];
		$role=$usuarioNuevo['role'];
		$padre=$usuarioNuevo['padre'];
		$madre=$usuarioNuevo['madre'];
		$apoderado=$usuarioNuevo['apoderado'];
		$estado=$usuarioNuevo['estado'];
		$direccion=$usuarioNuevo['direccion'];
		$movistar=$usuarioNuevo['movistar'];
		$rpm=$usuarioNuevo['rpm'];
		$claro=$usuarioNuevo['claro'];
		$otro=$usuarioNuevo['otro'];
		$fijo=$usuarioNuevo['fijo'];
		$fecha_nacimiento=$usuarioNuevo['fecha_nacimiento'];
		$comentario=$usuarioNuevo['comentario'];
		$created=$usuarioNuevo['created'];
		$modified=$usuarioNuevo['modified'];
		$username=$usuarioNuevo['username'];
		$password=$usuarioNuevo['password'];

		$sql ="INSERT INTO users (dni, nombres, apellido_paterno, apellido_materno, sexo, role, padre, madre, apoderado, estado, direccion, movistar, rpm, claro, otro, fijo, fecha_nacimiento, comentario, created, modified, username, password ) VALUES ('$dni', '$nombres', '$apellido_paterno', '$apellido_materno', '$sexo', '$role', '$padre', '$madre', '$apoderado', '$estado', '$direccion', '$movistar', '$rpm', '$claro', '$otro', '$fijo', '$fecha_nacimiento', '$comentario', NOW(), NOW(), '$username', '$password') ";

		$insert = $this->conexion->query($sql); 

		if($insert){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
	} 

	public function modificar($usuarioNuevo){

		$dni=$usuarioNuevo['dni'];
		$nombres=$usuarioNuevo['nombres'];
		$apellido_paterno=$usuarioNuevo['apellido_paterno'];
		$apellido_materno=$usuarioNuevo['apellido_materno'];
		$sexo=$usuarioNuevo['sexo'];
		$role=$usuarioNuevo['role'];
		$padre=$usuarioNuevo['padre'];
		$madre=$usuarioNuevo['madre'];
		$apoderado=$usuarioNuevo['apoderado'];
		$estado=$usuarioNuevo['estado'];
		$direccion=$usuarioNuevo['direccion'];
		$movistar=$usuarioNuevo['movistar'];
		$rpm=$usuarioNuevo['rpm'];
		$claro=$usuarioNuevo['claro'];
		$otro=$usuarioNuevo['otro'];
		$fijo=$usuarioNuevo['fijo'];
		$fecha_nacimiento=$usuarioNuevo['fecha_nacimiento'];
		$comentario=$usuarioNuevo['comentario'];
		$created=$usuarioNuevo['created'];
		$modified=$usuarioNuevo['modified'];
		$username=$usuarioNuevo['username'];
		$password=$usuarioNuevo['password'];

		$sql ="UPDATE users SET nombres='$nombres', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno', sexo='$sexo', role='$role', padre='$padre', madre='$madre', apoderado='$apoderado', estado='$estado', direccion='$direccion', movistar='$movistar', rpm='$rpm', claro='$claro', otro='$otro', fijo='$fijo', fecha_nacimiento='$fecha_nacimiento', comentario='$comentario', modified=NOW(), username='$username', password='$password' WHERE dni='$dni' ";

		$update = $this->conexion->query($sql); 
		
		if($update){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
	} 

	public function registrarPadre($dniAlumno,$campo,$dniPadre){

		if($campo=="padre") $sql ="UPDATE users SET padre='$dniPadre' WHERE dni='$dniAlumno' ";
		if($campo=="madre") $sql ="UPDATE users SET madre='$dniPadre' WHERE dni='$dniAlumno' ";
		if($campo=="apoderado") $sql ="UPDATE users SET apoderado='$dniPadre' WHERE dni='$dniAlumno' ";

		$update = $this->conexion->query($sql); 
		
		if($update){
			return true;
		} else {
			return false;
		}
		
		parent::cerrar();
	}
	
	public function actualizar_direccion_telefono_email_con_el_dni($dni, $direccion, $telefono, $email) {

		$sql ="UPDATE users SET direccion='$direccion', movistar='$telefono', email='$email' WHERE dni='$dni' ";
		$update = $this->conexion->query($sql); 

		if($update)	return true;
		else return false;
		
		parent::cerrar();
	} 
    
	public function buscar_por_id($user_id){
			
		$sql ="SELECT * FROM users WHERE id=$user_id ";
		
		$result = $this->conexion->query($sql); 
		
		$user = $result->fetch_all(MYSQLI_ASSOC);
		
		parent::cerrar();
		
		return $user;
	} 



     /*=============================================
	MOSTRAR ASISTENCIAS
	=============================================*/
    public function mdlVerTelefonosUsuarios($nivel,$periodo,$grupo,$condicion,$fecha){
        if($condicion == 0){
          $sql = "SELECT al.id AS id, al.apellido_paterno AS apePat,al.apellido_materno AS apeMat, 
          al.nombres AS nombreal, al.dni AS dni,ap.apellido_paterno AS apePa,ap.apellido_materno AS 
          apeMa, ap.nombres AS nombreap,ap.movistar , ap.rpm,ap.claro,ap.otro,ap.fijo,a.condicion FROM 
          users al, users ap, asistencias a, grupos g, grupos_horarios gh WHERE al.apoderado = ap.dni AND 
          a.user_id = al.id AND gh.id = a.grupo_horario_id AND gh.grupo_id = g.id AND a.fecha = 
          '$fecha' AND g.nivel_id = $nivel AND g.periodo_id = $periodo AND g.id = $grupo ";
            
        }
        if($condicion == "P"){
          $sql = "SELECT al.id AS id, al.apellido_paterno AS apePat,al.apellido_materno AS apeMat, 
          al.nombres AS nombreal, al.dni AS dni,ap.apellido_paterno AS apePa,ap.apellido_materno AS 
          apeMa, ap.nombres AS nombreap,ap.movistar , ap.rpm,ap.claro,ap.otro,ap.fijo,a.condicion FROM 
          users al, users ap, asistencias a, grupos g, grupos_horarios gh WHERE al.apoderado = ap.dni AND 
          a.user_id = al.id AND 
        gh.id = a.grupo_horario_id AND gh.grupo_id = g.id AND a.fecha LIKE '$fecha' AND g.nivel_id = 
        $nivel AND g.periodo_id = $periodo AND g.id = $grupo AND a.condicion = 'P'";
        }
        if($condicion == "T"){
          $sql = "SELECT al.id AS id, al.apellido_paterno AS apePat,al.apellido_materno AS apeMat, 
          al.nombres AS nombreal, al.dni AS dni,ap.apellido_paterno AS apePa,ap.apellido_materno AS 
          apeMa, ap.nombres AS nombreap,ap.movistar , ap.rpm,ap.claro,ap.otro,ap.fijo,a.condicion FROM 
          users al, users ap, asistencias a, grupos g, grupos_horarios gh WHERE al.apoderado = ap.dni AND 
          a.user_id = al.id AND gh.id = a.grupo_horario_id AND gh.grupo_id = g.id AND a.fecha = 
          '$fecha' AND g.nivel_id = $nivel AND g.periodo_id = $periodo AND g.id = $grupo AND a.condicion 
          = 'T' ";
        }if($condicion == "F"){
          $sql = "SELECT al.id AS id, al.apellido_paterno AS apePat,al.apellido_materno AS apeMat, 
          al.nombres AS nombreal, al.dni AS dni,ap.apellido_paterno AS apePa,ap.apellido_materno AS 
          apeMa, ap.nombres AS nombreap,ap.movistar , ap.rpm,ap.claro,ap.otro,ap.fijo,a.condicion FROM 
          users al, users ap, asistencias a, grupos g, grupos_horarios gh WHERE al.apoderado = ap.dni AND 
          a.user_id = al.id AND gh.id = a.grupo_horario_id AND gh.grupo_id = g.id AND a.fecha = 
          '$fecha' AND g.nivel_id = $nivel AND g.periodo_id = $periodo AND g.id = $grupo AND a.condicion 
          = 'F'";
        } 
        
        
        $result = $this->conexion->query($sql);         
        $asistencias = $result->fetch_all(MYSQLI_ASSOC); 
         
        parent::cerrar(); 
        return $asistencias; 
    }

} 

?> 