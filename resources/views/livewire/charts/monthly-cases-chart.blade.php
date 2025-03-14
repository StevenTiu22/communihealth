<div wire:ignore
    x-data="{
        init() {
            let chart = new Chart(this.$refs.monthlyCasesChart, {
                type: 'line',
                data: $wire.chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Cases'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    }
                }
            });
        }
    }"

     style="height: 250px"
>
    <canvas x-ref="monthlyCasesChart" id="monthlyCasesChart"></canvas>
</div>
