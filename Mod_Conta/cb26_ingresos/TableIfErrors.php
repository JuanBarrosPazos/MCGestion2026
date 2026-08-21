<?php

    if ($errors){
        print("<table class='tableForm' >
                    <th style='text-align:left'>
                    <font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font><br/>
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