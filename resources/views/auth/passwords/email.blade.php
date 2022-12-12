<x-layouts.base>
    <div class="m-auto max-w-sm sm:w-full md:max-w-md">
        <x-login-logo :account="app('currentTenant')"></x-login-logo>

        <form id="resetLoginForm" class="m-4 rounded bg-white px-8 pt-6 pb-8 shadow-lg" role="form" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-6">
                <label class="mb-1 block text-sm font-bold text-gray-700" for="email">Email Address</label>
                <input class="form-input block w-full text-gray-700" id="email" type="email" placeholder="Email Address" name="email" value="{{ old('email') }}">
                @error('email')
                    <p class="mt-2 flex items-center space-x-1 text-sm text-red-600 opacity-75">
                        <x-icons.exclamation-circle />
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div class="sm:flex-no-wrap flex flex-wrap items-center justify-between">
                <button class="focus:shadow-outline rounded bg-blue-500 py-2 px-4 font-bold text-white hover:bg-blue-700 focus:outline-none" type="submit">Send Password Reset Link</button>

                <a href="{{ route('login') }}" class="mt-4 inline-block align-baseline text-sm font-bold text-blue-500 hover:text-blue-800 sm:mt-0">Return to login</a>
            </div>
        </form>

        <p class="mb-20 text-center text-sm text-gray-500">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</x-layouts.base>
