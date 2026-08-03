<?php
session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require "../config/TablesNames.php";
	$sqld =  "SELECT * FROM $Admin WHERE `id` = '$_POST[id]'";
	$qd = mysqli_query($db, $sqld);
	$rowd = mysqli_fetch_assoc($qd);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){

		master_index();
		if(isset($_POST['oculto2'])){ show_form();
									log_info();													
		}elseif(isset($_POST['oculto'])){
					if($form_errors = validate_form()){
						show_form($form_errors);
					}else{ process_form();
							log_info();
					}
		}else{ show_form(); }

	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$kgin1 = $_POST['kgin1'];		$kgin2 = $_POST['kgin2'];
	global $kgin;					$kgin= $kgin1.".".$kgin2;
	
	$errors = array();
	
	if(strlen(trim($_POST['kgin1'])) == ''){
			$errors [] = "UNIT ENTRADA: <font color='#F1BD2D'>CAMPO OBLIGATORIO</font>";
	}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['kgin1'])){
			$errors [] = "UNIT ENTRADA: <font color='#F1BD2D'>CARACTERES NO VALIDOS.</font>";
	}elseif (!preg_match('/^[0-9]+$/',$_POST['kgin1'])){
			$errors [] = "UNIT ENTRADA: <font color='#F1BD2D'>SOLO NUMEROS</font>";
	}else{ }

	
	if(strlen(trim($_POST['kgin2'])) == ''){
			$errors [] = "DEC ENTRADA <font color='#F1BD2D'>CAMPO OBLIGATORIO</font>";
	}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['kgin2'])){
			$errors [] = "DEC ENTRADA <font color='#F1BD2D'>CARACTERES NO VALIDOS.</font>";
	}elseif (!preg_match('/^[0-9]+$/',$_POST['kgin2'])){
			$errors [] = "DEC ENTRADA <font color='#F1BD2D'>SOLO NUMEROS</font>";
	}else{ }

	
	if(strlen(trim($_POST['pvp1'])) == ''){
			$errors [] = "€ PVP SIN IVA <font color='#F1BD2D'>CAMPO OBLIGATORIO</font>";
	}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['pvp1'])){
			$errors [] = "€ PVP SIN IVA <font color='#F1BD2D'>CARACTERES NO VALIDOS.</font>";
	}elseif (!preg_match('/^[0-9]+$/',$_POST['pvp1'])){
			$errors [] = "€ PVP SIN IVA <font color='#F1BD2D'>SOLO NUMEROS</font>";
	}else{ }

	
	if(strlen(trim($_POST['pvp2'])) == ''){
			$errors [] = "CENT PVP SIN IVA <font color='#F1BD2D'>CAMPO OBLIGATORIO</font>";
	}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['pvp2'])){
			$errors [] = "CENT PVP SIN IVA <font color='#F1BD2D'>CARACTERES NO VALIDOS.</font>";
	}elseif (!preg_match('/^[0-9]+$/',$_POST['pvp2'])){
			$errors [] = "CENT PVP SIN IVA <font color='#F1BD2D'>SOLO NUMEROS</font>";
	}else{ }

	return $errors;

} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	global $date;					$date = date('Y-m-d');
	global $datekgbad;				$datekgbad = $_POST['datekgbad'];

	$SqlSelectProductos =  "SELECT * FROM $Productos WHERE `id` = '$_POST[id]' AND `valor` = '$_POST[producto]' ";
		$QrySelectProductos = mysqli_query($db, $SqlSelectProductos);
		$RowSelectProductos = mysqli_fetch_assoc($QrySelectProductos);

	require 'FormatNumber.php';
	global $perecedero;		$perecedero = $kgbad + $RowSelectProductos['kgbad'];
	global $diferencia;		$diferencia = ($entrada - $perecedero) - $CajaShop;

	if(($entrada - $perecedero) < 0){ $diferencia = '-' .$diferencia;}

	$SqlUpdateProductos = "UPDATE `$db_name`.$Productos SET `psiva` = '$psiva', `iva` = '$_POST[iva]', `ivae` = '$ivae', `pvp` = '$pvp', `kgin` = '$kgin', `datekgin` = '$_POST[datekgin]', `datekgbad` = '$datekgbad', `datecash` = '$date', `stock` = '$diferencia', `coment` = '$_POST[coment]' WHERE $Productos.`id` = '$_POST[id]' LIMIT 1 ";

	global $Redir;
	if(mysqli_query($db, $SqlUpdateProductos)){
		 
		require 'StockModifTablesResult.php';
		print($TableStockModif);

    	global $RedirUrl;	$RedirUrl = "ProductosVer.php?seccion=".$_POST['seccion'];
		global $RedirTime;	$RedirTime = 6000;
		require '../Inclu/AutoRedirUrl.php';
		global $Redir;      print ($Redir);
		
	}else{  print("* ERROR SQL L.106".mysqli_error($db))."</br>";
			show_form ();
	}

} // FIN FUNCTION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
		
		global $db; 	global $db_name;
		require "../config/TablesNames.php";
		
		global $MinDate;		$MinDate = date('Y-m-d');
		global $MaxDate;		$MaxDate = date('Y-').(date('m')+3).date('-d');

		require 'ProductosArrayTotalVar.php';
		global $ArrayStockModificar;			$ArrayStockModificar = 1;
		require	'ProductosArrayTotal.php';
	
		require 'TableValidateErrors.php';

		require 'StockModificarForm.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function log_info(){

	global $SecName; 		$SecName = $SecName;	

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- STOCK MODIFICAR 2 ".$ActionTime.". ".$SecName.".\n\t ID: ".$_POST['id'].".\n\t DATE IN:".$_POST['nsemana']."/".$_POST['datekgin'].".\n\t Pro Ref: ".$_POST['producto'].".\n\t Pro Name: ".@$_POST['proname'].".\n\t €/PVP ".$_POST['pvp'].".\n\t UNIT IN:".@$_POST['kgin'].".\n\t UNIT BAD:".@$_POST['kgbad'].".\n\t UNIT CASH:".@$_POST['kgcash'];

	require 'logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $Stocks;        $Stocks = '';
	
		require '../Inclu_Menu/Master_Index.php';
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	require '../Inclu/Inclu_Footer.php';
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>