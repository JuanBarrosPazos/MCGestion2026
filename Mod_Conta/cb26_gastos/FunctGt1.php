<?php

		global $sqlb;
		require 'FormConsultaFiltroGt1.php';
		//$sqlb =  "SELECT * FROM $vname WHERE `factdate` LIKE '$fil' ORDER BY $orden ";

		$qb = mysqli_query($db, $sqlb);
		if(mysqli_num_rows($qb) == 0){}
		global $gt; 	$gt = mysqli_num_rows($qb);
		
		if(($gt>0)&&($_POST['dm'] != '')&&($_POST['dd'] == '')){

		print("	<tr>
		 			<td>
			<form name='grafico' action='grafico_g.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display: inline-block !important;' >
		<input type='submit' value='GRAFIC LINEAL TOTAL DIA' title='VER GRAFICA LINEAL TOTAL POR DIA' class='botonnaranja' />
		<input type='hidden' name='grafico' value=1 />
			</form>	
			<form name='graficob' action='grafico_gb.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display: inline-block !important;'>
		<input type='submit' value='GRAFIC BARRAS TOTAL DIA' title='VER GRAFICA BARRAS TOTAL POR DIA' class='botonnaranja' />
		<input type='hidden' name='graficob' value=1 />
			</form>	
			<form name='grafico2' action='grafico_g2.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display: inline-block !important;'>
		<input type='submit' value='GRAFIC LINEAL DETALLE' title='VER GRAFICA LINEAL DETALLE' class='botonnaranja' />
		<input type='hidden' name='grafico2' value=1 />
			</form>	
			<form name='graficob2' action='grafico_gb2.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display: inline-block !important;'>
		<input type='submit' value='GRAFIC BARRAS DETALLE $$' title='VER GRAFICA BARRAS DETALLE' class='botonnaranja' />
		<input type='hidden' name='graficob2' value=1 />
			</form>	
					</td>
				</tr>");
		} // FIN if


?>