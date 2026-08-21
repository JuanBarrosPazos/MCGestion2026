<?php

	global $orden;
	if((isset($_POST['Orden']))&&($_POST['Orden']!= '')){
			$orden = $_POST['Orden'];
	}else{ $orden = '`factdate` ASC'; }
    //echo $orden;

	global $db; 	global $db_name;
	
	global $dyt1;
	if(isset($_POST['dy'])){
		if(strlen(trim($_POST['dy'])) != 0){ $dyt1  = '20'.$_POST['dy']; }else{ $dyt1 = date('Y'); }
	}else{ $dyt1 = date('Y'); }
    global $dyt1y;  $dyt1y = substr($dyt1, -2);    //echo $dyt1y;

	global $dm1; 
	if(isset($_POST['dm'])){
		if(strlen(trim($_POST['dm'])) != 0){ $dm1 = $_POST['dm']; }else{ $dm1 = "TRI0"; }
	}else{ $dm1 = "TRI0"; }	

	/* NOMBRE DE LAS TABLAS */

	global $vnamei; 	$vnamei = "`".$_SESSION['clave']."ingresos_".$dyt1."`";
	global $vnameg; 	$vnameg = "`".$_SESSION['clave']."gastos_".$dyt1."`";

	/* SENTENCIAS */

	global $sent; 		//$sent = "LIKE '".$dyt1y."/".$dm1."/%'";	
	global $sqli;		//$sqli = "SELECT * FROM $vnamei WHERE `factdate` $sent ORDER BY `id` ASC ";
	global $sqlg; 		//$sqlg = "SELECT * FROM $vnameg WHERE `factdate` $sent ORDER BY `id` ASC ";
	
	/* INGRESOS SUMAR PVPTOT */
	global $OperSqlToti;    //$OperSqlToti = "SUM(`factpvptot`)";
	global $sqlSumToti; 	//$sqlSumToti = "SELECT $OperSqlToti AS 'YearSumToti' FROM $vnamei WHERE `factdate` $sent ";
	/* INGRESOS SUMAR RETENCION TOT */
	global $OperSqlRetei; //$OperSqlRetei = "SUM(`factrete`)";
	global $sqlSumRetei;  //$sqlSumRetei = "SELECT $OperSqlRetei AS 'YearSumRetei' FROM $vnamei WHERE `factdate` $sent ";
	/* INGRESOS SUMAR IVA */	
    global $OperSqlIvai;   //$OperSqlIvai = "SUM(`factivae`)";
	global $sqlSumIvai;    //$sqlSumIvai = "SELECT $OperSqlIvai AS 'YearSumIvai' FROM $vnamei WHERE `factdate` $sent ";
	/* GASTOS SUMAR PVPTOT  */
	global $OperSqlTotg;   //$OperSqlTotg = "SUM(`factpvptot`)";
	global $sqlSumTotg;    //$sqlSumTotg = "SELECT $OperSqlTotg AS 'YearSumTotg' FROM $vnameg WHERE `factdate` $sent ";
	/* GASTOS SUMAR RETENCION TOT */
	global $OperSqlReteg;  //$OperSqlReteg = "SUM(`factrete`)";
	global $sqlSumReteg;   //$sqlSumReteg = "SELECT $OperSqlReteg AS 'YearSumReteg' FROM $vnameg WHERE `factdate` $sent ";
	/* GASTOS SUMAR IVA */
	global $OperSqlIvag;  //$OperSqlIvag = "SUM(`factivae`)";
	global $sqlSumIvag;   //$sqlSumIvag = "SELECT $OperSqlIvag AS 'YearSumIvag' FROM $vnameg WHERE `factdate` $sent ";

	global $betwIng;    global $betwFing;
	global $betwIni;    global $betwFini;
	
	/* LOGICA */

	//echo $dm1."<br>";
	 switch (true) {
		/* CONSULTA MESES DEL AÑO */ 
		case ($dm1 == "M01" || $dm1 == "M02" || $dm1 == "M03" || $dm1 == "M04" || $dm1 == "M05" || $dm1 == "M06" || $dm1 == "M07" || $dm1 == "M08" || $dm1 == "M09" || $dm1 == "M10" || $dm1 == "M11" || $dm1 == "M12" ):
			global $dyIni;	global $dyFin;
			if($dm1 == "M01"){ $dyIni = "-01-01"; $dyFin = "-01-31"; }
			elseif($dm1 == "M02"){ $dyIni = "-02-01"; $dyFin = "-02-31"; }
			elseif($dm1 == "M03"){ $dyIni = "-03-01"; $dyFin = "-03-31"; }
			elseif($dm1 == "M04"){ $dyIni = "-04-01"; $dyFin = "-04-31"; }
			elseif($dm1 == "M05"){ $dyIni = "-05-01"; $dyFin = "-05-31"; }
			elseif($dm1 == "M06"){ $dyIni = "-06-01"; $dyFin = "-06-31"; }
			elseif($dm1 == "M07"){ $dyIni = "-07-01"; $dyFin = "-07-31"; }
			elseif($dm1 == "M08"){ $dyIni = "-08-01"; $dyFin = "-08-31"; }
			elseif($dm1 == "M09"){ $dyIni = "-09-01"; $dyFin = "-09-31"; }
			elseif($dm1 == "M10"){ $dyIni = "-10-01"; $dyFin = "-10-31"; }
			elseif($dm1 == "M11"){ $dyIni = "-11-01"; $dyFin = "-11-31"; }
			elseif($dm1 == "M12"){ $dyIni = "-12-01"; $dyFin = "-12-31"; }
			else { }
			$betwIng = $betwIni = $dyt1y.$dyIni;
			$betwFing = $betwFini = $dyt1y.$dyFin;
			require 'Inclu_Index/SelectTrimes.php';
			break;
		
		/* CONSULTA TRIMESTRES */
		case ($dm1 == "TRI1"):
			$betwIng = $betwIni = $dyt1y."-01-01";
			$betwFing = $betwFini = $dyt1y."-03-31";
			require 'Inclu_Index/SelectTrimes.php';
			break;
		
		case ($dm1 == "TRI2"):
			$betwIng = $betwIni = $dyt1y."-04-01";
			$betwFing = $betwFini = $dyt1y."-06-31";
			require 'Inclu_Index/SelectTrimes.php';
			break;
		
		case ($dm1 == "TRI3"):
			$betwIng = $betwIni = $dyt1y."-07-01";
			$betwFing = $betwFini = $dyt1y."-09-31";
			require 'Inclu_Index/SelectTrimes.php';
			break;
		
		case ($dm1 == "TRI4"):
			$betwIng = $betwIni = $dyt1y."-10-01";
			$betwFing = $betwFini = $dyt1y."-12-31";
			require 'Inclu_Index/SelectTrimes.php';
			break;
		
		/* CONSULTA ANUAL */
		case ($dm1 == "ANU"):
			$dm1 = "";
			$sent = "LIKE '".$dyt1."-%' ORDER BY $orden ";
			require 'inclu_Index/SelectAnu.php';
			break;
		/* */
		default:
			$dm1 = substr($dm1,1,2);
			$sent = "LIKE '".$dyt1."-".$dm1."-%' ORDER BY $orden ";
			require 'inclu_Index/SelectAnu.php';
			break;

	 } // FIN SWITCH CASE

	//echo "* ".$dm1."<br>";
	//echo "<br>".$sqli."<br>";
	//echo "<br>".$sqlg."<br>";

					   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	////////////////////		***********  		////////////////////
                        /* TABLA BALANCE INGRESOS */
	////////////////////		***********  		////////////////////

	$qbi = mysqli_query($db, $sqli);
	global $counti;		$counti = mysqli_num_rows($qbi);
	//echo "** ".$counti."<br>";

