<?php

	// RAZON SOCIAL
	if($_POST['factnom'] == ''){$fnom = 'ññ';}
	else{$fnom = $_POST['factnom'];}
	global $factnom; 	$factnom = $_POST['factnom'];
	// NIF
	if($_POST['factnif'] == ''){$fnif = 'ññ';}
	else{$fnif = $_POST['factnif'];}
	global $factnif; 	$factnif = $_POST['factnif'];
	// FACTURA Nº
	if($_POST['factnum'] == ''){$fnum = 'ññ';}
	else{$fnum = $_POST['factnum'];}
	global $factnum; 	$factnum = $_POST['factnum'];
	// ORDEN
	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
		$orden = $_POST['Orden'];
	}else{ $orden = '`id` ASC'; }



?>