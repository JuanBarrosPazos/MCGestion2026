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
	
	global $InicioBlackTit;		$InicioBlackTit = "INICIO RETENCIONES";
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	global $db; 		global $db_name;	
	global $dyt1; 		global $dm1;
	
	$ret1 = $_POST['ret1'];
	$ret2 = $_POST['ret2'];
	global $tret; 		$tret = $ret1.".".$ret2; 		$tret = trim($tret);
	global $name; 		$name = $tret." %";

	global $vname; 		$vname = "`".$_SESSION['clave']."retencion`";

	$tabla = "<table class='tableForm' >
				<tr>
					<th colspan=4 >BORRADO EN ".strtoupper($vname)."</th>
				</tr>
				<tr>
					<td>RETENCION %</td><td>".$tret."</td>
					<td>NAME</td><td>".$name."</td>
				</tr>
				<tr>
					<td colspan=4 style='text-align:right;'>
						".$InicioBlack."
							<a href='retencion_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
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
						window.location.href='retencion_Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
			
	} // FIN function process_fomr()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	

	global $InicioBlackTit;		$InicioBlackTit = "INICIO RETENCIONES";
	global $DeleteWhiteTit;		$DeleteWhiteTit = "BORRAR";
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	global $db; 	global $db_name;
	
	if(isset($_POST['oculto2'])){
		$_SESSION['idx'] = $_POST['id'];
	
		$ret = strlen(trim($_POST['ret']));
		$ret = $ret - 3;
		$retx = $_POST['ret'];
		$ret1 = substr($_POST['ret'],0,$ret);
		$ret2 = substr($_POST['ret'],-2,2);

		$defaults = array (	'ret1' => $ret1,	
							'ret2' => $ret2);
						}
	elseif(isset($_POST['oculto'])){
		$defaults = $_POST;
	} else { $defaults = array ( 'ret1' => $_POST['ret1'],	
								 'ret2' => $_POST['ret2']);
						}
								
////////////////////

	print("<table class='tableForm' >
				<tr>
					<th colspan=2 >BORRAR % RETENCION</th>
				</tr>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td>RETENCION % TIPO</td>
					<td>
					".$defaults['ret1']."
	<input style='text-align:right' type='hidden' name='ret1' size=4 maxlength=2 value='".$defaults['ret1']."' />,".$defaults['ret2']."<input  type='hidden' name='ret2' size=4 maxlength=2 value='".$defaults['ret2']."' />%
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align:right;' >
						".$DeleteWhite.$closeButton."
							<input type='hidden' name='oculto' value=1 />
			</form>	
						".$InicioBlack."
							<a href='retencion_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
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
		
		global $tret;

		$ActionTime = date('H:i:s');

		global $dir;
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
					$dir = "../cb26_Docs/log";
					}
	
		global $text;
		$text = "\n- RETENCION BORRAR SELECCIONADO ".$ActionTime.".\n\t ID: ".$_POST['id'].".\n\t % TIPO RETENCION: ".$_POST['ret'].".\n\t NOMBRE: ".$_POST['name'].".";

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
		
		global $tret; 		global $name;

		$ActionTime = date('H:i:s');

		global $dir;
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
					$dir = "../cb26_Docs/log";
					}
	
		global $text;
		$text = "\n- RETENCION BORRADO ".$ActionTime.".\n\t ID: ".$_SESSION['idx'].".\n\t % TIPO RETENCION: ".$tret.".\n\t NOMBRE: ".$name.".";

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
		global $rutaRetencion;	$rutaRetencion = "";
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