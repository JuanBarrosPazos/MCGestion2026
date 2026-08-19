<?php

require 'Master_Index_Header.php';

if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){	
		
print("<ul id='MenuBar1' class='MenuBarVertical'>
			<li style='text-align:center !important;'>
				<button href='#' title='MENU APP' class='botonverde imgButIco MenuListBlack' style='width: 2.4em !important; height: 2.4em !important;' ></button>
		<ul>
	<!-- MENU ADMINISTRADORES -->
		<li><a href='".$rutaModAdmin."Admin/Admin_Ver.php'>MODULO ADMIN</a></li>
		<li><a href='".$rutaModConta."index.php'>CONTA BASIC</a></li>
	<!-- Fin MENU ADMINISTRADORES-->
	<!-- MENU PROVEEDORES -->
		<li><a href='".$rutaModConta."cb26_proveedores/proveedores_Ver.php'>PROVEEDORES</a></li>
	<!-- Fin MENU PROVEEDORES -->
	
	<!-- MENU CLIENTES -->
		<li><a href='".$AdminClientesWeb."ClienteVer.php' >CLIENTES SHOP</a></li>
	<!-- Fin MENU CLIENTES-->
 
    <!-- Inicio GESTIÓN DE VENTAS -->
		<li><a href='".$caja."Ventas.php'>VENTAS</a></li>  
	<!-- Fin GESTIÓN DE VENTAS -->

  	<!-- Inicio PRODUCTOS -->
		<li><a href='".$productos."ProductosVer.php'>PRODUCTOS</a></li>
	<!-- Fin PRODUCTOS -->

  	<!-- Inicio SECCIONES -->
		<li><a href='".$Secciones."SeccionesVer.php'>SECCIONES</a></li>
  	<!-- Fin SECCIONES -->

	<!-- Inicio CAJA -->
     	<li><a href='".$caja."caja_00.php'>INICIO CAJA</a></li>
	<!-- Fin CAJA -->
  	</ul>
  </li>
  <!-- FIN MENU ADMINISTRADORES -->
		<li style='text-align:center'>
					<form name='cerrar' action='".$rutaModAdmin."Admin/mcgexit.php' method='post'>
			<button type='submit' title='CLOSE SESSION' class='botonrojo imgButIco CloseSessionBlack' style='width:2.4em !important; height: 2.4em !important; margin-top:0.3em !important;' ></button>
				<input type='hidden' name='cerrar' value=1 />
					</form>	
		</li>
	</ul>
 	<!-- FIN UL GLOBAL -->
		<script type='text/javascript'>
		<!--  -->
			var MenuBar1 = new Spry.Widget.MenuBar('MenuBar1', {imgRight:'".$rutaindex."MenuVertical/SpryMenuBarRightHover.gif'});
		</script>
		<!-- *************************** -->
			<!-- FIN MENU NIVEL ADMIN -->
		<!-- *************************** -->
	</div>");

}elseif($_SESSION['Nivel']=='plus') {
	print("<ul id='MenuBar1' class='MenuBarVertical'>
			<li style='text-align:center !important;'>
				<button href='#' title='MENU APP' class='botonverde imgButIco MenuListBlack' style='width:2.4em !important; height:2.4em !important;' ></button>
			<ul>
	<!-- MENU PROVEEDORES -->
			<li><a href='".$proveedores."Provee_Ver.php' class='MenuBarItemSubmenu'>PROVEEDORES</a></li>
	<!-- Fin MENU PROVEEDORES -->
	
	<!-- MENU CLIENTES -->
			<li><a href='".$AdminClientesWeb."ClienteVer.php' >CLIENTES SHOP</a></li>
	<!-- Fin MENU CLIENTES-->
 
	<!-- Inicio STOCKS -->
		<li><a href='".$Stocks."Stock_Ver.php'>VER</a></li>
	<!-- Fin STOCKS -->
 
  	<!-- Inicio PRODUCTOS -->
		<li><a href='".$productos."ProductosVer.php'>VER</a></li>
	<!-- Fin PRODUCTOS -->

	<!-- Inicio CAJA -->
     	<li><a href='".$Stocks."Stock_Ver.php'>VER</a></li>
      	<li><a href='".$caja."caja_00.php'>INICIO CAJA</a></li>
	<!-- Fin CAJA -->
		</ul>
	</li>
	<!-- FIN MENU ADMINISTRADORES -->
		<li style='text-align:center'>
					<form name='cerrar' action='".$rutaModAdmin."Admin/mcgexit.php' method='post'>
			<button type='submit' title='CLOSE SESSION' class='botonrojo imgButIco CloseSessionBlack' style='width:2.4em !important; height: 2.4em !important; margin-top:0.3em !important;' ></button>
				<input type='hidden' name='cerrar' value=1 />
					</form>	
		</li>
	</ul>
	<!-- FIN UL GLOBAL -->
	<script type='text/javascript'>
	<!--  -->
		var MenuBar1 = new Spry.Widget.MenuBar('MenuBar1', {imgRight:'".$rutaindex."MenuVertical/SpryMenuBarRightHover.gif'});
	</script>
		<!-- *************************** -->
			<!-- FIN MENU NIVEL PLUS -->
		<!-- *************************** -->
	</div>");
	
}elseif($_SESSION['Nivel']=='user'){ 
	print("<ul id='MenuBar1' class='MenuBarVertical'>
			<li style='text-align:center !important;'>
				<button href='#' title='MENU APP' class='botonverde imgButIco MenuListBlack' style='width: 2.4em !important; height: 2.4em !important;' ></button>
			<ul>
	<!-- MENU CLIENTES -->
			<li><a href='".$AdminClientesWeb."ClienteVer.php'>CLIENTES SHOP</a></li>  
	<!-- Fin MENU CLIENTES-->
 
	<!-- Inicio CAJA -->
     		<li><a href='".$caja."caja_00.php'>INICIO CAJA</a></li>
	<!-- Fin CAJA -->
		</ul>
	</li>
	<!-- FIN MENU ADMINISTRADORES -->
		<li style='text-align:center'>
					<form name='cerrar' action='".$rutaModAdmin."Admin/mcgexit.php' method='post'>
			<button type='submit' title='CLOSE SESSION' class='botonrojo imgButIco CloseSessionBlack' style='width:2.4em !important; height: 2.4em !important; margin-top:0.3em !important;' ></button>
				<input type='hidden' name='cerrar' value=1 />
					</form>	
		</li>
	</ul>
	<!-- FIN UL GLOBAL -->
		<script type='text/javascript'>
		<!--  -->
			var MenuBar1 = new Spry.Widget.MenuBar('MenuBar1', {imgRight:'".$rutaindex."MenuVertical/SpryMenuBarRightHover.gif'});
		</script>
		<!-- *************************** -->
			<!-- FIN MENU NIVEL USER -->
		<!-- *************************** -->
	</div>");
	
}elseif($_SESSION['Nivel']=='caja'){
	print("<ul id='MenuBar1' class='MenuBarVertical'>
			<li style='text-align:center !important;'>
				<button href='#' title='MENU APP' class='botonverde imgButIco MenuListBlack' style='width:2.4em !important; height:2.4em !important;' ></button>
			<ul>
		<li><a href='".$AdminClientesWeb."ClienteVer.php'>MI PERFIL</a></li>  
      	<li><a href='".$caja."caja_00.php?tienda=1'>INICIO CAJA</a></li>
		</ul>
	</li>
  	<!-- FIN MENU NIVEL CAJA -->
		<li style='text-align:center'>
					<form name='cerrar' action='".$rutaModAdmin."Admin/mcgexit.php' method='post'>
			<button type='submit' title='CLOSE SESSION' class='botonrojo imgButIco CloseSessionBlack' style='width:2.4em !important; height: 2.4em !important; margin-top:0.3em !important;' ></button>
				<input type='hidden' name='cerrar' value=1 />
					</form>	
		</li>
	</ul>
	<!-- FIN UL GLOBAL -->
		<script type='text/javascript'>
		<!--  -->
			var MenuBar1 = new Spry.Widget.MenuBar('MenuBar1', {imgRight:'".$rutaindex."MenuVertical/SpryMenuBarRightHover.gif'});
		</script>
		<!-- *************************** -->
			<!-- FIN MENU NIVEL CAJA -->
		<!-- *************************** -->
	</div>");

}if($_SESSION['Nivel']=='cliente'){
	print("<ul id='MenuBar1' class='MenuBarVertical'>
		<!-- MENU CLIENTES -->
			<li style='text-align:center !important;'>
				<button href='#' title='MENU APP' class='botonverde imgButIco MenuListBlack' style='width:2.4em !important; height:2.4em !important;' ></button>
    		<ul>
				<li><a href='".$AdminClientesWeb."ClienteVer.php'>MI PERFIL</a></li>
				<li><a href='".$caja."caja_00.php?tienda=1'>TIENDA</a></li>
				<li><a href='".$caja."Ventas.php'>MIS COMPRAS</a></li>  
			</ul>
		</li>
	<!-- Fin MENU CLIENTES-->
		<li style='text-align:center'>
					<form name='cerrar' action='".$rutaModAdmin."Admin/mcgexit.php' method='post'>
			<button type='submit' title='CLOSE SESSION' class='botonrojo imgButIco CloseSessionBlack' style='width:2.4em !important; height: 2.4em !important; margin-top:0.3em !important;' ></button>
				<input type='hidden' name='cerrar' value=1 />
					</form>	
		</li>
	</ul>
		<!-- FINAL UL GLOBAL -->
		<!--	-->
		<script type='text/javascript'>
			var MenuBar1 = new Spry.Widget.MenuBar('MenuBar1', {imgRight:'".$rutaindex."MenuVerticalTutor/SpryMenuBarRightHover.gif'});
		</script>
		<!-- *************************** -->
			<!-- FIN MENU NIVEL CLIENTE -->
		<!-- *************************** -->
	</div>");
}
	
?>