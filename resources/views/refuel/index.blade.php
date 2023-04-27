<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 d-flex justify-content-center">
                    <h1 class="display-1">My Refuels</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table">
                        <thead>
                        <th>date</th>
                        <th>distance</th>
                        <th>Car</th>
                        <th></th>
                        </thead>
                        @foreach($refuels as $refuel)
                            <tr>
                                <td>{{ $refuel->timestamp }}</td>
                                <td>{{ $refuel->distance() }}</td>
                                <td>{{ $refuel->car->name }}</td>
                                <td><a class="btn btn-primary" href="cars/{{$refuel->id}}">details</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<?php
