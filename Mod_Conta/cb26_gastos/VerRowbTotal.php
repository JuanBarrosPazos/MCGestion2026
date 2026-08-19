<?php

        switch (true) {
                case ((!isset($vname))&&(strlen(trim($vname)) == 0)):
                        $vname = $vnameBot; 
                        break;
                case ((isset($vname))&&(strlen(trim($vname)) != 0)):
                        //echo "NO HAGO NADA";
                        //echo "* ".$vname."<br>";
                        break;
                case ((isset($_SESSION['vname']))&&(strlen(trim(@$_SESSION['vname'])) != 0)):
                        $vname = @$_SESSION['vname'];  
                        break;
                default:
                        echo "<table class='tableForm'><tr><td>
                                ERROR EN VARIABLE VNAME DE BBDD
                                </td></tr></table>";
                        global $redir;
                        $redir = "<script type='text/javascript'>
                                        function redir(){
                                        window.location.href='Ver.php';
                                                }
                                        setTimeout('redir()',8000);
                                        </script>";
                        print ($redir);
                        break;
        } // FIN SWITCH CASE

        print(" <input type='hidden' name='dyt1' value='".$dyt1."' />
                <input type='hidden' name='vname' value='".$vname."' />
                <input type='hidden' name='id' value='".$rowb['id']."' />
                <input type='hidden' name='factnum' value='".$rowb['factnum']."' />
                <input type='hidden' name='factnumini' value='".$rowb['factnumini']."' />
                <input type='hidden' name='factdate' value='".$rowb['factdate']."' />
                <input type='hidden' name='factdateini' value='".$rowb['factdateini']."' />
                <input type='hidden' name='factnom' value='".$rowb['factnom']."' />
                <input type='hidden' name='factnif' value='".$rowb['factnif']."' />
                <input type='hidden' name='factiva' value='".$rowb['factiva']."' />
                <input type='hidden' name='factivae' value='".$rowb['factivae']."' />
                <input type='hidden' name='factpvp' value='".$rowb['factpvp']."' />
                <input type='hidden' name='factret' value='".$rowb['factret']."' />
                <input type='hidden' name='factrete' value='".$rowb['factrete']."' />
                <input type='hidden' name='factpvptot' value='".$rowb['factpvptot']."' />
                <input type='hidden' name='coment' value='".$rowb['coment']."' />

                <input type='hidden' name='refprovee' value='".$rowb['refprovee']."' />

                <input type='hidden' name='myimg1'value='".@$rowb['myimg1']."' />
                <input type='hidden' name='myimg2' value='".@$rowb['myimg2']."' />
                <input type='hidden' name='myimg3' value='".@$rowb['myimg3']."' />
                <input type='hidden' name='myimg4' value='".@$rowb['myimg4']."' />
                
                <input type='hidden' name='factcrea' value='".$rowb['factcrea']."' />
                <input type='hidden' name='factmodif' value='".$rowb['factmodif']."' />
                
                <input type='hidden' name='delruta' value='".@$rowb['ruta']."' />");

?>