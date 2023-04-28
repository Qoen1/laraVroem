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
                    {{--success message--}}
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                        <br>
                    @endif

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-primary" href="drives/create">Add Drive</a>
                    </div>

                    <table class="table">
                        <thead>
                            <th>date</th>
                            <th>begin odometer</th>
                            <th>end odometer</th>
                            <th>distance</th>
                            <th>car</th>
                        </thead>
                        @foreach($drives as $drive)
                            <tr>
                                <td>{{ $drive->created_at }}</td>
                                <td>{{ $drive->begin_odometer }}</td>
                                <td>{{ $drive->end_odometer }}</td>
                                <td>{{ $drive->distance() }}</td>
                                <td>{{ $drive->car->name }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
