<?php

    global $keyModifDat, $titErrors;
    
    if($keyModifDat == 1){
        $titErrors = "* CONFIRME CIFRAS ACTUALIZADAS:";
    }else{
        $titErrors = "* SOLUCIONE ESTOS ERRORES:";
    }

    if ($errors){
        print("<table class='tableForm' >
                    <th style='text-align:left'>
                    <font color='#F1BD2D'>".$titErrors."</font><br/>
                    </th>
                    <tr>
                    <td style='text-align:left'>");
            
        for($a=0; $c=count($errors), $a<$c; $a++){
            print("<font color='#F1BD2D'>**</font>  ".$errors [$a]."<br/>");
            }
        print("</td>
                </tr>
                </table>
                <div style='clear:both'> ");
    }

?>