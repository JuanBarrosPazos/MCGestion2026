<?php

    print("<table class='tableForm'>
                <tr>
                    <th>".$Titulo."</th>
                </tr>
                <form name='form_datos' method='post' action='".$_SERVER['PHP_SELF']."'>
                    <input type='hidden' name='proveegastos' id='proveegastos_hidden' value='".htmlspecialchars(@$defaults['proveegastos'] ?? '')."' />
                    <input type='hidden' name='xl' value='".@$defaults['xl']."' />
                    <input type='hidden' name='id' value='".@$defaults['id']."' />
                    <input type='hidden' name='dy' value='".@$defaults['dy']."' />
                    <input type='hidden' name='dm' value='".@$defaults['dm']."' />
                    <input type='hidden' name='dd' value='".@$defaults['dd']."' />
                    <input type='hidden' name='factnum' value='".strtoupper(@$defaults['factnum'])."' />
                    <input type='hidden' name='factnumini' value='".strtoupper(@$defaults['factnumini'])."' />
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

        global $db, $db_name;
        global $tabla1; 
        $tabla1 = "`".$_SESSION['clave']."proveedores`";

        // Optimización SQL: Traer únicamente los campos requeridos
        $sqlb = "SELECT ref, rsocial FROM $tabla1 ORDER BY `rsocial` ASC";
        $qb = mysqli_query($db, $sqlb);

        $selected_name = "";
        $options_html = "";

        if(!$qb){
            print("* ".mysqli_error($db)."<br/>");
        } else {
            while($rows = mysqli_fetch_assoc($qb)){
                $ref = htmlspecialchars($rows['ref'], ENT_QUOTES);
                $rsocial = htmlspecialchars($rows['rsocial'], ENT_QUOTES);
                
                if($rows['ref'] == @$defaults['proveegastos']){
                    $selected_name = $rsocial;
                }
                $options_html .= "<option data-ref='".$ref."' value='".$rsocial."'></option>";
            }
        }  

        print("
            <input list='list_proveedores' id='input_proveegastos' class='botonlila' placeholder='BUSCAR PROVEEDOR...' value='".$selected_name."' autocomplete='off'>
            <datalist id='list_proveedores'>
                ".$options_html."
            </datalist>

            <script>
                document.getElementById('input_proveegastos').addEventListener('input', function() {
                    var val = this.value;
                    var opts = document.getElementById('list_proveedores').children;
                    var hiddenInput = document.getElementById('proveegastos_hidden');
                    hiddenInput.value = '';
                    for (var i = 0; i < opts.length; i++) {
                        if (opts[i].value === val) {
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