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
			if (isset($_POST['oculto2'])){ 	show_form();
											log_info();
					}elseif(isset($_POST['borrar'])){ 	process_form();
														log_info();
					}else{ show_form(); }

	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";
	
	$SqlDeleteClientesWebFeed = "DELETE FROM `$db_name`.$ClientesWebFeedback WHERE $ClientesWebFeedback.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $SqlDeleteClientesWebFeed)){
				global $Titulo;				$Titulo = "SE HAN BORRADO ESTOS DATOS DEFINITIVAMENTE";
				global $rutImg; 			$rutImg = "img_cliente/";
				global $safe_filename; 		$safe_filename = $_POST['myimg'];
				require "UserTablaCrea.php";
				print( $tabla );
				if(file_exists("img_cliente/".$_POST['myimg'])){
					// BORRA LA IMAGEN ORIGINAL SI EXISTE ['img_cliente/'.$safe_filename;]
					unlink("img_cliente/".$_POST['myimg']);
				}else{ }
	}else{ 	print("* ERROR SQL L.33 ".mysqli_error($db))."</br>";
			show_form ();
	}

	global $RedirUrl;	$RedirUrl = "FeedbackClienteVer.php";
	global $RedirTime;	$RedirTime = 6000;
	require '../Inclu/AutoRedirUrl.php';
	global $Redir;      print ($Redir);


}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
		
	global $KeyFeedback;		$KeyFeedback = 1;
	global $ArrayCliente;		$ArrayCliente = 1;
	global $TrAlert;			
	$TrAlert ="<tr>
				<th colspan=2 style='color:#F1BD2D;'>
					SE BORRARÁN ESTOS DATOS</br>NO SE PODRÁN RECUPERAR
				</th>
			</tr>";
	global $Title;				$Title ="BORRAR DATOS PERMANENTEMENTE";
	global $InputName;			$InputName = "borrar";
	global $BotonClass;			$BotonClass = "botonrojo imgButIco DeleteBlack";
	require 'ArrayTotalVar.php';
	global $ArrayFeedRecup;     $ArrayFeedRecup = 1;
	require "ArrayTotal.php";
	require "UserFormFeedback.php";

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

	global $nombre;		$nombre = $_POST['Nombre'];
	global $apellido;	$apellido = $_POST['Apellidos'];
	global $rf; 		$rf = $_POST['ref'];
		
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }
		
	$ActionTime = date('H:i:s');
	
	global $LogText;
	$LogText = "- ADMIN FEEDBACK BORRAR 2 ".$ActionTime.". ".$nombre." ".$apellido.".\n\t Ref: ".$rf.". Nivel: ".$_POST['Nivel'].".\n\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Password'];

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