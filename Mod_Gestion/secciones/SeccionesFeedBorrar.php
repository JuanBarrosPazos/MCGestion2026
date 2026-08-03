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
		if(isset($_POST['oculto2'])){ show_form();
									  log_info();
		}elseif(isset($_POST['borrar'])){ process_form();
										  log_info();
		}else{ show_form(); }

	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	/******** 	BORRAMOS LA SECCION EN LA TABLA SECCIONES FEEDBACK	*********/

	global $db;			global $db_name;
	require "../config/TablesNames.php";

	$SqlSeccionesFeedDelete = "DELETE FROM `$db_name`.$SeccionesFeed WHERE $SeccionesFeed.`valor` = '$_POST[valor]' ";
		
	global $ValorDelDir;	$ValorDelDir = $_POST['valor'];
	global $LogText;	global $Title;
	if(mysqli_query($db, $SqlSeccionesFeedDelete)){
		
		BorrarDir();
		$Title = "ELIMINADO RESPALDO DE SECCION";
		require 'SeccionesTablaResult.php';
		print($TablaResultados);

		global $RedirUrl;	$RedirUrl = "SeccionesFeedVer.php";
		global $RedirTime;	$RedirTime = 6000;
		require '../Inclu/AutoRedirUrl.php';
		global $Redir;      print ($Redir);
				
		$LogText = $LogText."* BORRADO RESPALDO DE SECCIONES FEEDBACK ".$_POST['valor']." / ".$_POST['nombre']."\n\t";
	
	}else{ $LogText = "* ERROR SQL L.60 ".mysqli_error($db)."\n"; }
	
} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function BorrarDir(){
	
		global $ValorDelDir;	global $LogText;
		// BORRAMOS LOS ARCHIVOS Y DIRECTORIO DE LA SECCION
			global $Carpeta;    $Carpeta = "../imgpro/imgpro".$ValorDelDir;
			if(file_exists($Carpeta)){ 
					$DirDel = $Carpeta."/";
					$OpenDir = opendir($DirDel);
					while($FileDel = readdir($OpenDir)){
							if(is_file($DirDel.$FileDel)){ unlink($DirDel.$FileDel); }
							$LogText = $LogText."* BORRADO ARCHIVO ".$DirDel.$FileDel."\n\t";
					}
						rmdir($Carpeta);
						$LogText = $LogText."* BORRADO DIRECTORIO ".$Carpeta."/ \n\t";
			}else{ }

	} // FIN function BorrarDir()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
		
	require 'SeccionesArrayTotalVar.php';
	global $ArraySeccionGeneral;				$ArraySeccionGeneral = 1;
	require 'SeccionesArrayTotal.php';
	
	global $Title;	$Title = "ELIMINAR RESPALDO";
	global $Borrar;	$Borrar = 1;
	require 'SeccionesFormBorraRecup.php';

	global $LogText;
	$LogText = $LogText."\n\t* FORMULARIO SECCIONES FEEDBACK BORRAR \n\tID: ".$_POST['id']."\n\tNOMBRE: ".$defaults['nombre']."\n\tVALOR: ".$defaults['valor'];

}	// FIN show_form();

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