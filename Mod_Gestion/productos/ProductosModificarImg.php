<?php
session_start();

	require '../Inclu/Admin_Inclu_popup.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

?>

<!---->
<script type="text/javascript">
//
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//
</script>

<?php

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')||($_SESSION['Nivel']=='user') || ($_SESSION['Nivel']=='caja')){
				
	if(isset($_POST['oculto2'])){ 
		process_form();
	}elseif((isset($_POST['myimg1']))||(isset($_POST['myimg2']))||(isset($_POST['myimg3']))||(isset($_POST['myimg4']))){ 
		process_form(); 
	}elseif(isset($_POST['imagenmodif'])){
		process_form();
	}elseif(isset($_POST['cero'])){
		process_form();
	}else{ }

}else{ require "../Inclu/AccesoDenegado.php";	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();

	$limite = 500 * 1024;
	
	$ext_permitidas = array('jpg','JPG','jpeg','JPEG','gif','GIF','png','PNG');
	
	$extension = substr($_FILES['myimg']['name'],-3);
	// print($extension);
	// $extension = end(explode('.', $_FILES['myimg']['name']) );
	$ext_correcta = in_array($extension, $ext_permitidas);

	$tipo_correcto = preg_match('/^image\/(pjpeg|jpeg|gif|png|jpg)$/', $_FILES['myimg']['type']);

		if($_FILES['myimg']['size'] == 0){
			$errors [] = "SELECCIONE UN FOTOGRAFÍA";
		}elseif(!$ext_correcta){
			$errors [] = "EXTENSIÓN NO PERMITIDA ".$_FILES['myimg']['name'];
		}elseif(!$tipo_correcto){
			$errors [] = "TIPO DE ARCHIVO NO PERMITIDO ".$_FILES['myimg']['name'];
		}elseif ($_FILES['myimg']['size'] > $limite){
			$tamanho = $_FILES['myimg']['size'] / 1024;
			$errors [] = "El archivo".$_FILES['myimg']['name']." es mayor de 500 KBytes. ".$tamanho." KB";
		}elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_PARTIAL){
				$errors [] = "CARGA DE ARCHIVO INTERRUMPIDA";
		}elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_NO_FILE){
					$errors [] = "ARCHIVO NO SE HA CARGADO";
		}
					
		return $errors;

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function modifica_form(){
	
		global $db; 		global $db_name;
		require "../config/TablesNames.php";

		global $img;		global $imgcamp;

		$safe_filename = trim(str_replace('/', '', $_FILES['myimg']['name']));
		$safe_filename = trim(str_replace('..', '', $safe_filename));

		$nombre = $_FILES['myimg']['name'];
		$nombre_tmp = $_FILES['myimg']['tmp_name'];
		$tipo = $_FILES['myimg']['type'];
		$tamano = $_FILES['myimg']['size'];

		$destination_file = "../imgpro/imgpro".$_SESSION['miseccion']."/".$safe_filename;
		
	    if( file_exists("../imgpro/imgpro".$_SESSION['miseccion']."/".$nombre) ){
			unlink("../imgpro/imgpro".$_SESSION['miseccion']."/".$nombre);
		}elseif (move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file)){

		// Eliminar el archivo antiguo untitled.png
		if($_SESSION['GestMyImg'] != 'untitled.png' ){
		unlink("../imgpro/imgpro".$_SESSION['miseccion']."/".$_SESSION['GestMyImg']);
									}
		// Renombrar el archivo:
		$extension = substr($_FILES['myimg']['name'],-3);
		// print($extension);
		// $extension = end(explode('.', $_FILES['myimg']['name']) );
		global $new_name;
		//	$new_name = $_SESSION['GestMyImg'];
		date('H:i:s');
		date('Y_m_d');
		$dt = date('is');
		global $new_name;
		$new_name = $_SESSION['mivalor']."_".$dt.".".$extension;
		$rename_filename = "../imgpro/imgpro".$_SESSION['miseccion']."/".$new_name;								
		rename($destination_file, $rename_filename);
		

		global $imgcamp;	$imgcamp = "`".$_SESSION['imgcamp']."`";

		global $mivalor;	$mivalor = $_SESSION['mivalor'];
			
		$sqla = "UPDATE `$db_name`.$Productos SET $imgcamp = '$new_name' WHERE $Productos.`valor` = '$mivalor' LIMIT 1 ";
			
		global $texerror;
		if(mysqli_query($db, $sqla)){
		}else{ print("* ERROR SQL L.140 ".mysqli_error($db));
				show_form ();
				$texerror = "\n\t ".mysqli_error($db);
		}
	}else{ print("NO SE HA PODIDO GUARDAR EN ../imgpro/imgpro".$_SESSION['miseccion']."/"); }

} 
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db; 	global $db_name;
	require "../config/TablesNames.php";

	if(isset($_POST['oculto2'])){
		
				unset($_SESSION['GestMyImg']);	
				unset($_SESSION['myimg1']);
				unset($_SESSION['myimg2']);
				unset($_SESSION['myimg3']);
				unset($_SESSION['myimg4']);	
				unset($_SESSION['miseccion']);	
				unset($_SESSION['miid']);	
				unset($_SESSION['mivalor']);	
				unset($_SESSION['minombre']);	
				unset($_SESSION['miref']);	
				
		$_SESSION['miseccion'] = $_POST['seccion'];
		$_SESSION['miid'] = $_POST['id'];
		$_SESSION['mivalor'] = $_POST['valor'];
		$_SESSION['minombre'] = $_POST['nombre'];
		$_SESSION['miref'] = $_POST['ref'];
	
		$sqlc =  "SELECT * FROM `$db_name`.$Productos WHERE `valor` = '$_POST[valor]'";
		$qc = mysqli_query($db, $sqlc);
		$countc = mysqli_num_rows($qc);
		$rowsc = mysqli_fetch_assoc($qc);
	
		$_SESSION['myimg1'] = $rowsc['myimg1'];
		$_SESSION['myimg2'] = $rowsc['myimg2'];
		$_SESSION['myimg3'] = $rowsc['myimg3'];
		$_SESSION['myimg4'] = $rowsc['myimg4'];
	
	} else {	$valor = $_SESSION['mivalor'];
													
				$sqlc =  "SELECT * FROM `$db_name`.$Productos WHERE `valor` = '$valor'";
				$qc = mysqli_query($db, $sqlc);
				$countc = mysqli_num_rows($qc);
				$rowsc = mysqli_fetch_assoc($qc);
									
				$_SESSION['myimg1'] = $rowsc['myimg1'];
				$_SESSION['myimg2'] = $rowsc['myimg2'];
				$_SESSION['myimg3'] = $rowsc['myimg3'];
				$_SESSION['myimg4'] = $rowsc['myimg4'];
			}

	print("<table class='detalle' align='center' style='font-size: 1.0em !important;'>
			<tr>
				<th colspan=4 class='BorderInf'>SECCION ".strtoupper($_SESSION['miseccion']).".
					</br>IMAGENES DEL PRODUCTO ".$_SESSION['minombre']."
				</th>
			</tr>
        	<tr>
				<td class='img1'>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
		  <img src='../imgpro/imgpro".$_SESSION['miseccion']."/".$_SESSION['myimg1']."'  onclick=\"MM_showHideLayers('contenedor','','show','foto1A','','show','foto2A','','hide','foto3A','','hide','foto4A','','hide')\" onload=\"MM_showHideLayers('foto1A','','show','foto2A','','hide','foto3A','','hide','foto4A','','hide')\" title='IMAGEN ".strtoupper($_SESSION['myimg1'])."' />
			<input name='myimg1' type='hidden' value='".$_SESSION['myimg1']."' />
			<button type='submit' title='MODIFICAR IMAGEN 1' class='botonazul imgButIco InicioBlack' >
			</button>
			<input type='hidden' name='myimg1' value=1 />
	</form>		  
		 	</td>
          	<td class='img1'>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data'>
		  <img src='../imgpro/imgpro".$_SESSION['miseccion']."/".$_SESSION['myimg2']."' onclick=\"MM_showHideLayers('foto1A','','hide','foto2A','','show','foto3A','','hide','foto4A','','hide')\" title='IMAGEN ".strtoupper($_SESSION['myimg2'])."' /> 
			<input name='myimg2' type='hidden' value='".$_SESSION['myimg2']."' />
			<button type='submit' title='MODIFICAR IMAGEN 2' class='botonazul imgButIco InicioBlack' >
			</button>
			<input type='hidden' name='myimg2' value=1 />
	</form>		  
		  </td>
          <td class='img1'>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data'>
		  <img src='../imgpro/imgpro".$_SESSION['miseccion']."/".$_SESSION['myimg3']."' onclick=\"MM_showHideLayers('foto1A','','hide','foto2A','','hide','foto3A','','show','foto4A','','hide')\" title='IMAGEN ".strtoupper($_SESSION['myimg3'])."' /> 
			<input name='myimg3' type='hidden' value='".$_SESSION['myimg3']."' />
			<button type='submit' title='MODIFICAR IMAGEN 3' class='botonazul imgButIco InicioBlack' >
			</button>
			<input type='hidden' name='myimg3' value=1 />
	</form>		  
		  </td>
          <td class='img1'>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
		  <img src='../imgpro/imgpro".$_SESSION['miseccion']."/".$_SESSION['myimg4']."' onclick=\"MM_showHideLayers('foto1A','','hide','foto2A','','hide','foto3A','','hide','foto4A','','show')\" title='IMAGEN ".strtoupper($_SESSION['myimg4'])."' /> 
			<input name='myimg4' type='hidden' value='".$_SESSION['myimg4']."' />
			<button type='submit' title='MODIFICAR IMAGEN 4' class='botonazul imgButIco InicioBlack' >
			</button>
			<input type='hidden' name='myimg4' value=1 />
	</form>
		  </td>
       </tr>
	   <tr>
			<td colspan=4 align='right' >
	<form name='cero' method='post' action='$_SERVER[PHP_SELF]' style='display: inline-block;' >
			<button type='submit' title='DETALLE IMAGENES' class='botonlila imgButIco DetalleBlack' >
			</button>
					<input type='hidden' name='cero' value=1 />
	</form>														
	<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\" style='display:inline-block;'>
			<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelWhite' >
			</button>
					<input type='hidden' name='oculto2' value=1 />
	</form>
			</td>
		</tr>");
       
$printimg =	"<div id='foto1A' class='img2'> 
				<img src='../imgpro/imgpro".$_SESSION['miseccion']."/".$_SESSION['myimg1']."' /> 
			</div>
			
            <div id='foto2A' class='img2'> 
				<img src='../imgpro/imgpro".$_SESSION['miseccion']."/".$_SESSION['myimg2']."' /> 
			</div>
			
            <div id='foto3A' class='img2'> 
				<img src='../imgpro/imgpro".$_SESSION['miseccion']."/".$_SESSION['myimg3']."' /> 
			</div>
			
            <div id='foto4A' class='img2'> 
				<img src='../imgpro/imgpro".$_SESSION['miseccion']."/".$_SESSION['myimg4']."' /> 
			</div>";
			
					global $style;
	if((isset($_POST['myimg1']))||(isset($_POST['myimg2']))||(isset($_POST['myimg3']))||(isset($_POST['myimg4']))){
					$style = 'margin-top:60px';
					show_form();
	}elseif(isset($_POST['imagenmodif'])){
					if($form_errors = validate_form()){
										$style = 'margin-top:60px';
										show_form($form_errors);
					}else{ 	modifica_form();
							show_form();
							//	log_info_02();
					}
	}elseif(isset($_POST['cero'])){	global $style;
							$style = 'margin-top:420px';
							print($printimg);
							
	}else{	$style = 'margin-top:420px';
			print($printimg);
	}

	print("</table>
	
	<div style='clear:both'></div>
	
	<!-- Inicio footer -->
		<div id='footer' style=".$style.">&copy; Juan Barr&oacute;s Pazos 2012 - 2023.</div>
	<!-- Fin footer -->
		</div>");	/* Final del print*/ 

		require '../Inclu/AutoWindowClose.php';
		global $Redir;      print ($Redir);

}	// FINAL process_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	require 'ProductosArrayTotalVar.php';
	global $ArrayProductosModificarImg;		$ArrayProductosModificarImg = 1;
	require	'ProductosArrayTotal.php';

	require 'TableValidateErrors.php';

	print($TrTitulo."<tr>
				<th colspan=3>
				<div style='display:block;'>
				<span style='color:#F1BD2D; display:block;'>
					LA IMAGEN ACTUAL
				</span>
				".strtoupper($defaults['seccion'])." / ".strtoupper($defaults['nombre'])." / ".strtoupper($_SESSION['GestMyImg'])."</div>
			<form name='cero' method='post' action='$_SERVER[PHP_SELF]' style='display: inline-block;' >
				<button type='submit' title='DETALLE IMAGENES' class='botonlila imgButIco DetalleBlack' >
				</button>
						<input type='hidden' name='cero' value=1 />
			</form>														
			<form name='cero' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;' >
				<button type='submit' title='ACTUALIZAR VISTAS' class='botonazul imgButIco CachedBlack' >
				</button>
						<input type='hidden' name='cero' value=1 />
			</form>
					</th>
					<th>
	<img src='../imgpro/imgpro".$defaults['seccion']."/".$_SESSION['GestMyImg']."' height='120px' width='90px' />
					</th>
				</tr>
				<tr>
					<td style='text-align:right; color:#F1BD2D;' >SELECCIONE IMAGEN</td>
					<td colspan=3>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data' >
		<input size=14 type='file' name='myimg' value='".$defaults['myimg']."' />
					</td>
				</tr>
				<tr align='center'>
					<td colspan=4 style='text-align:right;' >
			<button type='submit' title='MODIFICAR IMAGEN' class='botonverde imgButIco SaveBlack' >
			</button>
				<input type='hidden' name='imagenmodif' value=1 />
	</form>
	<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\" style='display:inline-block;'>
			<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelWhite' >
			</button>
					<input type='hidden' name='oculto2' value=1 />
	</form>
					</td>
				</tr>");

		require '../Inclu/AutoWindowClose.php';
		global $Redir;      print ($Redir);
	
	}	// FIN show_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info_02(){

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- CLIENTE DETALLES ".$ActionTime;

	require 'logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	//require '../Inclu/Inclu_Footer.php';
		
?>