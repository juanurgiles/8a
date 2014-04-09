<?php require_once('../Connections/cooperativa.php'); ?>
<?php

if (!isset($_SESSION)) {
  session_start();
}

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
	$fecha = date("Y-m-d H:i:s");
  $insertSQL = sprintf("INSERT INTO transacciones (idTransaccion, numeroCuenta, codigoTransaccion, idUsuario, fecha, montoTransaccion, saldoDisponible) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idTransaccion'], "int"),
                       GetSQLValueString($_POST['idCuenta'], "int"),
                       GetSQLValueString($_POST['codigoTransaccion'], "text"),
                       GetSQLValueString($_POST['idUsuario'], "int"),
                       GetSQLValueString($fecha, "date"),
                       GetSQLValueString($_POST['montoTransaccion'], "double"),
                       GetSQLValueString($_POST['saldoDisponible'], "double"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($insertSQL, $cooperativa) or die(mysql_error());
  if ($Result1){
	  $updateSaldo ="update cuenta set saldo=".GetSQLValueString($_POST['saldoDisponible'],"double")." where idCuenta=".GetSQLValueString($_POST['idCuenta'], "int");
	  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($updateSaldo, $cooperativa) or die(mysql_error());
  }
}

$colname_tipotrans = "-1";
if (isset($_GET['tipo'])) {
  $colname_tipotrans = $_GET['tipo'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_tipotrans = sprintf("SELECT idO, cvalor_o FROM opciones WHERE idO = %s", GetSQLValueString($colname_tipotrans, "int"));
$tipotrans = mysql_query($query_tipotrans, $cooperativa) or die(mysql_error());
$row_tipotrans = mysql_fetch_assoc($tipotrans);
$totalRows_tipotrans = mysql_num_rows($tipotrans);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script>
function cargar(div, desde, valor)
{
	nc=valor;
     $(div).load(desde+"?numc="+nc);
}
function calculaSaldo(tipo,valor)
{
tiene=$('#saldoCta').val();
if (tipo==15){
nuevo=parseFloat(tiene)+parseFloat(valor);
	 $('#btnInsertar').removeAttr("disabled");
}
if (tipo==16){
nuevo=parseFloat(tiene)-parseFloat(valor);
if(nuevo<1){
	 $('#btnInsertar').attr("disabled", "disabled");
}else{
		 $('#btnInsertar').removeAttr("disabled");
}
}
 $('#divSaldoDisp').html(nuevo);
 $('#saldoDisponible').val(nuevo);
 
}


function buscar()
{
var a=window.open("http://www.cooperativa8deagosto.com/Paginas/cuentas_l.php","","width=550,height=400");
}
</script>

<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Transacci&oacute;n de <?php echo $row_tipotrans['cvalor_o']; ?></h1>
<h2>Fecha: <?php echo date("Y-m-d H:i:s"); ?> </h2>
<?php if(!isset($_POST["MM_insert"])){?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table border="0" align="center" cellpadding="5" cellspacing="5">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">NumeroCuenta:</td>
      <td><span id="sprytextfield1">
        <input name="numeroCuenta" type="text" id="numeroCuenta" onblur="cargar('#Cuenta','trans_val_cuenta.php', this.value);" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><a href="cuentas_l.php" target="_blank">Buscar
      
      </a><input type="button" name="button2" onclick="buscar();" id="button2" value="..." /></td>
      <td><div id="Cuenta"></div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cliente:</td>
      <td><div id="NombreCliente"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">MontoTransaccion:</td>
      <td><span id="sprytextfield2">
      <input name="montoTransaccion" type="text" id="montoTransaccion" onblur="calculaSaldo(<?php echo $_GET['tipo']; ?>,this.value);" value="" size="32" /><br />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Valor no válido.</span></span></td>
      <td><span id="sprycheckbox1">
        <input type="checkbox" name="checkbox" id="checkbox" />
      <span class="checkboxRequiredMsg">Se&ntilde;ale para Continuar.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">SaldoDisponible:</td>
      <td><div id="divSaldoDisp"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input name="btnInsertar" type="submit" id="btnInsertar" value="Procesar" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="idTransaccion" value="" size="32" />
  <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['idPersonal']; ?>" size="32" />
  <input type="hidden" name="codigoTransaccion" value="<?php echo $row_tipotrans['cvalor_o']; ?>" size="32" />
  <input type="hidden" name="idCuenta" id="idCuenta" />
  <input name="tt" type="hidden" id="tt" value="<?php echo $_GET['tipo']; ?>" />
  <input type="hidden" name="saldoDisponible" id="saldoDisponible" value="" size="32" />
</form>
<p>&nbsp;</p>
<?php } else { ?>
<form action="imptrans.php" method="post" name="form2" target="_blank" id="form2">
  N&uacute;mero de Linea Imprimir
  <input type="text" name="linea" id="linea" />
  <input name="cuenta" type="hidden" id="cuenta" value="<?php echo $_POST['idCuenta']; ?>" />
<input type="submit" name="button" id="button" value="Imprimir" />
</form>

<?php }?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "currency", {validateOn:["blur"], useCharacterMasking:true});
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1", {validateOn:["change", "blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($tipotrans);
?>
