<?php
/*$query_mail = "SELECT * FROM config_email WHERE id_config ='1' ";
$sql_mail = $conexao->prepare($query_mail);
if($sql_mail->execute()){
    $consulta_config = $sql_mail->fetchAll(PDO::FETCH_ASSOC);
    if(count($consulta_config) > 0){
        foreach($consulta_config as $dados_config){

        }
    }else{
        $erro = 'Não foi possível encontrar as configurações do servidor de email';
    }
}else{
    $erro = 'Não foi possível encontrar as configurações do servidor de email';
}*/




 
// Metodo de envido de email

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Instância da classe
$mail = new PHPMailer(true);
try
{
    // Configurações do servidor
    $mail->isSMTP();        //Devine o uso de SMTP no envio
    $mail->SMTPAuth = true; //Habilita a autenticação SMTP
    $mail->Username   = 'atendimento@leaderempresarial.com.br';
    $mail->Password   = '!@lEAATE_1LTO01';
    // Criptografia do envio SSL também é aceito
    $mail->SMTPSecure = 'tls';
    // Informações específicadas pelo Google
    $mail->Host = 'email-ssl.com.br';
    $mail->Port = 587;
    // Define o remetente
    $mail->setFrom('atendimento@leaderempresarial.com.br', 'Atendimento');
    // Define o destinatário
    $mail->addAddress('fabionarcizo@gmail.com', 'Fabio Narcizo');
    // Conteúdo da mensagem
    $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
    $mail->Subject = 'Teste Envio de Email';
    $mail->Body    = 'Este é o corpo da mensagem <b>Olá!</b>';
    $mail->AltBody = 'Este é o cortpo da mensagem para clientes de e-mail que não reconhecem HTML';
    // Enviar
    $mail->send();
    echo '<script>';
    echo 'alert("Mensagem enviada com sucesso!")';
    echo '</script>';    
}
catch (Exception $e)
{
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


?>

