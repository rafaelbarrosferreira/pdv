import { Venda } from "./venda.js";

export class VisaoVenda {
    venda;
    produtosPesquisados = [];
    itensVenda = [];

    listarVendaRegex = () => (/^\/venda\/?$/i).test(location.pathname);
    venderRegex = () => (/^\/vender\/?$/i).test(location.pathname);
    editarVendaRegex = () => (/^\/venda\/\d+\/edit\/?$/i).test(location.pathname);

    constructor() {
        this.venda = new Venda();
        this.produtosPesquisados = [];
        this.itensVenda = [];
    }

    async configurarEdicao() {
        const table = document.getElementById('itens_pedido');
        const tbody = table.querySelector('tbody');
        const linhas = tbody.querySelectorAll('tr');
        const camposQuantidade = table.querySelectorAll('input');
        const botoesRemover = table.querySelectorAll('button');

        linhas.forEach((linha) => {
            const idProduto = Number(linha.getAttribute('data-id'));
            const selectedProduct = this.itensVenda.find(produto => produto.id === idProduto);
            const colunas = linha.querySelectorAll('td');
            const quantidade = linha.querySelector('input');
            if (!this.itensVenda.includes(selectedProduct)) {
                this.itensVenda.push({ "id": idProduto, "name": colunas[0].getAttribute('data-name'), "description": colunas[1].getAttribute('data-description'), 'price': colunas[2].getAttribute('data-price'), 'quantidade': Number(quantidade.value), 'total': Number(quantidade.value) * Number(colunas[2].getAttribute('data-price')) });
            }
        });

        botoesRemover.forEach((botao) => botao.addEventListener('click', this.removerProduto.bind(this)));
        camposQuantidade.forEach((input) => input.addEventListener('change', this.aoAlterarQuantidade.bind(this)));
    }
    async aoDigitarOProduto(callback) {
        const nomeProduto = document.querySelector('#produto');

        let passaNomeDoProduto = (event) => {
            let input = event.target;
            callback(input.value);
        }

        nomeProduto.addEventListener('keyup', this.delay(passaNomeDoProduto, 500));
    }

    async aoClicarEmVender(callback) {
        const vender = document.getElementById('vender');

        let funcAct = async(event) => {
            event.preventDefault();
            await callback();
        }

        vender.addEventListener('click', funcAct);
    }

    async aoClicarEmRemover(callback) {
        const removerBotoes = document.querySelectorAll('.remover_venda');

        let funcAct = async(event) => {
            event.preventDefault();
            event.stopPropagation();
            let elemento = event.target;
            await callback(Number(elemento.getAttribute('data-id')));
        }
        removerBotoes.forEach((remover) => {
            remover.addEventListener('click', funcAct);
        })
    }

    async montarListaProdutos(produtos) {
        this.produtosPesquisados = produtos;
        const productList = document.getElementById('product-list');
        productList.innerHTML = '';

        const fragment = document.createDocumentFragment();

        for (const produto of this.produtosPesquisados) {
            const item = document.createElement('li');
            item.classList.add('venda-item');
            item.setAttribute('data-id', produto.id);
            item.innerHTML = `
            <div class="flex flex-col md:flex-row">
              <div class="w-full md:w-1/4 p-4">
                Nome: ${produto.name}
              </div>
              <div class="w-full md:w-1/4 p-4">
                Descrição: ${produto.description}
              </div>
              <div class="w-full md:w-1/4 p-4">
                Valor: R$ ${produto.price.toFixed(2)}
              </div>
              <div class="w-full md:w-1/4 p-4">
                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded selecionar_produto">Selecionar</button>
              </div>
            </div>
          `;
            fragment.appendChild(item);
        }

        productList.appendChild(fragment);

        const buttons = Array.from(document.querySelectorAll('.selecionar_produto'));
        await buttons.forEach(async(button) => {
            await button.addEventListener('click', this.selecionarProduto.bind(this));
        });
    }

    async selecionarProduto(event) {
        const li = event.target.closest('li');
        const idProduto = Number(li.getAttribute('data-id'));
        const selectedProduct = this.produtosPesquisados.find(produto => produto.id === idProduto);
        if (!this.itensVenda.includes(selectedProduct)) {
            this.itensVenda.push(selectedProduct);
            this.adicionarProduto(selectedProduct);
        }
    }

    adicionarProduto(produto) {
        const tabela = document.getElementById('itens_pedido');
        const tbody = tabela.querySelector('tbody');

        const tr = document.createElement('tr');
        tr.setAttribute('data-id', produto.id);
        tr.classList = 'bg-gray-100';

        tr.append(
            this.criarTd(produto.name, produto.name, "Nome", 'data-name'),
            this.criarTd(produto.description, produto.description, "Descrição", 'data-description'),
            this.criarTd(produto.price, `R$ ${produto.price}`, "Preço", 'data-price'),
            this.criarTdQuantidade(produto, 'data-quantidade'),
            this.criarTd(produto.price * 1, produto.price * 1, "Total", 'data-total'),
            this.criarTdBotaoRemover()
        );

        tbody.appendChild(tr);


        this.atualizarValores();
    }

    criarTd(conteudo, conteudoHTML, tipo, nomeDoDado) {
        const td = document.createElement("td");
        td.innerHTML = conteudoHTML;
        td.classList = "border px-4 py-2 text-center";
        td.setAttribute(nomeDoDado, conteudo);

        return td;
    }

