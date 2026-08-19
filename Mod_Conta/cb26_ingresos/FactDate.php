<?php

    global $fil;    $fil = '';

    if(@$_POST['dy'] == ''){ $dy1 = '';
                             $dyt1 = date('Y');
                             $fil = date('Y').'-%';
                             $_SESSION['gyear'] = date('Y');
    }else{  $dy1 = $_POST['dy'];
            $fil = $dy1.'-%';
            $dyt1 = $_POST['dy'];
            $_SESSION['gyear'] = $_POST['dy'];	
             }

    if(@$_POST['dm'] == ''){ $dm1 = '';
                             $fil .= $dm1.'-%';
                             $_SESSION['gtime'] = '';

    }else{  $dm1 = $_POST['dm']."-%";
            $fil .= $dm1;
            $_SESSION['gtime'] = $_POST['dm'];
        }
        
    if(@$_POST['dd'] == ''){ $dd1 = '';
                             $fil .= $dd1;

    }else{  $dd1 = $_POST['dd'];
            if($fil ==''){ 
                $fil .= "%-".$dd1;
            }else{
                $fil .= $dd1;
            }
        }

    // print("* ".$dy1.$dm1.$dd1.". TU PUTA MADRE");

    global $factdate;
    $factdate = @$_POST['dy']."-".@$_POST['dm']."-".@$_POST['dd'];
    //$factdate = $_SESSION['newDy']."-".date('m-d');
    
	/*
    $fil = "%".$dy1.$dm1.$dd1."%";
	if ((@$_POST['dm'] == '')&&(@$_POST['dd'] != '')){$dm1 = '';
													$dd1 = $_POST['dd'];
													global $fil;
													$fil = "%".$dy1."/%".$dm1."%-".$dd1."%";
																					}
    echo "* ".$fil."<br>";
    */
    
?>