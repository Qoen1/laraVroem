<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 d-flex justify-content-center">
                    <h1 class="display-1">My Refuels</h1>
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                        <br>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger ">
                            {{ $errors->all()[0] }}
                        </div>
                        <br>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table bigBoiTable">
                        <thead>
                        <th>date</th>
                        <th>distance</th>
                        <th>Car</th>
                        <th></th>
                        </thead>
                        @foreach($refuels as $refuel)
                            <tr>
                                <td label="date">{{ $refuel->created_at->format('d-m-Y') }}</td>
                                <td label="distance">{{ $refuel->distance() }}</td>
                                <td label="car">{{ $refuel->car->name }}</td>
                                <td label=""><a class="btn btn-primary" href="refuels/{{$refuel->id}}">details</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<?php
