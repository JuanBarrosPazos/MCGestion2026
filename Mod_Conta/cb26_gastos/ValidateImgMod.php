<?php

    $errors = array();

    $limite = 500 * 1024;

    $ext_permitidas = array('jpg','JPG','gif','GIF','png','PNG','pdf','PDF','bmp','BMP');

    $extension = substr($_FILES['myimg']['name'],-3);
    // print($extension);
    // $extension = end(explode('.', $_FILES['myimg']['name']) );
    $ext_correcta = in_array($extension, $ext_permitidas);

    // $tipo_correcto = preg_match('/^image\/(gif|png|jpg|bmp)$/', $_FILES['myimg']['type']);

    if($_FILES['myimg']['size'] == 0){
        $errors [] = "Ha de seleccionar un documento imagen scaner o pdf";
    }elseif(!$ext_correcta){
        $errors [] = "La extension no esta admitida: ".$_FILES['myimg']['name'];
    }/*	elseif(!$tipo_correcto){
            $errors [] = "Este tipo de archivo no esta admitido: ".$_FILES['myimg']['name'];
    }*/elseif($_FILES['myimg']['size'] > $limite){
    $tamanho = $_FILES['myimg']['size'] / 1024;
    $errors [] = "El archivo".$_FILES['myimg']['name']." es mayor de 500 KBytes. ".$tamanho." KB";
    }elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_PARTIAL){
            $errors [] = "La carga del archivo se ha interrumpido.";
    }elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_NO_FILE){
                $errors [] = "Es archivo no se ha cargado.";
                }
                

?>