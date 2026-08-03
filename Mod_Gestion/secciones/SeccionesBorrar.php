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
		if(isset($_POST['oculto2'])){ show_form();
									  log_info();
		}elseif(isset($_POST['borrar'])){ ejecuta();
										  log_info();
		}else{ show_form(); }
	}else{ require "../Inclu/AccesoDenegado.php";	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ejecuta(){

	global $LogText;
	
	/******** 	SI NO EXISTE CREA LA SECCION EN LA TABLA SECCIONES FEED
				Y SI NO HAY ERRORES EJECUTA LA FUNCION PROCESS_FORM();		*********/

	global $db;		global $db_name;
	require "../config/TablesNames.php";

	$SqlSelectSeccionesFeed =  "SELECT * FROM `$db_name`.$SeccionesFeed WHERE $SeccionesFeed.`valor` = '$_POST[valor]' AND $SeccionesFeed.`nombre` = '$_POST[nombre]' ";
	
	$QrySelectSeccionesFeed = mysqli_query($db, $SqlSelectSeccionesFeed);
	//$RowSelectSeccionesFeed = mysqli_fetch_assoc($QrySelectSeccionesFeed);

	if(mysqli_num_rows($QrySelectSeccionesFeed) == 0){
		// NO EXISTE EN SECCIONES FEED
		$SqlInsertSeccionesFeed = "INSERT INTO `$db_name`.$SeccionesFeed (`valor`, `nombre`) VALUES ('$_POST[valor]', '$_POST[nombre]')";
		
		if(mysqli_query($db, $SqlInsertSeccionesFeed)){
				$LogText = $LogText."* RESPALDO SECCIONES FEED: ".$_POST['nombre']." / ".$_POST['valor']."\n\t";
				process_form();
		}else{ 	print ("* ERROR SQL L.43 ".mysqli_error($db).".</br>");
				$LogText = $LogText."* ERROR SQL L.43 ".mysqli_error($db)."\n\t";
		}

	}else{  $LogText = $LogText."* YA EXISTE LA SECCION EN SECCIONES FEEDBACK\n\t";
			print("<div style='margin:0.1em auto 0.1em auto; width:max-content; display:block; color:#F1BD2D;'>* YA EXISTE LA SECCION EN FEEDBACK SECCIONES</div>");
			show_form();
	}

} // FIN function ejecuta()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	/***********	BORRAMOS SECCION DE TABLA SECCIONES		***************/
			
	global $db;			global $db_name;
	require "../config/TablesNames.php";
			
	$SqlDeleteSecciones = "DELETE FROM `$db_name`.$Secciones WHERE $Secciones.`id` = '$_POST[id]' AND $Secciones.`valor` = '$_POST[valor]' LIMIT 1 ";
		
	global $LogText;	global $Title;
	if(mysqli_query($db, $SqlDeleteSecciones)){
		
			$Title = "DATOS BORRADOS";
			require 'SeccionesTablaResult.php';
			print($TablaResultados);

			global $RedirUrl;	$RedirUrl = "SeccionesVer.php";
			global $RedirTime;	$RedirTime = 6000;
			require '../Inclu/AutoRedirUrl.php';
			global $Redir;      print ($Redir);
			
			$LogText = $LogText."* BORRADO EN TABLA SECCIONES: ".$_POST['nombre']." / ".$_POST['valor']."\n\t";
	}else{ 	print ("* ERROR SQL L.116 ".mysqli_error($db).".</br>");
			$LogText = $LogText."* ERROR SQL L.98 ".mysqli_error($db)."\n\t";
	}

} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
		
	require 'SeccionesArrayTotalVar.php';
	global $ArraySeccionGeneral;				$ArraySeccionGeneral = 1;
	require 'SeccionesArrayTotal.php';
			
	global $Title;	$Title = "BORRAR SECCION";
	global $Borrar;	$Borrar = 1;
	require 'SeccionesFormBorraRecup.php';

	global $LogText;
	$LogText = "* VISTA SECCIONES BORRAR \n\tID: ".$_POST['id']."\n\tNOMBRE: ".$defaults['nombre']."\n\tVALOR: ".$defaults['valor']."\n\t";
		
}	

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