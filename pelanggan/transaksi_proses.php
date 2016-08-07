<?php 
include_once "../pelanggan/inc.session.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];


//memeriksa data dalam tmp keranjang
$cekSql = "SELECT * FROM tmp_keranjang WHERE  kd_pelanggan='$KodePelanggan'";
$cekQry = mysql_query($cekSql, $koneksidb) or die (mysql_error());
$cekQty = mysql_num_rows($cekQry);
if($cekQty < 1){
	echo "<br><br>";
	echo "<center>";
	echo "<b> BELUM ADA TRANSAKSI </b>";
	echo "<center>";
	
// Jika Keranjang masih Kosong, maka halaman Refresh ke data Barang
echo "<meta http-equiv='refresh' content='2; url=?page=Barang'>";
exit;
}

# MEMBACA DATA DARI FORM, untuk ditampilkan kembali pada form
$dataNama	    = isset($_POST['txtnama']) ? $_POST['txtnama'] : '';
$dataAlamat  	= isset($_POST['txtalamat']) ? $_POST['txtalamat'] : '';
$dataProvinsi	= isset($_POST['cmbprovinsi']) ? $_POST['cmbprovinsi'] : '';
$dataKota	    = isset($_POST['txtkota']) ? $_POST['txtkota'] : '';
$dataPos	    = isset($_POST['txtkpos']) ? $_POST['txtkpos'] : '';
$dataNoTelp     = isset($_POST['txttelp']) ? $_POST['txttelp'] : '';

//tombol klik
if(isset($_POST['btnsimpan'])){


	# Baca Variabel Form
	$txtnama	= $_POST['txtnama'];
	$txtnama	= str_replace("'","&pink;",$txtnama);
		
	$txtalamat	= $_POST['txtalamat'];
	$txtalamat	= str_replace("'","&pink;",$txtalamat);
	
	$cmbprovinsi= $_POST['cmbprovinsi'];

	$txtkota	= $_POST['txtkota'];
	$txtkota	= str_replace("'","&pink;",$txtkota);

	$txtkpos		= $_POST['txtkpos'];
	$txtkpos		= str_replace("'","&pink;",$txtkpos);
	
	$txttelp	= $_POST['txttelp'];
	$txttelp	= str_replace("'","&pink;",$txttelp);
	
// Validasi, jika data kosong kirimkan pemesanan error
	$pesanError = array();
	if (trim($txtnama) =="") {
		$pesanError[] = "Data <b>Nama Penerima</b> masih kosong";
	}
	if (trim($txtalamat) =="") {
		$pesanError[] = "Data <b>Alamat Tujuan</b> masih kosong";
	}
	if (trim($cmbprovinsi) =="KOSONG") {
		$pesanError[] =  "Data <b>Provinsi Tujuan</b> belum dipilih";
	}
	if (trim($txtkota) =="") {
		$pesanError[] = "Data <b>Kota Tujuan</b> masih kosong";
	}
	if (trim($txtkpos) =="") {
		$pesanError[] = "Data <b>Kode Pos</b> masih kosong";
	}
	if (trim($txttelp) =="") {
		$pesanError[] = "Data <b>Telepon/Hp</b> masih kosong";
	}

	//Jika ada error
	if (count($pesanError)>=1 ){
		echo "<div class='pesanError' align='left'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo " <br>"; 
	}
	else {
		
//Simpan data ke database jika tidak ada eror
$KodePemesanan	= buatKode("pemesanan", "PM");
$tanggal		= date('Y-m-d');
		
//simpan alamat kee database
$mySql	= "INSERT INTO pemesanan (no_pemesanan, tgl_pemesanan, kd_pelanggan, nama_penerima, 
			alamat, kd_provinsi, kota, kodepos, no_telp)
			VALUES('$KodePemesanan', '$tanggal', '$KodePelanggan', '$txtnama', 
			'$txtalamat', '$cmbprovinsi', '$txtkota', '$txtkpos', '$txttelp')";
			
$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query 1".mysql_error());
	if($myQry){
		// Membaca data dari tmp keranjang
		$bacaSql	= "SELECT * FROM tmp_keranjang WHERE kd_pelanggan='$KodePelanggan'";
		$bacaQry	= mysql_query($bacaSql, $koneksidb) or die ("Gagal query 2".mysql_error());
		while ($bacaData = mysql_fetch_array($bacaQry)) {
			
			// Simpan data dari Keranjang belanja ke Pemesanan_Item
			$Kode 	= $bacaData['kd_barang'];
			$Harga	= $bacaData['harga'];
			$Jumlah	= $bacaData['jumlah'];
				
$simpanSql="INSERT INTO pemesanan_item(no_pemesanan, kd_barang, harga, jumlah) 
	        VALUES('$KodePemesanan', '$Kode', '$Harga', '$Jumlah')";
mysql_query($simpanSql,$koneksidb) or die ("Gagal query simpan".mysql_error());
	}
			
// Kosongkan data Keranjang milik Pelanggan 
$hapusSql	= "DELETE FROM tmp_keranjang WHERE kd_pelanggan='$KodePelanggan'";
mysql_query($hapusSql,$koneksidb) or die ("Gagal query hapus keranjang".mysql_error());
			
	// Refresh
	echo "<meta http-equiv='refresh' content='0; url=?open=Transaksi-Sukses'>";
   }
 exit;
}	
} // End if($_POST) 


