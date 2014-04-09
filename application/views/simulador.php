<?php// require_once('Connections/cooperativa.php'); ?>
<?php 
$assets = base_url()."assets/";
?>
    <?php/*
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
$query_interes = "SELECT fvalor_o FROM opciones WHERE idO = 1";
$interes = mysql_query($query_interes, $cooperativa) or die(mysql_error());
$row_interes = mysql_fetch_assoc($interes);
$totalRows_interes = mysql_num_rows($interes);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Simulador de Cr�dito</title>
<script src="<?php echo $assets ?>SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript" language="JavaScript">
<!-- calculadora de cuotas de un prestamo -->

function calculadora(form){

<!-- solicitamos la cantidad prestada, el plazo y el tipo de interes -->
cantidad=form.cantidad.value*1;
tipo=form.tipo.value/(100*12); <!-- multiplicamos por 100, para disolver el %, y por 12, para tener valor mensual -->
tiempo=form.tiempo.value*1; <!-- multiplicamos por 12 para devolver valor mensual -->

var equivalencia;
equivalencia=valor(cantidad,tipo,tiempo); <!-- la valor depende de la cantidad, el tipo de interes y el tiempo solicitado -->

<!-- limitamos el n�mero de decimales a cero -->
//alert (equivalencia);
equivalencia=Math.round(equivalencia);

<!-- expresamos la operacion en euros -->
form.resultado.value=equivalencia+" D�lares"; <!-- devolvemos el resultado de la operacion -->

<!-- calculamos la valor -->
function valor(cantidad,tipo,tiempo){
potencia=1+tipo;

xxx=Math.pow(potencia,-tiempo);
<!-- funcion matematica donde la base es la potencia y el exponente el tiempo -->

xxx1=cantidad*tipo;
equivalencia=xxx1/(1-xxx);

return equivalencia;

}



}
//-->
</script>
<link href="<?php echo $assets ?>SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="entrada">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td width="11%">&nbsp;</td>
      <td width="31%" align="right"><img src="<?php echo $assets ?>images/sim.jpg" width="107" height="94" /></td>
      <td width="56%"><h2>Simulador de Cr�dito</h2></td>
      <td width="2%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="tf08">
        <tbody>
          <tr>
            <td width="233" align="right" bgcolor="#DEF2FE" class="cf53"><strong>Cantidad que desea solicitar:</strong></td>
            <td width="147" bgcolor="#DEF2FE" class="cf54"><span id="sprytextfield1">
            <input type="text" name="cantidad" style="border:1px solid #336699; background-color: #EEEEEE" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
            <td width="406" bgcolor="#DEF2FE" class="cf54">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="cf53"><strong>Tiempo a amortizar en meses:</strong></td>
            <td class="cf54"><span id="sprytextfield2">
            <input type="text" name="tiempo" value="" size="20" style="border:1px solid #336699; background-color: #EEEEEE" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
            <td class="cf54">&nbsp;</td>
          </tr>
          <tr bgcolor="#DEF2FE">
            <td align="right" class="cf53"><strong>Inter�s %:</strong></td>
            <td valign="middle" bgcolor="#DEF2FE" class="cf54"><span id="sprytextfield3">
            <input type="text" name="tipo" value="<?php echo $interes->fvalor_o //echo $row_interes['fvalor_o']; ?>" size="20" style="border:1px solid #336699; background-color: #EEEEEE" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
            <td bgcolor="#DEF2FE" class="cf54">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="cf55">&nbsp;</td>
            <td align="center" class="cf55"><input type="button" value="Calcular" name="calcular" onclick="calculadora(this.form)" style="font-size: 10pt; font-weight: bold" /></td>
            <td align="center" class="cf55">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="cf55">&nbsp;</td>
            <td align="center" class="cf55">&nbsp;</td>
            <td align="center" class="cf55">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" bgcolor="#DEF2FE" class="cf53"><strong>Cuota mensual:</strong></td>
            <td bgcolor="#DEF2FE" class="cf54"><input type="text" name="resultado" value="" size="20" style="font-family: Verdana, Arial; font-size: 10pt; color: rgb(255,0,0)" disabled="disabled" /></td>
            <td bgcolor="#DEF2FE" class="cf54"><span class="cf55">
              <input type="reset" value="Calcular otro" name="B2" />
            </span></td>
          </tr>
          <tr>
            <td class="cf53">&nbsp;</td>
            <td class="cf54">&nbsp;</td>
            <td class="cf54">&nbsp;</td>
          </tr>
          <tr>
            <td class="cf53">&nbsp;</td>
            <td class="cf54">&nbsp;</td>
            <td class="cf54">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "currency");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");
</script>
</body>
</html>
<?php
//mysql_free_result($interes);
?>
