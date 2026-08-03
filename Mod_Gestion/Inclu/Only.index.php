<?php
 
if((isset($_POST['Usuario'])&&(isset($_POST['Password'])))){

	require "config/TablesNames.php";
	
	global $Admin;	global $db;

	$sql =  "SELECT * FROM $Admin WHERE `Usuario` = '$_POST[Usuario]' AND `Password` = '$_POST[Password]'";
	$q = mysqli_query($db, $sql);
	$row = mysqli_fetch_assoc($q);
	$q = mysqli_query($db, $sql);
	global $row;		$row = mysqli_fetch_assoc($q);
	global $countq;		$countq = mysqli_num_rows($q);

	global $userid;		global $uservisita;

	if($countq < 1){ 

	}else{  $_SESSION['id'] = $row['id'];
			$_SESSION['ref'] = $row['ref'];
			$_SESSION['Nivel'] = $row['Nivel'];
			$_SESSION['Nombre'] = $row['Nombre'];
			$_SESSION['Apellidos'] = $row['Apellidos'];
			$_SESSION['dni'] = $row['dni'];
			$_SESSION['ldni'] = $row['ldni'];
			$_SESSION['Email'] = $row['Email'];
			$_SESSION['Usuario'] = $row['Usuario'];
			$_SESSION['Password'] = $row['Password'];
			$_SESSION['Direccion'] = $row['Direccion'];
			$_SESSION['Tlf1'] = $row['Tlf1'];
			$_SESSION['Tlf2'] = $row['Tlf2'];
			$_SESSION['myimg'] = $row['myimg'];
			$_SESSION['lastin'] = $row['lastin'];
			$_SESSION['lastout'] = $row['lastout'];
			$_SESSION['visitadmin'] = $row['visitadmin'];
			
			$userid = $_SESSION['id'];
			$uservisita = $_SESSION['visitadmin'];
		}

	}else{ }

?>