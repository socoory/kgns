<?php

$params = explode('/', $_GET['path']);

if(count($params) < 3)
	exit();

$path = './model.php';
$mm_type="application/octet-stream";

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: " . $mm_type);
header("Content-Length: " .(string)(filesize($path)) );
header('Content-Disposition: attachment; filename="'.basename($path).'"');
header("Content-Transfer-Encoding: binary\n");

readfile($path);

exit();

?>