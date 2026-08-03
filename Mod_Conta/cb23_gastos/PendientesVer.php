<?php
session_start();

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../Inclu/Conta_Head.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';
	require 'PendientesModificarImg.php';
	require 'PendientesVer02.php';

	$_SESSION['usuarios'] = '';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require 'VerLogica.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
	
		require 'IncShowForm01Val.php';

		return $errors;

	} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){
		
		global $db;
 
		show_form();

		global $dyt1;
		
		require 'FactDate.php';

		global $vname; 		$vname = "`".$_SESSION['clave']."gastos_pendientes`";

		global $sqlb;
		require 'FormConsultaFiltroGt2.php';
		
		/*	
		$sqlb =  "SELECT * FROM $vname WHERE (`factnum` = '$fnum' OR `factnif` = '$fnif' OR `refprovee` = '$fnom') AND  (`factdate` LIKE '$fil') ORDER BY $orden ";
		*/

		require 'FunctVerTodoSumTotal.php';

		global $rutPend;	$rutPend = 'Pendientes';
		global $pend;	$pend = "PENDIENTES";
		require 'Botonera.php';

		if(!$qb){
				print("<font color='#FF0000'>
						ERROR: </font>".mysqli_error($db)."</br>");
		}else{
			if(mysqli_num_rows($qb) == 0){
				global $titNoData;		$titNoData = "GASTOS PENDIENTES ".$dyt1."<br>";
				require 'NoData.php';
			}else{ 
					require 'PendientesRowbTotalTabla.php';
						} /* Fin segundo else anidado en if */

		} /* Fin de primer else . */
				
		global $fil; 		global $orden; 		global $factnom;
		global $factnif; 	global $factnum; 	global $vname;

		$sqlg = $sqlb;
		$qg = mysqli_query($db, $sqlg);

		if($_SESSION['gtime']==''){$_SESSION['gtime']='';}
		elseif($_SESSION['gtime']=='01'){$_SESSION['gtime']='ENERO';}
		elseif($_SESSION['gtime']=='02'){$_SESSION['gtime']='FEBRERO';}
		elseif($_SESSION['gtime']=='03'){$_SESSION['gtime']='MARZO';}
		elseif($_SESSION['gtime']=='04'){$_SESSION['gtime']='ABRIL';}
		elseif($_SESSION['gtime']=='05'){$_SESSION['gtime']='MAYO';}
		elseif($_SESSION['gtime']=='06'){$_SESSION['gtime']='JUNIO';}
		elseif($_SESSION['gtime']=='07'){$_SESSION['gtime']='JULIO';}
		elseif($_SESSION['gtime']=='08'){$_SESSION['gtime']='AGOSTO';}
		elseif($_SESSION['gtime']=='09'){$_SESSION['gtime']='SEPTIEMBRE';}
		elseif($_SESSION['gtime']=='10'){$_SESSION['gtime']='OCTUBRE';}
		elseif($_SESSION['gtime']=='11'){$_SESSION['gtime']='NOVIEMBRE';}
		elseif($_SESSION['gtime']=='12'){$_SESSION['gtime']='DICIEMBRE';}
	
		//print ("* ".$_SESSION['gtime']);
		
		global $rutaDir;
		$rutaDir = "../cb23_Docs/grafics/";

		/////////////

		$fh = fopen($rutaDir.'IMxT3.php','w+');
		while($registro = mysqli_fetch_array($qg)){
			$line = $registro['factpvptot'].",";
			fwrite($fh, $line);
			}
		fclose($fh);
		
		/////////////

		$sqlgd =  $sqlb;
		$qgd = mysqli_query($db, $sqlgd);

		$fhd = fopen($rutaDir.'IMxD3.php','w+');
		while($registrod = mysqli_fetch_array($qgd)){
			$lined = "M".substr($registrod['factdate'],3,2)."\nD".substr($registrod['factdate'],-2).",";
			fwrite($fhd, $lined);
			$_SESSION['rsoc'] = $registrod['factnom'];
			}
		fclose($fhd);
		
		require 'gdtvt2.php';

	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function gt2(){

		global $db;		global $db_name; 	global $dyt1;

		require 'FactDate.php';
		require 'VerConsultaLogica.php';
	
		global $vname; 		$vname = "`".$_SESSION['clave']."gastos_pendientes`";

		require 'FunctGt2.php';

	} // FIN function gt2()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function gt1(){

		global $db; 		global $db_name;

		require 'FactDate.php';

		global $vname; 	$vname = "`".$_SESSION['clave']."gastos_pendientes`";
	
		require 'FunctGt1.php';
		
	} // FIN function gt1()


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){

		if(isset($_POST['show_formcl'])){
					$defaults = $_POST;
		}elseif(isset($_POST['todo'])){
				$defaults = $_POST;
		}else{ $defaults = array ('factnom' => '',
									'factnif' => '',
									'factnum' => '',
									'factnumini' => '',
									'Orden' => isset($ordenar));
								}

		global $titulo; 		$titulo = "CONSULTAR GASTOS PENDIENTES";
		global $TitBut1;		$TitBut1 = "VER TODOS LOS GASTOS";		
		global $TitBut2;		$TitBut2 = "FILTRO BUSQUEDA GASTOS";
		require 'IncShowForm01.php';

	}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function ver_todo(){
		
		global $db; 		global $db_name;		global $limit;

		global $dyt1;
		require 'FactDate.php';

		global $orden;
		if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
			$orden = $_POST['Orden'];
		}else{ $orden = '`id` ASC'; }

		global $vname; 		$vname = "`".$_SESSION['clave']."gastos_pendientes`";

		global $iniVerTodo;		global $sqlb;
		if($iniVerTodo == 1){
				global $limit;
				$sqlb =  "SELECT * FROM $vname  ORDER BY '`factdate` DESC' $limit";
		}else{
			require 'FormConsultaFiltroGt1.php';
		}

		require 'FunctVerTodoSumTotal.php';

		global $rutPend;	$rutPend = 'Pendientes';
		global $pend;	$pend = "PENDIENTES";
		require 'Botonera.php';

		if(!$qb){
			print("<font color='#FF0000'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
		}else{
			if(mysqli_num_rows($qb) == 0){
				global $titNoData;		$titNoData = "GASTOS PENDIENTES ".$dyt1."<br>";
				require 'NoData.php';
			}else{ 
					require 'PendientesRowbTotalTabla.php';
				} /* Fin segundo else anidado en if */
		} /* Fin de primer else . */
				
			global $fil; 	global $sqlb;

			require 'FormConsultaFiltroGt1.php';

			$sqlg = $sqlb;
			//$sqlg =  "SELECT * FROM $vname WHERE `factdate` LIKE '$fil' ORDER BY $orden ";
			$qg = mysqli_query($db, $sqlg);

			if($_SESSION['gtime']==''){$_SESSION['gtime']='';}
			elseif($_SESSION['gtime']=='01'){$_SESSION['gtime']='ENERO';}
			elseif($_SESSION['gtime']=='02'){$_SESSION['gtime']='FEBRERO';}
			elseif($_SESSION['gtime']=='03'){$_SESSION['gtime']='MARZO';}
			elseif($_SESSION['gtime']=='04'){$_SESSION['gtime']='ABRIL';}
			elseif($_SESSION['gtime']=='05'){$_SESSION['gtime']='MAYO';}
			elseif($_SESSION['gtime']=='06'){$_SESSION['gtime']='JUNIO';}
			elseif($_SESSION['gtime']=='07'){$_SESSION['gtime']='JULIO';}
			elseif($_SESSION['gtime']=='08'){$_SESSION['gtime']='AGOSTO';}
			elseif($_SESSION['gtime']=='09'){$_SESSION['gtime']='SEPTIEMBRE';}
			elseif($_SESSION['gtime']=='10'){$_SESSION['gtime']='OCTUBRE';}
			elseif($_SESSION['gtime']=='11'){$_SESSION['gtime']='NOVIEMBRE';}
			elseif($_SESSION['gtime']=='12'){$_SESSION['gtime']='DICIEMBRE';}
			
			global $rutaDir;
			$rutaDir = "../cb23_Docs/grafics/";

			/////////////

			$fh = fopen($rutaDir.'IMxT.php','w+');
			while($registro = mysqli_fetch_array($qg)){
						$line = $registro['factpvptot'].",";
						fwrite($fh, $line);
					}
			fclose($fh);
			
			/////////////

			global $sqlb;
			require 'FormConsultaFiltroGt1.php';
			$sqlgd = $sqlb;
			//$sqlgd =  "SELECT * FROM $vname WHERE `factdate` LIKE '$fil' ORDER BY $orden ";
			$qgd = mysqli_query($db, $sqlgd);

			$fhd = fopen($rutaDir.'IMxD.php','w+');
			while($registrod = mysqli_fetch_array($qgd)){
					$lined = substr($registrod['factdate'],-2).",";
					fwrite($fhd, $lined);
				}
			fclose($fhd);
			
			require 'gdtvt.php';

	}	/* FIN ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaIndex;		$rutaIndex = "../";
		require '../Inclu_MInd/MasterIndexVar.php';
		global $rutaGastos;	$rutaGastos = "";
		require '../Inclu_MInd/MasterIndex.php'; 
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $dd;
	if($_POST['dd'] == ''){$dd = "DIA TODOS";}else{$dd = $_POST['dd'];}
	global $dm;
	if($_POST['dm'] == ''){$dm = "MES TODOS";}else{$dm = $_POST['dm'];}
	global $dy;
	if($_POST['dy'] == ''){ $dy = date('Y');} else{$dy = $_POST['dy'];}
	
	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
		$orden = $_POST['Orden'];
	}else{ $orden = '`id` ASC'; }

	if(isset($_POST['todo'])){$TitBut = "\n\tFiltro => TODOS LOS GASTOS. ".$orden."\n\tDATE: ".$dy."-".$dm."-".$dd.".";}
	else{$TitBut = "\n\tFiltro => \n\tDATE: ".$dy."-".$dm."-".$dd.".\n\tR. Social: ".$_POST['factnom'].".\n\tDNI: ".$_POST['factnif'].".\n\tNº FACTURA: ".$_POST['factnum'].".";}

	$ActionTime = date('H:i:s');

	global $text; 		$text = "\n- GASTOS CONSULTAR ".$ActionTime.$TitBut;
	
	require 'WriteLog.php';
	
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Conta_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>