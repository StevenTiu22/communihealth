<div wire:ignore
    x-data="{
        init() {
            let chart = new Chart(this.$refs.socioeconomicStatusChart, {
                type: 'bar',
                data: $wire.chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Patient Count'
                            }
                        }
                    }
                }
            });
        }
    }"
     style="height: 250px"
>
    <canvas x-ref="socioeconomicStatusChart" id="socioeconomicStatusChart"></canvas>
</div>
