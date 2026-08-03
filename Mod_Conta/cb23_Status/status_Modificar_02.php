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

		if(isset($_POST['oculto2'])){ show_form();
									  info_01();
		} elseif(isset($_POST['oculto'])){ 	process_form();
											info_02();
		} else { show_form(); }
	
	} else { require '../Inclu/table_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){
	
		global $InicioBlackTit;		$InicioBlackTit = "STATUS EJERCICIOS";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		global $db; 		global $db_name;	
		
		global $vname; 		$vname = "`".$_SESSION['clave']."status`";

		global $id; 		$id = $_POST['id'];
		global $year; 		$year = $_POST['year'];
		$ycod = substr(trim($_POST['year']),-2,2);
		global $stat; 		$stat = $_POST['stat'];
		global $hidden; 	$hidden = $_POST['hidden'];

		$tabla = "<table class='tableForm' >
					<tr>
						<th colspan=4 class='BorderInf'>
							MODIFICADO EN ".strtoupper($vname)."
						</th>
					</tr>
					<tr align='center'>
						<td class='BorderInf'>YEAR</td>
						<td class='BorderInf'>CODE</td>
						<td class='BorderInf'>STATUS</td>
						<td class='BorderInf'>HIDDEN</td>
					</tr>
					<tr align='center'>
						<td  class='BorderInf'>".$year."</td>
						<td  class='BorderInf'>".$ycod."</td>
						<td  class='BorderInf'>".$stat."</td>
						<td  class='BorderInf'>".$hidden."</td>
					</tr>
					<tr>
					<td colspan='4' style='text-align:right;' >
						".$InicioBlack."
							<a href='status_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
					</td>
				</tr>
			</table>";	
			
		$sqla = "UPDATE `$db_name`.$vname SET `year` = '$year', `ycod` = '$ycod', `stat` = '$stat', `hidden` = '$hidden' WHERE `year` = '$year'";
			
		if(mysqli_query($db, $sqla)){ print($tabla); 
									  ver_todo();
		} else { print("* MODIFIQUE LA ENTRADA 111: ".mysqli_error($db));
					show_form ();
					global $texerror;		$texerror = "\n\t ".mysqli_error($db);
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

	function ver_todo(){
			
		global $db; 		global $db_name;
		
		global $vname; 		$vname = "`".$_SESSION['clave']."status`";

		$sqlb =  "SELECT * FROM $vname ORDER BY `year` DESC ";
		$qb = mysqli_query($db, $sqlb);

		if(!$qb){
				print("<font color='#FF0000'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
		}else{
				
			if(mysqli_num_rows($qb) == 0){

				global $titNoData;	$titNoData = "TABLA ".strtoupper($vname)."<br><br>";
				require 'status_NoData.php';

			} else {print ("<table class='tableForm' >
							<tr>
								<th colspan=6 class='BorderInf'>
									EJERCCIOS STATUS ".mysqli_num_rows($qb)."
								</th>
							</tr>
							<tr align='center'>
								<th class='BorderInf'>ID</th>
								<th class='BorderInf'>YEAR</th>	
								<th class='BorderInf'>ICOD</th>		
								<th class='BorderInf'>STATE</th>
								<th class='BorderInf'>HIDDEN</th>	
							</tr>");
			
			global $styleBgc; global $i; $i = 1;

		while($rowb = mysqli_fetch_assoc($qb)){

			if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
			$i++;

			print (	"<tr class='".$styleBgc."'>
						<td class='BorderInf' align='center'>".$rowb['id']."</td>
						<td class='BorderInf' align='center'>".$rowb['year']."</td>
						<td class='BorderInf' align='center'>".$rowb['ycod']."</td>
						<td class='BorderInf' align='center'>".$rowb['stat']."</td>
						<td class='BorderInf' align='center'>".$rowb['hidden']."</td>
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
		
		global $InicioBlackTit;		$InicioBlackTit = "INICIO STATUS EJERCICIOS";
		global $SaveBlackTit;		$SaveBlackTit = "MODIFICAR STATUS EJERCICIOS";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		global $db; 		global $db_name;
		
		if(isset($_POST['oculto2'])){	
					$defaults = array (	'id' => $_POST['id'],
										'year' => $_POST['year'],	
										'ycod' => $_POST['ycod'],	
										'stat' => $_POST['stat'],
										'hidden' => $_POST['hidden']);
		} elseif(isset($_POST['oculto'])){
				$defaults = $_POST;
		} else { $defaults = array ( 'id' => $_POST['id'],
									'year' => $_POST['year'],	
									'ycod' => $_POST['ycod'],	
									'stat' => $_POST['stat'],
									'hidden' => $_POST['hidden']);
								}

		$stat = array (	'open' => 'STATE OPEN',
						'close' => 'STATE CLOSE');
											
		$hidden = array (	'no' => 'HIDDEN NO',
							'si' => 'HIDDEN YES');

	////////////////////

		print("<table class='tableForm' >
					<tr>
						<th colspan=4 >MODIFICAR STATUS EJERCICIO</th>
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
					</td>
					<td align='center'>
		<input name='ycod' type='hidden' value='".$defaults['ycod']."' />".$defaults['ycod']."
						</td>
						<td>
			<select name='stat'>");

			foreach($stat as $option => $stat1){
						print ("<option value='".$option."' ");
						if($option == $defaults['stat']){
										print ("selected = 'selected'");
													}
								print ("> $stat1 </option>");
									}	
		print ("</select>
					</td>
					<td>
				<select name='hidden'>");
					foreach($hidden as $option => $hidden1){
						print ("<option value='".$option."' ");
						if($option == $defaults['hidden']){
										print ("selected = 'selected'");
												}
								print ("> $hidden1 </option>");
									}	
		print ("</select>
						</td>
					</tr>
					<tr>
						<td colspan='4' style='text-align:right;' >
							".$SaveBlack.$closeButton."
							<input type='hidden' name='oculto' value=1 />
			</form>	
					<div style='display:inline-block; float:left !important;' >
						".$InicioBlack."
							<a href='status_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
						".$closeButton."
					</div>
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
					$dir = "../cb23_Docs/log";
					}
		
		global $text;
		$text = "\n- STATUS MODIFICAR SELECCIONADO ".$ActionTime.".\n\t ID: ".$_POST['id'].".\n\t YEAR: ".$_POST['year'].".\n\t STATUS: ".$_POST['stat'].".\n\t HIDDEN: ".$_POST['hidden'].".";

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
					$dir = "../cb23_Docs/log";
					}
		
		global $text;
		$text = "\n- STATUS MODIFICADO ".$ActionTime.".\n\t ID: ".$_POST['id'].".\n\t YEAR: ".$_POST['year'].".\n\t STATUS: ".$_POST['stat'].".\n\t HIDDEN: ".$_POST['hidden'].".";

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