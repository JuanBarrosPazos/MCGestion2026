
<?php
session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require "../config/TablesNames.php";
	global $ClientesWeb;	global $db;	global $db_name;
	$sqld =  "SELECT * FROM $ClientesWeb WHERE `Email` = '$_POST[Email]' OR `Usuario` = '$_POST[Usuario]'";
	$qd = mysqli_query($db, $sqld);
	$rowd = mysqli_fetch_assoc($qd);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){

		master_index();
		if(isset($_POST['oculto2'])){ show_form();
									   log_info();
		}elseif(isset($_POST['modifica'])){
				if($form_errors = validate_form()){
									show_form($form_errors);
				}else{ 	process_form();
						log_info();
				}
		}else{ show_form(); }

	}else{ require "../Inclu/AccesoDenegado.php";	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
		require 'validate_cliente.php';	
		
			return $errors;

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $Feedback;		$Feedback = 1;

	global $db;		global $db_name;
	require "../config/TablesNames.php";

	$SqlInsertClientesWeb = "INSERT INTO `$db_name`.$ClientesWeb SET `ref` = '$_POST[ref]', `Nivel` = '$_POST[Nivel]', `Nombre` = '$_POST[Nombre]', `Apellidos` = '$_POST[Apellidos]', `myimg` = '$_POST[myimg]', `doc` = '$_POST[doc]', `dni` = '$_POST[dni]', `ldni` = '$_POST[ldni]', `Email` = '$_POST[Email]', `Usuario` = '$_POST[Usuario]', `Password` = '$_POST[Password]', `Direccion` = '$_POST[Direccion]', `Tlf1` = '$_POST[Tlf1]', `Tlf2` = '$_POST[Tlf2]', `lastin` = '$_POST[lastin]', `lastout` = '$_POST[lastout]', `visitadmin` = '$_POST[visitadmin]' ";
	
	global $LogText;
	if(mysqli_query($db, $SqlInsertClientesWeb)){
			global $Titulo;				$Titulo = "DATOS ADMINISTRADOR RECUPERADO";
			global $rutImg; 			$rutImg = "img_cliente/";
			global $safe_filename; 		$safe_filename = $_POST['myimg'];
			require "UserTablaCrea.php";
			print($tabla);
	}else{	print("<font color='#F1BD2D'>* ERROR L.76</font></br>&nbsp;".mysqli_error($db))."</br>";
			show_form ();
					$LogText = $LogText." ".mysqli_error($db)."\n\t";
							}
							
	$SqlDeleteClientesWebFeedback = "DELETE FROM `$db_name`.$ClientesWebFeedback WHERE $ClientesWebFeedback.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $SqlDeleteClientesWebFeedback)){
		
	}else{	print("*ERROR SQL L.71 ".mysqli_error($db))."</br>"; }

	global $RedirUrl;	$RedirUrl = "FeedbackClienteVer.php";
	global $RedirTime;	$RedirTime = 6000;
	require '../Inclu/AutoRedirUrl.php';
	global $Redir;      print ($Redir);

}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
		global $KeyFeedback;		$KeyFeedback = 1;
		global $ArrayCliente;		$ArrayCliente = 1;
		global $TrAlert;			
		$TrAlert ="<tr>
						<th colspan=2 style='color:#F1BD2D;'>
							RECUPERARÁ ESTOS DATOS
						</th>
					</tr>";
		global $Title;				$Title ="RECUPERAR ESTOS DATOS";
		global $InputName;			$InputName = "modifica";
		global $BotonClass;			$BotonClass = "botonverde imgButIco RestoreBlack";

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
		
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }

	$ActionTime = date('H:i:s');


	global $LogText;
	$LogText = "- ADMIN FEEDBACK RECUPERAR 2 ".$ActionTime.". ".$nombre." ".$apellido.".\n\t Ref: ".$_POST['ref'].". Nivel: ".$_POST['Nivel'].".\n\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Password'];

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