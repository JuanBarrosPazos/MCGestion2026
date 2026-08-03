<?php
session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){

	master_index();

	if(isset($_POST['oculto2'])){ show_form();
								  log_info();
	}elseif(isset($_POST['oculto'])){ process_form();
									  log_info();
	}else{ show_form(); }

}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	// SI NO EXISTE EL PRODUCTO EN LA TABLA PRODUCTOS CREA EL PRODUCTO
	$SqlSelectProductos =  "SELECT * FROM `$db_name`.$Productos WHERE $Productos.`valor` = '$_POST[valor]'";
	$QrySelectProductos = mysqli_query($db, $SqlSelectProductos);
	$CountSelectProductos = mysqli_num_rows($QrySelectProductos);
	$RowSelectProductos = mysqli_fetch_assoc($QrySelectProductos);

	global $DirImg;		$DirImg = "../imgpro/imgpro".$_POST['seccion']."/";
	if($CountSelectProductos > 0){
		// EXISTE EL PRODUCTO EN LA TABLA PRODUCTOS
		print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
					<tr align='center'>
						<td style='color:#F1BD2D;'>YA EXISTE ESTE PRODUCTO ".$_POST['nombre']." EN ".strtoupper($Productos)."</td>
					</tr>
				</table>");
		// SE ELIMINAN LAS IMAGENES EN EL SERVIDOR SI NO COINCIDEN CON TABLA PRODUCTOS
		if(($_POST['myimg1'] != $RowSelectProductos['myimg1'])||($_POST['myimg1'] != $RowSelectProductos['myimg2'])||($_POST['myimg1'] != $RowSelectProductos['myimg3'])||($_POST['myimg1'] != $RowSelectProductos['myimg4'])){ 
			if(file_exists($DirImg.$_POST['myimg1'])){ unlink($DirImg.$_POST['myimg1']); }else{ }
		}else{ }

		if(($_POST['myimg2'] != $RowSelectProductos['myimg1'])||($_POST['myimg2'] != $RowSelectProductos['myimg2'])||($_POST['myimg2'] != $RowSelectProductos['myimg3'])||($_POST['myimg2'] != $RowSelectProductos['myimg4'])){
			if(file_exists($DirImg.$_POST['myimg2'])){ unlink($DirImg.$_POST['myimg2']); }else{ }
		}else{ }

		if(($_POST['myimg3'] != $RowSelectProductos['myimg1'])||($_POST['myimg3'] != $RowSelectProductos['myimg2'])||($_POST['myimg3'] != $RowSelectProductos['myimg3'])||($_POST['myimg3'] != $RowSelectProductos['myimg4'])){ 
			if(file_exists($DirImg.$_POST['myimg3'])){ unlink($DirImg.$_POST['myimg3']); }else{ }
		}else{ }

		if(($_POST['myimg4'] != $RowSelectProductos['myimg1'])||($_POST['myimg4'] != $RowSelectProductos['myimg2'])||($_POST['myimg4'] != $RowSelectProductos['myimg3'])||($_POST['myimg4'] != $RowSelectProductos['myimg4'])){ 
			if(file_exists($DirImg.$_POST['myimg4'])){ unlink($DirImg.$_POST['myimg4']); }else{ }
		}else{ }
	}elseif($CountSelectProductos < 1){
		// NO EXISTE EN LA TABLA PRODUCTOS
		// BORRAMOS LOS ARCHIVOS DE IMAGENES DEL PRODUCTO
		if(file_exists($DirImg.$_POST['myimg1'])){ unlink($DirImg.$_POST['myimg1']); }else{ }
		if(file_exists($DirImg.$_POST['myimg2'])){ unlink($DirImg.$_POST['myimg2']); }else{ }
		if(file_exists($DirImg.$_POST['myimg3'])){ unlink($DirImg.$_POST['myimg3']); }else{ }
		if(file_exists($DirImg.$_POST['myimg4'])){ unlink($DirImg.$_POST['myimg4']); }else{ }
	}else{ }

		// BORRAMOS LOS DATOS EN PRODUCTOS FEED
		$SqlDeleteProductosFeed = "DELETE FROM `$db_name`.$ProductosFeed WHERE $ProductosFeed.`id` = '$_POST[id]' LIMIT 1 ";
		if(mysqli_query($db, $SqlDeleteProductosFeed)){
			
			require 'ProductosBotonera.php';
			global $TitleForm;	$TitleForm = "PRODUCTO ELIMINADO COMPLETAMENTE";
			global $TrForm;		$TrForm = "";
			require 'ProductosTableFeed.php';
			print($TableFeed);
			print("SE HAN BORRADO LOS DATOS EN ".$_POST['seccion']." / ".$_POST['nombre']."</br>");

			global $RedirUrl;	$RedirUrl = "ProductosFeedbackVer.php?seccion=".$_POST['seccion'];
			global $RedirTime;	$RedirTime = 6000;
			require '../Inclu/AutoRedirUrl.php';
			global $Redir;      print ($Redir);
				
		}else{ 	print("* ERROR SQL L.74 ".mysqli_error($db))."</br>";
				show_form();
		}

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
		
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	require 'ProductosArrayTotalVar.php';
	global $ArrayProductosBorrarFeed;		$ArrayProductosBorrarFeed = 1;
	require	'ProductosArrayTotal.php';

	require 'TableValidateErrors.php';

	require 'ProductosBotonera.php';
	global $TitleForm;	$TitleForm = "BORRAR PROCUTO EN FEED ".strtoupper($_POST['seccion'])."";
	global $TrForm;
	$TrForm = "<tr>
					<td colspan=2 style='text-align:right;'>
						<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
							<input name='seccion' type='hidden' value='".$_POST['seccion']."' />
							<input name='id' type='hidden' value='".$_POST['id']."' />
							<input type='hidden' name='valor' value='".$defaults['valor']."' />
							<input type='hidden' name='nombre' value='".$defaults['nombre']."' />
							<input type='hidden' name='ref' value='".$defaults['ref']."' />
							<input type='hidden' name='coment' value='".$defaults['coment']."' />
							<input type='hidden' name='borrado' value='".$defaults['borrado']."' />
							<input type='hidden' name='myimg1' value='".$defaults['myimg1']."' />
							<input type='hidden' name='myimg2' value='".$defaults['myimg2']."' />
							<input type='hidden' name='myimg3' value='".$defaults['myimg3']."' />
							<input type='hidden' name='myimg4' value='".$defaults['myimg4']."' />
			<button type='submit' title='BORRAR FEEDBACK PRODUCTO' class='botonrojo imgButIco DeleteBlack'>
			</button>
								<input type='hidden' name='oculto' value=1 />
						</form>														
					</td>
				</tr>";
	require 'ProductosTableFeed.php';
	print($TableFeed); 
	
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	global $ProductosFeed;

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- PRODUCTOS FEEDBACK BORRAR 3 ".$ActionTime.". ".$ProductosFeed.", ".$_POST['id'].", ".$_POST['nombre'].", ".$_POST['valor'].", ".$_POST['ref'].", ".$_POST['coment'].", ".$_POST['borrado'];

	require 'logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $productos;        $productos = '';
	
		require '../Inclu_Menu/Master_Index.php';
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	require '../Inclu/Inclu_Footer.php';
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>