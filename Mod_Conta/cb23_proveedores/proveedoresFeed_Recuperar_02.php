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

		//print("Hello ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].".");
		master_index();

		if (isset($_POST['oculto2'])){
				show_form();
				info_01();
		} elseif(isset($_POST['modifica'])){
						process_form();
						info_02();
		} else { show_form();
				 unset($_SESSION['dudas']);
				 unset($_SESSION['dniold']);
						}

	} else { require '../Inclu/table_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $PersonsBlackTit;		$PersonsBlackTit = "VER TODOS LOS PROVEEDORES";
	global $DeleteBlackTit;			$DeleteBlackTit = "INICIO PAPELERA PROVEEDORES";
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	global $db; 		global $db_name;	
	global $vname; 		$vname = "`".$_SESSION['clave']."proveedores`";
	
	$sql = "INSERT INTO `$db_name`.$vname (`ref`, `rsocial`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Direccion`, `Tlf1`, `Tlf2`) VALUES ('$_POST[ref]', '$_POST[rsocial]', '$_POST[myimg]', '$_POST[doc]', '$_POST[dni]', '$_POST[ldni]', '$_POST[Email]', '$_POST[Direccion]', '$_POST[Tlf1]', '$_POST[Tlf2]')";

	if(mysqli_query($db, $sql)){
		
		print("<table class='tableForm' >
				<tr>
					<th colspan=3 >HA RECUPERADO EL PROVEEDOR</th>
				</tr>
				<tr>
					<td style='width: 120px; text-align: right;' >RAZON SOCIAL</td>
					<td style='width: 120px;'>".$_POST['rsocial']."</td>
					<td rowspan='4' style='width: 120px; text-align: center;' >
			<img src='../cb23_Docs/img_proveedores/".$_POST['myimg']."' height='120px' width='90px' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>DOCUMENTO</td><td>".$_POST['doc']."</td>
				</tr>				
				<tr>
					<td style='text-align: right;'>NUMERO</td><td>".$_POST['dni']."</td>
				</tr>				
				<tr>
					<td style='text-align: right;'>CONTROL</td><td>".$_POST['ldni']."</td>
				</tr>				
				<tr>
					<td style='text-align: right;'>MAIL</td><td colspan='2'>".$_POST['Email']."</td>
				</tr>
				<tr>
					<td style='text-align: right;'>REFERENCIA</td><td colspan='2'>".$_POST['ref']."</td>
				</tr>
				<tr>
					<td style='text-align: right;'>PAIS</td><td colspan='2'>".$_POST['Direccion']."</td>
				</tr>
				<tr>
					<td style='text-align: right;'>TELEFONO 1</td><td colspan='2'>".$_POST['Tlf1']."</td>
				</tr>
				<tr>
					<td style='text-align: right;'>TELEFONO 2</td><td colspan='2'>".$_POST['Tlf2']."</td>
				</tr>
				<tr>
					<td style='text-align: right;'>BORRADO</td><td colspan='2'>".$_POST['borrado']."</td>
				</tr>
				<tr>
					<td colspan='3' align='right' >
						".$PersonsBlack."
							<a href='proveedores_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton.$DeleteBlack."
							<a href='proveedoresFeed_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
					</td>
				</tr>
			</table>");


			global $vnamed; 		$vnamed = "`".$_SESSION['clave']."proveedores`";
			$sqld = "DELETE FROM `$db_name`.$vnamed WHERE `id` = '$_POST[id]' AND `del`='true' LIMIT 1 ";
			if(mysqli_query($db, $sqld)){
				// NADA
			}else{
				print("</br><font color='#FF0000'>
						* MODIFIQUE LA ENTRADA 106: </font></br> ".mysqli_error($db))."</br>";
				show_form();
				global $texerror; 		$texerror = "\n\t ".mysqli_error($db);
			}
			/*	*/
		} else { 
			print("</br><font color='#FF0000'>* ERROR L.59: </font></br> ".mysqli_error($db))."</br>";
					show_form ();
					//global $texerror;
					//$texerror = $texerror1.$texerror2.$texerror3.$texerror4."\n";
				}

		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='proveedoresFeed_Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
		
	} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
	
	if(isset($_POST['oculto2'])){
		
	$defaults = array ( 'id' => $_POST['id'],
						'rsocial' => $_POST['rsocial'],
						'myimg' => $_POST['myimg'],	
						'ref' => $_POST['ref'],
						'doc' => $_POST['doc'],
						'dni' => $_POST['dni'],
						'ldni' => $_POST['ldni'],
						'Email' => $_POST['Email'],
						'Direccion' => $_POST['Direccion'],
						'Tlf1' => $_POST['Tlf1'],
						'Tlf2' => $_POST['Tlf2'],
						'borrado' => $_POST['borrado']);

	} elseif(isset($_POST['modifica'])){

		$defaults = array ( 'id' => $_POST['id'],
							'rsocial' => $_POST['rsocial'],
							'myimg' => $_POST['myimg'],	
							'ref' => @$_POST['ref'],
							'doc' => $_POST['doc'],
							'dni' => $_POST['dni'],
							'ldni' => $_POST['ldni'],
							'Email' => $_POST['Email'],
							'Direccion' => $_POST['Direccion'],
							'Tlf1' => $_POST['Tlf1'],
							'borrado' => $_POST['borrado']);

	} else { $defaults = $_POST; }
	
		global $RestoreBlackTit;	$RestoreBlackTit = "RECUPERAR DATOS PROVEEDOR";
		global $PersonsBlackTit;	$PersonsBlackTit = "VER TODOS LOS PROVEEDORES";
		global $DeleteBlackTit;		$DeleteBlackTit = "INICIO PAPELERA PROVEEDORES";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

	print("<table class='tableForm' >
				<tr>
					<th colspan=2 >RECUPERAR DATOS DEL PROVEEDOR</th>
				</tr>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
		<input type='hidden' name='id' value='".$defaults['id']."' />
		<input type='hidden' name='myimg' value='".$defaults['myimg']."' />
				<tr>
					<td style='width: 120px; text-align: right;'>REFERENCIA</td>
					<td style='width: 160px;'>
		<input type='hidden' name='ref' value='".$defaults['ref']."' />".$defaults['ref']."</td>
				</tr>
				<tr>
					<td style='text-align: right;'>RAZON SOCIAL</td>
					<td>
		<input type='hidden' name='rsocial' value='".$defaults['rsocial']."' />".$defaults['rsocial']."
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>DOCUMENTO</td>
					<td>
		<input type='hidden' name='doc' value='".$defaults['doc']."' />".$defaults['doc']."
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>NÚMERO</td>
					<td>
		<input type='hidden' name='dni' value='".$defaults['dni']."' />".$defaults['dni']."
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>CONTROL</td>
					<td>
		<input type='hidden' name='ldni' value='".$defaults['ldni']."' />".$defaults['ldni']."
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>MAIL</td>
					<td>
		<input type='hidden' name='Email' value='".$defaults['Email']."' />".$defaults['Email']."
					</td>
				</tr>	
				<tr>
					<td style='text-align: right;'>DIRECCIÓN</td>
					<td>
		<input type='hidden' name='Direccion' value='".$defaults['Direccion']."' />".$defaults['Direccion']."
					</td>
				</tr>
				<tr>
				<tr>
					<td style='text-align: right;'>TELÉFONO 1</td>
					<td>
		<input type='hidden' name='Tlf1' value='".$defaults['Tlf1']."' />".$defaults['Tlf1']."
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>TELÉFONO 2</td>
					<td>
		<input type='hidden' name='Tlf2' value='".$defaults['Tlf2']."' />".$defaults['Tlf2']."
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>BORRADO</td>
					<td>
		<input type='hidden' name='borrado' value='".$defaults['borrado']."' />".$defaults['borrado']."
					</td>
				</tr>
				<tr>
					<td colspan='2'  align='right' valign='middle'>
				<!--
				<input type='submit' value='RECUPERAR DATOS' class='botonazul' />
				-->
				".$RestoreBlack.$closeButton."
						<input type='hidden' name='modifica' value=1 />
		</form>
						".$PersonsBlack."
							<a href='proveedores_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton.$DeleteBlack."
							<a href='proveedoresFeed_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
					</td>
				</tr>
			</table>"); /* Fin del print */

	}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaProveedores;	$rutaProveedores = "";
		require '../Inclu_MInd/MasterIndex.php'; 
				} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info_01(){

	global $db; 	global $orden;
	
	$orden = @$_POST['Orden'];
		
	$_SESSION['xid'] = $_POST['id'];
	if (isset($_POST['todo'])){$TitBut = "\n\tFiltro => TODOS LOS PROVEEDORES ".$orden;}
	else{$TitBut = "\n\tID: ".$_SESSION['xid'].".\n\tR. Social: ".$_POST['rsocial'].".\n\tDNI: ".$_POST['dni'].$_POST['ldni'].".\n\tReferencia: ".$_POST['ref'].".\n\tEmail: ".$_POST['Email'].".\n\tDireccion: ".$_POST['Direccion'].".\n\tTlf 1: ".$_POST['Tlf1'].".\n\tTlf 2: ".$_POST['Tlf2'].".";}

	$ActionTime = date('H:i:s');

	global $dir;
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
				$dir = "../cb23_Docs/log";
				}
	
	global $text;
	$text = "\n- PROVEEDORES MODIFICAR SELECCIONADO ".$ActionTime.$TitBut;

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

	global $db; 	global $rf;

	$ActionTime = date('H:i:s');
	
	global $dir;
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
				$dir = "../cb23_Docs/log";
				}

	global $texerror;
	global $text;
	$text = "\n- PROVEEDORES GASTO MODIFICADO ".$ActionTime.".\n\tID: ".$_SESSION['xid'].".\n\tR. Social: ".$_POST['rsocial'].".\n\tDNI: ".$_POST['dni'].$_POST['ldni'].".\n\tReferencia: ".$rf.".\n\tEmail: ".$_POST['Email'].".\n\tDireccion: ".$_POST['Direccion'].".\n\tTlf 1: ".$_POST['Tlf1'].".\n\tTlf 2: ".$_POST['Tlf2'].".";			

	$logdocu = $_SESSION['ref'];
	$logdate = date('Y_m_d');
	$logtext = $text.$texerror."\n";
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>