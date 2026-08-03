<?php
session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

	require "../config/TablesNames.php";

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){

	 master_index();
		if(isset($_POST['oculto'])){
				if($form_errors = validate_form()){
									show_form($form_errors);
						}else{	process_form();
								log_info();
									}
			} else { show_form(); }

	} else { require "../Inclu/AccesoDenegado.php";	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
		
		global $db;		global $db_name;
		global $SeccionNombre; 
			$SeccionNombre = trim(str_replace(' ', '', $_POST['nombre']));
			$SeccionNombre = strtoupper(trim($SeccionNombre));
		global $SeccionValor; 
			$SeccionValor = trim(str_replace(' ', '', $_POST['nombre']));
			$SeccionValor = strtolower(trim($SeccionValor));

		require "../config/TablesNames.php";
		$SqlSelectSecciones =  "SELECT * FROM $Secciones WHERE `valor` = '$SeccionValor' OR `nombre` = '$SeccionNombre' ";
		//echo "** ".$SqlSelectSecciones."<br>";
		global $QrySelectSecciones;		$QrySelectSecciones = mysqli_query($db, $SqlSelectSecciones);
		//$RowSelectSecciones = mysqli_fetch_assoc($QrySelectSecciones);
		global $QrySelectSecciones2;	$QrySelectSecciones2 = 0;
		
		require 'SeccionesValidate.php';

		return $errors;

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){

	global $SeccionNombre;		global $SeccionValor; 

	global $db;		global $db_name;
	require "../config/TablesNames.php";
	$SqlInsertSecciones = "INSERT INTO `$db_name`.$Secciones (`valor`, `nombre`) VALUES ('$SeccionValor', '$SeccionNombre')";
		
    global $LogText;	global $Title;
    if(mysqli_query($db, $SqlInsertSecciones)){
		
		global $carpeta;    $carpeta = "../imgpro/imgpro".$SeccionValor;
		if (!file_exists($carpeta)) {
				mkdir($carpeta, 0777, true);
				$LogText = $LogText."* HA CREADO EL DIRECTORIO ".$carpeta."/ \n\t";
				copy("../imgpro/untitled.png", $carpeta."/untitled.png");
		}else{ print("* NO HA CREADO EL DIRECTORIO ".$carpeta."<br>");
				$LogText = $LogText."* NO HA CREADO EL DIRECTORIO ".$carpeta."/ \n\t";
		}
		
		$Title = "CREADA UNA NUEVA SECCIÓN";
		require 'SeccionesTablaResult.php';
		print($TablaResultados);

		global $RedirUrl;	$RedirUrl = "SeccionesVer.php";
		global $RedirTime;	$RedirTime = 6000;
		require '../Inclu/AutoRedirUrl.php';
		global $Redir;      print ($Redir);

		$LogText = $LogText."* HA CREADO LA SECCION ".$_POST['nombre']." / ".$_POST['valor']."\n\t";

	}else{  print("* ERROR SQL L.87 ".mysqli_error($db))."</br>";
			$LogText = $LogText."*ERROR SQL L.87: ".mysqli_error($db)."\n\t";	
				}

	$LogText = "* SECCION CREARDA ".$SeccionNombre." VALOR: ".$SeccionValor."\n\t".$LogText;
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	require 'TableValidateErrors.php';

	require 'SeccionesArrayTotalVar.php';
	global $ArraySeccionCrear;				$ArraySeccionCrear = 1;
	require 'SeccionesArrayTotal.php';
	
	print("<table align='center' style=\"margin-top:10px\">
			<tr>
				<th colspan=2 style='text-align:right;'>
					<form name='crear' action='SeccionesVer.php' method='POST'>
			<button type='submit' title='CANCELAR Y VOLVER' class='botonrojo imgButIco CancelBlack'></button>
						<input type='hidden' name='oculto2' value=1 />
					</form>
				</th>
			</tr>				
			<tr>
				<th colspan=2 >CREAR NUEVA SECCI&Oacute;N</th>
			</tr>
			<tr>
				<td style='text-align:right;'>	
					NOMBRE <font color='#F1BD2D'>*</font>
				</td>
				<td>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data'>
			<input type='hidden' name='valor' value='".$defaults['valor']."' />
			<input type='text' name='nombre' size=23 maxlength=22 value='".$defaults['nombre']."' pattern='[a-zA-Z]{4,22}' placeholder='MINIMO 4 CARACTERES' required />
				</td>
			</tr>
			<tr>
				<td colspan='2' style='text-align:center;'>
			<button type='submit' title='CREAR SECCION' class='botonverde imgButIco SaveBlack'></button>
					<input type='hidden' name='oculto' value=1 />
		</form>														
				</td>
			</tr>
			</table>"); 
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $Secciones;        $Secciones = '';
		
		require '../Inclu_Menu/Master_Index.php';
		
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
	
	require '../Inclu/Inclu_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>