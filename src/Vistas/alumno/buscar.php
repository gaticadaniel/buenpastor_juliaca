<?php

?>

<div class="container">

	<form class="form-inline" role="form">
		<h3>Buscar Alumno
			<small> 
				<div class="radio">
				  <label>
				    <input type="radio" name="radio" value="apellidos" onclick="elegir()"> Por Apellidos y Nombres
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="radio" value="dni" onclick="elegir()" checked> Por DNI
				  </label>
				</div>	
		
			</small>
		</h3>
	</form>
	
	<script type="text/javascript">
	function elegir(){
		var resultado="ninguno";
		var porNombre=document.getElementsByName("radio");
			for(var i=0;i<porNombre.length;i++){
				if(porNombre[i].checked) resultado=porNombre[i].value;
			}
			if(resultado=='apellidos'){
				document.getElementById('por apellidos').style.display = 'block';
				document.getElementById('por dni').style.display = 'none';
			} 
			if(resultado=='dni'){
				document.getElementById('por apellidos').style.display = 'none';
				document.getElementById('por dni').style.display = 'block';
			}
	}
	</script>
	
	<div id="por apellidos" style='display:none;'>
		<form method="POST" class="form-inline" name="por_nombre" id="por_nombre" action="../../src/Controladores/AlumnoControl.php">
		  <div class="form-group">
		    <input type="text" class="form-control" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido Paterno">
		  </div>
		  <div class="form-group">
		    <input type="text" class="form-control" name="apellido_materno" id="apellido_materno" placeholder="Apellido Materno">
		  </div>
		  <div class="form-group">
		    <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombres">
		  </div>
		  <input type="hidden" name="control" id="control" value="Buscar" >
		  <input type="hidden" name="condicion" id="condicion" value="por_nombres" >
		  <button type="submit" class="btn btn-default">Buscar</button>
		</form>
	</div>
	
	<div id="por dni">
		<form method="POST" class="form-inline" name="por_dni" id="por_dni" action="../../src/Controladores/AlumnoControl.php">
		  <div class="form-group">
		    <input type="text" class="form-control" name="dni" id="dni" minlength="5" placeholder="DNI" required/>	
		  </div>
		  <input type="hidden" name="control" id="control" value="Buscar" >
		  <input type="hidden" name="condicion" id="condicion" value="por_dni" >
		  <button type="submit" class="btn btn-default">Buscar</button>
		</form>
	</div>
	</br>
	<div class="table-responsive">
<?php
if(isset($_SESSION['resultado'])){
	$resultado = $_SESSION['resultado'];
	$i=0;

	if(count($resultado)>0){
		echo "<h3>Resultados: <small>".count($resultado)." fila(s) encontrada(s)</small></h3>";
		echo "<table class='table table-hover'>";
		foreach ($resultado as $key => $value) {
			echo "<thead>";
			echo "<tr>";
			foreach ($value as $key => $value) {
				if($i<5){
					echo "<td>".$key."</td>";
					$i++;
				}
			}
			echo "<td>Opciones</td>";
			echo "</tr>";
			echo "</thead>";
		}
		$i=0;
		foreach ($resultado as $llave => $valor) {
			echo "<tbody>";
			echo "<tr>";
			foreach ($valor as $key => $value) {
				if($i<5){
					echo "<td>".$value."</td>";
					$i++;
				}
				
			}
			echo "<td><a href='#' onclick='javascript:document.ver".$llave.".submit()'>Ver</a> <a href='#' onclick='javascript:document.editar".$llave.".submit()'>Editar</a> Eliminar";

				echo "<form method='POST' name='ver".$llave."' id='ver".$llave."' action='../Controladores/AlumnoControl.php'>";
				echo "<input type='hidden' name='llave' id='llave' value='".$llave."'>";
				echo "<input type='hidden' name='control' id='control' value='Ver'>";
				echo "</form> ";

				echo "<form method='POST' name='editar".$llave."' id='editar".$llave."' action='../Controladores/AlumnoControl.php'>";
				echo "<input type='hidden' name='llave' id='llave' value='".$llave."'>";
				echo "<input type='hidden' name='control' id='control' value='Editar'>";
				echo "</form> ";

					
			echo "</td>";
			echo "</tr>";
			echo "</tbody>";
		}
		echo "</table>";
	} else {
		echo "<h3>Resultados: <small>".count($resultado)." filas encontradas</small></h3>";
	}
}
?>
	</div>
</div>

