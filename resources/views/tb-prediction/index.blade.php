<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 dark:text-gray-100 leading-tight">
            {{ __('TB Incidence Forecasting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6 mb-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-100">TB Incidence Prediction Tool</h3>
                        <p class="text-gray-400 mt-1">This tool uses ARIMA time-series analysis to forecast future TB incidence based on historical patterns.</p>
                    </div>
                </div>
            </div>
            <livewire:tb-forecast-table />
        </div>
    </div>
</x-app-layout>
