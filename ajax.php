<?php
define('WHITELIST',true); 
/*
 * Remove the Headerdata
 */
$data = substr($_POST['data'], strpos($_POST['data'], ",")+1);

/*
 * Decode to a binary png file
 */
 
$filename =  "tmpimages/img1.png";
file_put_contents($filename, base64_decode($data));


include 'ocr.php';


?>