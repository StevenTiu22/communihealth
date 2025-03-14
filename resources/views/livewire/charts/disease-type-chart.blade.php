<div wire:ignore
    x-data="{
        init() {
            let chart = new Chart(this.$refs.diseaseTypeChart, {
                type: 'doughnut',
                data: $wire.chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        }
    }"
     style="height: 250px"
>
    <canvas x-ref="diseaseTypeChart" id="diseaseTypeChart"></canvas>
</div>
