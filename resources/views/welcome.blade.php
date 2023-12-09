<x-app-layout>
    {{--welcome page--}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 d-flex justify-content-center">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
		    <h1 class="display-1">Welcome to the car management system</h1>
		    <p> the current time is: {{Carbon\Carbon::now();}} </p>
                </div>
            </div>
        </div>
</x-app-layout>
