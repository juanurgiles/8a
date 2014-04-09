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

$maxRows_credito = 10;
$pageNum_credito = 0;
if (isset($_GET['pageNum_credito'])) {
  $pageNum_credito = $_GET['pageNum_credito'];
}
$startRow_credito = $pageNum_credito * $maxRows_credito;

$colname_credito = "-1";
if (isset($_SESSION['idPersonal'])) {
  $colname_credito = $_SESSION['idPersonal'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_credito = sprintf("SELECT * FROM creditos WHERE idPersonal = %s", GetSQLValueString($colname_credito, "int"));
$query_limit_credito = sprintf("%s LIMIT %d, %d", $query_credito, $startRow_credito, $maxRows_credito);
$credito = mysql_query($query_limit_credito, $cooperativa) or die(mysql_error());
$row_credito = mysql_fetch_assoc($credito);

if (isset($_GET['totalRows_credito'])) {
  $totalRows_credito = $_GET['totalRows_credito'];
} else {
  $all_credito = mysql_query($query_credito);
  $totalRows_credito = mysql_num_rows($all_credito);
}
$totalPages_credito = ceil($totalRows_credito/$maxRows_credito)-1;

$queryString_credito = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_credito") == false && 
        stristr($param, "totalRows_credito") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_credito = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_credito = sprintf("&totalRows_credito=%d%s", $totalRows_credito, $queryString_credito);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cr&eacute;ditos</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="2"><h1>Cr&eacute;ditos </h1></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;<strong>
Registros <?php echo ($startRow_credito + 1) ?> a <?php echo min($startRow_credito + $maxRows_credito, $totalRows_credito) ?> de <?php echo $totalRows_credito ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table align="center" cellpadding="2" cellspacing="2">
      <tr>
        <th width="118" bgcolor="#05619B">Credito</th>
        <th width="100" bgcolor="#05619B">Detalle</th>
        <th width="125" bgcolor="#05619B">Monto Total</th>
        <th width="142" bgcolor="#05619B">#  Pagos</th>
        <th width="168" bgcolor="#05619B">Interes</th>
      </tr>
      <?php do { ?>
      <tr>
        <td height="40"><?php echo $row_credito['idCredito']; ?></td>
        <td><?php echo $row_credito['detalle']; ?></td>
        <td><?php echo $row_credito['montototal']; ?></td>
        <td><?php echo $row_credito['numeropagos']; ?></td>
        <td><?php echo $row_credito['interes']; ?></td>
      </tr>
      <?php } while ($row_credito = mysql_fetch_assoc($credito)); ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_credito > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_credito=%d%s", $currentPage, 0, $queryString_credito); ?>"><img src="First.gif" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_credito > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_credito=%d%s", $currentPage, max(0, $pageNum_credito - 1), $queryString_credito); ?>"><img src="Previous.gif" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_credito < $totalPages_credito) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_credito=%d%s", $currentPage, min($totalPages_credito, $pageNum_credito + 1), $queryString_credito); ?>"><img src="Next.gif" /></a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_credito < $totalPages_credito) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_credito=%d%s", $currentPage, $totalPages_credito, $queryString_credito); ?>"><img src="Last.gif" /></a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($credito);
?>
