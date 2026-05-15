<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Entre em contato com o Lava Rápido F1. Solicite orçamentos, tire dúvidas e agende sua estética automotiva.">
    <meta name="keywords" content="lava rapido contato, estética automotiva, polimento, higienização, lavagem de carro, F1">
    <title>Contato | Lava Rápido F1</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .contato-main {
            padding: 40px 20px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('../img/Fundo.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: calc(100vh - 250px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contato-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 40px;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            color: white;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: rgba(0, 123, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            color: #007BFF;
            flex-shrink: 0;
            border: 1px solid rgba(0, 123, 255, 0.3);
        }

        .info-content h3 {
            margin: 0 0 5px 0;
            font-size: 1.2em;
            color: #007BFF;
        }

        .info-content p {
            margin: 0;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.5;
        }

        .social-grid {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .social-item {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2em;
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-item:hover {
            background: #007BFF;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        }

        .contato-form-container {
            width: 100%;
        }

        .form-feedback {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            display: none;
            text-align: center;
            font-weight: 500;
        }

        .form-feedback.success {
            display: block;
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #28a745;
        }

        .form-feedback.error {
            display: block;
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        @media (max-width: 992px) {
            .contato-grid {
                grid-template-columns: 1fr;
            }
            .info-card {
                order: 2;
            }
            .contato-form-container {
                order: 1;
            }
        }

        /* Estilo para ajustar o header em páginas secundárias */
        header {
            position: relative;
        }
    </style>
</head>

<body>

    <header>
        <div class="header-content">
            <div id="logo-container" onclick="window.location.href='../index.html'" style="cursor: pointer;">
                <img src="../img/logo.png" alt="Lava Rápido F1 Logo" class="main-logo-img">
            </div>
            <div class="title-container">
                <h1 id="main-logo" onclick="window.location.href='../index.html'" style="cursor: pointer;">Lava Rápido F1</h1>
                <p class="slogan">"Brilho de campeão para o seu veículo"</p>
            </div>
        </div>
        <nav class="main-nav">
            <div class="nav-links">
                <a href="../index.html"><i class="fas fa-home"></i> Home</a>
                <a href="../index.html#sobre"><i class="fas fa-info-circle"></i> Sobre Nós</a>
                <a href="../index.html#agendamento"><i class="fas fa-calendar-alt"></i> Agendamento</a>
                <a href="../index.html#fotos-servicos"><i class="fas fa-concierge-bell"></i> Serviços</a>
                <a href="../index.html#tabela-precos"><i class="fas fa-tags"></i> Tabela de Preços</a>
                <a href="../index.html#planos-assinatura"><i class="fas fa-id-card"></i> Planos de Assinatura</a>
            </div>
            <div class="social-icons">
                <a href="https://wa.me/5511937775104" class="social-link whatsapp" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                <a href="#" class="social-link facebook" title="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="#" class="social-link instagram" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="mailto:contato@lavarapidof1.com.br" class="social-link email" title="E-mail"><i class="fas fa-envelope"></i></a>
            </div>
        </nav>
    </header>

    <main class="contato-main">
        <div class="contato-grid">
            
            <!-- Informações de Contato -->
            <aside class="info-card">
                <h2 class="section-title-neon" style="font-size: 1.8em; margin-bottom: 20px; text-align: left;">Fale <span>Conosco</span></h2>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3>Nosso Endereço</h3>
                        <p>Av. Marechal Tito 250<br>São Miguel Paulista, SP</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3>Telefone / WhatsApp</h3>
                        <p>(11) 93777-5104</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <h3>E-mail</h3>
                        <p>contato@lavarapidof1.com.br</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <h3>Horário de Atendimento</h3>
                        <p>Segunda a Sábado: 08h às 18h<br>Domingos: Fechado</p>
                    </div>
                </div>

                <div>
                    <h3>Siga-nos</h3>
                    <div class="social-grid">
                        <a href="https://wa.me/5511937775104" class="social-item"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-item"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-item"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </aside>

            <!-- Formulário de Contato -->
            <div class="contato-form-container">
                <div class="glassmorphism" style="max-width: 100%;">
                    <h2>Envie uma Mensagem</h2>
                    <p class="form-subtitle">Dúvidas, sugestões ou orçamentos personalizados</p>

                    <form id="form-contato">
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required>
                        </div>

                        <div class="input-group">
                            <i class="fas fa-phone"></i>
                            <input type="tel" id="telefone" name="telefone" placeholder="Seu WhatsApp" required>
                        </div>

                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="Seu melhor e-mail" required>
                        </div>

                        <div class="input-group">
                            <i class="fas fa-concierge-bell"></i>
                            <select id="assunto" name="assunto" style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.3); background: rgba(255, 255, 255, 0.9); color: #333; font-size: 1em; cursor: pointer;">
                                <option value="" disabled selected>Assunto do contato</option>
                                <option value="orcamento">Orçamento Personalizado</option>
                                <option value="duvida">Dúvidas sobre Serviços</option>
                                <option value="reclamacao">Sugestões ou Reclamações</option>
                                <option value="parceria">Parcerias / Outros</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <i class="fas fa-comment-alt"></i>
                            <textarea id="mensagem" name="mensagem" rows="5" placeholder="Como podemos te ajudar?" required></textarea>
                        </div>

                        <button type="submit" id="btn-enviar" class="btn-agendar">
                            Enviar Mensagem <i class="fas fa-paper-plane"></i>
                        </button>

                        <div id="feedback" class="form-feedback"></div>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="../img/logo.png" alt="Logo F1" class="footer-logo-img">
                <p>Lava Rápido F1</p>
            </div>
            <div class="footer-info">
                <p><i class="fas fa-map-marker-alt"></i> Av. Marechal Tito 250 - São Miguel Paulista, SP</p>
                <p><i class="fas fa-phone"></i> (11) 93777-5104</p>
                <p><i class="fas fa-envelope"></i> contato@lavarapidof1.com.br</p>
            </div>
            <div class="footer-social">
                <a href="https://wa.me/5511937775104" target="_blank"><i class="fab fa-whatsapp"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Lava Rápido F1. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Cursor Customizado -->
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <script src="../script.js"></script>
    <script>
        document.getElementById('form-contato').addEventListener('submit', function (e) {
            e.preventDefault();
            
            const btn = document.getElementById('btn-enviar');
            const feedback = document.getElementById('feedback');
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            btn.disabled = true;
            btn.innerHTML = 'Enviando... <i class="fas fa-spinner fa-spin"></i>';
            feedback.style.display = 'none';

            fetch('enviar_email.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    feedback.textContent = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
                    feedback.className = 'form-feedback success';
                    this.reset();
                } else {
                    throw new Error(data.message || 'Erro ao enviar mensagem.');
                }
            })
            .catch(error => {
                feedback.textContent = 'Erro: ' + error.message;
                feedback.className = 'form-feedback error';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = 'Enviar Mensagem <i class="fas fa-paper-plane"></i>';
                feedback.style.display = 'block';
            });
        });
    </script>
</body>

</html>