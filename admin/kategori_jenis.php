<style type="text/css">
.jeniskategori {
	font-size: 27px;
	text-align: right;
	font-weight: bold;
}
</style>
<table width="700" border="0" cellspacing="1" cellpadding="3" class="table-border">
  <tr>
    <td class="jeniskategori">Jenis Kategori</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="?open=Kategori-Add" target="_self"><img src="../images/btn_add_data.png" width="58" height="22" alt="addkategori"></a></td>
  </tr>
  <tr>
    <td><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr bgcolor="#FFCCCC">
        <td width="8%" align="center" scope="col"><strong>No</strong></td>
        <td width="75%" scope="col"><strong>Nama Kategori</strong></td>
        <td colspan="2" align="center" scope="col"><strong>Tools</strong></td>
        </tr>
        <?php
		$mySql = "SELECT * FROM kategori ORDER BY nm_kategori ASC";
		$myQry = mysql_query ($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
		$nomor = 0;
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData ['kd_kategori'];
		?>
      <tr>
        <td align="center"> <?php echo $nomor; ?></td>
        <td> <?php echo $myData['nm_kategori']; ?></td>
        <td width="8%" align="center"><a href="?open=Kategori-Edit&Kode=<?php echo $Kode; ?>" target="_self"><img src="../images/b_edit.png" width="16" height="16" alt="edit" /></a></td>
        <td width="8%" align="center"><a href="?open=Kategori-Delete&Kode=<?php echo $Kode; ?>" target="_self" onClick="return confirm('Yakin ingin menghapus jenis kategori ini..?')"><img src="../images/hapus.gif" width="16" height="16" alt="hapus" /></a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
</table>
