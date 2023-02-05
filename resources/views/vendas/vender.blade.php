@extends('layouts.app')

@section('content')
<script src="{{url(mix('js/vendas/index.js'))}}" type="module" defer="true"></script>


<x-card title="Painel de vendas">
   <div class="w-100 mx-auto py-10">
      <h1 class="text-2xl font-bold mb-5">Meu PDV</h1>
      
      <div class="message message-success hidden">
         <p>Operação realizada com sucesso!</p>
      </div>

      <form class="mb-5">
         <div>
            <label class="block mb-2 font-bold">Produto</label>
            <input type="text" id="produto" name="produto" placeholder="Digite aqui para buscar o produto!" class="border border-gray-400 p-2 w-full">
            <ul id="product-list">
            </ul>
         </div>

         <h1 class="text-2xl font-bold mb-5 mt-5">Itens Do Pedido</h1>


         <table class="w-full text-left table-collapse" id="itens_pedido">
            <thead>
               <tr class="bg-gray-800 text-white">
                  <th class="px-4 py-2 text-center">Produto</th>
                  <th class="px-4 py-2 text-center">Descrição</th>
                  <th class="px-4 py-2 text-center">Preço</th>
                  <th class="px-4 py-2 text-center">Quantidade</th>
                  <th class="px-4 py-2 text-center">Total</th>
                  <th class="px-4 py-2 text-center">Ações</th>
               </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            </tfoot>
         </table>

         <div class="flex items-center justify-center ">
            <button type="button" id="salvar" name="salvar" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5 ">
               Registrar Venda
            </button>
         </div>
      </form>
   </div>
</x-card>

@endsection