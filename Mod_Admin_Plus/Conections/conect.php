<?php

/*
global $db;	 		global $db_host; 		global $db_user; 		global $db_pass;
global $db_name; 	global $dbconecterror;

$db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(!$db){ die ("Es imposible conectar con la bbdd ".$db_name."</br>".mysqli_connect_error());
            }
*/


	global $db, $db_host, $db_user, $db_pass;         global $cero_conection;
    global $keyIndex;   global $keyBlog;

    if(($cero_conection == 1)||($keyBlog == 1)){
        echo ("ES IMPOSIBLE CONECTAR CON LA BBDD...</br>");
        header('Location: Mod_Admin_Plus/index.php');
        global $redir;
        $redir = "<script type='text/javascript'>
                    function redir(){
                        window.location.href='Mod_Admin_Plus/index.php';
                    }
                    setTimeout('redir()',50);
                </script>";
        print ($redir);
    }else{
        mysqli_report(MYSQLI_REPORT_OFF);
        $db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
        if (!$db){ 
            /*die*/
            echo ("Es imposible conectar con la bbdd ".$db_name."</br>".mysqli_connect_error());

            if($keyBlog == 1){
                header('Location: ../Mod_Admin_Plus/index.php');
                global $redir;
                $redir = "<script type='text/javascript'>
                            function redir(){
                                window.location.href='../Mod_Admin_Plus/index.php';
                            }
                            setTimeout('redir()',500);
                        </script>";
                print ($redir);
            }if($keyIndex == 1){
                header('Location: Mod_Admin_Plus/index.php');
                global $redir;
                $redir = "<script type='text/javascript'>
                            function redir(){
                                window.location.href='Mod_Admin_Plus/index.php';
                            }
                            setTimeout('redir()',500);
                        </script>";
                print ($redir);
            }else{  
                echo ("Es imposible conectar con la bbdd ".$db_name."</br>".mysqli_connect_error());
            }
            // FIN SI NO SE CUMPLE LA CONEXIÓN A BBDD
        }else{
            if($keyIndex == 1){
                //header('Location: Mod_Gestion/Admin_index.php');
                header('Location: Mod_Gestion/index.php');
                global $redir;
                $redir = "<script type='text/javascript'>
                            function redir(){
                                /*window.location.href='Mod_Gestion/Admin_index.php';*/
                                window.location.href='Mod_Gestion/Admin_index.php';
                            }
                            setTimeout('redir()',500);
                        </script>";
                print ($redir);
                }else{ }
            // FIN SI NO SE CUMPLE LA CONEXIÓN A BBDD
        }

    } // FIN $cero_conection == 1  

?>