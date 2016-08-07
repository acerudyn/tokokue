<title>Elfia Bakery</title>
<?php 
include_once "../library/inc.connection.php";

//klik tombol login
if(isset($_POST['Login'])){
	// Baca variabel form	
	$txtuser   = $_POST['txtuser'];
	$txtpass   = $_POST['txtpass'];
	
	// Validasi data pada form
	$pesanError = array();
	if (trim($txtuser)=="") {
		$pesanError[] = "Data <b>Username</b> kosong, silahkan isi dengan benar";
	}
	if (trim($txtpass)=="") {
		$pesanError[] = "Data <b>Password</b> kosong, silahkan isi dengan benar";
	}

	// Skrip validasi User dan Password dengan data di Database
	$loginSql = "SELECT * FROM pelanggan WHERE username='$txtuser' AND password=MD5('$txtpass')";
	$loginQry = mysql_query($loginSql, $koneksidb) or die ("Gagal query password".mysql_error());
	$loginQty = mysql_num_rows($loginQry);
	if($loginQty < 1) {
		$pesanError[] = "Data <b>Username dan Password</b> yang Anda masukan belum benar";
	}	
	
	// Tampilkan pesan Error jika ditemukan
	if (count($pesanError)>=1 ) {
		echo "<br>";
		echo "<div align='left'>";
		echo "&nbsp; <b> LOGIN ANDA SALAH </b><br><br>";
		echo "&nbsp; <b> Kesalahan Input : </b><br>";
		$urut_pesan = 0;
		foreach ($pesanError as $indeks=>$pesanTampil) {
			$urut_pesan++;
			echo "<div class='pesanError' align='left'>";
			echo "&nbsp; &nbsp;";
			echo "$urut_pesan . $pesanTampil <br>";
		}
		echo "<br>";
	}
	else {	
		# JIKA TIDAK ADA ERROR FORM DAN LOGIN BERHASIL
		if ($loginQty >=1) {
			// baca data dari Query Login
			$loginData = mysql_fetch_array($loginQry);
			
			// Membuat session
			$_SESSION['SES_PELANGGAN'] 	= $loginData['kd_pelanggan'];
			$_SESSION['SES_USERNAME'] 	= $loginData['username'];
			
			// Baca data Kode Pelanggan yang login
			$KodePelanggan	= $loginData['kd_pelanggan'];
			
			// Kosongkan tabel TMP yang datanya milik Pelanggan
			$hapusSql = "DELETE FROM tmp_keranjang WHERE kd_pelanggan='$KodePelanggan'";
			mysql_query($hapusSql) or die ("Gagal query hapus".mysql_error());
	
			echo "<meta http-equiv='refresh' content='0; url=index.php'>";
			exit;
		}
	}
}
?>