<?php
/**
 * Backend para Processamento de Agendamentos - Lava Rápido F1
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

header('Content-Type: application/json; charset=utf-8');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos.']);
    exit;
}

// Sanitização
$nome = htmlspecialchars(strip_tags($data['nome'] ?? ''), ENT_QUOTES, 'UTF-8');
$telefone = htmlspecialchars(strip_tags($data['telefone'] ?? ''), ENT_QUOTES, 'UTF-8');
$email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
$servico = htmlspecialchars(strip_tags($data['servico'] ?? ''), ENT_QUOTES, 'UTF-8');
$data_agend = htmlspecialchars(strip_tags($data['data'] ?? ''), ENT_QUOTES, 'UTF-8');
$hora = htmlspecialchars(strip_tags($data['hora'] ?? ''), ENT_QUOTES, 'UTF-8');
$delivery = isset($data['delivery']) && $data['delivery'] ? 'Sim' : 'Não';
$endereco = htmlspecialchars(strip_tags($data['endereco'] ?? 'Não informado'), ENT_QUOTES, 'UTF-8');
$mensagem = htmlspecialchars(strip_tags($data['mensagem'] ?? ''), ENT_QUOTES, 'UTF-8');

if (empty($nome) || empty($email) || empty($servico) || empty($data_agend)) {
    echo json_encode(['status' => 'error', 'message' => 'Campos obrigatórios faltando.']);
    exit;
}

// --- REGISTRO LOCAL (Arquivo JSON) ---
$arquivoLog = 'agendamentos.json';
$novoAgendamento = [
    'data_registro' => date('d/m/Y H:i'),
    'nome' => $nome,
    'telefone' => $telefone,
    'email' => $email,
    'servico' => $servico,
    'data_agendamento' => $data_agend,
    'hora' => $hora,
    'delivery' => $delivery,
    'endereco' => $endereco,
    'mensagem' => $mensagem,
    'status' => 'Pendente'
];

$registrosAtuais = [];
if (file_exists($arquivoLog)) {
    $conteudo = file_get_contents($arquivoLog);
    $registrosAtuais = json_decode($conteudo, true) ?: [];
}
array_unshift($registrosAtuais, $novoAgendamento);
file_put_contents($arquivoLog, json_encode($registrosAtuais, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// --- ENVIO DE E-MAILS ---
$mail = new PHPMailer(true);

try {
    // Configurações SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'gabrielslima480@gmail.com';
    $mail->Password   = 'qjct ycdu cqpu pqyi'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // 1. Notificação para o Dono
    $mail->setFrom('gabrielslima480@gmail.com', 'Sistema F1 - Novo Agendamento');
    $mail->addAddress('gabrielslima480@gmail.com');
    $mail->addReplyTo($email, $nome);

    $mail->isHTML(true);
    $mail->Subject = "Novo Agendamento: {$servico} - {$nome}";
    
    $bodyDono = "<h2>Nova Solicitação de Agendamento</h2>";
    $bodyDono .= "<p><strong>Cliente:</strong> {$nome}</p>";
    $bodyDono .= "<p><strong>Telefone:</strong> {$telefone}</p>";
    $bodyDono .= "<p><strong>E-mail:</strong> {$email}</p>";
    $bodyDono .= "<p><strong>Serviço:</strong> {$servico}</p>";
    $bodyDono .= "<p><strong>Data:</strong> " . date('d/m/Y', strtotime($data_agend)) . " às {$hora}</p>";
    $bodyDono .= "<p><strong>Delivery:</strong> {$delivery}</p>";
    if ($delivery === 'Sim') $bodyDono .= "<p><strong>Endereço:</strong> {$endereco}</p>";
    $bodyDono .= "<p><strong>Observações:</strong> {$mensagem}</p>";
    
    $mail->Body = $bodyDono;
    $mail->send();

    // 2. Confirmação para o Cliente
    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = "Confirmação de Solicitação - Lava Rápido F1";
    
    $bodyCliente = "<h2>Olá {$nome}, recebemos sua solicitação!</h2>";
    $bodyCliente .= "<p>Obrigado por escolher o Lava Rápido F1. Sua solicitação de agendamento está sendo processada.</p>";
    $bodyCliente .= "<h3>Detalhes da Solicitação:</h3>";
    $bodyCliente .= "<ul>";
    $bodyCliente .= "<li><strong>Serviço:</strong> {$servico}</li>";
    $bodyCliente .= "<li><strong>Data sugerida:</strong> " . date('d/m/Y', strtotime($data_agend)) . " às {$hora}</li>";
    $bodyCliente .= "<li><strong>Status:</strong> Aguardando confirmação da equipe</li>";
    $bodyCliente .= "</ul>";
    $bodyCliente .= "<p>Em breve entraremos em contato via WhatsApp para confirmar o horário.</p>";
    $bodyCliente .= "<br><p>Atenciosamente,<br>Equipe Lava Rápido F1</p>";

    $mail->Body = $bodyCliente;
    $mail->send();

    echo json_encode(['status' => 'success', 'message' => 'Agendamento solicitado com sucesso! Verifique seu e-mail.']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "Erro ao enviar notificações: {$mail->ErrorInfo}"]);
}
