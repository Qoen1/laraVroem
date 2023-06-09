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
                            <th style="width: 20vw"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cars as $car) @endforeach
                        <tr>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->drives()->orderBy('created_at', 'desc')->first()->user->name }}</td>
                            <td>
                                <a class="btn btn-primary" href="/drives/create/{{ $car->id }}">Add Drive</a>
                                |
                                <a class="btn btn-secondary" href="/refuels/create/{{ $car->id }}">Add Refuel</a>
                                |
                                <a class="btn btn-secondary" href="cars/{{$car->id}}">details</a>
                            </td>
                        </tr>
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