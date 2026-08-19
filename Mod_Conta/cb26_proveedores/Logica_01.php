<?php

	if(isset($_POST['todo'])){ 	show_form();							
								ver_todo();
								info();

	}elseif(isset($_POST['oculto'])){
			/*if($form_errors = validate_form()){
						show_form($form_errors);
			} else {*/process_form();
					info();
						//}

	}elseif((isset($_POST['oculto2']))||(isset($_POST['imagenmodif']))){
		show_form();
		require 'proveedores_Modificar_img.php';
		if (isset($_POST['oculto2'])){
				show_form_img();
		} elseif (isset($_POST['imagenmodif'])){
			if($form_errors = validate_form_img()){
				show_form_img($form_errors);
			} else { process_form_img();
					 info_img();
						}
									
		} else { show_form_img(); }


	}else { show_form();
			ver_todo();}

?>