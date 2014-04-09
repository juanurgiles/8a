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
  $insertSQL = sprintf("INSERT INTO aportes (idAportes, fecha, idPersonal, valor,validez) VALUES (%s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['idAportes'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['idPersonal'], "int"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['validez'], "date"));

// echo $insertSQL;
  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($insertSQL, $cooperativa) or die(mysql_error());
if($Result1){
mysql_select_db($database_cooperativa, $cooperativa);
$query_aporteId = "SELECT idAportes FROM aportes WHERE fecha = '".$_POST['fecha']."' and idPersonal=".$_POST['idPersonal'];
$aporteId = mysql_query($query_aporteId, $cooperativa) or die(mysql_error());
$row_aporteId = mysql_fetch_assoc($aporteId);
$totalRows_aporteId = mysql_num_rows($aporteId);	
}

  $insertGoTo = "aportes_recibo.php?ref=".$row_aporteId['idAportes'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_aportes = "SELECT fvalor_o FROM opciones WHERE idO = 21";
$aportes = mysql_query($query_aportes, $cooperativa) or die(mysql_error());
$row_aportes = mysql_fetch_assoc($aportes);
$totalRows_aportes = mysql_num_rows($aportes);

mysql_select_db($database_cooperativa, $cooperativa);
$query_personal = "SELECT idPersonal,nombrePersonal,apellidoPersonal FROM personal where socio=1";
$personal = mysql_query($query_personal, $cooperativa) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);
$totalRows_personal = mysql_num_rows($personal);

mysql_select_db($database_cooperativa, $cooperativa);
$query_Recordset1 = "SELECT fvalor_o FROM opciones WHERE idO = 22";
$Recordset1 = mysql_query($query_Recordset1, $cooperativa) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$fecha = date("Y-m-d H:i:s");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script>
function listarAportesPendientes(){
id=$("#idPersona").val();
$(listado).load("aportesPendientes.php?idP="+id+"&cuota="+<?php echo $row_aportes['fvalor_o']; ?>+"&mora="+<?php echo  $row_Recordset1['fvalor_o']; ?>);
$(listado).show();
}

</script>
</head>

<body>
<h1>Cobro de aportes</h1>
<h3><?php echo date("Y-m-d"); ?></h3>
<table align="center">
  <tr valign="baseline">
    <td nowrap="nowrap" align="right"><strong>Personal:</strong></td>
    <td><span id="spryselect2">
      <select name="idPersona" id="idPersona">
        <option value="-1">Seleccione</option>
        <?php
do {  
?>
        <option value="<?php echo $row_personal['idPersonal']?>"><?php echo $row_personal['nombrePersonal']." ".$row_personal['apellidoPersonal'];?></option>
        <?php
} while ($row_personal = mysql_fetch_assoc($personal));
  $rows = mysql_num_rows($personal);
  if($rows > 0) {
      mysql_data_seek($personal, 0);
	  $row_personal = mysql_fetch_assoc($personal);
  }
?>
      </select>
      `<span class="selectInvalidMsg">Seleccione un elemento v&aacute;lido.</span><span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    <td><input type="button" name="button" id="button" value="Listar" onclick="listarAportesPendientes();" /></td>
  </tr>
  <tr valign="baseline"> </tr>
</table>
<br />
<div id="listado">&nbsp;</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($aportes);

mysql_free_result($personal);

mysql_free_result($Recordset1);
?>
