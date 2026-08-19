<?php
 
	global $iniy;
	global $vname;		global $vnamei;		if(strlen(trim($vname))==0){ $vname = $vnamei; }else{ }

	print("<table class='tableForm' style='max-width: 610px;' >
				<tr>
					<th colspan=4 >
						".$title.strtoupper($vname)."
					</th>
				</tr>
				<tr>
					<td style='whidth:230px; text-align:right;'>NUMERO</td>
					<td style='whidth:220px;'>".$_POST['factnum']."</td>
					<td style='whidth:230px;text-align:right;'>FECHA</td>
					<td>".$iniy.$factdate."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>RAZON SOCIAL</td>
					<td>".$_POST['factnom']."</td>
					<td style='text-align:right;'>NIF / CIF</td>
					<td>".$_POST['factnif']."</td>
				</tr>
				<tr>
					<td style='text-align:right;'>IMPUESTOS</td>
					<td>".$_POST['factiva']." %</td>
					<td style='text-align:right;'>RETENCIONES</td>
					<td>".$_POST['factret']." %</td>
				</tr>
				<tr>
					<td></td>
					<td>".$factivae." €</td>
					<td></td>
					<td>".$factrete." €</td>
				</tr>
				<tr>
					<td style='text-align:right;'>SUBTOTAL</td>
					<td>".$factpvp." €</td>
					<td style='text-align:right;'>TOTAL</td>
					<td>".$factpvptot." €</td>
				</tr>
				<tr>
					<td style='text-align:right;'>DESCRIPCION</td>
					<td colspan='3' style='text-align:left;'>".$_POST['coment']."</td>
				</tr>
				<tr>
					<td colspan='4' align='center'>");
					
					require 'Botones.php';

			print("</td>
				</tr>
			</table>");	

?>