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

if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')||($_SESSION['Nivel']=='user')||($_SESSION['Nivel']=='caja')||($_SESSION['Nivel']=='cliente')){
	master_index();
	require "../config/TablesNames.php";	
			
	global $db;		global $CajaShop;		
/*#1* ok*/	if(isset($_POST['init_compra'])){ init_compra();
											  show_form();
											  //subtotal();
											  recup_compra();
											  log_info();
/*#2* ok*/	}elseif(isset($_POST['oculto'])){ show_form();
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
							subtotal();	
							log_info();													
								}
/*#3* ok*/	}elseif(isset($_POST['modif_pro'])){ show_form();
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
/*#4* ok*/	}elseif(isset($_POST['elim_pro'])){ show_form();
												elim_pro();
										 		log_info();													
			}elseif(isset($_POST['elim_pro2'])){ show_form();
										  		 elim_pro2();
						$RefOperShop = $_SESSION['oper'];
						$SqlCajaShopOper =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
							$QrySqlCajaShopOper = mysqli_query($db, $SqlCajaShopOper);
							$CountSqlCajaShopOper = mysqli_num_rows($QrySqlCajaShopOper);
											if($CountSqlCajaShopOper > 0){ subtotal();	}
											log_info();
/*#5* ok*/	}elseif(isset($_POST['subtotal'])){ show_form();
						$RefOperShop = $_SESSION['oper'];
						$SqlCajaShopOper =  "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
							$QrySqlCajaShopOper = mysqli_query($db, $SqlCajaShopOper);
							$CountSqlCajaShopOper = mysqli_num_rows($QrySqlCajaShopOper);
											if($CountSqlCajaShopOper > 0){ subtotal();	}
										  		log_info();													
/*#6* ok*/	}elseif(isset($_POST['recup_compra'])){	show_form();
													recup_compra();
													log_info();													
			}elseif(isset($_POST['recup_compra2'])){ 
												$_SESSION['oper'] = $_POST['oper'];
												show_form();
												/*
												global $KeySubTotal;
												if($KeySubTotal==1){ }else{ subtotal(); }
												*/
												subtotal();
												log_info();													
/*#7* ok*/	}elseif(isset($_POST['cancel_compra'])){ show_form();
													 cancel_compra();
												 	 log_info();													
			}elseif(isset($_POST['cancel_compra2'])){ show_form();
													  cancel_compra2();	
													  fcancel_1();
													  fcancel_2();
													  log_info();													
/*#8* ok*/	}elseif((isset($_POST['modif_client']))){ show_form();
													  show_formcl();	
													  subtotal();
													  log_info();
			}elseif(isset($_POST['selec_client'])){	show_form();
													show_formcl();	
													subtotal();
													log_info();
			}elseif(isset($_POST['todocl'])){ show_form();							
											  //show_formcl();
											  ver_todocl();
											  log_info();													
			}elseif(isset($_POST['show_formcl'])){
					if($form_errors = validate_formcl()){
							show_form();
							show_formcl($form_errors);
							subtotal();
							log_info();													
					}else{	show_form();
							show_formcl();
							selec_client();
							subtotal();
							log_info();													
								}
			}elseif(isset($_POST['selec_client2'])){ selec_client2();
													 show_form();
													 global $KeySubTotal;
												if($KeySubTotal==1){ }else{ subtotal(); }
													 log_info();													
/*#9* ok*/	}elseif(isset($_POST['pago'])){	show_form();
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
			}elseif(isset($_POST['pago3'])){ show_form();
											 pago3();	
											 log_info();													
			}else{	show_form();
					if(isset($_GET['tienda'])){ recup_compra(); }
			}

		}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_pago2(){

	global $Count;	$Count = 0;
	if((isset($_POST['efectivo']))){ $Count = $Count+1; }else{ $Count = $Count; }
	if((isset($_POST['bizum']))){ $Count = $Count+1; }else{ $Count = $Count; }
	if((isset($_POST['tarjeta']))){ $Count = $Count+1; }else{ $Count = $Count; }
	if((isset($_POST['sinpagar']))){ $Count = $Count+1; }else{ $Count = $Count; }
	if((isset($_POST['invitacion']))){ $Count = $Count+1; }else{ $Count = $Count; }
	if((isset($_POST['personal']))){ $Count = $Count+1; }else{ $Count = $Count; }

	$errors = array();

	if($Count<1){ $errors [] = "SELECCIONE UNA FORMA DE PAGO";
	}elseif($Count>1){ $errors [] = "SELECCIONE SOLO UNA FORMA DE PAGO"; }

	return $errors;

} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function pago2($errors=[]){
	global $db;				global $db_name;
	require "../config/TablesNames.php";
	
	global $Count;	global $defaults;	global $LogText;
	if(isset($_POST['pago'])||($Count<1)){
			$defaults = array('efectivo' => '','bizum' => '','tarjeta' => '','sinpagar' => '',
								'invitacion' => '','personal' => '',);
	}elseif(isset($_POST['pago2'])||($Count>1)){
			$defaults = array( 'efectivo' => @$_POST['efectivo'],'bizum' => @$_POST['bizum'],
								'tarjeta' => @$_POST['tarjeta'],'sinpagar' => @$_POST['sinpagar'],
								'invitacion' => @$_POST['invitacion'],'personal' => @$_POST['personal'],);
	}else{ 	$defaults = array('efectivo' => '','bizum' => '','tarjeta' => '','sinpagar' => '',
								'invitacion' => '','personal' => '',);
			$LogText = $LogText."* PAGO 01 =>\t* SESSION OPER ".$_SESSION['oper']."\t\n";
				}

	global $LError;		$LError = "L.180";
	require 'SumarIvaTot.php';

    $QrySqlCajaShopOper1 = mysqli_query($db, $SqlCajaShopOper);
	$RowSqlCajaShopOper1 = mysqli_fetch_assoc($QrySqlCajaShopOper1);
	global $ProName;		$ProName =strtolower($RowSqlCajaShopOper1['proname']);
	global $ClientRef;		$ClientRef = $RowSqlCajaShopOper1['refclient'];

		global $ClientRef;
		if($ClientRef == ''){ 
			print("<table align='center'>
					<tr>
						<td class='BorderInf' style='color:#F1BD2D;'>
							HA DE SELECCIONAR UN CLIENTE
						</td>
					</tr>
					<tr>
						<td align='center'>
				<form name='selec_client' method='post' action='$_SERVER[PHP_SELF]'>
			<button type='submit' title='SELECCIONAR CLIENTE' class='botonazul imgButIco PersonsBlack'>
			</button>
					<input type='hidden' name='selec_client' value=1 />
				</form>
						</td>
					</tr>
				</table>");
			show_formcl();
		}else{
			print("<table align='center'>										
					<tr>
						<td align='center' colspan='7' class='BorderInf'>DATOS DEL CLIENTE</td>
					</tr>
					<tr>
						<th class='BorderInfDch'>REFERENCIA</th>
						<th class='BorderInfDch' colspan=2 >DESIGNACION</th>
						<th class='BorderInfDch' >DNI</th>
						<th class='BorderInfDch'>EMAIL</th>
						<th class='BorderInfDch'>DIRECCION</th>
						<th class='BorderInfDch'>TELEFONO</th>
					</tr>");				
		
			$QryClientRef = mysqli_query($db, $SqlCajaShopOper);
				$RowClientRef = mysqli_fetch_assoc($QryClientRef);
				$ClientRef = $RowClientRef['refclient'];

			$SqlClientesWebClientRef =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ";
				$QrySqlClientesWebClientesWeb = mysqli_query($db, $SqlClientesWebClientRef);
			if(mysqli_num_rows($QrySqlClientesWebClientesWeb) == 0){
				$SqlClientesWebClientRef =  "SELECT * FROM $Admin WHERE `ref` = '$ClientRef' ";
					$QrySqlClientesWebClientesWeb = mysqli_query($db, $SqlClientesWebClientRef);
			}else{ }
					$RowSqlClientesWebClientesWeb = mysqli_fetch_assoc($QrySqlClientesWebClientesWeb);
					$_SESSION['nclient'] = $RowSqlClientesWebClientesWeb['Nivel'];
			
			if($ClientRef != ''){
				if($_SESSION['nclient']=='cliente'){
					$dtcl =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' LIMIT 1 ";
						$qdtcl = mysqli_query($db, $dtcl);
				}elseif(($_SESSION['nclient']=='admin')||($_SESSION['nclient']=='plus')||($_SESSION['nclient']=='user')||($_SESSION['nclient']=='caja')){
					$dtcl =  "SELECT * FROM $Admin WHERE `ref` = '$ClientRef' LIMIT 1 ";
						$qdtcl = mysqli_query($db, $dtcl);
				}

					$rowdtcl = mysqli_fetch_assoc($qdtcl);

				if(($rowdtcl['Nivel']=='admin')||($rowdtcl['Nivel']=='plus')||($rowdtcl['Nivel']=='user')||($rowdtcl['Nivel']=='caja')){ $ruta = '../Admin/img_admin/';
				}elseif($rowdtcl['Nivel']=='cliente'){ $ruta = '../AdminClientesWeb/img_cliente/'; }

				print("<tr align='center'>
						<td class='BorderInfDch'>".$rowdtcl['ref']."</td>
						<td class='BorderInfDch'>".$rowdtcl['Nombre']." ".$rowdtcl['Apellidos']."</td>
						<td class='BorderInfDch'>
							<img src='".$ruta."".$rowdtcl['myimg']."' height='40px' width='30px' />
						</td>
						<td class='BorderInfDch'>".$rowdtcl['dni']."".$rowdtcl['ldni']."</td>
						<td class='BorderInfDch'>".$rowdtcl['Email']."</td>
						<td class='BorderInfDch'>".$rowdtcl['Direccion']."</td>
						<td class='BorderInfDch'>".$rowdtcl['Tlf1']." / ".$rowdtcl['Tlf2']."</td>
					</tr>");			
			} // FIN if($ClientRef != '')
		print("</table>");
		} // FIN ELSE

	global $LError;		$LError = "L.262";
	global $LogTextKey;	$LogTextKey = 1;
	require 'RowLogText.php';
	
	global $KeyErrors;	$KeyErrors = 1;
	require 'TableValidateErrors.php';

	global $ClientRef;
	if($ClientRef != ''){ 
		print("<table align='center' class='PrintNone'>
				<tr>
					<td align='center' colspan='6' style='color:#F1BD2D;'>
						FORMA DE PAGO
					</td>
				</tr>
				<tr>
					<td align='center'>
				<form name='pago2'  action='$_SERVER[PHP_SELF]' method='POST' display='inline-block;'>
					<input type='checkbox' id='efectivo' name='efectivo' value='efectivo' ");
					if($defaults['efectivo']=='efectivo'){ print(" checked='checked'"); }
		print("</td>
				<td>EFECTIVO</td>
				<td align='center'>
					<input type='checkbox' id='bizum' name='bizum' value='bizum' ");
					if($defaults['bizum']=='bizum'){ print(" checked='checked'"); }
		print("</td>
				<td>BIZUM</td>
				<td align='center'>
				<input type='checkbox' id='tarjeta' name='tarjeta' value='tarjeta' ");
				if($defaults['tarjeta']=='tarjeta'){ print(" checked='checked'"); }
		print("</td>
				<td> TARJETA</td>
			</tr>
			<tr>
				<td align='center'>
				<input type='checkbox' id='invitacion' name='invitacion' value='invitacion' ");
				if($defaults['invitacion']=='invitacion'){ print(" checked='checked'"); }
		print("</td>
				<td>INVITACION</td>
				<td align='center'>
					<input type='checkbox' id='sinpagar' name='sinpagar' value='sinpagar' ");
					if($defaults['sinpagar']=='sinpagar'){ print(" checked='checked'"); }
		print("</td>
				<td>SIN PAGAR</td>
				<td align='center'>
					<input type='checkbox' id='personal' name='personal' value='personal' ");
					if($defaults['personal']=='personal'){ print(" checked='checked'"); }
		print("</td>
				<td>PERSONAL</td>
					</tr>
				</table>");
	}else{ } // FIN if($ClientRef != '')
		print("<table align='center'>
				<tr>
					<th style='font-size:14px' colspan=10 class='BorderInf'>
						<div style='display:inline-block; margin-top: 0.4em;'>
							SUBTOTAL COMPRA ".$_SESSION['oper']."
						</div>

				<form action='' method='get' > 
					<input type='button' name='imprimir' title='IMPRIMIR COMPROBANTE' class='botonverde imgButIco PrintBlack' onClick='window.print();' style='display:inline-block; float:right !important;'>
				</form>
					</th>
				</tr>
				<tr style='font-size:10px'>
					<th class='BorderInfDch'>CAJERO</th>			
					<th class='BorderInfDch'>CLIENTE</th>
					<th class='BorderInfDch'>OPER SESION</th>			
					<th class='BorderInfDch'>FECHA</th>				
					<th class='BorderInfDch'>SECCION</th>										
					<th class='BorderInfDch'>PRODUCTO</th>
					<th class='BorderInfDch'>UNI</th>
					<th class='BorderInfDch'>IVA€</th>
					<th class='BorderInfDch'>PVP</th>
					<th class='BorderInfDch'>SUBTOT</th>
				</tr>");
									
		global $ClientRef;	global $ProName;
		while($RowSqlCajaShopOper = mysqli_fetch_assoc($QrySqlCajaShopOper)){
					$ProName =strtolower($RowSqlCajaShopOper['proname']);
					$ClientRef = $RowSqlCajaShopOper['refclient'];
			print (	"<tr align='center'>
						<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['refcaja']."</td>
						<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['refclient']."</td>
						<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['oper']."</td>
						<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['datecash']."</td>
						<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['vseccion']."</td>
						<td class='BorderInfDch' align='right'>".$ProName."</td>
						<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['kgcash']."</td>
						<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['ivae']."</td>
						<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['pvp']."</td>
						<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['pvptot']."</td>
				<input name='id' type='hidden' value='".$RowSqlCajaShopOper['id']."' />
				<input name='ini' type='hidden' value='".$RowSqlCajaShopOper['ini']."' />
				<input name='cname' type='hidden' value='".$RowSqlCajaShopOper['cname']."' />
				<input name='refcaja' type='hidden' value='".$RowSqlCajaShopOper['refcaja']."' />
				<input name='oper' type='hidden' value='".$RowSqlCajaShopOper['oper']."' />
				<input name='clname' type='hidden' value='".$RowSqlCajaShopOper['clname']."' />
				<input name='refclient' type='hidden' value='".$RowSqlCajaShopOper['refclient']."' />
				<input name='nsemana' type='hidden' value='".$RowSqlCajaShopOper['nsemana']."' />
				<input name='datecash' type='hidden' value='".$RowSqlCajaShopOper['datecash']."' />
				<input name='vseccion' type='hidden' value='".$RowSqlCajaShopOper['vseccion']."' />
				<input name='proname' type='hidden' value='".$RowSqlCajaShopOper['proname']."' />
				<input name='producto' type='hidden' value='".$RowSqlCajaShopOper['producto']."' />
				<input name='psiva' type='hidden' value='".$RowSqlCajaShopOper['psiva']."' />
				<input name='iva' type='hidden' value='".$RowSqlCajaShopOper['iva']."' />
				<input name='kgcash' type='hidden' value='".$RowSqlCajaShopOper['kgcash']."' />
				<input name='ivae' type='hidden' value='".$RowSqlCajaShopOper['ivae']."' />
				<input name='pvp' type='hidden' value='".$RowSqlCajaShopOper['pvp']."' />
				<input name='pvptot' type='hidden' value='".$RowSqlCajaShopOper['pvptot']."' />
					</tr>");
		} // FIN WHILE
			print("<tr>
					<td colspan='10' class='BorderInf'></td>
				</tr>
					<td colspan='3' class='BorderInf'></td>
					<td colspan='3' class='BorderInfDch' align='right'>TOTAL IVA ".$sumaivae." €</td>
					<td colspan='3' class='BorderInfDch' align='center'>TOTAL ".$sumapvptot." €</td>
					<td class='BorderInf'>");

	if($ClientRef != ''){ 
			print("<button type='submit' title='PAGAR & SALIR' class='botonverde imgButIco MoneyBlack'></button>
						<input type='hidden' name='pago2' value=1 />
				</form>
				<form name='subtotal' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block; float:left;'>
			<button type='submit' title='CONTINUAR COMPRA' class='botonnaranja imgButIco CarroBlack'></button>
						<input type='hidden' name='subtotal' value=1 />
				</form>");
	}
			print("</td></table>");
} // FIN pago2()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function pago3(){
	global $db;		global $db_name;
	global $dyt1;	$dyt1 = date('Y');
	require "../config/TablesNames.php";

	global $LError;		$LError = "L.393";
	require 'SumarIvaTot.php';

	global $LogText;
	if($_POST['producto']==''){ $LogText = $LogText.'TODOS LOS PRODUCTOS';
	}else{ $LogText = $LogText.$_POST['producto']; }

	global $LError;		$LError = "L.399";
	global $LogTextKey;	$LogTextKey = 2;
	require 'RowLogText.php';
		
	global $Pago;
	switch (true) {
		case (isset($_POST['efectivo'])): $Pago = strtolower($_POST['efectivo']);
			break;
		case (isset($_POST['bizum'])): $Pago = strtolower($_POST['bizum']);
			break;
		case (isset($_POST['tarjeta'])): $Pago = strtolower($_POST['tarjeta']);
			break;
		case (isset($_POST['sinpagar'])): $Pago = strtolower($_POST['sinpagar']);
			break;
		case (isset($_POST['invitacion'])): $Pago = strtolower($_POST['invitacion']);
			break;
		case (isset($_POST['personal'])): $Pago = strtolower($_POST['personal']);
			break;
		default: $Pago = ""; break;
	}

		print("<table align='center'>
				<tr>
					<td style='text-align:center; color:#F1BD2D;' >COMPRA PAGADA</td>
				</tr>
				<tr>
					<td style='text-align:center; color:#F1BD2D;' >FORMA DE PAGO ".strtoupper($Pago)."</td>
				</tr>");

		print ("<table align='center'>
					<tr>
						<th colspan=8 class='BorderInf'>
							COMPRA ".$_SESSION['oper']."
						</th>
						<th colspan=2 class='BorderInf' >
					<form action='' method='get' style='display:inline-block; float:right'> 
						<input type='button' name='imprimir' title='IMPRIMIR COMPROBANTE' class='botonverde imgButIco PrintBlack' onClick='window.print();'>
					</form>
							<a href='ClienteVer.php' style='display:inline-block; float:right;'>
					<button type='button' title='INICIO CLIENTE' class='botonazul imgButIco InicioBlack' style='vertical-align:top;' ></button>
							</a>
						</th>
					</tr>
					<tr style='font-size:10px'>
						<th class='BorderInfDch'>CAJERO</th>			
						<th class='BorderInfDch'>CLIENTE</th>
						<th class='BorderInfDch'>OPER SESION</th>		
						<th class='BorderInfDch'>FECHA</th>				
						<th class='BorderInfDch'>SECCION</th>										
						<th class='BorderInfDch'>PRODUCTO</th>
						<th class='BorderInfDch'>UNI</th>
						<th class='BorderInfDch'>IVA€</th>
						<th class='BorderInfDch'>PVP</th>
						<th class='BorderInfDch'>SUBTOT</th>
					</tr>");
									
	global $ClientRef; global $ProName;

	while($RowSqlCajaShopOper = mysqli_fetch_assoc($QrySqlCajaShopOper)){
		$ProName =strtolower($RowSqlCajaShopOper['proname']);
		$ClientRef = $RowSqlCajaShopOper['refclient'];
	
		print("<tr align='center'>
				<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['refcaja']."</td>
				<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['refclient']."</td>
				<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['oper']."</td>
				<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['datecash']."</td>
				<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['vseccion']."</td>
				<td class='BorderInfDch' align='right'>".$ProName."</td>
				<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['kgcash']."</td>
				<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['ivae']."</td>
				<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['pvp']."</td>
				<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['pvptot']."</td>
				</tr>");
		} // FIN WHILE
						
		print("<tr>
					<td colspan='10' class='BorderInf'></td>
				</tr>
				<tr>
					<td colspan='4'></td>
					<td colspan='3' class='BorderDch' align='right'>TOTAL IVA".$sumaivae." €</td>
					<td colspan='3' align='center'>TOTAL ".$sumapvptot." €	</td>
				</tr>
			</table>");

	global $semana;		$semana = date('W');	
	global $date;		$date = date('Y-m-d');
	global $ATime;		$ATime = date('H:i:s');
	global $datecash;	$datecash = $date."/".$ATime;

		$QrySqlCajaShopOper2 = mysqli_query($db, $SqlCajaShopOper);
		$CountSqlCajaShopOper2 = mysqli_num_rows($QrySqlCajaShopOper2);
	
	global $KeyFor;
	for($i=0; $i<$CountSqlCajaShopOper2; $i++){
		$RowSqlCajaShopOper2 = mysqli_fetch_assoc($QrySqlCajaShopOper2);
		$SqlInsertVentasShop = "INSERT INTO `$db_name`.$VentasShop (`ini`, `cname`, `refcaja`, `clname`, `refclient`, `oper`, `nsemana`, `datecash`, `vseccion`, `producto`, `proname`, `kgcash`, `psiva`, `iva`, `ivae`, `pvp`, `pvptot`, `pago`, `coment` ) VALUES ('$RowSqlCajaShopOper2[ini]', '$RowSqlCajaShopOper2[cname]', '$RowSqlCajaShopOper2[refcaja]', '$RowSqlCajaShopOper2[clname]', '$RowSqlCajaShopOper2[refclient]',  '$RowSqlCajaShopOper2[oper]', '$RowSqlCajaShopOper2[nsemana]', '$datecash', '$RowSqlCajaShopOper2[vseccion]', '$RowSqlCajaShopOper2[producto]', '$RowSqlCajaShopOper2[proname]', '$RowSqlCajaShopOper2[kgcash]', '$RowSqlCajaShopOper2[psiva]', '$RowSqlCajaShopOper2[iva]', '$RowSqlCajaShopOper2[ivae]', '$RowSqlCajaShopOper2[pvp]', '$RowSqlCajaShopOper2[pvptot]', '$Pago', '$RowSqlCajaShopOper2[coment]')";
		if(mysqli_query($db, $SqlInsertVentasShop)){ 
			$KeyFor = 0;
		}else{ 
			$KeyFor = 1;
			print("* ERROR SQL L.501 ".mysqli_error($db)."<br>"); 
		}
	} /* FIN DEL FOR */

	if($KeyFor<1){
		$SqlDeleteCajaShop =  "DELETE FROM `$db_name`.$CajaShop WHERE `oper` = '$RefOperShop' ";
		if(mysqli_query($db, $SqlDeleteCajaShop)){ 
			//print("* COMPRA PAGADA<br>");
			global $RedirUrl;	$RedirUrl = "ClienteVer.php";
			global $RedirTime;	$RedirTime = 120000;
			require '../Inclu/AutoRedirUrl.php';
			global $Redir;      print ($Redir);
		}else{ 
			print("* ERROR SQL L.557 ".mysqli_error($db)."<br>");
		}	

	}else{
		print("* NO SE HAN BORRADO LOS REGISTROS EN ".$CajaShop."<br> * ERROR SQL L.557 ".mysqli_error($db)."<br>");
	}

} // FIN pago3()
										
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_formcl($errors=[]){
	// MUESTRA EL FORMULARIO DE SELECCION DE CLIENTE PARA UNA COMPRA
	global $db;		global $db_name;
	require "../config/TablesNames.php";
	
	global $k;
	if(isset($_POST['modif_client'])){ $_SESSION['KeyCreaCliente'] = 1; }else{ $_SESSION['KeyCreaCliente'] = 0; }
	//echo "** KeyCreaCliente = ".$_SESSION['KeyCreaCliente']."<br>";
	/* SE PASAN LOS VALORES POR DEFECTO Y SE DEVUELVEN LOS QUE HA ESCRITO EL USUARIO */
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }
	
	global $Ordenar;	global $defaults;
	if((isset($_POST['selec_client']))||(isset($_POST['init_compra']))||(isset($_POST['recup_compra']))||(isset($_POST['recup_compra2']))){ 
			$defaults = array ('Nombre' => '',
								'barra01' => '','barra02' => '',
								'sala01' => '','sala02' => '',
								'terraza01' => '','terraza02' => '',
								'Orden' => '',
								'cnivela' => '','cnivel' => '',);
	}elseif(isset($_POST['show_formcl'])){
			$defaults = array ('Nombre' => $_POST['Nombre'],
								'barra01' => $_POST['barra01'],'barra02' => $_POST['barra02'],
								'sala01' => $_POST['sala01'],'sala02' => $_POST['sala02'],
								'terraza01' => $_POST['terraza01'],'terraza02' => $_POST['terraza02'],
								'Orden' =>  '',
								'cnivela' => @$_POST['cnivela'],'cnivel' => '');
	}elseif(isset($_POST['todocl'])){ 
			$defaults = array ('Nombre' => '',
								'barra01' => '','barra02' => '',
								'sala01' => '','sala02' => '',
								'terraza01' => '','terraza02' => '',
								'Orden' =>  $Orden,
								'cnivela' => '','cnivel' => @$_POST['cnivel']);
	}else{	$defaults = array ('Nombre' => '',
								'barra01' => '','barra02' => '',
								'sala01' => '','sala02' => '',
								'terraza01' => '','terraza02' => '',
								'Orden' => $Orden,
								'cnivela' => '','cnivel' => '',);
				}

	$Ordenar = array ('`id` ASC' => 'ID ASC','`id` DESC' => 'ID DSC',
					 '`Nombre` ASC' => 'Nombre ASC','`Nombre` DESC' => 'Nombre DSC',
					 '`Apellidos` ASC' => 'Apellido ASC','`Apellido` DESC' => 'Apellido DSC',);

	require 'TableValidateErrors.php';
	
	if($_SESSION['Nivel']=='cliente'){

	}else{
		print("<table align='center' style='border:0px;margin-top:4px;width:max-content;'>
					<tr>
						<th colspan=2 class='BorderSup'>
							SELECCIONE CLIENTE<br>COMPRA: ".$_SESSION['oper']."
						</th>
					</tr>
					<tr>
						<td style='text-align:right;'>
				<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
						<input type='checkbox' name='cnivela' value='yes' ");
						if($defaults['cnivela']=='yes'){ print(" checked='checked'"); }
				print(" />
						</td>
						<td>BUSCAR EN ADMINISTRADORES</td>
					</tr>
					<tr>
						<td style='text-align:right; vertical-align: top !important;'>
				<button type='submit' title='CONSULTAR CLIENTES' class='botonazul imgButIco BuscaBlack'></button>
							<input type='hidden' name='show_formcl' value=1 />
						</td>
						<td>
							<div style='float:left'>
						<select name='barra01' style='min-width: 142px; margin: 0.1em !important;' class='botonverde'>
								<option value=''>BARRA 01</option>");
				// CONSTRUYE EL SELECT DE CLIENTES BARRA 01
				$SqlB01 =  "SELECT * FROM $ClientesWeb WHERE `Nombre` LIKE 'barra01%' ORDER BY `ref` ASC ";
					$qSqlB01 = mysqli_query($db, $SqlB01);
					if(!$qSqlB01){ print("* ERROR SQL L.643 ".mysqli_error($db)."</br>");
					}else{ while($rowsb1 = mysqli_fetch_assoc($qSqlB01)){
									print ("<option value='".$rowsb1['ref']."' ");
									if($rowsb1['ref'] == $defaults['barra01']){
														print ("selected = 'selected'");
												}
							print (">".ucfirst($rowsb1['Nombre'])." ".ucfirst($rowsb1['Apellidos'])."</option>");
								}
					} 
					print ("</select></div>
						<div style='float:left'>
					<select name='barra02' style='min-width: 142px; margin: 0.1em !important;' class='botonverde' >
								<option value=''>BARRA 02</option>");
				// CONSTRUYE EL SELECT DE CLIENTES BARRA 02
				$SqlB02 =  "SELECT * FROM $ClientesWeb WHERE `Nombre` LIKE 'barra02%' ORDER BY `ref` ASC ";
					$qSqlB02 = mysqli_query($db, $SqlB02);
						if(!$qSqlB02){ print("* ERROR SQL L.659 ".mysqli_error($db)."</br>");
						}else{ while($rowsb2 = mysqli_fetch_assoc($qSqlB02)){
										print ("<option value='".$rowsb2['ref']."' ");
										if($rowsb2['ref'] == $defaults['barra02']){
															print ("selected = 'selected'");
												}
								print (">".ucfirst($rowsb2['Nombre'])." ".ucfirst($rowsb2['Apellidos'])."</option>");
									}
								} 
						print ("</select></div>
									<div style='clear:both'></div>
							<div style='float:left'>
					<select name='sala01' style='min-width: 142px; margin: 0.1em !important;' class='botonnaranja' >
								<option value=''>SALA 01</option>");
				// CONSTRUYE EL SELECT DE CLIENTES SALA 01
				$SqlS01 =  "SELECT * FROM $ClientesWeb WHERE `Nombre` LIKE 'sala01%' ORDER BY `ref` ASC ";
					$qSqlS01 = mysqli_query($db, $SqlS01);
						if(!$qSqlS01){ print("* ERROR SQL L.676 ".mysqli_error($db)."</br>");
						}else{ while($rowss1 = mysqli_fetch_assoc($qSqlS01)){
										print ("<option value='".$rowss1['ref']."' ");
										if($rowss1['ref'] == $defaults['sala01']){
															print ("selected = 'selected'");
												}
								print (">".ucfirst($rowss1['Nombre'])." ".ucfirst($rowss1['Apellidos'])."</option>");
									}
								} 
						print ("</select></div>
							<div style='float:left'>
					<select name='sala02' style='min-width: 142px; margin: 0.1em !important;' class='botonnaranja' >
								<option value=''>SALA 02</option>");
				// CONSTRUYE EL SELECT DE CLIENTES SALA 02
				$SqlS02 =  "SELECT * FROM $ClientesWeb WHERE `Nombre` LIKE 'sala02%' ORDER BY `ref` ASC ";
					$qSqlS02 = mysqli_query($db, $SqlS02);
						if(!$qSqlS02){ print("* ERROR SQL L.692 ".mysqli_error($db)."</br>");
						}else{ while($rowss2 = mysqli_fetch_assoc($qSqlS02)){
										print ("<option value='".$rowss2['ref']."' ");
										if($rowss2['ref'] == $defaults['sala02']){
															print ("selected = 'selected'");
												}
								print (">".ucfirst($rowss2['Nombre'])." ".ucfirst($rowss2['Apellidos'])."</option>");
									}
								} 
						print ("</select></div>
									<div style='clear:both'></div>
							<div style='float:left'>
						<select name='terraza01' style='min-width: 142px; margin: 0.1em !important;' class='botonverde' >
								<option value=''>TERRAZA 01</option>");
				// CONSTRUYE EL SELECT DE CLIENTES TERRAZA 01
				$SqlT01 =  "SELECT * FROM $ClientesWeb WHERE `Nombre` LIKE 'terraza01%' ORDER BY `ref` ASC ";
					$qSqlT01 = mysqli_query($db, $SqlT01);
						if(!$qSqlT01){ print("* ERROR SQL L.709 ".mysqli_error($db)."</br>");
						}else{ while($rowst1 = mysqli_fetch_assoc($qSqlT01)){
										print ("<option value='".$rowst1['ref']."' ");
										if($rowst1['ref'] == $defaults['terraza01']){
															print ("selected = 'selected'");
												}
								print (">".ucfirst($rowst1['Nombre'])." ".ucfirst($rowst1['Apellidos'])."</option>");
									}
								} 
						print ("</select></div>
							<div style='float:left'>
						<select name='terraza02' style='min-width: 142px; margin: 0.1em !important;' class='botonverde' >
								<option value=''>TERRAZA 02</option>");
				// CONSTRUYE EL SELECT DE CLIENTES TERRAZA 02
				$SqlT02 =  "SELECT * FROM $ClientesWeb WHERE `Nombre` LIKE 'terraza02%' ORDER BY `ref` ASC ";
					$qSqlT02 = mysqli_query($db, $SqlT02);
						if(!$qSqlT02){ print("* ERROR SQL L.725 ".mysqli_error($db)."</br>");
						}else{ while($rowst2 = mysqli_fetch_assoc($qSqlT02)){
										print ("<option value='".$rowst2['ref']."' ");
										if($rowst2['ref'] == $defaults['terraza02']){
															print ("selected = 'selected'");
												}
								print (">".ucfirst($rowst2['Nombre'])." ".ucfirst($rowst2['Apellidos'])."</option>");
									}
								} 
						print ("</select></div>
						</td>
					</tr>
					<tr>
						<td class='BorderInf'></td>
						<td class='BorderInf'>
				<input type='text' name='Nombre' size=20 maxlength=10 value='".$defaults['Nombre']."' placeholder='NOMBRE' />
					</form>
						</td>
					</tr>
					<tr>
				<!-- *** INICIO CONSULTAR TODOS LOS CLIENTES
					<tr>
						<td align='center'>
					<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
							<input type='submit' value='TODOS LOS CLIENTES' />
							<input type='hidden' name='todocl' value=1 />
						</td>
						<td>ORDENAR POR
							<select name='Orden'>");
				// CONSTRUYE EL SELECT DE ORDENAR DATOS
				/*
				foreach($Ordenar as $option => $label){
					print ("<option value='".$option."' ");
						if($option == $defaults['Orden']){ print ("selected = 'selected'"); }
								print ("> $label </option>");
					}
				*/
		print("</select>
						</td>
					</tr>
					<tr>
						<td align='right'>
						<input type='checkbox' name='cnivel' value='yes' ");
						//if($defaults['cnivel']=='yes') {print(" checked=\"checked\"");}
				print(" />
						</td>
						<td>BUSCAR EN ADMINISTRADORES</td>
					</form></tr> 
				*** FIN OCULTAR VER TODOS LOS CLIENTES --> 
					</table>");

	} // ELSE NIVEL USUARIO NO ES CLIENTE

	// DATOS LOG			
	global $LogText;
	$LogText = $LogText."* CONSLUTAR CLIENTE =>\t* SESSION OPER ".$_SESSION['oper']."\t\t\t";
	switch (true) {
		case (isset($_POST['todocl'])): $LogText = $LogText.'TODOS LOS CLIENTES';
			break;
		case ($defaults['Nombre'] != ''): $LogText = $LogText."* REF CLIENTE ".$defaults['Nombre']."\t\t\t";
			break;
		case ($defaults['barra01']==''): $LogText = $LogText."* SECCION ".$defaults['barra01']."\t\t\t";
			break;
		case ($defaults['barra02']==''): $LogText = $LogText."* SECCION ".$defaults['barra02']."\t\t\t";
			break;
		case ($defaults['sala01']==''): $LogText = $LogText."* SECCION ".$defaults['sala01']."\t\t\t";
			break;
		case ($defaults['sala02']==''): $LogText = $LogText."* SECCION ".$defaults['sala02']."\t\t\t";
			break;
		case ($defaults['terraza01']==''): $LogText = $LogText."* SECCION ".$defaults['terraza01']."\t\t\t";
			break;
		case ($defaults['terraza02']==''): $LogText = $LogText."* SECCION ".$defaults['terraza02']."\t\t\t";
			break;
		default: $LogText = $LogText."";
			break;
	}
	
} // FIN function show_formcl

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_formcl(){
		// VALIDA EL FORMULARIO DE show_formcl($errors=[])
		global $db;		global $db_name;
		require '../config/TablesNames.php';

		global $CountInput; $CountInput = 0;		global $SqlText; $SqlText = "";		global $SqlRefClient;
		if($_POST['barra01'] != ''){ $CountInput = $CountInput + 1;	$SqlRefClient = $_POST['barra01'];
									 $SqlText = " WHERE `refclient` = '$SqlRefClient' "; }else{ }
		if($_POST['barra02'] != ''){ $CountInput = $CountInput + 1;	$SqlRefClient = $_POST['barra02'];
									 $SqlText = " WHERE `refclient` = '$SqlRefClient' "; }else{ }
		if($_POST['sala01'] != ''){ $CountInput = $CountInput + 1;	$SqlRefClient = $_POST['sala01'];
									$SqlText = " WHERE `refclient` = '$SqlRefClient' "; }else{ }
		if($_POST['sala02'] != ''){ $CountInput = $CountInput + 1;	$SqlRefClient = $_POST['sala02'];
									$SqlText = " WHERE `refclient` = '$SqlRefClient' "; }else{ }
		if($_POST['terraza01'] != ''){ $CountInput = $CountInput + 1;	$SqlRefClient = $_POST['terraza01'];
									   $SqlText = " WHERE `refclient` = '$SqlRefClient' "; }else{ }
		if($_POST['terraza02'] != ''){ $CountInput = $CountInput + 1;	$SqlRefClient = $_POST['terraza02'];
									   $SqlText = " WHERE `refclient` = '$SqlRefClient' "; }else{ }
		global $CountCajaShop;
		if($CountInput<1){ $SqlCajaShop = "";
		}else{
			$SqlCajaShop = "SELECT * FROM $CajaShop $SqlText ";
			//echo "<br><br><br>** ".$SqlCajaShop."<br>";
				$QrCajaShop = mysqli_query($db, $SqlCajaShop);
				$RowCajaShop = mysqli_fetch_array($QrCajaShop);
				$CountCajaShop = mysqli_num_rows($QrCajaShop);
			//echo "** \$_SESSION['KeyCreaCliente'] = ".$_SESSION['KeyCreaCliente']." & \$CountCajaShop = ".$CountCajaShop."<br>";
		}
		
		$errors = array();

		if((strlen(trim($_POST['Nombre'])) == 0)&&($_POST['barra01']=='')&&($_POST['barra02']=='')&&($_POST['sala01']=='')&&($_POST['sala02']=='')&&($_POST['terraza01']=='')&&($_POST['terraza02']=='')){
			$errors [] = " UNO DE LOS CAMPOS ES OBLIGATORIO";
		}elseif($CountInput > 1){
			$errors [] = " SÓLO UNA ZONA DEL LOCAL";
		}elseif(($CountCajaShop >= 1)&&($_SESSION['KeyCreaCliente']<1)){
			$errors [] = " YA EXISTE UNA CUENTA ABIERTA PARA ESTE CLIENTE";
			$errors [] = " CLIENTE ".ucfirst($SqlRefClient)." CUENTA ".$RowCajaShop['oper'];
		}

		return $errors;

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function selec_client(){
	// PROCESA EL FORMULARIO DE function show_formcl($errors=[])
	// SELECCIONA UN CLIENTE EN LA TABLA CLIENTES O ADMIN Y MUESTRA LA TABLA
	global $db;			global $db_name;
	require "../config/TablesNames.php";
	
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }

	global $ZonLocValue;	global $CountZonLoc;	$CountZonLoc = 1;
	switch (true) {
		case (strlen(trim($_POST['barra01']))>0): $ZonLocValue = $_POST['barra01'];
			break;
		case (strlen(trim($_POST['barra02']))>0): $ZonLocValue = $_POST['barra02'];
			break;
		case (strlen(trim($_POST['sala01']))>0): $ZonLocValue = $_POST['sala01'];
			break;
		case (strlen(trim($_POST['sala02']))>0): $ZonLocValue = $_POST['sala02']; 
			break;
		case (strlen(trim($_POST['terraza01']))>0): $ZonLocValue = $_POST['terraza01'];
			break;
		case (strlen(trim($_POST['terraza02']))>0): $ZonLocValue = $_POST['terraza02'];
			break;
		default: $ZonLocValue = ''; $CountZonLoc = 0;
			break;
	}

	global $CountNomPost;	$CountNomPost = trim(str_replace(' ', '', $_POST['Nombre']));
							$CountNomPost = strlen(trim($CountNomPost));
	global $NomSql;	global $ZonLocSql;	global $OperSql;	global $LogText;

	if($CountZonLoc < 1){ $ZonLocSql = "";	$LogText = $LogText.'';
	}else{ 	$ZonLocSql = " `ref` LIKE '%".$ZonLocValue."%' "; 
			$LogText = $LogText."* ZONA DEL LOCAL ".strtoupper($ZonLocValue)."\n\t\t\t\t\t\t";
		}
	
	if($CountNomPost < 1){ $NomSql = "";	$OperSql = "";	$LogText = $LogText.'';	
	}else{ 	$NomSql = "(`Nombre` LIKE '%".$_POST['Nombre']."%' OR `Apellidos` LIKE '%".$_POST['Nombre']."%') "; 
			$LogText = $LogText."* NOMBRE ".$_POST['Nombre']."\n\t\t\t\t\t\t";
		}

	// ASIGNA UNA CONSULTA SQL
	global $a;
	switch (true) {
		case (($CountNomPost < 1)&&($CountZonLoc < 1)): $a = "";
			break;
		case (($CountNomPost > 0)&&($CountZonLoc < 1)): $a = "WHERE $NomSql";
			break;
		case (($CountNomPost > 0)&&($CountZonLoc > 0)): $a = "WHERE ($NomSql $OperSql OR $ZonLocSql)";
														$OperSql = " OR "; 
			break;
		case (($CountNomPost < 1)&&($CountZonLoc > 0)): $a = "WHERE $ZonLocSql";
			break;
		default: $a = "";
			break;
	}

	if(!isset($_POST['cnivela'])){
		$sqlb =  "SELECT * FROM $ClientesWeb $a ORDER BY `Nombre` ASC  ";
			//echo "* L.914 NO ADMIN: ".$sqlb."<br>";
		$LogText = $LogText."* CONSULTA CLIENTE TABLA CLIENTES =>\t* SESSION OPER ".$_SESSION['oper']."\n\t\t\t\t\t\t";
	}elseif(strlen($_POST['cnivela']) != 0){
		$sqlb =  "SELECT * FROM $Admin $a ORDER BY `Nombre` ASC ";
			//echo "* 1054 SI ADMIN: ".$sqlb."<br>";
		$LogText = $LogText."* CONSULTA CLIENTE TABLA ADMIN =>\t* SESSION OPER ".$_SESSION['oper']."\n\t\t\t\t\t\t";
	} // FIN ELSE

		$qb = mysqli_query($db, $sqlb);
	if(!$qb){ print("* ERROR SQL L.914/918 ".mysqli_error($db)."</br>");
	}else{	if(mysqli_num_rows($qb)== 0){
				print("<table align='center' style=\"border:0px\">
							<tr>
								<td align='center' style='color:#F1BD2D;'>NO HAY DATOS</td>
							</tr>
						</table>");
		}else{ require 'TablaSelectCliente.php'; } // FIN ELSE

			} // FIN ELSE QUERY
	} // FIN function selec_cliente()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function selec_client2(){
	// PROCESA EL FORMULARIO DE function selec_client() Y SELECCIONA AL CLIENTE
	global $db;		global $db_name;	
	require "../config/TablesNames.php";

	global $ruta;
	if(($_POST['Nivel']=='admin')||($_POST['Nivel']=='plus')||($_POST['Nivel']=='user')||($_POST['Nivel']=='caja')){ $ruta = '../Admin/img_admin/'; }
	if($_POST['Nivel']=='cliente'){ $ruta = '../AdminClientesWeb/img_cliente/'; }

	$_SESSION['nclient'] = $_POST['Nivel'];
	global $tabla;
	$tabla = "<table align='center' style='margin-top:10px'>
				<tr>
					<th colspan=6 class='BorderInf' >HA SELECCIONADO</th>
				<tr>
					<th class='BorderInfDch'>ID</th>
					<th class='BorderInfDch'>REFERENCIA</th>
					<th class='BorderInfDch'>NIVEL</th>
					<th class='BorderInfDch'>NOMBRE</th>
					<th class='BorderInfDch'>APELLIDO</th>
					<th class='BorderInf'></th>
				</tr>
				<tr align='center'>
					<td class='BorderInfDch'>".$_POST['id']."</td>
					<td class='BorderInfDch'>".ucfirst($_POST['ref'])."</td>
					<td class='BorderInfDch'>".ucfirst($_POST['Nivel'])."</td>
					<td class='BorderInfDch'>".ucfirst($_POST['Nombre'])."</td>
					<td class='BorderInfDch'>".ucfirst($_POST['Apellidos'])."</td>
					<td class='BorderInf'>
						<img src='".$ruta."".$_POST['myimg']."' height='40px' width='30px' />
					</td>
				</tr>
			</table>";
		
		global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
		$SqlCajaShopOper = "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' LIMIT 1 ";
			$QrySqlCajaShopOper = mysqli_query($db, $SqlCajaShopOper);
			$RowSqlCajaShopOper = mysqli_fetch_assoc($QrySqlCajaShopOper);
		
		$ClientName = $_POST['Nombre']." ".$_POST['Apellidos'];	
			
		global $LogText;	global $Comentarios;
		global $DateTime;	$DateTime =" Time: ".date('y.m.d')." / ".date('H.i.s')."<br>";
	if($RowSqlCajaShopOper['oper'] == $RefOperShop){
			$SqlUpdateCajaShop = "UPDATE `$db_name`.$CajaShop SET `refclient` = '$_POST[ref]', `clname` = '$ClientName' WHERE `oper` = '$RefOperShop' ";
		if(mysqli_query($db, $SqlUpdateCajaShop)){
			if($RowSqlCajaShopOper['refclient']==""){
				$Comentarios = $RowSqlCajaShopOper['coment']."* Init Ref Cliente: ".$_POST['ref']. $DateTime;
			}elseif($RowSqlCajaShopOper['refclient']!=$_POST['ref']){ 
				$Comentarios = $RowSqlCajaShopOper['coment']."* Modif. Ref Cliente: ".$RowSqlCajaShopOper['refclient']." x ".$_POST['ref'].$DateTime;
			}else{ $Comentarios = $RowSqlCajaShopOper['coment']; }
				$SqlUpdateCajaShop2 = "UPDATE `$db_name`.$CajaShop SET `coment` = '$Comentarios' WHERE `oper` = '$RefOperShop' AND `ini` = 1 LIMIT 1 ";
			if(mysqli_query($db, $SqlUpdateCajaShop2)){
			}else{ print("* ERROR SQL L.991 ".mysqli_error($db)."</br>"); }

			print($tabla);

			// DATOS LOG
			$LogText = $LogText."* SELECCIONADO CLIENTE =>\t* SESSION OPER ".$RefOperShop."\n\t\t\t\t\t\t";
			switch (true) {
				case (isset($_POST['refclient'])): 
					$LogText = $LogText."* REF CLIENTE ".$_POST['refclient']."\n\t\t\t\t\t\t";
				case (isset($_POST['Nivel'])):
					$LogText = $LogText."* NIVEL ".$_POST['Nivel']."\n\t\t\t\t\t\t";
				case (isset($_POST['Nombre'])):
					$LogText = $LogText."* NOMBRE ".$_POST['Nombre']."\n\t\t\t\t\t\t";
				case (isset($_POST['Apellidos'])):
					$LogText = $LogText."* APELLIDOS ".$_POST['Apellidos']."\n\t\t\t\t\t\t";
					break;
				default: $LogText = $LogText.'';
					break;
			}
		}else{ print("* ERROR SQL L.984 ".mysqli_error($db)."</br>"); }
	} // FIN IF
		
} // FIN function selec_cliente2()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todocl(){
	// MUESTRA TODOS LOS CLIENTES DE LA TABLA CLIENTES O ADMIN.
	// ESTÁ ANULADA EN function show_formcl($errors=[])
	global $db;		global $db_name;	
	require "../config/TablesNames.php";
	$Orden = $_POST['Orden'];
	global $doc;
	if(isset($_POST['doc'])){ $doc = $_POST['doc']; }else{ $doc = ''; }
		
		global $LogText;	
	if(!isset($_POST['cnivel'])){
		$sqlb =  "SELECT * FROM $ClientesWeb ORDER BY $Orden ";
			$qb = mysqli_query($db, $sqlb);
			$LogText = $LogText."* CONSLUTAR TODO TABLA CLIENTES =>\t* SESSION OPER ".$_SESSION['oper']."\n";
	}elseif(isset($_POST['cnivel'])){
		$sqlb =  "SELECT * FROM $Admin ORDER BY $Orden ";
			$qb = mysqli_query($db, $sqlb);
			$LogText = $LogText."* CONSLUTAR TODO TABLA ADMIN =>\t* SESSION OPER ".$_SESSION['oper']."\n";
	}else{ }
	
	if(!$qb){ print("* ERROR SQL L.1032/1036 ".mysqli_error($db)."</br>");
	}else{ if(mysqli_num_rows($qb)== 0){
			print ("<table align='center'>
					<tr>
						<td style='color:#F1BD2D;'>NO HAY DATOS</td>
					</tr>
				</table>");
		}else{ require 'TablaSelectCliente.php'; } // FIN ELSE

		} // FIN ELSE
	} // FIN function ver_todocl()
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){

	$errors = array();

		global $kgcash;		global $kgin;
		if($_POST['kgcash1'] > $_POST['stock1']){
			$errors [] = "UNIT CAJA: SIN SUFICIENTE STOCK";
		}else{ }

		if($_POST['kgcash1'] == $_POST['stock1']){
			$errors [] = "UNIT CAJA: SIN SUFICIENTE STOCK";
		}else{ }

		if((strlen(trim($_POST['kgcash1'])) == 0)||($_POST['kgcash1'] == 0)){
			$errors [] = "UNIT CAJA: CAMPO OBLIGATORIO";
		}elseif(!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['kgcash1'])){
			$errors [] = "UNIT CAJA: CARACTERES NO VALIDOS";
		}elseif(!preg_match('/^[0-9]+$/',$_POST['kgcash1'])){
			$errors [] = "UNIT CAJA: >SOLO NUMEROS";
		}elseif($kgcash > $kgin){
			$errors [] = "MAS DE CAJA QUE DE ENTRADA";
		}else{ }
			
		if(strlen(trim($_POST['kgcash2'])) == 0){
			$errors [] = "DEC CAJA CAMPO OBLIGATORIO";
		}elseif(!preg_match('/^[^@#$&%<>:´"·\(\)=¿?!¡\[\]\{\};,:\*\']+$/',$_POST['kgcash2'])){
			$errors [] = "DEC CAJA CARACTERES NO VALIDOS";
		}elseif(!preg_match('/^[0-9]+$/',$_POST['kgcash2'])){
			$errors [] = "DEC CAJA SOLO NUMEROS";
		}else{ }
			
		return $errors;

	} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function init_compra(){
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	global $refcaja;	$refcaja = $_SESSION['ref'];
	$refcj2 = substr($refcaja,2,2);
	global $RefOperShop;	$RefOperShop = $refcj2.date('ymd').date('His');
	$_SESSION['oper'] = $RefOperShop;
	
	global $semana;		$semana = date('W');	
	global $date;		$date = date('Y-m-d');
	global $ATime;		$ATime = date('H:i:s');
	global $datecash;	$datecash = $date."/".$ATime;
	global $LogText;
	
	global $CajaShopName;		$CajaShopName = $_SESSION['Nombre']." ".$_SESSION['Apellidos'];
	global $ClienteName;		global $ClienteRef;		global $FiltroNivelCliente;
	if($_SESSION['Nivel']=='cliente'){
		$ClienteName = $CajaShopName; 		$ClienteRef = $refcaja;
		$FiltroNivelCliente = " AND `refclient`= '$refcaja' ";
	}elseif($_SESSION['Nivel']=='caja'){
		$ClienteName = ""; 		$ClienteRef = "";
		$FiltroNivelCliente = " AND `refcaja`= '$refcaja' ";
	}else{
		$ClienteName = ""; 		$ClienteRef = "";
		$FiltroNivelCliente = "";
	}

	$SqlCajaShopKgCash =  "SELECT * FROM $CajaShop WHERE `kgcash` = '0.00' $FiltroNivelCliente ";
	echo "** ".$SqlCajaShopKgCash."<br>";
		$QrySqlCajaShopKgCash = mysqli_query($db, $SqlCajaShopKgCash);

	if(mysqli_num_rows($QrySqlCajaShopKgCash) >= 1){
		$RowSqlCajaShopKgCash = mysqli_fetch_assoc($QrySqlCajaShopKgCash);
		$SqlDeleteCajaShop =  "DELETE FROM $CajaShop WHERE `kgcash` = '0.00' AND `refcaja` = '$refcaja' $FiltroNivelCliente ";
		// echo "** ".$SqlDeleteCajaShop."<br>";
		if(mysqli_query($db, $SqlDeleteCajaShop)){ }else{ print("* ERROR SQL L.1115 ".mysqli_error($db)."<br>"); }
		$LogText = $LogText."* CANCEL COMPRA AUTO Kg 0,00. SESSION OPER: ".$RowSqlCajaShopKgCash['oper']."\t* CAJA REF ".$RowSqlCajaShopKgCash['refcaja']."\t* CAJA NAME ".$RowSqlCajaShopKgCash['cname']."\t* CAJA DATE W.".$RowSqlCajaShopKgCash['nsemana']." / D.".$RowSqlCajaShopKgCash['datecash']."\n\t";
	}else{ }

	global $IniKey;	$IniKey = 1;
	global $DateTime;	$DateTime =" Time: ".date('y.m.d')."/".date('H.i.s')."<br>";
	$Comentarios = "* Init Caja: ".$CajaShopName." / ".$refcaja.$DateTime;

	$SqlInsertCajaShop = "INSERT INTO `$db_name`.$CajaShop (`ini`,`cname`, `refcaja`, `clname`, `refclient`, `oper`, `nsemana`, `datecash`, `vseccion`, `producto`, `proname`, `kgcash`, `psiva`, `iva`, `ivae`, `pvp`, `pvptot`, `coment`) VALUES ('$IniKey', '$CajaShopName', '$refcaja', '$ClienteName', '$ClienteRef', '$RefOperShop', '$semana', '$datecash', '', '', '', 0.00, 0.00, 0, 0.00, 0.00, 0.00, '$Comentarios')";
			
	if(mysqli_query($db, $SqlInsertCajaShop)){
		$LogText = $LogText."\t* INIT COMPRA NEW. SESSION OPER: ".$RefOperShop."\t* CAJA REF ".$refcaja."\t* CAJA NAME ".$CajaShopName."\t* CAJA DATE W.".$semana." / D.".$datecash."\n";
	}else{ print("* ERROR SQL L.1124 ".mysqli_error($db)."<br>"); }

} // FIN function init_compra()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function cancel_compra(){
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	global $LError;		$LError = "L.1141";
	require 'SumarIvaTot.php';
							
	print("<table align='center'>
			<tr style='font-size:14px'>
				<th colspan=9 class='BorderInf' style='color:#F1BD2D;'>
					CONFIRME ELIMINAR LA COMPRA ".$_SESSION['oper']." 
				</th>
				<th colspan=2 class='BorderInf' >
			<form name='subtotal' method='post' action='$_SERVER[PHP_SELF]'>
		<button type='submit' title='CONTINUAR COMPRA' class='botonverde imgButIco CarroBlack'></button>
				<input type='hidden' name='subtotal' value=1 />
			</form>	
				</th>
			</tr>
			<tr style='font-size:10px'>
				<th class='BorderInfDch'>CAJERO</th>				
				<th class='BorderInfDch'>CLIENTE</th>
				<th class='BorderInfDch'>OPER SESION</th>					
				<th class='BorderInfDch ocultatd440'>FECHA</th>				
				<th class='BorderInfDch'>SECCION</th>										
				<th class='BorderInfDch'>PRODUCTO</th>
				<th class='BorderInfDch'>CARRO</th>
				<th class='BorderInfDch'>PVP</th>
				<th class='BorderInfDch'>IVA€</th>
				<th class='BorderInfDch'>SUBT</th>
				<th class='BorderInf'></th>
			</tr>");

	global $LogText;		$LogText = $LogText."* CANCEL COMPRA 1 =>\t".$_SESSION['oper']."\n";

	while($RowSqlCajaShopOper = mysqli_fetch_assoc($QrySqlCajaShopOper)){
		$ProName = strtolower($RowSqlCajaShopOper['proname']);
		print("<tr align='center'>
			<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['refcaja']."</td>
			<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['refclient']."</td>
			<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['oper']."</td>
			<td class='BorderInfDch ocultatd440' align='right'>".$RowSqlCajaShopOper['datecash']."</td>
			<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['vseccion']."</td>
			<td class='BorderInfDch' align='right'>".$ProName."</td>
			<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['kgcash']."</td>
			<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['pvp']."</td>
			<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['ivae']."</td>
			<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['pvptot']."</td>
			<td style='text-align:right;' class='BorderInf'>");

		if($RowSqlCajaShopOper['ini']=='1'){
				print("<form name='cancel_compra2'  action='$_SERVER[PHP_SELF]' method='POST'>
					<input name='id' type='hidden' value='".$RowSqlCajaShopOper['id']."' />
					<input name='cname' type='hidden' value='".$RowSqlCajaShopOper['cname']."' />
					<input name='proname' type='hidden' value='".$RowSqlCajaShopOper['proname']."' />
					<input name='psiva' type='hidden' value='".$RowSqlCajaShopOper['psiva']."' />
					<input name='iva' type='hidden' value='".$RowSqlCajaShopOper['iva']."' />
					<input name='refcaja' type='hidden' value='".$RowSqlCajaShopOper['refcaja']."' />
					<input name='refclient' type='hidden' value='".$RowSqlCajaShopOper['refclient']."' />
					<input name='oper' type='hidden' value='".$RowSqlCajaShopOper['oper']."' />
					<input name='nsemana' type='hidden' value='".$RowSqlCajaShopOper['nsemana']."' />
					<input name='datecash' type='hidden' value='".$RowSqlCajaShopOper['datecash']."' />
					<input name='vseccion' type='hidden' value='".$RowSqlCajaShopOper['vseccion']."' />
					<input name='producto' type='hidden' value='".$RowSqlCajaShopOper['producto']."' />
					<input name='kgcash' type='hidden' value='".$RowSqlCajaShopOper['kgcash']."' />
					<input name='pvp' type='hidden' value='".$RowSqlCajaShopOper['pvp']."' />
					<input name='ivae' type='hidden' value='".$RowSqlCajaShopOper['ivae']."' />
					<input name='pvptot' type='hidden' value='".$RowSqlCajaShopOper['pvptot']."' />
			<button type='submit' title='CONFIRME ELIMINAR COMPRA' class='botonrojo imgButIco DeleteBlack'></button>
						<input type='hidden' name='cancel_compra2' value=1 />
					</form>");
		}else{ }
			print("</td></tr>");
	} // FIN WHILE
										
		print("<tr>
				<td colspan='11' class='BorderInf'></td>
			</tr>
				<td colspan='3' class='BorderInf'></td>
				<td colspan='2' class='BorderInf' align='right'>TOTAL IVA</td>
				<td colspan='2' class='BorderInfDch' align='left'>".$sumaivae." €</td>
				<td colspan='2' class='BorderInf' align='right'>TOTAL €</td>
				<td class='BorderInfDch' align='right'>".$sumapvptot."</td>
				<td class='BorderInf'></td>
			</tr>
		</table>");

	}// FIN function cancel_compra()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function cancel_compra2(){
	global $db; 	global $db_name;
	require "../config/TablesNames.php";

	global $LError;		$LError = "L.1232";
	require 'SumarIvaTot.php';

	global $LError;		$LError = "L.1237";
	global $LogTextKey;	$LogTextKey = 3;
	require 'RowLogText.php';
							
	print ("<table align='center'>
			<tr style='font-size:14px'>
				<th colspan=8 class='BorderInf'>HA CANCELADO LA COMPRA ".$_SESSION['oper']."</th>
				<th colspan=2 class='BorderInf' >
		<form name='init_compra' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>
			<button type='submit' title='NUEVA COMPRA' class='botonazul imgButIco InicioBlack'></button>
				<input type='hidden' name='init_compra' value=1 />
		</form>	
				</th>
			</tr>
			<tr style='font-size:10px'>
				<th class='BorderInfDch'>CAJERO</th>
				<th class='BorderInfDch'>CLIENTE</th>
				<th class='BorderInfDch'>OPER SESION</th>
				<th class='BorderInfDch'>FECHA</th>
				<th class='BorderInfDch'>SECCION</th>										
				<th class='BorderInfDch'>PRODUCTO</th>
				<th class='BorderInfDch'>CARRO</th>
				<th class='BorderInfDch'>IVA€</th>
				<th class='BorderInfDch'>PVP</th>
				<th class='BorderInf'>SUBT</th>
			</tr>");

	while($RowSqlCajaShopOper = mysqli_fetch_assoc($QrySqlCajaShopOper)){
		$ProName =strtolower($_POST['proname']);
		print("<tr align='center'>
					<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['refcaja']."</td>
					<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['refclient']."</td>
					<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['oper']."</td>
					<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['datecash']."</td>
					<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['vseccion']."</td>
					<td class='BorderInfDch' align='right'>".$ProName."</td>
					<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['kgcash']."</td>
					<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['ivae']."</td>
					<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['pvp']."</td>
					<td class='BorderInf' align='right'>".$RowSqlCajaShopOper['pvptot']."</td>
				</tr>");
	} // FIN WHILE
						
	print("<tr>
			<td colspan='10' class='BorderInf'></td>
		</tr>
			<td colspan='3' class='BorderInf'></td>
			<td colspan='2' class='BorderInf' align='right'>TOTAL IVA</td>
			<td colspan='2' class='BorderInfDch' align='left'>".$sumaivae." €</td>
			<td colspan='2' class='BorderInf' align='right'>TOTAL €</td>
			<td class='BorderInf' align='right'>".$sumapvptot."</td>
		</table>");
	} // FIN function cancel_compra2()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* SUMA COMPRA CANCELADA A STOCKS */
	function fcancel_1(){
		global $db;		global $db_name;
		require "../config/TablesNames.php";

		global $semana;		$semana = date('W');	
		global $date;		$date = date('Y-m-d');
		global $ATime;		$ATime = date('H:i:s');
		global $datecash;	$datecash = $date."/".$ATime;
	
		global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
		$SqlCajaShopOper = "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop'";
			$QrySqlCajaShopOper = mysqli_query($db, $SqlCajaShopOper);
			$CountSqlCajaShopOper = mysqli_num_rows($QrySqlCajaShopOper);
		
		global $seccx;		global $refpro;		global $LogText; 
		for($i=0; $i<$CountSqlCajaShopOper; $i++){
			$RowSqlCajaShopOper = mysqli_fetch_assoc($QrySqlCajaShopOper);
			$seccx = $RowSqlCajaShopOper['vseccion']; 	$seccx = "`".$seccx."`";
			$refpro = $RowSqlCajaShopOper['producto'];
			if($RowSqlCajaShopOper['producto']!=""){

			$SqlProductosValor = "SELECT * FROM $Productos WHERE `valor` = '$RowSqlCajaShopOper[producto]' AND `stock` > 0 ";
					$QrySqlProductosValor = mysqli_query($db, $SqlProductosValor);
					$RowSqlProductosValor = mysqli_fetch_assoc($QrySqlProductosValor);
				/* SUMA AL STOCK LA EL CARRO CANCELADO */
				$cuadraiva = $RowSqlProductosValor['ivae'] - $RowSqlCajaShopOper['ivae'];
					$cuadraiva = floatval($cuadraiva);	$cuadraiva = number_format($cuadraiva,2,".","");
				$cuadrakgcash = $RowSqlProductosValor['kgcash'] - $RowSqlCajaShopOper['kgcash'];
					$cuadrakgcash = floatval($cuadrakgcash);	$cuadrakgcash = number_format($cuadrakgcash,2,".","");
				$cuadrastock = $RowSqlProductosValor['stock'] + $RowSqlCajaShopOper['kgcash'];
					$cuadrastock = floatval($cuadrastock);	$cuadrastock = number_format($cuadrastock,2,".","");

				// $SqlCajaShopUpdate = "UPDATE `$db_name`.$Productos SET `ivae` = $cuadraiva, `kgcash` = '$cuadrakgcash', `stock` = '$cuadrastock', `pvptot` = '$cuadrapvptot' WHERE $Productos.`valor` = '$RowSqlCajaShopOper[producto]' AND `stock` > 0  LIMIT 1 ";
				$SqlCajaShopUpdate = "UPDATE `$db_name`.$Productos SET `kgcash` = '$cuadrakgcash', `stock` = '$cuadrastock' WHERE $Productos.`valor` = '$RowSqlCajaShopOper[producto]' AND `stock` > 0  LIMIT 1 ";

				if(mysqli_query($db, $SqlCajaShopUpdate)){
					//print( "* ACTUALIZADO STOCK ".$seccx." / ".$Productos."</br>" );
					$LogText = $LogText."\n* FCANCEL 1 ACTUALIZADO STOCK ".$seccx." ".$Productos.".";
				}else{ print("* ERROR SQL L.1329 ".mysqli_error($db));
							}
			}else{ }
		} /* FIN DEL FOR */

} /* FIN fcancel_1() */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/*	FUNCION QUE CANCELA LA COMPRA */
function fcancel_2(){
	global $db;			global $db_name;
	require "../config/TablesNames.php";

	global $LError;		$LError = "L.1351";
	require 'SumarIvaTot.php';

	global $LError;		$LError = "L.1355";
	global $LogTextKey;	$LogTextKey = 4;
	require 'RowLogText.php';
						
	if(mysqli_num_rows($QrySqlCajaShopOper) >= 1){
		$SqlDeleteCajaShop =  "DELETE FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
		if(mysqli_query($db, $SqlDeleteCajaShop)){ unset($_SESSION['oper']);
									 //print("* COMPRA CANCELADA.");
		}else{ print("* ERROR SQL L.1558 ".mysqli_error($db)."<br>"); }
	}else{ }

} // FIN fcancel_2()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function recup_compra(){
	global $db;			global $db_name;
	require "../config/TablesNames.php";

	unset($_SESSION['oper']);

	global $refcaja;	$refcaja = $_SESSION['ref'];
	global $FiltroNivelCliente;
	if($_SESSION['Nivel']=='cliente'){
		$FiltroNivelCliente = " AND `refclient`= '$refcaja' ";
	}elseif($_SESSION['Nivel']=='caja'){
		$FiltroNivelCliente = " AND `refcaja`= '$refcaja' ";
	}else{
		$FiltroNivelCliente = "";
	}
	$SqlCajaShopIni0 = "SELECT * FROM $CajaShop WHERE `ini` > '0' $FiltroNivelCliente ";
	echo "** ".$SqlCajaShopIni0."<br>";
		$QrySqlCajaShopIni0 = mysqli_query($db, $SqlCajaShopIni0);
		$CountSqlCajaShopIni0 = mysqli_num_rows($QrySqlCajaShopIni0);
		
	if($CountSqlCajaShopIni0 < 1){
			print("<div align='center' style='margin-bottom:80px;margin-top:80px; color:#F1BD2D;' >
						NO HAY COMPRAS PENDIENTES
					</div>");
	}else{	print ("<table align='center'>
						<tr style='font-size:14px'>
							<th colspan=6 class='BorderInf ocultatd440'>SESIONES DE COMPRAS</th>
							<th colspan=5 class='BorderInf muestratd440'>SESIONES DE COMPRAS</th>
						</tr>
						<tr style='font-size:12px'>
							<th class='BorderInfDch'>CAJERO</th>
							<th class='BorderInfDch'>OPER SESION</th>		
							<th class='BorderInfDch ocultatd440'>FECHA</th>
							<th class='BorderInfDch'>CLIENTE</th>										
							<th class='BorderInfDch'>CARRO</th>
							<th class='BorderInf'></th>
						</tr>");
									
	global $InixKey;	global $ClientRef;
	while($RowCajaShopIni0 = mysqli_fetch_assoc($QrySqlCajaShopIni0)){
		$ClientRef = $RowCajaShopIni0['refclient'];
		$InixKey = $RowCajaShopIni0['ini'];
		global $RefOperShop;	$RefOperShop = $RowCajaShopIni0['oper'];
		//if($RowCajaShopIni0['ini'] != '1'){ $RowCajaShopIni0['cname'] = '';	$RowCajaShopIni0['datecash'] = ''; }

		// SUMO LOS PRODUCTOS QUE HAY EN CADA COMPRA
		/*
		$a = "SELECT SUM(`kgcash`) AS 'sumapro' FROM $CajaShop WHERE `oper` = '$RowCajaShopIni0[oper]'";
		$b = mysqli_query($db, $a);
		$c = mysqli_fetch_assoc($b);
		echo "** ".$c['sumapro']."<br>";
		*/
		$SqlSumCajaShopIni = "SELECT * FROM $CajaShop WHERE `oper` = '$RowCajaShopIni0[oper]' ";
			$QrySumCajaShopIni = mysqli_query($db, $SqlSumCajaShopIni);
			$SumNumCajaShopIni = mysqli_num_rows($QrySumCajaShopIni);
		global $SumaResult;	$SumaResult = 0.00;
		for($i=0; $i<$SumNumCajaShopIni; $i++){ 
			$SumaProductos = mysqli_fetch_array($QrySumCajaShopIni);
			$SumaResult = $SumaResult + $SumaProductos['kgcash'];
			}
		//echo "** ".$SumNumCajaShopIni."<br>";		//echo "** ".$SumaResult."<br>";
		$SumaResult = floatval($SumaResult);		$SumaResult = number_format($SumaResult,2,".","");

		require 'WhileRecupCompra.php';

			} // FIN WHILE
		print("	</table>");
	} // FIN ELSE $count >= 1

	global $LogText;		$LogText = $LogText."* CONSULTA RECUPERAR COMPRAS 1 =>";

} /* FIN  recup_compra() */


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function subtotal(){

	global $db;		global $db_name;
	require "../config/TablesNames.php";

	global $RefOperShop;	$RefOperShop = $_SESSION['oper'];		

	global $LError;			$LError = "L.1447";
	require 'SumarIvaTot.php';
	//echo "** ".$SqlCajaShopOper."<br>";

	global $LError;			$LError = "L.1451";
	global $LogTextKey;		$LogTextKey = 4;
	require 'RowLogText.php';
		
		global $BotonContinuaCompra;
		if(isset($_POST['init_compra'])){
			$BotonContinuaCompra = "<form name='subtotal' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block; vertical-align:inherit !important;'>
					<button type='submit' title='CONTINUAR COMPRA' class='botonverde imgButIco CarroBlack'>
					</button>
						<input type='hidden' name='subtotal' value=1 />
				</form>";
		}else{ $BotonContinuaCompra = ""; }
		global $Cabecera;
		$Cabecera = "<div style='display:inline-block; margin-top: 0.6em; '>
					SUBTOTAL COMPRA ".$_SESSION['oper']."</div> ".$BotonContinuaCompra."
				<form action='' method='get' style='display:inline-block; float:right'> 
					<input type='button' name='imprimir' title='IMPRIMIR COMPROBANTE' class='botonverde imgButIco PrintBlack' onClick='window.print();'>
				</form>";

		print("<table align='center'> 
					<tr style='font-size:12px'>
			<th colspan=11 class='BorderInf ocultatd740 ocultatd440'>".$Cabecera."</th>
			<th colspan=10 class='BorderInf muestratd740 ocultatd440'>".$Cabecera."</th>
			<th colspan=7 class='BorderInf muestratd440 ocultatd740' >".$Cabecera."</th>
					</tr>
					<tr style='font-size:10px'>
						<th class='BorderInfDch ocultatd440'>CAJERO</th>		
						<th class='BorderInfDch'>CLIENTE</th>
						<th class='BorderInfDch ocultatd740 ocultatd440'>FECHA</th>
						<th class='BorderInfDch ocultatd440'>SECCION</th>
						<th class='BorderInfDch'>PRODUCTO</th>
						<th class='BorderInfDch ocultatd440'>STOCK</th>
						<th class='BorderInfDch' bgcolor='#494949'>CARRO</th>
						<th class='BorderInfDch'>PVP</th>
						<th class='BorderInfDch'>IVA€</th>
						<th class='BorderInfDch' bgcolor='#494949'>SUBT</th>

						<th class='BorderInf ocultatd440 ocultatd740'>
							<form name='cancel_compra' method='post' action='$_SERVER[PHP_SELF]'>
				<button type='submit' title='ELIMINAR COMPRA' class='botonrojo imgButIco DeleteBlack'></button>
								<input type='hidden' name='cancel_compra' value=1 />
							</form>	
						</th>
						<th class='BorderInf muestratd740 ocultatd440' style='width: 30px !important;'>
							<form name='cancel_compra' method='post' action='$_SERVER[PHP_SELF]'>
				<button type='submit' title='ELIMINAR COMPRA' class='botonrojo imgButIco DeleteBlack'></button>
								<input type='hidden' name='cancel_compra' value=1 />
							</form>	
						</th>
						<th class='BorderInf muestratd440 ocultatd740' style='width: 20px !important;'>
							<form name='cancel_compra' method='post' action='$_SERVER[PHP_SELF]'>
				<button type='submit' title='ELIMINAR COMPRA' class='botonrojo imgButIco DeleteBlack'></button>
								<input type='hidden' name='cancel_compra' value=1 />
							</form>	
						</th>
					</tr>");
									
	global $RowStock;
	while($RowSqlCajaShopOper = mysqli_fetch_assoc($QrySqlCajaShopOper)){
		$ProName = ucwords(strtolower($RowSqlCajaShopOper['proname']));

		if($RowSqlCajaShopOper['producto'] != ''){
			$fil = "%".$RowSqlCajaShopOper['producto']."%";
			$SqlProductosValor =  "SELECT * FROM $Productos WHERE `valor` LIKE '$fil' LIMIT 1";
				$QrySqlProductosValor = mysqli_query($db, $SqlProductosValor);
				$RowSqlProductosValor = mysqli_fetch_assoc($QrySqlProductosValor);
				$RowStock = $RowSqlProductosValor['stock'];
		}else{ $RowStock = 0.00; }

		print ("<tr align='center'>
			<td class='BorderInfDch ocultatd440' align='left'>".$RowSqlCajaShopOper['refcaja']."</td>
			<td class='BorderInfDch' align='left'>".$RowSqlCajaShopOper['refclient']."</td>
			<td class='BorderInfDch ocultatd740 ocultatd440' align='right'>".$RowSqlCajaShopOper['datecash']."</td>
			<td class='BorderInfDch ocultatd440' align='right'>".$RowSqlCajaShopOper['vseccion']."</td>
			<td class='BorderInfDch' align='right'>".$ProName."</td>
			<td class='BorderInfDch ocultatd440' align='right'>".$RowStock."</td>
			<td bgcolor='#494949' class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['kgcash']."</td>
			<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['pvp']."</td>
			<td class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['ivae']."</td>
			<td bgcolor='#494949' class='BorderInfDch' align='right'>".$RowSqlCajaShopOper['pvptot']."</td>");
		if($RowSqlCajaShopOper['producto'] != ''){
			print("<td class='BorderInf' style='text-align:center;'>
					<div style='float:left;margin-right:3px'>
				<form name='modif_pro' action='$_SERVER[PHP_SELF]' method='POST'>
					<input name='id' type='hidden' value='".$RowSqlCajaShopOper['id']."' />
					<input name='oper' type='hidden' value='".$RowSqlCajaShopOper['oper']."' />
					<input name='refcaja' type='hidden' value='".$RowSqlCajaShopOper['refcaja']."' />
					<input name='cname' type='hidden' value='".$RowSqlCajaShopOper['cname']."' />
					<input name='refclient' type='hidden' value='".$RowSqlCajaShopOper['refclient']."' />
					<input name='vseccion' type='hidden' value='".$RowSqlCajaShopOper['vseccion']."' />
					<input name='seccion' type='hidden' value='".$RowSqlCajaShopOper['vseccion']."' />
					<input name='proname' type='hidden' value='".$RowSqlCajaShopOper['proname']."' />
					<input name='producto' type='hidden' value='".$RowSqlCajaShopOper['producto']."' />
					<input name='psiva' type='hidden' value='".$RowSqlCajaShopOper['psiva']."' />
					<input name='iva' type='hidden' value='".$RowSqlCajaShopOper['iva']."' />
					<input name='nsemana' type='hidden' value='".$RowSqlCajaShopOper['nsemana']."' />
					<input name='datecash' type='hidden' value='".$RowSqlCajaShopOper['datecash']."' />
					<input name='stock' type='hidden' value='".$RowStock."' />
					<input name='kgcashx' type='hidden' value='".$RowSqlCajaShopOper['kgcash']."' />
					<input name='pvp' type='hidden' value='".$RowSqlCajaShopOper['pvp']."' />
					<input name='ivae' type='hidden' value='".$RowSqlCajaShopOper['ivae']."' />
					<input name='pvptot' type='hidden' value='".$RowSqlCajaShopOper['pvptot']."' />
			<button type='submit' title='MODIFICAR PRODUCTO' class='botonnaranja imgButIco CarroBlack'></button>
						<input type='hidden' name='modif_pro' value=1 />
				</form>
					</div>
					<div style='float:left;margin-right:3px'>
				<form name='elim_pro'  action='$_SERVER[PHP_SELF]' method='POST'>
					<input name='id' type='hidden' value='".$RowSqlCajaShopOper['id']."' />
					<input name='oper' type='hidden' value='".$RowSqlCajaShopOper['oper']."' />
					<input name='refcaja' type='hidden' value='".$RowSqlCajaShopOper['refcaja']."' />
					<input name='cname' type='hidden' value='".$RowSqlCajaShopOper['cname']."' />
					<input name='refclient' type='hidden' value='".$RowSqlCajaShopOper['refclient']."' />
					<input name='vseccion' type='hidden' value='".$RowSqlCajaShopOper['vseccion']."' />
					<input name='proname' type='hidden' value='".$RowSqlCajaShopOper['proname']."' />
					<input name='producto' type='hidden' value='".$RowSqlCajaShopOper['producto']."' />
					<input name='psiva' type='hidden' value='".$RowSqlCajaShopOper['psiva']."' />
					<input name='iva' type='hidden' value='".$RowSqlCajaShopOper['iva']."' />
					<input name='nsemana' type='hidden' value='".$RowSqlCajaShopOper['nsemana']."' />
					<input name='datecash' type='hidden' value='".$RowSqlCajaShopOper['datecash']."' />
					<input name='kgcash' type='hidden' value='".$RowSqlCajaShopOper['kgcash']."' />
					<input name='pvp' type='hidden' value='".$RowSqlCajaShopOper['pvp']."' />
					<input name='ivae' type='hidden' value='".$RowSqlCajaShopOper['ivae']."' />
					<input name='pvptot' type='hidden' value='".$RowSqlCajaShopOper['pvptot']."' />
			<button type='submit' title='BORRAR PRODUCTO' class='botonrojo imgButIco DeleteWhite'></button>
							<input type='hidden' name='elim_pro' value=1 />
					</div>
				</form>
					<div style='float:left;margin-right:3px'>
				<form name='ver' action='ProductosVerImg.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=440px,height=640px')\">
					<input name='seccion' type='hidden' value='".$RowSqlCajaShopOper['vseccion']."' />
					<input name='id' type='hidden' value='".$RowSqlCajaShopOper['id']."' />
					<input name='valor' type='hidden' value='".$RowSqlCajaShopOper['producto']."' />
					<input name='nombre' type='hidden' value='".$RowSqlCajaShopOper['proname']."' />
					<input name='ref' type='hidden' value='".$RowSqlCajaShopOper['producto']."' />
			<button type='submit' title='IMAGENES PRODUCTO' class='botonazul imgButIco FotoBlack'></button>
							<input type='hidden' name='oculto2' value=1 />
					</div>
				</form>");
		}else{ print("<td colspan='2' class='BorderInf'>"); }
		print("</td></tr>");
	} // FIN WHILE
			print("<tr>
					<td colspan=11 class='BorderInf ocultatd440 ocultatd740'></td>
					<td colspan=10 class='BorderInf ocultatd440 muestratd740'></td>
					<td colspan=7 class='BorderInf ocultatd740 muestratd440'></td>
				</tr>
				<tr>
					<td colspan=2 class='BorderInf'>");
			
			global $SqlCajaShopOper;	global $db;		global $db_name;
			//echo "** ".$SqlCajaShopOper."<br>";
			$QrySqlCajaShopOper2 = mysqli_query($db, $SqlCajaShopOper);
			$RowSqlCajaShopOper2 = mysqli_fetch_assoc($QrySqlCajaShopOper2);
			$ClientRef = $RowSqlCajaShopOper2['refclient'];
		if(($RowSqlCajaShopOper2['oper']!="")&&($RowSqlCajaShopOper2['refclient']!="")&&($RowSqlCajaShopOper2['kgcash']>0)&&($_SESSION['Nivel']!='cliente')){
		print("<form name='selec_client' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>
						<input name='refclient' type='hidden' value='".$RowSqlCajaShopOper2['refclient']."' />
			<button type='submit' title='MODIFICAR CLIENTE' class='botonnaranja imgButIco PersonAddBlack'></button>
						<input type='hidden' name='selec_client' value=1 />
						<input type='hidden' name='modif_client' value=1 />
					</form>");
		}else{ }

		if($RowSqlCajaShopOper2['refclient']==""){ $ClientRef = "";
		}else{
			$ClientRef = $RowSqlCajaShopOper2['refclient'];
			$SqlClientesWebClientRef =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ";
				$QrySqlClientesWebClientesWeb = mysqli_query($db, $SqlClientesWebClientRef);
			if(mysqli_num_rows($QrySqlClientesWebClientesWeb) == 0){
				$SqlClientesWebClientRef =  "SELECT * FROM $Admin WHERE `ref` = '$ClientRef' ";
					$QrySqlClientesWebClientesWeb = mysqli_query($db, $SqlClientesWebClientRef);
			}else{ }
					$RowSqlClientesWebClientesWeb = mysqli_fetch_assoc($QrySqlClientesWebClientesWeb);
					$_SESSION['nclient'] = $RowSqlClientesWebClientesWeb['Nivel'];
		}

		global $CssHeight;
		if($RefOperShop == ''){
		}elseif($ClientRef != ''){
			if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){ 
					$CssHeight = 'height=530px';
			}else{ 	$CssHeight = 'height=290px'; }
	
			global $SqlClientesWebClientRef2;
			if(($_SESSION['nclient']=='cliente')||($_SESSION['nclient']=='caja')){
				$SqlClientesWebClientRef2 =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ORDER BY `Nombre` ASC ";
					$CssHeight = 'height=530px';
			}elseif(($_SESSION['nclient']=='admin')||($_SESSION['nclient']=='plus')||($_SESSION['nclient']== 'user')){
				$SqlClientesWebClientRef2 =  "SELECT * FROM $Admin WHERE `ref` = '$ClientRef' ORDER BY `Nombre` ASC ";
			}
				$QryClientesWebClientRef2 = mysqli_query($db, $SqlClientesWebClientRef2);
				$RowClientesWebClientRef2 = mysqli_fetch_assoc($QryClientesWebClientRef2);
				//echo "** ".$SqlClientesWebClientRef2.">br>";

			if($RowClientesWebClientRef2['doc']=='local'){ $CssHeight = 'height=290px'; }else{ $CssHeight = 'height=530px'; }

				print("<form name='data_client' action='ClienteVer02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=320px,".$CssHeight."')\" style='display:inline-block;'>
					<input type='hidden' name='id' value='".$RowClientesWebClientRef2['id']."' />
					<input type='hidden' name='Nivel' value='".$RowClientesWebClientRef2['Nivel']."' />
					<input type='hidden' name='ref' value='".$RowClientesWebClientRef2['ref']."' />
					<input type='hidden' name='Nombre' value='".$RowClientesWebClientRef2['Nombre']."' />
					<input type='hidden' name='Apellidos' value='".$RowClientesWebClientRef2['Apellidos']."' />
					<input type='hidden' name='myimg' value='".$RowClientesWebClientRef2['myimg']."' />
					<input type='hidden' name='doc' value='".$RowClientesWebClientRef2['doc']."' />
					<input type='hidden' name='dni' value='".$RowClientesWebClientRef2['dni']."' />
					<input type='hidden' name='ldni' value='".$RowClientesWebClientRef2['ldni']."' />
					<input type='hidden' name='Email' value='".$RowClientesWebClientRef2['Email']."' />
					<input type='hidden' name='Usuario' value='".$RowClientesWebClientRef2['Usuario']."' />
					<input type='hidden' name='Password' value='".$RowClientesWebClientRef2['Password']."' />
					<input type='hidden' name='Direccion' value='".$RowClientesWebClientRef2['Direccion']."' />
					<input type='hidden' name='Tlf1' value='".$RowClientesWebClientRef2['Tlf1']."' />
					<input type='hidden' name='Tlf2' value='".$RowClientesWebClientRef2['Tlf2']."' />
					<input type='hidden' name='lastin' value='".$RowClientesWebClientRef2['lastin']."' />
					<input type='hidden' name='lastout' value='".$RowClientesWebClientRef2['lastout']."' />
					<input type='hidden' name='visitadmin' value='".$RowClientesWebClientRef2['visitadmin']."' />
			<button type='submit' title='DATOS CLIENTE' class='botonlila imgButIco InfoBlack'></button>
						<input type='hidden' name='data_client' value=1 />
				</form>");
		} // FIN elseif($ClientRef != '')
		print("<form name='coment_client' action='CompraComent.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=500px,height=320px')\" style='display:inline-block;'>
				<input type='hidden' name='oper' value='".$RefOperShop."' />
		<button type='submit' title='COMENTARIOS COMPRA' class='botonazul imgButIco DatosBlack'></button>
				<input type='hidden' name='coment_client' value=1 />
			</form>
				</td>
				<td colspan=2 class='BorderInf ocultatd440'></td>

				<td colspan=2 class='BorderInf ocultatd440 ocultatd740' align='right'>IVA €</td>
				<td class='BorderInf muestratd740 ocultatd440' align='right'>IVA €</td>

				<td class='BorderInfDch ocultatd440' bgcolor='#494949' align='left'>".$sumaivae."</td>
				<td colspan=2 class='BorderInfDch muestratd440' bgcolor='#494949' align='left'>IVA ".$sumaivae."</td>

				<td colspan='2' class='BorderInf ocultatd440' align='right'>TOTAL €</td>

				<td bgcolor='#494949' class='BorderInfDch ocultatd440' align='left'>".$sumapvptot."</td>
				<td colspan='2' bgcolor='#494949' class='BorderInfDch muestratd440' align='left'>TOT. ".$sumapvptot."</td>
				
				<td class='BorderInf'>");

			$QrySqlCajaShopOper3 = mysqli_query($db, $SqlCajaShopOper);
			$RowSqlCajaShopOper3 = mysqli_fetch_assoc($QrySqlCajaShopOper3);
		if($RefOperShop == ''){
		}elseif($RowSqlCajaShopOper3['producto'] != ''){
			print("<div style='text-align:center;'>
					<form name='pago' method='post' action='$_SERVER[PHP_SELF]'>
				<button type='submit' title='PAGAR COMPRA' class='botonazul imgButIco MoneyBlack'></button>
						<input type='hidden' name='pago' value=1 />
					</form>	
				</div>");
		}else{ }// FIN PRIMER ELSE
		print("</td></tr></table>");
		
} // FIN function subtotal()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function selec_pro(){
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	$SqlSeccionesValor =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[seccion]'";
		$QrySqlSeccionesValor = mysqli_query($db, $SqlSeccionesValor);
		$RowSqlSeccionesValor = mysqli_fetch_assoc($QrySqlSeccionesValor);
	global $_SecName;		$_SecName = $RowSqlSeccionesValor['nombre'];
	global $_SecValue;		$_SecValue = $RowSqlSeccionesValor['valor'];
	global $RefOperShop; 	$RefOperShop = $_SESSION['oper'];
	
	// SELECCIONO LOS VALORES DE LA OPERACION
	$SqlCajaShopOper = "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' ";
		$QrySqlCajaShopOper = mysqli_query($db, $SqlCajaShopOper);
		global $noper;	$noper = mysqli_num_rows($QrySqlCajaShopOper);
		$RowSqlCajaShopOper = mysqli_fetch_assoc($QrySqlCajaShopOper);
		global $ClientRef;		$ClientRef = $RowSqlCajaShopOper['refclient'];
		global $ClientName;		$ClientName = $RowSqlCajaShopOper['clname'];

	// SELECCIONO LOS VALORES DEL PRODUCTO
	$SqlCajaShopOperProducto = "SELECT * FROM $CajaShop WHERE `oper` = '$RefOperShop' AND `producto` = '$_POST[valor]' LIMIT 1";
		$QrySqlCajaShopOperProducto = mysqli_query($db, $SqlCajaShopOperProducto);
		$RowSqlCajaShopOperProducto = mysqli_fetch_assoc($QrySqlCajaShopOperProducto);
		$CountSqlCajaShopOperProducto = mysqli_num_rows($QrySqlCajaShopOperProducto);
		global $rowProduckgcash;
	if($CountSqlCajaShopOperProducto > 0){ $rowProduckgcash = $RowSqlCajaShopOperProducto['kgcash'];
	}else{ $rowProduckgcash = 0.00; }

	global $refcaja;	$refcaja = $_SESSION['ref'];
	global $semana;		$semana = date('W');	
	global $date;		$date = date('Y-m-d');
	global $ATime;		$ATime = date('H:i:s');
	global $datecash;	$datecash = $date."/".$ATime;

	global $kgcash;		$kgcash = 0.00;		global $pvptot;		global $ivae;	global $ivav;
	$kgcash1 = $_POST['kgcash1'];		$kgcash2 = $_POST['kgcash2'];
	$kgcash = $kgcash1.".".$kgcash2;
	$kgcash = floatval($kgcash);		$kgcash = number_format($kgcash,2,".","");

	$pvp = $_POST['pvp'];
	$pvp = floatval($pvp);				$pvp = number_format($pvp,2,".","");
	$pvptot = $kgcash * $pvp ;
	$pvptot = floatval($pvptot);		$pvptot = number_format($pvptot,2,".","");

	$pvp = $_POST['pvp'];
	$pvp = floatval($pvp);				$pvp = number_format($pvp,2,".","");
	$pvptot = $kgcash * $pvp ;
	$pvptot = floatval($pvptot);		$pvptot = number_format($pvptot,2,".","");
	
	$ivaop = $_POST['iva'];
	$ivae = $_POST['psiva']*($ivaop/100);
	$ivae = floatval($ivae);			$ivae = number_format($ivae,2,".","");
	$ivav = $ivae * $kgcash;
	$ivav = floatval($ivav);			$ivav = number_format($ivav,2,".","");
	global $tabla;
	$tabla = "<table align='center' style='margin-top:10px' class='PrintNone'>
				<tr>
					<th colspan=4 >HA SELECCIONADO SECCION ".$RowSqlSeccionesValor['nombre']."</th>
				</tr>
				<tr>
					<td style='text-align:right'>NAME</td><td>".$_POST['proname']."</td>
					<td style='text-align:right'>REF</td><td>".$_POST['valor']."</td>
				</tr>				
				<tr>
					<td style='text-align:right'>UNIT VENTA</td><td>".$kgcash."</td>
					<td style='text-align:right'>UNIT € PVP</td><td>".$_POST['pvp']." €</td>
				</tr>
				<tr>
					<td style='text-align:right'>PVP SIN IVA</td><td>".$_POST['psiva']." €</td>
					<td style='text-align:right'>TIPO IVA</td><td>".$_POST['iva']." %</td>
				</tr>
				<tr>
					<td style='text-align:right'>IVA €</td><td>".$ivav." €</td>
					<td style='text-align:right'>CAJA TOTAL €</td><td>".$pvptot." €</td>
				</tr>
			</table>";	 

		/* RESTA LA COMPRA AL STOCKS */														
		global $refpro;		$refpro = $_POST['valor']; 
		$SqlProductosValor = "SELECT * FROM $Productos WHERE `valor` = '$refpro' AND `stock` > 0 ";
			$QrySqlProductosValor = mysqli_query($db, $SqlProductosValor);
			$RowSqlProductosValor = mysqli_fetch_assoc($QrySqlProductosValor);
		global $cuadrakgcash;	global $cuadrapvptot;	global $cuadrastock;	global $cuadraiva;
		if(mysqli_num_rows($QrySqlProductosValor) > 0){
			/* RESTA AL STOCK LA NUEVA ENTRADA */
			$cuadrakgcash = $RowSqlProductosValor['kgcash'] + $kgcash;
				$cuadrakgcash = floatval($cuadrakgcash);
				$cuadrakgcash = number_format($cuadrakgcash,2,".","");
			$cuadrastock = $RowSqlProductosValor['stock'] - $kgcash;
				$cuadrastock = floatval($cuadrastock);
				$cuadrastock = number_format($cuadrastock,2,".","");
			$cuadraiva = $RowSqlProductosValor['ivae'] + $ivav;
				$cuadraiva = floatval($cuadraiva);
				$cuadraiva = number_format($cuadraiva,2,".","");
		// ACTUALIZA LOS VALORES DE LA TABLA PRODUCTOS
		//$SqlUpdateProductos = "UPDATE `$db_name`.$Productos SET `ivae` = $cuadraiva, `kgcash` = '$cuadrakgcash', `stock` = '$cuadrastock', `pvptot` = '$cuadrapvptot', `datecash` = '$datecash' WHERE $Productos.`valor` = '$refpro' AND `stock` > 0  LIMIT 1 ";
		$SqlUpdateProductos = "UPDATE `$db_name`.$Productos SET `kgcash` = '$cuadrakgcash', `stock` = '$cuadrastock', `datecash` = '$datecash' WHERE $Productos.`valor` = '$refpro' AND `stock` > 0  LIMIT 1 ";
		//echo "*L.1782 ".$SqlUpdateProductos."<br>";
		global $LogText;		global $seccx2;
		if(mysqli_query($db, $SqlUpdateProductos)){
			//print( "*L.1782 ACTUALIZADO STOCK ".$seccx2." ".$Productos."</br>" );
			$LogText = $LogText."\n* ACTUALIZADO STOCK RESTADO ".$kgcash."".$seccx2." ".$Productos."";
		}else{ print("* ERROR SQL L.1782 ".mysqli_error($db)); }
	}else{ }

	if(($RowSqlCajaShopOper['oper'] == $RefOperShop)&&($RowSqlCajaShopOper['kgcash'] == 0.00)){
		
		if($RowSqlCajaShopOper['clname']==""){ $ClientName = "`clname` = '$RowSqlCajaShopOper[cname]',"; }else{ $ClientName = ""; }
		if($RowSqlCajaShopOper['refclient']==""){ $clref = "`refclient` = '$RowSqlCajaShopOper[refcaja]',"; }else{ $clref = ""; }
		$SqlUpdateCajaShop = "UPDATE `$db_name`.$CajaShop SET $ClientName $clref `datecash` = '$datecash', `vseccion` = '$_POST[seccion]', `producto` = '$_POST[valor]', `proname` = '$_POST[proname]', `kgcash` = '$kgcash', `psiva` = '$_POST[psiva]',`iva` = '$_POST[iva]', `ivae` = '$ivav', `pvp` = '$_POST[pvp]', `pvptot` = '$pvptot' WHERE `oper` = '$RefOperShop' LIMIT 1 ";
		//echo "* L.1795 ".$SqlUpdateCajaShop."<br>";
		if(mysqli_query($db, $SqlUpdateCajaShop)){ 
			print($tabla);
			if(!isset($_POST['producto'])){ $LogText = $LogText.'TODOS LOS PRODUCTOS';
			}else{ $LogText = $LogText.$_POST['producto']; }
			$LogText = $LogText."* SELECT PRO =>\t* SESSION OPER ".$_SESSION['oper']."\t* REF CLIENTE ".$ClientRef."\t* SECCION ".$_POST['seccion']."\t* PRODUCTO ".$_POST['proname']."\t* UNIT CAJA ".$kgcash."\t* PVP ".$_POST['pvp']."\t* PVPTOT ".$pvptot."\n";
		}else{ print("* ERROR SQL L.1795 ".mysqli_error($db)."</br>"); }
		
	}elseif((@$RowSqlCajaShopOperProducto['producto'] == $_POST['valor'])){

		$SqlUpdateCajaShop = "UPDATE `$db_name`.$CajaShop SET `datecash` = '$datecash', `kgcash` = '$cuadrakgcash', `psiva` = '$_POST[psiva]', `ivae` = '$cuadraiva', `pvp` = '$_POST[pvp]', `pvptot` = '$pvptot' WHERE `oper` = '$RefOperShop' AND `producto` = '$_POST[valor]'  LIMIT 1 ";
		//echo "*2169 ".$SqlUpdateCajaShop."<br>";
		if(mysqli_query($db, $SqlUpdateCajaShop)){ 
			print($tabla);
			if(!isset($_POST['producto'])){ $LogText = $LogText.'TODOS LOS PRODUCTOS';
			}else{ $LogText = $LogText.$_POST['producto']; }
			$LogText = $LogText."* SELECT PRO =>\t* SESSION OPER ".$_SESSION['oper']."\t* REF CLIENTE ".$ClientRef."\t* SECCION ".$_POST['seccion']."\t* PRODUCTO ".$_POST['proname']."\t* UNIT CAJA ".$kgcash."\t* PVP ".$_POST['pvp']."\t* PVPTOT ".$pvptot."\n";
		}else{ print("* ERROR SQL L.1806 ".mysqli_error($db)."</br>"); }

	}else{ if($noper >= 1){ $IniKey = 0; }else{ $IniKey = 1; }

		$SqlInsertCajaShop = "INSERT INTO `$db_name`.$CajaShop (`ini`, `cname`, `refcaja`, `clname`, `refclient`, `oper`, `nsemana`, `datecash`, `vseccion`, `producto`, `proname`, `kgcash`, `psiva`, `iva`, `ivae`, `pvp`, `pvptot`) VALUES ('$IniKey', '$RowSqlCajaShopOper[cname]', '$refcaja', '$ClientName', '$ClientRef', '$RowSqlCajaShopOper[oper]', '$semana', '$datecash', '$_POST[seccion]', '$_POST[valor]', '$_POST[proname]', '$kgcash', '$_POST[psiva]', '$_POST[iva]', '$ivav', '$_POST[pvp]', '$pvptot')";
		//echo "* ".$SqlInsertCajaShop."<br><br>";
		if(mysqli_query($db, $SqlInsertCajaShop)){ 
			print( $tabla );
			if(!isset($_POST['producto'])){ $LogText = $LogText.'TODOS LOS PRODUCTOS'; }
			else{ $LogText = $LogText.$_POST['producto'];}
			$LogText = $LogText."* SELECT PRO =>\t* SESSION OPER ".$_SESSION['oper']."\t* REF CLIENTE ".$ClientRef."\t* SECCION ".$_POST['seccion']."\t* PRODUCTO ".$_POST['proname']."\t* UNIT CAJA ".$kgcash."\t* PVP ".$_POST['pvp']."\t* PVPTOT ".$pvptot."\n";
		}else{ print("* ERROR SQL L.1817 ".mysqli_error($db)."</br>"); }

	}
	
	} // FIN function selec_pro()
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form($errors=[]){
	global $db;		global $kgcash1;		global $kgcash2;
	require "../config/TablesNames.php";

	global $kgcash;	global $kgcash1;	global $kgcash2;
	if(isset($_POST['stock'])){
		$nkgcash = strlen(trim($_POST['stock']));
		$nkgcash = $nkgcash - 3;
		$kgcashx = $_POST['stock'];
		$kgcash1 = substr($_POST['stock'],0,$nkgcash);
		$kgcash2 = substr($_POST['stock'],-2,2);
	}else{ }

	global $kgcash;	global $kgcash1; global $kgcash2;

	if(isset($_POST['oculto'])){
			$defaults = array ( 'kgcash1' => 0,
								'kgcash2' => 00,);
	}elseif(isset($_POST['selec_pro'])){
		if(isset($_POST['kgcash1'])){
			$kgcash1 = $_POST['kgcash1'];	
			$kgcash2 = $_POST['kgcash2'];
			$kgcash = $kgcash1.".".$kgcash2;
			$kgcash = floatval($kgcash);
			$kgcash = number_format($kgcash,2,".","");
		}else{ $kgcash1 = 0; 
			   $kgcash2 = $_POST['kgcash2'];
				}
		$defaults = array( 'kgcash1' => $kgcash1,
						   'kgcash2' => $kgcash2,);

	}else{	$defaults = array ( 'kgcash1' => 0,
								'kgcash2' => 00,);
				}

	global $KeyErrors;	$KeyErrors = 2;

	require 'TableValidateErrors.php';

	if($_POST['producto']==""){ $fil = " = '".$_POST['producto']."'";
	}else{ $fil = " LIKE '%".$_POST['producto']."%'"; }

	$SqlProductosValor =  "SELECT * FROM $Productos WHERE `valor` $fil ";
		$QrySqlProductosValor = mysqli_query($db, $SqlProductosValor);
	//echo "**".$SqlProductosValor."<br>";

	$SqlSeccionesValor =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[seccion]'";
		$QrySqlSeccionesValor = mysqli_query($db, $SqlSeccionesValor);
		$RowSqlSeccionesValor = mysqli_fetch_assoc($QrySqlSeccionesValor);

	if(mysqli_num_rows($QrySqlSeccionesValor)== 0){ 
		print("<table align='center' style='margin-top:20px; margin-bottom:20px;' class='PrintNone'>
				<tr align='center'>
					<td style='color:#F1BD2D;'>SELECCIONE UNA SECCION</td>
				</tr>
			</table>");
	}else{
		if(mysqli_num_rows($QrySqlProductosValor)== 0){
			print("<table align='center' style='margin:-0.6em auto 0.8em auto;'>
					<tr align='center'>
						<td style='color:#F1BD2D;'>
							SELECCIONE UN PRODUCTO<br>NO HAY DATOS
						</td>
					</tr>
				</table>");

		}else{ print("<table align='center'>
						<tr style='font-size:14px'>
							<th colspan=10 class='BorderInf'>
								PRODUCTO DE LA SECCION ".$RowSqlSeccionesValor['nombre']."
							</th>
						</tr>
						<tr style='font-size:12px'>
							<th class='BorderInfDch'>REF PRO</th>	
							<th class='BorderInfDch'>NAME PRO</th>
							<th class='BorderInfDch'>PVPN</th>
							<th class='BorderInfDch'>IVA%</th>
							<th class='BorderInfDch'>IVA€</th>
							<th class='BorderInfDch'>PVP.€</th>
							<th class='BorderInfDch'>STOCK</th>
							<th class='BorderInfDch'>UNIT COMPRA</th>
							<th class='BorderInfDch'>DESCRIPCION</th>
							<th class='BorderInf' style='text-align:center;'>
						<form name='subtotal' method='post' action='$_SERVER[PHP_SELF]'>
				<button type='submit' title='CANCELAR PRODUCTO' class='botonrojo imgButIco CarroWhite'></button>
							<input type='hidden' name='subtotal' value=1 />
						</form>	
							</th>
						</tr>");
			while($RowSqlProductosValor = mysqli_fetch_assoc($QrySqlProductosValor)){
				if($RowSqlProductosValor['valor'] != ''){
					$nstock = strlen(trim($RowSqlProductosValor['stock']));	
					$nstock = $nstock - 3;
					$stockx = $RowSqlProductosValor['stock'];
					$stock1 = substr($RowSqlProductosValor['stock'],0,$nstock);
					$stock2 = substr($RowSqlProductosValor['stock'],-2,2);
					
					print (	"<tr align='center'>
								<td class='BorderInfDch' align='right'>".$RowSqlProductosValor['valor']."</td>
								<td class='BorderInfDch' align='left'>".$RowSqlProductosValor['nombre']."</td>
								<td class='BorderInfDch' align='right'>".$RowSqlProductosValor['psiva']."</td>
								<td class='BorderInfDch' align='right'>".$RowSqlProductosValor['iva']." %</td>
								<td class='BorderInfDch' align='right'>".$RowSqlProductosValor['ivae']."</td>
								<td class='BorderInfDch' align='right'>".$RowSqlProductosValor['pvp']."</td>
								<td class='BorderInfDch' align='right'>".$RowSqlProductosValor['stock']."</td>
				<form name='modifica' action='$_SERVER[PHP_SELF]' method='POST' style='display: inline-block;'>
						<input name='seccion' type='hidden' value='".$_POST['seccion']."' />
						<input name='valor' type='hidden' value='".$RowSqlProductosValor['valor']."' />
						<input name='producto' type='hidden' value='".$RowSqlProductosValor['valor']."' />
						<input name='proname' type='hidden' value='".$RowSqlProductosValor['nombre']."' />
						<input name='psiva' type='hidden' value='".$RowSqlProductosValor['psiva']."' />
						<input name='iva' type='hidden' value='".$RowSqlProductosValor['iva']."' />
						<input name='ivae' type='hidden' value='".$RowSqlProductosValor['ivae']."' />
						<input name='pvp' type='hidden' value='".$RowSqlProductosValor['pvp']."' />
						<input name='stock' type='hidden' value='".$RowSqlProductosValor['stock']."' />
						<input name='coment' type='hidden' value='".$RowSqlProductosValor['coment']."' />
								<td class='BorderInfDch' align='right'>
						<input name='kgcash1' type='number' min='1' max='".$stock1."' size='6' maxlength='2' value='".$defaults['kgcash1']."' style='text-align:right' required title='MAXIMO ".$stock1."' />
						,
						<input name='kgcash2' type='number' min='00' max='99' size='6' maxlength='2' value='".$defaults['kgcash2']."' />
						</td>
						<td width='160px' class='BorderInfDch' align='left'>".$RowSqlProductosValor['coment']."</td>
						
					<input name='stock1' type='hidden' value='".$stock1."' />
					<input name='stock2' type='hidden' value='".$stock2."' />
						<td  align='center' class='BorderInf'>
						<div style='float:left;margin-right:3px'>
				<button type='submit' title='GUARDAR PRODUCTO' class='botonverde imgButIco CarroBlack'></button>
							<input type='hidden' name='selec_pro' value=1 />
						</div>
				</form>
				<form name='ver' action='ProductosVerImg.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=440px, height=640px')\" style='display: inline-block;'>
					<input name='seccion' type='hidden' value='".$_POST['seccion']."' />
					<input name='id' type='hidden' value='".$RowSqlProductosValor['id']."' />
					<input name='valor' type='hidden' value='".$RowSqlProductosValor['valor']."' />
					<input name='nombre' type='hidden' value='".$RowSqlProductosValor['nombre']."' />
					<input name='ref' type='hidden' value='".$RowSqlProductosValor['ref']."' />
						<div style='float:left;margin-right:1px'>
				<button type='submit' title='IMAGENES PRODUCTO' class='botonazul imgButIco FotoBlack'></button>
							<input type='hidden' name='oculto2' value=1 />
						</div>
				</form></td></tr>");
			}else{ }
				} // FIN DEL WHILE
				print("</table>");
			} // FIN DEL SEGUNDO ANIDADO IF
		} // FIN DEL PRIMER ELSE
		
	}	// FIN process_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function modif_pro($errors=[]){
	global $db;			global $db_name;
	require "../config/TablesNames.php";

	global $semana;		$semana = date('W');	
	global $date;		$date = date('Y-m-d');
	global $ATime;		$ATime = date('H:i:s');
	global $datecash;	$datecash = $date."/".$ATime;

	$nkgcashx = strlen(trim($_POST['kgcashx']));
	$nkgcashx = $nkgcashx - 3;
	$kgcashx = $_POST['kgcashx'];
	global $kgcash1x;		$kgcash1x = substr($_POST['kgcashx'],0,$nkgcashx);
	global $kgcash2x;		$kgcash2x = substr($_POST['kgcashx'],-2,2);
			
	$nstock = strlen(trim($_POST['stock']));
	$nstock = $nstock - 3;
	$stockx = $_POST['stock'];
	$stock1 = substr($_POST['stock'],0,$nstock);
	$stock2 = substr($_POST['stock'],-2,2);
	$stock1Max = $stock1+$kgcash1x;
	//echo "** ".$stock1Max."<br>";

	$_SESSION['modif1e'] = $kgcash1x;		$_SESSION['modif1d'] = $kgcash2x;
	unset ($_SESSION['modif2e']);			unset ($_SESSION['modif2d']);

	if(isset($_POST['modif_pro'])){
				$defaults = array ( 'kgcash1' => $kgcash1x,
									'kgcash2' => $kgcash2x,);
	}elseif(isset($_POST['modif_pro2'])){
				$defaults = array ( 'kgcash1' => $_SESSION['modif1e'],
									'kgcash2' => $_SESSION['modif1d'],);
	}
	global $KeyErrors;		$KeyErrors == 3;	global $LogText;

	require 'TableValidateErrors.php';

	//$fil = "%".$_POST['producto']."%";
 	//$SqlProductosValor = "SELECT * FROM $Productos WHERE `valor` LIKE '$fil' ";
	//$QrySqlProductosValor = mysqli_query($db, $SqlProductosValor);
	
	//$SqlSeccionesValor =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[vseccion]'";
		//$QrySqlSeccionesValor = mysqli_query($db, $SqlSeccionesValor);
		//$RowSqlSeccionesValor = mysqli_fetch_assoc($QrySqlSeccionesValor);

		print ("<table align='center' class='PrintNone'>
				<tr style='font-size:14px'>
					<th colspan=12 class='BorderInf'>
							MODIFICAR PEDIDO CAJA SESION ".$_SESSION['oper']." 
					</th>
				</tr>
				<tr style='font-size:10px'>
					<th class='BorderInfDch'>CAJERO</th>
					<th class='BorderInfDch'>CLIENTE</th>
					<th class='BorderInfDch'>OPER SESION</th>
					<th class='BorderInfDch'>FECHA</th>	
					<th class='BorderInfDch'>SECCION</th>										
					<th class='BorderInfDch'>PRODUCTO</th>
					<th class='BorderInfDch'>STOCK</th>
					<th class='BorderInfDch'>CARRO</th>
					<th class='BorderInfDch'>IVA€</th>
					<th class='BorderInfDch'>PVP</th>
					<th class='BorderInfDch'></th>
					<th class='BorderInf'></th>
				</tr>");
		
		print("<tr align='center'>
					<td class='BorderInfDch' align='left'>".$_POST['refcaja']."</td>
					<td class='BorderInfDch' align='left'>".$_POST['refclient']."</td>
					<td class='BorderInfDch' align='right'>".$_POST['oper']."</td>
					<td class='BorderInfDch' align='right'>".$_POST['datecash']."</td>
					
					<td class='BorderInfDch' align='right'>".$_POST['vseccion']."</td>
					<td class='BorderInfDch' align='right'>".$_POST['producto']."</td>
					
					<td class='BorderInfDch' align='right'>".$_POST['stock']."</td>
					<td class='BorderInfDch' align='right'>
			<form name='modifica'  action='$_SERVER[PHP_SELF]' method='POST'>
				<input type='hidden' name='id' value='".$_POST['id']."' />
				<input type='hidden' name='cname' value='".$_POST['cname']."' />
				<input type='hidden' name='proname' value='".$_POST['proname']."' />
				<input type='hidden' name='psiva' value='".$_POST['psiva']."' />
				<input type='hidden' name='iva' value='".$_POST['iva']."' />
				<input type='hidden' name='refcaja' value='".$_POST['refcaja']."' />
				<input type='hidden' name='refclient' value='".$_POST['refclient']."' />
				<input type='hidden' name='oper' value='".$_POST['oper']."' />
				<input type='hidden' name='nsemana' value='".$_POST['nsemana']."' />
				<input type='hidden' name='datecash' value='".$_POST['datecash']."' />
				<input type='hidden' name='vseccion' value='".$_POST['vseccion']."' />
				<input type='hidden' name='seccion' value='".$_POST['vseccion']."' />
				<input type='hidden' name='producto' value='".$_POST['producto']."' />
				<input type='hidden' name='stock' value='".$_POST['stock']."' />
				<input type='hidden' name='stock1' value='".$stock1."' />
				<input type='hidden' name='stock2' value='".$stock2."' />
				<input type='hidden' name='kgcashx' value='".$_POST['kgcashx']."' />
				<input type='number' name='kgcash1' min='00' max='".$stock1Max."' size='6' maxlength='2' value='".$defaults['kgcash1']."' style='text-align:right' />
				,
				<input type='number' name='kgcash2' min='00' max='99' size='6' maxlength='2' value='".$defaults['kgcash2']."' />
					</td>
					<td class='BorderInfDch' align='right'>
				<input type='hidden' name='ivae' value='".$_POST['ivae']."' />".$_POST['ivae']."
					</td>
					<td class='BorderInfDch' align='right'>
				<input type='hidden' name='pvp' value='".$_POST['pvp']."' />".$_POST['pvp']."
					</td>
					<td class='BorderInfDch' align='right'>
				<input type='hidden' name='pvptot' value='".$_POST['pvptot']."' />".$_POST['pvptot']."
					</td>
					<td colspan=2 align='center' class='BorderInf'>
						<div style='float:left;margin-right:6px'>
				<button type='submit' title='MODIFICAR PRODUCTO' class='botonverde imgButIco CarroBlack'></button>
							<input type='hidden' name='modif_pro2' value=1 />
						</div>
						</td>
				</form>
			</tr>");
		subtotal();
		
		if($_POST['producto']==''){ $LogText = $LogText.'TODOS LOS PRODUCTOS';}
		else{ $LogText = $LogText.$_POST['producto']; }
		$LogText = $LogText."* MODIF PRO =>\t* SESSION OPER ".$_SESSION['oper']."\t* REF CLIENTE ".$_POST['refclient']."\t* SECCION ".$_POST['vseccion']."\t* PRODUCTO ".$_POST['producto']."\t	* UNIT CAJA ".$_POST['kgcashx']."\t* PVP ".$_POST['pvp']."\t* PVPTOT ".$_POST['pvptot']."\n";
		print("</table>");
		
	}	// FIN process_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function modif_pro2(){
	global $db;		global $db_name;	
	require "../config/TablesNames.php";
	
	global $secc2;		$secc2 = ucwords($_POST['vseccion']);
	
	global $semana;		$semana = date('W');	
	global $date;		$date = date('Y-m-d');
	global $ATime;		$ATime = date('H:i:s');
	global $datecash;	$datecash = $date."/".$ATime;

	$kgcash1 = $_POST['kgcash1'];	
	$kgcash2 = $_POST['kgcash2'];
	global $kgcash;		$kgcash = $kgcash1.".".$kgcash2;

	$_SESSION['modif2e'] = $_POST['kgcash1'];
	$_SESSION['modif2d'] = $_POST['kgcash2'];
	
	global $kgcashold;
	$kgcashold = $_SESSION['modif1e'].".".$_SESSION['modif1d'];
	$kgcashold = trim($kgcashold);
	
	global $mdf;
	switch (true) {
		case (($_SESSION['modif2e'] == $_SESSION['modif1e'])&&($_SESSION['modif2d'] == $_SESSION['modif1d'])):
				$mdf = $kgcash - $kgcashold;
				//print("* IGUAL COMPRA QUE ANTES ".$kgcash." - ".$kgcashold." = ".$mdf."</br>");
			break;
		case (($_SESSION['modif2e'] > $_SESSION['modif1e'])&&($_SESSION['modif2d'] > $_SESSION['modif1d'])):
				$mdf = $kgcash - $kgcashold;
				//print("* MAS COMPRA QUE ANTES ".$kgcash." > ".$kgcashold." = ".$mdf."</br>");
			break;
		case (($_SESSION['modif2e'] > $_SESSION['modif1e'])&&($_SESSION['modif2d'] < $_SESSION['modif1d'])):
				$mdf = $kgcash - $kgcashold;
				//print("* MAS COMPRA QUE ANTES ".$kgcash." > ".$kgcashold." = ".$mdf."</br>");
			break;
		case (($_SESSION['modif2e'] == $_SESSION['modif1e'])&&($_SESSION['modif2d'] > $_SESSION['modif1d'])):
				$mdf = $kgcash - $kgcashold;
				//print("* MAS COMPRA QUE ANTES ".$kgcash." > ".$kgcashold." = ".$mdf."</br>");
			break;
		case (($_SESSION['modif2e'] > $_SESSION['modif1e'])&&($_SESSION['modif2d'] == $_SESSION['modif1d'])):
				$mdf = $kgcash - $kgcashold;
				//print("* MAS COMPRA QUE ANTES ".$kgcash." > ".$kgcashold." = ".$mdf."</br>");
			break;
		case (($_SESSION['modif2e'] < $_SESSION['modif1e'])&&($_SESSION['modif2d'] < $_SESSION['modif1d'])):
				$mdf = $kgcash - $kgcashold;
				//print("* MENOS COMPRA QUE ANTES ".$kgcash." < ".$kgcashold." = ".$mdf."</br>");
			break;
		case (($_SESSION['modif2e'] < $_SESSION['modif1e'])&&($_SESSION['modif2d'] > $_SESSION['modif1d'])):
				$mdf = $kgcash - $kgcashold;
				//print("* MENOS COMPRA QUE ANTES ".$kgcash." < ".$kgcashold." = ".$mdf."</br>");
			break;
		case (($_SESSION['modif2e'] == $_SESSION['modif1e'])&&($_SESSION['modif2d'] < $_SESSION['modif1d'])):
				$mdf = $kgcash - $kgcashold;
				//print("* MENOS COMPRA QUE ANTES ".$kgcash." < ".$kgcashold." = ".$mdf."</br>");
			break;
		case (($_SESSION['modif2e'] < $_SESSION['modif1e'])&&($_SESSION['modif2d'] == $_SESSION['modif1d'])):
				$mdf = $kgcash - $kgcashold;
				//print("* MENOS COMPRA QUE ANTES ".$kgcash." < ".$kgcashold." = ".$mdf."</br>");
			break;
		default:
				print("* NO SE CUMPLE EL SWITCH L.2143</br>");
			break;
	} // FIN DEL SWITCH

	$pvp = $_POST['pvp'];	$pvp = floatval($pvp);	$pvp = number_format($pvp,2,".","");
	$pvptot = $kgcash * $pvp ;
	$pvptot = floatval($pvptot);		$pvptot = number_format($pvptot,2,".","");
	
	$_SESSION['pvptotold'] = $_POST['pvptot'];
	$pvptotold = $_POST['pvptot'];			$pvptotold = trim($pvptotold);		
	$pvptotold = floatval($pvptotold);		$pvptotold = number_format($pvptotold,2,".","");
	
	$ivaop = $_POST['iva'];		$ivaop  = floatval($ivaop);		$ivaop  = number_format($ivaop ,2,".","");
	$ivae = $_POST['psiva'] * ($ivaop / 100);
	$ivae  = floatval($ivae);	$ivaop  = number_format($ivaop ,2,".","");
	$ivav = $ivae * $kgcash;	$ivav  = floatval($ivav);		$ivav  = number_format($ivav ,2,".","");

	$tabla = "<table align='center' style='margin-top:10px'>
				<tr>
					<th colspan=4 >SECCION: ".strtoupper($secc2)."</th>
				</tr>
				<tr>
					<td style='text-align:right'>NAME</td><td>".$_POST['proname']."</td>
					<td style='text-align:right'>REF</td><td>".$_POST['producto']."</td>
				</tr>
				<tr>
					<td style='text-align:right'>UNIT VENTA</td><td>".$kgcash."</td>
					<td style='text-align:right'>CAJA TOT €</td><td>".$pvptot." €</td>
				</tr>				
				<tr>
					<td style='text-align:right'>PVP SIN IVA</td><td>".$_POST['psiva']." €</td>
					<td style='text-align:right'>TIPO IVA</td><td>".$_POST['iva']." %</td>
				</tr>
				<tr>
					<td style='text-align:right'>IVA €</td><td>".$ivav." €</td>
					<td style='text-align:right'>UNIT € PVP</td><td>".$_POST['pvp']." €</td>
				</tr>
			</table>";	/* Final de la variable*/ 
		
	global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
		
	$SqlUpdateCajaShop = "UPDATE `$db_name`.$CajaShop SET `kgcash` = '$kgcash', `ivae` = '$ivav', `pvptot` = '$pvptot' WHERE `id` = '$_POST[id]' AND `oper` = '$RefOperShop'  LIMIT 1 ";
		
	global $LogText;
	if(mysqli_query($db, $SqlUpdateCajaShop)){ 
		print( $tabla );
		if($_POST['producto']==''){ $LogText = $LogText.'TODOS LOS PRODUCTOS';
		}else{ $LogText = $LogText.$_POST['producto'];}
		$LogText = $LogText."* MODIF PRO 2 =>\t* SESSION OPER ".$_SESSION['oper']."\t* REF CLIENTE ".$_POST['refclient']."\t* SECCION ".$_POST['vseccion']."\t	* PRODUCTO ".$_POST['producto']."\t	* UNIT CAJA ".$kgcash."\t* PVP ".$_POST['pvp']."\t* PVPTOT ".$pvptot."\n";

	}else{ print("* ERROR SQL L.2225 ".mysqli_error($db)."</br>"); }
	
	/* SUMAN O RESTA COMPRA MODIFICADA A STOCKS	*/														
	global $db;		global $db_name;
	global $seccx;	$seccx = $_POST['vseccion'];	$seccx = "`".$seccx."`";
	global $refpro;	$refpro = $_POST['producto']; /* ref pro */

	$SqlProductosValor = "SELECT * FROM $Productos WHERE `valor` = '$refpro' AND `stock` > 0 ";
		$QrySqlProductosValor = mysqli_query($db, $SqlProductosValor);
		$RowSqlProductosValor = mysqli_fetch_assoc($QrySqlProductosValor);
	
	if(mysqli_num_rows($QrySqlProductosValor) > 0){
	/* SUMA O RESTA AL STOCK EL CARRO MODIFICADO */
		$cuadrastock = $RowSqlProductosValor['kgcash'] + $mdf;
		$cuadrastock1 = $RowSqlProductosValor['stock'] - $mdf;
	/* ACTUALIZO TABLA DE PRODUCTOS */
		$SqlUpdateProductos = "UPDATE `$db_name`.$Productos SET `ivae` = '$ivav', `kgcash` = '$cuadrastock', `stock` = '$cuadrastock1' WHERE $Productos.`valor` = '$refpro' AND `stock` > 0  LIMIT 1 ";
		if(mysqli_query($db, $SqlUpdateProductos)){
			//print("* MODIF PRO 2 ACTUALIZADO STOCK ".$seccx." ".$Productos."</br>" );
			$LogText = $LogText."\t* MODIF PRO 2 ACTUALIZADO STOCK ".$seccx." ".$Productos.".\n";
		}else{ print("* ERROR SQL L.2251 ".mysqli_error($db)."<br>"); }
	}else{ }

}	/* FIN modifica_pro2() */	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function elim_pro(){
	global $db;		global $db_name;
	require "../config/TablesNames.php";

	global $semana;		$semana = date('W');	
	global $date;		$date = date('Y-m-d');
	global $ATime;		$ATime = date('H:i:s');
	global $datecash;	$datecash = $date."/".$ATime;
		
	$nkgcash = strlen(trim($_POST['kgcash']));
	$nkgcash = $nkgcash - 3;
	$kgcashx = $_POST['kgcash'];
	$kgcash1 = substr($_POST['kgcash'],0,$nkgcash);
	$kgcash2 = substr($_POST['kgcash'],-2,2);
	$kgcash = $kgcash1.",".$kgcash2;
		
	/*
	$fil = "%".$_POST['producto']."%";
 	$SqlProductosValor =  "SELECT * FROM $Productos WHERE `valor` LIKE '$fil' ";
		$QrySqlProductosValor = mysqli_query($db, $SqlProductosValor);
	
	$SqlSeccionesValor =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[vseccion]'";
		$QrySqlSeccionesValor = mysqli_query($db, $SqlSeccionesValor);
		$RowSqlSeccionesValor = mysqli_fetch_assoc($QrySqlSeccionesValor);
	*/
	print("<table align='center'>
			<tr style='font-size:14px'>
				<th colspan=12 class='BorderInf'>
					ELIMINARÁ EL PRODUCTO EN ".$_SESSION['oper']." 
				</th>
			</tr>
			<tr style='font-size:10px'>
				<th class='BorderInfDch'>CAJERO</th>					
				<th class='BorderInfDch'>CLIENTE</th>
				<th class='BorderInfDch'>OPER SESION</th>					
				<th class='BorderInfDch'>FECHA</th>					
				<th class='BorderInfDch'>SECCION</th>										
				<th class='BorderInfDch'>PRODUCTO</th>
				<th class='BorderInfDch'>CARRO</th>
				<th class='BorderInfDch'>IVA€</th>
				<th class='BorderInfDch'>PVP</th>
				<th class='BorderInfDch'>SUBT</th>
				<th class='BorderInf'>
					<form name='subtotal' method='post' action='$_SERVER[PHP_SELF]'>
			<button type='submit' title='CANCELAR ELIMINAR' class='botonverde imgButIco CarroBlack'></button>
						<input type='hidden' name='subtotal' value=1 />
					</form>	
				</th>
			</tr>");
				
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
			<input name='kgcash' type='hidden' value='".$_POST['kgcash']."' />".$_POST['kgcash']."
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
		<button type='submit' title='CONFIRME ELIMINAR PRODUCTO' class='botonrojo imgButIco DeleteBlack'></button>
						<input type='hidden' name='elim_pro2' value=1 />
			</form>
					</td>
				</tr>");

		global $LogText;
		if($_POST['producto']==''){ $LogText = $LogText.'TODOS LOS PRODUCTOS';
		}else{ $LogText = $LogText.$_POST['producto'];}
		$LogText = $LogText."* ELIMINAR PRO 01 =>* SESSION OPER ".$_SESSION['oper']."\t* REF CLIENTE ".$_POST['refclient']."\t* SECCION ".$_POST['vseccion']."\t* PRODUCTO ".$_POST['producto']."\t* UNIT CAJA ".$_POST['kgcash']."\t* PVP ".$_POST['pvp']."\t* PVPTOT ".$_POST['pvptot']."\n";

		print("</table>");
		
	} // FINAL process_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function elim_pro2(){
	global $db;		global $db_name;	
	require "../config/TablesNames.php";
	
	global $semana;		$semana = date('W');	
	global $date;		$date = date('Y-m-d');
	global $ATime;		$ATime = date('H:i:s');
	global $datecash;	$datecash = $date."/".$ATime;
	
	$secc2 = ucwords($_POST['vseccion']);

	global $kgcash;					$kgcash = $_POST['kgcash'];
	$kgcash  = floatval($kgcash);	$kgcash = number_format($kgcash,2,".","");

	global $pvp;					$pvp = $_POST['pvp'];
	$pvp  = floatval($pvp);			$pvp = number_format($pvp,2,".","");
	global $pvptot;					$pvptot = $kgcash * $pvp ;
	$pvptot = floatval($pvptot);	$pvptot = number_format($pvptot,2,".","");
	
	global $ivaop;					$ivaop = $_POST['iva'];
	$ivaop = floatval($ivaop);		$ivaop = number_format($ivaop,2,".","");
	global $ivae;					$ivae = $_POST['psiva'] * ($ivaop / 100);
	$ivae = floatval($ivae);		$ivae = number_format($ivae,2,".","");
	global $ivav;					$ivav = $ivae * $kgcash;
	$ivav = floatval($ivav);		$ivav = number_format($ivav,2,".","");

	$tabla = "<table align='center' style='margin-top:10px'>
				<tr>
					<th colspan=4 class='BorderInf'>
								HA ELIMINADO EL PRODUCTO
					</th>
				</tr>
				<tr>
					<td>SECCION</td><td>".$secc2."</td>
					<td>PRODUCT REF</td><td>".$_POST['producto']."</td>
				</tr>				
				<tr>
					<td>PRODUCT NAME</td><td>".$_POST['proname']."</td>
					<td>UNIT VENTA</td><td>".$kgcash."</td>
				</tr>
				<tr>
					<td>PVP SIN IVA</td><td>".$_POST['psiva']." €</td>
					<td>TIPO IVA</td><td>".$_POST['iva']." %
					</td>
				</tr>
				<tr>
					<td>IVA €</td><td>".$ivav." €</td>
					<td>UNIT € PVP</td><td>".$_POST['pvp']." €</td>
				</tr>
				<tr>
					<td colspan='2'></td>
					<td>CAJA TOT €</td><td>".$pvptot." €</td>
				</tr>
			</table>";
		
	global $RefOperShop;	$RefOperShop = $_SESSION['oper'];
	$SqlCajaShopOperId =  "SELECT * FROM `$db_name`.$CajaShop WHERE `oper` = '$RefOperShop' AND `id` = '$_POST[id]' LIMIT 1 ";
	$QrySqlCajaShopOperId = mysqli_query($db, $SqlCajaShopOperId);
	$RowSqlCajaShopOperId = mysqli_fetch_assoc($QrySqlCajaShopOperId);
	if($RowSqlCajaShopOperId['ini'] == 1){
		$SqlCajaShopOperIni = "UPDATE `$db_name`.$CajaShop SET `ini` = '1' WHERE `oper` = '$RefOperShop' AND `ini` <> 1 LIMIT 1 ";
		if(mysqli_query($db, $SqlCajaShopOperIni)){ }else{ }
	}else{ }

	$SqlDeleteCajaShop = "DELETE FROM `$db_name`.$CajaShop WHERE `id` = '$_POST[id]' AND `oper` = '$RefOperShop'  LIMIT 1 ";
		
	global $LogText;
	if(mysqli_query($db, $SqlDeleteCajaShop)){
		print( $tabla );
		if($_POST['producto']==''){ $LogText = $LogText.'TODOS LOS PRODUCTOS';
		}else{ $LogText = $LogText.$_POST['producto'];}
		$LogText = $LogText."* ELIMINAR PRO 02 =>* SESSION OPER ".$_SESSION['oper']."\t* REF CLIENTE ".$_POST['refclient']."\t* SECCION ".$_POST['vseccion']."\t* PRODUCTO ".$_POST['producto']."\t* UNIT CAJA ".$_POST['kgcash']."\t* PVP ".$_POST['pvp']."\t* PVPTOT ".$_POST['pvptot']."\n";
	}else{ print("* ERROR SQL L.2436 ".mysqli_error($db)."</br>"); }
	
		/* SUMAN COMPRA CANCELADA A STOCKS	*/														
		global $refpro;		$refpro = $_POST['producto']; /* ref pro */
		$SqlProductosValor = "SELECT * FROM $Productos WHERE `valor` = '$refpro' AND `stock` > 0 ";
			$QrySqlProductosValor = mysqli_query($db, $SqlProductosValor);
			$RowSqlProductosValor = mysqli_fetch_assoc($QrySqlProductosValor);
		
		if(mysqli_num_rows($QrySqlProductosValor) > 0){
			/* SUMA AL STOCK AL CARRO CANCELADO */
			$cuadrakgcash = $RowSqlProductosValor['kgcash'] - $kgcash;
			$cuadrastock = $RowSqlProductosValor['stock'] + $kgcash;
			$cuadraivae = $RowSqlProductosValor['ivae'] - $ivav;
		/* ACTUALIZO TABLA DE PRODUCTOS */
		$SqlUpdateProductos = "UPDATE `$db_name`.$Productos SET `ivae` = '$cuadraivae', `kgcash` = '$cuadrakgcash', `stock` = '$cuadrastock' WHERE $Productos.`valor` = '$refpro' AND `stock` > 0  LIMIT 1 ";

			if(mysqli_query($db, $SqlUpdateProductos)){
				print( "* ELIM PRO 2 ACTUALIZADO STOCK ".$Productos." ".$Productos." ".$cuadrastock."</br>" );
				$LogText = $LogText."\t* ELIM PRO 2 ACTUALIZADO STOCK ".$Productos." ".$Productos.".\n";
			}else{ print("* ERROR SQL L.2459 ".mysqli_error($db)."<br>"); }

		}else{ }
		
	} /* FIN function elimina_pro2()  */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $db;		global $db_name;
	require "../config/TablesNames.php";

	switch (true) {
		case (isset($_POST['init_compra'])):
				$_SESSION['oper']="";
			break;
		case (isset($_POST['oper'])):
				$_SESSION['oper'] = $_POST['oper'];
			break;
		case ((!isset($_SESSION['oper']))&&(isset($_POST['oper']))):
				$_SESSION['oper'] = $_POST['oper'];
			break;
		default:
				$SqlSelectCajaShopOper = "SELECT * FROM $CajaShop WHERE `refcaja` = '$_SESSION[ref]' LIMIT 1 ";
				$QrySelectCajaShopOper = mysqli_query($db, $SqlSelectCajaShopOper);
				$RowSelectCajaShopOper = mysqli_fetch_assoc($QrySelectCajaShopOper);
				$CountSelectCajaShopOper = mysqli_num_rows($QrySelectCajaShopOper);
				if($CountSelectCajaShopOper>0){
					$_SESSION['oper'] = $RowSelectCajaShopOper['oper'];
				}else{
					//unset($_SESSION['oper']);
					$_SESSION['oper']="";
				}
			break;
	}

	global $Ordenar;
	if(isset($_POST['oculto1'])){
		//$defaults = $_POST;
		$defaults = array ('seccion' => $_POST['seccion'],
							'Orden' => $Ordenar,
							'producto' => @$_POST['producto'],);
	}elseif(isset($_POST['oculto'])){
			$defaults = $_POST;
	}else{	$defaults = array ('seccion' => @$_POST['seccion'],
								'Orden' => $Ordenar,
								'producto' => @$_POST['producto'], );
	}

	print("<table align='center' style='border:0px; margin-top:0.1em;' class='PrintNone'>
			<tr>
				<td align='center'>* CAJA SESION ".$_SESSION['oper']."</td>
			</tr>
			<tr>
				<td style='text-align:center;'>
			<form name='init_compra' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>
				<button type='submit' title='NUEVA COMPRA' class='botonverde imgButIco AddBlack'></button>
						<input type='hidden' name='init_compra' value=1 />
			</form>	
			<form name='recup_compra' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block; margin-left: -0.2em;'>
				<button type='submit' title='RECUPERAR COMPRAS' class='botonazul imgButIco CachedBlack'></button>
						<input type='hidden' name='recup_compra' value=1 />
			</form>");

	global $_SecName;		global $_SecValue;
	if(isset($_POST['seccion'])){
		$SqlSeccionesValor =  "SELECT * FROM $Secciones WHERE `valor` = '$_POST[seccion]'";
			$QrySqlSeccionesValor = mysqli_query($db, $SqlSeccionesValor);
			$RowSqlSeccionesValor = mysqli_fetch_assoc($QrySqlSeccionesValor);
		$_SecName = $RowSqlSeccionesValor['nombre'];
		$_SecValue = $RowSqlSeccionesValor['valor'];
	}else{ }

	global $RefOperShop;		global $KeyShowFormCl;		global $KeySubTotal;
	if((isset($_POST['init_compra']))||(isset($_POST['recup_compra2']))||(isset($_POST['cancel_compra']))||(isset($_POST['selec_client']))||(isset($_POST['selec_pro']))||(isset($_POST['subtotal']))||(isset($_POST['modif_pro2']))||(isset($_POST['modif_pro']))||(isset($_POST['elim_pro']))||(isset($_POST['elim_pro2']))||(isset($_POST['selec_client2']))||(isset($_POST['oculto1']))||(isset($_POST['oculto']))||(isset($_POST['todocl']))||(isset($_POST['show_formcl']))/*||(isset($_POST['pago']))*/){

		// OCULTO EL BOTON SELECCIONAR CLIENTE
		if($_SESSION['Nivel']=='cliente'){
			$BotonSelecCliente = "";
		}else{
			$BotonSelecCliente = "<form name='selec_client' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>
				<button type='submit' title='SELECCIONAR CLIENTE' class='botonazul imgButIco PersonsBlack'>
				</button>
						<input type='hidden' name='selec_client' value=1 />
					</form>";
		}

		// SI NO HAY CLIENTE SE MUESTRA EL FORMULARIO PARA SELECCIONAR UN CLIENTE
		$RefOperShop = $_SESSION['oper'];
		$sqlClName =  "SELECT * FROM `$db_name`.$CajaShop WHERE `oper` = '$RefOperShop' AND `ini` = 1 AND `clname` = '' AND `refclient` = ''  LIMIT 1 ";
			$sqlClNameQry = mysqli_query($db, $sqlClName);
			$sqlClNumsRow = mysqli_num_rows($sqlClNameQry);
			//echo "** ".$sqlClNumsRow."<br>";

		if((isset($_POST['modif_client']))||(isset($_POST['selec_client']))||(isset($_POST['recup_compra']))||(isset($_POST['show_formcl']))||(isset($_POST['todocl']))||(isset($_POST['pago']))){
				$KeyShowFormCl = 1;
		}else{ $KeyShowFormCl = 0; }

		if(($sqlClNumsRow>0)&&($KeyShowFormCl<1)){
			print($BotonSelecCliente."<form name='subtotal' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>
			<button type='submit' title='CONTINUAR COMPRA' class='botonazul imgButIco CarroBlack'></button>
						<input type='hidden' name='subtotal' value=1 />
					</form>	
				</td></tr></table>");
			show_formcl();	$KeySubTotal = 1;
		}elseif(($KeyShowFormCl<1)&&(!isset($_POST['init_compra']))&&($sqlClNumsRow<1)){
			$KeySubTotal = 0;

		// SELECCIONA SIN REPETICION, EL VALOR DE LAS SECCIONES CON PRODUCTOS EN LA TABLA PRODUCTOS
		$SqlProductoSeccion =  "SELECT DISTINCT $Productos.`vseccion` FROM $Productos WHERE `stock`>'0' ORDER BY `vseccion` ASC ";
			$QryProductoSeccion = mysqli_query($db, $SqlProductoSeccion);

		print("<table align='center' style='border:0px;margin-top:4px;' class='PrintNone' >
				<tr>
					<td style='text-align:center; color:#F1BD2D;' >
					SELECCIONE UNA SECCION <br> Y LUEGO UN PRODUCTO
					</td>
				</tr>
				<tr>
					<td style='text-align:center'>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>
		<button type='submit' title='CONSULTAR SECCIONES' class='botonverde imgButIco BuscaBlack'></button>
				<input type='hidden' name='oculto1' value=1 />
		<select name='seccion' style='vertical-align: top !important; margin: 0.2em 0.2em 0.1em 0.2em; min-width:10.0em;' class='botonverde'>
				<option value='' >SECCIONES</option>");

		if(!$QryProductoSeccion){
				print("* ERROR SQL L.2527 ".mysqli_error($db)."</br>");
		}else{
			while($RowProductoSeccion = mysqli_fetch_assoc($QryProductoSeccion)){
			// CONSULTA EN SECCIONES CON PRODUCTOS
	$SqlSecciones = "SELECT * FROM $Secciones WHERE `valor`='$RowProductoSeccion[vseccion]' ORDER BY `valor` ASC ";
	//$SqlSecciones =  "SELECT * FROM $Secciones ORDER BY `valor` ASC ";
			$QrySecciones = mysqli_query($db, $SqlSecciones);
				// IMPRIME EL SELECT DESPLEGABLE CON LAS SECCIONES
				if(!$QrySecciones){ 
					print("* ERROR SQL L.2562 ".mysqli_error($db)."</br>");
				}else{
					while($RowsSecciones = mysqli_fetch_assoc($QrySecciones)){
							print ("<option value='".$RowsSecciones['valor']."' ");
								if($RowsSecciones['valor'] == $defaults['seccion']){
													print ("selected = 'selected'");
										}
							print ("> ".$RowsSecciones['nombre']." </option>");
					} // FIN WHILE CONSTRUYE SELECT
				}
			} // FIN PRIMER WHILE CONSULTA EN SECCIONES CON PRODUCTOS
		} // FIN ELSE CONSULTA $SqlProductoSeccion

			print ("</select></form></td></tr>");	

		if((isset($_POST['oculto1']))||(isset($_POST['oculto']))||(isset($_POST['selec_pro'])||(isset($_POST['modif_pro']))||(isset($_POST['modif_pro2'])))){

		if((!isset($_POST['seccion']))||(strlen(trim($_POST['seccion']<1)))){
			print("<table align='center' style='margin:-0.6em auto 0.8em auto;' class='PrintNone' >
					<tr align='center'>
						<td style='color:#F1BD2D;'>SELECCIONE UNA SECCION</td>
					</tr>
				</table>");
		}elseif(isset($_POST['seccion'])){
					print("<tr>
							<td style='text-align:center;' >
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;' >
				<button type='submit' title='CONSULTAR PRODUCTOS' class='botonazul imgButIco BuscaBlack' style='margin-top: -0.2em;' >
				</button>
					<input type='hidden' name='oculto' value=1 />
					<input type='hidden' name='seccion' value='".$_POST['seccion']."' />
					<input type='hidden' name='oper' value='".$_SESSION['oper']."' />
		<select name='producto'style='vertical-align: top !important; margin: -0.2em 0.2em 0.1em 0.2em; min-width:10.0em;' class='botonazul' >
			<option value=''>PRODUCTOS</option>");
				//$sqlp = "SELECT * FROM $Productos ORDER BY `valor` ASC "; 
				//$sqlp = "SELECT * FROM $Productos WHERE `vseccion` = '$_SecValue' ORDER BY `valor` ASC";
				$sqlp = "SELECT * FROM $Productos WHERE `vseccion` = '$_SecValue' ORDER BY `valor` ASC";
				$qp = mysqli_query($db, $sqlp);
					if(!$qp){
							print("* ERROR SQL L.2589 ".mysqli_error($db)."</br>");
					}else{
						while($rowp = mysqli_fetch_assoc($qp)){
							print ("<option value='".$rowp['valor']."' ");
								if($rowp['valor'] == $defaults['producto']){ print ("selected = 'selected'"); }
									print ("> ".$rowp['nombre']." </option>");
							}
					} 
					print ("</select></form></td></tr></table>");

			}else{ } // FIN if($_POST['seccion']!=''){

					if(!isset($_POST['producto'])){ subtotal(); }else{ }
			} // FIN IF OCULTO1 OCULTO2
		} // FIN IF VER FORMULARIO SECCIONES
	}else{ print("</td></tr></table>"); } // FIN PRIMER if((isset($_POST['init_compra']))||....

} // FIN function show_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function log_info(){

		global $LogText;
	
		global $LogText;	$LogText = "\n- CAJA CARRO: ".$LogText;
		
		require '../logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $caja;        $caja = '';
	
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