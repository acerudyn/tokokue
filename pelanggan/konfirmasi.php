<?php
include_once "../pelanggan/inc.session.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";


//skrip untuk mengatur nilai dasar pada form
# Rekam data jika form kosong
$dataNopemesan  	= isset($_POST['nopemesan']) ? $_POST['nopemesan'] : '';
$dataNama			= isset($_POST['txtnama']) ? $_POST['txtnama'] : '';
$dataJumlahTransfer	= isset($_POST['txtjml']) ? $_POST['txtjml'] : '';
$dataBank       	= isset($_POST['cmbbank']) ? $_POST['cmbbank'] : '-pilih-';
$dataKeterangan 	= isset($_POST['txtket']) ? $_POST['txtket'] : '';

// Tombol klik simpan
if(isset($_POST['btnsave'])){


// Baca variabel form
	$nopemesan  	= $_POST['nopemesan'];
	$nopemesan  	= str_replace("'","&pink;",$nopemesan);
	
	$txtnama		= $_POST['txtnama'];
	$txtnama 		= str_replace("'","&pink;",$txtnama);
	
	$txtjml		    = $_POST['txtjml'];
	$txtjml 		= str_replace(".","",$txtjml); // Menghilangkan karakter titik (10.000 jadi 10000)
	$txtjml 		= str_replace(",","",$txtjml); // Menghilangkan karakter koma (10,000 jadi 10000)
	$txtjml 		= str_replace(" ","",$txtjml); // Menghilangkan karakter kosong (10 000 jadi 10000)
	
	$cmbbank	    = $_POST['cmbbank'];
	$cmbbank     	= str_replace("'","&pink;",$cmbbank);
	
	$txtket	        = $_POST['txtket'];
	$txtket     	= str_replace("'","&pink;",$txtket);
	
// pesan eror
	$pesanError = array();
	if (trim($nopemesan)=="") {
		$pesanError[] = "Data <b>No. Pemesanan</b>  masih kosong, isi sesuai dengan <b>No. Pemesanan</b> Anda";
	}
	if (trim($txtnama)=="") {
		$pesanError[] = "Data <b>Nama Penerima</b>  masih kosong, isi sesuai nama akun Anda";
	}
	if (trim($txtjml)=="" or ! is_numeric(trim($txtjml))) {
		$pesanError[] = "Data <b> Jumlah yang ditransfer (Rp)</b> masih kosong, dan <b> harus ditulis angka </b>";
	}
		if (trim($cmbbank) =="KOSONG") {
		$pesanError[] = "Pilihan <b>Bank</b> belum dipilih";
	}
	if (trim($txtket)=="") {
		$pesanError[] = "Data <b> Keterangan </b> masih kosong";
	}

	//jika ada eror maka muncul pesan
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
		//Jika tidak menemukan pesan error, simpan data ke database
		// Membuat tanggal
		$tanggal	= date('Y-m-d');
		
		// Simpan data ke database
		$mySql = "INSERT INTO konfirmasi (no_pemesanan, nm_pelanggan, jumlah_transfer, bank, keterangan, tanggal) 
				  VALUES ('$nopemesan', '$txtnama', '$txtjml', '$cmbbank', '$txtket', '$tanggal')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		echo "<center><b> SUKSES ... KONFIRMASI SUDAH DIKIRIM KEPADA PAGE ADMIN. TERIMAKASIH TELAH BERBELANJA DI TOKO KAMI. </b></center>";
		echo "<meta http-equiv='refresh' content='2; url=?open=Barang'>";
		exit;
	}	
}// End if($_POST) 

?>
<style type="text/css">
.ket {
	font-size: 10px;
}
</style>



<title>Elfia Bakery</title>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="83%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" align="center" bgcolor="#FF6699"><strong>KONFIRMASI PEMBAYARAN</strong></td>
    </tr>
    <tr>
      <td width="56%">No Pemesanan</td>
      <td width="1%">:</td>
      <td width="43%"> <label for="nopemesan"></label>
      <input name="nopemesan" type="text" id="nopemesan" value="<?php echo $dataNopemesan; ?>" size="20" maxlength="20"></td>
    </tr>
    <tr>
      <td>Nama Penerima</td>
      <td>:</td>
      <td><label for="txtnama"></label>
      <input name="txtnama" type="text" id="txtnama" value="<?php echo $dataNama; ?>" size="50" maxlength="100"></td>
    </tr>
    <tr>
      <td>Jumlah Transfer (Rp)</td>
      <td>:</td>
      <td><label for="txtjml"></label>
      <input name="txtjml" type="text" id="txtjml" value="<?php echo $dataJumlahTransfer; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td>Pilihan Bank</td>
      <td>:</td>
      <td>
        <p>
          <select name="cmbbank" id="cmbbank">
            <option value="KOSONG">....</option>
            <?php
		$pilihan = array("BCA", "BNI", "MANDIRI");
		foreach ($pilihan as $nilai) {
			if ($nilai == $dataBank) {
				$cek=" selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek>$nilai</option>";
		}
		?>
          </select>
      </p></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td>:</td>
      <td><p>
        <label for="txtket"></label>
        <textarea name="txtket" cols="40" rows="3" id="txtket"><?php echo $dataKeterangan; ?></textarea>
      </p>
      <p class="ket">*Tambahkan keterangan tanggal, nama bank dan atas nama rekening yang anda pakai pada saat Transfer. untuk mempermudah pengecekan dan tidak terjadi kesalahan data. Terimakasih.</p></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><input type="submit" name="btnsave" id="btnsave" value="Simpan &amp; Kirim"></td>
    </tr>
  </table>
</form>
