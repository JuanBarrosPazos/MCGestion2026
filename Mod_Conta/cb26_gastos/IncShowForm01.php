<?php

	unset($_SESSION['ImgCb23']);	unset($_SESSION['factdate']);
	unset($_SESSION['myimg1']); 	unset($_SESSION['myimg2']);
	unset($_SESSION['myimg3']); 	unset($_SESSION['myimg4']);	
	unset($_SESSION['miseccion']); 	unset($_SESSION['miid']);	
	unset($_SESSION['mivalor']); 	unset($_SESSION['minombre']);	
	unset($_SESSION['miref']); 		unset($_SESSION['midyt1']);
	unset($_SESSION['stat']);		unset($_SESSION['newDy']);
	unset($_SESSION['$nombre1n']);	unset($_SESSION['$nombre2n']);
	unset($_SESSION['$nombre3n']);	unset($_SESSION['$nombre4n']);
	unset($_SESSION['fnnew']);

	global $TitBut1;			global $TitBut2;

	global $DetalleGreyTit; 	$DetalleGreyTit = $TitBut1; 	// "VER TODOS LOS GASTOS"
	global $BuscaWhiteTit;		$BuscaWhiteTit = $TitBut2;		// "FILTRO BUSQUEDA GASTOS"
	require '../Inclu/BotoneraVar.php';
	global $closeButton;

	global $cnt; 		$cnt = 0;

	require 'ArrayMesDia.php';
	
	require 'TableIfErrors.php';

	require 'ArrayOrdenar.php';
	
	print("<table class='tableForm' >
				<tr>
					<th>".$titulo."</th>
				</tr>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td style='text-align:center;' >
				<!--
				<input type='submit' value='FILTRO GASTOS' title='FILTRO DE GASTOS' class='botonazul' />
				-->
				".$BuscaWhite.$closeButton."
				<input type='hidden' name='show_formcl' value=1 />

		<select name='Orden' title='ORDENAR POR...' class='botonlila' style='vertical-align: middle' >");
				foreach($ordenar as $option => $label){
					print ("<option value='".$option."' ");
					if($option == $defaults['Orden']){
									print ("selected = 'selected'");
										}
								print ("> $label </option>");
					}	
						
	print ("</select>
			<select name='dy' title='SELECCIONAR AÑO...' class='botonlila' style='vertical-align: middle' >
				<option value=''>YEAR</option>");
	
	global $db;
	global $t1; 		$t1 = "`".$_SESSION['clave']."status`";
	$sqly =  "SELECT * FROM $t1  WHERE `hidden` = 'no' ORDER BY `year` DESC ";
	$qy = mysqli_query($db, $sqly);				
		
	if(!$qy){print("* ".mysqli_error($db)."<br/>");
	}else{while($rowsy = mysqli_fetch_assoc($qy)){
						print ("<option value='20".$rowsy['ycod']."' ");
							if("20".($rowsy['ycod']) == @$defaults['dy']){
										print ("selected = 'selected'");
									}
										print ("> ".$rowsy['year']." </option>");
								}
							}  

	print ("</select>
			<select name='dm' title='SELECCIONAR MES...' class='botonlila' style='vertical-align: middle' >");
				foreach($dm as $optiondm => $labeldm){
					print ("<option value='".$optiondm."' ");
					if($optiondm == @$defaults['dm']){
								print ("selected = 'selected'");
									}
								print ("> $labeldm </option>");
						}	
																
	print ("</select>
			<select name='dd' title='SELECCIONAR DIA...' class='botonlila' style='vertical-align: middle' >");
				foreach($dd as $optiondd => $labeldd){
					print ("<option value='".$optiondd."' ");
					if($optiondd == @$defaults['dd']){
										print ("selected = 'selected'");
											}
									print ("> $labeldd </option>");
							}	
																
	print ("</select>
			</tr>
			<tr>					
				<td style='text-align:center;' >	
			<input type='text' name='factnum' placeholder='NÚMERO FACTURA' size=22 maxlength=20 value='".@$defaults['factnum']."' />
			<!--
			<input type='text' name='factnif' size=22 maxlength=10 value='".@$defaults['factnif']."' />
			-->
			<select name='factnif' title='NUMERO NIF FACTURA' class='botonlila'>
				<option value=''>Nº NIF</option>");
				global $db; 
				global $tabla1; 		$tabla1 = "`".$_SESSION['clave']."proveedores`";

				$sqlb =  "SELECT * FROM $tabla1 ORDER BY `rsocial` ASC ";
				$qb = mysqli_query($db, $sqlb);
				if(!$qb){
						print("* ".mysqli_error($db)."<br/>");
				} else {
					while($rows = mysqli_fetch_assoc($qb)){
						print ("<option value='".$rows['dni'].$rows['ldni']."' ");
						if($rows['dni'].$rows['ldni'] == @$defaults['factnif']){
													print ("selected = 'selected'");
															}
								print ("> ".$rows['dni'].$rows['ldni']." </option>");
							}
					}  

	print ("</select>
					<!--
					<input type='text' name='factnom' size=22 maxlength=22 value='".@$defaults['factnom']."' />
					-->
			<select name='factnom' title='RAZON SOCIAL' class='botonlila'>
				<option value=''>RAZON SOCIAL</option>");
				global $db;
				global $tabla1; 		$tabla1 = "`".$_SESSION['clave']."proveedores`";
				$sqlb =  "SELECT * FROM $tabla1 ORDER BY `rsocial` ASC ";
				$qb = mysqli_query($db, $sqlb);
				if(!$qb){
						print("* ".mysqli_error($db)."<br/>");
				} else {
					while($rows = mysqli_fetch_assoc($qb)){
						print ("<option value='".$rows['ref']."' ");
						if($rows['ref'] == @$defaults['factnom']){
											print ("selected = 'selected'");
													}
									print ("> ".$rows['rsocial']." </option>");
							}
			}

	print ("</select>
					</td>
				</tr>
			</form>");
						
	////////

	global $papelera;
	if((isset($_POST['show_formcl']))&&($papelera !=1)){ global $cnt; 	gt2(); }

	////////


	print ("<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
				<tr>
					<td style='text-align:center;' >
			<!--
			<input type='submit' value='TODOS LOS GASTOS' title='VER TODOS LOS GASTOS' class='botonazul' />
			-->
			".$DetalleGrey.$closeButton."
			<input type='hidden' name='todo' value=1 />

			<select name='Orden' title='ORDENAR POR...' class='botonazul' style='vertical-align: middle'>");
						
				foreach($ordenar as $option => $label){
					print ("<option value='".$option."' ");
					if($option == $defaults['Orden']){
										print ("selected = 'selected'");
													}
										print ("> $label </option>");
									}	
						
	print ("</select>
			<select name='dy' title='SELECCIONAR AÑO...' class='botonazul' style='vertical-align: middle' >
			<option value=''>YEAR</option>");
					
		global $db;
		global $t1; 		$t1 = "`".$_SESSION['clave']."status`";
		$sqly =  "SELECT * FROM $t1  WHERE `hidden` = 'no' ORDER BY `year` DESC ";
		$qy = mysqli_query($db, $sqly);				
			
		if(!$qy){print("* ".mysqli_error($db)."<br/>");
		}else{while($rowsy = mysqli_fetch_assoc($qy)){
							print ("<option value='20".$rowsy['ycod']."' ");
								if("20".($rowsy['ycod']) == @$defaults['dy']){
											print ("selected = 'selected'");
										}
											print ("> ".$rowsy['year']." </option>");
									}
								}  
									
	print ("</select>
			<select name='dm' title='SELECCIONAR MES...' class='botonazul' style='vertical-align: middle' >");
					foreach($dm as $optiondm => $labeldm){
								print ("<option value='".$optiondm."' ");
						if($optiondm == @$defaults['dm']){
											print ("selected = 'selected'");
													}
											print ("> $labeldm </option>");
									}	
																
	print ("</select>
			<select name='dd' title='SELECCIONAR DIA...' class='botonazul' style='vertical-align: middle'>");
						foreach($dd as $optiondd => $labeldd){
							print ("<option value='".$optiondd."' ");
							if($optiondd == @$defaults['dd']){
												print ("selected = 'selected'");
														}
												print ("> $labeldd </option>");
									}	
																
	print ("</select>
				</form>														
					</td></tr>");

	////////
		
		global $papelera;
		if((isset($_POST['todo']))&&($papelera !=1)){ gt1(); }

	////////
			
		print("	</table>"); /* Fin del print */


?>