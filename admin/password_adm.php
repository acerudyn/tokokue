<?php
// Validasi Login : yang boleh mengakses halaman ini hanya yang sudah Login admin
include_once "../library/inc.sessadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";


# Tombol Simpan diklik
if(isset($_POST['btnsimpan'])){
	// Baca form
	$txtpassbaru= $_POST['txtpassbaru'];
	$txtpasslama= $_POST['txtpasslama'];
	
	// Validasi form
	$pesanError = array();
	if (trim($txtpassbaru)=="") {
		$pesanError[] = "Data <b> Password baru </b> belum diisi !";		
	}
	
	// Validasi Password lama (harus benar)
	$sqlCek = "SELECT * FROM admin WHERE username='admin' AND password ='".md5($txtpasslama)."'";
	$qryCek = mysql_query($sqlCek, $koneksidb)  or die ("Query Periksa Password Salah : ".mysql_error());
	if(mysql_num_rows($qryCek) <1){
		$pesanError[] = "Maaf, <b> Password Anda Salah</b>....silahkan ulangi";
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
		$mySql	= "UPDATE admin SET password='".md5($txtpassbaru)."'";
		$myQry	= mysql_query($mySql, $koneksidb);
		if($myQry){
			echo "<b> Password Berhasil Diganti </b>";
			echo "<meta http-equiv='refresh' content='0; url=?open=Logout&Info=Password Berhasil Diganti'>";
		}
	}	
}  

# Membaca Data Login untuk diedit
$mySql = "SELECT * FROM admin";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1">
<table class="table-list" width="56%">
	<tr>
	  <th colspan="3">Ganti Password Admin</th>
	</tr>
	<tr>
      <td width="31%">Password Lama</td>
	  <td width="2%"><b>:</b></td>
	  <td width="67%"><input name="txtpasslama" type="password" value="" size="40" maxlength="30" id="txtpasslama"/></td>
	</tr>
	<tr>
	  <td>Password Baru </td>
	  <td><b>:</b></td>
	  <td><input name="txtpassbaru" type="password"  value="" size="40" maxlength="30" id="txtpassbaru"/></td>
	</tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnsimpan" value=" Save" style="cursor:pointer;" id="btnsimpan"></td>
    </tr>
</table>
</form>