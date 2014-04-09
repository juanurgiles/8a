<?php 
$assets = base_url()."assets/";
?>
<?php
/*
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
$error="";
if ((isset($_GET['idse'])) && ($_GET['idse'] != "")) {
  $deleteSQL = sprintf("DELETE FROM personal WHERE idPersonal=%s",
                       GetSQLValueString($_GET['idse'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($deleteSQL, $cooperativa) or $error="No se puede Eliminar el registro";
}

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_cooperativa, $cooperativa);
$query_personal = "SELECT idPersonal, codigoPersonal, cedulaPersonal, nombrePersonal, apellidoPersonal FROM personal where socio=".$_GET['id'];
$personal = mysql_query($query_personal, $cooperativa) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);
$totalRows_personal = mysql_num_rows($personal);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Personal</title>
	<meta charset="utf-8" />
<?php 
foreach($tabla->css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($tabla->js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<?php /*if ($error<>""){ ?>
<!--<script>
alert("<?php echo $error; ?>");
</script>-->
<?php } */?>
</head>

<body>
<h1>Listado de <?php echo $id==1?"Socios":"Clientes"; ?></h1>
<p>&nbsp;</p>
<div>
    <?php echo $tabla->output ?>
</div>
<!--<table class="display" id="example">
        <thead>
        <tr>
          <th>Codigo</th>
          <th>Nombre </th>
          <td>&nbsp;</td>
          <td><a href="socio_i.php?id=<?php /*echo $_GET['id']; ?>"><img src="../images/b_insrow.png" width="16" height="16" border="0" /></a></td>
          <td>&nbsp;</td>
  </tr></thead><tbody>
        <?php do { ?>
        <tr>
          <td><?php echo $row_personal['codigoPersonal']; ?></td>
          <td><a href="socioperfil.php?ids=<?php echo $row_personal['idPersonal']; ?>"><?php echo $row_personal['apellidoPersonal']; ?>&nbsp;<?php echo $row_personal['nombrePersonal']; ?></a></td>
          <td><a href="socioConsolidado.php?ids=<?php echo $row_personal['idPersonal']; ?>"><img src="../images/b_browse.png" width="16" height="16" border="0" /></a></td>
          <td><a href="socio_u.php?ids=<?php echo $row_personal['idPersonal']; ?>"><img src="../images/b_edit.png" width="16" height="16" border="0" /></a></td>
          <td><a href="socio.php?id=<?php echo $_GET['id']; ?>&idse=<?php echo $row_personal['idPersonal']; ?>"><img src="../images/b_drop.png" width="16" height="16" border="0" /></a></td>
        </tr>
        <?php } while ($row_personal = mysql_fetch_assoc($personal)); */?>
</tbody>
</table>-->
</body>
</html>
<?php
//mysql_free_result($personal);
?>
