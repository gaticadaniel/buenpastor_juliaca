<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_fecha.submit()'>Definir Fecha<?php if(isset($_SESSION['p3fecha'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_alumnos.submit()'>Seleccionar Estudiante<?php if(isset($_SESSION['llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_estado_cuenta.submit()'>Estado de Cuenta<?php if(isset($_SESSION['boleta'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick='javascript:document.form_emitir_boleta.submit()'>Emitir Boleta</a></li>
	</ul>
	
	<form method='POST' name='form_fecha' id='form_fecha' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='fecha.php'>
	</form>
	<form method='POST' name='form_alumnos' id='form_alumnos' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='buscar.php'>
	</form>
	<form method='POST' name='form_estado_cuenta' id='form_estado_cuenta' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='estado_de_cuenta.php'>
	</form>
	<form method='POST' name='form_emitir_boleta' id='form_emitir_boleta' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='emitir_boleta.php'>
	</form>
</div>
</br>
<?php 
$style = "style='FONT-SIZE:10px; LINE-HEIGHT:8px; FONT-FAMILY:Lucida Console'";
$style2 = "style='FONT-SIZE:8px; LINE-HEIGHT:8px; FONT-FAMILY:Arial,Helvetica,sans-serif'";

if(isset($_SESSION['boleta'])){
	$boleta = $_SESSION['boleta'];
	//print_r($boleta);
	//echo $_SESSION['llave_deuda'];
}
?>

<div class="container">
	<br>
	<center>	
	<div align="center" id="ImprimirBoleta" name="ImprimirBoleta" style="border : solid 2px #000000;
            background : #F0F8FF;
            color : #696969;
            padding : 5px;
            width : 230px;
            height : 350px;
            overflow : auto; ">
		<div class="col-md-12">
			<table>
				<tr >
					<td colspan="3" width="200" align="center" <?=$style2 ?> >
						ASOCIACION EDUCATIVA DE GESTION N0 ESTATAL
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						<strong>“COLEGIO DE CIENCIAS BUEN PASTOR”</strong>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						R.D. N°2506-DREP
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						JR. SAN MARTÍN 421 INT.02
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						PUNO - SAN ROMÁN - JULIACA
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						RUC: 20406231594
					</td>
				</tr>
				<tr>
					<td colspan="3" >&nbsp;</td>
				</tr>

				<tr>
					<td colspan="3" width="180" align="center" <?=$style ?> >
						<strong><?=$boleta['titulo'] ?></strong>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						<strong>NRO: <?=$boleta['serie']." - ".str_pad($boleta['correlativo'],8,"0",STR_PAD_LEFT) ?></strong>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						SERIE: <?php if(isset($_SESSION['standAbiertos'])) echo $_SESSION['standAbiertos'][0]['serie_maquina'];?>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						<?=$boleta['fecha']."&nbsp;&nbsp;&nbsp;&nbsp;".$boleta['hora'] ?>
					</td>
				</tr>

				<tr>
					<td colspan="3" >&nbsp;</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="left" <?=$style ?> >
						Apellidos: <?=$_SESSION['alumnosCaja'][$_SESSION['llave']]['apellido_paterno']." ".$_SESSION['alumnosCaja'][$_SESSION['llave']]['apellido_materno'] ?>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="left" <?=$style ?> >
						Nombres: <?=$_SESSION['alumnosCaja'][$_SESSION['llave']]['nombres'] ?>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="left" <?=$style ?> >
						<?=$boleta['comentario'] ?>
					</td>
				</tr>

				<tr>
					<td colspan="3" >&nbsp;</td>
				</tr>
				<tr >
					<td width="135" align="center" <?=$style ?> ><strong>DESCRIPCION</strong></td>
					<td colspan="2" width="45" align="center" <?=$style ?> ><strong>IMPORTE</strong></td>
				</tr>
				<tr>
					<td  <?=$style ?> ><?=$boleta['detalle'] ?></td>
					<td <?=$style ?> >S/.</td>
					<td align="right" <?=$style ?> ><?=number_format($boleta['monto'],2) ?>&nbsp;</td>
				</tr>
				<tr>
					<td <?=$style ?> >Descuento</td>
					<td <?=$style ?> >S/.</td>
					<td align="right" <?=$style ?> ><?="-".number_format($boleta['descuento'],2) ?>&nbsp;</td>
				</tr>
				<tr>
					<td <?=$style ?> ><strong>Total</strong></td>
					<td <?=$style ?> >S/.</td>
					<td <?=$style ?> align="right"><strong><?=number_format($boleta['total'],2) ?>&nbsp;</strong></td>
				</tr>

				<tr>
					<td colspan="3" >&nbsp;</td>
				</tr>
				<tr>
					<td <?=$style ?> >Efectivo</td>
					<td <?=$style ?> >S/.</td>
					<td <?=$style ?> align="right"><?=number_format($boleta['efectivo'],2) ?>&nbsp;</td>
				</tr>
				<tr>
					<td <?=$style ?> >Vuelto</td>
					<td <?=$style ?> >S/.</td>
					<td <?=$style ?> align="right"><?=number_format($boleta['vuelto'],2) ?>&nbsp;</td>
				</tr>

				<tr>
					<td colspan="3" >&nbsp;</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="right" <?=$style ?> >
						Usuario: <?=$boleta['username'] ?>
					</td>
				</tr>

			</table>
			
		</div>
	<br>
</div>
</center>

	<div class="col-md-6" align="right">
			<button type="submit" class="btn btn-default" onclick="imprimir();" <?php if(!isset($_SESSION['boleta'])) echo "disabled='disabled'"?> >Imprimir</button>
	</div>


<script type="text/javascript">
	function imprimir(){
		var objeto=document.getElementById('ImprimirBoleta');  //obtenemos el objeto a imprimir
		var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
		ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
		ventana.document.close();  //cerramos el documento
		ventana.print();  //imprimimos la ventana
		ventana.close();  //cerramos la ventana
	}
</script>