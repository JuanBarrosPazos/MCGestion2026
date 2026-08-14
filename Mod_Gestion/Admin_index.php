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
	if(!isset($_SESSION['Nivel'])&&(@$_SESSION['Nivel'] != 'wmaster')){
		require "Inclu/Only.index.php";
	}else{ }

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
					ayear();
								}
		}elseif(isset($_POST['salir'])){ salir();
										 show_form();
		}elseif(isset($_SESSION['Nivel'])){
								admin_entrada();
								process_form();
								ayear();
		}else{ 	suma_visit();	
				//show_form();
				global $RedirUrl;	$RedirUrl = "../Mod_Admin_Plus/index.php";
				global $RedirTime;	$RedirTime = 10;
				require 'Inclu/AutoRedirUrl.php';
				global $Redir;
				print ($Redir);
			}
												
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function modif(){
		
	$filename = "config/ayear.php";
	$fw1 = fopen($filename, 'r+');
	$contenido = fread($fw1,filesize($filename));
	fclose($fw1);
	
	$contenido = explode("\n",$contenido);
	$contenido[2] = "'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',";
	$contenido = implode("\n",$contenido);
	
	$fw = fopen($filename, 'w+');
	fwrite($fw, $contenido);
	fclose($fw);

	global $LogText;
	$LogText = "\nMODIFICADO ARRAY ANUAL config/ayear.php";
	log_info();
}

function modif2(){

	$filename = "config/year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);

	global $LogText;
	$LogText = "\nMODIFICADO ARCHIVO ANUAL config/year.txt";
	log_info();
}


