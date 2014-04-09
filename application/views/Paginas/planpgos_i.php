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
  $insertSQL = sprintf("INSERT INTO planpagos (idPlanPago, idCredito, fecha, cuota, valor, interes, notas) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idPlanPago'], "int"),
                       GetSQLValueString($_POST['idCredito'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['cuota'], "int"),
                       GetSQLValueString($_POST['valor'], "double"),
                       GetSQLValueString($_POST['interes'], "double"),
                       GetSQLValueString($_POST['notas'], "text"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($insertSQL, $cooperativa) or die(mysql_error());
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_planpagos = "SELECT * FROM planpagos";
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
<title>Agregar Plan de Pagos</title>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Agregar Plan de Pagos </h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Credito:</strong></td>
      <td><span id="spryselect1">
        <select name="idCredito">
          <option value="-1">Seleccione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_creditos['idCredito']?>"><?php echo $row_creditos['montototal']?></option>
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
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Fecha:</strong></td>
      <td><span id="sprytextfield1">
        <input type="text" name="fecha" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Cuota:</strong></td>
      <td><span id="sprytextfield2">
        <input type="text" name="cuota" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Valor:</strong></td>
      <td><span id="sprytextfield3">
        <input type="text" name="valor" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Interes:</strong></td>
      <td><span id="sprytextfield4">
        <input type="text" name="interes" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Notas:</strong></td>
      <td><span id="sprytextfield5">
        <input type="text" name="notas" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="idPlanPago" value="" size="32" />
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
