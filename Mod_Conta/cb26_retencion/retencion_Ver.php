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
		
	global $AddBlackTit;		$AddBlackTit = "CREAR TIPO RETENCION";
	global $CachedBlackTit;		$CachedBlackTit = "MODIFICAR % RETENCION";
	global $DeleteWhiteTit;		$DeleteWhiteTit = "BORRAR";
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	global $db; 		global $db_name;
	$orden = '`ret` ASC';
	
	global $vname; 		$vname = "`".$_SESSION['clave']."retencion`";

	$sqlb =  "SELECT * FROM $vname ORDER BY $orden ";
	$qb = mysqli_query($db, $sqlb);

	if(!$qb){
			print("<font color='#FF0000'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
	} else {
			if(mysqli_num_rows($qb) == 0){

				global $titNoData;	$titNoData = "TABLA ".strtoupper($vname)."<br><br>";
				require 'retencion_NoData.php';
				
			} else { 
				print ("<table class='tableForm' >
						<tr>
							<th colspan=5 class='BorderInf'>
								TIPOS % RETENCIONES ".mysqli_num_rows($qb)." RESULTADOS.
							</th>
						</tr>
						<tr>
							<th>ID</th>
							<th>VALUE %</th>
							<th>NAME</th>
							<th colspan=2>
								".$AddBlack."
									<a href='retencion_Crear.php' >&nbsp;&nbsp;&nbsp;&nbsp</a>
								".$closeButton."
							</th>
						</tr>");
			
				global $styleBgc; global $i; $i = 1;

			while($rowb = mysqli_fetch_assoc($qb)){

				if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
				$i++;
	
				if($rowb['ret'] != 0.00){

					print (	"<tr class='".$styleBgc."'>
						<form name='modifica' action='retencion_Modificar_02.php' method='POST'>
								<td align='center'>
							<input name='id' type='hidden' value='".$rowb['id']."' />".$rowb['id']."
								</td>
								<td align='center'>
							<input name='ret' type='hidden' value='".$rowb['ret']."' />".$rowb['ret']."
								</td>
								<td align='center'>
							<input name='name' type='hidden' value='".$rowb['name']."' />".$rowb['name']."
								</td>
								<td align='center'>
								".$CachedBlack.$closeButton."
									<input type='hidden' name='oculto2' value=1 />
						</form>
								</td>
								<td align='center'>
				<form name='modifica' action='retencion_Borrar_02.php' method='POST'>
						<input name='id' type='hidden' value='".$rowb['id']."' />
						<input name='ret' type='hidden' value='".$rowb['ret']."' />
						<input name='name' type='hidden' value='".$rowb['name']."' />
					<!--
						<input type='submit' class='botonrojo'  value='BORRAR % RETENCIONES' />
					-->
						".$DeleteWhite.$closeButton."
							<input type='hidden' name='oculto2' value=1 />
						</form>
								</td>
							</tr>");
						} // FIN IF
					} /* Fin del while.*/ 
			print("	</table> ");
			
			} /* Fin segundo else anidado en if */

		} /* Fin de primer else . */

	}	/* FINAL ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaRetencion;	$rutaRetencion = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info(){

		global $db; 		global $rowout;
		global $nombre; 	global $apellido;
		
		global $orden;
		if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
			$orden = $_POST['Orden'];
		}else{ $orden = '`id` ASC'; }

		if(isset($_POST['todo'])){$nombre = "TODOS LOS RETENCIONES ".$orden;};	

		$ActionTime = date('H:i:s');

		global $dir;
		if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
					$dir = "../cb26_Docs/log";
					}
		
		global $text;
		$text = "\n- RETENCIONES MODIFICAR BUSCAR: ".$ActionTime.".\n\t Filtro => ".$nombre.".";
		
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