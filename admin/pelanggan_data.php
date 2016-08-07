<?php
include_once "../library/inc.sessadmin.php";
include_once "../library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pelanggan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	 = mysql_num_rows($pageQry);
$maksData= ceil($jumlah/$baris);

// Membaca data form cari
$dataCari	= isset($_POST['txtcari']) ? $_POST['txtcari'] : '';
?>

<table width="800" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>Data Pelanggan </b></h1></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="right">
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
      <b>Cari Nama :</b>
        <input name="txtcari" type="text" id="txtcari" value="<?php echo $dataCari; ?>" size="40" maxlength="100" />
      <input name="btncari" type="submit" value="Cari" id="btncari" />
      </form></td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr bgcolor="#FF6666">
        <td width="23"><strong>No</strong></td>
        <td width="59"><strong>Kode</strong></td>
        <td width="150"><strong>Nama Pelanggan</strong></td>
        <td width="90"><strong>Kelamin</strong></td>
        <td width="111"><strong>No. Telepon</strong></td>
        <td width="95"><strong>Username</strong></td>
        <td align="center"><strong>Tools</strong><b></b></td>
        </tr>
      <?php
	# Jika tombol Cari/Search diklik, maka pencarian dilakukan
	if(isset($_POST['btncari'])){
		$mySql = "SELECT * FROM pelanggan WHERE nm_pelanggan LIKE '%$dataCari%' ORDER BY kd_pelanggan DESC LIMIT $hal, $baris";
	}
	else {
		$mySql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan DESC LIMIT $hal, $baris";
	} 
	
	// Menjalankan query di atas
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_pelanggan'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_pelanggan']; ?></td>
        <td><?php echo $myData['nm_pelanggan']; ?></td>
        <td><?php echo $myData['kelamin']; ?></td>
        <td><?php echo $myData['no_telp']; ?></td>
        <td><?php echo $myData['username']; ?></td>
        <td width="46" align="center"><a href="?open=Pelanggan-Hapus&Kode=<?php echo $Kode; ?>" target="_self" alt="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus ini ?')"><img src="../images/hapus.gif" width="16" height="16" alt="hapus" /></a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td><b>Jumlah Data :</b> <?php echo $jumlah; ?> </td>
    <td align="right"><b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Pelanggan-Data&hal=$list[$h]'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
