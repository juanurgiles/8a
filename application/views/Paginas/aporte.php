<?php require_once('../Connections/cooperativa.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_aportes = "SELECT idSocio, codigoSocio, cedulaSocio, nombreSocio, apellidoSocio FROM socios";
$aportes = mysql_query($query_aportes, $cooperativa) or die(mysql_error());
$row_aportes = mysql_fetch_assoc($aportes);
$totalRows_aportes = mysql_num_rows($aportes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Aportes del Mes</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td colspan="2"><h1>Aportes del Mes</h1></td>
    </tr>
    <tr>
      <td width="11%">&nbsp;</td>
      <td width="89%">&nbsp;
        <table border="1">
          <tr>
            <th>Código</th>
            <th>Nombre </th>
            <td>&nbsp;</td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_aportes['codigoSocio']; ?></td>
              <td><?php echo $row_aportes['nombreSocio']; ?><?php echo $row_aportes['apellidoSocio']; ?></td>
              <td><a href="aportemes.php?ids=<?php echo $row_aportes['idSocio']; ?>">Aporte</a></td>
            </tr>
            <?php } while ($row_aportes = mysql_fetch_assoc($aportes)); ?>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($aportes);
?>
