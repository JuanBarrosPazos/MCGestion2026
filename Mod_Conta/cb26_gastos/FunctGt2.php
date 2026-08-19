<?php

	global $sqlb;
	require 'FormConsultaFiltroGt2.php';
	
	$qc = mysqli_query($db, $sqlb);
	
	global $gt;
	if($qc){ $gt = mysqli_num_rows($qc); }else{ }

	global $cnt;

	if(($gt>0)&&($_POST['dm'] != '')&&($_POST['dd'] == '')&&($cnt < 1)){
		print("	<tr>
		 			<td>
			<form name='grafico' action='grafico_gf.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display: inline-block !important;'>
		<input type='submit' value='GRAFIC LINEAL TOTAL' title='VER GRAFICA LINEAL TOTAL' class='botonnaranja' />
		<input type='hidden' name='grafico' value=1 />
			</form>	
			<form name='grafico' action='grafico_gfb.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display: inline-block !important;'>
		<input type='submit' value='GRAFIC BARRAS TOTAL' title='VER GRAFICA BARRAS TOTAL' class='botonnaranja' />
		<input type='hidden' name='grafico' value=1 />
			</form>	
			<form name='grafico2' action='grafico_gf2.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display: inline-block !important;'>
		<input type='submit' value='GRAFIC LINEAL DETALLE' title='VER GRAFICA LINEAL DETALLE' class='botonnaranja' />
		<input type='hidden' name='grafico2' value=1 />
			</form>	
			<form name='grafico2' action='grafico_gf2b.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display: inline-block !important;'>
		<input type='submit' value='GRAFIC BARRAS DETALLE' title='VER GRAFICA BARRAS DETALLE' class='botonnaranja' />
		<input type='hidden' name='grafico2' value=1 />
			</form>	
					</td>
				</tr>");
		}else{ }

?>