<?php

	global $rutaDirTr;		global $ejerStatus;		global $Checkbox;		global $Checkboxb;

	print("<table class='tableForm' style='width:34.4em !important;' >
			<tr>
				<th colspan=2 >".$titulo."</th>
			</tr>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>

			<input type='hidden' name='vname' value='".$defaults['vname']."' />
			<input type='hidden' name='proveegastos' value='".$defaults['proveegastos']."' />

			<tr>
				<td style='text-align:right; width:50%;' >RAZON SOCIAL</td>
				<td style='width:50%;'>
			<input type='hidden' name='factnom' value='".$defaults['factnom']."' />".$defaults['factnom']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>NIF/CIF</td>
				<td>
			<input type='hidden' name='factnif'value='".$defaults['factnif']."' />".$defaults['factnif']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>REF. PROVEEDOR</td>
				<td>
			<input type='hidden' name='refprovee' value='".$defaults['refprovee']."' />".$defaults['refprovee']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>ID</td>
				<td>
			<input type='hidden' name='id' value='".$defaults['id']."' />".$defaults['id']."
				</td>
			</tr>
			<input type='hidden' name='delruta' value='".@$defaults['delruta']."' />
				".$rutaDirTr."
	            ".$Checkbox."
				".$ejerStatus."
				".$Checkboxb."
			<tr>
				<td style='text-align:right;'>NUMERO FACTURA</td>
				<td>
			<input type='hidden' name='factnum' value='".$defaults['factnum']."' />".$defaults['factnum']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>NUMERO INICIAL FACTURA</td>
				<td>
			<input type='hidden' name='factnumini' value='".$defaults['factnumini']."' />".$defaults['factnumini']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>FECHA ACTUAL</td>
				<td>
					".$defaults['dy']."-".$defaults['dm']."-".$defaults['dd']."<br>
						<input type='hidden' name='dy' value='".$defaults['dy']."' />
						<input type='hidden' name='dm' value='".$defaults['dm']."' />
						<input type='hidden' name='dd' value='".$defaults['dd']."' />
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>FECHA INICIAL</td>
				<td>
			<input type='hidden' name='factdateini' value='".$defaults['factdateini']."' />".$defaults['factdateini']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>FECHA CREACIÓN</td>
				<td>
			<input type='hidden' name='factcrea' value='".$defaults['factcrea']."' />".$defaults['factcrea']."
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>FECHA MOIFICACIÓN</td>
				<td>
			<input type='hidden' name='factmodif' value='".$defaults['factmodif']."' />".$defaults['factmodif']."
				</td>
			</tr>

			<tr>
				<td style='text-align:right;'>SUBTOTAL</td>
				<td>
					".$defaults['factpvp1'].",".$defaults['factpvp2']." €
						<input type='hidden' name='factpvp1' value='".$defaults['factpvp1']."' />
						<input type='hidden' name='factpvp2' value='".$defaults['factpvp2']."' />
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>IMPUESTOS</td>
				<td>
			<input type='hidden' name='factiva' value='".$defaults['factiva']."' />
				<span style='display:inline-block; width: 2.8em !important;' >
					".$defaults['factiva']." %</span> = ".$defaults['factivae1'].",".$defaults['factivae2']." €
						<input type='hidden' name='factivae1' value='".$defaults['factivae1']."' />
						<input type='hidden' name='factivae2' value='".$defaults['factivae2']."' />
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>RETENCIONES</td>
				<td>
			<input type='hidden' name='factret' value='".$defaults['factret']."' />
				<span style='display:inline-block; width: 2.8em !important;' >
					".$defaults['factret']." %</span> = ".$defaults['factrete1'].",".$defaults['factrete2']." €
						<input type='hidden' name='factrete1' value='".$defaults['factrete1']."' />
						<input type='hidden' name='factrete2' value='".$defaults['factrete2']."' />
				</td>
			</tr>
			<tr>
				<td style='text-align:right;'>TOTAL</td>
				<td>
					".$defaults['factpvptot1'].",".$defaults['factpvptot2']." €
					<input type='hidden' name='factpvptot1' value='".$defaults['factpvptot1']."' />
					<input type='hidden' name='factpvptot2' value='".$defaults['factpvptot2']."' />
				</td>
			</tr>
			<tr>
				<td colspan=2 style='text-align: left !important;' >DESCRIPCION</td>
			</tr>
			<tr>
				<td colspan=2 style='text-aling:left;' >
			<input type='hidden' name='coment' value='".$defaults['coment']."' />".$defaults['coment']."
				</td>
			</tr>

				<input type='hidden' name='myimg1' value='".$defaults['myimg1']."' />
				<input type='hidden' name='myimg2' value='".$defaults['myimg2']."' />
				<input type='hidden' name='myimg3' value='".$defaults['myimg3']."' />
				<input type='hidden' name='myimg4' value='".$defaults['myimg4']."' />
			<tr>
				<td colspan='2' align='right' >");

			if(strlen(trim($Checkbox)) == 0){
				echo $DeleteWhite.$closeButton;
			}else{ 
				echo $SaveBlack.$closeButton;
			}
		
		global $papeleraRecup;
		global $gastoModif3;

		if($gastoModif3 == 1){
				print("<input type='hidden' name='ocultoModif3' value=1 />
						</form>");
		}elseif($papeleraRecup == 1){
				print("<input type='hidden' name='ocultoRecup' value=1 />
						</form>");
		}else{ print("<input type='hidden' name='oculto' value=1 />
						</form>");
					}

		//global $Borrar2;		$Borrar2= "style='display:none; visibility: hidden;'";
			require 'Botones.php';
			print("</td>
				</tr>
			</table>");

?>