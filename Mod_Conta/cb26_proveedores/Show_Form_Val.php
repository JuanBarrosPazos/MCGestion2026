<?php

$errors = array();
	
	if ( (strlen(trim($_POST['ref'])) == 0) && (strlen(trim($_POST['dni'])) == 0) && (strlen(trim($_POST['rsocial'])) == 0) ){
		$errors [] = " <font color='#FF0000'>UNO DE LOS TRES CAMPOS OBLIGATORIO</font>";
		}

	elseif (!preg_match('/^[a-z A-Z 0-9 \s]*$/',$_POST['ref'])){
    $errors [] = "<font color='#FF0000'>¡¡ CARÁCTERES NO VALIDOS !!</font>";
    }

	elseif (!preg_match('/^[0-9 \s]*$/',$_POST['dni'])){
		$errors [] = "<font color='#FF0000'>¡¡ SOLO NÚMEROS !!</font>";
		}

	elseif (!preg_match('/^[a-z A-Z 0-9 \s]*$/',$_POST['rsocial'])){
    $errors [] = "<font color='#FF0000'>¡¡ CARÁCTERES NO VALIDOS !!</font>";
    }

?>