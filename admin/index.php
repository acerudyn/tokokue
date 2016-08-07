<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ADMINISTRATOR</title>
<link href="../style/button.css" rel="stylesheet" type="text/css">
<link href="../style/style_admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../plugins/calendar/tcal.css" />
<script type="text/javascript" src="../plugins/calendar/tcal.js"></script> 
<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>
<style type="text/css">
body {
	background-color: #FFD7EB;
	font-size: 18px;
	background-image: url(../images/12-42-59-LS71500L__89016.jpg);
	background-repeat: repeat;
}
</style>
</head>
<div id="wrap">
<body>
<table width="1000" height="786" align="center"  class="table-main">
  <tr>
    <td height="175" colspan="2"><a href="?open">
      <img src="../images/headerelfia.png" width="1020" height="199"alt="logo"
    </a></td>
  </tr>
  <tr valign="top">
    <td width="251"  style="border-right:3px solid #DDDDDD; border-color: #300;"><div style="margin:5px; padding:5px; font-size: 18px;">
	<?php include "menu.php";?> </div></td>
    <td width="1149" height="600"><div style="margin:20px; padding:30px; color: #F06; font-family: Perpetua;">
	<?php include "buka_file.php";?>
    </div></td>
  </tr>
</table>
</body>
</div>
</html>
