<link rel="stylesheet" href="/CSS/collapsable.css">

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="display-1 text-center">{{$car->name}}</h1>
                    <div class="d-flex flex-row justify-content-around">
                        <div class="flex-fill">
                            <div class="row justify-content-start">
                                <div class="col">license plate:</div>
                                <div class="col">{{$car->license_plate}}</div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col">total driven kilometers:</div>
                                <div class="col">{{$car->totalDistance()}}</div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col">total tracked kilometers:</div>
                                <div class="col">{{$car->trackedDistance()}}</div>
                            </div>
                        </div>
{{--                        <div class="devider flex-fill"></div>--}}
                        
                        <div class="flex-fill d-flex justify-content-center">NOOTNOOT</div>
                    </div>
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
                            <th>timestamp</th>
                            <th>distance</th>
                            <th>liters</th>
                            <th>cost</th>
                            <th></th>
                        </thead>
                        @foreach($refuels as $refuel)
                            <tr>
                                <td>{{$refuel->timestamp}}</td>
                                <td>{{$refuel->distance()}}</td>
                                <td>{{$refuel->liters}}</td>
                                <td>{{$refuel->cost}}</td>
                                <td><a class="btn btn-primary" href="/refuels/{{$refuel->id}}">details</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>