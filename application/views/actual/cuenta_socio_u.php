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
  $updateSQL = sprintf("UPDATE cuenta SET tipoCuenta=%s, numeroCuenta=%s, estado=%s, saldo=%s WHERE idCuenta=%s",
                       GetSQLValueString($_POST['tipoCuenta'], "text"),
                       GetSQLValueString($_POST['numeroCuenta'], "int"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['saldo'], "double"),
                       GetSQLValueString($_POST['idCuenta'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($updateSQL, $cooperativa) or die(mysql_error());

  $updateGoTo = "cuenta_socio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_cuenta = "-1";
if (isset($_GET['idc'])) {
  $colname_cuenta = $_GET['idc'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_cuenta = sprintf("SELECT * FROM cuenta WHERE idCuenta = %s", GetSQLValueString($colname_cuenta, "int"));
$cuenta = mysql_query($query_cuenta, $cooperativa) or die(mysql_error());
$row_cuenta = mysql_fetch_assoc($cuenta);
$totalRows_cuenta = mysql_num_rows($cuenta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IdCuenta:</td>
      <td><?php echo $row_cuenta['idCuenta']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tipo Cuenta:</td>
      <td><span id="sprytextfield1">
        <input type="text" name="tipoCuenta" value="<?php echo htmlentities($row_cuenta['tipoCuenta'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Número Cuenta:</td>
      <td><span id="sprytextfield2">
        <input type="text" name="numeroCuenta" value="<?php echo htmlentities($row_cuenta['numeroCuenta'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Estado:</td>
      <td><span id="sprytextfield3">
        <input type="text" name="estado" value="<?php echo htmlentities($row_cuenta['estado'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Saldo:</td>
      <td><span id="sprytextfield4">
        <input type="text" name="saldo" value="<?php echo htmlentities($row_cuenta['saldo'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idCuenta" value="<?php echo $row_cuenta['idCuenta']; ?>" />
</form>
<p>&nbsp;</p>
<p><a href="cuenta_socio.php">Atr&aacute;s</a></p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
</script>
</body>
</html>
<?php
mysql_free_result($cuenta);
?>
