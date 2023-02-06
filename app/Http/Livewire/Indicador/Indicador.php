<?php

namespace App\Http\Livewire\Indicador;

use App\Models\Produto;
use App\Models\Venda;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Indicador extends Component
{
    public int $totalProduto;
    public string $produtoMaisCaro;
    public string $tickedMedio;

    public array $vendasPorDia;
    public array $produtosMaisVendidos;
    public string $produtoMaisVendido;
    public string $produtoMenosVendido;

    protected $listeners = [
        'Produto::create' => '$refresh',
        'Produto::delete' => '$refresh'
    ];


    public function mount()
    {

        $faturamentoPeriodo = DB::table('vendas')
            ->select(DB::raw('SUM(total) as total_sales'))
            ->first();

        $qtdVendasPeriodo = Venda::count();
        $groupedSales = Venda::select('data_venda')
            ->groupBy('data_venda')
            ->get();

        $vendasDia = $groupedSales;

        foreach ($vendasDia as $venda) {
            $date = Carbon::parse($venda->data_atual);

            if (!isset($this->vendasPorDia[$date->toDateString()])) {
                $this->vendasPorDia[$date->toDateString()] = 0;
            }

            $this->vendasPorDia[$date->toDateString()] += 1;
        }
        $maisVendidos = Produto::select('produtos.name', DB::raw('SUM(itens_vendas.quantidade) as total_vendido'))
            ->distinct()
            ->join('itens_vendas', 'produtos.id', '=', 'itens_vendas.produto_id')
            ->groupBy('produtos.name')
            ->orderBy('total_vendido', 'desc')
            ->get();

        foreach ($maisVendidos as $maisVendido) {
            $this->produtosMaisVendidos[$maisVendido->name] = $maisVendido->total_vendido;
        }
       
        $this->produtoMaisVendido = $maisVendido->first()->name;
        $this->produtoMenosVendido = Produto::select('produtos.name', DB::raw('SUM(itens_vendas.quantidade) as total_vendido'))
            ->distinct()
            ->join('itens_vendas', 'produtos.id', '=', 'itens_vendas.produto_id')
            ->groupBy('produtos.name')
            ->orderBy('total_vendido', 'asc')
            ->first()->name;
        $this->tickedMedio = ($qtdVendasPeriodo) ? $faturamentoPeriodo->total_sales / $qtdVendasPeriodo : 0;

        $this->totalProduto = Produto::count();

        !$this->totalProduto ?: $this->produtoMaisCaro = Produto::select('name', 'price')
            ->orderBy('price', 'desc')->first();
    }


    public function render()
    {
        return view('livewire.indicador.indicador');
    }
}
