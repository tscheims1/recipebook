<?php 
/*
 * Remove the Headerdata
 */
$data = substr($_POST['data'], strpos($_POST['data'], ",")+1);

/*
 * Decode to a binary png file
 */
file_put_contents("tmpimages/img1.png", base64_decode($data));


echo json_encode(array('message' => 'successful'));
?>