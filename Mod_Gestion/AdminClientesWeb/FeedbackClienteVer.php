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
		if(isset($_POST['todo'])){  show_form();							
									ver_todo();
									log_info();
				}elseif(isset($_POST['oculto'])){
							if($form_errors = validate_form()){
											show_form($form_errors);
								}else{ 	process_form();
										log_info();
										}
				}else{ 	show_form();
						ver_todo(); 
				}

	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();
	
	if( (strlen(trim($_POST['Nombre'])) == 0) && (strlen(trim($_POST['Apellidos'])) == 0) ){
		$errors [] = " <font color='#F1BD2D'>UNO DE LOS DOS CAMPOS OBLIGATORIO</font>";
		}
	
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

	global $db;			global $db_name;
	require "../config/TablesNames.php";
	$SqlSelectClientesWebFeedback =  "SELECT * FROM $ClientesWebFeedback WHERE $LikeNombre OR $LikeApellido ORDER BY $Orden ";
 	
	$qb = mysqli_query($db, $SqlSelectClientesWebFeedback);
	
	global $KeyFeedback;
	if(!$qb){ 
				print("* ERROR SQL L.66 ".mysqli_error($db)."</br>");
				show_form();	
	}else{	$KeyFeedback = 1;
			require "UserWhileTabla.php";

	} // FIN ELSE WHILE TABLA
		
}	

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
		
	global $KeyFeedback; 		$KeyFeedback = 1;
	global $FormTitulo;			$FormTitulo = "FEEDBACK CLIENTES WEB";
	require "UserFormFiltro.php";

}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }

	global $db;		global $db_name;
	require "../config/TablesNames.php";
	$SqlSelectClientesWebFeed =  "SELECT * FROM $ClientesWebFeedback ORDER BY $Orden ";
 	
	$qb = mysqli_query($db, $SqlSelectClientesWebFeed);
	
	if(!$qb){
			print("* ERROR SQL L.128".mysqli_error($db)."</br>");
	}else{
			require "UserWhileTabla.php";
	} // FIN ELSE WHILE TABLA

}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $AdminClientesWeb;        $AdminClientesWeb = '';
	
		require '../Inclu_Menu/Master_Index.php';
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- ADMIN FEEDBACK VER ".$ActionTime." ".$LogText;

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