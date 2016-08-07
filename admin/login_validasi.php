<?php
//membuka koneksi database
include_once "../library/inc.connection.php";

//klik tombol login
if(isset($_POST['btnlogin'])){
	
 // Baca variabel form
	$txtuser = $_POST['txtuser'];
	$txtuser = str_replace("'","&pink;",$txtuser);	
	$txtpass = $_POST['txtpass'];
	$txtpass = str_replace("'","&pink;",$txtpass);
	
 // Validasi form login
	$pesanError = array();
	if ( trim($txtuser)=="") {
		$pesanError[] = "<b> Username </b>  tidak boleh kosong !";		
	}
	if (trim($txtpass)=="") {
		$pesanError[] = "<b> Password </b> tidak boleh kosong !";		
	}
	else {
	
// Validasi User dan Password 
	$sqlCek = "SELECT * FROM admin WHERE username='".($txtuser)."' AND password ='".md5($txtpass)."'";
	$qryCek = mysql_query($sqlCek, $koneksidb)  or die ("Query Periksa Password Salah : ".mysql_error());
	if(mysql_num_rows($qryCek) <1){
		$pesanError[] = "Maaf, <b> Username dan Password Tidak Cocok</b>....silahkan ulangi kembali";
	}
	}
	
 // Kesalahan
 // Jika ada error message ditemukan
	if (count($pesanError)>=1 ){
		echo "<div align='left'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
		
// Penggil file login
include "login.php";

	} 
	else {
		$loginSql = "SELECT * FROM admin WHERE username='".$txtuser."' AND password ='".md5($txtpass)."'";
		$loginQry = mysql_query($loginSql, $koneksidb)  or die ("Query Salah : ".mysql_error());
		if (mysql_num_rows($loginQry) >=1) {
			
// Jika berhasil login
$_SESSION['SES_ADMIN'] = $txtuser;
	echo "<meta http-equiv='refresh' content='0; url=?open=Halaman-Utama'>";	
	}
else {
			
// Jika gagal login
		echo "<meta http-equiv='refresh' content='0; url=?open=Login'>";	
	}
  }
}
else {
	echo "<meta http-equiv='refresh' content='0; url=?open=Login'>";
	}
?>