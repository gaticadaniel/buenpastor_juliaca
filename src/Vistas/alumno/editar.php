<?php
if(isset($_SESSION['resultado']) && isset($_SESSION['llave'])){
	$resultado = $_SESSION['resultado'];
	$llave = $_SESSION['llave'];
	
	if(count($resultado)>0){
?>
		<h3>Editando<small> datos del estudiante </small></h3>
		
		<form class='form-horizontal' method="POST"  name="prueba" id="prueba" action="../Controladores/AlumnoControl.php">

<?php		foreach ($resultado as $key => $value) {
				if($key==$llave){
					foreach ($value as $key => $value) {
?>
						<div class="form-group">
							<label class="col-lg-2 control-label"><?=$key?></label>
							<div class="col-lg-10">
								<input type="text" class="form-control" name="<?=$key?>" placeholder="<?=$key?>" value="<?=$value?>">
							</div>
						</div>
<?php				}
				}
			}
?>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<input type="hidden" name="control" id="control" value="Prueba" >
					<button type="submit" class="btn btn-default">Guardar</button>
				</div>
			</div>

		</form>
<?php		
	}
}
?>