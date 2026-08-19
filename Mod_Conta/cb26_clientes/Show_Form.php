<?php

	global $db, $db_name;	global $sqla;		global $sqlb;
	global $KeyForm;		global $tabla1;		global $TitBut;

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
					<td style='text-align: center;'>
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
				</td>
			</tr>
			<tr>
				<td>
			<input type='text' name='ref' id='ref' size=20 maxlength=20 pattern='[a-zA-Z0-9\s]{3,20}' placeholder='REF. CLIENTE' title='REFERENCIA CLIENTE...' value='".@$defaults['ref']."' />
			
			<input type='text' name='rsocial' id='rsocial' size=20 maxlength=20 pattern='[a-zA-Z0-9\s]{3,20}' placeholder='RAZON SOCIAL' title='RAZON SOCIAL CLIENTE...' value='".@$defaults['rsocial']."' />
		</form>	
					</td>
				</tr>
					<th>".$LinkForm1.$LinkForm2.$LinkForm3."</th>
				</tr>
			</table>"); /* Fin del print */

?>