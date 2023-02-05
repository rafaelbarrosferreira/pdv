import { VendaControladora } from "./venda-controladora.js";

document.addEventListener('DOMContentLoaded', async function() {
    const controladoraVenda = new VendaControladora();
    await controladoraVenda.init();
})