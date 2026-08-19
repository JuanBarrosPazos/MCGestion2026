<?php

    global $db;     global $db_name;    global $vname;      global $sqlb;

    //$sqlb =  "SELECT * FROM $vname WHERE `factdate` LIKE '$fil' ORDER BY $orden $limit ";
    global $qb;
    $qb = mysqli_query($db, $sqlb);

    /////////////////////	
    /* PARA SUMAR PVPTOT */

        if(!$qb){print(mysqli_error($db).".</br>");
        }else{
            $qpvptot = mysqli_query($db, $sqlb);
            $rowpvptot = mysqli_num_rows($qpvptot);
            $sumapvptot = 0;
                for($i=0; $i<$rowpvptot; $i++){
                        $ver = mysqli_fetch_array($qpvptot);
                        $sumapvptot = $sumapvptot + $ver['factpvptot'];
                                    }
        }
                
    /* FIN PARA SUMAR PVPTOT */
    /////////////////////////

    /////////////////////	
    /* PARA SUMAR RETENCIONES */

        if(!$qb){print(mysqli_error($db).".</br>");
        }else{
            $qrete = mysqli_query($db, $sqlb);
            $rowrete = mysqli_num_rows($qrete);
            $sumarete = 0;
                for($i=0; $i<$rowrete; $i++){
                        $verret = mysqli_fetch_array($qrete);
                        $sumarete = $sumarete + $verret['factrete'];
                                }
        }

    /* FIN PARA SUMAR RETENCIONES */
    /////////////////////////

    /////////////////////	
    /* PARA SUMAR IVA */

        if(!$qb){print(mysqli_error($db).".</br>");
        }else{
            $qivae = mysqli_query($db, $sqlb);
            $rowivae = mysqli_num_rows($qivae);
            $sumaivae = 0;
                for($i=0; $i<$rowivae; $i++){
                        $ver = mysqli_fetch_array($qivae);
                        $sumaivae = $sumaivae + $ver['factivae'];
                                }
        }

    /* FIN PARA SUMAR IVA */
    /////////////////////////

?>