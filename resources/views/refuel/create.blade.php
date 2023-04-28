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
                    <form action="/refuels" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label for="cost" class="col-sm-2 col-form-label">Cost</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="cost" value="0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="liters" class="col-sm-2 col-form-label">Liters</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="liters">
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
