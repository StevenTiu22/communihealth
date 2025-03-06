<x-app-layout title="TB Prediction">
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold">Tuberculosis (TB) Prediction System</h1>
                        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Run Prediction</button>
                    </div>

                    <div class="mb-6">
                        <p class="text-gray-600 dark:text-gray-300">
                            This system predicts TB occurrence in different regions based on historical data analysis.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                        <!-- Prediction Stats Card -->
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Prediction Statistics</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>High Risk Areas:</span>
                                    <span class="font-medium text-red-500">3</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Medium Risk Areas:</span>
                                    <span class="font-medium text-yellow-500">7</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Low Risk Areas:</span>
                                    <span class="font-medium text-green-500">12</span>
                                </div>
                            </div>
                        </div>

                        <!-- Input Parameters Card -->
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Input Parameters</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm mb-1">Region</label>
                                    <select class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600">
                                        <option>All Regions</option>
                                        <option>Region 1</option>
                                        <option>Region 2</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Time Period</label>
                                    <select class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600">
                                        <option>Last 6 Months</option>
                                        <option>Last Year</option>
                                        <option>Last 3 Years</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Analysis Card -->
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Recent Analysis</h3>
                            <div class="space-y-2">
                                <p class="text-sm">Last prediction run: <span class="font-medium">June 20, 2024</span></p>
                                <p class="text-sm">Confidence level: <span class="font-medium">85%</span></p>
                                <p class="text-sm">Data points analyzed: <span class="font-medium">1,245</span></p>
                                <div class="mt-4">
                                    <a href="#" class="text-blue-500 hover:underline text-sm">View full report</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
