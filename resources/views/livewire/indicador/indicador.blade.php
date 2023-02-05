<script>
    document.addEventListener('DOMContentLoaded', function() {
        const myChart = new Chart(document.getElementById('myChart'), {
            type: 'line',
            data: {
                labels: [
                    'Aprovações Diretas',
                    'Aprovações   por   Avaliação   Final',
                    'Reprovações   por   Nota',
                    'Reprovações por Falta'
                ],
                datasets: [{
                    label: 'My First Dataset',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                onClick: (e) => {
                    const canvasPosition = getRelativePosition(e, chart);

                    // Substitute the appropriate scale IDs
                    const dataX = chart.scales.x.getValueForPixel(canvasPosition.x);
                    const dataY = chart.scales.y.getValueForPixel(canvasPosition.y);
                }
            }
        });

    })
</script>

<div x-data="{ open: false }" x-cloak class=" flex justify-center mt-4 ">
    <button @click="open = ! open" x-bind:class="[open ? '': 'animate-pulse' ]" class="text-2xl font-medium rounded-full bg-indigo-600 hover:bg-indigo-500 focus:border-gray-800 text-white p-2.5">
        <x-icon name="clipboard-check" class="w-5 h-5" />
    </button>
    <br>
    <div x-show="open" class="ml-2">
        <x-card>
            📊 Indicador é uma forma de agregar valor para seu cliente, ele traz o que é mais importante e ajuda na tomada de decisão.
        </x-card>
    </div>
</div>


<div class="my-2">

    <x-card class="border-info-800 my-2  " title="Indicadores">

        <div class="my-4 flex justify-between">
            <label for="start-date" class="text-sm font-medium">Data Inicial:</label>
            <input type="date" id="start-date" value="{{\Carbon\Carbon::now()->toDateString()}}" x-model="startDate" class="border px-2 py-1 rounded-md">

            <label for="end-date" class="text-sm font-medium">Data Final:</label>
            <input type="date" id="end-date" x-model="endDate" value="{{\Carbon\Carbon::now()->addDays(30)->toDateString()}}" class="border px-2 py-1 rounded-md">
        </div>

        <div x-data="{ startDate: '', endDate: '' }">
            <div wire:loading.class="hidden" class="text-center grid grid-cols-2 gap-2">


                <div class=" bg-white p-3 border shadow-md shadow-red rounded-md">

                    <p class="font-bold-500 text-xl">{{$totalProduto }}</p>
                    <p class="">Quantidade de Produtos Cadastrado</p>
                </div>

                <div class=" bg-white p-3 border shadow-md shadow-red rounded-md">

                    <p class="font-bold-500 text-xl">{{ $produtoMaisCaro ? json_decode($produtoMaisCaro)->name.' R$ '.json_decode($produtoMaisCaro)->price : 'Não existe produto'}} </p>
                    <p class="">Produto Mais Caro</p>
                </div>
                
                <div class=" bg-white p-3 border shadow-md shadow-red rounded-md">

                    <p class="font-bold-500 text-xl">{{ $tickedMedio > 0 ? number_format($tickedMedio,3): 0.00}} </p>
                    <p class="">Ticked Médio</p>
                </div>
            </div>
        </div>


    </x-card>
</div>

<div class="my-2">
    <canvas id="myChart"></canvas>

</div>