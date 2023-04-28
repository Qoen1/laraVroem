<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 d-flex justify-content-center">
                    <h1 class="display-1">Add Drive</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="/drives" method="post">
                        @csrf
                        <button type="button" class="btn btn-outline-primary" onclick="toggle()" id="toggleBtn">+</button>
                        <div class="row mb-3" style="display: none" id="toggled">
                            <label for="begin" class="col-sm-2 col-form-label">Begin odometer</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="begin" value="0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end" class="col-sm-2 col-form-label">End odometer</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="end">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label fortimestamp="car" class="col-sm-2 col-form-label">Car</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="car" value="{{now()}}">
                                    @foreach($cars as $car)
                                        <option value="{{$car->id}}">{{$car->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end"><button type="submit" id="ree" class="btn btn-primary">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function toggle() {
        var x = document.getElementById("toggled");
        var y = document.getElementById("toggleBtn");

        if (x.style.display === "none") {
            x.style.display = "flex";
            x.querySelector("input").value = "0";
            y.innerText = "-";
        } else {
            x.style.display = "none";
            y.innerText = "+";
        }
    }
</script>