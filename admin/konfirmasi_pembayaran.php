<?php
include_once "../library/inc.sessadmin.php";
include_once "../library/inc.library.php";
include_once "../library/inc.connection.php";

//pembagian halaman
$baris 	= 5;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM konfirmasi";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	 = mysql_num_rows($pageQry);
$maksData= ceil($jumlah/$baris);
?>
<style type="text/css">
.Notanggalnopemesanannamapelanggantransferrpkettools {
	text-align: center;
}
</style>


<h1>Konfirmasi Pembayaran</h1>
<table width="979" border="0" cellspacing="1" cellpadding="3" class="table-list">
  <tr bgcolor="#FFCCCC" class="Notanggalnopemesanannamapelanggantransferrpkettools">
    <td width="33" scope="col"><strong>No</strong></td>
    <td width="97" scope="col"><strong>Tanggal</strong></td>
    <td width="119" scope="col"><strong>No. Pemesanan</strong></td>
    <td width="144" align="left" scope="col"><strong>Nama Pelanggan</strong></td>
    <td width="105" align="right" scope="col"><strong>Transfer (Rp)</strong></td>
    <td width="95" scope="col"><strong>Bank</strong></td>
    <td width="282" scope="col"><strong>Keterangan</strong></td>
    <td width="47" scope="col"><strong>Tools</strong></td>
  </tr>
 <?php
 //menampilkan data konfirmasi dari database
 $mySql = "SELECT * FROM konfirmasi ORDER BY konfirmasi.id DESC LIMIT $hal, $baris";
 $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
 $nomor = 0; 
 while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['id'];
 ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo IndonesiaTgl ($myData['tanggal']); ?></td>
    <td align="center"><?php echo $myData['no_pemesanan']; ?></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
    <td align="right"><?php echo format_angka($myData['jumlah_transfer']); ?></td>
    <td align="center"><?php echo $myData['bank']; ?></td>
    <td align="center"><?php echo $myData['keterangan']; ?></td>
    <td align="center"><a href="?open=Konfirmasi-Delete&Kode <?php echo $Kode ?>" target="_self" alt="Delete Data" onClick="return confirm('Yakin ingin menghapus data ini..?')">Delete</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4"><strong>Jumlah Data : <?php echo $jumlah; ?></strong></td>
    <td colspan="4"><strong>Halaman Ke : 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Konfirmasi-Bayar&hal=$list[$h]'>$h</a> ";
	}
	?></strong></td>
  </tr>
</table>
<p>&nbsp;</p>
