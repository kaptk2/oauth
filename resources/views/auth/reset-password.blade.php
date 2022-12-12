<x-layouts.base>
    <div class="container">
        <div class="m-auto max-w-sm sm:w-full md:max-w-md">
            <x-login-logo :account="app('currentTenant')"></x-login-logo>

            <form id="resetLoginForm" class="m-4 rounded bg-white px-8 pt-6 pb-8 shadow-lg" role="form" method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <h1 class="mb-6 -ml-8 border-l-4 border-blue-500 pl-6 text-2xl font-extrabold text-gray-700">Reset Password</h1>

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-bold text-gray-700" for="email">Email Address</label>

                    <input class="form-input block w-full text-gray-700" id="email" type="email" placeholder="Email Address" name="email" value="{{ old('email') }}">

                    @error('email')<p class="mt-2 text-sm text-red-600 opacity-75">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-bold text-gray-700" for="password">Password</label>

                    <input class="form-input block w-full text-gray-700" id="password" type="password" placeholder="Password" name="password">

                    @error('password')<p class="mt-2 text-sm text-red-600 opacity-75">{{ $message }}</p>@enderror
                </div>

                <div class="mb-8">
                    <label class="mb-1 block text-sm font-bold text-gray-700" for="password-confirm">Confirm Password</label>

                    <input class="form-input block w-full text-gray-700" id="password-confirm" type="password" placeholder="Confirm Password" name="password_confirmation">

                    @error('password_confirmation')<p class="mt-2 text-sm text-red-600 opacity-75">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between">
                    <button class="focus:shadow-outline rounded bg-blue-500 py-2 px-4 font-bold text-white hover:bg-blue-700 focus:outline-none" type="submit">Reset Password</button>

                    <a href="{{ route('login') }}" class="inline-block align-baseline text-sm font-bold text-blue-500 hover:text-blue-800">Return to login</a>
                </div>
            </form>

            <p class="mb-20 text-center text-sm text-gray-500">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</x-layouts.base>
