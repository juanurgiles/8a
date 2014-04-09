<?php //require_once('Connections/cooperativa.php'); ?>
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
}*/
?>
<?php/*
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['text1'])) {
  $loginUsername=$_POST['text1'];
  $password=$_POST['password1'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php?error=1";
  $MM_redirectLoginFailed = "index.php?error=1";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_cooperativa, $cooperativa);
  
  $LoginRS__query=sprintf("SELECT nuser, pwd,idPersonal, perfil FROM personal WHERE nuser=%s AND pwd=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $cooperativa) or die(mysql_error());
  $row_LoginRS = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
	$_SESSION['idPersonal']=$row_LoginRS['idPersonal'];
	$_SESSION['perfil']=$row_LoginRS['perfil'];
	
	$MM_redirectLoginSuccess = "main".$row_LoginRS['perfil'].".php";

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}*/
?>
<?php 
$assets = base_url()."assets/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
<style type="text/css">
body {
	background-color: #000;
}
</style>
<?php // if (isset($_GET['error'])){
//echo "<script>alert('Error de inicio de Sesi�n');</script>";
//}?>
<link href="<?php echo $assets ?>SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $assets ?>SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $assets ?>SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="<?php echo $assets ?>SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
</head>

<body>
s
<table width="0%" border="3" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td bgcolor="#05619B"><table border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td align="center"><img src="<?php echo $assets ?>images/logo2.png" alt="" width="192" height="119" /></td>
        <td><img src="<?php echo $assets ?>images/blank.gif" width="650" height="10" /><br />
          <img src="<?php echo $assets ?>images/coop.png" alt="" width="539" height="109" /></td>
        </tr>
      <tr>
        <td align="center" bgcolor="#EEEEEE"><img src="<?php echo $assets ?>images/blank.gif" width="100" height="154" /></td>
        <td bgcolor="#FFFFFF"><h2><em>Inicio de Sesi&oacute;n</em></h2>
          <form id="form1" name="form1" method="POST" action="<?php //echo $loginFormAction; ?>"><table width="0%" border="3" cellspacing="0" cellpadding="5">
          <tr>
            <td><table border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td><strong>Usuario:</strong></td>
                <td><span id="sprytextfield1">
                  <input type="text" name="text1" id="text1" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
              </tr>
              <tr>
                <td><strong>Contrase&ntilde;a:</strong></td>
                <td><span id="sprypassword1">
                  <input type="password" name="password1" id="password1" />
                  <span class="passwordRequiredMsg">Se necesita un valor.</span></span></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input type="submit" name="button" id="button" value="Entrar" /></td>
                </tr>
            </table></td>
          </tr>
        </table>
          </form>
          </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
</tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {validateOn:["blur"]});
</script>
</body>
</html>