<?php
 
 

 $s_id_factura = $_GET['f_id_factura']; 				// ID documento
require_once "../Modelos/DeudasModel.php";
$objRv = new DeudasModel();
$dataRv = $objRv->get_datos_comprobante($s_id_factura)[0];
$objRv2 = new DeudasModel();
$dataRvDet = $objRv2->get_datos_comprobante_det($s_id_factura) ;

/************************************************************************/   
	
    //CREACION DE XML DE DOCUMENTO FACTURA, BOLETA
   
	/*
	$text_qr = "$ruc1|$tipo_documento|$folio|$numero_factura1|$mto_igv|$total|$fecha|$tipo_documento_usuario|$documento_usuario|";
    $ruta_qr = "qr/" . $id_factura . ".png";
	QRcode::png($text_qr, $ruta_qr, 'Q', 9, 0);
	*/
	
	$doc = new DOMDocument();
    $doc->formatOutput = true;
    $doc->preserveWhiteSpace = true;
	$doc->encoding = 'utf-8';
	
/************************************************************************/
$tipo_documento = "03"; //BOLETA

$folio = $dataRv['serie']; 						// Serie doc
$numero_factura =   $dataRv['numeracion'] ; 	// NUMERACION
$fecha = $dataRv['fecha_documento']; 						// Fecha documento

$motivo = $dataRv['motivo'];						// Motivo
 
$ruc1 = $dataRv['empresa_ruc'];				// EMPRESA RUC
$nombre = $dataRv['EMPRESA_RAZON_SOCIAL']; 			// EMPRESA RAZON SOCUAL
$direccion = $dataRv['EMPRESA_DIRECCION']; 	// EMPRESA DIRECCION
  
$ruc = $dataRv["CLIENTE_RUC"];							// CLIENTE RUC
$dni = $dataRv["cliente_dni"];							// CLIENTE DNI
$nombre_cliente = $dataRv["cliente_nombre"]; 	// CLIENTE NOMBRE

$tipo_doc = $tipo_documento;

$razon_social_usuario = $nombre_cliente;

if ($ruc <> "") {
	$documento_usuario = $ruc;
	$tipo_documento_usuario = "6";
}
if ($ruc == "" and $dni <> "") {
	$documento_usuario = $dni;
	$tipo_documento_usuario = "1";
}
/*
 
$decimales = explode(".", number_format($subtotal, 2));
$entera = explode(".", $subtotal);
$texto_moneda = convertir($entera[0]) . ' y ' . $decimales[1] . '/100 NUEVOS SOLES';
 */
$texto_moneda ="Son  y 00/100 Soles";
$cabecera = array();
/********************************************** */ 


$cabecera["TIPO_OPERACION"] = '0101';
$cabecera["NRO_COMPROBANTE"] = $folio . "-" . $numero_factura;
$cabecera["FECHA_DOCUMENTO"] = $fecha;
$cabecera["FECHA_VTO"] = $fecha; 
$cabecera["TOTAL_LETRAS"] = $texto_moneda;
$cabecera["COD_TIPO_DOCUMENTO"] = $tipo_documento;
$cabecera["COD_MONEDA"] = "PEN";
$nums = '1';  										//Numero de items a registrar
$cabecera["NRO_OTR_COMPROBANTE"] = "";
$cabecera["NRO_GUIA_REMISION"] = ""; 
$cabecera["TIPO_DOCUMENTO_EMPRESA"] = 6;
$cabecera["NRO_DOCUMENTO_EMPRESA"] = $ruc1;;
$cabecera["RAZON_SOCIAL_EMPRESA"] = $nombre;
$cabecera["NOMBRE_COMERCIAL_EMPRESA"] = $nombre;
$cabecera["DEPARTAMENTO_EMPRESA"] = "PUNO"; //cambia
$cabecera["DISTRITO_EMPRESA"] = "JULIACA";
$cabecera["DIRECCION_EMPRESA"] = $direccion;
$cabecera["PROVINCIA_EMPRESA"] = "SAN ROMAN";
$cabecera["CONTACTO_EMPRESA"] = "";
$cabecera["CODIGO_PAIS_EMPRESA"] = "PEN";
$cabecera["TIPO_DOCUMENTO_CLIENTE"] = $tipo_documento_usuario;
$cabecera["NRO_DOCUMENTO_CLIENTE"] = $documento_usuario;
$cabecera["RAZON_SOCIAL_CLIENTE"] = $razon_social_usuario;
$cabecera["COD_UBIGEO_CLIENTE"] = "";
$cabecera["DEPARTAMENTO_CLIENTE"] = "";
$cabecera["PROVINCIA_CLIENTE"] = "";
$cabecera["DISTRITO_CLIENTE"] = "";
$cabecera["DIRECCION_CLIENTE"] = "";
$cabecera["COD_PAIS_CLIENTE"] = "PE";


