import { ServicoVenda } from "./venda-servico.js";
import { VisaoVenda } from "./venda-visao.js";
import { ServicoProduto } from "../produtos/produto-servico.js";

export class VendaControladora {
    servicoVenda = null;
    visaoVenda = null;
    servicoProduto = null;

    constructor() {
        this.servicoVenda = new ServicoVenda();
        this.visaoVenda = new VisaoVenda();
        this.servicoProduto = new ServicoProduto();
    }

    async init() {
        if (this.visaoVenda.listarVendaRegex()) {
            this.visaoVenda.aoClicarEmVender(this.redirecionaParaVendas.bind(this));
            this.visaoVenda.aoClicarEmRemover(this.remover.bind(this));
        } else if (this.visaoVenda.venderRegex()) {
            this.visaoVenda.aoDigitarOProduto(this.buscarProdutos.bind(this));
            this.visaoVenda.aoDispararRegistrarVenda(this.salvar.bind(this));
        } else if (this.visaoVenda.editarVendaRegex()) {
            this.visaoVenda.configurarEdicao();
            this.visaoVenda.aoDigitarOProduto(this.buscarProdutos.bind(this));
            this.visaoVenda.aoDispararEditarVenda(this.editar.bind(this));
        }
    }

    async redirecionaParaVendas() {
        try {
            setTimeout(() => {
                location.href = "/vender";
            }, 200);
        } catch (error) {
            this.visaoVenda.showErrorMessage(erro.message);
        }
    }
    async buscarProdutos(nomeProduto) {
        try {
            const produtos = await this.servicoProduto.comNome(nomeProduto);
            await this.visaoVenda.montarListaProdutos(produtos);
        } catch (error) {
            this.visaoVenda.showErrorMessage(erro.message);
        }
    }


    async salvar() {
        try {
            let venda = this.visaoVenda.pegarDadosDoForm();
            await this.servicoVenda.adicionar(venda);

            this.visaoVenda.showSuccessMessage('Venda registrada com sucesso!');
            setTimeout(() => {
                location.href = "/venda";
            }, 2000);
        } catch (erro) {
            this.visaoVenda.showErrorMessage(erro.message);
        }
    }

    async editar() {
        try {
            let venda = this.visaoVenda.pegarDadosDoFormEdit();

            await this.servicoVenda.atualizar(venda);

            this.visaoVenda.showSuccessMessage('Venda atualizada com sucesso!');
            setTimeout(() => {
                location.href = "/venda";
            }, 2000);
        } catch (erro) {
            this.visaoVenda.showErrorMessage(erro.message);
        }
    }

    async remover(id) {
        try {
            await this.servicoVenda.remover(id);

            this.visaoVenda.showSuccessMessage('Venda removida com sucesso!');
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } catch (erro) {
            this.visaoVenda.showErrorMessage(erro.message);
        }
    }

}