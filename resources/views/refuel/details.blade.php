<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-info" href="/refuels/{{ $refuel->id }}/manage">
                            <svg style="fill: black" xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
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
                    <div style="height: 40vh" class="d-flex justify-content-center mb-5">
                        <canvas id="usageChart"></canvas>
                    </div>
                    <div>
                        <div class="row justify-content-start">
                            <div class="col">driven kilometers:</div>
                            <div class="col">{{$refuel->distance()}}</div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col">liters tanked:</div>
                            <div class="col">{{round($refuel->liters, 2)}} L</div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col">payed amount:</div>
                            <div class="col">€ {{round($refuel->cost, 2)}}</div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col">driver:</div>
                            <div class="col">{{ $refuel->user->name }}</div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col">car:</div>
                            <div class="col">{{ $refuel->car->name }}</div>
                        </div>
                    </div>
                    <hr class="mt-4 mb-4">
                    <div class="accordion">
                        @foreach($users as $user)
                            @if(auth()->user()->id === $user->id)
                                <div class="accordion-item">
                                    <div class="accordion-header text-decoration-none  text-black" id="{{$user->id}}">
                                        <button class="btn button accordion-button" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{$user->id}}"
                                                aria-controls="collapse{{$user->id}}">
                                            {{$user->name}}
                                        </button>
                                    </div>
                                    <div id="collapse{{$user->id}}" class="accordion-collapse collapse show"
                                         aria-labelledby="Antwoord {{$user->id}}" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <div class="row justify-content-start">
                                                <div class="col">driven kilometers:</div>
                                                <div class="col">{{$refuel->userDriven($user)}}</div>
                                            </div>
                                            <div class="row justify-content-start">
                                                <div class="col">percentage driven:</div>
                                                <div class="col">{{round($refuel->percentageDriven($user))}}%</div>
                                            </div>
                                            <div class="row justify-content-start">
                                                <div class="col">amount owed:</div>
                                                <div class="col">€ {{round($refuel->amountToPay($user), 2)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="accordion-item">
                                    <div class="accordion-header text-decoration-none  text-black" id="{{$user->id}}">
                                        <button class="btn button accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{$user->id}}"
                                                aria-controls="collapse{{$user->id}}">
                                            {{$user->name}}
                                        </button>
                                    </div>
                                    <div id="collapse{{$user->id}}" class="accordion-collapse collapse"
                                         aria-labelledby="Antwoord {{$user->id}}" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <div class="row justify-content-start">
                                                <div class="col">driven kilometers:</div>
                                                <div class="col">{{$refuel->userDriven($user)}}</div>
                                            </div>
                                            <div class="row justify-content-start">
                                                <div class="col">percentage driven:</div>
                                                <div class="col">{{round($refuel->percentageDriven($user))}}%</div>
                                            </div>
                                            <div class="row justify-content-start">
                                                <div class="col">amount owed:</div>
                                                <div class="col">€ {{round($refuel->amountToPay($user), 2)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
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
                        <th>begin odometer</th>
                        <th>end odometer</th>
                        <th>distance</th>
                        <th>driver</th>
                        </thead>
                        @foreach($drives as $drive)
                            <tr>
                                <td label="created at">{{ $drive->created_at->format('d-m-Y') }}</td>
                                <td label="begin odometer">{{ $drive->begin_odometer }}</td>
                                <td label="end odometer">{{ $drive->end_odometer }}</td>
                                <td label="distance">{{ $drive->distance() }}</td>
                                <td label="driver">{{ $drive->user->name }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="module">
    let users = {{ \Illuminate\Support\Js::from($users) }};
    let drives = {{ \Illuminate\Support\Js::from($drives) }};

    for(let i=0;i<drives.length;i++){
        let drive = drives[i];
        for(let j=0;j<users.length;j++){
            let user = users[j];
            if(user.kilometers == undefined) user.kilometers = 0;
            if(user.amtOfDrives == undefined) user.amtOfDrives = 0;
            if(drive.user.id == user.id){
                user.kilometers += (drive.end_odometer - drive.begin_odometer);
                user.amtOfDrives++;
            }
        }
    }

    let labels = [];
    let drivenKilometersData = [];
    let amountOfDrivesData = [];
    for(let i=0;i<users.length;i++){
        labels.push(users[i].name);
        drivenKilometersData.push(users[i].kilometers);
        amountOfDrivesData.push(users[i].amtOfDrives)
    }

    new Chart(document.getElementById('usageChart'), {
        type: 'doughnut',
        data:{
            labels:labels,
            datasets:[{
                label:'driven kilometers',
                data: drivenKilometersData,
                // circumference: 180,
                rotation:270
            },{
                label:'amount of drives',
                data: amountOfDrivesData,
                // circumference: 180,
                rotation:90
            }]
        },
    })

    console.log(users);
    console.log(drives);
</script>