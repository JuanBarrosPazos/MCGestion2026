<?php
session_start();

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../Inclu/Conta_Head.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';
		
	require '../Inclu/sqld_query_fetch_assoc.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 

		master_index();

		if(isset($_POST['oculto'])){
					if($form_errors = validate_form()){
							show_form($form_errors);
					} else { process_form();
							 info();
								}
		} else { show_form(); }
	
	} else { require '../Inclu/table_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();
	
	/* VALIDAMOS EL CAMPO year */
	
		if(strlen(trim($_POST['year'])) == ''){
			$errors [] = "EJERCICIO YEAR:  <font color='#F1BD2D'>CAMPO OBLIGATORIO</font>";
			}
		
		elseif(strlen(trim($_POST['year'])) < 4){
			$errors [] = "EJERCICIO YEAR:  <font color='#F1BD2D'>MINIMO 4 NUMEROS</font>";
			}
		
		elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['year'])){
			$errors [] = "EJERCICIO YEAR:  <font color='#F1BD2D'>CARACTERES NO VALIDOS.</font>";
			}
			
		elseif (!preg_match('/^[0-9]+$/',$_POST['year'])){
			$errors [] = "EJERCICIO YEAR:  <font color='#F1BD2D'>SOLO NUMEROS</font>";
			}

		elseif($_POST['year'] == (date('Y')+1)){
			$errors [] = "EJERCICIO YEAR:  <font color='#F1BD2D'>
			<br>EL NUEVO AÑO SE CREARÁ AUTOMATICAMENTE.</font>";
			}
		
		elseif($_POST['year'] < (date('Y')-5)){
			$errors [] = "EJERCICIO YEAR:  <font color='#F1BD2D'>
			<br>NO SE PERMITEN EJERCICIOS < ".(date('Y')-5).".</font>";
			}
		
		elseif($_POST['year'] > date('Y')){
			$errors [] = "EJERCICIO YEAR:  <font color='#F1BD2D'>AÑO NO ADMITIDO</font>";
			}
		
