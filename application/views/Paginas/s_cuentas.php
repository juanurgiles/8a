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

$estado= "Activo";
if(isset($_POST['estadoCta'])){
	$estado=$_POST['estadoCta'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_cuentas = "SELECT `nombrePersonal`,`apellidoPersonal`,`numeroCuenta`,`tipoCuenta`,`saldo`,`fechaApertura`,`fechaUltTrans`,`estado` FROM cuenta   inner join personal on idP=idPersonal WHERE estado ='".$estado."' order by apellidoPersonal, nombrePersonal, tipoCuenta,numeroCuenta";
$cuentas = mysql_query($query_cuentas, $cooperativa) or die(mysql_error());
$row_cuentas = mysql_fetch_assoc($cuentas);
$totalRows_cuentas = mysql_num_rows($cuentas);
//echo $query_cuentas;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
<style type="text/css" title="currentStyle">@import "../media/css/demo_page.css";@import "../media/css/demo_table.css";</style>
<script type="text/javascript" language="javascript" src="../media/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../media/js/jquery.dataTables.js"></script>
<script type="text/javascript">
			jQuery.fn.dataTableExt.aTypes.push(
				function ( sData ) {
					return 'html';
				}
			);
			
			$(document).ready(function() {

				$('#example').dataTable();
			} );
		</script>
        <script>
		function suspenderCta(nc,est){
		if(confirm("Cambiar a "+est+" la cuenta: "+nc)){
eval('$("#suspender'+nc+'").load("s_cuentas_s.php?idc='+nc+'&est='+est+'");');
		}		
		}
		</script>
</head>

<body>
<h1>Movimiento de Cuentas
</h1>
<form id="form1" name="form1" method="post" action="">
  <select name="estadoCta" id="estadoCta">
    <option value="Activo">Activo</option>
    <option value="Inactivo">Inactivo</option>
  </select>
  <input type="submit" name="button" id="button" value="Enviar" />
</form>
<p><?php // print_r($_POST);?>&nbsp;</p>
<table  class="display" id="example">
  <thead>
  <tr>
    <th>Cliente</th>
    <th>Tipo Cuenta</th>
    <th>Numero de Cuenta </th>
    <th>Saldo</th>
    <th>Fecha &uacute;ltima Transacci&oacute;n</th>
    <th>Estado</th>
    <th><a href="s_cuentas_i.php" target="contenido"><img src="../images/b_insrow.png" width="16" height="16" /></a></th>
  </tr>
 </thead>
 <tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_cuentas['apellidoPersonal']; ?> <?php echo $row_cuentas['nombrePersonal']; ?></td>
      <td><?php echo $row_cuentas['tipoCuenta']; ?></td>
      <td><a href="libreta.php?cta=<?php echo $row_cuentas['numeroCuenta']; ?>&amp;cte=<?php echo $row_cuentas['apellidoPersonal']; ?> <?php echo $row_cuentas['nombrePersonal']; ?>" target="_blank"><?php echo $row_cuentas['numeroCuenta']; ?></a></td>
      <td><?php echo $row_cuentas['saldo']; ?></td>
      <td><?php echo $row_cuentas['fechaUltTrans']; ?></td>
      <td><?php echo $row_cuentas['estado']; ?></td>
      <td><div id="suspender<?php echo $row_cuentas['numeroCuenta']; ?>"><?php if($row_cuentas['estado']=="Inactivo") { ?><a href="#" onclick="suspenderCta(<?php echo $row_cuentas['numeroCuenta']; ?>,'Activo');">Activar</a><?php } else { ?><a href="#" onclick="suspenderCta(<?php echo $row_cuentas['numeroCuenta']; ?>,'Inactivo');">Suspender</a><?php }?></div>
        </td>
    </tr>
    <?php } while ($row_cuentas = mysql_fetch_assoc($cuentas)); ?></tbody>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($cuentas);
?>
