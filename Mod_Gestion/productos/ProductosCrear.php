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
		if(isset($_POST['oculto'])){
				if($form_errors = validate_form()){
						show_form($form_errors);
				}else{	process_form();
						log_info();
							}
		}else{ show_form(); }

	}else{ require "../Inclu/AccesoDenegado.php"; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
	
		require 'ProductosValidate.php';

		return $errors;

	} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	global $semana;		$semana = date('W');
	global $date;		$date = date('Y-m-d');

	global $ProductoValor;
	$ProductoValor = trim(str_replace(' ', '', $_POST['nombre']));
	$ProductoValor = strtolower($ProductoValor);

	require 'FormatNumber.php';

	/************* CREAMOS EL PRODUCTO EN LA TABLA PRODUCTOS ***************/

	//require 'ProductosCreaImgName.php';
	/*CREAMOS LAS IMAGENES EN LA IMG PRO SECCION */
	require 'ProductosCreaImg.php';
	require '../config/TablesNames.php';
	$sql = "INSERT INTO `$db_name`.$Productos (`vseccion`, `valor`, `nombre`, `ref`, `psiva`, `iva`, `ivae`, `pvp`, `kgin`, `datekgin`, `nsemana`, `kgbad`, `datekgbad`, `kgcash`, `datecash`, `stock`, `myimg1`, `myimg2`, `myimg3`, `myimg4`, `coment`) VALUES ('$_POST[seccion]', '$ProductoValor', '$_POST[nombre]', '$_POST[ref]', '$psiva', '$_POST[iva]', '$ivae', '$pvp', '$kgin',  '$date', '$semana', '$kgbad', '$_POST[datekgbad]', '$kgcash', '$date', '$diferencia', '$new_name1', '$new_name2', '$new_name3', '$new_name4', '$_POST[coment]')";
		
	if(mysqli_query($db, $sql)){ 
		require 'ProductosBotonera.php';
		require 'ProductosTableResult.php';
		print($TablaResultCrear);

    	global $RedirUrl;	$RedirUrl = "ProductosVer.php?seccion=".$_POST['seccion'];
		global $RedirTime;	$RedirTime = 6000;
		require '../Inclu/AutoRedirUrl.php';
		global $Redir;      print ($Redir);

	}else{ 	print("* ERROR SQL L.63 ".mysqli_error($db))."</br>";
			show_form();
	}

	// DATOS LOG...
	global $LogText;
	$LogText = "- PRODUCTO CREADO ".$Productos.".\n\tNAME: ".$_POST['nombre'].".\n\tVALOR: ".$_POST['valor'].".\n\tREFERENCIA: ".$_POST['ref'].".\n\tCOMENTARIOS: ".$_POST['coment'];

	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){

	global $db;		global $db_name;
	require "../config/TablesNames.php";

	require 'FormatNumber.php';

	global $MinDate;		$MinDate = date('Y-m-d');
	global $MaxDate;		$MaxDate = date('Y-').(date('m')+3).date('-d');

	global $semana;			$semana = date('W');		
	global $date;			$date = date('Y-m-d');

	require 'ProductosArrayTotalVar.php';
	global $ArrayProductosCrear;			$ArrayProductosCrear = 1;
	require	'ProductosArrayTotal.php';

	require 'TableValidateErrors.php';

	require 'ProductosBotonera.php';
	print("<table align='center' style='border:0px;margin-top:4px; text-align:center;'>
				<tr>
					<th colspan=2 style='text-align:center;' >".$ProductosBotonera."</th>
				</tr>				
				<tr>
					<th>CREAR PRODUCTO EN LA SECCIÓN ".$defaults['seccion']."</th>
				</tr>		
				<tr>
					<td>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<button type='submit' title='SELECCIONE UNA SECCION' class='botonverde imgButIco BuscaBlack'>
				</button>
					<input type='hidden' name='oculto1' value=1 />
						<select name='seccion' class='botonverde' >");
	/* RECORREMOS LOS VALORES DE LA TABLA SECCIONES PARA CONSTRUIR UN SELECT */	
		$SqlSelectSecciones =  "SELECT * FROM $Secciones ORDER BY `valor` ASC ";
		$QrySelectSecciones = mysqli_query($db, $SqlSelectSecciones);
		if(!$QrySelectSecciones){
				print("* ".mysqli_error($db)."</br>");
		}else{
			while($rows = mysqli_fetch_assoc($QrySelectSecciones)){
				print ("<option value='".$rows['valor']."' ");
					if($rows['valor'] == @$defaults['seccion']){ print ("selected = 'selected'"); }
							print ("> ".$rows['nombre']." </option>");
				}
		}  
		print ("</select>
				</form>	
					</td></tr></table>");
				
	if ((isset($_POST['oculto1']))||(isset($_POST['oculto']))){

		if($_POST['seccion'] == ''){
				print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
							<tr align='center'>
								<td style='color:#F1BD2D;'>
										SELECCIONE UNA SECCIÓN PARA CREAR PRODUCTOS
								</td>
							</tr>
						</table>");
		}elseif($_POST['seccion'] != ''){ require 'ProductosFormCrear.php'; }
	}

	} // FIN function show_form();	

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