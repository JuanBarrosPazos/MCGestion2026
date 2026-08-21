<?php

        global $DeleteBlackTit;         $DeleteBlackTit = "INICIO PAPELERA CLIENTES";
        global $PersonAddBlacktit;      $PersonAddBlacktit = "CREAR NUEVO CLIENTE";
        global $PersonsBlackTit;        $PersonsBlackTit = "VER TODOS LOS CLIENTES";
        require '../Inclu/BotoneraVar.php';
        global $closeButton, $KeyForm, $BotonPapelera, $DeleteBlack, $PersonAddBlack, $PersonsBlack;

	if($KeyForm == "feed"){
                $BotonPapelera = "";
	}else{
                $BotonPapelera = $DeleteBlack."<a href='clientesFeed_Ver.php' >&nbsp;&nbsp;&nbsp;</a>".$closeButton;
	}
        	
        global $titNoData;

        print ("<table class='tableForm' style='padding:0.6em;' >
                <tr>
                        <th>
                                ".$titNoData."
                                <font color='#F1BD2D'>NO HAY DATOS</font>
                        </th>
                </tr>
                <tr>
                        <th>
                                ".$PersonAddBlack."
                                        <a href='clientes_Crear.php' >&nbsp;&nbsp;&nbsp;</a>
                                ".$closeButton.$PersonsBlack."
                                        <a href='clientes_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
                                ".$closeButton.$BotonPapelera."
                        </th>
                </tr>
        </table>");

?>