<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 d-flex justify-content-around">
                    <a class="btn btn-primary" href="drives/create">Add Drive</a>
                    <div class="devider"></div>
                    <a class="btn btn-primary" href="refuels/create">Add Refuel</a>
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Car</td>
                            <td>Last driver</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cars as $car) @endforeach
                        <tr>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->drives()->orderBy('created_at', 'desc')->first()->user->name }}</td>
                            <td>
                                <a class="btn btn-secondary" href="/drives/create/{{ $car->id }}">Add Drive</a> | <a class="btn btn-secondary">Add Refuel</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
