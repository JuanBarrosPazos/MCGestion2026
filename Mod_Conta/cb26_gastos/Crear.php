<?php
session_start();

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

		unset($_SESSION['ImgCb23']);	unset($_SESSION['factdate']);
		unset($_SESSION['myimg1']); 	unset($_SESSION['myimg2']);
		unset($_SESSION['myimg3']); 	unset($_SESSION['myimg4']);	
		unset($_SESSION['miseccion']); 	unset($_SESSION['miid']);	
		unset($_SESSION['mivalor']); 	unset($_SESSION['minombre']);	
		unset($_SESSION['miref']); 		unset($_SESSION['midyt1']);
		unset($_SESSION['stat']);		unset($_SESSION['newDy']);
		unset($_SESSION['$nombre1n']);	unset($_SESSION['$nombre2n']);
		unset($_SESSION['$nombre3n']);	unset($_SESSION['$nombre4n']);
		unset($_SESSION['fnnew']);

		master_index();

		if(isset($_POST['oculto'])){
								
			if($form_errors = validate_form()){
							show_form($form_errors);
			} else { process_form();
					 info();
						}
								
		} else { show_form(); }
		

	} else { require '../Inclu/table_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
	
		global $db; 	global $sqld; 		global $qd; 		global $rowd;

		$errors = array();
		
		require 'ValidateForm.php';
		require 'ValidateImg.php';

		return $errors;

	} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){
	
		global $rutPend;	$rutPend = '';
		global $pend;		$pend = "";
		require 'Botonera.php';

		global $db; 		global $db_name;		global $vname;	
		global $dyt1; 		global $dm1;

		require 'FactDate.php';

		require 'FormatNumber.php';

		global $vname; 		$vname = "`".$_SESSION['clave']."gastos_".$dyt1."`";

		/************* INICIO NOMBRES DE LAS IMG  ***************/

		global $new_name1;	global $new_name2;	global $new_name3;	global $new_name4;
		
		if($_FILES['myimg1']['size'] == 0){
			$new_name1 = $_POST['factnum']."_1.png";
		}else{
			$extension1 = substr($_FILES['myimg1']['name'],-3);
			// $extension1 = end(explode('.', $_FILES['myimg1']['name']) );
			$new_name1 = $_POST['factnum']."_1.".$extension1;
		}

		if($_FILES['myimg2']['size'] == 0){
			$new_name2 = $_POST['factnum']."_2.png";
		}else{
			$extension2 = substr($_FILES['myimg2']['name'],-3);
			$new_name2 = $_POST['factnum']."_2.".$extension2;
		}

		if($_FILES['myimg3']['size'] == 0){
			$new_name3 = $_POST['factnum']."_3.png";
		}else{
			$extension3 = substr($_FILES['myimg3']['name'],-3);
			$new_name3 = $_POST['factnum']."_3.".$extension3;
		}

		if($_FILES['myimg4']['size'] == 0){
			$new_name4 = $_POST['factnum']."_4.png";
		}else{
			$extension4 = substr($_FILES['myimg4']['name'],-3);
			$new_name4 = $_POST['factnum']."_4.".$extension4;
		}

		/************* FIN NOMBRES DE LAS IMG  ***************/

		global $db; 		global $db_name;

		if(strlen(trim($factrete)) == 0){ $factrete = 0.0; }else{ }
		global $factcrea;	$factcrea = date('Y-m-i H:i:s');

		$sqla = "INSERT INTO `$db_name`.$vname (`factnum`, `factnumini`, `factdate`, `factdateini`, `refprovee`, `factnom`, `factnif`, `factiva`, `factivae`, `factpvp`, `factret`, `factrete`, `factpvptot`,`coment`, `myimg1`, `myimg2`, `myimg3`, `myimg4`, `factcrea`) VALUES ('$_POST[factnum]', '$_POST[factnum]', '$factdate', '$factdate', '$_POST[refprovee]', '$_POST[factnom]', '$_POST[factnif]', '$_POST[factiva]', '$factivae', '$factpvp', '$_POST[factret]', '$factrete', '$factpvptot', '$_POST[coment]', '$new_name1', '$new_name2', '$new_name3', '$new_name4', '$factcrea')";
		
		// SE CUMPLE EL QUERY
		if(mysqli_query($db, $sqla)){ 

			/************* INICIO CREAMOS LAS IMAGENES ***************/
		
			if($_FILES['myimg1']['size'] == 0){ 
				$new_name1 = $_POST['factnum']."_1.png";
				$rename_filename1 = "../cb26_Docs/docgastos_".$dyt1."/".$new_name1;								
				copy("../cb26_Docs/docgastos_".$dyt1."/untitled.png", $rename_filename1);
			}else{
				$safe_filename1 = trim(str_replace('/', '', $_FILES['myimg1']['name']));
				$safe_filename1 = trim(str_replace('..', '', $safe_filename1));
		
				$nombre1 = $_FILES['myimg1']['name'];
				$nombre1_tmp = $_FILES['myimg1']['tmp_name'];
				$tipo1 = $_FILES['myimg1']['type'];
				$tamano1 = $_FILES['myimg1']['size'];
	
				$destination_file1 = "../cb26_Docs/docgastos_".$dyt1."/".$safe_filename1;
			
			if( file_exists("../cb26_Docs/docgastos_".$dyt1."/".$nombre1) ){
					unlink("../cb26_Docs/docgastos_".$dyt1."/".$nombre1);
				//	print("** El archivo ".$nombre1." Ya existe, seleccione otra imagen.</br>");
			}elseif (move_uploaded_file($_FILES['myimg1']['tmp_name'], $destination_file1)){
	
				// Renombrar el archivo:
				//$extension1 = substr($_FILES['myimg1']['name'],-3);
				// print($extension1);
				// $extension1 = end(explode('.', $_FILES['myimg1']['name']) );
				global $new_name1;
				//$new_name1 = $_POST['factnum']."_1.".$extension1;
				$rename_filename1 = "../cb26_Docs/docgastos_".$dyt1."/".$new_name1;								
				rename($destination_file1, $rename_filename1);
	
			}else{print("NO SE HA PODIDO GUARDAR EN ".$destination_file1);}
					}
	
			/////////////
	
			if($_FILES['myimg2']['size'] == 0){
					$new_name2 = $_POST['factnum']."_2.png";
					$rename_filename2 = "../cb26_Docs/docgastos_".$dyt1."/".$new_name2;								
					copy("../cb26_Docs/docgastos_".$dyt1."/untitled.png", $rename_filename2);
			}else{
	
				$safe_filename2 = trim(str_replace('/', '', $_FILES['myimg2']['name']));
				$safe_filename2 = trim(str_replace('..', '', $safe_filename2));
		
				$nombre2 = $_FILES['myimg2']['name'];
				$nombre2_tmp = $_FILES['myimg2']['tmp_name'];
				$tipo2 = $_FILES['myimg2']['type'];
				$tamano2 = $_FILES['myimg2']['size'];
		
				$destination_file2 = "../cb26_Docs/docgastos_".$dyt1."/".$safe_filename2;
			
				if( file_exists("../cb26_Docs/docgastos_".$dyt1."/".$nombre2) ){
						unlink("../cb26_Docs/docgastos_".$dyt1."/".$nombre2);
					//	print("** El archivo ".$nombre1." Ya existe, seleccione otra imagen.</br>");
	
				}elseif (move_uploaded_file($_FILES['myimg2']['tmp_name'], $destination_file2)){
	
					// Renombrar el archivo:
					//$extension2 = substr($_FILES['myimg2']['name'],-3);
					// print($extension2);
					// $extension2 = end(explode('.', $_FILES['myimg2']['name']) );
					global $new_name2;
					//$new_name2 = $_POST['factnum']."_2.".$extension2;
					$rename_filename2 = "../cb26_Docs/docgastos_".$dyt1."/".$new_name2;								
					rename($destination_file2, $rename_filename2);
				}else {print("NO SE HA PODIDO GUARDAR EN ".$destination_file2);}
	
			}
				
			/////////////
	
			if($_FILES['myimg3']['size'] == 0){
					$new_name3 = $_POST['factnum']."_3.png";
					$rename_filename3 = "../cb26_Docs/docgastos_".$dyt1."/".$new_name3;								
					copy("../cb26_Docs/docgastos_".$dyt1."/untitled.png", $rename_filename3);
			}else{
	
				$safe_filename3 = trim(str_replace('/', '', $_FILES['myimg3']['name']));
				$safe_filename3 = trim(str_replace('..', '', $safe_filename3));
		
				$nombre3 = $_FILES['myimg3']['name'];
				$nombre3_tmp = $_FILES['myimg3']['tmp_name'];
				$tipo3 = $_FILES['myimg3']['type'];
				$tamano3 = $_FILES['myimg3']['size'];
		
				$destination_file3 = "../cb26_Docs/docgastos_".$dyt1."/".$safe_filename3;
			
				if( file_exists("../cb26_Docs/docgastos_".$dyt1."/".$nombre3) ){
						unlink("../cb26_Docs/docgastos_".$dyt1."/".$nombre3);
					//	print("** El archivo ".$nombre1." Ya existe, seleccione otra imagen.</br>");
				}elseif (move_uploaded_file($_FILES['myimg3']['tmp_name'], $destination_file3)){
	
					// Renombrar el archivo:
					//$extension3 = substr($_FILES['myimg3']['name'],-3);
					// print($extension3);
					// $extension3 = end(explode('.', $_FILES['myimg3']['name']) );
					global $new_name3;
					//$new_name3 = $_POST['factnum']."_3.".$extension3;
					$rename_filename3 = "../cb26_Docs/docgastos_".$dyt1."/".$new_name3;								
					rename($destination_file3, $rename_filename3);
				}else {print("NO SE HA PODIDO GUARDAR EN ".$destination_file3);}
				
			}
				
			/////////////
			
			if($_FILES['myimg4']['size'] == 0){
					$new_name4 = $_POST['factnum']."_4.png";
					$rename_filename4 = "../cb26_Docs/docgastos_".$dyt1."/".$new_name4;								
					copy("../cb26_Docs/docgastos_".$dyt1."/untitled.png", $rename_filename4);
			}else{
	
				$safe_filename4 = trim(str_replace('/', '', $_FILES['myimg4']['name']));
				$safe_filename4 = trim(str_replace('..', '', $safe_filename4));
		
				$nombre4 = $_FILES['myimg4']['name'];
				$nombre4_tmp = $_FILES['myimg4']['tmp_name'];
				$tipo4 = $_FILES['myimg4']['type'];
				$tamano4 = $_FILES['myimg4']['size'];
		
				$destination_file4 = "../cb26_Docs/docgastos_".$dyt1."/".$safe_filename4;
			
				if( file_exists("../cb26_Docs/docgastos_".$dyt1."/".$nombre4) ){
						unlink("../cb26_Docs/docgastos_".$dyt1."/".$nombre4);
					//	print("** El archivo ".$nombre1." Ya existe, seleccione otra imagen.</br>");
				}elseif (move_uploaded_file($_FILES['myimg4']['tmp_name'], $destination_file4)){

					// Renombrar el archivo:
					//$extension4 = substr($_FILES['myimg4']['name'],-3);
					// print($extension4);
					// $extension4 = end(explode('.', $_FILES['myimg4']['name']) );
					global $new_name4;
					//$new_name4 = $_POST['factnum']."_4.".$extension4;
					$rename_filename4 = "../cb26_Docs/docgastos_".$dyt1."/".$new_name4;								
					rename($destination_file4, $rename_filename4);
				}else {print("NO SE HA PODIDO GUARDAR EN ".$destination_file4);}
	
			}

			/************* FIN CREAMOS LAS IMAGENES ***************/

			global $iniy; 		$iniy = substr(date('Y'),0,2);
			global $title;	$title = 'SE HA GRABADO EN ';
			global $ConteBotones;		$ConteBotones = "style='display:block;'";

			/*
			global $Crear;			$Crear = "style='display:none; visibility: hidden;'";
			global $Ver2;			$Ver2 = "style='display:none; visibility: hidden;'";
			global $ModImg2;		$ModImg2 = "style='display:none; visibility: hidden;'";
			global $Modif2;			$Modif2 = "style='display:none; visibility: hidden;'";
			global $Borrar2;		$Borrar2 = "style='display:none; visibility: hidden;'";
			*/
			require 'TableFormResult.php';

		}else{ // NO SE CUMPLE EL QUERY
				print("* ERROR L.124: ".mysqli_error($db));
				show_form();
				global $texerror; 	$texerror = "\n\t ".mysqli_error($db);
			}

		/*
		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
		*/

	} // FIN function process_form()	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){
	
		global $rutPend;	$rutPend = '';
		global $pend;		$pend = "";
		require 'Botonera.php';

		global $db; 			global $db_name;

		global $valIvaeEnt;		global $valIvaeDec;		
		global $valReteEnt;		global $valReteDec;
		global $valToteEnt;		global $valToteDec;	
						
		global $sesionref; 		$sesionref = "`".$_SESSION['clave']."proveedores`";

		if((isset($_POST['proveegastos']))&&($_POST['proveegastos']!='')){
			$sqlx =  "SELECT * FROM $sesionref WHERE `ref` = '$_POST[proveegastos]'";
			$qx = mysqli_query($db, $sqlx);
			$rowprovee = mysqli_fetch_assoc($qx);

			$qx = mysqli_query($db, $sqlx);
			$rowprovee = mysqli_fetch_assoc($qx);
			$_rsocial = $rowprovee['rsocial'];
			$_ref = $rowprovee['ref'];
			$_dni = $rowprovee['dni'];
			$_ldni = $rowprovee['ldni'];
			global $_dnil;
			$_dnil = $_dni.$_ldni;
		}
	
		if((isset($_POST['oculto']))||(isset($_POST['oculto1']))){
			
			if(!isset($_POST['oculto'])){
				$_POST['factivae1'] = '00';		$_POST['factivae2'] = '00';
				$_POST['factrete1'] = '00';		$_POST['factrete2'] = '00';
				$_POST['factpvptot1'] = '00';	$_POST['factpvptot2'] = '00';
			}else{
				$_POST['factivae1'] = $valIvaeEnt;		$_POST['factivae2'] = $valIvaeDec;
				$_POST['factrete1'] = $valReteEnt;		$_POST['factrete2'] = $valReteDec;
				$_POST['factpvptot1'] = $valToteEnt;	$_POST['factpvptot2'] = $valToteDec;
					}	

					global $DelRuta;		$DelRuta ="";
			
					global $VarArray;	$VarArray = 4;
					require 'ArrayTotal.php';
		
		}else{ 
			
			global $DelRuta;		$DelRuta ="";
			
			global $VarArray;	$VarArray = 5;
			require 'ArrayTotal.php';

							}

		require 'ArrayMesDia.php';
										
		global $Titulo; 	$Titulo = "SELECCIONE PROVEEDOR GASTO";
		global $TitValue;	$TitValue = "SELECCIONE PROVEEDOR";
		require 'FormSelectProvee.php';
		
		global $Crear;			$Crear = "style='display:none; visibility: hidden;'";
		global $Ver2;			$Ver2 = "style='display:none; visibility: hidden;'";
		global $ModImg2;		$ModImg2 = "style='display:none; visibility: hidden;'";
		global $Modif2;			$Modif2 = "style='display:none; visibility: hidden;'";
		global $Borrar2;		$Borrar2 = "style='display:none; visibility: hidden;'";
		global $PendienteG;		$PendienteG = "style='display:none; visibility: hidden;'";
		
		print ("<tr>
					<td style='text-align:center;' >");
			
			global $ConteBotones;		$ConteBotones = "style='display:block;'";
			require 'Botones.php';
					
		print("</td>
				</tr>
			</table>");
				
		require 'TableIfErrors.php';

	////////////////////

	if ((isset($_POST['oculto1'])) || (isset($_POST['oculto']))) {
	if (($_POST['proveegastos'] == '') && ($defaults['factnom'] == '')) { 
			print("<table class='tableForm' >
						<tr align='center'>
							<td>
								<font color='red'>HA DE SELECCIONAR UN PROVEEDOR</font>
							</td>
						</tr>
					</table>");
				}

	if($_POST['proveegastos'] != '') {
	 
		print("<table class='tableForm' >
				<tr>
					<th colspan=2 >CREAR NUEVO GASTO</th>
				</tr>");
 
		require 'FormDatos.php';

		print("<tr>
					<td style='text-align:right;'>PDF / FOTO 1</td>
					<td>
		<input type='file' name='myimg1' value='".@$defaults['myimg1']."' style='color:#fff !important;' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>PDF / FOTO 2</td>
					<td>
		<input type='file' name='myimg2' value='".@$defaults['myimg2']."' style='color:#fff !important;' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>PDF / FOTO 3</td>
					<td>
		<input type='file' name='myimg3' value='".@$defaults['myimg3']."' style='color:#fff !important;' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>PDF / FOTO 4</td>
					<td>
		<input type='file' name='myimg4' value='".@$defaults['myimg4']."' style='color:#fff !important;' />
					</td>
				</tr>
				<tr>
					<td colspan='2' align='right' valign='middle' >
					<!--
						<input type='submit' value='GRABAR GASTO' class='botonverde' />
					-->
					".$SaveBlack.$closeButton."
						<input type='hidden' name='oculto' value=1 />
			</form>");
			
			global $ConteBotones;		$ConteBotones = "style='display:inline-block; float:left !important;'";
			require 'Botones.php';
			
			print("</td>
				</tr>
			</table>"); 
			}
		}

	} // FIN function show_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info(){

		global $factdate; 			global $factpvp;
		global $factpvptot; 		global $factrete;
		
		$ActionTime = date('H:i:s');

		global $text;
		$text = "\n- GASTO CREADO ".$ActionTime.".\n\tNº FACTURA: ".$_POST['factnum'].".\n\tDATE FACTURA: ".$factdate.".\n\tRAZON SOCIAL: ".$_POST['factnom'].".\n\tNIF: ".$_POST['factnif'].".\n\tTIPO IVA %: ".$_POST['factiva'].".\n\tTIPO RETEN %: ".$_POST['factret'].".\n\tRETEN €: ".$factrete.".\n\tNETO €: ".$factpvp.".\n\tTOTAL €: ".$factpvptot;

		require 'WriteLog.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaGastos;	$rutaGastos = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
				} /* Fin funcion master_index.*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>