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
		if (isset($_POST['oculto2'])){  show_form();
										log_info();
		}elseif($_POST['modifica']){
					if($form_errors = validate_form()){ show_form($form_errors);
					}else{ process_form();
							log_info();
							unset($_SESSION['refcl']);
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
	
	global $db;			global $db_name;
	require "../config/TablesNames.php";

	require "UserRefCrea.php";
	global $rf; 			//$rf = $_POST['refnew'];

	global $nombre;			$nombre = $_POST['Nombre'];
	global $apellido;		$apellido = $_POST['Apellidos'];
	global $LogText;

	// ACTUALIZA LOS DATOS GENERALES...
	$SqlUpdateClientesWeb = "UPDATE `$db_name`.$ClientesWeb SET `Nivel` = '$_POST[Nivel]', `Nombre` = '$_POST[Nombre]', `Apellidos` = '$_POST[Apellidos]', `doc` = '$_POST[doc]', `dni` = '$_POST[dni]', `ldni` = '$_POST[ldni]', `Email` = '$_POST[Email]', `Usuario` = '$_POST[Usuario]', `Password` = '$_POST[Password]', `Direccion` = '$_POST[Direccion]', `Tlf1` = '$_POST[Tlf1]', `Tlf2` = '$_POST[Tlf2]' WHERE $ClientesWeb.`id` = '$_POST[id]' LIMIT 1 ";
	if(mysqli_query($db, $SqlUpdateClientesWeb)){
					global $Titulo; 		$Titulo = "NUEVOS DATOS DEL USUARIO";
					global $rutImg; 		$rutImg = "img_cliente/";
					global $safe_filename; 	$safe_filename = $_POST['myimg'];
					require "UserTablaCrea.php";
					print($tabla);
	}else{ 	print("* ERROR SQL L.63 ".mysqli_error($db))."</br>";
			show_form ();
			$LogText = $LogText." ".mysqli_error($db)."\n\t";
	}
	
	global $ClientName;	$ClientName = $_POST['Nombre']." ".$_POST['Apellidos'];	
	global $refcl;		$refcl = $_SESSION['refcl'];

	// SI LA NUEVA REFERENCIA DE USUARIO NO COINCIDE LA ACTUALIZA...
	if($_SESSION['refcl']!=$rf){

		// ACTUALIZA LA REFERENCIA EN CLIENTES WEB...
		$SqlUpdateRefClientesWeb = "UPDATE `$db_name`.$ClientesWeb SET `ref` = '$rf' WHERE $ClientesWeb.`id` = '$_POST[id]' LIMIT 1 ";
		//echo "** ".$SqlUpdateRefClientesWeb."<br>";
		if(mysqli_query($db, $SqlUpdateRefClientesWeb)){
								//print($tabla);
		}else{ print("* ERROR SQL L.63 ".mysqli_error($db))."</br>";
				show_form ();
				$LogText = $LogText." ".mysqli_error($db)."\n\t";
		}
	
		// ACTUALIZA LA REFERENCIA Y NOMBRE CLIENTE EN $CajaShop...
		$SqlUpdateRefCajaShop = "UPDATE `$db_name`.$CajaShop SET `refclient` = '$rf', `clname` = '$ClientName'  WHERE $CajaShop.`refclient` = '$refcl' ";
		//echo "** ".$SqlUpdateRefClientesWeb."<br>";
		if(mysqli_query($db, $SqlUpdateRefCajaShop)){ 
		}else{ 	print("* ERROR SQL L.74 ".mysqli_error($db))."</br>";
				$LogText = $LogText." ".mysqli_error($db)."\n\t";
		}

		// ACTUALIZA LA REFERENCIA Y NOMBRE DEL CLIENTE EN LAS TABLAS VENTAS ANUALES...
		/* DETECTO LAS TABLAS VENTAS EN INFORMATION_SCHEMA.TABLES */
		global $table_name_tbventasshop;		
		$table_name_tbventasshop = $_SESSION['clave']."ventasshop_20";
		global $SqlSchema;
		$SqlSchema = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME LIKE '$table_name_tbventasshop%' ";
		//echo "** ".$SqlSchema."<br>";
		$QrySchema = mysqli_query($db, $SqlSchema);
		$CountSchema = mysqli_num_rows($QrySchema);
		/* FIN DETECTO LAS TABLAS VENTAS */

		if($CountSchema<1){ 
			echo "<p>NO HAY DATOS EN INFORMATION_SCHEMA.TABLES ".$table_name_tbventasshop."</p>";
			$LogText = $LogText."NO HAY DATOS EN INFORMATION_SCHEMA.TABLES ".$table_name_tbventasshop."\n\t";
		}else{
			global $a; 		$a = 1;
			global $date;	$date = date('y');
			while ($a <= $CountSchema){
				$TableName = $table_name_tbventasshop.$date;
				$SqlVentasShop =  "SELECT * FROM `$db_name`.$TableName WHERE $TableName.`refclient` = '$refcl' ";
				//echo "** ".$SqlVentasShop."<br>";
				$QryVentasShop = mysqli_query($db, $SqlVentasShop);
				$RowVentasShop = mysqli_fetch_assoc($QryVentasShop);
				if(mysqli_num_rows($QryVentasShop)>0){
					$LikeValor = "%".$_SESSION['refcl']."%";
					$SqlUpdateVentasShop = "UPDATE `$db_name`.$TableName SET `refclient` = '$rf', `clname` = '$ClientName' WHERE $TableName.`refclient` LIKE '$LikeValor' ";
					//echo "** ".$SqlUpdateVentasShop."<br>";
					if(mysqli_query($db, $SqlUpdateVentasShop)){ 
						print("MODIFICADAS VARIABLES EN ".$VentasShop.": ".$refcl." POR ".$rf."<br>");
						$LogText = $LogText."* UPDATE ".$VentasShop." ID ".$RowVentasShop['id']." VALORES ".$refcl." POR ".$rf."\n\t";
					}else{ 	print("* ERROR SQL L.132 ".mysqli_error($db))."</br>"; 
							$LogText = $LogText."* ERROR SQL L.132 ".mysqli_error($db)."\n\t";
					}

				}else{ echo "<p>NO HAY DATOS ".$_SESSION['refcl']." EN ".$TableName."</p>"; 
					$LogText = $LogText."* NO HAY DATOS ".$_SESSION['refcl']." EN ".$TableName."\n\t";
				}
					$a ++;	$date = $date-1;
			} // FIN WHILE
		} // FIN ELSE

		// AL CAMBIAR LA REFERENCIA CLIENTE SE CIERRA SESIÓN POR GET...
		global $RedirUrl;	$RedirUrl = "../index.php?salir=1";
		global $RedirTime;	$RedirTime = 6000;
		require '../Inclu/AutoRedirUrl.php';
		global $Redir;      print ($Redir);
		
	// FIN SI LA REFERENCIA NO ES IGUAL...
	}else{ 
		global $RedirUrl;	$RedirUrl = "ClienteVer.php";
		global $RedirTime;	$RedirTime = 6000;
		require '../Inclu/AutoRedirUrl.php';
		global $Redir;      print ($Redir);
	} // FIN ELSE LA REFERENCIA ES IGUAL...

} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
			
function show_form($errors=[]){
	
	$_SESSION['refcl'] = $_POST['ref'];
	
	require 'TableValidateErrors.php';

	require 'ArrayTotalVar.php';

	global $ArrayCliente;		global $ArrayAdmin;    global $ArrayCaja;		global $Titulo;
	switch (true) {
		case (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')):
			$ArrayCliente = 0;		$ArrayAdmin = 1;
			$Titulo = "MODIFICAR CLIENTE O CAJERO";
			break;
		case ($_SESSION['Nivel']=='caja'):
			$ArrayCaja = 1;
			$Titulo = "MODIFICAR DATOS CAJERO";
			break;
		case ($_SESSION['Nivel']=='cliente'):
			$ArrayCliente = 1;
			$Titulo = "MODIFICAR DATOS CLIENTE";
			break;
		default:
			$ArrayCliente = 1;
			$Titulo = "MODIFICAR DATOS ACTUALES";
			break;
	}

    global $ArrayClienteModif;      $ArrayClienteModif = 1;
	require "ArrayTotal.php";
	//require "UserRefCrea.php";
	require "UserFormModif.php";

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

	global $nombre;			$nombre = $_POST['Nombre'];
	global $apellido;		$apellido = $_POST['Apellidos'];
	global $rf;				
	if(isset($_POST['refnew'])){ $rf = $_POST['refnew']; }else{ $rf = $_POST['ref']; }
		
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }

	$ActionTime = date('H:i:s');
	
	global $LogText;
	$LogText = "- ADMIN MODIFICAR 2 ".$ActionTime.". ID:".$_POST['id'].". ".$nombre." ".$apellido.".\n\t Ref: ".$rf.". Nivel: ".$_POST['Nivel'].".\n\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Password'];

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