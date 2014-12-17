<?php
	require_once('book_fns.php');
	require_once('db_fns.php');
	session_start();
	$valid = false;

	$file = 'pdfs/'.$_GET['isbn'].'.pdf';
	$fp = fopen($file, "r") ;
	$filename = $_GET['isbn'].'.pdf';
	header("Cache-Control: maxage=1");
	header("Pragma: public");
	header("Content-type: application/pdf");
	header("Content-Disposition: inline; filename=".$filename."");
	header("Content-Description: PHP Generated Data");
	header("Content-Transfer-Encoding: binary");
	header('Content-Length:' . filesize($file));
	ob_clean();
	flush();
	while (!feof($fp)) {
	$buff = fread($fp, 1024);
	print $buff;
	}
	exit;
?>