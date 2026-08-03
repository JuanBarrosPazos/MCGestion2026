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

	// CONSULTA LOS DATOS DEL PRODUCTO EN PRODUCTOS
	$SqlSelectProductos =  "SELECT * FROM $Productos WHERE `id` = '$_POST[id]' AND `valor` = '$_POST[valor]' LIMIT 1 ";
	$QrySelectProductos = mysqli_query($db, $SqlSelectProductos );
	global $RowSelectProductos;
	$RowSelectProductos = mysqli_fetch_assoc($QrySelectProductos);

	// SI NO EXISTE EL PRODUCTO EN LA TABLA PRODUCTOS CREA EL PRODUCTO
						
	$SqlSelectProductosFeed =  "SELECT * FROM `$db_name`.$ProductosFeed WHERE $ProductosFeed.`valor` = '$_POST[valor]'";
	$QrySelectProductosFeed = mysqli_query($db, $SqlSelectProductosFeed);
	$CountSelectProductosFeed = mysqli_num_rows($QrySelectProductosFeed);

	global $FBaja;		$FBaja =  date('Y/m/d/H:i:s');

	if($CountSelectProductosFeed == 0){

		$SqlInsertProductosFeed = "INSERT INTO `$db_name`.$ProductosFeed (`vseccion`, `valor`, `nombre`, `ref`, `psiva`, `iva`, `ivae`, `pvp`, `kgin`, `datekgin`, `nsemana`, `kgbad`, `datekgbad`, `kgcash`, `datecash`, `stock`, `myimg1`, `myimg2`, `myimg3`, `myimg4`, `coment`, `borrado`) VALUES ('$RowSelectProductos[vseccion]','$RowSelectProductos[valor]','$RowSelectProductos[nombre]','$RowSelectProductos[ref]','$RowSelectProductos[psiva]','$RowSelectProductos[iva]','$RowSelectProductos[ivae]','$RowSelectProductos[pvp]','$RowSelectProductos[kgin]','$RowSelectProductos[datekgin]','$RowSelectProductos[nsemana]','$RowSelectProductos[kgbad]','$RowSelectProductos[datekgbad]','$RowSelectProductos[kgcash]','$RowSelectProductos[datecash]','$RowSelectProductos[stock]','$RowSelectProductos[myimg1]','$RowSelectProductos[myimg2]','$RowSelectProductos[myimg3]','$RowSelectProductos[myimg4]','$RowSelectProductos[coment]','$FBaja')";		

		if(mysqli_query($db, $SqlInsertProductosFeed)){
			print("SE HA CREADO EL PRODUCTO EN PRODUCTOS FEED ".$_POST['nombre']."</br>");
		}else{ print("* ERROR SQL L.50 ".mysqli_error($db))."</br>"; }

	}elseif($CountSelectProductosFeed > 0){											
											
	// SI EXISTE EL PRODUCTO EN LA TABLA PRODUCTOS MODIFICA LOS DATOS
				
		global $LikeProducto;		$LikeProducto = "LIKE '%".$_POST['valor']."%'";

		$SqlUpdateProductosFeed = "UPDATE `$db_name`.$ProductosFeed SET `vseccion`='$RowSelectProductos[vseccion]',`valor`='$RowSelectProductos[valor]',`nombre`='$RowSelectProductos[nombre]',`ref`='$RowSelectProductos[ref]',`psiva`='$RowSelectProductos[psiva]',`iva`='$RowSelectProductos[iva]',`ivae`='$RowSelectProductos[ivae]',`pvp`='$RowSelectProductos[pvp]',`kgin`='$RowSelectProductos[kgin]',`datekgin`='$RowSelectProductos[datekgin]',`nsemana`='$RowSelectProductos[nsemana]',`kgbad`='$RowSelectProductos[kgbad]',`datekgbad`='$RowSelectProductos[datekgbad]',`kgcash`='$RowSelectProductos[kgcash]',`datecash`='$RowSelectProductos[datecash]',`stock`='$RowSelectProductos[stock]',`myimg1`='$RowSelectProductos[myimg1]',`myimg2`='$RowSelectProductos[myimg2]',`myimg3`='$RowSelectProductos[myimg3]',`myimg4`='$RowSelectProductos[myimg4]',`coment`='$RowSelectProductos[coment]',`borrado`='$FBaja' WHERE $ProductosFeed.`valor` $LikeProducto ";

		if(mysqli_query($db, $SqlUpdateProductosFeed)){ 
			print("SE HA MODIFICADO EN ".$ProductosFeed.": ".$_POST['valor']." / ".$_POST['nombre']."</br>");
		}else{ print("* ERROR SQL L.62 ".mysqli_error($db))."</br>"; }
	}
						
	// BORRA LOS PRODUCTOS DE LA TABLA PRODUCTOS

	global $LikeProducto;		$LikeProducto = "LIKE '%".$_POST['valor']."%'";
			
	$SqlDeleteProducto = "DELETE FROM `$db_name`.$Productos WHERE $Productos.`valor` $LikeProducto LIMIT 1 ";

	if(mysqli_query($db, $SqlDeleteProducto)){
		require 'ProductosBotonera.php';
		require 'ProductosTableResult.php';
		print ($TablaResultBorrar);

    	global $RedirUrl;	$RedirUrl = "ProductosVer.php?seccion=".$_POST['seccion'];
		global $RedirTime;	$RedirTime = 6000;
		require '../Inclu/AutoRedirUrl.php';
		global $Redir;      print ($Redir);

		print("SE HAN BORRADO LOS PRODUCTOS EN ".$Productos." ".$_POST['valor']."</br>");
		
	}else{ print("* ERROR SQL L.73 ".mysqli_error($db))."</br>"; }

}	// FINAL process_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	require 'ProductosArrayTotalVar.php';
	global $ArrayProductosBorrar;			$ArrayProductosBorrar = 1;
	require	'ProductosArrayTotal.php';

	require 'TableValidateErrors.php';

	require 'ProductosBotonera.php';
	global $TitleForm;	$TitleForm = "BORRAR EL PRODUCTO EN ".strtoupper($_POST['seccion'])."";
	global $TrForm;
	$TrForm = "<tr height=40px>
					<td colspan=2 align='right'>
				<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
					<input name='seccion' type='hidden' value='".$_POST['seccion']."' />
					<input name='id' type='hidden' value='".$_POST['id']."' />
					<input type='hidden' name='valor' value='".$defaults['valor']."' />
					<input type='hidden' name='nombre' value='".$defaults['nombre']."' />
					<input type='hidden' name='ref' value='".$defaults['ref']."' />
					<input type='hidden' name='coment' value='".$defaults['coment']."' />
				<button type='submit' title='BORRAR PRODUCTO' class='botonrojo imgButIco DeleteWhite'>
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