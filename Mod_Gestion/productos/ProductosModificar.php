<?php
session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require "../config/TablesNames.php";
	$sqld =  "SELECT * FROM $Admin WHERE `id` = '$_POST[id]'";
	$qd = mysqli_query($db, $sqld);
	$rowd = mysqli_fetch_assoc($qd);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){

		master_index();

		if(isset($_POST['oculto2'])){ show_form();
								log_info();
		}elseif(isset($_POST['oculto'])){
				if($form_errors = validate_form()){
						show_form($form_errors);
				}else{ 	process_form();
						log_info();
						}
		}else{ show_form(); }

	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();
	
		if(strlen(trim($_POST['valor2'])) == 0){
			$errors [] = "VALOR <font color='#F1BD2D'>Campo es obligatorio.</font>";
		}elseif (strlen(trim($_POST['valor2'])) < 6){
			$errors [] = "VALOR <font color='#F1BD2D'>Más de 5 carácteres.</font>";
		}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['valor2'])){
			$errors [] = "VALOR <font color='#F1BD2D'>Caracteres no válidos.</font>";
		}elseif (!preg_match('/^[a-z,0-9._]+$/',$_POST['valor2'])){
			$errors [] = "VALOR <font color='#F1BD2D'>Solo minusculas. Se permite . o _ .</font>";
		}else{ }
	
		if(strlen(trim($_POST['nombre'])) == 0){
			$errors [] = "NOMBRE <font color='#F1BD2D'>Campo es obligatorio.</font>";
		}elseif (strlen(trim($_POST['nombre'])) < 5){
			$errors [] = "NOMBRE <font color='#F1BD2D'>Más de 4 carácteres.</font>";
		}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\.\*\']+$/',$_POST['nombre'])){
			$errors [] = "NOMBRE <font color='#F1BD2D'>Caracteres no válidos.</font>";
		}elseif (!preg_match('/^[A-Z,0-9\s]+$/',$_POST['nombre'])){
			$errors [] = "NOMBRE <font color='#F1BD2D'>Solo mayusculas o números sin acentos.</font>";
		}else{ }
	
		if (strlen(trim($_POST['ref'])) > 0){
			if(strlen(trim($_POST['ref'])) < 10){
				$errors [] = "REFERENCIA <font color='#F1BD2D'>Más de 9 carácteres.</font>";
			}elseif(!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\.\*\']+$/',$_POST['ref'])){
			$errors [] = "REFERENCIA  <font color='#F1BD2D'>No valido. Se permite _</font>";
			}elseif (!preg_match('/^[a-z,0-9_\s]+$/',$_POST['ref'])){
			$errors [] = "REFERENCIA  <font color='#F1BD2D'>Solo minusculas. Se permite _ o espacio.</font>";
				}
		}else{ }
		
	return $errors;

	} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){

	global $LogText;
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

/******** MODIFICA VARIABLE, NOMBRE Y COMENTARIOS EN LA TABLA PRODUCTOS *********/

	$sqlc = "UPDATE `$db_name`.$Productos SET `valor` = '$_POST[valor2]', `nombre` = '$_POST[nombre]', `ref` = '$_POST[ref]' WHERE $Productos.`id` = '$_POST[id]' LIMIT 1 ";

	global $Redir;
	if(mysqli_query($db, $sqlc)){

		require 'ProductosBotonera.php';
		require 'ProductosTableResult.php';
		print($TablaResultModif);

		global $RedirUrl;	$RedirUrl = "ProductosVer.php?seccion=".$_POST['seccion'];
		global $RedirTime;	$RedirTime = 6000;
		require '../Inclu/AutoRedirUrl.php';
		global $Redir;      print ($Redir);

	}else{ 	print("* ERROR SQL L.90 ".mysqli_error($db))."<br>";
			show_form ();
	}

/********** MODIFICA LA VARIABLE Y NOMBRE DEL PRODUCTO EN LA TABLA VENTAS ***********/

	/* DETECTO LAS TABLAS VENTAS EN INFORMATION_SCHEMA.TABLES */
		global $table_name_tbventasshop;		
		$table_name_tbventasshop = $_SESSION['clave']."ventasshop_20";
		global $SqlSchema;
		$SqlSchema = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME LIKE '$table_name_tbventasshop%' ";
		echo "** ".$SqlSchema."<br>";
		$QrySchema = mysqli_query($db, $SqlSchema);
		$CountSchema = mysqli_num_rows($QrySchema);

		echo "<p>TABLAS VENTAS SHOP EN BBDD: ".$_SESSION['clave']."ventasshop_ : ".$CountSchema."</p>";

		global $Valor1;		$Valor1 = $_POST['valor1'];
		global $Valor2;		$Valor2 = $_POST['valor2'];

		/* FIN DETECTO LAS TABLAS VENTAS */
		if($CountSchema<1){ 
			echo "<p>NO HAY DATOS EN INFORMATION_SCHEMA.TABLES ".$table_name_tbventasshop."</p>";
			$LogText = $LogText."NO HAY DATOS EN INFORMATION_SCHEMA.TABLES ".$table_name_tbventasshop."\n\t";
		}else{
			global $a; 		$a = 1;
			global $date;	$date = date('y');
			while ($a <= $CountSchema){
				$TableName = $table_name_tbventasshop.$date;
				//echo"<p>TABLA NOMBRE: ".$TableName."</p>";
				$SqlVentasShop =  "SELECT * FROM `$db_name`.$TableName WHERE $TableName.`producto` = '$Valor1' ";
				$QryVentasShop = mysqli_query($db, $SqlVentasShop);
				$RowVentasShop = mysqli_fetch_assoc($QryVentasShop);
				if(mysqli_num_rows($QryVentasShop)>0){
					$LikeValor = "%".$Valor1."%";
					$SqlUpdateVentasShop = "UPDATE `$db_name`.$TableName SET `producto` = '$Valor2', `proname` = '$_POST[nombre]' WHERE $TableName.`producto` LIKE '$LikeValor' ";
					if(mysqli_query($db, $SqlUpdateVentasShop)){ 
						//print("MODIFICADAS VARIABLES EN ".$VentasShop.": ".$_POST['valor1']." POR ".$_POST['valor2']."<br>");
						$LogText = $LogText."* UPDATE ".$VentasShop." ID ".$RowVentasShop['id']." VALORES ".$_POST['valor1']." POR ".$_POST['valor2']."\n\t";
					}else{ 	print("* ERROR SQL L.132 ".mysqli_error($db))."</br>"; 
							$LogText = $LogText."* ERROR SQL L.132 ".mysqli_error($db)."\n\t";
					}

				}else{ echo "<p>NO HAY DATOS ".$Valor1." EN ".$TableName."</p>"; 
					$LogText = $LogText."* NO HAY DATOS ".$Valor1." EN ".$TableName."\n\t";
				}

					$a ++;	$date = $date-1;
			} // FIN WHILE
		} // FIN ELSE

/********** MODIFICA LA VARIABLE Y NOMBRE DEL PRODUCTO EN LA TABLA CAJA	***********/
	
	$cj =  "SELECT * FROM `$db_name`.$CajaShop WHERE $CajaShop.`producto` = '$Valor1'";
	$qcj = mysqli_query($db, $cj);

	if(mysqli_num_rows($qcj)>0){											

		global $LikeValor;		$LikeValor = "%".$Valor1."%";
				
		$SqlUpdateCajaShop = "UPDATE `$db_name`.$CajaShop SET `producto` = '$Valor2', `proname` = '$_POST[nombre]' WHERE $CajaShop.`producto` LIKE '$LikeValor' ";

		if(mysqli_query($db, $SqlUpdateCajaShop)){ 
				print("MODIFICADAS VARIABLES EN ".$CajaShop.": ".$_POST['valor1']." POR L392".$_POST['valor2']."<br>");
		}else{ 	print("* ERROR SQL L.157 ".mysqli_error($db))."</br>"; }
		
	}else{ echo "<p>NO HAY DATOS ".$Valor1." EN ".$CajaShop."</p>"; }

	// DATOS LOG...
	$LogText = "* UPDATE BBDD ".$Productos.".\n\t ID: ".$_POST['id'].".\n\t NOMBRE: ".$_POST['nombre'].".\n\t Pro VALOR OLD: ".$_POST['valor1'].".\n\t VALOR NEW: ".$_POST['valor2'].".\n\t REFERENCIA: ".$_POST['ref']."\n\t".$LogText;

} // FIN FUNCTION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	require 'ProductosArrayTotalVar.php';
	global $ArrayProductosModificar;		$ArrayProductosModificar = 1;
	require	'ProductosArrayTotal.php';

	$SqlSelectSecciones =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[seccion]'";
	$QrySelectSecciones = mysqli_query($db, $SqlSelectSecciones);
	$RowSelectSecciones = mysqli_fetch_assoc($QrySelectSecciones);
	
	require 'ProductosBotonera.php';
	print("<table align='center' style='margin-top:10px;'>
                <tr>
					<th colspan=2 style='text-align:right;' >".$ProductosBotonera."</th>
				<tr>
					<th colspan=2 >MODIFICAR PRODUCTO EN ".$RowSelectSecciones['nombre']."</th>
				</tr>
				<tr>
					<td style='text-align:right;'>ID</td>
					<td>".$_POST['id']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>VALOR</td>
					<td>".$defaults['valor1']."
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NUEVO VALOR</td>
					<td>
		<form name='oculto' method='post' action='$_SERVER[PHP_SELF]'>
			<input type='hidden' name='seccion' value='".$_POST['seccion']."' />
			<input type='hidden' name='id' value='".$_POST['id']."' />
			<input type='hidden' name='valor1' value='".$defaults['valor1']."' />
			<input type='text' name='valor2' size=16 maxlength=14 value='".$defaults['valor2']."' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NOMBRE</td>
					<td>
			<input type='text' name='nombre' size=25 maxlength=23 value='".$defaults['nombre']."' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>REFERENCIA</td>
					<td>
			<input type='text' name='ref' size=16 maxlength=14 value='".$defaults['ref']."' />
					</td>
				</tr>
				<tr>
					<td colspan=2 style='text-align:right;'>
				<button type='submit' title='MODIFICAR DATOS' class='botonverde imgButIco SaveBlack'>
				</button>
			<input type='hidden' name='oculto' value=1 />
		</form>														
					</td>
				</tr>
			</table>");

	global $LogText;
	$LogText = "- PRODUCTOS MODIFICA 2 ".$Productos.".\n\t ID: ".$_POST['id'].".\n\t Pro Name: ".$_POST['nombre'].".\n\t Pro Valor: ".$_POST['valor'].".\n\t Pro Ref: ".$_POST['ref'].".\n\t Coment: ".$_POST['coment'];
	
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