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

	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){

		master_index();
		if(isset($_POST['todo'])){ 	show_form();							
									ver_todo();
									log_info();
		}elseif(isset($_POST['oculto'])){
				if($form_errors = validate_form()){
						show_form($form_errors);
				}else{ 	process_form();
						log_info();
							}
		}else{ 	show_form();
				ver_todo(); }

	}elseif(($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')){	
										master_index();
										ver_todo();
										unset($_SESSION['refcl']);
	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();
	
	if((strlen(trim($_POST['Nombre'])) == 0)&&(strlen(trim($_POST['Apellidos'])) == 0)){
		$errors [] = "UNO DE LOS DOS CAMPOS OBLIGATORIO";
	}else{ }
	
	return $errors;

} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	show_form();
		
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }
		
	global $LikeNombre;		$LikeNombre = "`Nombre` LIKE '%".$_POST['Nombre']."%'";
	global $LikeApellido;	$LikeApellido = "`Apellidos` LIKE '%".$_POST['Apellidos']."%'";

	if(strlen(trim($_POST['Apellidos'])) == 0){ $LikeApellido = $LikeNombre; }else{ }
	if(strlen(trim($_POST['Nombre'])) == 0){ $LikeNombre = $LikeApellido; }else{ }
	
	require "../config/TablesNames.php";
	$SqlSelectClientesWeb =  "SELECT * FROM $ClientesWeb WHERE ($LikeNombre OR $LikeApellido) AND `doc` <> 'local' ORDER BY $Orden ";
	
	$qb = mysqli_query($db, $SqlSelectClientesWeb);
	
	if(!$qb){ 	print("* ERROR SQL L.68 </font>".mysqli_error($db)."</br>");
				show_form();	
	}else{ 	global $KeyBorraUser;		$KeyBorraUser = 1;
			global $KeyFeedback; 		$KeyFeedback = 0;
			require "UserWhileTabla.php";
	} // FIN ELSE WHILE TABLA 

} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){
		
		global $Orden;
		if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }
			global $defaults;
		if(isset($_POST['oculto'])){
				$defaults = array ('Nombre' => $_POST['Nombre'],
									'Apellidos' => $_POST['Apellidos'],
									'Orden' => $Orden);
		}elseif(isset($_POST['todo'])){
				$defaults = array ('Nombre' => '', 'Apellidos' => '','Orden' => $Orden);
		}else{	$defaults = array ('Nombre' => '', 'Apellidos' => '','Orden' => $Orden);
					}
		
		require 'TableValidateErrors.php';

		global $KeyFeedback; 		$KeyFeedback = 0;
		global $FormTitulo;			$FormTitulo = "CLIENTES WEB";
		if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){ 
			require "UserFormFiltro.php";
		}else{ }
		
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }

	global $clref;			$clref = $_SESSION['ref'];

	global $db;		global $db_name;
	require "../config/TablesNames.php";
	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){
		//$SqlSelectClientesWeb =  "SELECT * FROM $ClientesWeb ORDER BY $Orden ";
		$SqlSelectClientesWeb =  "SELECT * FROM $ClientesWeb WHERE `doc` <> 'local' ORDER BY $Orden ";
	}elseif(($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')){
		$SqlSelectClientesWeb =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$clref' LIMIT 1 ";
	}

	$qb = mysqli_query($db, $SqlSelectClientesWeb);
	
	global $KeyIndex;	$KeyIndex = 0;
	if(!$qb){
			print("* ERROR SQL L.123/125 ".mysqli_error($db)."</br>");
	}else{ 	global $KeyBorraUser;	$KeyBorraUser = 1;
			require "UserWhileTabla.php";
	} // FIN ELSE WHILE TABLA

	global $RedirUrl;	$RedirUrl = "./ClienteVer.php";
	global $RedirTime;	$RedirTime = 30000;
	require '../Inclu/AutoRedirUrl.php';
	global $Redir; 		print ($Redir);

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';

		require '../Inclu_Menu/rutaindex.php';
		global $AdminClientesWeb;       $AdminClientesWeb = '';
		global $ClientesWeb;			$ClientesWeb = '../ClientesWeb/';
		require '../Inclu_Menu/Master_Index.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	global $nombre;			global $apellido;

	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }
	
	if(isset($_POST['todo'])){$nombre = "TODOS LOS USUARIOS ".$Orden;}	

	global $LogText;
	$LogText = "- ADMIN VER ".$nombre." ".$apellido;

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