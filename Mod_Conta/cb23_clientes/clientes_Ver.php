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

	global $KeyForm;	$KeyForm = '';
	
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
		
		global $db, $db_name;
		global $nombre;		$nombre = @$_POST['Nombre'];
		global $apellido;	$apellido = @$_POST['Apellidos'];
		
		show_form();
		
		require 'clientes_ConsultaLogica.php';

		global $orden;
		if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
			$orden = $_POST['Orden'];
		}else{ $orden = '`id` ASC'; }
		
		global $vname; 		$vname = "`".$_SESSION['clave']."clientes`";

		if ( (strlen(trim($_POST['ref'])) == 0) && (strlen(trim($_POST['rsocial'])) == 0) ){
			$sqlc =  "SELECT * FROM `$db_name`.$vname WHERE `ref`<>'ANONIMO' AND `del`='false' ORDER BY $orden ";
			//echo $sqlc;
		}else{
			$sqlc =  "SELECT * FROM `$db_name`.$vname WHERE `ref`<>'ANONIMO' AND (`ref` = '$ref' OR `rsocial` LIKE '$rso') AND `del`='false' ORDER BY $orden ";
			//echo $sqlc."<br>";
		}
	
		$qc = mysqli_query($db, $sqlc);
		
		if(!$qc){
				print("<font color='#FF0000'>
						Se ha producido un error: </font>".mysqli_error($db)."</br></br>");
		} else {
				
			if(mysqli_num_rows($qc)== 0){

				global $titNoData;	$titNoData = "TABLA ".strtoupper($vname)."<br><br>";
				require 'clientes_NoData.php';

			} else { 	
				print ("<table class='tableForm' >
						<tr>
							<th colspan=10 class='BorderInf'>CLIENTES ".mysqli_num_rows($qc)."</th>
						</tr>
						<tr>
							<th>ID</th>
							<th>REFERENCIA</th>
							<th>DNI</th>
							<th>RAZON SOCIAL</th>
							<th colspan='6'>ACCIONES</th>
						</tr>");
				
			global $styleBgc; global $i; $i = 0;

		while($rowb = mysqli_fetch_assoc($qc)){
			
			if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
			$i++;

			if($rowb['dni'] != "ANONIMO"){

			print (	"<tr class='".$styleBgc."'>
										
		<form name='ver' action='clientes_Ver_02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=550px,height=460px')\">
			<td align='left'>".$rowb['id']."</td>
			<td align='left'>".$rowb['ref']."</td>
			<td align='left'>".$rowb['dni'].$rowb['ldni']."</td>
			<td align='left'>".$rowb['rsocial']."</td>
			<td>
				<img src='../cb23_Docs/img_clientes/".$rowb['myimg']."' height='40px' width='30px' />
			</td>");

			require 'clientes_rowTotal.php';

		global $DetalleBlackTit; 	$DetalleBlackTit = "VER DETALLES";
		global $DatosBlackTit;		$DatosBlackTit = "MODIFICAR DATOS";
		global $FotoBlackTit;		$FotoBlackTit = "MODIFICAR IMAGEN";
		global $DeleteWhiteTit;		$DeleteWhiteTit = "BORRAR DATOS";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;
		
		print("<td colspan=2 align='center'>
					<!--
						<input type='submit' value='VER DETALLES' class='botonverde' />
					-->
					".$DetalleBlack.$closeButton."
						<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>

			<td align='center'>
							
			<form name='modifica' action='clientes_Modificar_02.php' method='POST'>");

				require 'clientes_rowTotal.php';

			print("<!--
			<input type='submit' value='MODIFICAR DATOS' class='botonnaranja' />
			-->
			".$DatosBlack.$closeButton."
						<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>	

			<td align='center'>

			<form name='modifica_img' action='$_SERVER[PHP_SELF]' method='POST' >");

			require 'clientes_rowTotal.php';

			print("<!--
			<input type='submit' value='MODIFICAR IMAGEN' class='botonnaranja' />
			-->
			".$FotoBlack.$closeButton."
								<input type='hidden' name='oculto2' value=1 />
						</form>
					</td>
			
			<td align='center'>
				<form name='modifica' action='clientes_Borrar_02.php' method='POST'>");

				require 'clientes_rowTotal.php';

			print("<!--
						<input type='submit' value='BORRAR DATOS' class='botonrojo' />
					-->
					".$DeleteWhite.$closeButton."
					<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>
		</tr>");} // FIN SI NO ES IGUAL A ANONIMO
						
	} /* Fin del while.*/ 

		print("</table>");
				
				} /* Fin segundo else anidado en if */

			} /* Fin de primer else . */
			
	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){
		
		global $titulo;
		$titulo = "GESTIONAR CLIENTES";
		global $LinkForm1;
		/*
		$$LinkForm1 = "<a href='clientes_Crear.php' title='CREAR NUEVO CLIENTE' class='botonverde' style='color:#343434;'>CREAR NUEVO CLIENTE</a>";
		 */

		global $PersonAddBlackTit;		$PersonAddBlackTit = "CREAR NUEVO CLIENTE";
		global $DeleteBlackTit;			$DeleteBlackTit = "INICIO PAPELERA CLIENTES";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;

		$LinkForm1 = $PersonAddBlack."<a href='clientes_Crear.php' >&nbsp;&nbsp;&nbsp;</a>".$closeButton;
		global $LinkForm2;
		$LinkForm2 = $DeleteBlack."<a href='clientesFeed_Ver.php' >&nbsp;&nbsp;&nbsp;</a>".$closeButton;
		global $titulo2;
		$titulo2 = "CLIENTES VER TODOS";

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

		$sesionref = "";
		global $vname; 		$vname = "`".$_SESSION['clave']."clientes`";

		$sqlb =  "SELECT * FROM `$db_name`.$vname WHERE `ref`<>'ANONIMO' AND `del`='false' ORDER BY $orden ";

		$qb = mysqli_query($db, $sqlb);
		
		if(!$qb){

			print("* Error SQL L.224. ".mysqli_error($db)."</br>");
				
		} else {
				
			if(mysqli_num_rows($qb) < 1){

				global $titNoData;	$titNoData = "TABLA ".strtoupper($vname)."<br><br>";
				require 'clientes_NoData.php';

			}else{ print ("<table class='tableForm' >
							<tr>
								<th colspan=10 class='BorderInf'>CLIENTES ".mysqli_num_rows($qb)."</th>
							</tr>
							<tr>
								<th>ID</th>
								<th>REFERENCIA</th>
								<th>DNI</th>
								<th>RAZON SOCIAL</th>
								<th colspan='6'>ACCIONES</th>
							</tr>");
				
			global $styleBgc;		global $i; $i = 0;

		while($rowb = mysqli_fetch_assoc($qb)){

			if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
			$i++;

		if($rowb['dni'] != "ANONIMO"){
				print (	"<tr class='".$styleBgc."'>
										
		<form name='ver' action='clientes_Ver_02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=550px,height=460px')\">

			<td align='left'>".$rowb['id']."</td>
			<td align='left'>".$rowb['ref']."</td>
			<td align='left'>".$rowb['dni'].$rowb['ldni']."</td>
			<td align='left'>".$rowb['rsocial']."</td>
			<td>
				<img src='../cb23_Docs/img_clientes/".$rowb['myimg']."' height='40px' width='30px' />
			</td>");

			require 'clientes_rowTotal.php';

		global $DetalleBlackTit;		$DetalleBlackTit = "VER DETALLES";
		global $DatosBlackTit;			$DatosBlackTit = "MODIFICAR DATOS";
		global $FotoBlackTit;			$FotoBlackTit = "MODIFICAR IMAGEN";
		global $DeleteWhitTit;			$DeleteWhitTit = "BORRAR CLIENTE";
		require '../Inclu/BotoneraVar.php';
		global $closeButton;
	
		print("<td colspan=2 align='center'>
					<!--
						<input type='submit' value='VER DETALLES' class='botonverde' />
					-->
					".$DetalleBlack.$closeButton."
							<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>
			<td align='center'>
				<form name='modifica' action='clientes_Modificar_02.php' method='POST'>");

			require 'clientes_rowTotal.php';

		print("<!--
			<input type='submit' value='MODIFICAR DATOS' class='botonnaranja' />
			-->
				".$DatosBlack.$closeButton."
						<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>	

			<td align='center'>
							
		<form name='modifica_img' action='$_SERVER[PHP_SELF]' method='POST' >");

			require 'clientes_rowTotal.php';

		print("<!--
			<input type='submit' value='MODIFICAR IMAGEN' class='botonnaranja' />
			-->
			".$FotoBlack.$closeButton."
						<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>
			<td align='center'>
				<form name='modifica' action='clientes_Borrar_02.php' method='POST'>");

			require 'clientes_rowTotal.php';

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
				
			} /* Fin segundo else anidado en if */

		} /* Fin de primer else . */
			
	}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaClientes;	$rutaClientes = "";
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

	if (isset($_POST['todo'])){$TitBut = "\n\tFiltro => TODOS LOS CLIENTES ".$orden;}
	else{$TitBut = "\n\tFiltros: \n\tR. Social: ".$_POST['rsocial'].".\n\tReferencia: ".$_POST['ref'].".";}

	$ActionTime = date('H:i:s');

	global $dir;
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
				$dir = "../cb23_Docs/log";
				}
	
	global $text;
	$text = "\n- CLIENTES MODIFICAR BUSCAR ".$ActionTime.$TitBut;

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