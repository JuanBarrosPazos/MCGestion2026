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
		}elseif(isset($_POST['ocultoRecup'])){

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


				/*
				// SI NO HA MARCADO EL CHECK
				if(!isset($_POST['xl'])){
						print("<div style='text-align:center; margin:auto;'>
									* HA DE MARCAR LA CASILLA DE CONFIRMACIÓN
								</div>");
							show_form();
				}elseif(isset($_POST['xl'])){ // SI HA SELECCIONADO EL CHECK
					if($form_errors = validate_form()){
						show_form($form_errors);
					}else{ // SI PASA LA VALIDACIÓN
							//process_form_2(); 
							echo "HE PASASO LA VALIDACIÓN <br>";
							}
				}
				*/

		}else{show_form();}
							
	}else{ require '../Inclu/table_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
	
		global $db; 	global $sqld; 	global $qd; 	global $rowd;

		global $papelera;		$papelera = 1;

		$errors = array();
		
		require 'ValidateForm.php';

		return $errors;

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form_2(){
	
		global $db; 			global $db_name;
		global $vname; 			global $dyt1;		$dyt1 = $_SESSION['dyt1'];
		//echo "** ".$dyt1."<br>";

		global $vnamed; 		$vnamed = "`".$_SESSION['clave']."ingresosfeed`";

		$idx = $_SESSION['idx'];
		// RECUPERO LA RUTA OLD DE LA BBDD
		$sqlrt = "SELECT * FROM `$db_name`.$vnamed  WHERE $vnamed.`id` = '$idx' LIMIT 1 ";
		$qrt = mysqli_query($db,$sqlrt);
		$rowrt = mysqli_fetch_assoc($qrt);
		global $rutaOld;	$rutaOld = $rowrt['ruta'];
		//echo "\$rutaOld = ".$rutaOld."<br>";

		global $vnamei;		//$vnamei = "`".$_SESSION['clave']."ingresos_".$dyt1."`";
		//echo $_POST['delruta']."<br>";
		global $vnameRuta;
		$vnameRuta = str_replace("../cb23_Docs/doc", "", $_POST['delruta']);
		$vnameRuta = str_replace("/", "", $vnameRuta);
		$vnamei = "`".$_SESSION['clave'].$vnameRuta."`";
		global $rutaNew;	$rutaNew = $_POST['delruta'];
		//echo $vnamei."<br>";

		global $rutPend;	$rutPend = '';
		global $pend;	$pend = "";
		require 'Botonera.php';
		global $title;			$title = 'SE HA INSERTADO LA FACTURA EN ';

			if($_SESSION['stat'] == 'close'){ $_POST['dy'] = $_SESSION['newDy']; }else{ }
		require 'FactDate.php';
			if($_SESSION['stat'] == 'close'){
				//$_POST['dy'] = $_SESSION['newDy'];
				global $factdate;	$factdate = $_SESSION['newDy']."-".date('m-d');
			}else{ }
			//echo $factdate."<br>";

		require 'FormatNumber.php';

		//require 'Modificar03FunctProcessForm2.php';
		
		$idx = $_SESSION['idx'];

		global $sent;
		$sent = "INSERT INTO `$db_name`.$vnamei (`factnum`, `factnumini`, `factdate`, `factdateini`, `refcliente`, `factnom`, `factnif`, `factiva`, `factivae`, `factpvp`, `factret`, `factrete`, `factpvptot`,`coment`, `myimg1`, `myimg2`, `myimg3`, `myimg4`, `factcrea`) VALUES ('$_POST[factnum]', '$_POST[factnumini]', '$factdate', '$_POST[factdateini]', '$_POST[clienteingresos]', '$_POST[factnom]', '$_POST[factnif]', '$_POST[factiva]', '$factivae', '$factpvp', '$_POST[factret]', '$factrete', '$factpvptot', '$_POST[coment]', '$_SESSION[myimg1]', '$_SESSION[myimg2]', '$_SESSION[myimg3]', '$_SESSION[myimg4]', '$_POST[factcrea]')";
		
		if(mysqli_query($db, $sent)){
			
			echo "** SE HA GRABADO EN ".$vnamei."<br>";

			//global $title;			$title = 'SE INSERTADO LA FACTURA EN ';
			global $Borrar2;		$Borrar2= "style='display:none; visibility: hidden;'";
			global $Modif2;			$Modif2= "style='display:none; visibility: hidden;'";
			global $ModImg2;		$ModImg2= "style='display:none; visibility: hidden;'";
			global $PendienteG;		$PendienteG= "style='display:none; visibility: hidden;'";
			global $Recupera3;		$Recupera3 = "style='display:none; visibility: hidden;'";
			global $Ver2;			$Ver2= "style='display:none; visibility: hidden;'";
			global $ConteBotones;	$ConteBotones = "style='display:block;'";

			global $papelera;		$papelera = 1;

		if($_SESSION['stat'] == 'close'){

			global $rutaOld;		global $rutaNew;
			if(file_exists($rutaOld.$_SESSION['myimg1'])){
						copy($rutaOld.$_SESSION['myimg1'], $rutaNew.$_SESSION['myimg1']);
			}else{
				print("<br/>- No Ok Copy Img Name 1 ".$rutaOld.$_SESSION['myimg1']. " TO ".$rutaNew.$_SESSION['myimg1']);}
 
			if(file_exists($rutaOld.$_SESSION['myimg2']) ){
						copy($rutaOld.$_SESSION['myimg2'], $rutaNew.$_SESSION['myimg2']);
			}else{
				print("<br/>- No Ok Copy Img Name 2 ".$rutaOld.$_SESSION['myimg2']. " TO ".$rutaNew.$_SESSION['myimg2']);}
											
			if(file_exists($rutaOld.$_SESSION['myimg3']) ){
						copy($rutaOld.$_SESSION['myimg3'], $rutaNew.$_SESSION['myimg3']);
			}else{
				print("<br/>- No Ok Copy Img Name 3 ".$rutaOld.$_SESSION['myimg3']. " TO ".$rutaNew.$_SESSION['myimg3']);}
											
			if(file_exists($rutaOld.$_SESSION['myimg4']) ){
						copy($rutaOld.$_SESSION['myimg4'], $rutaNew.$_SESSION['myimg4']);
			}else{print("<br/>- No Ok Copy Img Name 4 ".$rutaOld.$_SESSION['myimg4']. " TO ".$rutaNew.$_SESSION['myimg4']);}

			if(file_exists($rutaOld.$_SESSION['myimg1']) ){ unlink($rutaOld.$_SESSION['myimg1']); }else{ }
			if(file_exists($rutaOld.$_SESSION['myimg2']) ){ unlink($rutaOld.$_SESSION['myimg2']); }else{ }
			if(file_exists($rutaOld.$_SESSION['myimg3']) ){ unlink($rutaOld.$_SESSION['myimg3']); }else{ }
			if(file_exists($rutaOld.$_SESSION['myimg4']) ){ unlink($rutaOld.$_SESSION['myimg4']); }else{ }

		}else{ } // FIN $_SESSION['stat'] == 'close'

			require 'TableFormResult.php';
			
		}else{
			print("* ERROR L.64: ".mysqli_error($db));
			global $texerror; 	$texerror = "\n\t ".mysqli_error($db);
				}

		$idx = $_SESSION['idx'];
		// global $vnamed; 		$vnamed = "`".$_SESSION['clave']."ingresos_".$dyt1."`";
		$sqla = "DELETE FROM `$db_name`.$vnamed  WHERE $vnamed.`id` = '$idx'  ";

		if(mysqli_query($db, $sqla)){

			echo "** SE HA BORRADO EN ".$vnamed."<br>";

		}else{
			print("* ERROR L.88: ".mysqli_error($db));
			global $texerror; 	$texerror = "\n\t ".mysqli_error($db);
				}

		/*
		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='PapeleraVer.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
		*/
		
	} // FIN process_form_2()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){

		global $rutPend;	$rutPend = '';
		global $pend;	$pend = "";
		require 'Botonera.php';
		global $titulo; 	$titulo = "RECUPERAR ESTA FACTURA A SU UBICACIÓN ORIGINAL";
		global $titInput;	$titInput = "RECUPERAR FACTURA";
		global $TituloCheck;	$TituloCheck = "SI DESEA RECUPERAR LA FACTURA MARQUE LA CASILLA";

		if(isset($_POST['oculto2'])){ $_SESSION['yold'] = substr($_POST['factdate'],0,4); }else{ }

		global $db; 	global $db_name;

		global $papelera;		$papelera = 1;
		global $papeleraRecup;	$papeleraRecup = 1;

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