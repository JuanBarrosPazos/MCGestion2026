<?php

	global $db;			global $sqla;		global $sqlb;
	global $KeyForm;	global $tabla1;		global $TitBut;

	if($KeyForm == "feed"){
		$tabla1 = "`".$_SESSION['clave']."clientesfeed`";
		//$sqla =  "SELECT * FROM $tabla1 WHERE `ref` <> 'ANONIMO' ORDER BY `ref` ASC ";
		//$sqlb =  "SELECT * FROM $tabla1 WHERE `rsocial` <> 'ANONIMO' ORDER BY `rsocial` ASC ";
		$TitBut = "FILTRO PAPELERA CLIENTES";
	}else{
		$tabla1 = "`".$_SESSION['clave']."clientes`";
		//$sqla =  "SELECT * FROM $tabla1 WHERE `ref` <> 'ANONIMO' ORDER BY `ref` ASC ";
		//$sqlb =  "SELECT * FROM $tabla1 WHERE `rsocial` <> 'ANONIMO' ORDER BY `rsocial` ASC ";
		$TitBut = "FILTRO CLIENTES";
	}	

	if(isset($_POST['oculto'])){
		$defaults = $_POST;
		}
	elseif(isset($_POST['todo'])){
		$defaults = $_POST;
		} else {
				$defaults = array ('rsocial' => '',
								   'ref' => '',
								   'dni' => '',
								   'Orden' => isset($ordenar));
					}


	if ($errors){
		require 'tablaErrors.php';
	} // FIN ERRORS

	$ordenar = array (	'' => 'ORDEN CLIENTES',
						'`rsocial` ASC' => 'R. SOCIAL ASC',
						'`rsocial` DESC' => 'R. SOCIAL DESC',
						'`ref` ASC' => 'REF ASC',
						'`ref` DESC' => 'REF DESC',
						'`dni` ASC' => 'DNI ASC',
						'`dni` DESC' => 'DNI DESC',
						'`id` ASC' => 'ID ASC',
						'`id` DESC' => 'ID DESC');


			global $BuscaWhiteTit;		$BuscaWhiteTit = $TitBut;
			require '../Inclu/BotoneraVar.php';
			global $closeButton;

	print("<table class='tableForm' >
				<tr>
					<th>".$titulo."</th>
				</tr>
		<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td>
				<!--
				<input type='submit' title='FILTRO PAPELERA CLIENTES' value='FILTRO' class='botonazul' />
				-->
				".$BuscaWhite.$closeButton."
						<input type='hidden' name='oculto' value=1 />
		<select name='Orden' title='ORDENAR CLIENTES POR...' class='botonlila'>");
						
		foreach($ordenar as $option => $label){
			print ("<option value='".$option."' ");
				if($option == $defaults['Orden']){ print ("selected = 'selected'"); }
										print ("> $label </option>");
								}	
						
		print ("</select>
				<select name='ref' title='REFERENCIA CLIENTE...' class='botonlila'>
					<option value=''>REFERENCIA</option>");
					//global $tabla1; 		$tabla1 = "`".$_SESSION['clave']."clientes`";
					$sqla =  "SELECT * FROM $tabla1 WHERE `ref` <> 'ANONIMO' ORDER BY `ref` ASC ";
					$qa = mysqli_query($db, $sqla);
					if(!$qa){
							print("* ".mysqli_error($db)."<br/>");
					} else {
					while($rowsa = mysqli_fetch_assoc($qa)){
						print ("<option value='".$rowsa['ref']."' ");
						if($rowsa['ref'] == @$defaults['ref']){
											print ("selected = 'selected'");
													}
									print ("> ".$rowsa['ref']." </option>");
							}
				}
	
		print ("</select>
				<select name='rsocial' title='RAZON SOCIAL CLIENTE...' class='botonlila'>
					<option value=''>RAZON SOCIAL</option>");
					global $db;
					//global $tabla1; 		$tabla1 = "`".$_SESSION['clave']."clientes`";
					$sqlb =  "SELECT * FROM $tabla1 WHERE `rsocial` <> 'ANONIMO' ORDER BY `rsocial` ASC ";
					$qb = mysqli_query($db, $sqlb);
					if(!$qb){
							print("* ".mysqli_error($db)."<br/>");
					} else {
					while($rowsb = mysqli_fetch_assoc($qb)){
						print ("<option value='".$rowsb['rsocial']."' ");
						if($rowsb['rsocial'] == @$defaults['rsocial']){
											print ("selected = 'selected'");
													}
									print ("> ".$rowsb['rsocial']." </option>");
							}
				}
	
		print ("</select>
				</form>	
					</td>
				</tr>
					<th>".$LinkForm1.$LinkForm2."</th>
				</tr>
			</table>"); /* Fin del print */

?>