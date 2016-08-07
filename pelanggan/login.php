<style type="text/css">
.keterangan {
	font-size: 10px;
}
an {
	font-size: 12px;
}
.ket {
	font-weight: bold;
}
.ket {
	font-size: 14px;
}
</style>
<title>Elfia Bakery</title>
<form action="?open=Login-Validasi" method="post" name="form1" target="_self">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
 <?php
if (! isset($_SESSION['SES_PELANGGAN'])) {
// Jika belum Login, maka form Login ditampilkan
?>
    <tr>
      <td colspan="3" bgcolor="#F2EAD9"><img src="../images/Screenshot_2015-04-09-10-23-55_1428562625544.jpg" width="83" height="25" alt="login" /></td>
    </tr>
    <tr>
      <td width="9%">Username</td>
      <td width="1%">&nbsp;</td>
      <td width="90%"><input name="txtuser" type="text" id="txtuser" size="20" maxlength="30">
      </td>
    </tr>
    <tr>
      <td>Password</td>
      <td>&nbsp;</td>
      <td><input name="txtpass" type="password" id="txtpass" size="20" maxlength="30">   
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Login" id="Login" value="Masuk"></td>
    </tr>
    <tr>
      <td colspan="3">Belum jadi member? Klik [<a href="?open=Pelanggan-Baru" target="_self" title='Daftar Pelanggan'>SIGN UP]</a></td>
    </tr>
 <?php 
}
else{
//jika sudah login maka menu pelanggan tidak akan muncul
 ?>
    <tr>
      <td colspan="3" bgcolor="#FF9999"><strong>TRANSAKSI</strong></td>
    </tr>
    <tr>
      <td colspan="3"><a href="?open=Keranjang-Belanja">Keranjang Belanja<img src="../images/Screenshot_2015-04-09-10-23-55_1428562581949.jpg" width="23" height="19" align="top" /></a></td>
    </tr>
    <tr>
      <td colspan="3" valign="middle"><a href="?open=Transaksi-Tampil">Status Order <img src="../images/os.jpg" alt="cek" width="21" height="18" align="top" /></a></td>
    </tr>
    <tr>
      <td colspan="3"><a href="logout.php" title='Keluar'>Keluar</a></td>
    </tr>
    <tr bgcolor="#FF6666">
      <td colspan="3" bgcolor="#FF9999"><strong>PILIH BANK</strong></td>
    </tr>
    <tr>
      <td><img src="../images/BCA.gif" alt="bca" width="51" height="22" align="top" /></td>
      <td>:</td>
      <td height="33"> 000000000</td>
    </tr>
    <tr>
      <td><img src="../images/BNI.gif" alt="bni" width="48" height="15" align="absbottom" /></td>
      <td>:</td>
      <td height="33">  000000000</td>
    </tr>
    <tr>
      <td><img src="../images/Screenshot_2015-02-04-15-37-13_1423040382830.jpg" alt="mandiri" width="53" height="22" align="top" /></td>
      <td>:</td>
      <td height="34"> 000000000</td>
    </tr>
    <tr>
      <td colspan="3" class="ket">Semua An. Elfia Bakery</td>
    </tr>
    <tr>
      <td colspan="3" class="keterangan">*Pilih salah satu untuk transfer pembayaran</td>
    </tr>
<?php } ?>
  </table>
</form>
