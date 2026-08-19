<?php

	// RAZON SOCIAL
    if($_POST['rsocial'] == ''){$rso = '';}
    else{$rso = "%".$_POST['rsocial']."%";}
    global $rsocial; 		$rsocial = $_POST['rsocial'];
	// NIF
    /*
    if($_POST['dni'] == ''){$dni = '';}
    else{$dni = $_POST['dni'];}
    global $dnie; 		$dnie = $_POST['dni'];
    */
	// REF PROVEEDOR
    if($_POST['ref'] == ''){$ref = '';}
    else{$ref = $_POST['ref'];}
    global $refer; 		$refer = $_POST['ref'];
    // ORDEN
    global $orden;
    if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
        $orden = $_POST['Orden'];
    }else{ $orden = '`id` ASC'; }


?>