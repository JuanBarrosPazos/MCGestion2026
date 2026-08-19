<?php

	print(" <table class='tableForm' style='width:34.4em !important;'>
			<tr>
				<th class='BorderInf'>
					RAZON SOCIAL: ".strtoupper($_SESSION['minombre'])."
					<br>
					FACT Nº. ".$_SESSION['mivalor']."
					<br>
					ID: ".$_SESSION['miid']."
				</th>
			</tr>
	        <tr>
				<td style='text-align:center;' >
				<div class='img1'>
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
				<button type='submit' class='botonnaranja' title='MODIFICAR IMAGEN 1' >
					<img src='".$rutaDir.$myimg1."' />
				</button>							
					<input type='hidden' name='mimg1' value='".$_SESSION['myimg1']."' />
				<!--
					<input type='submit' value='MODIF IMG 1' class='botonnaranja' />
				-->
			</form>		  
				</div>
	        	<div class='img1'>
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
				<button type='submit' class='botonnaranja' title='MODIFICAR IMAGEN 2' >
							<img src='".$rutaDir.$myimg2."' /> 
				</button>							
					<input type='hidden' name='mimg2' value='".$_SESSION['myimg2']."' />
				<!--
					<input type='submit' value='MODIF IMG 2' class='botonnaranja' />
				-->
		</form>		  
				</div>
				<div class='img1'>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
				<button type='submit' class='botonnaranja' title='MODIFICAR IMAGEN 3' >
							<img src='".$rutaDir.$myimg3."' />
				</button>							
					<input name='mimg3' type='hidden' value='".$_SESSION['myimg3']."' />
				<!--	
					<input type='submit' value='MODIF IMG 3' class='botonnaranja' />
				-->
		</form>		  
				</div>
				<div class='img1'>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
				<button type='submit' class='botonnaranja' title='MODIFICAR IMAGEN 4' >
							<img src='".$rutaDir.$myimg4."' />
				</button>							
						<input name='mimg4' type='hidden' value='".$_SESSION['myimg4']."' />
					<!--
						<input type='submit' value='MODIF IMG 4' class='botonnaranja' />
					-->
		</form>		  
				</div>
			</td>
		</tr>");
       
	$printimg =	"<tr>
					<td>
						<div id='foto1A' class='img2'><img src='".$rutaDir.$myimg1."' /></div>
						<div id='foto2A' class='img2'><img src='".$rutaDir.$myimg2."' /></div>
						<div id='foto3A' class='img2'><img src='".$rutaDir.$myimg3."' /></div>
						<div id='foto4A' class='img2'><img src='".$rutaDir.$myimg4."' /></div>
					</td>
				</tr>";

?>