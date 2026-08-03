<?php

session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if ($_SESSION['Nivel']=='cliente'){
	
		master_index();
			
/* #1* ** */	if(isset($_POST['init_compra'])){
											init_compra();
											show_form();
											log_info();					
/* #2* ** */	}elseif(isset($_POST['oculto'])){
											show_form();
											process_form();
											subtotal();
				}elseif(isset($_POST['selec_pro'])){		
						if($form_errors = validate_form()){
												show_form();
												process_form($form_errors);
												subtotal();
												log_info();						
						}else{	show_form();
								selec_pro();
								log_info();													
								subtotal();	
									}
/* #3* ** */	}elseif(isset($_POST['modif_pro'])){
											show_form();
											modif_pro();	
											log_info();				
				}elseif(isset($_POST['modif_pro2'])){		
						if($form_errors = validate_form()){
												show_form();
												modif_pro($form_errors);
												log_info();				
						}else{	show_form();
								modif_pro2();	
								log_info();
								subtotal();
									}
/* #4* ** */	}elseif(isset($_POST['elim_pro'])){	
												show_form();
												elim_pro();	
												log_info();						
				}elseif(isset($_POST['elim_pro2'])){
												show_form();
												elim_pro2();
												log_info();							
											$RefOperShop = $_SESSION['oper'];
											require "../config/TablesNames.php";
											$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
											$qrc = mysqli_query($db, $rc);
											$count = mysqli_num_rows($qrc);
							if($count > 0){	subtotal();	}
/* #5* ** */	}elseif(isset($_POST['subtotal'])){
												show_form();
											$RefOperShop = $_SESSION['oper'];
											require "../config/TablesNames.php";
											$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
											$qrc = mysqli_query($db, $rc);
											$count = mysqli_num_rows($qrc);
											if($count > 0){	subtotal();	}
												log_info();					
/* #6* ** */	}elseif(isset($_POST['recup_compra'])){	
													show_form();
													recup_compra();
													log_info();					
				}elseif(isset($_POST['recup_compra2'])){ 
													recup_compra2();
													show_form();
													subtotal();
														log_info();								
/* #7* ** */	}elseif(isset($_POST['cancel_compra'])){ 
													show_form();
													cancel_compra();
												 		log_info();							
				}elseif(isset($_POST['cancel_compra2'])){ 
													show_form();
													cancel_compra2();	
														log_info();
													fcancel_1();
														log_info();								
													fcancel_2();
														log_info();							
													fcancel_3();
														log_info();					
													fcancel_4();
														log_info();				
/* #9* ** */	}elseif(isset($_POST['pago'])){	
											show_form();
											pago2();	
				}elseif(isset($_POST['pago2'])){				
							if($form_errors = validate_pago2()){
											show_form();
											pago2($form_errors);
											log_info();				
							}else{	show_form();
									pago3();
									log_info();													
									}
				}elseif(isset($_POST['pago3'])){
									show_form();
									pago3();	
									log_info();													
				}else {	show_form(); }

		}else { require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function validate_pago2(){

	if (strlen($_POST['efectivo']) != 0){
	if ((strlen($_POST['paypal']) != 0) || (strlen($_POST['visa']) != 0) || (strlen($_POST['mastercar']) != 0)){
				$errors [] = " SELECCIONE SOLO UNA FORMA DE PAGO";}
		}

	elseif (strlen($_POST['paypal']) != 0){
	if ((strlen($_POST['efectivo']) != 0) || (strlen($_POST['visa']) != 0) || (strlen($_POST['mastercar']) != 0)){
				$errors [] = " SELECCIONE SOLO UNA FORMA DE PAGO";}
		}

	elseif (strlen($_POST['visa']) != 0){
	if ((strlen($_POST['efectivo']) != 0) || (strlen($_POST['paypal']) != 0) || (strlen($_POST['mastercar']) != 0)){
				$errors [] = " SELECCIONE SOLO UNA FORMA DE PAGO";}
		}

	elseif (strlen($_POST['mastercar']) != 0){
	if ((strlen($_POST['efectivo']) != 0) || (strlen($_POST['paypal']) != 0) || (strlen($_POST['visa']) != 0)){
				$errors [] = " SELECCIONE SOLO UNA FORMA DE PAGO";}
		}
	
	else{$errors [] = " SELECCIONE UNA FORMA DE PAGO";}
				
		return $errors;

		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function pago2($errors=[]){
	
	if($_POST['pago2']){
				$defaults = array ( 'efectivo' => $_POST['efectivo'],
									'paypal' => $_POST['paypal'],
									'visa' => $_POST['visa'],
									'mastercar' => $_POST['mastercar']
												);
		} else {
				$defaults = array ( 'efectivo' => $_POST['efectivo'],
									'paypal' => $_POST['paypal'],
									'visa' => $_POST['visa'],
									'mastercar' => $_POST['mastercar']
												);
		$RefOperShop = $_SESSION['oper'];
		global $LogTextcarro;
		$LogTextcarro = "	* PAGO 01 =>\t
						* SESSION OPER ".$RefOperShop."\t\n"	
					 									;
													}
		
	if ($errors){
		print("<font color='#F1BD2D'>
				Solucione estos errores: </font></br>");
		
		for($a=0; $c=count($errors), $a<$c; $a++){
					print("<font color='#F1BD2D'>* </font>".$errors [$a]."</br>");
					$RefOperShop = $_SESSION['oper'];
					global $LogTextcarro;
					$LogTextcarro = "	* PAGO 01 =>\t
									* SESSION OPER ".$RefOperShop."\t
									* ERRORES ".$errors [$a]."\t\n";
					log_info();
				}
		}

	global $db;		global $db_name;
		
	global $RefOperShop;	$RefOperShop = $_SESSION['oper'];		
	require "../config/TablesNames.php";
	$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);
	
	$rowrc = mysqli_fetch_assoc($qrc);
	global $ProName;		$ProName =strtolower($rowrc['proname']);
	global $ClientRef;		$ClientRef = $rowrc['refclient'];

/////////////////////	
/* PARA SUMAR IVA */

if(!$qrc){print("* Error L199. ".mysqli_error($db).".</br>");
}
else{
	$qivae = mysqli_query($db, $rc);
	$rowivae = mysqli_num_rows($qivae);
	$sumaivae = 0;
		  for($i=0; $i<$rowivae; $i++){ $ver = mysqli_fetch_array($qivae);
										$sumaivae = $sumaivae + $ver['ivae'];
											}
		}
			
/* FIN PARA SUMAR IVA */
/////////////////////////

/////////////////////	
/* PARA SUMAR PVPTOT */
if(!$qrc){print("* Error L209. ".mysqli_error($db).".</br>");
}else{
	$qpvptot = mysqli_query($db, $rc);
	$rowpvptot = mysqli_num_rows($qpvptot);
	$sumapvptot = 0;
		  for($i=0; $i<$rowpvptot; $i++){ $ver = mysqli_fetch_array($qpvptot);
										  $sumapvptot = $sumapvptot + $ver['pvptot'];
											}
		}
			
/* FIN PARA SUMAR PVPTOT */
/////////////////////////
							
	print("	<table align='center'>										
				<tr>
					<td align='center' colspan='11' class='BorderInf'>
										SUS DATOS
					</td>
				</tr>
				<tr>
				<th class='BorderInfDch'>ID</th>
				<th class='BorderInfDch'>Nivel</th>
				<th class='BorderInfDch'>Referencia</th>
				<th class='BorderInfDch'>Nombre</th>
				<th class='BorderInfDch'>Apellidos</th>
				<th class='BorderInfDch'></th>
				<th class='BorderInfDch'>DNI</th>
				<th class='BorderInfDch'>EMAIL</th>
				<th class='BorderInfDch'>DIRECCION</th>
				<th class='BorderInfDch'>TLF 1</th>
				<th class='BorderInf'>TLF 2</th>
			</tr>");				
				
	$RefOperShop = $_SESSION['oper'];
	require "../config/TablesNames.php";
	$rdcl =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qdcl = mysqli_query($db, $rdcl);
	$rowdcl = mysqli_fetch_assoc($qdcl);
	$ClientRef = $rowdcl['refclient'];

	$ruta = '../AdminClientesWeb/img_cliente/';

	print("<tr align='center'>
						<td class='BorderInfDch'>
		<input name='id' type='hidden' value='".$_SESSION['id']."' />".$_SESSION['id']."
						</td>
						<td class='BorderInfDch'>
		<input name='Nivel' type='hidden' value='".$_SESSION['Nivel']."' />".$_SESSION['Nivel']."
						</td>
						<td class='BorderInfDch'>
		<input name='ref' type='hidden' value='".$_SESSION['ref']."' />".$_SESSION['ref']."
						</td>
						<td class='BorderInfDch'>
		<input name='Nombre' type='hidden' value='".$_SESSION['Nombre']."' />".$_SESSION['Nombre']."
						</td>
						<td class='BorderInfDch'>
		<input name='Apellidos' type='hidden' value='".$_SESSION['Apellidos']."' />".$_SESSION['Apellidos']."
						</td>
						<td class='BorderInfDch'>
		<input name='myimg' type='hidden' value='".$_SESSION['GestMyImg']."' />
			<img src='".$ruta.$_SESSION['GestMyImg']."' height='40px' width='30px' />
						</td>
						<td class='BorderInfDch'>
		<input name='dni' type='hidden' value='".$_SESSION['dni']."' />".$_SESSION['dni'].$_SESSION['ldni']."
		<input name='ldni' type='hidden' value='".$_SESSION['ldni']."' />
						</td>
						<td class='BorderInfDch'>
		<input name='Email' type='hidden' value='".$_SESSION['Email']."' />".$_SESSION['Email']."
						</td>
						<td class='BorderInfDch'>
		<input name='Direccion' type='hidden' value='".$_SESSION['Direccion']."' />".$_SESSION['Direccion']."
						</td>
						<td class='BorderInfDch'>
		<input name='Tlf1' type='hidden' value='".$_SESSION['Tlf1']."' />".$_SESSION['Tlf1']."
						</td>
						<td class='BorderInf'>
		<input name='Tlf2' type='hidden' value='".$_SESSION['Tlf2']."' />".$_SESSION['Tlf2']."
						</td>
				</form>
			</tr>	
		</table>");

/////////////////////	

	global $RefOperShop;		$RefOperShop = $_SESSION['oper'];	
	require "../config/TablesNames.php";
	$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);
		
if(!$qrc){print("* Error L311. ".mysqli_error($db).".</br>");
}else{
	$qcp = mysqli_query($db, $rc);
	$rowcp = mysqli_num_rows($qcp);
	for($i=0; $i<$rowcp; $i++){ $campo = mysqli_fetch_array($qcp);
		global $campos;
		$titut ="\n |  SECCION   |    REF PROD    |     PRO NAME     | CARRO";
		$datos =$datos."\n | ".$campo['vseccion']." | ".$campo['producto']." | ".$campo['proname']." | ".$campo['kgcash'];
	}
}
			
	$RefOperShop = $_SESSION['oper'];
	if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';
	}else{$tpro = $_POST['producto'];}
		global $campos; 	global $LogTextcarro;
		$LogTextcarro = "	* PAGO 2 =>\t
						* SESSION OPER: ".$RefOperShop."\t
						* REF CAJA: ".$campo['refcaja']."\t
						* REF CLIENT: ".$campo['refclient']."\t
						* NAME CLIENT: ".$campo['clname']."\t
						* IVA TOT: ".$sumaivae."\t
					  	* PVP TOT: ".$sumapvptot."".$titut.$datos;
						
///////////////////

		global $ClientRef;
		
print("	<form name='pago2'  action='$_SERVER[PHP_SELF]' method='POST'>");

		if($ClientRef != ''){ 
		print("<table align='center'>
					<tr>
						<td align='center' colspan='4' class='BorderInf'>
							<font color='#990000'>FORMA DE PAGO</font>
						</td>
					</tr>
					<tr>
						<td align='center'>
					<input type='checkbox' id='efectivo' name='efectivo' value='efectivo' ");
					//if($defaults['efectivo'] == 'efectivo') {print(" checked=\"checked\"");}
					print("</td>
							<td>EFECTIVO</td>
							<td align='center'>
					<input type='checkbox' id='paypal' name='paypal' value='paypal' ");
					//if($defaults['paypal'] == 'paypal') {print(" checked=\"checked\"");}
					print("</td>
							<td>PAY PAL</td>
						</tr>
						<tr>
							<td align='center'>
					<input type='checkbox' id='visa' name='visa' value='visa' ");
					//if($defaults['visa'] == 'visa') {print(" checked=\"checked\"");}
					print("</td>
							<td> VISA</td>
							<td align='center'>
					<input type='checkbox' id='mastercar' name='mastercar' value='mastercar' ");
					//if($defaults['mastercar'] == 'mastercar') {print(" checked=\"checked\"");}
					print("</td>
							<td>MASTERCAR</td>
						</tr>
							</table>");
				}
		print ("<table align='center'>
					<tr style='font-size:14px'>
						<th colspan=10 class='BorderInf'>
					SUS DATOS. FORMA DE PAGO & SUBTOTAL COMPRA ".$_SESSION['oper']." 
						</th>
					</tr>
					<tr style='font-size:10px'>
						<th class='BorderInfDch'>REF CAJA</th>
						<th class='BorderInfDch'>REF CLIENT</th>
						<th class='BorderInfDch'>OPER SESION</th>
						<th class='BorderInfDch'>FECHA</th>
						<th class='BorderInfDch'>SECCION</th>
						<th class='BorderInfDch'>PRODUCTO</th>
						<th class='BorderInfDch'>UNI</th>
						<th class='BorderInfDch'>IVA€</th>
						<th class='BorderInfDch'>PVP</th>
						<th class='BorderInfDch'>SUBTOT</th>
					</tr>");
									
	while($rowrc = mysqli_fetch_assoc($qrc)){
		
	$ProName =strtolower($rowrc['proname']);
	global $ClientRef;		$ClientRef = $rowrc['refclient'];

	print (	"<tr align='center'>
	
	<input name='id' type='hidden' value='".$rowrc['id']."' />
	<input name='ini' type='hidden' value='".$rowrc['ini']."' />
	<input name='cname' type='hidden' value='".$rowrc['cname']."' />
	<input name='clname' type='hidden' value='".$rowrc['clname']."' />
	<input name='psiva' type='hidden' value='".$rowrc['psiva']."' />
	<input name='iva' type='hidden' value='".$rowrc['iva']."' />
	<input name='nsemana' type='hidden' value='".$rowrc['nsemana']."' />
	<input name='proname' type='hidden' value='".$rowrc['proname']."' />
						<td class='BorderInfDch' align='left'>
	<input name='refcaja' type='hidden' value='".$rowrc['refcaja']."' />".$rowrc['refcaja']."
						</td>
						<td class='BorderInfDch' align='left'>
	<input name='refclient' type='hidden' value='".$rowrc['refclient']."' />".$rowrc['refclient']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='oper' type='hidden' value='".$rowrc['oper']."' />".$rowrc['oper']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='datecash' type='hidden' value='".$rowrc['datecash']."' />".$rowrc['datecash']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='vseccion' type='hidden' value='".$rowrc['vseccion']."' />".$rowrc['vseccion']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='producto' type='hidden' value='".$rowrc['producto']."' />".$ProName."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='kgcash' type='hidden' value='".$rowrc['kgcash']."' />".$rowrc['kgcash']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='ivae' type='hidden' value='".$rowrc['ivae']."' />".$rowrc['ivae']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='pvp' type='hidden' value='".$rowrc['pvp']."' />".$rowrc['pvp']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='pvptot' type='hidden' value='".$rowrc['pvptot']."' />".$rowrc['pvptot']."
						</td>
				</tr>");
	} /*	FIN WHILE	*/
						
	print("<tr>
				<td colspan='10' class='BorderInf'></td>
			</tr>
				<td colspan='2' class='BorderInf'></td>
				<td colspan='2' class='BorderInf' align='right'>TOTAL IVA</td>
				<td colspan='2' class='BorderInfDch' align='left'>".$sumaivae." €</td>
				<td colspan='2' class='BorderInf' align='right'>TOTAL €</td>
				<td class='BorderInfDch' align='right'>".$sumapvptot."</td>
				<td class='BorderInf'>");
if($ClientRef != ''){ print("
					<div align='center' >
						<form name='pago' method='post' action='$_SERVER[PHP_SELF]'>
							<input type='submit' value='PAGAR & SALIR' />
							<input type='hidden' name='pago2' value=1 />
						</form>	
					</div>");
		}
		print("</td>
					</table>");

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function pago3(){
	
	global $db;		global $db_name;

	global $RefOperShop;	$RefOperShop = $_SESSION['oper'];		
	require "../config/TablesNames.php";
	$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);

/////////////////////	
/* PARA SUMAR IVA */

if(!$qrc){print("* Error L476. ".mysqli_error($db).".</br>");
}else{
	$qivae = mysqli_query($db, $rc);
	$rowivae = mysqli_num_rows($qivae);
	$sumaivae = 0;
		for($i=0; $i<$rowivae; $i++){ $ver = mysqli_fetch_array($qivae);
									  $sumaivae = $sumaivae + $ver['ivae'];
											}
		}
			
/* FIN PARA SUMAR IVA */
/////////////////////////

/////////////////////	
/* PARA SUMAR PVPTOT */

if(!$qrc){print("* Error L476. ".mysqli_error($db).".</br>");
}else{
	$qpvptot = mysqli_query($db, $rc);
	$rowpvptot = mysqli_num_rows($qpvptot);
	$sumapvptot = 0;
		for($i=0; $i<$rowpvptot; $i++){ $ver = mysqli_fetch_array($qpvptot);
										$sumapvptot = $sumapvptot + $ver['pvptot'];
											}
		}
			
/* FIN PARA SUMAR PVPTOT */
/////////////////////////

if(!$qrc){print("* Error L476. ".mysqli_error($db).".</br>");
}else{
	$qcp = mysqli_query($db, $rc);
	$rowcp = mysqli_num_rows($qcp);
		for($i=0; $i<$rowcp; $i++){ $campo = mysqli_fetch_array($qcp);
			global $campos;
			$titut ="\n |  SECCION   |    REF PROD    |     PRO NAME     | CARRO";
			$datos =$datos."\n | ".$campo['vseccion']." | ".$campo['producto']." | ".$campo['proname']." | ".$campo['kgcash'];
			}
		}
			
		global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';
		}else{$tpro = $_POST['producto'];}
		global $campos;		global $LogTextcarro;
		$LogTextcarro = "	* PAGO COMPLET =>\t
						* SESSION OPER: ".$RefOperShop."\t
						* REF CAJA: ".$campo['refcaja']."\t
						* REF CLIENT: ".$campo['refclient']."\t
						* NAME CLIENT: ".$campo['clname']."\t
						* IVA TOT: ".$sumaivae."\t
					  	* PVP TOT: ".$sumapvptot."".$titut.$datos;
						
///////////////////
							
global $Pago;
$Pago = strtoupper($_POST['efectivo'])
		.strtoupper($_POST['paypal'])
		.strtoupper($_POST['visa'])
		.strtoupper($_POST['mastercar']);
		
		print("<table align='center'>
				<tr>
					<td align='center' class='BorderInf'>
						<font color='#990000'>FORMA DE PAGO</font>
					</td>
					<td align='center' class='BorderInf'>".$Pago."</td>
				</tr>");
		print ("<table align='center'>
					<tr style='font-size:14px'>
						<th colspan=9 class='BorderInf'>
							SUS DATOS. FORMA DE PAGO & SUBTOTAL COMPRA ".$_SESSION['oper']."
						</th>
						<th class='BorderInf'>
						<div style='float:right'>
					<form action='' method='get'> 
						<input type='button' name='imprimir' value='IMPRIMIR' onClick='window.print();'/>
					</form>
						</div>	
						</th>
					</tr>
					<tr style='font-size:10px'>
						<th class='BorderInfDch'>REF CAJA</th>
						<th class='BorderInfDch'>REF CLIENT</th>
						<th class='BorderInfDch'>OPER SESION</th>
						<th class='BorderInfDch'>FECHA</th>	
						<th class='BorderInfDch'>SECCION</th>										
						<th class='BorderInfDch'>PRODUCTO</th>
						<th class='BorderInfDch'>UNI</th>
						<th class='BorderInfDch'>IVA€</th>
						<th class='BorderInfDch'>PVP</th>
						<th class='BorderInfDch'>SUBTOT</th>
					</tr>");
									
	while($rowrc = mysqli_fetch_assoc($qrc)){
		
		global $db;		global $db_name;
		global $ProName;	$ProName =strtolower($rowrc['proname']);
		global $ClientRef;		$ClientRef = $rowrc['refclient'];
	
		print (	"<tr align='center'>
			<input name='id' type='hidden' value='".$rowrc['id']."' />
			<input name='ini' type='hidden' value='".$rowrc['ini']."' />
			<input name='cname' type='hidden' value='".$rowrc['cname']."' />
			<input name='clname' type='hidden' value='".$rowrc['clname']."' />
			<input name='psiva' type='hidden' value='".$rowrc['psiva']."' />
			<input name='iva' type='hidden' value='".$rowrc['iva']."' />
			<input name='nsemana' type='hidden' value='".$rowrc['nsemana']."' />
			<input name='proname' type='hidden' value='".$rowrc['proname']."' />
				<td class='BorderInfDch' align='left'>
			<input name='refcaja' type='hidden' value='".$rowrc['refcaja']."' />".$rowrc['refcaja']."
						</td>
						<td class='BorderInfDch' align='left'>
			<input name='refclient' type='hidden' value='".$rowrc['refclient']."' />".$rowrc['refclient']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='oper' type='hidden' value='".$rowrc['oper']."' />".$rowrc['oper']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='datecash' type='hidden' value='".$rowrc['datecash']."' />".$rowrc['datecash']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='vseccion' type='hidden' value='".$rowrc['vseccion']."' />".$rowrc['vseccion']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='producto' type='hidden' value='".$rowrc['producto']."' />".$ProName."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='kgcash' type='hidden' value='".$rowrc['kgcash']."' />".$rowrc['kgcash']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='ivae' type='hidden' value='".$rowrc['ivae']."' />".$rowrc['ivae']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='pvp' type='hidden' value='".$rowrc['pvp']."' />".$rowrc['pvp']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='pvptot' type='hidden' value='".$rowrc['pvptot']."' />".$rowrc['pvptot']."
						</td>
				</tr> ");
	} /*	FIN WHILE	*/
						
		print("<tr>
					<td colspan='10' class='BorderInf'></td>
				</tr>
				<tr>
					<td colspan='3' class='BorderInf'></td>
					<td colspan='2' class='BorderInf' align='right'>TOTAL IVA</td>
					<td colspan='2' class='BorderInfDch' align='left'>".$sumaivae." €</td>
					<td colspan='2' class='BorderInf' align='right'>TOTAL €</td>
					<td class='BorderInfDch' align='right'>".$sumapvptot."</td>
				</tr>
				</table>");
									
////////////////////

	print("<table align='center'>										
			<tr>
				<td align='center' colspan='12' class='BorderInf'>SUS DATOS</td>
			</tr>
			<tr>
				<th class='BorderInfDch'>ID</th>
				<th class='BorderInfDch'>Nivel</th>
				<th class='BorderInfDch'>Referencia</th>
				<th class='BorderInfDch'>Nombre</th>
				<th class='BorderInfDch'>Apellidos</th>
				<th class='BorderInfDch'></th>
				<th class='BorderInf'>DNI</th>
				<th class='BorderInfDch'></th>
				<th class='BorderInfDch'>EMAIL</th>
				<th class='BorderInfDch'>DIRECCION</th>
				<th class='BorderInfDch'>TLF 1</th>
				<th class='BorderInf'>TLF 2</th>
			</tr>");				

	global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
	require "../config/TablesNames.php";
	$rdcl =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qdcl = mysqli_query($db, $rdcl);
	$rowdcl = mysqli_fetch_assoc($qdcl);
	$ClientRef = $rowdcl['refclient'];
	// print("* ".$rowdcl['refclient']);

	$ncl =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ";
	$qncl = mysqli_query($db, $ncl);
	$rowncl = mysqli_fetch_assoc($qncl);
	$_SESSION['nclient'] = $rowncl['Nivel'];
	// print(" ".$_SESSION['nclient']);
		if(mysqli_num_rows($qncl) == 0){
			require "../config/TablesNames.php";
			$ncl =  "SELECT * FROM $Admin WHERE `ref` = '$ClientRef' ";
			$qncl = mysqli_query($db, $ncl);
			$rowncl = mysqli_fetch_assoc($qncl);
			$_SESSION['nclient'] = $rowncl['Nivel'];
			//	print(" ".$_SESSION['nclient']);
				}
if($ClientRef != ''){
	global $h;
	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){
		$h = 'height=620px';
	}else{ $h = 'height=250px'; }
	
	if($_SESSION['nclient'] == 'cliente'){
		require "../config/TablesNames.php";
		$dtcl =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ORDER BY `Nombre` ASC ";
		$qdtcl = mysqli_query($db, $dtcl);
		$h = 'height=620px';
	}elseif(($_SESSION['nclient'] == 'admin') || ($_SESSION['nclient'] == 'plus') || ($_SESSION['nclient'] == 'user') || ($_SESSION['nclient'] == 'caja')){
	require "../config/TablesNames.php";
	$dtcl =  "SELECT * FROM $Admin WHERE `ref` = '$ClientRef' ORDER BY `Nombre` ASC ";
	$qdtcl = mysqli_query($db, $dtcl);}

	while($rowdtcl = mysqli_fetch_assoc($qdtcl)){

	if (($rowdtcl['Nivel'] == 'admin') || ($rowdtcl['Nivel'] == 'plus') || ($rowdtcl['Nivel'] == 'user') || ($rowdtcl['Nivel'] == 'caja')){$ruta = '../Admin/img_admin/';}
	if ($rowdtcl['Nivel'] == 'cliente'){$ruta = '../AdminClientesWeb/img_cliente/';}

	print("	<tr align='center'>
				<td class='BorderInfDch'>
		<input name='id' type='hidden' value='".$rowdtcl['id']."' />".$rowdtcl['id']."
						</td>
						<td class='BorderInfDch'>
		<input name='Nivel' type='hidden' value='".$rowdtcl['Nivel']."' />".$rowdtcl['Nivel']."
						</td>
						<td class='BorderInfDch'>
		<input name='ref' type='hidden' value='".$rowdtcl['ref']."' />".$rowdtcl['ref']."
						</td>
						<td class='BorderInfDch'>
		<input name='Nombre' type='hidden' value='".$rowdtcl['Nombre']."' />".$rowdtcl['Nombre']."
						</td>
						<td class='BorderInfDch'>
		<input name='Apellidos' type='hidden' value='".$rowdtcl['Apellidos']."' />".$rowdtcl['Apellidos']."
						</td>
						<td class='BorderInfDch'>
		<input name='myimg' type='hidden' value='".$rowdtcl['myimg']."' />
			<img src='".$ruta."".$rowdtcl['myimg']."' height='40px' width='30px' />
						</td>
						<td class='BorderInf'>
		<input name='dni' type='hidden' value='".$rowdtcl['dni']."' />".$rowdtcl['dni']."
						</td>
						<td class='BorderInfDch'>
		<input name='ldni' type='hidden' value='".$rowdtcl['ldni']."' />".$rowdtcl['ldni']."
						</td>
						<td class='BorderInfDch'>
		<input name='Email' type='hidden' value='".$rowdtcl['Email']."' />".$rowdtcl['Email']."
						</td>
						<td class='BorderInfDch'>
		<input name='Direccion' type='hidden' value='".$rowdtcl['Direccion']."' />".$rowdtcl['Direccion']."
						</td>
						<td class='BorderInfDch'>
		<input name='Tlf1' type='hidden' value='".$rowdtcl['Tlf1']."' />".$rowdtcl['Tlf1']."
						</td>
						<td class='BorderInf'>
		<input name='Tlf2' type='hidden' value='".$rowdtcl['Tlf2']."' />".$rowdtcl['Tlf2']."
						</td>
					</tr>");			
		} /* Fin del while.*/ 
	}

	print("</form></table>");
						
////////////////////////

	global $Pago;
	$Pago = strtoupper($_POST['efectivo'])
			.strtoupper($_POST['paypal'])
			.strtoupper($_POST['visa'])
			.strtoupper($_POST['mastercar']);

	$date = date('y-m-d');
	$ATime = date('H:i:s');
	$datecash = $date."/".$ATime;

	global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
	require "../config/TablesNames.php";
	$vnt =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop'";
	$qvnt = mysqli_query($db, $vnt);
	$rowcvnt = mysqli_num_rows($qvnt);
	
	for($i=0; $i<$rowcvnt; $i++){
	
	$rowvnt = mysqli_fetch_assoc($qvnt);

	require "../config/TablesNames.php";

	$vnt = "INSERT INTO `$db_name`.$modvn (`ini`, `cname`, `refcaja`, `clname`, `refclient`, `oper`, `nsemana`, `datecash`, `vseccion`, `producto`, `proname`, `kgcash`, `psiva`, `iva`, `ivae`, `pvp`, `pvptot`, `pago` ) VALUES ('$rowvnt[ini]', '$rowvnt[cname]', '$rowvnt[refcaja]', '$rowvnt[clname]', '$rowvnt[refclient]',  '$rowvnt[oper]', '$rowvnt[nsemana]', '$datecash', '$rowvnt[vseccion]', '$rowvnt[producto]', '$rowvnt[proname]', '$rowvnt[kgcash]', '$rowvnt[psiva]', '$rowvnt[iva]', '$rowvnt[ivae]', '$rowvnt[pvp]', '$rowvnt[pvptot]', '$Pago' )";

		if(mysqli_query($db, $vnt)){print("*");
		} else {print("* Error L465. ".mysqli_error($db)."</br>"); }
																
	} /* FIN DEL FOR */

////////////////

	require "../config/TablesNames.php";
	
	$cc2 = "DELETE FROM `$db_name`.$CajaShop WHERE `oper` = '$RefOperShop' ";

		if(mysqli_query($db, $cc2)){ print("* COMPRA PAGADA.");
		}else{ print("* Error L776. ".mysqli_error($db)."</br>");}	
	}
										
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){

	global $kgcash;		global $kgin;

	if($_POST['kgcash1'] > $_POST['stock1']){ $errors [] = "UNIT CAJA: SIN SUFICIENTE STOCK";}else{ }
	if($_POST['kgcash1'] == $_POST['stock1']){ $errors [] = "UNIT CAJA: SIN SUFICIENTE STOCK"; }else{ }
	if(strlen(trim($_POST['kgcash1'])) == 0){ $errors [] = "UNIT CAJA: CAMPO OBLIGATORIO";
	}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['kgcash1'])){
			$errors [] = "UNIT CAJA: CARACTERES NO VALIDOS";
	}elseif (!preg_match('/^[0-9]+$/',$_POST['kgcash1'])){
			$errors [] = "UNIT CAJA: >SOLO NUMEROS";
	}elseif($kgcash > $kgin){
			$errors [] = "MAS DE CAJA QUE DE ENTRADA";
	}else{ }
			
	if(strlen(trim($_POST['kgcash2'])) == 0){$errors [] = "DEC CAJA CAMPO OBLIGATORIO";
	}elseif (!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['kgcash2'])){
			$errors [] = "DEC CAJA CARACTERES NO VALIDOS";
	}elseif (!preg_match('/^[0-9]+$/',$_POST['kgcash2'])){
			$errors [] = "DEC CAJA SOLO NUMEROS";
	}else{ }
			
		return $errors;

		} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function init_compra(){
	
	global $db;		global $db_name;

	global $refcaja;	$refcaja = $_SESSION['ref'];
	global $refcj;		$refcj = substr($refcaja,0,4);
	global $refcj2;		$refcj2 = substr($refcaja,2,2);
	global $RefOperShop;		$RefOperShop = $refcj2.date('ymd').date('His');
	$_SESSION['oper'] = $RefOperShop;
	
	global $CajaShopname;	$CajaShopname = $_SESSION['Nombre'];
	global $CajaShopape;	$CajaShopape = $_SESSION['Apellidos'];
	global $CajaShopna;		$CajaShopna = $CajaShopname." ".$CajaShopape;
	
	global $semana;		$semana = date('W');
	global $date;		$date = date('y-m-d');
	global $ATime;		$ATime = date('H:i:s');
	global $datecash;	$datecash = $date."/".$ATime;

	require "../config/TablesNames.php";
	$ic2 =  "SELECT * FROM $CajaShop WHERE `kgcash` = '00.00'";
	$qic2 = mysqli_query($db, $ic2);
	$rowic2 = mysqli_fetch_assoc($qic2);
				
	global $autodelete;
	if(mysqli_num_rows($qic2) >= 1){
		$autodelete = "* CANCEL COMPRA AUTO Kg.0,00. SESSION OPER: ".$rowic2['oper']."\t
							* CAJA REF ".$rowic2['refcaja']."\t	 
							* CAJA NAME ".$rowic2['cname']."\t	
							* CAJA DATE W.".$rowic2['nsemana']." / D.".$rowic2['datecash']."\n\t";

		require "../config/TablesNames.php";
		$ic3 =  "DELETE FROM $CajaShop WHERE `kgcash` = '00.00' ";
		if(mysqli_query($db, $ic3)){ }else{ print("* Error L853. ".mysqli_error($db)."</br>"); }
	}

		global $IniKey;	$IniKey = 1;
		global $ClientRef;	$ClientRef = $_SESSION['ref'];
	
		require "../config/TablesNames.php";

		$ic = "INSERT INTO `$db_name`.$CajaShop (`ini`,`cname`, `refcaja`, `clname`, `refclient`, `oper`, `nsemana`, `datecash`, `vseccion`, `producto`, `proname`, `kgcash`, `psiva`, `iva`, `ivae`, `pvp`, `pvptot`, `pago`) VALUES ('$IniKey', '$CajaShopna', '$refcaja', '$CajaShopna', '$ClientRef', '$RefOperShop', '$semana', '$datecash', '', '', '', '0.00', '0.00', '0', '0.00', '0.00', '0.00', '')";
		
		if(mysqli_query($db, $ic)){
			global $LogTextcarro;
			$LogTextcarro = $autodelete.
						"\t* INIT COMPRA NEW. SESSION OPER: ".$RefOperShop."\t
								* CAJA REF ".$refcaja."\t	
								* CAJA NAME ".$CajaShopna."\t	
								* CAJA DATE W.".$semana." / D.".$datecash."\n";
		}else{ print("* Error L859. ".mysqli_error($db)."</br>"); }

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function cancel_compra(){
	
	global $db; 	global $db_name;
	global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
	require "../config/TablesNames.php";
	$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);

/////////////////////	
/* PARA SUMAR IVA */

if(!$qrc){print("* Error L882. ".mysqli_error($db).".</br>");
}else{
	$qivae = mysqli_query($db, $rc);
	$rowivae = mysqli_num_rows($qivae);
	$sumaivae = 0;
		  for($i=0; $i<$rowivae; $i++){ $ver = mysqli_fetch_array($qivae);
										$sumaivae = $sumaivae + $ver['ivae'];
											}
	}
			
/* FIN PARA SUMAR IVA */
/////////////////////////

/////////////////////	
/* PARA SUMAR PVPTOT */

if(!$qrc){print("* Error L882. ".mysqli_error($db).".</br>");
}else{
	$qpvptot = mysqli_query($db, $rc);
	$rowpvptot = mysqli_num_rows($qpvptot);
	$sumapvptot = 0;
		  for($i=0; $i<$rowpvptot; $i++){ $ver = mysqli_fetch_array($qpvptot);
										  $sumapvptot = $sumapvptot + $ver['pvptot'];
											}
		}
			
/* FIN PARA SUMAR PVPTOT */
/////////////////////////
							
	print ("<table align='center'>
			<tr style='font-size:14px'>
				<th colspan=12 class='BorderInf'>
						SUBTOTAL COMPRA ".$_SESSION['oper']." 
				</th>
			</tr>
			<tr style='font-size:10px'>
				<th class='BorderInfDch'>REF CAJA</th>						
				<th class='BorderInfDch'>REF CLIENT</th>
				<th class='BorderInfDch'>OPER SESION</th>
				<th class='BorderInfDch'>FECHA</th>	
				<th class='BorderInfDch'>SECCION</th>										
				<th class='BorderInfDch'>PRODUCTO</th>
				<th class='BorderInfDch'>CARRO</th>
				<th class='BorderInfDch'>IVA€</th>
				<th class='BorderInfDch'>PVP</th>
				<th class='BorderInfDch'>SUBT</th>
				<th class='BorderInf'></th>
			</tr>");
			///////////////////

		global $RefOperShop; $RefOperShop = $_SESSION['oper'];
		global $LogTextcarro;	global $txt;
		$LogTextcarro = "* CANCEL COMPRA 1 =>\t".$txt."\n";

			///////////////////
									
	while($rowrc = mysqli_fetch_assoc($qrc)){
		
	$ProName =strtolower($rowrc['proname']);
	
	print (	"<tr align='center'>
										
	<form name='cancel_compra2'  action='$_SERVER[PHP_SELF]' method='POST'>
	
	<input name='id' type='hidden' value='".$rowrc['id']."' />
	<input name='cname' type='hidden' value='".$rowrc['cname']."' />
	<input name='proname' type='hidden' value='".$rowrc['proname']."' />
	<input name='psiva' type='hidden' value='".$rowrc['psiva']."' />
	<input name='iva' type='hidden' value='".$rowrc['iva']."' />
						<td class='BorderInfDch' align='left'>
	<input name='refcaja' type='hidden' value='".$rowrc['refcaja']."' />".$rowrc['refcaja']."
						</td>
						<td class='BorderInfDch' align='left'>
	<input name='refclient' type='hidden' value='".$rowrc['refclient']."' />".$rowrc['refclient']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='oper' type='hidden' value='".$rowrc['oper']."' />".$rowrc['oper']."
						</td>
	<input name='nsemana' type='hidden' value='".$rowrc['nsemana']."' />
						<td class='BorderInfDch' align='right'>
	<input name='datecash' type='hidden' value='".$rowrc['datecash']."' />".$rowrc['datecash']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='vseccion' type='hidden' value='".$rowrc['vseccion']."' />".$rowrc['vseccion']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='producto' type='hidden' value='".$rowrc['producto']."' />".$ProName."
						</td>

						<td class='BorderInfDch' align='right'>
	<input name='kgcash' type='hidden' value='".$rowrc['kgcash']."' />".$rowrc['kgcash']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='ivae' type='hidden' value='".$rowrc['ivae']."' />".$rowrc['ivae']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='pvp' type='hidden' value='".$rowrc['pvp']."' />".$rowrc['pvp']."
						</td>
						<td class='BorderInfDch' align='right'>
	<input name='pvptot' type='hidden' value='".$rowrc['pvptot']."' />".$rowrc['pvptot']."
						</td>
						<td class='BorderInfDch' align='right'>");
						

if($rowrc['ini'] == '1'){
		print("<div style='float:left;margin-right:6px'>
					<input type='submit' value='ELIMINAR COMPRA' />
					<input type='hidden' name='cancel_compra2' value=1 />
				</div>");
		}
	print("</form>
				</td>
			</tr>");
								
	} /* FIN WHILE */
										
		print("	<tr>
					<td colspan='12' class='BorderInf'></td>
				</tr>
					<td colspan='3' class='BorderInf'></td>
					<td colspan='2' class='BorderInf' align='right'>TOTAL IVA</td>
					<td colspan='2' class='BorderInfDch' align='left'>".$sumaivae." €</td>
					<td colspan='2' class='BorderInf' align='right'>TOTAL €</td>
					<td class='BorderInfDch' align='right'>".$sumapvptot."</td>
					<td class='BorderInf'></td>
				</table>");
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function cancel_compra2(){
	
	global $db;		global $db_name;

	$RefOperShop = $_SESSION['oper'];		
	require "../config/TablesNames.php";
	$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);

/////////////////////	
/* PARA SUMAR IVA */

if(!$qrc){print("* Error L1027. ".mysqli_error($db).".</br>");
}else{
	$qivae = mysqli_query($db, $rc);
	$rowivae = mysqli_num_rows($qivae);
	$sumaivae = 0;
		  for($i=0; $i<$rowivae; $i++){ $ver = mysqli_fetch_array($qivae);
										$sumaivae = $sumaivae + $ver['ivae'];
											}
		}
			
/* FIN PARA SUMAR IVA */
/////////////////////////

/////////////////////	
/* PARA SUMAR PVPTOT */

if(!$qrc){print("* Error L1027. ".mysqli_error($db).".</br>");
}else{
	$qpvptot = mysqli_query($db, $rc);
	$rowpvptot = mysqli_num_rows($qpvptot);
	$sumapvptot = 0;
		for($i=0; $i<$rowpvptot; $i++){ $ver = mysqli_fetch_array($qpvptot);
										$sumapvptot = $sumapvptot + $ver['pvptot'];
											}
		}
			
/* FIN PARA SUMAR PVPTOT */
/////////////////////////

/////////////////////	

if(!$qrc){print("* Error L1027. ".mysqli_error($db).".</br>");
}else{
	$qcp = mysqli_query($db, $rc);
	$rowcp = mysqli_num_rows($qcp);
		for($i=0; $i<$rowcp; $i++){ $campo = mysqli_fetch_array($qcp);
			global $campos;
			$titut ="\n |  SECCION   |    REF PROD    |     PRO NAME     | CARRO";
			$datos =$datos."\n | ".$campo['vseccion']." | ".$campo['producto']." | ".$campo['proname']." | ".$campo['kgcash'];
			}
		}
			
		global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';}
		else{$tpro = $_POST['producto'];}
		global $campos;
		global $LogTextcarro;
		$LogTextcarro = "	* CANCEL COMPRA 2 =>\t
						* SESSION OPER: ".$RefOperShop."\t
						* REF CAJA: ".$campo['refcaja']."\t
						* REF CLIENT: ".$campo['refclient']."\t
						* NAME CLIENT: ".$campo['clname']."\t
						* IVA TOT: ".$sumaivae."\t
					  	* PVP TOT: ".$sumapvptot."".$titut.$datos;
						
///////////////////
							
	print ("<table align='center'>
			<tr style='font-size:14px'>
				<th colspan=11 class='BorderInf'>
						HA CANCELADO LA COMPRA ".$_SESSION['oper']." 
				</th>
			</tr>
			<tr style='font-size:10px'>
				<th class='BorderInfDch'>REF CAJA</th>										
				<th class='BorderInfDch'>REF CLIENT</th>
				<th class='BorderInfDch'>OPER SESION</th>
				<th class='BorderInfDch'>FECHA</th>
				<th class='BorderInfDch'>SECCION</th>										
				<th class='BorderInfDch'>PRODUCTO</th>
				<th class='BorderInfDch'>CARRO</th>
				<th class='BorderInfDch'>IVA€</th>
				<th class='BorderInfDch'>PVP</th>
				<th class='BorderInfDch'>SUBT</th>
			</tr>");

	require "../config/TablesNames.php";
	$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);

	while($rowrc = mysqli_fetch_assoc($qrc)){
		
		$ProName =strtolower($_POST['proname']);
	
		print (	"<tr align='center'>
			<form name='cancel_compra2'  action='$_SERVER[PHP_SELF]' method='POST'>
				<input name='id' type='hidden' value='".$rowrc['id']."' />
				<input name='cname' type='hidden' value='".$rowrc['cname']."' />
				<input name='proname' type='hidden' value='".$rowrc['proname']."' />
				<input name='proname' type='hidden' value='".$rowrc['producto']."' />
				<input name='psiva' type='hidden' value='".$rowrc['psiva']."' />
				<input name='iva' type='hidden' value='".$rowrc['iva']."' />
				<input name='nsemana' type='hidden' value='".$rowrc['nsemana']."' />
					<td class='BorderInfDch' align='left'>".$rowrc['refcaja']."</td>
					<td class='BorderInfDch' align='left'>".$rowrc['refclient']."</td>
					<td class='BorderInfDch' align='right'>".$rowrc['oper']."</td>
					<td class='BorderInfDch' align='right'>".$rowrc['datecash']."</td>
					<td class='BorderInfDch' align='right'>".$rowrc['vseccion']."</td>
					<td class='BorderInfDch' align='right'>".$ProName."</td>
					<td class='BorderInfDch' align='right'>".$rowrc['kgcash']."</td>
					<td class='BorderInfDch' align='right'>".$rowrc['ivae']."</td>
					<td class='BorderInfDch' align='right'>".$rowrc['pvp']."</td>
					<td class='BorderInfDch' align='right'>".$rowrc['pvptot']."</td>
					<td class='BorderInfDch' align='right'></td>
				</tr>
			</form>");
		} /*	FIN WHILE	*/
						
		print("<tr>
				<td colspan='11' class='BorderInf'></td>
			</tr>
				<td colspan='3' class='BorderInf'></td>
				<td colspan='2' class='BorderInf' align='right'>TOTAL IVA</td>
				<td colspan='2' class='BorderInfDch' align='left'>".$sumaivae." €</td>
				<td colspan='2' class='BorderInf' align='right'>TOTAL €</td>
				<td class='BorderInfDch' align='right'>".$sumapvptot."</td>
			</table>");
		} /* FIN FUNTION */

/* SUMAN COMPRA CANCELADA A STOCKS	*/														

function fcancel_1(){
	
	$date = date('y-m-d');
	$ATime = date('H:i:s');
	$datecash = $date."/".$ATime;

	global $db;		global $db_name;

	$RefOperShop = $_SESSION['oper'];
	require "../config/TablesNames.php";
	$vnt =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop'";
	$qvnt = mysqli_query($db, $vnt);
	$rowcvnt = mysqli_num_rows($qvnt);
	
	for($i=0; $i<$rowcvnt; $i++){

		$rowvnt = mysqli_fetch_assoc($qvnt);
		global $refpro; 	$refpro = $rowvnt['producto']; 
		require "../config/TablesNames.php";
		$cs1 = "SELECT * FROM $Stocks WHERE `producto` = '$rowvnt[producto]' AND `stock` > 0 ";
		$qcs1 = mysqli_query($db, $cs1);
		$rowcs1 = mysqli_fetch_assoc($qcs1);
	
	/* SUMA AL STOCK LA EL CARRO CANCELADO */

		$cuadrastock = $rowcs1['kgcash'] - $rowvnt['kgcash'];
		$cuadrapvptot = $rowcs1['pvptot'] - $rowvnt['pvptot'];
		$cuadrastock1 = $rowcs1['stock'] + $rowvnt['kgcash'];
		$coment = $rowcs1['coment']."</br>* Status: ".$rowcs1['kgcash']."-(".$rowcs1['kgbad']."+".$rowcs1['kgcash'].")=".$rowcs1['stock']."</br> Descontadas ".$_POST['kgcash']." Cancela venta.";

		$vnt = "UPDATE `$db_name`.$Stocks SET `kgcash` = '$cuadrastock', `stock` = '$cuadrastock1', `pvptot` = '$cuadrapvptot', `coment` = '$coment' WHERE $Stocks.`producto` = '$rowvnt[producto]' AND `stock` > 0  LIMIT 1 ";

		if(mysqli_query($db, $vnt)){
			print( "* ACTUALIZADO STOCK ".$seccx." / ".$Stocks."</br>" );
			global $LogTextcarro;
			$LogTextcarro = "\n* FCANCEL 1 ACTUALIZADO STOCK ".$seccx." ".$Stocks.".";
		}else{ print("* Error L1184. ".mysqli_error($db)."</br>"); }

	} /* FIN DEL FOR */

} /* FIN fcancel_1() */

/* ACTUALIZO TABLA DE PRODUCTOS */

function fcancel_2(){

	global $db;		global $db_name;	global $pvp;

	$RefOperShop = $_SESSION['oper'];
	require "../config/TablesNames.php";
	$vnt =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop'";
	$qvnt = mysqli_query($db, $vnt);
	$rowcvnt = mysqli_num_rows($qvnt);
	
	for($i=0; $i<$rowcvnt; $i++){

		$rowvnt = mysqli_fetch_assoc($qvnt);
		
		global $refpro;		$refpro = $rowvnt['producto']; /* ref pro */

		require "../config/TablesNames.php";

		$cs1 = "SELECT * FROM $tablapro2 WHERE `valor` = '$rowvnt[producto]'  LIMIT 1 ";
		$qcs1 = mysqli_query($db, $cs1);
		$rowcs1 = mysqli_fetch_assoc($qcs1);

		$cuadrastock1 = $rowcs1['stock'] + $rowvnt['kgcash'];

		$vnt = "UPDATE `$db_name`.$Productos SET  `stock` = '$cuadrastock1' WHERE $Productos.`valor` = '$refpro' LIMIT 1 ";

		if(mysqli_query($db, $vnt)){
			print( "* ACTUALIZADO PRO STOCK ".$seccx." / ".$Productos."</br>" );
			global $LogTextcarro;
			$LogTextcarro = "\n* FCANCEL 2 ACTUALIZADO PRO STOCK ".$seccx." ".$Productos.".";
		}else{ print("* Error L1222. ".mysqli_error($db))."</br>"; }

	} /* FIN DEL FOR */

} /* FIN function fcancel_2() */

/* ACTUALIZO TABLA FEEDBACK PRODUCTOS */

function fcancel_3(){

	global $db;		global $db_name;

	$RefOperShop = $_SESSION['oper'];
	require "../config/TablesNames.php";
	$vnt =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop'";
	$qvnt = mysqli_query($db, $vnt);
	$rowcvnt = mysqli_num_rows($qvnt);
	
	for($i=0; $i<$rowcvnt; $i++){

		$rowvnt = mysqli_fetch_assoc($qvnt);
		
		global $refpro;
		$refpro = $rowvnt['producto']; /* ref pro */

		require "../config/TablesNames.php";

		$cs1 = "SELECT * FROM $tablafeedpro WHERE `valor` = '$rowvnt[producto]'  LIMIT 1 ";
		$qcs1 = mysqli_query($db, $cs1);
		$rowcs1 = mysqli_fetch_assoc($qcs1);

		$cuadrastock1 = $rowcs1['stock'] + $rowvnt['kgcash'];

		$vnt = "UPDATE `$db_name`.$tablafeedpro SET  `stock` = '$cuadrastock1' WHERE $tablafeedpro.`valor` = '$refpro' LIMIT 1 ";

		if(mysqli_query($db, $vnt)){
			print( "* FCANCEL 3 ACTUALIZADO FEED PRO STOCK ".$seccx." / ".$tablafeedpro."</br>" );
			global $LogTextcarro;
			$LogTextcarro = "\n* FCANCEL 3 ACTUALIZADO FEED PRO STOCK ".$seccx." ".$tablafeedpro.".";
		}else{ print("* Error L1261. ".mysqli_error($db))."</br>"; }
	} /* FIN DEL FOR */

} /* FIN fcancel_2() */

/*	FUNCION QUE CANCELA LA COMPRA */

function fcancel_4(){
	
	global $db;		global $db_name;

	$RefOperShop = $_SESSION['oper'];
	require "../config/TablesNames.php";
	$cc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop'";
	$qcc = mysqli_query($db, $cc);

/////////////////////	

if(!$qcc){print("* Error L1280. ".mysqli_error($db).".</br>");
}else{
	$qcp = mysqli_query($db, $cc);
	$rowcp = mysqli_num_rows($qcp);
		for($i=0; $i<$rowcp; $i++){ $campo = mysqli_fetch_array($qcp);
			global $campos;
			$titut ="\n |  SECCION   |    REF PROD    |     PRO NAME     | CARRO";
			$datos =$datos."\n | ".$campo['vseccion']." | ".$campo['producto']." | ".$campo['proname']." | ".$campo['kgcash'];
			}
		}
			
	$RefOperShop = $_SESSION['oper'];
	if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';
	}else{$tpro = $_POST['producto']; }
		global $campos;		global $LogTextcarro;
		global $sumaivae;	global $sumapvptot;
		$LogTextcarro = "	* FCANCEL 4 =>\t
						* SESSION OPER: ".$RefOperShop."\t
						* REF CAJA: ".$campo['refcaja']."\t
						* REF CLIENT: ".$campo['refclient']."\t
						* NAME CLIENT: ".$campo['clname']."\t
						* IVA TOT: ".$sumaivae."\t
					  	* PVP TOT: ".$sumapvptot."".$titut.$datos;
						
///////////////////
				
	if(mysqli_num_rows($qcc) >= 1){
		require "../config/TablesNames.php";
		$cc2 =  "DELETE FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
			if(mysqli_query($db, $cc2)){ unset($_SESSION['oper']);
										 print("* COMPRA CANCELADA.");
			}else{ print("* Error L1313. ".mysqli_error($db)."</br>"); }
		}

} /* FIN fcancel_2() */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function recup_compra(){
	
	global $db;		global $db_name;
	print("* ".$_SESSION['ref']);
	//unset($_SESSION['oper']);
	
	global $ref;	$ref = $_SESSION['ref'];

	require "../config/TablesNames.php";
	$rc =  "SELECT * FROM $CajaShop WHERE `refclient` = '$ref' ORDER BY `oper` ASC ";
	$qrc = mysqli_query($db, $rc);
	$count = mysqli_num_rows($qrc);
		
	if($count < 1){print("<div align='center' style='margin-bottom:120px;margin-top:120px'>
											NO HAY COMPRAS PENDIENTES
							</div>");}
		
	else{ print ("<table align='center'>
					<tr style='font-size:14px'>
						<th colspan=10 class='BorderInf'>SESIONES DE COMPRAS</th>
					</tr>
					<tr style='font-size:12px'>
						<th class='BorderInfDch'>CAJERO/A</th>
						<th class='BorderInfDch'>REF CAJA</th>											
						<th class='BorderInfDch'>OPER SESION</th>								
						<th class='BorderInfDch'>FECHA</th>										
						<th class='BorderInfDch'>REF CLIENTE</th>										
						<th class='BorderInfDch'>SECCION</th>										
						<th class='BorderInfDch'>PRODUCTO</th>										
						<th class='BorderInfDch'>CARRO</th>										
						<th colspan='2' class='BorderInf'></th>
					</tr>");
									
	while($rowrc = mysqli_fetch_assoc($qrc)){

	global $ClientRef;		$ClientRef = $_SESSION['oper'];
	global $InixKey;			$InixKey = $rowrc['ini'];
	if($rowrc['ini'] != '1'){$rowrc['cname'] = '';
							  $rowrc['datecash'] = '';}

	print (	"<tr align='center'>
		<form name='recup_compra2' method='post' action='$_SERVER[PHP_SELF]'>
						<td class='BorderInfDch' align='left'>
			<input name='cname' type='hidden' value='".$rowrc['cname']."' />".$rowrc['cname']."
						</td>
						<td class='BorderInfDch' align='left'>
			<input name='refcaja' type='hidden' value='".$rowrc['refcaja']."' />".$rowrc['refcaja']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='oper' type='hidden' value='".$rowrc['oper']."' />".$rowrc['oper']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='datecash' type='hidden' value='".$rowrc['datecash']."' />".$rowrc['datecash']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='refclient' type='hidden' value='".$rowrc['refclient']."' />".$rowrc['refclient']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='vseccion' type='hidden' value='".$rowrc['vseccion']."' />".$rowrc['vseccion']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='producto' type='hidden' value='".$rowrc['producto']."' />".$rowrc['producto']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='kgcash' type='hidden' value='".$rowrc['kgcash']."' />".$rowrc['kgcash']."
						</td>
			<td class='BorderInf'>");
									
	if($rowrc['ini'] == '1'){
	print("<div style='float:left;margin-right:4px'>
				<input type='submit' value='RECUPERA COMPRA' />
				<input type='hidden' name='recup_compra2' value=1 />
			</div>");
	}

	global $LogTextcarro; 		$LogTextcarro = "	* CONSULTA RECUPERA COMPRA 1 =>";

	print("</form>	
				</td>");

	require "../config/TablesNames.php";
	$dtcl =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ref' ";
	$qdtcl = mysqli_query($db, $dtcl);
	global $h;	$h = 'height=620px';

	while($rowdtcl = mysqli_fetch_assoc($qdtcl)){
		
		print("	<td class='BorderInf'>");
		
		global $InixKey;
		if($InixKey == '1'){ 

		print("	<div style='float:left;margin-right:4px'>
			<form name='data_client' action='../AdminClientesWeb/ClienteVer02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=500px,".$h."')\">

				<input name='id' type='hidden' value='".$rowdtcl['id']."' />
				<input name='Nivel' type='hidden' value='".$rowdtcl['Nivel']."' />
				<input name='ref' type='hidden' value='".$rowdtcl['ref']."' />
				<input name='Nombre' type='hidden' value='".$rowdtcl['Nombre']."' />
				<input name='Apellidos' type='hidden' value='".$rowdtcl['Apellidos']."' />
				<input name='myimg' type='hidden' value='".$rowdtcl['myimg']."' />
				<input name='doc' type='hidden' value='".$rowdtcl['doc']."' />
				<input name='dni' type='hidden' value='".$rowdtcl['dni']."' />
				<input name='ldni' type='hidden' value='".$rowdtcl['ldni']."' />
				<input name='Email' type='hidden' value='".$rowdtcl['Email']."' />
				<input name='Usuario' type='hidden' value='".$rowdtcl['Usuario']."' />
				<input name='Password' type='hidden' value='".$rowdtcl['Password']."' />
				<input name='Direccion' type='hidden' value='".$rowdtcl['Direccion']."' />
				<input name='Tlf1' type='hidden' value='".$rowdtcl['Tlf1']."' />
				<input name='Tlf2' type='hidden' value='".$rowdtcl['Tlf2']."' />
				<input name='lastin' type='hidden' value='".$rowdtcl['lastin']."' />
				<input name='lastout' type='hidden' value='".$rowdtcl['lastout']."' />
				<input name='visitadmin' type='hidden' value='".$rowdtcl['visitadmin']."' />
					<input type='submit' value='DATOS CLIENTE' />
					<input type='hidden' name='oculto2' value=1 />
				</form>	
			</div>");
		}

		print("</td>");

		} /* FIN DEL WHILE */
					
				print("</tr>");
			}
				print("</table>");
		}
	} /* FIN function recup_compra() */

function recup_compra2(){
		$_SESSION['oper'] = $_POST['oper'];
		//	print("* INIT CAJA SESION.".$_SESSION['oper']);	
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function subtotal(){
	
	global $db;		global $db_name;

	$RefOperShop = $_SESSION['oper'];		
	require "../config/TablesNames.php";
	$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);

/////////////////////	
/* PARA SUMAR IVA */

if(!$qrc){print("* Error L1471. ".mysqli_error($db).".</br>");
}else{
	$qivae = mysqli_query($db, $rc);
	$rowivae = mysqli_num_rows($qivae);
	$sumaivae = 0;
		for($i=0; $i<$rowivae; $i++){ $ver = mysqli_fetch_array($qivae);
				global $sumaivae;	$sumaivae = $sumaivae + $ver['ivae'];
											}
				}
			
/* FIN PARA SUMAR IVA */
/////////////////////////

/////////////////////	
/* PARA SUMAR PVPTOT */

if(!$qrc){print("* Error L1471. ".mysqli_error($db).".</br>");
}else{
	$qpvptot = mysqli_query($db, $rc);
	$rowpvptot = mysqli_num_rows($qpvptot);
	$sumapvptot = 0;
		for($i=0; $i<$rowpvptot; $i++){ $ver = mysqli_fetch_array($qpvptot);
					global $sumapvptot;		$sumapvptot = $sumapvptot + $ver['pvptot'];
				}
		}
			
/* FIN PARA SUMAR PVPTOT */
/////////////////////////

/////////////////////	

if(!$qrc){print("* Error L1471. ".mysqli_error($db).".</br>");
}else{
	$qcp = mysqli_query($db, $rc);
	$rowcp = mysqli_num_rows($qcp);
		  for($i=0; $i<$rowcp; $i++){ $campo = mysqli_fetch_array($qcp);
				global $campos;		$titut ="\n |  SECCION   |    REF PROD    |     PRO NAME     | CARRO";
				$datos =$datos."\n | ".$campo['vseccion']." | ".$campo['producto']." | ".$campo['proname']." | ".$campo['kgcash'];
			}
		}
			
		$RefOperShop = $_SESSION['oper'];
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';
		}else{$tpro = $_POST['producto'];}
		global $campos;		global $LogTextcarro;
		$LogTextcarro = "	* SUBTOTAL =>\t
						* SESSION OPER: ".$RefOperShop."\t
						* REF CAJA: ".$campo['refcaja']."\t
						* REF CLIENT: ".$campo['refclient']."\t
						* NAME CLIENT: ".$campo['clname']."\t
						* IVA TOT: ".$sumaivae."\t
					  	* PVP TOT: ".$sumapvptot."".$titut.$datos;
						
///////////////////
			
	print ("<table align='center'>
				<tr style='font-size:14px'>
					<th colspan=11 class='BorderInf'>
						REF CLIENT: ".$_SESSION['ref']." SUBTOTAL COMPRA ".$_SESSION['oper']." 
					</th>
				</tr>
				<tr style='font-size:10px'>
					<th class='BorderInfDch'>REF CAJA</th>
					<th class='BorderInfDch'>FECHA</th>
					<th class='BorderInfDch'>SECCION</th>										
					<th class='BorderInfDch'>PRODUCTO</th>
					<th class='BorderInfDch'>STOCK</th>
					<th bgcolor='#DCEDED' class='BorderInfDch'>CARRO</th>
					<th class='BorderInfDch'>IVA€</th>
					<th class='BorderInfDch'>PVP</th>
					<th bgcolor='#DCEDED' class='BorderInfDch'>SUBT</th>
					<th colspan='2' class='BorderInf'></th>
				</tr>");
									
	while($rowrc = mysqli_fetch_assoc($qrc)){
			$ProName = ucwords(strtolower($rowrc['proname']));
	
///////////////////////

if($rowrc['producto'] != ''){
	global $db;		global $db_name;

	$fil = "%".$rowrc['producto']."%";

	require "../config/TablesNames.php";
 	$sstk =  "SELECT * FROM $sstock WHERE `valor` LIKE '$fil' ";
	$qst = mysqli_query($db, $sstk);
	$RowStock= mysqli_fetch_assoc($qst);
	global $stock;
	$stock = $rowstock['stock'];
}

///////////////////////

	print ("<tr align='center'>
		<form name='modif_pro'  action='$_SERVER[PHP_SELF]' method='POST'>
			<input name='id' type='hidden' value='".$rowrc['id']."' />
			<input name='cname' type='hidden' value='".$rowrc['cname']."' />
			<input name='proname' type='hidden' value='".$rowrc['proname']."' />
			<input name='psiva' type='hidden' value='".$rowrc['psiva']."' />
			<input name='iva' type='hidden' value='".$rowrc['iva']."' />
						<td class='BorderInfDch' align='left'>
			<input name='refcaja' type='hidden' value='".$rowrc['refcaja']."' />".$rowrc['refcaja']."
						</td>
			<input name='refclient' type='hidden' value='".$rowrc['refclient']."' />
			<input name='oper' type='hidden' value='".$rowrc['oper']."' />
			<input name='nsemana' type='hidden' value='".$rowrc['nsemana']."' />
						<td class='BorderInfDch' align='right'>
			<input name='datecash' type='hidden' value='".$rowrc['datecash']."' />".$rowrc['datecash']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='vseccion' type='hidden' value='".$rowrc['vseccion']."' />".$rowrc['vseccion']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='producto' type='hidden' value='".$rowrc['producto']."' />".$ProName."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='stock' type='hidden' value='".$rowstock['stock']."' />".$rowstock['stock']."
						</td>
						<td bgcolor='#DCEDED' class='BorderInfDch' align='right'>
			<input name='kgcashx' type='hidden' value='".$rowrc['kgcash']."' />".$rowrc['kgcash']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='ivae' type='hidden' value='".$rowrc['ivae']."' />".$rowrc['ivae']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='pvp' type='hidden' value='".$rowrc['pvp']."' />".$rowrc['pvp']."
						</td>
						<td bgcolor='#DCEDED' class='BorderInfDch' align='right'>
			<input name='pvptot' type='hidden' value='".$rowrc['pvptot']."' />".$rowrc['pvptot']."
						</td>");

	if($rowrc['producto'] != ''){
			print("<td colspan='2' class='BorderInfDch' align='right'>
						<div style='float:left;margin-right:3px'>
							<input type='submit' value='MODIF' />
							<input type='hidden' name='modif_pro' value=1 />
						</div>
			</form>
			<form name='elim_pro'  action='$_SERVER[PHP_SELF]' method='POST'>
				<input name='id' type='hidden' value='".$rowrc['id']."' />
				<input name='cname' type='hidden' value='".$rowrc['cname']."' />
				<input name='proname' type='hidden' value='".$rowrc['proname']."' />
				<input name='psiva' type='hidden' value='".$rowrc['psiva']."' />
				<input name='iva' type='hidden' value='".$rowrc['iva']."' />
				<input name='refcaja' type='hidden' value='".$rowrc['refcaja']."' />	
				<input name='refclient' type='hidden' value='".$rowrc['refclient']."' />
				<input name='oper' type='hidden' value='".$rowrc['oper']."' />	
				<input name='nsemana' type='hidden' value='".$rowrc['nsemana']."' />	
				<input name='datecash' type='hidden' value='".$rowrc['datecash']."' />
				<input name='vseccion' type='hidden' value='".$rowrc['vseccion']."' />	
				<input name='producto' type='hidden' value='".$rowrc['producto']."' />
				<input name='kgcash' type='hidden' value='".$rowrc['kgcash']."' />	
				<input name='ivae' type='hidden' value='".$rowrc['ivae']."' />			
				<input name='pvp' type='hidden' value='".$rowrc['pvp']."' />	
				<input name='pvptot' type='hidden' value='".$rowrc['pvptot']."' />
			<div style='float:left;margin-right:3px'>
				<input type='submit' value='BORRA' />
				<input type='hidden' name='elim_pro' value=1 />
			</div>
		</form>
		
		<form name='ver' action='ProductosVerImg.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=440px,height=640px')\">
				<input name='seccion' type='hidden' value='".$rowrc['vseccion']."' />
				<input name='id' type='hidden' value='".$rowrc['id']."' />
				<input name='valor' type='hidden' value='".$rowrc['producto']."' />
				<input name='nombre' type='hidden' value='".$rowrc['proname']."' />
				<input name='ref' type='hidden' value='".$rowrc['producto']."' />
			<div style='float:left;margin-right:3px'>
				<input type='submit' value='IMAGENES' />
				<input type='hidden' name='oculto2' value=1 />
			</div>
		</form>");
		} /* FIN WHILE */

		print("</td>
				</tr>");
	} /*	FIN WHILE	*/
						
		print("<tr>
				<td colspan='11' class='BorderInf'></td>
			</tr>
				<td colspan='3' class='BorderInf'>");

	global $RefOperShop;		$RefOperShop = $_SESSION['oper'];
	require "../config/TablesNames.php";

	$rdcl =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qdcl = mysqli_query($db, $rdcl);
	$rowdcl = mysqli_fetch_assoc($qdcl);
	$ClientRef = $rowdcl['refclient'];
	// print("* ".$rowdcl['refclient']);

	$ncl =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ref' ";
	$qncl = mysqli_query($db, $ncl);
	$rowncl = mysqli_fetch_assoc($qncl);
	$_SESSION['nclient'] = $rowncl['Nivel'];
	// print(" ".$_SESSION['nclient']);

	$dtcl =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ORDER BY `Nombre` ASC ";
	$qdtcl = mysqli_query($db, $dtcl);
	global $h;	$h = 'height=620px';

	while($rowdtcl = mysqli_fetch_assoc($qdtcl)){

	print("	<div style='float:left;margin-right:6px'>
		<form name='data_client' action='ClienteVer02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=500px,".$h."')\">
			<input name='id' type='hidden' value='".$rowdtcl['id']."' />
			<input name='Nivel' type='hidden' value='".$rowdtcl['Nivel']."' />
			<input name='ref' type='hidden' value='".$rowdtcl['ref']."' />
			<input name='Nombre' type='hidden' value='".$rowdtcl['Nombre']."' />
			<input name='Apellidos' type='hidden' value='".$rowdtcl['Apellidos']."' />
			<input name='myimg' type='hidden' value='".$rowdtcl['myimg']."' />
			<input name='doc' type='hidden' value='".$rowdtcl['doc']."' />
			<input name='dni' type='hidden' value='".$rowdtcl['dni']."' />
			<input name='ldni' type='hidden' value='".$rowdtcl['ldni']."' />
			<input name='Email' type='hidden' value='".$rowdtcl['Email']."' />
			<input name='Usuario' type='hidden' value='".$rowdtcl['Usuario']."' />
			<input name='Password' type='hidden' value='".$rowdtcl['Password']."' />
			<input name='Direccion' type='hidden' value='".$rowdtcl['Direccion']."' />
			<input name='Tlf1' type='hidden' value='".$rowdtcl['Tlf1']."' />
			<input name='Tlf2' type='hidden' value='".$rowdtcl['Tlf2']."' />
			<input name='lastin' type='hidden' value='".$rowdtcl['lastin']."' />
			<input name='lastout' type='hidden' value='".$rowdtcl['lastout']."' />
			<input name='visitadmin' type='hidden' value='".$rowdtcl['visitadmin']."' />
				<input type='submit' value='DATOS CLIENTE' />
				<input type='hidden' name='oculto2' value=1 />
		</form>	
			</div>");			
	} /* Fin del while.*/ 
										
		print("</td>
				<td colspan='3' class='BorderInf' align='right'>TOTAL IVA</td>
				<td bgcolor='#DCEDED' class='BorderInfDch' align='left'>".$sumaivae." €</td>
				<td colspan='2' class='BorderInf' align='right'>TOTAL €</td>
				<td bgcolor='#DCEDED' class='BorderInfDch' align='right'>".$sumapvptot."</td>
				<td class='BorderInf'>");

		require "../config/TablesNames.php";
		$rdx =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
		$qdx = mysqli_query($db, $rdx);
		$rowdx = mysqli_fetch_assoc($qdx);
		if($RefOperShop == ''){}
		elseif($rowdx['producto'] != ''){
			print(" <div align='center' >
						<form name='pago' method='post' action='$_SERVER[PHP_SELF]'>
							<input type='submit' value='FORMA DE PAGO' />
							<input type='hidden' name='pago' value=1 />
						</form>	
					</div>");
				}
		
		print("</td></table>");

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function selec_pro(){
	
	global $db;		global $db_name;

	global $secc;	$secc = $_POST['seccion'];
	$secc = "`".$secc."`";

	require "../config/TablesNames.php";
	$sqlx =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[seccion]'";
	$q = mysqli_query($db, $sqlx);
	$rowseccion = mysqli_fetch_assoc($q);
	
	global $_sec;	$_sec = $rowseccion['nombre'];
	
/////////////////
	
	$semana = date('W');
	$date = date('Y-m-d');

	$kgcash1 = $_POST['kgcash1'];	
	$kgcash2 = $_POST['kgcash2'];
	
	global $kgcash;		$kgcash = $kgcash1.".".$kgcash2;

	$CajaShop = $kgcash;
	$pvp = $_POST['pvp'];
	global $pvptot;		$pvptot = $CajaShop * $pvp ;
	
	$ivae =$_POST['ivae'];
	$ivav = $ivae * $CajaShop;
	
/////////////////

	$tabla = "<table align='center' style='margin-top:10px'>
				<tr>
					<th colspan=4 class='BorderInf'>HA SELECCIONADO</th>
				</tr>
				<tr>
					<td>SECCION</td>
					<td>".$rowseccion['nombre']."</td>
					<td>PRODUCT REF</td>
					<td>".$_POST['valor']."</td>
				</tr>				
				<tr>
					<td>PRODUCT NAME</td>
					<td>".$_POST['proname']."</td>
					<td>UNIT VENTA</td>
					<td>".$kgcash."</td>
				</tr>
				<tr>
					<td>PVP SIN IVA</td>
					<td>".$_POST['psiva']." €
					</td>
					<td>TIPO IVA</td>
					<td>".$_POST['iva']." %
					</td>
				</tr>
				<tr>
					<td>IVA €</td>
					<td>".$ivav ." €
					</td>
					<td>UNIT € PVP</td>
					<td>".$_POST['pvp']." €
					</td>
				</tr>
				<tr>
					<td colspan='2'></td>
					<td>CAJA TOT €</td>
					<td>".$pvptot." €</td>
				</tr>
			</table>";	/* Final de la variable*/ 
		
	$RefOperShop = $_SESSION['oper'];

	require "../config/TablesNames.php";
	$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);
	$rowrc = mysqli_fetch_assoc($qrc);
	global $ClientRef;	$ClientRef = $_SESSION['ref'];
	$refcaja = $_SESSION['ref'];

	$CajaShopname = $_SESSION['Nombre'];
	$CajaShopape = $_SESSION['Apellidos'];
	global $CajaShopna; 	$CajaShopna = $CajaShopname." ".$CajaShopape;

	if (($rowrc['oper'] == $RefOperShop ) && ( $rowrc['kgcash'] == 00.00 )){

		require "../config/TablesNames.php";
		
		$sql = "UPDATE `$db_name`.$CajaShop SET `clname` = '$CajaShopna', `refclient` = '$ClientRef', `vseccion` = '$_POST[seccion]', `producto` = '$_POST[valor]', `proname` = '$_POST[proname]', `kgcash` = '$kgcash', `psiva` = '$_POST[psiva]', `iva` = '$_POST[iva]', `ivae` = '$ivav', `pvp` = '$_POST[pvp]', `pvptot` = '$pvptot' WHERE `oper` = '$RefOperShop' AND `kgcash` = '00.00'  LIMIT 1 ";
		
		if(mysqli_query($db, $sql)){ print( $tabla );
								
			///////////////////

		global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
		global $tpro;
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';
		}else{$tpro = $_POST['producto'];}
			global $LogTextcarro1;
			$LogTextcarro1 = "	* SELECT PRO =>\t
							* SESSION OPER ".$RefOperShop."\t
							* REF CLIENTE ".$ClientRef."\t
							* SECCION ".$_POST['seccion']."\t
							* PRODUCTO ".$_POST['proname']."\t	
							* UNIT CAJA ".$kgcash."\t
							* PVP ".$_POST['pvp']."\t
							* PVPTOT ".$pvptot."\n";

			///////////////////

		}else{ print("* Error L1827. ".mysqli_error($db))."</br>"; }
	}else{	

		require "../config/TablesNames.php";
		
		$ic = "INSERT INTO `$db_name`.$CajaShop (`cname`, `refcaja`, `oper`, `nsemana`, `datecash`) VALUES ('$CajaShopna', '$refcaja', '$rowrc[oper]', '$rowrc[nsemana]', '$rowrc[datecash]')";
		
		if(mysqli_query($db, $ic)){
			//print("* INIT CAJA SESION.".$_SESSION['oper']);
		}else{ print("* Error L1854. ".mysqli_error($db)."</br>");}
	
		require "../config/TablesNames.php";
		
		$sql = "UPDATE `$db_name`.$CajaShop SET `clname` = '$CajaShopna', `refclient` = '$ClientRef', `vseccion` = '$_POST[seccion]', `producto` = '$_POST[valor]', `proname` = '$_POST[proname]', `kgcash` = '$kgcash', `psiva` = '$_POST[psiva]', `iva` = '$_POST[iva]', `ivae` = '$ivav', `pvp` = '$_POST[pvp]', `pvptot` = '$pvptot' WHERE `oper` = '$RefOperShop' AND `kgcash` = '00.00'  LIMIT 1 ";
		
		if(mysqli_query($db, $sql)){ print($tabla);

		$RefOperShop = $_SESSION['oper'];
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';
		}else{$tpro = $_POST['producto'];}
		global $LogTextcarro1;
		$LogTextcarro1 = "	* SELECT PRO =>\t
						* SESSION OPER ".$RefOperShop."\t
						* REF CLIENTE ".$ClientRef."\t
						* SECCION ".$_POST['seccion']."\t
					  	* PRODUCTO ".$_POST['proname']."\t	
					  	* UNIT CAJA ".$kgcash."\t
					  	* PVP ".$_POST['pvp']."\t
					  	* PVPTOT ".$pvptot."\n";

		}else{ print("* Error L1862. ".mysqli_error($db))."</br>"; }
	}
					
/* RESTA COMPRA A STOCKS */															

	global $db;			global $db_name;
	global $refpro;		$refpro = $_POST['valor']; /* ref pro */
	require "../config/TablesNames.php";
	$cs1 = "SELECT * FROM $Stocks WHERE `producto` = '$refpro' AND `stock` > 0 ";
	$qcs1 = mysqli_query($db, $cs1);
	$rowcs1 = mysqli_fetch_assoc($qcs1);
	
	if(mysqli_num_rows($qcs1) > 0){
	
/* RESTA AL STOCK LA NUEVA ENTRADA */

	$cuadrastock = $rowcs1['kgcash'] + $kgcash;
	$cuadrapvptot = $rowcs1['pvptot'] + $pvptot;
	$cuadrastock1 = $rowcs1['stock'] - $kgcash;
	
	$coment = $rowcs1['coment']."</br>* Status: ".$rowcs1['kgcash']."+(".$rowcs1['kgbad']."+".$rowcs1['kgcash'].")=".$rowcs1['stock']."</br> Descontadas ".$kgcash." Venta del stock.";

	require "../config/TablesNames.php";
	
	$cs2 = "UPDATE `$db_name`.$Stocks SET `kgcash` = '$cuadrastock', `stock` = '$cuadrastock1',  `pvptot` = '$cuadrapvptot', `coment` = '$coment' WHERE $Stocks.`producto` = '$refpro' AND `stock` > 0  LIMIT 1 ";

	if(mysqli_query($db, $cs2)){
		print( "* ACTUALIZADO STOCK ".$seccx2." ".$Stocks."</br>" );
		global $LogTextcarro2;
		$LogTextcarro2 = "\n* ACTUALIZADO STOCK RESTADO ".$kgcash."".$seccx2." ".$Stocks."";
	}else{ print("* Error L1905. ".mysqli_error($db)."</br>"); }

/* ACTUALIZO TABLA DE PRODUCTOS */

	global $pvp;
	require "../config/TablesNames.php";
	$sqlc2 = "UPDATE `$db_name`.$secc SET  `stock` = '$cuadrastock1' WHERE $secc.`valor` = '$refpro' LIMIT 1 ";

	if(mysqli_query($db, $sqlc2)){
		print( "* ACTUALIZADO PRO STOCK ".$secc." ".$cuadrastock1."</br>" );
		global $LogTextcarro3;
		$LogTextcarro3 = "\n* ACTUALIZADO PRO STOCK ".$secc." ".$cuadrastock1."";
	}else{ print("* Error L1917. ".mysqli_error($db))."</br>";}

/* ACTUALIZO TABLA FEEDBACK PRODUCTOS */

	require "../config/TablesNames.php";
	
	$sqlc3 = "UPDATE `$db_name`.$tablafeedpro2 SET `stock` = '$cuadrastock1' WHERE $tablafeedpro2.`valor` = '$refpro' LIMIT 1 ";

		if(mysqli_query($db, $sqlc3)){
			print( "* ACTUALIZADO FEED FEED PRO ".$tablafeedpro23." ".$cuadrastock1."</br>" );
			global $LogTextcarro4;
			$LogTextcarro4 = "\n* ACTUALIZADO FEED PRO ".$tablafeedpro2." ".$cuadrastock1."";
		}else{ print("* Error L1929. ".mysqli_error($db))."</br>";}
	}else{print("");}
		
	global $LogTextcarro;
	$LogTextcarro = $LogTextcarro1.$LogTextcarro2.$LogTextcarro3.$LogTextcarro4;
					
	} /* function selec_pro() */
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function process_form($errors=[]){
	
	global $db;
		
	if($_POST['oculto']){
			$defaults = array ( 'kgcash1' => '',
								 'kgcash2' => '00',);
	}else{ }
	if($_POST['selec_pro']){
			global $kgcash1;
			global $kgcash2;
			$defaults = array ( 'kgcash1' => $kgcash1,
								 'kgcash2' => $kgcash2,);
	}else{ $defaults = array ( 'kgcash1' => '',
							  'kgcash2' => '00',);
					}
	
	if ($errors){
		print("<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font></br>* ".$_POST['proname'].".</br>");

		if($_POST['selec_pro']){
				$defaults = array ( 'kgcash1' => '',
									'kgcash2' => '00',);
				}
		
		for($a=0; $c=count($errors), $a<$c; $a++){
		print("<font color='#F1BD2D'>* </font>".$errors [$a]."</br>");

			$RefOperShop = $_SESSION['oper'];
			if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';}
			else{$tpro = $_POST['producto'];}
			global $LogTextcarro;
			$LogTextcarro = "	* SELECT PRO ERRORS =>\t
							* SESSION OPER ".$RefOperShop."\t
							* SECCION ".$_POST['seccion']."\t
							* PRODUCTO ".$_POST['proname']."\t	
							* ERROR ".$errors [$a]."\n";
				}
		}

///////////////////////////

	global $secc;	$secc = "pro".$_POST['seccion'];
	$secc = "`".$secc."`";
	$fil = "%".$_POST['producto']."%";

 	$sqlc =  "SELECT * FROM $secc WHERE `valor` LIKE '$fil' ";
	$qc = mysqli_query($db, $sqlc);
	
///////////////////

		require "../config/TablesNames.php";
		$sqlx =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[seccion]'";
		$q = mysqli_query($db, $sqlx);
		$rowseccion = mysqli_fetch_assoc($q);
		$_sec = $rowseccion['nombre'];
		$producto = "pro".$_POST['seccion'];

		$nkgcash = strlen(trim($_POST['stock']));
		$nkgcash = $nkgcash - 3;
		$kgcashx = $_POST['stock'];
		$kgcash1 = substr($_POST['stock'],0,$nkgcash);
		$kgcash2 = substr($_POST['stock'],-2,2);

		$kgcash1 = $_POST['kgcash1'];	
		$kgcash2 = $_POST['kgcash2'];
		global $kgcash;	
		$kgcash = $kgcash1.".".$kgcash2;
	
	if(!$qc){ print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
						<tr align='center'>
							<td>
								<font color='red'><b>
									TIENE QUE SELECCIONAR UNA SECCIÓN PARA VER LOS DATOS.
								</font>
							</td>
						</tr>
					</table>");
	}else{
		if(mysqli_num_rows($qc)== 0){
			print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
					<tr align='center'>
						<td>
							<font color='red'>
								<b>NO HAY DATOS EN ".$rowseccion['nombre'].".
							</font>
						</td>
					</tr>
				</table>");
		}else{ print ("<table align='center'>
						<tr style='font-size:13px'>
							<th colspan=10 class='BorderInf'>
								PRODUCTOS SECCION ".$rowseccion['nombre']."
							</th>
						</tr>	
						<tr style='font-size:12px'>
							<th class='BorderInfDch'>NAME PRO</th>
							<th class='BorderInfDch'>PVPN</th>
							<th class='BorderInfDch'>IVA%</th>	
							<th class='BorderInfDch'>IVA€</th>	
							<th class='BorderInfDch'>PVP.€</th>	
							<th class='BorderInfDch'>STOCK</th>										
							<th class='BorderInfDch'>UNIT COMPRA</th>
							<th class='BorderInfDch'>DESCRIPCION</th>
							<th class='BorderInf'></th>
						</tr>");
			
		while($rowc = mysqli_fetch_assoc($qc)){
				
			$semana = date('W');
			$date = date('Y-m-d');

		if ($rowc['valor'] != ''){
			
		print ("<tr align='center'>
			<form name='modifica'  action='$_SERVER[PHP_SELF]' method='POST'>
				<input name='seccion' type='hidden' value='".$_POST['seccion']."' />
				<input name='valor' type='hidden' value='".$rowc['valor']."' />
						<td class='BorderInfDch' align='left'>
				<input name='proname' type='hidden' value='".$rowc['nombre']."' />".$rowc['nombre']."
						</td>
						<td class='BorderInfDch' align='right'>
				<input name='psiva' type='hidden' value='".$rowc['psiva']."' />".$rowc['psiva']."
						</td>
						<td class='BorderInfDch' align='right'>
				<input name='iva' type='hidden' value='".$rowc['iva']."' />".$rowc['iva']." %
						</td>
						<td class='BorderInfDch' align='right'>
				<input name='ivae' type='hidden' value='".$rowc['ivae']."' />".$rowc['ivae']."
						</td>
						<td class='BorderInfDch' align='right'>
				<input name='pvp' type='hidden' value='".$rowc['pvp']."' />".$rowc['pvp']."
						</td>
						<td class='BorderInfDch' align='right'>
				<input name='stock' type='hidden' value='".$rowc['stock']."' />".$rowc['stock']."
						</td>
						<td class='BorderInfDch' align='right'>
				<input style='text-align:right' name='kgcash1' type='number' size='2' maxlength='2' value='".$defaults['kgcash1']."' />
				,
				<input name='kgcash2' type='number' size='2' maxlength='2' value='".$defaults['kgcash2']."' />
						</td>
						<td width='180px' class='BorderInfDch' align='left'>
				<input name='coment' type='hidden' value='".$rowc['coment']."' />".$rowc['coment']."
						</td>");
								
		$nstock = strlen(trim($rowc['stock']));
		$nstock = $nstock - 3;
		$stockx = $rowrc['stock'];
		$stock1 = substr($rowc['stock'],0,$nstock);
		$stock2 = substr($rowc['stock'],-2,2);

		print("<input name='stock1' type='hidden' value='".$stock1."' />
				<input name='stock2' type='hidden' value='".$stock2."' />");
					
/////////////////////	

		print("	<td align='center' class='BorderInfDch'>
					<div style='float:left;margin-right:3px'>
						<input type='submit' value='COMPRAR' />
						<input type='hidden' name='selec_pro' value=1 />
					</div>
			</form>
			<form name='ver' action='ProductosVerImg.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=440px,height=640px')\">
						<input name='seccion' type='hidden' value='".$_POST['seccion']."' />
						<input name='id' type='hidden' value='".$rowc['id']."' />
						<input name='valor' type='hidden' value='".$rowc['valor']."' />
						<input name='nombre' type='hidden' value='".$rowc['nombre']."' />
						<input name='ref' type='hidden' value='".$rowc['ref']."' />
					<div style='float:left;margin-right:3px'>
						<input type='submit' value='IMAGENES' />
						<input type='hidden' name='oculto2' value=1 />
					</div>
			</form>						
					</td>
				</tr>");
			}
		} /* Fin del while.*/ 

				print("</table>");
						
			} /* Fin segundo else anidado en if */
		
		} /* Fin de primer else . */
		
	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function modif_pro($errors=[]){
	
	global $db;
	
		$nkgcashx = strlen(trim($_POST['kgcashx']));
		$nkgcashx = $nkgcashx - 3;
		$kgcashx = $_POST['kgcashx'];
		global $kgcash1x;
		global $kgcash1x;
		$kgcash1x = substr($_POST['kgcashx'],0,$nkgcashx);
		$kgcash2x = substr($_POST['kgcashx'],-2,2);
			
		$nstock = strlen(trim($_POST['stock']));
		$nstock = $nstock - 3;
		$stockx = $_POST['stock'];
		$stock1 = substr($_POST['stock'],0,$nstock);
		$stock2 = substr($_POST['stock'],-2,2);

/////////////////////	

	$_SESSION['modif1e'] = $kgcash1x;
	$_SESSION['modif1d'] = $kgcash2x;
	
	unset ($_SESSION['modif2e']);
	unset ($_SESSION['modif2d']);

	
/////////////////////	

print ("* ".$_SESSION['modif1e'].",".$_SESSION['modif1d'].".");
	if($_POST['modif_pro']){
				$defaults = array ( 'kgcash1' => $kgcash1x,
									'kgcash2' => $kgcash2x,);
	}elseif($_POST['modif_pro2']){
				$defaults = array ( 'kgcash1' => $_SESSION['modif1e'],
									'kgcash2' => $_SESSION['modif1d'],);
	}

	if ($errors){
			
	print("<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font></br>* ".$_POST['proname'].".</br>");
		
	for($a=0; $c=count($errors), $a<$c; $a++){
		print("<font color='#F1BD2D'>* </font>".$errors [$a]."</br>");

			///////////////////

		$RefOperShop = $_SESSION['oper'];
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';}
		else{$tpro = $_POST['producto'];}
		global $LogTextcarro;
		$LogTextcarro = "	* MODIF PRO ERRORES =>\t
						* SESSION OPER ".$RefOperShop."\t
						* SECCION ".$_POST['seccion']."\t
					  	* PRODUCTO ".$_POST['proname']."\t	
					  	* ERRORS ".$errors [$a]."\n";
			}
		}

///////////////////////////

	global $secc;	
	$secc = "pro".$_POST['seccion'];
	$secc = "`".$secc."`";
	$fil = "%".$_POST['producto']."%";
 	$sqlc =  "SELECT * FROM $secc WHERE `valor` LIKE '$fil' ";
	$qc = mysqli_query($db, $sqlc);
	
///////////////////

	require "../config/TablesNames.php";
	$sqlx =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[seccion]'";
	$q = mysqli_query($db, $sqlx);
	$rowseccion = mysqli_fetch_assoc($q);
	$_sec = $rowseccion['nombre'];
	$producto = "pro".$_POST['seccion'];

	print ("<table align='center'>
				<tr style='font-size:14px'>
					<th colspan=12 class='BorderInf'>
						MODIFICARÁ EL PRODUCTO ".$_SESSION['oper']." 
					</th>
				</tr>
				<tr style='font-size:10px'>
					<th class='BorderInfDch'>REF CAJA</th>	
					<th class='BorderInfDch'>REF CLIENT</th>
					<th class='BorderInfDch'>OPER SESION</th>	
					<th class='BorderInfDch'>FECHA</th>	
					<th class='BorderInfDch'>SECCION</th>										
					<th class='BorderInfDch'>PRODUCTO</th>
					<th class='BorderInfDch'>STOCK</th>
					<th class='BorderInfDch'>CARRO</th>
					<th class='BorderInfDch'>IVA€</th>
					<th class='BorderInfDch'>PVP</th>
					<th class='BorderInfDch'>SUBT</th>
					<th class='BorderInf'></th>
				</tr>");
				
	$semana = date('W');
	$date = date('Y-m-d');
		
	print (	"<tr align='center'>
		<form name='modifica'  action='$_SERVER[PHP_SELF]' method='POST'>
			<input name='id' type='hidden' value='".$_POST['id']."' />
			<input name='cname' type='hidden' value='".$_POST['cname']."' />
			<input name='proname' type='hidden' value='".$_POST['proname']."' />
			<input name='psiva' type='hidden' value='".$_POST['psiva']."' />
			<input name='iva' type='hidden' value='".$_POST['iva']."' />
						<td class='BorderInfDch' align='left'>
			<input name='refcaja' type='hidden' value='".$_POST['refcaja']."' />".$_POST['refcaja']."
						</td>
						<td class='BorderInfDch' align='left'>
			<input name='refclient' type='hidden' value='".$_POST['refclient']."' />".$_POST['refclient']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='oper' type='hidden' value='".$_POST['oper']."' />".$_POST['oper']."
						</td>
			<input name='nsemana' type='hidden' value='".$_POST['nsemana']."' />
						<td class='BorderInfDch' align='right'>
			<input name='datecash' type='hidden' value='".$_POST['datecash']."' />".$_POST['datecash']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='vseccion' type='hidden' value='".$_POST['vseccion']."' />".$_POST['vseccion']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='producto' type='hidden' value='".$_POST['producto']."' />".$_POST['producto']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='stock' type='hidden' value='".$_POST['stock']."' />".$_POST['stock']."
			<input name='stock1' type='hidden' value='".$stock1."' />
			<input name='stock2' type='hidden' value='".$stock2."' />
			<input name='kgcashx' type='hidden' value='".$_POST['kgcashx']."' />
							</td>
						<td class='BorderInfDch' align='right' width='106px'>
			<input style='text-align:right' name='kgcash1' type='number' size='2' maxlength='2' value='".$defaults['kgcash1']."' />
			,
			<input name='kgcash2' type='number' size='2' maxlength='2' value='".$defaults['kgcash2']."' />
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='ivae' type='hidden' value='".$_POST['ivae']."' />".$_POST['ivae']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='pvp' type='hidden' value='".$_POST['pvp']."' />".$_POST['pvp']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='pvptot' type='hidden' value='".$_POST['pvptot']."' />".$_POST['pvptot']."
						</td>
					<td colspan=2 align='center' class='BorderInf'>
				<div style='float:left;margin-right:6px'>
			<input type='submit' value='MODIFICAR' />
			<input type='hidden' name='modif_pro2' value=1 />
				</div>
						</td>
				</form>
			</tr>");
					
				///////////////////

		$RefOperShop = $_SESSION['oper'];
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';}
		else{$tpro = $_POST['producto'];}
		global $LogTextcarro;
		$LogTextcarro = "	* MODIF PRO =>\t
						* SESSION OPER ".$RefOperShop."\t
						* REF CLIENTE ".$_POST['refclient']."\t
						* SECCION ".$_POST['vseccion']."\t
					  	* PRODUCTO ".$_POST['producto']."\t	
					  	* UNIT CAJA ".$_POST['kgcashx']."\t
					  	* PVP ".$_POST['pvp']."\t
					  	* PVPTOT ".$_POST['pvptot']."\n";

			print("</table>");
		
	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function modif_pro2(){
	
	global $db;		global $db_name;		global $secc;	
	
	$secc2 = ucwords($_POST['vseccion']);
	$secc = $_POST['vseccion'];
	$secc = "`".$secc."`";
	
	global $_sec;

	$producto = "pro".$_POST['seccion'];

/////////////////
	
	$semana = date('W');
	$date = date('Y-m-d');

	$kgcash1 = $_POST['kgcash1'];	
	$kgcash2 = $_POST['kgcash2'];
	global $kgcash;	
	$kgcash = $kgcash1.".".$kgcash2;

////////////////

	$_SESSION['modif2e'] = $_POST['kgcash1'];
	$_SESSION['modif2d'] = $_POST['kgcash2'];
	
	global $kgcashold;
	$kgcashold = $_SESSION['modif1e'].".".$_SESSION['modif1d'];
	$kgcashold = trim($kgcashold);
	
	if(($_SESSION['modif2e'] > $_SESSION['modif1e'])&&($_SESSION['modif2d'] > $_SESSION['modif1d'])){
		print("** MAS COMPRA QUE ANTES. ");
		global $mdf;
		$mdf = $kgcash - $kgcashold;
		print("* ".$kgcash." > ".$kgcashold." = ".$mdf."</br>");
	}elseif(($_SESSION['modif2e'] > $_SESSION['modif1e'])&&($_SESSION['modif2d'] < $_SESSION['modif1d'])){
		print("** MAS COMPRA QUE ANTES. ");
		global $mdf;
		$mdf = $kgcash - $kgcashold;
		print("* ".$kgcash." > ".$kgcashold." = ".$mdf."</br>");
	}elseif(($_SESSION['modif2e'] == $_SESSION['modif1e'])&&($_SESSION['modif2d'] > $_SESSION['modif1d'])){
		print("** MAS COMPRA QUE ANTES. ");
		global $mdf;
		$mdf = $kgcash - $kgcashold;
		print("* ".$kgcash." > ".$kgcashold." = ".$mdf."</br>");
	}elseif(($_SESSION['modif2e'] > $_SESSION['modif1e'])&&($_SESSION['modif2d'] == $_SESSION['modif1d'])){
		print("** MAS COMPRA QUE ANTES. ");
		global $mdf;
		$mdf = $kgcash - $kgcashold;
		print("* ".$kgcash." > ".$kgcashold." = ".$mdf."</br>");
	}elseif(($_SESSION['modif2e'] < $_SESSION['modif1e'])&&($_SESSION['modif2d'] < $_SESSION['modif1d'])){
		print("* MENOS COMPRA QUE ANTES. ");
		global $mdf;
		$mdf = $kgcash - $kgcashold;
		print("* ".$kgcash." < ".$kgcashold." = ".$mdf."</br>");
	}elseif(($_SESSION['modif2e'] < $_SESSION['modif1e'])&&($_SESSION['modif2d'] > $_SESSION['modif1d'])){
		print("* MENOS COMPRA QUE ANTES. ");
		global $mdf;
		$mdf = $kgcash - $kgcashold;
		print("* ".$kgcash." < ".$kgcashold." = ".$mdf."</br>");
	}elseif(($_SESSION['modif2e'] == $_SESSION['modif1e'])&&($_SESSION['modif2d'] < $_SESSION['modif1d'])){
		print("* MENOS COMPRA QUE ANTES. ");
		global $mdf;
		$mdf = $kgcash - $kgcashold;
		print("* ".$kgcash." < ".$kgcashold." = ".$mdf."</br>");
	}elseif(($_SESSION['modif2e'] < $_SESSION['modif1e'])&&($_SESSION['modif2d'] == $_SESSION['modif1d'])){
		print("* MENOS COMPRA QUE ANTES. ");
		global $mdf;
		$mdf = $kgcash - $kgcashold;
		print("* ".$kgcash." < ".$kgcashold." = ".$mdf."</br>");
	}
	
//////////////////////

	$CajaShop = $kgcash;
	$pvp = $_POST['pvp'];
	$pvptot = $CajaShop * $pvp;
	
	$_SESSION['pvptotold'] = $_POST['pvptot'];
	$pvptotold = $_SESSION['pvptotold'];
	$pvptotold = trim($pvptotold);
	
	$cuadrapvptot = $pvptot - $pvptotold;
	
	$ivaop = $_POST['iva'];
	$ivae = $_POST['psiva'] * ($ivaop / 100);
	$ivav = $ivae * $CajaShop;

/////////////////

	$tabla = "<table align='center' style='margin-top:10px'>
				<tr>
					<th colspan=2 class='BorderInf'>HA MODIFICADO EL PRODUCTO</th>
				</tr>
				<tr>
					<td>SECCION</td>
					<td>".$secc2."</td>
				</tr>
				<tr>
					<td>PRODUCT REF</td>
					<td>".$_POST['producto']."</td>
				</tr>				
				<tr>
					<td>PRODUCT NAME</td>
					<td>".$_POST['proname']."</td>
				</tr>				
				<tr>
					<td>UNIT VENTA</td>
					<td>".$kgcash."</td>
				</tr>
				<tr>
					<td>PVP SIN IVA</td>
					<td>".$_POST['psiva']." €</td>
				</tr>
				<tr>
					<td>TIPO IVA</td>
					<td>".$_POST['iva']." %</td>
				</tr>
				<tr>
					<td>IVA €</td>
					<td>".$ivav ." €</td>
				</tr>
				<tr>
					<td>UNIT € PVP</td>
					<td>".$_POST['pvp']." €</td>
				</tr>
				<tr>
					<td>CAJA TOT €</td>
					<td>".$pvptot." €</td>
				</tr>
			</table>";	/* Final de la variable*/ 
		
	$RefOperShop = $_SESSION['oper'];

	require "../config/TablesNames.php";

	$rc =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);
	$rowrc = mysqli_fetch_assoc($qrc);

	$sql = "UPDATE `$db_name`.$CajaShop SET `kgcash` = '$kgcash', `ivae` = '$ivav', `pvptot` = '$pvptot' WHERE `id` = '$_POST[id]' AND `oper` = '$RefOperShop'  LIMIT 1 ";
		
	if(mysqli_query($db, $sql)){ 
		
		print( $tabla );
								
		$RefOperShop = $_SESSION['oper'];
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';}
		else{$tpro = $_POST['producto'];}
		global $LogTextcarro1;
		$LogTextcarro1 = "	* MODIF PRO 2 =>\t
						* SESSION OPER ".$RefOperShop."\t
						* REF CLIENTE ".$_POST['refclient']."\t
						* SECCION ".$_POST['vseccion']."\t
					  	* PRODUCTO ".$_POST['producto']."\t	
					  	* UNIT CAJA ".$kgcash."\t
					  	* PVP ".$_POST['pvp']."\t
					  	* PVPTOT ".$pvptot."\n";

	}else{ print("* Error L2460. ".mysqli_error($db))."</br>"; }
	
/* SUMAN O RESTA COMPRA MODIFICADA A STOCKS */															

	global $refpro;
	$refpro = $_POST['producto']; /* ref pro */

	require "../config/TablesNames.php";

	$cs1 = "SELECT * FROM $Stocks WHERE `producto` = '$refpro' AND `stock` > 0 ";
	$qcs1 = mysqli_query($db, $cs1);
	$rowcs1 = mysqli_fetch_assoc($qcs1);
	
	if(mysqli_num_rows($qcs1) > 0){
	
/* SUMA O RESTA AL STOCK EL CARRO MODIFICADO */

	$cuadrastock = $rowcs1['kgcash'] + $mdf;
	$cuadrapvptot = $rowcs1['pvptot'] + $cuadrapvptot;
	$cuadrastock1 = $rowcs1['stock'] - $mdf;
	$coment = $rowcs1['coment']."</br>* Status: ".$rowcs1['kgcash']."+(".$rowcs1['kgbad']."+".$rowcs1['kgcash'].")=".$rowcs1['stock']."</br> Descontadas ".$mdf." Venta del stock.";

	require "../config/TablesNames.php";

	$cs2 = "UPDATE `$db_name`.$Stocks SET `kgcash` = '$cuadrastock', `stock` = '$cuadrastock1', `pvptot` = '$cuadrapvptot', `coment` = '$coment' WHERE $Stocks.`producto` = '$refpro' AND `stock` > 0  LIMIT 1 ";

	if(mysqli_query($db, $cs2)){
						
		print( "* MODIF PRO 2 ACTUALIZADO STOCK ".$seccx3." ".$Stocks."</br>" );
		global $LogTextcarro2;
		$LogTextcarro2 = "\t* MODIF PRO 2 ACTUALIZADO STOCK ".$seccx3." ".$Stocks.".\n";

	}else{ print("* Error L2503. ".mysqli_error($db)."</br>");
									}

/* ACTUALIZO TABLA DE PRODUCTOS */

	global $pvp;

	require "../config/TablesNames.php";

	$sqlc2 = "UPDATE `$db_name`.$Productos SET  `stock` = '$cuadrastock1' WHERE $Productos.`valor` = '$refpro' LIMIT 1 ";

	if(mysqli_query($db, $sqlc2)){
		print( "* MODIF PRO 2 ACTUALIZADO PRO STOCK ".$_POST['vseccion']." ".$Productos."</br>" );
		global $LogTextcarro3;
		$LogTextcarro3 = "\t* MODIF PRO 2 ACTUALIZADO PRO STOCK ".$_POST['vseccion']." ".$Productos.".\n";						
	}else{ print("* Error L2520. ".mysqli_error($db))."</br>"; }

/* ACTUALIZO TABLA FEEDBACK PRODUCTOS */

	require "../config/TablesNames.php";

	$sqlc3 = "UPDATE `$db_name`.$tablafeedpro3 SET `stock` = '$cuadrastock1' WHERE $tablafeedpro3.`valor` = '$refpro' LIMIT 1 ";

	if(mysqli_query($db, $sqlc3)){
		print( "* MODIF PRO 2 ACTUALIZADO FEED PRO STOCK ".$_POST['vseccion']." ".$tablafeedpro3."</br>" );
		global $LogTextcarro4;
		$LogTextcarro4 = "\t* MODIF PRO 2 ACTUALIZADO  FEED PRO STOCK ".$_POST['vseccion']." ".$tablafeedpro3.".\n";						
	}else{ print("* Error L2532. ".mysqli_error($db))."</br>"; }

}else{ print("");}

	global $LogTextcarro;		$LogTextcarro = $LogTextcarro1.$LogTextcarro2.$LogTextcarro3.$LogTextcarro4;

	}	/* FIN modifica_pro2() */	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function elim_pro(){
	
	global $db;
	
		$nkgcash = strlen(trim($_POST['kgcash']));
		$nkgcash = $nkgcash - 3;
		$kgcashx = $_POST['kgcash'];
		$kgcash1 = substr($_POST['kgcash'],0,$nkgcash);
		$kgcash2 = substr($_POST['kgcash'],-2,2);
		$kgcash = $kgcash1.",".$kgcash2;
		
///////////////////////////

	$fil = "%".$_POST['producto']."%";

	require "../config/TablesNames.php";
 	$sqlc =  "SELECT * FROM $secc WHERE `valor` LIKE '$fil' ";
	$qc = mysqli_query($db, $sqlc);
	
///////////////////

	$sqlx =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[seccion]'";
	$q = mysqli_query($db, $sqlx);
	$rowseccion = mysqli_fetch_assoc($q);
	$_sec = $rowseccion['nombre'];
	$producto = "pro".$_POST['seccion'];
	print ("<table align='center'>
				<tr style='font-size:14px'>
					<th colspan=12 class='BorderInf'>
						ELIMINARÁ EL PRODUCTO EN ".$_SESSION['oper']." 
					</th>
				</tr>
				<tr style='font-size:10px'>
				<th class='BorderInfDch'>REF CAJA</th>	
				<th class='BorderInfDch'>REF CLIENT</th>
				<th class='BorderInfDch'>OPER SESION</th>
				<th class='BorderInfDch'>FECHA</th>
				<th class='BorderInfDch'>SECCION</th>										
				<th class='BorderInfDch'>PRODUCTO</th>
				<th class='BorderInfDch'>CARRO</th>
				<th class='BorderInfDch'>IVA€</th>
				<th class='BorderInfDch'>PVP</th>
				<th class='BorderInfDch'>SUBT</th>
				<th class='BorderInf'></th>
			</tr>");
				
	$semana = date('W');
	$date = date('Y-m-d');
		
	print (	"<tr align='center'>
		<form name='modifica'  action='$_SERVER[PHP_SELF]' method='POST'>
			<input name='id' type='hidden' value='".$_POST['id']."' />
			<input name='cname' type='hidden' value='".$_POST['cname']."' />
			<input name='proname' type='hidden' value='".$_POST['proname']."' />
			<input name='psiva' type='hidden' value='".$_POST['psiva']."' />
			<input name='iva' type='hidden' value='".$_POST['iva']."' />
						<td class='BorderInfDch' align='left'>
			<input name='refcaja' type='hidden' value='".$_POST['refcaja']."' />".$_POST['refcaja']."
						</td>
						<td class='BorderInfDch' align='left'>
			<input name='refclient' type='hidden' value='".$_POST['refclient']."' />".$_POST['refclient']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='oper' type='hidden' value='".$_POST['oper']."' />".$_POST['oper']."
						</td>
			<input name='nsemana' type='hidden' value='".$_POST['nsemana']."' />
						<td class='BorderInfDch' align='right'>
			<input name='datecash' type='hidden' value='".$_POST['datecash']."' />".$_POST['datecash']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='vseccion' type='hidden' value='".$_POST['vseccion']."' />".$_POST['vseccion']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='producto' type='hidden' value='".$_POST['producto']."' />".$_POST['producto']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='kgcash1' type='hidden' value='".$_POST['kgcash']."' />".$_POST['kgcash']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='ivae' type='hidden' value='".$_POST['ivae']."' />".$_POST['ivae']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='pvp' type='hidden' value='".$_POST['pvp']."' />".$_POST['pvp']."
						</td>
						<td class='BorderInfDch' align='right'>
			<input name='pvptot' type='hidden' value='".$_POST['pvptot']."' />".$_POST['pvptot']."
						</td>
						<td colspan=2 align='center' class='BorderInf'>
							<div style='float:left;margin-right:6px'>
								<input type='submit' value='ELIMINAR PRODUCTO' />
								<input type='hidden' name='elim_pro2' value=1 />
							</div>
						</td>
				</form>
					</tr>");

			///////////////////

		$RefOperShop = $_SESSION['oper'];
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';}
		else{$tpro = $_POST['producto'];}
		global $LogTextcarro;
		$LogTextcarro = "	* ELIMINAR PRO 01 =>
						* SESSION OPER ".$RefOperShop."\t
						* REF CLIENTE ".$_POST['refclient']."\t
						* SECCION ".$_POST['vseccion']."\t
					  	* PRODUCTO ".$_POST['producto']."\t	
					  	* UNIT CAJA ".$_POST['kgcash']."\t
					  	* PVP ".$_POST['pvp']."\t
					  	* PVPTOT ".$_POST['pvptot']."\n";

		print("</table>");
		
	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function elim_pro2(){
	
	global $db;		global $db_name;		global $secc;	
	
	$secc2 = ucwords($_POST['vseccion']);
	$secc = $_POST['vseccion'];
	$secc = "`".$secc."`";
	
	global $_sec;

	$producto = "pro".$_POST['seccion'];

/////////////////
	
	$semana = date('W');
	$date = date('Y-m-d');

	$kgcash1 = $_POST['kgcash1'];	
	$kgcash2 = $_POST['kgcash2'];
	global $kgcash;	
	$kgcash = $kgcash1.".".$kgcash2;

	$CajaShop = $kgcash;
	$pvp = $_POST['pvp'];
	$pvptot = $CajaShop * $pvp ;
	
	$ivaop = $_POST['iva'];
	$ivae = $_POST['psiva'] * ($ivaop / 100);
	$ivav = $ivae * $CajaShop;

/////////////////

	$tabla = "<table align='center' style='margin-top:10px'>
				<tr>
					<th colspan=4 class='BorderInf'>HA ELIMINADO EL PRODUCTO</th>
				</tr>
				<tr>
					<td>SECCION</td>
					<td>".$secc2."</td>
					<td>PRODUCT REF</td>
					<td>".$_POST['producto']."</td>
				</tr>				
				<tr>
					<td>PRODUCT NAME</td>
					<td>".$_POST['proname']."</td>
					<td>UNIT VENTA</td>
					<td>".$kgcash."</td>
				</tr>
				<tr>
					<td>PVP SIN IVA</td>
					<td>".$_POST['psiva']." €</td>
					<td>TIPO IVA</td>
					<td>".$_POST['iva']." %</td>
				</tr>
				<tr>
					<td>IVA €</td>
					<td>".$ivav ." €</td>
					<td>UNIT € PVP</td>
					<td>".$_POST['pvp']." €/td>
				</tr>
				<tr>
					<td colspan='2'></td>
					<td>CAJA TOT €</td>
					<td>".$pvptot." €</td>
				</tr>
			</table>";	/* Final de la variable*/ 
		
	$RefOperShop = $_SESSION['oper'];

	require "../config/TablesNames.php";

	$rx =  "SELECT * FROM `$db_name`.$CajaShop WHERE `oper` = '$RefOperShop' AND `id` = '$_POST[id]'  LIMIT 1 ";
	$qrx = mysqli_query($db, $rx);
	$rowrx = mysqli_fetch_assoc($qrx);
		
if($rowrx['ini'] == 1){ 

	require "../config/TablesNames.php";

	$rx2 = "UPDATE `$db_name`.$CajaShop SET `ini` = '1' WHERE `oper` = '$RefOperShop' AND `ini` <> 1 LIMIT 1 ";

	if(mysqli_query($db, $rx2)){print("* INI OK.");}else{ }

	}else{ }

	require "../config/TablesNames.php";

	$rc =  "SELECT * FROM `$db_name`.$CajaShop WHERE `oper` = '$RefOperShop' ";
	$qrc = mysqli_query($db, $rc);
	$rowrc = mysqli_fetch_assoc($qrc);
		
	$sql = "DELETE FROM `$db_name`.$CajaShop  WHERE `id` = '$_POST[id]' AND `oper` = '$RefOperShop'  LIMIT 1 ";
		
	if(mysqli_query($db, $sql)){
		
		print( $tabla );

		$RefOperShop = $_SESSION['oper'];
		if($_POST['producto'] == ''){$tpro = 'TODOS LOS PRODUCTOS';}
		else{$tpro = $_POST['producto'];}
		global $LogTextcarro1;
		$LogTextcarro1 = "	* ELIMINAR PRO 02 =>
						* SESSION OPER ".$RefOperShop."\t
						* REF CLIENTE ".$_POST['refclient']."\t
						* SECCION ".$_POST['vseccion']."\t
					  	* PRODUCTO ".$_POST['producto']."\t	
					  	* UNIT CAJA ".$_POST['kgcash']."\t
					  	* PVP ".$_POST['pvp']."\t
					  	* PVPTOT ".$_POST['pvptot']."\n";

	}else{ print("* Error L2761. ".mysqli_error($db))."</br>"; }
	
/* SUMAN COMPRA CANCELADA A STOCKS	*/														

	global $db;			global $db_name;

	global $refpro;		$refpro = $_POST['producto']; /* ref pro */

	require "../config/TablesNames.php";
	
	$cs1 = "SELECT * FROM $Stocks WHERE `producto` = '$refpro' AND `stock` > 0 ";
	$qcs1 = mysqli_query($db, $cs1);
	$rowcs1 = mysqli_fetch_assoc($qcs1);
	
	if(mysqli_num_rows($qcs1) > 0){
	
/* SUMA AL STOCK AL CARRO CANCELADO */

	$cuadrastock = $rowcs1['kgcash'] - $kgcash;
	$cuadrapvptot = $rowcs1['pvptot'] - $_POST['pvptot'];
	$cuadrastock1 = $rowcs1['stock'] + $kgcash;
	$coment = $rowcs1['coment']."</br>* Status: ".$rowcs1['kgcash']."-(".$rowcs1['kgbad']."+".$rowcs1['kgcash'].")=".$rowcs1['stock']."</br> Descontadas ".$kgcash." Venta del stock.";

	require "../config/TablesNames.php";

	$cs2 = "UPDATE `$db_name`.$Stocks SET `kgcash` = '$cuadrastock', `stock` = '$cuadrastock1', `pvptot` = '$cuadrapvptot', `coment` = '$coment' WHERE $Stocks.`producto` = '$refpro' AND `stock` > 0  LIMIT 1 ";

	if(mysqli_query($db, $cs2)){
		print( "* ELIM PRO 2 ACTUALIZADO STOCK ".$seccx3." ".$Stocks." ".$cuadrastock1."</br>" );
		global $LogTextcarro2;
		$LogTextcarro2 = "\t* ELIM PRO 2 ACTUALIZADO STOCK ".$seccx3." ".$Stocks.".\n";
	}else{ print("* Error L2805. ".mysqli_error($db)."</br>"); }

/* ACTUALIZO TABLA DE PRODUCTOS */

	global $pvp;

	require "../config/TablesNames.php";

	$sqlc2 = "UPDATE `$db_name`.$Productos SET  `stock` = '$cuadrastock1' WHERE $Productos.`valor` = '$refpro' LIMIT 1 ";

	if(mysqli_query($db, $sqlc2)){
		print( "* ELIM PRO 2 ACTUALIZADO PRO STOCK ".$Productos." ".$cuadrastock1."</br>" );
		global $LogTextcarro3;
		$LogTextcarro3 = "\t* ELIM PRO 2 ACTUALIZADO PRO STOCK ".$Productos." ".$cuadrastock1.".\n";
	}else{ print("* Error L2819. ".mysqli_error($db))."</br>"; }

///////////// ACTUALIZO TABLA FEEDBACK PRODUCTOS ///////

	require "../config/TablesNames.php";

	$sqlc3 = "UPDATE `$db_name`.$tablafeedpro3 SET `stock` = '$cuadrastock1' WHERE $tablafeedpro3.`valor` = '$refpro' LIMIT 1 ";

		if(mysqli_query($db, $sqlc3)){
			print( "* ELIM PRO 2 ACTUALIZADO FEED PRO STOCK ".$tablafeedpro3." ".$cuadrastock1."</br>" );
			global $LogTextcarro4;
			$LogTextcarro4 = "\t* ELIM PRO 2 ACTUALIZADO FEED PRO STOCK ".$tablafeedpro3." ".$cuadrastock1.".\n";
		}else{ print("* Error L2831. ".mysqli_error($db))."</br>";}

	}else{print("");}
		
	global $LogTextcarro;		$LogTextcarro = $LogTextcarro1.$LogTextcarro2.$LogTextcarro3.$LogTextcarro4;
					
	}	/* FIN fntion elimina_pro2()  */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function show_form(){
	
	if (isset($_POST['init_compra']) || isset($_POST['recup_compra2']) || isset($_POST['cancel_compra']) || isset($_POST['cancel_compra2']) || isset($_POST['selec_pro']) || isset($_POST['subtotal']) || isset($_POST['modif_pro2']) || isset($_POST['modif_pro']) || isset($_POST['elim_pro']) || isset($_POST['elim_pro2']) || isset($_POST['oculto1']) || isset($_POST['oculto']) || isset($_POST['todocl']) || isset($_POST['show_formcl']) || isset($_POST['pago']) || isset($_POST['pago2']) || isset($_POST['pago3'])) {
		print("* CAJA SESION. ".$_SESSION['oper']);
	}
	
	print("<table align='center' style=\"border:0px;margin-top:4px\">
				<tr>
					<td>
						<div align='center' style='float:left;margin-right:6px'>
			<form name='init_compra' method='post' action='$_SERVER[PHP_SELF]'>
							<input type='submit' value='NUEVA COMPRA' />
							<input type='hidden' name='init_compra' value=1 />
			</form>	
						</div>	
						<div style='float:left;margin-right:6px'>
			<form name='recup_compra' method='post' action='$_SERVER[PHP_SELF]'>
							<input type='submit' value='RECUPERA COMPRA' />
							<input type='hidden' name='recup_compra' value=1 />
			</form>	
						</div>");
	
	if (isset($_POST['init_compra']) || isset($_POST['recup_compra2']) || isset($_POST['cancel_compra']) || isset($_POST['selec_pro']) || isset($_POST['subtotal']) || isset($_POST['modif_pro2']) || isset($_POST['modif_pro']) || isset($_POST['elim_pro']) || isset($_POST['elim_pro2']) || isset($_POST['oculto1']) || isset($_POST['oculto']) || isset($_POST['todocl']) || isset($_POST['show_formcl']) || isset($_POST['pago'])) {
	
	print("</div>	
						<div style='float:left;margin-right:6px'>
			<form name='cancel_compra' method='post' action='$_SERVER[PHP_SELF]'>
							<input type='submit' value='CANCEL COMPRA' />
							<input type='hidden' name='cancel_compra' value=1 />
			</form>	
						</div>
						<div style='float:left;margin-right:6px'>
			<form name='subtotal' method='post' action='$_SERVER[PHP_SELF]'>
							<input type='submit' value='SUBTOTAL' />
							<input type='hidden' name='subtotal' value=1 />
			</form>	
						</div>
					<td>
				</tr>");
		}
				
	print("	</table> ");
		
///////////////////
	
	global $Ordenar;	global $producto;	global $seccion;

	if(isset($_POST['seccion'])){ $seccion = $_POST['seccion'];
	}else{ $seccion = ""; }

	if(isset($_POST['oculto1'])){
				$defaults = $_POST;
				$defaults = array ('seccion' => $seccion,
								   'Orden' => $Ordenar,
								   'producto' => $producto,
								   );
		}elseif(isset($_POST['oculto'])){
				$defaults = $_POST;
		}else{
				$defaults = array ('seccion' => $seccion,
								   'Orden' => $Ordenar,
								   'producto' => $producto,
								   );
				}
										
//////////////////////////

	if (isset($_POST['init_compra']) || isset($_POST['recup_compra2']) || isset($_POST['cancel_compra']) || isset($_POST['selec_pro']) || isset($_POST['subtotal']) || isset($_POST['modif_pro2']) || isset($_POST['modif_pro']) || isset($_POST['elim_pro']) || isset($_POST['elim_pro2']) || isset($_POST['oculto1']) || isset($_POST['oculto']) || isset($_POST['todocl']) || isset($_POST['show_formcl']) || isset($_POST['pago'])) {

	global $db;		global $_sec;	global $seccion;
	
	if(isset($_POST['seccion'])){ $seccion = $_POST['seccion'];
	}else{ $seccion = ""; }
		
	require "../config/TablesNames.php";
	$sqlx =  "SELECT * FROM $Secciones WHERE `valor` = '$seccion'";
	$q = mysqli_query($db, $sqlx);
	$rowseccion = mysqli_fetch_assoc($q);
	
	$_sec = $rowseccion['nombre'];

	print("<table align='center' style=\"border:0px;margin-top:4px\">
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td>
					<div style='float:left'>
						<input type='submit' value='CONTINUE COMPRA' />
						<input type='hidden' name='oculto1' value=1 />
					</div>
					<div style='float:left'>
	<select name='seccion'>");

	require "../config/TablesNames.php";
	$sqlb =  "SELECT * FROM $Secciones ORDER BY `valor` ASC ";
	$qb = mysqli_query($db, $sqlb);
	
	if(!$qb){
			print("* Error L2943. ".mysqli_error($db)."</br>");
	} else {
		while($rows = mysqli_fetch_assoc($qb)){
				print ("<option value='".$rows['valor']."' ");
				if($rows['valor'] == $defaults['seccion']){	print ("selected = 'selected'"); }
										print ("> ".$rows['nombre']." </option>");
			}
	} 
		print ("</select>
						</div>
					</td>
				</tr>
				</form>	
			</table>");	
						
/////////////////////////

	if (isset($_POST['oculto1']) || isset($_POST['oculto'])) {
	if ($_POST['seccion'] == '') { 
			print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
					<tr align='center'>
						<td>
							<font color='red'><b>SELECCIONE SECCIÓN.</font>
						</td>
					</tr>
				</table>");
			}	
	if ($_POST['seccion'] != ''){
	print("<table align='center' style='border:0px;margin-top:4px'>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td>
					<div style='float:left'>
						<input type='submit' value='SELECCIONE PRODUCTO' />
						<input type='hidden' name='oculto' value=1 />
					</div>
						<input name='seccion' type='hidden' value='".$_POST['seccion']."' />
					<div style='float:left'>
			<select name='producto'>");
	global $db; 
	require "../config/TablesNames.php";
	$sqlp =  "SELECT * FROM $secc ORDER BY `valor` ASC ";
	$qp = mysqli_query($db, $sqlp);
	if(!$qp){
			print("* Error L2988. ".mysqli_error($db)."</br>");
	}else{
		while($rowp = mysqli_fetch_assoc($qp)){
					print ("<option value='".$rowp['valor']."' ");
					if($rowp['valor'] == $defaults['producto']){ print ("selected = 'selected'"); }
											print ("> ".$rowp['nombre']." </option>");
				}
			} 
	print ("</select>
					</div>
				</td>
			</tr>
		</table>				
			</form>"); 
				}
			}
		}	
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	global $db;		global $rowout; 	global $LogTextcarro;
	global $_sec; 	$secc = $_sec;	
	
	$ActionTime = date('H:i:s');

	
		global $LogText;
		$LogText = "\n- CAJA CARRO ".$ActionTime.".".$LogTextcarro;
		
		require 'logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){

		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $ClientesWeb;        $ClientesWeb = '';
	
		require '../Inclu_Menu/Master_Index.php';
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	require '../Inclu/Inclu_Footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
?>