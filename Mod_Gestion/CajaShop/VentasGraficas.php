<?php

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	global $StyleTimeLine; 
	if($LiquidoCaja < 0){ $StyleTimeLine = "style='height: 12.8em !important;'"; }else{ $StyleTimeLine = ""; }

    // GRAFICA CONSULTA TOTALES
	
	print ("<div style='clear:both'></div>
			<div class='divTablaIndex' >
				<table class='tablac PrintNone'>
				<tr>
					<th class='resultadosi'>GRAFICA TOTALES</th>
				</tr>
				<tr>
					<td>
						<ul class='timeline' ".$StyleTimeLine.">");
        if($TotalInvita>0){
            $PorcentNoCobrado = ($TotalInvita*100)/$sumapvptot;
        }else{ $PorcentNoCobrado = 0.00;}
		print("<li>
					<a href='#' title='TOTAL NO COBRADO ".$TotalInvita." €'>
				<span class='label'>".$TotalInvita."</span>
				<span class='count bgcolorNaranja' style='height: ".$PorcentNoCobrado."%;'>(".$PorcentNoCobrado.")</span>
				<span class='labelTit'>GRATIS</span>
					</a>
			</li>");
        if($TotalCobrado>0){
    		$PorcentCobrado = ($TotalCobrado*100)/$sumapvptot;
        }else{ $PorcentCobrado = 0.00;}
		print("<li>
					<a href='#' title='TOTAL COBROS ".$TotalCobrado." €'>
				<span class='label'>".$TotalCobrado."</span>
				<span class='count bgcolorVerde' style='height: ".$PorcentCobrado."%'>(".$PorcentCobrado.")</span>
				<span class='labelTit'>COBROS</span>
					</a>
			</li>");
        global $StyleLabel;  $StyleLabel = "";
		global $StyleCount;		
		if($LiquidoCaja > 0){
				$PorcentLiquidoCaja = ($LiquidoCaja*100)/$sumapvptot;
				$StyleCount = "style='height: ".$PorcentLiquidoCaja."%;'";
		}elseif($LiquidoCaja < 0){
				$PorcentLiquidoCaja = ($LiquidoCaja*100)/(abs($sumapvptot));
                $StyleLabel = "style='background-color: #F8CD41; color:#F1BD2D; font-weight: bold; border-radius: 0.4em 0.4em 0.0em 0.0em !important;'";
				$StyleCount = "style='height: 1.2em !important; bottom: -3.2em !important; background-color: #F1BD2D !important; left: 0.03em; border-radius: 0.0em 0.0em 0.4em 0.4em !important;'";
		}else{ 	$PorcentLiquidoCaja = 0.00;
				$StyleCount = "style='height: ".$PorcentLiquidoCaja."%;'";
		}
		// 	$PorcentLiquidoCaja = ($LiquidoCaja*100)/$sumapvptot;
		print("<li>
					<a href='#' title='LIQUIDO CAJA ".$LiquidoCaja." €' >
				<span class='label' ".$StyleLabel.">".$LiquidoCaja."</span>
				<span class='count bgcolorNaranja' ".$StyleCount." >(".$PorcentLiquidoCaja.")</span>
				<span class='labelTit'>LIQUIDO</span>
					</a>
			</li>");
        if($sumapvptot > 0){
			$PorcentSumaTotal = ((abs($sumapvptot))*100)/(abs($sumapvptot)); 
		}else{ $PorcentSumaTotal = 0.00; }
        //	$PorcentSumaTotal = ($sumapvptot*100)/$sumapvptot;
        print("<li>
					<a href='#' title='SUMA TOTAL ".(abs($sumapvptot))." €'>
				<span class='label'>".(abs($sumapvptot))."</span>
				<span class='count bgcolorAzul' style='height: ".$PorcentSumaTotal."%'>(".$PorcentSumaTotal.")</span>
				<span class='labelTit'>TOTAL</span>
					</a>
			</li>");
        if($sumaivasoportado>0){
    		$PorcentIvaSop = ($sumaivasoportado*100)/$sumapvptot;
        }else{ $PorcentIvaSop = 0.00; }

		if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){
		print("<li>
					<a href='#' title='IVA SOPORTADO ".$sumaivasoportado." €'>
				<span class='label'>".$sumaivasoportado."</span>
				<span class='count bgcolorNaranja' style='height: ".$PorcentIvaSop."%'>(".$PorcentIvaSop.")</span>
				<span class='labelTit'>IVA SOPORT</span>
					</a>
			</li>");
		}else{ }
		
        if($sumaivarepercutido>0){
    		$PorcentIvaRep = ($sumaivarepercutido*100)/$sumapvptot;
        }else{ $PorcentIvaRep = 0.00; }
		print("<li>
					<a href='#' title='IVA REPERCUTIDO ".$sumaivarepercutido." €'>
				<span class='label'>".$sumaivarepercutido."</span>
				<span class='count bgcolorVerde' style='height: ".$PorcentIvaRep."%'>(".$PorcentIvaRep.")</span>
				<span class='labelTit'>IVA REPER</span>
					</a>
			</li>");
        if($sumaivae>0){
    		$PorcentIvaTot = ($sumaivae*100)/$sumapvptot;
        }else{ $PorcentIvaTot = 0.00;}
		print("<li>
					<a href='#' title='IVA TOTAL ".$sumaivae." €'>
				<span class='label'>".$sumaivae."</span>
				<span class='count bgcolorAzul' style='height: ".$PorcentIvaTot."%'>(".$PorcentIvaTot.")</span>
				<span class='labelTit'>IVA TOTAL</span>
					</a>
			</li>
			
    	</ul>
            </td>
        </tr>
    </table>
	</div>");
        
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel']=='admin')){

    // GRAFICA CONSULTA NO COBRADO
	print ("<div style='clear:both'></div>
            <div class='divTablaIndex' >
			    <table class='tablac PrintNone' >
				<tr>
					<th class='resultadosi'>GRAFICA GRATIS</th>
				</tr>
				<tr>
					<td>
						<ul class='timeline' ".$StyleTimeLine.">");
        if($sumasinpagar>0){
            $PorcentSinPagar = ($sumasinpagar*100)/$sumapvptot;
        }else{ $PorcentSinPagar = 0.00;}
		print("<li>
					<a href='#' title='SIN PAGAR ".$sumasinpagar." €'>
				<span class='label'>".$sumasinpagar."</span>
				<span class='count bgcolorLila' style='height: ".$PorcentSinPagar."%'>(".$PorcentSinPagar.")</span>
				<span class='labelTit'>SIN PAGAR</span>
					</a>
			</li>");
        if($sumapersonal>0){
            $PorcentPersonal = ($sumapersonal*100)/$sumapvptot;
        }else{ $PorcentPersonal = 0.00;}
		print("<li>
					<a href='#' title='PERSONAL ".$sumapersonal." €'>
				<span class='label'>".$sumapersonal."</span>
				<span class='count bgcolorVerde' style='height: ".$PorcentPersonal."%'>(".$PorcentPersonal.")</span>
				<span class='labelTit'>PERSONAL</span>
					</a>
			</li>");
        if($sumainvita>0){
            $PorcentInvita = ($sumainvita*100)/$sumapvptot;
        }else{ $PorcentInvita = 0.00;}
		print("<li>
					<a href='#' title='INVITACIONES ".$sumainvita." €'>
				<span class='label'>".$sumainvita."</span>
				<span class='count bgcolorAzul' style='height: ".$PorcentInvita."%'>(".$PorcentInvita.")</span>
				<span class='labelTit'>INVITACION</span>
					</a>
			</li>");
        if($TotalInvita>0){
            $PorcentNoCobrado = ($TotalInvita*100)/$sumapvptot;
        }else{ $PorcentNoCobrado = 0.00;}
		print("<li>
					<a href='#' title='TOTAL NO COBRADO ".$TotalInvita." €'>
				<span class='label'>".$TotalInvita."</span>
				<span class='count bgcolorNaranja' style='height: ".$PorcentNoCobrado."%'>(".$PorcentNoCobrado.")</span>
				<span class='labelTit'>TOTAL</span>
					</a>
				</li>
            </ul>
                </td>
            </tr>
        </table>");

	}else{	print ("<div style='clear:both'></div>
					<div class='divTablaIndex' >");
	}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

    //  GRAFICA CONSULTA COBRADO
	print ("<table class='tablac PrintNone'>
				<tr>
					<th class='resultadosi'>GRAFICA COBRADO</th>
				</tr>
				<tr>
					<td>
						<ul class='timeline' ".$StyleTimeLine.">");
        if($sumabizum>0){
            $PorcentBizum = ($sumabizum*100)/$sumapvptot;
        }else{ $PorcentBizum = 0.00;}
		print("<li>
					<a href='#' title='BIZUM ".$sumabizum." €'>
				<span class='label'>".$sumabizum."</span>
				<span class='count bgcolorLila' style='height: ".$PorcentBizum."%'>(".$PorcentBizum.")</span>
				<span class='labelTit'>BIZUM</span>
					</a>
			</li>");
        if($sumatarjeta>0){
            $PorcentTarjeta = ($sumatarjeta*100)/$sumapvptot;
        }else{ $PorcentTarjeta = 0.00;}
		print("<li>
					<a href='#' title='TARJETA ".$sumatarjeta." €'>
				<span class='label'>".$sumatarjeta."</span>
				<span class='count bgcolorNaranja' style='height: ".$PorcentTarjeta."%'>(".$PorcentTarjeta.")</span>
				<span class='labelTit'>TARJETA</span>
					</a>
			</li>");
        if($sumaefectivo>0){
            $PorcentEfectivo = ($sumaefectivo*100)/$sumapvptot;
        }else{ $PorcentEfectivo = 0.00;}
		print("<li>
					<a href='#' title='EFECTIVO ".$sumaefectivo." €'>
				<span class='label'>".$sumaefectivo."</span>
				<span class='count bgcolorAzul' style='height: ".$PorcentEfectivo."%'>(".$PorcentEfectivo.")</span>
				<span class='labelTit'>EFECTIVO</span>
					</a>
			</li>");
        
        if($TotalCobrado>0){
            $PorcentTotalCobrado = ($TotalCobrado*100)/$sumapvptot;
        }else{ $PorcentTotalCobrado = 0.00;}
		print("<li>
					<a href='#' title='TOTAL COBROS ".$TotalCobrado." €'>
			<span class='label'>".$TotalCobrado."</span>
			<span class='count bgcolorVerde' style='height: ".$PorcentTotalCobrado."%'>
				(".$PorcentTotalCobrado.")
			</span>
			<span class='labelTit'>TOTAL</span>
			</a>
			</li>
        </ul>
            </td>
        </tr>
    </table>
    	</div>");

?>