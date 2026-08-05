<?php

		print("	<div style='margin: auto; width: fit-content;'>
					<table class='tableForm'>
						<tr>
							<th style='text-align:left'>
								<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
							</th>
						</tr>
						<tr>
							<td style='text-align:left'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
				print("<font color='#FF0000'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</td>
				</tr>
				</table>
				</div>
				<div style='clear:both'></div>");


?>