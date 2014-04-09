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

$colname_aportes = "-1";
if (isset($_GET['ids'])) {
  $colname_aportes = $_GET['ids'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_aportes = sprintf("SELECT * FROM aportes WHERE idPersonal = %s", GetSQLValueString($colname_aportes, "int"));
$aportes = mysql_query($query_aportes, $cooperativa) or die(mysql_error());
$row_aportes = mysql_fetch_assoc($aportes);
mysql_select_db($database_cooperativa, $cooperativa);
$query_aportes = "SELECT * FROM aportes";
$aportes = mysql_query($query_aportes, $cooperativa) or die(mysql_error());
$row_aportes = mysql_fetch_assoc($aportes);
$colname_aportes = "-1";
if (isset($_SESSION['idPersonal'])) {
  $colname_aportes = $_SESSION['idPersonal'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_aportes = sprintf("SELECT * FROM aportes WHERE idPersonal = %s", GetSQLValueString($colname_aportes, "int"));
$aportes = mysql_query($query_aportes, $cooperativa) or die(mysql_error());
$row_aportes = mysql_fetch_assoc($aportes);
$maxRows_aportes = 10;
$pageNum_aportes = 0;
if (isset($_GET['pageNum_aportes'])) {
  $pageNum_aportes = $_GET['pageNum_aportes'];
}
$startRow_aportes = $pageNum_aportes * $maxRows_aportes;
mysql_select_db($database_cooperativa, $cooperativa);
$query_aportes = sprintf("SELECT * FROM aportes WHERE idPersonal = %s", GetSQLValueString($colname_aportes, "int"));
$query_limit_aportes = sprintf("%s LIMIT %d, %d", $query_aportes, $startRow_aportes, $maxRows_aportes);
$aportes = mysql_query($query_limit_aportes, $cooperativa) or die(mysql_error());
$row_aportes = mysql_fetch_assoc($aportes);

if (isset($_GET['totalRows_aportes'])) {
  $totalRows_aportes = $_GET['totalRows_aportes'];
} else {
  $all_aportes = mysql_query($query_aportes);
  $totalRows_aportes = mysql_num_rows($all_aportes);
}
$totalPages_aportes = ceil($totalRows_aportes/$maxRows_aportes)-1;

$queryString_aportes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_aportes") == false && 
        stristr($param, "totalRows_aportes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_aportes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_aportes = sprintf("&totalRows_aportes=%d%s", $totalRows_aportes, $queryString_aportes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Aportes</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="2"><h1>Aportes</h1></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">&nbsp;
      <strong>Registros <?php echo ($startRow_aportes + 1) ?> a <?php echo min($startRow_aportes + $maxRows_aportes, $totalRows_aportes) ?> de <?php echo $totalRows_aportes ?></strong></td>
  </tr>
  <tr>
    <td width="20%"></td>
    <td width="80%"><table width="383" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <th bgcolor="#05619B">Aportes</th>
        <th bgcolor="#05619B">Fecha</th>
        <th bgcolor="#05619B">Valor</th>
      </tr>
      <?php do { ?>
      <tr>
        <td height="32"><?php echo $row_aportes['idAportes']; ?></td>
        <td><?php echo $row_aportes['fecha']; ?></td>
        <td><?php echo $row_aportes['valor']; ?></td>
      </tr>
      <?php } while ($row_aportes = mysql_fetch_assoc($aportes)); ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_aportes > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_aportes=%d%s", $currentPage, 0, $queryString_aportes); ?>"><img src="First.gif" /></a>
            <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_aportes > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_aportes=%d%s", $currentPage, max(0, $pageNum_aportes - 1), $queryString_aportes); ?>"><img src="Previous.gif" /></a>
            <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_aportes < $totalPages_aportes) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_aportes=%d%s", $currentPage, min($totalPages_aportes, $pageNum_aportes + 1), $queryString_aportes); ?>"><img src="Next.gif" /></a>
            <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_aportes < $totalPages_aportes) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_aportes=%d%s", $currentPage, $totalPages_aportes, $queryString_aportes); ?>"><img src="Last.gif" /></a>
            <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($aportes);
?>
