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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE personal SET codigoPersonal=%s, cedulaPersonal=%s, nombrePersonal=%s, apellidoPersonal=%s, notas=%s, direccion=%s, provincia=%s, sexo=%s, estadoCivil=%s, conyuge=%s, telefono=%s, celular=%s, nuser=%s, pwd=%s, perfil=%s WHERE idPersonal=%s",
                       GetSQLValueString($_POST['codigoPersonal'], "text"),
                       GetSQLValueString($_POST['cedulaPersonal'], "text"),
                       GetSQLValueString($_POST['nombrePersonal'], "text"),
                       GetSQLValueString($_POST['apellidoPersonal'], "text"),
                       GetSQLValueString($_POST['notas'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['provincia'], "text"),
                       GetSQLValueString($_POST['sexo'], "text"),
                       GetSQLValueString($_POST['estadoCivil'], "text"),
                       GetSQLValueString($_POST['conyuge'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString($_POST['nuser'], "text"),
                       GetSQLValueString($_POST['pwd'], "text"),
                       GetSQLValueString($_POST['perfil'], "text"),
                       GetSQLValueString($_POST['idPersonal'], "int"));

  mysql_select_db($database_cooperativa, $cooperativa);
  $Result1 = mysql_query($updateSQL, $cooperativa) or die(mysql_error());

  $updateGoTo = "socio_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_personal = "-1";
if (isset($_GET['ids'])) {
  $colname_personal = $_GET['ids'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_personal = sprintf("SELECT * FROM personal WHERE idPersonal = %s", GetSQLValueString($colname_personal, "int"));
$personal = mysql_query($query_personal, $cooperativa) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);
$totalRows_personal = mysql_num_rows($personal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Editar Socio</title>
</head>

<body>
<h1>Editar Socio </h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Personal:</strong></td>
      <td><?php echo $row_personal['idPersonal']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Codigo:</strong></td>
      <td><input type="text" name="codigoPersonal" value="<?php echo htmlentities($row_personal['codigoPersonal'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Cedula:</strong></td>
      <td><input type="text" name="cedulaPersonal" value="<?php echo htmlentities($row_personal['cedulaPersonal'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Nombre:</strong></td>
      <td><input type="text" name="nombrePersonal" value="<?php echo htmlentities($row_personal['nombrePersonal'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Apellidoo:</strong></td>
      <td><input type="text" name="apellidoPersonal" value="<?php echo htmlentities($row_personal['apellidoPersonal'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Notas:</strong></td>
      <td><input type="text" name="notas" value="<?php echo htmlentities($row_personal['notas'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Direcc&oacute;n:</strong></td>
      <td><input type="text" name="direccion" value="<?php echo htmlentities($row_personal['direccion'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Provincia:</strong></td>
      <td><input type="text" name="provincia" value="<?php echo htmlentities($row_personal['provincia'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Sexo:</strong></td>
      <td><input type="text" name="sexo" value="<?php echo htmlentities($row_personal['sexo'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Estado Civil:</strong></td>
      <td><input type="text" name="estadoCivil" value="<?php echo htmlentities($row_personal['estadoCivil'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Conyuge:</strong></td>
      <td><input type="text" name="conyuge" value="<?php echo htmlentities($row_personal['conyuge'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Telefono:</strong></td>
      <td><input type="text" name="telefono" value="<?php echo htmlentities($row_personal['telefono'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Celular:</strong></td>
      <td><input type="text" name="celular" value="<?php echo htmlentities($row_personal['celular'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Nuser:</strong></td>
      <td><input type="text" name="nuser" value="<?php echo htmlentities($row_personal['nuser'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Pwd:</strong></td>
      <td><input type="text" name="pwd" value="<?php echo htmlentities($row_personal['pwd'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Perfil:</strong></td>
      <td><input type="text" name="perfil" value="<?php echo htmlentities($row_personal['perfil'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idPersonal" value="<?php echo $row_personal['idPersonal']; ?>" />
</form>
<p><a href="javascript:history.back(1)">Atrás</a></p>
</body>
</html>
<?php
mysql_free_result($personal);
?>
