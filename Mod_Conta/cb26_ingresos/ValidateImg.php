<?php

	if($_FILES['myimg1']['size'] == 0){	}
	else{
			
		$limite = 500 * 1024;
		
		$ext_permitidas = array('jpg','JPG','gif','GIF','png','PNG','pdf','PDF','bmp','BMP');
		
		$extension1 = substr($_FILES['myimg1']['name'],-3);
		// print($extension1);
		// $extension1 = end(explode('.', $_FILES['myimg1']['name']) );

		$ext_correcta1 = in_array($extension1, $ext_permitidas);

		// $tipo_correcto1 = preg_match('/^image\/(gif|png|jpg|bmp)$/', $_FILES['myimg1']['type']);

		if(!$ext_correcta1){
				$errors [] = "La extension no esta admitida: ".$_FILES['myimg1']['name'];
				}
		/*	
			elseif(!$tipo_correcto1){
				$errors [] = "Este tipo de archivo no esta admitido: ".$_FILES['myimg1']['name'];
				}
		*/	

		elseif ($_FILES['myimg1']['size'] > $limite){
		$tamanho1 = $_FILES['myimg1']['size'] / 1024;
		$errors [] = "El archivo".$_FILES['myimg1']['name']." es mayor de 500 KBytes. ".$tamanho1." KB";
		
        }elseif ($_FILES['myimg1']['error'] == UPLOAD_ERR_PARTIAL){
				$errors [] = "La carga del archivo se ha interrumpido.";
		}elseif ($_FILES['myimg1']['error'] == UPLOAD_ERR_NO_FILE){
					$errors [] = "Es archivo no se ha cargado.";
					}
	}
		
	//////////////

	if($_FILES['myimg2']['size'] == 0){}
	else{
		 
		$limite = 500 * 1024;
		$ext_permitidas = array('jpg','JPG','gif','GIF','png','PNG','pdf','PDF','bmp','BMP');
		
		$extension2 = substr($_FILES['myimg2']['name'],-3);
		// print($extension2);
		// $extensio2n = end(explode('.', $_FILES['myimg2']['name']) );
		$ext_correcta2 = in_array($extension2, $ext_permitidas);

		// $tipo_correcto2 = preg_match('/^image\/(gif|png|jpg|bmp)$/', $_FILES['myimg2']['type']);

		if(!$ext_correcta2){
			$errors [] = "La extension no esta admitida: ".$_FILES['myimg2']['name'];
			}
		/*
		elseif(!$tipo_correcto2){
			$errors [] = "Este tipo de archivo no esta admitido: ".$_FILES['myimg2']['name'];
			}
		*/
		elseif ($_FILES['myimg2']['size'] > $limite){
		$tamanho2 = $_FILES['myimg2']['size'] / 1024;
		$errors [] = "El archivo".$_FILES['myimg2']['name']." es mayor de 500 KBytes. ".$tamanho2." KB";
		}elseif ($_FILES['myimg2']['error'] == UPLOAD_ERR_PARTIAL){
				$errors [] = "La carga del archivo se ha interrumpido.";
		}elseif ($_FILES['myimg2']['error'] == UPLOAD_ERR_NO_FILE){
					$errors [] = "Es archivo no se ha cargado.";
		}
	}

	//////////////

	if($_FILES['myimg3']['size'] == 0){}
	else{
		 
		$limite = 500 * 1024;
		$ext_permitidas = array('jpg','JPG','gif','GIF','png','PNG','pdf','PDF','bmp','BMP');
		
		$extension3 = substr($_FILES['myimg3']['name'],-3);
		// print($extension3);
		// $extension3 = end(explode('.', $_FILES['myimg3']['name']) );
		$ext_correcta3 = in_array($extension3, $ext_permitidas);

		// $tipo_correcto3 = preg_match('/^image\/(gif|png|jpg|bmp)$/', $_FILES['myimg3']['type']);

		 
		if(!$ext_correcta3){
			$errors [] = "La extension no esta admitida: ".$_FILES['myimg3']['name'];
			}
		/*
		elseif(!$tipo_correcto3){
			$errors [] = "Este tipo de archivo no esta admitido: ".$_FILES['myimg3']['name'];
			}
		*/
		elseif ($_FILES['myimg3']['size'] > $limite){
		$tamanho3 = $_FILES['myimg3']['size'] / 1024;
		$errors [] = "El archivo".$_FILES['myimg3']['name']." es mayor de 500 KBytes. ".$tamanho3." KB";
		}elseif ($_FILES['myimg3']['error'] == UPLOAD_ERR_PARTIAL){
				$errors [] = "La carga del archivo se ha interrumpido.";
		}elseif ($_FILES['myimg3']['error'] == UPLOAD_ERR_NO_FILE){
					$errors [] = "Es archivo no se ha cargado.";
					}
	}

	//////////////

	if($_FILES['myimg4']['size'] == 0){ }
	else{
		 
        $limite = 500 * 1024;
        $ext_permitidas = array('jpg','JPG','gif','GIF','png','PNG','pdf','PDF','bmp','BMP');
        
        $extension4 = substr($_FILES['myimg4']['name'],-3);
        // print($extension4);
        // $extension4 = end(explode('.', $_FILES['myimg4']['name']) );
        $ext_correcta4 = in_array($extension4, $ext_permitidas);

        // $tipo_correcto4 = preg_match('/^image\/(gif|png|jpg|bmp)$/', $_FILES['myimg4']['type']);

        if(!$ext_correcta4){
            $errors [] = "La extension no esta admitida: ".$_FILES['myimg4']['name'];
            }
        /*
        elseif(!$tipo_correcto4){
            $errors [] = "Este tipo de archivo no esta admitido: ".$_FILES['myimg4']['name'];
            }
        */
        elseif($_FILES['myimg4']['size'] > $limite){
        $tamanho4 = $_FILES['myimg4']['size'] / 1024;
        $errors [] = "El archivo".$_FILES['myimg4']['name']." es mayor de 500 KBytes. ".$tamanho4." KB";
        
        }elseif($_FILES['myimg4']['error'] == UPLOAD_ERR_PARTIAL){
                    $errors [] = "La carga del archivo se ha interrumpido.";
        }elseif ($_FILES['myimg4']['error'] == UPLOAD_ERR_NO_FILE){
                        $errors [] = "Es archivo no se ha cargado.";
                        }
	}

?>