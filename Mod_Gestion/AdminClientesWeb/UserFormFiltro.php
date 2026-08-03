<?php
 
    global $FormTitulo;		global $KeyFeedback;		global $accion;
	global $valor;			
	global $BotonFeed;			global $BotonIco;		global $BotonRefresca;
	global $defaults;
	
	if($KeyFeedback == 1){
		$accion = "ClienteVer.php";
		$BotonIco = "PersonsBlack";
		$valor = "GESTION DE CLIENTES";
		$BotonFeed = "";
		$BotonRefresca = "";
	}else{
		$accion = "ClienteCrear.php";
		$BotonIco = "PersonAddBlack";
		
		switch (true) {
			case (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')):
				$valor = "CREAR CLIENTE O CAJERO";
				break;
			case (($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')):
				$valor = "CREAR CLIENTE";
				break;
			default:
				$valor = "CREAR CLIENTE";
				break;
		}

		$BotonFeed = "<form name='boton' action='FeedbackClienteVer.php' method='post' style='display: inline-block;' >
				<button type='submit' title='GESTION FEEDBACK' class='botonazul imgButIco CachedBlack'>
				</button>
						<input type='hidden' name='todo' value=1 />
					 </form>";
		$BotonRefresca = "<form name='todo' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block; float:right;'>
				<button type='submit' title='REFRESCAR VISTA DESPUES DE MODIFICAR DATOS...' class='botonlila imgButIco RestoreWhite'>
				</button>
					<input type='hidden' name='todo' value=1 />
					<input type='hidden' name='Orden' value='".$defaults['Orden']."' />
			</form>";

	}

    global $Ordenar;
	$Ordenar = array (	'`id` ASC' => 'ID Ascendente',
						'`id` DESC' => 'ID Descendente',
						'`Nombre` ASC' => 'Nombre Ascendente',
						'`Nombre` DESC' => 'Nombre Descendente',
						'`Apellidos` ASC' => 'Apellidos Ascenedente',
						'`Apellidos` DESC' => 'Apellidos Descendente',
						'`Email` ASC' => 'Dirección de Email Ascendente',
						'`Email` DESC' => 'Dirección de Email Descendente',
						'`Tlf1` ASC' => 'Teléfono 1 Ascendente',
						'`Tlf1` DESC' => 'Teléfono 1 Descendente',
						'`Tlf2` ASC' => 'Teléfono 2 Ascendente',
						'`Tlf2` DESC' => 'Teléfono 2 Descendente',);

	print("<table align='center' style=\"border:0px;margin-top:4px\">
				<tr>
					<th style='color:#F1BD2D;'>".$FormTitulo."</th>
				</tr>
				<tr>
					<th style='text-align:center' >
			<form name='boton' action='".$accion."' method='post' style='display: inline-block;' >
				<button type='submit' title='".$valor."' class='botonazul imgButIco ".$BotonIco."'>
				</button>
					<input type='hidden' name='todo' value=1 />
			</form>
					".$BotonFeed."
					</th>
				</tr>
				<tr>
					<td style='text-align:right;'>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>
				<button type='submit' title='FILTRO CONSULTA' class='botonverde imgButIco BuscaBlack'>
				</button>
					<input type='hidden' name='oculto' value=1 />
					<input type='hidden' name='Orden' value='".$defaults['Orden']."' />
				<input type='text' name='Nombre' size=20 maxlenth=10 value='".@$defaults['Nombre']."' pattern='[a-zA-Z\s]{3,25}' placeholder='NOMBRE' />
				<input type='text' name='Apellidos' size=20 maxlenth=10 value='".@$defaults['Apellidos']."' pattern='[a-zA-Z\s]{3,25}' placeholder='APELLIDOS' />
			</form>	
					</td>
				</tr>
				<tr>
					<td>
				".$BotonRefresca."

			<form name='todo' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block; float:left;' >
				<button type='submit' title='CONSULTAR TODOS' class='botonazul imgButIco DetalleBlack'>
				</button>
						<input type='hidden' name='todo' value=1 />
						<select name='Orden' class='botonazul'>");
				foreach($Ordenar as $option => $label){
					print ("<option value='".$option."' ");
					if($option == @$defaults['Orden']){ print ("selected = 'selected'"); }
													print ("> $label </option>");
												}	
						
		print ("</select>
					</form>	
						</td>
					</tr>
				</table>");

?>