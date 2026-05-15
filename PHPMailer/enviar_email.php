<?php
/**
 * Script para processar o formulário de contato e enviar e-mail usando PHPMailer
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Ajuste os caminhos conforme sua estrutura
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Configurar cabeçalho para resposta JSON
header('Content-Type: application/json; charset=utf-8');

// Obter dados da requisição
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos.']);
    exit;
}

$nome = htmlspecialchars(strip_tags($data['nome'] ?? ''), ENT_QUOTES, 'UTF-8');
$telefone = htmlspecialchars(strip_tags($data['telefone'] ?? ''), ENT_QUOTES, 'UTF-8');
$email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
$assunto_contato = htmlspecialchars(strip_tags($data['assunto'] ?? ''), ENT_QUOTES, 'UTF-8');
$mensagem = htmlspecialchars(strip_tags($data['mensagem'] ?? ''), ENT_QUOTES, 'UTF-8');

// Validação básica
if (empty($nome) || empty($email) || empty($mensagem)) {
    echo json_encode(['status' => 'error', 'message' => 'Campos obrigatórios faltando.']);
    exit;
}

$mail = new PHPMailer(true);

try {
    // Configurações do Servidor SMTP (Exemplo com Gmail)
    // Para usar o Gmail, você precisa gerar uma "Senha de App" se tiver 2FA
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';                     // Servidor SMTP
    $mail->SMTPAuth   = true;                                 // Habilitar autenticação SMTP
    $mail->Username   = 'gabrielslima480@gmail.com';                // Seu e-mail (USUÁRIO)
    $mail->Password   = 'qjct ycdu cqpu pqyi';                   // Sua senha de app (SENHA)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Habilitar TLS
    $mail->Port       = 587;                                  // Porta TCP

    // Configurações do E-mail
    $mail->setFrom('gabrielslima480@gmail.com', 'Lava Rápido F1 - Contato');
    $mail->addAddress('gabrielslima480@gmail.com');          // E-mail que receberá a mensagem
    $mail->addReplyTo($email, $nome);

    // Conteúdo
    $mail->isHTML(true);
    $mail->Subject = "Novo Contato: " . ucfirst($assunto_contato) . " - " . $nome;
    
    // Corpo do E-mail formatado
    $body = "<h2>Nova mensagem recebida pelo site</h2>";
    $body .= "<p><strong>Nome:</strong> {$nome}</p>";
    $body .= "<p><strong>Telefone:</strong> {$telefone}</p>";
    $body .= "<p><strong>E-mail:</strong> {$email}</p>";
    $body .= "<p><strong>Assunto:</strong> {$assunto_contato}</p>";
    $body .= "<p><strong>Mensagem:</strong><br>" . nl2br($mensagem) . "</p>";
    $body .= "<hr><p>Este e-mail foi enviado automaticamente pelo formulário de contato do Lava Rápido F1.</p>";

    $mail->Body = $body;
    $mail->AltBody = "Nome: {$nome}\nTelefone: {$telefone}\nE-mail: {$email}\nAssunto: {$assunto_contato}\nMensagem:\n{$mensagem}";

    $mail->send();

    // --- REGISTRO LOCAL (Arquivo JSON) ---
    $arquivoLog = 'contatos.json';
    $novoRegistro = [
        'data' => date('d/m/Y H:i'),
        'nome' => $nome,
        'telefone' => $telefone,
        'email' => $email,
        'assunto' => $assunto_contato,
        'mensagem' => $mensagem
    ];

    $registrosAtuais = [];
    if (file_exists($arquivoLog)) {
        $conteudo = file_get_contents($arquivoLog);
        $registrosAtuais = json_decode($conteudo, true) ?: [];
    }
    
    array_unshift($registrosAtuais, $novoRegistro); // Adiciona no topo
    file_put_contents($arquivoLog, json_encode($registrosAtuais, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode(['status' => 'success', 'message' => 'Mensagem enviada e registrada com sucesso!']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "Erro ao enviar: {$mail->ErrorInfo}"]);
}
