<?php

	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
		$orden = $_POST['Orden'];
	}else{ $orden = '`factdate` ASC'; }

    global $vname; 		global $limit;
	global $sqlb; 		$sqlb =  "SELECT * FROM $vname WHERE 1 ";

	global $filtro;
	if($fil == ''){
		$filtro = '';
	}else{
		$filtro = " WHERE `factdate` LIKE '$fil' ";
	}

	$sqlb =  "SELECT * FROM $vname $filtro ORDER BY $orden $limit";
	//echo "--- ".$sqlb."<br>";

?>