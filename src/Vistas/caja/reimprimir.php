<?php 
$style = "style='FONT-SIZE:10px; LINE-HEIGHT:8px; FONT-FAMILY:Lucida Console'";
$style2 = "style='FONT-SIZE:8px; LINE-HEIGHT:8px; FONT-FAMILY:Arial,Helvetica,sans-serif'";

session_start();
if(isset($_SESSION['boletas_pendientes'])){
	$boleta = $_SESSION['boletas_pendientes'];
}
$orden = $_GET['orden'];
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
						<strong>TICKET BOLETA</strong>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						<strong>NRO: <?=str_pad($boleta[$orden]['serie'],3,"0",STR_PAD_LEFT)." - ".str_pad($boleta[$orden]['correlativo'],8,"0",STR_PAD_LEFT) ?></strong>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						SERIE: <?=$boleta[$orden]['serie_maquina'];?>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="center" <?=$style ?> >
						<?=$boleta[$orden]['fecha']."&nbsp;&nbsp;&nbsp;&nbsp;".substr($boleta[$orden]['hora'], 0,-3) ?>
					</td>
				</tr>

				<tr>
					<td colspan="3" >&nbsp;</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="left" <?=$style ?> >
						Apellidos: <?=$boleta[$orden]['apellido_paterno']." ".$boleta[$orden]['apellido_materno'] ?>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="left" <?=$style ?> >
						Nombres: <?=$boleta[$orden]['nombres'] ?>
					</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="left" <?=$style ?> >
						<?=$boleta[$orden]['comentario'] ?>
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
					<td  <?=$style ?> ><?=$boleta[$orden]['detalle'] ?></td>
					<td <?=$style ?> >S/</td>
					<td align="right" <?=$style ?> ><?=number_format($boleta[$orden]['monto'],2) ?>&nbsp;</td>
				</tr>
				<tr>
					<td <?=$style ?> >Descuento</td>
					<td <?=$style ?> >S/</td>
					<td align="right" <?=$style ?> ><?="-".number_format($boleta[$orden]['descuento'],2) ?></td>
				</tr>
				<tr>
					<td <?=$style ?> ><strong>Total</strong></td>
					<td <?=$style ?> >S/</td>
					<td <?=$style ?> align="right"><strong><?=number_format($boleta[$orden]['total'],2) ?>&nbsp;</strong></td>
				</tr>

				<tr>
					<td colspan="3" >&nbsp;</td>
				</tr>
				<tr>
					<td <?=$style ?> >Efectivo</td>
					<td <?=$style ?> >S/</td>
					<td <?=$style ?> align="right"><?=number_format($boleta[$orden]['efectivo'],2) ?>&nbsp;</td>
				</tr>
				<tr>
					<td <?=$style ?> >Vuelto</td>
					<td <?=$style ?> >S/</td>
					<td <?=$style ?> align="right"><?=number_format($boleta[$orden]['vuelto'],2) ?>&nbsp;</td>
				</tr>

				<tr>
					<td colspan="3" >&nbsp;</td>
				</tr>
				<tr >
					<td colspan="3" width="180" align="right" <?=$style ?> >
						Usuario: <?=$boleta[$orden]['username'] ?>
					</td>
				</tr>

			</table>
			
		</div>
	<br>
</div>
</center>

	<div class="col-md-6" align="right">
			<button type="submit" class="btn btn-default" onclick="imprimir();" <?php if(!isset($_SESSION['boletas_pendientes'])) echo "disabled='disabled'"?> >Imprimir</button>
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