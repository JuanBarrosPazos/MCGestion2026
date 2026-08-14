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
					ver_todo();
					info();
									
	} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function ver_todo(){
		
		global $RestoreBlackTit;	$RestoreBlackTit = "RECUPERAR FEEDBACK EJERCICIO";
		global $DeleteWhiteTit;		$DeleteWhiteTit = "BORRAR STATUS EJERCICIO";
		global $InicioBlackTit;		$InicioBlackTit = "INICIO STATUS EJERCICIOS";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		global $db; 		global $db_name;
		
		global $vname; 		$vname = "`".$_SESSION['clave']."status`";

		$sqlb =  "SELECT * FROM $vname WHERE `del`='true' ORDER BY `year` ASC ";
		$qb = mysqli_query($db, $sqlb);

		if(!$qb){
			print("<font color='#FF0000'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
		} else {
			if(mysqli_num_rows($qb) == 0){

				global $titNoData;	$titNoData = "TABLA ".strtoupper($vname)."<br><br>";
				require 'status_NoData.php';

			}else{ print ("<table class='tableForm' >
							<tr>
								<th colspan=8>
							RECUPERAR FEEDBACK EJERCCIOS ".mysqli_num_rows($qb)." RESULTADOS
								</th>
							</tr>
							<tr>
								<th>ID</th><th>YEAR</th><th>ICOD</th>
								<th>STATE</th><th>HIDDEN</th><th>DATE</th>
								<th colspan=2>
									".$InicioBlack."
										<a href='status_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
									".$closeButton."
								</th>
							</tr>");
			
			global $styleBgc; global $i; $i = 1;

		while($rowb = mysqli_fetch_assoc($qb)){

			if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
			$i++;

			print (	"<tr class='".$styleBgc."'>
				<form name='modifica' action='status_feedback_recuperar_02.php' method='POST'>
						<td align='center'>
					<input name='id' type='hidden' value='".$rowb['id']."' />".$rowb['id']."
						</td>
						<td align='center'>
					<input name='year' type='hidden' value='".$rowb['year']."' />".$rowb['year']."
						</td>
						<td align='center'>
					<input name='ycod' type='hidden' value='".$rowb['ycod']."' />".$rowb['ycod']."
						</td>
						<td align='center'>
					<input name='stat' type='hidden' value='".$rowb['stat']."' />".$rowb['stat']."
						</td>
						<td align='center'>
					<input name='hidden' type='hidden' value='".$rowb['hidden']."' />".$rowb['hidden']."
						</td>
						<td align='center'>
					<input name='date' type='hidden' value='".$rowb['date']."' />".$rowb['date']."
						</td>
						<td align='right'>
							".$RestoreBlack.$closeButton."
					<input type='hidden' name='oculto2' value=1 />
				</form>
						</td>
						<td >
				<form name='modifica' action='status_feedback_borrar_02.php' method='POST'>
					<input name='id' type='hidden' value='".$rowb['id']."' />
					<input name='year' type='hidden' value='".$rowb['year']."' />
					<input name='ycod' type='hidden' value='".$rowb['ycod']."' />
					<input name='stat' type='hidden' value='".$rowb['stat']."' />
					<input name='hidden' type='hidden' value='".$rowb['hidden']."' />
					<!--
					<input type='submit' value='BORRAR FEEDBACK EJERCICIO' />
					-->
						".$DeleteWhite.$closeButton."
							<input type='hidden' name='oculto2' value=1 />
				</form>
						</td>
					</tr>");
				} /* Fin del while.*/ 

				print("</table>");
			
			} /* Fin segundo else anidado en if */

		} /* Fin de primer else . */

	}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaStatus;	$rutaStatus = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info(){

		global $db;
		global $nombre;		$nombre = "STATUS TODOS LOS EJERCICIOS";
		
		global $orden;
		if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
			$orden = $_POST['Orden'];
		}else{ $orden = '`id` ASC'; }

		$ActionTime = date('H:i:s');

		global $dir;
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
					$dir = "../cb23_Docs/log";
					}
		
		global $text;
		$text = "\n- FEEDBACK EJERCICIO RECUPERA 1: ".$ActionTime.".\n\t Filtro => ".$nombre.".";
		
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

	require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>