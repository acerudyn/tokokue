<?php
// Membaca Kode dari URL
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	
	// Menampilkan data sesuai Kode dari URL
	$lihatSql = "SELECT barang.*, kategori.nm_kategori FROM barang 
				LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori
				WHERE barang.kd_barang='$Kode'";
	
	$lihatQry = mysql_query($lihatSql, $koneksidb) or die ("Data Gagal Ditampilkan ..!");
	$no=0;
	$lihatData = mysql_fetch_array($lihatQry);
	  $no++;
	  $KodeBarang= $lihatData['kd_barang'];
	  $KodeKategori = $lihatData['kd_kategori'];
	  	  
	  // Membaca gambar utama
	  if ($lihatData['file_gambar']=="") {
			$filegambar = "noimage.jpg";
	  }
	  else {
			$filegambar	= $lihatData['file_gambar'];
	  }
} 
else {
	// Jika variabel Kode tidak ada di URL
	echo "Kode barang tidak ada ";
	
	// Refresh
	echo "<meta http-equiv='refresh' content='2; url=index.php'>";
	exit;
}
?>
<style type="text/css">
.barang {
	text-align: center;
	font-weight: bold;
}
.button.small strong {
	text-align: center;
}
</style>


<title>Elfia Bakery</title>

<table width="80%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="29%" align="center"><img src="../img-barang/<?php echo $filegambar; ?>" width="204" height="241" border="0" /><br />
      <br />
     <a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>"><img src="../images/tombol_beli.png" width="88" height="29" alt="beli" /></a></td>
    <td width="71%"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr bgcolor="#FFFFCC" class="barang">
          <td colspan="3">DETAIL BARANG</td>
        </tr>
        <tr>
          <td width="39%">Nama Barang</td>
          <td width="2%">:</td>
          <td width="59%"><b><?php echo $lihatData['nm_barang']; ?></b></td>
        </tr>
        <tr>
          <td>Harga (Rp)</td>
          <td>:</td>
          <td><?php echo format_angka($lihatData['harga_jual']); ?></td>
        </tr>
        <tr>
          <td>Stok</td>
          <td>:</td>
          <td><?php echo $lihatData['stok']; ?></td>
        </tr>
        <tr>
          <td>Kategori</td>
          <td>:</td>
          <td><?php echo $lihatData['nm_kategori']; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">Keterangan :</td>
        </tr>
        <tr>
          <td colspan="3"><?php echo $lihatData['keterangan']; ?></td>
        </tr>
    </table></td>
  </tr>
</table>
<?php include "barang_sejenis.php"; ?>
