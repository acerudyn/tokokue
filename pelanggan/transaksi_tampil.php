<?php
include_once "../pelanggan/inc.session.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];
?>
<title>Elfia Bakery</title>
 
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr bgcolor="#FF6666">
    <td colspan="8" bgcolor="#FF9999"><strong>DAFTAR PEMESANAN </strong></td>
  </tr>
  <tr bgcolor="#FFCCCC">
    <td width="4%">No</td>
    <td width="15%">No. Pesan</td>
    <td width="10%">Tanggal</td>
    <td width="22%">Nama Penerima</td>
    <td width="14%">Total   (Rp)</td>
    <td width="17%">Biaya Kirim (Rp)</td>
    <td width="11%">Status</td>
    <td width="7%">Tools</td>
  </tr>
<?php
// Deklrasi variabel
	$biayakirim	= 0;
	$totalbayar = 0;

// Menampilkan semua data Pesanan Lunas (yang sudah lunas)
$mySql = "SELECT pemesanan.*, pelanggan.nm_pelanggan, provinsi.biaya_kirim
		  FROM pemesanan
		  LEFT JOIN pelanggan ON pemesanan.kd_pelanggan= pelanggan.kd_pelanggan 
		  LEFT JOIN provinsi ON pemesanan.kd_provinsi=provinsi.kd_provinsi
		  WHERE pemesanan.kd_pelanggan='$KodePelanggan' ORDER BY no_pemesanan";
$myQry = @mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
$nomor = 0;
while ($myData =mysql_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['no_pemesanan'];
	
	// Deklarasi variabel data
	$diskonharga	= 0;
	$hargadiskon	= 0;
	$totalharga		= 0;
	$totalbarang	= 0;
	
	// Menampilkan data di pemesanan_item
	$hitungSql	= "SELECT SUM(harga * jumlah) As total_harga,
				SUM(jumlah) As total_barang FROM pemesanan_item WHERE no_pemesanan='$Kode'";
	$hitungQry 	= mysql_query($hitungSql, $koneksidb) or die ("Gagal query 2 ".mysql_error());
	$hitungdata = mysql_fetch_array($hitungQry);
	
	$totalharga		= $hitungdata['total_harga'];
	$totalbarang	= $hitungdata['total_barang'];
	
	
	// Hitung total yang harus dibayar
	$totalbayar	= $totalharga + $myData['biaya_kirim'];

?>
  <tr>
	<td> <?php echo $nomor; ?> </td>
	<td> <?php echo $myData['no_pemesanan']; ?> </td>
	<td> <?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?> </td>
	<td> <?php echo $myData['nama_penerima']; ?> </td>
	<td> Rp. <?php echo format_angka($totalharga); ?> </td>
	<td> Rp. <?php echo format_angka($myData['biaya_kirim']); ?> </td>
	<td> <?php echo $myData['status_bayar']; ?> </td>
    <td><a href="transaksi_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank" alt="Lihat"><img src="../images/b_print.png" alt="print" width="16" height="16" align="texttop" /></a></td>
  </tr>
<?php } ?>
</table>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<center></center>