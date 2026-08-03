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
if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){

	master_index();
	
	if(isset($_POST['oculto2'])){ show_form();
								  log_info();
	}elseif(isset($_POST['oculto'])){  process_form();
									  log_info();
	}else{ show_form(); }

}else{ 	require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	// CONSULTA LOS DATOS DEL PRODUCTO EN PRODUCTOS FEED
	$SqlSelectProductosFeed =  "SELECT * FROM $ProductosFeed WHERE `id` = '$_POST[id]' AND `valor` = '$_POST[valor]' LIMIT 1 ";
	$QrySelectProductosFeed = mysqli_query($db, $SqlSelectProductosFeed );
	global $RowSelectProductosFeed;
	$RowSelectProductosFeed = mysqli_fetch_assoc($QrySelectProductosFeed);

	// SI NO EXISTE EL PRODUCTO EN LA TABLA PRODUCTOS CREA EL PRODUCTO
	$SqlSelectProductos =  "SELECT * FROM `$db_name`.$Productos WHERE $Productos.`valor` = '$_POST[valor]'";
	$QrySelectProductos = mysqli_query($db, $SqlSelectProductos);
	$CountSelectProductos = mysqli_num_rows($QrySelectProductos);

	global $FBaja;		$FBaja =  date('Y/m/d/H:i:s');

	if($CountSelectProductos == 0){

		$SqlInsertProductos = "INSERT INTO `$db_name`.$Productos (`vseccion`, `valor`, `nombre`, `ref`, `psiva`, `iva`, `ivae`, `pvp`, `kgin`, `datekgin`, `nsemana`, `kgbad`, `datekgbad`, `kgcash`, `datecash`, `stock`, `myimg1`, `myimg2`, `myimg3`, `myimg4`, `coment`) VALUES ('$RowSelectProductosFeed[vseccion]','$RowSelectProductosFeed[valor]','$RowSelectProductosFeed[nombre]','$RowSelectProductosFeed[ref]','$RowSelectProductosFeed[psiva]','$RowSelectProductosFeed[iva]','$RowSelectProductosFeed[ivae]','$RowSelectProductosFeed[pvp]','$RowSelectProductosFeed[kgin]','$RowSelectProductosFeed[datekgin]','$RowSelectProductosFeed[nsemana]','$RowSelectProductosFeed[kgbad]','$RowSelectProductosFeed[datekgbad]','$RowSelectProductosFeed[kgcash]','$RowSelectProductosFeed[datecash]','$RowSelectProductosFeed[stock]','$RowSelectProductosFeed[myimg1]','$RowSelectProductosFeed[myimg2]','$RowSelectProductosFeed[myimg3]','$RowSelectProductosFeed[myimg4]','$RowSelectProductosFeed[coment]')";		

		if(mysqli_query($db, $SqlInsertProductos)){
			// BORRA LOS PRODUCTOS DE PRODUCTOS FEED
			global $LikeProducto;		$LikeProducto = "LIKE '%".$_POST['valor']."%'";
			$SqlDeleteProductoFeed = "DELETE FROM `$db_name`.$ProductosFeed WHERE $ProductosFeed.`valor` $LikeProducto LIMIT 1 ";
			if(mysqli_query($db, $SqlDeleteProductoFeed)){
				require 'ProductosBotonera.php';
				global $TitleForm;	$TitleForm = "DATOS DEL PRODUCTO BORRADO";
				global $TrForm;		$TrForm = "";
				require 'ProductosTableFeed.php';
				print ($TableFeed);

				global $RedirUrl;	$RedirUrl = "ProductosFeedbackVer.php?seccion=".$_POST['seccion'];
				global $RedirTime;	$RedirTime = 6000;
				require '../Inclu/AutoRedirUrl.php';
				global $Redir;      print ($Redir);

				print("SE HAN BORRADO LOS PRODUCTOS EN ".$Productos." ".$_POST['valor']."</br>");
			}else{ print("* ERROR SQL L.54 ".mysqli_error($db))."</br>"; }

			print("SE HA CREADO EL PRODUCTO EN PRODUCTOS ".$_POST['nombre']."</br>");
		}else{ 
			print("* ERROR SQL L.49 ".mysqli_error($db))."</br>"; 
		} // FIN ELSE

	}elseif($CountSelectProductos > 0){											
									
		print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
					<tr align='center'>
						<td style='color:#F1BD2D;'>YA EXISTE ESTE PRODUCTO ".$_POST['nombre']." EN ".strtoupper($Productos)."</td>
					</tr>
				</table>");
		show_form();
		
	}else{ }

}	// FINAL process_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	require 'ProductosArrayTotalVar.php';
	global $ArrayProductosRecuperarFeed;	$ArrayProductosRecuperarFeed = 1;
	require	'ProductosArrayTotal.php';

	require 'TableValidateErrors.php';

	require 'ProductosBotonera.php';
	global $TitleForm;	$TitleForm = "RECUPERAR EL PRODUCTO EN ".strtoupper($_POST['seccion'])."";
	global $TrForm;
	$TrForm = "<tr>
					<td colspan=2 align='right'>
				<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
					<input name='seccion' type='hidden' value='".$_POST['seccion']."' />
					<input name='id' type='hidden' value='".$_POST['id']."' />
					<input type='hidden' name='valor' value='".$defaults['valor']."' />
					<input type='hidden' name='nombre' value='".$defaults['nombre']."' />
					<input type='hidden' name='ref' value='".$defaults['ref']."' />
					<input type='hidden' name='borrado' value='".$defaults['borrado']."' />
					<input type='hidden' name='coment' value='".$defaults['coment']."' />
				<button type='submit' title='RECUPERAR PRODUCTO' class='botonazul imgButIco RestoreWhite'>
				</button>
						<input type='hidden' name='oculto' value=1 />
				</form>														
					</td>
				</tr>";
	require 'ProductosTableFeed.php';
	print($TableFeed); 
	
	}	// FIN show_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- PRODUCTOS BORRAR 3: ".$ActionTime.". ".$_POST['seccion'].", ".$_POST['id'].", ".$_POST['nombre'].", ".$_POST['valor'].", ".$_POST['ref'].", ".$_POST['coment'];

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