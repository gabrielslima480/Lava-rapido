document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('agendamentoForm');
    const lista = document.getElementById('listaAgendamentos');
    const deliveryCheckbox = document.getElementById('delivery');
    const enderecoContainer = document.getElementById('endereco-container');
    const enderecoInput = document.getElementById('endereco');

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

        // Lógica de planos de assinatura
        let avisoAssinaturaHTML = "";
        let avisoAlertaTXT = "";

        if (servico.startsWith('Plano')) {
            let meses = 0;
            if (servico.includes('3 Meses')) meses = 3;
            else if (servico.includes('5 Meses')) meses = 5;
            else if (servico.includes('1 Ano')) meses = 12;

            const [ano, mes, dia] = data.split('-');
            const dataInicio = new Date(ano, mes - 1, dia);
            
            const dataFim = new Date(dataInicio);
            dataFim.setMonth(dataFim.getMonth() + meses);

            const dataAviso = new Date(dataFim);
            dataAviso.setDate(dataAviso.getDate() - 3);

            const dataFimFormatada = dataFim.toLocaleDateString('pt-BR');
            const dataAvisoFormatada = dataAviso.toLocaleDateString('pt-BR');

            avisoAssinaturaHTML = `<br><span style="color: #28a745;"><strong>Assinatura Válida até:</strong> ${dataFimFormatada}</span><br>
            <span style="color: #FF9800;">Lembrete de renovação agendado para o e-mail <strong>${email}</strong> no dia ${dataAvisoFormatada} (3 dias antes do término).</span>`;

            avisoAlertaTXT = `\n\nComo você contratou um ${servico}, um e-mail de aviso será enviado para ${email} no dia ${dataAvisoFormatada}, que é 3 dias antes do seu plano terminar (${dataFimFormatada}).`;
        }

        // Gera um código de agendamento aleatório (Ex: F1-A3B9C)
        const codigoAgendamento = 'F1-' + Math.random().toString(36).substring(2, 7).toUpperCase();

        // Função simples para evitar XSS
        const escapeHTML = (str) => String(str).replace(/[&<>"']/g, m => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        })[m]);

        const safeNome = escapeHTML(nome);
        const safeServico = escapeHTML(servico);
        const safeData = escapeHTML(data);
        const safeHora = escapeHTML(hora);
        const safeTelefone = escapeHTML(telefone);
        const safeEmail = escapeHTML(email);
        const safeEndereco = escapeHTML(endereco);
        const safeComentarios = escapeHTML(comentarios);

        // Formatação do item de agendamento
        const li = document.createElement('li');
        let texto = `<strong>${safeNome}</strong> - ${safeServico} em ${safeData} às ${safeHora} (Tel: ${safeTelefone}) <br>E-mail: ${safeEmail} <br><span style="color: #007BFF; font-weight: bold;">Código de Confirmação: ${codigoAgendamento}</span>`;
        
        if (delivery) {
            texto += ` <br><em>Delivery para: ${safeEndereco || 'Endereço não informado'}</em>`;
        }
        
        if (comentarios.trim() !== "") {
            texto += ` <br><span style="color: #666; font-style: italic;"><strong>Observações:</strong> ${safeComentarios}</span>`;
        }
        
        texto += avisoAssinaturaHTML;
        
        li.innerHTML = texto;
        
        // Exibe um alerta de sucesso com o código para o cliente
        alert(`Agendamento de ${servico} realizado com sucesso!\n\nSeu código de confirmação é: ${codigoAgendamento}\n\nGuarde este código para acompanhar o seu serviço.${avisoAlertaTXT}`);
        
        // Adiciona à lista
        lista.appendChild(li);
        
        // Limpa o formulário
        form.reset();
        
        // Rola até a lista
        lista.scrollIntoView({ behavior: 'smooth' });
    });

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
});
