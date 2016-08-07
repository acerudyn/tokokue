<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Nomor Halaman (Paging)
$baris = 5;
$hal   = isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql = "SELECT * FROM barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	 = mysql_num_rows($pageQry);
$maks	 = ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1); 
?>
<html>
<head>
<link href="style/user.css" rel="stylesheet" type="text/css">
<style type="text/css">
.koleksipinkkabelboutique {	text-align: center;
}
</style>
<title>Elfia Bakery</title>
</head>
<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="3" align="center" bgcolor="#FF9999" scope="col"><span class="koleksipinkkabelboutique">  <strong>KOLEKSI KAMI</strong></span></td>
  </tr>
<?php
// Menampilkan daftar barang
$barangSql = "SELECT barang.*,  kategori.nm_kategori FROM barang 
			LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
			ORDER BY barang.kd_barang ASC LIMIT $mulai, $baris";
$barangQry = mysql_query($barangSql, $koneksidb) or die ("Gagal Query".mysql_error()); 
$nomor = 0;
while ($barangData = mysql_fetch_array($barangQry)) {
	$nomor++;
	$KodeBarang = $barangData['kd_barang'];
	$KodeKategori = $barangData['kd_kategori'];
	
	// Membaca file gambar
	if ($barangData['file_gambar']=="") {
		$filegambar = "noimage.jpg";
	}
	else {
		$filegambar	= $barangData['file_gambar'];
	}
  
	// Warna baris data
	if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
?>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="28%" align="center">
	  <a href="?open=Barang-Detail&Kode=<?php echo $KodeBarang; ?>" title='Detail'><img src="../img-barang/<?php echo $filegambar; ?>" width="100" border="0"> </a> <br>
      <div class='harga'>Rp. <?php echo format_angka($barangData['harga_jual']); ?> </div><br></td>
    
    <td width="60%" valign="top">
	  <a href="?open=Barang-Detail&Kode=<?php echo $KodeBarang; ?>">
      <div class='judul'><?php echo $barangData['nm_barang']; ?> </div>
      </a>
      
	  <p><?php echo substr($barangData['keterangan'], 0, 200); ?> ....</p>
	  <p> <strong>Kategori :</strong> <a href="?open=Kategori-Barang&Kode=<?php echo $KodeKategori; ?>"> <?php echo $barangData['nm_kategori']; ?> </a></p></td>
  <td width="12%" align="center" valign="middle"><p><a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" ><img src="../images/tombol_beli.png" width="88" height="29" alt="beli"></a></p></td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="3" align="left" bgcolor="#FFCCCC">
	<b>Halaman:
    <?php
	for ($h = 1; $h <= $maks; $h++) {
			echo "[  <a href='?hal=$h'>$h</a> ]";
	}
	?>
    </b></td>
  </tr>
</table>
</body>
</html>