////////////////

	elseif(isset($_POST['oculto'])){
		
		global $db; 		global $db_name;
			
		$a = $_POST['year'];
		$a = trim($a);
				
		global $vname; 		$vname = "`".$_SESSION['clave']."status`";
			
		$sqlx =  "SELECT * FROM `$db_name`.$vname WHERE `year` = '$a' ";
		$qx = mysqli_query($db, $sqlx);
		$countx = mysqli_num_rows($qx);
		$rowsx = mysqli_fetch_assoc($qx);
			
		$sqly =  "SELECT * FROM `$db_name`.$vname ORDER BY `year` ASC ";
		$qy = mysqli_query($db, $sqly);		
		$ry = mysqli_fetch_assoc($qy);		
		$yval = $ry['year'];			

		global $vname2; 		$vname2 = "`".$_SESSION['clave']."status`";
		$sqlf =  "SELECT * FROM `$db_name`.$vname2 WHERE `year` = '$a'";
		$qf = mysqli_query($db, $sqlf);	
		$countf = mysqli_num_rows($qf);	
				
		if($countf > 0){ $errors [] = "<font color='#F1BD2D'>T. FEEDBACK YA EXISTE ESTE EJERCICIO ".$a.".</font>"; 
		} elseif($countx > 0){$errors [] = "<font color='#F1BD2D'>YA EXISTE ESTE EJERCICIO</font>";
		} elseif($_POST['year'] < ($yval - 1)){$errors [] = "<font color='#F1BD2D'>AÑO PERMITIDO <b>* ".($yval-1)." *</b></font>"; }
						
		}
				
	return $errors;

	} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){
	
		global $InicioBlackTit;		$InicioBlackTit = "INICIO STATUS EJERCICIOS";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		global $db; 		global $db_name;	
		global $vname; 		$vname = "`".$_SESSION['clave']."status`";

		global $year; 		$year = $_POST['year'];
		global $ycod; 		$ycod = substr(trim($_POST['year']),-2,2);
		$stat = 'open';
		$hidden = 'no';
		
		$tabla = "<table class='tableForm' >
					<tr>
						<th colspan=2 >
							NUEVO EJERCICIO<br/>GRABADO EN ".strtoupper($vname)."
						</th>
					</tr>
					<tr>
						<td style='text-align:left;'>EJERCICIO</td><td>".$year."</td>
					</tr>
					<tr>
						<td style='text-align:left;'>CODE</td><td>".$ycod."</td>
					</tr>
					<tr>
						<td style='text-align:left;'>STATE</td><td>".$stat."</td>
					</tr>
					<tr>
						<td style='text-align:left;'>HIDDEN</td><td>".$hidden."</td>
					</tr>
					<tr>
						<td colspan='2' style='text-align:right;' >
							".$InicioBlack."
								<a href='status_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
							".$closeButton."
						</td>
					</tr>
			</table>";	
		
		/////////////
	
		$sqla = "INSERT INTO `$db_name`.$vname (`year`, `ycod`, `stat`, `hidden`) VALUES ('$year', '$ycod', '$stat', '$hidden')";
			
		if(mysqli_query($db, $sqla)){ print($tabla); 
									crear_tablas();
		} else { print("* MODIFIQUE LA ENTRADA 207: ".mysqli_error($db));
				show_form ();
				global $texerror; 		$texerror = "\n\t ".mysqli_error($db);
		}

		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='status_Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
					
	} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* GENERA LAS TABLAS Y DIRECTORIOS PARA EL NUEVO YEAR / STATUS */
	function crear_tablas(){
				tingresos();
				tgastos();
				insert_log();
	}

	function tingresos(){

		global $db; 		global $db_name;
		global $year;
			
		global $vname1;		 $vname1 = "`".$_SESSION['clave']."ingresos_".$year."`";
			
		$tv = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname1 (
		`id` int(4) NOT NULL auto_increment,
		`factnum` varchar(20) collate utf8_spanish2_ci NOT NULL,
		`factdate` varchar(20) collate utf8_spanish2_ci NOT NULL,
		`refprovee` varchar(20) collate utf8_spanish2_ci NOT NULL,
		`factnom` varchar(22) collate utf8_spanish2_ci NOT NULL,
		`factnif` varchar(20) collate utf8_spanish2_ci NOT NULL,
		`factiva` int(2) NOT NULL,
		`factivae` decimal(9,2) unsigned NOT NULL,
		`factpvp` decimal(9,2) unsigned NOT NULL,
		`factret` int(2) NOT NULL,
		`factrete` decimal(9,2) unsigned NOT NULL,
		`factpvptot` decimal(9,2) unsigned NOT NULL,
		`coment` text collate utf8_spanish2_ci NOT NULL,
		`myimg1` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
		`myimg2` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
		`myimg3` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
		`myimg4` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
		PRIMARY KEY  (`id`),
		UNIQUE KEY `id` (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ";
				
		global $dat1;
		if(mysqli_query($db, $tv)){
			$dat1 = "\tCREADA TABLA ".$vname1.".\n";
		} else {print( "* NO OK TABLA VENTAS. ".mysqli_error($db).".\n");
				$dat1 = "\tNO CREADA TABLA ".$vname1.". ".mysqli_error($db).".\n";
					}
					
		// CREA EL DIRECTORIO DE INGRESOS.

		$vn1 = "docingresos_".$year;
		$carpeta1 = "../cb26_Docs/".$vn1;
		global $dat1b;
		if (!file_exists($carpeta1)) {
			mkdir($carpeta1, 0777, true);
			copy("../cb26_Images/untitled.png", $carpeta1."/untitled.png");
			copy("../cb26_Images/pdf.png", $carpeta1."/pdf.png");
			$dat1b = "\tCREADO EL DIRECTORIO ".$carpeta1.".\n";
		}else{print("* NO HA CREADO EL DIRECTORIO ".$carpeta1."\n");
			$dat1b = "\tNO CREADO EL DIRECTORIO ".$carpeta1.".\n";
				}
		}
			
		function tgastos(){
			
			global $db; 		global $db_name;
			global $year;

			global $vname2; 		$vname2 = "`".$_SESSION['clave']."gastos_".$year."`";
			
			$tg = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname2 (
			`id` int(4) NOT NULL auto_increment,
			`factnum` varchar(20) collate utf8_spanish2_ci NOT NULL,
			`factdate` varchar(20) collate utf8_spanish2_ci NOT NULL,
			`refprovee` varchar(20) collate utf8_spanish2_ci NOT NULL,
			`factnom` varchar(22) collate utf8_spanish2_ci NOT NULL,
			`factnif` varchar(20) collate utf8_spanish2_ci NOT NULL,
			`factiva` int(2) NOT NULL,
			`factivae` decimal(9,2) unsigned NOT NULL,
			`factpvp` decimal(9,2) unsigned NOT NULL,
			`factret` int(2) NOT NULL,
			`factrete` decimal(9,2) unsigned NOT NULL,
			`factpvptot` decimal(9,2) unsigned NOT NULL,
			`coment` text collate utf8_spanish2_ci NOT NULL,
			`myimg1` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
			`myimg2` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
			`myimg3` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
			`myimg4` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
			PRIMARY KEY  (`id`),
			UNIQUE KEY `id` (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ";
				
			global $dat2;
			if(mysqli_query($db, $tg)){
					$dat2 = "\tCREADA TABLA ".$vname2.".\n";
			}else{print( "* NO OK TABLA GASTOS. ".mysqli_error($db)."\n");
					$dat2 = "\tNO CREADA TABLA ".$vname2.". ".mysqli_error($db).".\n";
						}
			
		// CREA EL DIRECTORIO DE DOC GASTOS.

			$vn2 = "docgastos_".$year;
			$carpeta2 = "../cb26_Docs/".$vn2;
			global $dat2b;
			if (!file_exists($carpeta2)) {
				mkdir($carpeta2, 0777, true);
				copy("../cb26_Images/untitled.png", $carpeta2."/untitled.png");
				copy("../cb26_Images/pdf.png", $carpeta2."/pdf.png");
				$dat2b = "\tCREADO EL DIRECTORIO ".$carpeta2.".\n";
			}else{die("* NO HA CREADO EL DIRECTORIO ".$carpeta2."\n");
				$dat2b = "\tNO CREADO EL DIRECTORIO ".$carpeta2.".\n";
				}
			}
			

							
		function insert_log(){
			
				global $dat1;	global $dat1b;	global $dat2;	global $dat2b;
				global $dat3;	global $dat4;	global $dat5;
				global $datos;
				$datos = $dat1.$dat1b.$dat2.$dat2b.$dat3.$dat4.$dat5."\n";

			global $dir;
			if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
						$dir = "../cb26_Docs/log";
					}

			global $year;
			$logdocu = $_SESSION['ref'];
			$logdate = date('Y_m_d');
			$logtext = "\n** CREADO NUEVO EJERCICIO => ".$year.".\n\t User Ref: ".$_SESSION['ref'].".\n\t User Name: ".$_SESSION['Nombre']." ".$_SESSION['Apellidos']."\n \n".$datos;
			$filename = $dir."/".$logdate."_".$logdocu.".log";
			$log = fopen($filename, 'ab+');
			fwrite($log, $logtext);
			fclose($log);

		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){
	
		global $InicioBlackTit;		$InicioBlackTit = "INICIO STATUS EJERCICIOS";
		global $SaveBlackTit;		$SaveBlackTit = "CREAR NUEVO EJERCICIO";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		if(isset($_POST['oculto'])){
							$defaults = $_POST;
		} else {$defaults = array (	'year' => @$_POST['year']);
							}

		if ($errors){
			require 'tablaErrors.php';
		}
		
////////////////////

		print("<table class='tableForm' >
				<tr>
					<th colspan=2 >CREAR NUEVO AÑO / EJERCICIO</th>
				</tr>
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td style='text-align:right;' >EJERCICIO YEAR</td>
					<td>
			<input type='text' name='year' size=4 maxlength=4 value='".$defaults['year']."' />
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align:right;' >
						".$SaveBlack.$closeButton."
							<input type='hidden' name='oculto' value=1 />
						".$InicioBlack."
							<a href='status_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
			</form>														
					</td>
				</tr>
			</table>"); 
	
	}  // FIN function show_form($errors=[])

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

		global $db; 	global $year;

		$ActionTime = date('H:i:s');

		global $dir;
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
					$dir = "../cb26_Docs/log";
					}
		
		global $text;
		$text = "\n- NUEVO EJERCICIO CREADO ".$ActionTime.".\n\t ".$year.".";

			$logdocu = $_SESSION['ref'];
			$logdate = date('Y_m_d');
			$logtext = $text."\n";
			$filename = $dir."/".$logdate."_".$logdocu.".log";
			$log = fopen($filename, 'ab+');
			fwrite($log, $logtext);
			fclose($log);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaStatus;	$rutaStatus = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
	} /* Fin funcion master_index.*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>