<?php require_once('../Connections/cooperativa.php'); ?>
<?php if (!isset($_SESSION)) {
  session_start();
}?>
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

$colname_credito = "-1";
if (isset($_GET['personal'])) {
  $colname_credito = $_GET['personal'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_credito = sprintf("SELECT * FROM creditos WHERE idPersonal = %s", GetSQLValueString($colname_credito, "int"));
$credito = mysql_query($query_credito, $cooperativa) or die(mysql_error());
$row_credito = mysql_fetch_assoc($credito);
$totalRows_credito = mysql_num_rows($credito);
 if (!isset($_SESSION)) {
  session_start();
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<table border="1">
  <tr>
    <td>Crédito</td>
    <td>Detalle</td>
    <td>Monto Total</td>
    <td>N&uacute;mero pagos</td>
    <td>Personal</td>
    <td>interes</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_credito['idCredito']; ?></td>
      <td><?php echo $row_credito['detalle']; ?></td>
      <td><?php echo $row_credito['montototal']; ?></td>
      <td><?php echo $row_credito['numeropagos']; ?></td>
      <td><?php echo $row_credito['idPersonal']; ?></td>
      <td><?php echo $row_credito['interes']; ?></td>
    </tr>
    <?php } while ($row_credito = mysql_fetch_assoc($credito)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($credito);
?>
