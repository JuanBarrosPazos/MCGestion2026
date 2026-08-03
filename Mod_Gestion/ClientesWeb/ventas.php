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

if(($_SESSION['Nivel']=='cliente')){

					master_index();

								if($_POST['todo']){
										show_form();							
										ver_todo();
										log_info();
										}
								
								elseif($_POST['show_formcl']){
									
										if($form_errors = validate_form()){
											show_form($form_errors);
												}else{
													process_form();
													log_info();
													}
									}
									
								else{
										show_form();
										}
								
				}else{ 
					
											require "../Inclu/AccesoDenegado.php";			

								
							}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function validate_form(){
	
	$errors = array();
	
	if(trim($_POST['refoper']) == ''){
		$errors [] = " REF OPERACIÓN ES OBLIGATORIO";
		}
	
	return $errors;

		} /* Finaliza la función validate_form(); */
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function process_form(){
	
	show_form();

	if($_POST['dy'] == ''){ $dy1 = '';
							 $dyt1 = date('Y');	}else{$dy1 = $_POST['dy'];
														$dy1 = $dy1;
														global $dyt1;
														$dyt1 = "20".$_POST['dy'];
																					}
	if($_POST['dm'] == ''){ $dm1 = '';}else{$dm1 = $_POST['dm'];
												$dm1 = "-".$dm1."-";}
	if($_POST['dd'] == ''){ $dd1 = '';}else{$dd1 = $_POST['dd'];
												$dd1 = $dd1."/";}

	$fil = "%".$dy1.$dm1.$dd1."%";

	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }
	
	if($_POST['refoper'] == ''){$rop = '~~';}
	else{$rop = $_POST['refoper'];}
	global $refoper;
	$refoper = $_POST['refoper'];
	
	$rf = $_SESSION['ref'];
	//$rf ="%".$rf."%";

	require "../config/TablesNames.php";
	$sqlc =  "SELECT * FROM $VentasShop WHERE `refclient` = '$rf' AND `oper` = '$rop' AND  `datecash` LIKE '$fil' ORDER BY $Orden ";
 	
	$qc = mysqli_query($db, $sqlc);
	
/////////////////////	
/* PARA SUMAR PVPTOT */

if(!$qc){print(mysqli_error($db).".</br>");
}
else{
	$qpvptot = mysqli_query($db, $sqlc);
	$rowpvptot = mysqli_num_rows($qpvptot);
	$sumapvptot = 0;
		  for($i=0; $i<$rowpvptot; $i++)
										{
											$ver = mysqli_fetch_array($qpvptot);

	$sumapvptot = $sumapvptot + $ver['pvptot'];
											}
}
			
/* FIN PARA SUMAR PVPTOT */
/////////////////////////


/////////////////////	
/* PARA SUMAR IVA */

if(!$qc){print(mysqli_error($db).".</br>");
}
else{
	$qivae = mysqli_query($db, $sqlc);
	$rowivae = mysqli_num_rows($qivae);
	$sumaivae = 0;
		  for($i=0; $i<$rowivae; $i++)
										{
											$ver = mysqli_fetch_array($qivae);

	$sumaivae = $sumaivae + ($ver['ivae'] * $ver['kgcash']);
											}
}
			
