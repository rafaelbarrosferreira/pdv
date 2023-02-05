import { RepositorioProduto } from "./produto-repositorio.js";
export class ServicoProduto {
    repositorioProduto;

    constructor() {
        this.repositorioProduto = new RepositorioProduto();
    }

    async todos() {
        return this.repositorioProduto.todos();
    }

    async adicionar(produto) {
        return this.repositorioProduto.adicionar(produto);
    }

    async atualizar(produto) {
        return this.repositorioProduto.atualizar(produto);
    }

    async remover(produtoId) {
        return this.repositorioProduto.remover(produtoId);
    }

    async comNome(produtoNome) {
        return this.repositorioProduto.comNome(produtoNome);
    }

    async dadosParaForm() {
        return this.repositorioProduto.dadosParaForm();
    }
}