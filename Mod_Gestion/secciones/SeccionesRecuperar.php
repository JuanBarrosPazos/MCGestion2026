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
	
	global $db;	global $db_name;
	require "../config/TablesNames.php";

	/******** 	NO EXISTE LA SECCION EN LA TABLA SECCIONES	*********/
	$SqlSeccionesSelect =  "SELECT * FROM `$db_name`.$Secciones WHERE $Secciones.`valor` = '$_POST[valor]' OR $Secciones.`nombre` = '$_POST[nombre]' ";
	
	$QrySqlSeccionesSelect = mysqli_query($db, $SqlSeccionesSelect);
	//$RowSqlSeccionesSelect = mysqli_fetch_assoc($QrySqlSeccionesSelect);

	global $LogText;
	if(mysqli_num_rows($QrySqlSeccionesSelect) == 0){

		/******** 	GRABAMOS LA SECCION EN LA TABLA SECCIONES	*********/
		$SqlSeccionesInsert = "INSERT INTO `$db_name`.$Secciones (`valor`, `nombre`) VALUES ('$_POST[valor]', '$_POST[nombre]')";

		global $Title;
		if(mysqli_query($db, $SqlSeccionesInsert)){

			$Title = "SECCION RECUPERADA";
			require 'SeccionesTablaResult.php';
			print($TablaResultados);

			global $RedirUrl;	$RedirUrl = "SeccionesFeedVer.php";
			global $RedirTime;	$RedirTime = 6000;
			require '../Inclu/AutoRedirUrl.php';
			global $Redir;      print ($Redir);

			$LogText = $LogText."\n\t* HA RECUPERADO LA SECCION ".$_POST['nombre']." / ".$_POST['valor']."\n\t";
		
		}else{	print("* ERROR SQL L.45 ".mysqli_error($db))."</br>";
				$LogText = $LogText."* ERROR SQL L.66 ".mysqli_error($db)."\n";
		}
	
		/******** 	BORRAMOS LA SECCION EN LA TABLA SECCIONES FEED	*********/
		$SqlSeccionesFeedDelete = "DELETE FROM `$db_name`.$SeccionesFeed WHERE $SeccionesFeed.`valor` = '$_POST[valor]' ";
			
		if(mysqli_query($db, $SqlSeccionesFeedDelete)){
			//print("<div style='margin:0.1em auto 0.1em auto; width:max-content; display:block; color:#F1BD2D;'>* SECCION BORRADA EN SECCIONES FEEDBACK</div>");
			$LogText = $LogText."\n\t* BORRADA EN SECCION FEED ".$_POST['nombre']." / ".$_POST['valor']."\n\t";
		}else{ 	print("* ERROR SQL L.66 ".mysqli_error($db))."</br>";
				$LogText = $LogText."\n\t* ERROR SQL L.77 ".mysqli_error($db)."\n\t";
		}

	}else{  $LogText = $LogText."\n\t* YA EXISTE LA SECCION EN SECCIONES \n\t";
		print("<div style='margin:0.1em auto 0.1em auto; width:max-content; display:block; color:#F1BD2D;'>* YA EXISTE LA SECCION EN SECCIONES</div>");
		show_form();
	}
	
}  // FIN process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
	
	require 'SeccionesArrayTotalVar.php';
	global $ArraySeccionGeneral;				$ArraySeccionGeneral = 1;
	require 'SeccionesArrayTotal.php';
								   
	global $Title;	$Title = "RECUPERAR ESTA SECCIÓN";
	global $Borrar;	$Borrar = 0;
	require 'SeccionesFormBorraRecup.php';

	global $LogText;
	$LogText = "* VISTA SECCIONES FEEDBACK RECUPERAR \n\tID: ".$_POST['id']."\n\tNOMBRE: ".$defaults['nombre']."\n\tVALOR: ".$defaults['valor'];
	
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