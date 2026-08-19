<?php

		//require 'FactDate.php';
		//require 'FormatNumber.php';

		if(file_exists($rutaOld.$_SESSION['myimg1'])){
					copy($rutaOld.$_SESSION['myimg1'], $rutaNew.$_SESSION['myimg1']);
					//unlink($rutaOld.$_SESSION['myimg1']);
					/*	
					print(" <br/>* CHANGE YEAR FACT: ".$_SESSION['yold']." X ".$dyt1."
									<br/>- Ok Copy & Unlink Img Name 1.");
					*/
		}else{
			print("<br/>- No Ok Copy & Unlink Img Name 1 ".$rutaOld.$_SESSION['myimg1']. " TO ".$rutaNew.$_SESSION['myimg1']);}

		if(file_exists($rutaOld.$_SESSION['myimg2']) ){
					copy($rutaOld.$_SESSION['myimg2'], $rutaNew.$_SESSION['myimg2']);
					//unlink($rutaOld.$_SESSION['myimg2']);
					/* print("<br/>- Ok Copy & Unlink Img Name 2."); */
		}else{
			print("<br/>- No Ok Copy & Unlink Img Name 2 ".$rutaOld.$_SESSION['myimg2']. " TO ".$rutaNew.$_SESSION['myimg2']);}
										
		if(file_exists($rutaOld.$_SESSION['myimg3']) ){
					copy($rutaOld.$_SESSION['myimg3'], $rutaNew.$_SESSION['myimg3']);
					//unlink($rutaOld.$_SESSION['myimg3']);
					/* print("<br/>- Ok Copy & Unlink Img Name 3."); */
		}else{
			print("<br/>- No Ok Copy & Unlink Img Name 3 ".$rutaOld.$_SESSION['myimg3']. " TO ".$rutaNew.$_SESSION['myimg3']);}
										
		if(file_exists($rutaOld.$_SESSION['myimg4']) ){
					copy($rutaOld.$_SESSION['myimg4'], $rutaNew.$_SESSION['myimg4']);
					//unlink($rutaOld.$_SESSION['myimg4']);
					/* print("<br/>- Ok Copy & Unlink Img Name 4."); */
		}else{print("<br/>- No Ok Copy & Unlink Img Name 4 ".$rutaOld.$_SESSION['myimg4']. " TO ".$rutaNew.$_SESSION['myimg4']);}
						
		$idx = $_SESSION['idx'];

		//global $vnamei; 		$vnamei = "`".$_SESSION['clave']."ingresos_pendientes`";
		$_SESSION['vname'] = $vnamei;
		
		global $sent;
		$sent = "INSERT INTO `$db_name`.$vnamei (`factnum`, `factnumini`, `factdate`, `factdateini`, `refcliente`, `factnom`, `factnif`, `factiva`, `factivae`, `factpvp`, `factret`, `factrete`, `factpvptot`,`coment`, `myimg1`, `myimg2`, `myimg3`, `myimg4`, `factcrea`) VALUES ('$_POST[factnum]', '$_POST[factnumini]', '$factdate', '$_POST[factdateini]', '$_POST[clienteingresos]', '$_POST[factnom]', '$_POST[factnif]', '$_POST[factiva]', '$factivae', '$factpvp', '$_POST[factret]', '$factrete', '$factpvptot', '$_POST[coment]', '$_SESSION[myimg1]', '$_SESSION[myimg2]', '$_SESSION[myimg3]', '$_SESSION[myimg4]', '$_POST[factcrea]')";
		
		if(mysqli_query($db, $sent)){

			//global $title;			$title = 'SE HA INSERTADO LA FACTURA EN ';
			global $Borrar2;		$Borrar2= "style='display:none; visibility: hidden;'";
			global $Modif2;			$Modif2= "style='display:none; visibility: hidden;'";
			global $ModImg2;		$ModImg2= "style='display:none; visibility: hidden;'";
			global $PendienteG;		$PendienteG= "style='display:none; visibility: hidden;'";
			global $Recupera3;		$Recupera3 = "style='display:none; visibility: hidden;'";
			global $Ver2;			$Ver2= "style='display:none; visibility: hidden;'";
			global $ConteBotones;	$ConteBotones = "style='display:block;'";
			require 'TableFormResult.php';	
			
			if(file_exists($rutaOld.$_SESSION['myimg1']) ){ unlink($rutaOld.$_SESSION['myimg1']); }else{ }
			if(file_exists($rutaOld.$_SESSION['myimg2']) ){ unlink($rutaOld.$_SESSION['myimg2']); }else{ }
			if(file_exists($rutaOld.$_SESSION['myimg3']) ){ unlink($rutaOld.$_SESSION['myimg3']); }else{ }
			if(file_exists($rutaOld.$_SESSION['myimg4']) ){ unlink($rutaOld.$_SESSION['myimg4']); }else{ }

		}else{
			print("* ERROR L.93: ".mysqli_error($db));
			global $texerror; 	$texerror = "\n\t ".mysqli_error($db);
				}

		$idx = $_SESSION['idx'];
		// global $vnamed; 		$vnamed = "`".$_SESSION['clave']."ingresos_".$dyt1."`";
		$sqla = "DELETE FROM `$db_name`.$vnamed  WHERE $vnamed.`id` = '$idx'  ";

		if(mysqli_query($db, $sqla)){ //	print("<br/>* OK DELETE DATA."); 
		}else{
			print("* ERROR LINEA 98: ".mysqli_error($db));
			global $texerror; 	$texerror = "\n\t ".mysqli_error($db);
				}

		/*
		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
		*/


?>