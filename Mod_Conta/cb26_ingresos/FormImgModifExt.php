<?php

	// Renombrar el archivo:
	global $extension;

	// print($extension);
	// $extension = end(explode('.', $_FILES['myimg']['name']) );
	date('H:i:s');
	date('Y-m-d');
	$dt = date('is');
	global $new_name;
	//	$new_name = $_SESSION['ImgCb23'];
	$new_name = $_SESSION['mivalor']."_".$dt.".".$extension;
	$rename_filename = $rutaDir.$new_name;								
	rename($destination_file, $rename_filename);

	global $mivalor; 	$imgcamp = "`".$_SESSION['imgcamp']."`";
	$mivalor = $_SESSION['mivalor'];
			
	$sqla = "UPDATE `$db_name`.$vname SET $imgcamp = '$new_name' WHERE $vname.`id` = '$_SESSION[miid]' AND $vname.`factnum` = '$mivalor' LIMIT 1 ";
			
	if(mysqli_query($db, $sqla)){
		
		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='".$rutaRedir."Ver.php?imagen=1';
					}
					setTimeout('redir()',1);
					</script>";
		print ($redir);

	}else { print("* ERROR ".mysqli_error($db));
			show_form ();
			global $texerror;		$texerror = "\n\t ".mysqli_error($db);
				}
    


?>