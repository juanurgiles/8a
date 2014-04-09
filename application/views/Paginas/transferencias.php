<?php require_once('../Connections/cooperativa.php'); ?>
<?php if (!isset($_SESSION)) {
  session_start();
}?>
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

mysql_select_db($database_cooperativa, $cooperativa);
$query_ctaOrigen = 'select concat(idCuenta,";",clave) as id ,concat(TipoCuenta," #",numeroCuenta," $",saldo) as nombre  from cuenta where estado ="Activo" and idP='.$_SESSION["idPersonal"];
//echo $query_ctaOrigen;
$ctaOrigen = mysql_query($query_ctaOrigen, $cooperativa) or die(mysql_error());
$row_ctaOrigen = mysql_fetch_assoc($ctaOrigen);
$totalRows_ctaOrigen = mysql_num_rows($ctaOrigen);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script><script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
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
function Confirma(){
	$("#Confirmar").show();
	}

function borrar(){
	$("#Confirmar").hide();
	$("#NombreCliente").html("");
	$("#Cuenta").html("");
	}
</script>

</head>

<body>
<h1>Transferencias</h1>
<form id="form1" name="form1" method="post" action="transferencias_pcs.php">
<table border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td>Cuenta Origen</td>
    <td colspan="2"><select name="idCtaOrigen" id="idCtaOrigen">
      <option value="-1">Seleccione la cuenta origen</option>
      <?php
do {  
?>
      <option value="<?php echo $row_ctaOrigen['id']?>"><?php echo $row_ctaOrigen['nombre']?></option>
      <?php
} while ($row_ctaOrigen = mysql_fetch_assoc($ctaOrigen));
  $rows = mysql_num_rows($ctaOrigen);
  if($rows > 0) {
      mysql_data_seek($ctaOrigen, 0);
	  $row_ctaOrigen = mysql_fetch_assoc($ctaOrigen);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td>Cuenta Destino</td>
    <td><span id="sprytextfield1">
    <input name="numeroCuenta" type="text" id="numeroCuenta" onblur="cargar('#Cuenta','trans_val_cuenta.php', this.value);" size="32" />
    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
      <input type="hidden" name="idCuenta" id="idCuenta" /></td>
    <td><div id="Cuenta">*</div></td>
  </tr>
  <tr>
    <td>Cliente Destino:</td>
    <td colspan="2"><div id="NombreCliente"></div></td>
  </tr>
  <tr>
    <td>Monto</td>
    <td><span id="sprytextfield2">
    <input name="montoTransaccion" type="text" id="montoTransaccion" onblur="calculaSaldo(<?php echo $_GET['tipo']; ?>,this.value);" value="" size="32" />
    <br />
    <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Valor no v&aacute;lido.</span></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Concepto</td>
    <td colspan="2"><span id="sprytextarea1">
    <textarea name="descripcion" cols="32" id="descripcion"></textarea>
    <span id="countsprytextarea1">&nbsp;</span><span class="textareaRequiredMsg">Se necesita un valor.</span><span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><p>
      <input type="button" name="button" id="button" value="Aceptar" onclick="Confirma();" />
    </p></td>
  </tr>
</table><div id="Confirmar"><table border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td>Clave de Transferencia</td>
    <td colspan="2"><input type="text" name="pwd" id="pwd" /></td>
    <td><span id="sprycheckbox1">
    <input type="checkbox" name="checkbox" id="checkbox" />
    <span class="checkboxRequiredMsg">Se&ntilde;ale para Continuar.</span></span></td>
    <td><input type="submit" name="button2" id="button2" value="Transferir" /></td>
  </tr>
  <tr>
    <td colspan="5" align="center"><input type="reset" name="button3" id="button3" value="Cancelar" onclick="borrar()" /></td>
  </tr>
</table></div></form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "currency", {validateOn:["blur"], useCharacterMasking:true});
$("#Confirmar").hide();
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {counterId:"countsprytextarea1", maxChars:30, counterType:"chars_remaining", validateOn:["blur"]});
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1", {validateOn:["change", "blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($ctaOrigen);
?>
