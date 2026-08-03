<?php
session_start();
	
	global $index;		$index = 1;
	require '../Mod_Admin_Plus/Inclu/error_hidden.php';
	require 'Inclu/Conta_Head.php';
	require '../Mod_Admin_Plus/Conections/conection.php';
	require '../Mod_Admin_Plus/Conections/conect.php';
	require '../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
 
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
							ayear();
							status_close();
							process_form();
	} else { require 'Inclu/table_permisos.php'; }	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/*		*/
	function modif(){
																	
		$filename = "cb23_Docs/ayear.php";
		$fw1 = fopen($filename, 'r+');
		$contenido = fread($fw1,filesize($filename));
		fclose($fw1);
		
		$contenido = explode("\n",$contenido);
		$contenido[2] = "'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',";
		$contenido = implode("\n",$contenido);
		
		$fw = fopen($filename, 'w+');
		fwrite($fw, $contenido);
		fclose($fw);
		global $dat1;
		$dat1 = "\tMODIFICADO Y ACTUALIZADO ".$filename.PHP_EOL;
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function modif2(){

		$filename = "cb23_Docs/year.txt";
		$fw2 = fopen($filename, 'w+');
		$date = "".date('Y')."";
		fwrite($fw2, $date);
		fclose($fw2);
		global $dat2;
		$dat2 = "\tMODIFICADO Y ACTUALIZADO ".$filename.".\n";
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function tingresos(){

		global $db;
		
		global $tblClientes; 	
		$tblClientes = "`".$_SESSION['clave']."clientes`";

		global $db_name; 		
		$vname = "`".$_SESSION['clave']."ingresos_".date('Y')."`";
		
		$tv = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname (
	`id` int(4) NOT NULL auto_increment,
	`factnum` varchar(20) collate utf8_spanish2_ci NOT NULL,
	`factdate` varchar(20) collate utf8_spanish2_ci NOT NULL,
	`refcliente` varchar(20) collate utf8_spanish2_ci NOT NULL,
	`factnom` varchar(22) collate utf8_spanish2_ci NOT NULL,
	`factnif` varchar(20) collate utf8_spanish2_ci NOT NULL,
	`factiva` int(2) NOT NULL,
	`factivae` decimal(9,2) unsigned NOT NULL,
	`factpvp` decimal(9,2) unsigned NOT NULL,
	`factpvptot` decimal(9,2) unsigned NOT NULL,
	`coment` text collate utf8_spanish2_ci NOT NULL,
	`myimg1` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
	`myimg2` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
	`myimg3` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
	`myimg4` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
	PRIMARY KEY  (`id`),
	UNIQUE KEY `id` (`id`),
	INDEX `refcliente` (`refcliente`),
	FOREIGN KEY (`refcliente`) REFERENCES $tblClientes (`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ";
			
		if(mysqli_query($db, $tv)){
				global $dat4;
				$dat4 = "\tCREADA TABLA ".$vname.".\n";

					} else {print( "* NO OK TABLA VENTAS. ".mysqli_error($db).".\n");
							global $dat4;
							$dat4 = "\tNO CREADA TABLA ".$vname.". ".mysqli_error($db).".\n";
					}
					
	// CREA EL DIRECTORIO DE INGRESOS DE ESTE AÑO

		$vn3 = "docingresos_".date('Y');
		$carpeta3 = "cb23_Docs/".$vn3;
		if (!file_exists($carpeta3)) {
				mkdir($carpeta3, 0777, true);
				copy("cb23_Images/untitled.png", $carpeta3."/untitled.png");
				copy("cb23_Images/pdf.png", $carpeta3."/pdf.png");
				global $dat4b;
				$dat4b = "\tCREADO EL DIRECTORIO ".$carpeta3.".\n";
			} else{ 
				print("* NO HA CREADO EL DIRECTORIO ".$carpeta3."\n");
				global $dat4b;
				$dat4b = "\tNO CREADO EL DIRECTORIO ".$carpeta3.".\n";
			}
		
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function tgastos(){
		
		global $db; 		global $db_name;
		
		global $tablProveedores;
		$tablProveedores = "`".$_SESSION['clave']."proveedores`";

		global $vname;		
		$vname = "`".$_SESSION['clave']."gastos_".date('Y')."`";
		
		$tg = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname (
	`id` int(4) NOT NULL auto_increment,
	`factnum` varchar(20) collate utf8_spanish2_ci NOT NULL,
	`factdate` varchar(20) collate utf8_spanish2_ci NOT NULL,
	`refprovee` varchar(20) collate utf8_spanish2_ci NOT NULL,
	`factnom` varchar(22) collate utf8_spanish2_ci NOT NULL,
	`factnif` varchar(20) collate utf8_spanish2_ci NOT NULL,
	`factiva` int(2) NOT NULL,
	`factivae` decimal(9,2) unsigned NOT NULL,
	`factpvp` decimal(9,2) unsigned NOT NULL,
	`factpvptot` decimal(9,2) unsigned NOT NULL,
	`coment` text collate utf8_spanish2_ci NOT NULL,
	`myimg1` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
	`myimg2` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
	`myimg3` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
	`myimg4` varchar(30) collate utf8_spanish2_ci NOT NULL default 'untitled.png',
	PRIMARY KEY  (`id`),
	UNIQUE KEY `id` (`id`),
	INDEX `refprovee` (`refprovee`),
	FOREIGN KEY (`refprovee`) REFERENCES $tablProveedores (`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ";
			
		if(mysqli_query($db, $tg)){
				global $dat5; 		$dat5 = "\tCREADA TABLA ".$vname.".\n";

			// CREA EL DIRECTORIO DE DOC GASTOS.
				$vn1 = "docgastos_".date('Y');
				$carpeta1 = "cb23_Docs/".$vn1;
				if (!file_exists($carpeta1)) {
					mkdir($carpeta1, 0777, true);
					copy("cb23_Images/untitled.png", $carpeta1."/untitled.png");
					copy("cb23_Images/pdf.png", $carpeta1."/pdf.png");
					global $dat5b;
					$dat5b = "\tCREADO EL DIRECTORIO ".$carpeta1.".\n";
				} else{print("* NO HA CREADO EL DIRECTORIO ".$carpeta1."\n");
					global $dat5b;
					$dat5b = "\tNO CREADO EL DIRECTORIO ".$carpeta1.".\n";
					}

			} else {print( "* NO OK TABLA GASTOS. ".mysqli_error($db)."\n");
							global $dat5;
							$dat5 = "\tNO CREADA TABLA ".$vname.". ".mysqli_error($db).".\n";
					}
	} // FIN FUNCTION tgastos()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function newstatus(){

		global $db;	 		global $db_name;
		
		global $vname10; 	$vname10 = "`".$_SESSION['clave']."status`";
		global $year; 		$year = date('Y')/*+1*/;
		global $ycod;		$ycod = date('y');
		//$ycod = substr(trim($year),-2,2);
				
		global $stat; 		$stat = 'open';
		global $hidden; 	$hidden = 'no';
				
		$sqla9 = "INSERT INTO `$db_name`.$vname10 (`year`, `ycod`, `stat`, `hidden`) VALUES ('$year', '$ycod', '$stat', '$hidden')";
					
			if(mysqli_query($db, $sqla9)){ 			
				global $dat9;
				$dat9 = "\tACTUALIZADA TABLA ".$vname10.".\n";
			} else { print("* NO OK VALUES EN ".$vname10.". ".mysqli_error($db)."</br>");
					global $dat9;
					$dat9 = "\tNO CREADA TABLA ".$vname10.". ".mysqli_error($db).".\n";
				}
		
	} // FIN function newstatus()
					
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function ayear(){

		$filename = "cb23_Docs/year.txt";
		$fw2 = fopen($filename, 'r+');
		$fget = fgets($fw2);
		fclose($fw2);
		
		$carpeta1 = "cb23_Docs/docgastos_".date('Y');
		$carpeta2 = "cb23_Docs/docingresos_".date('Y');

		if($fget == date('Y')){
			/*print("<div style='clear:both'></div>
				<div style='width:200px'>* EL AÑO ES EL MISMO </div>".date('Y')." == ".$fget );*/
				
		} elseif(($fget != date('Y')) && (!file_exists($carpeta1)) && (!file_exists($carpeta2))){ 
			print(" <div style='clear:both'></div>
					<div style='width:200px'>* EL AÑO HA CAMBIADO </div>"/*.date('Y')." != ".$fget */);
			modif();
			modif2(); 		tingresos(); 		tgastos();
			newstatus();
			global $dat2;	global $dat3;	global $dat4;	global $dat4b;	global $dat5;
			global $dat5b;	global $dat6;	global $dat7;	global $dat8;	global $dat9;
			global $text;
			$text = $dat2.$dat3.$dat4.$dat4b.$dat5.$dat5b.$dat6.$dat7.$dat8.$dat9."\n";
		} elseif($fget != date('Y')){ modif();
									modif2();
									global $dat2;
									global $text; 	$text = $dat2."\n";
									}
		ini_log_cb23();

	} // FIN FUNCTION ayear()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function status_close(){
		
		global $db; 	global $db_name;
				
		global $ystatus; 	$ystatus = date('Y')-1; 	$ystatus = trim($ystatus);
		global $stdate; 	$stdate = date('Y'); 		$stdate = trim($stdate);
				
		global $t1; 		$t1 = "`".$_SESSION['clave']."status`";

		$sqls =  "SELECT * FROM $t1  WHERE $t1.`year` < '$stdate' AND $t1.`stat` = 'open' ORDER BY `year` DESC ";
		$qs = mysqli_query($db, $sqls);				
		$qsn = mysqli_num_rows($qs);
		$qsr = mysqli_fetch_assoc($qs);
		//print("* Valor año: ".$qsr['year'].". ");
				
		global $stmes; 		$stmes = trim(date('m'));
				
		if(!$qs){ print("* ".mysqli_error($db)."<br/>");
		} elseif($qsn > 0){ 
			//print("* ENTRADAS: ".$qsn.". "); 
		}

		/* PASA EL ESTADO DEL EJERCICIO AUTOMATICAMENTE A CLOSE */
		if((@$qsr['year'] == $ystatus) && ($qsn > 0) && ($ystatus < $stdate) && ($stmes > 1)){
			$sg1st = "UPDATE `$db_name`.$t1 SET `stat` = 'close' WHERE `year` = $ystatus AND `stat` = 'open' ";
			if(mysqli_query($db, $sg1st)){ 
				// print("* OK CLOSE EJERCICIO: ".$ystatus.".<br/>");
			} else {
				print("<font color='#FF0000'>* ".mysqli_error($db))."</br>";}
		}

		/* PASA EL ESTADO DEL EJERCICIO AUTOMATICAMENTE A OPEN */
		if((($qsn > 1)||($qsn == 1)) && (($qsr['year']-1) < $ystatus)){
			$sqls3 =  "SELECT $t1.`year` FROM $t1  WHERE `stat` = 'open' AND `year` < '$ystatus' ORDER BY `year` DESC";
			$qs3 = mysqli_query($db, $sqls3);				
			$qsn3 = mysqli_num_rows($qs3);
					
			$sg1st2 = "UPDATE `$db_name`.$t1 SET `stat` = 'close' WHERE `year` < $ystatus AND `stat` = 'open' ";
			if(mysqli_query($db, $sg1st2)){ 
				if($qsn3>0){print("* OK CLOSE ".$qsn3." YEAR: ");}
					while($rowi = mysqli_fetch_assoc($qs3)){
							print($rowi['year'].". ");
								}
							print("<br/>");
						} else {print("<font color='#FF0000'>* ".mysqli_error($db))."</br>";}
				}
						
	} // FIN function status_close()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){
		
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){	

		//print("Wellcome: ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].".");
			
			master_index();

			show_balance();
			
		}	else { require 'Inclu/table_permisos.php'; }
					
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_balance($errors=[]){
	
		global $ordenar;
		if(isset($_POST['filtroBal'])){
			$defaults = $_POST;
		} else { 
			$defaults = array ( 'id' => '',
								'year' => '',
								'mes' => '',
								'tot' => '',
								'Orden' => $ordenar);
							}

			$dm = array ( '' => 'MES TODOS',
						  'M01' => 'ENERO', 'M02' => 'FEBRERO', 'M03' => 'MARZO',
						  'M04' => 'ABRIL', 'M05' => 'MAYO', 'M06' => 'JUNIO',
						  'M07' => 'JULIO', 'M08' => 'AGOSTO', 'M09' => 'SEPTIEMBRE',
						  'M10' => 'OCTUBRE', 'M11' => 'NOVIEMBRE', 'M12' => 'DICIEMBRE',
						  'TRI0' => 'TRIMESTRAL', 'TRI1' => 'TRIMESTRE 1', 'TRI2' => 'TRIMESTRE 2',
						  'TRI3' => 'TRIMESTRE 3', 'TRI4' => 'TRIMESTRE 4', 'ANU' => 'ANUAL');

			$ordenar = array ('`factdate` ASC' => 'Fecha Asc',
							  '`factdate` DESC' => 'Fecha Desc',
							  '`factpvptot` ASC' => 'TOTAL Asc',
							  '`factpvptot` DESC' => 'TOTAL Desc',
							  '`factnif` ASC' => 'Nif Asc',
							  '`factnif` DESC' => 'Nif Desc',
							  '`id` ASC' => 'Id Asc',
							  '`id` DESC' => 'Id Desc');
	
		if ($errors){

			require 'Inclu_Index/tablaErrors.php';

		}
		
		print("<table class='tableForm' >
					<tr>
						<th>BALANCE CONTABLE & GRÁFICAS</th>
					</tr>
			<form name='filtroBal' method='post' action='$_SERVER[PHP_SELF]' >
					<tr>
						<td align='center'>
							<!--
							<input type='submit' value='FILTRO BALANCES' class='botonazul' />
							-->
			<button type='submit' title='FILTRO BALANCES' class='botonlila imgButIco BuscaWhite' style='vertical-align: middle' >
			</button>
						<input type='hidden' name='filtroBal' value=1 />
				<select name='Orden' title='ORDENAR POR...' class='botonlila' style='vertical-align: middle' >");
							
		foreach($ordenar as $option => $label){
				print ("<option value='".$option."' ");
					if($option == $defaults['Orden']){print ("selected = 'selected'");}
													print ("> $label </option>");
												}	
		print ("</select>
				<select name='dy' title='SELECCIONAR AÑO...' class='botonlila' style='vertical-align: middle' >
					<option value=''>YEAR</option>");
	
			global $db;
			global $t1; 		$t1 = "`".$_SESSION['clave']."status`";
			$sqly =  "SELECT * FROM $t1  WHERE `hidden` = 'no' ORDER BY `year` DESC ";
			$qy = mysqli_query($db, $sqly);				
				
			if(!$qy){print("* ".mysqli_error($db)."<br/>");
			}else{while($rowsy = mysqli_fetch_assoc($qy)){
								print ("<option value='".$rowsy['ycod']."' ");
									if($rowsy['ycod'] == @$defaults['dy']){
												print ("selected = 'selected'");
											}
												print ("> ".$rowsy['year']." </option>");
										}
									}  

		print ("</select>
				<select name='dm' title='SELECCIONAR MES...' class='botonlila' style='vertical-align: middle' >");

		foreach($dm as $optiondm => $labeldm){
					print ("<option value='".$optiondm."' ");
						if($optiondm == @$defaults['dm']){
										print ("selected = 'selected'");}
										print ("> $labeldm </option>");
						}	
																
		print ("</select>
					</form>											
				</td>
			</tr>
		</table>"); /* Fin del print */


		if(isset($_POST['filtroBal'])){
			global $dm1;
			if(($_POST['dm'] == '')||($_POST['dm'] == 'TRI0')){
				require 'Inclu_Index/indexConsultaTablasTrim.php';
			}else{
				require 'Inclu_Index/indexConsultaTablas.php';
			}
		}else{
			require 'Inclu_Index/indexConsultaTablasTrim.php';
		}

	}	/* Fin show_balance(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){

		global $rutaIndex;		$rutaIndex = "";
		require 'Inclu_MInd/MasterIndexVar.php';
		
		require 'Inclu_MInd/MasterIndex.php'; 
		
				} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function ini_log_cb23(){

		$ActionTime = date('H:i:s');

		global $text;

		$logdate = date('Y_m_d');

		$logtext = "** ".$ActionTime.PHP_EOL."\t** ".$text.PHP_EOL;
		$filename = "../Mod_Conta/config/logs/ini_log_".$logdate.".log";
		$log = fopen($filename, 'ab+');
		fwrite($log, $logtext);
		fclose($log);

		}

			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require 'Inclu/Conta_Footer.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>