<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 d-flex justify-content-center">
                    <h1 class="display-1">My Drives</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
                    
                    <div class="table-container">
                        <table class="table bigBoiTable">
                            <thead>
                            <th>date</th>
                            <th>begin odometer</th>
                            <th>end odometer</th>
                            <th>distance</th>
                            <th></th>
                            </thead>
                            @foreach($drives as $drive)
                                <tr>
                                    <td label="date">{{ $drive->created_at->format('d-m-Y') }}</td>
                                    <td label="begin odometer">{{ $drive->begin_odometer }}</td>
                                    <td label="end odometer">{{ $drive->end_odometer }}</td>
                                    <td label="distance">{{ $drive->distance() }}</td>
                                    <td label="car">{{ $drive->car->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
