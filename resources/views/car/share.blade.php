<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="post" action="/cars/share">
                    @csrf
                    <div>
                        <label for="email">email</label>
                        <input name="invitee" type="email" value="koenverstappen2003@gmail.com">
                    </div>
                    <input name="car_id" type="hidden" value="{{ $car }}">
                    <button type="submit">Share</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>