<div>
    <div class="bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg border border-gray-700">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-100">Forecast Data Summary</h3>

                <div class="flex items-center space-x-4">
                    <div>
                        <label for="forecastMonths" class="block text-sm font-medium text-gray-300">Months</label>
                        <select id="forecastMonths" wire:model="forecastMonths" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="3">3 months</option>
                            <option value="6">6 months</option>
                            <option value="12">12 months</option>
                            <option value="24">24 months</option>
                        </select>
                    </div>
                    <button wire:click="generateForecast" class="inline-flex items-center mt-5 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500">
                        <span wire:loading.remove wire:target="generateForecast">Update Forecast</span>
                        <span wire:loading wire:target="generateForecast">Processing...</span>
                    </button>
                </div>
            </div>

            @if($error)
                <div class="bg-red-900/40 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 112 0v4a1 1 0 11-2 0V9zm1-5.5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-300">{{ $error }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div wire:loading wire:target="generateForecast" class="flex justify-center py-12">
                <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-blue-400">Generating forecast data...</span>
            </div>

            <div wire:loading.remove wire:target="generateForecast">
                <!-- Chart Legend -->
                <div class="bg-gray-700 p-4 rounded-md mb-6">
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <span class="h-3 w-3 bg-blue-500 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-200">Predicted TB Cases</span>
                        </div>
                        <div class="flex items-center">
                            <span class="h-3 w-3 bg-blue-500/30 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-200">Confidence Range (95%)</span>
                        </div>
                        <div class="flex items-center ml-auto">
                            <span class="text-xs text-gray-400">Using ARIMA time-series forecasting model</span>
                        </div>
                    </div>
                </div>


                <!-- Model Version Info - ADD THIS SECTION -->
                <div class="bg-gray-800 border border-gray-700 rounded-md mb-6 overflow-hidden">
                    <div x-data="{ open: false }" class="w-full">
                        <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-200">
                                    Model: <span class="text-blue-400">{{ $currentModel->version_date->format('Y-m-d') ?? 'Unknown' }}</span>
                                    <!-- Show order if available -->
                                    @if(isset($currentModel) && isset($currentModel->order_p))
                                        <span class="text-gray-400 ml-1">(ARIMA({{ $currentModel->order_p }},{{ $currentModel->order_d }},{{ $currentModel->order_q }}))</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <!-- Model Freshness Indicator -->
                                @if(isset($currentModel) && $currentModel->last_data_date)
                                    @php
                                        $daysSinceUpdate = \Carbon\Carbon::parse($currentModel->last_data_date)->diffInDays(\Carbon\Carbon::now());
                                    @endphp

                                    @if($daysSinceUpdate < 30)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Recent
                        </span>
                                    @elseif($daysSinceUpdate < 60)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Moderate
                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-300">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Needs Update
                        </span>
                                    @endif
                                @endif

                                <!-- Dropdown Arrow -->
                                <svg :class="{'transform rotate-180': open}" class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <div x-show="open" x-collapse>
                            <div class="px-4 pt-0 pb-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    <!-- Training Information -->
                                    <div class="bg-gray-700/50 p-3 rounded">
                                        <h4 class="text-xs text-gray-400 uppercase mb-1">Training</h4>
                                        <p class="text-sm text-gray-200">
                                            Trained: {{ isset($currentModel) && $currentModel->training_date ? $currentModel->training_date->format('Y-m-d') : 'Unknown' }}
                                        </p>
                                        <p class="text-sm text-gray-200">
                                            Last Data: {{ isset($currentModel) && $currentModel->last_data_date ? $currentModel->last_data_date->format('Y-m-d') : 'Unknown' }}
                                        </p>
                                    </div>

                                    <!-- Model Metrics -->
                                    <div class="bg-gray-700/50 p-3 rounded">
                                        <h4 class="text-xs text-gray-400 uppercase mb-1">Metrics</h4>
                                        <div class="grid grid-cols-2 gap-2">
                                            <p class="text-sm text-gray-200">AIC: <span class="text-blue-300">{{ isset($currentModel) && $currentModel->aic ? number_format($currentModel->aic, 2) : 'N/A' }}</span></p>
                                            <p class="text-sm text-gray-200">BIC: <span class="text-blue-300">{{ isset($currentModel) && $currentModel->bic ? number_format($currentModel->bic, 2) : 'N/A' }}</span></p>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="bg-gray-700/50 p-3 rounded">
                                        <h4 class="text-xs text-gray-400 uppercase mb-1">Notes</h4>
                                        <p class="text-sm text-gray-200 line-clamp-2">
                                            {{ isset($currentModel) && $currentModel->notes ? $currentModel->notes : 'No additional information.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Container -->
                <div class="bg-gray-900 p-4 rounded-lg mb-8">
                    <div wire:ignore
                         x-data="{
                            chart: null,
                            forecastData: @entangle('forecastData'),

                            init() {
                                this.$watch('forecastData', (data) => {
                                    if (data && data.length > 0) {
                                        this.initChart();
                                    }
                                });

                                if (this.forecastData && this.forecastData.length > 0) {
                                    this.$nextTick(() => this.initChart());
                                }

                                window.addEventListener('chartDataUpdated', () => {
                                    this.$nextTick(() => this.initChart());
                                });
                            },

                            initChart() {
                                const ctx = this.$refs.tbForecastChart;

                                if (this.chart) {
                                    this.chart.destroy();
                                }

                                const labels = this.forecastData.map(item => item.month);
                                const forecasts = this.forecastData.map(item => item.forecast);
                                const lowerBounds = this.forecastData.map(item => item.lower_bound);
                                const upperBounds = this.forecastData.map(item => item.upper_bound);

                                this.chart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: labels,
                                        datasets: [
                                            {
                                                label: 'Forecasted TB Cases',
                                                data: forecasts,
                                                borderColor: 'rgb(59, 130, 246)',
                                                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                                borderWidth: 2,
                                                tension: 0.2,
                                                pointRadius: 4,
                                                pointBackgroundColor: 'rgb(59, 130, 246)',
                                                pointHoverRadius: 6,
                                                pointHoverBackgroundColor: 'white',
                                                pointHoverBorderColor: 'rgb(59, 130, 246)',
                                                pointHoverBorderWidth: 2,
                                                order: 1
                                            },
                                            {
                                                label: '95% Confidence Interval',
                                                data: lowerBounds,
                                                borderColor: 'rgba(59, 130, 246, 0.3)',
                                                pointRadius: 0,
                                                backgroundColor: 'transparent',
                                                borderWidth: 1,
                                                fill: false,
                                                tension: 0.1,
                                                order: 2
                                            },
                                            {
                                                label: '95% Confidence Interval Upper',
                                                data: upperBounds,
                                                borderColor: 'rgba(59, 130, 246, 0.3)',
                                                pointRadius: 0,
                                                backgroundColor: 'rgba(59, 130, 246, 0.15)',
                                                borderWidth: 1,
                                                fill: '-1',
                                                tension: 0.1,
                                                order: 2
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        animation: {
                                            duration: 1000
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'TB Cases',
                                                    color: '#9ca3af',
                                                    font: {
                                                        weight: 'normal'
                                                    }
                                                },
                                                grid: {
                                                    color: 'rgba(75, 85, 99, 0.2)',
                                                },
                                                ticks: {
                                                    precision: 0,
                                                    color: '#9ca3af',
                                                }
                                            },
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Month',
                                                    color: '#9ca3af',
                                                    font: {
                                                        weight: 'normal'
                                                    }
                                                },
                                                grid: {
                                                    display: false,
                                                },
                                                ticks: {
                                                    color: '#9ca3af',
                                                }
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false,
                                            },
                                            tooltip: {
                                                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                                titleColor: '#f3f4f6',
                                                bodyColor: '#f3f4f6',
                                                borderColor: '#4b5563',
                                                borderWidth: 1,
                                                padding: 10,
                                                displayColors: false,
                                                callbacks: {
                                                    title: function(tooltipItems) {
                                                        return tooltipItems[0].label;
                                                    },
                                                    label: function(context) {
                                                        const datasetLabel = context.dataset.label || '';

                                                        if (datasetLabel === 'Forecasted TB Cases') {
                                                            return `Forecast: ${context.parsed.y} cases`;
                                                        }
                                                        else if (context.datasetIndex === 1) {
                                                            const upperValue = upperBounds[context.dataIndex];
                                                            return `Range: ${context.parsed.y} - ${upperValue} cases (95% confidence)`;
                                                        }
                                                        return null;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                         }"
                         style="height: 400px;"
                    >
                        <canvas x-ref="tbForecastChart" id="tbForecastChart"></canvas>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Month</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Predicted Cases</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Lower Bound (95%)</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Upper Bound (95%)</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Range</th>
                        </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @if($forecastData)
                            @foreach($forecastData as $forecast)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $forecast['month'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-right font-medium">{{ $forecast['forecast'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-right">{{ $forecast['lower_bound'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-right">{{ $forecast['upper_bound'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-right">
                                        <span class="inline-flex w-20 h-4 bg-gray-700 rounded">
                                            <span class="w-full h-full bg-blue-600 opacity-50 rounded" style="width: {{ min(100, max(0, ($forecast['upper_bound'] - $forecast['lower_bound']) / max(1, $forecast['forecast']) * 50)) }}%"></span>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 text-center">No forecast data available</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
