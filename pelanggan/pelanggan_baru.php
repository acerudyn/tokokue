<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

//penyimpanan sukses
if(isset($_GET['Aksi']) and $_GET['Aksi']=="Sukses"){
	echo "<br><br><center> <b>SELAMAT, PENDAFTARAN ANDA SUDAH KAMI TERIMA </b> Sekarang, Anda dapat login untuk melakukan pemesanan </center></br></br>";
	
	echo "<meta http-equiv='refresh' content='2; url='?open=Barang'>";
	exit;
}

//klik tombol daftar
if(isset($_POST['btndaftar'])){
	// Baca Variabel Form
	$txtnama	= $_POST['txtnama'];
	$txtnama 	= str_replace("'","&pink;",$txtnama);
	
	$cmbkelamin	= $_POST['cmbkelamin'];
	$txtemail	= $_POST['txtemail'];
	$txtnotelp	= $_POST['txtnotelp'];
	
	$txtuser	= $_POST['txtuser'];
	$txtpass1	= $_POST['txtpass1'];
	$txtpass2	= $_POST['txtpass2'];

	// Validasi, jika data kosong kirimkan pesan error
	$pesanError = array();
	if (trim($txtnama) =="") {
		$pesanError[] = "Data <b>Nama Pelanggan</b> masih kosong";
	}
	if (trim($cmbkelamin) =="KOSONG") {
		$pesanError[] = "Data <b>Jenis Kelamin</b> belum dipilih";
	}
	if (trim($txtemail) =="") {
		$pesanError[] = "Data <b>Alamat Email</b> masih kosong";
	}
	if (trim($txtnotelp) =="") {
		$pesanError[] = "Data <b>No. Telepon</b> masih kosong";
	}
	if (trim($txtuser) =="") {
		$pesanError[] = "Data <b>Username</b> masih kosong";
	}
	if (trim($txtpass1) =="") {
		$pesanError[] = "Data <b>Password</b> masih kosong";
	}
	if (trim($txtpass1) != trim($txtpass2)) {
		$pesanError[] = "Data <b>Password Ke 2</b> tidak sama dengan sebelumnya";
	}
	
	// Valiasii Username, tidak boleh ada yang kembar
	$sqlCek = "SELECT * FROM pelanggan WHERE username='$txtuser'";
	$qryCek = mysql_query($sqlCek, $koneksidb) or die ("Gagal Cek");
	$adaCek = mysql_num_rows($qryCek);
	if($adaCek >= 1) {	
			$pesanError[] = "Silakan coba yang lain, User <b> $txtuser </b> sudah ada yang menggunakan.";
	}	
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='pesanError' align='left'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "<br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		$kodeBaru	= buatKode("pelanggan","P");
		$tanggal	= date('Y-m-d');
		$mySql	= "INSERT INTO pelanggan ( kd_pelanggan, nm_pelanggan, kelamin, email, no_telp, 
											username, password, tgl_daftar) 
					VALUES ('$kodeBaru', '$txtnama', '$cmbkelamin', '$txtemail', '$txtnotelp', 
											'$txtuser', MD5('$txtpass1'), '$tanggal')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang'>";
		}
		exit;
	}	
} // End if($_POST) 

# BACA VARIABEL FORM
$kodeBaru	    = buatKode("pelanggan","P");
$dataNama		= isset($_POST['txtnama']) ? $_POST['txtnama'] : '';
$dataKelamin	= isset($_POST['cmbkelamin']) ? $_POST['cmbkelamin'] : 'Laki-laki';
$dataEmail		= isset($_POST['txtemail']) ? $_POST['txtemail'] : '';
$dataNoTelp 	= isset($_POST['txtnotelp']) ? $_POST['txtnotelp'] : '';
$dataUser		= isset($_POST['txtuser']) ? $_POST['txtuser'] : '';

?>
<title></title>


<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="80%" border="0" cellpadding="3" cellspacing="1">
    <tr>
      <td colspan="3" bgcolor="#FF6699"><strong>PENDAFTARAN MEMBER BARU</strong></td>
    </tr>
    <tr>
      <td width="28%">Nama Lengkap</td>
      <td width="1%">:</td>
      <td width="71%"><label for="txtnama"></label>
      <input name="txtnama" type="text" id="txtnama" value="<?php echo $dataNama; ?>" size="40" maxlength="60"></td>
    </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>:</td>
      <td><label for="cmbkelamin"></label>
        <select name="cmbkelamin" id="cmbkelamin">
        <option value="KOSONG">....</option>
          <?php
		$pilihan = array("Laki-laki", "Perempuan");
		foreach ($pilihan as $nilai) {
			if ($nilai == $dataKelamin) {
				$cek=" selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek>$nilai</option>";
		}
		?>
      </select></td>
    </tr>
    <tr>
      <td>Email</td>
      <td>:</td>
      <td><label for="txtemail"></label>
      <input name="txtemail" type="text" id="txtemail" value="<?php echo $dataEmail; ?>" size="40" maxlength="40"></td>
    </tr>
    <tr>
      <td>No. Telepon/Hp</td>
      <td>:</td>
      <td><label for="txtnotelp"></label>
      <input name="txtnotelp" type="text" id="txtnotelp" value="<?php echo $dataNoTelp; ?>" size="20" maxlength="15"></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FF6699"><strong>DATA LOGIN</strong></td>
    </tr>
    <tr>
      <td>Username</td>
      <td>:</td>
      <td><label for="txtuser"></label>
      <input name="txtuser" type="text" id="txtuser" value="<?php echo $dataUser; ?>" size="25" maxlength="30"></td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td><label for="txtpass1"></label>
      <input name="txtpass1" type="password" id="txtpass1" size="25" maxlength="20"></td>
    </tr>
    <tr>
      <td>Password (Ulangi)</td>
      <td>:</td>
      <td><label for="txtpass2"></label>
      <input name="txtpass2" type="password" id="txtpass2" size="25" maxlength="20"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btndaftar" id="btndaftar" value="Sign Up"></td>
    </tr>
  </table>
</form>
