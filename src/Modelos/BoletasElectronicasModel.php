<?php  
require_once "Model.php";

class BoletasElectronicasModel extends Model {
	     
    public function __construct(){ 
        parent::__construct(); 
    } 


	public function anular_boleta_por_id($idBoleta){
	} 

	public function guardar_boleta_electronica($boleta){

		//DATOS PARA LA BOLETA: ESTANDAR UBL 2.1

		//DATOS DE LA CABECERA DE LA BOLETA
		$boletaCab['tipOperacion']='0101';							//VENTA INTERNA
		$boletaCab['fecEmision']=$boleta['fecha'];
		$boletaCab['horEmision']=$boleta['hora'];
		$boletaCab['fecVencimiento']='-';
		$boletaCab['codLocalEmisor']='0001';						// Código de domicilio fiscal o de local anexo del emisor
		$boletaCab['tipDocUsuario']='1';							// Catálogo 6: 1-DNI, 4-CarnetExtrajeria, 6-RUC
		$boletaCab['numDocUsuario']=$boleta['dni'];
		$boletaCab['rznSocialUsuario']=$boleta['usuario'];
		$boletaCab['tipMoneda']='PEN';								//Tipo de Moneda Soles de Peru = PEN
		$boletaCab['sumTotTributos']=0.00;							// Sumatoria Total de Tributos
		$boletaCab['sumTotValVenta']=$boleta['monto'];
		$boletaCab['sumPrecioVenta']=$boletaCab['sumTotTributos']+$boletaCab['sumTotValVenta'];
		$boletaCab['sumDescTotal']=$boleta['descuento'];
		$boletaCab['sumOtrosCargos']=0.00;
		$boletaCab['sumTotalAnticipos']=0.00;
		$boletaCab['sumImpVenta']=$boletaCab['sumPrecioVenta']-$boletaCab['sumDescTotal']+$boletaCab['sumOtrosCargos']-$boletaCab['sumTotalAnticipos'];
		$boletaCab['ublVersionId']='2.1';
		$boletaCab['customizationId']='2.0';

		//DATOS DEL DETALLE DE LA BOLETA
		$boletaDet['codUnidadMedida']='ZZ';
		$boletaDet['ctdUnidadItem']=1;
		$boletaDet['codProducto']=$boleta['subcuenta_id'];
		$boletaDet['codProductoSunat']='-';
		$boletaDet['desItem']=$boleta['detalle'];
		
		if ($boleta['total']==0) $boletaDet['mtoValorUnitario']=$boleta['total']; else $boletaDet['mtoValorUnitario']=$boleta['monto']; //monto
		
		$boletaDet['sumTotTributosItem']=0.00; // sumar 9+16+26 ojooooooooooooooooooooooooooooooooo

		if ($boleta['total']==0) $transferencia="GRATUITA"; else $transferencia="EXONERADO";
		
		//9997=EXONERADO - VAT - EXO, 9996=GRATUITO -FRE - GRA,  CATALOGO 5
		
		if ($transferencia=="GRATUITA") {
			$boletaDet['codTriIGV']='9996';	//8
			$boletaDet['mtoIgvItem']=0.00; //9
			$boletaDet['mtoBaseIgvItem']=$boleta['monto']; //10
			$boletaDet['nomTributoIgvItem']='GRA'; //11
			$boletaDet['codTipTributoIgvItem']='FRE'; //12
			
		}

		if ($transferencia=="EXONERADO") {
			$boletaDet['codTriIGV']='9997'; //8
			$boletaDet['mtoIgvItem']=0.00; //9
			$boletaDet['mtoBaseIgvItem']=$boleta['total']; //10
			$boletaDet['nomTributoIgvItem']='EXO'; //11
			$boletaDet['codTipTributoIgvItem']='VAT'; //12	
		}

		if ($boleta['total']==0) $boletaDet['tipAfeIGV']='21'; else $boletaDet['tipAfeIGV']='20';
		$boletaDet['porIgvItem']='18.00';
		$boletaDet['codTriISC']='-';
		
		$boletaDet['mtoIscItem']=0.00;
		$boletaDet['mtoBaseIscItem']=0.00;		//
		$boletaDet['nomTributoIscItem']='';		//CATALOGO 5: ISC
		$boletaDet['codTipTributoIscItem']='';	//CATALOGO 5: EXC
		$boletaDet['tipSisISC']='';
		
		$boletaDet['porIscItem']=15.00;
		$boletaDet['codTriOtroItem']='-';
		$boletaDet['mtoTriOtroItem']=0.00;
		$boletaDet['mtoBaseTriOtroItem']=0.00;
		$boletaDet['nomTributoIOtroItem']='';
		$boletaDet['codTipTributoIOtroItem']='';
		
		$boletaDet['porTriOtroItem']=15.00;
		
		if ($boleta['total']==0) {
			$boletaDet['mtoPrecioVentaUnitario']=$boleta['total']; 
			$boletaDet['mtoValorVentaItem']=$boletaDet['ctdUnidadItem']*$boletaDet['mtoPrecioVentaUnitario'];
			$boletaDet['mtoValorReferencialUnitario']=$boleta['descuento'];
		} else {
			$boletaDet['mtoPrecioVentaUnitario']=$boleta['total']; //monto
			$boletaDet['mtoValorVentaItem']=$boletaDet['ctdUnidadItem']*$boleta['monto']-$boletaCab['sumDescTotal']; //$boletaDet['ctdUnidadItem']*$boletaDet['mtoPrecioVentaUnitario']-$boletaCab['sumDescTotal'];
			$boletaDet['mtoValorReferencialUnitario']=0.00;
		}
		

					//DATOS PARA EL ARCHIVO LEYENDA
			$boleta['codLeyenda']= "";
			$boleta['desLeyenda']= "";
			if($boleta['total']>0){
				//CONVERTIMOS EL TOTAL DE NUMEROS A LETRAS
				require_once "../Modelos/HerramientasModel.php";
				$objHerramientas = new HerramientasModel();
				$boleta['desLeyenda']=$objHerramientas->numero_a_texto($boleta['total']);
				$boleta['codLeyenda']= "1000";
			} else {
				$boleta['desLeyenda']="TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE";
				$boleta['codLeyenda']= "1002";
			}
		
		
		$boletaLey['codLeyenda']=$boleta['codLeyenda'];
		$boletaLey['desLeyenda']=$boleta['desLeyenda'];
		
		$boletaTri['codTriIGV']=$boletaDet['codTriIGV'];
		$boletaTri['nomTributoIgvItem']=$boletaDet['nomTributoIgvItem'];	 //CATALOGO 5: NOMBRE
		$boletaTri['codTipTributoIgvItem']=$boletaDet['codTipTributoIgvItem'];		//CATALOGO 5: codigo internacional
		$boletaTri['mtoBaseIgvItem']=$boletaDet['mtoBaseIgvItem'];
		$boletaTri['mtoIgvItem']=$boletaDet['mtoIgvItem'];

		//CREAMOS LOS ARCHIVOS DE TEXTO				C:\SFS_v1.2\sunat_archivos\sfs\DATA\
		//ARCHIVO.CAB
		$archivoCab="20406231594-03-".$boleta['serie']."-".str_pad($boleta['correlativo'],8,"0",STR_PAD_LEFT).".CAB";
		$cabecera=fopen('C:\\SFS_v1.2\\sunat_archivos\\sfs\\DATA\\'.$archivoCab,"a");
		fwrite($cabecera,implode("|", $boletaCab)."|");
		fclose($cabecera);

		//ARCHIVO.DET
		$archivoDet="20406231594-03-".$boleta['serie']."-".str_pad($boleta['correlativo'],8,"0",STR_PAD_LEFT).".DET";
		$detalle=fopen('C:\\SFS_v1.2\\sunat_archivos\\sfs\\DATA\\'.$archivoDet,"a");
		fwrite($detalle,implode("|", $boletaDet)."|");
		fclose($detalle);

		//ARCHIVO.LEY
		$archivoLey="20406231594-03-".$boleta['serie']."-".str_pad($boleta['correlativo'],8,"0",STR_PAD_LEFT).".LEY";
		$leyenda=fopen('C:\\SFS_v1.2\\sunat_archivos\\sfs\\DATA\\'.$archivoLey,"a");
		fwrite($leyenda,implode("|", $boletaLey)."|");
		fclose($leyenda);

		//ARCHIVO.TRI
		$archivoTri="20406231594-03-".$boleta['serie']."-".str_pad($boleta['correlativo'],8,"0",STR_PAD_LEFT).".TRI";
		$tributo=fopen('C:\\SFS_v1.2\\sunat_archivos\\sfs\\DATA\\'.$archivoTri,"a");
		fwrite($tributo,implode("|", $boletaTri)."|");
		fclose($tributo);
		
		return true;
		
		parent::cerrar();
	} 
} 
?> 
