<?php

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form_img(){
	
		global $sqld; 		global $qd; 	global $rowd;

		require 'ValidateImgMod.php';

		return $errors;

	}  // FIN VALIDATE_FOMR()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function borra_img(){

		global $db; 	global $db_name; 	global $vname;	global $imgcamp;

		global $rutaRedir;	$rutaRedir = 'Pendientes';

		global $vname; 		$vname = "`".$_SESSION['clave']."ingresos_pendientes`";

		global $rutaDir; 		$rutaDir = "../cb26_Docs/docingresos_pendientes/";
		$_SESSION['ruta'] = $rutaDir;

		global $borraImg;		$borraImg = 1;

		require 'FormImgModif.php';

	} // FIN function borra_img()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function modifica_form_img(){

		global $db; 	global $db_name;	global $img; 	global $imgcamp;

		global $rutaRedir;	$rutaRedir = 'Pendientes';

		global $vname; 		$vname = "`".$_SESSION['clave']."ingresos_pendientes`";

		global $rutaDir; 		$rutaDir = "../cb26_Docs/docingresos_pendientes/";
		$_SESSION['ruta'] = $rutaDir;

		global $borraImg;		$borraImg = '';

		require 'FormImgModif.php';

	} // FIN function modifica_form_img()
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form_img(){
	
		global $db; 		global $db_name;

		global $rutPend;	$rutPend = 'Pendientes';
		global $pend;	$pend = "PENDIENTES";
		require 'Botonera.php';
	
		if(isset($_POST['oculto2'])){ $_SESSION['midyt1'] = $_POST['dyt1']; }else{ }

		global $vname; 			$vname = "`".$_SESSION['clave']."ingresos_pendientes`";
		global $rutaDir; 		$rutaDir = "../cb26_Docs/docingresos_pendientes/";
		$_SESSION['ruta'] = $rutaDir;

		require 'FormImgModifProcessFormImg.php';

	} // FIN function process_form_img()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
					
	function show_form_img($errors=[]){
	
		global $db; 	global $db_name;

		global $rutPend;	$rutPend = 'Pendientes';
		global $pend;	$pend = "PENDIENTES";
		require 'Botonera.php';

		global $rutaDir; 		$rutaDir = "../cb26_Docs/docingresos_pendientes/";
		$_SESSION['ruta'] = $rutaDir;

		require 'FormImgShowFormImg.php';

	} // FIN show_form_img($errors=[])

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info_img(){

		global $db; 		global $destination_file;
		global $new_name; 	global $mivalor;

		$ActionTime = date('H:i:s');

		global $text;
		$text = "- IMAGEN INGRESOS MODIFICADA ".$ActionTime."\n\tNº FACT. ".$mivalor."\n\tCAMPO: ".$_SESSION['imgcamp'].".\n\tNOMBRE: ".$destination_file."\n\tNUEVO NOMBRE: ".$new_name;

		require 'WriteLog.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>