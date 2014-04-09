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

if ((isset($_GET['idce'])) && ($_GET['idce'] != "")) {
  $deleteSQL = sprintf("DELETE FROM cuenta WHERE idCuenta=%s",
                       GetSQLValueString($_GET['idce'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($deleteSQL, $cooperativa) or die(mysql_error());

  $deleteGoTo = "cuenta_socio.php";
 
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_cuenta = 10;
$pageNum_cuenta = 0;
if (isset($_GET['pageNum_cuenta'])) {
  $pageNum_cuenta = $_GET['pageNum_cuenta'];
}
$startRow_cuenta = $pageNum_cuenta * $maxRows_cuenta;

mysql_select_db($database_cooperativa, $cooperativa);
$query_cuenta = "SELECT * FROM cuenta";
$query_limit_cuenta = sprintf("%s LIMIT %d, %d", $query_cuenta, $startRow_cuenta, $maxRows_cuenta);
$cuenta = mysql_query($query_limit_cuenta, $cooperativa) or die(mysql_error());
$row_cuenta = mysql_fetch_assoc($cuenta);

if (isset($_GET['totalRows_cuenta'])) {
  $totalRows_cuenta = $_GET['totalRows_cuenta'];
} else {
  $all_cuenta = mysql_query($query_cuenta);
  $totalRows_cuenta = mysql_num_rows($all_cuenta);
}
$totalPages_cuenta = ceil($totalRows_cuenta/$maxRows_cuenta)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<table border="1">
  <tr>
    <td>Cuenta</td>
    <td>Tipo Cuenta</td>
    <td>N&uacute;mero Cuenta</td>
    <td>Estado</td>
    <td>Saldo</td>
    <td colspan="2"><a href="cuenta_socio_i.php">Insertar</a></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_cuenta['idCuenta']; ?></td>
      <td><?php echo $row_cuenta['tipoCuenta']; ?></td>
      <td><?php echo $row_cuenta['numeroCuenta']; ?></td>
      <td><?php echo $row_cuenta['estado']; ?></td>
      <td><?php echo $row_cuenta['saldo']; ?></td>
      <td><a href="cuenta_socio_u.php?idc=<?php echo $row_cuenta['idCuenta']; ?>">Editar</a></td>
      <td><a href="cuenta_socio.php?idce=<?php echo $row_cuenta['idCuenta']; ?>">Eliminar</a></td>
    </tr>
    <?php } while ($row_cuenta = mysql_fetch_assoc($cuenta)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($cuenta);
?>
