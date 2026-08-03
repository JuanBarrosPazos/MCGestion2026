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

				if(isset($_POST['delete'])){	delete();
											listfiles();
											info_del();
										}
				elseif(isset($_POST['backupm'])){
											manual_backup();
											listfiles();
											info();
											}
				elseif(isset($_POST['downl'])){
											listfiles();
											red();
											info_downl();
											}
					else {	listfiles();}
								
				} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function red(){

	global $redir;
	$redir = "<script type='text/javascript'>
					function redir(){
					window.location.href='".$_POST['ruta']."' ;
				}
				setTimeout('redir()',1000);
				</script>";
	print ($redir);

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function manual_backup(){

	require 'bbdd_My_export_tot.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function listfiles(){

	print ("<table style='margin-top:2px;'>
				<tr>
					<td colspan=2 style='text-align:center;' >
			<a href='bbdd.php' class='botonazul' style=' color: #343434 !important;' >EXPORTAR BBDD TABLAS</a>
					</td>
				</tr>
				<tr>
					<td align='center'>
						<form name='delete' action='$_SERVER[PHP_SELF]' method='post'>
				<input type='submit' value='REALIZAR UNA EXPORTACION MANUAL DE BBDD AHORA' class='botonverde' />
				<input type='hidden' name='backupm' value='1' >
						</form>
					</td>
				</tr>
			</table>");

	if(isset($_SESSION['tablas']) == ''){ $_SESSION['tablas'] = $_SESSION['ref']; }
	//print("*".$_SESSION['tablas'].".</br>");

	global $ruta;
	$ruta ="bbdd_export_tot/";
	//print("RUTA: ".$ruta.".</br>");
	
	global $rutag;
	$rutag = "bbdd_export_tot/{*}";
	//print("RUTA G: ".$rutag.".</br>");
		
	$directorio = opendir($ruta);
	global $num;
	$num=count(glob($rutag,GLOB_BRACE));
	if($num < 1){
		
		print ("<table align='center' style='border:1; margin-top:2px' width='auto'>
				<tr>
				<td align='center'>NO HAY ARCHIVOS PARA DESCARGAR</td>
				</tr>");
	}else{
		
	print ("<table align='center' style='border:1; margin-top:2px' width='auto'>
				<tr>
					<td align='center' colspan='3' class='BorderInf'>
						DESCARGAR BBDD BACKUP AUTO Y MANUAL .SQL
					</td>
				</tr>");

	while($archivo = readdir($directorio)){
		if($archivo != ',' && $archivo != '.' && $archivo != '..'){
			print("<tr>
			<td class='BorderInfDch'>
				<form name='delete' action='$_SERVER[PHP_SELF]' method='POST'>
					<input type='hidden' name='tablas' value='".$_SESSION['tablas']."' />
					<input type='hidden' name='ruta' value='".$ruta.$archivo."' />
					<input type='submit' value='ELIMINAR' class='botonrojo' />
					<input type='hidden' name='delete' value='1' />
				</form>
			</td>
			<td class='BorderInfDch'>
				<form name='archivos' action='$_SERVER[PHP_SELF]' method='POST'>
					<input type='hidden' name='tablas' value='".$_SESSION['tablas']."' />
					<input type='hidden' name='ruta' value='".$ruta.$archivo."' />
					<input type='submit' value='DESCARGAR' class='botonverde' />
					<input type='hidden' name='downl' value='1' />
				</form>
			</td>
			<td class='BorderInf'>".strtoupper($archivo)."</td>
			");
		}else{}
	} // FIN DEL WHILE
	}
	closedir($directorio);
	print("</table>");
}

function delete(){unlink($_POST['ruta']);}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $datebbddx;
	
	$ActionTime = date('H:i:s');

	global $dir2;
	$dir2 = "bbdd_log";
	
	global $text2;
	$text2 = PHP_EOL."- RESPALDADO CREADO MANUALMENTE BBDD POR: ".$_SESSION['ref']." ".$ActionTime.PHP_EOL."\t NOMBRE BBDD: ".$datebbddx.".sql";

	$logdate2 = date('Y_m_d');
	$logtext2 = $text2.PHP_EOL;
	$filename2 = $dir2."/".$logdate2.".log";
	$log2 = fopen($filename2, 'ab+');
	fwrite($log2, $logtext2);
	fclose($log2);

	}

					////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info_del(){

	global $datebbddx;
	
	$ActionTime = date('H:i:s');

	global $dir2;
	$dir2 = "bbdd_log";
	
	global $text2;
	$text2 = PHP_EOL."- RESPALDO BORRADO MANUALMENTE BBDD POR: ".$_SESSION['ref']." ".$ActionTime.PHP_EOL."\t NOMBRE BBDD: ".$_POST['ruta'];

	$logdate2 = date('Y_m_d');
	$logtext2 = $text2.PHP_EOL;
	$filename2 = $dir2."/".$logdate2.".log";
	$log2 = fopen($filename2, 'ab+');
	fwrite($log2, $logtext2);
	fclose($log2);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				 ///////////////////

function info_downl(){

	global $datebbddx;
	
	$ActionTime = date('H:i:s');

	global $dir2;
	$dir2 = "bbdd_log";
	
	global $text2;
	$text2 = PHP_EOL."- RESPALDO DESCARGADO MANUALMENTE BBDD POR: ".$_SESSION['ref']." ".$ActionTime.PHP_EOL."\t NOMBRE BBDD: ".$_POST['ruta'];

	$logdate2 = date('Y_m_d');
	$logtext2 = $text2.PHP_EOL;
	$filename2 = $dir2."/".$logdate2.".log";
	$log2 = fopen($filename2, 'ab+');
	fwrite($log2, $logtext2);
	fclose($log2);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaUpBbdd;	$rutaUpBbdd = "";
		require '../Inclu_MInd/MasterIndex.php'; 
					
	} /* Fin funcion master_index.*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Conta_Footer.php';

					   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>
