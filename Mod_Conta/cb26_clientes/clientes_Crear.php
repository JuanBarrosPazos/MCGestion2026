<?php
session_start();

	//echo $_SESSION['ref'];
	//echo $_SESSION['Usuario'];

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

		master_index();

		if(isset($_POST['oculto'])){
				if($form_errors = validate_form()){
							show_form($form_errors);
							unset($_SESSION['dudas']);
				} else { process_form();
						 info();
							}
		} else { show_form();
				 unset($_SESSION['dudas']);
					}
	} else { require '../Inclu/table_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
	
		global $db, $db_name;
		global $sqld; 		global $qd; 		global $rowd;
	
		require 'validate.php';	
		
		return $errors;

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db, $db_name;	
	global $rf1, $rf2;

	if (preg_match('/^(\w{1})/', $_POST['rsocial'] ?? '', $ref1)) { $rf1 = $ref1[1];
																	$rf1 = trim($rf1);
	}

	if (preg_match('/^(\w{1})*(\s\w{1})/', $_POST['rsocial'] ?? '',$ref2)){ $rf2 = $ref2[2];
																			$rf2 = trim($rf2);
	}
	
	global $rf;
	$rf = strtolower($rf1.$rf2.$_POST['dni'].$_POST['ldni']);
	$rf = trim($rf);
			
	/************* CREAMOS LAS IMAGENES EN LA IMG CLIENTE DIRECTORIO ***************/

	global $tabla1; 		$sesionref = $_SESSION['ref'];

	global $new_name;
	if($_FILES['myimg']['size'] == 0){
		$nombre = 'untitled.png';
		$new_name = $rf.".png";
	}else{		 
		$extension = substr($_FILES['myimg']['name'],-3);
		// print($extension);
		// $extension = end(explode('.', $_FILES['myimg']['name']) );
		$new_name = $rf.".".$extension;
	}																		

	global $vname; 		$vname = "`".$_SESSION['clave']."clientes`";

	global $tlf2;
	if(strlen(trim($_POST['Tlf2'])) == 0){
		$tlf2 = 0;
	} else { $tlf2 = $_POST['Tlf2']; }

	$sql = "INSERT INTO `$db_name`.$vname (`ref`, `rsocial`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Direccion`, `Tlf1`, `Tlf2`) VALUES ('$rf', '$_POST[rsocial]', '$new_name', '$_POST[doc]', '$_POST[dni]', '$_POST[ldni]', '$_POST[Email]', '$_POST[Direccion]', '$_POST[Tlf1]', '$tlf2')";
		
	if(mysqli_query($db, $sql)){
		
		if($_FILES['myimg']['size'] == 0){
			$nombre = 'untitled.png';
			global $new_name;
			//$new_name = $rf.".png";
			$rename_filename = "../cb26_Docs/img_clientes/".$new_name;							
			copy("../cb26_Docs/img_clientes/untitled.png", $rename_filename);

	}else{	$safe_filename = trim(str_replace('/', '', $_FILES['myimg']['name']));
			$safe_filename = trim(str_replace('..', '', $safe_filename));

		 	$nombre = $_FILES['myimg']['name'];
		  	$nombre_tmp = $_FILES['myimg']['tmp_name'];
		  	$tipo = $_FILES['myimg']['type'];
		  	$tamano = $_FILES['myimg']['size'];
		  
			global $destination_file;
			$destination_file = "../cb26_Docs/img_clientes/".$safe_filename;

			if(file_exists( "../cb26_Docs/img_clientes/".$nombre) ){
					unlink("../cb26_Docs/img_clientes/".$nombre);
				//	print("* El archivo ".$nombre." ya existe, seleccione otra imagen.</br>");

			}elseif (move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file)){
					
					// Renombrar el archivo:
					$extension = substr($_FILES['myimg']['name'],-3);
					// print($extension);
					// $extension = end(explode('.', $_FILES['myimg']['name']) );
					global $new_name;
					//$new_name = $rf.".".$extension;
					$rename_filename = "../cb26_Docs/img_clientes/".$new_name;								
					rename($destination_file, $rename_filename);

					// print("El archivo se ha guardado en: ".$destination_file);
			
			}else { print("NO SE HA PODIDO GUARDAR EN ../cb26_Docs/img_clientes/".$new_name); }
		
		} // FIN ELSE
	
	//	$fil = "%".$rf."%";
		$pimg =  "SELECT * FROM `$db_name`.$vname WHERE `ref` = '$rf' ";
		$qpimg = mysqli_query($db, $pimg);
		$rowpimg = mysqli_fetch_assoc($qpimg);
		$_SESSION['dudas'] = $rowpimg['myimg'];
		global $dudas; 		$dudas = $_SESSION['dudas']; 	$dudas = trim($dudas);
	//	print("** ".$rowpimg['myimg']);

		global $PersonAddBlackTit;		$PersonAddBlackTit = "CREAR NUEVO CLIENTE";
		global $PersonsBlackTit;		$PersonsBlackTit = "VER TODOS LOS CLIENTES";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		print("<table class='tableForm'>
				<tr>
					<th colspan=3 >HA REGISTRADO UN NUEVO CLIENTE</th>
				</tr>
				<tr>
					<td style='width:120px; text-align:right;' >RAZON SOCIAL</td>
					<td  style='width:120px;' >".$_POST['rsocial']."</td>
					<td rowspan='5'  style='width:100px; text-align:center;' >
			<img src='../cb26_Docs/img_clientes/".$dudas."' height='120px' width='90px' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;' >DOCUMENTO</td><td>".$_POST['doc']."</td>
				</tr>				
				<tr>
					<td style='text-align:right;' >NUMERO</td><td>".$_POST['dni']."</td>
				</tr>				
				<tr>
					<td style='text-align:right;' >CONTROL</td><td>".$_POST['ldni']."</td>
				</tr>				
				<tr>
					<td style='text-align:right;' >MAIL</td><td colspan='2'>".$_POST['Email']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >REFERENCIA</td><td>".$rf."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >PAIS</td>
					<td colspan='2'>".$_POST['Direccion']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >TELEFONO 1</td><td colspan='2'>".$_POST['Tlf1']."</td>
				</tr>
				<tr>
					<td style='text-align:right;' >TELEFONO 2</td><td colspan='2'>".$_POST['Tlf2']."</td>
				</tr>
				<tr>
					<td colspan='3' style='text-align:center;' >
					".$PersonAddBlack."
						<a href='clientes_Crear.php' >&nbsp;&nbsp;&nbsp;</a>
					".$closeButton.$PersonsBlack."
						<a href='clientes_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
					".$closeButton."
							</td>
				</tr>
			</table>" );

		} else { 
			print("</br><font color='#F1BD2D'>
					* MODIFIQUE LA ENTRADA 146: </font></br> ".mysqli_error($db))."</br>";
					show_form ();
					global $texerror; 	$texerror = "\n\t ".mysqli_error($db);
				}

		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='clientes_Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);

	} /* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
		} else { 
			$defaults = array ( 'rsocial' => '',
								'myimg' => @$_POST['myimg'],	
								'ref' => '',
								'doc' => '',
								'dni' => '',
								'ldni' => '',
								'Email' => '',
								'Direccion' => '',
								'Tlf1' => '',
								'Tlf2' => '');
							}
	
	global $texerror;
	$texerror = "ERROR EN CAMPO DEL FORMULARIO.";
			
	if ($errors){
		require 'tablaErrors.php';
	} // FIN ERRORS
	
	$doctype = array (	'' => 'TIPO DE IDENTIFICADOR',
						'UNDEFINE' => 'Sin Validación Definida...',
						'DNI' => 'DNI/NIF Espa&ntilde;oles',
						'NIE' => 'NIE/NIF Extranjeros',
						'NIFespecial' => 'NIF Persona F&iacute;sica Especial',
						'NIFsa' => 'NIF Sociedad An&oacute;nima',
						'NIFsrl' => 'NIF Sociedad Respons. Limitada',
						'NIFscol' => 'NIF Sociedad Colectiva',
						'NIFscom' => 'NIF Sociedad Comanditaria',
						'NIFcbhy' => 'NIF Com. Bienes y Herencia Yacente',
						'NIFscoop' => 'NIF Sociedades Cooperativas',
						'NIFasoc' => 'NIF Asociaciones',
						'NIFcpph' => 'NIF Comunidad Propietarios',
						'NIFsccspj' => 'NIF Sociedad Civil',
						'NIFee' => 'NIF Entidad Extranjera',
						'NIFcl' => 'NIF Corporaciones Locales',
						'NIFop' => 'NIF Organismo Publico',
						'NIFcir' => 'NIF Instituciones Religiosas',
						'NIFoaeca' => 'NIF Admin Estado y Com. Autonoma',
						'NIFute' => 'NIF Union Temporales Empresas',
						'NIFotnd' => 'NIF Otros Tipos no Definidos',
						'NIFepenr' => 'NIF Establecim. Entidad No Residente');

	global $rf1, $rf2;

	if (preg_match('/^(\w{1})/', $_POST['rsocial'] ?? '', $ref1)) { $rf1 = $ref1[1];
																	$rf1 = trim($rf1);
	}

	if (preg_match('/^(\w{1})*(\s\w{1})/', $_POST['rsocial'] ?? '',$ref2)){ $rf2 = $ref2[2];
																			$rf2 = trim($rf2);
	}

	global $rf;
	$rf = strtolower($rf1.$rf2.@$_POST['dni'].@$_POST['ldni']);
	$rf = trim($rf);

	print("<table class='tableForm'>
				<tr>
					<th colspan=2 >
							DATOS DEL NUEVO CLIENTE
					</th>
				</tr>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
				<tr>
					<td style='width:120px; text-align:right;'>REFERENCIA<font color='#F1BD2D'> *</font></td>
					<td>SE GENERA AUTOMÁTICA</td>
				</tr>
				<tr>
					<td style='text-align:right;'>RAZON SOCIAL<font color='#F1BD2D'> *</font>
					</td>
					<td>
		<input type='text' name='rsocial' size=30 maxlength=30 pattern='[a-zA-Z0-9\s]{3,30}' placeholder='RAZON SOCIAL' value='".$defaults['rsocial']."' required />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>DOCUMENTO<font color='#F1BD2D'> *</font></td>
					<td>
			<select name='doc' required >");
				foreach($doctype as $option => $label){
					print ("<option value='".$option."' ");
					if($option == $defaults['doc']){ 
							print ("selected = 'selected'");
													}
									print ("> $label </option>");
								}
		
		global $SaveBlackTit;		$SaveBlackTit = "REGISTRAR ESTOS DATOS";
		global $PersonsBlackTit;	$PersonsBlackTit = "VER TODOS LOS CLIENTES";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		print ("</select>
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NÚMERO<font color='#F1BD2D'> *</font></td>
					<td>
		<input type='text' name='dni' size=14 maxlength=8 pattern='[0-9A-Z]{8,8}' placeholder='IDENTIFCADOR'  value='".$defaults['dni']."' required />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>CONTROL<font color='#F1BD2D'> *</font></td>
					<td>
		<input type='text' name='ldni' size=14 maxlength=1  pattern='[0-9A-Z]{1,1}' placeholder='CONTROL ID.' value='".$defaults['ldni']."' required />
				</td>
				</tr>
				<tr> 
					<td style='text-align:right;'>MAIL<font color='#F1BD2D'> *</font></td>
					<td>
		<input type='mail' name='Email' size=42 maxlength=50 placeholder='miemail@enminusculas' value='".$defaults['Email']."'/>
					</td>
				</tr>	
				<tr>
					<td style='text-align:right;'>DIRECCIÓN<font color='#F1BD2D'> *</font></td>
					<td>
	<input type='text' name='Direccion' size=42 maxlength=60 placeholder='MI DIRECCION' value='".$defaults['Direccion']."' required />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>TELÉFONO 1<font color='#F1BD2D'> *</font></td>
					<td>
		<input type='text' name='Tlf1' size=12 maxlength=9 pattern='[0-9]{9,9}' placeholder='TELEFONO 1' value='".$defaults['Tlf1']."' required />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>TELEÉFONO 2&nbsp;&nbsp;</td>
					<td>
		<input type='text'  name='Tlf2' size=12 maxlength=9 pattern='[0-9]{9,9}' placeholder='TELEFONO 2' value='".$defaults['Tlf2']."' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>FOTOGRAFIA<font color='#F1BD2D'>&nbsp;&nbsp;</font></td>
					<td>
		<input type='file' name='myimg' value='".@$defaults['myimg']."' style='color:#fff;' />
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align:right;'>
					<!--
						<input type='submit' value='REGISTRAR ESTOS DATOS' class='botonazul' />
					-->
					".$SaveBlack.$closeButton."
						<input type='hidden' name='oculto' value=1 />
			</form>	
					".$PersonsBlack."											
						<a href='clientes_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
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
		global $rutaClientes;	$rutaClientes = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
				} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $db; 	global $rf;

	$ActionTime = date('H:i:s');
	
	global $dir;
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
				$dir = "../cb26_Docs/log";
				}

	global $text;
	$text = "\n- CLIENTES CREAR ".$ActionTime.".\n\tR. Social: ".$_POST['rsocial'].".\n\tDNI: ".$_POST['dni'].$_POST['ldni'].".\n\tReferencia: ".$rf.".\n\tEmail: ".$_POST['Email'].".\n\tDireccion: ".$_POST['Direccion'].".\n\tTlf 1: ".$_POST['Tlf1'].".\n\tTlf 2: ".$_POST['Tlf2'].".";
	
	global $texerror;
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
	
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>