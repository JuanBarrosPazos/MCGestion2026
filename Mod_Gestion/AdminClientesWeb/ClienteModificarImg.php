<?php
session_start();

	require '../Inclu/Admin_Inclu_popup.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')){
 	
	if (isset($_POST['oculto2'])){ show_form();}
			elseif(isset($_POST['imagenmodif'])){
						if($form_errors = validate_form()){
								show_form($form_errors);
						}else{ 	process_form();
								log_info();
									}
				}else{ show_form(); }

}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
		require 'validate_cliente.php';	
		
		return $errors;

} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
		global $imgOld; 		$imgOld = $_POST['imgOld'];

		global $safe_filename;
		$safe_filename = trim(str_replace('/', '', $_FILES['myimg']['name']));
		$safe_filename = trim(str_replace('..', '', $safe_filename));

	//$imgNombre = $_FILES['myimg']['name'];
	//$imgNombre_tmp = $_FILES['myimg']['tmp_name'];
	//$imgTipo = $_FILES['myimg']['type'];
	//$imgTamano = $_FILES['myimg']['size'];
		  
		global $destination_file; 		$destination_file = 'img_cliente/'.$safe_filename;

	// RENOMBRA LA IMAGEN
	// EXTRAIGO LA EXTENSION
		global $extension; 				$extension = substr($_FILES['myimg']['name'],-3);
		if(($extension == "peg")||($extension == "PEG")){
				$extension = substr($_FILES['myimg']['name'],-4);
		}else{ }

	// print($extension);
	// [DEPECRATED] => $extension = end(explode('.', $_FILES['myimg']['name']) );
		//date('H:i:s');
		//date('Y_m_d');
		global $dt; 				$dt = date('is');
		global $rf; 				$rf = $_POST['ref'];
		global $imgNewName; 		$imgNewName = $rf."_".$dt.".".$extension;

		global $rename_filename; 	$rename_filename = "img_cliente/".$imgNewName;	
		//rename($destination_file, $rename_filename);

	/////////////////////////////

		global $Titulo; 			$Titulo = "SE HA MODIFICADO LA IMAGEN";
		global $rutImg; 			$rutImg = "img_cliente/";

		global $KeyModifImg; 		$KeyModifImg = 1;

	/* if( file_exists( 'img_cliente/'.$nombre) ){
							print("El archivo ".$nombre." ya existe, seleccione otra imagen."
							);
							show_form();
		}elseif (move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file)){ LO QUE SEA... }
	*/

	require "../config/TablesNames.php";

	$sqlc = "UPDATE `$db_name`.$ClientesWeb SET `myimg` = '$imgNewName' WHERE $ClientesWeb.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $sqlc)){

		global $destination_file;
		move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file);
		global $KeyModifImg;
		global $tabla;
		require "UserTablaCrea.php";
		print($tabla);
		if(file_exists($rutImg.$imgOld)){
			// BORRA LA IMAGEN ORIGINAL SI EXISTE ['img_cliente/'.$safe_filename;]
			unlink($rutImg.$imgOld);

		}else{ }
	
		global $rename_filename;
		rename($destination_file, $rename_filename);

		if(!file_exists($rename_filename)){ print("NO SE HA PODIDO GUARDAR EN ".$rename_filename);
		}else{ /*print ("LA IMAGEN SE HA GUARDADO OK...");*/ 
			$_SESSION['myimg'] = $imgNewName;
		}

		require '../Inclu/AutoWindowClose.php';
		global $Redir; 		print ($Redir);

	}else{ print("* ERROR SQL L.94 ".mysqli_error($db))."</br>";
					show_form ();
	}

	} // FIN FUNCTION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	global $rf; 		$rf = $_POST['ref'];
	global $img2;
	if(isset($_POST['oculto2'])){
		$defaults = array ( 'id' => $_POST['id'],
							'Nombre' => $_POST['Nombre'],'Apellidos' => $_POST['Apellidos'],
							'myimg' => $_POST['myimg'],'imgOld' => $_POST['myimg'],
							'ref' => $_POST['ref'],'Nivel' => $_POST['Nivel'],									
							'doc' => $_POST['doc'],'dni' => $_POST['dni'],'ldni' => $_POST['ldni'],
							'Email' => $_POST['Email'],
							'Usuario' => $_POST['Usuario'],'Usuario2' => $_POST['Usuario'],
							'Password' => $_POST['Password'],'Password2' => $_POST['Password'],
							'Direccion' => $_POST['Direccion'],
							'Tlf1' => $_POST['Tlf1'],'Tlf2' => $_POST['Tlf2'], );
	}elseif(isset($_POST['imagenmodif'])){
		$img2 = $_POST['imgOld'];
		$defaults = array ( 'id' => $_POST['id'],
							'Nombre' => $_POST['Nombre'],'Apellidos' => $_POST['Apellidos'],
							'myimg' => $img2,'imgOld' => $_POST['imgOld'],
							'Nivel' => $_POST['Nivel'],'ref' => $_POST['ref'],
							'doc' => $_POST['doc'],'dni' => $_POST['dni'],'ldni' => $_POST['ldni'],
							'Email' => $_POST['Email'],
							'Usuario' => $_POST['Usuario'],'Usuario2' => $_POST['Usuario'],
							'Password' => $_POST['Password'],'Password2' => $_POST['Password'],
							'Direccion' => $_POST['Direccion'],
							'Tlf1' => $_POST['Tlf1'],'Tlf2' => $_POST['Tlf2'],);
	}else{ }
	
	require 'TableValidateErrors.php';
	
	print("<table align='center' style='margin-top:1.2em; font-size:1.1em !important;'>
				<tr>
					<th colspan=2 style='color:#F1BD2D;'>
						<div style='display:inline-block; margin: 0.4em 0.1em 0.1em 0.1em;'>
							SELECCIONE UNA NUEVA IMAGEN
						</div>
			<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\" style='display:inline-block; float:right;'>
				<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelWhite'>
				</button>
					<input type='hidden' name='oculto2' value=1 />
			</form>
					</th>
				</tr>
				<tr>
					<th class='BorderInf'>
				LA IMAGEN ACTUAL DE</br>".$defaults['Nombre']." ".$defaults['Apellidos'].". **".$rf."
					</th>
					<th class='BorderInf'>
						<img src='img_cliente/".$defaults['myimg']."' height='120px' width='90px' />
					</th>
				</tr>
				<tr>
					<td colspan=2 style='color:#F1BD2D;'>SELECCIONE UNA FOTOGRAFIA</td>
				</tr>
					</td>
				</tr>
				<tr>
					<td colspan=2 style='text-align:right;'>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data' >
			<button type='submit' title='MODIFICAR LA IMAGEN' class='botonverde imgButIco SaveBlack' style='display:inline-block; float:right; margin-left: 0.4em;' >
			</button>
					<input type='hidden' name='id' value='".$defaults['id']."' />					
					<input type='file' name='myimg' value='".$defaults['myimg']."' />						
					<input type='hidden' name='imgOld' value='".$defaults['imgOld']."' />
					<input type='hidden' name='Nombre' value='".$defaults['Nombre']."' />
					<input type='hidden' name='Apellidos' value='".$defaults['Apellidos']."' />
					<input type='hidden' name='doc' value='".$defaults['doc']."' />
					<input type='hidden' name='dni' value='".$defaults['dni']."' />
					<input type='hidden' name='ldni' value='".$defaults['ldni']."' />
					<input type='hidden' name='Email' value='".$defaults['Email']."' />
					<input type='hidden' name='Nivel' value='".$defaults['Nivel']."' />
					<input type='hidden' name='ref' value='".$defaults['ref']."' />
					<input type='hidden' name='Usuario' value='".$defaults['Usuario']."' />
					<input type='hidden' name='Usuario2' value='".$defaults['Usuario2']."' />
					<input type='hidden' name='Password' value='".$defaults['Password']."' />
					<input type='hidden' name='Password2' value='".$defaults['Password2']."' />
					<input type='hidden' name='Direccion' value='".$defaults['Direccion']."' />
					<input type='hidden' name='Tlf1' value='".$defaults['Tlf1']."' />
					<input type='hidden' name='Tlf2' value='".$defaults['Tlf2']."' />
						<input type='hidden' name='imagenmodif' value=1 />
		</form>														
					</td>
				</tr>
				<tr>
					<td colspan=2 style='text-align:right;'>
			<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\" style='display:inline-block; float:right; margin-right:2.6em;'>
				<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelWhite'>
				</button>
					<input type='hidden' name='oculto2' value=1 />
			</form>
					</td>
				</tr>
			</table>");

			require '../Inclu/AutoWindowClose.php';
			global $Redir; 		print ($Redir);

	} // FIN show_form()

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

function log_info(){

	global $destination_file;	

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- ADMIN MODIFICAR IMG ".$ActionTime.". ID:".$_POST['id'].". ".$_POST['Nombre']." ".$_POST['Apellidos']." / ".$destination_file;

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