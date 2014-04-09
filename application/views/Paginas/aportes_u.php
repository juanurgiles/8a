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
  $updateSQL = sprintf("UPDATE aportes SET fecha=%s, idPersonal=%s, valor=%s WHERE idAportes=%s",
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['idPersonal'], "int"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['idAportes'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($updateSQL, $cooperativa) or die(mysql_error());

  $updateGoTo = "aportes_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_aportes = "-1";
if (isset($_GET['ida'])) {
  $colname_aportes = $_GET['ida'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_aportes = sprintf("SELECT * FROM aportes WHERE idAportes = %s", GetSQLValueString($colname_aportes, "int"));
$aportes = mysql_query($query_aportes, $cooperativa) or die(mysql_error());
$row_aportes = mysql_fetch_assoc($aportes);
$totalRows_aportes = mysql_num_rows($aportes);

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
<title>Aporte</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Aportes:</strong></td>
      <td><?php echo $row_aportes['idAportes']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Fecha:</strong></td>
      <td><span id="sprytextfield1">
        <input type="text" name="fecha" value="<?php echo htmlentities($row_aportes['fecha'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Personal:</strong></td>
      <td><span id="spryselect1">
        <select name="idPersonal">
          <option value="-1" <?php if (!(strcmp(-1, htmlentities($row_aportes['idPersonal'], ENT_COMPAT, 'iso-8859-1')))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_aportes['idAportes']?>"<?php if (!(strcmp($row_aportes['idAportes'], htmlentities($row_aportes['idPersonal'], ENT_COMPAT, 'iso-8859-1')))) {echo "selected=\"selected\"";} ?>><?php echo $row_aportes['fecha']?></option>
          <?php
} while ($row_aportes = mysql_fetch_assoc($aportes));
  $rows = mysql_num_rows($aportes);
  if($rows > 0) {
      mysql_data_seek($aportes, 0);
	  $row_aportes = mysql_fetch_assoc($aportes);
  }
?>
        </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Valor:</strong></td>
      <td><span id="sprytextfield2">
        <input type="text" name="valor" value="<?php echo htmlentities($row_aportes['valor'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idAportes" value="<?php echo $row_aportes['idAportes']; ?>" />
</form>
<p><a href="aportes_l.php">Atr&aacute;s</a></p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($aportes);

mysql_free_result($personal);
?>