?>
<title>Elfia Bakery</title>



<table width="82%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="5" bgcolor="#FF6666">KONFIRMASI DAFTAR BELANJA ANDA</td>
  </tr>
  <tr bgcolor="#FFCCCC">
    <td width="5%">No</td>
    <td width="34%">Nama Barang</td>
    <td width="24%">Harga(Rp)</td>
    <td width="10%">Jumlah</td>
    <td width="27%">Total (Rp)</td>
  </tr>
   <?php
  	// buat variabel data
	$subtotal	 = 0;
	$totalharga	 = 0;
	$totalbarang = 0;
	
  // Menampilkan daftar barang yang sudah dipilih (ada d Keranjang)
	$mySql = "SELECT barang.nm_barang, tmp_keranjang.*
			 FROM tmp_keranjang
			 LEFT JOIN barang ON tmp_keranjang.kd_barang=barang.kd_barang
			 WHERE barang.kd_barang=tmp_keranjang.kd_barang AND tmp_keranjang.kd_pelanggan='$KodePelanggan' 
			 ORDER BY tmp_keranjang.id";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal SQL".mysql_error());
	$nomor	= 0;
	while ($myData = mysql_fetch_array($myQry)) {
	  $nomor++;
	  // Mendapatkan total harga (harga * jumlah)
	  $subtotal= $myData['harga'] * $myData['jumlah']; 
	  
	  // Mendapatkan total harga  dari seluruh  barang
	  $totalharga = $totalharga + $subtotal; 
	  
	  // Mendapatkan total barang
	  $totalbarang = $totalbarang + $myData['jumlah']; 
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><a href="?open=Barang-Detail&amp;Kode=<?php echo $myData['kd_barang']; ?>" target="_blank"><?php echo $myData['nm_barang']; ?></a></td>
    <td align="right">Rp.<?php echo format_angka($myData['harga']); ?></td>
    <td align="center"><?php echo $myData['jumlah']; ?></td>
    <td align="right">Rp. <?php echo format_angka($subtotal); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" align="right" bgcolor="#FFF0FF"><strong>GRAND TOTAL :</strong></td>
    <td align="center"><?php echo $totalbarang; ?></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($totalharga); ?></strong></td>
  </tr>
</table>
<p>&nbsp;</p>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="82%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#FF6666"><strong>LENGKAPI ALAMAT UNTUK PENGIRIMAN BARANG</strong></td>
    </tr>
    <tr>
      <td width="26%">Nama Penerima</td>
      <td width="1%">:</td>
      <td width="73%"><label for="txtnama"></label>
      <input name="txtnama" type="text" id="txtnama" value="<?php echo $dataNama; ?>" size="50" maxlength="80"></td>
    </tr>
    <tr>
      <td>Alamat Lengkap</td>
      <td>:</td>
      <td height="2"><label for="txtalamat"></label>
      <textarea name="txtalamat" cols="50" rows="2" id="txtalamat"><?php echo $dataAlamat; ?></textarea></td>
    </tr>
    <tr>
      <td>Provinsi</td>
      <td>:</td>
      <td><select name="cmbprovinsi">
          <option value="KOSONG" selected>....</option>
          <?php
		$comboSql = "SELECT * FROM provinsi ORDER BY nm_provinsi ASC";
		$comboQry = mysql_query($comboSql, $koneksidb) or die ("Gagal query".mysql_error());
		while ($comboData =mysql_fetch_array($comboQry)) {
			if ($comboData['kd_provinsi']==$dataProvinsi) {
				$cek="selected";
			}
			else {
				$cek="";
			}
			echo "<option value='$comboData[kd_provinsi]' $cek>$comboData[nm_provinsi]</option>";
		}
		?>
        </select></td>
    </tr>
    <tr>
      <td>Kota</td>
      <td>:</td>
      <td><label for="txtkota"></label>
      <input name="txtkota" type="text" id="txtkota" value="<?php echo $dataKota; ?>" size="40" maxlength="50">
      *</td>
    </tr>
    <tr>
      <td>Kode Pos</td>
      <td>:</td>
      <td><label for="txtkpos"></label>
      <input name="txtkpos" type="text" id="txtkpos" value="<?php echo $dataPos; ?>" size="10" maxlength="5">
      *</td>
    </tr>
    <tr>
      <td>Telepon/Hp</td>
      <td>:</td>
      <td><label for="txttelp"></label>
      <input name="txttelp" type="text" id="txttelp" value="<?php echo $dataNoTelp; ?>" size="20" maxlength="15">
      *</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnsimpan" id="btnsimpan" value="Simpan &amp; Lanjutkan"></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
