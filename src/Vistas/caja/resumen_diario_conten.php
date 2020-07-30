<?php
	 $comprobantes = $_SESSION['comprobantes'];
     $contador01 =0;
     $subtotal=$j =0;
	?>
				<h3>REGISTRO DE VENTAS 2020</h3>
				<table class='table table-hover'>
					<thead>
						<tr>
							<td align='center'><strong>#</strong></td>
							<td align='center'><strong>COMPROBANTE</strong></td>
							<td align='center'><strong>TIPO</strong></td>
							<td align='center'><strong>DETALLE</strong></td>
							<td align='center'><strong>TOTAL</strong></td>
							<td align='center'><strong>ESTADO SUNAT</strong></td>
							<td align='center' Colspan="3"><strong>DOCUMENTOS</strong></td>							
							<td align='center' Colspan="2"><strong>OPCIONES</strong></td>
						</tr>
					</thead>
					<tbody>
	<?php	
 
foreach ($comprobantes as $value)
   {
	$contador01++;
	 ?>
	 
	 <tr>
	 	<td><?=$contador01?></td>
		<td><?=$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT) ?></td>
		<td><?=($value['comprobante_id']=='3')?'BV':'FV'?></td>
		<td></td>
		<td><?=$value['total']?> </td>

		<td>

<?php 


if(file_exists('../Controladores/sunat/cdr/R-20406231594-0'.$value['comprobante_id'].'-'.$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT).'.xml')){

	$texto = file( '../Controladores/sunat/cdr/R-20406231594-0'.$value['comprobante_id'].'-'.$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT).'.xml' );
	$xml = new SimpleXMLElement( $texto );
	$elementos = $xml->xpath('/ar:ApplicationResponse/cac:DocumentResponse/cac:Response/cbc:Description');
	print_r( $elementos );

	?>

<small class="label pull-right bg-green">Aceptado</small> 
<br> 
<button class="btn-danger btn-xs">Error!  Info</button>
	
</td>
	<?php
}else{
	echo '-';
}
?>
	
		
		<td>
		<?php 
		if(file_exists('../Controladores/sunat/xml_sin_firma/20406231594-0'.$value['comprobante_id'].'-'.$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT).'.xml')){
										if(file_exists('../Controladores/sunat/xml_firmado/20406231594-0'.$value['comprobante_id'].'-'.$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT).'.xml')){
											?>
											<a href="../Controladores/sunat/xml_firmado/20406231594-0<?=$value['comprobante_id']?>-<?=$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT)?>.xml" download class='btn btn-primary btn-xs'>
											<i class="fa fa-download"></i> XML
										</a>
											<?php
										}else {
											echo 'XML No Firmado';
										}}else{
											echo 'XML No Generado';
										}
										?>
		 </td>
		<td>
		<?php 
										if(file_exists('../Controladores/sunat/cdr/R-20406231594-0'.$value['comprobante_id'].'-'.$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT).'.xml')){
											?>
											<a href="../Controladores/sunat/cdr/R-20406231594-0<?=$value['comprobante_id']?>-<?=$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT)?>.xml" download class='btn btn-primary btn-xs'>
											<i class="fa fa-download"></i> CDR
										</a>
											<?php
										}else {
											?>
											CDR No Generado
											<?php
										}
										?>
		</td>
		<td><button class="btn btn-sm  "><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF</button></td>

		<td>
		
		<?php if(!file_exists('../Controladores/sunat/xml_sin_firma/20406231594-0'.$value['comprobante_id'].'-'.$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT).'.xml')){?>
		<a href="#" class='btn btn-primary btn-xs' title='Generar xml' onclick="erasoft_gen_xml(<?=$value['id']?>)">GEN XML</a> 
		<?php } ?>

		</td>
		<td>
		
		<?php if(file_exists('../Controladores/sunat/xml_sin_firma/20406231594-0'.$value['comprobante_id'].'-'.$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT).'.xml')){
			if(!file_exists('../Controladores/sunat/cdr/R-20406231594-0'.$value['comprobante_id'].'-'.$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT).'.xml')){?>
			<a href="#" class='btn btn-primary btn-xs' title='Firmar & Enviar xml' onclick="erasoft_send_and_firm_xml('20406231594-0<?=$value['comprobante_id']?>-<?=$value['serie']?>-<?=str_pad($value['correlativo'],8,0,STR_PAD_LEFT)?>')">SUNAT</a>
		<?php }} ?>

		</td>

	 </tr>
	 
	 
	 
	 <?php	
	
   } ?>
   </table>