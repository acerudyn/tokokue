<title>Elfia Bakery</title>
<?php
include_once "../pinkkabel-shop/inc.session.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Program ini akan Dijalankan ketika Tombol BELI diklik, tombol BELI ada di halaman Produk Barang

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];

if(isset($_GET['Kode'])) {
	// Baca Kode Barang yang dipilih
	$Kode = $_GET['Kode'];
	
// Baca data di dalam Keranjang Belanja	
$cekSql = "SELECT * FROM tmp_keranjang WHERE kd_barang='$Kode' AND kd_pelanggan='$KodePelanggan'";
$cekQry = mysql_query($cekSql, $koneksidb) or die ("Cek data barang".mysql_error());
	if(mysql_num_rows($cekQry) >=1) {
		// Jika barang sudah pernah dipilih, maka update saja jumlah barangnya (+1)
		$mySql = "UPDATE tmp_keranjang SET jumlah=jumlah + 1 WHERE kd_barang='$Kode' AND kd_pelanggan='$KodePelanggan'";
	}
	else {
		// Jika barang belum pernah dipilih, maka tambahkan baris baru ke keranjang
		$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal ambil data barang".mysql_error());
		$myData = mysql_fetch_array($myQry);
		
// Membaca data dari tabel Barang, untuk diinput ke tabel TMP
$hargaModal	= $myData['harga_modal'];
$hargaJual	= $myData['harga_jual'];
$tanggal	= date('Y-m-d');
		
// Simpan data ke TMP (Keranjang Belanja)
$mySql	= "INSERT INTO tmp_keranjang (kd_barang, harga, jumlah, tanggal, kd_pelanggan) 
					VALUES('$Kode', '$hargaJual', '1', '$tanggal', '$KodePelanggan')";
}
	
	// Menjalankan SQL di atas ( Update jumlah barang & Input barang baru ke TMP)
	$myQry = mysql_query($mySql, $koneksidb) or die ("Error".mysql_error());
	if ($myQry) {
		echo "<meta http-equiv='refresh' content='0; url=?open=Keranjang-Belanja'>";
	}
}

?>