function tventas(){
	
	global $db;		global $db_name;
	$vname = $_SESSION['clave']."ventasshop_".date('Y');
	$vname = "`".$vname."`";
	
	$tv = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname (
  `id` int(4) NOT NULL auto_increment,
  `ini` varchar(3) collate utf8_spanish2_ci NOT NULL,
  `cname` varchar(52) collate utf8_spanish2_ci NOT NULL,
  `refcaja` varchar(20) collate utf8_spanish2_ci NOT NULL,
  `clname` varchar(52) collate utf8_spanish2_ci NOT NULL,
  `refclient` varchar(20) collate utf8_spanish2_ci NOT NULL,
  `oper` varchar(20) collate utf8_spanish2_ci NOT NULL,
  `nsemana` int(2) NOT NULL,
  `datecash` varchar(20) collate utf8_spanish2_ci NOT NULL,
  `vseccion` varchar(22) collate utf8_spanish2_ci NOT NULL,
  `producto` varchar(20) collate utf8_spanish2_ci,
  `proname` varchar(24) collate utf8_spanish2_ci NOT NULL,
  `kgcash` decimal(7,2) unsigned NOT NULL,
  `psiva` decimal(7,2) unsigned NOT NULL,
  `iva` int(2) NOT NULL,
  `ivae` decimal(7,2) unsigned NOT NULL,
  `pvp` decimal(7,2) unsigned NOT NULL,
  `pvptot` decimal(10,2) unsigned NOT NULL,
  `pago` varchar(20) collate utf8_spanish2_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ";
		
	global $LogText;
	if(mysqli_query($db, $tv)){
		$LogText = "\nCREADA LA TABLA ".$vname;
	} else {
		print( "* NO OK TABLA VENTAS. ".mysqli_error($db)."\n");
		$LogText = "\nNO CREADA LA TABLA ".$vname;
	}
		log_info();
}
	
function ayear(){

	global $LogText; 		$LogText = "EJECUTADA FUNCIÓN ayear()\n\t";
	
	$filename = "config/year.txt";
	$fw2 = fopen($filename, 'r+');
	$fget = fgets($fw2);
	fclose($fw2);
	
	if($fget == date('Y')){
		//print("EL AÑO ES EL MISMO ".date('Y')." == ".$fget);
		//$LogText = $LogText."EL AÑO ES EL MISMO ".date('Y')." == ".$fget;
	}elseif($fget != date('Y')){ 
		modif();
		modif2();
		tventas();
		print("EL AÑO HA CAMBIADO ".date('Y')." != ".$fget);
		$LogText = $LogText."EL AÑO HA CAMBIADO ".date('Y')." != ".$fget;
	}

	log_info();

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function admin_entrada(){

	global $db;			global $db_name;		global $userid;		global $uservisita;

	$total = $uservisita + 1;
	$datein = date('Y-m-d/H:i:s');

	$datein = date('Y-m-d/H:i:s');

	require "config/TablesNames.php";

	$sqladin = "UPDATE `$db_name`.$Admin SET `lastin` = '$datein', `visitadmin` = '$total' WHERE $Admin .`id` = '$userid' LIMIT 1 ";
		
	if(mysqli_query($db, $sqladin)){ }else{ print("* ERROR SQL L.192 ".mysqli_error($db))."</br>"; }

	global $LogText;
	$LogText = "\n** ACCESO ADMINISTRADOR => .".$datein.".\n \t USER REF: ".$_SESSION['ref']."\n\tUSER NAME: ".$_SESSION['Nombre']." ".$_SESSION['Apellidos']."\n";

	log_info();

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

	global $db, $db_name;
	global $sumavisit;
	
	require "config/TablesNames.php";
	
	$sqlv =  "SELECT * FROM $VisitasAdmin ";
	$qv = mysqli_query($db, $sqlv);
	
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit;
	$sumavisit = $tot + 1;

	$idv = 69;
	
	if(mysqli_query($db, $sqlv)){ 
				print("<div style='clear:both'></div>
						<table align='right' style='margin-top:0px'>
							<tr>	
								<td align='right'><font color='#59746A'>VISITAS:</font>	</td>
								<td  align='right'><font color='#59746A'>".$tot."</font></td>
							</tr>
							<tr>
								<td align='right'><font color='#59746A'>ACCESOS PERMITIDOS:</font></td>
								<td align='right'><font color='#59746A'>".$rowv['acceso']."</font></td>
							</tr>
							<tr>
								<td align='right'><font color='#59746A'>ACCESOS DENEGADOS:</font></td>
								<td align='right'><font color='#59746A'>".$rowv['deneg']."</font></td>
							</tr>
						</table>
						</br>");
		} else { print("<font color='#F1BD2D'>* Error: </font></br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db)."</br>");
					}

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_visit(){

	global $db, $db_name;
	global $sumavisit;
	
	require "config/TablesNames.php";

	$sqlv =  "SELECT * FROM $VisitasAdmin";
	$qv = mysqli_query($db, $sqlv);
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit;
	$sumavisit = $tot + 1;

	$idv = 69;
	
	$sqlv = "UPDATE `$db_name`.$VisitasAdmin SET `admin` = '$sumavisit' WHERE $VisitasAdmin.`idv` = '$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqlv)){ print(" </br>");
			} else { print("<font color='#F1BD2D'>* Error: </font></br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db)."</br>");
						}
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_acces(){

	global $db, $db_name;
	global $sumaacces;
	
	require "config/TablesNames.php";

	$sqla =  "SELECT * FROM $VisitasAdmin";
	$qa = mysqli_query($db, $sqla);
	$rowa = mysqli_fetch_assoc($qa);
	
	$_SESSION['acceso'] = $rowa['acceso'];
	
	$tota = $rowa['acceso'];

	global $sumaacces;	$sumaacces = $tota + 1;

	$idv = 69;
	
	$sqla = "UPDATE `$db_name`.$VisitasAdmin SET `acceso` = '$sumaacces' WHERE $VisitasAdmin.`idv` = '$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqla)){ print ('</br>');
			} else { print("<font color='#F1BD2D'>* Error: </font></br>
							&nbsp;&nbsp;&nbsp;".mysqli_error($db)."</br>");
						}

		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_denegado(){

	global $db, $db_name;
	global $sumadeneg;
	
	require "config/TablesNames.php";

	$sqld =  "SELECT * FROM $VisitasAdmin";
	$qd = mysqli_query($db, $sqld);
	$rowd = mysqli_fetch_assoc($qd);
	
	$_SESSION['deneg'] = $rowd['deneg'];
	
	$dng = $rowd['deneg'];
	
	global $sumadeneg;
	$sumadeneg = $dng + 1;

	$idd = 69;
	
	$sqld = "UPDATE `$db_name`.$VisitasAdmin SET `deneg` = '$sumadeneg' WHERE $VisitasAdmin.`idv` = '$idd' LIMIT 1 ";

	if(mysqli_query($db, $sqld)){ print("	</br>");
			} else { print("<font color='#F1BD2D'>* Error: </font></br>
							&nbsp;&nbsp;&nbsp;".mysqli_error($db)."</br>");
				}
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	global $db, $sql;
	global $q;
	global $row;
	
	$errors = array();
	
	if (strlen(trim($_POST['Usuario'])) == 0){
		$errors [] = "Usuario: Campo obligatorio.";
		}
	
	if (strlen(trim($_POST['Password'])) == 0){
		$errors [] = "Password: Campo Obligatorio:";
		}
		
	if(trim($_POST['Usuario'] != @$row['Usuario'])){
		$errors [] = "Nombre o Password incorrecto.";
		}
	
	elseif(trim($_POST['Password'] != @$row['Password'])){
		$errors [] = "Nombre o Password incorrecto.";
		}

	return $errors;

		}
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;
					
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin') || ($_SESSION['Nivel']=='plus') || ($_SESSION['Nivel']=='user') || ($_SESSION['Nivel']=='caja')){				 
		global $rutaindex;		$rutaindex = "../Mod_Admin_Plus/";
			master_index();
			recup_compra();
			// DATOS LOG...
			global $LogText;	$LogText = "ACCESO A ADMIN INDEX MCGESTION...";
			log_info();			
	}else{ require "../Inclu/AccesoDenegado.php"; }
		
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
		} else {
				$defaults = array ('Usuario' => '',
								   'Password' => '');
								   }
	
	if ($errors){
		print("<font color='#F1BD2D'>Solucione estos errores:</font></br>");
		
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#F1BD2D'>* Campo </font>".$errors [$a]."</br>");
			}
		}
	show_visit();
	print("<div style='clear:both'></div>
			<table align='center' style=\"margin-top:2px; margin-bottom:8px\" >
				<tr>
					<th colspan=2 width=100% valign=\"bottom\" class='BorderInf'>
						SUS DATOS DE ACCESO
					</th>
				</tr>
				<tr>
					<td>USUARIO</td>
					<td>
		<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
			<input type='Password' name='Usuario' size=20 maxlength=50 value='".$defaults['Usuario']."' />
					</td>
				</tr>
				<tr>
					<td>PASSWORD</td>
					<td>
			<input type='Password' name='Password' size=20 maxlength=50 value='".$defaults['Password']."' />
					</td>
				</tr>
				<tr>
					<td valign='middle' align='right' colspan='2'>
						<input type='submit' value='ACCEDER' />
						<input type='hidden' name='oculto' value=1 />
					</td>
				</tr>
		</form>	
			</table>"); 
	
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function recup_compra(){
	
	global $db;			global $db_name;
	require "config/TablesNames.php";

	unset($_SESSION['oper']);

	$SqlCajaShopIni0 = "SELECT * FROM $CajaShop WHERE `ini` > '0' ";
	$QrySqlCajaShopIni0 = mysqli_query($db, $SqlCajaShopIni0);
	$CountSqlCajaShopIni0 = mysqli_num_rows($QrySqlCajaShopIni0);
		
	if($CountSqlCajaShopIni0 < 1){
			print("<div align='center' style='margin-bottom:8.0em;margin-top:8.0em'>
				<form name='init_compra' method='post' action='CajaShop/caja_00.php' style='display:block;'>
			<button type='submit' title='CREAR NUEVA COMPRA' class='botonazul imgButIco InicioBlack'></button>
						<input type='hidden' name='init_compra' value=1 />
				</form>						
						NO HAY COMPRAS PENDIENTES
					</div>");
	}else{	print ("<table align='center'>
						<tr style='font-size:14px'>
							<th colspan=6 class='BorderInf'>SESIONES DE COMPRAS</th>
						</tr>
						<tr style='font-size:12px'>
							<th class='BorderInfDch'>CAJERO</th>
							<th class='BorderInfDch ocultatd440'>REF CAJA</th>
							<th class='BorderInfDch'>OPER SESION</th>		
							<th class='BorderInfDch ocultatd440'>FECHA</th>
							<th class='BorderInfDch'>CLIENTE</th>										
							<th class='BorderInf'></th>
						</tr>");
									
	global $ClientRef;
	while($RowCajaShopIni0 = mysqli_fetch_assoc($QrySqlCajaShopIni0)){
	
	print (	"<tr>
				<td class='BorderInfDch' align='left'>".$RowCajaShopIni0['cname']."</td>
				<td class='BorderInfDch ocultatd440' align='left'>".$RowCajaShopIni0['refcaja']."</td>
				<td class='BorderInfDch' align='right'>".$RowCajaShopIni0['oper']."</td>
				<td class='BorderInfDch ocultatd440' align='right'>".$RowCajaShopIni0['datecash']."</td>
				<td class='BorderInfDch' align='right'>".$RowCajaShopIni0['refclient']."</td>
			<td class='BorderInf'>
		<form name='recup_compra2' method='post' action='CajaShop/caja_00.php' style='display:inline-block;'>
			<input name='cname' type='hidden' value='".$RowCajaShopIni0['cname']."' />
			<input name='refcaja' type='hidden' value='".$RowCajaShopIni0['refcaja']."' />
			<input name='oper' type='hidden' value='".$RowCajaShopIni0['oper']."' />
			<input name='datecash' type='hidden' value='".$RowCajaShopIni0['datecash']."' />
			<input name='refclient' type='hidden' value='".$RowCajaShopIni0['refclient']."' />
				<button type='submit' title='RECUPERA COMPRA' class='botonazul imgButIco CachedBlack' style='vertical-align:top;'></button>
				<input type='hidden' name='recup_compra2' value=1 />
		</form>");

	global $ClientRef;
	if($RowCajaShopIni0['refclient']==""){ 
		$ClientRef = "";		$_SESSION['nclient'] = "";
	}else{ 
		$ClientRef = $RowCajaShopIni0['refclient'];
		$SqlClientesWeb = "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ";
		$QrySqlClientesWeb = mysqli_query($db, $SqlClientesWeb);
		if(mysqli_num_rows($QrySqlClientesWeb) == 0){
				$SqlClientesWeb = "SELECT * FROM $Admin WHERE `ref` = '$ClientRef' ";
				$QrySqlClientesWeb = mysqli_query($db, $SqlClientesWeb);
				$RowSqlClientesWeb = mysqli_fetch_assoc($QrySqlClientesWeb);
				$_SESSION['nclient'] = $RowSqlClientesWeb['Nivel'];
			//	print(" ".$_SESSION['nclient']);
		}else{
			$RowSqlClientesWeb = mysqli_fetch_assoc($QrySqlClientesWeb);
			$_SESSION['nclient'] = $RowSqlClientesWeb['Nivel'];
			}
	}

if($ClientRef != ''){
	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin') || ($_SESSION['Nivel']=='plus')){$CssHeight = 'height=530px';}
	else {$CssHeight = 'height=250px';}

	if($_SESSION['nclient'] == 'cliente'){
		require "config/TablesNames.php";
		$SqlClientesWebRef =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ORDER BY `Nombre` ASC ";
		$QrySqlClientesWebRef = mysqli_query($db, $SqlClientesWebRef);
		$CssHeight = 'height=530px';
	}elseif(($_SESSION['nclient'] == 'admin') || ($_SESSION['nclient'] == 'plus') || ($_SESSION['nclient'] == 'user') || ($_SESSION['nclient'] == 'caja')){
		require "config/TablesNames.php";
		$SqlClientesWebRef =  "SELECT * FROM $Admin WHERE `ref` = '$ClientRef' ORDER BY `Nombre` ASC ";
		$QrySqlClientesWebRef = mysqli_query($db, $SqlClientesWebRef);}

		while($RowSqlClientesWebClient = mysqli_fetch_assoc($QrySqlClientesWebRef)){

		print("<form name='data_client' action='CajaShop/ClienteVer02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=500px,".$CssHeight."') \"  style='display:inline-block;'>
				<input type='hidden' name='id' value='".$RowSqlClientesWebClient['id']."' />
				<input type='hidden' name='Nivel' value='".$RowSqlClientesWebClient['Nivel']."' />
				<input type='hidden' name='ref' value='".$RowSqlClientesWebClient['ref']."' />
				<input type='hidden' name='Nombre' value='".$RowSqlClientesWebClient['Nombre']."' />
				<input type='hidden' name='Apellidos' value='".$RowSqlClientesWebClient['Apellidos']."' />
				<input type='hidden' name='myimg' value='".$RowSqlClientesWebClient['myimg']."' />
				<input type='hidden' name='doc' value='".$RowSqlClientesWebClient['doc']."' />
				<input type='hidden' name='dni' value='".$RowSqlClientesWebClient['dni']."' />
				<input type='hidden' name='ldni' value='".$RowSqlClientesWebClient['ldni']."' />
				<input type='hidden' name='Email' value='".$RowSqlClientesWebClient['Email']."' />
				<input type='hidden' name='Usuario'value='".$RowSqlClientesWebClient['Usuario']."' />
				<input type='hidden' name='Password' value='".$RowSqlClientesWebClient['Password']."' />
				<input type='hidden' name='Direccion' value='".$RowSqlClientesWebClient['Direccion']."' />
				<input type='hidden' name='Tlf1' value='".$RowSqlClientesWebClient['Tlf1']."' />
				<input type='hidden' name='Tlf2' value='".$RowSqlClientesWebClient['Tlf2']."' />
				<input type='hidden' name='lastin' value='".$RowSqlClientesWebClient['lastin']."' />
				<input type='hidden' name='lastout' value='".$RowSqlClientesWebClient['lastout']."' />
				<input type='hidden' name='visitadmin' value='".$RowSqlClientesWebClient['visitadmin']."' />
					<button type='submit' title='DATOS CLIENTE' class='botonlila imgButIco InfoBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='data_client' value=1 />
			</form></td>");
		} /* FIN DEL WHILE */
	}else{ }
			print("	</tr>");
					}
		print("	</table>");
				}
		}

	function recup_compra2(){
		
		$_SESSION['oper'] = $_POST['oper'];
	//	print("* INIT CAJA SESION.".$_SESSION['oper']);

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
	
	function salir() {	
		
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

		print("HA CERRADO SESION</br>");

	}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function log_info(){

		global $KeyLog;		$KeyLog = "index";
		require 'logs/LogInfo.php';
		
	}
			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
			
	require 'Inclu/Inclu_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


?>