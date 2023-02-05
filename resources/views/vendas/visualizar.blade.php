@extends('layouts.app')

@section('content')
<script src="{{url(mix('js/vendas/index.js'))}}" type="module" defer="true"></script>


<x-card title="Painel de vendas">
   <div class="w-100 mx-auto py-10">
      <h1 class="text-2xl font-bold mb-5">Visualizar Venda</h1>

      <form class="mb-5">
         <div>
            <label class="block mb-2 font-bold">Data da Venda</label>
            <input type="text" id="data_venda" name="data_venda" value="{{\Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y H:m')}}" disabled class="border border-gray-400 p-2 w-full">
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
               </tr>
            </thead>
            <tbody>
               @foreach($venda->produtos as $produto)
               <tr class="bg-gray-100" data-id="{{$produto->id}}">
                  <td class="border px-4 py-2 text-center" data-name="{{$produto->name}}">{{$produto->name}}</td>
                  <td class="border px-4 py-2 text-center" data-description="{{$produto->description}}">{{$produto->description}}</td>
                  <td class="border px-4 py-2 text-center" data-price="{{$produto->price}}">{{$produto->price}}</td>
                  <td class="border px-4 py-2 text-center" data-price="{{$produto->pivot->quantidade}}">
                     {{$produto->pivot->quantidade}}
                  </td>
                  <td class="border px-4 py-2 text-center" data-total="{{($produto->pivot->quantidade * $produto->price)}}">R$ {{($produto->pivot->quantidade * $produto->price)}}</td>
               </tr>
               @endforeach
            </tbody>
            <tfoot>
               <tr class="text-sm text-gray-700 bg-gray-200 text-lg">
                  <td colspan="4" style="text-align: center;">Total</td>
                  <td colspan="1" style="text-align: center;">R$ {{$venda->total}}</td>
               </tr>
            </tfoot>
         </table>

         <div class="flex items-center justify-center ">
            <a href="{{ url('venda/') }}" class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-4 rounded-full m-4">
               Voltar
            </a>
         </div>
      </form>
   </div>
</x-card>

@endsection