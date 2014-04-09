<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Libreta</title>
<style type="text/css">
body {
	background-image: url(../images/libreta.png);
	background-repeat: no-repeat;
}
#apDiv1 {
	position: absolute;
	left: 16px;
	top: 97px;
	width: 380px;
	height: 83px;
	z-index: 1;
}
#apDiv2 {
	position: absolute;
	left: 338px;
	top: 580px;
	width: 82px;
	height: 16px;
	z-index: 2;
}
.titulo{
	
	font-style:italic;
	font-weight:bold;
	color:#05609A;
}

</style>
</head>

<body>
<div id="apDiv1">
  <p><span class="titulo">Cuenta:</span> &nbsp;&nbsp;&nbsp;<?php echo $_GET['cta']; ?><br /><br />
    <span class="titulo">Cliente:</span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_GET['cte']; ?></p>
</div>
<div id="apDiv2"></div>
</body>
</html>