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

$colname_ultimoPago = "-1";
if (isset($_GET['idP'])) {
  $colname_ultimoPago = $_GET['idP'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_ultimoPago = sprintf("SELECT max(numAporte) as ultPago FROM aportes WHERE idPersonal = %s ", GetSQLValueString($colname_ultimoPago, "int"));
$ultimoPago = mysql_query($query_ultimoPago, $cooperativa) or die(mysql_error());
$row_ultimoPago = mysql_fetch_assoc($ultimoPago);
$totalRows_ultimoPago = "-1";
if (isset($_GET['idP'])) {
  $totalRows_ultimoPago = $_GET['idP'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_ultimoPago = sprintf("SELECT max(validez) as ultPago FROM aportes WHERE idPersonal = %s ", GetSQLValueString($colname_ultimoPago, "int"));
$ultimoPago = mysql_query($query_ultimoPago, $cooperativa) or die(mysql_error());
$row_ultimoPago = mysql_fetch_assoc($ultimoPago);
$totalRows_ultimoPago = mysql_num_rows($ultimoPago);

$colname_fregSocio = "-1";
if (isset($_GET['idP'])) {
  $colname_fregSocio = $_GET['idP'];
}

 $fecha = date("Y-m-d H:i:s");
$fecha2=$row_ultimoPago['ultPago'];
//echo "***".$fecha2."+++";
if ($fecha2=='0000-00-00'or$fecha2=="")
{
	mysql_select_db($database_cooperativa, $cooperativa);
$query_fregSocio = sprintf("SELECT fechaReg FROM personal WHERE idPersonal = %s", GetSQLValueString($_GET['idP'], "int"));
$fregSocio = mysql_query($query_fregSocio, $cooperativa) or die(mysql_error());
$row_fregSocio = mysql_fetch_assoc($fregSocio);
$totalRows_fregSocio = mysql_num_rows($fregSocio);
	$fecha2=$row_fregSocio['fechaReg'];
	$fecha2=date("Y-m-d", strtotime("$fecha2 -1 month"));
mysql_free_result($fregSocio);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body><?php if ($_GET['idP']<>-1){ ?>
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">No.</td>
    <td align="center">Mes</td>
    <td align="center">Valor</td>
    <td><?php echo $_GET['idP']; ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr /></td>
  </tr><?php $n=1; while(date("Y-m", strtotime("$fecha2"))<date("Y-m", strtotime("$fecha"))){ ?>
  <tr>
    <td align="center"><?php echo $n++; ?></td>
    <td align="center"><?php $fecha2= date("Y-m", strtotime("$fecha2 +1 month")); echo $fecha2;
	
	$fecha3=date("Y-m-d", strtotime("$fecha2 +16 day"));
	
	 ?></td>
    <td align="center"><?php 
	if ($fecha3>$fecha){
	 $valor=$_GET['cuota']; }else{ $valor= $_GET['cuota']+$_GET['mora'];} echo $valor; ?></td>
    <td align="center"><form action="<?php echo $editFormAction; ?>" method="post" name="form<?php echo $n-1; ?>" id="form<?php echo $n-1; ?>">
      <input type="hidden" name="MM_insert" value="form<?php echo $n-1; ?>" />
  <input type="hidden" name="idAportes" value="" size="32" />
  <input name="fecha" type="hidden" value="<?php echo $fecha; ?>" size="32" />
  <input type="hidden" name="valor" value="<?php echo $valor; ?>" size="32" />
    <input name="idPersonal" type="hidden" id="idPersonal" value="<?php echo $_GET['idP']; ?>" />
    <input name="validez" type="hidden" id="validez" value="<?php echo $fecha2; ?>-01" />
<input type="submit" value="Pagar" <?php if ($n<>2) echo 'disabled="disabled"'; ?> />
    </form></td>
  </tr>
<?php   } ?>
</table>
<?php } //echo $row_ultimoPago['ultPago']; ?>
</body>
</html>
<?php
mysql_free_result($ultimoPago);
?>
