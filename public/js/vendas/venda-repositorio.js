import { VendaError } from "./venda-error.js";

const API = 'http://localhost:8000';
const crfToken = document.querySelector('meta[name="csrf-token"]');

export class RepositorioVenda {

    async todos() {
        try {
            let resposta = await fetch(`${API}/venda`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'GET',
            })
            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new Error();
            }
            console.log(resposta.json());
            return resposta;
        } catch (error) {
            throw new VendaError('Erro ao atualizar venda!');
        }
    }

    async adicionar(venda) {
        try {
            console.log(crfToken.getAttribute('content'));
            let resposta = await fetch(`${API}/venda`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'POST',
                body: JSON.stringify(venda),
            })
            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new VendaError('Erro ao registrar Vendas!');
            }
            return resposta;
        } catch (error) {
            throw new VendaError('Erro ao adicionar venda!');
        }
    }

    async atualizar(venda) {
        let extractIdFromUrl = (url) => {
            let matches = url.match(/\/venda\/(\d+)\/edit\/?$/i);
            if (matches && matches.length > 1) {
                return matches[1];
            }
            return null;
        }
        try {
            let resposta = await fetch(`${API}/venda/${extractIdFromUrl(location.pathname)}`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'PUT',
                body: JSON.stringify(venda),
            })
            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new Error();
            }
            return resposta;
        } catch (error) {
            throw new VendaError('Erro ao adicionar venda!');
        }
    }

    async remover(vendaId) {
        try {
            console.log(vendaId);
            let resposta = await fetch(`${API}/venda/${vendaId}`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'DELETE',
            })

            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new Error();
            }
            console.log(resposta.json());
            return resposta;
        } catch (error) {
            throw new VendaError('Erro ao atualizar venda!');
        }
    }

    async comId(vendaId) {
        try {
            let resposta = await fetch(`${API}/venda/${vendaId}/show`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'GET',
            })
            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new Error();
            }
            return resposta;
        } catch (error) {
            throw new VendaError('Erro ao atualizar venda!');
        }
    }

    async dadosParaForm() {
        try {
            let resposta = await fetch(`${API}/venda/create`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'GET',
            })
            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new Error();
            }
            return resposta;
        } catch (error) {
            throw new VendaError('Erro ao atualizar venda!');
        }
    }
}