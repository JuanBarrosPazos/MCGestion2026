<?php

    global $AddBlackTit;		$AddBlackTit = "CREAR NUEVO TIPO IMPUESTO";
    require '../Inclu/BotoneraVar.php';
    global $closeButton;

    global $titNoData;

    print ("<table align='center'>
                <tr>
                    <th>
                    ".$titNoData."
                    <font color='#FF0000'>NO HAY DATOS</font>
                    
                    </th>
                </tr>
                <tr>
                    <th class='BorderInfDch'>
								".$AddBlack."
									<a href='Impuestos_Crear.php' >&nbsp;&nbsp;&nbsp;&nbsp</a>
								".$closeButton."
                    </th>
                </tr>
            </table>");

?>