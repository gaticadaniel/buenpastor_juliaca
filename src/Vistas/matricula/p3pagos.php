<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_alumnos.submit()'>Lista de Alumnos<?php if(isset($_SESSION['p3llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick='javascript:document.form_pagos.submit()'>Condiciones Económicas <?php if(isset($_SESSION['p3pagosConfirmados'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_compromiso.submit()'>Compromiso de Pago<?php if(isset($_SESSION['p3firmantes'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_finalizar.submit()'>Finalizar</a></li>
	</ul>
	
	
	<form method='POST' name='form_alumnos' id='form_alumnos' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p3alumnos.php'>
	</form>
	<form method='POST' name='form_pagos' id='form_Pagos' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p3pagos.php'>
	</form>
	<form method='POST' name='form_compromiso' id='form_compromiso' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p3compromiso.php'>
	</form>
	<form method='POST' name='form_finalizar' id='form_finalizar' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p3finalizar.php'>
	</form>
</div>
</br>
<?php 
//print_r($_SESSION['p3pagos']);

//print_r($_SESSION['p3pagos']);
//print_r($_SESSION['p3descuentos']);
//print_r($_SESSION['p3apoderado']);

?>


<?php

if( isset($_SESSION['p3cuentas']) ){
	$cuentas = $_SESSION['p3cuentas'];
	for ($k=0; $k < count($cuentas); $k++) {
?>
		<h3><?=$cuentas[$k]['cuenta']?><small> Por favor seleccione el descuento si es que corresponde</small></h3>

		<div class="row">
			<div class="col-md-7">
				<strong>PAGOS</strong></td>
			
						<table class='table table-hover'>
							<tr>
								<td><strong>#</strong></td>
								<td><strong>DETALLE</strong></td>
								<td><strong>MONTO</strong></td>
								<td><strong>DESCUENTO (P.O.)</strong></td>
								<td><strong>FECHA DE COBRO</strong></td>
								<td><strong>VENCIMIENTO</strong></td>
							</tr>
<?php
							$j=0;
							for ($i=0; $i < count($_SESSION['p3pagos']) ; $i++) {
								$resultado = $_SESSION['p3pagos'];
								if ($resultado[$i]['cuenta']==$cuentas[$k]['cuenta']){
									$j++;
									echo "<tr>";
									echo "<td>".$j."</td>"; 
									echo "<td>".$resultado[$i]['detalle']."</td>";
									echo "<td>".$resultado[$i]['monto']."</td>";
									echo "<td>".$resultado[$i]['descuento_pago_oportuno']."</td>";	
									echo "<td>".$resultado[$i]['fecha_de_cobro']."</td>";
									echo "<td>".$resultado[$i]['fecha_vencimiento']."</td>";
									echo "</tr>";
								}
							}
?>
						</table>

			</div>
			<div class="col-md-5">
				<strong>DESCUENTOS</strong>

						<table class='table table-hover'>
							<tr>
								<td><strong>#</strong></td>
								<td><strong>DESCUENTO</strong></td>
								<td><strong>PORCENTAJE</strong></td>
								<td><strong>SELECCION</strong></td>
							</tr>
							<form method='POST' name='form_<?=$cuentas[$k]['cuenta']?>' id='form_periodo' action='../Controladores/MatriculaControl.php' onsubmit="return validate()">
<?php
							$j=0;
							for ($i=0; $i < count($_SESSION['p3descuentos']) ; $i++) {
								$resultado = $_SESSION['p3descuentos'];
								if ($resultado[$i]['cuenta']==$cuentas[$k]['cuenta']){
									$j++;
									echo "<tr>";
									echo "<td>".$j."</td>"; 
									echo "<td>".$resultado[$i]['descuento']."</td>";
									echo "<td>".$resultado[$i]['porcentaje']."</td>";
									if ($resultado[$i]['seleccion']==1) echo "<td><label><input type='radio' name='".$cuentas[$k]['cuenta']."' value='".$resultado[$i]['id']."' checked></label></td>";
									else echo "<td><label><input type='radio' name='id' value='".$resultado[$i]['id']."' onchange='this.form.submit()'></label></td>";
									echo "</tr>";
								}
							}
?>
								<input type='hidden' name='cuenta' id='cuenta' value='<?=$cuentas[$k]['cuenta']?>'>
								<input type='hidden' name='control' id='control' value='CalcularDescuentoP3'>
							</form>
						</table>
			</div>
		</div>
<?php
	}
}
?>
<div class="row">
	<div class="col-md-12" align="right">
		<form class="form-inline" role="form" name="form_pagos" id="form_pagos" method="POST" form action='../Controladores/MatriculaControl.php' >
	  				<input type='hidden' name='seguro' id='seguro' value='OK'>
	  				<input type='hidden' name='control' id='control' value='ConfirmarPagosP3'>
				<button type="submit" class="btn btn-default">Listo</button>
			</div>
		</form>
	</div>
</div>