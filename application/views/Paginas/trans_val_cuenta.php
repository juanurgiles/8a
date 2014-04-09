<?php require_once('../Connections/cooperativa.php'); ?>
<?php

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");


header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");


header("Cache-Control: no-store, no-cache, must-revalidate");


header("Cache-Control: post-check=0, pre-check=0", false);


header("Pragma: no-cache"); 

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

$colname_cuenta = "-1";
if (isset($_GET['numc'])) {
  $colname_cuenta = $_GET['numc'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_cuenta = sprintf("SELECT idCuenta, concat(apellidoPersonal,' ',nombrePersonal) as cliente, estado, saldo FROM cuenta inner join personal on idP=idPersonal WHERE numeroCuenta = %s", GetSQLValueString($colname_cuenta, "text"));
$cuenta = mysql_query($query_cuenta, $cooperativa) or die(mysql_error());
$row_cuenta = mysql_fetch_assoc($cuenta);
$totalRows_cuenta = mysql_num_rows($cuenta);
?>
<?php if ($totalRows_cuenta>0){ ?>
<form id="form1" name="form1" method="post" action="">
  <input name="idCta" type="hidden" id="idCta" value="<?php echo $row_cuenta['idCuenta']; ?>" />
  <input name="estadoCta" type="hidden" id="estadoCta" value="<?php echo $row_cuenta['estado']; ?>" />
  <input name="saldoCta" type="hidden" id="saldoCta" value="<?php echo $row_cuenta['saldo']; ?>" />
  <input name="nomCliente" type="hidden" id="nomCliente" value="<?php echo $row_cuenta['cliente']; ?>" />
</form>
<?php if ($row_cuenta['estado']=="Activo"){?>
Ok
<script>
client=$('#nomCliente').val();
	 $('#NombreCliente').html(client);
	 $('#idCuenta').val($('#idCta').val());
	 $('#btnInsertar').removeAttr("disabled");
</script>
<?php 
}else{
?>Cuenta Inactiva
<script>
client=$('#nomCliente').val();

$('#saldoCta').val();
	 $('#NombreCliente').html(client);
	  $('#btnInsertar').attr("disabled", "disabled");
</script>
	<?php 
}}else{ ?>
La cuenta no existe
<script>
	 $('#NombreCliente').html("ND");
	  $('#btnInsertar').attr("disabled", "disabled");
</script>
<?php }?>
<?php
mysql_free_result($cuenta);
?>
