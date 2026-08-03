<?php

		print("<table align='center'>
				<tr>
					<th colspan=4 class='BorderInfDch'>
						CLIENTES ".mysqli_num_rows($qb)." Resultados.
					</th>
				</tr>
				<tr>
					<th class='BorderInfDch'>REF</th>
					<th class='BorderInfDch' colspan=2'>NOMBRE</th>
					<th class='BorderInf'></th>
				</tr>");
			
	while($rowb = mysqli_fetch_assoc($qb)){
 			
	if(($rowb['Nivel']=='admin')||($rowb['Nivel']=='plus')||($rowb['Nivel']=='user')){ 
		$ruta = '../../Mod_Admin_Plus/Users/'.$rowb['ref']."/img_admin/";
	}elseif(($rowb['Nivel']=='cliente')||($rowb['Nivel']=='caja')){ 
		$ruta = '../AdminClientesWeb/img_cliente/'; }

			print (	"<tr align='center'>
						<td class='BorderInfDch'>".ucfirst($rowb['ref'])."</td>
						<td class='BorderInf'>".ucfirst($rowb['Nombre'])." ".ucfirst($rowb['Apellidos'])."</td>
						<td class='BorderInfDch'>
							<img src='".$ruta."".$rowb['myimg']."' height='40px' width='30px' />
						</td>
						<td align='center' class='BorderInf'>
				<form name='selec_client2' action='$_SERVER[PHP_SELF]' method='POST'>
					<input name='id' type='hidden' value='".$rowb['id']."' />
					<input name='ref' type='hidden' value='".$rowb['ref']."' />
					<input name='Nivel' type='hidden' value='".$rowb['Nivel']."' />
					<input name='Nombre' type='hidden' value='".$rowb['Nombre']."' />
					<input name='Apellidos' type='hidden' value='".$rowb['Apellidos']."' />
					<input name='myimg' type='hidden' value='".$rowb['myimg']."' />
			<button type='submit' title='SELECCIONAR ESTE CLIENTE' class='botonverde imgButIco AddBlack' style='vertical-align:top;' ></button>
							<input type='hidden' name='selec_client2' value=1 />
				</form>
						</td>
					</tr>");
			}  // FIN WHILE
		print("</table>");

?>