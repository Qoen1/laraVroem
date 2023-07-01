<link rel="stylesheet" href="/CSS/app.css">

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
                        <div class="flex-fill">
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
                            <th></th>
                        </thead>
                        @foreach($drives as $drive)
                            <tr class="text-md">
                                <td class="align-middle">{{$drive->created_at}}</td>
                                <td class="align-middle">{{$drive->distance()}}</td>
                                <td class="align-middle">{{$drive->begin_odometer}}</td>
                                <td class="align-middle">{{$drive->end_odometer}}</td>
                                <td class="align-middle">{{$drive->user->name}}</td>
                                <td class="align-middle">
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
                                <td><a class="btn btn-primary" href="/refuels/{{$refuel->id}}">details</a></td>
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