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

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){

		master_index();
		if(isset($_POST['todo'])){ 	
						show_form();							
						ver_todo();
						log_info();
		}else{ 	show_form();
				ver_todo(); 
				log_info();
		}

	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form(){

		global $defaults;

		if(isset($_POST['todo'])){ $defaults = $_POST; } 
		
		global $feed;			$feed = 0;
		global $FormTitulo;		$FormTitulo = "VER SECCIONES";
		require "SeccionesFormFiltro.php";

	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }

	require "../config/TablesNames.php";
	$SqlSelectSecciones =  "SELECT * FROM $Secciones WHERE `valor` <> '' ORDER BY $Orden ";
	global $QrySelectSecciones;
	$QrySelectSecciones = mysqli_query($db, $SqlSelectSecciones);
	
	global $feed;	$feed == 0;
	require 'SeccionesTablaVerTodo.php';

	// DATOS LOG...
	global $LogText;	$LogText = $LogText."* SECCIONES VER TODAS. ORDEN ".$Orden."\n\t";


	}	// FIN ver_todo();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $Secciones;        $Secciones = '';
		
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