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

if ((isset($_GET['idOe'])) && ($_GET['idOe'] != "")) {
  $deleteSQL = sprintf("DELETE FROM opciones WHERE idO=%s",
                       GetSQLValueString($_GET['idOe'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($deleteSQL, $cooperativa) or die(mysql_error());

  $deleteGoTo = "opciones_l.php";
  
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_opciones = "-1";
if (isset($_GET['tipo'])) {
  $colname_opciones = $_GET['tipo'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_opciones = sprintf("SELECT * FROM opciones WHERE idO = %s", GetSQLValueString($colname_opciones, "int"));
$opciones = mysql_query($query_opciones, $cooperativa) or die(mysql_error());
$row_opciones = mysql_fetch_assoc($opciones);
$totalRows_opciones = mysql_num_rows($opciones);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista Opciones</title>
</head>

<body>
<h1><?php echo $row_opciones['cvalor_o']; ?></h1>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td><table align="center" cellpadding="2" cellspacing="2" class="display" id="example">
      <tr>
        <th align="center" bgcolor="#05619B">Descripci&oacute;n</th>
        <th align="center" bgcolor="#05619B">Porcentaje</th>
        <td align="center" bgcolor="#05619B">&nbsp;</td>
      </tr>
      <?php do { ?>
      <tr>
        <td><?php echo $row_opciones['cvalor_o']; ?></td>
        <td><?php echo $row_opciones['fvalor_o']; ?></td>
        <td><a href="opciones_u.php?idO=<?php echo $row_opciones['idO']; ?>">Editar</a></td>
      </tr>
      <?php } while ($row_opciones = mysql_fetch_assoc($opciones)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($opciones);
?>
