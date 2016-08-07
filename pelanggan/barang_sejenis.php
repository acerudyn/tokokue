

<style type="text/css">
.koleksipinkkabelboutique {
	text-align: center;
}
</style>
<title>Elfia Bakery</title>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="2" bgcolor="#FF9999" class="koleksipinkkabelboutique">KOLEKSI BARANG SEJENIS</td>
  </tr>
<?php
	// Membaca Kode barang pada URL
	$Kode	= $_GET['Kode'];

	// menampilkan daftar barang
	$barang3Sql = "SELECT barang.*,  kategori.nm_kategori FROM barang 
				LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori 
				WHERE barang.kd_kategori='$KodeKategori' AND barang.kd_barang != '$Kode' 
				ORDER BY barang.kd_barang DESC LIMIT 5";
	$barang3Qry = mysql_query($barang3Sql, $koneksidb) or die ("Gagal Query".mysql_error()); 
	$nomor = 0;
	while ($barang3Data = mysql_fetch_array($barang3Qry)) {
	  $nomor++;
	  $KodeBarang = $barang3Data['kd_barang'];
	  $KodeKategori = $barang3Data['kd_kategori'];

	  // menampilkan gambar utama
	  if ($barang3Data['file_gambar']=="") {
			$filegambar = "noimage.jpg";
	  }
	  else {
			$filegambar	= $barang3Data['file_gambar'];
	  }
	  
	// Warna baris data
	if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="26%" align="center">
	  <a href="?open=Barang-Detail&amp;Kode=<?php echo $KodeBarang; ?>"> <img src="../img-barang/<?php echo $filegambar; ?>" width="100" border="0"/> </a> <br>
      <div class='harga'>Rp. <?php echo format_angka($barang3Data['harga_jual']); ?> </div><br>
      <a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" target="_self" ><img src="../images/beli.gif" width="63" height="19" alt="beli" /></a> </td>
    <td width="74%" valign="top">
	  <a href="?open=Barang-Detail&Kode=<?php echo $KodeBarang; ?>">
      <div class='judul'><?php echo $barang3Data['nm_barang']; ?> </div>
      </a>
      
	  <p><?php echo substr($barang3Data['keterangan'], 0, 200); ?> ....</p>
	  <p> <strong>Kategori :</strong> <a href="?open=Kategori-Barang&Kode=<?php echo $KodeKategori; ?>"> <?php echo $barang3Data['nm_kategori']; ?> </a></p></td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="2"></td>
  </tr>
</table>

