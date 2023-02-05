import { ProdutoError } from "./produto-error.js";
const API = 'http://localhost:8000';
const crfToken = document.querySelector('meta[name="csrf-token"]');

export class RepositorioProduto {
    async todos() {
        try {
            let resposta = await fetch(`${API}/produto`, {
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
            throw new ProdutoError('Erro ao atualizar produto!');
        }
    }

    async comNome(nomeProduto) {
        try {
            let resposta = await fetch(`${API}/produto/${nomeProduto}/comNome`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'GET',
            })
            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new Error();
            }
            return resposta.json();
        } catch (error) {
            throw new ProdutoError('Erro ao atualizar produto!');
        }
    }

    async adicionar(produto) {
        try {
            let resposta = await fetch(`${API}/produto`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'POST',
                body: JSON.stringify(produto),
            })
            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new Error();
            }
            return resposta;
        } catch (error) {
            throw new ProdutoError('Erro ao adicionar produto!');
        }
    }

    async atualizar(produto) {
        try {
            let resposta = await fetch(`${API}/produto/${produto.id}/edit`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'PUT',
                body: JSON.stringify(produto),
            })
            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new Error();
            }
            return resposta;
        } catch (error) {
            throw new ProdutoError('Erro ao adicionar produto!');
        }
    }

    async remover(produtoId) {
        try {
            let resposta = await fetch(`${API}/produto/${produtoId}`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': crfToken.getAttribute('content')
                },
                method: 'DELETE',
            })
            if (resposta.status >= 400) { // Mesmo que if ( ! resposta.ok )
                throw new Error();
            }
            return resposta;
        } catch (error) {
            throw new ProdutoError('Erro ao atualizar produto!');
        }
    }

    async comId(produtoId) {
        try {
            let resposta = await fetch(`${API}/produto/${produtoId}/show`, {
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
            throw new ProdutoError('Erro ao atualizar produto!');
        }
    }

    async dadosParaForm() {
        try {
            let resposta = await fetch(`${API}/produto/create`, {
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
            throw new ProdutoError('Erro ao atualizar produto!');
        }
    }
}