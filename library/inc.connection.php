<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Untitled Document</title>
</head>
<body>
<?php
//konek ke web server lokal
$myHost ="localhost";
$myUser ="root";
$myPass ="";
$myDbs ="elfiabakery";
//konek ke web server lokal
$koneksidb = mysql_connect($myHost, $myUser, $myPass);
if (! $koneksidb) {
	echo "failed Connection !";
}
//memilih database pada mysql server
mysql_select_db($myDbs) or die ("database not Found !");
?>
</body>
</html>