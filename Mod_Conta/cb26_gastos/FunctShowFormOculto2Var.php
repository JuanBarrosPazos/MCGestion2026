<?php

    global $datex;      $datex = $_POST['factdate'];
    global $dyx;        $dyx = substr($_POST['factdate'],0,4);
    global $dmx;        $dmx = substr($_POST['factdate'],5,2);
    global $ddx;        $ddx = substr($_POST['factdate'],-2,2);
                        $dyt1 = $dyx;

                        $_SESSION['yold'] = $dyx;
                        $_SESSION['mold'] = $dmx;
                        $_SESSION['dold'] = $ddx;
            
                        $_SESSION['myimg1'] = $_POST['myimg1'];
                        $_SESSION['myimg2'] = $_POST['myimg2'];
                        $_SESSION['myimg3'] = $_POST['myimg3'];
                        $_SESSION['myimg4'] = $_POST['myimg4'];
        
                        $ivae = strlen(trim($_POST['factivae']));
                        $ivae = $ivae - 3;
                        $ivaex = $_POST['factivae'];
                        $ivae1 = substr($_POST['factivae'],0,$ivae);
                        $ivae2 = substr($_POST['factivae'],-2,2);
                        $_SESSION['ivae1'] = $ivae1;
                        $_SESSION['ivae2'] = $ivae2;

                        $rete = strlen(trim($_POST['factrete']));
                        $rete = $rete - 3;
                        $retex = $_POST['factrete'];
                        $rete1 = substr($_POST['factrete'],0,$rete);
                        $rete2 = substr($_POST['factrete'],-2,2);
                        $_SESSION['rete1'] = $rete1;
                        $_SESSION['rete2'] = $rete2;
                        
                        $factpvp = strlen(trim($_POST['factpvp']));
                        $factpvp = $factpvp - 3;
                        $factpvpx = $_POST['factpvp'];
                        $factpvp1 = substr($_POST['factpvp'],0,$factpvp);
                        $factpvp2 = substr($_POST['factpvp'],-2,2);
                        $_SESSION['factpvp1'] = $factpvp1;
                        $_SESSION['factpvp2'] = $factpvp2;
            
                        $factpvptot = strlen(trim($_POST['factpvptot']));
                        $factpvptot = $factpvptot - 3;
                        $factpvptotx = $_POST['factpvptot'];
                        $factpvptot1 = substr($_POST['factpvptot'],0,$factpvptot);
                        $factpvptot2 = substr($_POST['factpvptot'],-2,2);
                        $_SESSION['factpvptot1'] = $factpvptot1;
                        $_SESSION['factpvptot2'] = $factpvptot2;
            
                        $dnie = strlen(trim($_POST['factnif']));
                        $dnie = $dnie - 1;
                        $dnix = $_POST['factnif'];
                        $dninx = substr($_POST['factnif'],0,$dnie);
                        $dnilx = substr($_POST['factnif'],-1,1);
                        $dninx = trim($dninx);
                        $dnilx = trim($dnilx);
                        $fil1 = "%".$dninx."%";
                        $fil2 = "%".$dnilx."%";
            
                        $_SESSION['fnold'] = $_POST['factnum'];

                        $_POST['proveegastos'] = $_POST['refprovee'];

?>