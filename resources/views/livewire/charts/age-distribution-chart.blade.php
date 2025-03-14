<div wire:ignore
    x-data="{
        init() {
            chart = new Chart(this.$refs.ageDistributionChart, {
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
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Age Group'
                            }
                        }
                    }
                }
            });
        }
    }"
     style="height: 300px;"
>
    <canvas x-ref="ageDistributionChart" id="ageDistributionChart"></canvas>
</div>
