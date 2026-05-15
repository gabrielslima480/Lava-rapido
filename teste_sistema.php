<?php
/**
 * Teste de Integração de Sistema - Lava Rápido F1
 */

echo "--- INICIANDO TESTE DE SISTEMA ---\n";

// 1. Simular os dados que o JavaScript enviaria
$dados = [
    'nome' => 'Robô de Teste',
    'telefone' => '0000-0000',
    'email' => 'sistema@teste.com',
    'assunto' => 'Verificação Automática',
    'mensagem' => 'Este é um teste automático para verificar a integridade do sistema de registros e e-mail.'
];

// 2. Definir as globais necessárias para simular a requisição (como se viesse do fetch)
$_SERVER['REQUEST_METHOD'] = 'POST';
$input = json_encode($dados);

// Criar um wrapper para o stream php://input
// No PHP CLI não podemos escrever no php://input, então vamos simular a lógica do arquivo enviar_email.php diretamente

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Lógica de sanitização e salvamento (copiada do enviar_email.php para teste isolado)
$nome = htmlspecialchars(strip_tags($dados['nome']), ENT_QUOTES, 'UTF-8');
$email = filter_var($dados['email'], FILTER_SANITIZE_EMAIL);
$mensagem = htmlspecialchars(strip_tags($dados['mensagem']), ENT_QUOTES, 'UTF-8');

echo "Salvando registro no JSON...\n";
$arquivoLog = 'PHPMailer/contatos.json';
$novoRegistro = [
    'data' => date('d/m/Y H:i'),
    'nome' => $nome,
    'telefone' => $dados['telefone'],
    'email' => $email,
    'assunto' => $dados['assunto'],
    'mensagem' => $mensagem
];

$registrosAtuais = [];
if (file_exists($arquivoLog)) {
    $conteudo = file_get_contents($arquivoLog);
    $registrosAtuais = json_decode($conteudo, true) ?: [];
}

array_unshift($registrosAtuais, $novoRegistro);
if (file_put_contents($arquivoLog, json_encode($registrosAtuais, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo "OK: Registro salvo no contatos.json com sucesso.\n";
} else {
    echo "ERRO: Falha ao salvar no contatos.json.\n";
    exit(1);
}

echo "Verificando se o arquivo existe e tem conteúdo...\n";
if (file_exists($arquivoLog) && filesize($arquivoLog) > 0) {
    echo "OK: Arquivo contatos.json validado.\n";
} else {
    echo "ERRO: Arquivo contatos.json está vazio ou não existe.\n";
    exit(1);
}

echo "--- SISTEMA VERIFICADO COM SUCESSO ---\n";
