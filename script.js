document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('agendamentoForm');
    const lista = document.getElementById('listaAgendamentos');
    const deliveryCheckbox = document.getElementById('delivery');
    const enderecoContainer = document.getElementById('endereco-container');
    const enderecoInput = document.getElementById('endereco');

    // Função simples para evitar XSS
    const escapeHTML = (str) => String(str).replace(/[&<>"']/g, m => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    })[m]);

    if (deliveryCheckbox && enderecoContainer) {
        deliveryCheckbox.addEventListener('change', () => {
            if (deliveryCheckbox.checked) {
                enderecoContainer.style.display = 'block';
                enderecoInput.setAttribute('required', 'true');
            } else {
                enderecoContainer.style.display = 'none';
                enderecoInput.removeAttribute('required');
            }
        });
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const nome = document.getElementById('nome').value;
        const telefone = document.getElementById('telefone').value;
        const email = document.getElementById('email').value;
        const servico = document.getElementById('servico').value;
        const data = document.getElementById('data').value;
        const hora = document.getElementById('hora').value;
        const delivery = document.getElementById('delivery').checked;
        const endereco = document.getElementById('endereco').value;
        const comentarios = document.getElementById('comentarios') ? document.getElementById('comentarios').value : "";

        // Gera um código de agendamento aleatório (Ex: F1-A3B9C)
        const codigoAgendamento = 'F1-' + Math.random().toString(36).substring(2, 7).toUpperCase();

        // Adiciona à tabela
        adicionarLinhaTabela(nome, servico, `${data} ${hora}`, 'Confirmado', codigoAgendamento);
        
        // Exibe um alerta de sucesso
        alert(`Agendamento de ${servico} realizado com sucesso!\n\nSeu código de confirmação é: ${codigoAgendamento}`);
        
        // Limpa o formulário e rola até a tabela
        form.reset();
        document.getElementById('lista-agendamentos-section').scrollIntoView({ behavior: 'smooth' });
    });

    // Função para adicionar linha na tabela
    function adicionarLinhaTabela(nome, servico, dataHora, status, codigo) {
        const tr = document.createElement('tr');
        
        const statusClass = status === 'Confirmado' ? 'status-confirmado' : 'status-pendente';
        
        tr.innerHTML = `
            <td><strong>${escapeHTML(nome)}</strong></td>
            <td>${escapeHTML(servico)}</td>
            <td>${escapeHTML(dataHora)}</td>
            <td><span class="status-badge ${statusClass}">${status}</span></td>
            <td><span class="codigo-tag">${escapeHTML(codigo)}</span></td>
        `;
        
        lista.appendChild(tr);
    }

    // --- LÓGICA DO MODAL DE PAGAMENTO ---
    const modal = document.getElementById('modalPagamento');
    const formPagamento = document.getElementById('formPagamento');
    let planoSelecionado = '';

    window.abrirModalAssinatura = function(plano, preco) {
        planoSelecionado = plano;
        document.getElementById('modal-plano-info').innerHTML = `Você selecionou o <strong>${plano}</strong> - R$ ${preco},00/mês`;
        modal.style.display = 'block';
    };

    window.fecharModal = function() {
        modal.style.display = 'none';
    };

    // Fecha o modal ao clicar fora dele
    window.onclick = function(event) {
        if (event.target == modal) {
            fecharModal();
        }
    };

    if (formPagamento) {
        formPagamento.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const nome = document.getElementById('pay-nome').value;
            const email = document.getElementById('pay-email').value;
            const whatsapp = document.getElementById('pay-whatsapp').value;
            
            // Simulação de processamento
            const codigoAssinatura = 'SUB-' + Math.random().toString(36).substring(2, 7).toUpperCase();
            
            // Notificações
            enviarNotificacoes(nome, planoSelecionado, email, whatsapp, codigoAssinatura);
            
            // Adiciona na tabela de agendamentos/solicitações
            adicionarLinhaTabela(nome, `Assinatura: ${planoSelecionado}`, 'Processamento Mensal', 'Confirmado', codigoAssinatura);
            
            alert(`Pagamento processado com sucesso!\n\nSua assinatura do ${planoSelecionado} está ativa.\nCódigo: ${codigoAssinatura}\n\nEnviamos os detalhes para seu e-mail e WhatsApp.`);
            
            fecharModal();
            formPagamento.reset();
            document.getElementById('lista-agendamentos-section').scrollIntoView({ behavior: 'smooth' });
        });
    }

    function enviarNotificacoes(nome, plano, email, whatsapp, codigo) {
        // Simulação de E-mail
        console.log(`[SIMULAÇÃO E-MAIL] Para: ${email}\nAssunto: Confirmação de Assinatura F1\nOlá ${nome}, seu ${plano} foi ativado com o código ${codigo}.`);
        
        // WhatsApp link
        const mensagem = encodeURIComponent(`Olá! Acabei de assinar o ${plano} no Lava Rápido F1. Meu código é: ${codigo}. Nome: ${nome}`);
        const waLink = `https://wa.me/55${whatsapp.replace(/\D/g, '')}?text=${mensagem}`;
        
        // Abre o WhatsApp em uma nova aba
        window.open(waLink, '_blank');
    }

    // --- LÓGICA DE AVALIAÇÕES ---
    const feedbackForm = document.getElementById('feedbackForm');
    const listaFeedback = document.getElementById('listaFeedback');

    // Função para carregar avaliações do localStorage
    const carregarAvaliacoes = () => {
        const avaliacoes = JSON.parse(localStorage.getItem('avaliacoesF1')) || [];
        listaFeedback.innerHTML = '';
        
        avaliacoes.forEach(av => {
            const card = document.createElement('div');
            card.className = 'feedback-card';
            
            let estrelasHTML = '';
            for(let i=1; i<=5; i++) {
                estrelasHTML += `<i class="${i <= av.nota ? 'fas' : 'far'} fa-star"></i>`;
            }

            card.innerHTML = `
                <h4>${escapeHTML(av.nome)}</h4>
                <div class="stars">${estrelasHTML}</div>
                <p>${escapeHTML(av.comentario)}</p>
                <span class="date">${av.data}</span>
            `;
            listaFeedback.appendChild(card);
        });
    };

    if (feedbackForm) {
        feedbackForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const nome = document.getElementById('feedbackNome').value;
            const comentario = document.getElementById('feedbackComentario').value;
            const nota = feedbackForm.querySelector('input[name="rating"]:checked').value;
            const dataPost = new Date().toLocaleDateString('pt-BR');

            const novaAvaliacao = {
                nome,
                comentario,
                nota,
                data: dataPost
            };

            // Salva no localStorage
            const avaliacoes = JSON.parse(localStorage.getItem('avaliacoesF1')) || [];
            avaliacoes.unshift(novaAvaliacao); // Adiciona no início da lista
            localStorage.setItem('avaliacoesF1', JSON.stringify(avaliacoes));

            // Feedback visual e limpa form
            alert('Obrigado pela sua avaliação!');
            feedbackForm.reset();
            carregarAvaliacoes();
        });
    }

    // Inicializa as avaliações ao carregar a página
    carregarAvaliacoes();

    // Aviso para link do Facebook (em construção)
    const facebookLink = document.querySelector('.facebook-link');
    if (facebookLink) {
        facebookLink.addEventListener('click', (e) => {
            if (facebookLink.getAttribute('href') === '#') {
                e.preventDefault();
                alert('A nossa página do Facebook estará disponível em breve!');
            }
        });
    }

    // Funcionalidade de retorno ao topo ao clicar no logo ou no título
    const mainLogo = document.getElementById('main-logo');
    const logoContainer = document.getElementById('logo-container');
    const navHome = document.getElementById('nav-home');
    
    const scrollToTop = (e) => {
        if (e) e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };

    if (mainLogo) mainLogo.addEventListener('click', scrollToTop);
    if (logoContainer) logoContainer.addEventListener('click', scrollToTop);
    if (navHome) navHome.addEventListener('click', scrollToTop);

    // --- LÓGICA DO CURSOR CUSTOMIZADO ---
    const cursorDot = document.querySelector('.cursor-dot');
    const cursorOutline = document.querySelector('.cursor-outline');

    if (cursorDot && cursorOutline) {
        let prevX = 0;
        let prevY = 0;
        let angle = 0;

        window.addEventListener('mousemove', (e) => {
            const posX = e.clientX;
            const posY = e.clientY;

            // Calcula o ângulo de rotação baseado no movimento
            const dx = posX - prevX;
            const dy = posY - prevY;
            
            // Só atualiza o ângulo se houver movimento significativo para evitar trepidação
            if (Math.abs(dx) > 1 || Math.abs(dy) > 1) {
                angle = Math.atan2(dy, dx) * (180 / Math.PI) + 90; // +90 porque o SVG aponta para cima
            }

            // O carro (ponto) segue e rotaciona
            cursorDot.style.left = `${posX}px`;
            cursorDot.style.top = `${posY}px`;
            cursorDot.style.transform = `translate(-50%, -50%) rotate(${angle}deg)`;

            // O contorno segue com suavidade
            cursorOutline.style.left = `${posX}px`;
            cursorOutline.style.top = `${posY}px`;

            prevX = posX;
            prevY = posY;
        });

        // Adiciona classe de hover para elementos interativos
        const interactiveElements = document.querySelectorAll('a, button, input, textarea, .glass-card, .gallery-item, #logo-container, #main-logo, .social-link');
        
        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', () => {
                document.body.classList.add('cursor-hover');
            });
            el.addEventListener('mouseleave', () => {
                document.body.classList.remove('cursor-hover');
            });
        });
    }
});
