<?php
include_once "../library/inc.sessadmin.php";

// Periksa data Kode pada URL
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Hapus data sesuai Kode yang dikirim di URL
	$Kode	= $_GET['Kode'];
	$mySql = "DELETE FROM pelanggan WHERE kd_pelanggan='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?open=Pelanggan-Data'>";
	}
}
?>