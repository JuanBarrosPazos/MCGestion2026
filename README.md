# ** PROYECTO INICIADO EN EL AÑO 2012 **
## * SE MODIFICA EL NOMBRE A MCGestion2025 2025.05.25
## * DESCRIPCION GENERAL *
### GESTOR DE STOCK, VENTAS, ADMINISTRADORES Y CLIENTES.
* CONFIGURACION BBDD: ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci
- Se implementan tres modulos.
- Mod_Admin: Gestión de administradores en sus distintos niveles y control de horario laboral.
- Mod_Conta: Gestión de ingresos, gastos, clientes, proveedores y balances.
- Mod_Gestion: Gestión del flujo de caja y almacén.
- Enfocada actualmente al servicio en hostelería, se podría implementar en cualquier sector.
- Podemos crear secciones, productos, fecha perecederos, modificar stocks y precios de productos, iva, etc...
- Realizar una comanda en una mesa o zona del local, modificarla, mover la comanda a otra zona del local, hasta el momento de finalizar la facturación...
----
## CUESTIONES PENDIENTES
- ** REVISAR CONFIGURACIONES PARA LAS TABLAS FEED... Y MODIFICAR LAS FUNCIONES RELACIONADAS...

- CONFIGURAR MEDIA PARA IMPRESIÓN DE FACTURA.
- OJO $KeyBorraUser NO LA LLAMA NADIE.
- LOGS PRODUCTOS, LOGS CAJA.
- REFRESCAR CONSULTAS REDIR AUTO CON VARIABLES POR GET.
- !! FUNCIÓN TOTAL DE VENTAS. VOLCADO DIARIO Y ACTUALIZACIÓN EN MOD_CONTA INGRESOS.
- !! MODIFICAR FACTURAS ERRONEAS PAGADAS...
- !! QUÉ HACER CON LOS PRODUCTOS EN STOCK AL ELIMINAR UNA SECCION TOTALMENTE...
- ?? PERECEDEROS ENTRAN EN LA TABLA GASTOS CON BASE IMPONIBLE Y SIN IVA.
- ??? EN LA VALIDACIÓN DE IMÁGENES LOS ARCHIVOS PSD Y OTROS NO SE CONSIGUEN VALIDAR ???
- ! Ojo al $txt no se define en ningún sitio. La defino global $txt para evitar el error.
----
# ** ÚLTIMA VERSIÓN:
## * MCGestion2026 V26.08.10
* SE INTEGRA MOD_ADMIN_PLUS Con la gestión de horario laboral de los empleados.
* SE MODIFICA LA CONFIGURACIÓN DE LAS TABLAS Y SE ELIMINAN LAS TABLAS FEED...
* SE RECONFIGURA FEED Mod_Conta\cb23_clientes
----
## * MCGestion2023 V24.09.26A
* AJUSTE DE LOS @media print
* AJUSTES GENERALES EN CajaShop/
----
