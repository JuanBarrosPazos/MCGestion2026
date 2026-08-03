<?php
session_start();

	global $rutaHeader;		$rutaHeader = "";
	require $rutaHeader.'Inclu/Inclu_Header.php'; 
	require '../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Mod_Admin_Plus/Conections/conection.php';
	require '../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
 
	require "Inclu/Only.index.Cliente.php";
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
					
	if(isset($_POST['oculto'])){
		if($form_errors = validate_form()){ 
							suma_denegado ();
							show_form($form_errors);
		}else{ 	admin_entrada();
				suma_acces();
				process_form();
						}
	}elseif((isset($_POST['salir']))||(isset($_GET['salir']))){
													salir();
									 				show_form();
													unset($_SESSION['refcl']);
	}elseif(isset($_SESSION['Nivel'])){
							admin_entrada();
							process_form();
							//ayear();
	}else{ //consulta_tablas();
			suma_visit();	
			show_form();
			unset($_SESSION['refcl']);
		/*
			global $RedirUrl;	$RedirUrl = "../Mod_Admin_Plus/index.php";
			global $RedirTime;	$RedirTime = 10;
			require 'Inclu/AutoRedirUrl.php';
			global $Redir;
			print ($Redir);
		*/
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function consulta_tablas(){

	/* DETECTA LAS TABLAS EN LA BBDD Y RETORNA LOS NOMBRES DE ESTAS MEDIANTE UN WHILE */

	global $db;		global $db_name;

	/* DETECTO LAS TABLAS CON CLAVE EN LA BBDD */
	global $sqltcl;			global $table_name_cl;
	$table_name_cl = $_SESSION['clave']."%";
	$table_name_cl = "LIKE '$table_name_cl'";
	$sqltcl = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $table_name_cl";
	$querycl = mysqli_query($db, $sqltcl);
	$countcl= mysqli_num_rows($querycl);
	global $infoTCalve;
	$infoTClave = "<p>* TABLAS EN BBDD CON CLAVE: ".$_SESSION['clave'].": ".$countcl."</p>";
	echo $infoTClave;
	/* FIN VERIFICO LAS TABLAS CON LA CLAVE EN LA BBDD */

	/* DETECTO LAS TABLAS GASTOS EN LA BBDD */
	global $table_name_gs;
	$table_name_gs = $_SESSION['clave']."gastosshop_%";
	$table_name_gs = "LIKE '$table_name_gs'";
	global $sqltgs;
	$sqltgs = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $table_name_gs";
	echo "<p>* CONSULTA SQL GASTOS:<br>&nbsp;&nbsp;&nbsp;".$sqltgs."</p>";
	$querygs = mysqli_query($db, $sqltgs);
	$countgs= mysqli_num_rows($querygs);
	global $infoTGastos;
	$infoTGastos = "<p>- TABLAS GASTOS EN BBDD: ".$table_name_gs.": ".$countgs."</p>";
	echo $infoTGastos;
	/* FIN VERIFICO LAS TABLAS GASTOS EN LA BBDD */
	/* WHILE PARA RECORRER LAS TABLAS GASTOS CONSULTADAS */
		//$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES ";
		$consulta = "SHOW TABLES FROM $db_name $table_name_gs";
				echo "- CONSULTA SQL GASTOS:<br>&nbsp;&nbsp;&nbsp;".$consulta."<p>";
		$respuesta = mysqli_query($db, $consulta);
		if(!$respuesta){ print("* ERROR L.83 ".mysqli_error($db)."</p>");
		}else{	echo "- WHILE TABLAS GASTOS:<br>";
				global $count;	$count = 1;
			while($fila = mysqli_fetch_row($respuesta)){
					print("&nbsp;&nbsp;&nbsp;* ".$count.": ".$fila[0]."<br>");
	/*
	$sg = "UPDATE `$db_name`.`$fila[0]` SET `refprovee`='xxx', `factnif`='xxx', `factnom`='xxx' WHERE `$fila[0]`.`factnif` LIKE 'xxx' ";
	echo "&nbsp;&nbsp;&nbsp;* ".$count.": ".$sg."<br>";
	*/
				$count ++;
			}// FIN WHILE
		}// FIN ELSE
	/* FIN WHILE PARA RECORRER LAS TABLAS GASTOS */
	
	/* DETECTO LAS TABLAS VENTAS EN LA BBDD */
	global $table_name_vn;
	$table_name_vn = $_SESSION['clave']."ventasshop_%";
	$table_name_vn = "LIKE '$table_name_vn'";
	global $sqltvn;
	$sqltvn = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $table_name_vn";
	echo "<p>* CONSULTA SQL VENTAS:<br>&nbsp;&nbsp;&nbsp;".$sqltvn."</p>";
	$queryvn = mysqli_query($db, $sqltvn);
	$countvn= mysqli_num_rows($queryvn);
	global $infoTVentas;
	$infoTVentas = "<p>- TABLAS VENTAS EN BBDD: ".$table_name_vn.": ".$countvn."</p>";
	echo $infoTVentas;
	/* FIN VERIFICO LAS TABLAS VENTAS EN LA BBDD */
	/* WHILE PARA RECORRER LAS TABLAS GASTOS CONSULTADAS */
		//$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES ";
		$consulta = "SHOW TABLES FROM $db_name $table_name_vn";
				echo "- CONSULTA SQL VENTAS:<br>&nbsp;&nbsp;&nbsp;".$consulta."<p>";
		$respuesta = mysqli_query($db, $consulta);
		if(!$respuesta){ print("* ERROR L.110 ".mysqli_error($db)."</p>");
		}else{	echo "- WHILE TABLAS VENTAS:<br>";
				global $count;	$count = 1;
			while($fila = mysqli_fetch_row($respuesta)) {
					print("&nbsp;&nbsp;&nbsp; *".$count.": ".$fila[0]."<br>");
					$count++;
			}// FIN WHILE
		}// FIN ELSE
	/* FIN WHILE PARA RECORRER LAS TABLAS GASTOS */

}
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function admin_entrada(){

	global $db;			global $db_name;
	global $userid;		global $uservisita;

	$total = $uservisita + 1;
	$datein = date('Y-m-d/H:i:s');

	require "config/TablesNames.php";

	$sqladin = "UPDATE `$db_name`.$ClientesWeb SET `lastin` = '$datein', `visitadmin` = '$total' WHERE $ClientesWeb.`id` = '$userid' LIMIT 1 ";
		
	if(mysqli_query($db, $sqladin)){

	}else{ print("* ERROR L.144 ".mysqli_error($db))."</br>"; }
		
		global $LogText;
		$LogText = "!! INICIO SESION USUARIO: ".$_SESSION['Nombre']." ".$_SESSION['Apellidos']." => ".$datein.PHP_EOL."\t\tREFERENCIA: ".$_SESSION['ref']." NIVEL: ".$_SESSION['Nivel'].PHP_EOL;

		global $KeyLog;		$KeyLog = "index";
		require 'logs/LogInfo.php';

		// PASA LOG AL SISTEMA Mod_Admin SOLO INICIO Y CIERRE DE SESION...
		$ActionTime = date('H:i:s');
		$logdate = date('Y_m_d');
		$LogText = "** ".$ActionTime.PHP_EOL."\t ** ".$LogText.PHP_EOL;
		$filename = "../Mod_Admin_Plus/LogsAcceso/LogsAcceso_".$logdate.".log";
		$log = fopen($filename, 'ab+');
		fwrite($log, $LogText);
		fclose($log);

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_visit(){

	global $rowv;		global $sumavisit;
	
	require "config/TablesNames.php";
	$sqlv =  "SELECT * FROM $VisitasClientesWeb";
	$qv = mysqli_query($db, $sqlv);
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit;		$sumavisit = $tot + 1;

	$idv = 69;

	if(mysqli_query($db, $sqlv)){
		print(" <div style='clear:both'></div>
		 		<table align='center' style='margin-top:0.1em; color: #59746a;'>
					<tr>	
						<td style='text-align:right;'>VISITS:</td>
						<td style='text-align:left;'>".$tot."</td>
					</tr>
					<tr>
						<td style='text-align:right;'>AUTHORIZED:</td>
						<td style='text-align:left;'>".$rowv['acceso']."</td>
					</tr>
					<tr>
						<td style='text-align:right;'>FORBIDDEN:</td>
						<td style='text-align:left;'>".$rowv['deneg']."</td>
					</tr>
				</table>");
	}else{ print("* ERROR L.96".mysqli_error($db)."</br>"); }

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_visit(){

	global $rowv;		global $sumavisit;
	
	require "config/TablesNames.php";
	$sqlv =  "SELECT * FROM $VisitasClientesWeb";
	$qv = mysqli_query($db, $sqlv);
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit; 		$sumavisit = $tot + 1;

	$idv = 69;
	
	require "config/TablesNames.php";

	$sqlv = "UPDATE `$db_name`.$VisitasClientesWeb SET `admin` = '$sumavisit' WHERE $VisitasClientesWeb.`idv` = '$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqlv)){ print(" </br>");
	}else{ print("* ERROR L.151".mysqli_error($db)."</br>"); }

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_acces(){

	global $rowa;		global $sumaacces;
	
	require "config/TablesNames.php";
	$sqla =  "SELECT * FROM $VisitasClientesWeb";
	$qa = mysqli_query($db, $sqla);
	
	$rowa = mysqli_fetch_assoc($qa);
	
	$_SESSION['acceso'] = $rowa['acceso'];
	
	$tota = $rowa['acceso'];

	global $sumaacces;		$sumaacces = $tota + 1;
	
	$idv = 69;
	
	require "config/TablesNames.php";

	$sqla = "UPDATE `$db_name`.$VisitasClientesWeb SET `acceso` = '$sumaacces' WHERE $VisitasClientesWeb.`idv` = '$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqla)){ print ('</br>');
	}else{ print("* ERROR L.182 ".mysqli_error($db)."</br>"); }

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_denegado(){

	global $rowd;		global $sumadeneg;

	require "config/TablesNames.php";
	$sqld =  "SELECT * FROM $VisitasClientesWeb";
	$qd = mysqli_query($db, $sqld);
	$rowd = mysqli_fetch_assoc($qd);
	
	$_SESSION['deneg'] = $rowd['deneg'];
	
	$dng = $rowd['deneg'];
	
	global $sumadeneg; 		$sumadeneg = $dng + 1;
	
	$idd = 69;
	
	require "config/TablesNames.php";

	$sqld = "UPDATE `$db_name`.$VisitasClientesWeb SET `deneg` = '$sumadeneg' WHERE $VisitasClientesWeb.`idv` = '$idd' LIMIT 1 ";

	if(mysqli_query($db, $sqld)){ print("	</br>");
	}else{ print("* ERROR L.212 ".mysqli_error($db)."</br>"); }

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	global $db;			global $sql;		global $q;			global $row;
	
	$errors = array();
	
	if(strlen(trim($_POST['Usuario'])) == 0){ $errors [] = "USUARIO: CAMPO OBLIGATORIO";
	}else{ }
	
	if(strlen(trim($_POST['Password'])) == 0){ $errors [] = "PASSWORD: CAMPO OBLIGATORIO";
	}else{ }
	
	if(trim($_POST['Usuario'] != @$row['Usuario'])){ $errors [] = "NOMBRE O PASWORD INCORRECTO";
	}elseif(trim($_POST['Password'] != @$row['Password'])){ $errors [] = "NOMBRE O PASWORD INCORRECTO";
	}else{ }

	return $errors;

} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
if(($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')){				 
	
	master_index();
								
	global $nombre;			$nombre = $_SESSION['Nombre']; 
	global $apellido;		$apellido = $_SESSION['Apellidos'];
		
	require "config/TablesNames.php";
	
	$SqlSelectClientesWeb =  "SELECT * FROM $ClientesWeb WHERE `Nombre` = '$nombre' AND `Apellidos` = '$apellido' ";
 	
	$qb = mysqli_query($db, $SqlSelectClientesWeb);
	
		global $KeyIndex;	global $KeyBorraUser;
		if(!$qb){ print("* ERROR SQL L.339 ".mysqli_error($db)."</br>");
									show_form();	
		}else{  $KeyIndex = 1; 		$KeyBorraUser = 1;
				//require "AdminClientesWeb/UserWhileTabla.php";
		} // FIN PRIMER ELSE

		global $RedirUrl;	$RedirUrl = "AdminClientesWeb/ClienteVer.php";
		global $RedirTime;	$RedirTime = 10;
		require 'Inclu/AutoRedirUrl.php';
		global $Redir; 		print ($Redir);
		
	}else{ require "Inclu/AccesoDenegado.php"; }
				
}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
	}else{ $defaults = array ('Usuario' => '',
							  'Password' => '');
								   }
	
	if($errors){
		print("	<table align='center' style='color:#F1BD2D;'>
				<tr>
					<th style='text-align:center;'>
						* SOLUCIONE ESTOS ERRORES:<br/>
					</th>
				</tr>
				<tr>
					<td style='text-align:left !important'>");
	
			for($a=0; $c=count($errors), $a<$c; $a++){
				print("<font color='#F1BD2D'>**</font>  ".$errors [$a]."</br>");
			}

			print("</td>
				</tr>
			</table>");
		}
		
	print("<div style='clear:both'></div>
			<table align='center' style=\"margin-top:2px; margin-bottom:8px\" >
				<tr>
					<th colspan=2 style='width:100%; vertical-align:bottom; text-align:right;'>
		<form name='boton' action='AdminClientesWeb/ClavesPerdidas.php' method='post' style='display: inline-block; float:left;' >
			<button type='submit' title='NO RECUERDO MIS CLAVES' class='botonazul imgButIco CandadoBlack'>
			</button>
				<input type='hidden' name='volver' value=1 />
		</form>
		<form name='boton' action='AdminClientesWeb/ClienteCrear.php' method='post' style='display: inline-block;' >
			<button type='submit' title='CREAR NUEVO CLIENTE' class='botonazul imgButIco PersonAddBlack'>
			</button>
				<input type='hidden' name='volver' value=1 />
		</form>
					</th>
				</tr>
				<tr>
					<th colspan=2 style='width:100%; vertical-align:bottom; text-align:center;' >
						DATOS DE ACCESO CLIENTE
					</th>
				</tr>
				<tr>
					<td style='text-align:right;'>USUARIO</td>
					<td>
		<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
			<input type='Password' name='Usuario' size=20 maxlength=50 value='".$defaults['Usuario']."' />
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>PASSWORD</td>
					<td>
			<input type='Password' name='Password' size=20 maxlength=50 value='".$defaults['Password']."' />
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align:right; vertical-align:middle;'>
			<button type='submit' title='ACCEDER' class='botonverde imgButIco CloseSessionBlack' style='vertical-align:top;' ></button>
						<input type='hidden' name='oculto' value=1 />
		</form>	
						<a href='Admin_index.php' style='display:inline-block; float:left;'>
			<button type='button' title='ACCESO ADMINISTRACION SISTEMA' class='botonverde imgButIco InicioBlack' style='vertical-align:top;' ></button>
						</a>
					</td>
				</tr>
			</table>
			<div style='clear:both'></div>");
			show_visit();
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){

		global $rutaindex;          $rutaindex = '';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require 'Inclu_Menu/rutaindex.php';
	
		require 'Inclu_Menu/Master_Index.php';
		
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function salir(){

		unset($_SESSION['id']);				unset($_SESSION['ref']);
		unset($_SESSION['Nivel']);			unset($_SESSION['Nombre']);
		unset($_SESSION['Apellidos']); 		unset($_SESSION['dni']);
		unset($_SESSION['ldni']);			unset($_SESSION['Email']);
		unset($_SESSION['Usuario']);		unset($_SESSION['Password']);
		unset($_SESSION['Direccion']);		unset($_SESSION['Tlf1']);
		unset($_SESSION['Tlf2']);			unset($_SESSION['myimg']);
		unset($_SESSION['lastin']);			unset($_SESSION['lastout']);
		unset($_SESSION['visitadmin']);		unset($_SESSION['GestMyImg']);
		unset($_SESSION['nclient']);

		print("<table align='center' style=\"border:0px\">
				<tr>
					<td align='center' style='color:#F1BD2D;' >HA CERRADO SESION</td>
				</tr>
			</table>");
		
	}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require 'Inclu/Inclu_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>