<?php
//session_start();

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	//require '../Inclu/Conta_Head.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require '../Inclu/sqld_query_fetch_assoc.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/*
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 

		//print("Hello ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].".</br>");
					
		if (isset($_POST['oculto2'])){
						show_form_img();
		} elseif (isset($_POST['imagenmodif'])){
									
			if($form_errors = validate_form_img()){
				show_form_img($form_errors);
					} else {
						process_form_img();
						info_img();
						}
									
		} else { show_form_img(); }

	} else { require '../Inclu/table_permisos.php'; }

	*/
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form_img(){
	
		global $sqld, $qd;
		
		$limite = 500 * 1024;
		
		$ext_permitidas = array('jpg','gif','png','bmp');
		//$extension = substr($_FILES['myimg']['name'],-3);
		$extension = pathinfo($_FILES['myimg']['name'], PATHINFO_EXTENSION);
		$extension = strtolower($extension);
		// print($extension);
		// $extension = end(explode('.', $_FILES['myimg']['name']) );
		$ext_correcta = in_array($extension, $ext_permitidas);

		$ext_nopermitidas = array('txt','psd','pdf','mp4','mp3');
		$ext_nocorrecta = in_array($extension, $ext_nopermitidas);

		// $tipo_correcto = preg_match('/^image\/(gif|png|jpg|bmp)$/', $_FILES['myimg']['type']);

		$errors = array();

		if($_FILES['myimg']['size'] == 0){
				$errors [] = "Ha de seleccionar una fotograf&iacute;a.";
		}elseif($ext_nocorrecta) {
				$errors [] = "Extension no permitida: ".$_FILES['myimg']['name'];
		}elseif(!$ext_correcta) {
				$errors [] = "Extension no admitida: ".$_FILES['myimg']['name'];
		}
		/*
			elseif(!$tipo_correcto){
				$errors [] = "Este tipo de archivo no esta admitido: ".$_FILES['myimg']['name'];
				}
		*/
		elseif ($_FILES['myimg']['size'] > $limite){
			$tamanho = $_FILES['myimg']['size'] / 1024;
			$errors [] = "El archivo".$_FILES['myimg']['name']." es mayor de 500 KBytes. ".$tamanho." KB";
		} elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_PARTIAL){
			$errors [] = "La carga del archivo se ha interrumpido.";
		} elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_NO_FILE){
			$errors [] = "Es archivo no se ha cargado.";
		}
						
		return $errors;

	} // FIN function validate_form_img()
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form_img(){
	
	global $PersonsBlackTit;		$PersonsBlackTit = "VER TODOS LOS proveedores";
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	global $db;

	global $vname;			$vname = "`".$_SESSION['clave']."proveedores`";
	
	global $safe_filename;
		$safe_filename = trim(str_replace('/', '', $_FILES['myimg']['name']));
		$safe_filename = trim(str_replace('..', '', $safe_filename));

		$nombre = $_FILES['myimg']['name'];
		$nombre_tmp = $_FILES['myimg']['tmp_name'];
		$tipo = $_FILES['myimg']['type'];
		$tamano = $_FILES['myimg']['size'];

	global $destination_file;
		$destination_file = "../cb26_Docs/img_proveedores/".$safe_filename;
		
	    if( file_exists("../cb26_Docs/img_proveedores/".$nombre) ){
			unlink("../cb26_Docs/img_proveedores/".$nombre);
		}elseif(move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file)){

			if(file_exists("../cb26_Docs/img_proveedores/".$_SESSION['myimgx'])){
				unlink("../cb26_Docs/img_proveedores/".$_SESSION['myimgx']);
			}else{ }
											
			// Renombrar el archivo:
			$extension = substr($_FILES['myimg']['name'],-3);
			// print($extension);
			// $extension = end(explode('.', $_FILES['myimg']['name']) );
			//date('H:i:s');
			//date('Y-m-d');
			$dt = date('is');
			global $new_name;
			$nn = $_SESSION['refx'];
			$new_name = $nn."_".$dt.".".$extension;
			global $rename_filename;
			$rename_filename = "../cb26_Docs/img_proveedores/".$new_name;	
			rename($destination_file, $rename_filename);
				
			global $db; 		global $db_name;

			$id = $_SESSION['idx'];
				
			global $dniold; 	$dinold = $_SESSION['dniold']; 		$dinold = trim($dinold);
				
			$sqla = "UPDATE `$db_name`.$vname SET `myimg` = '$new_name'  WHERE $vname.`dni` = '$dinold' LIMIT 1 ";
				
			if(mysqli_query($db, $sqla)){print("");
			}else { print("</br><font color='#F1BD2D'>* ERROR </font>".mysqli_error($db)); }

			if(mysqli_query($db, $sqla)){
					
				print("<table class='tableForm' >
						<tr>
							<th colspan=3 >NUEVOS DATOS</th>
						</tr>
						<tr>
							<td style='width: 120px; text-align: right;'>RAZON SOCIAL</td>
							<td style='width: 120px;'>".$_POST['rsocial']."</td>
							<td rowspan='4' align='center' width='100px'>
				<img src='../cb26_Docs/img_proveedores/".$new_name."' height='120px' width='90px' />
							</td>
						</tr>
						<tr>
							<td style='text-align: right;'>REFERENCIA</td><td>".$_POST['ref']."</td>
						</tr>				
						<tr>
							<td style='text-align: right;'>DOCUMENTO</td><td>".$_POST['doc']."</td>
						</tr>				
						<tr>
							<td style='text-align: right;'>NÚMERO</td><td>".$_POST['dni']."</td>
						</tr>				
						<tr>
							<td style='text-align: right;'>CONTROL</td><td colspan=2>".$_POST['ldni']."</td>
						</tr>				
						<tr>
							<td style='text-align: right;'>MAIL</td><td colspan=2>".$_POST['Email']."</td>
						</tr>
						<tr>
							<td style='text-align: right;'>DIRECCIÓN</td><td colspan=2>".$_POST['Direccion']."</td>
						</tr>
						<tr>
							<td style='text-align: right;'>TELÉFONO 1</td><td colspan=2>".$_POST['Tlf1']."</td>
						</tr>
						<tr>
							<td style='text-align: right;'>TELÉFONO 2</td><td colspan=2>".$_POST['Tlf2']."</td>
						</tr>
						<tr>
							<td colspan=3 align='right' >
								".$PersonsBlack."
                					<a href='proveedores_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
        						".$closeButton."
							</td>
						</tr>
					</table>");
								
					unset($_SESSION['myimgx']);
					unset($_SESSION['refx']);
					unset($_SESSION['idx']);

			} else { print("* ERROR ".mysqli_error($db));
						show_form_img();
						global $texerror; 		$texerror = "\n\t ".mysqli_error($db);
						}
		}
						
		else {print("NO SE HA PODIDO GUARDAR EN ../imgpro/imgpro".$_SESSION['miseccion']."/");}

		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='proveedores_Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);

	} // FIN function process_form_img()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form_img($errors=[]){
	
	global $SaveBlackTit;		$SaveBlackTit = "MODIFICAR LA IMAGEN";
	global $PersonsBlackTit;	$PersonsBlackTit = "VER TODOS LOS proveedores";
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	global $dt; 		global $db; 	

	global $sesionref; 		$sesionref = $_SESSION['ref'];

	if(isset($_POST['oculto2'])){

			$_SESSION['myimgx'] = $_POST['myimg'];
			$_SESSION['refx'] = $_POST['ref'];
			$_SESSION['idx'] = $_POST['id'];
			$_SESSION['dniold'] = $_POST['dni'];
			//echo $_SESSION['OldImg']."--**--<br>";

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
								'Tlf2' => $_POST['Tlf2']);
	
	} elseif(isset($_POST['imagenmodif'])){
				global $OldImg;
			if(!isset($_POST['myimg'])){ 
				$OldImg = $_SESSION['myimgx'];
				//echo $OldImg."1**--**<br>";
			}else{ $OldImg = $_POST['myimg']; 
				//echo $OldImg."2**--**<br>";
			}
			
			$defaults = array ( 'id' => $_POST['id'],
								'rsocial' => $_POST['rsocial'],
								'myimg' => $OldImg,	
								'ref' => $_POST['ref'],
								'doc' => $_POST['doc'],
								'dni' => $_POST['dni'],
								'ldni' => $_POST['ldni'],
								'Email' => $_POST['Email'],
								'Direccion' => $_POST['Direccion'],
								'Tlf1' => $_POST['Tlf1'],
								'Tlf2' => $_POST['Tlf2']);
							}
	if ($errors){
		print("	<div>
					<table class='tableForm'>
					<th style='text-align:left'>
					<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font><br/>
					</th>
					<tr>
					<td style='text-align:left'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#F1BD2D'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</td>
				</tr>
				</table>
				</div>
				<div style='clear:both'></div>");
		}
		
	print("<table align='center' style='border:none;'>
				<tr>
					<th colspan=2 >MODIFICAR IMAGEN CLIENTE</th>
				</tr>
				<tr>
					<th class='BorderInf'>LA IMAGEN ACTUAL DE : </br>".$defaults['rsocial']."</th>
					<th class='BorderInf'>
		<img src='../cb26_Docs/img_proveedores/".$defaults['myimg']."' height='120px' width='90px' />
					</th>
				</tr>
				<tr>
					<td colspan=2>
					SELECCIONE UNA IMAGEN
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data'>
			<input type='file' name='myimg' value='".$defaults['myimg']."' style='color:#fff;' />
					</td>
				<tr>
					<td colspan=2 style='text-align: right;'>
						<input type='hidden' name='id' value='".$defaults['id']."' />					
						<input type='hidden' name='ref' value='".$defaults['ref']."' />					
						<input type='hidden' name='rsocial' value='".$defaults['rsocial']."' />
						<input type='hidden' name='doc' value='".$defaults['doc']."' />
						<input type='hidden' name='dni' value='".$defaults['dni']."' />
						<input type='hidden' name='ldni' value='".$defaults['ldni']."' />
						<input type='hidden' name='Email' value='".$defaults['Email']."' />
						<input type='hidden' name='Direccion' value='".$defaults['Direccion']."' />
						<input type='hidden' name='Tlf1' value='".$defaults['Tlf1']."' />
						<input type='hidden' name='Tlf2' value='".$defaults['Tlf2']."' />
						<!--
						<input type='submit' value='MODIFICAR LA IMAGEN' class='botonverde'/>
						-->
						".$SaveBlack.$closeButton."
							<input type='hidden' name='imagenmodif' value=1 />
				</form>														
					</td>
					<td align='right'>
						".$PersonsBlack."
							<a href='proveedores_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
					</td>
				</tr>
			</table>");
			
	} // FIN show_form_img($errors=[])	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/*
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaproveedores;	$rutaproveedores = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
				} 
	*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info_img(){

	global $db; 		global $destination_file;		global $rename_filename;

	$ActionTime = date('H:i:s');

	global $dir;
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
				$dir = "../cb26_Docs/log";
				}

global $text;
$text = "\n- proveedores IMG MODIFICADA ".$ActionTime.".\n\tR. Social: ".$_POST['rsocial'].".\n\tDNI: ".$_POST['dni'].$_POST['ldni'].".\n\tReferencia: ".$_POST['ref'].".\n\t".$destination_file.".\n\t".$rename_filename;

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

	//require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>