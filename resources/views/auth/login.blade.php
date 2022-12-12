<div class="m-auto max-w-sm sm:w-full md:max-w-md">
    @if(app('currentTenant')->oauthProviders->isNotEmpty())
        @foreach(app('currentTenant')->oauthProviders as $provider)
            @switch($provider->name)
                @case('google')
                    <a href="/redirect/google"
                       class="m-4 block flex w-full content-center rounded bg-white shadow-lg hover:shadow-2xl">
                        <span class="block w-5/6 pt-4 text-center text-lg font-semibold text-gray-800">Sign in with Google</span>
                    </a>
                    @break
            @endswitch
        @endforeach
    @endif
</div>
