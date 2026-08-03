<?php
session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require "../config/TablesNames.php";

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){

		master_index();
		if(isset($_POST['oculto2'])){	show_form();
										log_info();
		}elseif($_POST['modifica']){
			if($form_errors = validate_form()){ 
					show_form($form_errors);
					log_info();
			}else{ 	process_form();
					log_info();
					}
		}else{ 	show_form(); 
				log_info();
		}

	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
		
		require "../config/TablesNames.php";
		$SqlSelectSecciones =  "SELECT * FROM $Secciones WHERE (`valor` <> '' AND `id` <> '$_POST[id]') AND (`valor` = '$_POST[valor2]' OR `nombre` = '$_POST[nombre]') ";
		global $QrySelectSecciones;		$QrySelectSecciones = mysqli_query($db, $SqlSelectSecciones);

		$SqlSelectSecciones2 =  "SELECT * FROM $Secciones WHERE `id` = '$_POST[id]' AND `valor` = '$_POST[valor2]' AND `nombre` = '$_POST[nombre]' ";
		global $QrySelectSecciones2;		$QrySelectSecciones2 = mysqli_query($db, $SqlSelectSecciones2);

		require 'SeccionesValidate.php';

		return $errors;

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $LogText;
	require 'SeccionesModificarSql.php';

	// DATOS LOG...
	$LogText = "* SECCION MODIFICADA\n\tID: ".$_POST['id']."\n\tNOMBRE: ".$_POST['nombre']."\n\tVALOR: ".$_POST['valor1']." => ".$_POST['valor2']."\n\t".$LogText;

} // FIN function process_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){

	global $LogText;
	require 'SeccionesArrayTotalVar.php';
	global $ArraySeccionModificar;			$ArraySeccionModificar = 1;
	require 'SeccionesArrayTotal.php';
	
	require 'TableValidateErrors.php';
		
	print("<table align='center' style=\"margin-top:10px\">
				<tr>
					<td style='color:#F1BD2D' align='center'>
						<b>EL CAMPO VALOR</b> DA EL VALOR A LAS VARIABLES<br>
							Y NOMBRES DE TABLAS QUE SE HAN CREADO AUTOMÁTICAMENTE.<br>
						<b>SI SE MODIFICA</b> SE MODIFICARÁ EL NOMBRE<br>
							DE TODAS LAS TABLAS DEPENDIENTES AUTOMÁTICAMENTE
					</td>
				</tr>
			</table>
			<table align='center' border=0>
				<tr>
					<th colspan=2 >
						<div style='display:inline-block; margin: 0.4em 0.1em 0.1em 0.1em; color:#F1BD2D;'>
							MODIFICAR SECCION
						</div>
		<form name='crear' action='SeccionesVer.php' method='POST' style='display:inline-block; float:right;'>
				<button type='submit' title='CANCELAR Y VOLVER' class='botonrojo imgButIco CancelBlack'>
				</button>
						<input type='hidden' name='oculto2' value=1 />
			</form>
					</th>
				</tr>
				<tr>
					<td width=130px style='text-align:right;'>Id</td>
					<td>".$defaults['id']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>VALOR ACTUAL <font color='#F1BD2D'>*</font></td>
					<td>".$defaults['valor1']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NUEVO VALOR <font color='#F1BD2D'>*</font></td>
					<td>
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
				<input type='hidden' name='id' value='".$defaults['id']."' />
				<input type='hidden' name='valor1' value='".$defaults['valor1']."' />
			<input type='text' name='valor2' size=23 maxlength=22 value='".$defaults['valor2']."' pattern='[a-z]{3,22}' placeholder='MINUSCULAS MIN.3' required />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NOMBRE <font color='#F1BD2D'>*</font></td>
					<td>
			<input type='text' name='nombre' size=23 maxlength=22 value='".$defaults['nombre']."' pattern='[A-Z\s]{4,22}' placeholder='MAYUSCULAS MIN.4' required />
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align:center;'>
				<button type='submit' title='MODIFICAR SECCION' class='botonverde imgButIco SaveBlack'></button>
						<input type='hidden' name='modifica' value=1 />
					</td>
				</tr>
		</form>														
			</table>");	
			
		//DAOTS LOG...
		$LogText = $LogText."* VISTA SECCIONES MODIFICAR \n\tID: ".$_POST['id']."\n\tNOMBRE: ".$defaults['nombre']."\n\tVALOR: ".$defaults['valor1']."\n\t";
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $Secciones;        $Secciones = '';
		
		require '../Inclu_Menu/Master_Index.php';
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function log_info(){

		require '../logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	require '../Inclu/Inclu_Footer.php';
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>