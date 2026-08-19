<?php

    $dir = "../cb26_Docs/log";

    $logdocu = $_SESSION['ref'];
    $logdate = date('Y_m_d');
    $logtext = $text."\n";
    $filename = $dir."/".$logdate."_".$logdocu.".log";
    $log = fopen($filename, 'ab+');
    fwrite($log, $logtext);
    fclose($log);

?>