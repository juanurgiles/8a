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
  $updateSQL = sprintf("UPDATE creditos SET detalle=%s, montototal=%s, numeropagos=%s, idPersonal=%s, interes=%s WHERE idCredito=%s",
                       GetSQLValueString($_POST['detalle'], "text"),
                       GetSQLValueString($_POST['montototal'], "text"),
                       GetSQLValueString($_POST['numeropagos'], "text"),
                       GetSQLValueString($_POST['idPersonal'], "int"),
                       GetSQLValueString($_POST['interes'], "double"),
                       GetSQLValueString($_POST['idCredito'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($updateSQL, $cooperativa) or die(mysql_error());

  $updateGoTo = "creditos_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_creditos = "-1";
if (isset($_GET['idc'])) {
  $colname_creditos = $_GET['idc'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_creditos = sprintf("SELECT * FROM creditos WHERE idCredito = %s", GetSQLValueString($colname_creditos, "int"));
$creditos = mysql_query($query_creditos, $cooperativa) or die(mysql_error());
$row_creditos = mysql_fetch_assoc($creditos);
$totalRows_creditos = mysql_num_rows($creditos);

mysql_select_db($database_cooperativa, $cooperativa);
$query_personal = "SELECT * FROM personal";
$personal = mysql_query($query_personal, $cooperativa) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);
$totalRows_personal = mysql_num_rows($personal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Editar Cr&eacute;dito</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Editar Crédito
</h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Credito:</strong></td>
      <td><?php echo $row_creditos['idCredito']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Detalle:</strong></td>
      <td><span id="sprytextfield1">
        <input type="text" name="detalle" value="<?php echo htmlentities($row_creditos['detalle'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Monto Total:</strong></td>
      <td><span id="sprytextfield2">
        <input type="text" name="montototal" value="<?php echo htmlentities($row_creditos['montototal'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Numero Pagos:</strong></td>
      <td><span id="sprytextfield3">
        <input type="text" name="numeropagos" value="<?php echo htmlentities($row_creditos['numeropagos'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>personal:</strong></td>
      <td><span id="spryselect1">
        <select name="idPersonal">
          <option value="-1" <?php if (!(strcmp(-1, htmlentities($row_creditos['idPersonal'], ENT_COMPAT, 'iso-8859-1')))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_personal['idPersonal']?>"<?php if (!(strcmp($row_personal['idPersonal'], htmlentities($row_creditos['idPersonal'], ENT_COMPAT, 'iso-8859-1')))) {echo "selected=\"selected\"";} ?>><?php echo $row_personal['nombrePersonal']?></option>
          <?php
} while ($row_personal = mysql_fetch_assoc($personal));
  $rows = mysql_num_rows($personal);
  if($rows > 0) {
      mysql_data_seek($personal, 0);
	  $row_personal = mysql_fetch_assoc($personal);
  }
?>
        </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Interes:</strong></td>
      <td><span id="sprytextfield4">
        <input type="text" name="interes" value="<?php echo htmlentities($row_creditos['interes'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idCredito" value="<?php echo $row_creditos['idCredito']; ?>" />
</form>
<p><a href="creditos_l.php">Atr&aacute;s</a></p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
</script>
</body>
</html>
<?php
mysql_free_result($creditos);

mysql_free_result($personal);
?>
