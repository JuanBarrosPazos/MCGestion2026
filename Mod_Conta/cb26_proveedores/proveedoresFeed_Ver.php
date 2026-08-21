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

	global $KeyForm; 	$KeyForm = "feed";

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 

		master_index();

		require 'Logica_01.php';
									
	} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
		
		require 'Show_Form_Val.php';
		
		return $errors;

	} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){
		
		global $db; 		global $db_name;
		global $nombre;		$nombre = @$_POST['Nombre'];
		global $apellido;	$apellido = @$_POST['Apellidos'];
		
		show_form();
		
		require 'proveedores_ConsultaLogica.php';

		global $vname; 		$vname = "`".$_SESSION['clave']."proveedores`";


		$sqlc =  "SELECT * FROM `$db_name`.$vname WHERE `ref`<>'ANONIMO' AND $ref $rso AND `del`='true' ORDER BY $orden ";
		echo $sqlc."<br>";

		$qc = mysqli_query($db, $sqlc);
		
		if(!$qc){
				print("<font color='#F1BD2D'>
						Se ha producido un error: </font>".mysqli_error($db)."</br></br>");
		} else {
				
			if(mysqli_num_rows($qc)== 0){

				global $titNoData;	$titNoData = "TABLA ".strtoupper($vname)."<br><br>";
				require 'proveedores_NoData.php';

			} else { 	
				print ("<table class='tableForm' >
						<tr>
							<th colspan=11 class='BorderInf'>PAPELERA proveedores ".mysqli_num_rows($qc)."</th>
						</tr>
						<tr>
							<th>ID</th>
							<th>REFERENCIA</th>
							<th>DNI</th>
							<th>RAZON SOCIAL</th>
							<th></th>
							<th>DELETE</th>
							<th colspan='5'>ACCIONES</th>
					</tr>");
				
			global $DetalleBlackTit;	$DetalleBlackTit = "VER DETALLES";
			global $RestoreBlackTit;	$RestoreBlackTit = "RECUPERAR DATOS CLIENTE";
			global $DeleteWhiteTit;		$DeleteWhiteTit = "BORRAR";
			require '../Inclu/BotoneraVar.php';
			global $closeButton;

			global $styleBgc; global $i; $i = 1;

			while($rowb = mysqli_fetch_assoc($qc)){

				if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
				$i++;
	
			print (	"<tr class='".$styleBgc."'>
										
		<form name='ver' action='proveedoresFeed_Ver_02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=550px,height=460px')\">

			<td align='left'>".$rowb['id']."</td>
			<td align='left'>".$rowb['ref']."</td>
			<td align='left'>".$rowb['dni'].$rowb['ldni']."</td>
			<td align='left'>".$rowb['rsocial']."</td>
			<td>
				<img src='../cb26_Docs/img_proveedores/".$rowb['myimg']."' height='40px' width='30px' />
			</td>

			<td>".$rowb['borrado']."</td>");

			require 'proveedores_rowTotal.php';

		print("<td colspan=2 align='center'>
					<!--
						<input type='submit' value='VER DETALLES' class='botonverde' />
					-->
					".$DetalleBlack.$closeButton."
						<input type='hidden' name='oculto2' value=1 />
			</td>
				</form>

			<td align='center'>
				<form name='modifica' action='proveedoresFeed_Recuperar_02.php' method='POST'>");

				require 'proveedores_rowTotal.php';
	
		print("<!--
				<input type='submit' value='RECUPERAR DATOS' class='botonnaranja' />
				-->
					".$RestoreBlack.$closeButton."
						<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>	
			<td align='center'>
				<form name='modifica' action='proveedoresFeed_Borrar_02.php' method='POST'>");

				require 'proveedores_rowTotal.php';
	
		print("<!--
					<input type='submit' value='BORRAR DATOS' class='botonrojo' />
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
			
	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){
		
		global $PersonAddBlackTit;		$PersonAddBlackTit = "CREAR NUEVO CLIENTE";
		global $DeleteBlackTit;			$DeleteBlackTit = "VER TODO PAPELERA proveedores";
		global $PersonsBlackTit;		$PersonsBlackTit = "VER TODOS LOS proveedores";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		global $titulo;
		$titulo = "PAPELERA proveedores";

		global $LinkForm1 ;
		$LinkForm1 = "<a href='proveedores_Crear.php' >".$PersonAddBlack.$closeButton."</a>";
		global $LinkForm2 ;
		$LinkForm2 = "<a href='proveedores_Ver.php' >".$PersonsBlack.$closeButton."</a>";
		global $LinkForm3;
		$LinkForm3 = "<a href='proveedoresFeed_Ver.php' >".$DeleteBlack.$closeButton."</a>";

		global $titulo2;
		$titulo2 = "PAPELERA proveedores VER TODO";

		require 'Show_Form.php';
	
	}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function ver_todo(){

		global $db, $db_name;

		global $orden;
		if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
			$orden = $_POST['Orden'];
		}else{ $orden = '`id` ASC'; }

		global $vname; 		$vname = "`".$_SESSION['clave']."proveedores`";

		global $result;
		$result =  "SELECT * FROM `$db_name`.$vname WHERE `ref`<>'ANONIMO' AND `del`='true' ";
		require 'Paginacion_Head.php';
		global $ruta;				$ruta = "";
		global $pagedest;			$pagedest = "proveedoresFeed_Ver.php";

		//$sqlb =  "SELECT * FROM `$db_name`.$vname WHERE `del`='true' ORDER BY $orden $limit ";
		$sqlb =  "$result ORDER BY $orden $limit ";
		
		$qb = mysqli_query($db, $sqlb);
		
		if(!$qb){
			print("* ERROR SQL L.222: ".mysqli_error($db)."</br>");
		} else {
			if(mysqli_num_rows($qb)<= 0){
				global $titNoData;	$titNoData = "TABLA ".strtoupper($vname)."<br><br>";
				require 'proveedores_NoData.php';
			} else { print ("<table class='tableForm' >
							<tr>
				<th colspan=11 class='BorderInf'>PAPELERA proveedores ".mysqli_num_rows($qb)."</th>
							</tr>
							<tr>
								<th>ID</th>
								<th>REFERENCIA</th>
								<th>DNI</th>
								<th>RAZON SOCIAL</th>
								<th></th>
								<th>DELETE</th>
								<th colspan='5'>ACCIONES</th>
							</tr>");
				
			global $DetalleBlackTit;		$DetalleBlackTit = "VER DETALLES";
			global $RestoreBlackTit;		$RestoreBlackTit = "RECUPERAR DATOS CLIENTE";
			global $DeleteWhiteTit;			$DeleteWhiteTit = "BORRAR";
			require '../Inclu/BotoneraVar.php';
			global $closeButton;

			global $styleBgc; global $i; $i = 1;

			while($rowb = mysqli_fetch_assoc($qb)){

				if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
				$i++;
	
		if($rowb['dni'] != "ANONIMO"){
			print (	"<tr class='".$styleBgc."'>
				<td align='left'>".$rowb['id']."</td>
				<td align='left'>".$rowb['ref']."</td>
				<td align='left'>".$rowb['dni'].$rowb['ldni']."</td>
				<td align='left'>".$rowb['rsocial']."</td>
				<td>
				<img src='../cb26_Docs/img_proveedores/".$rowb['myimg']."' height='40px' width='30px' />
			</td>
			<td>".$rowb['borrado']."</td>
			
			<form name='ver' action='proveedores_Ver_02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=550px,height=460px')\">");

			require 'proveedores_rowTotal.php';

			print("<td colspan=2 align='center'>
					<!--
						<input type='submit' value='VER DETALLES' class='botonverde' />
					-->
					".$DetalleBlack.$closeButton."
						<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>

			<td align='center'>
				<form name='modifica' action='proveedoresFeed_Recuperar_02.php' method='POST'>");

				require 'proveedores_rowTotal.php';

		print("<!--
				<input type='submit' value='RECUPERAR DATOS' class='botonnaranja' />
				-->
					".$RestoreBlack.$closeButton."
						<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>	

			<td align='center'>
				<form name='modifica' action='proveedoresFeed_Borrar_02.php' method='POST'>");

			require 'proveedores_rowTotal.php';

		print("<!--
				<input type='submit' value='BORRAR DATOS' class='botonrojo' />
				-->
					".$DeleteWhite.$closeButton."
						<input type='hidden' name='oculto2' value=1 />
				</form>
			</td> 
				</tr>");
			}
						
		} /* Fin del while.*/ 

			print("</table>");

			require 'Paginacion_Footter.php';

			} /* Fin segundo else anidado en if */

		} /* Fin de primer else . */
			
	}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaproveedores;	$rutaproveedores = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
				} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $db;

	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
		$orden = $_POST['Orden'];
	}else{ $orden = '`id` ASC'; }

	if (isset($_POST['todo'])){$TitBut = "\n\tFiltro => TODOS LOS proveedores ".$orden;}
	else{$TitBut = "\n\tFiltros: \n\tR. Social: ".$_POST['rsocial'].".\n\tReferencia: ".$_POST['ref'].".";}

	$ActionTime = date('H:i:s');

	global $dir;
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
				$dir = "../cb26_Docs/log";
				}
	
	global $text;
	$text = "\n- proveedores MODIFICAR BUSCAR ".$ActionTime.$TitBut;

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
	
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>