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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_sociocredito = 10;
$pageNum_sociocredito = 0;
if (isset($_GET['pageNum_sociocredito'])) {
  $pageNum_sociocredito = $_GET['pageNum_sociocredito'];
}
$startRow_sociocredito = $pageNum_sociocredito * $maxRows_sociocredito;

mysql_select_db($database_cooperativa, $cooperativa);
$query_sociocredito = "SELECT idPersonal, codigoPersonal, cedulaPersonal, nombrePersonal, apellidoPersonal FROM personal";
$query_limit_sociocredito = sprintf("%s LIMIT %d, %d", $query_sociocredito, $startRow_sociocredito, $maxRows_sociocredito);
$sociocredito = mysql_query($query_limit_sociocredito, $cooperativa) or die(mysql_error());
$row_sociocredito = mysql_fetch_assoc($sociocredito);

if (isset($_GET['totalRows_sociocredito'])) {
  $totalRows_sociocredito = $_GET['totalRows_sociocredito'];
} else {
  $all_sociocredito = mysql_query($query_sociocredito);
  $totalRows_sociocredito = mysql_num_rows($all_sociocredito);
}
$totalPages_sociocredito = ceil($totalRows_sociocredito/$maxRows_sociocredito)-1;

$queryString_sociocredito = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_sociocredito") == false && 
        stristr($param, "totalRows_sociocredito") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_sociocredito = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_sociocredito = sprintf("&totalRows_sociocredito=%d%s", $totalRows_sociocredito, $queryString_sociocredito);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td align="right">&nbsp;
      <strong>Registros <?php echo ($startRow_sociocredito + 1) ?> a <?php echo min($startRow_sociocredito + $maxRows_sociocredito, $totalRows_sociocredito) ?> de <?php echo $totalRows_sociocredito ?></strong></td>
  </tr>
  <tr>
    <td><table align="center" cellpadding="2" cellspacing="2">
      <tr>
        <th bgcolor="#05619B">Socio</th>
        <th bgcolor="#05619B">C&oacute;digo </th>
        <th bgcolor="#05619B">Cedula</th>
        <th bgcolor="#05619B">Nombres y Apellidos</th>
        <td bgcolor="#05619B">&nbsp;</td>
      </tr>
      <?php do { ?>
      <tr>
        <td><?php echo $row_sociocredito['idPersonal']; ?></td>
        <td><?php echo $row_sociocredito['codigoPersonal']; ?></td>
        <td><?php echo $row_sociocredito['cedulaSocio']; ?></td>
        <td><?php echo $row_sociocredito['nombrePersonal']; ?> <?php echo $row_sociocredito['apellidoPersonal']; ?></td>
        <td><a href="credito.php?personal=<?php echo $row_credito['idCredito']; ?>">Cr&eacute;dito</a></td>
      </tr>
      <?php } while ($row_sociocredito = mysql_fetch_assoc($sociocredito)); ?>
    </table></td>
  </tr>
  <tr>
    <td height="46">
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_sociocredito > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_sociocredito=%d%s", $currentPage, 0, $queryString_sociocredito); ?>"><img src="First.gif" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_sociocredito > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_sociocredito=%d%s", $currentPage, max(0, $pageNum_sociocredito - 1), $queryString_sociocredito); ?>"><img src="Previous.gif" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_sociocredito < $totalPages_sociocredito) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_sociocredito=%d%s", $currentPage, min($totalPages_sociocredito, $pageNum_sociocredito + 1), $queryString_sociocredito); ?>"><img src="Next.gif" /></a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_sociocredito < $totalPages_sociocredito) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_sociocredito=%d%s", $currentPage, $totalPages_sociocredito, $queryString_sociocredito); ?>"><img src="Last.gif" /></a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($sociocredito);
?>
