<?php

	$errors = array();
	
	if ( (strlen(trim($_POST['factnum'])) == 0) && (strlen(trim($_POST['factnif'])) == 0)  && (strlen(trim($_POST['factnom'])) == 0)){
		$errors [] = "<font color='#FF0000'> Nº FACTURA / Nº NIF / RAZON SOCIAL:</font><br> UNO DE LOS TRES CAMPOS ES OBLIGATORIO";
		}

?>