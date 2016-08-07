<style type="text/css">
.NAMAPROVINSI {
	text-align: right;
	font-size: 24px;
	
}
.NAMAPROVINSI td {
	font-size: 27px;
	font-weight: bold;
}
.NoNamaBiayaKirimTools {
	color: #FCF;
}
</style>
<table width="700" border="0" cellspacing="1" cellpadding="3" class="table-border">
  <tr class="NAMAPROVINSI">
    <td>Nama Provinsi</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="?open=Provinsi-Add" target="_self"><img src="../images/btn_add_data.png" alt="Tambah data provinsi" name="btnadd" width="59" height="22" id="btnadd"></a></td>
  </tr>
  <tr>
    <td><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr bgcolor="#FFCCCC">
        <td width="10%" scope="col"><strong>No</strong></td>
        <td width="51%" scope="col"><strong>Nama</strong></td>
        <td width="24%" align="right" scope="col"><strong>Biaya Kirim (Rp)</strong></td>
        <td colspan="2" align="center" scope="col"><strong>Tools</strong></td>
        </tr>
     <?php
	$mySql = "SELECT * FROM provinsi ORDER BY nm_provinsi ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_provinsi'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['nm_provinsi']; ?></td>
        <td align="right"><?php echo format_angka($myData['biaya_kirim']); ?></td>
        <td width="7%" align="center"><a href="?open=Provinsi-Edit&Kode=<?php echo $Kode; ?>" target="_self"><img src="../images/b_edit.png" width="16" height="16" alt="edit" /></a></td>
        <td width="8%" align="center"><a href="?open=Provinsi-Delete&Kode=<?php echo $Kode; ?>" target="_self" onClick="return confirm ('Yakin ingin menghapus data Provinsi ini..?')"><img src="../images/hapus.gif" width="16" height="16" alt="hapus" /></a></td>
      </tr>
	  <?php } ?>
    </table></td>
  </tr>
</table>
