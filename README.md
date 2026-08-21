# ** PROYECTO INICIADO EN EL AÑO 2012 **
## * SE MODIFICA EL NOMBRE A MCGestion2026
## * DESCRIPCION GENERAL *
### GESTOR DE STOCK, VENTAS, ADMINISTRADORES Y CLIENTES.
* CONFIGURACION BBDD: ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci
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

- ** Mod_Conta\cb26_proveedores REVISAR CONFIGURACIÓN Y FUNCIONAMIENTO

- proveedoresFeed_Borrar_02.php Pendiente Confirmar Operaciones en cascada bbdd...
- proveedores_Modificar_02.php  Pendiente Confirmar operaciones en cascada bbdd...
- proveedoresFeed_Borrar_02.php Pendiente Confirmar operaciones en cascada bbdd...

- clientesFeed_Borrar_02.php Pendiente Confirmar Operaciones en cascada bbdd...
- clientes_Modificar_02.php  Pendiente Confirmar operaciones en cascada bbdd...
- clientesFeed_Borrar_02.php Pendiente Confirmar operaciones en cascada bbdd...

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
## * MCGestion2026 V26.08.21 (Beta cb26_)
    * Actualizado jpgraph v4.4.3
    - cb26_gastos Ajustes codigo en: Crear.php Ver.php ValidateForm.php 

----
## * MCGestion2026 V26.08.20 (Beta cb26_) py
    * INTEGRACIÓN DE SCRIPTS PY...
    - Mod_Conta Clientes y Proveedores:
        - Se integra script py para la generación de imagenes y datos automaticamente.
        - Mod_Conta\GenerarDatosPy\generaDatosImgClientProvee01Ok.py
    - Mod_Admin_Plus:
        - Se integra script py para generar datos de horarios aleatorios en varios años.
        - Mod_Admin_Plus\GenerarDatosPy\generaDatosHorarios04.py
        - Se integra script py para generar datos de documentos oficiales y comprovar la validación.
        - Mod_Admin_Plus\GenerarDatosPy\generarDatosDniOtros.py

----
## * MCGestion2026 V26.08.19B (Beta cb26_)
    - Se modifica cb23_*/*.* por cb26_*/*.*
    - Clonado de cb26_clientes en cb26_proveedores...
        - Modificación Automatica de clientes x proveedores...
        - Modificación del nombre de los archivos...
    - Se modifica Mod_Admin_Plus\config\index_Play_System.php que pasa a ser Mod_Admin_Plus\index.php
        - function process_pin() -> window.location.href='index.php?redir=1';
    - clientes_Modificar_02.php
        - Modificación de datos y cambio de nombre de imagen al modificar la referencia del cliente...
    - clientesFeed_Borrar_02.php
        - Eliminacion definitiva del cliente y su imagen...

----
## * MCGestion2026 V26.08.18 (Beta cb23_clientes)
    * cb23_clientes
        - ** Pendiente: clientes_Modificar_02.php
        - Ok Logica_01.php Show_Form.php Show_Form_Val.php 
            - Se modifican los select por input y se integra la validación...
        - Ok clientes_Crear.php.
            - datos bbdd...
            - Img cliente en servidor...
        - Ok clientes_Ver.php
            - Consulta dinánmica a la bbdd con clientes_ConsultaLogica.php
            - Paginación en ver todos los clientes...
            - Menos cliente ANONIMO inicial...
            - del = false en bbdd...
        - Ok clientes_Modificar_img.php
        - Ok clientes_Ver_02.php
            - window.close() 10s
        - clientes_Borrar_02.php
            - del de false a true en bbdd...
        - Ok clientesFeed_Recuperar_02.php
            - del de true a false en bbdd..
        - Ok clientesFeed_Ver.php
            - del = true en bbdd...
        - Ok clientesFeed_Ver_02.php
            - Se elimina el script y se visualiza en clientes_Ver_02.php
            - window.close() 10s
        - Ok clientesFeed_Borrar_02.php
            - Del datos bbdd...
            - Del img en server...
        - Ok validate.php
            - Se modifica la estructura de la librería.
            - Se validan todos los campos de formulario mediante php...
            - Se validan todos los tipos de documento...

* SE MODIFICA LA CONFIGURACIÓN DE LAS TABLAS, CLAVE FORANEA, RELACIONES Y SE ELIMINAN LAS TABLAS FEED...
* SE INTEGRA MOD_ADMIN_PLUS Con la gestión de horario laboral de los empleados.
* SE RECONFIGURA FEED Mod_Conta\cb23_clientes
----
## * MCGestion2023 V24.09.26A
    * AJUSTE DE LOS @media print
    * AJUSTES GENERALES EN CajaShop/
----