/////////////////////	
/* PARA SUMAR PVPTOT */

	global $sumapvptoti;
	if($counti > 0){
		//echo $sqlSumToti."<br>";
		$qrySumToti = mysqli_query($db, $sqlSumToti);
		$SumToti = mysqli_fetch_assoc($qrySumToti);
		$sumapvptoti = $SumToti['YearSumToti'];
		$sumapvptoti  = number_format($sumapvptoti ,2,".","");
	}else{ $sumapvptoti = "0.00"; }

/* FIN PARA SUMAR PVPTOT */
/////////////////////////

/////////////////////	
/* PARA SUMAR RETENCION TOT */	
	global $sumaretei;
	if($counti > 0){
		$qrySumRetei = mysqli_query($db, $sqlSumRetei);
		$SumRetei = mysqli_fetch_assoc($qrySumRetei);
		$sumaretei = $SumRetei['YearSumRetei'];
		$sumaretei  = number_format($sumaretei ,2,".","");
	}else{ $sumaretei = "0.00"; }

/* FIN PARA SUMAR RETENCION TOT */
/////////////////////////

/////////////////////	
/* PARA SUMAR IVA */	

	global $sumaivaei;
	if($counti > 0){
		$qrySumIvai = mysqli_query($db, $sqlSumIvai);
		$SumIvai = mysqli_fetch_assoc($qrySumIvai);
		$sumaivaei = $SumIvai['YearSumIvai'];
		$sumaivaei  = number_format($sumaivaei ,2,".","");
	}else{ $sumaivaei = "0.00"; }

