<?php
include_once "../library/inc.sessadmin.php";

// Periksa data Kode pada URL
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Membaca Kode dari URL
	$Kode	= $_GET['Kode'];
	
// Menghapus data Konfirmasi
$mySql 	= "DELETE FROM konfirmasi WHERE id='$Kode'";
$myQry 	= mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
if($myQry){
	echo "<meta http-equiv='refresh' content='0; url=?open=Konfirmasi-Bayar'>";
  }
}
?>