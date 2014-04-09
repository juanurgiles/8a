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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_personal = 10;
$pageNum_personal = 0;
if (isset($_GET['pageNum_personal'])) {
  $pageNum_personal = $_GET['pageNum_personal'];
}
$startRow_personal = $pageNum_personal * $maxRows_personal;

mysql_select_db($database_cooperativa, $cooperativa);
$query_personal = "select p.idPersonal, codigoPersonal, cedulaPersonal, nombrePersonal, apellidoPersonal, sum(a.valor) as totalAportes
from personal p inner join aportes a on a.idPersonal=p.idPersonal
group by p.idPersonal, codigoPersonal, cedulaPersonal, nombrePersonal, apellidoPersonal";
$query_limit_personal = sprintf("%s LIMIT %d, %d", $query_personal, $startRow_personal, $maxRows_personal);
$personal = mysql_query($query_limit_personal, $cooperativa) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);

if (isset($_GET['totalRows_personal'])) {
  $totalRows_personal = $_GET['totalRows_personal'];
} else {
  $all_personal = mysql_query($query_personal);
  $totalRows_personal = mysql_num_rows($all_personal);
}
$totalPages_personal = ceil($totalRows_personal/$maxRows_personal)-1;

$queryString_personal = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_personal") == false && 
        stristr($param, "totalRows_personal") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_personal = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_personal = sprintf("&totalRows_personal=%d%s", $totalRows_personal, $queryString_personal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<h1>Capital de la Cooperativa</h1>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td align="right"><strong>&nbsp;
Registros <?php echo ($startRow_personal + 1) ?> a <?php echo min($startRow_personal + $maxRows_personal, $totalRows_personal) ?> de <?php echo $totalRows_personal ?></strong></td>
  </tr>
  <tr>
    <td><table border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <th bgcolor="#05619B">C&oacute;digo</th>
        <th bgcolor="#05619B">C&eacute;dula</th>
        <th bgcolor="#05619B">Nombre</th>
        <th bgcolor="#05619B">Apellido</th>
        <th bgcolor="#05619B">Aportes</th>
        <th bgcolor="#05619B">&nbsp;</th>
      </tr>
      <?php $tot=0; do { ?>
      <tr>
        <td><?php echo $row_personal['codigoPersonal']; ?></td>
        <td><?php echo $row_personal['cedulaPersonal']; ?></td>
        <td><?php echo $row_personal['nombrePersonal']; ?></td>
        <td><?php  echo $row_personal['apellidoPersonal']; ?></td>
        <td align="center"><?php $tot=$tot+ $row_personal['totalAportes']; echo $row_personal['totalAportes']; ?></td>
        <td><a href="aportes_l.php?ids=<?php echo $row_personal['idPersonal']; ?>"><img src="../images/b_browse.png" width="16" height="16" border="0" /></a></td>
      </tr><?php } while ($row_personal = mysql_fetch_assoc($personal)); ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Total</td>
        <td><?php echo $tot; ?>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_personal > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_personal=%d%s", $currentPage, 0, $queryString_personal); ?>"><img src="First.gif" /></a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_personal > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_personal=%d%s", $currentPage, max(0, $pageNum_personal - 1), $queryString_personal); ?>"><img src="Previous.gif" /></a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_personal < $totalPages_personal) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_personal=%d%s", $currentPage, min($totalPages_personal, $pageNum_personal + 1), $queryString_personal); ?>"><img src="Next.gif" /></a>
    <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_personal < $totalPages_personal) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_personal=%d%s", $currentPage, $totalPages_personal, $queryString_personal); ?>"><img src="Last.gif" /></a>
    <?php } // Show if not last page ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($personal);
?>
