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

if ((isset($_GET['idrpe'])) && ($_GET['idrpe'] != "")) {
  $deleteSQL = sprintf("DELETE FROM registropagos WHERE idRegistroPagos=%s",
                       GetSQLValueString($_GET['idrpe'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($deleteSQL, $cooperativa) or die(mysql_error());

  $deleteGoTo = "registropagos_l.php";
 
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_registropagos = "SELECT * FROM registropagos";
$registropagos = mysql_query($query_registropagos, $cooperativa) or die(mysql_error());
$row_registropagos = mysql_fetch_assoc($registropagos);
$totalRows_registropagos = mysql_num_rows($registropagos);
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
    <td>Registro Pagos</td>
    <td>Plan Pago</td>
    <td>Fecha Pago</td>
    <td>Monto</td>
    <td>Valor Interes</td>
    <td>Interes Mora</td>
    <td>Valor Mora</td>
    <td>Notas</td>
    <td>MontoRecibido</td>
    <td colspan="2"><a href="registropagos_i.php">Insertar</a></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_registropagos['idRegistroPagos']; ?></td>
      <td><?php echo $row_registropagos['idPlanPago']; ?></td>
      <td><?php echo $row_registropagos['fechaPago']; ?></td>
      <td><?php echo $row_registropagos['montopago']; ?></td>
      <td><?php echo $row_registropagos['valorInteres']; ?></td>
      <td><?php echo $row_registropagos['interesMora']; ?></td>
      <td><?php echo $row_registropagos['valorMora']; ?></td>
      <td><?php echo $row_registropagos['notas']; ?></td>
      <td><?php echo $row_registropagos['montoRecibido']; ?></td>
      <td><a href="registropagos_u.php?idrp=<?php echo $row_registropagos['idRegistroPagos']; ?>">Editar</a></td>
      <td><a href="registropagos_l.php?idrpe=<?php echo $row_registropagos['idRegistroPagos']; ?>">Eliminar</a></td>
    </tr>
    <?php } while ($row_registropagos = mysql_fetch_assoc($registropagos)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($registropagos);
?>
