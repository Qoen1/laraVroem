<section class="space-y-6">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Generate API token') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __('you can request an API token by clicking the button below.') }}
    </p>

    <form method="post" action="{{ route('profile.generateToken') }}">
        @csrf
        <x-primary-button>
            {{ __('Request API token') }}
        </x-primary-button>
    </form>

</section>
