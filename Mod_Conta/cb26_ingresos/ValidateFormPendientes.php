<?php

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* INICIO VALIDACIÓN DE LOS VALORES NUMERICOS DE LA FACTURA */

	require 'FormatNumber.php'; 

	global $civae;
	$civae = $factpvp * ($fiva / 100);
	$civae = floatval($civae);
    $civae = number_format($civae,2,".","");
	//$civae = number_format($civae,2,".","");
    //echo "*** ".$civae."<br>";
	global $valIvaeEnt;		$valIvaeEnt = substr($civae,0,-3);
	global $valIvaeDec;		$valIvaeDec = substr($civae,-2);
	//echo "*** ".$valIvaeEnt.".".$valIvaeDec."<br>";

	if(trim($factivae) != trim($civae)){
		$errors [] = "IMPUESTOS € <font color='#FF0000'> => </font> ".$civae." €";
	}

	$fret = $_POST['factret'];

	$crete = $factpvp * ($fret / 100);
	$crete = floatval($crete);
	$crete = number_format($crete,2,".","");
	if(trim($factrete) != trim($crete)){
		$errors [] = "RETENCIONES € <font color='#FF0000'> => </font> ".$crete." €";
	}
	global $valReteEnt;		$valReteEnt = substr($crete,0,-3);
	global $valReteDec;		$valReteDec = substr($crete,-2);
	//echo "*** ".$valReteEnt.".".$valReteDec."<br>";

	//$cftot = ($factpvp + $civae) + $factrete;
	$cftot = ($factpvp + $civae) + $crete;
	$cftot = floatval($cftot);
	$cftot = number_format($cftot,2,".","");
	if(trim($factpvptot) != trim($cftot)){
			$errors [] = "TOTAL € <font color='#FF0000'> => </font> ".$cftot." €";
	}
	global $valToteEnt;		$valToteEnt = substr($cftot,0,-3);
	global $valToteDec;		$valToteDec = substr($cftot,-2);
	//echo "*** ".$valToteEnt.".".$valToteDec."<br>";
	

	/* FINAL VALIDACIÓN DE LOS VALORES NUMERICOS DE LA FACTURA */


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
        
     // VALIDO EL CAMPO dy & dm & dd 
		 
	if(trim($_POST['dy']) == ''){
		$errors [] = "YEAR <font color='#FF0000'>Campo obligatorio.</font>";
		}
	
	if(trim($_POST['dm']) == ''){
		$errors [] = "MONTH <font color='#FF0000'>Campo obligatorio.</font>";
		}
	
	if(trim($_POST['dd']) == ''){
		$errors [] = "DAY <font color='#FF0000'>Campo obligatorio.</font>";
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
    // VALIDO NUMERO DE FACTURA
	if(strlen(trim($_POST['factnum'])) == 0){
		$errors [] = "FACTURA NUMERO <font color='#FF0000'>Campo obligatorio.</font>";
		}
	
	elseif (strlen(trim($_POST['factnum'])) < 5){
		$errors [] = "FACTURA NUMERO <font color='#FF0000'>Más de 4 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\.\*\']+$/',$_POST['factnum'])){
		$errors [] = "FACTURA NUMERO <font color='#FF0000'>Caracteres no válidos.</font>";
		}
		
	elseif (!preg_match('/^[a-zA-Z,0-9_\s]+$/',$_POST['factnum'])){
		$errors [] = "FACTURA NUMERO <font color='#FF0000'>Solo letras o números sin acentos.</font>";
		}

	elseif (!preg_match('/^[A-Z,0-9_\s]+$/',$_POST['factnum'])){
$errors [] = "FACTURA NUMERO <font color='#FF0000'>Solo mayusculas, números sin acentos 0 _.</font>";
		}

    /*
	if(strlen(trim($_POST['factdate'])) == 0){
		$errors [] = "FECHA <font color='#FF0000'>Campo obligatorio.</font>";
		}
	
	elseif (strlen(trim($_POST['factdate'])) < 5){
		$errors [] = "FECHA <font color='#FF0000'>Más de 4 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\.\*\']+$/',$_POST['factdate'])){
		$errors [] = "FECHA <font color='#FF0000'>Caracteres no válidos.</font>";
		}
	elseif (!preg_match('/^[a-zA-Z,0-9\s]+$/',$_POST['factdate'])){
		$errors [] = "FECHA <font color='#FF0000'>Solo letras o números sin acentos.</font>";
		}
    */

	 // VALIDO EL CAMPO factnom RAZON SOCIAL
	
	if(strlen(trim($_POST['factnom'])) == 0){
		$errors [] = "RAZON SOCIAL <font color='#FF0000'>Campo obligatorio.</font>";
		}
	
	elseif (strlen(trim($_POST['factnom'])) < 4){
		$errors [] = "RAZON SOCIAL <font color='#FF0000'>Más de 3 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\.\*\']+$/',$_POST['factnom'])){
		$errors [] = "RAZON SOCIAL <font color='#FF0000'>Caracteres no válidos.</font>";
		}
		
	elseif (!preg_match('/^[a-zA-Z,0-9_\s]+$/',$_POST['factnom'])){
		$errors [] = "RAZON SOCIAL <font color='#FF0000'>Solo letras, números sin acentos o _.</font>";
		}

	 // VALIDO EL CAMPO factnif NIF DEL CLIENTE
	
	if(strlen(trim($_POST['factnif'])) == 0){
		$errors [] = "NIF/CIF <font color='#FF0000'>Campo obligatorio.</font>";
		}
	
	elseif (strlen(trim($_POST['factnif'])) < 5){
		$errors [] = "NIF/CIF <font color='#FF0000'>Más de 4 carácteres.</font>";
		}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\.\*\']+$/',$_POST['factnif'])){
		$errors [] = "NIF/CIF <font color='#FF0000'>Caracteres no válidos.</font>";
		}
		
	elseif (!preg_match('/^[A-Z,a-z,0-9\s]+$/',$_POST['factnif'])){
		$errors [] = "NIF/CIF <font color='#FF0000'>Solo mayusculas o números sin acentos.</font>";
		}

	// VALIDO EL campo factiva
	
	if($_POST['factiva'] == ''){
		$errors [] = "IMPUESTOS: <font color='#FF0000'>SELECCIONE EL TIPO DE IVA</font>";
	}
					
	// VALIDOEL CAMPO factivae

        if(strlen(trim($_POST['factivae1'])) == 0){
                $errors [] = "IMPUESTOS € <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
                }
            
        elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['factivae1'])){
                $errors [] = "IMPUESTOS € <font color='#FF0000'>CARACTERES NO VALIDOS.</font>";
                }
			
		elseif (!preg_match('/^[0-9]+$/',$_POST['factivae1'])){
			$errors [] = "IMPUESTOS € <font color='#FF0000'>SOLO NUMEROS</font>";
			}

		if(strlen(trim($_POST['factivae2'])) == 0){
			$errors [] = "IMPUESTOS € <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
			}
		
        elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['factivae2'])){
                $errors [] = "IMPUESTOS € <font color='#FF0000'>CARACTERES NO VALIDOS.</font>";
                }
			
		elseif (!preg_match('/^[0-9]+$/',$_POST['factivae2'])){
			$errors [] = "IMPUESTOS € <font color='#FF0000'>SOLO NUMEROS</font>";
			}

	// VALIDO CAMPO factret
	
	if($_POST['factret'] == ''){
		$errors [] = "RETENCIONES: <font color='#FF0000'>SELECCIONE EL TIPO DE IVA</font>";
		}
					
	// VALIDO EL CAMPO factrete
	
		if(strlen(trim($_POST['factrete1'])) == 0){
			$errors [] = "RETENCIONES € <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
			}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['factrete1'])){
			$errors [] = "RETENCIONES € <font color='#FF0000'>CARACTERES NO VALIDOS.</font>";
			}
			
		elseif (!preg_match('/^[0-9]+$/',$_POST['factrete1'])){
			$errors [] = "RETENCIONES € <font color='#FF0000'>SOLO NUMEROS</font>";
			}

		if(strlen(trim($_POST['factrete2'])) == 0){
			$errors [] = "RETENCIONES € <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
			}
		
        elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['factrete2'])){
                $errors [] = "RETENCIONES € <font color='#FF0000'>CARACTERES NO VALIDOS.</font>";
                }
			
		elseif (!preg_match('/^[0-9]+$/',$_POST['factrete2'])){
			$errors [] = "IMPUESTOS € <font color='#FF0000'>SOLO NUMEROS</font>";
			}

	// VALIDO EL CAMPO factpvp
	
		if(strlen(trim($_POST['factpvp1'])) == 0){
			$errors [] = "SUBTOTAL € <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
			}
		
		elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['factpvp1'])){
			$errors [] = "SUBTOTAL € <font color='#FF0000'>CARACTERES NO VALIDOS.</font>";
			}
			
		elseif (!preg_match('/^[0-9]+$/',$_POST['factpvp1'])){
			$errors [] = "SUBTOTAL € <font color='#FF0000'>SOLO NUMEROS</font>";
			}

		if(strlen(trim($_POST['factpvp2'])) == 0){
			$errors [] = "SUBTOTAL € <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
			}
		
		elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['factpvp2'])){
			$errors [] = "SUBTOTAL € <font color='#FF0000'>CARACTERES NO VALIDOS.</font>";
			}
			
		elseif (!preg_match('/^[0-9]+$/',$_POST['factpvp2'])){
			$errors [] = "SUBTOTAL € <font color='#FF0000'>SOLO NUMEROS</font>";
			}

	// VALIDO EL CAMPO factpvptot
	
		if(strlen(trim($_POST['factpvptot1'])) == 0){
			$errors [] = "TOTAL € <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
			}
		
        elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['factpvptot1'])){
                $errors [] = "TOTAL € <font color='#FF0000'>CARACTERES NO VALIDOS.</font>";
                }
			
		elseif (!preg_match('/^[0-9]+$/',$_POST['factpvptot1'])){
			$errors [] = "TOTAL € <font color='#FF0000'>SOLO NUMEROS</font>";
			}

		if(strlen(trim($_POST['factpvptot2'])) == 0){
			$errors [] = "TOTAL € <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
			}
		
        elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['factpvptot2'])){
                $errors [] = "TOTAL € <font color='#FF0000'>CARACTERES NO VALIDOS.</font>";
                }
			
		elseif (!preg_match('/^[0-9]+$/',$_POST['factpvptot2'])){
			$errors [] = "TOTAL € <font color='#FF0000'>SOLO NUMEROS</font>";
			}

	 // VALIDAMOS EL CAMPO coment
		
	if(strlen(trim($_POST['coment'])) == 0){
		$errors [] = "DESCRIPCIÓN <font color='#FF0000'>Campo obligatorio.</font>";
		}
	
	elseif (strlen(trim($_POST['coment'])) < 10){
		$errors [] = "DESCRIPCIÓN <font color='#FF0000'>Más de 10 carácteres.</font>";
		}
		
	elseif (strlen(trim($_POST['coment'])) > 19){

	if (!preg_match('/^[a-z A-Z 0-9 \s ,.;:\'-() áéíóúñ € \/]+$/',$_POST['coment'])){
		$errors [] = "DESCRIPCIÓN  <font color='#FF0000'>A escrito caracteres no permitidos. { } [ ] ¿ ? < > ¡ ! @ # ...</font>";
		}
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	global $keyModifDat;

	if((isset($_POST['factnum']))&&(strlen(trim($_POST['factnum'])) != 0)){
	
        global $db; 	global $db_name;

		global $dyt1;		
		if((isset($_POST['dy']))&&(strlen(trim($_POST['dy'])) != 0)){
        	$dyt1 = $_POST['dy'];
		}else{ $dyt1 = date('Y'); }
                                                                    
		/* INICIO VERIFICO EL NUMERO DE LA FACTURA EN TODAS LAS TABLAS ACTIVAS MENOS PAPELERA STATUS */
			global $tableName; 			$tableName = "`".$_SESSION['clave']."status`";
			$a = "SELECT MIN(year) FROM `$db_name`.$tableName ";
			$ra = mysqli_query($db, $a);
			$ym = mysqli_fetch_row($ra);
			global $yearMin;	$yearMin = $ym[0];		//echo $yearMin;
			global $yearHoy; 	$yearHoy = date('Y'); 	//echo $yearHoy;
		
			global $texerror; 	$texerror = '';

			while($yearMin<=$yearHoy){

				global $vnamegw; 		$vnamegw = "`".$_SESSION['clave']."ingresos_".$yearMin."`";

				if($yearMin != $dyt1){

				$sqlgw =  "SELECT * FROM `$db_name`.$vnamegw WHERE `factnum` = '$_POST[factnum]'";
				$qgw = mysqli_query($db, $sqlgw);
				$countgw = mysqli_num_rows($qgw);	
				//	$rowsg = mysqli_fetch_assoc($qg);
				if(mysqli_query($db, $sqlgw)){ //print("* OK");
				}else{  print("</br>* ERROR L.295</br> ".mysqli_error($db)."</br>");
						$texerror .= "\n\t* ERROR L.295 ".mysqli_error($db);
							}

				if($countgw > 0){ $errors [] = "<font color='#FF0000'>YA EXISTE LA FACTURA EN ".$vnamegw." </font>"; }

				}else{ }

				$yearMin++;

			} // FIN WHILE
						
		/* FIN VERIFICO EL NUMERO DE LA FACTURA EN TODAS LAS TABLAS ACTIVAS MENOS PAPELERA STATUS */

        global $vnameg; 	$vnameg = "`".$_SESSION['clave']."ingresos_".$dyt1."`";
        global $vnamegp; 	$vnamegp = "`".$_SESSION['clave']."ingresos_pendientes`";
 
		if((isset($_POST['id']))&&(strlen(trim($_POST['id'])) != 0)){
			$sqlg =  "SELECT * FROM `$db_name`.$vnameg WHERE `factnum` = '$_POST[factnum]'";
			$sqlgp =  "SELECT * FROM `$db_name`.$vnamegp WHERE `id` <> '$_POST[id]' AND `factnum` = '$_POST[factnum]'";
			//echo "id esta set<br>";
		}else{
			$sqlg =  "SELECT * FROM `$db_name`.$vnameg WHERE `factnum` = '$_POST[factnum]'";
			$sqlgp =  "SELECT * FROM `$db_name`.$vnamegp WHERE `factnum` = '$_POST[factnum]'";
			//echo "id NO esta set<br>";
		}

        $qg = mysqli_query($db, $sqlg);				$qgp = mysqli_query($db, $sqlgp);
        $countg = mysqli_num_rows($qg);				$countgp = mysqli_num_rows($qgp);
    //	$rowsg = mysqli_fetch_assoc($qg);			$rowsgp = mysqli_fetch_assoc($qgp);
        
        if($countg > 0){
			$errors [] = "<font color='#FF0000'>YA EXISTE LA FACTURA EN ".$vnameg." </font>";
	    }
        if($countgp > 0){
			$errors [] = "<font color='#FF0000'>--YA EXISTE LA FACTURA EN ".$vnamegp." </font>";
	    } 

	}else{ } // FIN SI isset($_POST['factnum']

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


?>