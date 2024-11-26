@extends('layouts.app')

@section('content')
<head>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<!-- Add the correct background image properties to prevent tiling -->
<body class="bg-gray-100 bg-cover bg-no-repeat bg-center min-h-screen" style="background-image: url('{{ asset('images/image1.jpg') }}')">

    <h1 class="text-4xl font-bold text-center mb-10 text-white">Travel Insurance Quote</h1>

    <form action="{{ route('quote.store') }}" method="POST" class="max-w-3xl mx-auto bg-white p-10 rounded-lg shadow-md border border-gray-300">
        @csrf

        <!-- Form Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Destination -->
            <div>
                <label for="destination" class="block text-lg font-medium text-gray-700 mb-3">Destination</label>
                <select name="destination" id="destination" class="w-full p-4 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="Europe">Europe (+$10)</option>
                    <option value="Asia">Asia (+$20)</option>
                    <option value="America">America (+$30)</option>
                </select>
            </div>

            <!-- Start Date -->
            <div>
                <label for="start_date" class="block text-lg font-medium text-gray-700 mb-3">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="w-full p-4 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- End Date -->
            <div>
                <label for="end_date" class="block text-lg font-medium text-gray-700 mb-3">End Date</label>
                <input type="date" name="end_date" id="end_date" class="w-full p-4 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Number of Travelers -->
            <div>
                <label for="number_of_travelers" class="block text-lg font-medium text-gray-700 mb-3">Number of Travelers</label>
                <input type="number" name="number_of_travelers" id="number_of_travelers" class="w-full p-4 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" min="1">
            </div>

            <!-- Coverage Options -->
            <div class="col-span-2">
                <label class="block text-lg font-medium text-gray-700 mb-3">Coverage Options</label>
                <div class="flex gap-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="medical_expenses" value="1" class="mr-3 rounded-md focus:ring-blue-500">
                        Medical Expenses (+$20)
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="trip_cancellation" value="1" class="mr-3 rounded-md focus:ring-blue-500">
                        Trip Cancellation (+$30)
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="mt-10 flex gap-8">
            <button type="submit" class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white py-4 px-8 rounded-lg shadow-xl transition ease-in-out duration-300">
                Get Quote
            </button>

            <button type="reset" class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white py-4 px-8 rounded-lg shadow-xl transition ease-in-out duration-300">
                Reset Form
            </button>
        </div>
    </form>

</body>
@endsection
