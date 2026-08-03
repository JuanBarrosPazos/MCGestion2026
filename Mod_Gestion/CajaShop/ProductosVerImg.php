<?php
session_start();

	require '../Inclu/Admin_Inclu_popup.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

?>

<!--	-->

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
if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin') || ($_SESSION['Nivel']=='plus') || ($_SESSION['Nivel']=='user') || ($_SESSION['Nivel']=='caja')||($_SESSION['Nivel']=='cliente')){
				
	//global $nombre;			$nombre = $_POST['Nombre'];
	//global $apellido;		$apellido = $_POST['Apellidos'];
							
	if($_POST['oculto2']){ process_form();} 
	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	
	require "../config/TablesNames.php";
	$sqlc =  "SELECT * FROM `$db_name`.$Productos WHERE `valor` = '$_POST[valor]'";
	//echo "** ".$sqlc."<br>";
	$qc = mysqli_query($db, $sqlc);
	$countc = mysqli_num_rows($qc);
	$rowsc = mysqli_fetch_assoc($qc);
	
	print("<table class='detalle' align='center'>
				<tr>
					<th colspan=4>
							SECCION ".strtoupper($_POST['seccion'])."
							</br> 
							IMAGENES DE ".strtoupper($_POST['valor'])."
					</th>
				</tr>
		        <tr>
		          <td class='img1'>
		<img src='../imgpro/imgpro".$_POST['seccion']."/".$rowsc['myimg1']."'  onclick=\"MM_showHideLayers('contenedor','','show','foto1Ab','','show','foto2Ab','','hide','foto3Ab','','hide','foto4Ab','','hide')\" onload=\"MM_showHideLayers('foto1Ab','','show','foto2Ab','','hide','foto3Ab','','hide','foto4Ab','','hide')\" /> 
				</td>
				
				<td class='img1'>
		<img src='../imgpro/imgpro".$_POST['seccion']."/".$rowsc['myimg2']."' onclick=\"MM_showHideLayers('foto1Ab','','hide','foto2Ab','','show','foto3Ab','','hide','foto4Ab','','hide')\" /> 
				</td>
				
				<td class='img1'>
		<img src='../imgpro/imgpro".$_POST['seccion']."/".$rowsc['myimg3']."' onclick=\"MM_showHideLayers('foto1Ab','','hide','foto2Ab','','hide','foto3Ab','','show','foto4Ab','','hide')\" /> 
				</td>
				
				<td class='img1'>
		<img src='../imgpro/imgpro".$_POST['seccion']."/".$rowsc['myimg4']."' onclick=\"MM_showHideLayers('foto1Ab','','hide','foto2Ab','','hide','foto3Ab','','hide','foto4Ab','','show')\" /> 
				</td>
			</tr>
					<div id='foto1Ab' class='img2'> 
			<img src='../imgpro/imgpro".$_POST['seccion']."/".$rowsc['myimg1']."' /> 
					</div>
					<div id='foto2Ab' class='img2'> 
			<img src='../imgpro/imgpro".$_POST['seccion']."/".$rowsc['myimg2']."' /> 
					</div>
					<div id='foto3Ab' class='img2'> 
			<img src='../imgpro/imgpro".$_POST['seccion']."/".$rowsc['myimg3']."' /> 
					</div>
					<div id='foto4Ab' class='img2'> 
			<img src='../imgpro/imgpro".$_POST['seccion']."/".$rowsc['myimg4']."' /> 
					</div>
				<tr>
							<td colspan=4 align='right' >
			<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
				<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='oculto2' value=1 />
			</form>
							</td>
						</tr>
			</table>
	
		<div style='clear:both'></div>
		<!-- Inicio footer -->
		<div id='footer' style='margin-top:415px'>&copy; Juan Barr&oacute;s Pazos 2012 - 2023.</div>
		<!-- Fin footer -->
		</div>"); 

	}	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	global $db;			global $rowout;
	global $nombre;		global $apellido;	

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- CLIENTE DETALLES ".$ActionTime.". ".$nombre." ".$apellido;

	require 'logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	//require '../Inclu/Inclu_Footer.php';
		
?>