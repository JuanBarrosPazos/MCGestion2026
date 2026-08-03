<?php

if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')) {	


print("<div style='clear:both'></div>
		
<div class='MenuVertical'>
Hello: ".$_SESSION['Nombre'][0]." ".$_SESSION['Apellidos'].".</br>

 <!-- Comienza ul global -->
 		
<ul id='MenuBar1' class='MenuBarVertical'>

  <li class='MenuBarItemSubmenu'>
  <a href='#'>APP MENU</a>
  <ul>
 
<!-- MENU ADMINISTRADORES -->

  	<li>
		<a href='".$rutaModAdmin."Admin/Admin_Ver.php' >MOD ADMIN</a>
  	</li>");
	  if(file_exists($rutaModGestion.'Admin_index.php')){
		print("<li><a href='".$rutaModGestion."Admin_index.php'>MOD GESTION</a></li>");
	  }else{ }

print("<!-- Fin MENU ADMINISTRADORES-->
 
<!-- MENU GASTOS PROVEEDORES -->

  	<li>
		<a href='".$rutaProveedores."proveedores_Ver.php'>PROVEEDORES</a>
  	</li>

<!-- Fin MENU GASTOS PROVEEDORES -->
	
<!-- MENU INGRESOS PROVEEDORES -->

  	<li>
		<a href='".$rutaClientes."clientes_Ver.php' >CLIENTES</a>
 	</li>

<!-- Fin MENU INGRESOS PROVEEDORES-->
 
<!-- Inicio GESTIÓN DE GASTOS -->

  	<li><a href='".$rutaGastos."Ver.php' >GASTOS</a></li>

<!-- Fin GESTIÓN DE GASTOS -->

<!-- Inicio GESTIÓN DE INGRESOS -->

  	<li><a href='".$rutaIngresos."Ver.php' >INGRESOS</a></li>
	
<!-- Fin GESTIÓN DE INGRESOS -->

<!-- Inicio GESTIÓN DE BALANCES -->

	<li><a  href='".$rutaIndex."index.php' >BALANCES</a></li>
	
<!-- Fin GESTIÓN DE BALANCES -->
 
<!-- Inicio GESTIÓN DE IMPUESTOS -->

	<li><a href='".$rutaImpuestos."Impuestos_Ver.php'>% IMPUESTOS</a></li>
	
<!-- Fin GESTIÓN DE IMPUESTOS -->
 
<!-- Inicio RETENCION -->

	<li><a href='".$rutaRetencion."retencion_Ver.php' >% RETENCIONES</a></li>
	
<!-- Fin RETENCION -->

<!-- Inicio STATUS EJERCICIOS -->

	<li><a href='".$rutaStatus."status_Ver.php'>STATUS EJERCICIOS</a></li>
	
<!-- Fin STATUS EJERCICIO -->"); // FIN DEL PRINT

	global $rutDir;	$rutDir = $rutaIndex."../Mod_Admin_Plus/index.php";
	if(!file_exists($rutDir)) {
		print("<!-- Inicio BBDD -->
					<li><a href='".$rutaUpBbdd."export_bbdd_backups.php'>BACKUP BBDD</a></li>
				<!-- Fin BBDD -->");
				echo $rutDir;
	}else{ }

print("</ul>
  	</li>
  
<!-- FIN MENU ADMINISTRADORES -->
 
  	<li style='text-align:left'>
  		<form name='cerrar' action='".$rutaModAdmin."Admin/mcgexit.php' method='post'>
			<input type='submit' value='CLOSE SESION' class='botonverde' style='margin:0.2em auto 0.2em -0.4em;'/>
			<input type='hidden' name='cerrar' value=1 />
	</form>	
	</li>
	
	</ul>
	
<!-- FIN UL GLOBAL -->

<script type='text/javascript'>
<!--
var MenuBar1 = new Spry.Widget.MenuBar('MenuBar1', {imgRight:'MenuVerticalTutor/SpryMenuBarRightHover.gif'});
//-->
</script>

</div>");

	} 
	
?>