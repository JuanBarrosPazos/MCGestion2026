<?php

	// EL ORDEN DE CONSTRUCCIÓN ESTÁ BASADO EN LA CLAVE FORANEA, SI SE UTILIZA...
	// 15 TABLAS
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function ini_log_cb23(){

		global $LogText;
		$ActionTime = date('H:i:s');

		$logdate = date('Y_m_d');

		$LogText = "** ".$ActionTime.PHP_EOL."\t** ".$LogText.PHP_EOL;
		$filename = "../Mod_Conta/config/logs/ini_log_".$logdate.".log";
		$log = fopen($filename, 'ab+');
		fwrite($log, $LogText);
		fclose($log);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function config_one_cb23(){
	
	global $LogText;
	if(file_exists('../Mod_Conta/config/year.txt')){unlink("../Mod_Conta/config/year.txt");
					$LogText = $LogText.PHP_EOL."\tUNLINK ../Mod_Conta/config/year.txt";
	}else{	print("DON`T UNLINK ../Mod_Conta/config/year.txt </br>");
			$LogText = $LogText.PHP_EOL."\tDON'T UNLINK ../Mod_Conta/config/year.txt";
	}

	/*
	if(file_exists('../Mod_Conta/config/ayear.php')){unlink("../Mod_Conta/config/ayear.php");
					$LogText = $LogText.PHP_EOL."\tUNLINK ../Mod_Conta/config/ayear.php";
	}else{ print("DON'T UNLINK config/ayear.php </br>");
					$LogText = $LogText.PHP_EOL."\tDON'T UNLINK ../Mod_Conta/config/ayear.php";}
	*/

	if(!file_exists('../Mod_Conta/config/year.txt')){
			if(file_exists('../Mod_Conta/config/year_Init_System.txt')){
				copy("../Mod_Conta/config/year_Init_System.txt", "../Mod_Conta/config/year.txt");
				$LogText = $LogText.PHP_EOL."\tRENAME ../Mod_Conta/config/year_Init_System.txt TO ../Mod_Conta/config/year.txt";
			} else {
		//print("DON'T RENAME ../Mod_Conta/config/year_Init_System.txt TO ../Mod_Conta/config/year.txt </br>");
				$LogText = $LogText.PHP_EOL."\tDON'T RENAME ../Mod_Conta/config/year_Init_System.txt TO ../Mod_Conta/config/year.txt";
			}
	}else{ $LogText = $LogText.""; }

	/*
	if(!file_exists('../Mod_Conta/config/ayear.php')){
			if(file_exists('../Mod_Conta/config/ayear_Init_System.php')){
				copy("../Mod_Conta/config/ayear_Init_System.php", "../Mod_Conta/config/ayear.php");
				$LogText = $LogText.PHP_EOL."\tRENAME ../Mod_Conta/config/ayear_Init_System.php TO ../Mod_Conta/config/ayear.php";
			}else{
			//print("DON'T RENAME ../Mod_Conta/config/ayear_Init_System.php TO ../Mod_Conta/config/ayear.php </br>");
				$LogText = $LogText.PHP_EOL."\tDON'T RENAME ../Mod_Conta/config/ayear_Init_System.php TO ../Mod_Conta/config/ayear.php";
			}
	}else{ $LogText = $LogText."";}
	*/

	if(!file_exists('../Mod_Conta/cb26_Docs/year.txt')){
			if(file_exists('../Mod_Conta/config/year_Init_System.txt')){
				copy("../Mod_Conta/config/year_Init_System.txt", "../Mod_Conta/cb26_Docs/year.txt");
				$LogText = $LogText."\n \t RENAME ../Mod_Conta/config/year_Init_System.txt TO "."../Mod_Conta/cb26_Docs/year.txt";
			}else{
		//print("DON'T RENAME ../Mod_Conta/config/year_Init_System.txt TO ../Mod_Conta/config/year.txt </br>");
				$LogText = $LogText."\n \t RENAME ../Mod_Conta/config/year_Init_System.txt TO ../Mod_Conta/cb26_Docs/year.txt";
			}
	}else{ $LogText = $LogText."";}

	/*
	if(!file_exists('../Mod_Conta/cb26_Docs/ayear.php')){
			if(file_exists('../Mod_Conta/config/ayear_Init_System.php')){
				copy("../Mod_Conta/config/ayear_Init_System.php", "../Mod_Conta/cb26_Docs/ayear.php");
				$LogText = $LogText."\n \t RENAME ../Mod_Conta/config/ayear_Init_System.php TO ../Mod_Conta/cb26_Docs/ayear.php";
			}else{
		//print("DON'T RENAME ../Mod_Conta/config/ayear_Init_System.php TO ../Mod_Conta/cb26_Docs/ayear.php </br>");
				$LogText = $LogText."\n \t RENAME ../Mod_Conta/config/ayear_Init_System.php TO ../Mod_Conta/cb26_Docs/ayear.php";
			}
	}else{ $LogText = $LogText."";}
	*/
  
	// PASAMOS LOS PARAMETROS A LOS LOG.
	global $LogText; 
	$LogText = "MOD_CONTA SUSTITUCION DE ARCHIVOS:".$LogText;

	ini_log_cb23();

	} // FIN function config_one_cb23()
	
	config_one_cb23();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	global $db, $db_name, $db_host, $db_user, $db_pass, $LogText;
	
	/************** CREAMOS LA TABLA ADMIN ***************/
	// SE CONSTRUYE DESDE MOD_ADMIN
					
	/************* CREAMOS LA TABLA VISITAS ADMIN ****************/
	// SE CONSTRUYE DESDE MOD_ADMIN

	/************** CREAMOS LA TABLA PROVEEDORES ***************/

	global $vname5;
	$vname5 = "`".$_SESSION['clave']."proveedores`";
	
	$provee = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname5 (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) NOT NULL,
  `rsocial` varchar(30) NOT NULL,
  `myimg` varchar(30) NOT NULL default 'untitled.png',
  `doc` varchar(11) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `ldni` varchar(1) NOT NULL,
  `Email` varchar(50) NULL,
  `Direccion` varchar(60) NOT NULL,
  `Tlf1` int(9) NOT NULL default 000000000,
  `Tlf2` int(9) NOT NULL default 000000000,
  `del` varchar(5) NOT NULL default 'false',
  `borrado` datetime NULL,
  `recuper` datetime NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `ref` (`ref`),
  PRIMARY KEY `ref` (`ref`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db, $provee)){
			$LogText = $LogText."\t* OK CREATE TABLE ".$vname5."\n";

		$vp = "INSERT INTO `$db_name`.$vname5 (`id`, `ref`, `rsocial`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Direccion`, `Tlf1`, `Tlf2`, `del`, `borrado`, `recuper`) VALUES (1, 'ANONIMO', 'ANONIMO', 'untitled.png', 'ANONIMO', 'ANONIMO', 'X', 'anonimo@anonimo.es', 'Not Adress', 000000000, 000000000, 'false', NULL, NULL)";
		
		if(mysqli_query($db, $vp)){
				$LogText = $LogText."\t* OK INSERT INIT VALUES EN ".$vname5."\n";
		}else{ 	//print("* ERROR INSERT INIT VALUES EN ".$vname5.". ".mysqli_error($db)."</br>");
				$LogText = $LogText."\t* ERROR INSERT INIT VALUES EN ".$vname5."\n\t* ".mysqli_error($db)."\n";
		}

	}else{ 	//print("* ERROR CREATE TABLE ".$vname5." ".mysqli_error($db)."</br>");
			$LogText = $LogText."\t* ERROR CREATE TABLE ".$vname5."\n\t* ".mysqli_error($db)."\n";
	}

	/************** CREAMOS LA TABLA GASTOS PENDIENTES  ***************/

	global $tablProveedores;
	$tablProveedores = "`".$_SESSION['clave']."proveedores`";
		
	global $vname1b;
	$vname1b = "`".$_SESSION['clave']."gastos_pendientes`";

	$tgb = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname1b (
  `id` int(4) NOT NULL auto_increment,
  `factnum` varchar(20) NOT NULL,
  `factnumini` varchar(20) NOT NULL,
  `factdate` date NOT NULL,
  `factdateini` date NOT NULL,
  `refprovee` varchar(20) NOT NULL,
  `factnom` varchar(22) NOT NULL,
  `factnif` varchar(20) NOT NULL,
  `factiva` int(2) NOT NULL,
  `factivae` decimal(9,2) unsigned NOT NULL,
  `factpvp` decimal(9,2) unsigned NOT NULL,
  `factret` int(2) unsigned NOT NULL,
  `factrete` decimal(9,2) unsigned NOT NULL,
  `factpvptot` decimal(9,2) unsigned NOT NULL,
  `coment` text NOT NULL,
  `myimg1` varchar(30) NOT NULL default 'untitled.png',
  `myimg2` varchar(30) NOT NULL default 'untitled.png',
  `myimg3` varchar(30) NOT NULL default 'untitled.png',
  `myimg4` varchar(30) NOT NULL default 'untitled.png',
  `factcrea` datetime NOT NULL,
  `factmodif` datetime NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  INDEX `refprovee` (`refprovee`),
  FOREIGN KEY (`refprovee`) REFERENCES $tablProveedores (`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db, $tgb)){
			$LogText = $LogText."\t* OK CREATE TABLE ".$vname1b."\n";
	}else{ 	//print( "* ERROR CREATE TABLE ".$vname1b.". ".mysqli_error($db)."\n");
			$LogText = $LogText."\t* ERROR CREATE TABLE ".$vname1b."\n\t* ".mysqli_error($db)."\n";
	}
			
	/************** CREAMOS LA TABLA CLIENTES ***************/

	global $vname6;
	$vname6 = "`".$_SESSION['clave']."clientes`";
	
	$provei = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname6 (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) NOT NULL,
  `rsocial` varchar(30) NOT NULL,
  `myimg` varchar(30) NOT NULL default 'untitled.png',
  `doc` varchar(11) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `ldni` varchar(1) NOT NULL,
  `Email` varchar(50) NULL,
  `Direccion` varchar(60) NOT NULL,
  `Tlf1` int(9) NOT NULL default 000000000,
  `Tlf2`int(9) NOT NULL default 000000000,
  `del` varchar(5) NOT NULL default 'false',
  `borrado` datetime NULL,
  `recuper` datetime NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `ref` (`ref`),
  PRIMARY KEY `ref` (`ref`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db, $provei)){
			$LogText = $LogText."\t* OK CRETATE TABLE ".$vname6."\n";

		$vpi = "INSERT INTO `$db_name`.$vname6 (`id`, `ref`, `rsocial`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Direccion`, `Tlf1`, `Tlf2`, `del`, `borrado`, `recuper`) VALUES (1, 'ANONIMO', 'ANONIMO', 'untitled.png', 'ANONIMO', 'ANONIMO', 'X', 'anonimo@anonimo.es', 'Not Adress', 000000000, 000000000, 'false', NULL, NULL)";
			
		if(mysqli_query($db, $vpi)){
				$LogText = $LogText."\t* OK INSERT INIT VALUES EN ".$vname6."\n";
		}else{ 	//print("* ERROR INSERT INIT VALUES EN ".$vname6.". ".mysqli_error($db)."</br>");
				$LogText = $LogText."\t* ERROR INSERT INIT VALUES EN ".$vname6."\n\t* ".mysqli_error($db)."\n";
				}
	}else{ 	//print("* ERROR CREATE TABLE ".$vname6.". ".mysqli_error($db)."</br>");
			$LogText = $LogText."\t* ERROR CREATE TABLE ".$vname6."\n\t* ".mysqli_error($db)." \n";
	}

	/************** CREAMOS LA TABLA INGRESOS PENDIENTES ***************/

	global $tblClientes;
	$tblClientes = "`".$_SESSION['clave']."clientes`";

	global $vname3b;
	$vname3b = "`".$_SESSION['clave']."ingresos_pendientes`";
	
	$tib = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname3b (
  `id` int(4) NOT NULL auto_increment,
  `factnum` varchar(20) NOT NULL,
  `factnumini` varchar(20) NOT NULL,
  `factdate` date NOT NULL,
  `factdateini` date NOT NULL,
  `refcliente` varchar(20) NOT NULL,
  `factnom` varchar(22) NOT NULL,
  `factnif` varchar(20) NOT NULL,
  `factiva` int(2) NOT NULL,
  `factivae` decimal(9,2) unsigned NOT NULL,
  `factpvp` decimal(9,2) unsigned NOT NULL,
  `factret` int(2) unsigned NOT NULL,
  `factrete` decimal(9,2) unsigned NOT NULL,
  `factpvptot` decimal(9,2) unsigned NOT NULL,
  `coment` text NOT NULL,
  `myimg1` varchar(30) NOT NULL default 'untitled.png',
  `myimg2` varchar(30) NOT NULL default 'untitled.png',
  `myimg3` varchar(30) NOT NULL default 'untitled.png',
  `myimg4` varchar(30) NOT NULL default 'untitled.png',
  `factcrea` datetime NOT NULL,
  `factmodif` datetime NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  INDEX `refcliente` (`refcliente`),
  FOREIGN KEY (`refcliente`) REFERENCES $tblClientes (`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db, $tib)){
			$LogText = $LogText."\t* OK CREATE TABLE ".$vname3b."\n";
	}else{	//print( "* ERROR CREATE TABLE ".$vname3b." ".mysqli_error($db)."\n");
			$LogText = $LogText."\t* ERROR CREATE TABLE ".$vname3b."\n\t* ".mysqli_error($db)."\n";
	}

	/************** CREAMOS LA TABLA IMPUESTOS ***************/

	global $vname10;
	$vname10 = "`".$_SESSION['clave']."impuestos`";

	$impuestos = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname10 (
				  `id` int(2) NOT NULL auto_increment,
  				  `iva` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  				  `name` varchar(12) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'NAME %',
				  PRIMARY KEY  (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=6 ";
		
	if(mysqli_query($db, $impuestos)){
			global $table16;
			$table16 = "\t* OK TABLA ".$vname10.". \n";
		} else { print("* NO OK TABLE ".$vname10.". ".mysqli_error($db)."</br>");
				 global $table16;
				 $table16 = "\t* NO OK TABLA ".$vname10.". ".mysqli_error($db)." \n";
			}
					
$vname10 = strtolower($vname10);					
$impuestos2 = "INSERT INTO `$db_name`.$vname10 (`id`, `iva`, `name`) VALUES
(1, '0.00', '% IMPUESTOS'), 
(2, '0.00', '0.00 %'), 
(3, '4.00', '4.00 %'), 
(4, '10.00', '10.00 %'),  
(5, '21.00', '21.00 %')";
		
	if(mysqli_query($db, $impuestos2)){
			$LogText = $LogText."\t* OK INIT VALUES EN ".$vname10.". \n";
	} else { print("* NO OK INIT VALUES EN ".$vname10.". ".mysqli_error($db)."</br>");
			$LogText = $LogText."\t* NO OK INIT VALUES EN ".$vname10.". ".mysqli_error($db)." \n";
	}


	/************** CREAMOS LA TABLA STATUS ***************/

	global $vname11;
	$vname11 = "`".$_SESSION['clave']."status`";

	$status = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname11 (
				  `id` int(2) NOT NULL auto_increment,
  				  `year` int(4) NOT NULL,
   				  `ycod` int(2) NOT NULL,
 				  `stat` varchar(5) NOT NULL DEFAULT 'open',
 				  `hidden` varchar(2) NOT NULL DEFAULT 'no',
				  `del` varchar(5) NOT NULL default 'false',
  				  `borrado` datetime NULL,
				  `recuper` datetime NULL,
				  PRIMARY KEY  (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=3 ";
		
	global $y1;		$y1 = date('Y')-1;
	global $y1b;	$y1b = date('y')-1;
	global $y2;		$y2 = date('Y');
	global $y2b;	$y2b = date('y'); 
	if(mysqli_query($db, $status)){
		$LogText = $LogText."\t* OK CREATE TABLE ".$vname11.". \n";

		$vname11 = strtolower($vname11);					
		$status2 = "INSERT INTO `$db_name`.$vname11 (`id`, `year`, `ycod`, `stat`, `hidden`) VALUES (1, '$y1', '$y1b', 'open', 'no'), (2, '$y2', '$y2b', 'open', 'no') ";
		if(mysqli_query($db, $status2)){
				$LogText = $LogText."\t* OK INSERT INIT VALUES EN ".$vname11.". \n";
		}else{ 	//print("* ERROR INSERT INIT VALUES EN ".$vname11." ".mysqli_error($db)."</br>");
				$LogText = $LogText."\t* ERROR INSERT INIT VALUES EN ".$vname11."\n\t* ".mysqli_error($db)." \n";
		}
	}else{ 	//print("* ERROR CREATE TABLE ".$vname11." ".mysqli_error($db)."</br>");
			$LogText = $LogText."\t* ERROR CREATE TABLE ".$vname11."\n\t* ".mysqli_error($db)." \n";
	}

	/************** CREAMOS LA TABLA RETENCION ***************/

	global $vname13;
	$vname13 = "`".$_SESSION['clave']."retencion`";

	$retencion = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname13 (
				  `id` int(2) NOT NULL auto_increment,
  				  `ret` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  				  `name` varchar(12) NOT NULL DEFAULT 'NAME %',
				  PRIMARY KEY  (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=6 ";
		
	if(mysqli_query($db, $retencion)){
			$LogText = $LogText."\t* OK CREATE TABLE ".$vname13."\n";

			$vname13 = strtolower($vname13);					
			$retencion2 = "INSERT INTO `$db_name`.$vname13 (`id`, `ret`, `name`) VALUES (1, '0.00', '% RETENCION'), 
			(2, '0.00', '0.00 %'), (3, '15.00', '15.00 %')";
			if(mysqli_query($db, $retencion2)){
					$LogText = $LogText."\t* OK INSERT INIT VALUES EN ".$vname13."\n";
			}else{ 	//print("* ERROR INSERT INIT VALUES EN ".$vname13.". ".mysqli_error($db)."</br>");
					$LogText = $LogText."\t* ERROR INSERT INIT VALUES EN ".$vname13."\n\t* ".mysqli_error($db)." \n";
			}
	}else{ 	//print("* ERROR CREATE TABLE ".$vname13." ".mysqli_error($db)."</br>");
			$LogText = $LogText."\t* ERROR CREATE TABLE ".$vname13."\n\t* ".mysqli_error($db)."\n";
	}
					

	/************	PASAMOS LOS PARAMETROS A .LOG	*****************/
	
		global $data0;
		$datein = date('Y-m-d H:i:s');
		$logdate = date('Y_m_d');
		$LogText = $LogText.PHP_EOL."** CONFIG INIT ".$datein;
		$LogText = $LogText.PHP_EOL."** index.php function crear_tablas()";
		$LogText = $LogText.PHP_EOL." * ".$db_name;
		$LogText = $LogText.PHP_EOL." * ".$db_host;
		$LogText = $LogText.PHP_EOL." * ".$db_user;
		$LogText = $LogText.PHP_EOL." * ".$db_pass."\n";

		ini_log_cb23();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	global $LogText; 	$LogText = "";
	
	/************		SE CREAN TABLAS Y DIRECTORIOS ADICIONALES DESDE CONFIG2		*****************/

	$carpeta = "../Mod_Conta/cb26_Docs";
	if (!file_exists($carpeta)) {
			mkdir($carpeta, 0777, true);
			$LogText = $LogText."\t* OK DIRECTORIO ../Mod_Conta/cb26_Docs. \n";
	}else{	//print("* NO HA CREADO EL DIRECTORIO ".$carpeta."\n");
			$LogText = $LogText."\t* YA EXISTE EL DIRECTORIO ../Mod_Conta/cb26_Docs. \n";
			}

	/************** CREAMOS LA TABLA GASTOS  ***************/

	global $tablProveedores;
	$tablProveedores = "`".$_SESSION['clave']."proveedores`";

	global $vname1;
	$vname1 = "`".$_SESSION['clave']."gastos_".date('Y')."`";
	
	$tg = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname1 (
  `id` int(4) NOT NULL auto_increment,
  `factnum` varchar(20) NOT NULL,
  `factnumini` varchar(20) NOT NULL,
  `factdate` date NOT NULL,
  `factdateini` date NOT NULL,
  `refprovee` varchar(20) NOT NULL,
  `factnom` varchar(22) NOT NULL,
  `factnif` varchar(20) NOT NULL,
  `factiva` int(2) NOT NULL,
  `factivae` decimal(9,2) unsigned NOT NULL,
  `factpvp` decimal(9,2) unsigned NOT NULL,
  `factret` int(2) unsigned NOT NULL,
  `factrete` decimal(9,2) unsigned NOT NULL,
  `factpvptot` decimal(9,2) unsigned NOT NULL,
  `coment` text NOT NULL,
  `myimg1` varchar(30) NOT NULL default 'untitled.png',
  `myimg2` varchar(30) NOT NULL default 'untitled.png',
  `myimg3` varchar(30) NOT NULL default 'untitled.png',
  `myimg4` varchar(30) NOT NULL default 'untitled.png',
  `factcrea` datetime NOT NULL,
  `factmodif` datetime NOT NULL default CURRENT_TIMESTAMP,
  `del` varchar(5) NOT NULL default 'false',
  `borrado` datetime NULL,
  `recuper` datetime NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  INDEX `refprovee` (`refprovee`),
  FOREIGN KEY (`refprovee`) REFERENCES $tablProveedores (`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";

	if(mysqli_query($db, $tg)){
			$LogText = $LogText."\t* OK CREATE TABLE ".$vname1."\n";
	}else{ 	//print( "* ERROR CREATE TABLE ".$vname1." ".mysqli_error($db)."\n");
			$LogText = $LogText."\t* ERROR CREATE TABLE ".$vname1."\n\t* ".mysqli_error($db)."\n";
			}

// CREA EL DIRECTORIO DE DOC GASTOS.

	$vn1 = "docgastos_".date('Y');
	$carpeta1 = "../Mod_Conta/cb26_Docs/".$vn1;
	if (!file_exists($carpeta1)) {
		mkdir($carpeta1, 0777, true);
		copy("../Mod_Conta/cb26_Images/untitled.png", $carpeta1."/untitled.png");
		copy("../Mod_Conta/cb26_Images/pdf.png", $carpeta1."/pdf.png");
		$LogText = $LogText."\t* OK DIRECTORIO ".$carpeta1."\n";
	}else{ //print("* NO OK EL DIRECTORIO ".$carpeta1."\n");
			$LogText = $LogText."\t* YA EXISTE EL DIRECTORIO ".$carpeta1."\n";
			}

	/************** CREAMOS LA TABLA GASTOS DEL AÑO ANTERIOR ***************/

	global $vname2;
	$vname2 = "`".$_SESSION['clave']."gastos_".(date('Y')-1)."`";
	
	$tg2 = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname2 (
  `id` int(4) NOT NULL auto_increment,
  `factnum` varchar(20) NOT NULL,
  `factnumini` varchar(20) NOT NULL,
  `factdate` date NOT NULL,
  `factdateini` date NOT NULL,
  `refprovee` varchar(20) NOT NULL,
  `factnom` varchar(22) NOT NULL,
  `factnif` varchar(20) NOT NULL,
  `factiva` int(2) NOT NULL,
  `factivae` decimal(9,2) unsigned NOT NULL,
  `factpvp` decimal(9,2) unsigned NOT NULL,
  `factret` int(2) unsigned NOT NULL,
  `factrete` decimal(9,2) unsigned NOT NULL,
  `factpvptot` decimal(9,2) unsigned NOT NULL,
  `coment` text NOT NULL,
  `myimg1` varchar(30) NOT NULL default 'untitled.png',
  `myimg2` varchar(30) NOT NULL default 'untitled.png',
  `myimg3` varchar(30) NOT NULL default 'untitled.png',
  `myimg4` varchar(30) NOT NULL default 'untitled.png',
  `factcrea` datetime NOT NULL,
  `factmodif` datetime NOT NULL default CURRENT_TIMESTAMP,
  `del` varchar(5) NOT NULL default 'false',
  `borrado` datetime NULL,
  `recuper` datetime NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  INDEX `refprovee` (`refprovee`),
  FOREIGN KEY (`refprovee`) REFERENCES $tablProveedores (`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db, $tg2)){
			$LogText = $LogText."\t* OK CREATE TABLE ".$vname2."\n";
	}else{ 	//print( "* ERROR CREATE TABLE ".$vname2." ".mysqli_error($db)."\n");
			$LogText = $LogText."\t* ERROR CREATE TABLE ".$vname2."\n\t* ".mysqli_error($db)."\n";
			}
				
// CREA EL DIRECTORIO DE GASTOS DE AÑO ANTERIOR.

	$vn2 = "docgastos_".(date('Y')-1);
	$carpeta2 = "../Mod_Conta/cb26_Docs/".$vn2;
	if (!file_exists($carpeta2)) {
			mkdir($carpeta2, 0777, true);
			copy("../Mod_Conta/cb26_Images/untitled.png", $carpeta2."/untitled.png");
			copy("../Mod_Conta/cb26_Images/pdf.png", $carpeta2."/pdf.png");
			$LogText = $LogText."\t* OK DIRECTORIO ".$carpeta2."\n";
	}else{	//print("* YA EXISTE EL DIRECTORIO DIRECTORIO ".$carpeta2."\n");
			$LogText = $LogText."\t* YA EXISTE EL DIRECTORIO ".$carpeta2."\n";
				}

	/************** CREAMOS LA TABLA INGRESOS  ***************/

	global $tblClientes;
	$tblClientes = "`".$_SESSION['clave']."clientes`";

	global $vname3;
	$vname3 = "`".$_SESSION['clave']."ingresos_".date('Y')."`";
	
	$ti = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname3 (
  `id` int(4) NOT NULL auto_increment,
  `factnum` varchar(20) NOT NULL,
  `factnumini` varchar(20) NOT NULL,
  `factdate` date NOT NULL,
  `factdateini` date NOT NULL,
  `refcliente` varchar(20) NOT NULL,
  `factnom` varchar(22) NOT NULL,
  `factnif` varchar(20) NOT NULL,
  `factiva` int(2) NOT NULL,
  `factivae` decimal(9,2) unsigned NOT NULL,
  `factpvp` decimal(9,2) unsigned NOT NULL,
  `factret` int(2) unsigned NOT NULL,
  `factrete` decimal(9,2) unsigned NOT NULL,
  `factpvptot` decimal(9,2) unsigned NOT NULL,
  `coment` text NOT NULL,
  `myimg1` varchar(30) NOT NULL default 'untitled.png',
  `myimg2` varchar(30) NOT NULL default 'untitled.png',
  `myimg3` varchar(30) NOT NULL default 'untitled.png',
  `myimg4` varchar(30) NOT NULL default 'untitled.png',
  `factcrea` datetime NOT NULL,
  `factmodif` datetime NOT NULL default CURRENT_TIMESTAMP,
  `del` varchar(5) NOT NULL default 'false',
  `borrado` datetime NULL,
  `recuper` datetime NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  INDEX `refcliente` (`refcliente`),
  FOREIGN KEY (`refcliente`) REFERENCES $tblClientes (`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db, $ti)){
			$LogText = $LogText."\t* OK CREATE TABLE ".$vname3."\n";
	}else{ 	//print( "* ERROR CREATE TABLE ".$vname3.". ".mysqli_error($db)."\n");
			$LogText = $LogText."\t* ERROR CREATE TABLE ".$vname3."\n\t* ".mysqli_error($db)."\n";
				}
				
// CREA EL DIRECTORIO DE INGRESOS DEL AÑO.

	$vn3 = "docingresos_".date('Y');
	$carpeta3 = "../Mod_Conta/cb26_Docs/".$vn3;
	if (!file_exists($carpeta3)) {
			mkdir($carpeta3, 0777, true);
			copy("../Mod_Conta/cb26_Images/untitled.png", $carpeta3."/untitled.png");
			copy("../Mod_Conta/cb26_Images/pdf.png", $carpeta3."/pdf.png");
			$LogText = $LogText."\t* OK DIRECTORIO ".$carpeta3."\n";
	}else{ //print("* NO OK EL DIRECTORIO ".$carpeta3."\n");
			$LogText = $LogText."\t* YA EXISTE EL DIRECTORIO ".$carpeta3."\n";
				}
	
	/************** CREAMOS LA TABLA INGRESOS del año anterior  ***************/

	global $vname4;
	$vname4 = "`".$_SESSION['clave']."ingresos_".(date('Y')-1)."`";
	
	$ti2 = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname4 (
  `id` int(4) NOT NULL auto_increment,
  `factnum` varchar(20) NOT NULL,
  `factnumini` varchar(20) NOT NULL,
  `factdate` date NOT NULL,
  `factdateini` date NOT NULL,
  `refcliente` varchar(20) NOT NULL,
  `factnom` varchar(22) NOT NULL,
  `factnif` varchar(20) NOT NULL,
  `factiva` int(2) NOT NULL,
  `factivae` decimal(9,2) unsigned NOT NULL,
  `factpvp` decimal(9,2) unsigned NOT NULL,
  `factret` int(2) unsigned NOT NULL,
  `factrete` decimal(9,2) unsigned NOT NULL,
  `factpvptot` decimal(9,2) unsigned NOT NULL,
  `coment` text NOT NULL,
  `myimg1` varchar(30) NOT NULL default 'untitled.png',
  `myimg2` varchar(30) NOT NULL default 'untitled.png',
  `myimg3` varchar(30) NOT NULL default 'untitled.png',
  `myimg4` varchar(30) NOT NULL default 'untitled.png',
  `factcrea` datetime NOT NULL,
  `factmodif` datetime NOT NULL default CURRENT_TIMESTAMP,
  `del` varchar(5) NOT NULL default 'false',
  `borrado` datetime NULL,
  `recuper` datetime NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  INDEX `refcliente` (`refcliente`),
  FOREIGN KEY (`refcliente`) REFERENCES $tblClientes (`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db, $ti2)){
			$LogText = $LogText."\t* OK CRETE TABLE ".$vname4."\n";
	}else{  //print( "* ERROR CREATE TABLE ".$vname4." ".mysqli_error($db)."\n");
			$LogText = $LogText."\t* ERROR CREATE TABLE".$vname4."\n\t* ".mysqli_error($db)."\n";
			}
				
// CREA EL DIRECTORIO DE INGRESOS DEL AÑO ANTERIOR.

	$vn4 = "docingresos_".(date('Y')-1);
	$carpeta4 = "../Mod_Conta/cb26_Docs/".$vn4;
	if (!file_exists($carpeta4)) {
			mkdir($carpeta4, 0777, true);
			copy("../Mod_Conta/cb26_Images/untitled.png", $carpeta4."/untitled.png");
			copy("../Mod_Conta/cb26_Images/pdf.png", $carpeta4."/pdf.png");
			$LogText = $LogText."\t* OK DIRECTORIO ".$carpeta4."\n";
	} else { //print("* NO OK EL DIRECTORIO ".$carpeta4."\n");
			 $LogText = $LogText."\t* YA EXISTE EL DIRECTORIO ".$carpeta4."\n";
				}

		/************	PASAMOS LOS PARAMETROS A .LOG	*****************/
	
		$datein = date('Y-m-d H:i:s');
		$logdate = date('Y_m_d');
		$LogText = $LogText.PHP_EOL."** CONFIG INIT ".$datein;
		$LogText = $LogText.PHP_EOL."** config/config2.php function crear_tablas()";
		$LogText = $LogText.PHP_EOL." * ".$db_name;
		$LogText = $LogText.PHP_EOL." * ".$db_host;
		$LogText = $LogText.PHP_EOL." * ".$db_user;
		$LogText = $LogText.PHP_EOL." * ".$db_pass."\n";

		ini_log_cb23();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

		/************	FUNCIONES ADICIONALES PARA MOD_CONTA	*****************/

		/************	CONFIGURACIÓN ANUAL PARA MOD_CONTA	*****************/

function modif2a(){
	$filename = "../Mod_Conta/cb26_Docs/ayear.php";
	
	$contenido = "<?php\n \$dy = array ('' => 'YEAR',\n'".date('y')."' => '".date('Y')."',\n'".(date('y')-1)."' => '".(date('Y')-1)."',\n);\n?>";
	
	$fw = fopen($filename, 'w+');
	fwrite($fw, $contenido);
	fclose($fw);
	global $dat1;
	$dat1 = "\tMODIFICADO Y ACTUALIZADO ".$filename.PHP_EOL;
}

function modif2b(){
	$filename = "../Mod_Conta/cb26_Docs/year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);
	global $dat2;
	$dat2 = "\tMODIFICADO Y ACTUALIZADO ".$filename.".\n";
}

function modif3a(){
	$filename = "../Mod_Conta/config/ayear.php";
	
	$contenido = "<?php\n \$dy = array ('' => 'YEAR',\n'".date('y')."' => '".date('Y')."',\n'".(date('y')-1)."' => '".(date('Y')-1)."',\n);\n?>";
	
	$fw = fopen($filename, 'w+');
	fwrite($fw, $contenido);
	fclose($fw);
	global $dat1;
	$dat1 = "\tMODIFICADO Y ACTUALIZADO ".$filename.PHP_EOL;
}

function modif3b(){
	$filename = "../Mod_Conta/config/year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);
}

function ayear_cb23(){
	$filename = "../Mod_Conta/config/year.txt";
	$fw2 = fopen($filename, 'r+');
	$fget = fgets($fw2);
	fclose($fw2);
	
	if($fget == date('Y')){ }
	elseif($fget != date('Y')){
			modif2a();
			modif2b();
			modif3a(); 
			modif3b();
		}

} // FIN function ayear_cb23()

	ayear_cb23();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

		/************	COMPROBACIÓN Y CREACIÓN DE DIRECTORIOS PARA MOD_CONTA	*****************/
				 
	function crear_dir(){

	// ESTA FUNCIÓN LA TENGO INTEGRADA EN MOD_ADMIN DENTRO DE function crear_tablas()
		global $data0; 		$carpeta = "../Mod_Conta/cb26_Docs/temp";
		if (!file_exists($carpeta)) {
			mkdir($carpeta, 0777, true);
			$data0 = $data0."\t* OK DIRECTORIO ../Mod_Conta/cb26_Docs/temp. \n";
			}
			else{	//print("* NO HA CREADO EL DIRECTORIO ".$carpeta."\n");
					$data0 = $data0."\t* YA EXISTE EL DIRECTORIO ../Mod_Conta/cb26_Docs/temp. \n";
				}
	
		$carpeta = "../Mod_Conta/cb26_Docs/log";
		if (!file_exists($carpeta)) {
			mkdir($carpeta, 0777, true);
			$data0 = $data0."\t* OK DIRECTORIO ../Mod_Conta/cb26_Docs/log. \n";
			}
			else{	//print("* NO HA CREADO EL DIRECTORIO ".$carpeta."\n");
					$data0 = $data0."\t* YA EXISTE EL DIRECTORIO ../Mod_Conta/cb26_Docs/log. \n";
				}
	
		$carpeta = "../Mod_Conta/cb26_Docs/grafics";
		if (!file_exists($carpeta)) {
			mkdir($carpeta, 0777, true);
			$data0 = $data0."\t* OK DIRECTORIO ../Mod_Conta/cb26_Docs/grafics. \n";
			}
			else{	//print("* NO HA CREADO EL DIRECTORIO ".$carpeta."\n");
					$data0 = $data0."\t* YA EXISTE EL DIRECTORIO ../Mod_Conta/cb26_Docs/grafics. \n";
				}

/*	DEPECRATED...
	// CREA EL DIRECTORIO DE IMAGEN DE USUARIO.
	
		$vn1 = "img_admin";
		$carpetaimg = "../Mod_Conta/cb26_Docs/".$vn1;
		if (!file_exists($carpetaimg)) {
			mkdir($carpetaimg, 0777, true);
			copy("config/cb26_Images/untitled.png", $carpetaimg."/untitled.png");
			$data0 = $data0."\t* OK DIRECTORIO ".$carpetaimg."\n";
			}
			else{//print("* NO OK EL DIRECTORIO ".$carpetaimg."\n");
				$data0  = $data0."\t* YA EXISTE EL DIRECTORIO ".$carpetaimg."\n";
			}
*/	
	
	// CREA EL DIRECTORIO DE IMAGEN DE PROVEEDOR GASTOS.
	
		$vn1 = "img_proveedores";
		$carpetaimg1 = "../Mod_Conta/cb26_Docs/".$vn1;
		if (!file_exists($carpetaimg1)) {
			mkdir($carpetaimg1, 0777, true);
			copy("config/cb26_Images/untitled.png", $carpetaimg1."/untitled.png");
			$data0 = $data0."\t* OK DIRECTORIO ".$carpetaimg1."\n";
			}
			else{//print("* NO OK EL DIRECTORIO ".$carpetaimg1."\n");
				$data0 = $data0."\t* YA EXISTE EL DIRECTORIO ".$carpetaimg1."\n";
			}
		
	// CREA EL DIRECTORIO DE IMAGEN DE PROVEEDOR INGRESOS.
	
		$vn1 = "img_clientes";
		$carpetaimg2 = "../Mod_Conta/cb26_Docs/".$vn1;
		if (!file_exists($carpetaimg2)) {
			mkdir($carpetaimg2, 0777, true);
			copy("config/cb26_Images/untitled.png", $carpetaimg2."/untitled.png");
			$data0 = $data0."\t* OK DIRECTORIO ".$carpetaimg2."\n";
			}
			else{//print("* NO OK EL DIRECTORIO ".$carpetaimg2."\n");
				$data0 = $data0."\t* YA EXISTE EL DIRECTORIO ".$carpetaimg2."\n";
			}
		
	// CREA EL DIRECTORIO GRAFICS.
	
		$vn1 = "grafics";
		$carpetaimg2 = "../Mod_Conta/cb26_Docs/".$vn1;
		if (!file_exists($carpetaimg2)) {
			mkdir($carpetaimg2, 0777, true);
			copy("config/cb26_Images/untitled.png", $carpetaimg2."/untitled.png");
			$data0 = $data0."\t* OK DIRECTORIO ".$carpetaimg2."\n";
			}
			else{//print("* YA EXISTE EL DIRECTORIO ".$carpetaimg2."\n");
				$data0 = $data0."\t* YA EXISTE EL DIRECTORIO ".$carpetaimg2."\n";
			}
	
	// CREA EL DIRECTORIO DE DOC GASTOS PENDIENTES.
	
		$vn1b = "docgastos_pendientes";
		$carpeta1b = "../Mod_Conta/cb26_Docs/".$vn1b;
		if (!file_exists($carpeta1b)) {
			mkdir($carpeta1b, 0777, true);
			copy("config/cb26_Images/untitled.png", $carpeta1b."/untitled.png");
			copy("config/cb26_Images/pdf.png", $carpeta1b."/pdf.png");
			$data0 = $data0."\t* OK DIRECTORIO ".$carpeta1b."\n";
			}
			else{//print("* YA EXISTE EL DIRECTORIO ".$carpeta1b."\n");
				$data0 = $data0."\t* YA EXISTE EL DIRECTORIO ".$carpeta1b."\n";
			}
	
	// CREA EL DIRECTORIO DE IMAGENES.
	
		$vn3b = "docingresos_pendientes";
		$carpeta3b = "../Mod_Conta/cb26_Docs/".$vn3b;
		if (!file_exists($carpeta3b)) {
			mkdir($carpeta3b, 0777, true);
			copy("config/cb26_Images/untitled.png", $carpeta3b."/untitled.png");
			copy("config/cb26_Images/pdf.png", $carpeta3b."/pdf.png");
			$data0 = $data0."\t* OK DIRECTORIO ".$carpeta3b."\n";
			}
			else{//print("* NO OK EL DIRECTORIO ".$carpeta3b."\n");
				$data0 = $data0."\t* YA EXISTE EL DIRECTORIO ".$carpeta3b."\n";
			}

	/************	PASAMOS LOS PARAMETROS A .LOG	*****************/
	
	$datein = date('Y-m-d H:i:s');

	global $LogText;
	$LogText = " CONFIG INIT ".$datein.".\n** index.php function crear_dir() \n".$data0."\n";

	ini_log_cb23();
		
	} // FIN function crear_dir()

	crear_dir();


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>