<?php

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require "TablesNames.php";

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if(isset($_POST['oculto'])){
			if($form_errors = validate_form()){ show_form($form_errors);
					} else { config_one();
							 process_form();}
		} else {show_form();}
								
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function config_one(){
	
	if(file_exists('../index.php')){unlink("../index.php");
					$data1 = "\n \t UNLINK ../index.php";}
			else {print("ERROR UNLINK ../index.php </br>");
					$data1 = "\n \t ERROR UNLINK ../index.php";}

	if(!file_exists('../index.php')){
			if(file_exists('index_Play_System.php')){
				copy("index_Play_System.php", "../index_Play_System.php");
				$data2 = "\n \t COPY ../index_Play_System.php";
				} else {print("ERROR COPY index_Play_System.php </br>");
						$data2 = "\n \t ERROR COPY index_Play_System.php";}
			} 

	if(file_exists('../index_Play_System.php')){
				rename("../index_Play_System.php", "../index.php");
				$data3 = "\n \t RENAME ../index_Play_System.php TO ../index.php";
			} else {print("ERROR RENAME ../index_Play_System.php TO ../index.php </br>");
				$data3 = "\n \t ERROR RENAME ../index_Play_System.php TO ../index.php";}
	
	global $cfone;
	$cfone ="\n SUSTITUCION DE ARCHIVOS:".$data1.$data2.$data3;
	
	}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function validate_form(){
	
	global $sqld;
	global $qd;
	global $rowd;
	
	require 'validate.php';	
		
	return $errors;

		} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function process_form(){
	
	global $db;

	/*	REFERENCIA DE USUARIO	*/
	require "../Admin/UserRefCrea.php";

	$safe_filename = trim(str_replace('/', '', $_FILES['myimg']['name']));
	$safe_filename = trim(str_replace('..', '', $safe_filename));

	//$nombre = $_FILES['myimg']['name'];
	//$nombre_tmp = $_FILES['myimg']['tmp_name'];
	//$tipo = $_FILES['myimg']['type'];
	//$tamano = $_FILES['myimg']['size'];
		  
	global $destination_file;
	$destination_file = '../Admin/img_admin/'.$safe_filename;

		// RENOMBRA LA IMAGEN
		// EXTRAIGO LA EXTENSION
			global $extension;
			$extension = substr($_FILES['myimg']['name'],-3);
			if(($extension == "peg")||($extension == "PEG")){
				$extension = substr($_FILES['myimg']['name'],-4);
			} else { }

		// print($extension);
		// [DEPECRATED] => $extension = end(explode('.', $_FILES['myimg']['name']) );
			date('H:i:s');
			date('Y_m_d');
			global $dt;
			$dt = date('is');

		global $imgNewName;
		$imgNewName = $rf."_".$dt.".".$extension;

		global $rename_filename;
		$rename_filename = "../Admin/img_admin/".$imgNewName;	
		//rename($destination_file, $rename_filename);
		

/**************************************/

	global $titulo;
	$titulo = "SE HA REGISTRADO COMO PRIMER ADMISTRADOR";
	global $rutImg;
	$rutImg = "../Admin/img_admin/";

	global $KeyLinkAcceso;
	$KeyLinkAcceso = 1;

	global $tabla;
	require "../Admin/UserTablaCrea.php";	

	if( file_exists( '../Admin/img_admin/'.$destination_file) ){
		print("<br><font color='#F1BD2D'>**</font> El archivo ".$destination_file." ya existe, seleccione otra imagen.</br>");
		unlink($destination_file);
		show_form();
	} else {

	global $nombre;			$nombre = $_POST['Nombre'];
	global $apellido;		$apellido = $_POST['Apellidos'];
	
	require "../config/TablesNames.php";

	$sql = "INSERT INTO `$db_name`.$Admin (`ref`, `Nivel`, `Nombre`, `Apellidos`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Usuario`, `Password`, `Direccion`, `Tlf1`, `Tlf2`) VALUES ('$rf', '$_POST[Nivel]', '$_POST[Nombre]', '$_POST[Apellidos]', '$imgNewName', '$_POST[doc]', '$_POST[dni]', '$_POST[ldni]', '$_POST[Email]', '$_POST[Usuario]', '$_POST[Password]', '$_POST[Direccion]', '$_POST[Tlf1]', '$_POST[Tlf2]')";
		
	if(mysqli_query($db, $sql)){ 
		
		global $destination_file;
		move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file);
		global $tabla;
		print( $tabla );
		global $rename_filename;
		rename($destination_file, $rename_filename);

		if( !file_exists( $rename_filename ) ){ print("NO SE HA PODIDO GUARDAR EN ".$rename_filename);
		}else{ /* print ("LA IMAGEN SE HA GUARDADO OK..."); */ }

		global $cfone;
		$datein = date('Y-m-d/H:i:s');
		$logdate = date('Y_m_d');
		$LogText = $cfone."\n - CREADO USER ADMIN 1. ".$datein.". User Ref: ".$rf.".\n \t Name: ".$_POST['Nombre']." ".$_POST['Apellidos'].". \n \t User: ".$_POST['Usuario'].".\n \t Pass: ".$_POST['Password'].".\n";
		$filename = "../logs/Config/".$logdate."_CONFIG_INIT.log";
		$log = fopen($filename, 'ab+');
		fwrite($log, $LogText);
		fclose($log);

	} else { print("</br><font color='#F1BD2D'>
					* MODIFIQUE L.177 </font></br> ".mysqli_error($db))."</br>";
				show_form ();
					}
			} 

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
		} else {
				$defaults = array ( 'Nombre' => '',
									'Apellidos' => '',
									'myimg' => @$_POST['myimg'],	
									'Nivel' => '',
									'ref' => '',
									'doc' => '',
									'dni' => '',
									'ldni' => '',
									'Email' => 'Solo letras minúsculas',
									'Usuario' => '',
									'Usuario2' => '',
									'Password' => '',
									'Password2' => '',
									'Direccion' => '',
									'Tlf1' => '',
									'Tlf2' => '');
								   }

   if ($errors){
		print("<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font></br>");
		
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#F1BD2D'>**</font>  ".$errors[$a]."</br>");
			}
		}

		global $ArrayAdmin;
		$ArrayAdmin = 1;
		global $ArrayConfig;
		$ArrayConfig = 1;
		require "../Admin/ArrayTotal.php";

		require "../Admin/UserRefCrea.php";

		global $LogTextit;
		$LogTextit = "DATOS DEL NUEVO ADMINISTRADOR";

		global $keyConfig2;
		$keyConfig2 = 1;

		require "../Admin/UserFormCrea.php";

	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function master_index(){
		
				require '../Inclu_Menu/Master_Index_Admin.php';
		
				} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Inclu_Footer.php';
		
?>