import { RepositorioVenda } from "./venda-repositorio.js";

export class ServicoVenda {
    repositorioVenda = null;

    constructor() {
        this.repositorioVenda = new RepositorioVenda();
    }

    async todos() {
        return await this.repositorioVenda.todos();
    }

    async adicionar(venda) {
        return this.repositorioVenda.adicionar(venda);
    }

    async atualizar(venda) {
        return this.repositorioVenda.atualizar(venda);
    }

    async remover(vendaId) {
        return this.repositorioVenda.remover(vendaId);
    }

    async dadosParaForm() {
        return this.repositorioVenda.dadosParaForm();
    }
}