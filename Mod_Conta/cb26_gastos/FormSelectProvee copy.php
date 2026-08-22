<?php

    print("<table class='tableForm'>
                <tr>
                    <th>".$Titulo."</th>
                </tr>
                <form name='form_datos' method='post' action='".$_SERVER['PHP_SELF']."'>
                    <input type='hidden' name='proveegastos' id='proveegastos_hidden' value='".htmlspecialchars($defaults['proveegastos'] ?? '')."' />
                    <input type='hidden' name='xl' value='".@$defaults['xl']."' />
                    <input type='hidden' name='id' value='".@$defaults['id']."' />
                    <input type='hidden' name='dy' value='".@$defaults['dy']."' />
                    <input type='hidden' name='dm' value='".@$defaults['dm']."' />
                    <input type='hidden' name='dd' value='".@$defaults['dd']."' />
                    <input type='hidden' name='factnum' value='".strtoupper(@$defaults['factnum'] ?? '')."' />
                    <input type='hidden' name='factnumini' value='".strtoupper(@$defaults['factnumini'] ?? '')."' />
                    <input type='hidden' name='refprovee' value='".$defaults['refprovee']."' />
                    <input type='hidden' name='factnom' value='".$defaults['factnom']."' />
                    <input type='hidden' name='factnif' value='".$defaults['factnif']."' />
                    <input type='hidden' name='factiva' value='".@$defaults['factiva']."' />
                    <input type='hidden' name='factivae1' value='".@$defaults['factivae1']."' />
                    <input type='hidden' name='factivae2' value='".@$defaults['factivae2']."' />
                    <input type='hidden' name='factret' value='".@$defaults['factret']."' />
                    <input type='hidden' name='factrete1' value='".@$defaults['factrete1']."' />
                    <input type='hidden' name='factrete2' value='".@$defaults['factrete2']."' />
                    <input type='hidden' name='factpvp1' value='".@$defaults['factpvp1']."' />
                    <input type='hidden' name='factpvp2' value='".@$defaults['factpvp2']."' />
                    <input type='hidden' name='factpvptot1' value='".@$defaults['factpvptot1']."' />
                    <input type='hidden' name='factpvptot2' value='".@$defaults['factpvptot2']."' />
                    <input type='hidden' name='coment' value='".@$defaults['coment']."' />
                    <input type='hidden' name='factcrea' value='".@$defaults['factcrea']."' />
                    <input type='hidden' name='factmodif' value='".@$defaults['factmodif']."' />
                <tr>
                    <td style='text-align:center;'>
                        <div style='display:inline-block; vertical-align: middle;'>
                            ".$PersonsWhite."".$closeButton."
                            <input type='hidden' name='oculto1' value=1 />
                        </div>
                        <div style='display:inline-block; vertical-align: middle;'>");

        global $db;
        global $tabla1; 
        $tabla1 = "`".$_SESSION['clave']."proveedores`";

        $sqlb = "SELECT ref, rsocial FROM $tabla1 ORDER BY `rsocial` ASC";
        $qb = mysqli_query($db, $sqlb);

        $selected_name = "";
        $options_html = "";

        // Función en PHP para normalizar el texto removiendo acentos en las opciones
        function quitarAcentos($cadena) {
            $unwanted_array = array(
                'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
            );
            return strtr($cadena, $unwanted_array);
        }

        if(!$qb){
            print("* ".mysqli_error($db)."<br/>");
        } else {
            while($rows = mysqli_fetch_assoc($qb)){
                $ref = htmlspecialchars($rows['ref'], ENT_QUOTES);
                $rsocial = htmlspecialchars($rows['rsocial'], ENT_QUOTES);
                $rsocial_sin_acento = quitarAcentos($rsocial);
                
                if($rows['ref'] == @$defaults['proveegastos']){
                    $selected_name = $rsocial;
                }
                
                // Si el nombre contiene tildes, mostramos ambas versiones para asegurar la búsqueda sin acentos
                if ($rsocial !== $rsocial_sin_acento) {
                    $options_html .= "<option data-ref='".$ref."' value='".$rsocial."' label='".$rsocial_sin_acento."'></option>";
                    $options_html .= "<option data-ref='".$ref."' value='".$rsocial_sin_acento."' label='".$rsocial."'></option>";
                } else {
                    $options_html .= "<option data-ref='".$ref."' value='".$rsocial."'></option>";
                }
            }
        }  

        print("
            <input list='list_proveedores' id='input_proveegastos' class='botonlila' placeholder='BUSCAR PROVEEDOR...' value='".$selected_name."' autocomplete='off'>
            <datalist id='list_proveedores'>
                ".$options_html."
            </datalist>

            <script>
                // Normaliza acentos mediante Unicode NFD para comparar al escribir
                function removerAcentos(texto) {
                    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                }

                document.getElementById('input_proveegastos').addEventListener('input', function() {
                    var valBusqueda = removerAcentos(this.value.toLowerCase());
                    var opts = document.getElementById('list_proveedores').children;
                    var hiddenInput = document.getElementById('proveegastos_hidden');
                    
                    hiddenInput.value = '';

                    for (var i = 0; i < opts.length; i++) {
                        var valOption = removerAcentos(opts[i].value.toLowerCase());
                        var labelOption = opts[i].getAttribute('label') ? removerAcentos(opts[i].getAttribute('label').toLowerCase()) : '';

                        if (valOption === valBusqueda || labelOption === valBusqueda) {
                            hiddenInput.value = opts[i].getAttribute('data-ref');
                            break;
                        }
                    }
                });
            </script>
                        </div>
                    </td>
                </tr>
                </form>");

?>