<?php

	$factivae1 = $_POST['factivae1'];
	$factivae2 = $_POST['factivae2'];
	global $factivae;
	$factivae = $factivae1.".".$factivae2;
	$factivae = floatval($factivae);
    $factivae = number_format($factivae,2,".","");
    //echo "*** ".$factivae."<br>";
    
	$factrete1 = $_POST['factrete1'];
	$factrete2 = $_POST['factrete2'];
	global $factrete;
	$factrete = $factrete1.".".$factrete2;
	$factrete = floatval($factrete);
    $factrete = number_format($factrete,2,".","");
    //echo "*** ".$factrete."<br>";

	$factpvp1 = $_POST['factpvp1'];
	$factpvp2 = $_POST['factpvp2'];
	global $factpvp;
	$factpvp = $factpvp1.".".$factpvp2;
	$factpvp = floatval($factpvp);
    $factpvp = number_format($factpvp,2,".","");
    //echo "*** ".$factpvp."<br>";

	$factpvptot1 = $_POST['factpvptot1'];
	$factpvptot2 = $_POST['factpvptot2'];
	global $factpvptot;
	$factpvptot = $factpvptot1.".".$factpvptot2;
	$factpvptot = floatval($factpvptot);
    $factpvptot = number_format($factpvptot,2,".","");
    //echo "*** ".$factpvptot."<br>";

	global $fiva;
	$fiva = floatval($_POST['factiva']);
	$fiva = number_format($fiva,2,".","");
    //echo "*** ".$fiva."<br>";

?>