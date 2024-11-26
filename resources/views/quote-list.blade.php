@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-center mb-6">Saved Quotes</h1>

    <table class="table-auto w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Destination</th>
                <th class="px-4 py-2">Start Date</th>
                <th class="px-4 py-2">End Date</th>
                <th class="px-4 py-2">Travelers</th>
                <th class="px-4 py-2">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quotes as $quote)
                <tr>
                    <td class="border px-4 py-2">{{ $quote->destination }}</td>
                    <td class="border px-4 py-2">{{ $quote->start_date }}</td>
                    <td class="border px-4 py-2">{{ $quote->end_date }}</td>
                    <td class="border px-4 py-2">{{ $quote->number_of_travelers }}</td>
                    <td class="border px-4 py-2">${{ $quote->total_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
