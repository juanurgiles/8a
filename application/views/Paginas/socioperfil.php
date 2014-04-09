<?php require_once('../Connections/cooperativa.php'); ?>
<?php

if (!isset($_SESSION)) {
  session_start();
}

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

$colname_personal = "-1";
if (isset($_GET['ids'])) {
  $colname_personal = $_GET['ids'];
}
mysql_select_db($database_cooperativa, $cooperativa);
$query_personal = sprintf("SELECT * FROM personal WHERE idPersonal = %s", GetSQLValueString($colname_personal, "int"));
$personal = mysql_query($query_personal, $cooperativa) or die(mysql_error());
$row_personal = mysql_fetch_assoc($personal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Perfil del Personal</title>

<style type="text/css">
h3 {
	color: #06F;
	font-size:12px;
}
</style>
</head>

<body>
<table width="100%" border="3" cellspacing="3" cellpadding="5">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="5">
      <tr>
        <th colspan="8"><h1>PERFIL EL SOCIO </h1></th>
      </tr>
      <tr>
        <th colspan="8" bgcolor="#05619B">&nbsp;</th>
      </tr>
      <tr>
        <td height="51"><h3><strong>C&oacute;digo:</strong></h3></td>
        <td height="51" colspan="2" align="left"><?php echo $row_personal['codigoPersonal']; ?></td>
        <td align="right"><h3><strong>C&eacute;dula:</strong></h3></td>
        <td colspan="2" align="left"><?php echo $row_personal['cedulaPersonal']; ?></td>
        <td width="15%" colspan="2" rowspan="4"><table width="99%" height="145" border="2" cellpadding="5" cellspacing="5">
            <tr>
              <td height="55"><?php if (file_exists("personal/socio".$row_personal['cedulaPersonal'].".jpg")){ ?>
                <a href="#"><img src="personal/socio<?php echo $row_personal['cedulaPersonal']; ?>.jpg" alt="Cambiar Foto" width="145" height="150" /></a>
 <?php  
}else{ ?>
 <a href="#"><img src="personal/socio.jpg" alt="Cambiar Foto" width="145" height="150" /></a>
<?php    } ?>
              </td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="2"><h3><strong>Apellidos</strong></h3></td>
        <td colspan="4"><?php echo $row_personal['apellidoPersonal']; ?></td>
      </tr>
      <tr>
        <td colspan="2"><h3><strong>  Nombres:</strong></h3></td>
        <td colspan="4"><?php echo $row_personal['nombrePersonal']; ?></td>
        </tr>
      <tr>
        <td width="13%" height="33"><h3><strong>Sexo: </strong></h3></td>
        <td width="15%" align="left"><?php echo $row_personal['sexo']; ?></td>
        <td>&nbsp;</td>
        <td colspan="2" align="right"><h3><strong>Estado Civil:</strong></h3></td>
        <td width="15%" align="left"><?php echo $row_personal['estadoCivil']; ?></td>
      </tr>
      <tr>
        <td height="23" colspan="8" align="center" bgcolor="#05619B">&nbsp;</td>
        </tr>
      <tr>
        <td height="43"><h3><strong>Provincia: </strong></h3></td>
        <td colspan="3" align="left"><?php echo $row_personal['provincia']; ?></td>
        <td width="14%" align="left"><h3><strong>Direcci&oacute;n:</strong></h3></td>
        <td colspan="3" align="left"><?php echo $row_personal['direccion']; ?></td>
      </tr>
      <tr>
        <td height="46"><h3><strong>Tel&eacute;fono:</strong></h3></td>
        <td align="left"><?php echo $row_personal['telefono']; ?></td>
        <td width="10%"><h3><strong>Celular:</strong></h3></td>
        <td width="18%" align="left"><?php echo $row_personal['celular']; ?></td>
        <td colspan="2"><h3><strong>Nombres del Conyuge:</strong></h3></td>
        <td colspan="2"><?php echo $row_personal['conyuge']; ?></td>
      </tr>
      <tr>
        <td colspan="2"><h3><strong>Nombre Usuario: </strong></h3></td>
        <td colspan="2" align="left"><?php echo $row_personal['nuser']; ?></td>
        <td><h3><strong>Contrase&ntilde;a:</strong></h3></td>
        <td colspan="3" align="left"><?php echo "***";//$row_personal['pwd']; ?></td>
      </tr>
      <tr>
        <td colspan="8" bgcolor="#05619B">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="8"><h3><strong>Notas:</strong></h3></td>
      </tr>
      <tr>
        <td colspan="8"><?php echo $row_personal['notas']; ?></td>
      </tr>
    </table></td>
  </tr>
</table><p><a href="javascript:history.back(1)">Atrás</a></p>
</body>
</html>
<?php
mysql_free_result($personal);
?>
