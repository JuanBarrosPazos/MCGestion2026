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

	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')){

		master_index();
		if(isset($_POST['oculto2'])){
								show_form();
								log_info();
		}elseif($_POST['borrar']){ 	process_form();
									Feedback();
									log_info();
		}else{ show_form(); }

	}else{ require "../Inclu/AccesoDenegado.php";	}
 
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	
	require "../config/TablesNames.php";
	
	$SqlDeleteClientesWeb = "DELETE FROM `$db_name`.$ClientesWeb WHERE $ClientesWeb.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $SqlDeleteClientesWeb)){
			global $KeyLinkAcceso;	$KeyLinkAcceso = "borrar2";
			global $Titulo;			$Titulo = "USUARIO BORRADO";
			global $rutImg; 		$rutImg = "img_cliente/";
			global $safe_filename; 	$safe_filename = $_POST['myimg'];
			require 'UserTablaCrea.php';
			print ($tabla);
	}else{ 	print("* ERROR SQL L.128 ".mysqli_error($db))."</br>";
			show_form ();
	}

	global $RedirUrl;
	if(($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')){ 
			$RedirUrl = "../index.php?salir=1";
	}else{ $RedirUrl = "ClienteVer.php"; }
	global $RedirTime;	$RedirTime = 6000;
	require '../Inclu/AutoRedirUrl.php';
	global $Redir;      print ($Redir);

	} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
					
function show_form(){
	
	global $KeyLinkAcceso;	$KeyLinkAcceso = "borrar1";
	global $Titulo;			$Titulo = "BORRARA ESTOS DATOS";
	global $rutImg; 		$rutImg = "img_cliente/";
	global $safe_filename; 	$safe_filename = $_POST['myimg'];
	require 'UserTablaCrea.php';
	echo $tabla;

} // FIN function show_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function Feedback(){
	
	global $FBaja;		$FBaja = date('Y-m-d/H:i:s');

	global $db;		global $db_name;
	require "../config/TablesNames.php";
	
	$SqlInsertClientesWebFeedback = "INSERT INTO `$db_name`.$ClientesWebFeedback (`ref`, `Nivel`, `Nombre`, `Apellidos`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Usuario`, `Password`, `Direccion`, `Tlf1`, `Tlf2`, `borrado`, `lastin`, `lastout`, `visitadmin`) VALUES ('$_POST[ref]', '$_POST[Nivel]', '$_POST[Nombre]', '$_POST[Apellidos]', '$_POST[myimg]', '$_POST[doc]', '$_POST[dni]', '$_POST[ldni]', '$_POST[Email]', '$_POST[Usuario]', '$_POST[Password]', '$_POST[Direccion]', '$_POST[Tlf1]', '$_POST[Tlf2]', '$FBaja', '$_POST[lastin]', '$_POST[lastout]', '$_POST[visitadmin]')";
	
	if(mysqli_query($db, $SqlInsertClientesWebFeedback)){ 
			//print("FOK.");
	}else{ print("* ERROR SQL L.304 ".mysqli_error($dbf))."</br>"; }

	} // FIN function Feedback()

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

	global $nombre;			$nombre = $_POST['Nombre'];
	global $apellido;		$apellido = $_POST['Apellidos'];
	global $rf; 			$rf = $_POST['ref'];
		
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- ADMIN BORRAR 2 ".$ActionTime.". ID:".$_POST['id'].". ".$nombre." ".$apellido.".\n\t Ref: ".$rf.". Nivel: ".$_POST['Nivel'].".\n\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Password'];

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
