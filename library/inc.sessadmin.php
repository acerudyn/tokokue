<?php
if(empty($_SESSION['SES_ADMIN'])) {
	echo "<center>";
	echo "<br> <br> <b>Maaf Akses Anda Tidak Dapat DiProses!</b> <br>
		  Masukkan Data Login Anda Dengan Benar Untuk Dapat Mengakses Halaman Ini. Terima Kasih.";
	echo "</center>";
	include_once "login.php";
	exit;
}
?>