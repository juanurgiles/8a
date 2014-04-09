<?php if (!isset($_SESSION)) {
  session_start();
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cajero</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #000;
}
#contenido {
	width: 700px;
	height: 600px;
	z-index: 1;
}
</style>
</head>

<body>
<table width="0%" border="3" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td bgcolor="#05619B"><table border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td align="center" bgcolor="#05619B"><img src="images/logo2.png" alt="" width="192" height="119" /></td>
        <td><img src="images/blank.gif" width="650" height="10" /><br />
          <img src="images/coop.png" alt="" width="539" height="109" /></td>
        </tr>
      <tr>
        <td bgcolor="#EEEEEE"></td>
        <td bgcolor="#FFFFFF"><h2><em>Men&uacute; del Cajero</em></h2></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#EEEEEE"><ul id="MenuBar1" class="MenuBarVertical">
          <li><a href="#" class="MenuBarItemSubmenu"><strong>Cliente</strong></a>
            <ul>
              <li><a href="Paginas/cuentas_l.php" target="contenido">Cuenta</a></li>
</ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu"><strong>Transacciones</strong></a>
            <ul>
              <li><a href="Paginas/transacciones.php?tipo=15" target="contenido">Dep&oacute;sito</a></li>
              <li><a href="Paginas/transacciones.php?tipo=16" target="contenido">Retiro</a></li>
            </ul>
          </li>
          <li><a href="Paginas/aportes_i.php" target="contenido"><strong>Aportes</strong></a></li>
          <li><a href="Paginas/creditos_lc.php" target="contenido"><strong>Cr&eacute;dito</strong>s</a>            </li>
          <li><a href="desconectar.php"><strong>Salir</strong></a></li>
        </ul></td>
        <td bgcolor="#FFFFFF"><iframe id="contenido" name="contenido" src="inicio.php">__</iframe></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
</tr>
</table>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>