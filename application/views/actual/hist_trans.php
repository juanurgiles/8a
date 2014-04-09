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

$maxRows_retiro = 10;
$pageNum_retiro = 0;
if (isset($_GET['pageNum_retiro'])) {
  $pageNum_retiro = $_GET['pageNum_retiro'];
}
$startRow_retiro = $pageNum_retiro * $maxRows_retiro;

mysql_select_db($database_cooperativa, $cooperativa);
$query_retiro = "SELECT * FROM transacciones where numeroCuenta=".$_GET['idc'];
$query_limit_retiro = sprintf("%s LIMIT %d, %d", $query_retiro, $startRow_retiro, $maxRows_retiro);
$retiro = mysql_query($query_limit_retiro, $cooperativa) or die(mysql_error());
$row_retiro = mysql_fetch_assoc($retiro);

if (isset($_GET['totalRows_retiro'])) {
  $totalRows_retiro = $_GET['totalRows_retiro'];
} else {
  $all_retiro = mysql_query($query_retiro);
  $totalRows_retiro = mysql_num_rows($all_retiro);
}
$totalPages_retiro = ceil($totalRows_retiro/$maxRows_retiro)-1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<h1>Histórico de Transacciones</h1>
<?php if(isset($_GET['idc'])){ ?>
<table border="1">
  <tr>
    <td>Transacci&oacute;n</td>
    <td>N&uacute;mero Cuenta</td>
    <td>C&oacute;digo Transacci&oacute;n</td>
    <td>Usuario</td>
    <td>Fecha</td>
    <td>Monto Transacci&oacute;n</td>
    <td>Saldo Disponible</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_retiro['idTransaccion']; ?></td>
      <td><?php echo $row_retiro['numeroCuenta']; ?></td>
      <td><?php echo $row_retiro['codigoTransaccion']; ?></td>
      <td><?php echo $row_retiro['idUsuario']; ?></td>
      <td><?php echo $row_retiro['fecha']; ?></td>
      <td><?php echo $row_retiro['montoTransaccion']; ?></td>
      <td><?php echo $row_retiro['saldoDisponible']; ?></td>
    </tr>
    <?php } while ($row_retiro = mysql_fetch_assoc($retiro)); ?>
</table> 
<?php } ?>
</body>
</html>
<?php
mysql_free_result($retiro);

?>
