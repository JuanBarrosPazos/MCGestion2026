<?php

        global $DeleteBlackTit;         $DeleteBlackTit = "INICIO PAPELERA PROVEEDORES";
        global $PersonAddBlacktit;      $PersonAddBlacktit = "CREAR NUEVO PROVEEDOR";
        global $PersonsBlackTit;        $PersonsBlackTit = "VER TODOS LOS PROVEEDORES";
        require '../Inclu/BotoneraVar.php';
        global $closeButton;

	global $KeyForm;        global $BotonPapelera;

	if($KeyForm == "feed"){
                $BotonPapelera = "";
	}else{
                $BotonPapelera = $DeleteBlack."<a href='proveedoresFeed_Ver.php' >&nbsp;&nbsp;&nbsp;</a>".$closeButton;
	}	

        global $titNoData;

        print ("<table class='tableForm' style='padding:0.6em;' >
                <tr>
                        <th>
                                ".$titNoData."
                                <font color='#FF0000'>NO HAY DATOS</font>
                        </th>
                </tr>
                <tr>
                        <th>
                                ".$PersonAddBlack."
                                        <a href='proveedores_Crear.php' >&nbsp;&nbsp;&nbsp;</a>
                                ".$closeButton.$PersonsBlack."
                        <a href='proveedores_Ver.php' >&nbsp;&nbsp;&nbsp;</a>
                                ".$closeButton.$BotonPapelera."
                        </th>
                </tr>
        </table>");

?>