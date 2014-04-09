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

mysql_select_db($database_cooperativa, $cooperativa);
$query_cuentas = "select `tipoCuenta`,`numeroCuenta`,concat(`apellidoPersonal`,' ',`nombrePersonal`) as cliente,`cedulaPersonal`,`socio`,`estado` from `personal` as p inner join cuenta on idPersonal=idP";
$cuentas = mysql_query($query_cuentas, $cooperativa) or die(mysql_error());
$row_cuentas = mysql_fetch_assoc($cuentas);
$totalRows_cuentas = mysql_num_rows($cuentas);
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
</head>

<body>
<h1>Cuentas de cliente
</h1>
<p>&nbsp;</p>
<table border="1" class="display" id="example">
<thead>
  <tr>
    <th>Tipo Cta</th>
    <th>N&uacute;mero Cta</th>
    <th>Cliente</th>
    <th>C&eacute;dula</th>
    <th>Tipo Cliente</th>
    <th>Estado</th>
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_cuentas['tipoCuenta']; ?></td>
      <td><?php echo $row_cuentas['numeroCuenta']; ?></td>
      <td><?php echo $row_cuentas['cliente']; ?></td>
      <td><?php echo $row_cuentas['cedulaPersonal']; ?></td>
      <td align="center"><?php echo $row_cuentas['socio']==0?"Cliente":"Socio"; ?></td>
      <td align="center"><?php echo $row_cuentas['estado']; ?></td>
    </tr>
    <?php } while ($row_cuentas = mysql_fetch_assoc($cuentas)); ?>
    </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($cuentas);
?>
