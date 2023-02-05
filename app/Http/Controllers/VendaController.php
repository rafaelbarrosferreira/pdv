<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendas = Venda::with(['produtos'])->get();
        return view('vendas.listar')->with('vendas', $vendas)->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendas.vender')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $regras = [
                'data_venda' => 'required|int',
                'total' => 'required',
                'itensProdutos' => 'required|array'
            ];

            $data = $request->all();
            $validator = Validator($data, $regras);
            if ($validator->fails()) {
                $resposta['erros'] = $validator->errors();
                throw new \Exception('Ocorreu um erro no envio de dados!');
            }
            $data['data_venda'] = Carbon::now();

            $venda = Venda::create($data);
            $itens = [];
            if (count($data['itensProdutos'])) {
                foreach ($data['itensProdutos'] as $item) {
                    $itens[] = [
                        'produto_id' => $item['id'],
                        'venda_id' => $venda->id,
                        'preco' => $item['price'],
                        'quantidade' => $item['quantidade'],
                    ];
                }
            } else {
                throw new \Exception("É necessário ao menos um produto para realização desta venda!");
            }

            if (count($itens)) $venda->produtos()->attach($itens);

            DB::commit();

            return ['Venda Realizada com Sucesso'];
        } catch (\Exception $e) {
            DB::rollBack();
            return response([$e->getMessage()], 400)->headesr('Content-Type', 'text/plain');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venda = Venda::where('id',$id)->with(['produtos'])->first();
        return view('vendas.visualizar')->with('venda', $venda)->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venda = Venda::where('id',$id)->with(['produtos'])->first();
        return view('vendas.editar')->with('venda', $venda)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $regras = [
                'data_venda' => 'required|int',
                'total' => 'required',
                'itensProdutos' => 'required|array'
            ];

            $data = $request->all();
            $validator = Validator($data, $regras);
            if ($validator->fails()) {
                $resposta['erros'] = $validator->errors();
                throw new \Exception('Ocorreu um erro no envio de dados!');
            }
            unset($data['data_venda']);
            
            $venda = Venda::find($id);
            $venda->total = $data['total'];
            $venda->save();

            $itens = [];
            if (count($data['itensProdutos'])) {
                foreach ($data['itensProdutos'] as $item) {
                    $itens[] = [
                        'produto_id' => $item['id'],
                        'venda_id' => $venda->id,
                        'preco' => $item['price'],
                        'quantidade' => $item['quantidade'],
                    ];
                }
            } else {
                throw new \Exception("É necessário ao menos um produto para realização desta venda!");
            }

            $venda->produtos()->detach();

            if (count($itens)) $venda->produtos()->attach($itens);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            DB::commit();

            return ['Venda atualizada com Sucesso'];
        } catch (\Exception $e) {
            DB::rollBack();
            return response([$e->getMessage()], 400)->headesr('Content-Type', 'text/plain');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $venda =  Venda::find($id);
            $venda->produtos()->detach();
            $deleted = $venda->delete();
            if($deleted){
                return true;
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        } catch (\Exception $e) {
            return response([$e->getMessage()], 400)->headesr('Content-Type', 'text/plain');
        }
    }
}
