<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href='#' onclick='javascript:document.form_alumno.submit()'>Alumno <?php if(isset($_SESSION['alumnoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_padre.submit()'>Padre <?php if(isset($_SESSION['padreMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_madre.submit()'>Madre <?php if(isset($_SESSION['madreMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_apoderado.submit()'>Apoderado <?php if(isset($_SESSION['apoderadoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_periodo.submit()'>Periodo <?php if(isset($_SESSION['periodoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_grupo.submit()'>Grupo <?php if(isset($_SESSION['grupoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_finalizar.submit()'>Finalizar</a></li>
	</ul>
	
	
	<form method='POST' name='form_alumno' id='form_alumno' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='alumno.php'>
	</form>
	<form method='POST' name='form_padre' id='form_padre' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='padre.php'>
	</form>
	<form method='POST' name='form_madre' id='form_madre' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='madre.php'>
	</form>
	<form method='POST' name='form_apoderado' id='form_apoderado' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='apoderado.php'>
	</form>
	<form method='POST' name='form_periodo' id='form_periodo' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='periodo.php'>
	</form>
	<form method='POST' name='form_grupo' id='form_grupo' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='grupo.php'>
	</form>
	<form method='POST' name='form_finalizar' id='form_finalizar' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='finalizar.php'>
	</form>
</div>

<div class="container">
	<form class="form-inline" action="../../src/Controladores/MatriculaControl.php" method="post" onsubmit="return validacion()" name="buscar">
		<div class="form-group">
			<h3>Buscar Alumno <small> 
			<input type="text" class="form-control" name="dniAlumno" id="dniAlumno" placeholder="DNI" required/>	
			<input type="hidden" name="control" id="control" value="BuscarDatos" >
			<button type="submit" class="btn btn-default">Buscar</button>
			</small> 
			</h3>
		</div>
	</form>
</div>

	
<?php

if( isset($_SESSION['alumnoMatricula']) or isset($_SESSION['dniAlumno']) or isset($_SESSION['alumnoMatri']) ){
	if ( isset($_SESSION['alumnoMatricula']) ){
		$alumnoMatricula = $_SESSION['alumnoMatricula'];
			
		$id=$alumnoMatricula['0']['id'];
		$dni=$alumnoMatricula['0']['dni'];
		$nombres=$alumnoMatricula['0']['nombres'];
		$apellido_paterno=$alumnoMatricula['0']['apellido_paterno'];
		$apellido_materno=$alumnoMatricula['0']['apellido_materno'];
		$sexo=$alumnoMatricula['0']['sexo'];
		$role=$alumnoMatricula['0']['role'];
		$padre=$alumnoMatricula['0']['padre'];
		$madre=$alumnoMatricula['0']['madre'];
		$apoderado=$alumnoMatricula['0']['apoderado'];
		$estado=$alumnoMatricula['0']['estado'];
		$direccion=$alumnoMatricula['0']['direccion'];
		$movistar=$alumnoMatricula['0']['movistar'];
		$rpm=$alumnoMatricula['0']['rpm'];
		$claro=$alumnoMatricula['0']['claro'];
		$otro=$alumnoMatricula['0']['otro'];
		$fijo=$alumnoMatricula['0']['fijo'];
		$fecha_nacimiento=$alumnoMatricula['0']['fecha_nacimiento'];
		$comentario=$alumnoMatricula['0']['comentario'];
		$created=$alumnoMatricula['0']['created'];
		$modified=$alumnoMatricula['0']['modified'];
		$username=$alumnoMatricula['0']['username'];
		$password=$alumnoMatricula['0']['password'];
		$accion="MODIFICAR";
	} 
	if ( isset($_SESSION['alumnoMatri']) ){
		$alumnoMatricula = $_SESSION['alumnoMatri'];
			
		$id=$alumnoMatricula['id'];
		$dni=$alumnoMatricula['dni'];
		$nombres=$alumnoMatricula['nombres'];
		$apellido_paterno=$alumnoMatricula['apellido_paterno'];
		$apellido_materno=$alumnoMatricula['apellido_materno'];
		$sexo=$alumnoMatricula['sexo'];
		$role=$alumnoMatricula['role'];
		$padre=$alumnoMatricula['padre'];
		$madre=$alumnoMatricula['madre'];
		$apoderado=$alumnoMatricula['apoderado'];
		$estado=$alumnoMatricula['estado'];
		$direccion=$alumnoMatricula['direccion'];
		$movistar=$alumnoMatricula['movistar'];
		$rpm=$alumnoMatricula['rpm'];
		$claro=$alumnoMatricula['claro'];
		$otro=$alumnoMatricula['otro'];
		$fijo=$alumnoMatricula['fijo'];
		$fecha_nacimiento=$alumnoMatricula['fecha_nacimiento'];
		$comentario=$alumnoMatricula['comentario'];
		$created=$alumnoMatricula['created'];
		$modified=$alumnoMatricula['modified'];
		$username=$alumnoMatricula['username'];
		$password=$alumnoMatricula['password'];
		$accion=$alumnoMatricula['accion'];
	} 

	if ( isset($_SESSION['dniAlumno']) ){
		$id="";
		$dni=$_SESSION['dniAlumno'];
		$nombres="";
		$apellido_paterno="";
		$apellido_materno="";
		$sexo="";
		$role="Alumno";
		$padre="";
		$madre="";
		$apoderado="";
		$estado="1";
		$direccion="";
		$movistar="";
		$rpm="";
		$claro="";
		$otro="";
		$fijo="";
		$fecha_nacimiento="";
		$comentario="";
		$created="";
		$modified="";
		$username="";
		$password="";
		$accion="INSERTAR";
//		$_SESSION['dniAlumno']=null;
	}
?>
			<form class='form-horizontal' method="POST"  name="form_alumno" id="form_alumno" action="../Controladores/MatriculaControl.php" onSubmit="return validando()">
	
							<div class="form-group">
								<label class="col-lg-2 control-label">Id</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="id" placeholder="id" value="<?=$id?>" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">DNI</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="dni" placeholder="dni" value="<?=$dni?>" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Nombres</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="nombres" placeholder="nombres" value="<?=$nombres?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Apellido Paterno</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="apellido_paterno" placeholder="apellido_paterno" value="<?=$apellido_paterno?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Apellido Materno</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="apellido_materno" placeholder="apellido_materno" value="<?=$apellido_materno?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Sexo</label>
								<div class="col-lg-10">
									<div class="radio">
									  <label>
									    <input type="radio" name="sexo" id="sexo" value="Masculino" <?php if($sexo=="Masculino") echo "checked='true'"; ?> >Masculino
									  </label>
									  <label>
									    <input type="radio" name="sexo" id="sexo" value="Femenino" <?php if($sexo=="Femenino") echo "checked='true'"; ?> >Femenino
									  </label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Rol</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="role" placeholder="role" value="<?=$role?>" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Padre</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="padre" placeholder="padre" value="<?=$padre?>" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Madre</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="madre" placeholder="madre" value="<?=$madre?>" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Apoderado</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="apoderado" placeholder="apoderado" value="<?=$apoderado?>" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Estado</label>
								<div class="col-lg-10">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="estado" id="estado" <?php if($estado=="1") echo"checked='true'"; ?> readonly="true" >
										</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Dirección</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="direccion" placeholder="direccion" value="<?=$direccion?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Movistar</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="movistar" placeholder="movistar" value="<?=$movistar?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Rpm</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="rpm" placeholder="rpm" value="<?=$rpm?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Claro</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="claro" placeholder="claro" value="<?=$claro?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Otro</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="otro" placeholder="otro" value="<?=$otro?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Fijo</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="fijo" placeholder="fijo" value="<?=$fijo?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Fecha de Nacimiento</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="AAAA-MM-DD" value="<?=$fecha_nacimiento?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Comentario</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="comentario" placeholder="comentario" value="<?=$comentario?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Created</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="created" placeholder="created" value="<?=$created?>" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Modified</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="modified" placeholder="modified" value="<?=$modified?>" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">username</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="username" placeholder="username" value="<?=$username?>" readonly="true">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">password</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="password" placeholder="password" value="<?=$password?>" readonly="true">
								</div>
							</div>
	
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
						<input type="hidden" name="accion" id="accion" value="<?=$accion?>" >
						<input type="hidden" name="control" id="control" value="ConfirmarAlumno" >
						<button type="submit" class="btn btn-default">Confirmar</button>
					</div>
				</div>
	
			</form>
<?php

}

?>


<script language="javascript" type="text/javascript"> 
	function validacion() { 
	  var dni=document.getElementById("dniAlumno").value;
	  if (!(/^\d{8}$/.test(dni))) { 
	    alert('DNI no válido');
	    document.getElementById("dniAlumno").focus();
	    return false; 
	  } else {
	  	return true;
	  }
	}

	function validando(){
		fecha = document.getElementById("fecha_nacimiento").value;
		foco = document.getElementById("fecha_nacimiento");
		var validformat=/^\d{4}\-\d{2}\-\d{2}$/ //Basic check for format validity
		var returnval=false
		if (!validformat.test(fecha)){
			alert("Formato incorrecto: use YYYY-MM-DD");
			foco.select()
			return false;
		}
		var yearfield=fecha.split("-")[0]
		var monthfield=fecha.split("-")[1]
		var dayfield=fecha.split("-")[2]
		var dayobj = new Date(yearfield, monthfield-1, dayfield)
		if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield)){
			alert("La fecha no existe.")
			foco.select()
			return false;
		}
		var a = 0, rdbtn=document.getElementsByName("sexo")
		for(i=0;i<rdbtn.length;i++) {
			if(rdbtn.item(i).checked == false) {
				a++;
			}
		}
		if(a == rdbtn.length) {
			alert("Por favor, seleccione sexo");
			return false;
		}
		return true;
	}

</script>