/* FIN PARA SUMAR IVA */
/////////////////////////

	if(!$qc){
			print("<font color='#F1BD2D'>
					Se ha producido un error: </font>".mysqli_error($db)."</br></br>");
		}else{
			
			if(mysqli_num_rows($qc)== 0){
							print ("<table align='center' style=\"border:0px\">
										<tr>
											<td align='center'>
												<font color='#F1BD2D'>
														NINGÚN DATO SE CIÑE A ESTOS CRITERIOS.
													</br>
														INTENTELO CON OTROS PARÁMETROS.
												</font>
											</td>
										</tr>
									</table>");

				}else{ print ("<table align='center'>
									<tr>
										<th colspan=12 class='BorderInf'>
									".mysqli_num_rows($qc)." RESULTADOS.
										</th>
									</tr>
									
									<tr>
										
										<th class='BorderInfDch'>
											CJ. NAME
										</th>																			
										
										<th class='BorderInfDch'>
											REF CAJA
										</th>																			
										
										<th class='BorderInfDch'>
											CL. NAME
										</th>
										
										<th class='BorderInfDch'>
											REF CLIENT
										</th>
										
										<th class='BorderInfDch'>
											OPER SESION
										</th>																			
										
										<th class='BorderInfDch'>
											FECHA
										</th>																			
										
										<th class='BorderInfDch'>
											SECCION
										</th>										

										<th class='BorderInfDch'>
											PRODUCTO
										</th>
										
										<th bgcolor='#DCEDED' class='BorderInfDch'>
											CARRO
										</th>
										
										<th class='BorderInfDch'>
											IVA€
										</th>
										
										<th class='BorderInfDch'>
											PVP
										</th>
										
										<th bgcolor='#DCEDED' class='BorderInf'>
											SUBT
										</th>
										
									</tr>");
			
			while($rowc = mysqli_fetch_assoc($qc)){
 			
			print (	"<tr align='center'>
									
	<input name='id' type='hidden' value='".$rowc['id']."' />
	<input name='proname' type='hidden' value='".$rowc['proname']."' />
	<input name='psiva' type='hidden' value='".$rowc['psiva']."' />
	<input name='iva' type='hidden' value='".$rowc['iva']."' />

						<td class='BorderInfDch' align='center'>
	<input name='cname' type='hidden' value='".$rowc['cname']."' />".$rowc['cname']."
						</td>
	
						<td class='BorderInfDch' align='left'>
	<input name='refcaja' type='hidden' value='".$rowc['refcaja']."' />".$rowc['refcaja']."
						</td>
						
						<td class='BorderInfDch' align='center'>
	<input name='clname' type='hidden' value='".$rowc['clname']."' />".$rowc['clname']."
						</td>
						
						<td class='BorderInfDch' align='left'>
	<input name='refclient' type='hidden' value='".$rowc['refclient']."' />".$rowc['refclient']."
						</td>
						
						<td class='BorderInfDch' align='right'>
	<input name='oper' type='hidden' value='".$rowc['oper']."' />".$rowc['oper']."
						</td>
						
	<input name='nsemana' type='hidden' value='".$rowc['nsemana']."' />
						
						<td class='BorderInfDch' align='right'>
	<input name='datecash' type='hidden' value='".$rowc['datecash']."' />".$rowc['datecash']."
						</td>

						<td class='BorderInfDch' align='right'>
	<input name='vseccion' type='hidden' value='".$rowc['vseccion']."' />".$rowc['vseccion']."
						</td>

						<td class='BorderInfDch' align='right'>
	<input name='producto' type='hidden' value='".$rowc['producto']."' />".$rowc['producto']."
						</td>

						<td bgcolor='#DCEDED' class='BorderInfDch' align='right'>
	<input name='kgcash' type='hidden' value='".$rowc['kgcash']."' />".$rowc['kgcash']."
						</td>

						<td class='BorderInfDch' align='right'>
	<input name='ivae' type='hidden' value='".$rowc['ivae']."' />".$rowc['ivae']."
						</td>

						<td class='BorderInfDch' align='right'>
	<input name='pvp' type='hidden' value='".$rowc['pvp']."' />".$rowc['pvp']."
						</td>

						<td bgcolor='#DCEDED' class='BorderInf' align='right'>
	<input name='pvptot' type='hidden' value='".$rowc['pvptot']."' />".$rowc['pvptot']."
						</td>
										
		</form>
					</tr>");
								} /* Fin del while.*/ 

									print("		<tr>
										<td colspan='12' class='BorderInf'>
										</td>
									</tr>
						
									<tr>
										
										<td  colspan='5' class='BorderInf' align='right'>
												TOTALES:
										</td>
																				
										<td colspan='2' class='BorderInf' align='right'>
												IVA SOPORTADO €
										</td>
										
							<td bgcolor='#DCEDED' class='BorderInfDch' align='left'>
												".$sumaivae." .€
										</td>
										
										<td colspan='2' class='BorderInf' align='right'>
												TOTAL €
										</td>
										
							<td bgcolor='#DCEDED' colspan='2' class='BorderInf' align='left'>
												".$sumapvptot." .€
										</td>
								</tr>
						</table>
								");
			
						} /* Fin segundo else anidado en if */

			} /* Fin de primer else . */
		
	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function show_form($errors=[]){
	
	if($_POST['show_formcl']){
		$defaults = $_POST;
		}
	elseif($_POST['todo']){
		$defaults = $_POST;
		}else{global $Ordenar;
				$defaults = array ('nombre' => '',
								   'refoper' => '',
								   'refclient' => '',
								   'Orden' => $Ordenar,
								   						);

								   							}

	require '../config/ayear.php';
	
	$dm = array (	'' => 'MES',
					'01' => '01',
					'02' => '02',
					'03' => '03',
					'04' => '04',
					'05' => '05',
					'06' => '06',
					'07' => '07',
					'08' => '08',
					'09' => '09',
					'10' => '10',
					'11' => '11',
					'12' => '12',
									);
	
	$dd = array (	'' => 'DÍA',
					'01' => '01',
					'02' => '02',
					'03' => '03',
					'04' => '04',
					'05' => '05',
					'06' => '06',
					'07' => '07',
					'08' => '08',
					'09' => '09',
					'10' => '10',
					'11' => '11',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20',
					'21' => '21',
					'22' => '22',
					'23' => '23',
					'24' => '24',
					'25' => '25',
					'26' => '26',
					'27' => '27',
					'28' => '28',
					'29' => '29',
					'30' => '30',
					'31' => '31',
									);
										
	if($errors){
		print("</br><font color='#F1BD2D'>
				Solucione estos errores: </font></br>");
		
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#F1BD2D'>* </font>".$errors [$a]."</br>");
			}
		}
		
	$Ordenar = array (	'`oper` ASC' => 'Operacion Asc',
						'`oper` DESC' => 'Operacion Desc',
						'`clname` ASC' => 'Nombre Cliente Asc',
						'`clname` DESC' => 'Nombre Cliente Desc',
						'`refclient` ASC' => 'Ref Cliente Asc',
						'`refclient` DESC' => 'Ref Cliente Desc',
						'`cname` ASC' => 'Nombre Caja Asc',
						'`cname` DESC' => 'Nombre Caja Des',
						'`refcaja` ASC' => 'Ref Caja Asc',
						'`refcaja` DESC' => 'Ref Caja Desc',
																);

	print("
			<table align='center' style=\"border:0px;margin-top:4px\">
				<tr>
					<th colspan=2>
						CONSULTAR COMPRAS
					</th>
				</tr>
				
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
						
				<tr>
					<td align='right'>
						<input type='submit' value='FILTRO VENTAS' />
						<input type='hidden' name='show_formcl' value=1 />
					</td>
					
					<td class='BorderSup'>

					<div style='float:left'>

						<select name='Orden'>");
						
				foreach($Ordenar as $option => $label){
					
					print ("<option value='".$option."' ");
					
					if($option == $defaults['Orden']){
															print ("selected = 'selected'");
																								}
													print ("> $label </option>");
												}	
						
	print ("	</select>
	
						</div>

					<div style='float:left'>

						<select name='dy'>");

				foreach($dy as $optiondy => $labeldy){
					
					print ("<option value='".$optiondy."' ");
					
					if($optiondy == $defaults['dy']){
															print ("selected = 'selected'");
																								}
													print ("> $labeldy </option>");
												}	
																
	print ("	</select>
					</div>

					<div style='float:left'>

						<select name='dm'>");

				foreach($dm as $optiondm => $labeldm){
					
					print ("<option value='".$optiondm."' ");
					
					if($optiondm == $defaults['dm']){
															print ("selected = 'selected'");
																								}
													print ("> $labeldm </option>");
												}	
																
	print ("	</select>
					</div>

					<div style='float:left'>

						<select name='dd'>");

				foreach($dd as $optiondd => $labeldd){
					
					print ("<option value='".$optiondd."' ");
					
					if($optiondd == $defaults['dd']){
															print ("selected = 'selected'");
																								}
													print ("> $labeldd </option>");
												}	
																
	print ("	</select>
					</div>

					</td>
					
				</tr>
	
				<tr>
					<td>
					</td>
					<td>	
						REF OPERACIÓN
	<div style='float:right'>
	<input type='text' name='refoper' size=22 maxlength=20 value='".$defaults['refoper']."' />
	</div>
					</td>
				</tr>
	
		</form>	
				
		<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
		
				<tr>
					<td align='center' class='BorderSup'>
						<input type='submit' value='TODAS LAS VENTAS' />
						<input type='hidden' name='todo' value=1 />
					</td>
					<td class='BorderSup'>	

					<div style='float:left'>

						<select name='Orden'>");
						
				foreach($Ordenar as $option => $label){
					
					print ("<option value='".$option."' ");
					
					if($option == $defaults['Orden']){
															print ("selected = 'selected'");
																								}
													print ("> $label </option>");
												}	
						
	print ("	</select>
	
						</div>

					<div style='float:left'>

						<select name='dy'>");
				
				foreach($dy as $optiondy => $labeldy){
					
					print ("<option value='".$optiondy."' ");
					
					if($optiondy == $defaults['dy']){
															print ("selected = 'selected'");
																								}
													print ("> $labeldy </option>");
												}	
																
	print ("	</select>
					</div>

					<div style='float:left'>

						<select name='dm'>");

				foreach($dm as $optiondm => $labeldm){
					
					print ("<option value='".$optiondm."' ");
					
					if($optiondm == $defaults['dm']){
															print ("selected = 'selected'");
																								}
													print ("> $labeldm </option>");
												}	
																
	print ("	</select>
					</div>

					<div style='float:left'>

						<select name='dd'>");

				foreach($dd as $optiondd => $labeldd){
					
					print ("<option value='".$optiondd."' ");
					
					if($optiondd == $defaults['dd']){
															print ("selected = 'selected'");
																								}
													print ("> $labeldd </option>");
												}	
																
	print ("	</select>
					</div>

					</td>
				</tr>
		
		</form>														
			
			</table>				
						"); 
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
///

function ver_todo(){
		
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }

	if($_POST['dy'] == ''){ $dy1 = '';
							 $dyt1 = date('Y');	}else{$dy1 = $_POST['dy'];
														$dy1 = $dy1;
														global $dyt1;
														$dyt1 = "20".$_POST['dy'];
																	}
	if($_POST['dm'] == ''){ $dm1 = '';}else{	$dm1 = $_POST['dm'];
													$dm1 = "-".$dm1."-";
																	}
	if($_POST['dd'] == ''){ $dd1 = '';}else{	$dd1 = $_POST['dd'];
													$dd1 = $dd1."/";
																	}
																	
	$fil = "%".$dy1.$dm1.$dd1."%";

	$rf = $_SESSION['ref'];
	//$rf ="%".$rf."%";

	require "../config/TablesNames.php";
	$sqlb =  "SELECT * FROM $VentasShop WHERE `refclient` = '$rf' AND `datecash` LIKE '$fil' ORDER BY $Orden ";
	$qb = mysqli_query($db, $sqlb);
	
/////////////////////	
/* PARA SUMAR PVPTOT */

if(!$qb){print(mysqli_error($db).".</br>");
}
else{
	$qpvptot = mysqli_query($db, $sqlb);
	$rowpvptot = mysqli_num_rows($qpvptot);
	$sumapvptot = 0;
		  for($i=0; $i<$rowpvptot; $i++)
										{
											$ver = mysqli_fetch_array($qpvptot);

	$sumapvptot = $sumapvptot + $ver['pvptot'];
											}
}
			
/* FIN PARA SUMAR PVPTOT */
/////////////////////////


/////////////////////	
/* PARA SUMAR IVA */

if(!$qb){print(mysqli_error($db).".</br>");
}
else{
	$qivae = mysqli_query($db, $sqlb);
	$rowivae = mysqli_num_rows($qivae);
	$sumaivae = 0;
		  for($i=0; $i<$rowivae; $i++)
										{
											$ver = mysqli_fetch_array($qivae);

	$sumaivae = $sumaivae + ($ver['ivae'] * $ver['kgcash']);
											}
}
			
/* FIN PARA SUMAR IVA */
/////////////////////////

	if(!$qb){
			print("<font color='#F1BD2D'>Se ha producido un error: </font></br>".mysqli_error($db)."</br>");
			
		}else{
			
			if(mysqli_num_rows($qb)== 0){
							print ("<table align='center'>
										<tr>
											<td>
												<font color='#F1BD2D'>
													NO HAY DATOS
												</font>
											</td>
										</tr>
									</table>");
									

				}else{ print ("<table align='center'>
									<tr>
										<th colspan=12 class='BorderInf'>
									".mysqli_num_rows($qb)." RESULTADOS.
										</th>
									</tr>
									
									<tr>
										
										<th class='BorderInfDch'>
											CJ. NAME
										</th>																			
										
										<th class='BorderInfDch'>
											REF CAJA
										</th>																			
										
										<th class='BorderInfDch'>
											CL. NAME
										</th>
										
										<th class='BorderInfDch'>
											REF CLIENT
										</th>
										
										<th class='BorderInfDch'>
											OPER SESION
										</th>																			
										
										<th class='BorderInfDch'>
											FECHA
										</th>																			
										
										<th class='BorderInfDch'>
											SECCION
										</th>										

										<th class='BorderInfDch'>
											PRODUCTO
										</th>
										
										<th bgcolor='#DCEDED' class='BorderInfDch'>
											CARRO
										</th>
										
										<th class='BorderInfDch'>
											IVA€
										</th>
										
										<th class='BorderInfDch'>
											PVP
										</th>
										
										<th bgcolor='#DCEDED' class='BorderInf'>
											SUBT
										</th>
										
									</tr>");
			
			while($rowb = mysqli_fetch_assoc($qb)){

			print (	"<tr align='center'>
									
<form name='ver' action='ClienteVer02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=500px,height=610px')\">

	<input name='id' type='hidden' value='".$rowb['id']."' />
	<input name='proname' type='hidden' value='".$rowb['proname']."' />
	<input name='psiva' type='hidden' value='".$rowb['psiva']."' />
	<input name='iva' type='hidden' value='".$rowb['iva']."' />

						<td class='BorderInfDch' align='center'>
	<input name='cname' type='hidden' value='".$rowb['cname']."' />".$rowb['cname']."
						</td>
	
						<td class='BorderInfDch' align='left'>
	<input name='refcaja' type='hidden' value='".$rowb['refcaja']."' />".$rowb['refcaja']."
						</td>
						
						<td class='BorderInfDch' align='center'>
	<input name='clname' type='hidden' value='".$rowb['clname']."' />".$rowb['clname']."
						</td>
						
						<td class='BorderInfDch' align='left'>
	<input name='refclient' type='hidden' value='".$rowb['refclient']."' />".$rowb['refclient']."
						</td>
						
						<td class='BorderInfDch' align='right'>
	<input name='oper' type='hidden' value='".$rowb['oper']."' />".$rowb['oper']."
						</td>
						
	<input name='nsemana' type='hidden' value='".$rowb['nsemana']."' />
						
						<td class='BorderInfDch' align='right'>
	<input name='datecash' type='hidden' value='".$rowb['datecash']."' />".$rowb['datecash']."
						</td>

						<td class='BorderInfDch' align='right'>
	<input name='vseccion' type='hidden' value='".$rowb['vseccion']."' />".$rowb['vseccion']."
						</td>

						<td class='BorderInfDch' align='right'>
	<input name='producto' type='hidden' value='".$rowb['producto']."' />".$rowb['producto']."
						</td>

						<td bgcolor='#DCEDED' class='BorderInfDch' align='right'>
	<input name='kgcash' type='hidden' value='".$rowb['kgcash']."' />".$rowb['kgcash']."
						</td>

						<td class='BorderInfDch' align='right'>
	<input name='ivae' type='hidden' value='".$rowb['ivae']."' />".$rowb['ivae']."
						</td>

						<td class='BorderInfDch' align='right'>
	<input name='pvp' type='hidden' value='".$rowb['pvp']."' />".$rowb['pvp']."
						</td>

						<td bgcolor='#DCEDED' class='BorderInf' align='right'>
	<input name='pvptot' type='hidden' value='".$rowb['pvptot']."' />".$rowb['pvptot']."
						</td>
										
		</form>
					</tr>");
								} /* Fin del while.*/ 

									print("		<tr>
										<td colspan='12' class='BorderInf'>
										</td>
									</tr>
						
									<tr>
										
										<td  colspan='5' class='BorderInf' align='right'>
												TOTALES:
										</td>
																				
										<td colspan='2' class='BorderInf' align='right'>
												IVA SOPORTADO €
										</td>
										
										<td bgcolor='#DCEDED' class='BorderInfDch' align='left'>
												".$sumaivae." .€
										</td>
										
										<td colspan='2' class='BorderInf' align='right'>
												TOTAL €
										</td>
										
						<td colspan='2' bgcolor='#DCEDED' class='BorderInf' align='left'>
												".$sumapvptot." .€
										</td>
										
								</tr>
						</table>
								");
			
						} /* Fin segundo else anidado en if */

			} /* Fin de primer else . */
		
	}	/* Final  ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
				require '../Inclu/Master_In_Clientes.php';
		
				} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	global $nombre;
	global $apellido;
	
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }
	
	if($_POST['todo']){$nombre = "TODOS LOS USUARIOS ".$Orden;}

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- CLIENTE VER ".$ActionTime.". ".$nombre." ".$apellido;
	
	require 'logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Inclu_Footer.php';
		
?>