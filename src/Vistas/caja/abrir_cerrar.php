<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href='#' >Abrir o Cerrar Stand</a></li>
	</ul>
</div>
</br>
<?php
//print_r($_SESSION['standAbiertos']);

?>

<form method='POST' name='form_stands_cerrados' id='form_stands_cerrados' action='../Controladores/CajaControl.php' onsubmit="return validate()">

<?php
	if(isset($_SESSION['standCerrados'])){
		$array = $_SESSION['standCerrados'];
		
		echo "<h3>Stand Cerrados: <small>".count($array)." encontrado(s)</small></h3>";
		if (count($array) > 0) {
			$COLUMNAS = 4;
			$i=0;
	
			echo "<table class='table table-hover'>";
			echo "<tr>";
			foreach ($array as $key => $value) {
				foreach ($value as $titulo => $contenido) {
					if ($i < $COLUMNAS) echo "<td><strong>".$titulo."</strong></td>";
					else break;
					$i++;
				}
				break;
			}
			echo "<td><strong>Seleccionar</strong></td>";
			echo "</tr>";
	
			foreach ($array as $key => $value) {
				$i=0;
				echo "<tr>";
				foreach ($value as $titulo => $contenido) {
					if ($titulo=='id') $id = $contenido;
					if ($i < $COLUMNAS) echo "<td>".$contenido."</td>";
					else break;
					$i++;
				}
					echo "<td><label><input type='radio' name='stand_id' value='".$id."'></label></td>";
				echo "</tr>";
			}
	
			echo "</table>";
		}	
	}
?>
	<input type='hidden' name='control' id='control' value='Abrir_Cerrar'>
	<input type='hidden' name='accion' id='accion' value='Abrir'>
	<p align="right" >
	<button type="submit" class="btn btn-default" <?php if(count($_SESSION['standAbiertos'])>0) echo "disabled='true'"?> >Abrir</button>
	</p>
</form>


	
<script type="text/javascript">

function validate() {
	var a = 0, rdbtn=document.getElementsByName("stand_id")
	for(i=0;i<rdbtn.length;i++) {
		if(rdbtn.item(i).checked == false) {
			a++;
		}
	}
	if(a == rdbtn.length) {
		alert("Por favor, seleccione un stand");
//		document.getElementById("pais").style.border = "2px solid red";
		return false;
	} else {
//		document.getElementById("pais").style.border = "";
	}
}
</script>

<form method='POST' name='form_stands_abiertos' id='form_stands_abiertos' action='../Controladores/CajaControl.php'>

<?php
	if(isset($_SESSION['standAbiertos'])){
		$array = $_SESSION['standAbiertos'];
		
		echo "<h3>Stand Abiertos: <small>".count($array)." encontrado(s)</small></h3>";
		if (count($array) > 0) {
			$COLUMNAS = 4;
			$i=0;
	
			echo "<table class='table table-hover'>";
			echo "<tr>";
			foreach ($array as $key => $value) {
				foreach ($value as $titulo => $contenido) {
					if ($i < $COLUMNAS) echo "<td><strong>".$titulo."</strong></td>";
					else break;
					$i++;
				}
				break;
			}
			echo "<td><strong>Seleccionar</strong></td>";
			echo "</tr>";
	
			foreach ($array as $key => $value) {
				$i=0;
				echo "<tr>";
				foreach ($value as $titulo => $contenido) {
					if ($titulo=='id') $id = $contenido;
					if ($i < $COLUMNAS) echo "<td>".$contenido."</td>";
					else break;
					$i++;
				}
					echo "<td><label><input type='radio' name='stand_id' value='".$id."' checked='true' ></label></td>";
				echo "</tr>";
			}
	
			echo "</table>";
		}	
	}
?>
	<input type='hidden' name='control' id='control' value='Abrir_Cerrar'>
	<input type='hidden' name='accion' id='accion' value='Cerrar'>
	<p align="right" >
	<button type="submit" class="btn btn-default" <?php if(count($_SESSION['standAbiertos'])<1) echo "disabled='true'"?> >Cerrar</button>
	</p>
</form>