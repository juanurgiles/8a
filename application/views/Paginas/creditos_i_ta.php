<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
</head>

<body>
<?php //print_r($_GET); 
$ncuotas=$_GET['tiempo'];
$cuota=$_GET['cuota'];
$saldo=$_GET['saldo']; 
$interes=$_GET['interes']; 
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0"><thead>
  <tr>
    <th align="center">No.</th>
    <th align="center">Fecha</th>
    <th align="center">Capital</th>
    <th align="center">Inter&eacute;s</th>
    <th align="center">Cuota</th>
    <th align="center">Saldo</th>
  </tr>
  </thead>
  <tbody>
  <?php
$Fecha = date("Y-m-d"); 
$sumaCuota=0;

   for($i=1;$i<=$ncuotas;$i++){
	   $intMes=$saldo*$interes/100/12;
	   $capital=$cuota-$intMes;
	   $saldo=$saldo-$capital ?>
  <tr>
    <td align="center"><?php echo $i; ?></td>
    <td align="center"><?php $Fecha= date("Y-m-d", strtotime("$Fecha +1 month")); echo $Fecha;
	 ?>&nbsp;</td>
    <td align="right"><?php printf("%.2f",$capital); ?></td>
    <td align="right"><?php printf("%.2f",$intMes); ?>&nbsp;</td>
    <td align="right"><?php $sumaCuota+=$cuota; echo $cuota; ?>&nbsp;</td>
    <td align="right"><?php printf("%.2f",$saldo); ?></td>
  </tr><?php } ?>
  <tr>
    <td colspan="4" align="right"><strong>Total a pagar:</strong></td>
    <td align="right"><?php echo $sumaCuota ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>
<p>&nbsp;</p>
</body>
</html>