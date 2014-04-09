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
  $updateSQL = sprintf("UPDATE planpagos SET idCredito=%s, fecha=%s, cuota=%s, valor=%s, interes=%s, notas=%s WHERE idPlanPago=%s",
                       GetSQLValueString($_POST['idCredito'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['cuota'], "int"),
                       GetSQLValueString($_POST['valor'], "double"),
                       GetSQLValueString($_POST['interes'], "double"),
                       GetSQLValueString($_POST['notas'], "text"),
                       GetSQLValueString($_POST['idPlanPago'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($updateSQL, $cooperativa) or die(mysql_error());

  $updateGoTo = "planpgos_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_planpagos = "-1";
if (isset($_GET['idpp'])) {
  $colname_planpagos = $_GET['idpp'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_planpagos = sprintf("SELECT * FROM planpagos WHERE idPlanPago = %s", GetSQLValueString($colname_planpagos, "int"));
$planpagos = mysql_query($query_planpagos, $cooperativa) or die(mysql_error());
$row_planpagos = mysql_fetch_assoc($planpagos);
$totalRows_planpagos = mysql_num_rows($planpagos);

mysql_select_db($database_cooperativa, $cooperativa);
$query_creditos = "SELECT * FROM creditos";
$creditos = mysql_query($query_creditos, $cooperativa) or die(mysql_error());
$row_creditos = mysql_fetch_assoc($creditos);
$totalRows_creditos = mysql_num_rows($creditos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Plan Pago:</td>
      <td><?php echo $row_planpagos['idPlanPago']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Credito:</td>
      <td><span id="spryselect1">
        <select name="idCredito">
          <option value="-1" <?php if (!(strcmp(-1, htmlentities($row_planpagos['idCredito'], ENT_COMPAT, 'iso-8859-1')))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_creditos['idCredito']?>"<?php if (!(strcmp($row_creditos['idCredito'], htmlentities($row_planpagos['idCredito'], ENT_COMPAT, 'iso-8859-1')))) {echo "selected=\"selected\"";} ?>><?php echo $row_creditos['montototal']?></option>
          <?php
} while ($row_creditos = mysql_fetch_assoc($creditos));
  $rows = mysql_num_rows($creditos);
  if($rows > 0) {
      mysql_data_seek($creditos, 0);
	  $row_creditos = mysql_fetch_assoc($creditos);
  }
?>
        </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha:</td>
      <td><span id="sprytextfield1">
        <input type="text" name="fecha" value="<?php echo htmlentities($row_planpagos['fecha'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cuota:</td>
      <td><span id="sprytextfield2">
        <input type="text" name="cuota" value="<?php echo htmlentities($row_planpagos['cuota'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Valor:</td>
      <td><span id="sprytextfield3">
        <input type="text" name="valor" value="<?php echo htmlentities($row_planpagos['valor'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Interes:</td>
      <td><span id="sprytextfield4">
        <input type="text" name="interes" value="<?php echo htmlentities($row_planpagos['interes'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Notas:</td>
      <td><span id="sprytextfield5">
        <input type="text" name="notas" value="<?php echo htmlentities($row_planpagos['notas'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idPlanPago" value="<?php echo $row_planpagos['idPlanPago']; ?>" />
</form>
<p><a href="planpgos_l.php">Atr&aacute;s</a></p>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($planpagos);

mysql_free_result($creditos);
?>
