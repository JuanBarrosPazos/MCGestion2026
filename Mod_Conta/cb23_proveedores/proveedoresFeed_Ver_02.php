<?php
session_start();

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../Inclu/Conta_Head.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 

	global $nombre;		$nombre = isset($_POST['Nombre']);
	global $apellido;	$apellido = isset($_POST['Apellidos']);
							
	if(isset($_POST['oculto2'])){	process_form();
									info();
										}
								
	} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;
	
	global $nombre;			$nombre = isset($_POST['Nombre']);
	global $apellido; 		$apellido = isset($_POST['Apellidos']);
	global $sesionref; 		$sesionref = $_SESSION['ref'];
	$sesionref = strtolower($sesionref);
	
	global $CancelBlackTit;		$CancelBlackTit = "CERRAR VENTANA";
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	print("<table class='tableForm' style='margin-top: 1.6em !important;' >
			<tr>
				<th colspan=3 >PAPELERA DATOS DEL PROVEEDOR</th>
			</tr>
			<tr>
				<td style='width:120px; text-align:right;' >ID</td>
				<td style='width:120px;' >".$_POST['id']."</td>
				<td rowspan='5' style='width:140px;' >
		<img src='../cb23_Docs/img_proveedores/".$_POST['myimg']."' height='120px' width='90px' />
				</td>
			</tr>
			<tr>
				<td style='text-align:right;' >REFERENCIA</td><td>".$_POST['ref']."</td>
			</tr>
			<tr>
				<td style='text-align:right;' >RAZON SOCIAL</td><td>".$_POST['rsocial']."</td>
			</tr>				
			<tr>
				<td style='text-align:right;' >Tipo Documento</td><td>".$_POST['doc']."</td>
			</tr>				
			<tr>
				<td style='text-align:right;' >N&uacute;mero</td><td>".$_POST['dni']." ".$_POST['ldni']."</td>
			</tr>				
			<tr>
				<td style='text-align:right;' >MAIL</td><td colspan='2'>".$_POST['Email']."</td>
			</tr>
			<tr>
				<td style='text-align:right;' >Direcci&oacute;n</td><td colspan='2'>".$_POST['Direccion']."</td>
			</tr>
			<tr>
				<td style='text-align:right;' >Tel&eacute;fono 1</td><td colspan='2'>".$_POST['Tlf1']."</td>
			</tr>
			<tr>
				<td style='text-align:right;' >Tel&eacute;fono 2</td><td colspan='2'>".$_POST['Tlf2']."</td>
			</tr>
			<tr>
				<td style='text-align:right;' >Fecha Borrado</td><td colspan='2'>".$_POST['borrado']."</td>
			</tr>
			<tr>
				<td colspan=3 style='text-align:right;' >
					<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
						<!--
						<input type='submit' value='CERRAR VENTANA' class='botonverde' />
						-->
						".$CancelBlack.$closeButton."
							<input type='hidden' name='oculto2' value=1 />
					</form>
				</td>
			</tr>
		</table>");

	} // FIN process_form()
			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $db;
		
	$ActionTime = date('H:i:s');
	
	global $dir;
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
				$dir = "../cb23_Docs/log";
				}
	
	global $text;
	$text = "\n- PROVEEDORES DETALLES ".$ActionTime.".\n\tID: ".$_POST['id'].".\n\tR. Social: ".$_POST['rsocial'].".\n\tDNI: ".$_POST['dni'].$_POST['ldni'].".\n\tReferencia: ".$_POST['ref'].".";

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

	require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>