<?php
session_start();

	global $rutaHeader;		$rutaHeader = "../";
	require $rutaHeader.'Inclu/Inclu_Header.php';
	require '../../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../../Mod_Admin_Plus/Conections/conection.php';
	require '../../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){

		master_index();
		if(isset($_POST['show_formcl'])){
				if($form_errors = validate_form()){
								show_form($form_errors);
				}else{	process_form();
						log_info();
							}
		}elseif((isset($_POST['formproducto']))||(isset($_POST['formseccion']))){
			show_form();
			process_form();
		}else{ show_form(); }

	}elseif($_SESSION['Nivel']=="cliente"){
			master_index();
			show_form();
			process_form();
	}else{ require "../Inclu/AccesoDenegado.php"; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function validate_form(){
	
		// VALIDA EL FORMULARIO DE show_formcl($errors=[])
		$errors = array();

		if((!isset($_POST['Nombre']))&&(!isset($_POST['zonalocal']))){
				$errors [] = "<div style='margin: 0.1em auto 0.1em auto; text-align:center;'><font style='color:#F1BD2D;' >ZONA DEL LOCAL</font> O <font style='color:#F1BD2D;' >CRITERIO DE BUSQUEDA</font><br> UNO DE LOS CAMPOS ES OBLIGATORIO</div> ";
		}else{ }
		
		return $errors;

	}
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function process_form(){
		
		global $db;		global $db_name;
		require "../config/TablesNames.php";
		
		//show_form();

		require 'VentasSql.php';

		if(!$qc){
				print("* ERROR SQL L.62 QC ".mysqli_error($db)."</br></br>");
		}else{

			if(mysqli_num_rows($qc)== 0){
				print ("<table align='center' style=\"border:0px\">
							<tr>
								<td align='center'>
									<font color='#F1BD2D'>NO HAY DATOS</font>
								</td>
							</tr>
						</table>");
			}elseif(((isset($_POST['formseccion']))&&($_POST['seccion']!=''))||((isset($_POST['formproducto']))&&($_POST['producto']!=''))||(isset($_POST['show_formcl']))||($_SESSION['Nivel']=='cliente')||($_SESSION['Nivel']=='caja')){
					require 'VentasCalculos.php';
					require 'VentasTabla.php';
					require 'VentasGraficas.php';
			}else{  } // FIN SEGUNDO ELSE ANIDADO

		} // FIN PRIMER ELSE

	} // FINAL process_form();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function show_form($errors=[]){

		global $dy1;	global $dyt1;	global $dm1;	global $dd1;
		if((!isset($_POST['dy']))||($_POST['dy']=='')){ $dy1 = '';
														$dyt1 = date('Y'); }else{ $dy1 = $_POST['dy'];
																				  $dy1 = $dy1;
																				  $dyt1 = "20".$_POST['dy'];
																						}
		if((!isset($_POST['dm']))||($_POST['dm']=='')){ $dm1 = ''; }else{ $dm1 = $_POST['dm'];
																		  $dm1 = "-".$dm1."-";
																			}

		if((!isset($_POST['dd']))||($_POST['dd']=='')){ $dd1 = ''; }else{ $dd1 = $_POST['dd'];
																		  $dd1 = $dd1."/";
																			}

		global $db;		global $db_name;
		require "../config/TablesNames.php";

		global $Orden;
		if(isset($_POST['Orden'])){ $Orden = $_POST['Orden']; }else{ $Orden ='`id` ASC';}
		global $Nombre;
		if(isset($_POST['Nombre'])){ $Nombre = $_POST['Nombre']; }else{ $Nombre = ""; }
		global $Seccion;
		if(isset($_POST['seccion'])){ $Seccion = $_POST['seccion']; }else{ $Seccion = ""; }
		global $Producto;
		if(isset($_POST['producto'])){ $Producto = $_POST['producto']; }else{ $Producto = ""; }
		global $ZonaSec;

		if($_SESSION['Nivel']=='cliente'){ $ZonaSec = 1;
		}elseif(isset($_POST['zonaseccion'])){ $ZonaSec = $_POST['zonaseccion']; 
		}else{ $ZonaSec = ""; }

		global $ZonaLocal;
		if(isset($_POST['zonalocal'])){ $ZonaLocal = $_POST['zonalocal']; }else{ $ZonaLocal = ""; }

		global $defaults;
		if(isset($_POST['show_formcl'])){
			$defaults = array ('zonaseccion' => $ZonaSec,
								'Nombre' => $Nombre,
								'zonalocal' => $ZonaLocal,
								'Orden' => $Orden,
								'dy' => $_POST['dy'],
								'dm' => $_POST['dm'],
								'dd' => $_POST['dd'],
								'seccion' => '',
								'producto' => '',);
		}elseif(isset($_POST['formseccion'])){
			$defaults = array ('zonaseccion' => $ZonaSec,
								'Nombre' => '',
								'zonalocal' => '',
								'Orden' => $Orden,
								'dy' => $_POST['dy'],
								'dm' => $_POST['dm'],
								'dd' => $_POST['dd'],
								'seccion' => $Seccion,
								'producto' => '',);
		}elseif(isset($_POST['producto'])){
			$defaults = array ('zonaseccion' => $ZonaSec,
								'Nombre' => '',
								'zonalocal' => '',
								'Orden' => $Orden,
								'dy' => $_POST['dy'],
								'dm' => $_POST['dm'],
								'dd' => $_POST['dd'],
								'seccion' => $Seccion,
								'producto' => $Producto,);
		}else{ 
			$defaults = array ('zonaseccion' => $ZonaSec,
								'Nombre' => $Nombre,
								'zonalocal' => $ZonaLocal,
								'Orden' => $Orden,
								'dy' => '',
								'dm' => '',
								'dd' => '',
								'seccion' => $Seccion,
								'producto' => '',);
		}

		require 'VentasArrayTotal.php';
		require 'TableValidateErrors.php';
		require 'VentasShowFormComun.php';
			

	} // FIN show_form($errors=[])

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		global $rutaindex;          $rutaindex = '../';
		global $rutaOut;            $rutaOut = $rutaindex.'../';
		require '../Inclu_Menu/rutaindex.php';
		global $caja;        $caja = '';
	
		require '../Inclu_Menu/Master_Index.php';
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function log_info(){

	global $Nombre;		global $apellido;
	
	global $Orden;
	if(!isset($_POST['Orden'])){ $Orden = "`id` ASC"; }else{ $Orden = $_POST['Orden']; }
	
	if(isset($_POST['todo'])){ $Nombre = "TODOS LOS USUARIOS ".$Orden; }

	$ActionTime = date('H:i:s');

	global $LogText;
	$LogText = "- CLIENTE VER ".$ActionTime.". ".$Nombre." ".$apellido;
	
	require '../logs/LogInfo.php';

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	
	require '../Inclu/Inclu_Footer.php';
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>