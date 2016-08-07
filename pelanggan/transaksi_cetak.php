<?php
session_start();
include_once "../pelanggan/inc.session.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];

// data Kode di URL harus ada
if(isset($_GET['Kode'])) {
	// Membaca Kode (No Pemesanan)
	$Kode	= $_GET['Kode'];
	
	// Sql membaca data Pemesanan utama sesuai Kode yang dipilih
	$mySql 	= "SELECT pemesanan.*, pelanggan.nm_pelanggan, provinsi.*
			  FROM pemesanan
			  LEFT JOIN pelanggan ON pemesanan.kd_pelanggan= pelanggan.kd_pelanggan 
			  LEFT JOIN provinsi ON pemesanan.kd_provinsi=provinsi.kd_provinsi
			  WHERE pemesanan.kd_pelanggan='$KodePelanggan' AND pemesanan.no_pemesanan ='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal query");
	$myData= mysql_fetch_array($myQry);
} 
else {
	// Jika data Kode di URL tidak terbaca
	echo "<meta http-equiv='refresh' content='0; url=?open=Transaksi-Tampil'>";
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="style/styles_cetak.css" rel="stylesheet" type="text/css">
<title>Cetak Transaksi</title>
</head>

<body>
<p>CETAK TRANSAKSI PEMESANAN BARANG</p>
<table width="600" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="175"><strong>No. Pemesanan</strong></td>
    <td width="6"><strong>:</strong></td>
    <td width="397"><?php echo $myData['no_pemesanan']; ?></td>
  </tr>
  <tr>
    <td><strong>Tanggal Pemesanan</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?></td>
  </tr>
  <tr>
    <td><strong>Kode Pelanggan</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['kd_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Nama Pelanggan</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Nama Penerima</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nama_penerima']; ?></td>
  </tr>
  <tr>
    <td><strong>Alamat Lengkap</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['alamat']; ?></td>
  </tr>
  <tr>
    <td><strong>Provinsi</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nm_provinsi']; ?></td>
  </tr>
  <tr>
    <td><strong>Kota</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['kota']; ?></td>
  </tr>
  <tr>
    <td><strong>No. Telepon/Hp</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['no_telp']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Status Pembayaran</strong></td>
    <td><strong>:</strong></td>
    <td><strong><?php echo $myData['status_bayar']; ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="800" border="0" cellspacing="1" cellpadding="3">
  <tr align="center" bgcolor="#FFCCCC">
    <td width="32">No</td>
    <td width="89">Kode</td>
    <td width="250">Nama Barang</td>
    <td width="135">Harga (Rp)</td>
    <td width="82">Jumlah</td>
    <td width="169">Total (Rp)</td>
  </tr>
   <?php 
	  // Deklarasi variabel
	  $subtotal	= 0;
	  $totalbarang = 0;
	  $biayakirim = 0;
	  $totalharga = 0;
	  $totalbayar =0;
	  $diskon=0;
	  
	  // SQL Menampilkan data Barang yang dipesan
	$tampilSql = "SELECT barang.nm_barang, pemesanan_item.*
				FROM pemesanan, pemesanan_item
				LEFT JOIN barang ON pemesanan_item.kd_barang=barang.kd_barang
				WHERE pemesanan.no_pemesanan=pemesanan_item.no_pemesanan
				AND pemesanan.no_pemesanan='$Kode'
				ORDER BY pemesanan_item.kd_barang";
	$tampilQry = mysql_query($tampilSql, $koneksidb) or die ("Gagal SQL".mysql_error());
	$no	= 0; 
	while ($tampilData = mysql_fetch_array($tampilQry)) {
	  $no++;
	  // Menghitung subtotal harga (harga  * jumlah)
	  $subtotal		= $tampilData['harga'] * $tampilData['jumlah'];
	  
	  // Menjumlah total semua harga 
	  $totalharga 	= $totalharga + $subtotal;  
	  
	  // Menjumlah item barang
	  $totalbarang	= $totalbarang + $tampilData['jumlah'];
	  
	  // Menghitung Diskon
	  if ($totalharga > 200000) { 
	   $diskon = 0.1*$totalharga; 
	  }
	   else { 
	   $diskon = 0; 
	  }
  ?>
  <tr align="center">
    <td><?php echo $no; ?></td>
    <td><?php echo $tampilData['kd_barang']; ?></td>
    <td><?php echo $tampilData['nm_barang']; ?></td>
    <td>Rp. <?php echo format_angka($tampilData['harga']); ?></td>
    <td><?php echo $tampilData['jumlah']; ?></td>
    <td>Rp. <?php echo format_angka($subtotal); ?></td>
  </tr>
   <?php } 
  	// Menghitung	
		$totalbayar = $totalharga + $myData['biaya_kirim'] - $diskon;  

		
	
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right" bgcolor="#FFCC99"><strong>Total Belanja (Rp)</strong></td>
    <td align="right">Rp. <?php echo format_angka($totalharga); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right"><strong>Biaya Kirim (Rp) </strong></td>
    <td align="right">Rp. <?php echo format_angka($myData['biaya_kirim']); ?></td>
  </tr>
  <tr>
    <td colspan="3" align="right">&nbsp;</td>
    <td colspan="2" align="right" bgcolor="#FFFFCC"><strong>Diskon (Rp)</strong></td>
    <td align="right">Rp. <?php echo format_angka($diskon); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right" bgcolor="#FFCC99"><strong>GRAND TOTAL (Rp) </strong></td>
    <td align="right"><?php echo format_angka($totalbayar); ?></td>
  </tr>
  <tr>
    <td colspan="6"><strong>Jadi Total yang harus di Transfer  adalah <b>Rp. <?php echo format_angka($totalbayar); ?></b></strong></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>