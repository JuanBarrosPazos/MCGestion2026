<?php
session_start();

	require '../Inclu/Admin_Inclu_popup.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='cliente')){
					
		if($_POST['oculto2']){	process_form();
								log_info();
		}else{ }
									
	}else{ require "../Inclu/AccesoDenegado.php";	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	global $Borrado;
	if(isset($_POST['profeedback'])){
		$SqlSelectDat =  "SELECT * FROM `$db_name`.$ProductosFeed WHERE `valor` = '$_POST[valor]' LIMIT 1 ";
		$Borrado = "<tr>
						<td style='color:#F1BD2D; text-align:right;' >DELETE DATE </td>
						<td>".$_POST['borrado']."</td>
					</tr>";
	}else{
		$SqlSelectDat =  "SELECT * FROM `$db_name`.$Productos WHERE `valor` = '$_POST[valor]' LIMIT 1 ";
		$Borrado = "";
	}
	$QrySelectDat = mysqli_query($db, $SqlSelectDat);
	$RowSelectDat= mysqli_fetch_assoc($QrySelectDat);

	print("<table align='center' style='font-size:1.1em !important;' >
				<tr>
					<th colspan=2  style='color:#F1BD2D; text-align:center;' >
				<div style='display:inline-block; margin: 0.4em 0.1em 0.1em 0.1em; text-align:center;'>
					SECCION ".strtoupper($RowSelectDat['vseccion'])."
				</div>
		<form name='closewindow' action='$_SERVER[PHP_SELF]' onsubmit=\"window.close()\" style='display:inline-block; float:right;' >
				<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelBlack'>
				</button>
						<input type='hidden' name='oculto2' value=1 />
			</form>
					</th>
				</tr>
				<tr>
					<td colspan=2 style='text-align:center;' >
		<img src='../imgpro/imgpro".$RowSelectDat['vseccion']."/".$RowSelectDat['myimg1']."' style='display:inline-block; width:3.2em; height: 3.6em; margin: 0.2em;' />					
		<img src='../imgpro/imgpro".$RowSelectDat['vseccion']."/".$RowSelectDat['myimg2']."' style='display:inline-block; width:3.2em; height: 3.6em; margin: 0.2em;' />					
		<img src='../imgpro/imgpro".$RowSelectDat['vseccion']."/".$RowSelectDat['myimg3']."' style='display:inline-block; width:3.2em; height: 3.6em; margin: 0.2em;' />					
		<img src='../imgpro/imgpro".$RowSelectDat['vseccion']."/".$RowSelectDat['myimg4']."' style='display:inline-block; width:3.2em; height: 3.6em; margin: 0.2em;' />					
					</td>
				</tr>
				".$Borrado."
				<tr>
					<td width=160px style='text-align:right;'>ID </td>
					<td >".$RowSelectDat['id']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>VALOR </td>
					<td>".$RowSelectDat['valor']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >NOMBRE </td>
					<td>".$RowSelectDat['nombre']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >REFERENCIA </td>
					<td>".$RowSelectDat['ref']."</td>
				</tr>
				<tr>
					<td style='text-align:right; color:#F1BD2D;' class='BorderSup' >UNID. STOCK</td>
					<td class='BorderSup'>".$RowSelectDat['stock']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >UNID. PERECEDEROS </td>
					<td>".$RowSelectDat['kgbad']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >UNID. TOTAL CASH </td>
					<td>".$RowSelectDat['kgcash']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >UNID. TOTAL IN </td>
					<td >".$RowSelectDat['kgin']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' class='BorderSup' >UNIDAD NETO</td>
					<td class='BorderSup' >".$RowSelectDat['psiva']." € </td>
				</tr>				
				<tr>
					<td style='text-align:right;' >IVA </td>
					<td>".$RowSelectDat['iva']." %</td>
				</tr>				
				<tr>
					<td style='text-align:right;' >UNIDAD IVA </td>
					<td>".$RowSelectDat['ivae']." €</td>
				</tr>				
				<tr>
					<td style='text-align:right; color:#F1BD2D;' >UNIDAD PVP</td>
					<td>".$RowSelectDat['pvp']." €</td>
				</tr>				
				<tr>
					<td style='text-align:right; color:#F1BD2D;' class='BorderSup' >PERECEDEROS DATE </td>
					<td class='BorderSup'>".$RowSelectDat['datekgbad']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >LAST DATE STOCK IN </td>
					<td>".$RowSelectDat['datekgin']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >LAST WEEK STOCK IN </td>
					<td>".$RowSelectDat['nsemana']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >LAST DATE CASH </td>
					<td>".$RowSelectDat['datecash']."</td>
				</tr>
				<tr>
					<td colspan=2 style='text-align:center; color:#F1BD2D;' class='BorderSup' >COMENTARIOS</td>
				</tr>
				<tr>
					<td colspan=2 style='text-align:left; width:300px;' >".$RowSelectDat['coment']."</td>
				</tr>
				<tr>
					<td colspan=2 align='right'>
			<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
				<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelBlack'>
				</button>
						<input type='hidden' name='oculto2' value=1 />
			</form>
					</td>
				</tr>
			</table>"); 
			
			require '../Inclu/AutoWindowClose.php';
			global $Redir;      print ($Redir);
		
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
