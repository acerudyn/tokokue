<?php
include_once "../library/inc.sessadmin.php";
include_once "../library/inc.library.php";

//tombol simpan klik
if (isset($_POST['btnsimpan'])) {

// Baca form
	$txtnama	= $_POST['txtnama'];
	$txtnama 	= str_replace("'","&pink;",$txtnama); // Membuang karakter petik (')
	
	// Validasi form
	$pesanError = array();
	if (trim($txtnama)=="") {
		$pesanError[] = "Data <b>Nama Kategori</b> tidak boleh kosong !";		
	}

// Validasi Nama Kategori, tidak boleh ada yang kembar (namanya sama)
	$cekSql	="SELECT * FROM kategori WHERE nm_kategori='$txtnama'";
	$cekQry	=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Kategori <b> $txtnama </b> sudah ada, ganti dengan yang nama berbeda";
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		$kodeBaru= buatKode("kategori", "K");
		$mySql	= "INSERT INTO kategori SET kd_kategori='$kodeBaru', nm_kategori='$txtnama'";
		$myQry	= mysql_query($mySql) or die ("Query salah : ".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Jenis'>";
		}
	}
} // End if($_POST) 

//membuat nilai data pada form input
$dataKode = buatKode ("kategori", "K");
$dataKategori = isset($_POST['txtnama']) ? $_POST['txtnama']: '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col">Tambah Jenis Kategori</th>
    </tr>
    <tr>
      <td width="203">Kode</td>
      <td width="1">:</td>
      <td width="424"><label for="txtfield"></label>
      <input name="txtfield" type="text" disabled="disabled" id="txtfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td>Nama Kategori</td>
      <td>:</td>
      <td><label for="txtnama"></label>
      <input name="txtnama" type="text" id="txtnama" value="<?php echo $dataKategori; ?>" size="70" maxlength="100"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnsimpan" id="btnsimpan" value="SIMPAN"></td>
    </tr>
  </table>
</form>
