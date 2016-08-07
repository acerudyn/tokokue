
<?php
if(! empty($_SESSION['SES_ADMIN'])) {
	echo "<p><center><marquee><h1>:: Selamat Datang.. Anda login sebagai Administrator ::</h1></marquee></center></p>";
	exit;
}
else {
	echo "<center><h1 style='margin:50px 50px 50px 50px; padding:0px;'> - SELAMAT DATANG - </h1></p></center>";
	echo "<center><b><h3> Silahkan <a href='?open=Login' alt='Login'>login</a> terlebih dahulu untuk dapat mengakses form Administrator </h3></center>";	
}

?>
