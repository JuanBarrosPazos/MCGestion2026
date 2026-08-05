<?php

// 10 TABLAS MOD GESTION + 15 TABLAS MOD CONTA + 4 TABLAS MOD ADMIN = 29 TABLAS EN TOTAL

global $db, $db_name, $db_host, $db_user, $db_pass;
 
/************* CREAMOS LA TABLA ADMIN *************/
/************* CREAMOS LA TABLA FEEDBACK *************/
/************* CREAMOS LA TABLA VISITAS ADMIN *************/
/************* CREAMOS LA TABLA IP CONTROL*************/

	        ////////////////////		////////////////////
////////////////////		////////////////////		////////////////////
	       ////////////////////	      ////////////////////

function ini_log_ModGest(){

	global $LogText;
        $ActionTime = date('H:i:s');
	$logdate = date('Y_m_d');

	$LogText = "** ".$ActionTime.PHP_EOL."\n\t** ".$LogText.PHP_EOL;
	$filename = "../Mod_Gestion/logs/Config/ini_log_".$logdate.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $LogText);
	fclose($log);

}

function config_one_ModGest(){
        global $LogText;
	if(file_exists('../Mod_Gestion/config/year.txt')){ 
                unlink("../Mod_Gestion/config/year.txt");
                $LogText = $LogText."\n \t UNLINK ../Mod_Gestion/config/year.txt";
        }else{  print("ERROR UNLINK ../Mod_Gestion/config/year.txt </br>");
		$LogText = $LogText."\n \t ERROR UNLINK ../Mod_Gestion/config/year.txt";
        }

	if(file_exists('../Mod_Gestion/config/ayear.php')){
                unlink("../Mod_Gestion/config/ayear.php");
                $LogText = $LogText."\n \t UNLINK ../Mod_Gestion/config/ayear.php";
        }else{  print("ERROR UNLINK ../Mod_Gestion/config/ayear.php </br>");
                $LogText = $LogText."\n \t ERROR UNLINK ../Mod_Gestion/config/ayear.php";
        }

	if(!file_exists('../Mod_Gestion/config/year.txt')){
		if(file_exists('../Mod_Gestion/config/year_Init_System.txt')){
			copy("../Mod_Gestion/config/year_Init_System.txt", "../Mod_Gestion/config/year.txt");
			$LogText = $LogText."\n \t RENAME year_Init_System.txt TO year.txt";
		}else{  print("ERROR RENAME year_Init_System.txt TO year.txt </br>");
			$LogText = $LogText."\n \t ERROR RENAME year_Init_System.txt TO year.txt";
                }
	}else{ }

	if(!file_exists('../Mod_Gestion/config/ayear.php')){
		if(file_exists('../Mod_Gestion/config/ayear_Init_System.php')){
			copy("../Mod_Gestion/config/ayear_Init_System.php", "../Mod_Gestion/config/ayear.php");
			$LogText = $LogText."\n \t RENAME ayear_Init_System.php TO ayear.php";
		}else{  print("ERROR RENAME ayear_Init_System.php TO ayear.php </br>");
			$LogText = $LogText."\n \t ERROR RENAME ayear_Init_System.php TO ayear.php";}
	}else{ }
	
        $LogText ="\n SUSTITUCION DE ARCHIVOS:".$LogText;
        ini_log_ModGest();
} // FIN config_one_ModGest()

        config_one_ModGest();

function modif_ModGest(){

	$filename = "../Mod_Gestion/config/ayear.php";
	$fw1 = fopen($filename, 'r+');
	$contenido = fread($fw1,filesize($filename));
	fclose($fw1);
	
	$contenido = explode("\n",$contenido);
	$contenido[2] = "'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',\n'".(date('y')-1)."' => '".(date('Y')-1)."',";
	$contenido = implode("\n",$contenido);
	
	$fw = fopen($filename, 'w+');
	fwrite($fw, $contenido);
	fclose($fw);

        global $LogText;
        $LogText = "\nCONSTRUIDO ARRAY ../Mod_Gestion/config/ayear.php";
        ini_log_ModGest();
}

