<?php

	print ("<table class='tableForm' >
			<tr>
				<th colspan=12 class='BorderInf'>
					GASTOS ".$dyt1." - ".mysqli_num_rows($qb)." RESULTADOS
				</th>
			</tr>
			<tr>
				<th class='BorderInfDch'>ID</th>
				<th class='BorderInfDch'>NUMERO</th>
				<th class='BorderInfDch'>Y/M/D</th>
				<th class='BorderInfDch'>RAZON SOCIAL</th>
				<th class='BorderInfDch'>NIF / CIF</th>
				<th class='BorderInfDch'>IMP %</th>
				<th class='BorderInfDch'>IMP €</th>
				<th class='BorderInfDch'>SUBTOT</th>										
				<th class='BorderInfDch'>RET %</th>
				<th class='BorderInfDch'>RET €</th>
				<th class='BorderInfDch'>TOTAL</th>
				<th class='BorderInf' style='text-align:center;' >
					".$AddBlack."
						<a href='Crear.php'>&nbsp;&nbsp;&nbsp;</a>
					".$closeButton."
					".$DeleteBlack."
						<a href='PapeleraVer.php' >&nbsp;&nbsp;&nbsp;</a>
					".$closeButton."
					".$MoneypWhite."
						<a href='PendientesVer.php' >&nbsp;&nbsp;&nbsp;</a>
					".$closeButton."
				</th>
			</tr>");
		
	global $styleBgc; global $i; $i = 1;
	
	global $vnameStatus; 		$vnameStatus = "`".$_SESSION['clave']."status`";

	while($rowb = mysqli_fetch_assoc($qb)){

		if(($i%2) == 0){ $styleBgc = "bgctdb"; }else{ $styleBgc = "bgctd"; }
		$i++;

		global $vname; 		global $dyt1;
				
		print ("<tr class='".$styleBgc."'>
					<td align='center'>".$rowb['id']."</td>
					<td align='center'>".$rowb['factnum']."</td>
					<td align='left'>".$rowb['factdate']."</td>
					<td align='center'>".$rowb['factnom']."</td>
					<td align='left'>".$rowb['factnif']."</td>
					<td align='right'>".$rowb['factiva']."</td>
					<td align='right'>".$rowb['factivae']."</td>
					<td align='right'>".$rowb['factpvp']."</td>
					<td align='right'>".$rowb['factret']."</td>
					<td align='right'>".$rowb['factrete']."</td>
					<td align='right'>".$rowb['factpvptot']."</td>

					<td style='text-align:center;' >
				<div style='display:inline-block;'>
		<form name='ver' action='$_SERVER[PHP_SELF]' method='POST'>");

		require 'VerRowbTotal.php';

		print("".$DetalleBlack.$closeButton."
				<input type='hidden' name='ocultoDetalle' value=1 />
			</form>
				</div>
				<div style='display:inline-block;' >
			<form name='ver' action='$_SERVER[PHP_SELF]' method='POST'>");

		require 'VerRowbTotal.php';

		print($FotoBlack.$closeButton."
				<input type='hidden' name='oculto2' value=1 />
			</form>						
				</div>");

		global $a;	$a= (substr($rowb['factdate'],0,4)); 
		$sqlSTatus =  "SELECT * FROM $vnameStatus WHERE `year`='$a' LIMIT 1 ";
		$qStauts = mysqli_query($db, $sqlSTatus);
		$rowStatus = mysqli_fetch_assoc($qStauts);

		global $style;
		//if($rowStatus['stat']==''){
		if($rowStatus['stat']=='close'){
			$style = "style='display:none; visibility: hidden;";
		}else{
			$style = "style='display:inline-block;'";
		}

		print("<div ".$style." >
			<form name='modifica' action='Modificar02.php' method='POST'>");

		require 'VerRowbTotal.php';

		print($DatosBlack.$closeButton."
					<input type='hidden' name='oculto2' value=1 />
			</form>
				</div>
				<div ".$style." >
		<form name='modifica' action='Modificar03.php' method='POST'>");

		require 'VerRowbTotal.php';

		print($MoneyWhite.$closeButton."
				<input type='hidden' name='oculto2' value=1 />
		</form>
				</div>
				<div ".$style." >
			<form name='modifica' action='Borrar.php' method='POST'>");

			require 'VerRowbTotal.php';

		print($DeleteWhite.$closeButton."
					<input type='hidden' name='oculto2' value=1 />
			</form>
				</div>");

		print("</tr>");

		} // FIN WHILE

		print("<tr>
					<td colspan='12' class='BorderInf'></td>
				</tr>
				<tr>
					<td></td>
					<td colspan='3' class='BorderDch' align='center'>IMPUESTOS REPERC €</td>
					<td colspan='3' class='BorderDch' align='center'>RETENCION REPERC €</td>
					<td colspan='4' class='BorderDch' align='center'>TOTAL €</td>
					<td colspan='2' rowspan=2 align='center'>
						<div id='footer' style='font-size:0.9em;' >&copy; J. Barr&oacute;s 2016/23</div>
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan='3' class='BorderDch' align='center'>".$sumaivae." €</td>
					<td colspan='3' class='BorderDch' align='center'>".$sumarete." €</td>
					<td colspan='4' class='BorderDch' align='center'>".$sumapvptot." €</td>
				</tr>
					</table>");

	//echo "\$dateini: ".$dateini."  \$datefin: ".$datefin."<br>";

?>