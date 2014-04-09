<?php 
$assets = base_url()."assets/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Contactos</title>
<style type="text/css">
.Estilo35 {font-size: small}
.Estilo43 {font-size: large;
	font-weight: bold;
}
.alertasRojo {font-family: Arial;
	font-size: 11px;
	color: #FF0000;
}
</style>
<link href="<?php echo $assets ?>SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $assets ?>SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $assets ?>SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="<?php echo $assets ?>SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
</head>

<body>
<h2>Contactos</h2>
<table width="80%" height="462" align="center" cellpadding="3" cellspacing="2">
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><table width="0%" border="0" align="center" cellpadding="2" cellspacing="0" class="ttex">
      <tr>
        <td colspan="2" align="center" bgcolor="#FFFFFF" class="tex"><img src="<?php echo $assets ?>images/cont.jpg" alt="" width="225" height="113" /></td>
      </tr>
      <tr>
        <td width="61" align="left" bgcolor="#DEF2FE" class="tex"><strong>Localidad:</strong></td>
        <td width="271" align="left" bgcolor="#DEF2FE" class="tex">Latacunga</td>
      </tr>
      <tr>
        <td align="left" class="tex"><strong>Area:</strong></td>
        <td align="left" class="tex">Cooperativa de Ahorro y Cr&eacute;dito</td>
      </tr>
      <tr>
        <td align="left" bgcolor="#DEF2FE" class="tex"><strong>Tel&eacute;fono: </strong></td>
        <td align="left" bgcolor="#DEF2FE" class="tex">593 - 3 - 266 - 0441</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="tex"><strong>Direcci&oacute;n: </strong></td>
        <td align="left" class="tex">Calle Quito y Juan Abel Echeverr�a</td>
      </tr>
      <tr>
        <td align="left" valign="top" bgcolor="#DEF2FE" class="tex"><strong>Email</strong>: </td>
        <td align="left" bgcolor="#DEF2FE" class="tex">info@cooperativa8deagosto.com</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="94" bgcolor="#FFFFFF"><p>&nbsp;</p></td>
    <td width="663" bgcolor="#FFFFFF"><p></p><table width="419" border="2" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFA309">
                            <tr>
                        <td width="413" bgcolor="#DEF2FE"><form action="send.php" method="post" name="form1" id="form3">
                          <div align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="5">
                              <tr>
                                <td><div align="justify" class="Estilo43">
                                  <p><strong>Cont�ctese</strong> Cooperativa </p>
                                </div></td>
                              </tr>
                            </table>
                            <table width="347" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
                              <tr>
                                <td width="65" align="right" valign="top" bgcolor="#DEF2FE"><div align="justify" class="Estilo35">
                                  <div align="right"><span class="Tit_medio"><strong>Nombres:</strong></span></div>
                                  </div></td>
                                <td width="252" valign="top" bgcolor="#DEF2FE"><div align="left"><span id="sprytextfield7"><span id="sprytextfield5"><span id="sprytextfield11">
                                  <input name="Nombre" type="text" id="Nombre" size="35" />
                                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg"><span class="alertasRojo">Se requiere el ingreso de su Nombre</span>.</span></span></div>
                                  <span id="sprytextfield1"><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                                </tr>
                              <tr>
                                <td align="right" valign="top" bgcolor="#DEF2FE"><div align="justify" class="Estilo35">
                                  <div align="right"><span class="Tit_medio"><strong>Apellidos:</strong></span></div>
                                  </div></td>
                                <td valign="top" bgcolor="#DEF2FE"><div align="left"><span id="sprytextfield"><span id="sprytextfield6">
                                <input name="Apellido" type="text" id="Apellido" size="35" />
                                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>                                <span class="textfieldRequiredMsg"><span class="alertasRojo">Se requiere el ingreso de su Apellido</span>.</span></span></div></td>
                                </tr>
                              <tr>
                                <td align="right" valign="top" bgcolor="#DEF2FE"><div align="justify" class="Estilo35">
                                  <div align="right"><span class="Tit_medio"><strong>Email:</strong></span></div>
                                  </div></td>
                                <td valign="top" bgcolor="#DEF2FE"><div align="left"><span id="sprytextfield4"><span id="sprytextfield8">
                                  <input name="Email" type="text" id="Email" size="35" />
                                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg"><span class="alertasRojo">Se requiere el ingreso de su Email</span>.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></div></td>
                                </tr>
                              <tr>
                                <td align="right" valign="top" bgcolor="#DEF2FE"><div align="justify" class="Estilo35">
                                  <div align="right"><span class="Tit_medio"><strong>Tel&eacute;fono:</strong></span></div>
                                  </div></td>
                                <td valign="top" bgcolor="#DEF2FE"><div align="left"><span id="sprytextfield2"><span id="sprytextfield9">
                                    <input name="Telefono" type="text" id="Telefono" size="35" />
                                    <span class="textfieldRequiredMsg"> necesita un valor.</span></span><span class="textfieldRequiredMsg"><span class="alertasRojo">Se requiere el ingreso N�mero telef�nico</span>.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span>
                                </div></td>
                                </tr>
                              <tr>
                                <td align="right" valign="top" bgcolor="#DEF2FE"><div align="justify" class="Estilo35">
                                  <div align="right"><span class="Tit_medio"><strong>Asunto:</strong></span></div>
                                  </div></td>
                                <td valign="top" bgcolor="#DEF2FE"><div align="left"><span id="sprytextfield3"><span id="sprytextfield10">
                                  <input name="Asunto" type="text" id="Asunto" size="35" />
                                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg"><span class="alertasRojo">Se requiere el ingreso del Asunto</span>.</span></span></div></td>
                                </tr>
                              <tr>
                                <td align="right" valign="top" bgcolor="#DEF2FE"><div align="justify" class="Tit_medio">
                                  <div align="right"><span class="Tit_medio"><strong>Mensaje:</strong></span></div>
                                  </div></td>
                                <td valign="top" bgcolor="#DEF2FE"><div align="left"><span id="sprytextarea1"><span id="sprytextarea2"><span id="sprytextarea3">
                                  <textarea name="Mensaje" id="Mensaje" cols="32" rows="5"></textarea>
                                <span class="textareaRequiredMsg">Se necesita un valor.</span></span><span class="textareaRequiredMsg">Se necesita un valor.</span></span><span class="textareaRequiredMsg"><span class="alertasRojo">Se necesita un valor.</span></span></span></div></td>
                                </tr>
                              <tr>
                                <td colspan="2" align="center" valign="middle" bgcolor="#DEF2FE"><div align="center" class="Estilo35">
                                  <div align="right">
                                    <input name="button3" type="submit" id="button3" value="Enviar" />
                                    </div>
                                  </div></td>
                                </tr>
                              </table>
                            <br />
                          </div>
  </form></td>
</tr>
                  </table></p>
      </p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3");
</script>
</body>
</html>