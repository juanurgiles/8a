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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opciones SET cvalor_o=%s, nvalor_o=%s, fvalor_o=%s, detalles_o=%s WHERE idO=%s",
                       GetSQLValueString($_POST['cvalor_o'], "text"),
                       GetSQLValueString($_POST['nvalor_o'], "double"),
                       GetSQLValueString($_POST['fvalor_o'], "double"),
                       GetSQLValueString($_POST['detalles_o'], "text"),
                       GetSQLValueString($_POST['idO'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($updateSQL, $cooperativa) or die(mysql_error());

  $updateGoTo = "opciones_lt.php?tipo=".$_POST['tipo'];
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_opciones = "-1";
if (isset($_GET['idO'])) {
  $colname_opciones = $_GET['idO'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_opciones = sprintf("SELECT * FROM opciones WHERE idO = %s", GetSQLValueString($colname_opciones, "int"));
$opciones = mysql_query($query_opciones, $cooperativa) or die(mysql_error());
$row_opciones = mysql_fetch_assoc($opciones);
$totalRows_opciones = mysql_num_rows($opciones);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Editar Opciones</title>
</head>

<body>
<h1><strong>Editar Opciones</strong></h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Opciones:</strong></td>
      <td><?php echo $row_opciones['idO']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Descripci&oacute;n:</strong></td>
      <td><input type="text" name="cvalor_o" value="<?php echo htmlentities($row_opciones['cvalor_o'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idO" value="<?php echo $row_opciones['idO']; ?>" />
  <input type="hidden" name="fvalor_o" value="<?php echo htmlentities($row_opciones['fvalor_o'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
  <input name="tipo" type="text" id="tipo" value="<?php echo $row_opciones['tipo_o']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($opciones);
?>
