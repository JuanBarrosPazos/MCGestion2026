<?php

    global $InicioBlackTit;		$InicioBlackTit = "INICIO STATUS EJERCICIOS";
    global $AddBlackTit;		$AddBlackTit = "CREAR NUEVO EJERCICIO";
    global $DeleteGreyTit;		$DeleteGreyTit = "PAPELERA STATUS EJERCICIO";
    require '../Inclu/BotoneraVar.php';
    global $closeButton;

    global $titNoData;

    print ("<table class='tableForm' >
                <tr>
                    <th>
                        ".$titNoData."
                        <font color='#FF0000'>NO HAY DATOS</font>
                    </th>
                </tr>
                <tr>
                    <th>
                        ".$AddBlack."
                            <a href='status_Crear.php' >&nbsp;&nbsp;&nbsp;</a>
                        ".$closeButton.$InicioBlack."
                            <a href='status_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
                        ".$closeButton.$DeleteGrey."
                            <a href='status_feedback_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
                        ".$closeButton."
                    </th>
                </tr>
            </table>");

?>