function modif2_ModGest(){

	$filename = "../Mod_Gestion/config/year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);

        global $LogText;
        $LogText = "\nCONSTRUIDO ARCHIVO AÑO ACTUAL ../Mod_Gestion/config/year.txt";
        ini_log_ModGest();
}

function ayear_ModGest(){

	global $LogText;
	$LogText = "EJECUTADA FUNCIÓN ayear()";

	$filename = "../Mod_Gestion/config/year.txt";
	$fw2 = fopen($filename, 'r+');
	$fget = fgets($fw2);
	fclose($fw2);
	
	if($fget == date('Y')){
            //print("EL AÑO ES EL MISMO ".date('Y')." == ".$fget);
			//$LogText = $LogText."EL AÑO ES EL MISMO ".date('Y')." == ".$fget;
        }elseif($fget != date('Y')){ 
                                modif_ModGest();
			        modif2_ModGest();
			print("EL AÑO HA CAMBIADO ".date('Y')." != ".$fget);
			$LogText = $LogText."EL AÑO HA CAMBIADO ".date('Y')." != ".$fget;
	}
        ini_log_ModGest();
} // FIN ayear_ModGest()

        ayear_ModGest();

	        ////////////////////		////////////////////
////////////////////		////////////////////		////////////////////
	       ////////////////////	      ////////////////////

global $LogText;

/************* CREAMOS LA TABLA CLIENTES SHOP *************/

global $table_name_cl;
$table_name_cl = "`".$_SESSION['clave']."clientesweb`";

