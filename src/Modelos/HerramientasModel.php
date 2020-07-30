<?php  
require_once "Model.php";

class HerramientasModel extends Model {
	     
    public function __construct(){ 
        parent::__construct(); 
    } 

	public function numero_a_texto($monto){
		
		$unidad = ['CERO','UNO','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE'];
		$decenaEspecial = ['DIEZ','ONCE','DOCE','TRECE','CATORCE','QUINCE','DIECISEIS','DIECISIETE','DIECIOCHO','DIECINUEVE'];
		$decena = ['DIEZ','VEINTE','TREINTA','CUARENTA','CINCUENTA','SESENTA','SETENTA','OCHENTA','NOVENTA'];
		$centena = ['CIENTO','DOSCIENTOS','TRESCIENTOS','CUATROCIENTOS','QUINIENTOS','SEISCIENTOS','SETECIENTOS','OCHOCIENTOS','NOVECIENTOS'];

		$texto = '';
		$numero = number_format($monto,2);
		$array = str_split($numero);
		
		$millares = $centenas = $decenas = $unidades = $centimos = 0;
		$cadMillares = $cadCentenas = $cadDecenas = $cadUnidades = $cadCentimos = "";

		if(strlen($numero)==4){
			$unidades=$array[0];
			$centimos=$array['2'].$array['3'];
		} elseif (strlen($numero)==5){
			$decenas=$array[0];
			$unidades=$array[1];
			$centimos=$array['3'].$array['4'];
		} elseif ((strlen($numero)==6)) {
			$centenas=$array[0];
			$decenas=$array[1];
			$unidades=$array[2];
			$centimos=$array['4'].$array['5'];
		} elseif ((strlen($numero)==8)) {
			$millares=$array['0'];
			$centenas=$array['2'];
			$decenas=$array['3'];
			$unidades=$array['4'];
			$centimos=$array['6'].$array['7'];
		}

		$cadCentimos = " CON ".$centimos."/100 SOLES";
		
		//CREAMOS CADENA DE MILLARES
		if ($millares > 0) {
			if ($centenas==0 && $decenas==0 && $unidades==0) {
				$cadUnidades="-";
				if($millares==1){
					$cadMillares="UN MIL ";	
				} else {
					$cadMillares=$unidad[$millares]." MIL ";
				}
			} else {
				if($millares==1){
					$cadMillares="UN MIL ";	
				} else {
					$cadMillares=$unidad[$millares]." MIL ";
				}
			}
		} else {
			$cadMillares="-";
		}
		
		//CREAMOS LA CADENA DE CENTENAS
		if ($centenas > 0) {
			if ($decenas==0 && $unidades==0) {
				$cadUnidades="-";
				if($centenas==1){
					$cadCentenas="CIEN";
				} else {
					$cadCentenas=$centena[$centenas-1];
				}
			} else {
				$cadCentenas=$centena[$centenas-1];
			}
		} else {
			$cadCentenas="-";
		}
		
		//CREAMOS LA CADENA DE DECENAS
		if ($decenas > 0) {
			
			if($decenas == 1){
				$cadDecenas=" ".$decenaEspecial[$unidades];
				$cadUnidades="-";
			} elseif ($decenas == 2) {
				if($unidades==0){
					$cadDecenas=" ".$decena[1];
					$cadUnidades = "-";
				} else {
					$cadDecenas=" VEINTI".$unidad[$unidades];
				}
			} else {
				if ($unidades==0){
					$cadDecenas=" ".$decena[$decenas-1];
					$cadUnidades = "-";
				} else {
					$cadDecenas=" ".$decena[$decenas-1]." Y ";	
				}
			}
			
		} else {
			$cadDecenas="-";
		}
		
		if($cadUnidades!="-"){
			if($unidades >= 0){
				$cadUnidades=$unidad[$unidades];
			}
		}

		
		if ($cadMillares=="-")	$cadMillares="";
		if ($cadCentenas=="-")	$cadCentenas="";
		if ($cadDecenas=="-")	$cadDecenas="";
		if ($cadUnidades=="-")	$cadUnidades="";

//		$texto ="NUMERO=".$numero." UM=".$millares." C=".$centenas." D=".$decenas." U=".$unidades." C=".$centimos;
//		$texto1 = "<BR>";
		$texto2 = trim($cadMillares.$cadCentenas.$cadDecenas.$cadUnidades.$cadCentimos);
//		echo $texto;
//		echo $texto1;
//		echo $texto2;
		
//		break;
		parent::cerrar();
		return $texto2;
	} 

} 
?> 
