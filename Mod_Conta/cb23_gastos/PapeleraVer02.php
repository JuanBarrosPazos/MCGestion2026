<?php
	//session_start();

	//require '../../Mod_Admin_Plus/Inclu/error_hidden.php';
	//require '../Inclu/Conta_Head.php';
	//require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	//equire '../../Mod_Admin_Plus/Conections/conection.php';
	//require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/*
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 

		if(isset($_POST['ocultoDetalle'])){ process_form_Detalle();
											info_Detalle();
									} 
	} else { require '../Inclu/table_permisos.php'; }
	*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form_Detalle(){
	
		global $rutPend;	$rutPend = '';
		global $pend;	$pend = "";
		require 'Botonera.php';

		global $db; 		global $db_name;
		global $vname; 		$vname = $vname = "`".$_SESSION['clave']."gastosfeed`";
							// $vname = $_POST['vname'];
		//print("** ".$_POST['vname']." / ".$_POST['dyt1']);
			
		$sqlc =  "SELECT * FROM `$db_name`.$vname WHERE `id` = '$_POST[id]'";
		//echo "* ".$sqlc."<br>";

		$qc = mysqli_query($db, $sqlc);
		$rowsc = mysqli_fetch_assoc($qc);
		$countc = mysqli_num_rows($qc);

		$ext_permitidas = array('pdf','PDF');
				
		global $myimg1;		global $myimg2;		global $myimg3;		global $myimg4;

			$extension1 = substr($rowsc['myimg1'],-3);
			// print($extension1);
			// $extension1 = end(explode('.', $_FILES['myimg1']['name']) );
			$ext_correcta1 = in_array($extension1, $ext_permitidas);
			if(!$ext_correcta1){ $myimg1 = $rowsc['myimg1'];}
			else{$myimg1 = 'pdf.png';}

			$extension2 = substr($rowsc['myimg2'],-3);
			// print($extension2);
			// $extension2 = end(explode('.', $_FILES['myimg2']['name']) );
			$ext_correcta2 = in_array($extension2, $ext_permitidas);
			if(!$ext_correcta2){ $myimg2 = $rowsc['myimg2'];}
			else{$myimg2 = 'pdf.png';}

			$extension3 = substr($rowsc['myimg3'],-3);
			// print($extension3);
			// $extension3 = end(explode('.', $_FILES['myimg3']['name']) );
			$ext_correcta3 = in_array($extension3, $ext_permitidas);
			if(!$ext_correcta3){ $myimg3 = $rowsc['myimg3'];}
			else{$myimg3 = 'pdf.png';}

			$extension4 = substr($rowsc['myimg4'],-3);
			// print($extension4);
			// $extension4 = end(explode('.', $_FILES['myimg4']['name']) );
			$ext_correcta4 = in_array($extension4, $ext_permitidas);
			if(!$ext_correcta4){ $myimg4 = $rowsc['myimg4'];}
			else{$myimg4 = 'pdf.png';}

			global $rutaDir;		$rutaDir = $rowsc['ruta'];
			//$rutaDir = substr($_POST['vname'],-5,-1);

			global $papelera;		$papelera = 1;

			global $rutaDirTr;
			$rutaDirTr ="<tr>
							<td style='text-align: right !important;' >RUTA DIR</td>
							<td>".$rowsc['ruta']."</td>			
						</tr>";

			require 'TableVer02.php';
			/*
			global $redir;
			$redir = "<script type='text/javascript'>
							function redir(){
							window.location.href='VerPapelera.php';
						}
						setTimeout('redir()',12000);
						</script>";
			print ($redir);
			*/
	
	} // FIN function process_form_Detalle()
			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function info_Detalle(){

		global $db;

		$ActionTime = date('H:i:s');

		if ($_SESSION['usuarios'] != $_SESSION['ref']){$a = "DEL USUARIO ".$_SESSION['usuarios'].". ";}
		else{$a = " DEL USUARIO ".$_SESSION['ref'].". ";}

		global $text;
		$text = "\n- GASTO DETALLES ".$a.$ActionTime.".\n\tRAZON SOCIAL: ".strtoupper($_POST['factnom']).".\n\tNIF: ".$_POST['factnif']."\n\tFACTURA IN Nº: ".$_POST['factnum'].".";

		require 'WriteLog.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	//require '../Inclu/Conta_Footer.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>