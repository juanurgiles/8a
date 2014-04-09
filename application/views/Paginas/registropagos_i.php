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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO registropagos (idRegistroPagos, idPlanPago, fechaPago, montopago, valorInteres, interesMora, valorMora, notas, montoRecibido) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idRegistroPagos'], "int"),
                       GetSQLValueString($_POST['idPlanPago'], "int"),
                       GetSQLValueString($_POST['fechaPago'], "date"),
                       GetSQLValueString($_POST['montopago'], "text"),
                       GetSQLValueString($_POST['valorInteres'], "double"),
                       GetSQLValueString($_POST['interesMora'], "double"),
                       GetSQLValueString($_POST['valorMora'], "double"),
                       GetSQLValueString($_POST['notas'], "text"),
                       GetSQLValueString($_POST['montoRecibido'], "double"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($insertSQL, $cooperativa) or die(mysql_error());
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_registropagos = "SELECT * FROM registropagos";
$registropagos = mysql_query($query_registropagos, $cooperativa) or die(mysql_error());
$row_registropagos = mysql_fetch_assoc($registropagos);
$totalRows_registropagos = mysql_num_rows($registropagos);

mysql_select_db($database_cooperativa, $cooperativa);
$query_planpagos = "SELECT * FROM planpagos";
$planpagos = mysql_query($query_planpagos, $cooperativa) or die(mysql_error());
$row_planpagos = mysql_fetch_assoc($planpagos);
$totalRows_planpagos = mysql_num_rows($planpagos);
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
      <td><span id="spryselect1">
        <select name="idPlanPago">
          <option value="-1">Seleccione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_planpagos['idPlanPago']?>"><?php echo $row_planpagos['cuota']?></option>
          <?php
} while ($row_planpagos = mysql_fetch_assoc($planpagos));
  $rows = mysql_num_rows($planpagos);
  if($rows > 0) {
      mysql_data_seek($planpagos, 0);
	  $row_planpagos = mysql_fetch_assoc($planpagos);
  }
?>
        </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha Pago:</td>
      <td><span id="sprytextfield1">
        <input type="text" name="fechaPago" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Monto Pago:</td>
      <td><span id="sprytextfield2">
        <input type="text" name="montopago" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Valor Interes:</td>
      <td><span id="sprytextfield3">
        <input type="text" name="valorInteres" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Interes Mora:</td>
      <td><span id="sprytextfield4">
        <input type="text" name="interesMora" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Valor Mora:</td>
      <td><span id="sprytextfield5">
        <input type="text" name="valorMora" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Notas:</td>
      <td><span id="sprytextfield6">
        <input type="text" name="notas" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Monto Recibido:</td>
      <td><span id="sprytextfield7">
        <input type="text" name="montoRecibido" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="idRegistroPagos" value="" size="32" />
</form>
<p><a href="registropagos_l.php">Atr&aacute;s</a></p>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($registropagos);

mysql_free_result($planpagos);
?>
