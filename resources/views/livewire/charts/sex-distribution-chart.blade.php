<div x-data="{
    init() {
        const ctx = this.$refs.sexDistribution;
        const chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: $wire.chartData['labels'],
            datasets: $wire.chartData.datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
        });
    }
}"
>
    <canvas wire:ignore x-ref="sexDistribution" id="sex-distribution"></canvas>
</div>
