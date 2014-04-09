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

$colname_planpagos = "-1";
if (isset($_GET['idc'])) {
  $colname_planpagos = $_GET['idc'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_planpagos = sprintf("SELECT * FROM planpagos WHERE idCredito = %s", GetSQLValueString($colname_planpagos, "int"));
$planpagos = mysql_query($query_planpagos, $cooperativa) or die(mysql_error());
$row_planpagos = mysql_fetch_assoc($planpagos);
$totalRows_planpagos = mysql_num_rows($planpagos);

mysql_select_db($database_cooperativa, $cooperativa);
$query_creditos = "select idCredito,tipoCredito,montototal,numeropagos,estado,fechaCredito,detalle,interes, concat(apellidoPersonal,' ',nombrePersonal) as cliente from creditos c inner join personal p  on p.idPersonal=c.idPersonal where idCredito=".$_GET['idc'];
$creditos = mysql_query($query_creditos, $cooperativa) or die(mysql_error());
$row_creditos = mysql_fetch_assoc($creditos);
$totalRows_creditos = mysql_num_rows($creditos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tabla de pagos</title>
</head>

<body>
<?php // print_r($_GET);  ?>
<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><strong>Cooperativa de Ahorro y Crédito 8 de Agosto</strong>
      <p>Credito de <?php echo $row_creditos['tipoCredito']; ?> No. <?php echo $row_creditos['idCredito']; ?>;</p>
      <p>Monto: <?php echo $row_creditos['montototal']; ?> al <?php echo $row_creditos['interes']; ?>%  anual</p>
      <p>Tiempo: <?php echo $row_creditos['numeropagos']; ?> meses</p>
      <p>Otorgado el: <?php echo substr($row_creditos['fechaCredito'],0,10); ?></p>
      <p>Cliente: <?php echo $row_creditos['cliente']; ?></p>
      <p>Destinaci&oacute;n: <?php echo $row_creditos['detalle']; ?></p>
      <table width="100%" border="1" align="center">
        <tr>
          <th>Num. Cuota</th>
          <th>Fecha</th>
          <th>Capital</th>
          <th>Interes</th>
          <th>Cuota</th>
          <th>Saldo</th>
        </tr>
        <?php do { ?>
        <tr align="center">
          <td><?php echo $row_planpagos['numCuota']; ?></td>
          <td><?php echo $row_planpagos['fecha']; ?></td>
          <td><?php echo $row_planpagos['capital']; ?></td>
          <td><?php echo $row_planpagos['interes']; ?></td>
          <td><?php echo $row_planpagos['cuota']; ?></td>
          <td><?php echo $row_planpagos['saldo']; ?></td>
        </tr>
        <?php } while ($row_planpagos = mysql_fetch_assoc($planpagos)); ?>
      </table>
      <p>
        <?php if (!isset($_GET['imp'])){ ?>
        <a href="creditos_rpt.php?idc=<?php echo $_GET['idc']; ?>&imp=1" target="_blank">Imprimir</a>
        <?php } ?>
    </p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($planpagos);

mysql_free_result($creditos);
?>
