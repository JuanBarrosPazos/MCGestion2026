<?php
session_start();

	require 'Inclu/Inclu_Menu_00.php';
	require '../Mod_Admin_Plus/Inclu/my_bbdd_clave.php';
	require '../Mod_Admin_Plus/Conections/conection.php';
	require '../Mod_Admin_Plus/Conections/conect.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
 
	require "Inclu/Only.index.Cliente.php";
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
					
	if(isset($_POST['oculto'])){
		if($form_errors = validate_form()){
							suma_denegado ();
							show_form($form_errors);
		}else{ 	admin_entrada();
				suma_acces();
				process_form();
						}
	}elseif(isset($_POST['salir'])) { salir();
									  show_form();
	}elseif(isset($_SESSION['Nivel'])){
							admin_entrada();
							process_form();
							//ayear();
	}else{ suma_visit();	
			//show_form();

			global $RedirUrl;	$RedirUrl = "../Mod_Admin_Plus/index.php";
			global $RedirTime;	$RedirTime = 10;
			require '../Inclu/AutoRedirUrl.php';
			global $Redir;      print ($Redir);
	}
				
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function admin_entrada(){

	global $db; 			global $db_name;
	global $userid; 		global $uservisita;

	global $dir;
	if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')||($_SESSION['Nivel']=='plus')){
		$dir = 'Admin';
		}elseif ($_SESSION['Nivel']=='cliente'){ $dir = 'ClientesWeb';
	}elseif (($_SESSION['Nivel']=='user') || ($_SESSION['Nivel']=='caja')){ $dir = 'User';}
	
	$total = $uservisita + 1;
	$datein = date('Y-m-d/H:i:s');

	require "config/TablesNames.php";

	$sqladin = "UPDATE `$db_name`.$ClientesWeb SET `lastin` = '$datein', `visitadmin` = '$total' WHERE $ClientesWeb.`id` = '$userid' LIMIT 1 ";
		
	if(mysqli_query($db, $sqladin)){
			// print("* ");
		}else{ 
			print("</br><font color='#F1BD2D'>* FATAL ERROR funcion admin_entrada(): </font></br> ".mysqli_error($db))."</br>";
							}
					
	$logname = $_SESSION['Nombre'];	
	$logape = $_SESSION['Apellidos'];	
	$logname = trim($logname);	
	$logape = trim($logape);	
	$logdocu = $logname."_".$logape;
	$logdate = date('Y_m_d');
	$LogText = "\n** INICIO SESION => .".$datein.".\n \t User Ref: ".$_SESSION['ref'].".\n \t ".$_SESSION['Nombre']." ".$_SESSION['Apellidos']."\n \n";
	$filename = "logs/".$dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $LogText);
	fclose($log);

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_visit(){

	global $rowv;
	global $sumavisit;
	
	require "config/TablesNames.php";
	$sqlv =  "SELECT * FROM $VisitasClientesWeb";
	$qv = mysqli_query($db, $sqlv);
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit;
	$sumavisit = $tot + 1;

	$idv = 69;

	if(mysqli_query($db, $sqlv)){
			print(" <div style='clear:both'></div>
			 		<table align='right' style='margin-top:0px'>
						<tr>	
							<td align='right'><font color='#59746A'>VISITAS:</font></td>
							<td  align='right'><font color='#59746A'>".$tot."</font></td>
						</tr>
						<tr>
							<td><font color='#59746A'>ACCESOS PERMITIDOS: </font></td>
							<td align='right'><font color='#59746A'>".$rowv['acceso']."</font></td>
						</tr>
						<tr>
							<td><font color='#59746A'>ACCESOS DENEGADOS:</font></td>
							<td align='right'><font color='#59746A'>".$rowv['deneg']."</font></td>
						</tr>
					</table></br>");
		}else{ 
			("<font color='#F1BD2D'>* Error: </font></br>&nbsp;&nbsp;&nbsp;".mysqli_error($db)." </br>");
				}
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_visit(){

	global $rowv;
	global $sumavisit;
	
	require "config/TablesNames.php";
	$sqlv =  "SELECT * FROM $VisitasClientesWeb";
	$qv = mysqli_query($db, $sqlv);
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit;
	$sumavisit = $tot + 1;

	$idv = 69;
	
	require "config/TablesNames.php";

	$sqlv = "UPDATE `$db_name`.$VisitasClientesWeb SET `admin` = '$sumavisit' WHERE $VisitasClientesWeb.`idv` = '$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqlv)){ print(" </br>");
		}else{ 
				print("<font color='#F1BD2D'>* Error: </font></br>&nbsp;&nbsp;&nbsp;".mysqli_error($db)."</br>");
							}
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_acces(){

	global $rowa;
	global $sumaacces;
	
	require "config/TablesNames.php";
	$sqla =  "SELECT * FROM $VisitasClientesWeb";
	$qa = mysqli_query($db, $sqla);
	
	$rowa = mysqli_fetch_assoc($qa);
	
	$_SESSION['acceso'] = $rowa['acceso'];
	
	$tota = $rowa['acceso'];

	global $sumaacces;
	$sumaacces = $tota + 1;
	
	$idv = 69;
	
	require "config/TablesNames.php";

	$sqla = "UPDATE `$db_name`.$VisitasClientesWeb SET `acceso` = '$sumaacces' WHERE $VisitasClientesWeb.`idv` = '$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqla)){ print ('</br>');
			}else{ print("<font color='#F1BD2D'>
						* Error: </font>
						</br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db)."
						</br>");
					}

		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_denegado(){

	global $rowd;
	global $sumadeneg;

	require "config/TablesNames.php";
	$sqld =  "SELECT * FROM $VisitasClientesWeb";
	$qd = mysqli_query($db, $sqld);
	$rowd = mysqli_fetch_assoc($qd);
	
	$_SESSION['deneg'] = $rowd['deneg'];
	
	$dng = $rowd['deneg'];
	
	global $sumadeneg;
	$sumadeneg = $dng + 1;
	
	$idd = 69;
	
	require "config/TablesNames.php";

	$sqld = "UPDATE `$db_name`.$VisitasClientesWeb SET `deneg` = '$sumadeneg' WHERE $VisitasClientesWeb.`idv` = '$idd' LIMIT 1 ";

	if(mysqli_query($db, $sqld)){ print("	</br>");
			}else{ print("<font color='#F1BD2D'>
						* Error: </font>
						</br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db)."
						</br>");
				}

		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	global $db;
	global $sql;
	global $q;
	global $row;
	
	$errors = array();
	
	if (strlen(trim($_POST['Usuario'])) == 0){
		$errors [] = "Usuario: Campo obligatorio.";
		}
	
	if (strlen(trim($_POST['Password'])) == 0){
		$errors [] = "Password: Campo Obligatorio:";
		}
		
	
	if(trim($_POST['Usuario'] != @$row['Usuario'])){
		$errors [] = "Nombre o Password incorrecto.";
		}
	
	elseif(trim($_POST['Password'] != @$row['Password'])){
		$errors [] = "Nombre o Password incorrecto.";
		}

	return $errors;

		} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
if ($_SESSION['Nivel']=='cliente'){				 
print("WELLCOME ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].". REF CLIENT: ".$_SESSION['ref']);
	
	master_index();
								
	global $nombre; 
	global $apellido;
	$nombre = $_SESSION['Nombre'];
	$apellido = $_SESSION['Apellidos'];
		
	require "config/TablesNames.php";
	$sqlb =  "SELECT * FROM $ClientesWeb WHERE `Nombre` = '$nombre' AND `Apellidos` = '$apellido'  ";
 	
	$qb = mysqli_query($db, $sqlb);
	
	if(!$qb){ print("<font color='#F1BD2D'>Se ha producido un error: </font>".mysqli_error($db)."</br></br>");
				show_form();	
		}else{ 
				global $KeyIndex;		$KeyIndex = 1;
				global $KeyBorraUser;	$KeyBorraUser = 1;
				require "ClientesWeb/UserWhileTabla.php";

					} /***** Fin de primer else . */
		
		}	else{ 
			require "Inclu/AccesoDenegado.php";			

					}
				
	}	/* Final process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
		}else{ $defaults = array ('Usuario' => '',
								    'Password' => '');
								   }
	
	if ($errors){
		print("<font color='#F1BD2D'>Solucione estos errores:</font></br>");
		
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#F1BD2D'>* Campo </font>".$errors [$a]."</br>");
			}
		}
		
	print("".show_visit()."<div style='clear:both'></div>
			<table align='center' style=\"margin-top:2px; margin-bottom:8px\" >
				<tr>
					<th colspan=2 width=100% valign=\"bottom\" class='BorderInf'>
						<a href='ClientesWebClienteCrear.php'>
							CREAR NUEVO CLIENTE
						</a>
					</th>
				</tr>
				
				<tr>
					<th colspan=2 width=100% valign=\"bottom\" class='BorderInf'>
						DATOS DE ACCESO CLIENTE
					</th>
				</tr>
				
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
						
				<tr>
					<td>	
						USUARIO
					</td>
					<td>
		<input type='Password' name='Usuario' size=20 maxlength=50 value='".$defaults['Usuario']."' />
					</td>
				</tr>
	
				<tr>
					<td>	
						PASSWORD
					</td>
					<td>
		<input type='Password' name='Password' size=20 maxlength=50 value='".$defaults['Password']."' />
					</td>
				</tr>
	
				<tr>
					<td valign='middle' align='right' colspan='2'>
						<input type='submit' class='submit' value='ACCEDER' />
						<input type='hidden' name='oculto' value=1 />
					</td>
				</tr>
		</form>	
				<tr>
					<th colspan=2 width=100% valign=\"bottom\" class='BorderSup'>
						<a href='Admin_index.php'>
							ACCESO ADMINISTRACION SISTEMA
						</a>
					</th>
				</tr>
			</table>"); 
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){

		require 'Inclu/Master_In_Clientes_00.php';
		
				}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function salir() {
		
		unset($_SESSION['id']);				unset($_SESSION['ref']);
		unset($_SESSION['Nivel']);			unset($_SESSION['Nombre']);
		unset($_SESSION['Apellidos']); 		unset($_SESSION['dni']);
		unset($_SESSION['ldni']);			unset($_SESSION['Email']);
		unset($_SESSION['Usuario']);		unset($_SESSION['Password']);
		unset($_SESSION['Direccion']);		unset($_SESSION['Tlf1']);
		unset($_SESSION['Tlf2']);			unset($_SESSION['myimg']);
		unset($_SESSION['lastin']);			unset($_SESSION['lastout']);
		unset($_SESSION['visitadmin']);		unset($_SESSION['GestMyImg']);
		unset($_SESSION['nclient']);

		print("HA CERRADO SESION</br>");
		
	}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require 'Inclu/Inclu_Footer.php';

?>