<?php
include_once "../library/inc.sessadmin.php"; //validasi harus login
include_once "../library/inc.connection.php"; // Membuka koneksi
include_once "../library/inc.library.php"; //untuk perintah

//UNTUK PEMBAGIAN HALAMAN
$baris = 5;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	 = mysql_num_rows($pageQry);
$maksData= ceil($jumlah/$baris);
?>


<style type="text/css">
.Databarang {
	font-size: 27px;
	text-align: right;
	font-weight: bold;
}
</style>
<table width="700" border="0" cellspacing="1" cellpadding="3" class="table-border">
  <tr>
    <td colspan="2" class="Databarang">Data Barang</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><a href="?open=Barang-Add" target="_self"><img src="../images/btn_add_data.png" width="58" height="22" alt="tambah"></a></td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr bgcolor="#FFCCCC">
        <td width="8%" scope="col"><strong>No</strong></td>
        <td width="15%" scope="col"><strong>Kode</strong></td>
        <td width="34%" scope="col"><strong>Nama Barang</strong></td>
        <td width="8%" scope="col"><strong>Stok</strong></td>
        <td width="22%" align="right" scope="col"><strong>Harga(Rp)</strong></td>
        <td colspan="2" align="center" scope="col"><strong>Tools</strong></td>
        </tr>
    <?php	
	$mySql = "SELECT * FROM barang ORDER BY kd_barang ASC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData ['kd_barang']; ?></td>
        <td><?php echo $myData ['nm_barang']; ?></td>
        <td><?php echo $myData ['stok']; ?></td>
        <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
        <td width="6%" align="center"><a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self"><img src="../images/b_edit.png" width="16" height="16" alt="edit" /></a></td>
        <td width="7%" align="center"><a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('Yakin ingin menghapus nama barang ini..?')"><img src="../images/hapus.gif" width="16" height="16" alt="hapus" /></a></td>
      </tr>
     <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td width="313"><strong>Jumlah Data :</strong> <?php echo $jumlah; ?> </td>
    <td width="372"><strong>Halaman Ke : </strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris*$h-$baris;
		echo "<a href='?open=Barang-Data&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
