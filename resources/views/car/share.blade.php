<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="/cars/share">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">email</label>
                            <div class="col-sm-10">
                                <input name="invitee" class="form-control" type="email"
                                       value="koenverstappen2003@gmail.com">
                            </div>
                        </div>
                        <input name="car_id" type="hidden" value="{{ $car }}">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn border-primary">Share</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>