<?php

	global $TdIvaSopor;		global $TdPersonal;
	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){
		$TdIvaSopor = "IVA SOPORTADO ".number_format($sumaivasoportado,2,".",",")." €";
		$TdPersonal = "PERSONAL ".$sumapersonal." €";
	}else{
		$TdIvaSopor = "";	$TdPersonal = "";
	}

		print ("<table align='center'>
				<tr>
					<th colspan=11 class='BorderInf'>
					<div style='display:inline-block; margin-top: 0.4em;'>
						".mysqli_num_rows($qc)." RESULTADOS
					</div>
				<form action='' method='get' style='display:inline-block; float:right'> 
					<input type='button' name='imprimir' title='IMPRIMIR COMPROBANTE' class='botonverde imgButIco PrintBlack' onClick='window.print();'>
				</form>
					</th>
				</tr>
				<tr>
					<th class='BorderInfDch'>CAJERO</th>	
					<th class='BorderInfDch'>ZONA / CLIENTE</th>
					<th class='BorderInfDch'>OPER SESION</th>	
					<th class='BorderInfDch'>FECHA</th>
					<th class='BorderInfDch'>SECCION</th>
					<th class='BorderInfDch'>PRODUCTO</th>
					<th class='BorderInfDch'>CARRO</th>
					<th class='BorderInfDch'>IVA€</th>
					<th class='BorderInfDch'>PVP</th>
					<th class='BorderInfDch'>SUBT</th>
					<th class='BorderInf'>PAGO</th>
				</tr>");
			global $Color;
			while($rowc = mysqli_fetch_assoc($qc)){
				
				switch (true) {
					case ($rowc['pago']=='invitacion'): $Color = '#DD92FD';
						break;
					case ($rowc['pago']=='personal'): $Color = '#F1BD2D';
						break;
					case ($rowc['pago']=='sinpagar'): $Color = '#f34d4d';
						break;
					default: $Color = '#90FAF5';
						break;
				}

			print("<tr>
					<td class='BorderInfDch' align='left'>".$rowc['cname']." / Ref: ".$rowc['refcaja']."</td>
					<td class='BorderInfDch' align='left'>". ucwords(strtolower($rowc['clname']))." / Ref: ".$rowc['refclient']."</td>
					<td class='BorderInfDch' align='right'>".$rowc['oper']."</td>
					<td class='BorderInfDch' align='right'>".$rowc['datecash']."</td>
					<td class='BorderInfDch' align='right'>".$rowc['vseccion']."</td>
					<td class='BorderInfDch' align='right'>". ucwords(strtolower($rowc['proname']))."</td>
					<td class='BorderInfDch' align='right'>".$rowc['kgcash']."</td>
					<td class='BorderInfDch' align='right' style='color:".$Color.";'>".$rowc['ivae']."</td>
					<td class='BorderInfDch' align='right'>".$rowc['pvp']."</td>
					<td class='BorderInfDch' align='right' style='color:".$Color.";'>".$rowc['pvptot']."</td>
					<td class='BorderInf' align='right' style='color:".$Color.";'>".$rowc['pago']."</td>
				</tr>");
		} /* FIN WHILE */ 

		if($LiquidoCaja<0){ $Color = '#f34d4d'; }else{ $Color = '#F1BD2D';}
			print("<tr>
					<td colspan='11' class='BorderInf'></td>
				</tr>
				<tr>
					<td colspan='11' style='text-align:center; color:#59D4FA;'>
						TOTALES CONSULTA
					</td>
				</tr>
				<tr>
					<td style='text-align:right; color:#F1BD2D;'>
						IVA TOTAL ".number_format($sumaivae,2,".",",")." €
                    </td>
					<td></td>
					<td colspan='2' style='text-align:right; color:#F1BD2D;'>
						TOTAL SIN IVA ".number_format(($sumapvptot-$sumaivae),2,".",",")." €
					</td>
					<td colspan='3' style='text-align:right; color:#F1BD2D;'>
						SUMA TOTAL ".number_format($sumapvptot,2,".",",")." €
					</td>
					<td colspan='4' style='text-align:right; color:".$Color.";'>
						LIQUIDO CAJA ".number_format($LiquidoCaja,2,".",",")." €
					</td>
				</tr>
				<tr style='color:#90FAF5;'>
					<td style='text-align:right; color:#F1BD2D;'>
						IVA REPERCUTIDO ".number_format($sumaivarepercutido,2,".",",")." €
                    </td>
					<td style='text-align:right;'>BIZUM ".$sumabizum."</td>
					<td colspan='2' style='text-align:right;'>TARJETA ".$sumatarjeta." €</td>
					<td colspan='3' style='text-align:right;'>EFECTIVO ".$sumaefectivo." €</td>
					<td colspan='4' style='text-align:right;'>
						COBRADO ".number_format($TotalCobrado,2,".",",")." €
					</td>
				</tr>
				<tr>
					<td style='text-align:right; color:#F1BD2D;'>".$TdIvaSopor." </td>
					<td style='text-align:right; color:#DD92FD;'>".$TdPersonal."</td>
					<td colspan='2'  style='text-align:right; color:#DD92FD;'>SIN PAGAR ".$sumasinpagar."</td>
					<td colspan='3' style='text-align:right; color:#DD92FD;'>INVITACIONES ".$sumainvita." €</td>
					<td colspan='4' style='text-align:right; color:#DD92FD;'>
						NO COBRADO ".number_format($TotalInvita,2,".",",")." €
					</td>
				</tr>
			</table>");

?>