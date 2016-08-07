<?php
# JIKA DIKENALI YANG LOGIN ADMIN
if(isset($_SESSION['SES_ADMIN'])){
?>
<style type="text/css">
.login {
	font-size: 24px;
	font-family: Perpetua;
}
.login {
	font-weight: bold;
}
</style>
<ul>
	<p><img src="../images/teddy_bear-128.png" alt="logo" width="15" height="16" align="absmiddle" /><a href='?open' title='Halaman Utama'>Halaman Utama</a></p>
	<p><img src="../images/teddy_bear-128.png" alt="logo" width="15" height="16" align="absmiddle" /><a href='?open=Data' title='Data Jualan' target="_self">Data-Data</a></p>
	<p><img src="../images/teddy_bear-128.png" alt="logo" width="15" height="16" align="absmiddle" /><a href='?open=Pemesanan-Barang' title='Pemesanan Barang' target="_self">Pemesanan Barang</a></p>
	<p><img src="../images/teddy_bear-128.png" alt="logo" width="15" height="16" align="absmiddle" /><a href='?open=Konfirmasi-Bayar' title='Konfirmasi Pembayaran' target="_self">Konfirmasi Pembayaran</a></p>
	<p><img src="../images/teddy_bear-128.png" alt="logo" width="15" height="16" align="absmiddle" /><a href='?open=Laporan' title='Laporan' target="_self">Laporan - Laporan</a></p>
	<p><img src="../images/teddy_bear-128.png" alt="logo" width="15" height="16" align="absmiddle" /><a href='?open=Password-Adm' title='Password Adm'>Password Admin</a></p>
	<p><img src="../images/teddy_bear-128.png" alt="logo" width="15" height="16" align="absmiddle" /><a href='?open=Logout' title='Logout (Exit)'>Logout</a></p>

</ul>
<?php
} 
else {
	
// JIKA BELUM ADA YANG LOGIN
?>
<ul>
<a href='?open=Login' title='Login' target="_self" class="login"><img src="../images/teddy_bear-128.png" alt="logo" width="17" height="17" align="texttop" /><span class="login"><strong>Log-in</strong></span></a> 
  </ul>
<?php } ?>