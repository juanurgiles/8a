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

if ((isset($_GET['idce'])) && ($_GET['idce'] != "")) {
  $deleteSQL = sprintf("DELETE FROM creditos WHERE idCredito=%s",
                       GetSQLValueString($_GET['idce'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($deleteSQL, $cooperativa) or die(mysql_error());

  $deleteGoTo = "creditos_l.php";
    header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_creditos = "select idCredito,tipoCredito,montototal,numeropagos,estado,fechaCredito, concat(apellidoPersonal,' ',nombrePersonal) as cliente from creditos c inner join personal p  on p.idPersonal=c.idPersonal order by fechaCredito desc";
$creditos = mysql_query($query_creditos, $cooperativa) or die(mysql_error());
$row_creditos = mysql_fetch_assoc($creditos);
$totalRows_creditos = mysql_num_rows($creditos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Listar Cr&eacute;dito</title>
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
<h1>Listar Crédito
</h1>
<table border="1" class="display" id="example">
<thead>
  <tr>
    <th>Fecha</th>
    <th>Tipo</th>
    <th>Cliente</th>
    <th>Monto</th>
    <th>Tiempo</th>
    <th>Estado</th>
    <th align="center"><strong><a href="creditos_i.php"><img src="../images/b_insrow.png" width="16" height="16" /></a></strong></th>
    <th align="center">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr>
      <td nowrap><?php echo substr($row_creditos['fechaCredito'],0,10); ?></td>
      <td><?php echo $row_creditos['tipoCredito']; ?></td>
      <td nowrap><?php echo $row_creditos['cliente']; ?></td>
      <td><?php echo $row_creditos['montototal']; ?></td>
      <td><?php echo $row_creditos['numeropagos']; ?></td>
      <td><?php echo $row_creditos['estado']; ?></td>
      <td><a href="creditos_rpt.php?idc=<?php echo $row_creditos['idCredito']; ?>" target="_blank"><img src="../images/b_browse.png" width="16" height="16" /></a></td>
      <td><a href="creditos_l.php?idce=<?php echo $row_creditos['idCredito']; ?>"><img src="../images/b_drop.png" width="16" height="16" /></a></td>
      </tr>
    <?php } while ($row_creditos = mysql_fetch_assoc($creditos)); ?>
    </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($creditos);
?>
