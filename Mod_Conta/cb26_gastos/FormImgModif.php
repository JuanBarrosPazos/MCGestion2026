<?php

		global $db; 		global $db_name; 	global $vname;	global $img; 	global $imgcamp;
		global $rutaDir;	global $borraImg;	global $extension;

		global $safe_filename;		global $nombre;		global $destination_file;
		if($borraImg == 1){

			$safe_filename = trim(str_replace('/', '', $_POST['myimg']));
			$safe_filename = trim(str_replace('..', '', $safe_filename));

			$nombre = $_POST['myimg'];

			$destination_file = $rutaDir.$safe_filename;

			if(file_exists($rutaDir.$nombre)){
							unlink($rutaDir.$nombre);
			}else{ }
			
			
			if(!file_exists($rutaDir.$nombre)){
				//copy($rutaDir."untitled.png", $rutaDir.$nombre);

				if(copy($rutaDir."untitled.png", $destination_file)){

					$extension = substr($nombre,-3);
					$extension = strtolower($extension);
					if($extension == "pdf"){ $extension = "png"; }else{ }
				
					require 'FormImgModifExt.php';
								
				}else{ print("NO SE HA PODIDO GUARDAR EN ../imgpro/imgpro".$_SESSION['miseccion']."/"); }

			} // FIN LA FILE NO EXISTE

		}else{ // SI $borraImg == 1

			$safe_filename = trim(str_replace('/', '', $_FILES['myimg']['name']));
			$safe_filename = trim(str_replace('..', '', $safe_filename));

			$nombre = $_FILES['myimg']['name'];
			$nombre_tmp = $_FILES['myimg']['tmp_name'];
			$tipo = $_FILES['myimg']['type'];
			$tamano = $_FILES['myimg']['size'];

			$destination_file = $rutaDir.$safe_filename;

			if(file_exists($rutaDir.$nombre) ){
							unlink($rutaDir.$nombre);
			}elseif(move_uploaded_file($_FILES['myimg']['tmp_name'], $destination_file)){
				
				// Eliminar el archivo antiguo untitled.png
				if($_SESSION['ImgCb23'] != 'untitled.png' ){
							@unlink($rutaDir.$_SESSION['ImgCb23']);
											}
				$extension = substr($_FILES['myimg']['name'],-3);
				$extension = strtolower($extension);

				require 'FormImgModifExt.php';

			}else{ print("NO SE HA PODIDO GUARDAR EN ../imgpro/imgpro".$_SESSION['miseccion']."/"); }

	} // FIN ELSE $borraImg == 1


		


?>