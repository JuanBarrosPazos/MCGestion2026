<?php
session_start();

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../Inclu/Conta_Head.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 

		master_index();

		if(isset($_POST['oculto2'])){	show_form();
										info_01();
		} elseif(isset($_POST['oculto'])){ 	process_form();
											info_02();
		} else { show_form(); }
	
	} else { require '../Inclu/table_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){

		global $DeleteGreyTit;		$DeleteGreyTit = "PAPELERA STATUS EJERCICIOS";
		global $InicioBlackTit;		$InicioBlackTit = "INICIO STATUS EJERCICIOS";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		global $db; 		global $db_name;	
		
		global $vname; 		$vname = "`".$_SESSION['clave']."status`";
		global $id; 		$id = $_POST['id'];
		global $year; 		$year = $_POST['year'];
		global $ycod; 		$ycod = substr(trim($_POST['year']),-2,2);
		global $stat; 		$stat = $_POST['stat'];
		global $hidden; 	$hidden = $_POST['hidden'];
		
		$tabla = "<table class='tableForm' >
					<tr>
						<th colspan=4 >BORRADO EN ".strtoupper($vname)."</th>
					</tr>
					<tr align='center'>
						<td>YEAR</td>
						<td>CODE</td>
						<td>STATUS</td>
						<td>HIDDEN</td>
					</tr>
					<tr align='center'>
						<td>".$year."</td>
						<td>".$ycod."</td>
						<td>".$stat."</td>
						<td>".$hidden."</td>
					</tr>
					<tr>
					<td colspan='4' style='text-align:right;' >
						".$InicioBlack."
							<a href='status_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton.$DeleteGrey."
							<a href='status_feedback_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
						</td>
					</tr>
				</table>";	
		
		$sqla = "DELETE FROM `$db_name`.$vname WHERE `year` = '$year' AND `del`='true'";
	
		if(mysqli_query($db, $sqla)){ borrart(); 	borrard();
									  borrare(); 	print($tabla);
									  ver_todo(); 	ver_feedback();
		} else { print("* MODIFIQUE LA ENTRADA 114: ".mysqli_error($db));
				show_form ();
				global $texerror; 	$texerror = "\n\t ".mysqli_error($db);
			}
			
		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='status_feedback_Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
		
	} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function borrard(){
	
		global $db_name; 		global $sesionref;
		global $year; 			global $ycod;

		/* BORRAMOS DIRECTORIO Y ARCHIVOS INGRESOS => YEAR XXXX. */
			$dird1 = "../cb26_Docs/docingresos_".$year;
			if(file_exists($dird1)){ $dir1 = $dird1."/";
									 $handle1 = opendir($dir1);
								while ($file1 = readdir($handle1))
										{if (is_file($dir1.$file1))
											{unlink($dir1.$file1);}
												}
										rmdir ($dird1);
												global $dd1;
												$dd1 = "\t- BORRADA: ".$dird1."/ \n";
										} else {print("");}

		/* BORRAMOS TABLA, DIRECTORIO Y ARCHIVOS GASTOS => YEAR XXXX. */
			$dird2 = "../cb26_Docs/docgastos_".$year;
			if(file_exists($dird2)){ $dir2 = $dird2."/";
									 $handle2 = opendir($dir2);
								while ($file2 = readdir($handle2))
										{if (is_file($dir2.$file2))
											{unlink($dir2.$file2);}
												}
										rmdir ($dird2);
											global $dd2;
											$dd2 = "\t- BORRADA: ".$dird2."/ \n";
										} else {print("");}
	
	} // FIN function borrard()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function borrare(){
	
		global $db; 			global $db_name;	
		global $sesionref; 		global $year;
		global $ycod;

		global $fil;		$fil = $ycod."/%";
		
		global $vname6;		$vname6 = "`".$_SESSION['clave']."gastos_pendientes`";
		$vname6 = strtolower($vname6);	
		$sql6 = "DELETE FROM `$db_name`.$vname6 WHERE `factdate` LIKE '$fil' ";
		if(mysqli_query($db, $sql6)){} 
		else {print("* MODIFIQUE LA ENTRADA 207: ".mysqli_error($db));}

		global $vname7;		$vname7 = "`".$_SESSION['clave']."ingresos_pendientes`";
		$vname7 = strtolower($vname7);	
		$sql7 = "DELETE FROM `$db_name`.$vname7 WHERE `factdate` LIKE '$fil' ";
		if(mysqli_query($db, $sql7)){} 
		else {print("* MODIFIQUE LA ENTRADA 215: ".mysqli_error($db));}

	} // FIN function borrare()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function borrart(){
	
		global $db; 			global $db_name;	
		global $sesionref; 		global $year;
		global $ycod;
			
		/* BORRAMOS TABLA INGRESOS => YEAR XXXX. */
		global $vname1; 		$vname1 = "`".$_SESSION['clave']."ingresos_".$year."`";
		$sql1 = "DROP TABLE `$db_name`.$vname1 ";
		if(mysqli_query($db, $sql1)){ 
					} else {
						print("* MODIFIQUE LA ENTRADA 234: ".mysqli_error($db));
							}
		
		/* BORRAMOS TABLA  GASTOS => YEAR XXXX. */
		global $vname2; 		$vname2 = "`".$_SESSION['clave']."gastos_".$year."`";
		$sql2 = "DROP TABLE `$db_name`.$vname2 ";
		if(mysqli_query($db, $sql2)){ 
				} else {
					print("* MODIFIQUE LA ENTRADA 244: ".mysqli_error($db));
						}

	} // FIN function borrart()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function ver_todo(){
			
		global $db; 		global $db_name;
		
		global $vname; 		$vname = "`".$_SESSION['clave']."status`";

		$sqlb =  "SELECT * FROM $vname ORDER BY `year` DESC ";
		$qb = mysqli_query($db, $sqlb);

		if(!$qb){
			print("<font color='#F1BD2D'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
		} else {
			if(mysqli_num_rows($qb) == 0){

				global $titNoData;	$titNoData = "TABLA ".strtoupper($vname)."<br><br>";
				require 'status_NoData.php';

			} else { print ("<table class='tableForm' >
								<tr>
									<th colspan=6 >
										EJERCCIOS STATUS ".mysqli_num_rows($qb)."
									</th>
								</tr>
								<tr align='center'>
									<th>ID</th><th>YEAR</th><th>ICOD</th>									
									<th>STATE</th<th>HIDDEN</th>										
								</tr>");
			
				global $styleBgc; global $i; $i = 1;

			while($rowb = mysqli_fetch_assoc($qb)){

				if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
				$i++;
	
			print (	"<tr  class='".$styleBgc."'>
						<td align='center'>".$rowb['id']."</td>
						<td align='center'>".$rowb['year']."</td>
						<td align='center'>".$rowb['ycod']."</td>
						<td align='center'>".$rowb['stat']."</td>
						<td align='center'>".$rowb['hidden']."</td>
					</tr>");
				} /* Fin del while.*/ 

			print("	</table> ");
			
			} /* Fin segundo else anidado en if */

		} /* Fin de primer else . */

	}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_feedback(){
		
	global $db; 		global $db_name;
	
	global $vname; 		$vname = "`".$_SESSION['clave']."status`";

	$sqlb =  "SELECT * FROM $vname WHERE `del`='true' ORDER BY `year` DESC ";
	$qb = mysqli_query($db, $sqlb);

	if(!$qb){
			print("<font color='#F1BD2D'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
	} else {
		if(mysqli_num_rows($qb) == 0){
			
			global $titNoData;	$titNoData = "TABLA ".strtoupper($vname)."<br><br>";
			require 'status_NoData.php';

		} else { print ("<table class='tableForm'>
							<tr>
								<th colspan=6 >
									FEEDBACK EJERCICIOS ".mysqli_num_rows($qb)."
								</th>
							</tr>
							<tr align='center'>
								<th>ID</th><th>YEAR</th><th>ICOD</th>					
								<th>STATE</th><th>HIDDEN</th><th>DATE</th>							
							</tr>");
			
				global $styleBgc; global $i; $i = 1;

			while($rowb = mysqli_fetch_assoc($qb)){

				if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
				$i++;
	
			print (	"<tr class='".$styleBgc."'>
						<td align='center'>".$rowb['id']."</td>
						<td align='center'>".$rowb['year']."</td>
						<td align='center'>".$rowb['ycod']."</td>
						<td align='center'>".$rowb['stat']."</td>
						<td align='center'>".$rowb['hidden']."</td>
						<td align='center'>".$rowb['date']."</td>
					</tr>");
				} /* Fin del while.*/ 

			print("	</table> ");
			
			} /* Fin segundo else anidado en if */

		} /* Fin de primer else . */

	}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form(){

		global $DeleteGreyTit;		$DeleteGreyTit = "PAPELERA STATUS EJERCICIOS";
		global $DeleteWhiteTit;		$DeleteWhiteTit = "ELIMINAR FEEDBACK EJERCICIO";
		global $InicioBlackTit;		$InicioBlackTit = "INICIO STATUS EJERCICIOS";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		global $db; 	global $db_name;
	
		if(isset($_POST['oculto2'])){	
			$defaults = array (	'id' => $_POST['id'],
								'year' => $_POST['year'],	
								'ycod' => $_POST['ycod'],	
								'stat' => $_POST['stat'],
								'hidden' => $_POST['hidden'],
								'sesion' => @$_POST['sesion']);
		} elseif(isset($_POST['oculto'])){
				$defaults = $_POST;
		} else { $defaults = array ( 'id' => $_POST['id'],
									'year' => $_POST['year'],	
									'ycod' => $_POST['ycod'],	
									'stat' => $_POST['stat'],
									'hidden' => $_POST['hidden'],	
									'sesion' => @$_POST['sesion']);
								}

		$stat = array (	'open' => 'STATE OPEN',
						'close' => 'STATE CLOSE');
											
		$hidden = array (	'no' => 'HIDDEN NO',
							'si' => 'HIDDEN YES');

	////////////////////

	print("<table class='tableForm' >
				<tr>
					<th colspan=4 >
						BORRARDO TOTAL FEEDBACK EJERCICIO					
					</th>
				</tr>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td align='center'>YEAR</td>
					<td align='center'>CODE</td>
					<td align='center'>STATUS</td>
					<td align='center'>HIDDEN</td>
				</tr>
				<tr>
					<td>
		<input name='year' type='hidden' value='".$defaults['year']."' />".$defaults['year']."
		<input name='id' type='hidden' value='".$defaults['id']."' />
		<input name='sesion' type='hidden' value='".$defaults['sesion']."' />
					</td>
					<td align='center'>
		<input name='ycod' type='hidden' value='".$defaults['ycod']."' />".$defaults['ycod']."
					</td>
					<td align='center'>
		<input name='stat' type='hidden' value='".$defaults['stat']."' />".$defaults['stat']."
					</td>
					<td align='center'>
		<input name='hidden' type='hidden' value='".$defaults['hidden']."' />".$defaults['hidden']."
					</td>
				</tr>
				<tr>
					<td colspan='4' style='text-align:right;' >
						".$DeleteWhite.$closeButton."
							<input type='hidden' name='oculto' value=1 />
			</form>														
						".$InicioBlack."
							<a href='status_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton.$DeleteGrey."
							<a href='status_feedback_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
					</td>
				</tr>
			</table>"); 
	
	} // FIN function show_form()	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info_01(){

		global $db;
		
		$ActionTime = date('H:i:s');

		global $dir;
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
					$dir = "../cb26_Docs/log";
					}
	
		global $text;
		$text = "\n- FEEDBACK ELIMINAR SELECCIONADO ".$ActionTime.".\n\t ID: ".$_POST['id'].".\n\t YEAR: ".$_POST['year'].".\n\t STATUS: ".$_POST['stat'].".\n\t HIDDEN: ".$_POST['hidden'].".";

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

	function info_02(){

		global $db;
		
		$ActionTime = date('H:i:s');

		global $dir;
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
					$dir = "../cb26_Docs/log";
					}
		
		global $text;
		$text = "\n- FEEDBACK ELIMINADO ".$ActionTime.".\n\t ID: ".$_POST['id'].".\n\t YEAR: ".$_POST['year'].".\n\t STATUS: ".$_POST['stat'].".\n\t HIDDEN: ".$_POST['hidden'].".";

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