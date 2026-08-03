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
		if(isset($_POST['oculto2'])){ 	show_form();
										log_info();													
		}elseif(isset($_POST['oculto'])){
					if($form_errors = validate_form()){
							show_form($form_errors);
					}else{ 	process_form();
							log_info();
					}
		}else{ show_form(); }

	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){

	global $db;		global $db_name;
	require "../config/TablesNames.php";
	
	$SqlSelectProductos =  "SELECT * FROM $Productos WHERE `id` = '$_POST[id]' AND `valor` = '$_POST[producto]' LIMIT 1";
	$QrySelectProductos = mysqli_query($db, $SqlSelectProductos);
	$RowSelectProductos = mysqli_fetch_assoc($QrySelectProductos);

	$kgbad1 = $_POST['kgbad1'];			$kgbad2 = $_POST['kgbad2'];	
	global $kgbad;						$kgbad = $kgbad1.".".$kgbad2;
	$kgbad = floatval($kgbad);			$kgbad = number_format($kgbad,2,".","");

	global $pvptot;					$pvptot = $RowSelectProductos['pvp'];
	$pvptot = floatval($pvptot);	$pvptot = number_format($pvptot,2,".","");

	global $Stock;		global $perecedero;
	switch (true) {
		case $kgbad==0:
				$perecedero = $RowSelectProductos['kgbad'];
				$Stock = $RowSelectProductos['stock'];
			break;
		case ($kgbad>0):
				$perecedero = ($RowSelectProductos['kgbad']+$kgbad);
				$Stock = $RowSelectProductos['stock'] - $kgbad;
			break;
		case ($kgbad<0):
				$perecedero = ($RowSelectProductos['kgbad']+$kgbad);
				$Stock = $RowSelectProductos['stock'] - $kgbad;
			break;
		default:
				$perecedero = $RowSelectProductos['kgbad'];
				$Stock = $RowSelectProductos['stock'];
			break;
	}

	$perecedero = floatval($perecedero);	$perecedero = number_format($perecedero,2,".","");
	$Stock = floatval($Stock);				$Stock = number_format($Stock,2,".","");

	$errors = array();
	
	if(strlen(trim($_POST['kgbad1'])) == ''){
			$errors [] = "UNIT PERECEDEROS: <font color='#F1BD2D'>CAMPO OBLIGATORIO</font>";
	}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['kgbad1'])){
			$errors [] = "UNIT PERECEDEROS: <font color='#F1BD2D'>CARACTERES NO VALIDOS.</font>";
	}else{ }

	
	if(strlen(trim($_POST['kgbad2'])) == ''){
			$errors [] = "DEC PERECEDEROS <font color='#F1BD2D'>CAMPO OBLIGATORIO</font>";
	}elseif(($_POST['kgbad1'] == 0)&&($_POST['kgbad2'] == 0)){
			$errors [] = "UNIT PERECEDEROS: <font color='#F1BD2D'>0.00</font>";
	}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['kgbad2'])){
			$errors [] = "DEC PERECEDEROS <font color='#F1BD2D'>CARACTERES NO VALIDOS.</font>";
	}elseif (!preg_match('/^[0-9]+$/',$_POST['kgbad2'])){
			$errors [] = "DEC PERECEDEROS <font color='#F1BD2D'>SOLO NUMEROS</font>";
	}else{ }

	if($perecedero<0){
		$errors [] = "<font color='#F1BD2D'>PERECEDEROS ".$perecedero." INFERIOR A 0.00</font>";
	}
			
	return $errors;

} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	global $date;				$date = date('Y-m-d');
	global $datekgbad;			$datekgbad = $_POST['datekgbad'];

	$SqlSelectProductos =  "SELECT * FROM $Productos WHERE `id` = '$_POST[id]' AND `valor` = '$_POST[producto]' LIMIT 1";
		$QrySelectProductos = mysqli_query($db, $SqlSelectProductos);
		$RowSelectProductos = mysqli_fetch_assoc($QrySelectProductos);

	//require 'FormatNumber.php';
	global $Stock;		global $perecedero;

	$SqlUpdateProductos = "UPDATE `$db_name`.$Productos SET `kgbad` = '$perecedero', `datekgbad` = '$datekgbad', `datecash` = '$date', `stock` = '$Stock' WHERE $Productos.`id` = '$_POST[id]' LIMIT 1 ";

	global $Redir;
	if(mysqli_query($db, $SqlUpdateProductos)){ 
		require 'StockModifTablesResult.php';
		print($TablePerecederos);

    	global $RedirUrl;	$RedirUrl = "ProductosVer.php?seccion=".$_POST['seccion'];
		global $RedirTime;	$RedirTime = 6000;
		require '../Inclu/AutoRedirUrl.php';
		global $Redir;      print ($Redir);

	}else{  print("* ERROR SQL L.123".mysqli_error($db))."</br>";
			show_form ();
	}

} // FIN FUNCTION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
		
		global $db;		global $db_name;
		require "../config/TablesNames.php";

		$SqlSelectProductos =  "SELECT * FROM $Productos WHERE `valor` = '$_POST[producto]' LIMIT 1";
		$QrySelectProductos = mysqli_query($db, $SqlSelectProductos);
		global $RowSelectProductos;
		$RowSelectProductos = mysqli_fetch_assoc($QrySelectProductos);
		
		require 'TableValidateErrors.php';

		global $MinDate;		$MinDate = date('Y-m-d');
		global $MaxDate;		$MaxDate = date('Y-').(date('m')+3).date('-d');

		require 'ProductosArrayTotalVar.php';
		global $ArrayStockPerecederos;			$ArrayStockPerecederos = 1;
		require	'ProductosArrayTotal.php';

		require 'StockModifPerecederosForm.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function log_info(){

	global $SecName; 		$SecName = $SecName;	

	$ActionTime = date('H:i:s');

	global $dir;
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){ 
		$dir = 'Admin';}
	
		global $LogText;
		$LogText = "- STOCK MODIFICAR 2 ".$ActionTime.". ".$SecName.".\n\t ID: ".$_POST['id'].".\n\t Pro Ref: ".$_POST['producto'].".\n\t Pro Name: ".@$_POST['proname'];

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