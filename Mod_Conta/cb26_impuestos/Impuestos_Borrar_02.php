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

		if (isset($_POST['oculto2'])){	show_form();
										info_01();
		} elseif(isset($_POST['oculto'])){	process_form();
											info_02();
		} else { show_form(); }

	} else { require '../Inclu/table_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $InicioBlackTit;		$InicioBlackTit = "INICIO IMPUESTOS";
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	global $db; 		global $db_name;	
	global $dyt1; 		global $dm1;
	
	$iva1 = $_POST['iva1'];
	$iva2 = $_POST['iva2'];
	global $tiva; 		$tiva = $iva1.".".$iva2; 		$tiva = trim($tiva);
	global $name; 		$name = $tiva." %";

	global $vname; 		$vname = "`".$_SESSION['clave']."impuestos`";

	$tabla = "<table class='tableForm' >
				<tr>
					<th colspan=4 >BORRADO EN ".strtoupper($vname)."</th>
				</tr>
				<tr>
					<td>IMPUESTO %</td><td>".$tiva."</td>
					<td>NAME</td><td>".$name."</td>
				</tr>
				<tr>
					<td colspan=4 style='text-align:right;'>
						".$InicioBlack."
							<a href='Impuestos_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
					</td>
				</tr>
			</table>";	
		
		global $db;		global $db_name;
		global $idx;	$idx = $_SESSION['idx'];

		$sqla = "DELETE FROM `$db_name`.$vname WHERE $vname.`id` = '$idx'";
		
		if(mysqli_query($db, $sqla)){ print($tabla); 
				} else {
					print("* MODIFIQUE LA ENTRADA 104: ".mysqli_error($db));
					show_form ();
					global $texerror; 	$texerror = "\n\t ".mysqli_error($db);
						}

		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='Impuestos_Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
			
	} // FIN function process_fomr()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	

	global $InicioBlackTit;		$InicioBlackTit = "INICIO IMPUESTOS";
	global $DeleteWhiteTit;		$DeleteWhiteTit = "BORRAR";
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	global $db; 	global $db_name;
	
	if(isset($_POST['oculto2'])){
		$_SESSION['idx'] = $_POST['id'];
	
		$iva = strlen(trim($_POST['iva']));
		$iva = $iva - 3;
		$ivax = $_POST['iva'];
		$iva1 = substr($_POST['iva'],0,$iva);
		$iva2 = substr($_POST['iva'],-2,2);

		$defaults = array (	'iva1' => $iva1,	
							'iva2' => $iva2);
						}
	elseif(isset($_POST['oculto'])){
		$defaults = $_POST;
	} else { $defaults = array ( 'iva1' => $_POST['iva1'],	
								 'iva2' => $_POST['iva2']);
						}
								
////////////////////

	print("<table class='tableForm' >
				<tr>
					<th colspan=2 >BORRAR % IMPUESTO</th>
				</tr>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td>IMPUESTO % TIPO</td>
					<td>
					".$defaults['iva1']."
	<input style='text-align:right' type='hidden' name='iva1' size=4 maxlength=2 value='".$defaults['iva1']."' />,".$defaults['iva2']."<input  type='hidden' name='iva2' size=4 maxlength=2 value='".$defaults['iva2']."' />%
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align:right;' >
						".$DeleteWhite.$closeButton."
							<input type='hidden' name='oculto' value=1 />
			</form>	
						".$InicioBlack."
							<a href='Impuestos_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
					</td>
				</tr>
			</table>"); 
	
	} // FIN function show_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info_01(){

		global $db;			global $name;
		
		global $tiva;

		$ActionTime = date('H:i:s');

		global $dir;
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
					$dir = "../cb26_Docs/log";
					}
	
		global $text;
		$text = "\n- IMPUESTO BORRAR SELECCIONADO ".$ActionTime.".\n\t ID: ".$_POST['id'].".\n\t % TIPO IMPUESTO: ".$_POST['iva'].".\n\t NOMBRE: ".$_POST['name'].".";

		$logdocu = $_SESSION['ref'];
		$logdate = date('Y_m_d');
		$logtext = $text."\n";
		$filename = $dir."/".$logdate."_".$logdocu.".log";
		$log = fopen($filename, 'ab+');
		fwrite($log, $logtext);
		fclose($log);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info_02(){

		global $db;
		
		global $tiva; 		global $name;

		$ActionTime = date('H:i:s');

		global $dir;
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
					$dir = "../cb26_Docs/log";
					}
	
		global $text;
		$text = "\n- IMPUESTO BORRADO ".$ActionTime.".\n\t ID: ".$_SESSION['idx'].".\n\t % TIPO IMPUESTO: ".$tiva.".\n\t NOMBRE: ".$name.".";

		$logdocu = $_SESSION['ref'];
		$logdate = date('Y_m_d');
		$logtext = $text."\n";
		$filename = $dir."/".$logdate."_".$logdocu.".log";
		$log = fopen($filename, 'ab+');
		fwrite($log, $logtext);
		fclose($log);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaImpuestos;	$rutaImpuestos = "";
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