/* FIN PARA SUMAR IVA */
/////////////////////////

	if(!$qbi){
	print("<font color='#F1BD2D'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
	} else {
		if(mysqli_num_rows($qbi) == 0){
			print ("<div style='clear:both'></div>
			<div class='divTablaIndex'>
			<table class='tabla tableForm' >
						<tr>
						<th colspan='3' class='resultadosi'>BALANCE INGRESOS</th>
					</tr>
					<tr>
						<td colspan='3'>
							<span style='display:block; margin-top: 0.4em;'>
								<font color='#F1BD2D'>NO HAY DATOS</font>
							</span>
						</td>
					</tr>
					<tr>
						<td class='resultadosi' align='center'>IMP DIFER</td>
						<td class='resultadosi' align='center'>RETEN DIFER</td>
						<td class='resultadosi' align='center'>TOT DIFER</td>
					</tr>
					<tr>
						<td class='resultadosi' align='center'>".$sumaivaei." €</td>
						<td class='resultadosi' align='center'>".$sumaretei." €</td>
						<td class='resultadosi' align='center'>".$sumapvptoti." €</td>
					</tr>
				</table>");
		} else { print ("<div style='clear:both'></div>
			<div class='divTablaIndex'>
			<table class='tabla tableForm' >
			<tr>
				<th colspan=6 class='BorderInf resultadosi'>
					BALANCE INGRESOS ".mysqli_num_rows($qbi)."R.
				</th>
			</tr>
			<tr>
				<td colspan='2' class='resultadosi' align='center'>IMP REPER</td>
				<td colspan='2' class='resultadosi' align='center'>RETEN REPER</td>
				<td colspan='2' class='resultadosi' align='center'>TOT INGRESOS</td>
			</tr>
			<tr>
				<td colspan='2' class='resultadosi' align='center'>".$sumaivaei." €</td>
				<td colspan='2' class='resultadosi' align='center'>".$sumaretei." €</td>
				<td colspan='2' class='resultadosi' align='center'>".$sumapvptoti." €</td>
			</tr>
			<tr>
				<td colspan=6 class='BorderSup BorderInf'>
					<div class='section'>
						<ul class='chartlist'>");
	
		global $sqli; global $sqlgri; 	$sqlgri = $sqli;	
		$qbgri = mysqli_query($db, $sqlgri);
	
		global $styleBgc; global $i; $i = 1;

		while($rowgri = mysqli_fetch_assoc($qbgri)){
	
			if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
			$i++;

			$rowgri['factpvptot']  = number_format($rowgri['factpvptot'],2,".","");
			//if($TriSumTotg == ''){ $TriSumTotg = "0.00"; }else{ }
			global $sumapvptoti;
			if($sumapvptoti > 0){
				$TotEi = ($rowgri['factpvptot']*100)/$sumapvptoti;
			}elseif($sumapvptoti < 0){
				$TotEi = abs(($sumapvptoti*100)/($rowgri['factpvptot']));
			}else{ $TotEi = 0.00; }

			print("<li class='".$styleBgc."' >
						<a href='#' title='".$rowgri['factdate']." || ".$rowgri['factpvptot']." €'>
			<span class='count'>".$rowgri['factdate']." || ".$rowgri['factpvptot']." €</span>
			<span class='index bgcolori' style='width: ".$TotEi."%;'>".$rowgri['factpvptot']."</span>
						</a>
					</li>");
	
			} // FIN WHILE
	
		print("	</ul>
					</div>
				</td>
			</tr>
			<tr>
				<th>AÑO</th><th>FECHA</th><th>IVA REPER</th>
				<th>SUB TOT</th><th>RET REPER</th><th>TOTAL €</th>			
			</tr>");

		global $styleBgc; 
		if($counti > 0){

			global $i; $i = 1;
			while($rowi = mysqli_fetch_assoc($qbi)){

				if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
				$i++;

			global $dyt1;
			//if($rowi['tot']!= 0.00){
			print (	"<tr class='".$styleBgc."' >
						<td align='right'>".$dyt1."</td>
						<td align='right'>".$rowi['factdate']."</td>
						<td align='right'>".$rowi['factivae']." €</td>
						<td  align='right'>".$rowi['factpvp']." €</td>
						<td align='right'>".$rowi['factrete']." €</td>
						<td align='right'>".$rowi['factpvptot']." €</td>
					</tr>");
					
							//}
			} /* Fin del while.*/ 

		}else{
			/*
			$TriSumSubToti = "0.00";
			$TriSumRetei ="0.00";
			$TriSumToti = "0.00";
			print (	"<tr class='".$styleBgc."'>
						<td align='center' >".$dyt1."</td>
						<td align='right' >".$dyt1."</td>
						<td align='right' >0.00 €</td>
						<td align='right' >0.00 €</td>
						<td align='right' >0.00 €</td>
						<td align='right' >0.00 €</td>
					</tr>");
			*/
			}      

			print("</table>");
		} /* Fin segundo else anidado en if */

	} /* Fin de primer else . */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	////////////////////		***********  		////////////////////
                        /* TABLA BALANCE GASTOS */
	////////////////////		***********  		////////////////////

	global $qbg;		$qbg = mysqli_query($db, $sqlg);
	global $countg;		$countg = mysqli_num_rows($qbg);

/////////////////////	
/* PARA SUMAR PVPTOT */

	global $sumapvptotg;
	if($countg > 0){
		//echo $sqlSumTot."<br>";
		$qrySumTotg = mysqli_query($db, $sqlSumTotg);
		$SumTotg = mysqli_fetch_assoc($qrySumTotg);
		$sumapvptotg = $SumTotg['YearSumTotg'];
		$sumapvptotg  = number_format($sumapvptotg ,2,".","");
	}else{ $sumapvptotg = "0.00"; }

/* FIN PARA SUMAR PVPTOT */
/////////////////////////

/////////////////////	
/* PARA SUMAR RETENCION TOT */

	global $sumareteg;
	if($countg > 0){
		//echo $sqlSumRete."<br>";
		$qrySumReteg = mysqli_query($db, $sqlSumReteg);
		$SumReteg = mysqli_fetch_assoc($qrySumReteg);
		$sumareteg = $SumReteg['YearSumReteg'];
		$sumareteg  = number_format($sumareteg ,2,".","");
	}else{ $sumareteg = "0.00"; }
			
/* FIN PARA SUMAR RETENCION TOT */
/////////////////////////

/////////////////////	
/* PARA SUMAR IVA */

	global $sumaivaeg;
	if($countg > 0){
		//echo $sqlSumIva."<br>";
		$qrySumIvag = mysqli_query($db, $sqlSumIvag);
		$SumIvag = mysqli_fetch_assoc($qrySumIvag);
		$sumaivaeg = $SumIvag['YearSumIvag'];
		$sumaivaeg  = number_format($sumaivaeg ,2,".","");
	}else{ $sumaivaeg = "0.00"; }
			
/* FIN PARA SUMAR IVA */
/////////////////////////

	if(!$qbg){
			print("<font color='#F1BD2D'>*Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
	} else {
		if(mysqli_num_rows($qbg) == 0){
			print ("<table class='tablac tableForm' >
						<tr>
							<th colspan='3' class='resultadosg'>BALANCE GASTOS</th>
						</tr>
						<tr>
							<td colspan='3'>
								<span style='display:block; margin-top: 0.4em;'>
									<font color='#F1BD2D'>NO HAY DATOS</font>
								</span>
							</td>
						</tr>
						<tr>
							<td class='resultadosg' align='center'>IMP DIFER</td>
							<td class='resultadosg' align='center'>RETEN DIFER</td>
							<td class='resultadosg' align='center'>TOT DIFER</td>
						</tr>
						<tr>
							<td class='resultadosg' align='center'>".$sumaivaeg." €</td>
							<td class='resultadosg' align='center'>".$sumareteg." €</td>
							<td class='resultadosg' align='center'>".$sumapvptotg." €</td>
						</tr>
					</table>");
		} else { 
			print ("<table class='tablac tableForm' >
				<tr>
					<th colspan='6' class='BorderInf resultadosg'>
						BALANCE GASTOS ".mysqli_num_rows($qbg)."R.
					</th>
				</tr>
				<tr>
					<td colspan='2' class='resultadosg' align='center'>IMP SOPOR</td>
					<td colspan='2' class='resultadosg' align='center'>RETEN SOPORT</td>
					<td colspan='2' class='resultadosg' align='center'>TOTAL GASTOS</td>
				</tr>
				<tr>
					<td colspan='2' class='resultadosg' align='center'>".$sumaivaeg." €</td>
					<td colspan='2' class='resultadosg' align='center'>".$sumareteg." €</td>
					<td colspan='2' class='resultadosg' align='center'>".$sumapvptotg." €</td>
				</tr>
				<tr>
				<td colspan=6 class='BorderSup BorderInf'>
					<div class='section'>
						<ul class='chartlist'>");

		global $sqlg; global $sqlgrg; 	$sqlgrg = $sqlg;	
		$qbgrg = mysqli_query($db, $sqlgrg);
			  
		global $styleBgc; global $i; $i = 1;

		while($rowgrg = mysqli_fetch_assoc($qbgrg)){

			if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
			$i++;

			$rowgrg['factpvptot']  = number_format($rowgrg['factpvptot']  ,2,".","");
			//if($TriSumTotg == ''){ $TriSumTotg = "0.00"; }else{ }
			global $sumapvptotg;
			if($sumapvptotg > 0){
				$TotEg = ($rowgrg['factpvptot']*100)/$sumapvptotg;
			}elseif($sumapvptotg < 0){
				$TotEg = abs(($sumapvptotg*100)/($rowgrg['factpvptot']));
			}else{ $TotEg = 0.00; }

			print("<li class='".$styleBgc."' >
						<a href='#' title='".$rowgrg['factdate']." || ".$rowgrg['factpvptot']." €'>
			<span class='count'>".$rowgrg['factdate']." || ".$rowgrg['factpvptot']." €</span>
			<span class='index bgcolorg' style='width: ".$TotEg."%;'>".$rowgrg['factpvptot']."</span>
						</a>
					</li>");

		} // FIN WHILE

		print("	</ul>
				</div>
					</td>
				</tr>
				<tr>
					<th>AÑO</th><th>MES</th><th>IVA REPER</th>
					<th>SUBTOT</th><th>RET REPER</th><th>TOTAL €</th>	
				</tr>");
			
	global $styleBgc; 
	if($countg > 0){
		global $i; $i = 1;
		while($rowg = mysqli_fetch_assoc($qbg)){
			if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd'"; }
			$i++;
			global $dyt1;
			//if($rowb['tot']!= 0.00){
					print (	"<tr class='".$styleBgc."'>
								<td align='right'>".$dyt1."</td>
								<td align='right'>".$rowg['factdate']."</td>
								<td align='right'>".$rowg['factivae']." €</td>
								<td align='right'>".$rowg['factpvp']." €</td>
								<td align='right'>".$rowg['factrete']." €</td>
								<td align='right'>".$rowg['factpvptot']." €</td>
							</tr>");
							//}
		} /* Fin del while.*/ 
	}else{
		/*
		global $dyt1;
		print (	"<tr class='".$styleBgc."'>
					<td align='center' >".$dyt1."</td>
					<td align='right' >".$dyt1."</td>
					<td align='right' >0.00 €</td>
					<td align='right' >0.00 €</td>
					<td align='right' >0.00 €</td>
					<td align='right' >0.00 €</td>
				</tr>");
		*/
	}
		print("</table>");
			} /* Fin segundo else anidado en if */
		} /* Fin de primer else . */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

			////////////////////		**********  		////////////////////
								/* TABLA BALANCE DIFERENCIAL */
			////////////////////		**********  		////////////////////
		
/////////////////////	

/* OPERACIONES PARA DIFER */	

	global $sumapvptoti; 		global $sumaretei; 		global $sumaivaei;
	global $sumapvptotg; 		global $sumareteg; 		global $sumaivaeg;
	global $sumapvptotd; 		global $sumareted; 		global $sumaivaed;

	$sumapvptotd = $sumapvptoti - $sumapvptotg;
	$sumapvptotd  = number_format($sumapvptotd ,2,".","");
	//if($sumapvptotd == ""){$sumapvptotd = "0.00"; }else{ }

	/* CALCULO DIFERENCIA RETENCIONES IVA */
	$sumareted = $sumaretei - $sumareteg;
	$sumareted  = number_format($sumareted ,2,".","");
	//if($sumareted == ""){ $sumareted = "0.00";}else{ }

	$sumaivaed = $sumaivaei - $sumaivaeg;
	$sumaivaed  = number_format($sumaivaed ,2,".","");
	
	global $sumapvptotd;
	
	if($sumapvptotd > 0){
		$TotEd1 = abs(($sumaivaed*100)/$sumapvptotd);
		$TotEd2 = abs(($sumareted*100)/$sumapvptotd);
		$TotEd3 = abs(($sumapvptotd*100)/$sumapvptoti);
	}elseif($sumapvptotd < 0){
		$TotEd1 = abs(($sumaivaed*100)/(abs($sumapvptotd)));
		$TotEd2 = abs(($sumareted*100)/(abs($sumapvptotd)));
		if($sumapvptoti == 0){ 
			$TotEd3 = abs(($sumapvptotd*100)/(abs($sumapvptotd)));
		}else{
			$TotEd3 = abs(($sumapvptoti*100)/(abs($sumapvptotd)));
		}
	}else{ $TotEd1 = 0.00;	$TotEd2 = 0.00;	$TotEd3 = 0.00;}

	global $sumapvptoti;
	if($sumapvptoti > 0){
		$TotEd4 = abs(($sumapvptoti*100)/$sumapvptoti);
	}else{
		$TotEd4 = 0.00;
	}

	global $sumapvptotg;
	if(($sumapvptotg > 0)&&($sumapvptoti > 0)){
		$TotEd5 = abs(($sumapvptotg*100)/$sumapvptoti);
	}elseif(($sumapvptotg > 0)&&($sumapvptoti <= 0)){
		$TotEd5 = abs(($sumapvptotg*100)/$sumapvptotd);
		//echo $TotEd5;
	}else{
		$TotEd5 = 0.00;
	}

	global $bgRed;
	if(	$sumaivaed >= 0){ $bgivaed = ""; }else{ $bgivaed = "style='background: #ff5e00 !important;'"; }
	if(	$sumareted >= 0){ $bgreted = ""; }else{ $bgreted = "style='background: #ff5e00 !important;'"; }
	if(	$sumapvptotd >= 0){ $bgpvptotd = ""; }else{ $bgpvptotd = "style='background: #ff5e00 !important;'"; }

	if(($TotEd1 == 0.00)&&($TotEd2 == 0.00)&&($TotEd3 == 0.00)&&($TotEd4 == 0.00)&&($TotEd5 == 0.00)){			
		print ("<table class='tabla tableForm' >
					<tr>
						<th colspan='3' class='resultadosd'>
							DIFERENCIA INGRESOS / GASTOS 
						</th>
					</tr>
					<tr>
						<td colspan='3' >
							<span style='display:block; margin-top: 0.4em;'>
								<font color='#F1BD2D'>NO HAY DATOS</font>
							</span>
						</td>
					</tr>
					<tr>
						<td class='resultadosd' align='center'>IMP DIFER</td>
						<td class='resultadosd' align='center'>RETEN DIFER</td>
						<td class='resultadosd' align='center'>TOT DIFER</td>
					</tr>
					<tr>
						<td class='resultadosd' align='center'>".$sumaivaed." €</td>
						<td class='resultadosd' align='center'>".$sumareted." €</td>
						<td class='resultadosd' align='center'>".$sumapvptotd." €</td>
					</tr>
				</table>");
	}else{
	print ("<table class='tabla tableForm' >
				<tr>
					<th colspan='3' class='BorderInf resultadosd'>
						DIFERENCIA INGRESOS / GASTOS 
					</th>
				</tr>
				<tr>
					<td class='resultadosd' align='center'>IMP DIFER</td>
					<td class='resultadosd' align='center'>RETEN DIFER</td>
					<td class='resultadosd' align='center'>TOT DIFER</td>
				</tr>
				<tr>
					<td class='resultadosd' align='center'>".$sumaivaed." €</td>
					<td class='resultadosd' align='center'>".$sumareted." €</td>
					<td class='resultadosd' align='center'>".$sumapvptotd." €</td>
				</tr>
				<tr>
					<td colspan=6 class='BorderSup' >
						<div class='section'>
				<ul class='timeline'>
					<li class='TimeLine2'>
						<a href='#' title='IMPUESTOS DIFER ".$sumaivaed." €'>
				<span class='label' ".$bgivaed.">IMP <br>".$sumaivaed."</span>
				<span class='count bgcolorir' style='height: ".$TotEd1."%;'>(".$TotEd1.")</span>
						</a>
					</li>	
					<li class='TimeLine2'>
						<a href='#' title='RETENCION DIFER ".$sumareted." €'>
				<span class='label' ".$bgreted.">RET <br>".$sumareted."</span>
				<span class='count bgcolorir' style='height: ".$TotEd2."%;'>(".$TotEd2.")</span>
						</a>
					</li>	
					<li class='TimeLine2' >
						<a href='#' title='TOTAL INGRESOS ".$sumapvptoti." €'>
				<span class='label' >IN <br>".$sumapvptoti."</span>
				<span class='count bgcolori' style='height: ".$TotEd4."%;'>(".$TotEd4.")</span>
						</a>
					</li>	
					<li class='TimeLine2' >
						<a href='#' title='TOTAL GASTOS ".$sumapvptotg." €'>
				<span class='label' >OUT <br>".$sumapvptotg."</span>
				<span class='count bgcolorg' style='height: ".$TotEd5."%;'>(".$TotEd5.")</span>
						</a>
					</li>	
					<li class='TimeLine2' >
						<a href='#' title='TOTAL DIFERENCIA ".$sumapvptotd." €'>
				<span class='label' ".$bgpvptotd.">DIF <br>".$sumapvptotd."</span>
				<span class='count bgcolord' style='height: ".$TotEd3."%;'>(".$TotEd3.")</span>
						</a>
					</li>	
				</ul>
						</div>
					</td>
				</tr>
			</table>
		</div>");
	}

?>