<?php require_once('../Connections/cooperativa.php'); ?>
<?php
$fechaAct=date("Y-m-d");
function dias_transcurridos($fecha_f,$fecha_i)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	//$dias 	= abs($dias);
	 $dias = floor($dias);
	 if($dias>0)		
	return $dias;
	else 
	return 0;
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
  $insertSQL = sprintf("INSERT INTO registropagos (idRegistroPagos, idPP, fechaPago, montopago, interesMora, diasMora, valorMora, notas, montoRecibido) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idRegistroPagos'], "int"),
                       GetSQLValueString($_POST['idPP'], "int"),
                       GetSQLValueString($_POST['fechaPago'], "date"),
                       GetSQLValueString($_POST['montopago'], "text"),
                       GetSQLValueString($_POST['interesMora'], "double"),
                       GetSQLValueString($_POST['diasMora'], "int"),
                       GetSQLValueString($_POST['valorMora'], "double"),
                       GetSQLValueString($_POST['notas'], "text"),
                       GetSQLValueString($_POST['montoRecibido'], "double"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($insertSQL, $cooperativa) or die(mysql_error());
}

$colname_planpagos = "-1";
if (isset($_GET['idc'])) {
  $colname_planpagos = $_GET['idc'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_planpagos = sprintf("select * from planpagos left join registropagos on idPlanPago = idpp where idCredito=%s and isnull(idRegistroPagos)", GetSQLValueString($colname_planpagos, "int"));
$planpagos = mysql_query($query_planpagos, $cooperativa) or die(mysql_error());
$row_planpagos = mysql_fetch_assoc($planpagos);
$totalRows_planpagos = mysql_num_rows($planpagos);

mysql_select_db($database_cooperativa, $cooperativa);
$query_intMora = "SELECT fvalor_o FROM opciones WHERE idO = 2";
$intMora = mysql_query($query_intMora, $cooperativa) or die(mysql_error());
$row_intMora = mysql_fetch_assoc($intMora);
$totalRows_intMora = mysql_num_rows($intMora);

mysql_select_db($database_cooperativa, $cooperativa);
$query_creditos = "select idCredito,tipoCredito,montototal,numeropagos,estado,fechaCredito,detalle,interes, concat(apellidoPersonal,' ',nombrePersonal) as cliente from creditos c inner join personal p  on p.idPersonal=c.idPersonal where idCredito=".$_GET['idc'];
$creditos = mysql_query($query_creditos, $cooperativa) or die(mysql_error());
$row_creditos = mysql_fetch_assoc($creditos);
$totalRows_creditos = mysql_num_rows($creditos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tabla de pagos</title>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php // print_r($_GET);  ?>
<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><p>Crédito de <?php echo $row_creditos['tipoCredito']; ?> No. <?php echo $row_creditos['idCredito']; ?>;</p>
      <p>Monto: <?php echo $row_creditos['montototal']; ?> al <?php echo $row_creditos['interes']; ?>%  anual</p>
      <p>Tiempo: <?php echo $row_creditos['numeropagos']; ?> meses</p>
      <p>Otorgado el: <?php echo substr($row_creditos['fechaCredito'],0,10); ?></p>
      <p>Cliente: <?php echo $row_creditos['cliente']; ?></p>
      <p>Destinaci&oacute;n: <?php echo $row_creditos['detalle']; ?></p>
      <table width="100%" border="0" align="center">
        <tr>
          <td colspan="2"><hr /></td>
        </tr>
        <?php do { ?>
          <tr align="center">
              <td colspan="2" align="left" valign="top"><strong>Cuota No. <?php echo $row_planpagos['numCuota']; ?></strong></td>
          </tr>
          <tr align="center">
            <td valign="top"><p>&nbsp;</p>
              <table>
                <tr>
                  <td><strong>Fecha: </strong></td>
                  <td nowrap="nowrap"><?php echo $row_planpagos['fecha']; ?></td>
                </tr>
                <tr>
                  <td><strong>Cuota:</strong></td>
                  <td><?php echo $row_planpagos['cuota']; ?></td>
                </tr>
                <tr>
                  <td><strong>Saldo:</strong></td>
                  <td><?php echo $row_planpagos['saldo']; ?></td>
                </tr>
              </table></td>
              <td><form action="<?php echo $editFormAction; ?>" method="post" name="form<?php echo $row_planpagos['idPlanPago']; ?>" id="form<?php echo $row_planpagos['idPlanPago']; ?>">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="left"><strong>Fecha pago:</strong></td>
                    <td><?php echo $fechaAct; ?></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="left"><strong>Inter&eacute;s mora:</strong></td>
                    <td><?php echo $row_intMora['fvalor_o']; ?></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="left"><strong>D&iacute;as en mora:</strong></td>
                    <td><?php $dias= dias_transcurridos($row_planpagos['fecha'],$fechaAct); ?><?php echo $dias; ?></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="left"><strong>Valor por mora:</strong></td>
                    <td><?php $vmora= $row_planpagos['cuota']*(($row_intMora['fvalor_o'])*$dias/30); $vmora=intval($vmora)/100; echo $vmora;?></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="left" valign="top" nowrap="nowrap"><strong>Notas:</strong></td>
                    <td valign="baseline"><span id="sprytextarea1">
                    <textarea name="notas" cols="40" rows="3"></textarea>Caracteres restantes: <span id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg"><br />
                    Se ha superado el número máximo de caracteres.</span></span></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="left" valign="middle" nowrap="nowrap"><strong>Monto a Recibir:</strong></td>
                    <td valign="top"><h2><?php $vcobra=$row_planpagos['cuota']+$vmora; echo $vcobra;?></h2></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right"><strong>Procesar Cobro:</strong></td>
                    <td><span id="sprycheckbox1">
                      <input type="checkbox" name="checkbox1" id="checkbox1" />
                    <span class="checkboxRequiredMsg">Debe seleccionar para procesar el cobro.</span></span></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" value="Cobrar" /></td>
                  </tr>
                </table>
                <input type="hidden" name="idRegistroPagos" value="" size="32" />
                <input type="hidden" name="idPP" value="<?php echo $row_planpagos['idPlanPago']; ?>" size="32" />
                <input type="hidden" name="fechaPago" value="<?php echo $fechaAct; ?>" size="32" />
                <input type="hidden" name="montopago" value="<?php echo $row_planpagos['cuota']; ?>" size="32" />
                <input type="hidden" name="interesMora" value="<?php echo $row_intMora['fvalor_o']; ?>" size="32" />
                <input type="hidden" name="diasMora" value="<?php echo $dias;  ?>" size="32" />
                <input type="hidden" name="valorMora" value="<?php  echo $vmora;?>" size="32" />
                <input type="hidden" name="montoRecibido" value="<?php echo $vcobra; ?>" size="32" />
                <input type="hidden" name="MM_insert" value="form1" />
              </form></td>
          </tr>
          <tr align="center">
            <td colspan="2"><hr /></td>
          </tr>
         <?php } while ($row_planpagos = mysql_fetch_assoc($planpagos)); ?>
      </table></td>
  </tr>
</table>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1", {validateOn:["blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {counterId:"countsprytextarea1", counterType:"chars_remaining", maxChars:100, isRequired:false});
</script>
</body>
</html>
<?php
mysql_free_result($planpagos);

mysql_free_result($intMora);

mysql_free_result($creditos);
?>
