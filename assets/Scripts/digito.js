// JavaScript Document
// <script> 
function CalcularDv(num1)
{ 
 var vpri, x, y, z, i, nit1, dv1;
 nit1=num1;
	if (isNaN(nit1))
	{
 	document.form1.dv.value="X";
  alert('El valor digitado no es un numero valido');		
	} else {
  vpri = new Array(16); 
 	x=0 ; y=0 ; z=nit1.length ;
 	vpri[1]=3;
 	vpri[2]=7;
 	vpri[3]=13; 
 	vpri[4]=17;
 	vpri[5]=19;
 	vpri[6]=23;
 	vpri[7]=29;
 	vpri[8]=37;
 	vpri[9]=41;
 	vpri[10]=43;
 	vpri[11]=47;  
 	vpri[12]=53;  
 	vpri[13]=59; 
 	vpri[14]=67; 
 	vpri[15]=71;
  for(i=0 ; i<z ; i++)
 	{ 
 	 y=(nit1.substr(i,1));
 		//document.write(y+"x"+ vpri[z-i] +":");
   x+=(y*vpri[z-i]);
 		//document.write(x+"<br>");		
 	} 
  y=x%11
 	//document.write(y+"<br>");
  if (y > 1)
 	{
   dv1=11-y;
 	} else {
   dv1=y;
 	}
 	return dv1;
	}
}
//
var miPopup
function abreVentana2()
{ 
 miPopup = window.open("vacia.htm","Resultado","width=300,height=300,scrollbars=no") 
 miPopup.focus() 
 miPopup.nit2.value = document.form1.nit.value
 miPopup = 0
}	
//
var message="Lfmmtto.com se reserva los Derechos de Autor de esta p�gina."
function click(e)
{
 if (document.all)
	{
  if (event.button==2||event.button==3)
		{
	  alert(message);
	 	return false;
		}
	}
	if (document.layers)
	{
		if (e.which == 3)
		{
			alert(message);
			return false;
		}
	}
}
if (document.layers)
{
	document.captureEvents(Event.MOUSEDOWN);
}
document.onmousedown=click;
// JavaScript Document