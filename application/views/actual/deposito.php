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

if ((isset($_GET['idae'])) && ($_GET['idae'] != "")) {
  $deleteSQL = sprintf("DELETE FROM aportes WHERE idAportes=%s",
                       GetSQLValueString($_GET['idae'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($deleteSQL, $cooperativa) or die(mysql_error());

  $deleteGoTo = "deposito.php";
  
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_deposito = 10;
$pageNum_deposito = 0;
if (isset($_GET['pageNum_deposito'])) {
  $pageNum_deposito = $_GET['pageNum_deposito'];
}
$startRow_deposito = $pageNum_deposito * $maxRows_deposito;

mysql_select_db($database_cooperativa, $cooperativa);
$query_deposito = "SELECT * FROM aportes";
$query_limit_deposito = sprintf("%s LIMIT %d, %d", $query_deposito, $startRow_deposito, $maxRows_deposito);
$deposito = mysql_query($query_limit_deposito, $cooperativa) or die(mysql_error());
$row_deposito = mysql_fetch_assoc($deposito);

if (isset($_GET['totalRows_deposito'])) {
  $totalRows_deposito = $_GET['totalRows_deposito'];
} else {
  $all_deposito = mysql_query($query_deposito);
  $totalRows_deposito = mysql_num_rows($all_deposito);
}
$totalPages_deposito = ceil($totalRows_deposito/$maxRows_deposito)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dep&oacute;sito</title>
</head>

<body>
<table border="1">
  <tr>
    <td align="center"><strong>Dep&oacute;sito</strong></td>
    <td align="center"><strong>Fecha </strong></td>
    <td align="center"><strong>Socio</strong></td>
    <td align="center"><strong>Valor</strong></td>
    <td align="center"><a href="deposito_i.php">Insertar</a></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_deposito['idAportes']; ?></td>
      <td><?php echo $row_deposito['fecha']; ?></td>
      <td><?php echo $row_deposito['idSocio']; ?></td>
      <td><?php echo $row_deposito['valor']; ?></td>
      <td><a href="deposito.php?idae=<?php echo $row_deposito['idAportes']; ?>">Eliminar</a></td>
    </tr>
    <?php } while ($row_deposito = mysql_fetch_assoc($deposito)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($deposito);
?>
