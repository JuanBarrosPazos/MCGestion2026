<?php

		global $sesionref; 		$sesionref = "`".$_SESSION['clave']."clientes`";
		
		if(isset($_POST['clienteingresos'])){
			$sqlx =  "SELECT * FROM $sesionref WHERE `ref` = '$_POST[clientes]'";
			$qx = mysqli_query($db, $sqlx);
			$rowcliente = mysqli_fetch_assoc($qx);
			$_rsocial = $rowcliente['rsocial'];
			$_ref = $rowcliente['ref'];
			$_dni = $rowcliente['dni'];
			$_ldni = $rowcliente['ldni'];
			global $_dnil; 		$_dnil = $_dni.$_ldni;
		}
		
		$_SESSION['idx'] = $_POST['id'];

		global $defaults;

		if(isset($_POST['oculto2'])){

			require 'FunctShowFormOculto2Var.php';
		
			$sx =  "SELECT * FROM $sesionref WHERE `dni` LIKE '$fil1' LIMIT 1 ";
			$qx = mysqli_query($db, $sx);
			$rowpv = mysqli_fetch_assoc($qx);
			$_rsocial = @$rowpv['rsocial'];
			$_ref = @$rowpv['ref'];
			$_dni = @$rowpv['dni'];
			$_ldni = @$rowpv['ldni'];
			global $_dnil; 		$_dnil = $_dni.$_ldni;
			

			$sqlImg = "SELECT * FROM $_POST[vname] WHERE `id` = '$_POST[id]' LIMIT 1 ";
			//echo "\$sqlImg = ".$sqlImg."<br>";
			$qImg = mysqli_query($db, $sqlImg);
			$rowImg = mysqli_fetch_assoc($qImg);

			global $DelRuta;		$DelRuta = @$_POST['delruta'];

			global $VarArray;	$VarArray = 1;
			require 'ArrayTotal.php';
			
		}elseif(isset($_POST['oculto'])){
					$defaults = $_POST;
		}elseif(isset($_POST['oculto1'])){

			global $VarArray;	$VarArray = 3;
			require 'ArrayTotal.php';

		}elseif((isset($_POST['ocultoRecup']))||(isset($_POST['ocultoModif3']))){

				//echo "SOY OCULTO RECUP...<br>";
				$defaults = $_POST;

				global $valIvaeEnt;						global $valIvaeDec;
				$_POST['factivae1'] = $valIvaeEnt;		$_POST['factivae2'] = $valIvaeDec;
				$defaults['factivae1'] = $valIvaeEnt;	$defaults['factivae2'] = $valIvaeDec;

				global $valReteEnt; 					global $valReteDec;
				$_POST['factrete1'] = $valReteEnt;		$_POST['factrete2'] = $valReteDec;
				$defaults['factrete1'] = $valReteEnt;	$defaults['factrete2'] = $valReteDec;

				global $valToteEnt;						global $valToteDec;	
				$_POST['factpvptot1'] = $valToteEnt;	$_POST['factpvptot2'] = $valToteDec;
				$defaults['factpvptot1'] = $valToteEnt;	$defaults['factpvptot2'] = $valToteDec;
				//echo "\$_POST['delruta'] = ".$_POST['delruta']."<br>";

				
			}

		require 'TableIfErrors.php';

		require 'ArrayMesDia.php';

		////////////////////
		
		global $db, $db_name, $dyt1;
		global $rutaOld;	global $papeleraRecup;		global $ingresoModif3;
		if($papeleraRecup == 1){
			$idx = $_SESSION['idx'];
			$vnamed = "`".$_SESSION['clave']."ingresos_".$dyt1."`";
			$sqlrt = "SELECT * FROM `$db_name`.$vnamed  WHERE $vnamed.`id` = '$idx' LIMIT 1 ";
			$qrt = mysqli_query($db,$sqlrt);
			$rowrt = mysqli_fetch_assoc($qrt);
		}elseif($ingresoModif3 == 1){
			$rutaOld = "../cb26_Docs/docingresos_pendientes/";
			//echo "\$RutaOld = ".$rutaOld."<br>";
		}else{ }


		global $rutaDir;
		if((strlen(trim($rutaOld)))!= 0){
			$rutaDir = $rutaOld;
		}elseif((strlen(trim(@$defaults['delruta']))) != 0){
			$rutaDir = @$defaults['delruta'];
		}elseif((strlen(trim(@$_POST['delruta']))) != 0){
			$rutaDir = @$_POST['delruta'];
		}else{  }

		if($_POST['clienteingresos'] != ''){

			global $checked;		global $checkedb;

			global $Checkbox;
			if(@$defaults['xl'] == 'yes'){ $checked = "checked='checked'";}else{ $checked = ""; }
			global $Checkboxb;
			if(@$defaults['xlb'] == 'yes'){ $checkedb = "checked='checked'";}else{ $checkedb = ""; }
			
			$Checkbox = "<tr>
							<td colspan='2' style='text-align:center;' >
								".$TituloCheck." : &nbsp; 
								<input type='checkbox' name='xl' value='yes' ".$checked."/>
							</td>
						</tr>";

			global $a;	$a = $defaults['dy'];
			global $vnameStatus; 		$vnameStatus = "`".$_SESSION['clave']."status`";
			$sqlSTatus =  "SELECT * FROM $vnameStatus WHERE `year`='$a' LIMIT 1 ";
			//echo "\$sqlSTatus = ".$sqlSTatus."<br>";
			$qStauts = mysqli_query($db, $sqlSTatus);
			$rowStatus = mysqli_fetch_assoc($qStauts);
			global $nY;		$nY = date('Y');
			global $papeleraRecup;		global $ejerStatus;

			if(($papeleraRecup == 1)||($ingresoModif3 == 1)){
				if($rowStatus['stat']=='close'){
					$ejerStatus =  "<tr><td colspan=2 style='text-align:center;' >EL EJERCICIO ".$a." ESTÁ CERRADO<br>";
					if(@$defaults['delruta'] == "../cb26_Docs/docingresos_pendientes/"){
						$_SESSION['stat'] = "closePendiente";
						$ejerStatus .=  "SE RECUPERARÁ EN ".@$defaults['delruta']."</td></tr>";
					}else{
						$_SESSION['stat'] = 'close';
						$defaults['delruta'] = "../cb26_Docs/docingresos_".$nY."/";
						$_SESSION['newDy'] = date('Y');
						$ejerStatus .=  "SE RECUPERARÁ EN ".@$defaults['delruta']."</td></tr>
						<tr>
							<td style='text-align:right;'>FECHA NUEVA</td>
							<td>".$_SESSION['newDy']."-".date('m-d')."</td>
						</tr>";
						$Checkboxb = "<tr>
										<td colspan='2' style='text-align:center;' >
											CONFIRMO LA NUEVA RUTA Y FECHA: &nbsp; 
											<input type='checkbox' name='xlb' value='yes' ".$checkedb."/>
										</td>
									</tr>";
					}
					
				}else{
					$_SESSION['stat'] = 'open';
					$ejerStatus =  "<tr><td colspan=2 style='text-align:center;' >EL EJERCICIO ".$a." ESTÁ ABIERTO</td></tr>"; 
				}

				global $rutaDirTr;
				$rutaDirTr ="<tr>
								<td style='text-align: right !important;' >RUTA DIR</td>
								<td>".$rutaDir."</td>			
							</tr>";

			}else{ $rutaDirTr =""; }

			//global $titulo; 		$titulo = "MARCAR COMO NO PAGADO ESTE INGRESO";
			//global $titInput;		$titInput = "GUARDAR COMO INGRESO PENDIENTE DE PAGO";
			global $Recupera3;		$Recupera3 = "style='display:none; visibility: hidden;'";
			global $PendienteG;		$PendienteG = "style='display:none; visibility: hidden;'";
			
			//if($rowStatus['stat']==''){
			if($rowStatus['stat']=='close'){
				if($rutPend == 'Pendientes'){
					global $Modif2;			$Modif2 = "style='display:none; visibility: hidden;'";
					global $ModImg2;		$ModImg2 = "style='display:none; visibility: hidden;'";
				}else{
					global $Modif2;			$Modif2 = "style='display:inline-block;'";
					global $ModImg2;		$ModImg2 = "style='display:inline-block;'";
				}
				//global $Borrar2;		$Borrar2= "style='display:none; visibility: hidden;'";
				//global $PendienteG;		$PendienteG = "style='display:none; visibility: hidden;'";
				//global $Recupera3;		$Recupera3 = "style='display:none; visibility: hidden;'";
			}else{ }

		global $dyt1; 		$dyt1 = $defaults['dy'];
		$_SESSION['dyt1'] = $defaults['dy'];

			require 'TableBorrar.php';

		}

?>