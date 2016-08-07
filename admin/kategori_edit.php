<?php
include_once "../library/inc.sessadmin.php";

# MEMBACA TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnsimpan'])){

// Baca form
$txtnama	= $_POST['txtnama'];
$txtnama 	= str_replace("'","&pink;",$txtnama); // Membuang karakter petik (') 
	
// Validasi form
$pesanError = array();
	if (trim($txtnama)=="") {
		$pesanError[] = "Data <b>Nama Kategori</b> tidak boleh kosong !";		
	}
		
// Validasi Nama Kategori, tidak boleh ada yang kembar (namanya sama)
$txtnamalama	= $_POST['txtnamalama'];
$cekSql	="SELECT * FROM kategori WHERE nm_kategori='$txtnama' AND NOT(nm_kategori='$txtnamalama')";
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
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesanError, simpan data ke database
		$Kode	= $_POST['txtkode'];
		$mySql	= "UPDATE kategori SET nm_kategori ='$txtnama' WHERE kd_kategori ='$Kode'";
		$myQry	= mysql_query($mySql) or die ("Query salah : ".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Jenis'>";
		}
		exit;
	}	
} // End if($_POST) 

//======================================================================
# MEMBACA DATA DARI FORM / DATABASE, UNTUK DITAMPILKAN KEMBALI PADA FORM
// Membaca data dari database, Sesuai kode yang dipilih dari Tampil Data (dikirim ke URL browser)
$Kode  = isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtkode'];
$mySql = "SELECT * FROM kategori WHERE kd_kategori='$Kode'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);

// Masukkan data ke variabel, untuk dibaca di form input
$dataKode		= $myData['kd_kategori'];
$dataKategori	= isset($_POST['txtnama']) ?  $_POST['txtnama'] : $myData['nm_kategori'];
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="676" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col">Update Jenis Kategori</th>
    </tr>
    <tr>
      <td width="201">Kode</td>
      <td width="3">:</td>
      <td width="450"><label for="txtfield"></label>
      <input name="txtfield" type="text" disabled="disabled" id="txtfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/>
      <input name="txtkode" type="hidden" id="txtkode" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td>Nama Kategori</td>
      <td>:</td>
      <td><label for="txtnama"></label>
      <input name="txtnama" type="text" id="txtnama" value="<?php echo $dataKategori; ?>" size="70" maxlength="100">
      <input name="txtnamalama" type="hidden" id="txtnamalama" value="<?php echo $myData['nm_kategori']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnsimpan" id="btnsimpan" value="SIMPAN"></td>
    </tr>
  </table>
</form>
