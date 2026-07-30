<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../../index.html');
    exit;
}

$nome       = htmlspecialchars($_POST['name']);
$sobrenome  = htmlspecialchars($_POST['sobrenome']);
$telefone   = htmlspecialchars($_POST['telefone']);
$email      = htmlspecialchars($_POST['email']);
$assunto    = htmlspecialchars($_POST['subject']);
$mensagem   = nl2br(htmlspecialchars($_POST['message']));

$mail = new PHPMailer(true);

try {

    /*
    |---------------------------------------------------------
    | SMTP KINGHOST
    |---------------------------------------------------------
    */

    $mail->isSMTP();

    $mail->Host       = 'smtp.kinghost.net';
    $mail->SMTPAuth   = true;

    $mail->Username   = 'projetos@aserralheria.com.br';
    $mail->Password   = 'ASerralheria@2026';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->CharSet = 'UTF-8';

    /*
    |---------------------------------------------------------
    | REMETENTE
    |---------------------------------------------------------
    */

    $mail->setFrom(
        'projetos@aserralheria.com.br',
        'Site - A Serralheria'
    );

    /*
    |---------------------------------------------------------
    | DESTINATÁRIOS
    |---------------------------------------------------------
    */

    $mail->addAddress('projetos@aserralheria.com.br');
    $mail->addAddress('emedigitalmkt@gmail.com');

    /*
    |---------------------------------------------------------
    | RESPOSTA
    |---------------------------------------------------------
    */

    $mail->addReplyTo($email, $nome);

    /*
    |---------------------------------------------------------
    | CONTEÚDO
    |---------------------------------------------------------
    */

    $mail->isHTML(true);

    $mail->Subject = "Novo contato pelo site - {$assunto}";

    $mail->Body = "

    <h2>Novo contato recebido</h2>

    <strong>Nome:</strong> {$nome} {$sobrenome}<br><br>

    <strong>Telefone:</strong> {$telefone}<br><br>

    <strong>E-mail:</strong> {$email}<br><br>

    <strong>Assunto:</strong> {$assunto}<br><br>

    <strong>Mensagem:</strong><br>

    {$mensagem}

    ";

    $mail->send();

    header("Location: ../../obrigado.html");
    exit;

} catch (Exception $e) {

    echo "<h2>Erro ao enviar.</h2>";
    echo $mail->ErrorInfo;

}