$ClientesWeb = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_cl (
`id` int(4) NOT NULL auto_increment,
`ref` varchar(20) NOT NULL,
`Nivel` varchar(8) NOT NULL default 'cliente',
`Nombre` varchar(25) NOT NULL,
`Apellidos` varchar(25) NOT NULL,
`myimg` varchar(30) NOT NULL default 'untitled.png',
`doc` varchar(11) NOT NULL,
`dni` varchar(8) NOT NULL,
`ldni` varchar(1) NOT NULL,
`Email` varchar(50) NOT NULL,
`Usuario` varchar(12) NOT NULL,
`Password` varchar(12) NOT NULL,
`Direccion` varchar(60) NOT NULL,
`Tlf1` int(9) NOT NULL,
`Tlf2` int(9) NOT NULL,
`lastin` datetime NOT NULL default CURRENT_TIMESTAMP,
`lastout` datetime NOT NULL default CURRENT_TIMESTAMP,
`visitadmin` varchar(4) NOT NULL default '0',
`del` varchar(5) NOT NULL default 'false',
`borrado` datetime NULL,
`recuper` datetime NULL,
UNIQUE KEY `id` (`id`),
UNIQUE KEY `ref` (`ref`),
PRIMARY KEY `ref` (`ref`),
UNIQUE KEY `dni` (`dni`),
UNIQUE KEY `Email` (`Email`),
UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
    
if(mysqli_query($db, $ClientesWeb)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$table_name_cl."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE ".$table_name_cl."\n\t* ".mysqli_error($db)."\n"; }

$vc = "INSERT INTO `$db_name`.$table_name_cl (`ref`,`Nivel`, `Nombre`, `Apellidos`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Usuario`, `Password`, `Direccion`, `Tlf1`, `Tlf2`) VALUES
('anonimo', 'cliente', 'Anonimo', 'Anonimo', 'untitled.png', 'local', '00000000', '0', 'anonimo', 'Anonimo', 'Anonimo', 'local', '000000000', '000000000'),
('barra0101', 'cliente', 'barra01', 'cliente01', 'untitled.png', 'local', '00B01C01', '0', 'barra0101', 'barra0101', 'barra0101', 'local', '000000000', '000000000'),
('barra0102', 'cliente', 'barra01', 'cliente02', 'untitled.png', 'local', '00B01C02', '0', 'barra0102', 'barra0102', 'barra0102', 'local', '000000000', '000000000'),
('barra0103', 'cliente', 'barra01', 'cliente03', 'untitled.png', 'local', '00B01C03', '0', 'barra0103', 'barra0103', 'barra0103', 'local', '000000000', '000000000'),
('barra0104', 'cliente', 'barra01', 'cliente04', 'untitled.png', 'local', '00B01C04', '0', 'barra0104', 'barra0104', 'barra0104', 'local', '000000000', '000000000'),
('barra0105', 'cliente', 'barra01', 'cliente05', 'untitled.png', 'local', '00B01C05', '0', 'barra0105', 'barra0105', 'barra0105', 'local', '000000000', '000000000'),
('barra0106', 'cliente', 'barra01', 'cliente06', 'untitled.png', 'local', '00B01C06', '0', 'barra0106', 'barra0106', 'barra0106', 'local', '000000000', '000000000'),
('barra0107', 'cliente', 'barra01', 'cliente07', 'untitled.png', 'local', '00B01C07', '0', 'barra0107', 'barra0107', 'barra0107', 'local', '000000000', '000000000'),
('barra0108', 'cliente', 'barra01', 'cliente08', 'untitled.png', 'local', '00B01C08', '0', 'barra0108', 'barra0108', 'barra0108', 'local', '000000000', '000000000'),
('barra0201', 'cliente', 'barra02', 'cliente01', 'untitled.png', 'local', '00B02C01', '0', 'barra0201', 'barra0201', 'barra0201', 'local', '000000000', '000000000'),
('barra0202', 'cliente', 'barra02', 'cliente02', 'untitled.png', 'local', '00B02C02', '0', 'barra0202', 'barra0202', 'barra0202', 'local', '000000000', '000000000'),
('barra0203', 'cliente', 'barra02', 'cliente03', 'untitled.png', 'local', '00B02C03', '0', 'barra0203', 'barra0203', 'barra0203', 'local', '000000000', '000000000'),
('barra0204', 'cliente', 'barra02', 'cliente04', 'untitled.png', 'local', '00B02C04', '0', 'barra0204', 'barra0204', 'barra0204', 'local', '000000000', '000000000'),
('barra0205', 'cliente', 'barra02', 'cliente05', 'untitled.png', 'local', '00B02C05', '0', 'barra0205', 'barra0205', 'barra0205', 'local', '000000000', '000000000'),
('barra0206', 'cliente', 'barra02', 'cliente06', 'untitled.png', 'local', '00B02C06', '0', 'barra0206', 'barra0206', 'barra0206', 'local', '000000000', '000000000'),
('barra0207', 'cliente', 'barra02', 'cliente07', 'untitled.png', 'local', '00B02C07', '0', 'barra0207', 'barra0207', 'barra0207', 'local', '000000000', '000000000'),
('barra0208', 'cliente', 'barra02', 'cliente08', 'untitled.png', 'local', '00B02C08', '0', 'barra0208', 'barra0208', 'barra0208', 'local', '000000000', '000000000'),
('s01mesa01', 'cliente', 'sala01', 'mesa01', 'untitled.png', 'local', '00S01C01', '0', 's01mesa01', 's01mesa01', 's01mesa01', 'local', '000000000', '000000000'),
('s01mesa02', 'cliente', 'sala01', 'mesa02', 'untitled.png', 'local', '00S01C02', '0', 's01mesa02', 's01mesa02', 's01mesa02', 'local', '000000000', '000000000'),
('s01mesa03', 'cliente', 'sala01', 'mesa03', 'untitled.png', 'local', '00S01C03', '0', 's01mesa03', 's01mesa03', 's01mesa03', 'local', '000000000', '000000000'),
('s01mesa04', 'cliente', 'sala01', 'mesa04', 'untitled.png', 'local', '00S01C04', '0', 's01mesa04', 's01mesa04', 's01mesa04', 'local', '000000000', '000000000'),
('s01mesa05', 'cliente', 'sala01', 'mesa05', 'untitled.png', 'local', '00S01C05', '0', 's01mesa05', 's01mesa05', 's01mesa05', 'local', '000000000', '000000000'),
('s01mesa06', 'cliente', 'sala01', 'mesa06', 'untitled.png', 'local', '00S01C06', '0', 's01mesa06', 's01mesa06', 's01mesa06', 'local', '000000000', '000000000'),
('s01mesa07', 'cliente', 'sala01', 'mesa07', 'untitled.png', 'local', '00S01C07', '0', 's01mesa07', 's01mesa07', 's01mesa07', 'local', '000000000', '000000000'),
('s01mesa08', 'cliente', 'sala01', 'mesa08', 'untitled.png', 'local', '00S01C08', '0', 's01mesa08', 's01mesa08', 's01mesa08', 'local', '000000000', '000000000'),
('s02mesa01', 'cliente', 'sala02', 'mesa01', 'untitled.png', 'local', '00S02C01', '0', 's02mesa01', 's02mesa01', 's02mesa01', 'local', '000000000', '000000000'),
('s02mesa02', 'cliente', 'sala02', 'mesa02', 'untitled.png', 'local', '00S02C02', '0', 's02mesa02', 's02mesa02', 's02mesa02', 'local', '000000000', '000000000'),
('s02mesa03', 'cliente', 'sala02', 'mesa03', 'untitled.png', 'local', '00S02C03', '0', 's02mesa03', 's02mesa03', 's02mesa03', 'local', '000000000', '000000000'),
('s02mesa04', 'cliente', 'sala02', 'mesa04', 'untitled.png', 'local', '00S02C04', '0', 's02mesa04', 's02mesa04', 's02mesa04', 'local', '000000000', '000000000'),
('s02mesa05', 'cliente', 'sala02', 'mesa05', 'untitled.png', 'local', '00S02C05', '0', 's02mesa05', 's02mesa05', 's02mesa05', 'local', '000000000', '000000000'),
('s02mesa06', 'cliente', 'sala02', 'mesa06', 'untitled.png', 'local', '00S02C06', '0', 's02mesa06', 's02mesa06', 's02mesa06', 'local', '000000000', '000000000'),
('s02mesa07', 'cliente', 'sala02', 'mesa07', 'untitled.png', 'local', '00S02C07', '0', 's02mesa07', 's02mesa07', 's02mesa07', 'local', '000000000', '000000000'),
('s02mesa08', 'cliente', 'sala02', 'mesa08', 'untitled.png', 'local', '00S02C08', '0', 's02mesa08', 's02mesa08', 's02mesa08', 'local', '000000000', '000000000'),
('terraza0101', 'cliente', 'terraza01', 'mesa01', 'untitled.png', 'local', '00T01C01', '0', 'terraza0101', 'terraza0101', 'terraza0101', 'local', '000000000', '000000000'),
('terraza0102', 'cliente', 'terraza01', 'mesa02', 'untitled.png', 'local', '00T01C02', '0', 'terraza0102', 'terraza0102', 'terraza0102', 'local', '000000000', '000000000'),
('terraza0103', 'cliente', 'terraza01', 'mesa03', 'untitled.png', 'local', '00T01C03', '0', 'terraza0103', 'terraza0103', 'terraza0103', 'local', '000000000', '000000000'),
('terraza0104', 'cliente', 'terraza01', 'mesa04', 'untitled.png', 'local', '00T01C04', '0', 'terraza0104', 'terraza0104', 'terraza0104', 'local', '000000000', '000000000'),
('terraza0105', 'cliente', 'terraza01', 'mesa05', 'untitled.png', 'local', '00T01C05', '0', 'terraza0105', 'terraza0105', 'terraza0105', 'local', '000000000', '000000000'),
('terraza0106', 'cliente', 'terrazaa01', 'mesa06', 'untitled.png', 'local', '00T01C06', '0', 'terraza0106', 'terraza0106', 'terraza0106', 'local', '000000000', '000000000'),
('terraza0107', 'cliente', 'terraza01', 'mesa07', 'untitled.png', 'local', '00T01C07', '0', 'terraza0107', 'terraza0107', 'terraza0107', 'local', '000000000', '000000000'),
('terraza0108', 'cliente', 'terraza01', 'mesa08', 'untitled.png', 'local', '00T01C08', '0', 'terraza0108', 'terraza0108', 'terraza0108', 'local', '000000000', '000000000'),
('terraza0201', 'cliente', 'terraza02', 'mesa01', 'untitled.png', 'local', '00T02C01', '0', 'terraza0201', 'terraza0201', 'terraza0201', 'local', '000000000', '000000000'),
('terraza0202', 'cliente', 'terraza02', 'mesa02', 'untitled.png', 'local', '00T02C02', '0', 'terraza0202', 'terraza0202', 'terraza0202', 'local', '000000000', '000000000'),
('terraza0203', 'cliente', 'terraza02', 'mesa03', 'untitled.png', 'local', '00T02C03', '0', 'terraza0203', 'terraza0203', 'terraza0203', 'local', '000000000', '000000000'),
('terraza0204', 'cliente', 'terraza02', 'mesa04', 'untitled.png', 'local', '00T02C04', '0', 'terraza0204', 'terraza0204', 'terraza0204', 'local', '000000000', '000000000'),
('terraza0205', 'cliente', 'terraza02', 'mesa05', 'untitled.png', 'local', '00T02C05', '0', 'terraza0205', 'terraza0205', 'terraza0205', 'local', '000000000', '000000000'),
('terraza0206', 'cliente', 'terraza02', 'mesa06', 'untitled.png', 'local', '00T02C06', '0', 'terraza0206', 'terraza0206', 'terraza0206', 'local', '000000000', '000000000'),
('terraza0207', 'cliente', 'terraza02', 'mesa07', 'untitled.png', 'local', '00T02C07', '0', 'terraza0207', 'terraza0207', 'terraza0207', 'local', '000000000', '000000000'),
('terraza0208', 'cliente', 'terraza02', 'mesa08', 'untitled.png', 'local', '00T02C08', '0', 'terraza0208', 'terraza0208', 'terraza0208', 'local', '000000000', '000000000')";

if(mysqli_query($db, $vc)){
        $LogText = $LogText."\t* OK INSERT INIT VALUES EN  ".$table_name_cl."\n";
}else{  $LogText = $LogText."\t* ERROR INSERT INIT VALUES EN  ".$table_name_cl."\n\t* ".mysqli_error($db)."\n";  }

/************* CREAMOS LA TABLA CLIENTES SHOP FEEDBACK ************

global $table_name_fcl;
$table_name_fcl = "`".$_SESSION['clave']."clienteswebfeed`";

$feedbackcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_fcl (
`id` int(4) NOT NULL auto_increment,
`ref` varchar(20) NOT NULL,
`Nivel` varchar(8) NOT NULL default 'cliente',
`Nombre` varchar(25) NOT NULL,
`Apellidos` varchar(25) NOT NULL,
`myimg` varchar(30) NOT NULL default 'untitled.png ',
`doc` varchar(11) NOT NULL,
`dni` varchar(8) NOT NULL,
`ldni` varchar(1) NOT NULL,
`Email` varchar(50) NOT NULL,
`Usuario` varchar(10) NOT NULL,
`Password` varchar(10) NOT NULL,
`Direccion` varchar(60) NOT NULL,
`Tlf1` int(9) NOT NULL default 0,
`Tlf2` int(9) NOT NULL default 0,
`lastin` datetime NOT NULL default CURRENT_TIMESTAMP,
`lastout` datetime NOT NULL default CURRENT_TIMESTAMP,
`visitadmin` varchar(4) NOT NULL default '0',
`borrado` datetime NOT NULL default CURRENT_TIMESTAMP,
UNIQUE KEY `id` (`id`),
UNIQUE KEY `ref` (`ref`),
UNIQUE KEY `dni` (`dni`),
UNIQUE KEY `Email` (`Email`),
UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
    
if(mysqli_query($db, $feedbackcl)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$table_name_fcl."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE TABLE ".$table_name_fcl."\n\t* ".mysqli_error($db)."\n"; }
*/

/************* CREAMOS LA TABLA VISITAS CLIENTES SHOP ****************/

global $table_name_vstb;
$table_name_vstb = "`".$_SESSION['clave']."visitasclientesweb`";
 
$VisitasClientesWeb = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_vstb (
`idv` int(2) NOT NULL,
`visita` int(10) NOT NULL,
`admin` int(10) NOT NULL,
`deneg` int(10) NOT NULL,
`acceso` int(10) NOT NULL,
PRIMARY KEY  (`idv`)
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
                 
if(mysqli_query($db, $VisitasClientesWeb)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$table_name_vstb."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE TABLE ".$table_name_vstb."\n\t* ".mysqli_error($db)."\n"; }

$vd = "INSERT INTO `$db_name`.$table_name_vstb (`idv`, `visita`, `admin`, `deneg`, `acceso`) VALUES (69, 0, 0, 0, 0)";
if(mysqli_query($db, $vd)){
        $LogText = $LogText."\t* OK INSERT INIT VALUES EN ".$table_name_vstb."\n";
}else{  $LogText = $LogText."\t* ERROR INSERT INIT ".$table_name_vstb."\n\t* ".mysqli_error($db)."\n"; }
 
/************* CREAMOS LA TABLA SECCIONES *************/

global $table_name_sec;
$table_name_sec = "`".$_SESSION['clave']."secciones`";

$Secciones = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_sec (
`id` int(3) NOT NULL auto_increment,
`valor` varchar(22) NOT NULL,
`nombre` varchar(22) NOT NULL,
`del` varchar(5) NOT NULL default 'false',
`borrado` datetime NULL,
`recuper` datetime NULL,
PRIMARY KEY  (`id`),
UNIQUE KEY `id` (`id`,`valor`,`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
    
if(mysqli_query($db, $Secciones)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$table_name_sec."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE TABLE ".$table_name_sec."\n\t* ".mysqli_error($db)."\n"; }
                
$vd = "INSERT INTO `$db_name`.$table_name_sec (`id`, `valor`, `nombre`) VALUES ('0', '', 'SECCIONES')";
if(mysqli_query($db, $vd)){
        $LogText = $LogText."\t* OK INSERT INIT VALUES EN ".$table_name_sec."\n";
}else{  $LogText = $LogText."\t* ERROR INSERT INIT VALUES EN ".$table_name_sec."\n\t* ".mysqli_error($db)."\n";
        }
                
/************* CREAMOS LA TABLA SECCIONES FEEDBACK ************

global $table_name_gfs;
$table_name_gfs = "`".$_SESSION['clave']."seccionesfeed`";

$gfs = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_gfs (
`id` int(3) NOT NULL auto_increment,
`valor` varchar(22) NOT NULL,
`nombre` varchar(22) NOT NULL,
PRIMARY KEY  (`id`),
UNIQUE KEY `id` (`id`,`valor`,`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
    
if(mysqli_query($db, $gfs)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$table_name_gfs."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE TABLE ".$table_name_gfs."\n\t* ".mysqli_error($db)."\n"; }
*/

/************* CREAMOS LA TABLA DE PRODUCTOS *************/

global $table_name_gfp;
$table_name_gfp = "`".$_SESSION['clave']."productos`";

$gfp = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_gfp (
`id` int(4) NOT NULL auto_increment,
`vseccion` varchar(22),
`valor` varchar(14),
`nombre` varchar(24) NOT NULL,
`ref` varchar(14) NOT NULL DEFAULT 'NO CODE',
`psiva` decimal(7,2) unsigned NOT NULL,
`iva` int(2) NOT NULL,
`ivae` decimal(7,2) unsigned NOT NULL,
`pvp` decimal(7,2) unsigned NOT NULL,
`kgin` decimal(7,2) unsigned NOT NULL,
`datekgin` varchar(20) NOT NULL,
`nsemana` int(2) NOT NULL,
`kgbad` decimal(7,2) unsigned NOT NULL,
`datekgbad` varchar(20) default NULL,
`kgcash` decimal(7,2) unsigned NOT NULL,
`datecash` varchar(20) NOT NULL,
`stock` decimal(7,2) unsigned NOT NULL,
`myimg1` varchar(30) NOT NULL default 'untitled.png',
`myimg2` varchar(30) NOT NULL default 'untitled.png',
`myimg3` varchar(30) NOT NULL default 'untitled.png',
`myimg4` varchar(30) NOT NULL default 'untitled.png',
`coment` text(400),
`del` varchar(5) NOT NULL default 'false',
`borrado` datetime NULL,
`recuper` datetime NULL,
PRIMARY KEY  (`id`),
UNIQUE KEY `id` (`id`),
UNIQUE KEY `valor` (`valor`),
UNIQUE KEY `nombre` (`nombre`),
UNIQUE KEY `ref` (`ref`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
    
if(mysqli_query($db, $gfp)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$table_name_gfp."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE TABLE ".$table_name_gfp."\n\t* ".mysqli_error($db)."\n"; }
                
/************* CREAMOS LA TABLA DE PRODUCTOS FEEDBACK ************

global $table_name_gfpf;
$table_name_gfpf = "`".$_SESSION['clave']."productosfeed`";

$gfpf = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_gfpf (
`id` int(4) NOT NULL auto_increment,
`vseccion` varchar(22),
`valor` varchar(14),
`nombre` varchar(24) NOT NULL,
`ref` varchar(14) NOT NULL DEFAULT 'NO CODE',
`psiva` decimal(7,2) unsigned NOT NULL,
`iva` int(2) NOT NULL,
`ivae` decimal(7,2) unsigned NOT NULL,
`pvp` decimal(7,2) unsigned NOT NULL,
`kgin` decimal(7,2) unsigned NOT NULL,
`datekgin` varchar(20) NOT NULL,
`nsemana` int(2) NOT NULL,
`kgbad` decimal(7,2) unsigned NOT NULL,
`datekgbad` varchar(20) default NULL,
`kgcash` decimal(7,2) unsigned NOT NULL,
`datecash` varchar(20) NOT NULL,
`stock` decimal(7,2) unsigned NOT NULL,
`myimg1` varchar(30) NOT NULL default 'untitled.png',
`myimg2` varchar(30) NOT NULL default 'untitled.png',
`myimg3` varchar(30) NOT NULL default 'untitled.png',
`myimg4` varchar(30) NOT NULL default 'untitled.png',
`coment` text(400),
`borrado` varchar(22) NOT NULL,
PRIMARY KEY  (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
    
if(mysqli_query($db, $gfpf)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$table_name_gfpf."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE TABLE ".$table_name_gfpf."\n\t* ".mysqli_error($db)."\n"; }
*/

/************* CREAMOS LA TABLA CAJA *************/

global $table_name_gcj;
$table_name_gcj = "`".$_SESSION['clave']."cajashop`";

$gcj = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_gcj (
`id` int(4) NOT NULL auto_increment,
`ini` varchar(3) NOT NULL,
`cname` varchar(52) NOT NULL,
`refcaja` varchar(20) NOT NULL,
`clname` varchar(52) NOT NULL,
`refclient` varchar(20) NOT NULL,
`oper` varchar(20) NOT NULL,
`nsemana` int(2) NOT NULL,
`datecash` varchar(20) NOT NULL,
`vseccion` varchar(22) NOT NULL,
`producto` varchar(20) NOT NULL,
`proname` varchar(24) NOT NULL,
`kgcash` decimal(7,2) unsigned NOT NULL,
`psiva` decimal(7,2) unsigned NOT NULL,
`iva` int(2) NOT NULL,
`ivae` decimal(7,2) unsigned NOT NULL,
`pvp` decimal(7,2) unsigned NOT NULL,
`pvptot` decimal(10,2) unsigned NOT NULL,
`coment` text(400) NULL,
PRIMARY KEY  (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
    
if(mysqli_query($db, $gcj)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$table_name_gcj."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE TABLE ".$table_name_gcj."\n\t* ".mysqli_error($db)."\n"; }
                
/************* CREAMOS LA TABLA VENTAS ESTE AÑO *************/

global $vname;
$vname = $_SESSION['clave']."ventasshop_".date('Y');
$vname = "`".$vname."`";

$gcj = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname (
`id` int(4) NOT NULL auto_increment,
`ini` varchar(3) NOT NULL,
`cname` varchar(52) NOT NULL,
`refcaja` varchar(20) NOT NULL,
`clname` varchar(52) NOT NULL,
`refclient` varchar(20) NOT NULL,
`oper` varchar(20) NOT NULL,
`nsemana` int(2) NOT NULL,
`datecash` varchar(20) NOT NULL,
`vseccion` varchar(22) NOT NULL,
`producto` varchar(20),
`proname` varchar(24) NOT NULL,
`kgcash` decimal(7,2) unsigned NOT NULL,
`psiva` decimal(7,2) unsigned NOT NULL,
`iva` int(2) NOT NULL,
`ivae` decimal(7,2) unsigned NOT NULL,
`pvp` decimal(7,2) unsigned NOT NULL,
`pvptot` decimal(10,2) unsigned NOT NULL,
`pago` varchar(20) NOT NULL,
`coment` text(400) NULL,
PRIMARY KEY  (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
    
if(mysqli_query($db, $gcj)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$vname."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE TABLE ".$vname."\n\t* ".mysqli_error($db)."\n"; }
                
/************* CREAMOS LA TABLA VENTAS AÑO ANTERIOR  *************/

global $vname;
$vname = $_SESSION['clave']."ventasshop_".(date('Y')-1);
$vname = "`".$vname."`";

$gcj2 = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname (
`id` int(4) NOT NULL auto_increment,
`ini` varchar(3) NOT NULL,
`cname` varchar(52) NOT NULL,
`refcaja` varchar(20) NOT NULL,
`clname` varchar(52) NOT NULL,
`refclient` varchar(20) NOT NULL,
`oper` varchar(20) NOT NULL,
`nsemana` int(2) NOT NULL,
`datecash` varchar(20) NOT NULL,
`vseccion` varchar(22) NOT NULL,
`producto` varchar(20),
`proname` varchar(24) NOT NULL,
`kgcash` decimal(7,2) unsigned NOT NULL,
`psiva` decimal(7,2) unsigned NOT NULL,
`iva` int(2) NOT NULL,
`ivae` decimal(7,2) unsigned NOT NULL,
`pvp` decimal(7,2) unsigned NOT NULL,
`pvptot` decimal(10,2) unsigned NOT NULL,
`pago` varchar(20) NOT NULL,
`coment` text(400) NULL,
PRIMARY KEY  (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
    
if(mysqli_query($db, $gcj2)){
        $LogText = $LogText."\t* OK CREATE TABLE ".$vname."\n";
}else{  $LogText = $LogText."\t* ERROR CREATE TABLE ".$vname."\n\t* ".mysqli_error($db)."\n"; }

				////////////////////			////////////////////
////////////////////			////////////////////			////////////////////
				////////////////////			///////////////////

/*************	PASAMOS LOS PARAMETROS A .LOG	*************/
global $datein;
$LogText = PHP_EOL."\n - CONFIG INIT GESTION ".$datein.".\n * ".$db_name.". \n * ".$db_host.". \n * ".$db_user.". \n * ".$db_pass."\n".$LogText."\n";

?>
