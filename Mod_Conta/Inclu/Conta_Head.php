<?php

    global $index;      global $ruta;       global $Titulo;
    global $OnLoad;     global $PlayHoraJs; global $GrafIndex;
    if($index == 1){
        $ruta = "";
        $PlayHoraJs = "<script src='js/playhora.js' type='text/javascript'></script>";
        $OnLoad = 'onload="hora()"';
        $Titulo = '<div style="margin-top:4px; text-align:center" id="TitTut">
                      <font color="#59746A"><span id="hora">000000</span></font>
                    </div> ';
        $GrafIndex = "<link href='".$ruta."Inclu_Index/GrafIndex.css' rel='stylesheet' type='text/css' />
        <script type='text/javascript'>window['_gaUserPrefs'] = { ioo : function() { return true; } }</script>";
    }else{
        $ruta = "../";
        $PlayHoraJs = "";
        $OnLoad = '';
        /*
        $Titulo = '<div style="margin-top:10px; text-align:center">
                      <span style="font-size:12px; color:#59746A">ESTÁ EN CONTA BASIC</span>
                    </div>';
        */
        $Titulo = '';
        $GrafIndex = "";
    }

    print("<!DOCTYPE html>
        <head>
            <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
            <meta http-equiv='content-type' content='text/html' charset='utf-8' />
            <meta http-equiv='Content-Language' content='es-es'>
            <meta name='Language' content='Spanish'>
            <meta name='description' content='Modulo Administrador' />
            <meta name='keywords' content='Juan Barros Pazos, Programas gratis, Spain, Mallorca' />
            <meta name='robots' content='all, index, follow' />
            <meta name='audience' content='All' />
            <title>Juan Manuel Barros Pazos</title>

            ".$GrafIndex."
            <link href='".$ruta."Css/conta.css' rel='stylesheet' type='text/css' />
            <link href='".$ruta."cb26_Images/logo_new' type='image/ico' rel='shortcut icon' />
            <!--
                <meta name='google-site-verification' content='eZH2zCJFS0R2mpv-pG5sLmYowSRSmDA48lBLzwfFj1I' />
            -->

            <script src='".$ruta."MenuVertical/SpryMenuBar.js' type='text/javascript'></script>
            <link href='".$ruta."MenuVertical/SpryMenuBarVertical.css' rel='stylesheet' type='text/css' />

            <script src='".$ruta."Scripts/swfobject_modified.js' type='text/javascript'></script>

            <script src='".$ruta."js/limtaCaracteres.js' type='text/javascript'></script>
            ".$PlayHoraJs."
        </head>

    <body topmargin='0' ".$OnLoad." >

    <div id='Conte'>

    <div id='head'> 
            <span style='font-size:18px'> JUAN MANUEL BARR&Oacute;S PAZOS</span>
                </br>
               <span style='font-size:12px'> PALMA DE MALLORCA ~ PROGRAMACI&Oacute;N & DISE&Ntilde;O.</span>
    </div>

        <div style='clear:both'></div>
        ".$Titulo."
         <div style='clear:both'></div>
            
    <!--
    ////////////////////////////////
    ////////////////////////////////
        Inicio contenedor de datos.
    ////////////////////////////////
    ////////////////////////////////
    -->

        <div id='Caja2Admin'>");

?>
