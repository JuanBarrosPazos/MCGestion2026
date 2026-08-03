<?php

    global $LinkAcceso;		global $KeyLinkAcceso;		global $rf;
	global $WinClose;		global $KeyModifImg;		global $KeyClienteCero;
	global $Action;

	// PASA LOS VALORES INPUT POST AL FORMULARIO...
	global $PostValues;
	if(isset($_SESSION['Nivel'])){
			$PostValues = " <input type='hidden' name='id' value='".$_POST['id']."' />					
					<input type='hidden' name='ref' value='".@$_POST['ref']."' />					
					<input type='hidden' name='refnew' value='".@$_POST['refnew']."' />					
					<input type='hidden' name='Nivel' value='".$_POST['Nivel']."' />
					<input type='hidden' name='Nombre' value='".$_POST['Nombre']."' />
					<input type='hidden' name='Apellidos' value='".$_POST['Apellidos']."' />
					<input type='hidden' name='myimg' value='".@$_POST['myimg']."' />
					<input type='hidden' name='doc' value='".$_POST['doc']."' />
					<input type='hidden' name='dni' value='".$_POST['dni']."' />
					<input type='hidden' name='ldni' value='".$_POST['ldni']."' />
					<input type='hidden'' name='Email' value='".$_POST['Email']."' />
					<input type='hidden' name='Usuario' value='".$_POST['Usuario']."' />
					<input type='hidden' name='Password' value='".$_POST['Password']."' />
					<input type='hidden' name='Direccion' value='".$_POST['Direccion']."' />
					<input type='hidden' name='Tlf1' value='".$_POST['Tlf1']."' />
					<input type='hidden' name='Tlf2' value='".$_POST['Tlf2']."' />
					<input type='hidden' name='lastin' value='".@$_POST['lastin']."' />					
					<input type='hidden' name='lastout' value='".@$_POST['lastout']."' />					
					<input type='hidden' name='visitadmin' value='".@$_POST['visitadmin']."' />";
		global $Feedback;
		if($Feedback == 1){
			$Action = "ClienteVer.php";
		}else{
			$Action = "ClienteVer.php";
		}
			
	}else{ $PostValues = "";	$Action = "../index.php"; }

	// CONMUTA EL VALOR DE LA REFERENCIA CLIENTE...
	global $rf;
	if(isset($_POST['ref'])){ $rf = $_POST['ref']; }else{ }

	// MUESTRA OCULTA EL BOTON CREAR CLIENTE...
	global $BotonCreaCliente;
	switch (true) {
		case (@$_SESSION['Nivel']=='cliente'):
			$BotonCreaCliente = "";
			break;
		case (($_SESSION['Nivel'] == 'wmaster')||(@$_SESSION['Nivel']=='admin')||(@$_SESSION['Nivel']=='caja')):
			$BotonCreaCliente = "<form name='boton' action='ClienteCrear.php' method='post' style='display: inline-block;' >
			<button type='submit' title='CREAR CLIENTE O CAJERO' class='botonverde imgButIco PersonAddBlack'>
			</button>
					<input type='hidden' name='volver' value=1 />
				</form>";
			break;
		default:
			$BotonCreaCliente = "";
			break;
	}

	// BOTONERA PARTE SUPERIOR TABLA...
	if($KeyModifImg == 1){
		$ModifImgBotonIni = "";
		$WinClose = "<tr><td colspan=3 style='text-align:right;' >
						<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
                    <button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelWhite'>
                    </button>
							<input type='hidden' name='oculto2' value=1 />
						</form>
					</td></tr>";
		global $imgNewName;
		$safe_filename = $imgNewName;
	}else{
		$ModifImgBotonIni = "<tr>
								<th colspan=3 style='text-align:right;'>".$BotonCreaCliente."
				<form name='boton' action='ClienteVer.php' method='post' style='display: inline-block;' >
                    <button type='submit' title='INICIO CLIENTES' class='botonverde imgButIco PersonsBlack'>
                    </button>
						<input type='hidden' name='todo' value=1 />
				</form>
				<form name='boton' action='ClienteVer.php' method='post' style='display:inline-block;' >
						<button type='submit' title='INICIO FEEDBACK' class='botonverde imgButIco CachedBlack' >
						</button>
							<input type='hidden' name='todo' value=1 />
				</form>
								</th>
							</tr>";
		$WinClose = "";
	}

	// BOTONERA FIN TABLA...
    if($KeyLinkAcceso == 1){
			$LinkAcceso = "<tr>
							<td colspan=3 style='text-align:right;' class='BorderSup'>
								<a href=\"../Admin_index.php\">ADMINISTRADOR ACCESO A INICIO DEL SISTEMA</a>
							</td>
						</tr>";
						
    }elseif($KeyLinkAcceso == "borrar1"){
			$LinkAcceso = "<tr>
			<td colspan='3' style='text-align:right;'>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
			<button type='submit' title='ELIMINAR DATOS PERMANENTEMENTE' class='botonrojo imgButIco DeleteWhite' >
			</button>
				".$PostValues."
			<input type='hidden' name='borrar' value=1 />
		</form>
			</td>
				</tr>";
	}else{ $LinkAcceso = ""; }

	global $Titulo;		global $rutImg;
	global $tabla;
	$tabla = "<table align='center' style='margin-top:1.0em; font-size:1.0em !important;'>
				<tr>
					<th colspan=3 style='color:#F1BD2D;' >".$Titulo."</th>
				</tr>
					".$ModifImgBotonIni."
				<tr>
					<td width=100px style='text-align:right;'>NOMBRE </td>
					<td width=100px>".$_POST['Nombre']."</td>
					<td width='100px' rowspan='5' align='center'>
						<img src='".$rutImg.$safe_filename."' height='120px' width='90px' />
					</td>
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
					<td style='text-align:right;'>CONTROL </td>
					<td>".$_POST['ldni']."</td>
				</tr>				
				<tr>
					<td style='text-align:right;'>MAIL </td>
					<td colspan='2'>".$_POST['Email']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NIVEL </td>
					<td colspan='2'>".$_POST['Nivel']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>REFERENCIA </td>
					<td colspan='2'>".$rf."</td>
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
				</tr>".$LinkAcceso.$WinClose."
			</table>";	 

?>