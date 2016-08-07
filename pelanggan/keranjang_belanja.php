<?php
include_once "../pelanggan/inc.session.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];

//skrip memeriksa data pada tmp keranjang
$cekSql = "SELECT * FROM tmp_keranjang WHERE  kd_pelanggan='$KodePelanggan'";
$cekQry = mysql_query($cekSql, $koneksidb) or die (mysql_error());
$cekQty = mysql_num_rows($cekQry);
if($cekQty < 1){
	echo "<br><br>";
	echo "<center>";
	echo "<b> KERANJANG BELANJA KOSONG </b>";
	echo "<center>";
	
// Jika Keranjang masih Kosong, maka halaman Refresh ke data Barang
echo "<meta http-equiv='refresh' content='2; url=?page=Barang'>";
exit;
}

// Klik tombol simpan
if(isset($_POST['btnsimpan'])){
	$arrData = count($_POST['txtjml']); 
	$qty = 1;
	for ($i=0; $i < $arrData; $i++) {
		# Melewati biar tidak 0 atau minus
		if ($_POST['txtjml'][$i] < 1) {
			$qty = 1;
		}
		else {
			$qty = $_POST['txtjml'][$i];
		}
					
		# Simpan Perubahan
		$KodeBrg	= $_POST['txtkodehide'][$i];
		$tanggal	= date('Y-m-d');
		$jam		= date('G:i:s');
		
		$sql = "UPDATE tmp_keranjang SET jumlah='$qty', tanggal='$tanggal' 
				WHERE kd_barang='$KodeBrg' AND kd_pelanggan='$KodePelanggan'";
		$query = mysql_query($sql, $koneksidb);
	}
	// Refresh
	echo "<meta http-equiv='refresh' content='0; url=?open=Keranjang-Belanja'>";
	exit;	
}

# MENGHAPUS DATA BARANG YANG ADA DI KERANJANG
// Membaca Kode dari URL
if(isset($_GET['aksi']) and trim($_GET['aksi'])=="Hapus"){ 
	// Membaca Id data yang dihapus
	$idhapus	= $_GET['idhapus'];
	
	// Menghapus data keranjang sesuai Kode yang dibaca di URL
	$mySql = "DELETE FROM tmp_keranjang  WHERE id='$idhapus' AND kd_pelanggan='$KodePelanggan'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?open=Keranjang-Belanja'>";
	}
}


?>
<title>Elfia Bakery</title>



<style type="text/css">
.cart {
	color: #300;
	font-weight: bold;
}
</style>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" target="_self">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="6" align="right"><img src="../images/Screenshot_2015-04-09-10-23-55_1428562581949.jpg" alt="cart" width="32" height="26" align="absbottom"><span class="cart">Keranjang Belanja</span></td>
    </tr>
    <tr bgcolor="#FF6666">
      <td width="20%" align="center"><strong>Gambar</strong></td>
      <td width="31%"><strong>Nama Barang</strong></td>
      <td width="16%" align="right"><strong>Harga (Rp</strong>)</td>
      <td width="9%" align="center"><strong>Jumlah</strong></td>
      <td width="19%" align="right"><strong>Total (Rp)</strong></td>
      <td width="5%"><strong>Tools</strong></td>
    </tr>
    <?php
	// Menampilkan data Barang dari tmp keranjang
	$mySql = "SELECT barang.nm_barang, barang.file_gambar, kategori.nm_kategori, tmp_keranjang.*
			  FROM tmp_keranjang
			  LEFT JOIN barang ON tmp_keranjang.kd_barang=barang.kd_barang
			  LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
			  WHERE tmp_keranjang.kd_pelanggan='$KodePelanggan' 
			  ORDER BY tmp_keranjang.id";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal SQL".mysql_error());
	$total = 0; $grandtotal = 0;
	$no	= 0;
	while ($myData = mysql_fetch_array($myQry)) {
	  $no++;
	  
	  // Menghitung sub total harga
	  $total 		= $myData['harga'] * $myData['jumlah'];
	  $grandtotal	= $grandtotal + $total;
	  
	  // Menampilkan gambar
	  if ($myData['file_gambar']=="") {
			$filegambar = "../imgages/noimage.jpg";
	  }
	  else {
			$filegambar	= $myData['file_gambar'];
	  }
	  
	  #Kode Barang
	  $Kode = $myData['kd_barang'];
	?>
    <tr>
      <td rowspan="3" align="center"><img src="../img-barang/<?php echo $filegambar; ?>" width="91" height="85" border="1" ></td>
      <td><a href="?open=Barang-Detail&Kode=<?php echo $Kode; ?>" target="_blank"><strong><?php echo $myData['nm_barang']; ?></strong></a></td>
      <td align="right">Rp.<?php echo format_angka($myData['harga']); ?></td>
      <td align="center"><input name="txtjml[]" type="text" value="<?php echo $myData['jumlah']; ?>" size="4" maxlength="2">
      <input name="txtkodehide[]" type="hidden" value="<?php echo $myData['kd_barang']; ?>"></td>
      <td align="right"><span>Rp. <?php echo format_angka($total); ?></span></td>
      <td align="center"><a href="?open=Keranjang-Belanja&aksi=Hapus&idhapus=<?php echo $myData['id'];?>"><img src="../images/hapus.gif" alt="Apakah ingin menghapus data ini dari keranjang?" width="16" height="16" border="0"></a></td>
    </tr>
    <tr>
      <td>Kategori : <?php echo $myData['nm_kategori']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="38">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="right"><strong>GRAND TOTAL :</strong></td>
      <td align="right" bgcolor="#FFE1FF"><strong><?php echo "Rp. ".format_angka($grandtotal); ?></strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="70" valign="bottom"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" valign="top"><p>
        <input type="submit" name="btnsimpan" id="btnsimpan" value="Ubah Jumlah">
      </p></td>
      <td align="left" valign="bottom">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="right"><a href="?open=Barang" title='Beli Lagi' target="_self"><img src="../images/Screenshot_2015-04-08-21-39-02_1428504115976.jpg" alt="bl" width="54" height="34" align="absmiddle" /></a>  ATAU <a href="?open=Transaksi-Proses" title='Lanjutkan Transaksi'><img src="../images/btn_lanjutkan2.jpg" alt="Lanjutkan Transaksi" width="180" height="33" align="absmiddle"></a></td>
    </tr>
  </table>
</form>