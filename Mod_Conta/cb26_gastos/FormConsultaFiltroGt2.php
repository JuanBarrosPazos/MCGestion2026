<?php

	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
		$orden = $_POST['Orden'];
	}else{ $orden = '`factdate` ASC'; }

    global $vname; 
	global $sqlb; 		$sqlb =  "SELECT * FROM $vname WHERE 1 ";

	// FACTURA Nº
	global $fnum;		global $or1;	global $or2;	global $key;	
	if(strlen(trim($_POST['factnum'])) == 0){
		$fnum = '';
		$sqlb .= " AND (";
		$or1 = '';
		$key = 0;
	}else{
		$fnum = "%".$_POST['factnum']."%";
		$or1 = 'OR';
		$sqlb .= " AND (`factnum` LIKE '$fnum' ";
		$key = 1;
	}
	global $factnum; 	$factnum = $_POST['factnum'];
	
	// NIF
	global $fnif;		
	if(strlen(trim($_POST['factnif'])) == 0){
		$fnif = '';
		if($or1 == ''){ $or2 = ''; } else { $or2 = 'OR'; }
		$sqlb .= "";
		$key = $key+0;
	}else{
		$fnif = $_POST['factnif'];
		$or2 = 'OR';
		$sqlb .= " $or1 `factnif` = '$fnif' ";
		$key = $key+1;
	}

	global $factnif; 	$factnif = $_POST['factnif'];
	
	// RAZON SOCIAL
	global $fnom;
	if(strlen(trim($_POST['factnom'])) == 0){
		$fnom = '';
		$sqlb .= "";
		$key = $key+0;
	}else{
		$fnom = $_POST['factnom'];
		$sqlb .= " $or2 `refprovee` = '$fnom' ";
		$key = $key+1;
	}
	global $factnom; 	$factnom = $_POST['factnom'];

	if(($fil == "%%")||($fil == '')){
		if($key == 0){ $sqlb .= ""; }else{ $sqlb .= ")"; }
	}else{
		$sqlb .= ") AND  (`factdate` LIKE '$fil')";
	}
		//$sqlb .= "OR  `factdate` LIKE '$fil' ";

	if($key == 0){ $sqlb =  "SELECT * FROM $vname "; }else{ }
	//echo $key."<br>";
	
	$sqlb .= " ORDER BY $orden ";
	//echo "-*- ".$sqlb."<br>";

?>