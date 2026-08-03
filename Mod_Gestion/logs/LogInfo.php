<?php

	global $LogText;	global $rf;				global $new_name;	
	global $db;			global $db_name;		global $Orden;
	global $KeyLog;		global $rutaLog;

	global $ActionTime;	$ActionTime = date('H:i:s');

	global $dir;
	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){ 
			$dir = 'Admin';
	}elseif($_SESSION['Nivel']=='cliente'){ 
			$dir = 'Clientes';
	}elseif(($_SESSION['Nivel']=='user')||($_SESSION['Nivel']=='caja')){
			$dir = 'User';}

	if($KeyLog == "index"){ $rutaLog = ""; }else{ $rutaLog = "../"; }

	$logdocu = $_SESSION['Nombre']."_".$_SESSION['Apellidos'];
	$logdate = date('Y_m_d');
	$LogText = "- ".$ActionTime." ".$LogText."\n";
	$filename = $rutaLog."logs/".$dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $LogText);
	fclose($log);

?>