<?php 
 
//$s_dia =$_SESSION["f_dia"] ;
$s_mes =$_SESSION["f_mes"] ; 
 
$comprobantes = $_SESSION['comprobantes'];
$contador01 =0;
 
require_once '../../vendor/autoload.php';

$client = new GuzzleHttp\Client(['timeout'=>200.0]);

$s_token_efac =(isset($_SESSION["f_token_efac"]))?$_SESSION["f_token_efac"]:'X';

if($s_token_efac=='X'){
	$respAuth = $client->request('POST', 'https://api-seguridad.sunat.gob.pe/v1/clientesextranet/04e43703-8e6d-4902-9666-dfbb02fc3502/oauth2/token/', [
		'form_params' => [
			'grant_type' => 'client_credentials',
			'scope' => 'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes',
			'client_id' => '04e43703-8e6d-4902-9666-dfbb02fc3502',
			'client_secret' => '9N0HWP7uHtTPOqZE/pzptA=='
		]
	]); 
	
	$charAuth = json_decode($respAuth->getBody());
	$s_token_efac =$charAuth->access_token;
	$_SESSION["f_token_efac"] =$charAuth->access_token;
}
 



//echo $charAuth->access_token;


?>

<div class="container mb-4">
	<div class=" ">
	<div class="row mb-4">
		<form action="../Controladores/CajaControl.php" method="post">
		
                <div class="col-xs-4">
				    <select class="form-control" id="f_mes" name="f_mes">
						<option value="X">-->Mes<--</option>
						<option <?=($s_mes=="01")?"selected":"" ?> value="01">Enero </option>
						<option <?=($s_mes=="02")?"selected":"" ?> value="02">Febrero</option>
						<option <?=($s_mes=="03")?"selected":"" ?> value="03">Marzo</option>
						<option <?=($s_mes=="04")?"selected":"" ?> value="04">Abril</option>
						<option <?=($s_mes=="05")?"selected":"" ?> value="05">Mayo</option>
						<option <?=($s_mes=="06")?"selected":"" ?> value="06">Junio</option>
						<option <?=($s_mes=="07")?"selected":"" ?> value="07">Julio</option>
						<option <?=($s_mes=="08")?"selected":"" ?> value="08">Agosto</option>
						<option <?=($s_mes=="09")?"selected":"" ?> value="09">Setiembre</option>
						<option <?=($s_mes=="10")?"selected":"" ?> value="10">Octubre</option>
						<option <?=($s_mes=="11")?"selected":"" ?> value="11">Noviembre</option>
						<option <?=($s_mes=="12")?"selected":"" ?> value="12">Diciembre</option>
                    </select>
                </div> 
				<div class="col-xs-4">
					<button type="submit"class="btn btn-primary" onclick="sendRV()" >ENVIAR</button>
				</div>
					<input type="hidden" id="" name="control" value="Resumen"/> 
				</form>
              </div>

	</div>		
	<div class="table-responsive">
	<?php
	 

			 
				$subtotal=$j=0;
	?>
				<h3>RESUMEN DE VENTAS BUEN PASTOR</h3>
				<table class='table table-hover'>
					<thead>
						<tr>
							<td align='center'><strong>#</strong></td>
							<td align='center'><strong>COMPROBANTE</strong></td>
							<td align='center'><strong>TIPO</strong></td>
							<td align='center'><strong>FECHA</strong></td>
							<td align='center'><strong>DETALLE</strong></td>
							<td align='center'><strong>TOTAL</strong></td>
							<td align='center'><strong>ESTADO SUNAT</strong></td> 
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
		<td><?=$value['fecha']?> </td>
		<td></td>
		<td><?=$value['total']?> </td>

		<td>

<?php  
if(file_exists('../Controladores/sunat/cdr/R-20406231594-0'.$value['comprobante_id'].'-'.$value['serie'].'-'.str_pad($value['correlativo'],8,"0",STR_PAD_LEFT).'.xml')){

	$respComprobante = $client->request('POST', 'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes/20406231594/validarcomprobante', [
		'body' => '{"numRuc": "20406231594","codComp": "0'.$value['comprobante_id'].'","numeroSerie": "'.$value['serie'].'","numero": "'.$value['correlativo'].'","fechaEmision": "'. $value['fecha'].'","monto": "'.number_format($value['total'], 2, '.', '').'"}',
		'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json','Authorization' => 'Bearer '.$s_token_efac ]
	]);
	
	$charComprobante = json_decode($respComprobante->getBody()); 
 
	$stateCp = $charComprobante->data->estadoCp;
	
	if($stateCp=="0"){
		?>
<button class="btn-danger btn-xs">Error!  NO EXISTE</button>
		<?php
	}
	if($stateCp=="1"){
		?> 
<small class="label pull-right bg-green">ACEPTADO  </small>
		<?php
	}
	if($stateCp=="2"){
		?>
<small class="label pull-right bg-purple">ANULADo</small>
		<?php
	}
	if($stateCp=="3"){
		?>
<small class="label pull-right bg-green">AUTORIZADO</small>
		<?php
	}
	if($stateCp=="4"){
		?>
<button class="btn-danger btn-xs">Error!  AUTORIZADO</button>
		<?php
	}

	?>

 
<br> 
 
	
</td>
	<?php
}else{
	echo 'No Enviado';
}
?>
	
		 

	 </tr>
	 
	 
	 
	 <?php	
	
   } ?>
   </table>
 