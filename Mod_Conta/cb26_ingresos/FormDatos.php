<?php

	global $KeyModif;	global $rutPend;

	print("<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
                <input type='hidden' name='id' value='".@$defaults['id']."' />
                <input type='hidden' name='clienteingresos' value='".$defaults['clienteingresos']."' />
				<tr>
					<td style='text-align:right;'>NUMERO</td>
					<td>
		<input type='text' name='factnum' size=22 maxlength=20 value='".strtoupper(@$defaults['factnum'])."' required />
		<input type='hidden' name='factnumini' value='".strtoupper(@$defaults['factnumini'])."' />** ".strtoupper(@$defaults['factnumini'])."
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>FECHA</td>
					<td>
				<div style='float:left'>");

		if(($rutPend == 'Pendientes')||($KeyModif == 1)){

		print("<input type='hidden' name='dy' value='".@$defaults['dy']."' />
				<span class='botonverde'>".@$defaults['dy']."</span>");
		}else{	

		print("<select name='dy' title='SELECCIONAR AÑO..' class='botonverde' style='vertical-align: middle;' required >
			<option value=''>YEAR</option>");
			global $db;
			global $t1; 		$t1 = "`".$_SESSION['clave']."status`";

			$sqly =  "SELECT * FROM $t1 WHERE `stat` = 'open' ORDER BY `year` DESC ";

			$qy = mysqli_query($db, $sqly);				
				
			if(!$qy){
					print("* ".mysqli_error($db)."<br/>");
			}else{
				while($rowsy = mysqli_fetch_assoc($qy)){
						print ("<option value='20".$rowsy['ycod']."' ");
							if(("20".$rowsy['ycod']) == @$defaults['dy']){
									print ("selected = 'selected'");
															}
									print ("> ".$rowsy['year']." </option>");
										}
				}  
		} // FIN ELSE	

		print ("</select>
					</div>
					<div style='float:left'>
				<select style='margin-left:12px' name='dm' class='botonverde' required >");
					foreach($dm as $optiondm => $labeldm){
						print ("<option value='".$optiondm."' ");
					if($optiondm == @$defaults['dm']){
										print ("selected = 'selected'");
											}
								print ("> $labeldm </option>");
							}	
																
		print ("</select>
					</div>
					<div style='float:left'>
						<select style='margin-left:12px' name='dd' class='botonverde' required >");
			foreach($dd as $optiondd => $labeldd){
						print ("<option value='".$optiondd."' ");
					if($optiondd == @$defaults['dd']){
										print ("selected = 'selected'");
											}
							print ("> $labeldd </option>");
						}
							
		print ("</select> 
					</div>
					</td>
				</tr>

		<input type='hidden' name='factdate'value='".@$defaults['dy']."-".@$defaults['dm']."-".@$defaults['dd']."' />
		<input type='hidden' name='factdateini'value='".@$defaults['factdateini']."' />
		<input type='hidden' name='factcrea'value='".@$defaults['factcrea']."' />
		<input type='hidden' name='factmodif'value='".@$defaults['factmodif']."' />
	
				<tr>
					<td style='text-align:right;'>RAZON SOCIAL</td>
					<td>
		<input type='hidden' name='factnom' value='".@$defaults['factnom']."' />".@$defaults['factnom']."
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>REFERENCIA</td>
					<td>
		<input type='hidden' name='refcliente' value='".$defaults['refcliente']."' />".$defaults['refcliente']."
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>NIF/CIF</td>
					<td>
		<input type='hidden' name='factnif'value='".@$defaults['factnif']."' />".@$defaults['factnif']."
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>IMPUESTOS %</td>
					<td>
			<div style='float:left'>
				<select name='factiva' class='botonverde' required >");

		global $db;
		global $vnamei; 		$vnamei = "`".$_SESSION['clave']."impuestos`";
		$sqli =  "SELECT * FROM $vnamei ORDER BY `iva` ASC ";
		$qi = mysqli_query($db, $sqli);

			if(!$qi){	print("* ".mysqli_error($db)."</br>");
			} else {
					while($rowimp = mysqli_fetch_assoc($qi)){
							print ("<option value='".$rowimp['iva']."' ");
							if($rowimp['iva'] == @$defaults['factiva']){
							print ("selected = 'selected'");
									}
							print ("> ".$rowimp['name']." </option>");
							}
						} 
						 
		print ("</select>
						</div>
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>IMPUESTOS €</td>
					<td>
			<!--		
			<input type='text' name='factivae1' size=5 maxlength=5 value='".@$defaults['factivae1']."' style='text-align:right' required />,
			<input type='text' name='factivae2' size=2 maxlength=2 value='".@$defaults['factivae2']."' required /> €
			-->
			<input type='hidden' name='factivae1' value='".@$defaults['factivae1']."' required />".@$defaults['factivae1'].",
			<input type='hidden' name='factivae2' value='".@$defaults['factivae2']."' required />".@$defaults['factivae2']." €
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>RETENCIONES %</td>
					<td>
			<div style='float:left'>
				<select name='factret' class='botonverde' required>");

		global $db;
		global $vnamer; 	$vnamer = "`".$_SESSION['clave']."retencion`";
		$sqlr =  "SELECT * FROM $vnamer ORDER BY `ret` ASC ";
		$qr = mysqli_query($db, $sqlr);

			if(!$qr){	print("* ".mysqli_error($db)."</br>");
				} else {
					while($rowret = mysqli_fetch_assoc($qr)){
							print ("<option value='".$rowret['ret']."' ");
							if($rowret['ret'] == @$defaults['factret']){
							print ("selected = 'selected'");
								}
							print ("> ".$rowret['name']." </option>");
							}
						} 
						 
		print ("</select>
						</div>
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>RETENCIONES €</td>
					<td>
			<!--
			<input style='text-align:right' type='text' name='factrete1' size=5 maxlength=5 value='".@$defaults['factrete1']."' required />,
			<input type='text' name='factrete2' size=2 maxlength=2 value='".@$defaults['factrete2']."' required />€
			-->
			<input type='hidden' name='factrete1' value='".@$defaults['factrete1']."' />".@$defaults['factrete1'].",
			<input type='hidden' name='factrete2' value='".@$defaults['factrete2']."' />".@$defaults['factrete2']." €
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>SUBTOTAL €</td>
					<td>
			<input type='text' name='factpvp1' size=5 maxlength=5 value='".@$defaults['factpvp1']."'  style='text-align:right' required/> , 
			<input type='text' name='factpvp2' size=2 maxlength=2 value='".@$defaults['factpvp2']."' required />€
					</td>
				</tr>
				<tr>
					<td style='text-align:right;'>TOTAL €</td>
					<td>
			<!--
			<input type='text' name='factpvptot1' size=5 maxlength=5 value='".@$defaults['factpvptot1']."' style='text-align:right' required />,
			<input type='text' name='factpvptot2' size=2 maxlength=2 value='".@$defaults['factpvptot2']."' required />€
			-->
			<input type='hidden' name='factpvptot1' value='".@$defaults['factpvptot1']."' required />".@$defaults['factpvptot1'].",
			<input type='hidden' name='factpvptot2' value='".@$defaults['factpvptot2']."' required />".@$defaults['factpvptot2']." €
					</td>
				</tr>
				<tr>
					<td style='text-align:right; vertical-align:top;'>DESCRIPCIÓN</td>
					<td>
			<textarea id='coment' cols='35' rows='7' onkeypress='return limitac(event, 200);' onkeyup='actualizaInfoc(200)' name='coment' required>".@$defaults['coment']."</textarea>
			</br>
	            <div id='infoc' align='center' style='color:#0080C0;'>
        					Maximum 200 characters            
				</div>
					</td>
				</tr>");

?>