    criarTdQuantidade(produto) {
        const tdQuantidade = document.createElement("td");
        tdQuantidade.classList = "border px-4 py-2 text-center";

        const inputQuantidade = document.createElement('input');
        inputQuantidade.name = `quantidade_${produto.id}`;
        inputQuantidade.id = `quantidade_${produto.id}`;
        inputQuantidade.value = Number(1);
        inputQuantidade.type = "number";
        inputQuantidade.min = 1;
        inputQuantidade.className = "quantidade_produto";

        tdQuantidade.append(inputQuantidade);
        inputQuantidade.addEventListener('input', this.aoAlterarQuantidade.bind(this));

        return tdQuantidade;
    }

    criarTdBotaoRemover() {
        const tdAcao = document.createElement('td');
        tdAcao.classList = "border px-4 py-2 text-center";

        const botaoRemover = document.createElement('button');
        botaoRemover.type = "button";
        botaoRemover.classList = "m-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded";
        botaoRemover.innerHTML = 'Remover';
        botaoRemover.addEventListener('click', this.removerProduto.bind(this));

        tdAcao.append(botaoRemover);

        return tdAcao;
    }

    atualizarValores() {
        const tabela = document.getElementById('itens_pedido');
        const tbody = tabela.querySelector('tbody');
        const trs = tbody.querySelectorAll('tr');
        let totalGeral = 0;
        trs.forEach((tr) => {
            const idProduto = Number(tr.getAttribute('data-id'));
            const tdQuantidade = tr.querySelector('td input');
            const quantidade = Number(tdQuantidade.value);
            console.log(quantidade);
            const tdPreco = tr.querySelector('[data-price]');
            const preco = Number(tdPreco.getAttribute('data-price'));
            console.log(preco);
            const tdTotal = tr.querySelector('[data-total]');
            tdTotal.innerHTML = Number(preco * quantidade).toFixed(2);
            totalGeral += preco * quantidade;
        });
        const tfoot = tabela.querySelector("tfoot");
        tfoot.innerHTML = '';
        const trFoot = document.createElement('tr');
        trFoot.classList = "text-sm text-gray-700 bg-gray-200 text-lg";
        const tdTotalGeral = document.createElement('td');
        tdTotalGeral.innerHTML = 'Total';
        tdTotalGeral.style.textAlign = 'center';
        tdTotalGeral.colSpan = 4;
        const tdTotalGeralValor = document.createElement('td');
        tdTotalGeralValor.innerHTML = `R$ ${Number(totalGeral.toFixed(2))}`;
        tdTotalGeralValor.style.textAlign = 'center';
        tdTotalGeralValor.colSpan = 2;
        trFoot.append(tdTotalGeral, tdTotalGeralValor)
        tfoot.append(trFoot);
    }

    removerProduto(event) {
        const botao = event.target;
        const tr = botao.closest('tr');
        const idProduto = Number(tr.getAttribute('data-id'));
        const index = this.itensVenda.findIndex(item => item.id === idProduto);

        if (index >= 0) {
            this.itensVenda.splice(index, 1);
            tr.remove();
        }
        this.atualizarValores();
    }

    pegarDadosDoForm() {

        const tabela = document.getElementById('itens_pedido');
        const tbody = tabela.querySelector('tbody');

        const produtos = tbody.querySelectorAll('tr');

        let itensVenda = [];

        let valorTotal = 0;
        produtos.forEach((item) => {
            const colunas = item.querySelectorAll('td');
            const quantidade = colunas[3].querySelector('input');
            itensVenda.push({ "id": item.getAttribute('data-id'), "name": colunas[0].getAttribute('data-name'), "description": colunas[1].getAttribute('data-description'), 'price': colunas[2].getAttribute('data-price'), 'quantidade': Number(quantidade.value), 'total': Number(quantidade.value) * Number(colunas[2].getAttribute('data-price')) });

            valorTotal += Number(quantidade.value) * Number(colunas[2].getAttribute('data-price'));
        })
        let venda = new Venda(Date.now(), valorTotal, itensVenda);
        return venda;
    }

    pegarDadosDoFormEdit() {
        return this.pegarDadosDoForm();
    }
    aoDispararRegistrarVenda(callback) {
        let funcAct = (event) => {
            event.preventDefault();
            callback(event);
        }

        const botao = document.querySelector('#salvar');

        botao.addEventListener('click', funcAct);
    }

    aoDispararEditarVenda(callback) {
        this.aoDispararRegistrarVenda(callback);
    }

    aoAlterarQuantidade(event) {
        const input = event.target;
        const id = input.id.split('_')[1];
        const tr = input.closest('tr');
        const tdPreco = tr.querySelector('[data-price]');
        console.log(tdPreco);

        const preco = Number(tdPreco.getAttribute('data-price'));

        const tdTotal = tr.querySelector('[data-total]');
        tdTotal.innerHTML = preco * input.value;
        this.atualizarValores();
    }

    delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    showSuccessMessage(message) {
        var div = document.createElement("div");
        div.className = "message message-success";
        div.innerHTML = "<p>" + message + "</p>";
        document.body.appendChild(div);
    }

    showErrorMessage(message) {
        var div = document.createElement("div");
        div.className = "message message-error";
        div.innerHTML = "<p>" + message + "</p>";
        document.body.appendChild(div);
    }
}