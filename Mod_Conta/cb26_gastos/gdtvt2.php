<?php

/////////////////////////////////////////////////////////////////////////////////////////////////

	if($_POST['dy'] == ''){ $dy = date('Y'); } else {$dy = $_POST['dy'];}

	//$dm = "/".$_POST['dm']."/";
	
	global $db;	 		global $db_name; 		global $fil;
	global $orden; 		global $factnom; 		global $factnif;
	global $factnum; 	global $fnum; 			global $fnif;
	global $fnom;
	
	//$fnum = "%".$fnum."%";
	//$fnom = "%".$fnom."%";
	
	global $vname; 		//$vname = "`".$_SESSION['clave']."gastos_".$dyt1."`";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';

/////////////////////////
/* PARA SUMAR TOTAL 01 */

	$fil = "%".$dy."/01%";
	//$sql01 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	$sql01 =  $sqlb;
	$qb01 = mysqli_query($db, $sql01);

	if($qb01){
	$qtot01 = mysqli_query($db, $sql01);
	$rowtot01 = mysqli_num_rows($qtot01);
	$sumatot01 = 0;
		  for($i=0; $i<$rowtot01; $i++){$ver = mysqli_fetch_assoc($qtot01);
						 				$sumatot01 = $sumatot01 + $ver['factpvptot'];
										}
	$m01 = "01,";
	if($sumatot01 == 0){$sumatot01 = "0.00,";
	//print("* ".$m01." ".$sumatot01."<br/>");
	}else{$sumatot01 = $sumatot01.",";
			//print("* ".$m01.". ".$sumatot01."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 01 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 02 */

	$fil = "%".$dy."/02%";
	//$sql02 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql02 =  $sqlb;
	$qb02 = mysqli_query($db, $sql02);

	if($qb02){
	$qtot02 = mysqli_query($db, $sql02);
	$rowtot02 = mysqli_num_rows($qtot02);
	$sumatot02 = 0;
		  for($i=0; $i<$rowtot02; $i++){$ver = mysqli_fetch_assoc($qtot02);
						 				$sumatot02 = $sumatot02 + $ver['factpvptot'];
										}
	$m02 = "02,";
	if($sumatot02 == 0){$sumatot02 = "0.00,";
	//print("* ".$m02." ".$sumatot02."<br/>");
	}else{$sumatot02 = $sumatot02.",";
			//print("* ".$m02." ".$sumatot02."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 02 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 03 */

	$fil = "%".$dy."/03%";
	//$sql03 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql03 =  $sqlb;
	$qb03 = mysqli_query($db, $sql03);

	if($qb03){
	$qtot03 = mysqli_query($db, $sql03);
	$rowtot03 = mysqli_num_rows($qtot03);
	$sumatot03 = 0;
		  for($i=0; $i<$rowtot03; $i++){$ver = mysqli_fetch_assoc($qtot03);
						 				$sumatot03 = $sumatot03 + $ver['factpvptot'];
										}
	$m03 = "03,";
	if($sumatot03 == 0){$sumatot03 = "0.00,";
	//print("* ".$m03." ".$sumatot03."<br/>");
	}else{$sumatot03 = $sumatot03.",";
			//print("* ".$m03." ".$sumatot03."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 03 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 04 */

	$fil = "%".$dy."/04%";
	//$sql04 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql04 =  $sqlb;
	$qb04 = mysqli_query($db, $sql04);

	if($qb04){
	$qtot04 = mysqli_query($db, $sql04);
	$rowtot04 = mysqli_num_rows($qtot04);
	$sumatot04 = 0;
		  for($i=0; $i<$rowtot04; $i++){$ver = mysqli_fetch_assoc($qtot04);
						 				$sumatot04 = $sumatot04 + $ver['factpvptot'];
										}
	$m04 = "04,";
	if($sumatot04 == 0){$sumatot04 = "0.00,";
	//print("* ".$m04." ".$sumatot04."<br/>");
	}else{$sumatot04 = $sumatot04.",";
			//print("* ".$m04." ".$sumatot04."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 04 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 05 */

	$fil = "%".$dy."/05%";
	//$sql05 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql05 =  $sqlb;
	$qb05 = mysqli_query($db, $sql05);

	if($qb05){
	$qtot05 = mysqli_query($db, $sql05);
	$rowtot05 = mysqli_num_rows($qtot05);
	$sumatot05 = 0;
		  for($i=0; $i<$rowtot05; $i++){$ver = mysqli_fetch_assoc($qtot05);
						 				$sumatot05 = $sumatot05 + $ver['factpvptot'];
										}
	$m05 = "05,";
	if($sumatot05 == 0){$sumatot05 = "0.00,";
	//print("* ".$m05." ".$sumatot05."<br/>");
	}else{$sumatot05 = $sumatot05.",";
			//print("* ".$m05." ".$sumatot05."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 05 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 06 */

	$fil = "%".$dy."/06%";
	//$sql06 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql06 =  $sqlb;
	$qb06 = mysqli_query($db, $sql06);

	if($qb06){
	$qtot06 = mysqli_query($db, $sql06);
	$rowtot06 = mysqli_num_rows($qtot06);
	$sumatot06 = 0;
		  for($i=0; $i<$rowtot06; $i++){$ver = mysqli_fetch_assoc($qtot06);
						 				$sumatot06 = $sumatot06 + $ver['factpvptot'];
										}
	$m06 = "06,";
	if($sumatot06 == 0){$sumatot06 = "0.00,";
	//print("* ".$m06." ".$sumatot06."<br/>");
	}else{$sumatot06 = $sumatot06.",";
			//print("* ".$m06." ".$sumatot06."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 06 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 07 */

	$fil = "%".$dy."/07%";
	//$sql07 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql07 =  $sqlb;
	$qb07 = mysqli_query($db, $sql07);

	if($qb07){
	$qtot07 = mysqli_query($db, $sql07);
	$rowtot07 = mysqli_num_rows($qtot07);
	$sumatot07 = 0;
		  for($i=0; $i<$rowtot07; $i++){$ver = mysqli_fetch_assoc($qtot07);
						 				$sumatot07 = $sumatot07 + $ver['factpvptot'];
										}
	$m07 = "07,";
	if($sumatot07 == 0){$sumatot07 = "0.00,";
	//print("* ".$m07." ".$sumatot07."<br/>");
	}else{$sumatot07 = $sumatot07.",";
			//print("* ".$m07." ".$sumatot07."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 07 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 08 */

	$fil = "%".$dy."/08%";
	//$sql08 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql08 =  $sqlb;
	$qb08 = mysqli_query($db, $sql08);

	if($qb08){
	$qtot08 = mysqli_query($db, $sql08);
	$rowtot08 = mysqli_num_rows($qtot08);
	$sumatot08 = 0;
		  for($i=0; $i<$rowtot08; $i++){$ver = mysqli_fetch_assoc($qtot08);
						 				$sumatot08 = $sumatot08 + $ver['factpvptot'];
										}
	$m08 = "08,";
	if($sumatot08 == 0){$sumatot08 = "0.00,";
	//print("* ".$m08." ".$sumatot08."<br/>");
	}else{$sumatot08 = $sumatot08.",";
			//print("* ".$m08." ".$sumatot08."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 08 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 09 */

	$fil = "%".$dy."/09%";
	//$sql09 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql09 =  $sqlb;
	$qb09 = mysqli_query($db, $sql09);

	if($qb09){
	$qtot09 = mysqli_query($db, $sql09);
	$rowtot09 = mysqli_num_rows($qtot09);
	$sumatot09 = 0;
		  for($i=0; $i<$rowtot09; $i++){$ver = mysqli_fetch_assoc($qtot09);
						 				$sumatot09 = $sumatot09 + $ver['factpvptot'];
										}
	$m09 = "09,";
	if($sumatot09 == 0){$sumatot09 = "0.00,";
	//print("* ".$m09." ".$sumatot09."<br/>");
	}else{$sumatot09 = $sumatot09.",";
			//print("* ".$m09." ".$sumatot09."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 09 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 10 */

	$fil = "%".$dy."/10%";
	//$sql10 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql10 =  $sqlb;
	$qb10 = mysqli_query($db, $sql10);

	if($qb10){
	$qtot10 = mysqli_query($db, $sql10);
	$rowtot10 = mysqli_num_rows($qtot10);
	$sumatot10 = 0;
		  for($i=0; $i<$rowtot10; $i++){$ver = mysqli_fetch_assoc($qtot10);
						 				$sumatot10 = $sumatot10 + $ver['factpvptot'];
										}
	$m10 = "10,";
	if($sumatot10 == 0){$sumatot10 = "0.00,";
	//print("* ".$m10." ".$sumatot10."<br/>");
	}else{$sumatot10 = $sumatot10.",";
			//print("* ".$m10." ".$sumatot10."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 10 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 11 */

	$fil = "%".$dy."/11%";
	//$sql11 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql11 =  $sqlb;
	$qb11 = mysqli_query($db, $sql11);

	if($qb11){
	$qtot11 = mysqli_query($db, $sql11);
	$rowtot11 = mysqli_num_rows($qtot11);
	$sumatot11 = 0;
		  for($i=0; $i<$rowtot11; $i++){$ver = mysqli_fetch_assoc($qtot11);
						 				$sumatot11 = $sumatot11 + $ver['factpvptot'];
										}
	$m11 = "11,";
	if($sumatot11 == 0){$sumatot11 = "0.00,";
	//print("* ".$m11." ".$sumatot11."<br/>");
	}else{$sumatot11 = $sumatot11.",";
			//print("* ".$m11." ".$sumatot11."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 11 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 12 */

	$fil = "%".$dy."/12%";
	//$sql12 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	$sql12 =  $sqlb;
	$qb12 = mysqli_query($db, $sql12);

	if($qb12){
	$qtot12 = mysqli_query($db, $sql12);
	$rowtot12 = mysqli_num_rows($qtot12);
	$sumatot12 = 0;
		  for($i=0; $i<$rowtot12; $i++){$ver = mysqli_fetch_assoc($qtot12);
						 				$sumatot12 = $sumatot12 + $ver['factpvptot'];
										}
	$m12 = "12,";
	if($sumatot12 == 0){$sumatot12 = "0.00";
	//print("* ".$m12." ".$sumatot12."<br/>");
	}else{$sumatot12 = $sumatot12;
			//print("* ".$m12." ".$sumatot12."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 12 */
/////////////////////////


	global $rutaDir;
	$rutaDir = "../cb26_Docs/grafics/";

	$fh = fopen($rutaDir.'GDTVT2.php','w+');

	$text = $sumatot01.$sumatot02.$sumatot03.$sumatot04.$sumatot05.$sumatot06.$sumatot07.$sumatot08.$sumatot09.$sumatot10.$sumatot11.$sumatot12;

	fwrite($fh, $text);
	fclose($fh);

?>