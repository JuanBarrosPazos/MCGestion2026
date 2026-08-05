<?php

    global $Nivel;				global $defaults;		
	global $ArrayConfig, $ArrayCliente, $ArrayAdmin, $ArrayProveedor;
	global $ArrayCaja, $ArrayClienteCrea, $ArrayClienteModif;	

    if($ArrayConfig == 1){
        $Nivel = array ( 'admin' => 'NIVEL USUARIO',
                         'admin' => 'ADMINISTRADOR',);
    }elseif($ArrayCliente == 1){
        $Nivel = array ( 'cliente' => 'NIVEL USUARIO',
                         'cliente' => 'CLIENTE',);														
    }elseif($ArrayCaja == 1){
		$Nivel = array ( '' => 'NIVEL USUARIO',
						'cliente' => 'CLIENTE',
						'caja'  => 'USER CAJERO/A',);
	}elseif($ArrayAdmin == 1){        
		$Nivel = array ( '' => 'NIVEL USUARIO',
                        'cliente' => 'CLIENTE',
                        'caja'  => 'USER CAJERO/A',
						'close'  => 'USER CAJERO/A',);	
	}else{ }               

	if(($ArrayAdmin == 1)||($ArrayCliente == 1)||($ArrayCaja == 1)){
	
		/* EL ARRAY DE MOD ADMIN...
		$Nivel = array ('' => 'NIVEL USUARIO',
									'admin' => 'ADMINISTRADOR',
									'plus' => 'USER PLUS',
									'user' => 'USER',
									'close' => 'CLOSE', );	
		*/
		global $doctype;
		$doctype = array (	'DNI' => 'DNI/NIF Espa&ntilde;oles',
							'NIE' => 'NIE/NIF Extranjeros',
							'NIFespecial' => 'NIF Persona F&iacute;sica Especial',
							/*
							'NIFsa' => 'NIF Sociedad An&oacute;nima',
							'NIFsrl' => 'NIF Sociedad Responsabilidad Limitada',
							'NIFscol' => 'NIF Sociedad Colectiva',
							'NIFscom' => 'NIF Sociedad Comanditaria',
							'NIFcbhy' => 'NIF Comunidad Bienes y Herencias Yacentes',
							'NIFscoop' => 'NIF Sociedades Cooperativas',
							'NIFasoc' => 'NIF Asociaciones',
							'NIFcpph' => 'NIF Comunidad Propietarios Propiedad Horizontal',
							'NIFsccspj' => 'NIF Sociedad Civil, con o sin Personalidad Juridica',
							'NIFee' => 'NIF Entidad Extranjera',
							'NIFcl' => 'NIF Corporaciones Locales',
							'NIFop' => 'NIF Organismo Publico',
							'NIFcir' => 'NIF Congragaciones Instituciones Religiosas',
							'NIFoaeca' => 'NIF Organos Admin Estado y Comunidades Autonomas',
							'NIFute' => 'NIF Uniones Temporales de Empresas',
							'NIFotnd' => 'NIF Otros Tipos no Definidos',
							'NIFepenr' => 'NIF Establecimientos Permanentes Entidades no Residentes',
							*/
						);

    }elseif($ArrayProveedor == 1) {
        	$doctype = array (	'DNI' => 'DNI/NIF Espa&ntilde;oles',
						'NIE' => 'NIE/NIF Extranjeros',
						'NIFespecial' => 'NIF Persona F&iacute;sica Especial',
						'NIFsa' => 'NIF Sociedad An&oacute;nima',
						'NIFsrl' => 'NIF Sociedad Responsabilidad Limitada',
						'NIFscol' => 'NIF Sociedad Colectiva',
						'NIFscom' => 'NIF Sociedad Comanditaria',
						'NIFcbhy' => 'NIF Comunidad Bienes y Herencias Yacentes',
						'NIFscoop' => 'NIF Sociedades Cooperativas',
						'NIFasoc' => 'NIF Asociaciones',
						'NIFcpph' => 'NIF Comunidad Propietarios Propiedad Horizontal',
						'NIFsccspj' => 'NIF Sociedad Civil, con o sin Personalidad Juridica',
						'NIFee' => 'NIF Entidad Extranjera',
						'NIFcl' => 'NIF Corporaciones Locales',
						'NIFop' => 'NIF Organismo Publico',
						'NIFcir' => 'NIF Congragaciones Instituciones Religiosas',
						'NIFoaeca' => 'NIF Organos Admin Estado y Comunidades Autonomas',
						'NIFute' => 'NIF Uniones Temporales de Empresas',
						'NIFotnd' => 'NIF Otros Tipos no Definidos',
						'NIFepenr' => 'NIF Establecimientos Permanentes Entidades no Residentes',);
    }else { }

	global $ArrayFeedRecup;
	if($ArrayFeedRecup == 1){
		if((isset($_POST['oculto2']))||(isset($_POST['borrar']))){
			$defaults = array ( 'id' => $_POST['id'],'ref' => $_POST['ref'],
								'Nombre' => $_POST['Nombre'],'Apellidos' => $_POST['Apellidos'],
								'myimg' => $_POST['myimg'],'Nivel' => $_POST['Nivel'],
								'doc' => $_POST['doc'],'dni' => $_POST['dni'],'ldni' => $_POST['ldni'],
								'Email' => $_POST['Email'],
								'Usuario' => $_POST['Usuario'],'Usuario2' => $_POST['Usuario'],
								'Password' => $_POST['Password'],'Password2' => $_POST['Password'],
								'Direccion' => $_POST['Direccion'],
								'Tlf1' => $_POST['Tlf1'],'Tlf2' => $_POST['Tlf2'],
								'lastin' => $_POST['lastin'],'lastout' => $_POST['lastout'],
								'visitadmin' => $_POST['visitadmin'],);
		}elseif(isset($_POST['modifica'])){
			$defaults = array ( 'id' => $_POST['id'],'ref' => $_POST['ref'],
								'Nombre' => $_POST['Nombre'],'Apellidos' => $_POST['Apellidos'],
								'myimg' => $_POST['myimg'],'Nivel' => $_POST['Nivel'],							
								'doc' => $_POST['doc'],'dni' => $_POST['dni'],'ldni' => $_POST['ldni'],
								'Email' => $_POST['Email'],
								'Usuario' => $_POST['Usuario'],'Usuario2' => @$_POST['Usuario2'],
								'Password' => $_POST['Password'],'Password2' => @$_POST['Password2'],
								'Direccion' => $_POST['Direccion'],
								'Tlf1' => $_POST['Tlf1'],'Tlf2' => $_POST['Tlf2'],
								'lastin' => $_POST['lastin'],'lastout' => $_POST['lastout'],
								'visitadmin' => $_POST['visitadmin'],);
		}else{ }
	
	}elseif($ArrayClienteCrea == 1){
		if(isset($_POST['oculto'])){
			$defaults = array ( 'Nombre' => $_POST['Nombre'],'Apellidos' => $_POST['Apellidos'],
								'myimg' => @$_POST['myimg'],'Nivel' => $_POST['Nivel'],
								'doc' => $_POST['doc'],'dni' => $_POST['dni'],'ldni' => $_POST['ldni'],
								'Email' => $_POST['Email'],
								'Usuario' => $_POST['Usuario'],'Usuario2' => $_POST['Usuario2'],
								'Password' => $_POST['Password'],'Password2' => $_POST['Password2'],
								'Direccion' => $_POST['Direccion'],
								'Tlf1' => $_POST['Tlf1'],'Tlf2' => $_POST['Tlf2'],
								'Condiciones' => @$_POST['Condiciones'],
								'Datos' => @$_POST['Datos'],);
		}else{	
			$defaults = array ( 'Nombre' => '','Apellidos' => '',
								'myimg' => '','Nivel' => '',
								'doc' => '','dni' => '','ldni' => '',
								'Email' => '',
								'Usuario' => '','Usuario2' => '',
								'Password' => '','Password2' => '',
								'Direccion' => '','Tlf1' => '','Tlf2' => '',
								'Condiciones' => '','Datos' => '',);
		}

	}elseif( $ArrayClienteModif == 1){
		if(isset($_POST['oculto2'])){
			$defaults = array ( 'id' => $_POST['id'],'refnew' => $_POST['ref'],
								'Nombre' => $_POST['Nombre'],'Apellidos' => $_POST['Apellidos'],
								'myimg' => $_POST['myimg'],'Nivel' => $_POST['Nivel'],								
								'doc' => $_POST['doc'],'dni' => $_POST['dni'],'ldni' => $_POST['ldni'],
								'Email' => $_POST['Email'],
								'Usuario' => $_POST['Usuario'],'Usuario2' => $_POST['Usuario'],
								'Password' => $_POST['Password'],'Password2' => $_POST['Password'],
								'Direccion' => $_POST['Direccion'],
								'Tlf1' => $_POST['Tlf1'],'Tlf2' => $_POST['Tlf2'],
								'lastin' => "",'lastout' => "",
								'visitadmin' => "",);
		}elseif($_POST['modifica']){
			$defaults = array ( 'id' => $_POST['id'],'refnew' => $_POST['refnew'],
								'Nombre' => $_POST['Nombre'],'Apellidos' => $_POST['Apellidos'],
								'myimg' => $_POST['myimg'],'Nivel' => $_POST['Nivel'],
								'doc' => $_POST['doc'],'dni' => $_POST['dni'],'ldni' => $_POST['ldni'],
								'Email' => $_POST['Email'],
								'Usuario' => $_POST['Usuario'],'Usuario2' => $_POST['Usuario2'],
								'Password' => $_POST['Password'],'Password2' => $_POST['Password2'],
								'Direccion' => $_POST['Direccion'],
								'Tlf1' => $_POST['Tlf1'],'Tlf2' => $_POST['Tlf2'],
								'lastin' => "",'lastout' => "",
								'visitadmin' => "",);
		}else{ }
	

	}
	
	
	else{

	}




?>