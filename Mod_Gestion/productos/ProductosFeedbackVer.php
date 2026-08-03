<?php
session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){

		master_index();
		if((isset($_POST['oculto1']))||(isset($_POST['oculto2']))||(isset($_GET['seccion']))){ 
									process_form();
									log_info();
		}else{ show_form(); }

	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
		
	show_form();
	
	require "../config/TablesNames.php";
	global $Seccion;

	switch (true) {
		case (isset($_POST['seccion'])):
			$Seccion = $_POST['seccion'];
			break;
		case (isset($_GET['seccion'])):
			$Seccion = $_GET['seccion'];
			break;
		default:
			$Seccion = '';
			break;
	}

	$SqlSelectSecciones =  "SELECT * FROM $Secciones WHERE `valor` = '$Seccion'";
	$QrySelectSecciones = mysqli_query($db, $SqlSelectSecciones);
	$RowSelectSecciones = mysqli_fetch_assoc($QrySelectSecciones);
	global $SecNameName;		$SecNameName = $RowSelectSecciones['nombre'];
	global $SecNameValue;		$SecNameValue = $RowSelectSecciones['valor'];

	$sqs1 = "SELECT * FROM $ProductosFeed WHERE `vseccion` = '$SecNameValue' AND `valor` <> '' ORDER BY `nombre` ASC";
	$qb = mysqli_query($db, $sqs1);

	global $KeyProductosVer;	$KeyProductosVer = 2;
	require 'ProductosTableVer.php';
	
	// DATOS LOG...
	global $LogText;	$LogText = "- PRODUCTOS VER SECCION ".$SecNameName;

	} /* Fin ver_todo_1();*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";
	
	require 'ProductosArrayTotalVar.php';
	global $ArrayProductosVerFeed;			$ArrayProductosVerFeed = 1;
	require	'ProductosArrayTotal.php';

	global $SecNameName;	
	if(isset($_POST['seccion'])){
		$SqlSelectSecciones =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[seccion]'";
		$QrySelectSecciones = mysqli_query($db, $SqlSelectSecciones);
		$RowSelectSecciones= mysqli_fetch_assoc($QrySelectSecciones);
		$SecNameName = $RowSelectSecciones['nombre'];
	}else{ }

		global $FormTitulo;		$FormTitulo = "VER PRODUCTOS FEEDBACK";
		global $feed;			$feed = 1;
		require 'ProductosFormFiltro.php';
	
	} /* FIN show_form(); */
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $productos;        $productos = '';

		require '../Inclu_Menu/Master_Index.php';
	
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function log_info(){

		require '../logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	require '../Inclu/Inclu_Footer.php';
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>