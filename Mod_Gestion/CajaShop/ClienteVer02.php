<?php
session_start();

	require '../Inclu/Admin_Inclu_popup.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')||($_SESSION['Nivel']=='user')||($_SESSION['Nivel']=='caja')||($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')){
		if($_POST['data_client']){ process_form(); } 
		}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $nombre;		$nombre = $_POST['Nombre'];
	global $apellido;	$apellido = $_POST['Apellidos'];
	
	if(($_POST['Nivel']=='admin')||($_POST['Nivel']=='plus')||($_POST['Nivel']=='user')||($_POST['Nivel']=='caja')){ $ruta = "../../Mod_Admin_Plus/Users/".$_POST['ref']."/img_admin/";
	}elseif($_POST['Nivel']=='cliente'){ $ruta = "../AdminClientesWeb/img_cliente/"; }
	$_SESSION['nclient'] = $_POST['Nivel'];

	if((($_SESSION['Nivel'] == 'wmaster')||($_SESSION['nclient']=='cliente')||($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin'))&&($_POST['doc']!='local')){ 
				$h = "height='120'px";
				$w = "width='90'px";
	}elseif($_POST['doc']=='local'){ $h1 = 120-((120*50)/100);
									 $h = "height='".$h1."'px";
									 $w1 = 90-((90*50)/100);
									 $w = "width='".$w1."'px";
	}else { $h1 = 120-((120*20)/100);
			$h = "height='".$h1."'px";
			$w1 = 90-((90*20)/100);
			$w = "width='".$w1."'px";
		}
							
	global $ruta;
	print("<table align='center' style='font-size:1.1em !important;' >
				<tr>
					<th colspan=2 style='color:#F1BD2D'>DATOS DEL CLIENTE</th>
				</tr>
				<tr>
					<td colspan=2 align='center'>
						<img src='".$ruta."".$_POST['myimg']."' ".$h." ".$w." />
					</td>
				</tr>
				<tr>
					<td width=120px style='text-align:right;'>ID </td>
					<td width='120px'>".$_POST['id']."</td>
				</tr>");
				
	if((($_SESSION['nclient']=='cliente')||($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus'))&&($_POST['doc']!='local')){
		print("<tr>
				<td style='text-align:right;'>NIVEL </td>
				<td>".$_POST['Nivel']."</td>
			</tr>");
	}else{ }
		
	print("<tr>
			<td style='text-align:right;''>REFERENCIA </td>
			<td>".$_POST['ref']."</td>
		</tr>
		<tr>
			<td colspan=2 style='text-align:center;'>".ucfirst($_POST['Nombre'])." ".ucfirst($_POST['Apellidos'])."</td>
		</tr>");
				
	if((($_SESSION['nclient']=='cliente')||($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus'))&&($_POST['doc']!='local')){
		print("<tr>
				<td style='text-align:right;'>MAIL </td>
				<td>".$_POST['Email']."</td>
			</tr>
			<tr>
				<td style='text-align:right;'>USUARIO </td>
				<td>".$_POST['Usuario']."</td>
			</tr>
			<tr>
				<td style='text-align:right;'>PASSWORD </td>
				<td>".$_POST['Password']."</td>
			</tr>
			<tr>
				<td style='text-align:right;'>DIRECCION </td>
				<td>".$_POST['Direccion']."</td>
			</tr>
			<tr>
				<td style='text-align:right;'>TELEFONO 1 </td>
				<td>".$_POST['Tlf1']."</td>
			</tr>
			<tr>
				<td style='text-align:right;'>TELEFONO 2 </td>
				<td>".$_POST['Tlf2']."</td>
			</tr>");
	}else{ }

	print("<tr>
			<td colspan=2 align='right' >
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

	global $nombre;		global $apellido;	

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- CLIENTE DETALLES ".$ActionTime.". ".$nombre." ".$apellido;

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