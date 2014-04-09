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
  $insertSQL = sprintf("INSERT INTO cuenta (idCuenta, tipoCuenta, numeroCuenta, estado, saldo, idP, clave, fechaApertura, fechaUltTrans) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idCuenta'], "int"),
                       GetSQLValueString($_POST['tipoCuenta'], "text"),
                       GetSQLValueString($_POST['numeroCuenta'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['saldo'], "double"),
                       GetSQLValueString($_POST['idP'], "int"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($_POST['fechaApertura'], "date"),
                       GetSQLValueString($_POST['fechaUltTrans'], "date"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($insertSQL, $cooperativa) or die(mysql_error());
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_tipoCuenta = "SELECT cvalor_o FROM opciones WHERE tipo_o = 'TipoCuenta'";
$tipoCuenta = mysql_query($query_tipoCuenta, $cooperativa) or die(mysql_error());
$row_tipoCuenta = mysql_fetch_assoc($tipoCuenta);
$totalRows_tipoCuenta = mysql_num_rows($tipoCuenta);

mysql_select_db($database_cooperativa, $cooperativa);
$query_estado = "SELECT cvalor_o FROM opciones WHERE tipo_o = 'Estado'";
$estado = mysql_query($query_estado, $cooperativa) or die(mysql_error());
$row_estado = mysql_fetch_assoc($estado);
$totalRows_estado = mysql_num_rows($estado);

mysql_select_db($database_cooperativa, $cooperativa);
$query_personal = "SELECT idPersonal, cedulaPersonal, nombrePersonal, apellidoPersonal FROM personal ORDER BY apellidoPersonal ASC";
$personal = mysql_query($query_personal, $cooperativa) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);
$totalRows_personal = mysql_num_rows($personal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script>
function BuscarCta(valor)
{
	nc=valor;
     $("#ncta").load("s_cuentas_new.php?tipo="+nc);
}
</script>
</head>

<body>
<h1>Crear Cuenta
</h1>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">TipoCuenta:</td>
      <td><span id="spryselect1">
        <select name="tipoCuenta" id="tipoCuenta" onblur="BuscarCta(this.value);">
          <option value="-1">Seleccione </option>
          <?php
do {  
?>
          <option value="<?php echo $row_tipoCuenta['cvalor_o']?>"><?php echo $row_tipoCuenta['cvalor_o']?></option>
          <?php
} while ($row_tipoCuenta = mysql_fetch_assoc($tipoCuenta));
  $rows = mysql_num_rows($tipoCuenta);
  if($rows > 0) {
      mysql_data_seek($tipoCuenta, 0);
	  $row_tipoCuenta = mysql_fetch_assoc($tipoCuenta);
  }
?>
        </select>
      <span class="selectInvalidMsg"><br />
      Seleccione el &quot;Tipo de Cuenta&quot;.</span><span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Numero Cuenta:</td>
      <td><span id="sprytextfield1">
      <input name="numeroCuenta" type="text" id="numeroCuenta" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cliente:</td>
      <td><span id="spryselect2">
        <select name="idP" id="idP">
          <option value="-1">Seleccione Uno</option>
          <?php
do {  
?>
          <option value="<?php echo $row_personal['idPersonal']?>"><?php echo $row_personal['apellidoPersonal']." ". $row_personal['nombrePersonal']. "(".$row_personal['cedulaPersonal'].")" ?></option>
          <?php
} while ($row_personal = mysql_fetch_assoc($personal));
  $rows = mysql_num_rows($personal);
  if($rows > 0) {
      mysql_data_seek($personal, 0);
	  $row_personal = mysql_fetch_assoc($personal);
  }
?>
        </select>
      <span class="selectInvalidMsg">Seleccione un Cliente.</span><span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Clave Transferencias:</td>
      <td><input type="text" name="clave" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FechaApertura:</td>
      <td><input type="text" name="fechaApertura" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="idCuenta" value="" size="32" />
  <input type="hidden" name="estado" value="Activo" size="32" />
  <input type="hidden" name="saldo" value="0" size="32" />
  <input type="hidden" name="fechaUltTrans" value="" size="32" />
  <div id="ncta" style=" visibility:hidden;">Cta</div>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur", "change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1"});
</script>

</body>
</html>
<?php
mysql_free_result($tipoCuenta);

mysql_free_result($estado);

mysql_free_result($personal);
?>
