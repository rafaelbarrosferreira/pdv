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
    public $startDate;
    public $endDate;

    public array $vendasPorDia;

    protected $listeners = [
        'Produto::create' => '$refresh',
        'Produto::delete' => '$refresh'
    ];


    public function mount()
    {

        $faturamentoPeriodo = DB::table('vendas')->select(DB::raw('SUM(total) as fat'))->whereBetween('created_at',[Carbon::parse($this->startDate)->hour(0)->minute(0)->toDateTimeString(),Carbon::parse($this->endDate)->toDateTimeString()])->first();

        $qtdVendasPeriodo = Venda::whereBetween('created_at',[Carbon::parse($this->startDate)->hour(0)->minute(0)->toDateTimeString(),Carbon::parse($this->endDate)->toDateTimeString()])->count();
        $currentDate = Carbon::now()->toDateString();
        $currentDate = Carbon::now()->toDateString();


        $this->vendasPorDia =  Venda::selectRaw('count(distinct created_at) as count, created_at as data')
        ->whereBetween('created_at', [
            Carbon::parse($this->startDate)->startOfDay()->toDateTimeString(),
            Carbon::parse($this->endDate)->toDateTimeString()
        ])
        ->groupBy('created_at')
        ->get()->toArray();
        
        $this->tickedMedio =($qtdVendasPeriodo) ? $faturamentoPeriodo->fat/ $qtdVendasPeriodo : 0;

        $this->totalProduto = Produto::count();

        !$this->totalProduto ? : $this->produtoMaisCaro = Produto::select('name','price')
                                                        ->orderBy('price','desc')->first();

  

    }


    public function render()
    {
        return view('livewire.indicador.indicador');
    }
}

