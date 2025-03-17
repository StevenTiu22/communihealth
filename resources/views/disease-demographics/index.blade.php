<x-app-layout :title="$title">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            {{ __('Patient and Disease Demographics') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Patient Sex Distribution Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Patient Sex Distribution</h3>
                        <div class="h-auto">
                            <livewire:charts.sex-distribution-chart />
                        </div>
                    </div>
                </div>

                <!-- Age Distribution Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Age Distribution</h3>
                        <div class="h-64">
                            <livewire:charts.age-distribution-chart />
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Socioeconomic Status Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Socioeconomic Status</h3>
                        <div class="h-64">
                            <livewire:charts.socio-economic-status-chart />
                        </div>
                    </div>
                </div>

                <!-- Disease Type Distribution Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Disease Type Distribution</h3>
                        <div class="h-64">
                            <livewire:charts.disease-type-chart />
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Disease Severity Distribution Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Disease Severity Distribution</h3>
                        <div class="h-64">
                            <livewire:charts.disease-severity-chart />
                        </div>
                    </div>
                </div>

                <!-- Monthly Disease Cases Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Disease Cases</h3>
                        <div class="h-64">
                            <livewire:charts.monthly-cases-chart />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
