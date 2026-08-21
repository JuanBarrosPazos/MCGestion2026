<?php
session_start();

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../Inclu/Conta_Head.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';
	require 'PapeleraVer02.php';

	$_SESSION['usuarios'] = '';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require 'VerLogica.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
	
		require 'IncShowForm01Val.php';

		return $errors;

	} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){
		
		global $db;
 
		show_form();

		global $dyt1;
		
		require 'FactDate.php';

		global $vname; 		$vname ="`".$_SESSION['clave']."ingresos_".$dyt1."`";

		global $sqlb;
		require 'FormConsultaFiltroGt2.php';
		
		require 'FunctVerTodoSumTotal.php';

		global $rutPend;	$rutPend = '';
		global $pend;	$pend = "";
		require 'Botonera.php';

		if(!$qb){
				print("<font color='#F1BD2D'>
						Se ha producido un error: </font>".mysqli_error($db)."</br>");
		}else{
			if(mysqli_num_rows($qb) == 0){
					global $titNoData;		$titNoData = "PAPELERA INGRESOS ".$dyt1."<br>";
					require 'NoData.php';
			}else{ 
					require 'PapeleraRowbTabla.php';
						} /* Fin segundo else anidado en if */

		} /* Fin de primer else . */
				
	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){
	
		if(isset($_POST['show_formcl'])){
					$defaults = $_POST;
		}elseif(isset($_POST['todo'])){
				$defaults = $_POST;
		}else{ $defaults = array ( 'factnom' => '',
									'factnif' => '',
									'factnum' => '',
									'factnumini' => '',
									'Orden' => isset($ordenar));
								}

		global $titulo; 		$titulo = "CONSULTAR PAPELERA INGRESOS";
		global $TitBut1;		$TitBut1 = "VER TODOS PAPELERA INGRESOS";		
		global $TitBut2;		$TitBut2 = "FILTRO BUSQUEDA PAPELERA INGRESOS";
		global $papelera;		$papelera = 1;
		require 'IncShowForm01.php';	

	}	/* Fin show_form(); */


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function ver_todo(){
		
		global $db; 		global $db_name;		global $limit;

		global $dyt1;
		require 'FactDate.php';

		global $orden;
		if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
			$orden = $_POST['Orden'];
		}else{ $orden = '`id` ASC'; }

		global $vname; 		$vname = "`".$_SESSION['clave']."ingresos_".$dyt1."`";

		global $iniVerTodo;		global $sqlb;
		if($iniVerTodo == 1){
				global $limit;
				$sqlb =  "SELECT * FROM $vname WHERE `del`='true' ORDER BY `factdate` DESC $limit";
		}else{
			require 'FormConsultaFiltroGt1.php';
		}

		//$sqlb =  "SELECT * FROM $vname WHERE `factdate` LIKE '$fil' ORDER BY $orden $limit ";

		require 'FunctVerTodoSumTotal.php';

		global $rutPend;	$rutPend = '';
		global $pend;	$pend = "";
		require 'Botonera.php';

		if(!$qb){
			print("<font color='#F1BD2D'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
		}else{
			if(mysqli_num_rows($qb) == 0){
				global $titNoData;		$titNoData = "PAPELERA INGRESOS ".$dyt1."<br>";
				require 'NoData.php';
			}else{ 
					require 'PapeleraRowbTabla.php';
				} /* Fin segundo else anidado en if */
		} /* Fin de primer else . */
				
	}	/* FIN ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaIngresos;	$rutaIngresos = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info(){

	global $dd;
	if($_POST['dd'] == ''){$dd = "DIA TODOS";}else{$dd = $_POST['dd'];}
	global $dm;
	if($_POST['dm'] == ''){$dm = "MES TODOS";}else{$dm = $_POST['dm'];}
	global $dy;
	if($_POST['dy'] == ''){ $dy = date('Y');} else{$dy = $_POST['dy'];}

	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
		$orden = $_POST['Orden'];
	}else{ $orden = '`id` ASC'; }

	if(isset($_POST['todo'])){$TitBut = "\n\tFiltro => TODOS LOS INGRESOS. ".$orden."\n\tDATE: ".$dy."-".$dm."-".$dd.".";}
	else{$TitBut = "\n\tFiltro => \n\tDATE: ".$dy."-".$dm."-".$dd.".\n\tR. Social: ".$_POST['factnom'].".\n\tDNI: ".$_POST['factnif'].".\n\tNº FACTURA: ".$_POST['factnum'].".";}

	$ActionTime = date('H:i:s');

	global $text; 		$text = "\n- INGRESOS CONSULTAR ".$ActionTime.$TitBut;
	
	require 'WriteLog.php';
	
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>