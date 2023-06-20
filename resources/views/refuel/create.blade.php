<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 d-flex justify-content-center">
                    <h1 class="display-1">Add Refuel</h1>
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
                    <form action="{{ route('refuels.store') }}" method="post">
                        @csrf
                        <div class="row mb-3" id="toggled">
                            <label for="begin" class="col-sm-2 col-form-label">Begin odometer</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="begin" value="{{ $previous_endOdometer }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end" class="col-sm-2 col-form-label">End odometer</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="end">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="cost" class="col-sm-2 col-form-label">Cost</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="cost">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="liters" class="col-sm-2 col-form-label">Liters</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="liters">
                            </div>
                        </div>
                        <input type="hidden" name="car" value="{{ $car->id }}">
                        <div class="d-flex justify-content-end"><button type="submit" id="ree" class="btn btn-primary">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
