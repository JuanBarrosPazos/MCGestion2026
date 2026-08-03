<?php

    if (($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){ 

        master_index();
        global $limit;          $limit = '';
        global $iniVerTodo;	$iniVerTodo = '';

        if(isset($_POST['todo'])){  show_form();							
                                    ver_todo();
                                    info();
        }elseif(isset($_POST['show_formcl'])){
                    if($form_errors = validate_form()){
                            show_form($form_errors);
                    }else{ process_form();
                            info();
                                }
        }elseif((isset($_POST['oculto2']))||(isset($_GET['imagen']))||(isset($_POST['mimg1']))||(isset($_POST['mimg2']))||(isset($_POST['mimg3']))||(isset($_POST['mimg4']))||(isset($_POST['imagenmodif']))||(isset($_POST['cero']))||(isset($_POST['borraimg']))){ 
                        process_form_img();
        }elseif(isset($_POST['ocultoDetalle'])){ 
                        process_form_Detalle();
                        info_Detalle();
        }else{  show_form();
                $limit = 'LIMIT 20';
                $iniVerTodo = 1;
                ver_todo();
                        }
                                
    } else { require '../Inclu/table_permisos.php'; }

?>