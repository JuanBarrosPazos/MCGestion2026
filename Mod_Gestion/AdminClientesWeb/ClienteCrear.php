<?php
session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require "../config/TablesNames.php";

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	global $KeyClienteCero;

	if(isset($_SESSION['Nivel'])){
		if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){ 
			master_index(); 
		}else{ require "../Inclu/AccesoDenegado.php"; }
		$KeyClienteCero = 0;
	}else{ 
		$KeyClienteCero = 1;
	}

	if(isset($_POST['oculto'])){
		if($form_errors = validate_form()){ 
				show_form($form_errors);
		}else{  process_form();
				log_info();
		}
	}else{ show_form(); }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
		
		global $CheckCondiciones;		global $CheckDatos;

		require 'validate_cliente.php';	
		
		if(!isset($_SESSION['Nivel'])){
	
			if(!isset($_POST['Condiciones'])){
				$errors [] = "CONDICIONES DEL SERVICIO: CAMPO OBLIGATORIO";
				$CheckCondiciones = "";
			}else{ 
				$CheckCondiciones = "checked='checked'";
			}
		
			if(!isset($_POST['Datos'])){
				$errors [] = "TRATAMIENTO DE DATOS: CAMPO OBLIGATORIO";
				$CheckDatos = "";
			}else{ 
				$CheckDatos = "checked='checked'";
			}

		}else{ }

		return $errors;
	
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
		require "UserRefCrea.php";

		global $safe_filename;
		$safe_filename = trim(str_replace('/', '', $_FILES['myimg']['name']));
		$safe_filename = trim(str_replace('..', '', $safe_filename));

		//$imgNombre = $_FILES['myimg']['name'];
		//$imgNombre_tmp = $_FILES['myimg']['tmp_name'];
		//$imgTipo = $_FILES['myimg']['type'];
		//$imgTamano = $_FILES['myimg']['size'];
		  
		global $destination_file;	$destination_file = 'img_cliente/'.$safe_filename;
		
		// RENOMBRA LA IMAGEN
		// EXTRAIGO LA EXTENSION
			global $extension;		$extension = substr($_FILES['myimg']['name'],-3);
			if(($extension == "peg")||($extension == "PEG")){
				$extension = substr($_FILES['myimg']['name'],-4);
			}else{ }

		// print($extension);
		// [DEPECRATED] => $extension = end(explode('.', $_FILES['myimg']['name']) );
		//	date('H:i:s');	date('Y_m_d');
		global $dt;		$dt = date('is');

		global $imgNewName;			$imgNewName = $rf."_".$dt.".".$extension;
		global $rename_filename;	$rename_filename = "img_cliente/".$imgNewName;	
		//rename($destination_file, $rename_filename);

	/**************************************/

	global $Titulo;			$Titulo = "SE HA REGISTRADO COMO CLIENTE";
	global $rutImg;			$rutImg = "img_cliente/"; 
	global $safe_filename;	$safe_filename = $imgNewName;
	require "UserTablaCrea.php";

	if(file_exists($destination_file)){
		print("<br><font color='#F1BD2D'>**</font> LA IMAGEN ".$destination_file." YA EXISTE, SERA BORRADA</br>");
		// BORRA LA IMAGEN ORIGINAL SI EXISTE ['img_cliente/'.$safe_filename;]
		unlink($destination_file);
		show_form();
	}else{
		global $nombre;		$nombre = $_POST['Nombre'];
		global $apellido;	$apellido = $_POST['Apellidos'];

		require "../config/TablesNames.php";

		$sql = "INSERT INTO `$db_name`.$ClientesWeb (`ref`,`Nivel`, `Nombre`, `Apellidos`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Usuario`, `Password`, `Direccion`, `Tlf1`, `Tlf2`) VALUES ('$rf', '$_POST[Nivel]', '$_POST[Nombre]', '$_POST[Apellidos]', '$imgNewName', '$_POST[doc]', '$_POST[dni]', '$_POST[ldni]', '$_POST[Email]', '$_POST[Usuario]', '$_POST[Password]', '$_POST[Direccion]', '$_POST[Tlf1]', '$_POST[Tlf2]')";
		
		if(mysqli_query($db, $sql)){
			global $destination_file;
			move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file);
			global $tabla;
			print( $tabla );
			global $rename_filename;
			rename($destination_file, $rename_filename);

			if(!file_exists($rename_filename)){ print("NO SE HA PODIDO GUARDAR EN ".$rename_filename);
			}else{ /*print ("LA IMAGEN SE HA GUARDADO OK...");*/ }

			global $RedirUrl;
			if(!isset($_SESSION['Nivel'])){ $RedirUrl = "../index.php";
			}else{ $RedirUrl = "ClienteVer.php"; }
				
			global $RedirTime;	$RedirTime = 6000;
			require '../Inclu/AutoRedirUrl.php';
			global $Redir; 		print ($Redir);

		}else{ print("* ERROR SQL L.93 ".mysqli_error($db))."</br>";
						show_form ();
						global $texerror;	$texerror = "* SQL ERROR L.93 ".mysqli_error($db)."\n\t";
		}
	} // ELSE NO EXISTE LA IMAGEN

} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
		require 'TableValidateErrors.php';

		require 'ArrayTotalVar.php';

		global $ArrayCliente;		global $ArrayAdmin;		global $ArrayCaja;		global $Titulo;
		switch (true) {
			case ((@$_SESSION['Nivel'] == 'wmaster')||(@$_SESSION['Nivel']=='admin')):
				$ArrayAdmin = 1;
				$Titulo = "NUEVO CLIENTE O CAJERO";
				break;
			case ($_SESSION['Nivel']=='caja'):
				$ArrayCaja = 1;
				$Titulo = "NUEVO CAJERO CAJERO";
				break;
			case (@$_SESSION['Nivel']=='cliente'):
				$ArrayCliente = 1;
				$Titulo = "DATOS NUEVO CLIENTE";
				break;
			default:
				$ArrayCliente = 1;
				$Titulo = "DATOS NUEVO CLIENTE";
				break;
		}

		global $ArrayClienteCrea;		$ArrayClienteCrea = 1;
		require "ArrayTotal.php";

		require "UserRefCrea.php";

		require "UserFormCrea.php";
	
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

	global $nombre;		global $apellido;		global $rf;		global $texerror;

	global $LogText;
	if ($nombre == ''){$LogText = "- ERROR LA IMAGEN YA EXISTE";}
	else{$LogText = "- ADMIN CREAR  ".$nombre." ".$apellido.".\n\t Ref: ".$rf.". Nivel: ".$_POST['Nivel'].".\n\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Password'];			
	}

	if(isset($_SESSION['nivel'])){
			require '../logs/LogInfo.php';
	}else{ }

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	require '../Inclu/Inclu_Footer.php';
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>
