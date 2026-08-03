<?php
session_start();

	require '../Inclu/Admin_Inclu_popup.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')){
					
		global $nombre;			$nombre = $_POST['Nombre'];
		global $apellido;		$apellido = $_POST['Apellidos'];
		
		if($_POST['oculto2']){	process_form();
								log_info();
									} 
									
	}else{ require "../Inclu/AccesoDenegado.php";	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $nombre;		$nombre = $_POST['Nombre'];
	global $apellido;	$apellido = $_POST['Apellidos'];
	global $Borrado;
	if(strlen(trim($_POST['borrado']))>0){
			$Borrado = "<tr>
							<td style='text-align:right;'>BORRADO </td>
							<td colspan='2'>".$_POST['borrado']."</td>
						</tr>";
	}else{ $Borrado = ""; }
	print("<table align='center' style='font-size:1.0em !important;'>
				<tr>
					<th colspan=3 style='color:#F1BD2D;'>
					<div style='display:inline-block; margin: 0.4em 0.1em 0.1em 0.1em;'>
						CLIENTE: ".strtoupper($_POST['Nombre'])." ".strtoupper($_POST['Apellidos'])."
					</div>
			<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\" style='display:inline-block; float:right;'>
				<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelWhite'>
				</button>
					<input type='hidden' name='oculto2' value=1 />
			</form>
					</th>
				</tr>
				<tr>
					<td style='width:100px; text-align:right;'>ID </td>
					<td style='width:100px;' >".$_POST['id']."</td>
					<td style='width:100px;' rowspan='8' align='center'>
						<img src='img_cliente/".$_POST['myimg']."' height='120px' width='90px' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NIVEL </td>
					<td>".$_POST['Nivel']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>REFERENCIA </td>
					<td>".$_POST['ref']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NOMBRE </td>
					<td>".$_POST['Nombre']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>APELLIDOS </td>
					<td>".$_POST['Apellidos']."</td>
				</tr>				
				<tr>
					<td style='text-align:right;'>DOCUMENTO </td>
					<td>".$_POST['doc']."</td>
				</tr>				
				<tr>
					<td style='text-align:right;'>NUMERO </td>
					<td>".$_POST['dni']."</td>
				</tr>				
				<tr>
					<td style='text-align:right;'>CONTROL</td>
					<td>".$_POST['ldni']."</td>
				</tr>				
				<tr>
					<td style='text-align:right;'>MAIL </td>
					<td colspan='2'>".$_POST['Email']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>USUARIO </td>
					<td colspan='2'>".$_POST['Usuario']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>PASSWORD </td>
					<td colspan='2'>".$_POST['Password']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>DIRECCION </td>
					<td colspan='2'>".$_POST['Direccion']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>TELEFONO 1 </td>
					<td colspan='2'>".$_POST['Tlf1']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>TELEFONO 2 </td>
					<td colspan='2'>".$_POST['Tlf2']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>LAST IN </td>
					<td colspan='2'>".$_POST['lastin']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>LAST OUT </td>
					<td colspan='2'>".$_POST['lastout']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>Nº VISITAS </td>
					<td colspan='2'>".$_POST['visitadmin']."</td>
				</tr>
				".$Borrado."
				<tr>
					<td colspan=3 style='text-align:right;' >
			<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
				<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelWhite'>
				</button>
					<input type='hidden' name='oculto2' value=1 />
			</form>
					</td>
				</tr>
			</table>"); 
			
			require '../Inclu/AutoWindowClose.php';
			global $Redir; 		print ($Redir);
	
	}
			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	global $nombre;		global $apellido;
	
	global $LogText;
	$LogText = "- ADMIN DETALLES . ".$nombre." ".$apellido;

	require '../logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Inclu_Footer.php';
		
?>
