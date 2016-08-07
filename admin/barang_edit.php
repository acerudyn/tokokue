<?php
// Validasi Login : yang boleh mengakses halaman ini hanya yang sudah Login admin
include_once "../library/inc.sessadmin.php";
include_once "../library/inc.library.php";

// Tombol simpan
if(isset($_POST['btnsimpan'])){

	
// Baca form
	$txtnama	= $_POST['txtnama'];
	$txtnama 	= str_replace("'","&pink;",$txtnama);
	$txtnama	= ucwords(strtolower($txtnama)); 
	
	$hargamodal	= $_POST['hargamodal'];
	$hargamodal = str_replace("'","&pink;",$hargamodal);
	
	$hargajual	= $_POST['hargajual'];
	$hargajual 	= str_replace("'","&pink;",$hargajual);
	
	$txtstok	= $_POST['txtstok'];
	$txtstok 	= str_replace("'","&pink;",$txtstok);
	
	$txtket	=$_POST['txtket'];
	$txtket 	= str_replace("'","&pink;",$txtket);
	
	$cmbkategori	=$_POST['cmbkategori'];
	
// Validasi form
	$pesanError = array();
	if (trim($txtnama)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> tidak boleh kosong !";		
	}	
	if (trim($hargamodal)==""  or ! is_numeric(trim($hargamodal))) {
		$pesanError[] = "Data <b>Harga Modal (Rp)</b> tidak boleh kosong !";		
	}
	if (trim($hargajual)==""  or ! is_numeric(trim($hargajual))) {
		$pesanError[] = "Data <b>Harga Jual (Rp)</b> tidak boleh kosong !";		
	}
	if (trim($txtstok)=="" or ! is_numeric(trim($txtstok))) {
		$pesanError[] = "Data <b>Stok</b>  tidak boleh kosong !";		
	}
	if (trim($txtket)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}
	if (trim($cmbkategori)=="KOSONG") {
		$pesanError[] = "Data <b>Kategori</b> belum dipilih !";		
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
		// Membaca Kode dari form
		$Kode	= $_POST['txtkode'];
		
		// Mengkopi file gambar
		if (trim($_FILES['namafile']['name']) =="") {
			$nama_file = $_POST['txtnamafile'];
		}
		else {
			// Jika file gambar lama ada, akan dihapus
			if(file_exists("../img-barang/".$_POST['txtnamafile'])) {
				unlink("../img-barang/".$_POST['txtnamafile']);	
			}
			
			// Mengkopi file gambar terbaru yang ditambahkan
			$nama_file = $_FILES['namafile']['name'];
			$nama_file = stripslashes($nama_file);
			$nama_file = str_replace("'","",$nama_file);

			$nama_file = $Kode.".".$nama_file;
			copy($_FILES['namafile']['tmp_name'],"../img-barang/".$nama_file);		
		}
		
		// Simpan hasil perubahan data
		$mySql	= "UPDATE barang SET
					nm_barang	= '$txtnama',
					harga_modal = '$hargamodal',
					harga_jual 	= '$hargajual',
					stok 		= '$txtstok',
					keterangan 	= '$txtket',
					file_gambar	= '$nama_file',
					kd_kategori = '$cmbkategori' WHERE kd_barang = '$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		if($myQry){
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
		}
	}	
} 

# ======================================================================
# MEMBACA DATA DARI FORM / DATABASE, UNTUK DITAMPILKAN KEMBALI PADA FORM
// Membaca data dari database, Sesuai kode yang dipilih dari Tampil Data (dikirim ke URL browser)
$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtkode'];
$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
$myData 	= mysql_fetch_array($myQry);

// Masukkan data ke variabel, untuk dibaca di form input
	$dataKode	    = $myData['kd_barang'];
	$dataNama	    = isset($_POST['txtnama']) ? $_POST['txtnama'] : $myData['nm_barang'];
	$dataHrgModal	= isset($_POST['hargamodal']) ? $_POST['hargamodal'] : $myData['harga_modal'];
	$dataHrgJual	= isset($_POST['hargajual']) ? $_POST['hargajual'] : $myData['harga_jual'];
	$dataStok	    = isset($_POST['txtstok']) ? $_POST['txtstok'] : $myData['stok'];  
	$dataKeterangan	= isset($_POST['txtket']) ? $_POST['txtket'] : $myData['keterangan']; 
	$dataKategori	= isset($_POST['cmbkategori']) ? $_POST['cmbkategori'] : $myData['kd_kategori'];		
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" target="_self">
  <table class="table-list" width="674" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col">Update Data Barang</th>
    </tr>
    <tr>
      <td>Nama Barang </td>
      <td><strong>:</strong></td>
      <td><input name="txtnama" value="<?php echo $dataNama; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td width="205">Kode</td>
      <td width="3">:</td>
      <td width="444"><label for="txtfield"></label>
      <input name="txtfield" type="text" id="txtfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/>
      <input name="txtkode" type="hidden" id="txtkode" value="<?php echo $dataKode; ?>" size="70" maxlength="100"></td>
    </tr>
    <tr>
      <td>Harga Modal (Rp)</td>
      <td>:</td>
      <td><label for="hargamodal"></label>
      <input name="hargamodal" type="text" id="hargamodal" value="<?php echo $dataHrgModal; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td>Harga Jual (Rp)</td>
      <td>:</td>
      <td><label for="hargajual"></label>
      <input name="hargajual" type="text" id="hargajual" value="<?php echo $dataHrgJual; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td>Stok</td>
      <td>:</td>
      <td><label for="txtstok"></label>
      <input name="txtstok" type="text" id="txtstok" value="<?php echo $dataStok; ?>" size="10" maxlength="4"></td>
    </tr>
    <tr>
      <td>File Gambar</td>
      <td>:</td>
      <td><label for="namafile"></label>
      <input name="namafile" type="file" id="namafile" size="50">
      <input type="hidden" name="txtnamafile" id="txtnamafile" /></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td>:</td>
      <td><label for="txtket"></label>
      <textarea name="txtket" id="txtket" cols="60" rows="5"><?php echo $dataKeterangan; ?></textarea></td>
    </tr>
    <tr>
      <td>Kategori</td>
      <td>:</td>
      <td><label for="cmbkategori"></label>
        <select name="cmbkategori" id="cmbkategori">
        <option value="KOSONG">....</option>
        <?php
		$mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query" .mysql_error());
		while ($myData = mysql_fetch_array($myQry)) {
			if ($myData['kd_kategori']== $dataKategori) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$myData[kd_kategori]' $cek> $myData[nm_kategori] </option>";
		  }
		  ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnsimpan" id="btnsimpan" value="SIMPAN"></td>
    </tr>
  </table>
</form>
