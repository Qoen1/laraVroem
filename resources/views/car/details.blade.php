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
                        <a class="btn btn-outline-info" href="/cars/{{ $car->id }}/manage">
                            <svg style="fill: black" xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                        </a>
                    </div>
                    <h1 class="display-1 text-center">{{$car->name}}</h1>
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
                    <div class="d-flex flex-row justify-content-around flex-wrap">
                        <div class="flex-fill d-flex flex-column">
                            <div class="row justify-content-start">
                                <div class="col">license plate:</div>
                                <div class="col">{{$car->license_plate}}</div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col">current odometer value:</div>
                                <div class="col">{{$car->totalDistance()}}</div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col">total tracked kilometers:</div>
                                <div class="col">{{$car->trackedDistance()}} km</div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col">total fuel consumption:</div>
                                <div class="col">{{round($car->totalFuel(), 2)}} L</div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col">Average fuel consumption:</div>
                                <div class="col">{{round($car->averageKilometersPerLiter(), 2)}} km / L</div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col">Average fuel price:</div>
                                <div class="col">€ {{round($car->averageFuelCost(), 2)}}</div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col">Average spent per kilometer:</div>
                                <div class="col">€ {{round($car->averageCostPerKilometer(), 2)}}</div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col">Total spent on fuel:</div>
                                <div class="col">€ {{round($car->totalFuelCost(), 2)}}</div>
                            </div>
                        </div>
                        <div class="devider"></div>

                        <div class="flex-fill d-flex justify-content-center">
                            <canvas id="Chart" class=" embed-responsive embed-responsive-4by3"></canvas>
                        </div>
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
                    <table class="table">
                        <thead>
                            <th>created at</th>
                            <th>distance</th>
                            <th>begin odometer</th>
                            <th>end odometer</th>
                            <th>driver</th>
                        </thead>
                        @foreach($drives as $drive)
                            <tr class="text-md">
                                <td class="align-middle">{{$drive->created_at}}</td>
                                <td class="align-middle">{{$drive->distance()}}</td>
                                <td class="align-middle">{{$drive->begin_odometer}}</td>
                                <td class="align-middle">{{$drive->end_odometer}}</td>
                                <td class="align-middle">{{$drive->user->name}}</td>
                            </tr>
                        @endforeach
                    </table>
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
                            <th>created at</th>
                            <th>distance</th>
                            <th>liters</th>
                            <th>cost</th>
                            <th></th>
                        </thead>
                        @foreach($refuels as $refuel)
                            <tr>
                                <td>{{$refuel->created_at->format('d-m-Y') }}</td>
                                <td>{{$refuel->distance()}}</td>
                                <td>{{$refuel->liters}}</td>
                                <td>{{$refuel->cost}}</td>
                                <td>
                                    <a class="btn btn-primary p-1" href="/refuels/{{$refuel->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M320 0c-17.7 0-32 14.3-32 32s14.3 32 32 32h82.7L201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3V192c0 17.7 14.3 32 32 32s32-14.3 32-32V32c0-17.7-14.3-32-32-32H320zM80 32C35.8 32 0 67.8 0 112V432c0 44.2 35.8 80 80 80H400c44.2 0 80-35.8 80-80V320c0-17.7-14.3-32-32-32s-32 14.3-32 32V432c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16H192c17.7 0 32-14.3 32-32s-14.3-32-32-32H80z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
    (async function() {

        let badVibes = {{ \Illuminate\Support\Js::from($graph) }};
        const data = badVibes.map(row => {
            let ding = {
                month: row.month,
                users: [],
            };
            for(let i=0;i<row.users.length;i++){
                let user = row.users[i];
                ding.users.push({
                    name: user.name,
                    kilometers: user.kilometers,
                });
            }
            return ding;
        });

        console.log(data);

        let datasets = [];

        for (let i = 0; i < data[0].users.length; i++) {
            let user = data[0].users[i];
            datasets.push({
                label: user.name,
                data: data.map(row => row.users[i].kilometers),
                tension: 0.3
            });
        }

        new Chart(
            document.getElementById('Chart'),
            {
                type: 'line',
                data: {
                    labels: data.map(row => row.month),
                    datasets: datasets,

                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );
    })();

    function total_kilometers(drives){
        let total_kilometers = 0;
        for(let i=0;i<drives.length;i++){
            let drive = drives[i];
            total_kilometers += drive.end_odometer - drive.begin_odometer;
        }
        return total_kilometers;
    }
</script>