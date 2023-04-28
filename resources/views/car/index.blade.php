<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 d-flex justify-content-center">
                    <h1 class="display-1">My Cars</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-primary" href="cars/create">Add Car</a>
                    </div>

                    <table class="table">
                        <thead>
                        <th>date</th>
                        <th>begin odometer</th>
                        <th>end odometer</th>
                        <th>distance</th>
                        <th></th>
                        </thead>
                        @foreach($cars as $car)
                            <tr>
                                <td>{{ $car->name }}</td>
                                <td>{{ $car->license_plate }}</td>
                                <td>{{ $car->totalDistance() }}</td>
                                <td>{{ $car->trackedDistance() }}</td>
                                <td><a class="btn btn-primary" href="cars/{{$car->id}}">details</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<?php