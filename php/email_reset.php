<?php
$mail = $_POST['email']; // destinataire du mail
$crlf = "\r\n";
$message_txt = "Bienvenue sur notre site. veuillez cliquer sur ce lien pour changer votre mdp : http://localhost/projet%20commum/Projet-formation/password_reset.php?email=". $_POST['email'] ."&token=".$token;  // contenu du mail en texte simple
$message_html = "<html><head></head><body>Bienvenue sur notre site. <a href='php/validate_email.php'>Veuillez cliquer sur ce lien pour valider votre addresse mail.</a></body></html>"; // contenu du mail en html
$boundary = "-----=".md5(rand());
$sujet = "Sujet";   // sujet du mail
$header = "From: \"Notre site\"<notresite@exemple.com>".$crlf;    // expediteur
$header.= "Reply-to: \"Notre site\" <reply.notresite@exemple.com>".$crlf;   // personne en retour de mail
$header.= "MIME-Version: 1.0".$crlf;
$header.= "Content-Type: multipart/alternative;".$crlf." boundary=\"$boundary\"".$crlf;
$message = $crlf."--".$boundary.$crlf;
$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$crlf;
$message.= "Content-Transfer-Encoding: 8bit".$crlf;
$message.= $crlf.$message_txt.$crlf;
$message.= $crlf."--".$boundary.$crlf;
$message.= "Content-Type: text/html; charset=\"UTF-8\"".$crlf;
$message.= "Content-Transfer-Encoding: 8bit".$crlf;
$message.= $crlf.$message_html.$crlf;
$message.= $crlf."--".$boundary."--".$crlf;
$message.= $crlf."--".$boundary."--".$crlf;
mail($mail,$sujet,$message,$header);