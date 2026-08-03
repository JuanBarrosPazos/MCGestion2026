<?php
session_start();

	// ESTE SCRIPT FUNCIONA CON VARIABLES GLOBALES.

	require_once ('../jpgraph/src/jpgraph.php');
	require_once ('../jpgraph/src/jpgraph_bar.php');

	require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 
				
		if(isset($_POST['graficob'])){	a();
										process_form();
										info();				
											} 
	} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function a(){	
	
		global $rutaDir; 		$rutaDir = "../cb23_Docs/grafics/";

		/////	DATOS DIARIOS TOTALES	//////
		
		global $IDTVT; 			$IDTVT = $rutaDir."IDTVT.php";
		global $file_IDTVT; 	$file_IDTVT = file_get_contents($IDTVT);
		$IDTVT_a = explode(',',$file_IDTVT);
		global $gt; 	$gt = $IDTVT_a;
					
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){

		global $coordenadax; 	global $rutaDir; 	global $gt; 	global $gd;
		
		global $s1; 	$s1 = $_SESSION['ref']; 		$s1 = trim($s1);
		global $s2; 	$s2 = $_SESSION['usuarios']; 	$s2 = trim($s2);

		global $mensaje;
		if($s2 == $s1){
			$mensaje = "\nGRAFICA PARA DEL USUARIO ".$_SESSION['ref'].".\n\n";}
		elseif($s2 != $s1){
			if($s2 == ''){$mensaje = "\nGRAFICA PARA DEL USUARIO ".$_SESSION['ref'].".\n\n";}
			else{$mensaje = "\nGRAFICA PARA DEL USUARIO ".$_SESSION['usuarios'].".\n\n";}
			}
		else{$mensaje = "\nGRAFICA PARA DEL USUARIO ".$_SESSION['ref'].".\n\n";}
		
		global $data; 	$data = $gt;

		$_SESSION['coor_x'] = $gd;		

		$gd = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);


		$graph = new Graph(1000,600,'auto');
		$graph->SetScale("textlin");
		
		$graph->SetShadow();
		$graph->img->SetMargin(40,30,40,40);
		
		$theme_class=new UniversalTheme;
		$graph->SetTheme($theme_class);
		$graph->img->SetAntiAliasing(true);
		
		$coordenadax = $gd;
		$graph->xaxis->SetTickLabels($coordenadax);
		//$graph->xgrid->SetColor('#E3E3E3');
		
			global $titulo;
			if(isset($_POST['graficotit'])){
				$titulo = 'INGRESOS PENDIENTES DIARIOS TOTALES MES '.$_SESSION['gtime']." ".$_SESSION['gyear'];
			}else{ 
				$titulo = 'INGRESOS DIARIOS TOTALES MES '.$_SESSION['gtime']." ".$_SESSION['gyear'];
			}
			//$titulo = 'INGRESOS DIARIOS TOTALES MES '.$_SESSION['gtime']." ".$_SESSION['gyear'];

		$titulo1 = $mensaje."BALANCE ".$titulo;
		$graph->title->Set($titulo1);
		//$graph->SetBox(false);

		$graph->yaxis->HideZeroLabel();
		$graph->yaxis->HideLine(false);
		$graph->yaxis->HideTicks(false,false);
		
		$bplot1 = new BarPlot($data);
		$graph->Add($bplot1);
		$bplot1->SetFillColor("#01DFD7");
		$bplot1->SetColor("#01DFD7");
		$bplot1->SetLegend($titulo);
		
		//$bplot1->SetShadow();
		
		$graph->legend->SetFrameWeight(1);
		$graph->legend->SetPos(0.5,0.96,'center','bottom');

		$graph->Stroke();	
		
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info(){

		global $db; 	global $titulo; 	global $gd; 	global $data;

		global $mensaje;
		if($_SESSION['usuarios'] == ''){
			$mensaje = "\USUARIO ".$_SESSION['ref'].". ";}
		elseif($_SESSION['usuarios'] != ''){
			$mensaje = "USUARIO ".$_SESSION['usuarios'].". ";}

		$ActionTime = date('H:i:s');

		global $text;
		$text = "- INGRESOS CONSULTA GRAFICA BARRAS.\n\t".$mensaje.$ActionTime.".\n\t* ".$titulo.".\n\tORDENADA X\n\t".implode(", ",$gd)."\n\tDATOS\n\t".implode(", ",$data);

		require 'WriteLog.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
?>