<?php
include_once "../library/inc.sessadmin.php";

//tombol simpan klik
if(isset($_POST['SIMPAN'])){
	
	
//simpan ke database
// Membuat nilai data pada form input
$dataKode	= buatKode("provinsi", "P");
$dataNama 	= isset($_POST['nm_prov']) ?  $_POST['nm_prov'] : '';
$dataBiaya	= isset($_POST['biayakirim']) ?  $_POST['biayakirim'] : '';

//Baca Variabel
	$nm_prov=$_POST['nm_prov'];
	$nm_prov= str_replace("'","&pink;",$nm_prov);
	
	$biayakirim	=$_POST['biayakirim'];
	$biayakirim= str_replace("'","&pink;",$biayakirim);

// Validasi form
	$pesanError = array();
	if (trim($nm_prov)=="") {
		$pesanError[] = "Data <b>Nama Provinsi</b> tidak boleh kosong !";		
	}
	if (trim($biayakirim)=="" or ! is_numeric(trim($biayakirim))) {
		$pesanError[] = "Data <b>Biaya Kirim (Rp)</b> tidak boleh kosong, dan harus diisi angka !";		
	}

// Validasi Nama Provinsi, tidak boleh ada yang kembar (namanya sama)
	$txtnamalama	= $_POST['txtnamalama'];
	$cekSql	= "SELECT * FROM provinsi WHERE nm_provinsi='$nm_prov' AND NOT(nm_provinsi='$txtnamalama')";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Provinsi <b> $nm_prov </b> sudah ada, ganti dengan yang nama berbeda";
	}
	
	//JIKA ADA PESAN ERROR DARI VALIDASI
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
		$mySql	= "UPDATE provinsi SET nm_provinsi ='$nm_prov', biaya_kirim ='$biayakirim' WHERE kd_provinsi ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Provinsi-Data'>";
		}
		exit;
	}	

} // End if($_POST) 

//======================================================================
# MEMBACA DATA DARI FORM / DATABASE, UNTUK DITAMPILKAN KEMBALI PADA FORM
// Membaca data dari database, Sesuai kode yang dipilih dari Tampil Data (dikirim ke URL browser)
$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtkode'];
$mySql	 = "SELECT * FROM provinsi WHERE kd_provinsi='$Kode'";
$myQry	 = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData  = mysql_fetch_array($myQry);

	// Masukkan data ke variabel, untuk dibaca di form input
	$dataKode	= $myData['kd_provinsi'];
	$dataNama 	= isset($_POST['nm_prov']) ?  $_POST['nm_prov'] : $myData['nm_provinsi'];
	$dataBiaya	= isset($_POST['biayakirim']) ?  $_POST['biayakirim'] : $myData['biaya_kirim'];
?>



<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col">Update Data Provinsi</th>
    </tr>
    <tr>
      <td width="172">Kode</td>
      <td width="1">:</td>
      <td width="455"><label for="txtfield"></label>
      <input name="txtfield" type="text" disabled="disabled" id="txtfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly">
      <input name="txtkode" type="hidden" id="txtkode" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td>Nama Provinsi</td>
      <td>:</td>
      <td><label for="nm_prov"></label>
      <input name="nm_prov" type="text" id="nm_prov" value="<?php echo $dataNama; ?>" size="70" maxlength="100">
      <input name="txtnamalama" type="hidden" id="txtnamalama" value="<?php echo $myData['nm_provinsi']; ?>" /></td>
    </tr>
    <tr>
      <td>Biaya Kirim (Rp)</td>
      <td>:</td>
      <td><label for="biayakirim"></label>
      <input name="biayakirim" type="text" id="biayakirim" value="<?php echo $dataBiaya; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="SIMPAN" id="SIMPAN" value="Simpan"></td>
    </tr>
  </table>
</form>
