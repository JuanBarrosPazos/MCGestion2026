<?php
    
    global $dyt1;	global $db, $db_name;

    global $DetalleBlack, $closeButton, $DeleteWhite, $DeleteBlack, $RestoreBlack, $CancelBlack, $AddBlack, $MoneypGrey, $MoneypWhite, $MoneyWhite, $MoneyBlack, $FotoBlack, $DatosBlack;    

    if((isset($dyx))&&($dyx != '')){
        $dyt1 = $dyx;
    }elseif((!isset($dyt1))&&($dyt1 == '')){	
        $dyt1 = date('Y');
    }else{ }

    global $selBotones;

    if((isset($_POST['id']))&&(@$_POST['id'] != '')){
        $selBotones = " WHERE `id` = '$_POST[id]' ";
    }elseif((isset($_SESSION['miid']))&&($_SESSION['miid'] != '')){
        $selBotones = " WHERE `id` = '$_SESSION[miid]' ";
    }else{ $selBotones = " ORDER BY `id` DESC "; }

    global $db; 	global $db_name;	global $vnameBot;   global $vname;      global $rutPend;
    global $papelera;

    switch (true) {
        case ($papelera== '1'):
            $vnameBot = "`".$_SESSION['clave']."gastos_".date('Y')."`";
            break;
        case ($rutPend == 'Pendientes'):
            $vnameBot = "`".$_SESSION['clave']."gastos_pendientes`";
            global $PendienteG;		$PendienteG = "style='display:none; visibility: hidden;'";
            break;
        case ((isset($_POST['vname']))&&(strlen(trim($_POST['vname'])) != 0)):
            $vnameBot = $_POST['vname'];
            break;
        case ($vname!=''):
            $vnameBot = $vname;
            break;
        /*
        case ((isset($_SESSION['vname']))&&(strlen(trim(@$_SESSION['vname'])) != 0)):
            $vnameBot = @$_SESSION['vname'];
            break;
        */
        default:
            //echo "** NO SE CUMPLE NADA ** <br>";
            $vnameBot = "`".$_SESSION['clave']."gastos_".date('Y')."`";
            $vname = $vnameBot;
            break;
    } // FIN SWITCH CASE

    //echo "*_* ".$vname."<br>";
    //echo "*-* ".$vnameBot."<br>";
    global $sqlBot;		$sqlBot = "SELECT * FROM `$db_name`.$vnameBot $selBotones LIMIT 1 ";
    //echo "** ".$rutPend;
    //echo "<br>-*- ".$sqlBot."<br>";
    $qBot = mysqli_query($db, $sqlBot);
    $countBot = mysqli_num_rows($qBot);
    $rowb = mysqli_fetch_assoc($qBot);
    //echo "** ".@$rowb['id']."<br>";

    print("<div ".$ConteBotones." ><!-- INICIO DIV CONTENEDOR -->");

    // INICIO SI ES LA PAPELERA DE GASTOS
    if($papelera == 1){

        print("<div ".$Ver2.">
        <form name='ver2' action='PapeleraVer.php' method='POST' style='display:inline-block;'>");

        require 'VerRowbTotal.php';

        print($DetalleBlack.$closeButton."
                <input type='hidden' name='ocultoDetalle' value=1 />
        </form>
        </div>

        <div ".$Borrar2.">
        <form name='modifica' action='PapeleraBorrar.php' method='POST' style='display:inline-block;' >");

        require 'VerRowbTotal.php';

        print($DeleteWhite.$closeButton."
                <input type='hidden' name='oculto2' value=1 />
            </form>
        </div>
        <div ".$Recupera3.">
        <form name='modifica' action='PapeleraRecuperar.php' method='POST' style='display:inline-block;' >");

        require 'VerRowbTotal.php';

        print($RestoreBlack.$closeButton."
                <input type='hidden' name='oculto2' value=1 />
            </form>
            </div>

            <div style='display:inline-block;' >
                ".$CancelBlack."
                    <a href='PapeleraVer.php' >&nbsp;&nbsp;&nbsp;</a>
                ".$closeButton."
            </div>");
            
    }else{ // INICIO SI NO ES LA PAPELERA DE GASTOS
        print("<div ".$Crear.">
                    ".$AddBlack."
                        <a href='".$rutPend."Crear.php' >&nbsp;&nbsp;&nbsp;</a>
                    ".$closeButton."
                </div>

                <div class='BorderIzd BorderDch'  style='display:inline-block;' >
                    ".$MoneypGrey."
                        <a href='Ver.php' >&nbsp;&nbsp;&nbsp;</a>
                    ".$closeButton."
                    ".$DeleteBlack."
                        <a href='PapeleraVer.php' >&nbsp;&nbsp;&nbsp;</a>
                    ".$closeButton."
                    ".$MoneypWhite."
                        <a href='PendientesVer.php' >&nbsp;&nbsp;&nbsp;</a>
                    ".$closeButton."
                </div>
                
                <div ".$Ver2.">
                    <form name='ver2' action='".$rutPend."Ver.php' method='POST' style='display:inline-block;'>");

                    require 'VerRowbTotal.php';

                    print($DetalleBlack.$closeButton."
                            <input type='hidden' name='ocultoDetalle' value=1 />
                    </form>
                </div>

                <div ".$ModImg2.">
                    <form name='ver' action='".$rutPend."Ver.php' method='POST'>");

                    require 'VerRowbTotal.php';

                    print($FotoBlack.$closeButton."
                                <input type='hidden' name='oculto2' value=1 />
                    </form>
                </div>

                <div ".$Modif2.">
                    <form name='modifica' action='".$rutPend."Modificar02.php' method='POST' >");

                    require 'VerRowbTotal.php';

                    print($DatosBlack.$closeButton."
                                <input type='hidden' name='oculto2' value=1 />
                            </form>
                </div>
        
                <div ".$PendienteG.">
                    <form name='modifica' action='Modificar03.php' method='POST'>");

                    require 'VerRowbTotal.php';

                    print($MoneyWhite.$closeButton."
                            <input type='hidden' name='oculto2' value=1 />
                    </form>
                </div>

                <div ".$Borrar2.">
                    <form name='borrar' action='".$rutPend."Borrar.php' method='POST' >");

                    require 'VerRowbTotal.php';
                    
                    print($DeleteWhite.$closeButton."
                            <input type='hidden' name='oculto2' value=1 />
                    </form>
                </div>");

            if($rutPend == 'Pendientes'){

                print("<div ".$Recupera3.">
                <form name='modifica' action='PendientesModificar03.php' method='POST'>");

                require 'VerRowbTotal.php';

                print($MoneyBlack.$closeButton."
                        <input type='hidden' name='oculto2' value=1 />
                        </form>
                    </div>");

            }else{ }

                print(" <div class='BorderIzd BorderDch' style='display:inline-block;' >
                            ".$CancelBlack."
                                <a href='".$rutPend."Ver.php' >&nbsp;&nbsp;&nbsp;</a>
                            ".$closeButton."
                        </div>");

    } // FIN SI NO ES LA PAPELERA DE GASTOS

	print("</div><!-- FIN DIV CONTENEDOR -->");

?>