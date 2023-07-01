<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="table-container">
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
                    <canvas id="Chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="table-container">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Car</th>
                            <th>Last driver</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cars as $car)
                        <tr>
                            <td>{{ $car->name }}</td>
                            @if($car->drives->count() > 0)
                                <td>{{ $car->drives()->orderBy('created_at', 'desc')->first()->user->name }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td class="d-flex align-items-center flex-row">
                                <a class="btn btn-primary" href="/drives/create/{{ $car->id }}">Add Drive</a>
                                <div class="vr m-2"></div>
                                <a class="btn btn-secondary" href="/refuels/create/{{ $car->id }}">Add Refuel</a>
                                <div class="vr m-2"></div>
                                <a class="btn btn-secondary" href="cars/{{$car->id}}">details</a>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
    (async function() {

        let badVibes = {{ \Illuminate\Support\Js::from($drives) }};
        console.log(badVibes);
        const data = badVibes.map(row => ({
            month: row.month,
            kilometers: total_kilometers(row.value),
        }));

        new Chart(
            document.getElementById('Chart'),
            {
                type: 'line',
                data: {
                    labels: data.map(row => row.month),
                    datasets: [
                        {
                            label: 'Kilometers driven per month',
                            data: data.map(row => row.kilometers),
                            tension: 0.3
                        }
                    ]
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