<?php

/////////////////////////////////////////////////////////////////////////////////////////////////

	if($_POST['dy'] == ''){ $dy = date('Y');	
							 } else {$dy = $_POST['dy'];}
	$dm = "/".$_POST['dm']."/";
	global $fil;
	global $db;												

	global $vname; 		//$vname = "`".$_SESSION['clave']."ingresos_".$dyt1."`";

/////////////////////////
/* PARA SUMAR TOTAL 01 */

	$fil = $dy.$dm."01";
	//$sql01 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql01 = $sqlb;
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

	$fil = $dy.$dm."02";
	//$sql02 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql02 = $sqlb;
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

	$fil = $dy.$dm."03";
	//$sql03 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql03 = $sqlb;
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

	$fil = $dy.$dm."04";
	//$sql04 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql04 = $sqlb;
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

	$fil = $dy.$dm."05";
	//$sql05 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql05 = $sqlb;
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

	$fil = $dy.$dm."06";
	//$sql06 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql06 = $sqlb;
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

	$fil = $dy.$dm."07";
	//$sql07 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql07 = $sqlb;
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

	$fil = $dy.$dm."08";
	//$sql08 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql08 = $sqlb;
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

	$fil = $dy.$dm."09";
	//$sql09 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql09 = $sqlb;
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

	$fil = $dy.$dm."10";
	//$sql10 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql10 = $sqlb;
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

	$fil = $dy.$dm."11";
	//$sql11 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql11 = $sqlb;
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

	$fil = $dy.$dm."12";
	//$sql12 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql12 = $sqlb;
	$qb12 = mysqli_query($db, $sql12);

	if($qb12){
	$qtot12 = mysqli_query($db, $sql12);
	$rowtot12 = mysqli_num_rows($qtot12);
	$sumatot12 = 0;
		  for($i=0; $i<$rowtot12; $i++){$ver = mysqli_fetch_assoc($qtot12);
						 				$sumatot12 = $sumatot12 + $ver['factpvptot'];
										}
	$m12 = "12,";
	if($sumatot12 == 0){$sumatot12 = "0.00,";
	//print("* ".$m12." ".$sumatot12."<br/>");
	}else{$sumatot12 = $sumatot12.",";
			//print("* ".$m12." ".$sumatot12."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 12 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 13 */

	$fil = $dy.$dm."13";
	//$sql13 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql13 = $sqlb;
	$qb13 = mysqli_query($db, $sql13);

	if($qb13){
	$qtot13 = mysqli_query($db, $sql13);
	$rowtot13 = mysqli_num_rows($qtot13);
	$sumatot13 = 0;
		  for($i=0; $i<$rowtot13; $i++){$ver = mysqli_fetch_assoc($qtot13);
						 				$sumatot13 = $sumatot13 + $ver['factpvptot'];
										}
	$m13 = "13,";
	if($sumatot13 == 0){$sumatot13 = "0.00,";
	//print("* ".$m13." ".$sumatot13."<br/>");
	}else{$sumatot13 = $sumatot13.",";
			//print("* ".$m13." ".$sumatot13."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 13 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 14 */

	$fil = $dy.$dm."14";
	//$sql14 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql14 = $sqlb;
	$qb14 = mysqli_query($db, $sql14);

	if($qb14){
	$qtot14 = mysqli_query($db, $sql14);
	$rowtot14 = mysqli_num_rows($qtot14);
	$sumatot14 = 0;
		  for($i=0; $i<$rowtot14; $i++){$ver = mysqli_fetch_assoc($qtot14);
						 				$sumatot14 = $sumatot14 + $ver['factpvptot'];
										}
	$m14 = "14,";
	if($sumatot14 == 0){$sumatot14 = "0.00,";
	//print("* ".$m14." ".$sumatot14."<br/>");
	}else{$sumatot14 = $sumatot14.",";
			//print("* ".$m14." ".$sumatot14."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 14 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 15 */

	$fil = $dy.$dm."15";
	//$sql15 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql15 = $sqlb;
	$qb15 = mysqli_query($db, $sql15);

	if($qb15){
	$qtot15 = mysqli_query($db, $sql15);
	$rowtot15 = mysqli_num_rows($qtot15);
	$sumatot15 = 0;
		  for($i=0; $i<$rowtot15; $i++){$ver = mysqli_fetch_assoc($qtot15);
						 				$sumatot15 = $sumatot15 + $ver['factpvptot'];
										}
	$m15 = "15,";
	if($sumatot15 == 0){$sumatot15 = "0.00,";
	//print("* ".$m15." ".$sumatot15."<br/>");
	}else{$sumatot15 = $sumatot15.",";
			//print("* ".$m15." ".$sumatot15."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 15 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 16 */

	$fil = $dy.$dm."16";
	//$sql16 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql16 = $sqlb;
	$qb16 = mysqli_query($db, $sql16);

	if($qb16){
	$qtot16 = mysqli_query($db, $sql16);
	$rowtot16 = mysqli_num_rows($qtot16);
	$sumatot16 = 0;
		  for($i=0; $i<$rowtot16; $i++){$ver = mysqli_fetch_assoc($qtot16);
						 				$sumatot16 = $sumatot16 + $ver['factpvptot'];
										}
	$m16 = "16,";
	if($sumatot16 == 0){$sumatot16 = "0.00,";
	//print("* ".$m16." ".$sumatot16."<br/>");
	}else{$sumatot16 = $sumatot16.",";
			//print("* ".$m16." ".$sumatot16."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 16 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 17 */

	$fil = $dy.$dm."17";
	//$sql17 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql17 = $sqlb;
	$qb17 = mysqli_query($db, $sql17);

	if($qb17){
	$qtot17 = mysqli_query($db, $sql17);
	$rowtot17 = mysqli_num_rows($qtot17);
	$sumatot17 = 0;
		  for($i=0; $i<$rowtot17; $i++){$ver = mysqli_fetch_assoc($qtot17);
						 				$sumatot17 = $sumatot17 + $ver['factpvptot'];
										}
	$m17 = "17,";
	if($sumatot17 == 0){$sumatot17 = "0.00,";
	//print("* ".$m17." ".$sumatot17."<br/>");
	}else{$sumatot17 = $sumatot17.",";
			//print("* ".$m17." ".$sumatot17."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 17 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 18 */

	$fil = $dy.$dm."18";
	//$sql18 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql18 = $sqlb;
	$qb18 = mysqli_query($db, $sql18);

	if($qb18){
	$qtot18 = mysqli_query($db, $sql18);
	$rowtot18 = mysqli_num_rows($qtot18);
	$sumatot18 = 0;
		  for($i=0; $i<$rowtot18; $i++){$ver = mysqli_fetch_assoc($qtot18);
						 				$sumatot18 = $sumatot18 + $ver['factpvptot'];
										}
	$m18 = "18,";
	if($sumatot18 == 0){$sumatot18 = "0.00,";
	//print("* ".$m18." ".$sumatot18."<br/>");
	}else{$sumatot18 = $sumatot18.",";
			//print("* ".$m18." ".$sumatot18."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 18 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 19 */

	$fil = $dy.$dm."19";
	//$sql19 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql19 = $sqlb;
	$qb19 = mysqli_query($db, $sql19);

	if($qb19){
	$qtot19 = mysqli_query($db, $sql19);
	$rowtot19 = mysqli_num_rows($qtot19);
	$sumatot19 = 0;
		  for($i=0; $i<$rowtot19; $i++){$ver = mysqli_fetch_assoc($qtot19);
						 				$sumatot19 = $sumatot19 + $ver['factpvptot'];
										}
	$m19 = "19,";
	if($sumatot19 == 0){$sumatot19 = "0.00,";
	//print("* ".$m19." ".$sumatot19."<br/>");
	}else{$sumatot19 = $sumatot19.",";
			//print("* ".$m19." ".$sumatot19."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 19 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 20 */

	$fil = $dy.$dm."20";
	//$sql20 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql20 = $sqlb;
	$qb20 = mysqli_query($db, $sql20);

	if($qb20){
	$qtot20 = mysqli_query($db, $sql20);
	$rowtot20 = mysqli_num_rows($qtot20);
	$sumatot20 = 0;
		  for($i=0; $i<$rowtot20; $i++){$ver = mysqli_fetch_assoc($qtot20);
						 				$sumatot20 = $sumatot20 + $ver['factpvptot'];
										}
	$m20 = "20,";
	if($sumatot20 == 0){$sumatot20 = "0.00,";
	//print("* ".$m20." ".$sumatot20."<br/>");
	}else{$sumatot20 = $sumatot20.",";
			//print("* ".$m20." ".$sumatot20."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 20 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 21 */

	$fil = $dy.$dm."21";
	//$sql21 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql21 = $sqlb;
	$qb21 = mysqli_query($db, $sql21);

	if($qb21){
	$qtot21 = mysqli_query($db, $sql21);
	$rowtot21 = mysqli_num_rows($qtot21);
	$sumatot21 = 0;
		  for($i=0; $i<$rowtot21; $i++){$ver = mysqli_fetch_assoc($qtot21);
						 				$sumatot21 = $sumatot21 + $ver['factpvptot'];
										}
	$m21 = "21,";
	if($sumatot21 == 0){$sumatot21 = "0.00,";
	//print("* ".$m21." ".$sumatot21."<br/>");
	}else{$sumatot21 = $sumatot21.",";
			//print("* ".$m21." ".$sumatot21."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 21 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 22 */

	$fil = $dy.$dm."22";
	//$sql22 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql22 = $sqlb;
	$qb22 = mysqli_query($db, $sql22);

	if($qb22){
	$qtot22 = mysqli_query($db, $sql22);
	$rowtot22 = mysqli_num_rows($qtot22);
	$sumatot22 = 0;
		  for($i=0; $i<$rowtot22; $i++){$ver = mysqli_fetch_assoc($qtot22);
						 				$sumatot22 = $sumatot22 + $ver['factpvptot'];
										}
	$m22 = "22,";
	if($sumatot22 == 0){$sumatot22 = "0.00,";
	//print("* ".$m22." ".$sumatot22."<br/>");
	}else{$sumatot22 = $sumatot22.",";
			//print("* ".$m22." ".$sumatot22."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 22 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 23 */

	$fil = $dy.$dm."23";
	//$sql23 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql23 = $sqlb;
	$qb23 = mysqli_query($db, $sql23);

	if($qb23){
	$qtot23 = mysqli_query($db, $sql23);
	$rowtot23 = mysqli_num_rows($qtot23);
	$sumatot23 = 0;
		  for($i=0; $i<$rowtot23; $i++){$ver = mysqli_fetch_assoc($qtot23);
						 				$sumatot23 = $sumatot23 + $ver['factpvptot'];
										}
	$m23 = "23,";
	if($sumatot23 == 0){$sumatot23 = "0.00,";
	//print("* ".$m23." ".$sumatot23."<br/>");
	}else{$sumatot23 = $sumatot23.",";
			//print("* ".$m23." ".$sumatot23."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 23 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 24 */

	$fil = $dy.$dm."24";
	//$sql24 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql24 = $sqlb;
	$qb24 = mysqli_query($db, $sql24);

	if($qb24){
	$qtot24 = mysqli_query($db, $sql24);
	$rowtot24 = mysqli_num_rows($qtot24);
	$sumatot24 = 0;
		  for($i=0; $i<$rowtot24; $i++){$ver = mysqli_fetch_assoc($qtot24);
						 				$sumatot24 = $sumatot24 + $ver['factpvptot'];
										}
	$m24 = "24,";
	if($sumatot24 == 0){$sumatot24 = "0.00,";
	//print("* ".$m24." ".$sumatot24."<br/>");
	}else{$sumatot24 = $sumatot24.",";
			//print("* ".$m24." ".$sumatot24."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 24 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 25 */

	$fil = $dy.$dm."25";
	//$sql25 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql25 = $sqlb;
	$qb25 = mysqli_query($db, $sql25);

	if($qb25){
	$qtot25 = mysqli_query($db, $sql25);
	$rowtot25 = mysqli_num_rows($qtot25);
	$sumatot25 = 0;
		  for($i=0; $i<$rowtot25; $i++){$ver = mysqli_fetch_assoc($qtot25);
						 				$sumatot25 = $sumatot25 + $ver['factpvptot'];
										}
	$m25 = "25,";
	if($sumatot25 == 0){$sumatot25 = "0.00,";
	//print("* ".$m25." ".$sumatot25."<br/>");
	}else{$sumatot25 = $sumatot25.",";
			//print("* ".$m25." ".$sumatot25."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 25 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 26 */

	$fil = $dy.$dm."26";
	//$sql26 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql26 = $sqlb;
	$qb26 = mysqli_query($db, $sql26);

	if($qb26){
	$qtot26 = mysqli_query($db, $sql26);
	$rowtot26 = mysqli_num_rows($qtot26);
	$sumatot26 = 0;
		  for($i=0; $i<$rowtot26; $i++){$ver = mysqli_fetch_assoc($qtot26);
						 				$sumatot26 = $sumatot26 + $ver['factpvptot'];
										}
	$m26 = "26,";
	if($sumatot26 == 0){$sumatot26 = "0.00,";
	//print("* ".$m26." ".$sumatot26."<br/>");
	}else{$sumatot26 = $sumatot26.",";
			//print("* ".$m26." ".$sumatot26."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 26 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 27 */

	$fil = $dy.$dm."27";
	//$sql27 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql27 = $sqlb;
	$qb27 = mysqli_query($db, $sql27);

	if($qb27){
	$qtot27 = mysqli_query($db, $sql27);
	$rowtot27 = mysqli_num_rows($qtot27);
	$sumatot27 = 0;
		  for($i=0; $i<$rowtot27; $i++){$ver = mysqli_fetch_assoc($qtot27);
						 				$sumatot27 = $sumatot27 + $ver['factpvptot'];
										}
	$m27 = "27,";
	if($sumatot27 == 0){$sumatot27 = "0.00,";
	//print("* ".$m27." ".$sumatot27."<br/>");
	}else{$sumatot27 = $sumatot27.",";
			//print("* ".$m27." ".$sumatot27."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 27 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 28 */

	$fil = $dy.$dm."28";
	//$sql28 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql28 = $sqlb;
	$qb28 = mysqli_query($db, $sql28);

	if($qb28){
	$qtot28 = mysqli_query($db, $sql28);
	$rowtot28 = mysqli_num_rows($qtot28);
	$sumatot28 = 0;
		  for($i=0; $i<$rowtot28; $i++){$ver = mysqli_fetch_assoc($qtot28);
						 				$sumatot28 = $sumatot28 + $ver['factpvptot'];
										}
	$m28 = "28,";
	if($sumatot28 == 0){$sumatot28 = "0.00,";
	//print("* ".$m28." ".$sumatot28."<br/>");
	}else{$sumatot28 = $sumatot28.",";
			//print("* ".$m28." ".$sumatot28."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 28 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 29 */

	$fil = $dy.$dm."29";
	//$sql29 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql29 = $sqlb;
	$qb29 = mysqli_query($db, $sql29);

	if($qb29){
	$qtot29 = mysqli_query($db, $sql29);
	$rowtot29 = mysqli_num_rows($qtot29);
	$sumatot29 = 0;
		  for($i=0; $i<$rowtot29; $i++){$ver = mysqli_fetch_assoc($qtot29);
						 				$sumatot29 = $sumatot29 + $ver['factpvptot'];
										}
	$m29 = "29,";
	if($sumatot29 == 0){$sumatot29 = "0.00,";
	//print("* ".$m29." ".$sumatot29."<br/>");
	}else{$sumatot29 = $sumatot29.",";
			//print("* ".$m29." ".$sumatot29."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 29 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 30 */

	$fil = $dy.$dm."30";
	//$sql30 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql30 = $sqlb;
	$qb30 = mysqli_query($db, $sql30);

	if($qb30){
	$qtot30 = mysqli_query($db, $sql30);
	$rowtot30 = mysqli_num_rows($qtot30);
	$sumatot30 = 0;
		  for($i=0; $i<$rowtot30; $i++){$ver = mysqli_fetch_assoc($qtot30);
						 				$sumatot30 = $sumatot30 + $ver['factpvptot'];
										}
	$m30 = "30,";
	if($sumatot30 == 0){$sumatot30 = "0.00,";
	//print("* ".$m30." ".$sumatot30."<br/>");
	}else{$sumatot30 = $sumatot30.",";
			//print("* ".$m30." ".$sumatot30."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 30 */
/////////////////////////

/////////////////////////
/* PARA SUMAR TOTAL 31 */

	$fil = $dy.$dm."31";
	//$sql31 =  "SELECT * FROM $vname WHERE `factdate` = '$fil' ";
	global $sqlb;
	require 'FormConsultaFiltroGt1.php';
	$sql31 = $sqlb;
	$qb31 = mysqli_query($db, $sql31);

	if($qb31){
	$qtot31 = mysqli_query($db, $sql31);
	$rowtot31 = mysqli_num_rows($qtot31);
	$sumatot31 = 0;
		  for($i=0; $i<$rowtot30; $i++){$ver = mysqli_fetch_assoc($qtot31);
						 				$sumatot31 = $sumatot31 + $ver['factpvptot'];
										}
	$m31 = "31,";
	if($sumatot31 == 0){$sumatot31 = "0.00";
	//print("* ".$m31." ".$sumatot31."<br/>");
	}else{$sumatot31 = $sumatot31;
			//print("* ".$m31." ".$sumatot31."<br/>");
					}		
}
/* FIN PARA SUMAR TOTAL 31 */
/////////////////////////

	global $rutaDir;
	$rutaDir = "../cb26_Docs/grafics/";

$fh = fopen($rutaDir.'idTVT.php','w+');

$text = $sumatot01.$sumatot02.$sumatot03.$sumatot04.$sumatot05.$sumatot06.$sumatot07.$sumatot08.$sumatot09.$sumatot10.$sumatot11.$sumatot12.$sumatot13.$sumatot14.$sumatot15.$sumatot16.$sumatot17.$sumatot18.$sumatot19.$sumatot20.$sumatot21.$sumatot22.$sumatot23.$sumatot24.$sumatot25.$sumatot26.$sumatot27.$sumatot28.$sumatot29.$sumatot30.$sumatot31;

fwrite($fh, $text);
fclose($fh);

?>