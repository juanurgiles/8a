<?php require_once('../Connections/cooperativa.php'); ?>
<?php
$idc=-1;
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
  $insertSQL = sprintf("INSERT INTO creditos (idCredito, detalle, montototal, numeropagos, idPersonal,tipoCredito, interes,estado,fechaCredito) VALUES (%s, %s, %s, %s, %s, %s, %s,'Vigente',%s)",
                       GetSQLValueString($_POST['idCredito'], "int"),
                       GetSQLValueString($_POST['detalle'], "text"),
                       GetSQLValueString($_POST['montototal'], "text"),
                       GetSQLValueString($_POST['numeropagos'], "text"),
                       GetSQLValueString($_POST['idPersonal'], "int"),

GetSQLValueString($_POST['tipoCredito'], "text"),
                       GetSQLValueString($_POST['interes'], "double"),
					   GetSQLValueString($_POST['fechaCredito'], "date"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($insertSQL, $cooperativa) or die(mysql_error());

if ($Result1) {
  $colname_cred = $_POST['fechaCredito'];
mysql_select_db($database_cooperativa, $cooperativa);
$query_cred = sprintf("SELECT idCredito FROM creditos WHERE fechaCredito = %s", GetSQLValueString($colname_cred, "date"));
$cred = mysql_query($query_cred, $cooperativa) or die(mysql_error());
$row_cred = mysql_fetch_assoc($cred);
$totalRows_cred = mysql_num_rows($cred);
$idc=$row_cred['idCredito'];
mysql_free_result($cred);
$ncuotas=$_POST['numeropagos'];
$cuota=$_POST['cuota'];
$saldo=$_POST['montototal']; 
$interes=$_POST['interes'];

$Fecha = date("Y-m-d"); 
$sumaCuota=0;

$insertSQL = "insert into planpagos values ";

   for($i=1;$i<=$ncuotas;$i++){
	   $intMes=$saldo*$interes/100/12;
	   $capital=$cuota-$intMes;
	   $saldo=$saldo-$capital; 

$Fecha= date("Y-m-d", strtotime("$Fecha +1 month"));
	   
  $insertSQL = $insertSQL. "(null,'".$idc."','".$i."','".$Fecha."','".$capital."','".$intMes."','".$cuota."','".$saldo."')";

   if ($i+1<=$ncuotas)
   	$insertSQL= $insertSQL.", ";
	   }
   //echo $insertSQL;
  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($insertSQL, $cooperativa) or die(mysql_error());

}
//echo $idc;

  $insertGoTo = "creditos_rpt.php?idc=".$idc;
 header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_personal = "SELECT * FROM personal";
$personal = mysql_query($query_personal, $cooperativa) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);
$totalRows_personal = mysql_num_rows($personal);

mysql_select_db($database_cooperativa, $cooperativa);
$query_lst_tipoCredito = "SELECT cvalor_o, fvalor_o FROM opciones WHERE tipo_o = 'tipoCredito' ORDER BY cvalor_o ASC";
$lst_tipoCredito = mysql_query($query_lst_tipoCredito, $cooperativa) or die(mysql_error());
$row_lst_tipoCredito = mysql_fetch_assoc($lst_tipoCredito);
$totalRows_lst_tipoCredito = mysql_num_rows($lst_tipoCredito);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Agregar Cr&eacute;dito</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="JavaScript">
<!-- calculadora de cuotas de un prestamo -->

function calculadora(form){

<!-- solicitamos la cantidad prestada, el plazo y el tipo de interes -->
cantidad=form.montototal.value*1;
tipo=form.interes.value/(100*12); <!-- multiplicamos por 100, para disolver el %, y por 12, para tener valor mensual -->
tiempo=form.numeropagos.value*1; <!-- multiplicamos por 12 para devolver valor mensual -->

var equivalencia;
equivalencia=valor(cantidad,tipo,tiempo); <!-- la valor depende de la cantidad, el tipo de interes y el tiempo solicitado -->

<!-- expresamos la operacion en euros form.resultado.value=-->
equivalencia+" Dólares"; <!-- devolvemos el resultado de la operacion -->

<!-- calculamos la valor -->
function valor(cantidad,tipo,tiempo){
potencia=1+tipo;

xxx=Math.pow(potencia,-tiempo);
<!-- funcion matematica donde la base es la potencia y el exponente el tiempo -->

xxx1=cantidad*tipo;
equivalencia=xxx1/(1-xxx);

<!-- limitamos el número de decimales a cero -->
equivalencia=Math.round(equivalencia*100);
equivalencia=equivalencia/100;
generarTabla(equivalencia);
return equivalencia;

}



}
//-->
</script>
<script>
function ponerInteres(interes){
	$("#interes").val(interes.value);
	$("#interes1").val(interes.value);
	
	var valor = interes.options[interes.selectedIndex].text;
		$("#tipo de Crédito").val(valor);
}
function generarTabla(cuota){
    $("#cuota").val(cuota);
	$("#cuota1").val(cuota);
	a=$("#numeropagos").val();
	b=$("#cuota").val();
	c=$("#montototal").val();
	d=$("#interes").val();
	
	$("#tablaAm").load("creditos_i_ta.php?tiempo="+a+"&cuota="+b+"&saldo="+c+"&interes="+d);
}
</script>

</head>

<body>
<h1>Agregar Crédito
</h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Tipo:</strong></td>
      <td><span id="spryselect2">
        <select name="cmdtipoCredito" id="cmdtipoCredito" onblur="ponerInteres(this);">
          <option value="-1">Seleccione el tipo</option>
          <?php
do {  
?>
          <option value="<?php echo $row_lst_tipoCredito['fvalor_o']?>"><?php echo $row_lst_tipoCredito['cvalor_o']?></option>
          <?php
} while ($row_lst_tipoCredito = mysql_fetch_assoc($lst_tipoCredito));
  $rows = mysql_num_rows($lst_tipoCredito);
  if($rows > 0) {
      mysql_data_seek($lst_tipoCredito, 0);
	  $row_lst_tipoCredito = mysql_fetch_assoc($lst_tipoCredito);
  }
?>
        </select>
      <span class="selectInvalidMsg">Seleccione un elemento válido.</span><span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Personal:</strong></td>
      <td><span id="spryselect1">
        <select name="idPersonal">
          <option value="-1">Seleccione el cliente</option>
          <?php
do {  
?>
          <option value="<?php echo $row_personal['idPersonal']?>"><?php echo $row_personal['apellidoPersonal'].' '.$row_personal['nombrePersonal']?></option>
          <?php
} while ($row_personal = mysql_fetch_assoc($personal));
  $rows = mysql_num_rows($personal);
  if($rows > 0) {
      mysql_data_seek($personal, 0);
	  $row_personal = mysql_fetch_assoc($personal);
  }
?>
        </select>
        <span class="selectInvalidMsg">Seleccione un elemento válido.</span><span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><strong>Detalle:</strong></td>
      <td><span id="sprytextarea1">
        <textarea name="detalle" id="detalle" cols="45" rows="5"></textarea>
      <span id="countsprytextarea1">&nbsp;</span><span class="textareaRequiredMsg"><br />
Escriba la Descripción.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Monto:</strong></td>
      <td><span id="sprytextfield2">
        <input name="montototal" type="text" id="montototal" value="1000" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Plazo:</strong></td>
      <td><span id="sprytextfield3">
        <input name="numeropagos" type="text" id="numeropagos" value="12" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Interes:</strong></td>
      <td><span id="sprytextfield4">
        <input name="interes" type="hidden" id="interes" value="" size="32" />
        <input type="text" name="interes1" id="interes1" disabled="disabled"/>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="button" name="button" id="button" value="Calcular" onclick="calculadora(this.form)" />
      <input type="hidden" name="tipoCredito" id="tipoCredito" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap"><strong>Cuota:</strong></td>
      <td align="left" nowrap="nowrap"><label for="cuota"></label>
      <input type="hidden" name="cuota" id="cuota" />
      <input type="text" name="cuota1" id="cuota1" disabled="disabled"/>
      <input name="fechaCredito" type="text" id="fechaCredito" value="<?php echo date("Y-m-d H:i:s"); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" nowrap="nowrap"><div id="tablaAm">Colocar aquí el contenido de la nueva etiqueta Div</div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="idCredito" value="" size="32" />
  <input type="submit" value="Insertar registro" />
</form>
<p><a href="creditos_l.php">Atr&aacute;s</a></p>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur"], invalidValue:"-1"});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1", validateOn:["blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_count"});
</script>
</body>
</html>
<?php
mysql_free_result($personal);

mysql_free_result($lst_tipoCredito);


?>
