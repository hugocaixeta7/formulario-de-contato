<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/vendor/autoload.php';

$mail = new PHPMailer(true);

    // Configuração do servidor
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host       = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth   = true;
    $mail->Username   = '5821c4439144a6';
    $mail->Password   = 'ee2acb42deed89';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Destinatário
    $mail->setFrom('Atendimento@hugz.com', 'Atendimento');
    $mail->addAddress($dados['email'], $dados['name']);     

    // Corpo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Recebi a mensagem de contato';
    $mail->Body    = "Prezado(a) {$dados['name']}<br><br>
                      Recebi o seu e-mail e será lido o mais rápido possível.<br><br>
                      <strong>Assunto:</strong> {$dados['subject']}<br>
                      <strong>Conteúdo:</strong> {$dados['content']}";
    $mail->AltBody = "Prezado(a) {$dados['name']}\n\n
                      Recebi o seu e-mail e será lido o mais rápido possível.\n\n
                      Assunto: {$dados['subject']}\n
                      Conteúdo: {$dados['content']}";

    $mail->send();
   
