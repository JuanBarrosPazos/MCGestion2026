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

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')||($_SESSION['Nivel']=='user')||($_SESSION['Nivel']=='caja')){
				
		//global $nombre;			$nombre = $_POST['Nombre'];
		//global $apellido;		$apellido = $_POST['Apellidos'];
		
		if($_POST['oculto2']){	process_form();
								log_info();
		}else{ }
								
	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	if(isset($_POST['profeedback'])){
		$SqlSelectImg =  "SELECT * FROM `$db_name`.$ProductosFeed WHERE `valor` = '$_POST[valor]'";
	}else{
		$SqlSelectImg =  "SELECT * FROM `$db_name`.$Productos WHERE `valor` = '$_POST[valor]'";
	}
	$QrySelectImg = mysqli_query($db, $SqlSelectImg);
	$RowSelectImg = mysqli_fetch_assoc($QrySelectImg);
	
	print("<table class='detalle' align='center'>
				<tr>
					<th colspan=4 >SECCION ".strtoupper($_POST['seccion']).".
						</br>IMAGENES DEL PRODUCTO ".$_POST['nombre']."
					</th>
				</tr>
		        <tr>
          <td class='img1'>
			<img src='../imgpro/imgpro".$_POST['seccion']."/".$RowSelectImg['myimg1']."'  onclick=\"MM_showHideLayers('contenedor','','show','foto1Ab','','show','foto2Ab','','hide','foto3Ab','','hide','foto4Ab','','hide')\" onload=\"MM_showHideLayers('foto1Ab','','show','foto2Ab','','hide','foto3Ab','','hide','foto4Ab','','hide')\" /> 
		  </td>
		  
          <td class='img1'>
			<img src='../imgpro/imgpro".$_POST['seccion']."/".$RowSelectImg['myimg2']."' onclick=\"MM_showHideLayers('foto1Ab','','hide','foto2Ab','','show','foto3Ab','','hide','foto4Ab','','hide')\" /> 
		  </td>
		  
          <td class='img1'>
			<img src='../imgpro/imgpro".$_POST['seccion']."/".$RowSelectImg['myimg3']."' onclick=\"MM_showHideLayers('foto1Ab','','hide','foto2Ab','','hide','foto3Ab','','show','foto4Ab','','hide')\" /> 
		  </td>
		  
          <td class='img1'>
			<img src='../imgpro/imgpro".$_POST['seccion']."/".$RowSelectImg['myimg4']."' onclick=\"MM_showHideLayers('foto1Ab','','hide','foto2Ab','','hide','foto3Ab','','hide','foto4Ab','','show')\" /> 
		  </td>
       </tr>
       
			<div id='foto1Ab' class='img2'> 
				<img src='../imgpro/imgpro".$_POST['seccion']."/".$RowSelectImg['myimg1']."' /> 
			</div>
			
            <div id='foto2Ab' class='img2'> 
				<img src='../imgpro/imgpro".$_POST['seccion']."/".$RowSelectImg['myimg2']."' /> 
			</div>
			
            <div id='foto3Ab' class='img2'> 
				<img src='../imgpro/imgpro".$_POST['seccion']."/".$RowSelectImg['myimg3']."' /> 
			</div>
			
            <div id='foto4Ab' class='img2'> 
				<img src='../imgpro/imgpro".$_POST['seccion']."/".$RowSelectImg['myimg4']."' /> 
			</div>
		
		<tr>
					<td colspan=4 align='right' >
			<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
				<button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelBlack'>
				</button>
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

	require '../Inclu/AutoWindowClose.php';
	global $Redir;      print ($Redir);

global $LogText;		$LogText = "- IMAGENES PRODUCTO NOMBRE: ".$_POST['nombre'].". SECCION: ".$_POST['seccion'];

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
	
	//require '../Inclu/Inclu_Footer.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>