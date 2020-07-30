<?php

//$s_id_factura = $_GET['f_id_factura']; 				// ID documento
//$s_id_factura = 8; 				// ID documento
require './../Controladores/lib/CifrasEnLetras.php';
 
$letras = new  CifrasEnLetras();



require_once "./../Modelos/DeudasModel.php";
$objRv = new DeudasModel();
$dataRv = $objRv->get_datos_comprobante($s_id_factura)[0];
$objRv2 = new DeudasModel();
$dataRvDet = $objRv2->get_datos_comprobante_det($s_id_factura) ;

$numerosLetras = $letras->convertirSolesEnLetras($dataRv['total']);

$cliente_nombre=$dataRv['cliente_nombre'];
$cliente_direccion=$dataRv['cliente_direccion'];
$cliente_documento=$dataRv['cliente_dni'];
$cliente_documento_RUC=$dataRv['CLIENTE_RUC'];

$doc_fecha = $dataRv['fecha_documento'];
$doc_serie = $dataRv['serie'];
$doc_numero = $dataRv['numeracion'];
$doc_tipo = $dataRv['comprobante_id'];

$doc_imp_gravado = $dataRv['total_gravadas'];
$doc_imp_inafecta = $dataRv['total_inafecta'];
$doc_imp_exonerada = $dataRv['total_exoneradas'];
$doc_imp_gratuita = $dataRv['total_gratuitas'];
$doc_imp_descuento = $dataRv['total_descueto'];
$doc_imp_igv = $dataRv['total_igv'];
$doc_imp_total = $dataRv['total'];

$data_qr =  $dataRv['empresa_ruc'].'|'.$dataRv['serie'].'|'.$dataRv['numeracion'].'|'.number_format($dataRv['total_igv'], 2, '.', '').'|'. number_format($dataRv['total'], 2, '.', '') .'|'.$dataRv['fecha_documento'].'|1|'.$cliente_documento;

