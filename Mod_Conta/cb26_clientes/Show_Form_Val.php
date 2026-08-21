<?php

$errors = array();
	
	if ((strlen(trim($_POST['ref'])) == 0) && (strlen(trim($_POST['rsocial'])) == 0)){

		$errors [] = " <font color='#F1BD2D'>UNO DE LOS DOS CAMPOS OBLIGATORIO</font>";

	}elseif((strlen(trim($_POST['ref'])) > 20) OR (strlen(trim($_POST['rsocial'])) > 20) ){

    	$errors [] = "<font color='#F1BD2D'>¡¡ MÁXIMO 20 CARACTERES !!</font>";

	}elseif (!preg_match('/^[a-z A-Z 0-9 \s]*$/',$_POST['ref'])){

    	$errors [] = "<font color='#F1BD2D'>¡¡ CARÁCTERES NO VALIDOS !!</font>";

    }elseif (!preg_match('/^[a-z A-Z 0-9 \s]*$/',$_POST['rsocial'])){

    	$errors [] = "<font color='#F1BD2D'>¡¡ CARÁCTERES NO VALIDOS !!</font>";
 
    }

?>