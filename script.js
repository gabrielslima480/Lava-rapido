document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('agendamentoForm');
    const lista = document.getElementById('listaAgendamentos');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const nome = document.getElementById('nome').value;
        const telefone = document.getElementById('telefone').value;
        const servico = document.getElementById('servico').value;
        const data = document.getElementById('data').value;
        const hora = document.getElementById('hora').value;
        const delivery = document.getElementById('delivery').checked;
        const endereco = document.getElementById('endereco').value;

        // Gera um código de agendamento aleatório (Ex: F1-A3B9C)
        const codigoAgendamento = 'F1-' + Math.random().toString(36).substring(2, 7).toUpperCase();

        // Formatação do item de agendamento
        const li = document.createElement('li');
        let texto = `<strong>${nome}</strong> - ${servico} em ${data} às ${hora} (Tel: ${telefone}) <br><span style="color: #007BFF; font-weight: bold;">Código de Confirmação: ${codigoAgendamento}</span>`;
        
        if (delivery) {
            texto += ` <br><em>Delivery para: ${endereco || 'Endereço não informado'}</em>`;
        }
        
        li.innerHTML = texto;
        
        // Exibe um alerta de sucesso com o código para o cliente
        alert(`Agendamento de ${servico} realizado com sucesso!\n\nSeu código de confirmação é: ${codigoAgendamento}\n\nGuarde este código para acompanhar o seu serviço.`);
        
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
    }

    // Informações ao clicar nas imagens dos serviços
    const informacoesServicos = {
        'lavagem-simples': 'Lavagem Simples:\n\nInclui a lavagem completa da lataria com shampoo neutro, limpeza externa dos vidros e secagem cuidadosa para não riscar a pintura do seu veículo.',
        'higienizacao-interna': 'Higienização Interna:\n\nLimpeza profunda dos bancos (tecido ou couro), teto, carpetes e painel. Removemos manchas e ácaros, deixando um aroma agradável de carro novo.',
        'polimento': 'Polimento:\n\nRemovemos micro-riscos, manchas superficiais e oxidação da pintura, devolvendo o brilho intenso e protegendo a lataria do seu carro.',
        'pretinho': 'Pretinho nos Pneus:\n\nAplicação de produto especial que limpa, hidrata e devolve o brilho de pneu novo, além de criar uma camada protetora contra ressecamento.'
    };

    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', () => {
            const servico = item.getAttribute('data-servico');
            if (servico && informacoesServicos[servico]) {
                alert(informacoesServicos[servico]);
            }
        });
    });
});
