<div wire:ignore
    x-data="{
        init() {
            let chart = new Chart(this.$refs.diseaseSeverityChart, {
                type: 'bar',
                data: $wire.chartData,
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Cases'
                            }
                        }
                    }
                }
            });
        }
    }"
     style="height: 250px;"
>
    <canvas x-ref="diseaseSeverityChart" id="diseaseSeverityChart"></canvas>
</div>
