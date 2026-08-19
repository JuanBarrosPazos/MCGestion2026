<?php

	// REF CLIENTE & RAZON SOCIAL
	global $oper, $openPar, $closePar;
	if((strlen(trim($_POST['ref'])) == 0)||(strlen(trim($_POST['rsocial'])) == 0)){
		//$ref = "`ref` = ".trim($_POST['ref'])."%";
		$oper = "";
		$openPar = "";
		$closePar = "";
	}elseif((strlen(trim($_POST['ref'])) != 0)&&(strlen(trim($_POST['rsocial'])) != 0)){
		$openPar = "(";
		$closePar = ")";
		$oper = " OR ";
	}
	
	if((strlen(trim($_POST['ref'])) != 0)){
		$ref = $openPar." `ref` LIKE '%".trim($_POST['ref'])."%' ";
	}else{ $ref = ""; }

	if((strlen(trim($_POST['rsocial'])) != 0)){
		$rso = $oper." `rsocial` LIKE '%".$_POST['rsocial']."%' ".$closePar;
	}else{ $rso = ""; }
	
	// NIF
    /*
    if($_POST['dni'] == ''){$dni = '';}
    else{$dni = $_POST['dni'];}
    global $dnie; 		$dnie = $_POST['dni'];
    */
    
    // ORDEN
    global $orden;
    if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
        $orden = $_POST['Orden'];
    }else{ $orden = '`id` ASC'; }


?>