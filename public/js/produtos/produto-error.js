export class ProdutoError extends Error {
    constructor(mensagem) {
        super(mensagem);
        this.name = 'ProdutoError';
    }
}