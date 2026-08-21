<?php

	global $db; 	global $db_name; 	global $dyt1;
	
	if(isset($_POST['dy'])){
		if(strlen(trim($_POST['dy'])) != 0){ $dyt1  = '20'.$_POST['dy']; }else{ $dyt1 = date('Y'); }
	}else{ $dyt1 = date('Y'); }
    global $dyt1y;  $dyt1y = substr($dyt1, -2);    //echo $dyt1y;

	global $dm1; 
	if(isset($_POST['dm'])){
		if(strlen(trim($_POST['dm'])) != 0){ $dm1 = $_POST['dm']; }else{ $dm1 = "TRI0"; }
	}else{ $dm1 = "TRI0"; }	
	//echo $dm1;

	global $sent; 	$sent = "LIKE '%".$dm1."%'";

    global $betwIni;    global $betwFin;
    global $mesIni;     global $mesFin;
	
    if($dm1 == 'TRI0'){
        $mesIni = 1;            $mesFin = 3;
		$mesIniGri = 1;			$mesFinGri = 3;
		$mesIniGrg = 1;			$mesFinGrg = 3;
		$mesIniGrd = 1;			$mesFinGrd = 3;
    }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	////////////////////		***********  		////////////////////
                        /* TABLA BALANCE INGRESOS */
	////////////////////		***********  		////////////////////

	
	global $vnamei; 	$vnamei = "`".$_SESSION['clave']."ingresos_".$dyt1."`";

	global $OperSql;        $OperSql = "*";

    $sqli = "SELECT $OperSql FROM $vnamei";
    //echo " <br>* ".$sqli."<br>";
	$qbi = mysqli_query($db, $sqli);
	global $counti;		$counti = mysqli_num_rows($qbi);
    //echo "Rows: ".$counti."<br><br>";

/////////////////////	
/* PARA SUMAR PVPTOT */	
    global $OperSql;        $OperSql = "SUM(`factpvptot`)";
	global $sumapvptoti;

	if($counti > 0){
		$sqlSumToti = "SELECT $OperSql AS 'YearSumToti' FROM $vnamei";
		//echo "- ".$sqlSumToti."<br>";
		$qrySumToti = mysqli_query($db, $sqlSumToti);
		$SumToti = mysqli_fetch_assoc($qrySumToti);
		$sumapvptoti = $SumToti['YearSumToti'];
		$sumapvptoti  = number_format((float)($sumapvptoti ?? 0 ) ,2,".","");
		//if($sumapvptoti == ''){ $sumapvptoti = "0.00"; }else{ }
		//echo "- TOTAL ANUAL: ".$sumapvptoti."<br>";
	}else{ $sumapvptoti = "0.00"; }

/* FIN PARA SUMAR PVPTOT */
/////////////////////////

/////////////////////	
/* PARA SUMAR RETENCION TOT */	

    global $OperSql;        $OperSql = "SUM(`factrete`)";
	global $sumaretei;

	if($counti > 0){
		$sqlSumRetei = "SELECT $OperSql AS 'YearSumRetei' FROM $vnamei";
		//echo "* ".$sqlSumRetei."<br>";
		$qrySumRetei = mysqli_query($db, $sqlSumRetei);
		$SumRetei = mysqli_fetch_assoc($qrySumRetei);
		$sumaretei = $SumRetei['YearSumRetei'];
		$sumaretei  = number_format((float)($sumaretei ?? 0 ) ,2,".","");
		//if($sumaretei == ''){ $sumaretei = "0.00"; }else{ }
		//echo "* TOTAL ANUAL RETENCIONES: ".$sumaretei."<br>";
	}else{ $sumaretei = "0.00"; }

/* FIN PARA SUMAR RETENCION TOT */
/////////////////////////

