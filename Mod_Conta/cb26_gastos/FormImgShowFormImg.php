<?php

		if(isset($_POST['mimg1'])){	$_SESSION['ImgCb23'] = $_SESSION['myimg1'];
									$_SESSION['imgcamp'] = "myimg1";}
		if(isset($_POST['mimg2'])){	$_SESSION['ImgCb23'] = $_SESSION['myimg2'];
									$_SESSION['imgcamp'] = "myimg2";}
		if(isset($_POST['mimg3'])){	$_SESSION['ImgCb23'] = $_SESSION['myimg3'];
									$_SESSION['imgcamp'] = "myimg3";}
		if(isset($_POST['mimg4'])){	$_SESSION['ImgCb23'] = $_SESSION['myimg4'];
									$_SESSION['imgcamp'] = "myimg4";}

		if(isset($_POST['oculto2'])){
					$defaults = array ( 'seccion' => '',
										'id' => '',
										'valor' => '',
										'nombre' => '',
										'ref' => '',										
										'myimg' => '');
									}
								   
		elseif((isset($_POST['mimg1']))||(isset($_POST['mimg2']))||(isset($_POST['mimg3']))||(isset($_POST['mimg4']))){
				$defaults = array ( 'seccion' => $_SESSION['miseccion'],
									'id' => $_SESSION['miid'],
									'valor' => $_SESSION['mivalor'],
									'nombre' => $_SESSION['minombre'],
									'ref' => $_SESSION['miref'],									
									'myimg' => $_SESSION['ImgCb23']);
		}elseif((isset($_POST['imagenmodif']))||(isset($_POST['borraimg']))){
				$defaults = array ( 'seccion' => $_SESSION['miseccion'],
									'id' => $_SESSION['miid'],
									'valor' => $_SESSION['mivalor'],
									'nombre' => $_SESSION['minombre'],
									'ref' => $_SESSION['miref'],									
									'myimg' => $_SESSION['ImgCb23']);
			}

		if ($errors){
			print("<tr>
						<th style='text-align:center'>
							<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
						</th>
					</tr>
					<tr>
						<td style='text-align:center' >");
			for($a=0; $c=count($errors), $a<$c; $a++){
				print("<font color='#FF0000'>**</font>  ".$errors [$a]."<br/>");
				}
			print("</td>
					</tr>");
		}
	
		$ext_permitidas = array('pdf','PDF');
		
		$extension = substr($defaults['myimg'],-3);
		$ext_correcta = in_array($extension, $ext_permitidas);
		if(!$ext_correcta){ 	global $myimg1;
								$myimg = $defaults['myimg'];
							}
		else{	global $myimg; 	$myimg = 'pdf.png'; }

		global $DeleteWhiteTit;		$DeleteWhiteTit = "BORRAR ESTA IMAGEN";

		global $TituloCheck;	$TituloCheck = "CONFIRME EL BORRADO CON EL CHECKBOX";
		global $checked;
		if(@$defaults['xl'] == 'yes') { $checked = "checked='checked'";}else{ $checked = ""; }
		
		global $Checkbox;
		$Checkbox = "<input type='checkbox' name='xl' value='yes' ".$checked." style='text-align:center; display:inline-block; vertical-align:middle; margin: 0.7em 0.2em 0.1em 0.8em;'/>";

	print("<tr>
				<th style='padding-top: 0.6em'>SELECCIONE UNA NUEVA IMAGEN</th>
			</tr>
			<tr>
				<th>
			LA IMAGEN ACTUAL </br>".strtoupper($defaults['seccion'])." / ".strtoupper($defaults['nombre'])." / ".strtoupper($_SESSION['ImgCb23']).".
						</br></br>
				<form name='cero' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;' >
					".$CachedWhite."".$closeButton."
					<input type='hidden' name='cero' value=1 />
				</form>	
				
				<div class='img1'>
					<img src='".$rutaDir.$myimg."' />
				</div>

				<form name='borraimg' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;' >
				
					<input type='hidden' name='myimg' value='".$defaults['myimg']."' style='color:#fff;' />
						<div style='display:inline-block;'>".$defaults['myimg']."
						".$DeleteWhite.$closeButton.$Checkbox."
						<input type='hidden' name='borraimg' value=1 />
				</form>

				</th>
			</tr>
			<tr>
				<td>
					<div style='text-align:center;' >SELECCIONE IMAGEN</div>
					<div style='text-align:center;'>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data'>
			<input type='file' name='myimg' value='".$defaults['myimg']."' style='color:#fff;' />
					".$SaveBlack.$closeButton."
					<input type='hidden' name='imagenmodif' value=1 />
		</form>														
					</div>
				</td>
			</tr>");


?>