?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <style>
        h1{
            color:red;
        }
        #tableEfac{
        height:100px; 
        width:100px;
       /* border: 1; 
        border-color: green;*/
        }
        #tablaClienteDatos{
        padding:10px;
        margin:10px;
        height:100px; 
        width:100px;
      /*  border: 1; 
        border-color: green;*/
        }

        #tablaArticulos{ 
       /* border: 1; 
        border-color: green;*/
        border-collapse:collapse;
        padding:15px;
        margin-left:30px;
        margin-top:10px;
        width:100%;
        /*background-color: red;*/
        /*background-image: url('http://buenpastor.edu.pe/bpvirtual/imagenes/LogoEscudoBP.jpg');*/
        
 
        }
        .cld{
            border-spacing: 10px;
            border-collapse: separate;
        }
        #efacLogo{
            height:100px; 
            width:100px;
        }
        .efacNum{
          /*  border: 1; */
            border: 2px solid black; 
            border-radius: 25px; 
            padding-top: 25px;
            padding-bottom: 25px;
            padding-right: 15px; 
            padding-left: 15px;
            text-align : center; 
        }
        .efacTitulo{ 
            width:270px; 
         /*   border: 1; */
            padding-top: 0px;
            padding-bottom: 0px;
            padding-right: 15px;
            padding-left: 15px;
            text-align : center; 
        }
        .efaclogo{ 
           
        /*    border: 1; */
            padding-top: 0px;
            padding-bottom: 0px;
            padding-right: 15px;
            padding-left: 15px;
            text-align : center; 
        }
        .efacCliente{
         /*   border: 1; */
            padding-top: 25px;
            padding-bottom: 25px;
            padding-right: 0px;
            padding-left: 0px;
        }
        

     </style>
 </head>
 <body>
     <!--<h1  >Elvis Hola PDF ==>    <?php echo "ACEPTA PHP GOO"?></h1>-->

    
    <table  id="tableEfac"  >
      <!--  HEADER  -->
        <tr> 
            <td colspan="3" class="cld efaclogo">
                <img id="efacLogo" src="http://buenpastor.edu.pe/bpvirtual/imagenes/LogoEscudoBP.jpg" alt=""/> 
            </td> 
            
            <td colspan="3" class="cld efacTitulo">
                <h5>ASOC.EDUC.DE G.N.E.COL.DE CIEN.BUEN COLEGIO DE CIENCIAS BUEN PASTOR</h5>
                <h6>JR. SAN MARTIN NRO. 421 INT. 02 - CERCADO SAN ROMA  </h6>     
               <!--p>
               <?=print_r($dataRv)?></p-->
            </td>

            <td colspan="3" rowspan="2" class="cld efacNum"  >
                
                <p>
                 <b>R.U.C. 20406231594</b> <br>
                 <?php
                 if($doc_tipo=='3'){
                    ?>  BOLETA DE VENTA ELECTRONICA  <br>
                    <?php
                 }else if($doc_tipo=='5'){
                    ?>  FACTURA DE VENTA ELECTRONICA  <br>
                  <?php
                 }
                 ?>
                 <?=$doc_serie?>-<?=$doc_numero?> <br>
                 
                
                </p>
                

                
            </td>
             
           
        </tr>
        <tr>
        <td colspan="6" class="cld efacTitulo">
         

           
       </td> 
       </tr>
     </table>



        <table id="tablaClienteDatos" > 
            <!--td colspan="5" class="cld efacCliente"  id="tablaClienteDatos"-->
            
                    <tr>
                        <td><b>   CLIENTE :</b></td>
                        <td style="  width:250px;">   <?=$cliente_nombre?> </td>
                        <td><b>DIRECCION :</b></td>
                        <td style="  width:250px;"> <?=$cliente_direccion?> </td>
                    </tr> 
                    <tr> 
                        <td> <b>DNI/RUC:</b></td>
                        <td> <?=$cliente_documento?> </td>
                        <td> <b>FECHA:</b></td>
                        <td><?=$doc_fecha?></td>
                    </tr>   
        </table>

        <hr>
        <table id="tablaArticulos" >
        <!--  BODY  -->
            <thead>
                <tr >
                    <th style="border:1; padding-left:10px; padding-right:10px">#</th>
                    <th style="border:1; padding-left:10px; padding-right:10px">CANT</th>
                    <th style="border:1; padding-left:125px; padding-right:125px">DESCRIPCION</th>
                    <th style="border:1; padding-left:15px; padding-right:15px">PREC. UNI</th>
                    <th style="border:1; padding-left:15px; padding-right:15px">SUBTOTAL</th>
                     
                </tr>
            </thead>
            <tbody>
            <?php 
            $numRowPrint = 9;
            $numRow = 0;
            for ($ii = 0;$ii <= count($dataRvDet) - 1;$ii++) {
                $numRow++
                ?>
                <tr>
                    <td style="text-align : center; border-left:1;   padding-top:7.5px; padding-bottom:7.5px"><?=$numRow?></td>
                    <td style="text-align : center; "><?=$dataRvDet[$ii]['CANTIDAD']?></td>
                    <td><?=$dataRvDet[$ii]['detalle']?></td>
                    <td style="text-align : right; "><?=number_format($dataRvDet[$ii]['precio'], 2, '.', '')?></td>
                    <td style="text-align : right; border-right:1;   padding-top:7.5px; padding-bottom:7.5px"> <?= number_format($dataRvDet[$ii]['precio'], 2, '.', '')?></td> 
                </tr>
                <?php 
            }
            
            $numRowPrint = $numRowPrint - $numRow ;

            for($i=0;$i<=$numRowPrint;$i++){
                $numRow++;
            ?>
                <tr>
                    <td style="text-align : center; border-left:1;   padding-top:7.5px; padding-bottom:7.5px"><?=$numRow?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="border-right:1;   padding-top:7.5px; padding-bottom:7.5px"></td> 
                </tr>
                <?php 
}
                ?>   
                <tr>
                    <td colspan="5" style="border-left:1;border-right:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px"> </td>
                </tr>       
                <tr>
                    <td colspan="3" style="border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px">
                        Son : <?=$numerosLetras?>
                    </td>
                    <td style="border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px"> OP. GRAVADA</td>
                    <td style="text-align : right; border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px"> <?= number_format($doc_imp_gravado, 2, '.', '') ?></td> 
                </tr>    
                
                <tr>
                    <td colspan="2" rowspan="6"    >
                        <!--img style="height:100px; width:100px;" src="http://buenpastor.edu.pe/bpvirtual/src/Controladores/sunat/qr/QR-123456789-03-B501-00000045.png" alt=""-->
                        <img src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=<?=$data_qr?>&choe=UTF-8" title="Link to Google.com" />
                        
                    </td>
                    <td colspan="1" rowspan="6" style="width:200px; border-right:1;"  >
                        
                    Autorizado mediante Resolución de Intendencia No Representación impresa de Boleta Electrónica.
     
                    </td>
                    <td style="border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px">OP. INAFECTA</td>
                    <td style="text-align : right; border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px; padding-right:7.5px;"><?= number_format($doc_imp_inafecta, 2, '.', '') ?></td> 
                </tr>   
                
                <tr>
                    
                    <td style="border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px"> OP. EXONERADA</td>
                    <td style="text-align : right; border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px; padding-right:7.5px;"><?= number_format($doc_imp_exonerada, 2, '.', '') ?> </td> 
                </tr>   
                
                <tr>
                    
                    <td style="border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px">OP. GRATUITA</td>
                    <td style="text-align : right; border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px; padding-right:7.5px;"><?= number_format($doc_imp_gratuita, 2, '.', '') ?> </td> 
                </tr>   
                <tr>
                     
                    <td style="border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px">DESCUENTOS</td>
                    <td style="text-align : right; border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px; padding-right:7.5px;"><?= number_format($doc_imp_descuento, 2, '.', '') ?> </td> 
                </tr>     
                <tr>
                     
                    <td style="border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px">IGV</td>
                    <td style="text-align : right; border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px; padding-right:7.5px;"><?= number_format($doc_imp_igv, 2, '.', '') ?> </td> 
                </tr>     
                <tr>
                     
                    <td style="border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px">PRECIO DE VENTA</td>
                    <td style="text-align : right; border:1; border-bottom:1; padding-top:7.5px; padding-bottom:7.5px; padding-right:7.5px;"><?= number_format($doc_imp_total, 2, '.', '') ?> </td> 
                </tr>     
                
            </tbody>
             
        </table>
 
    

 </body>
 </html>