/////////////////////	 
/* PARA SUMAR IVA */	

	global $OperSql;        $OperSql = "SUM(`factivae`)";
	global $sumaivaei;

	if($counti > 0){
		$sqlSumIvai = "SELECT $OperSql AS 'YearSumIvai' FROM $vnamei";
		//echo "- ".$sqlSumIvai."<br>";
		$qrySumIvai = mysqli_query($db, $sqlSumIvai);
		$SumIvai = mysqli_fetch_assoc($qrySumIvai);
		$sumaivaei = $SumIvai['YearSumIvai'];
		$sumaivaei  = number_format((float)($sumaivaei ?? 0 ) ,2,".","");
		//if($sumaivaei == ''){ $sumaivaei = "0.00";   }else{ }
		//echo "- TOTAL ANUAL IVA: ".$sumaivaei."<br>";
	}else{ $sumaivaei = "0.00"; }

	/* FIN PARA SUMAR IVA */
	/////////////////////////

	if($counti > 0){

		print ("<div style='clear:both'></div>
				<div class='divTablaIndex' >
				<table class='tabla tableForm' >
				<tr>
					<th colspan=6 class='resultadosi'>
						INGRESOS TRIMESTRALES
					</th>
				</tr>
				<tr>
					<td colspan=6 class='BorderInf' style='padding-bottom:1.6em;' >
						<div class='section'>
							<ul class='timeline'>");
			  
		global $grd;	$gri = 1;

		while($gri<=4){

			if($dm1 == 'TRI0'){
				if($mesIniGri < 10){ $mesIniGri = '0'.$mesIniGri; }else{ }
				if($mesFinGri < 10){ $mesFinGri = '0'.$mesFinGri; }else{ }
				$betwIniGri = $dyt1y.'/'.$mesIniGri.'/01';
				$betwFinGri = $dyt1y.'/'.$mesFinGri.'/31';
		
				global $MesNombGri;
				if($mesFinGri < 4){ $MesNombGri = "TRI1"; 
				}elseif($mesFinGri < 7){ $MesNombGri = "TRI2"; 
				}elseif($mesFinGri < 10){ $MesNombGri = "TRI3"; 
				}else{  $MesNombGri = "TRI4"; }

				$rowi['factdate'] = $MesNombGri;
			}
			
			$SqlFromi = "FROM $vnamei WHERE (`factdate` BETWEEN '$betwIniGri' AND '$betwFinGri')";
			$sqlSumToti = "SELECT SUM(`factpvptot`) AS 'TriSumToti' $SqlFromi";
			$qrySumToti = mysqli_query($db, $sqlSumToti);
			$SumToti = mysqli_fetch_assoc($qrySumToti);
			$TriSumToti = $SumToti['TriSumToti'];
			$rowi['factpvptot']  = number_format((float)($TriSumToti ?? 0 ) ,2,".","");
			//if($TriSumTotg == ''){ $TriSumTotg = "0.00"; }else{ }
			global $sumapvptoti;
			if($sumapvptoti > 0){
				$TotEi = ($rowi['factpvptot']*100)/$sumapvptoti;
			}elseif($sumapvptoti < 0){
				$TotEi = ($rowi['factpvptot']*100)/(abs($sumapvptoti));
			}else{ $TotEi = 0.00;}

			print("<li>
						<a href='#' title='".$rowi['factdate']." ".$rowi['factpvptot']." €'>
							<span class='label'>".$rowi['factdate']."<br>".$rowi['factpvptot']."</span>
							<span class='count bgcolori' style='height: ".$TotEi."%'>(".$TotEi.")</span>
						</a>
					</li>");

			$gri++;	$mesIniGri = $mesIniGri+3;    $mesFinGri = $mesFinGri+3;
		}
		if($sumapvptoti > 0){
			$TotEi = ((abs($sumapvptoti))*100)/(abs($sumapvptoti)); 
		}else{ $TotEi = 0.00; }

		print("<li>
					<a href='#' title='ANUAL TOT ".(abs($sumapvptoti))." €'>
						<span class='label'>".$dyt1."<br>".(abs($sumapvptoti))."</span>
						<span class='count bgcolord' style='height: ".$TotEi."%'>(".$TotEi.")</span>
					</a>
				</li>

				</ul>
				</div>
					</td>
				</tr>
			<tr>
				<td colspan='2' class='resultadosi' align='center'>IMP REPER</td>
				<td colspan='2' class='resultadosi' align='center'>RETEN REPER</td>
				<td colspan='2' class='resultadosi' align='center'>TOT INGRESOS</td>
			</tr>
			<tr>
				<td colspan='2' class='BorderInf resultadosi' align='center'>".$sumaivaei." €</td>
				<td colspan='2' class='BorderInf resultadosi' align='center'>".$sumaretei." €</td>
				<td colspan='2' class='BorderInf resultadosi' align='center'>".$sumapvptoti." €</td>
			</tr>
			<tr>
				<th>AÑO</th><th>MES</th><th>IVA REPER</th>
				<th>SUB TOT</th><th>RET REPER</th><th>TOTAL €</th>			
			</tr>");

		global $styleBgc;	
		global $i;  $i = 1; 	
		while($i <= 4){

			if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }

			if(($dm1 == 'TRI0')||($dm1 == 'TRI0')){
				if($mesIni < 10){ $mesIni = '0'.$mesIni; }else{ }
				if($mesFin < 10){ $mesFin = '0'.$mesFin; }else{ }
				$betwIni = $dyt1y.'/'.$mesIni.'/01';
				$betwFin = $dyt1y.'/'.$mesFin.'/31';
		
				global $MesNomb;
				if($mesFin < 4){ $MesNomb = "TRI1"; 
				}elseif($mesFin < 7){ $MesNomb = "TRI2"; 
				}elseif($mesFin < 10){ $MesNomb = "TRI3"; 
				}else{  $MesNomb = "TRI4"; }

				$rowi['factdate'] = $MesNomb;
			}
    
			global $TriSumIvai;	global $TriSumSubToti;	global $TriSumRetei;	global $TriSumToti;
	
			$SqlFromi = "FROM $vnamei WHERE (`factdate` BETWEEN '$betwIni' AND '$betwFin')";
			$sqlSumIva = "SELECT SUM(`factivae`) AS 'TriSumIvai' $SqlFromi";
			$qrySumIva = mysqli_query($db, $sqlSumIva);
			$SumIva = mysqli_fetch_assoc($qrySumIva);
			$TriSumIvai = $SumIva['TriSumIvai'];
			$rowi['factivae']  = number_format((float)($TriSumIvai ?? 0 ) ,2,".","");
			//if($TriSumIvai == ''){ $TriSumIvai = "0.00"; }else{ }

			$sqlSumSub = "SELECT SUM(`factpvp`) AS 'TriSumSubToti' $SqlFromi";
			$qrySumSub = mysqli_query($db, $sqlSumSub);
			$SumSub = mysqli_fetch_assoc($qrySumSub);
			$TriSumSubToti = $SumSub['TriSumSubToti'];
			$rowi['factpvp']  = number_format((float)($TriSumSubToti ?? 0 ) ,2,".","");
			//if($TriSumSubToti == ''){ $TriSumSubToti = "0.00"; }else{ }

			$sqlSumRete = "SELECT SUM(`factrete`) AS 'TriSumRetei' $SqlFromi";
			$qrySumRete = mysqli_query($db, $sqlSumRete);
			$SumRete = mysqli_fetch_assoc($qrySumRete);
			$TriSumRetei = $SumRete['TriSumRetei'];
			$rowi['factrete']  = number_format((float)($TriSumRetei ?? 0 ) ,2,".","");
			//if($TriSumRetei == ''){ $TriSumRetei ="0.00"; }else{ }

			$sqlSumTot = "SELECT SUM(`factpvptot`) AS 'TriSumToti' $SqlFromi";
			//echo "* ".$sqlSumTot."<br>";
			$qrySumTot = mysqli_query($db, $sqlSumTot);
			$SumTot = mysqli_fetch_assoc($qrySumTot);
			$TriSumToti = $SumTot['TriSumToti'];
			$rowi['factpvptot']  = number_format((float)($TriSumToti ?? 0 ) ,2,".","");
			//if($TriSumToti == ''){ $TriSumToti = "0.00"; }else{ }

		global $vnamei; 	global $dyt1;   global $MesNomb;
		print (	"<tr class='".$styleBgc."'>
					<td align='center' >".$dyt1."</td>
					<td align='right' >".$rowi['factdate']."</td>
					<td align='right' >".$rowi['factivae']." €</td>
					<td align='right' >".$rowi['factpvp']." €</td>
					<td align='right' >".$rowi['factrete']." €</td>
					<td align='right' >".$rowi['factpvptot']." €</td>
				</tr>");

			$i++;   $mesIni = $mesIni+3;    $mesFin = $mesFin+3;

		} /* FIN DEL WHILE */ 

	}else{
		global $dyt1;
		$TriSumSubToti = "0.00";
		$TriSumRetei ="0.00";
		$TriSumToti = "0.00";
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
	}      

	print("</table>");

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	////////////////////		***********  		////////////////////
                        /* TABLA BALANCE GASTOS */
	////////////////////		***********  		////////////////////

	global $betwIni;    global $betwFin;
    global $mesIni;     global $mesFin;
	global $mesIniGrg;	global $mesFinGrg;
    if($dm1 == 'TRI0'){
        $mesIni = 1;	$mesFin = 3;
		$mesIniGrg = 1;	$mesFinGrg = 3;
	}

	global $vnameg; 	$vnameg = "`".$_SESSION['clave']."gastos_".$dyt1."`";
    
    global $OperSql;        $OperSql = "*";

    $sqlg = "SELECT $OperSql FROM $vnameg";
    //echo " * NUEVA SENTECIA TABLA INFERIOR:<br>".$sqli."<br>";
	$qbg = mysqli_query($db, $sqlg);
	global $countg;	$countg = mysqli_num_rows($qbg);
    //echo "Rows: ".$countg."<br><br>";

/////////////////////	
/* PARA SUMAR PVPTOT */

    global $OperSql;        $OperSql = "SUM(`factpvptot`)";
    $sqlSumTotg = "SELECT $OperSql AS 'YearSumTotg' FROM $vnameg";
    //echo $sqlSumTot."<br>";
	global $sumapvptotg;
	if($countg > 0){
		$qrySumTotg = mysqli_query($db, $sqlSumTotg);
		$SumTotg = mysqli_fetch_assoc($qrySumTotg);
		$sumapvptotg = $SumTotg['YearSumTotg'];
		$sumapvptotg  = number_format((float)($sumapvptotg ?? 0 ) ,2,".","");
		//if($sumapvptotg == ''){ $sumapvptotg = "0.00"; }else{ }
		//echo "* TOTAL ANUAL: ".$sumapvptoti."<br>";
	}else{ $sumapvptotg = "0.00"; }

/* FIN PARA SUMAR PVPTOT */
/////////////////////////

/////////////////////	
/* PARA SUMAR RETENCION TOT */

    global $OperSql;        $OperSql = "SUM(`factrete`)";
    $sqlSumReteg = "SELECT $OperSql AS 'YearSumReteg' FROM $vnameg";
    //echo $sqlSumRete."<br>";
	global $sumareteg;
	if($countg > 0){
		$qrySumReteg = mysqli_query($db, $sqlSumReteg);
		$SumReteg = mysqli_fetch_assoc($qrySumReteg);
		$sumareteg = $SumReteg['YearSumReteg'];
		$sumareteg  = number_format((float)($sumareteg ?? 0 ) ,2,".","");
		//if($sumareteg == ''){  }else{ }
		//echo "* TOTAL ANUAL RETENCIONES: ".$sumaretei."<br>";
	}else{ $sumareteg = "0.00"; }

/* FIN PARA SUMAR RETENCION TOT */
/////////////////////////

/////////////////////	
/* PARA SUMAR IVA */	

    global $OperSql;        $OperSql = "SUM(`factivae`)";
    $sqlSumIvag = "SELECT $OperSql AS 'YearSumIvag' FROM $vnameg";
    //echo $sqlSumIva."<br>";
	if($countg > 0){
		$qrySumIvag = mysqli_query($db, $sqlSumIvag);
		$SumIvag = mysqli_fetch_assoc($qrySumIvag);
		global $sumaivaeg;
		$sumaivaeg = $SumIvag['YearSumIvag'];
		$sumaivaeg  = number_format((float)($sumaivaeg ?? 0 ) ,2,".","");
		//if($sumaivaeg == ''){ $sumaivaeg = "0.00";   }else{ }
		//echo "* TOTAL ANUAL IVA: ".$sumaivaei."<br>";
	}else{ $sumaivaeg = "0.00"; }

/* FIN PARA SUMAR IVA */
/////////////////////////
	
	if($countg > 0){

		print ("<table class='tablac tableForm'>
				<tr>
					<th colspan=6 class='resultadosg'>
						GASTOS TRIMESTRALES
					</th>
				</tr>
				<tr>
					<td colspan=6 class='BorderInf' style='padding-bottom:1.6em;'>
						<div class='section'>
							<ul class='timeline'>");
			  
		global $grg;	$grg = 1;
		while($grg<=4){

			if($dm1 == 'TRI0'){
				if($mesIniGrg < 10){ $mesIniGrg = '0'.$mesIniGrg; }else{ }
				if($mesFinGrg < 10){ $mesFinGrg = '0'.$mesFinGrg; }else{ }
				$betwIniGrg = $dyt1y.'/'.$mesIniGrg.'/01';
				$betwFinGrg = $dyt1y.'/'.$mesFinGrg.'/31';
		
				global $MesNombGrg;
				if($mesFinGrg < 4){ $MesNombGrg = "TRI1"; 
				}elseif($mesFinGrg < 7){ $MesNombGrg = "TRI2"; 
				}elseif($mesFinGrg < 10){ $MesNombGrg = "TRI3"; 
				}else{  $MesNombGrg = "TRI4"; }

				$rowg['factdate'] = $MesNombGrg;
			}
			
			$SqlFromg = "FROM $vnameg WHERE (`factdate` BETWEEN '$betwIniGrg' AND '$betwFinGrg')";

			$sqlSumTotg = "SELECT SUM(`factpvptot`) AS 'TriSumTotg' $SqlFromg";
			$qrySumTotg = mysqli_query($db, $sqlSumTotg);
			$SumTotg = mysqli_fetch_assoc($qrySumTotg);
			$TriSumTotg = $SumTotg['TriSumTotg'];
			$rowg['factpvptot']  = number_format((float)($TriSumTotg ?? 0 ) ,2,".","");
			//if($TriSumTotg == ''){ $TriSumTotg = "0.00"; }else{ }
			global $sumapvptotg;
			if($sumapvptotg > 0){
				$TotEg = ($rowg['factpvptot']*100)/$sumapvptotg;
			}elseif($sumapvptotg < 0){
				$TotEg = ($rowg['factpvptot']*100)/(abs($sumapvptotg));
			}else{ $TotEg = 0.00;}

			print("<li>
						<a href='#' title='".$rowg['factdate']." ".$rowg['factpvptot']." €'>
							<span class='label'>".$rowg['factdate']."<br>".$rowg['factpvptot']."</span>
							<span class='count bgcolorg' style='height: ".$TotEg."%'>(".$TotEg.")</span>
						</a>
					</li>");

			$grg++;	$mesIniGrg = $mesIniGrg+3;    $mesFinGrg = $mesFinGrg+3;
		}

		if($sumapvptotg > 0){
			$TotEg = ((abs($sumapvptotg))*100)/(abs($sumapvptotg)); 
		}else{ $TotEg = 0.00; }

		print("<li>
					<a href='#' title='ANUAL TOT ".(abs($sumapvptotg))." €'>
						<span class='label'>".$dyt1."<br>".(abs($sumapvptotg))."</span>
						<span class='count bgcolord' style='height: ".$TotEg."%'>(".$TotEg.")</span>
					</a>
				</li>");

		print("	</ul>
				</div>
					</td>
				</tr>
				<tr>
					<td colspan='2' class='resultadosg' align='center'>IMP REPER</td>
					<td colspan='2' class='resultadosg' align='center'>RETEN REPER</td>
					<td colspan='2' class='resultadosg' align='center'>TOT GASTOS</td>
				</tr>
				<tr>
					<td colspan='2' class='BorderInf resultadosg' align='center'>".$sumaivaeg." €</td>
					<td colspan='2' class='BorderInf resultadosg' align='center'>".$sumareteg." €</td>
					<td colspan='2' class='BorderInf resultadosg' align='center'>".$sumapvptotg." €</td>
				</tr>
				<tr>
					<th>AÑO</th><th>MES</th><th>IVA REPER</th>
					<th>SUB TOT</th><th>RET REPER</th><th>TOTAL €</th>			
				</tr>");

		global $styleBgc;
		global $i;  $i = 1; 
		while($i <= 4){

			if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
		
			if($dm1 == 'TRI0'){
				if($mesIni < 10){ $mesIni = '0'.$mesIni; }else{ }
				if($mesFin < 10){ $mesFin = '0'.$mesFin; }else{ }
				$betwIni = $dyt1y.'/'.$mesIni.'/01';
				$betwFin = $dyt1y.'/'.$mesFin.'/31';
		
				global $MesNomb;
				if($mesFin < 4){ $MesNomb = "TRI1"; 
				}elseif($mesFin < 7){ $MesNomb = "TRI2"; 
				}elseif($mesFin < 10){ $MesNomb = "TRI3"; 
				}else{  $MesNomb = "TRI4"; }

				$rowg['factdate'] = $MesNomb;
			}
		
		$SqlFromg = "FROM $vnameg WHERE (`factdate` BETWEEN '$betwIni' AND '$betwFin')";
		$sqlSumIvag = "SELECT SUM(`factivae`) AS 'TriSumIvag' $SqlFromg";
		$qrySumIvag = mysqli_query($db, $sqlSumIvag);
		$SumIvag = mysqli_fetch_assoc($qrySumIvag);
		$TriSumIvag = $SumIvag['TriSumIvag'];
		$rowg['factivae'] = number_format((float)($TriSumIvag ?? 0 ),2,".","");
		//if($TriSumIvag == ''){ $TriSumIvag = "0.00"; }else{ }

		$sqlSumSubg = "SELECT SUM(`factpvp`) AS 'TriSumSubTotg' $SqlFromg";
		$qrySumSubg = mysqli_query($db, $sqlSumSubg);
		$SumSubg = mysqli_fetch_assoc($qrySumSubg);
		$TriSumSubTotg = $SumSubg['TriSumSubTotg'];
		$rowg['factpvp'] = number_format((float)($TriSumSubTotg ?? 0 ),2,".","");
		//if($TriSumSubTotg == ''){ $TriSumSubTotg = "0.00"; }else{ }

		$sqlSumReteg = "SELECT SUM(`factrete`) AS 'TriSumReteg' $SqlFromg";
		$qrySumReteg = mysqli_query($db, $sqlSumReteg);
		$SumReteg = mysqli_fetch_assoc($qrySumReteg);
		$TriSumReteg = $SumReteg['TriSumReteg'];
		$rowg['factrete']  = number_format((float)($TriSumReteg ?? 0 ) ,2,".","");
		//if($TriSumReteg == ''){ $TriSumReteg ="0.00"; }else{ }

		$sqlSumTotg = "SELECT SUM(`factpvptot`) AS 'TriSumTotg' $SqlFromg";
		$qrySumTotg = mysqli_query($db, $sqlSumTotg);
		$SumTotg = mysqli_fetch_assoc($qrySumTotg);
		$TriSumTotg = $SumTotg['TriSumTotg'];
		$rowg['factpvptot']  = number_format((float)($TriSumTotg ?? 0 ) ,2,".","");
		//if($TriSumTotg == ''){ $TriSumTotg = "0.00"; }else{ }
				
		global $dyt1;
		print (	"<tr class='".$styleBgc."'>
					<td align='center' >".$dyt1."</td>
					<td align='right' >".$rowg['factdate']."</td>
					<td align='right' >".$rowg['factivae']." €</td>
					<td align='right' >".$rowg['factpvp']." €</td>
					<td align='right' >".$rowg['factrete']." €</td>
					<td align='right' >".$rowg['factpvptot']." €</td>
				</tr>");

			$i++;   $mesIni = $mesIni+3;    $mesFin = $mesFin+3;

		} /* Fin del while.*/ 
	}else{
		global $dyt1;
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
		</tr>");
		}
	print("</table>");

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

			////////////////////		**********  		////////////////////
								/* TABLA BALANCE DIFERENCIAL */
			////////////////////		**********  		////////////////////
		
    if($dm1 == 'TRI0'){
        $mesIni = 1;            $mesFin = 3;
	}

/////////////////////	

/* OPERACIONES PARA DIFER */	

	global $sumapvptoti; 		global $sumaretei; 		global $sumaivaei;
	global $sumapvptotg; 		global $sumareteg; 		global $sumaivaeg;
	global $sumapvptotd; 		global $sumareted; 		global $sumaivaed;

	$sumapvptotd = $sumapvptoti - $sumapvptotg;
	$sumapvptotd  = number_format((float)($sumapvptotd ?? 0 ) ,2,".","");
	//if($sumapvptotd == ""){$sumapvptotd = "0.00"; }else{ }

	$sumareted = $sumaretei - $sumareteg;
	$sumareted  = number_format((float)($sumareted ?? 0 ) ,2,".","");
	//if($sumareted == ""){ $sumareted = "0.00";}else{ }

	$sumaivaed = $sumaivaei - $sumaivaeg;
	$sumaivaed  = number_format((float)($sumaivaed ?? 0 ) ,2,".","");
	//if($sumaivaed == ""){ $sumaivaed = "0.00"; }else{ }

	//$sumapvptotd = '';	$sumareted = 0.00;	$sumaivaed = 0;

	if((($sumapvptotd == 0.00)||($sumapvptotd == ''))&&(($sumareted == 0.00)||($sumareted == ''))&&(($sumaivaed == 0.00)||($sumaivaed == ''))){			
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
				<th colspan=6 class='resultadosd'>
					DIFERENCIA INGRESOS / GASTOS TRIMESTRALES
				</th>
			</tr>
			<tr>
				<td colspan=6 class='BorderInf' style='padding-bottom:1.6em;'>
					<div class='section'>
						<ul class='timeline'>");
	
		global $grd;	$grd = 1;

		while($grd<=4){

			if($dm1 == 'TRI0'){
				if($mesIniGrd < 10){ $mesIniGrd = '0'.$mesIniGrd; }else{ }
				if($mesFinGrd < 10){ $mesFinGrd = '0'.$mesFinGrd; }else{ }

				$betwIniGri = $dyt1y.'/'.$mesIniGrd.'/01';	$betwIniGrg = $dyt1y.'/'.$mesIniGrd.'/01';
				$betwFinGri = $dyt1y.'/'.$mesFinGrd.'/31';	$betwFinGrg = $dyt1y.'/'.$mesFinGrd.'/31';
		
				global $MesNombGrd;
				if($mesFinGrd < 4){ $MesNombGrd = "TRI1"; 
				}elseif($mesFinGrd < 7){ $MesNombGrd = "TRI2"; 
				}elseif($mesFinGrd < 10){ $MesNombGrd = "TRI3"; 
				}else{  $MesNombGrd = "TRI4"; }

				$rowd['factdate'] = $MesNombGrd;
			}
			
			
			$SqlFromgri = "FROM $vnamei WHERE (`factdate` BETWEEN '$betwIniGri' AND '$betwFinGri')";
			//echo $SqlFromgri."<br>";
			$sqlSumTotgri = "SELECT SUM(`factpvptot`) AS 'TriSumTotgri' $SqlFromgri";
			$qrySumTotgri = mysqli_query($db, $sqlSumTotgri);
			$SumTotgri = mysqli_fetch_assoc($qrySumTotgri);
			$TriSumTotgri = $SumTotgri['TriSumTotgri'];
			$rowgri['factpvptot']  = number_format((float)($TriSumTotgri ?? 0 ) ,2,".","");
			//if($TriSumTotg == ''){ $TriSumTotg = "0.00"; }else{ }
			//echo $rowgri['factpvptot']."<br>";

			global $sumapvptoti;
			if($sumapvptoti > 0){
				$TotEi = ($rowi['factpvptot']*100)/$sumapvptoti;
			}elseif($sumapvptoti < 0){
				$TotEi = ($rowi['factpvptot']*100)/(abs($sumapvptoti));
			}else{ $TotEi = 0.00;}
			
			/*	*/
			$SqlFromgrg = "FROM $vnameg WHERE (`factdate` BETWEEN '$betwIniGrg' AND '$betwFinGrg')";
			//echo $SqlFromgrg."<br>";
			$sqlSumTotgrg = "SELECT SUM(`factpvptot`) AS 'TriSumTotgrg' $SqlFromgrg";
			$qrySumTotgrg = mysqli_query($db, $sqlSumTotgrg);
			$SumTotgrg = mysqli_fetch_assoc($qrySumTotgrg);
			$TriSumTotgrg = $SumTotgrg['TriSumTotgrg'];
			$rowgrg['factpvptot']  = number_format((float)($TriSumTotgrg ?? 0 ) ,2,".","");
			
			//if($TriSumTotg == ''){ $TriSumTotg = "0.00"; }else{ }
			//echo $rowgrg['factpvptot']."<br>";
			/* */

			global $sumapvptotd;
			$calculo = $rowgri['factpvptot'] - $rowgrg['factpvptot'];
			$rowd['factpvptot'] = number_format(abs((float)($calculo ?? 0)) ,2,".","");
			if($sumapvptotd > 0){
				$TotEd = ($rowd['factpvptot']*100)/$sumapvptotd;
			}elseif($sumapvptotd < 0){
				$TotEd = ($rowd['factpvptot']*100)/(abs($sumapvptotd));
			}else{ $TotEd = 0.00;}

		if(	$rowd['factpvptot'] >= 0){ $bgRed = ""; }else{ $bgRed = "style='background: #ff5e00 !important;'"; }

		print("<li>
					<a href='#' title='".$rowd['factdate']." ".$rowd['factpvptot']." €'>
						<span class='label' ".$bgRed.">".$rowd['factdate']."<br>".$rowd['factpvptot']."</span>
						<span class='count bgcolorir' style='height: ".$TotEd."%'>(".$TotEd.")</span>
					</a>
				</li>");

			$grd++;	$mesIniGrd = $mesIniGrd+3;    $mesFinGrd = $mesFinGrd+3;
		}

		if(	$sumapvptotd >= 0){ $bgRed = ""; }else{ $bgRed = "style='background: #ff5e00 !important;'"; }

		if($sumapvptotd > 0){
			$TotEd = ((abs($sumapvptotd))*100)/(abs($sumapvptotd)); 
		}elseif($sumapvptotd < 0){
			$TotEd = ((abs($sumapvptotd))*100)/(abs($sumapvptotd));
		}else{ $TotEd = 0.00; }

		print("<li>
					<a href='#' title='DIFER ANUAL ".$sumapvptotd." €'>
						<span class='label' ".$bgRed.">".$dyt1."<br>".$sumapvptotd."</span>
						<span class='count bgcolord' style='height: ".$TotEd."%'>(".$TotEd.")</span>
					</a>
				</li>");
		
	print("	</ul>
				</div>
					</td>
			</tr>
			<tr>
				<td colspan='2' class='resultadosd' align='center'>IMP REPER</td>
				<td colspan='2' class='resultadosd' align='center'>RETEN REPER</td>
				<td colspan='2' class='resultadosd' align='center'>DIFER INGRESOS</td>
			</tr>
			<tr>
				<td colspan='2' class='BorderInf resultadosd' align='center'>".$sumaivaed." €</td>
				<td colspan='2' class='BorderInf resultadosd' align='center'>".$sumareted." €</td>
				<td colspan='2' class='BorderInf resultadosd' align='center'>".$sumapvptotd." €</td>
			</tr>
			<tr>
				<th>AÑO</th><th>MES</th><th>IVA REPER</th>
				<th>SUB TOT</th><th>RET REPER</th><th>TOTAL €</th>			
			</tr>");

    global $i;  $i = 1; 
    global $TriSumIvad;		global $TriSumSubTotd; 		global $TriSumReted; 		global $TriSumTotd;

	global $styleBgc;

	while($i <= 4){

		if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }

        if($dm1 == 'TRI0'){
            if($mesIni < 10){ $mesIni = '0'.$mesIni; }else{ }
            if($mesFin < 10){ $mesFin = '0'.$mesFin; }else{ }
            $betwIni = $dyt1y.'/'.$mesIni.'/01';
            $betwFin = $dyt1y.'/'.$mesFin.'/31';
    
            global $MesNomb;
            if($mesFin < 4){ $MesNomb = "TRI1"; 
            }elseif($mesFin < 7){ $MesNomb = "TRI2"; 
            }elseif($mesFin < 10){ $MesNomb = "TRI3"; 
            }else{  $MesNomb = "TRI4"; }
        }

		/* CONSULTAS PARA INGRESOS */
		global $vnamei; global $SqlFromi;
		$SqlFromi = "FROM $vnamei WHERE (`factdate` BETWEEN '$betwIni' AND '$betwFin')";

		$sqlSumIva = "SELECT SUM(`factivae`) AS 'TriSumIvai' $SqlFromi";
		$qrySumIva = mysqli_query($db, $sqlSumIva);
		$SumIva = mysqli_fetch_assoc($qrySumIva);
		$TriSumIvai = $SumIva['TriSumIvai'];
		$TriSumIvai = number_format((float)($TriSumIvai ?? 0 ),2,".","");
		//if($TriSumIvai == ''){ $TriSumIvai = "0.00"; }else{ }
		
		$sqlSumSub = "SELECT SUM(`factpvp`) AS 'TriSumSubToti' $SqlFromi";
		$qrySumSub = mysqli_query($db, $sqlSumSub);
		$SumSub = mysqli_fetch_assoc($qrySumSub);
		$TriSumSubToti = $SumSub['TriSumSubToti'];
		$TriSumSubToti = number_format((float)($TriSumSubToti ?? 0 ),2,".","");
		//if($TriSumSubToti == ''){ $TriSumSubToti = "0.00"; }else{ }
	
		$sqlSumRete = "SELECT SUM(`factrete`) AS 'TriSumRetei' $SqlFromi";
		$qrySumRete = mysqli_query($db, $sqlSumRete);
		$SumRete = mysqli_fetch_assoc($qrySumRete);
		$TriSumRetei = $SumRete['TriSumRetei'];
		$TriSumRetei = number_format((float)($TriSumRetei ?? 0 ),2,".","");
		//if($TriSumRetei == ''){ $TriSumRetei ="0.00"; }else{ }
	
		$sqlSumTot = "SELECT SUM(`factpvptot`) AS 'TriSumToti' $SqlFromi";
		$qrySumTot = mysqli_query($db, $sqlSumTot);
		$SumTot = mysqli_fetch_assoc($qrySumTot);
		$TriSumToti = $SumTot['TriSumToti'];
		$TriSumToti= number_format((float)($TriSumToti ?? 0 ),2,".","");
		//if($TriSumToti == ''){ $TriSumToti = "0.00"; }else{ }

		/* CONSULTAS PARA GASTOS */
		global $vnameg; 	global $SqlFromg;
		$SqlFromg = "FROM $vnameg WHERE (`factdate` BETWEEN '$betwIni' AND '$betwFin')";
		
		$sqlSumIvag = "SELECT SUM(`factivae`) AS 'TriSumIvag' $SqlFromg";
		$qrySumIvag = mysqli_query($db, $sqlSumIvag);
		$SumIvag = mysqli_fetch_assoc($qrySumIvag);
		$TriSumIvag = $SumIvag['TriSumIvag'];
		$TriSumIvag = number_format((float)($TriSumIvag ?? 0 ),2,".","");
		//if($TriSumIvag == ''){ $TriSumIvag = "0.00"; }else{ }
	
		$sqlSumSubg = "SELECT SUM(`factpvp`) AS 'TriSumSubTotg' $SqlFromg";
		$qrySumSubg = mysqli_query($db, $sqlSumSubg);
		$SumSubg = mysqli_fetch_assoc($qrySumSubg);
		$TriSumSubTotg = $SumSubg['TriSumSubTotg'];
		$TriSumSubTotg = number_format((float)($TriSumSubTotg ?? 0 ),2,".","");
		//if($TriSumSubTotg == ''){ $TriSumSubTotg = "0.00"; }else{ }
	
		$sqlSumReteg = "SELECT SUM(`factrete`) AS 'TriSumReteg' $SqlFromg";
		$qrySumReteg = mysqli_query($db, $sqlSumReteg);
		$SumReteg = mysqli_fetch_assoc($qrySumReteg);
		$TriSumReteg = $SumReteg['TriSumReteg'];
		$TriSumReteg = number_format((float)($TriSumReteg ?? 0 ),2,".","");
		//if($TriSumReteg == ''){ $TriSumReteg ="0.00"; }else{ }
	
		$sqlSumTotg = "SELECT SUM(`factpvptot`) AS 'TriSumTotg' $SqlFromg";
		$qrySumTotg = mysqli_query($db, $sqlSumTotg);
		$SumTotg = mysqli_fetch_assoc($qrySumTotg);
		$TriSumTotg = $SumTotg['TriSumTotg'];
		$TriSumTotg = number_format((float)($TriSumTotg ?? 0 ),2,".","");
		//if($TriSumTotg == ''){ $TriSumTotg = "0.00"; }else{ }

		/* CALCULO DE LAS DIFERENCIAS */

		$TriSumIvad = $TriSumIvai - $TriSumIvag;
		$TriSumIvad = number_format((float)($TriSumIvad ?? 0 ),2,".","");

		$TriSumSubTotd = $TriSumSubToti - $TriSumSubTotg;
		$TriSumSubTotd= number_format((float)($TriSumSubTotd ?? 0 ),2,".","");

		$TriSumReted = $TriSumRetei - $TriSumReteg;
		$TriSumReted = number_format(($TriSumReted ?? 0 ),2,".","");

		$TriSumTotd = $TriSumToti - $TriSumTotg;
		$TriSumTotd = number_format((float)($TriSumTotd ?? 0 ),2,".","");

		global $dyt1;   global $MesNomb;
		//if($rowi['tot']!= 0.00){
		print (	"<tr class='".$styleBgc."' >
					<td align='center' >".$dyt1."</td>
					<td align='right' >".$MesNomb."</td>
					<td align='right' >".$TriSumIvad." €</td>
					<td align='right' >".$TriSumSubTotd." €</td>
					<td align='right' >".$TriSumReted." €</td>
					<td align='right' >".$TriSumTotd." €</td>
				</tr>");

        $i++;   $mesIni = $mesIni+3;    $mesFin = $mesFin+3;

    } /* Fin del while.*/ 

	print("</table>");

	} // FIN SI HAY DATOS

			////////////////////		***********  		////////////////////

	print("</div>");


?>