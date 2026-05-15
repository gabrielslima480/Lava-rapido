<?php
/**
 * Painel de Visualização de Contatos - Lava Rápido F1
 */

$arquivoLog = 'contatos.json';
$arquivoAgend = 'agendamentos.json';
$contatos = [];
$agendamentos = [];

if (file_exists($arquivoLog)) {
    $conteudo = file_get_contents($arquivoLog);
    $contatos = json_decode($conteudo, true) ?: [];
}

if (file_exists($arquivoAgend)) {
    $conteudoAgend = file_get_contents($arquivoAgend);
    $agendamentos = json_decode($conteudoAgend, true) ?: [];
}

// Lógica para limpar o histórico
if (isset($_POST['limpar_historico'])) {
    $tipo = $_POST['tipo_limpeza'] ?? 'contatos';
    if ($tipo === 'agendamentos') {
        file_put_contents($arquivoAgend, json_encode([], JSON_PRETTY_PRINT));
    } else {
        file_put_contents($arquivoLog, json_encode([], JSON_PRETTY_PRINT));
    }
    header("Location: painel_contatos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Registros | Lava Rápido F1</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #0a0a0a;
            color: white;
            padding: 40px 20px;
        }
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        .btn-refresh {
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-refresh:hover {
            background: #0056b3;
            transform: scale(1.05);
        }
        .registro-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            transition: 0.3s;
        }
        .registro-card:hover {
            border-color: #007BFF;
            background: rgba(255, 255, 255, 0.08);
        }
        .registro-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .registro-meta {
            display: flex;
            gap: 20px;
            font-size: 0.9em;
            color: #007BFF;
        }
        .registro-data {
            color: #aaa;
            font-size: 0.85em;
        }
        .registro-body {
            line-height: 1.6;
        }
        .badge-assunto {
            background: rgba(0, 123, 255, 0.2);
            color: #007BFF;
            padding: 3px 10px;
            border-radius: 5px;
            font-size: 0.8em;
            font-weight: bold;
            text-transform: uppercase;
        }
        .empty-state {
            text-align: center;
            padding: 100px 20px;
            color: #555;
        }
        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }
        .tab-btn {
            background: none;
            border: none;
            color: #888;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            padding: 10px 20px;
            transition: 0.3s;
        }
        .tab-btn.active {
            color: #007BFF;
            border-bottom: 3px solid #007BFF;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .badge-delivery {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
        }
    </style>
</head>
<body>

    <div class="admin-container">
        <div class="header-panel">
            <div>
                <h1 class="section-title-neon" style="text-align: left; margin: 0;">Painel de <span>Registros</span></h1>
                <p style="color: #888; margin-top: 5px;">Histórico de mensagens recebidas pelo site.</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <form method="POST" onsubmit="return confirm('Tem certeza que deseja apagar todas as mensagens? Esta ação não pode ser desfeita.')">
                    <button type="submit" name="limpar_historico" class="btn-refresh" style="background: rgba(220, 53, 69, 0.2); border: 1px solid #dc3545; color: #dc3545;">
                        <i class="fas fa-trash-alt"></i> Limpar Histórico
                    </button>
                </form>
                <a href="javascript:location.reload()" class="btn-refresh">
                    <i class="fas fa-sync-alt"></i> Atualizar
                </a>
            </div>
        </div>

        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('contatos')">Mensagens de Contato (<?php echo count($contatos); ?>)</button>
            <button class="tab-btn" onclick="showTab('agendamentos')">Solicitações de Agendamento (<?php echo count($agendamentos); ?>)</button>
        </div>

        <!-- ABA DE CONTATOS -->
        <div id="tab-contatos" class="tab-content active">
            <?php if (empty($contatos)): ?>
                <div class="empty-state">
                    <i class="fas fa-inbox fa-4x" style="margin-bottom: 20px; opacity: 0.2;"></i>
                    <p>Nenhuma mensagem de contato encontrada.</p>
                </div>
            <?php else: ?>
                <div class="registros-lista">
                    <?php foreach ($contatos as $c): ?>
                        <div class="registro-card">
                            <div class="registro-header">
                                <div class="registro-meta">
                                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($c['nome']); ?></span>
                                    <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($c['telefone']); ?></span>
                                </div>
                                <div class="registro-data">
                                    <i class="fas fa-calendar-alt"></i> <?php echo $c['data']; ?>
                                </div>
                            </div>
                            <div class="registro-body">
                                <p style="margin-bottom: 10px;">
                                    <span class="badge-assunto"><?php echo htmlspecialchars($c['assunto']); ?></span>
                                </p>
                                <p><?php echo nl2br(htmlspecialchars($c['mensagem'])); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ABA DE AGENDAMENTOS -->
        <div id="tab-agendamentos" class="tab-content">
            <?php if (empty($agendamentos)): ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-check fa-4x" style="margin-bottom: 20px; opacity: 0.2;"></i>
                    <p>Nenhuma solicitação de agendamento encontrada.</p>
                </div>
            <?php else: ?>
                <div class="registros-lista">
                    <?php foreach ($agendamentos as $a): ?>
                        <div class="registro-card">
                            <div class="registro-header">
                                <div class="registro-meta">
                                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($a['nome']); ?></span>
                                    <span><i class="fas fa-car"></i> <strong><?php echo htmlspecialchars($a['servico']); ?></strong></span>
                                </div>
                                <div class="registro-data">
                                    <i class="fas fa-calendar-day"></i> <?php echo date('d/m/Y', strtotime($a['data_agendamento'])); ?> às <?php echo $a['hora']; ?>
                                </div>
                            </div>
                            <div class="registro-body">
                                <div style="display: flex; gap: 15px; margin-bottom: 10px; font-size: 0.9em;">
                                    <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($a['telefone']); ?></span>
                                    <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($a['email']); ?></span>
                                    <?php if ($a['delivery'] === 'Sim'): ?>
                                        <span class="badge-delivery"><i class="fas fa-truck"></i> Delivery</span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($a['delivery'] === 'Sim'): ?>
                                    <p style="font-size: 0.9em; color: #aaa; margin-bottom: 10px;"><i class="fas fa-map-marker-alt"></i> Endereço: <?php echo htmlspecialchars($a['endereco']); ?></p>
                                <?php endif; ?>
                                <p><?php echo nl2br(htmlspecialchars($a['mensagem'])); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <script>
            function showTab(tabName) {
                // Esconde todos
                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                
                // Mostra o selecionado
                document.getElementById('tab-' + tabName).classList.add('active');
                event.currentTarget.classList.add('active');
            }
        </script>

        <div style="text-align: center; margin-top: 40px;">
            <a href="../index.html" style="color: #555; text-decoration: none; font-size: 0.9em;">
                <i class="fas fa-arrow-left"></i> Voltar para o Site
            </a>
        </div>
    </div>

</body>
</html>
