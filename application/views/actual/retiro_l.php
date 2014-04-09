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
$query_retiro = "SELECT * FROM transacciones where numeroCuenta=".$_POST['cuenta'];
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

mysql_select_db($database_cooperativa, $cooperativa);
$query_cuentas = "SELECT idCuenta, numeroCuenta FROM cuenta ORDER BY numeroCuenta ASC";
$cuentas = mysql_query($query_cuentas, $cooperativa) or die(mysql_error());
$row_cuentas = mysql_fetch_assoc($cuentas);
$totalRows_cuentas = mysql_num_rows($cuentas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<h1>Histórico de Transacciones</h1>
<form id="form1" name="form1" method="post" action="">
  <p>
    <select name="cuenta" id="cuenta">
      <?php
do {  
?>
      <option value="<?php echo $row_cuentas['idCuenta']?>"><?php echo $row_cuentas['numeroCuenta']?></option>
      <?php
} while ($row_cuentas = mysql_fetch_assoc($cuentas));
  $rows = mysql_num_rows($cuentas);
  if($rows > 0) {
      mysql_data_seek($cuentas, 0);
	  $row_cuentas = mysql_fetch_assoc($cuentas);
  }
?>
    </select>
    <input type="submit" name="button" id="button" value="Enviar" />
  </p>
</form>
<?php if(isset($_POST['cuenta'])){ ?><table border="1">
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

mysql_free_result($cuentas);
?>
