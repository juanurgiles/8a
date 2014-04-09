<?php /*
$to = "email";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "email";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";*/
?>
<?php
//print_r($_POST);
if(isset($_POST['Asunto'])){
 $to = "info@cooperativa8deagosto.com";
 $subject = "Mensaje desde la web - ".$_POST['Asunto'];
 $body = "De: ".$_POST['Nombre']." ".$_POST['Apellido']."\nE-mail: ".$_POST['Email']."\nTeléfono: ".$_POST['Telefono']."\n\n".$_POST['Mensaje'];
 
// echo $to."/n".$subject."/n".$body;
 
if (mail($to, $subject, $body)) {
   echo("<p>Mensaje enviado Correctamente!</p>");
  } else {
   echo("<p>No se puede enviar su mensaje, intente más tarde/p>");
  }}
 ?>