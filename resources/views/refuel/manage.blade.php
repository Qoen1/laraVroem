<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-info rounded-circle p-1 m-1" href="/refuels/{{ $refuel->id }}">
                            <svg style="fill: black" xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M267.5 440.6c9.5 7.9 22.8 9.7 34.1 4.4s18.4-16.6 18.4-29V96c0-12.4-7.2-23.7-18.4-29s-24.5-3.6-34.1 4.4l-192 160L64 241V96c0-17.7-14.3-32-32-32S0 78.3 0 96V416c0 17.7 14.3 32 32 32s32-14.3 32-32V271l11.5 9.6 192 160z"/></svg>
                        </a>
                    </div>
                    <h1 class="text-center display-1">Refuel on {{$refuel->created_at->format('d-m-Y')}}</h1>


                </div>
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table">
                        <thead>
                        <th>created at</th>
                        <th>begin odometer</th>
                        <th>end odometer</th>
                        <th>distance</th>
                        <th>driver</th>
                        <th></th>
                        </thead>
                        @foreach($drives as $drive)
                            <tr>
                                <td>{{ $drive->created_at->format('d-m-Y') }}</td>
                                <td>{{ $drive->begin_odometer }}</td>
                                <td>{{ $drive->end_odometer }}</td>
                                <td>{{ $drive->distance() }}</td>
                                <td>{{ $drive->user->name }}</td>
                                <td>
                                    <form action="/refuels/removeDrive" method="post">
                                        @csrf
                                        <input type="hidden" name="refuel_id" value="{{ $refuel->id }}">
                                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                                        <button class="btn btn-danger bg-danger" type="submit">-</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
