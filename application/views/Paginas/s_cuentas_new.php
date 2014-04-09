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

$colname_sigCta = "-1";
if (isset($_GET['tipo'])) {
  $colname_sigCta = $_GET['tipo'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_sigCta = sprintf("SELECT max(numeroCuenta)+1 as SigCta FROM cuenta WHERE tipoCuenta = %s ORDER BY numeroCuenta DESC", GetSQLValueString($colname_sigCta, "text"));
$sigCta = mysql_query($query_sigCta, $cooperativa) or die(mysql_error());
$row_sigCta = mysql_fetch_assoc($sigCta);
$totalRows_sigCta = mysql_num_rows($sigCta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<?php echo $row_sigCta['SigCta']; ?>
<script>
$("#numeroCuenta").val("<?php echo $row_sigCta['SigCta']; ?>");
</script>
</body>
</html>
<?php
mysql_free_result($sigCta);
?>
