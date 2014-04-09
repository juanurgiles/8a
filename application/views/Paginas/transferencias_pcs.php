<?php 
$idpwd=explode(";",$_POST['idCtaOrigen']);
echo $idpwd[0]."<br />";
echo $idpwd[1];
if ($_POST['pwd']==$idpwd[1]){
echo "Procesar";	



}else{
$error="No se puede procesar; verifique su clave de transferencias";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<h1>Recibo de Transferencia</h1>
<h2 style="color:#F00"><?php echo $error; ?> 
</h2>
<p><?php print_r($_POST); ?></p>
</body>
</html>