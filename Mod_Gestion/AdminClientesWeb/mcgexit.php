<?php
session_start();
 

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	global $userid;
	$userid = $_SESSION['id'];
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin') || ($_SESSION['Nivel']=='plus') || ($_SESSION['Nivel']=='user') || ($_SESSION['Nivel']=='caja')){

	master_index();
					
		if ($_POST['cerrar']){	admin_salida();
								desconex();
												}	
					} else { 
					
						require "../Inclu/AccesoDenegado.php";			
								
							}
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
///

function admin_salida(){

	global $userid;
	global $dir;
	
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin') || ($_SESSION['Nivel']=='plus')){ 
		$dir = 'Admin';
	}elseif ($_SESSION['Nivel']=='cliente'){ $dir = 'ClientesWeb';
	}elseif (($_SESSION['Nivel']=='user') || ($_SESSION['Nivel']=='caja')){ $dir = 'User';}

	$dateadout = date('Y-m-d/H:i:s');

	require "../config/TablesNames.php";

	$sqladout = "UPDATE `$db_name`.$ClientesWeb SET `lastout` = '$dateadout' WHERE $ClientesWeb.`id` = '$userid' LIMIT 1 ";
		
	if(mysqli_query($db, $sqladout)){
				} else {
				print("</br>
				<font color='#F1BD2D'>
		* FATAL ERROR funcion admin_entrada(): </font></br> ".mysqli_error($db))."
				</br>";
					}
					
	$LogText = "** FIN SESION ".$_SESSION['Nombre']." ".$_SESSION['Apellidos']." => ".$dateadout;
	$logname = $_SESSION['Nombre'];	
	$logape = $_SESSION['Apellidos'];	
	$logname = trim($logname);	
	$logape = trim($logape);	
	$logdocu = $logname."_".$logape;
	$logdate = date('Y_m_d');
	$LogText = "\n".$LogText."\n \n";
	$filename = "../logs/".$dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $LogText);
	fclose($log);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){

		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $AdminClientesWeb;        $AdminClientesWeb = '';
	
		require '../Inclu_Menu/Master_Index.php';

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function desconex(){

			print("<table align='center' style='margin-top:80px; margin-bottom:80px; border:none !important;'>
						<form name='salir' action='../Admin_index.php' method='post'>
							<tr>
								<td valign='bottom' align='center'>
									<input type='submit' value='CONFIRME CERRAR SESIÓN' />
								</td>
							</tr>								
									<input type='hidden' name='salir' value=1 />
						</form>	
					</table>
							");
	
			} 
			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Inclu_Footer.php';

?>