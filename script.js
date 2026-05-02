document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('agendamentoForm');
    const lista = document.getElementById('listaAgendamentos');

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

        // Formatação do item de agendamento
        const li = document.createElement('li');
        let texto = `<strong>${nome}</strong> - ${servico} em ${data} às ${hora} (Tel: ${telefone}) <br>E-mail: ${email} <br><span style="color: #007BFF; font-weight: bold;">Código de Confirmação: ${codigoAgendamento}</span>`;
        
        if (delivery) {
            texto += ` <br><em>Delivery para: ${endereco || 'Endereço não informado'}</em>`;
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

    // Aviso para link do Facebook (em construção)
    const facebookLink = document.querySelector('.facebook-link');
    if (facebookLink) {
        facebookLink.addEventListener('click', (e) => {
            if (facebookLink.getAttribute('href') === '#') {
                e.preventDefault();
                alert('A nossa página do Facebook estará disponível em breve!');
            }
        });
});
