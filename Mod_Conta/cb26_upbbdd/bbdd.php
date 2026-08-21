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

		if(isset($_POST['delete'])){ delete();
									 show_form();
								 	 listfiles();
										}
	
		elseif(isset($_POST['oculto2'])){ show_form();
								  		  ver_todo();
							  			  listfiles();

				} else {  show_form();
						  listfiles();
							}
								
			} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $db;
	global $db_name;
	
	if((isset($_POST['oculto2']))||(isset($_POST['delete']))){
					$_SESSION['tablas'] = strtolower($_POST['tablas']);
					$defaults = array ('Orden' => isset($ordenar),
								   	   'tablas' => strtolower($_POST['tablas']),
								   						);
					// print($_SESSION['tablas']);
										}
	else{unset($_SESSION['tablas']);}
	
			////////////////////		**********  		////////////////////

	global $nom;
	$nom = strtolower(@$_SESSION['tablas']);
	if (strtolower(@$_SESSION['tablas']) == 'admin'){$nom = $nom;}
	else{$nom = $nom."%";}
	$nom = "LIKE '$nom'";
	
/* Se busca las tablas en la base de datos */

	//$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES ";
	$consulta = "SHOW TABLES FROM $db_name $nom";
	$respuesta = mysqli_query($db, $consulta);
	if(!$respuesta){
	print("<font color='#F1BD2D'>194 Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
		
	} else {print( "<table align='center'>
						<tr>
							<td colspan=2 style='text-align:center;' >
		<a href='export_bbdd_backups.php' class='botonazul' style=' color: #343434 !important;' >EXPORTAR BBDD COMPLETA</a>
							</td>
						</tr>
						<tr>
							<th colspan=2 class='BorderInf'>
								NUMERO DE TABLAS ".(mysqli_num_rows($respuesta)-2).".
							</th>
						</tr>");

			while ($fila = mysqli_fetch_row($respuesta)) {

				if(($fila[0] != $_SESSION['clave']."visitasadmin")&&($fila[0] != $_SESSION['clave']."ipcontrol")){
					print(	"<tr>
							<td class='BorderInfDch'>
											".$fila[0]."
							</td>
							<td class='BorderInf'>
				<form name='exporta' action='$_SERVER[PHP_SELF]' method='POST'>
					<input type='hidden' name='tablas' value='".@$defaults['tablas']."' />
					<input name='tabla' type='hidden' value='".$fila[0]."' />
					<input type='submit' value='EXPORTA TABLA ".strtoupper($fila[0])."' class='botonverde'/>
					<input type='hidden' name='oculto2' value=1 />
				</form>
							</td>
						<tr>");
				}
					}	// FIN WHILE

			print("</table>");		
				}
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
	
		require 'export_bbdd.php';

	}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function listfiles(){
	
	global $ruta;
	$ruta ="bbdd/";
	
	$directorio = opendir($ruta);
	global $num;
	$num=count(glob("bbdd/{*}",GLOB_BRACE));
	if($num < 1){print ("<table align='center' style='border:1; margin-top:2px' width='auto'>
	<tr><td align='center' class='BorderInf'>NO HAY ARCHIVOS PARA DESCARGAR</td></tr>");
	}else{
		
	print ("<table align='center' style='border:1; margin-top:2px' width='auto'>
	<tr><td align='center' colspan='3' class='BorderInf'>ARCHIVOS RESPALDO BBDD </td></tr>");
	while($archivo = readdir($directorio)){
		if($archivo != ',' && $archivo != '.' && $archivo != '..'){
			print("<tr>
			<td class='BorderInfDch'>
			<form name='delete' action='$_SERVER[PHP_SELF]' method='post'>
			<input type='hidden' name='tablas' value='".@$_SESSION['tablas']."' />
			<input type='hidden' name='ruta' value='".$ruta.$archivo."'>
			<input type='submit' value='ELIMINAR' class='botonnaranja' >
			<input type='hidden' name='delete' value='1' >
			</form>
			</td>
			<td class='BorderInfDch'>
			<form name='archivos' action='".$ruta.$archivo."' target='_blank' method='post'>
			<input type='hidden' name='tablas' value='".@$_SESSION['tablas']."' />
			<input type='submit' value='DESCARGAR' class='botonazul' >
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
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaUpBbdd;	$rutaUpBbdd = "";
		require '../Inclu_MInd/MasterIndex.php'; 

			}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Conta_Footer.php';
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por Juan Manuel Barros Pazos 2020/21 */

?>