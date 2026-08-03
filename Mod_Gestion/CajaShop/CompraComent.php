<?php
session_start();

	require '../Inclu/Admin_Inclu_popup.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')||($_SESSION['Nivel']=='user')||($_SESSION['Nivel']=='caja')||($_SESSION['Nivel']=='cliente')){
		if($_POST['coment_client']){ process_form(); } 
}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;			global $db_name;
	
	require '../config/TablesNames.php';
	$sql = "SELECT * FROM $CajaShop WHERE `oper` = '$_POST[oper]' LIMIT 1 ";
	$qr = mysqli_query($db, $sql);
	$row = mysqli_fetch_assoc($qr);
	global $Coment;
	if($row['coment']==""){ $Coment = "NO HAY COMENTARIOS..."; }else{ $Coment = $row['coment']; }
	print("<table align='center'>
				<tr>
					<th colspan=2>COMENTARIOS</th>
				</tr>
				<tr>
					<td style='text-align:right;'>OPERACION NUMERO </td>
					<td>".$row['oper']."</td>
				</tr>				
				<tr>
					<td width=220px style='text-align:right;'>NOMBRE CAJERO </td>
					<td width=220px>".$row['cname']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>REFERENCIA CAJERO </td>
					<td>".$row['refcaja']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NOMBRE CLIENTE </td>
					<td>".$row['clname']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>REFERENCIA CLIENTE </td>
					<td>".$row['refclient']."</td>
				</tr>
				<tr>
					<td colspan=2 style='text-align:center;'>COMENTARIOS</td>
				</tr>
				<tr>
					<td colspan=2>".$Coment."</td>
				</tr>				
				<tr>
					<td colspan=2 style='text-align:right;'>
						<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
					<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelBlack' style='vertical-align:top;' ></button>
							<input type='hidden' name='oculto2' value=1 />
						</form>
					</td>
				</tr>
			</table>");	
	}
			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	global $nombre;
	global $apellido;	

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- COMENTARIOS ".$ActionTime.". ".$nombre." ".$apellido;

	require 'logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Inclu_Footer.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
		
?>