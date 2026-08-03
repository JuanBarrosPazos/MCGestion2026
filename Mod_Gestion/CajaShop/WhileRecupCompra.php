<?php

		print("<tr align='center'>
					<td class='BorderInfDch' style='text-align:right;'>
						".$RowCajaShopIni0['cname']." ".$RowCajaShopIni0['refcaja']."
					</td>
					<td class='BorderInfDch' style='text-align:right;'>".$RowCajaShopIni0['oper']."</td>
					<td class='BorderInfDch ocultatd440' style='text-align:right;'>
						".$RowCajaShopIni0['datecash']."
					</td>
					<td class='BorderInfDch' style='text-align:right;'>
						".strtoupper($RowCajaShopIni0['refclient'])."
					</td>
					<td class='BorderInfDch' style='text-align:right;'>".$SumaResult."</td>
					<td class='BorderInf'>");

		if($RowCajaShopIni0['ini'] == 1){
			print("<div style='float:left;'>
				<form name='recup_compra2' method='post' action='$_SERVER[PHP_SELF]'>
					<input type='hidden' name='cname' value='".$RowCajaShopIni0['cname']."' />
					<input type='hidden' name='refcaja' value='".$RowCajaShopIni0['refcaja']."' />
					<input type='hidden' name='oper' value='".$RowCajaShopIni0['oper']."' />
					<input type='hidden' name='datecash' value='".$RowCajaShopIni0['datecash']."' />
					<input type='hidden' name='refclient' value='".$RowCajaShopIni0['refclient']."' />
					<input type='hidden' name='vseccion' value='".$RowCajaShopIni0['vseccion']."' />
					<input type='hidden' name='producto' value='".$RowCajaShopIni0['producto']."' />
					<input type='hidden' name='kgcash' value='".$RowCajaShopIni0['kgcash']."' />
				<button type='submit' title='RECUPERAR ESTA COMPRA' class='botonverde imgButIco RestoreBlack' style='vertical-align:top;' ></button>
						<input type='hidden' name='recup_compra2' value=1 />
				</form>
					</div>
					<div style='float:left;'>
				<form name='coment_client' action='CompraComent.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=500px,height=320px')\">
						<input name='oper' type='hidden' value='".$RefOperShop."' />
					<button type='submit' title='COMENTARIOS COMPRA' class='botonazul imgButIco DatosBlack' style='vertical-align:top;' ></button>
						<input type='hidden' name='coment_client' value=1 />
				</form>
					</div>");			
		}else{ }

		global $ClientRef;	global $CssHeight;
		if($ClientRef != ""){
			$SqlClientesWebRef =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ";
				$QrySqlClientesWebRef = mysqli_query($db, $SqlClientesWebRef);
			if(mysqli_num_rows($QrySqlClientesWebRef) == 0){
				$SqlClientesWebRef =  "SELECT * FROM $Admin WHERE `ref` = '$ClientRef' ";
				$QrySqlClientesWebRef = mysqli_query($db, $SqlClientesWebRef);
			}else{ }
				$RowSqlClientesWebClient = mysqli_fetch_assoc($QrySqlClientesWebRef);
				$_SESSION['nclient'] = $RowSqlClientesWebClient['Nivel'];
        
		if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){ 
				$CssHeight = 'height=530px'; 
		}else { $CssHeight = 'height=290px'; }

		global $SqlClientesWebRef;
		if($_SESSION['nclient']=='cliente'){
			$SqlClientesWebRef =  "SELECT * FROM $ClientesWeb WHERE `ref` = '$ClientRef' ORDER BY `Nombre` ASC ";
			$CssHeight = 'height=530px';
		}elseif(($_SESSION['nclient']=='admin')||($_SESSION['nclient']=='plus')||($_SESSION['nclient']=='user')||($_SESSION['nclient']=='caja')){
			$SqlClientesWebRef =  "SELECT * FROM $Admin WHERE `ref`='$ClientRef' ORDER BY `Nombre` ASC ";
		}
		$QrySqlClientesWebRef = mysqli_query($db, $SqlClientesWebRef);

		while($RowSqlClientesWebClient = mysqli_fetch_assoc($QrySqlClientesWebRef)){
			if($RowSqlClientesWebClient['doc']=='local'){ $CssHeight = 'height=290px'; }else{ $CssHeight = 'height=530px'; }
			global $InixKey;
			if($InixKey == 1){
				print("<div style='float:left;'>
						<form name='data_client' action='ClienteVer02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=320px,".$CssHeight."')\">
				<input type='hidden' name='id' value='".$RowSqlClientesWebClient['id']."' />
				<input type='hidden' name='Nivel' value='".$RowSqlClientesWebClient['Nivel']."' />
				<input type='hidden' name='ref' value='".$RowSqlClientesWebClient['ref']."' />
				<input type='hidden' name='Nombre' value='".$RowSqlClientesWebClient['Nombre']."' />
				<input type='hidden' name='Apellidos' value='".$RowSqlClientesWebClient['Apellidos']."' />
				<input type='hidden' name='myimg' value='".$RowSqlClientesWebClient['myimg']."' />
				<input type='hidden' name='doc' value='".$RowSqlClientesWebClient['doc']."' />
				<input type='hidden' name='dni' value='".$RowSqlClientesWebClient['dni']."' />
				<input type='hidden' name='ldni' value='".$RowSqlClientesWebClient['ldni']."' />
				<input type='hidden' name='Email' value='".$RowSqlClientesWebClient['Email']."' />
				<input type='hidden' name='Usuario' value='".$RowSqlClientesWebClient['Usuario']."' />
				<input type='hidden' name='Password' value='".$RowSqlClientesWebClient['Password']."' />
				<input type='hidden' name='Direccion' value='".$RowSqlClientesWebClient['Direccion']."' />
				<input type='hidden' name='Tlf1' value='".$RowSqlClientesWebClient['Tlf1']."' />
				<input type='hidden' name='Tlf2' value='".$RowSqlClientesWebClient['Tlf2']."' />
				<input type='hidden' name='lastin' value='".$RowSqlClientesWebClient['lastin']."' />
				<input type='hidden' name='lastout' value='".$RowSqlClientesWebClient['lastout']."' />
				<input type='hidden' name='visitadmin' value='".$RowSqlClientesWebClient['visitadmin']."' />
					<button type='submit' title='DATOS CLIENTE' class='botonlila imgButIco InfoBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='data_client' value=1 />
			</form>
					</div>");
			} // FIN IF
		print("</td>");
				} /* FIN DEL WHILE */
				
		} // FIN if($ClientRef != '')

				global $ClientRef;
				if($ClientRef == ''){ print("</td>"); }
						print("</tr>");


?>