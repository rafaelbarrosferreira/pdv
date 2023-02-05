@extends('layouts.app')

@section('content')
<script src="{{url(mix('js/vendas/index.js'))}}" type="module" defer="true"></script>


<x-card title="Painel de vendas">
   <div class="w-100 mx-auto py-10">
      <h1 class="text-2xl font-bold mb-5">Editar Venda</h1>

      <form class="mb-5">
         <div>
            <label class="block mb-2 font-bold">Data da Venda</label>
            <input type="text" id="data_venda" name="data_venda" value="{{\Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y H:m')}}" disabled class="border border-gray-400 p-2 w-full">
         </div>

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
               @foreach($venda->produtos as $produto)
               <tr class="bg-gray-100" data-id="{{$produto->id}}">
                  <td class="border px-4 py-2 text-center" data-name="{{$produto->name}}">{{$produto->name}}</td>
                  <td class="border px-4 py-2 text-center" data-description="{{$produto->description}}">{{$produto->description}}</td>
                  <td class="border px-4 py-2 text-center" data-price="{{$produto->price}}">{{$produto->price}}</td>
                  <td class="border px-4 py-2 text-center" data-price="{{$produto->pivot->quantidade}}">
                     <input type="number" name="quantidade_{{$produto->id}}"  id="quantidade_{{$produto->id}}" class="quantidade_produto" value="{{$produto->pivot->quantidade}}" min="1">
                  </td>
                  <td class="border px-4 py-2 text-center" data-total="{{($produto->pivot->quantidade * $produto->price)}}">R$ {{($produto->pivot->quantidade * $produto->price)}}</td>
                  <td class="border px-4 py-2 text-center">
                     <button type="button" class="m-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Remover
                     </button>
                  </td>
               </tr>
               @endforeach
            </tbody>
            <tfoot>
               <tr class="text-sm text-gray-700 bg-gray-200 text-lg">
                  <td colspan="4" style="text-align: center;">Total</td>
                  <td colspan="2" style="text-align: center;">R$ {{$venda->total}}</td>
               </tr>
            </tfoot>
         </table>

         <div class="flex items-center justify-center ">
            <button type="button" id="salvar" name="salvar" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5 ">
               Editar Venda
            </button>
         </div>
      </form>
   </div>
</x-card>

@endsection