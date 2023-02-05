export class VendaError extends Error {
    constructor(mensagem) {
        super(mensagem);
        this.name = 'VendaError';
    }
}