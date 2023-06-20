<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 d-flex justify-content-center">
                    <h1 class="display-1">Add Car</h1>
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
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="/cars" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label for="begin" class="col-sm-2 col-form-label">name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="license_plate" class="col-sm-2 col-form-label">license plate</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="license_plate">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end"><button type="submit" id="ree" class="btn btn-primary">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>