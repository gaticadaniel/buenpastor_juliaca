<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once '../../vendor/autoload.php';

 


$s_id_factura = $_GET['f_id_factura']; 
use Spipu\Html2Pdf\Html2Pdf;
//$html= file_get_contents("../Vistas/caja/resumen_diario_pdf.php");

 

try
{
    ob_start();
    require_once './../Vistas/caja/resumen_diario_pdf.php';
    $html=ob_get_clean();
     
    $html2pdf=new HTML2PDF('P','A4','es','true','UTF-8');
     
    $html2pdf->writeHTML( ($html));
    $html2pdf->output();
    
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}