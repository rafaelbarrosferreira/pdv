export class Venda {
    data_venda;
    total;
    itensProdutos;
    constructor(
        data_venda,
        total,
        itensProdutos
    ) {
        this.data_venda = data_venda;
        this.total = total;
        this.itensProdutos = itensProdutos;
    }
}