$cabecera["TOTAL_GRAVADAS"] = $dataRv['total_gravadas']; 
$cabecera["TOTAL_GRATUITAS"] = $dataRv['total_gratuitas'];
$cabecera["TOTAL_EXONERADAS"] = $dataRv['total_exoneradas'];
$cabecera["TOTAL_INAFECTA"] = $dataRv['total_inafecta'];
$cabecera["TOTAL_OTR_IMP"] = $dataRv['total_otr_imp']; 
$cabecera["TOTAL_DESCUENTO"] = $dataRv['total_descueto'];
$cabecera["TOTAL"] = $dataRv['total'];
$cabecera["SUB_TOTAL"] = $dataRv['total'];
$cabecera["TOTAL_IGV"] = $dataRv['total_igv'] ;
 



/************************************************************************/
 


        $xmlCPE = '<?xml version="1.0" encoding="utf-8"?>
                <Invoice xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ccts="urn:un:unece:uncefact:documentation:2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2" xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2">
                	<ext:UBLExtensions>
                		<ext:UBLExtension>
                			<ext:ExtensionContent>
                			</ext:ExtensionContent>
                		</ext:UBLExtension>
                	</ext:UBLExtensions>
                	<cbc:UBLVersionID>2.1</cbc:UBLVersionID>
                	<cbc:CustomizationID schemeAgencyName="PE:SUNAT">2.0</cbc:CustomizationID>
                	<cbc:ProfileID schemeName="Tipo de Operacion" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo51">' . $cabecera["TIPO_OPERACION"] . '</cbc:ProfileID>
                	<cbc:ID>' . $cabecera["NRO_COMPROBANTE"] . '</cbc:ID>
                	<cbc:IssueDate>' . $cabecera["FECHA_DOCUMENTO"] . '</cbc:IssueDate>
                	<cbc:IssueTime>00:00:00</cbc:IssueTime>
                	<cbc:DueDate>' . $cabecera["FECHA_VTO"] . '</cbc:DueDate>
                	<cbc:InvoiceTypeCode listAgencyName="PE:SUNAT" listName="Tipo de Documento" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01" listID="0101" name="Tipo de Operacion" listSchemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo51">' . $cabecera["COD_TIPO_DOCUMENTO"] . '</cbc:InvoiceTypeCode>';
					   
					if ($cabecera["TOTAL_LETRAS"] <> "") {
                            $xmlCPE = $xmlCPE . '<cbc:Note languageLocaleID="1000">' . $cabecera["TOTAL_LETRAS"] . '</cbc:Note>';
						}
						
                        $xmlCPE = $xmlCPE . '<cbc:DocumentCurrencyCode listID="ISO 4217 Alpha" listName="Currency" listAgencyName="United Nations Economic Commission for Europe">' . $cabecera["COD_MONEDA"] . '</cbc:DocumentCurrencyCode>
                            <cbc:LineCountNumeric>' . $nums . '</cbc:LineCountNumeric>';
                        if ($cabecera["NRO_OTR_COMPROBANTE"] <> "") {
                            $xmlCPE = $xmlCPE . '<cac:OrderReference>
                                    <cbc:ID>' . $cabecera["NRO_OTR_COMPROBANTE"] . '</cbc:ID>
                            </cac:OrderReference>';
                        }
                     
                        $xmlCPE = $xmlCPE . '<cac:Signature>
						<cbc:ID>' . $cabecera["NRO_COMPROBANTE"] . '</cbc:ID>
						
                		<cac:SignatoryParty>
                			<cac:PartyIdentification>
                				<cbc:ID>' . $cabecera["NRO_DOCUMENTO_EMPRESA"] . '</cbc:ID>
                			</cac:PartyIdentification>
                			<cac:PartyName>
                				<cbc:Name>' . $cabecera["RAZON_SOCIAL_EMPRESA"] . '</cbc:Name>
                			</cac:PartyName>
                		</cac:SignatoryParty>
                		<cac:DigitalSignatureAttachment>
                			<cac:ExternalReference>
                				<cbc:URI>#' . $cabecera["NRO_COMPROBANTE"] . '</cbc:URI>
                			</cac:ExternalReference>
                		</cac:DigitalSignatureAttachment>
                	</cac:Signature>
                	<cac:AccountingSupplierParty>
                		<cac:Party>
                			<cac:PartyIdentification>
                				<cbc:ID schemeID="' . $cabecera["TIPO_DOCUMENTO_EMPRESA"] . '" schemeName="Documento de Identidad" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $cabecera["NRO_DOCUMENTO_EMPRESA"] . '</cbc:ID>
                			</cac:PartyIdentification>
                			<cac:PartyName>
                				<cbc:Name><![CDATA[' . $cabecera["NOMBRE_COMERCIAL_EMPRESA"] . ']]></cbc:Name>
                			</cac:PartyName>
                			<cac:PartyTaxScheme>
                				<cbc:RegistrationName><![CDATA[' . $cabecera["RAZON_SOCIAL_EMPRESA"] . ']]></cbc:RegistrationName>
                				<cbc:CompanyID schemeID="' . $cabecera["TIPO_DOCUMENTO_EMPRESA"] . '" schemeName="SUNAT:Identificador de Documento de Identidad" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $cabecera["NRO_DOCUMENTO_EMPRESA"] . '</cbc:CompanyID>
                				<cac:TaxScheme>
                					<cbc:ID schemeID="' . $cabecera["TIPO_DOCUMENTO_EMPRESA"] . '" schemeName="SUNAT:Identificador de Documento de Identidad" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $cabecera["NRO_DOCUMENTO_EMPRESA"] . '</cbc:ID>
                				</cac:TaxScheme>
                			</cac:PartyTaxScheme>
                			<cac:PartyLegalEntity>
                				<cbc:RegistrationName><![CDATA[' . $cabecera["RAZON_SOCIAL_EMPRESA"] . ']]></cbc:RegistrationName>
                				<cac:RegistrationAddress>
                					<cbc:ID schemeName="Ubigeos" schemeAgencyName="PE:INEI" />
                					<cbc:AddressTypeCode listAgencyName="PE:SUNAT" listName="Establecimientos anexos">0000</cbc:AddressTypeCode>
                					<cbc:CityName><![CDATA[' . $cabecera["DEPARTAMENTO_EMPRESA"] . ']]></cbc:CityName>
                					<cbc:CountrySubentity><![CDATA[' . $cabecera["PROVINCIA_EMPRESA"] . ']]></cbc:CountrySubentity>
                					<cbc:District><![CDATA[' . $cabecera["DISTRITO_EMPRESA"] . ']]></cbc:District>
                					<cac:AddressLine>
                						<cbc:Line><![CDATA[' . $cabecera["DIRECCION_EMPRESA"] . ']]></cbc:Line>
                					</cac:AddressLine>
                					<cac:Country>
                						<cbc:IdentificationCode listID="ISO 3166-1" listAgencyName="United Nations Economic Commission for Europe" listName="Country">' . $cabecera["CODIGO_PAIS_EMPRESA"] . '</cbc:IdentificationCode>
                					</cac:Country>
                				</cac:RegistrationAddress>
                			</cac:PartyLegalEntity>
                			<cac:Contact>
                				<cbc:Name><![CDATA[' . $cabecera["CONTACTO_EMPRESA"] . ']]></cbc:Name>
                			</cac:Contact>
                		</cac:Party>
                	</cac:AccountingSupplierParty>
                	<cac:AccountingCustomerParty>
                		<cac:Party>
                			<cac:PartyIdentification>
                				<cbc:ID schemeID="' . $cabecera["TIPO_DOCUMENTO_CLIENTE"] . '" schemeName="Documento de Identidad" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $cabecera["NRO_DOCUMENTO_CLIENTE"] . '</cbc:ID>
                			</cac:PartyIdentification>
                			<cac:PartyName>
                				<cbc:Name><![CDATA[' . $cabecera["RAZON_SOCIAL_CLIENTE"] . ']]></cbc:Name>
                			</cac:PartyName>
                			<cac:PartyTaxScheme>
                				<cbc:RegistrationName><![CDATA[' . $cabecera["RAZON_SOCIAL_CLIENTE"] . ']]></cbc:RegistrationName>
                				<cbc:CompanyID schemeID="' . $cabecera["TIPO_DOCUMENTO_CLIENTE"] . '" schemeName="SUNAT:Identificador de Documento de Identidad" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $cabecera["NRO_DOCUMENTO_CLIENTE"] . '</cbc:CompanyID>
                				<cac:TaxScheme>
                					<cbc:ID schemeID="' . $cabecera["TIPO_DOCUMENTO_CLIENTE"] . '" schemeName="SUNAT:Identificador de Documento de Identidad" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $cabecera["NRO_DOCUMENTO_CLIENTE"] . '</cbc:ID>
                				</cac:TaxScheme>
                			</cac:PartyTaxScheme>
                			<cac:PartyLegalEntity>
                				<cbc:RegistrationName><![CDATA[' . $cabecera["RAZON_SOCIAL_CLIENTE"] . ']]></cbc:RegistrationName>
                				<cac:RegistrationAddress>
                					<cbc:ID schemeName="Ubigeos" schemeAgencyName="PE:INEI">' . $cabecera["COD_UBIGEO_CLIENTE"] . '</cbc:ID>
                					<cbc:CityName><![CDATA[' . $cabecera["DEPARTAMENTO_CLIENTE"] . ']]></cbc:CityName>
                					<cbc:CountrySubentity><![CDATA[' . $cabecera["PROVINCIA_CLIENTE"] . ']]></cbc:CountrySubentity>
                					<cbc:District><![CDATA[' . $cabecera["DISTRITO_CLIENTE"] . ']]></cbc:District>
                					<cac:AddressLine>
                						<cbc:Line><![CDATA[' . $cabecera["DIRECCION_CLIENTE"] . ']]></cbc:Line>
                					</cac:AddressLine>                                        
                					<cac:Country>
                						<cbc:IdentificationCode listID="ISO 3166-1" listAgencyName="United Nations Economic Commission for Europe" listName="Country">' . $cabecera["COD_PAIS_CLIENTE"] . '</cbc:IdentificationCode>
                					</cac:Country>
                				</cac:RegistrationAddress>
                			</cac:PartyLegalEntity>
                		</cac:Party>
                	</cac:AccountingCustomerParty>
                	<cac:AllowanceCharge>
                		<cbc:ChargeIndicator>false</cbc:ChargeIndicator>
                		<cbc:AllowanceChargeReasonCode listName="Cargo/descuento" listAgencyName="PE:SUNAT" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo53">02</cbc:AllowanceChargeReasonCode>
                		<cbc:MultiplierFactorNumeric>0.00</cbc:MultiplierFactorNumeric>
                		<cbc:Amount currencyID="' . $cabecera["COD_MONEDA"] . '">0.00</cbc:Amount>
                		<cbc:BaseAmount currencyID="' . $cabecera["COD_MONEDA"] . '">0.00</cbc:BaseAmount>
                	</cac:AllowanceCharge>
                	<cac:TaxTotal>
                		<cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL_IGV"] . '</cbc:TaxAmount>
						';
						
						if ($cabecera["TOTAL_GRAVADAS"] > 0) {
                            $xmlCPE = $xmlCPE . '
							<cac:TaxSubtotal>
								<cbc:TaxableAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL_GRAVADAS"] . '</cbc:TaxableAmount>
								<cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL_IGV"] . '</cbc:TaxAmount>
								<cac:TaxCategory>
									<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">S</cbc:ID>
									<cac:TaxScheme>
										<cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">1000</cbc:ID>
										<cbc:Name>IGV</cbc:Name>
										<cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
									</cac:TaxScheme>
								</cac:TaxCategory>
							</cac:TaxSubtotal>';
						}
                        
                       
                        if ($cabecera["TOTAL_GRATUITAS"] > 0) {
                            $xmlCPE = $xmlCPE . '<cac:TaxSubtotal>
                			<cbc:TaxableAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL_GRATUITAS"] . '</cbc:TaxableAmount>
                			<cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">0.00</cbc:TaxAmount>
                			<cac:TaxCategory>
                				<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">Z</cbc:ID>
                				<cac:TaxScheme>
                					<cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID>
                					<cbc:Name>GRA</cbc:Name>
                					<cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                				</cac:TaxScheme>
                			</cac:TaxCategory>
                		</cac:TaxSubtotal>';
						}
						
                        if ($cabecera["TOTAL_EXONERADAS"] > 0) {
                            $xmlCPE = $xmlCPE . '<cac:TaxSubtotal>
                			<cbc:TaxableAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL_EXONERADAS"] . '</cbc:TaxableAmount>
                			<cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">0.00</cbc:TaxAmount>
                			<cac:TaxCategory>
                				<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                				<cac:TaxScheme>
                					<cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                					<cbc:Name>EXO</cbc:Name>
                					<cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                				</cac:TaxScheme>
                			</cac:TaxCategory>
                		</cac:TaxSubtotal>';
                        }
                        if ($cabecera["TOTAL_INAFECTA"] > 0) {
                            $xmlCPE = $xmlCPE . '<cac:TaxSubtotal>
                			<cbc:TaxableAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL_INAFECTA"] . '</cbc:TaxableAmount>
                			<cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">0.00</cbc:TaxAmount>
                			<cac:TaxCategory>
                				<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">O</cbc:ID>
                				<cac:TaxScheme>
                					<cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                					<cbc:Name>INA</cbc:Name>
                					<cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                				</cac:TaxScheme>
                			</cac:TaxCategory>
                		</cac:TaxSubtotal>';
                        }
                        if ($cabecera["TOTAL_OTR_IMP"] > 0) {
                            $xmlCPE = $xmlCPE . '<cac:TaxSubtotal>
                			<cbc:TaxableAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL_OTR_IMP"] . '</cbc:TaxableAmount>
                			<cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL_OTR_IMP"] . '</cbc:TaxAmount>
                			<cac:TaxCategory>
                				<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">S</cbc:ID>
                				<cac:TaxScheme>
                					<cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9999</cbc:ID>
                					<cbc:Name>OTR</cbc:Name>
                					<cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                				</cac:TaxScheme>
                			</cac:TaxCategory>
                		</cac:TaxSubtotal>';
                        }
                        //TOTAL=GRAVADA+IGV+EXONERADA
                        //NO ENTRA GRATUITA(INAFECTA) NI DESCUENTO
                        //SUB_TOTAL=PRECIO(SIN IGV) * CANTIDAD
                        $xmlCPE = $xmlCPE . '</cac:TaxTotal>
                	<cac:LegalMonetaryTotal>
                		<cbc:LineExtensionAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["SUB_TOTAL"] . '</cbc:LineExtensionAmount>
                		<cbc:TaxInclusiveAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL"] . '</cbc:TaxInclusiveAmount>
                		<cbc:AllowanceTotalAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL_DESCUENTO"] . '</cbc:AllowanceTotalAmount>
                		<cbc:ChargeTotalAmount currencyID="' . $cabecera["COD_MONEDA"] . '">0.00</cbc:ChargeTotalAmount>
                		<cbc:PayableAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL"] . '</cbc:PayableAmount>
                	</cac:LegalMonetaryTotal>';
						//LISTA DE PRODUCTOS
						
                       for ($i = 0;$i <= count($dataRvDet) - 1;$i++) {

							/** DETALLE **/

$cabecera["CANTIDAD_DET"] = $dataRvDet[$i]['CANTIDAD'];				//CANTIDAD
$cabecera["UNIDAD_MEDIDA"] = "NIU";			//UNIDAD MEDIDA
$cabecera["IMPORTE_DET"] = $dataRvDet[$i]['total'];				//IMPORTE
$cabecera["PRECIO_DET"] = $dataRvDet[$i]['precio'];				//PRECIO
$cabecera["PRECIO_TIPO_CODIGO"] = "01";		//TIPO PRECIO
$cabecera["IGV"] = $dataRvDet[$i]['igv'];						//IGV
$cabecera["POR_IGV"] = 18.00;				//PORCENTAJE IGV
$cabecera["COD_TIPO_OPERACION"] = $dataRvDet[$i]['tipo_igv'];		//TIPO IGV
$cabecera["DESCRIPCION_DET"] = $dataRvDet[$i]['detalle'];			// DETALLE 
$cabecera["CODIGO_DET"] = "";				// CODIGO DET
$cabecera["PRECIO_SIN_IGV_DET"] = $dataRvDet[$i]['precio_sin_igv'];		// PRECIO SIN IGV

/******************************************************************* */
 
                            $xmlCPE = $xmlCPE . '<cac:InvoiceLine>
                					<cbc:ID>' . $i . '</cbc:ID>
                					<cbc:InvoicedQuantity unitCode="' . $cabecera["UNIDAD_MEDIDA"] . '" unitCodeListID="UN/ECE rec 20" unitCodeListAgencyName="United Nations Economic Commission for Europe">' . $cabecera["CANTIDAD_DET"] . '</cbc:InvoicedQuantity>
                					<cbc:LineExtensionAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["IMPORTE_DET"] . '</cbc:LineExtensionAmount>
                					<cac:PricingReference>
                						<cac:AlternativeConditionPrice>
                							<cbc:PriceAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["PRECIO_DET"] . '</cbc:PriceAmount>
                							<cbc:PriceTypeCode listName="Tipo de Precio" listAgencyName="PE:SUNAT" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16">' . $cabecera["PRECIO_TIPO_CODIGO"] . '</cbc:PriceTypeCode>
                						</cac:AlternativeConditionPrice>
									</cac:PricingReference> ';
									if ($cabecera["COD_TIPO_OPERACION"] =="10") {
										$xmlCPE = $xmlCPE .'<cac:TaxTotal>
                						<cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["IGV"] . '</cbc:TaxAmount>
                						<cac:TaxSubtotal>
                							<cbc:TaxableAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["IMPORTE_DET"] . '</cbc:TaxableAmount>
                							<cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["IGV"] . '</cbc:TaxAmount>
                							<cac:TaxCategory>
                								<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">S</cbc:ID>
                								<cbc:Percent>' . $cabecera["POR_IGV"] . '</cbc:Percent>
												<cbc:TaxExemptionReasonCode listAgencyName="PE:SUNAT" listName="SUNAT:Codigo de Tipo de Afectación del IGV" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07">' . $cabecera["COD_TIPO_OPERACION"] . '</cbc:TaxExemptionReasonCode>
												
                								<cac:TaxScheme>
                									<cbc:ID schemeID="UN/ECE 5153" schemeName="Tax Scheme Identifier" schemeAgencyName="United Nations Economic Commission for Europe">1000</cbc:ID>
                									<cbc:Name>IGV</cbc:Name>
                									<cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
												</cac:TaxScheme>
												
                							</cac:TaxCategory>
                						</cac:TaxSubtotal>
                					</cac:TaxTotal>';
									 } else if ($cabecera["COD_TIPO_OPERACION"] =="30"){
										$xmlCPE = $xmlCPE .'
										<cac:TaxTotal> 
											<cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["IGV"] . '</cbc:TaxAmount>
											<cac:TaxSubtotal>
												<cbc:TaxableAmount currencyID="PEN">'.$cabecera["IMPORTE_DET"] .'</cbc:TaxableAmount>
												<cbc:TaxAmount currencyID="PEN">0.00</cbc:TaxAmount>
												<cac:TaxCategory>
													<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">O</cbc:ID>
													<cbc:Percent>0.00</cbc:Percent>
													<cbc:TaxExemptionReasonCode listAgencyName="PE:SUNAT" listName="SUNAT:Codigo de Tipo de Afectación del IGV" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07">' . $cabecera["COD_TIPO_OPERACION"] . '</cbc:TaxExemptionReasonCode>
													
													<cac:TaxScheme>
														<cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
														<cbc:Name>INA</cbc:Name>
														<cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
													</cac:TaxScheme>
												</cac:TaxCategory>
											</cac:TaxSubtotal> 
										</cac:TaxTotal>';
									 }else {

									 }
									 $xmlCPE = $xmlCPE .'
                					
                					<cac:Item>
                						<cbc:Description><![CDATA[' .  ((isset($cabecera["DESCRIPCION_DET"])) ? $cabecera["DESCRIPCION_DET"] : "") . ']]></cbc:Description>
                						<cac:SellersItemIdentification>
                							<cbc:ID><![CDATA[' .  ((isset($cabecera["CODIGO_DET"])) ? $cabecera["CODIGO_DET"] : "") . ']]></cbc:ID>
                						</cac:SellersItemIdentification>
                					</cac:Item>
                					<cac:Price>
                						<cbc:PriceAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["PRECIO_SIN_IGV_DET"] . '</cbc:PriceAmount>
                					</cac:Price>
                				</cac:InvoiceLine>';
        }
        $xmlCPE = $xmlCPE . '</Invoice>';
 
    $doc->loadXML($xmlCPE);
    //GUARDAR DOCUMENTO XML EN facturas-sin-firmar
    $doc->save("sunat/xml_sin_firma/$ruc1-$tipo_doc-$folio-$numero_factura.xml");
    chmod("sunat/xml_sin_firma/$ruc1-$tipo_doc-$folio-$numero_factura.xml", 0777);
  
	//header("location:ver_ticket.php?id_factura=$id_factura&motivo=$motivo&tipo=2&r=$texto_moneda");
?>
