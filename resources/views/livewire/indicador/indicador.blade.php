<script>
    document.addEventListener('DOMContentLoaded', function() {
        const vendasPorDia = new Chart(document.getElementById('vendasPorDia'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($vendasPorDia)); ?>,
                datasets: [{
                    label: 'Vendas Por dia',
                    data: <?php echo json_encode(array_values($vendasPorDia)); ?>,
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
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });

        const vendasPorProduto = new Chart(document.getElementById('vendasPorProduto'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($produtosMaisVendidos)); ?>,
                datasets: [{
                    label: 'Vendas por produto',
                    data: <?php echo json_encode(array_values($produtosMaisVendidos)); ?>,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
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
                
                <div class=" bg-white p-3 border shadow-md shadow-red rounded-md">

                    <p class="font-bold-500 text-xl">{{ $produtoMaisVendido ? $produtoMaisVendido: ''}} </p>
                    <p class="">Produto Mais vendido</p>
                </div>
 
                <div class=" bg-white p-3 border shadow-md shadow-red rounded-md">

                    <p class="font-bold-500 text-xl">{{ $produtoMenosVendido ? $produtoMenosVendido : ''}} </p>
                    <p class="">Produto menos vendido</p>
                </div>
            </div>
        </div>


        <div class=" bg-white p-3 border shadow-md shadow-red rounded-md">
            <div class="my-2">
                <canvas style="height: 300px; width: 100%;" id="vendasPorProduto"></canvas>

            </div>
        </div>]

        <div class=" bg-white p-3 border shadow-md shadow-red rounded-md">

            <div class="my-2">
                <canvas style="height: 100px; width: 20%;" id="vendasPorDia"></canvas>

            </div>
        </div>
    </x-card>
</div>