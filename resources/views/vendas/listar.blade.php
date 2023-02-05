@extends('layouts.app')

@section('content')
<script src="{{url(mix('js/vendas/index.js'))}}" type="module" defer="true"></script>


<x-card title="Vendas Realizadas">
   <div class="flex items-center justify-center">
      <button type="button" id="vender" name="vender" class="bg-green-500 text-white py-2 px-4 rounded mb-5">VENDER</button>
   </div>

   <hr>
   <h1 class="text-2xl font-bold mb-5">Vendas</h1>

   <table class="w-full text-left table-collapse " id="itens_pedido">
      <thead>
         <tr class="bg-gray-800 text-white">
            <th class="px-4 py-2 text-center">ID</th>
            <th class="px-4 py-2 text-center">DATA</th>
            <th class="px-4 py-2 text-center">TOTAL</th>
            <th class="px-4 py-2 text-center">Açoes</th>
         </tr>
      </thead>
      <tbody>
         @foreach($vendas as $venda)
         <tr class="bg-gray-100">
            <td class="border px-4 py-2 text-center">{{$venda->id}}</td>
            <td class="border px-4 py-2 text-center">{{\Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y H:m')}}</td>
            <td class="border px-4 py-2 text-center">{{$venda->total}}</td>
            <td class="border px-4 py-2 text-center">
               <a href="{{ url('venda/'.$venda->id.'/edit') }}" class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 rounded-full mr-3">
                  Atualizar
               </a>
               <a href="{{ url('venda/'.$venda->id) }}" class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-4 rounded-full mr-3">
                  Visualizar
               </a>
               <button id="remover_venda" name="remover_venda" data-id="{{$venda->id}}" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded-full mr-3 remover_venda">
                  Remover
               </button>
            </td>
         </tr>
         @endforeach
      </tbody>
      <tfoot>
      </tfoot>
   </table>
</x-card>

@endsection