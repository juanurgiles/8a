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

if ((isset($_GET['idse'])) && ($_GET['idse'] != "")) {
  $deleteSQL = sprintf("DELETE FROM personal WHERE idPersonal=%s",
                       GetSQLValueString($_GET['idse'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($deleteSQL, $cooperativa) or die(mysql_error());

  $deleteGoTo = "socio_l.php";
  
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_cooperativa, $cooperativa);
$query_personal = "SELECT * FROM personal";
$personal= mysql_query($query_personal, $cooperativa) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);
$totalRows_personal = mysql_num_rows($personal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Socios</title>
</head>

<body>
<h1>Listar de Socios</h1>
<table border="1" class="display" id="example">
  <tr>
    <th>Socio</th>
    <th>Codigo</th>
    <th>Cedula</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Notas</th>
    <th>Direcci&oacute;n</th>
    <th>Provincia</th>
    <th>Sexo</th>
    <th>Estado Civil</th>
    <th>Conyuge</th>
    <th>Telefono</th>
    <th>Celular</th>
    <th>Nuser</th>
    <th>Pwd</th>
    <th>Perfil</th>
    <td colspan="2" align="center"><a href="socio_i.php">Insertar</a></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_personal['idPersonal']; ?></td>
      <td><?php echo $row_personal['codigoPersonal']; ?></td>
      <td><?php echo $row_personal['cedulaPersonal']; ?></td>
      <td><?php echo $row_personal['nombrePersonal']; ?></td>
      <td><?php echo $row_personal['apellidoPersonal']; ?></td>
      <td><?php echo $row_personal['notas']; ?></td>
      <td><?php echo $row_personal['direccion']; ?></td>
      <td><?php echo $row_personal['provincia']; ?></td>
      <td><?php echo $row_personal['sexo']; ?></td>
      <td><?php echo $row_personal['estadoCivil']; ?></td>
      <td><?php echo $row_personal['conyuge']; ?></td>
      <td><?php echo $row_personal['telefono']; ?></td>
      <td><?php echo $row_personal['celular']; ?></td>
      <td><?php echo $row_personal['nuser']; ?></td>
      <td><?php echo $row_personal['pwd']; ?></td>
      <td><?php echo $row_personal['perfil']; ?></td>
      <td><a href="socio_u.php?ids=<?php echo $row_personal['idPersonal']; ?>">Editar</a></td>
      <td><a href="socio_l.php?idse=<?php echo $row_personal['idPersonal']; ?>">Eliminar</a></td>
    </tr>
    <?php } while ($row_= mysql_fetch_assoc($personal)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($personal);
?>
