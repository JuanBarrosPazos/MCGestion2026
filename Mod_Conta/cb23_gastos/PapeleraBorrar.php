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

		if(isset($_POST['oculto2'])){ info_01();
									  show_form();
		}elseif(isset($_POST['oculto'])){	
				// SI NO HA MARCADO PARA BORRAR.
				if(!isset($_POST['xl'])){
					print("<div style='text-align:center; margin:auto;'>
								* HA DE MARCAR LA CASILLA DE CONFIRMACIÓN
							</div>");
						show_form();
				}elseif(isset($_POST['xl'])){
							process_form();
							info_02();
								}
		} else {show_form();}

	} else { require '../Inclu/table_permisos.php'; } 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){

		global $rutPend;	$rutPend = '';
		global $pend;		$pend = "";
		require 'Botonera.php';

		require 'FactDate.php';

		global $db, $db_name;
		global $dyt1;		$dyt1 = $_POST['dy'];

		global $vname; 		$vname = "`".$_SESSION['clave']."gastos_".$dyt1."`";
 
		require 'FormatNumber.php';

		/////////////
			
		$sqla = "DELETE FROM `$db_name`.$vname  WHERE $vname.`id` = '$_POST[id]' ";
			
		if(mysqli_query($db, $sqla)){ 
			
			global $title;			$title = 'SE HA BORRADO EN ';
			global $Borrar2;		$Borrar2= "style='display:none; visibility: hidden;'";
			global $Modif2;			$Modif2= "style='display:none; visibility: hidden;'";
			global $ModImg2;		$ModImg2= "style='display:none; visibility: hidden;'";
			global $PendienteG;		$PendienteG = "style='display:none; visibility: hidden;'";
			global $Ver2;			$Ver2= "style='display:none; visibility: hidden;'";

			global $ConteBotones;	$ConteBotones = "style='display:block;'";
			require 'TableFormResult.php';			
			
			echo $_POST['delruta'].$_POST['myimg1']."<br>";

			if( file_exists($_POST['delruta'].$_POST['myimg1']) ){
				$destination_file = $_POST['delruta'].$_POST['myimg1'];
				unlink($destination_file);
				}

			if( file_exists($_POST['delruta'].$_POST['myimg2']) ){
				$destination_file = $_POST['delruta'].$_POST['myimg2'];
				unlink($destination_file);
				}

			if( file_exists($_POST['delruta'].$_POST['myimg3']) ){
				$destination_file = $_POST['delruta'].$_POST['myimg3'];
				unlink($destination_file);
				}

			if( file_exists($_POST['delruta'].$_POST['myimg4']) ){
				$destination_file = $_POST['delruta'].$_POST['myimg4'];
				unlink($destination_file);
				}

		} else { print("* ERROR L.59: ".mysqli_error($db));
					show_form ();
					global $texerror; $texerror = "\n\t ".mysqli_error($db);
					}

		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='PapeleraVer.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);

	} // FIN process_form()
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form(){

		global $db;			global $db_name;
		
		global $rutPend;	$rutPend = '';
		global $pend;		$pend = "";
		require 'Botonera.php';

		global $TituloCheck;	$TituloCheck = "CONFIRME EL BORRADO CON EL CHECKBOX";

		global $dyt1;

		if(isset($_POST['oculto2'])){

			require 'FunctShowFormOculto2Var.php';

			$sesionref2 = "docgastos_".$dyt1;
			global $DelRuta;		$DelRuta ="../cb23_Docs/".$sesionref2."/";

			global $VarArray;	$VarArray = 1;
			require 'ArrayTotal.php';
			
	}elseif(isset($_POST['oculto'])){
			$defaults = $_POST;
	}

		////////////////////

		global $titulo; 	$titulo = "ELIMINAR FACTURA TOTALMENTE";
		global $titInput;	$titInput = "BORRAR FACTURA TOTALMENTE";
		global $Borrar2;	$Borrar2= "style='display:none; visibility: hidden;'";

		global $papelera;		$papelera = 1;
		
		global $checked;

		if(@$defaults['xl'] == 'yes') { $checked = "checked='checked'";}else{ $checked = ""; }
		
		global $Checkbox;
		$Checkbox = "<tr>
						<td colspan='2' style='text-align:center;' >
							".$TituloCheck." : &nbsp; 
							<input type='checkbox' name='xl' value='yes' ".$checked."/>
						</td>
					</tr>";
		global $rutaDirTr;
		$rutaDirTr ="<tr>
						<td style='text-align: right !important;' >RUTA DIR</td>
						<td>".@$defaults['delruta']."</td>			
					</tr>";

		/*	OCULTO FUNCIONES CON STATUS CLOSE
		global $a;	$a= $defaults['dy'];
		global $vnameStatus; 		$vnameStatus = "`".$_SESSION['clave']."status`";
		$sqlSTatus =  "SELECT * FROM $vnameStatus WHERE `year`='$a' LIMIT 1 ";
		$qStauts = mysqli_query($db, $sqlSTatus);
		$rowStatus = mysqli_fetch_assoc($qStauts);

		if($rowStatus['stat']=='close'){
			global $Borrar2;		$Borrar2= "style='display:none; visibility: hidden;'";
			global $Modif2;			$Modif2= "style='display:none; visibility: hidden;'";
			global $PendienteG;		$PendienteG = "style='display:none; visibility: hidden;'";
			global $Recupera3;		$Recupera3 = "style='display:none; visibility: hidden;'";
		}else{ }
		*/

		require 'TableBorrar.php';
	
	} // FIN function show_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info_01(){

	global $db;
	
		$TitBut = "\n\tFiltro => \n\tDATE: ".$_POST['factdate'].".\n\tR. Social: ".$_POST['factnom'].".\n\tDNI: ".$_POST['factnif'].".\n\tNº FACTURA: ".$_POST['factnum'].".";

		$ActionTime = date('H:i:s');

		global $text;
		$text = "\n- GASTO SELECCIONADO MODIFICAR ".$ActionTime.$TitBut;
		
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
		$text = "\n- GASTO MODIFICADO ".$ActionTime.".\n\tNº FACTURA: ".$_POST['factnum'].".\n\tDATE FACTURA: ".$factdate.".\n\tRAZON SOCIAL: ".$_POST['factnom'].".\n\tNIF: ".$_POST['factnif'].".\n\tTIPO IVA %: ".$_POST['factiva'].".\n\tIMP €: ".$factivae.".\n\tNETO €: ".$factpvp.".\n\tTOTAL €: ".$factpvptot;

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
		global $rutaGastos;	$rutaGastos = "";
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