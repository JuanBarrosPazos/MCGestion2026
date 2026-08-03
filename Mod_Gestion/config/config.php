<?php

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';

	if($_POST['config']){
							
		if($form_errors = validate_form()){ show_form($form_errors); } 
		else {	process_form();
				require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
				require '../../Mod_Admin_Plus/Conections/conection.php';
				$db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
		
				
			if (!$db){ 	global $dbconecterror;
						$dbconecterror = $dbname." * ".mysqli_connect_error()."\n"; 
						print ("NO CONECTA A BBDD ".$db_name."</br>".mysqli_connect_error());
						show_form();
						
						} elseif($db) { config_one();
								 		crear_tablas();
								 		ayear();
										}
				}
							
	} else {show_form();}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function config_one(){
	
	if(file_exists('year.txt')){unlink("year.txt");
					$data1 = "\n \t UNLINK year.txt";}
			else {print("ERROR UNLINK year.txt </br>");
					$data1 = "\n \t ERROR UNLINK year.txt";}


	if(file_exists('ayear.php')){unlink("ayear.php");
					$data2 = "\n \t UNLINK ayear.php";}
			else {print("ERROR UNLINK ayear.php </br>");
					$data2 = "\n \t ERROR UNLINK ayear.php";}

	if(!file_exists('year.txt')){
			if(file_exists('year_Init_System.txt')){
				copy("year_Init_System.txt", "year.txt");
				$data3 = "\n \t RENAME year_Init_System.txt TO year.txt";
			} else {print("ERROR RENAME year_Init_System.txt TO year.txt </br>");
				$data3 = "\n \t ERROR RENAME year_Init_System.txt TO year.txt";}
			}

	if(!file_exists('ayear.php')){
			if(file_exists('ayear_Init_System.php')){
				copy("ayear_Init_System.php", "ayear.php");
				$data4 = "\n \t RENAME ayear_Init_System.php TO ayear.php";
			} else {print("ERROR RENAME ayear_Init_System.php TO ayear.php </br>");
				$data4 = "\n \t ERROR RENAME ayear_Init_System.php TO ayear.php";}
			}
	
	global $cfone;
	$cfone ="\n SUSTITUCION DE ARCHIVOS:".$data1.$data2.$data3.$data4;

	}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function validate_form(){
	
	
	if(strlen(trim($_POST['host'])) == 0){
		$errors [] = "HOST: <font color='#F1BD2D'> es obligatorio.</font>";
		}
	
	elseif (strlen(trim($_POST['host'])) < 4){
		$errors [] = "HOST: <font color='#F1BD2D'>Más de 3 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\*]+$/',$_POST['host'])){
		$errors [] = "HOST: <font color='#F1BD2D'>caracteres no validos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z 0-9 \.]+$/',$_POST['host'])){
		$errors [] = "HOST: <font color='#F1BD2D'>NO VALIDOS</font>";
		}

	
	if(strlen(trim($_POST['user'])) == 0){
		$errors [] = "USER: <font color='#F1BD2D'> es obligatorio.</font>";
		}
	
	elseif (strlen(trim($_POST['user'])) < 4){
		$errors [] = "USER: <font color='#F1BD2D'>Más de 3 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\*]+$/',$_POST['user'])){
		$errors [] = "USER: <font color='#F1BD2D'>caracteres no validos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z 0-9 \.]+$/',$_POST['user'])){
		$errors [] = "USER: <font color='#F1BD2D'>NO VALIDOS</font>";
		}

	
	if(strlen(trim($_POST['pass'])) == 0){
		$errors [] = "PASS: <font color='#F1BD2D'> es obligatorio.</font>";
		}
	
	elseif (strlen(trim($_POST['pass'])) < 4){
		$errors [] = "PASS: <font color='#F1BD2D'>Más de 3 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\*]+$/',$_POST['pass'])){
		$errors [] = "PASS: <font color='#F1BD2D'>caracteres no validos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z 0-9 \.]+$/',$_POST['pass'])){
		$errors [] = "PASS: <font color='#F1BD2D'>NO VALIDOS</font>";
		}

	
	if(strlen(trim($_POST['name'])) == 0){
		$errors [] = "NAME: <font color='#F1BD2D'> es obligatorio.</font>";
		}
	
	elseif (strlen(trim($_POST['name'])) < 4){
		$errors [] = "NAME: <font color='#F1BD2D'>Más de 3 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\*]+$/',$_POST['name'])){
		$errors [] = "NAME: <font color='#F1BD2D'>caracteres no validos.</font>";
		}
		
	elseif (!preg_match('/^[a-z A-Z 0-9 \.]+$/',$_POST['name'])){
		$errors [] = "NAME: <font color='#F1BD2D'>NO VALIDOS</font>";
		}

			return $errors;

		} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function process_form(){
	
	/************** CREAMOS EL ARCHIVO DE CONFIGURACIÓN **************/

	$host = "'".$_POST['host']."'";
	$user = "'".$_POST['user']."'";
	$pass = "'".$_POST['pass']."'";
	$name = "'".$_POST['name']."'";

	$bddata = '<?php
				$db_host = '.$host.'; 
				$db_user = '.$user.'; 
				$db_pass = '.$pass.'; 
				$db_name = '.$name.'; 
				?>';
	
	$filename = "../../Mod_Admin_Plus/Conections/conection.php";
	$config = fopen($filename, 'w+');
	fwrite($config, $bddata);
	fclose($config);
	
		print("	<table align='center'>
		
					<tr>
						<td colspan='2' align='center'>
								SE HA CREADO EL ARCHIVO DE CONEXIONES.
							</br>
								CON LAS SIGUIENTES VARIABLES.
						</td>
					</tr>
					<tr>
						<td>
								VARIABLE HOST ADRESS
						</td>
						<td>
								\$db_host = ".$host."; \n
						</td>		
					</tr>								

					<tr>
						<td>
								VARIABLE USER NAME
						</td>
						<td>
								\$db_user = ".$user."; \n
						</td>		
					</tr>	
												
					<tr>
						<td>
								VARIABLE PASSWORD
						</td>
						<td>
								\$db_pass = ".$pass."; \n
						</td>		
					</tr>	
												
					<tr>
						<td>
								VARIABLE BBDD NAME
						</td>
						<td>
								\$db_name = ".$name."; \n
						</td>		
					</tr>
													
				</table>
				
							");
							
			}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	
	function crear_tablas(){
	
	global $ruta0; $ruta0 = "";
	require "crearTablas.php";
	require "../AppsConect/CreaTablasModGestion.php";
					
// CREA EL DIRECTORIO DE IMAGENES.

	$vname2 = "docgastos_".date('Y');
	$carpeta = "../gastos/".$vname2;
	if (!file_exists($carpeta)) {
		mkdir($carpeta, 0777, true);
		copy("../gastos/untitled.png", $carpeta."/untitled.png");
		copy("../gastos/pdf.png", $carpeta."/pdf.png");}
		else{die("* NO HA CREADO EL DIRECTORIO ".$carpeta."\n");}
	
	$vname3 = "docgastos_".(date('Y')-1);
	$carpeta3 = "../gastos/".$vname3;
	if (!file_exists($carpeta3)) {
		mkdir($carpeta3, 0777, true);
		copy("../gastos/untitled.png", $carpeta3."/untitled.png");
		copy("../gastos/pdf.png", $carpeta3."/pdf.png");}
		else{die("* NO HA CREADO EL DIRECTORIO ".$carpeta3."\n");}
	
	/************	PASAMOS LOS PARAMETROS A .LOG	*****************/
	
global $cfone;				global $LogText;				global $LogText2;
$datein = date('Y-m-d/H:i:s');
$logdate = date('Y_m_d');
$LogText = $cfone."\n - CONFIG INIT ".$datein.".\n * ".$db_name.". \n * ".$db_host.". \n * ".$db_user.". \n * ".$db_pass."\n".$dbconecterror.$LogText.$LogText2."\n";
$filename = "../logs/Config/".$logdate."_CONFIG_INIT.log";
$log = fopen($filename, 'ab+');
fwrite($log, $LogText);
fclose($log);

	}	

///////////////////////

function modif(){
									   							
	$filename = "ayear.php";
	$fw1 = fopen($filename, 'r+');
	$contenido = fread($fw1,filesize($filename));
	fclose($fw1);
	
	$contenido = explode("\n",$contenido);
	$contenido[2] = "'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',\n'".(date('y')-1)."' => '".(date('Y')-1)."',";
	$contenido = implode("\n",$contenido);
	
	//fseek($fw, 37);
	$fw = fopen($filename, 'w+');
	fwrite($fw, $contenido);
	fclose($fw);
}

function modif2(){

	$filename = "year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);
}

function ayear(){
	$filename = "year.txt";
	$fw2 = fopen($filename, 'r+');
	$fget = fgets($fw2);
	fclose($fw2);
	
	if($fget == date('Y')){}
	elseif($fget != date('Y')){ modif();
								modif2();
	}

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function show_form($errors=[]){
	
	/* Se pasan los valores por defecto y se devuelven los que ha escrito el usuario. */
	
	if($_POST['config']){
		$defaults = $_POST;
		} else {
				$defaults = array ( 'host' => '',
									'user' => '',
									'pass' => '',
									'name' => '',
														);
								   }
	
	if ($errors){
		print("<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font></br>");
		
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#F1BD2D'>**</font>  ".$errors [$a]."</br>");
			}
		}
		
	print("
	
			<table align='center' style=\"margin-top:10px\">
					<tr>
					<td style='color:red' align='center'>
					
					INTRODUZCA LOS DATOS DE CONEXI&Oacute;N A LA BBDD.
							</br>
				SE CREAR&Aacute; EL ARCHIVO DE CONEXI&Oacute;N Y LAS TABLAS DE CONFIGURACI&Oacute;N.
					</td>
				</tr>
			</table>
			
			<table align='center' style=\"margin-top:10px\">

				<tr>
					<th colspan=2 class='BorderInf'>

							INIT CONFIG DATA
					</th>
				</tr>
				
<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data'>
						
				<tr>
					<td width=200px>	
						<font color='#F1BD2D'>*</font>
						DB HOST ADRESS
					</td>
					<td width=200px>
		<input type='text' name='host' size=25 maxlength=22 value='".$defaults['host']."' />
					</td>
				</tr>
					
				<tr>
					<td width=200px>	
						<font color='#F1BD2D'>*</font>
						DB USER NAME
					</td>
					<td width=200px>
		<input type='text' name='user' size=25 maxlength=22 value='".$defaults['user']."' />
					</td>
				</tr>
					
				<tr>
					<td width=200px>	
						<font color='#F1BD2D'>*</font>
						DB PASSWORD
					</td>
					<td width=200px>
		<input type='text' name='pass' size=25 maxlength=22 value='".$defaults['pass']."' />
					</td>
				</tr>
				
				<tr>
					<td width=200px>	
						<font color='#F1BD2D'>*</font>
						DB NAME
					</td>
					<td width=200px>
		<input type='text' name='name' size=25 maxlength=22 value='".$defaults['name']."' />
					</td>
				</tr>
					
				<tr>
					<td align='right' valign='middle'  class='BorderSup' colspan='2'>
						<input type='submit' value='INIT CONFIG' />
						<input type='hidden' name='config' value=1 />
						
					</td>
					
				</tr>
				
		</form>														
			</table>"); 
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
///

	require '../Inclu/Inclu_Footer.php';

?>