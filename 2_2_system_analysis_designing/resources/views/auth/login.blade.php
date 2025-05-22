<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="userid" :value="__('아이디')" />
            <x-text-input id="userid" class="block mt-1 w-full" type="text" name="userid" :value="old('userid')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('userid')" class="mt-2" />
            <x-input-error :messages="$errors->get('err')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('비밀번호')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('로그인') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
