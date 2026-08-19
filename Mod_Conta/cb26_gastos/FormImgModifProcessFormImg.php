<?php

		if(isset($_POST['oculto2'])){
		
			//$_SESSION['midyt1'] = substr($_POST['vname'],-5,-1);
			// $_SESSION['midyt1'] = $_POST['dyt1'];

			global $vname;		// $vname = "`".$_SESSION['clave']."gastos_".$_SESSION['midyt1']."`";
			// $vname = $_POST['vname'];	

			global $rutaDir; 		// $rutaDir = "../cb26_Docs/docgastos_".$_SESSION['midyt1']."/";
			//$_SESSION['ruta'] = $rutaDir;
				
			$_SESSION['factdate'] = $_POST['factdate'];
			$_SESSION['miseccion'] = $_SESSION['ref'];
			$_SESSION['miid'] = $_POST['id'];
			$_SESSION['mivalor'] = $_POST['factnum'];
			$_SESSION['minombre'] = $_POST['factnom'];
			$_SESSION['miref'] = $_POST['refprovee'];

			global $sqlc;
		//	$sqlc =  "SELECT * FROM `$db_name`.$vname WHERE `factnum` = '$_POST[factnum]'";
			$sqlc =  "SELECT * FROM `$db_name`.$vname WHERE `id` = '$_SESSION[miid]'";
			$qc = mysqli_query($db, $sqlc);
			$rowsc = mysqli_fetch_assoc($qc);

			$ext_permitidas = array('pdf','PDF');

			@$extension1 = substr($rowsc['myimg1'],-3);
			$ext_correcta1 = in_array($extension1, $ext_permitidas);
			if(!$ext_correcta1){ global $myimg1; 	$myimg1 = $rowsc['myimg1'];
								@$_SESSION['myimg1'] = $rowsc['myimg1'];
			}else{	global $myimg1; 	$myimg1 = 'pdf.png';
					$_SESSION['myimg1'] = $myimg1;
						}

			$extension2 = substr($rowsc['myimg2'],-3);
			$ext_correcta2 = in_array($extension2, $ext_permitidas);
			if(!$ext_correcta2){ global $myimg2; 	$myimg2 = $rowsc['myimg2'];
								$_SESSION['myimg2'] = $rowsc['myimg2'];
			}else{	global $myimg2; 	$myimg2 = 'pdf.png';
					$_SESSION['myimg2'] = $myimg2;
						}

			$extension3 = substr($rowsc['myimg3'],-3);
			$ext_correcta3 = in_array($extension3, $ext_permitidas);
			if(!$ext_correcta3){ global $myimg3; 	$myimg3 = $rowsc['myimg3'];
								$_SESSION['myimg3'] = $rowsc['myimg3'];
			}else{	global $myimg3; 	$myimg3 = 'pdf.png';
					$_SESSION['myimg3'] = $myimg3;
						}

			$extension4 = substr($rowsc['myimg4'],-3);
			$ext_correcta4 = in_array($extension4, $ext_permitidas);
			if(!$ext_correcta4){ global $myimg4; 	$myimg4 = $rowsc['myimg4'];
								$_SESSION['myimg4'] = $rowsc['myimg4'];
			}else{	global $myimg4; 	$myimg4 = 'pdf.png';
					$_SESSION['myimg4'] = $myimg4;
						}
	
		}else{		
	
		global $rutaDir; 	// $rutaDir = "../cb26_Docs/docgastos_".$_SESSION['midyt1']."/";
		//$_SESSION['ruta'] = $rutaDir;

		global $vname; 		// $vname = "`".$_SESSION['clave']."gastos_".$_SESSION['midyt1']."`";

			global $sqlc;
		//	$sqlc =  "SELECT * FROM `$db_name`.$vname WHERE `factnum` = '$_SESSION[mivalor]'";
			$sqlc =  "SELECT * FROM `$db_name`.$vname WHERE `id` = '$_SESSION[miid]'";
			$qc = mysqli_query($db, $sqlc);
			$rowsc = mysqli_fetch_assoc($qc);
										
			$ext_permitidas = array('pdf','PDF');
			
			$extension1 = substr($rowsc['myimg1'],-3);
			$ext_correcta1 = in_array($extension1, $ext_permitidas);
			if(!$ext_correcta1){ global $myimg1; 	 $myimg1 = $rowsc['myimg1'];
								 $_SESSION['myimg1'] = $rowsc['myimg1'];
			}else{	global $myimg1; 	$myimg1 = 'pdf.png';
					$_SESSION['myimg1'] = $rowsc['myimg1'];
						}

			$extension2 = substr($rowsc['myimg2'],-3);
			$ext_correcta2 = in_array($extension2, $ext_permitidas);
			if(!$ext_correcta2){ global $myimg2;
								 $myimg2 = $rowsc['myimg2'];
								 $_SESSION['myimg2'] = $rowsc['myimg2'];
			}else{	global $myimg2; 	$myimg2 = 'pdf.png';
					$_SESSION['myimg2'] = $rowsc['myimg2'];
						}

			$extension3 = substr($rowsc['myimg3'],-3);
			$ext_correcta3 = in_array($extension3, $ext_permitidas);
			if(!$ext_correcta3){ 	global $myimg3; 	$myimg3 = $rowsc['myimg3'];
									$_SESSION['myimg3'] = $rowsc['myimg3'];
			}else{	global $myimg3; 	$myimg3 = 'pdf.png';
					$_SESSION['myimg3'] = $rowsc['myimg3'];
						}

			$extension4 = substr($rowsc['myimg4'],-3);
			$ext_correcta4 = in_array($extension4, $ext_permitidas);
			if(!$ext_correcta4){ global $myimg4; 	 $myimg4 = $rowsc['myimg4'];
								 $_SESSION['myimg4'] = $rowsc['myimg4'];
			}else{	global $myimg4; 	$myimg4 = 'pdf.png';
					$_SESSION['myimg4'] = $rowsc['myimg4'];
						}
		}

		require 'TableImgModif.php';

		if((isset($_POST['mimg1']))||(isset($_POST['mimg2']))||(isset($_POST['mimg3']))||(isset($_POST['mimg4']))){
							show_form_img();
		}elseif(isset($_POST['borraimg'])){
			if(!isset($_POST['xl'])){
							print("<div style='text-align:center; margin:auto;'>
										* HA DE MARCAR LA CASILLA DE CONFIRMACIÓN
									</div>");
							show_form_img();
			}elseif(isset($_POST['xl'])){
							//echo "HE PASADO LA VALIDACIÓN<br>";
							borra_img();
							show_form_img();
							info_img();
						}
		}elseif(isset($_POST['imagenmodif'])){
			if($form_errors = validate_form_img()){
						show_form_img($form_errors);
			}else{  modifica_form_img();
					show_form_img();
					info_img();
						}
		}elseif(isset($_POST['cero'])){ print($printimg);
									
		}else{ print($printimg); }

		print(" <tr>
					<td style='text-align: center;' >");

		global $ModImg2;		$ModImg2 = "style='display:none; visibility: hidden;'";
		global $ConteBotones;	$ConteBotones = "style='display:block;'";

		global $a;	$a= (substr($_SESSION['factdate'],0,4));
		global $vnameStatus; 		$vnameStatus = "`".$_SESSION['clave']."status`";
		$sqlSTatus =  "SELECT * FROM $vnameStatus WHERE `year`='$a' LIMIT 1 ";
		$qStauts = mysqli_query($db, $sqlSTatus);
		$rowStatus = mysqli_fetch_assoc($qStauts);

		global $style;
		//if($rowStatus['stat']==''){
		if($rowStatus['stat']=='close'){
			global $Borrar2;		$Borrar2= "style='display:none; visibility: hidden;'";
			global $Modif2;			$Modif2= "style='display:none; visibility: hidden;'";
			global $PendienteG;		$PendienteG = "style='display:none; visibility: hidden;'";
			global $Recupera3;		$Recupera3 = "style='display:none; visibility: hidden;'";
		}else{ }

		require 'Botones.php';
		
		print("</td>
				</tr>
			</table>");	 

		//echo "<br>** ".$sqlc."<br";



?>