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

$colname_aportes = "-1";
if (isset($_GET['ids'])) {
  $colname_aportes = $_GET['ids'];
}

if ((isset($_GET['idae'])) && ($_GET['idae'] != "")) {
  $deleteSQL = sprintf("DELETE FROM aportes WHERE idAportes=%s",
                       GetSQLValueString($_GET['idae'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($deleteSQL, $cooperativa) or die(mysql_error());

  $deleteGoTo = "aportes_l.php";
 
  header(sprintf("Location: %s", $deleteGoTo));
}
$colname_aportes = "-1";
if (isset($_GET['ids'])) {
  $colname_aportes = $_GET['ids'];
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_aportes = sprintf("SELECT * FROM aportes WHERE idPersonal = %s order by fecha desc", GetSQLValueString($colname_aportes, "int"));
$aportes = mysql_query($query_aportes, $cooperativa) or die(mysql_error());
$row_aportes = mysql_fetch_assoc($aportes);
$totalRows_aportes = mysql_num_rows($aportes);

$colname_socio = "-1";
if (isset($_GET['ids'])) {
  $colname_socio = $_GET['ids'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_socio = sprintf("SELECT nombrePersonal, apellidoPersonal FROM personal WHERE idPersonal = %s", GetSQLValueString($colname_socio, "int"));
$socio = mysql_query($query_socio, $cooperativa) or die(mysql_error());
$row_socio = mysql_fetch_assoc($socio);
$totalRows_socio = mysql_num_rows($socio);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<h2>Hist&oacute;rico de Aportes de <?php echo $row_socio['apellidoPersonal']; ?> <?php echo $row_socio['nombrePersonal']; ?></h2>
<table border="1" cellpadding="0" cellspacing="0" class="display" id="example">
  <tr>
    <th height="23">Referencia</th>
    <th>N&ordm;</th>
    <th>Fecha</th>
    <th>Descripci&oacute;n</th>
    <th>Valor</th>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <?php $suma=0; do { ?>
    <tr>
      <td><?php echo $row_aportes['idAportes']; ?></td>
      <td><?php echo $row_aportes['numAporte']; ?></td>
      <td><?php echo $row_aportes['fecha']; ?></td>
      <td><?php echo $row_aportes['notas']; ?></td>
      <td><?php $suma=$suma+$row_aportes['valor']; echo $row_aportes['valor']; ?></td>
      <td><a href="aportes_u.php?ida=<?php echo $row_aportes['idAportes']; ?>"><img src="../images/b_edit.png" width="16" height="16" border="0" /></a></td>
      <td><a href="aportes_l.php?idae=<?php echo $row_aportes['idAportes']; ?>"><img src="../images/b_drop.png" width="16" height="16" border="0" /></a></td>
    </tr><?php } while ($row_aportes = mysql_fetch_assoc($aportes)); ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><?php echo $suma; ?>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
</table>
</body>
</html>
<?php
mysql_free_result($aportes);

mysql_free_result($socio);
?>
