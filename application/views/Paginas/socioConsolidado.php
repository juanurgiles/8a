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

$colname_aportes = "-1";
if (isset($_GET['ids'])) {
  $colname_aportes = $_GET['ids'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_aportes = sprintf("SELECT * FROM aportes WHERE idPersonal = %s ORDER BY fecha DESC limit 0,5", GetSQLValueString($colname_aportes, "int"));
$aportes = mysql_query($query_aportes, $cooperativa) or die(mysql_error());
$row_aportes = mysql_fetch_assoc($aportes);
$totalRows_aportes = mysql_num_rows($aportes);

$colname_socio = "-1";
if (isset($_GET['ids'])) {
  $colname_socio = $_GET['ids'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_socio = sprintf("SELECT nombrePersonal, apellidoPersonal, socio FROM personal WHERE idPersonal = %s", GetSQLValueString($colname_socio, "int"));
$socio = mysql_query($query_socio, $cooperativa) or die(mysql_error());
$row_socio = mysql_fetch_assoc($socio);
$totalRows_socio = mysql_num_rows($socio);

$colname_Cuentas = "-1";
if (isset($_GET['ids'])) {
  $colname_Cuentas = $_GET['ids'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_Cuentas = sprintf("SELECT * FROM cuenta WHERE idP = %s ORDER BY tipoCuenta ASC", GetSQLValueString($colname_Cuentas, "int"));
$Cuentas = mysql_query($query_Cuentas, $cooperativa) or die(mysql_error());
$row_Cuentas = mysql_fetch_assoc($Cuentas);
$totalRows_Cuentas = mysql_num_rows($Cuentas);

$colname_Creditos = "-1";
if (isset($_GET['ids'])) {
  $colname_Creditos = $_GET['ids'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_Creditos = sprintf("SELECT * FROM creditos WHERE idPersonal = %s and creditos.estado='Vigente'", GetSQLValueString($colname_Creditos, "int"));
$Creditos = mysql_query($query_Creditos, $cooperativa) or die(mysql_error());
$row_Creditos = mysql_fetch_assoc($Creditos);
$totalRows_Creditos = mysql_num_rows($Creditos);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t�tulo</title>
<script src="<?php echo $assets ?>SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="<?php echo $assets ?>SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Actividades del <?php echo $socio->socio==1?"Socio":"Cliente"; ?></h1>
<p><?php echo $socio->apellidoPersonal; ?> <?php echo $socio->nombrePersonal; ?></p>
<?php if ($socio->socio==1){
?>
<div id="CollapsiblePanel1" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0"><h2>Aportes <img src="<?php echo $assets ?>images/b_browse.png" width="16" height="16" /></h2></div>
  <div class="CollapsiblePanelContent"><?php if (count($aportes)>0){?><table border="1">
  <tr>
    <td>idAportes</td>
    <td>fecha</td>
    <td>idPersonal</td>
    <td>valor</td>
  </tr>
  <?php foreach ($aportes as $aporte) {
          
      ?>
    <tr>
      <td><?php echo $aporte->idAportes; ?></td>
      <td><?php echo $aporte->fecha; ?></td>
      <td><?php echo $aporte->idPersonal; ?></td>
      <td><?php echo $aporte->valor; ?></td>
    </tr>
    <?php } //while ($row_aportes = mysql_fetch_assoc($aportes)); ?>
</table><?php } else{ echo "No dispone informaci�n de Aportes"; }?></div>
</div>
<?php } ?>
<br />
<div id="CollapsiblePanel2" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0"><h2>Cuentas <img src="<?php echo $assets ?>images/b_insrow.png" width="16" height="16" /></h2></div>
  <div class="CollapsiblePanelContent"><?php if(count($cuentas)>0){?><table border="1">
  <tr>
    <td>idCuenta</td>
    <td>tipoCuenta</td>
    <td>numeroCuenta</td>
    <td>estado</td>
    <td>saldo</td>
    <td>Ultimo Movimiento</td>
  </tr>
  <?php foreach ($cuentas as $cuenta) {
       
    ?>
    <tr>
      <td><?php echo $cuenta->idCuenta; ?></td>
      <td><?php echo $cuenta->tipoCuenta; ?></td>
      <td><a href="#"><?php echo $cuenta->numeroCuenta; ?></a></td>
      <td><?php echo $cuenta->estado; ?></td>
      <td><?php echo $cuenta->saldo; ?></td>
      <td>&nbsp;</td>
    </tr>
    <?php } //while ($row_Cuentas = mysql_fetch_assoc($Cuentas)); ?>
</table><?php } else{ echo "No dispone informaci�n de Cuentas"; }?></div>
</div>
<br />
<div id="CollapsiblePanel3" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0"><h2>Cr&eacute;ditos <img src="<?php echo $assets ?>images/b_insrow.png" width="16" height="16" /></h2></div>
  <div class="CollapsiblePanelContent"><?php if (count($creditos)>0){ ?><table border="1">
  <tr>
    <td>idCredito</td>
    <td>Fecha</td>
    <td>detalle</td>
    <td>montototal</td>
    <td>Monto Pagado</td>
    <td>Pagos Pendientes</td>
  </tr>
  <?php foreach ($creditos as $credito) {
           
        ?>
    <tr>
      <td><?php echo $credito->idCredito; ?></td>
      <td><?php echo $credito->fechaCredito; ?></td>
      <td><a href="creditos_rpt.php?idc=<?php echo $credito->idCredito; ?>" target="_blank"><?php echo $credito->detalle; ?></a></td>
      <td><?php echo $credito->montototal; ?></td>
      <td>&nbsp;</td>
      <td><?php echo $credito->numeropagos; ?></td>
    </tr>
    <?php } //while ($row_Creditos = mysql_fetch_assoc($Creditos)); ?>
</table><?php } else{ echo "No dispone informaci�n de Creditos"; }?></div>
</div>
<p><a href="javascript:history.back(1)">Atr�s</a></p>
<script type="text/javascript">
<?php if ($socio->socio==1){
?>
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
<?php } ?>
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", {contentIsOpen:false});
var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3", {contentIsOpen:false});
</script>
</body>
</html>
<?php
//mysql_free_result($aportes);
//
//mysql_free_result($socio);
//
//mysql_free_result($Cuentas);
//
//mysql_free_result($Creditos);
?>
