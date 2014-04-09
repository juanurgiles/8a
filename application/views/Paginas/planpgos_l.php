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

if ((isset($_GET['idppe'])) && ($_GET['idppe'] != "")) {
  $deleteSQL = sprintf("DELETE FROM planpagos WHERE idPlanPago=%s",
                       GetSQLValueString($_GET['idppe'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($deleteSQL, $cooperativa) or die(mysql_error());

  $deleteGoTo = "planpgos_l.php";
 
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_planpagos = "SELECT * FROM planpagos";
$planpagos = mysql_query($query_planpagos, $cooperativa) or die(mysql_error());
$row_planpagos = mysql_fetch_assoc($planpagos);
$totalRows_planpagos = mysql_num_rows($planpagos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Listar Plan de Pagos</title>
</head>

<body>
<h1>Listar Plan de Pagos </h1>
<table border="1" class="display" id="example">
  <tr>
    <th>Plan Pago</th>
    <th>Credito</th>
    <th>Fecha</th>
    <th>Cuota</th>
    <th>Valor</th>
    <th>Interes</th>
    <th>Notas</th>
    <td colspan="2" align="center"><a href="planpgos_i.php">Ingresar</a></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_planpagos['idPlanPago']; ?></td>
      <td><?php echo $row_planpagos['idCredito']; ?></td>
      <td><?php echo $row_planpagos['fecha']; ?></td>
      <td><?php echo $row_planpagos['cuota']; ?></td>
      <td><?php echo $row_planpagos['valor']; ?></td>
      <td><?php echo $row_planpagos['interes']; ?></td>
      <td><?php echo $row_planpagos['notas']; ?></td>
      <td><a href="planpgos_u.php?idpp=<?php echo $row_planpagos['idPlanPago']; ?>">Editar</a></td>
      <td><a href="planpgos_l.php?idppe=<?php echo $row_planpagos['idPlanPago']; ?>">Eliminar</a></td>
    </tr>
    <?php } while ($row_planpagos = mysql_fetch_assoc($planpagos)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($planpagos);
?>
