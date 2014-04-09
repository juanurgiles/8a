<?php 
$assets = base_url()."assets/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administrador - Cooperativa 8 de Agosto</title>
<script src="<?php echo $assets ?>SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="<?php echo $assets ?>SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #000;
	
}
#contenido {
	width: 700px;
	height: 600px;
	z-index: 1;
	}
</style>
<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>

<body onload="MM_preloadImages('<?php echo $assets ?>images/salir1.png')">
<table width="0%" border="3" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td bgcolor="#05619B"><table border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td align="center" bgcolor="#05619B"><img src="<?php echo $assets ?>images/logo2.png" alt="" width="192" height="119" /></td>
        <td colspan="2"><img src="<?php echo $assets ?>images/blank.gif" width="650" height="10" /><br />
          <img src="<?php echo $assets ?>images/coop.png" alt="" width="539" height="109" /></td>
        </tr>
      <tr>
        <td bgcolor="#EEEEEE"></td>
        <td bgcolor="#FFFFFF"><h2><em>Men&uacute; de Administrador</em></h2></td>
        <td align="right" bgcolor="#FFFFFF"><a href="desconectar.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image4','','<?php echo $assets ?>images/salir1.png',1)"><img src="<?php echo $assets ?>images/salir.png" alt="Salir" width="72" height="37" id="Image4" border="0" /></a></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#EEEEEE"><ul id="MenuBar1" class="MenuBarVertical">
          <li><a href="#" class="MenuBarItemSubmenu"><strong>Socios</strong></a>
            <ul>
              <li><a href="<?php echo base_url() ?>index.php/sistema/socio/1" target="contenido">Listado de Socios</a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/socio/0" target="contenido">Listado de Clientes</a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/s_cuentas.php" target="contenido">Movimiento de Cuentas</a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/creditos_l.php" target="contenido">Cr�ditos</a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/aporteperfil.php" target="contenido">Aportes</a></li>
              </ul>
            </li>
          <li><a href="#" class="MenuBarItemSubmenu"><strong>Reportes</strong></a>
            <ul>
              <li><a href="actual/retiro_l.php" target="contenido">Transacciones</a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/aporteperfil.php" target="contenido">Aportes </a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/creditos_l.php" target="contenido">Cr�dito</a></li>
                     </ul>
          </li> 
<li><a href="#" class="MenuBarItemSubmenu"><strong>Mantenimiento</strong></a>
  <ul>
              <li><a href="<?php echo base_url() ?>index.php/sistema/opciones_l.php?tipo=2" target="contenido">Inter�s Mora</a>              </li>
<li><a href="<?php echo base_url() ?>index.php/sistema/opciones_lt.php?tipo=TipoCuenta" target="contenido">Tipo Cuenta</a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/opciones_lt.php?tipo=Estado" target="contenido">Estados</a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/opciones_li.php?tipo=TipoCredito" target="contenido">Tipo de Cr�dito</a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/opciones_lt.php?tipo=EstadoCredito" target="contenido">Estado de Cr�dito</a></li>
              <li><a href="<?php echo base_url() ?>index.php/sistema/opciones_lt.php?tipo=TipoTransaccion" target="contenido">Tipo de Transacci�n</a></li>
               <li><a href="<?php echo base_url() ?>index.php/sistema/opciones_li.php?tipo=Aporte" target="contenido">Valor de Aporte</a></li>
               <li><a href="<?php echo base_url() ?>index.php/sistema/opciones_li.php?tipo=MoraAporte" target="contenido">Mora en Aporte</a></li>
  </ul>
        </li>
        <li><a href="desconectar.php"><strong>Salir</strong></a></li>
        </ul></td>
        <td colspan="2" bgcolor="#FFFFFF"><iframe id="contenido" name="contenido" src="<?php echo base_url() ?>index.php/sistema/inicio">__</iframe></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
    </table></td>
</tr>
</table>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"<?php echo $assets ?>SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>