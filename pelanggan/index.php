<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ELFIA BAKERY</title>
<link rel="shortcut icon" href="../images/Baby-teddy-bear-512.png" type="image/x-icon">

<meta name="robots" content="index, follow">
<meta name="description" content="ELFIA BAKERY adalah online shop yang menjual berbagai macam cake tentunya kualitas serta pelayanan kami tidak akan mengecewakan">
<meta name="keywords" content="butter cake, sponge cake, swissroll dan lainnya">
<style type="text/css">
body {
	background-image: url(../images/elfia.png);
	background-repeat: repeat;
}
menu {
	font-family: Papyrus;
}
body {
	font-size: 18px;
	font-family: Perpetua;
	color: #300;
	//background-image: url(../images/wallpaper.jpg);
}
headera {
	color: #300;
}
inpo {
	font-size: 14px;
}
tdinpo {
	font-size: 14px;
}
.txtcari {
	background-color: #FFC;
}
</style>
</head>

<body>
<span class="background"></span>
<table width="1020" border="0" align="center" cellpadding="3" cellspacing="1" class="a">
  <tr>
    <td height="24" colspan="2"><marquee>
    <a href="?open=Profil"></a>Alamat Toko: Jalan Raya Narogong Km. 7 Bojong Menteng Rt.003/01 No. 17, Bekasi Timur -17177 . <img src="../images/Viber-logo.jpeg" alt="telp" width="17" height="15" align="texttop">Handphone
    082168038388
    </marquee></td>
  </tr>
  <tr valign="top" class="Menudata">
    <td height="32" colspan="2" align="right"><form action="?open=Barang-Pencarian" method="post" name="form1" target="_self">
      <a href="?open=Home" title='Home'><span class="Home">HOME </span></a>|
      Search
      <label for="keyword"></label>
      <input name="keyword" type="text" id="keyword" size="30" maxlength="100">
      <input type="submit" name="btncari" id="btncari" value="Go">
    </form></td>
  </tr>
  <tr>
    <td height="199" colspan="2"><img src="../images/headerelfia.png" width="1016" height="199" alt="logo"></td>
  </tr>
  <tr valign="top" class="Menudata">
    <td colspan="2"><img src="../images/garis.jpg" width="1016" height="27" alt="garis"></td>
  </tr>
  <tr valign="top" class="Menudata">
    <td width="236"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr bgcolor="#FFCCCC">
        <td height="24" bgcolor="#FFCCCC"><strong> Kontak Kami</strong></td>
      </tr>
      <tr>
        <td height="49" align="left"><img src="../images/Logo-BBM_Blackberry-Messenger.png" alt="bbm" width="38" height="30" align="absmiddle"> Pin BBM  : 532F582A</td>
      </tr>
      <tr>
        <td height="44" align="left"><img src="../images/whatsapp-logo-vectorline-for-pc-free-download--windows-78xp-computer----temcam-bkrxkxbk.jpg" alt="line" width="31" height="26" hspace="2" align="absmiddle"> Line     : Elfiabakery</td>
      </tr>
      <tr>
        <td height="44" align="left"><img src="../images/WhatsApp-Logo.png" alt="wa" width="38" height="34" align="absmiddle">WA : 085891116910    </td>
      </tr>
      <tr>
        <td height="24" align="left"><img src="../images/Mail-icon.png" alt="mail" width="39" height="35" align="absmiddle"> elfiabakery@gmail.com</td>
      </tr>
      <tr bgcolor="#FFCCCC">
        <td bgcolor="#FFCCCC"><strong>Follow Kami</strong></td>
      </tr>
      <tr>
        <td height="31"><p><img src="../images/facebook_logo.jpg" alt="fb" width="34" height="30" align="absmiddle"> Facebook : Elfia Bakery</p></td>
      </tr>
      <tr>
        <td> <?php 
		if (file_exists ("login.php"))
		{ include "login.php"; }
		else { echo "file login.php belum ada"; }
		 ?> </td>
      </tr>
      <tr bgcolor="#FFCCCC">
        <td height="20" valign="middle" bgcolor="#FF6699"><strong> Kategori</strong></td>
      </tr>
      <?php
		  $mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
		  $myQry = mysql_query($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
		  while($myData = mysql_fetch_array($myQry)) {
		  	$Kode = $myData['kd_kategori'];
		  ?>
            <tr>
              <td width="8%"><img src="../images/cake.jpg" width="9" height="9"><b><?php echo "<a href=?open=Barang-Kategori&Kode=$Kode>$myData[nm_kategori]</a>"; ?></b></td>
            </tr>
            <?php
		  }
		  ?>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="769" valign="top"> <?php include "buka_file.php"; ?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFCC">
    <td height="44" colspan="2" align="center" bgcolor="#FFF0FF" class="FOOT">&copy; 2016 All rights reserved by ELFIA BAKERY<br>
  Penjualan Cake</td>
  </tr>
</table>
</body>
</html>