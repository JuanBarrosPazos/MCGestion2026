<?php

	global $iniVerTodo;
	if($iniVerTodo == 1){ 
		$tableTit = "GASTOS PAPELERA TODOS - "; 
	}else{ 
		$tableTit ="GASTOS PAPELERA ".$dyt1." - "; 
	}
	print ("<table class='tableForm' >
			<tr>
				<th colspan=9 class='BorderInf'>
					".$tableTit.mysqli_num_rows($qb)." RESULTADOS
				</th>
			</tr>
			<tr>
				<th class='BorderInfDch'>ID</th>
				<th class='BorderInfDch'>NUMERO</th>
				<th class='BorderInfDch'>Y/M/D</th>	
				<th class='BorderInfDch'>RAZON SOCIAL</th>
				<th class='BorderInfDch'>REF.</th>
				<th class='BorderInfDch'>RUTA ORIGEN</th>
				<th colspan=5 class='BorderInf' style='text-align:center;' >
					".$AddBlack."
						<a href='Crear.php'>&nbsp;&nbsp;&nbsp;</a>
					".$closeButton."
					".$MoneypGrey."
						<a href='Ver.php' >&nbsp;&nbsp;&nbsp;</a>
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
					<td align='right'>".$rowb['ruta']."</td>
					
					<td colspan=3 style='text-align:center;' >
					<div style='display:inline-block;'>
		<form name='ver' action='$_SERVER[PHP_SELF]' method='POST'>");

			require 'VerRowbTotal.php';

			print($DetalleBlack.$closeButton."
				<input type='hidden' name='ocultoDetalle' value=1 />
			</form>
				</div>");

		/*	OCULTO FUNCIONES CON STATUS CLOSE
		global $a;	$a= (substr($rowb['factdate'],0,4)); 
		$sqlSTatus =  "SELECT * FROM $vnameStatus WHERE `year`='$a' LIMIT 1 ";
		$qStauts = mysqli_query($db, $sqlSTatus);
		$rowStatus = mysqli_fetch_assoc($qStauts);

		global $style;
		if($rowStatus['stat']=='close'){
			$style = "style='display:none; visibility: hidden;";
		}else{
			$style = "style='display:inline-block;'";
		}
		*/
		global $style;
		$style = "style='display:inline-block;'";

		print("<div ".$style.">
		<form name='modifica' action='PapeleraRecuperar.php' method='POST'>");

			require 'VerRowbTotal.php';

			print($RestoreBlack.$closeButton."
				<input type='hidden' name='oculto2' value=1 />
		</form>
				</div>");
	//}else{ print(""); }

		print("<div style='display:inline-block;'>
			<form name='modifica' action='PapeleraBorrar.php' method='POST'>");

			require 'VerRowbTotal.php';

			print($DeleteWhite.$closeButton."
					<input type='hidden' name='oculto2' value=1 />
			</form>
					</div>
				</tr>");

		} // FIN WHILE

		print("<tr>
					<td colspan='9' class='BorderInf'></td>
				</tr>
				<tr>
					<td colspan='3' class='BorderDch' align='center'>IMPUESTOS REPERC €</td>
					<td colspan='2' class='BorderDch' align='center'>RETENCION REPERC €</td>
					<td class='BorderDch' align='center'>TOTAL €</td>
					<td colspan='3' rowspan=2 align='center'>
						<div id='footer' style='font-size:0.9em;' >&copy; J. Barr&oacute;s 2016/23</div>
					</td>
				</tr>
				<tr>
					<td colspan='3' class='BorderDch' align='center'>".$sumaivae." €</td>
					<td colspan='2' class='BorderDch' align='center'>".$sumarete." €</td>
					<td class='BorderDch' align='center'>".$sumapvptot." €</td>
				</tr>
					</table>");

?>