<link rel="stylesheet" href="/CSS/app.css">
{{--TODO: add list of current members--}}
{{--TODO: add list of pending invites--}}
{{--TODO: add ability to revoke and create invite--}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-info rounded-circle p-1 m-1" href="/cars/{{ $car->id }}">
                            <svg style="fill: black" xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M267.5 440.6c9.5 7.9 22.8 9.7 34.1 4.4s18.4-16.6 18.4-29V96c0-12.4-7.2-23.7-18.4-29s-24.5-3.6-34.1 4.4l-192 160L64 241V96c0-17.7-14.3-32-32-32S0 78.3 0 96V416c0 17.7 14.3 32 32 32s32-14.3 32-32V271l11.5 9.6 192 160z"/></svg>
                        </a>
                    </div>
                    <h1 class="display-1 text-center">Manage {{$car->name}}</h1>
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
                    <div>
                        <div class="position-relative">
                            <h2 class="text-center display-6">
                                users
                            </h2>
                            @if(!Agent::isMobile())
                                <div class="position-absolute translate-middle-y top-50 end-0 ">
                            @else
                                <div class="d-flex justify-content-center">
                            @endif
                                <a class="btn btn-primary" href="/cars/{{ $car->id }}/share">invite someone</a>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>name</th>
                                <th>actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td label="name">{{ $user->name }}</td>
                                    <td label="actions">
                                        -
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-center display-6">current set</h2>
                    <table class="table bigBoiTable">
                        <thead>
                            <th>created at</th>
                            <th>distance</th>
                            <th>begin odometer</th>
                            <th>end odometer</th>
                            <th>driver</th>
                            <th></th>
                        </thead>
                        <tbody>
                        @foreach($drives as $drive)
                            <tr class="text-md">
                                <td label="created at" class="align-middle">{{$drive->created_at}}</td>
                                <td label="distance" class="align-middle">{{$drive->distance()}}</td>
                                <td label="begin odometer" class="align-middle">{{$drive->begin_odometer}}</td>
                                <td label="end odometer" class="align-middle">{{$drive->end_odometer}}</td>
                                <td label="driver" class="align-middle">{{$drive->user->name}}</td>
                                <td label="add to" class="align-middle">
                                    <form action="/refuels/addDrive" method="post" class="m-0">
                                        @csrf
                                        <select name="refuel_id" id="refuel_id" class="addDriveToRefuel">
                                            <option value="" autofocus>select refuel</option>
                                            @foreach($refuels->slice(0, 10) as $refuel)
                                                <option value="{{$refuel->id}}">{{\Carbon\Carbon::createFromDate($refuel->created_at)->format('d-m-Y')}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="drive_id" value="{{$drive->id}}">

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
                        <th>created at</th>
                        <th>distance</th>
                        <th>liters</th>
                        <th>cost</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @foreach($refuels as $refuel)
                            <tr>
                                <td label="created at">{{$refuel->created_at->format('d-m-Y') }}</td>
                                <td label="distance">{{$refuel->distance()}}</td>
                                <td label="liters">{{$refuel->liters}}</td>
                                <td label="cost">{{$refuel->cost}}</td>
                                <td label="">
                                    <a class="btn btn-primary p-1" href="/refuels/{{$refuel->id}}/manage">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M320 0c-17.7 0-32 14.3-32 32s14.3 32 32 32h82.7L201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3V192c0 17.7 14.3 32 32 32s32-14.3 32-32V32c0-17.7-14.3-32-32-32H320zM80 32C35.8 32 0 67.8 0 112V432c0 44.2 35.8 80 80 80H400c44.2 0 80-35.8 80-80V320c0-17.7-14.3-32-32-32s-32 14.3-32 32V432c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16H192c17.7 0 32-14.3 32-32s-14.3-32-32-32H80z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    //get all input filds with class addDriveToRefuel
    let addDriveToRefuel = document.querySelectorAll('.addDriveToRefuel');
    //loop over all input filds
    addDriveToRefuel.forEach(function (input) {
        //add event listener to input fild
        input.addEventListener('change', function () {
            //get the form
            let form = this.parentElement;
            //submit the form
            form.submit();
        });
    });
</script>