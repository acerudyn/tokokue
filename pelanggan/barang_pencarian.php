<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

$filterSql	= "";
// Membaca variabel form
$keyword	= isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
$keyword	= isset($_POST['keyword']) ? $_POST['keyword'] : $Keyword;

// Jika tombol Cari diklik
if(isset($_POST['btncari'])){
	if($_POST) {
         // Skrip pencarian
		$filterSql = "WHERE nm_barang LIKE '%$keyword%' OR nm_barang LIKE '$keyword%'";
	}
}
else {
	if($Keyword){
         // Skrip pencarian
		$filterSql = "WHERE nm_barang LIKE '%$keyword%' OR nm_barang LIKE '$keyword%'";
	}
	else {
		$filterSql = "";
	}
} 

# Nomor Halaman (Paging)
$baris	= 5;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM barang $filterSql ORDER BY kd_barang DESC";
$pageQry= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	= mysql_num_rows($pageQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1);
?>
<title>Elfia Bakery</title>


<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="2" align="center" bgcolor="#FF9999" scope="col"><strong>HASIL PENCARIAN BARANG</strong> " <?php echo $keyword; ?> "</td>
  </tr>
<?php
// Menampilkan daftar barang
$barangSql = "SELECT barang.*,  kategori.nm_kategori FROM barang 
			LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
			$filterSql 
			ORDER BY barang.kd_barang ASC LIMIT $mulai, $baris";
$barangQry = mysql_query($barangSql, $koneksidb) or die ("Gagal Query".mysql_error()); 
$nomor = 0;
while ($barangData = mysql_fetch_array($barangQry)) {
  $nomor++;
  $KodeBarang = $barangData['kd_barang'];
  $KodeKategori = $barangData['kd_kategori'];
  
  // Menampilkan gambar utama
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
    <td width="26%" align="center">
	  <a href="?open=Barang-Detail&Kode=<?php echo $KodeBarang; ?>"><img src="../img-barang/<?php echo $filegambar; ?>" width="100" border="0"> </a> <br>
      <div class='harga'>Rp. <?php echo format_angka($barangData['harga_jual']); ?> </div><br>
      <a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" target="_self"> <strong><img src="../images/tombol_beli.png" alt="beli" width="88" height="31" align="absmiddle" /></strong></a></td>
    <td width="74%" valign="top">
	  <a href="?open=Barang-Detail&Kode=<?php echo $KodeBarang; ?>">
      <div class='judul'><?php echo $barangData['nm_barang']; ?> </div>
      </a>
      
	  <p><?php echo substr($barangData['keterangan'], 0, 200); ?> ....</p>
      <p><strong>Stok :</strong> <?php echo $barangData['stok']; ?></p>
    <strong>Kategori :</strong> <a href="?open=Kategori-Barang&Kode=<?php echo $KodeKategori; ?>"> <?php echo $barangData['nm_kategori']; ?> </a></td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="2">Halaman :  <?php
	for ($h = 1; $h <= $maks; $h++) {
			echo "[  <a href='?open=Barang-Pencarian&keyword=$keyword&hal=$h'>$h</a> ]";
	}
	?></td>
  </tr>
</table>

