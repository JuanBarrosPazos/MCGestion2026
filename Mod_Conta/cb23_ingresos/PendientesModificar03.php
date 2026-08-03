<?php
session_start();

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../Inclu/Conta_Head.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';
		
	require '../Inclu/sqld_query_fetch_assoc.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 

		master_index();

		if(isset($_POST['oculto2'])){	info_01();
										show_form();
		} elseif(isset($_POST['ocultoModif3'])){
			if($form_errors = validate_form()){
				show_form($form_errors);
		}else{ // SI PASA LA VALIDACIÓN

			// SI NO HA MARCADO EL CHECK
			if((!isset($_POST['xl']))||((!isset($_POST['xlb']))&&($_SESSION['stat'] == 'close'))){
				if(!isset($_POST['xl'])){
					print("<div style='text-align:center; margin:auto;'>
								* HA DE MARCAR LA CASILLA DE CONFIRMACIÓN
							</div>");
				}else { }

				if((!isset($_POST['xlb']))&&($_SESSION['stat'] == 'close')){
					print("<div style='text-align:center; margin:auto;'>
								* HA DE ACEPTAR LA NUEVA RUTA DE RECUPERACIÓN
							</div>");
				}else { }
						show_form();

			}elseif(isset($_POST['xl'])){ // SI HA SELECCIONADO EL CHECK
					process_form_2(); 
					echo "HE PASASO LA VALIDACIÓN Y PROCESS_FORM_2()<br>";
				}
			}

		}else{show_form();}
							
	}else{ require '../Inclu/table_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
	
		global $db; 	global $sqld; 	global $qd; 	global $rowd;

		//global $papelera;		$papelera = 1;
		global $ingresoModif3;	$ingresoModif3 = 1;
		
		$errors = array();
		
		require 'ValidateForm.php';

		return $errors;

	} 
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form_2(){

		global $db; 		global $db_name;
		global $vname; 		global $dyt1;		

		global $rutaNew;	global $vnamei;
		if($_SESSION['stat'] == 'close'){
			$dyt1 = $_SESSION['newDy'];
			$rutaNew = $_POST['delruta'];
			$vnamei = "`".$_SESSION['clave']."ingresos_".$dyt1."`";
			$_POST['dy'] = $_SESSION['newDy'];
		}else{
			$dyt1 = $_SESSION['dyt1'];
			$rutaNew = "../cb23_Docs/docingresos_".$dyt1."/";
			$vnamei = "`".$_SESSION['clave']."ingresos_".$dyt1."`";
		}

		echo "* RUTA NEW ".$rutaNew."<br>";
		echo "* VNAMEI ".$vnamei."<br>";

		global $rutaOld;	$rutaOld = "../cb23_Docs/docingresos_pendientes/";
		global $vnamed; 	$vnamed = "`".$_SESSION['clave']."ingresos_pendientes`";
		
		echo "* RUTA OLD ".$rutaOld."<br>";
		echo "* VNAMED ".$vnamed."<br>";
		
		global $rutPend;	$rutPend = 'Pendientes';
		global $pend;	$pend = "PENDIENTES";
		require 'Botonera.php';
		global $title;			$title = 'SE HA RECUPERADO LA FACTURA EN ';

		require 'FactDate.php';

		if($_SESSION['stat'] == 'close'){ 
			//$_POST['dy'] = $_SESSION['newDy'];
			global $factdate;	$factdate = $_SESSION['newDy']."-".date('m-d');
		}else{ }

		require 'FormatNumber.php';

		require 'Modificar03FunctProcessForm2.php';

		/*
		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='PendientesVer.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
		*/

		/*
			global $dyx; 		$dyx = $_POST['dy'];
			global $dmx; 		$dmx = "M".$_POST['dm'];

			global $mes;
			if(($dmx == "M01")||($dmx == "M02")||($dmx == "M03")){$mes = "TRI1";}
			elseif(($dmx == "M04")||($dmx == "M05")||($dmx == "M06")){$mes = "TRI2";}
			elseif(($dmx == "M07")||($dmx == "M08")||($dmx == "M09")){$mes = "TRI3";}
			elseif(($dmx == "10")||($dmx == "11")||($dmx == "12")){$mes = "TRI4";}
		*/
	
	} // FIN process_form_2()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){

		global $rutPend;	$rutPend = 'Pendientes';
		global $pend;	$pend = "PENDIENTES";
		require 'Botonera.php';
		global $titulo; 	$titulo = "MARCAR COMO COBRADO ESTE INGRESO PENDIENTE";
		global $titInput;	$titInput = "GUARDAR INGRESO PENDIENTE COMO PAGADO";
		global $TituloCheck;	$TituloCheck = "SI SE HA PAGADO LA FACTURA MARQUE LA CASILLA";

		global $rutaOld;		$rutaOld = "../cb23_Docs/docingresos_pendientes/";
		//echo "* ".$rutaOld."<br>";
		global $rutaDir;	$rutaDir = $rutaOld;

		global $db; 		global $db_name;

		global $ingresoModif3;	$ingresoModif3 = 1;

		require 'Modificar03FunctShowForm.php';

	} // FIN function show_form($errors=[])

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info_01(){

		global $db;
		
		$TitBut = "\n\tFiltro => \n\tDATE: ".$_POST['factdate'].".\n\tR. Social: ".$_POST['factnom'].".\n\tDNI: ".$_POST['factnif'].".\n\tNº FACTURA: ".$_POST['factnum'].".";

		$ActionTime = date('H:i:s');

		global $text;
		$text = "\n- INGRESO PENDIENTE MODIFICAR SELECCIONADO FACTURA PAGADA ".$ActionTime.".\n\tNº FACTURA: ".$_POST['factnum'].".\n\tDATE FACTURA: ".$_POST['factdate'].".\n\tRAZON SOCIAL: ".$_POST['factnom'].".\n\tNIF: ".$_POST['factnif'].".\n\tTIPO IVA %: ".$_POST['factiva'].".\n\tIMP €: ".$_POST['factivae'].".\n\tNETO €: ".$_POST['factpvp'].".\n\tTOTAL €: ".$_POST['factpvptot'];
	
		require 'WriteLog.php';


	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info_02(){

	global $db; 		global $factivae;
	global $factpvp; 	global $factpvptot; 	global $factdate;

	$ActionTime = date('H:i:s');

	global $text;
	$text = "\n- INGRESO PENDIENTE MODIFICADO FACTURA PAGADA ".$ActionTime.".\n\tNº FACTURA: ".$_POST['factnum'].".\n\tDATE FACTURA: ".$factdate.".\n\tRAZON SOCIAL: ".$_POST['factnom'].".\n\tNIF: ".$_POST['factnif'].".\n\tTIPO IVA %: ".$_POST['factiva'].".\n\tIMP €: ".$factivae.".\n\tNETO €: ".$factpvp.".\n\tTOTAL €: ".$factpvptot;

		$logname = $_SESSION['Nombre'];	
		$logape = $_SESSION['Apellidos'];	
		$logname = trim($logname);	
		$logape = trim($logape);

		require 'WriteLog.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaIngresos;	$rutaIngresos = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
				} /* Fin funcion master_index.*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	 require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>