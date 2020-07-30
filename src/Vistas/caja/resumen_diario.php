<!--div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li>XXXX</li>
		 <li> <?=$_SESSION["f_dia"]?></li>
		 <li> <?=$_SESSION["f_mes"]?></li>
		 <li>XXXX</li>
	</ul>
	
</div-->
<?php 


$s_dia =$_SESSION["f_dia"] ;
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
				<select class="form-control" id="f_dia" name="f_dia">
						<option value = "X">--Dia--</option>
						<option <?=($s_dia=="01")?"selected":"" ?> value = "01"> 1 </option>
						<option <?=($s_dia=="02")?"selected":"" ?> value = "02"> 2 </option>
						<option <?=($s_dia=="03")?"selected":"" ?> value = "03"> 3 </option>
						<option <?=($s_dia=="04")?"selected":"" ?> value = "04"> 4 </option>
						<option <?=($s_dia=="05")?"selected":"" ?> value = "05"> 5 </option>
						<option <?=($s_dia=="06")?"selected":"" ?> value = "06"> 6 </option>
						<option <?=($s_dia=="07")?"selected":"" ?> value = "07"> 7 </option>
						<option <?=($s_dia=="08")?"selected":"" ?> value = "08"> 8 </option>
						<option <?=($s_dia=="09")?"selected":"" ?> value = "09"> 9 </option>
						<option <?=($s_dia=="10")?"selected":"" ?> value = "10"> 10 </option>
						<option <?=($s_dia=="11")?"selected":"" ?> value = "11"> 11 </option>
						<option <?=($s_dia=="12")?"selected":"" ?> value = "12"> 12 </option>
						<option <?=($s_dia=="13")?"selected":"" ?> value = "13"> 13 </option>
						<option <?=($s_dia=="14")?"selected":"" ?> value = "14"> 14 </option>
						<option <?=($s_dia=="15")?"selected":"" ?> value = "15"> 15 </option>
						<option <?=($s_dia=="16")?"selected":"" ?> value = "16"> 16 </option>
						<option <?=($s_dia=="17")?"selected":"" ?> value = "17"> 17 </option>
						<option <?=($s_dia=="18")?"selected":"" ?> value = "18"> 18 </option>
						<option <?=($s_dia=="19")?"selected":"" ?> value = "19"> 19 </option>
						<option <?=($s_dia=="20")?"selected":"" ?> value = "20"> 20 </option>
						<option <?=($s_dia=="21")?"selected":"" ?> value = "21"> 21 </option>
						<option <?=($s_dia=="22")?"selected":"" ?> value = "22"> 22 </option>
						<option <?=($s_dia=="23")?"selected":"" ?> value = "23"> 23 </option>
						<option <?=($s_dia=="24")?"selected":"" ?> value = "24"> 24 </option>
						<option <?=($s_dia=="25")?"selected":"" ?> value = "25"> 25 </option>
						<option <?=($s_dia=="26")?"selected":"" ?> value = "26"> 26 </option>
						<option <?=($s_dia=="27")?"selected":"" ?> value = "27"> 27 </option>
						<option <?=($s_dia=="28")?"selected":"" ?> value = "28"> 28 </option>
						<option <?=($s_dia=="29")?"selected":"" ?> value = "29"> 29 </option>
						<option <?=($s_dia=="30")?"selected":"" ?> value = "30"> 30 </option>
						<option <?=($s_dia=="31")?"selected":"" ?> value = "31"> 31 </option>
				</select>
                </div> 
				<div class="col-xs-4">
					<button type="submit"class="btn btn-primary" onclick="sendRV()" >ENVIAR</button>
				</div>
					<input type="hidden" id="" name="control" value="Diario"/> 
				</form>
              </div>

	</div>		
	<div class="table-responsive">
	<?php
	 

			 
				$subtotal=$j=0;
	?>
				<h3>REGISTRO DE VENTAS</h3>
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
//echo $value['fecha'];
//$date=date_create($value['fecha']);
  //echo date_format($date,"d/m/Y");
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
<small class="label pull-right bg-green">ACEPTADO X</small>
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

		<td> 
        <a href="../Controladores/CrearPDF.php?f_id_factura=<?=$value['id']?>" target="_blank"> <i class="fa fa-file-pdf-o" aria-hidden="true" ></i>PDF</a>
        <!--button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal" onclick="cargarPDF()"><i class="fa fa-file-pdf-o" aria-hidden="true" ></i>PDF</button-->
        </td>

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

   <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
      <iframe src="http://www.google.com" width="100%" height="100%" frameborder="0" scrolling="yes" id="iframe"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
	</div>

</div>


<script type="text/javascript">

function cargarPDF(){

    $.ajax({
					url: "./caja/resumen_diario_pdf.php", 
					success: function(result){  
                        var htmlVal = '../Controladores/CrearPDF.php';
                        console.log(" => "+htmlVal);
                        $('#iframe').attr('src',htmlVal );
                        $('#iframe').reload();

                        var myFrame = $("#iframe").contents().find('body');  

                        myFrame.html(result); 

                        console.log("=>> : ",result);  

				},
				error :function(xhr,status,error)	{
					
				}}
				);

}

function sendRV()
{
	var  s_dia ="";
	var  s_mes ="";

	s_dia = $('#f_dia').val();
	s_mes = $('#f_mes').val();

	var pathname = window.location.pathname; // Returns path only (/path/example.html)
var url      = window.location.href;     // Returns full URL (https://example.com/path/example.html)
var origin   = window.location.origin;   // Returns base URL (https://example.com)

	//alert("Hi val Dia :"+s_dia+"  - Mes : "+s_mes);

	console.log("pathname : "+pathname);
	console.log("url : "+url);
	console.log("origin : "+origin);
 



}

function erasoft_gen_xml(id_efac){
			//VentanaCentrada('./pdf/documentos/enviar_sunat.php?fac='+id_factura,'Factura','','1024','768','true');
			

			$.ajax({
					url: "../Controladores/Boleta_ve.php?f_id_factura="+id_efac, 
					success: function(result){

						alert("Genero XMLL");
						location.reload();
				},
				error :function(xhr,status,error)	{
					alert("Error");
				}}
				);
		}
 


function erasoft_send_and_firm_xml(doc_fac){
	$.ajax({
					url: "../Controladores/Envia_sunat.php?fac="+doc_fac, 
					success: function(result){

						alert("Genero XMLL");
						location.reload();
						 
				},
				error :function(xhr,status,error)	{
					alert("Error");
				}}
				);
		}

		</script>
