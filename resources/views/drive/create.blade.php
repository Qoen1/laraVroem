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
                        <div class="row mb-3">
                            <label for="begin" class="col-sm-2 col-form-label">Begin odometer</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="begin">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end" class="col-sm-2 col-form-label">End odometer</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="end">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end" class="col-sm-2 col-form-label">End odometer</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="timestamp" value="{{now()}}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end"><button type="submit" id="ree" class="btn btn-primary">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
