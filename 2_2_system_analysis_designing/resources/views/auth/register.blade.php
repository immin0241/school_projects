<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="userid" :value="__('아이디')" />
            <x-text-input id="userid" class="block mt-1 w-full" type="text" name="userid" :value="old('userid')" required autofocus autocomplete="userid" />
            <x-input-error :messages="$errors->get('userid')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('사용자 이름')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('비밀번호')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('비밀번호 확인')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label :value="__('회원 종류')" />
            <div class="grid grid-cols-2 gap-4 mt-2">
                <label>
                    <input type="radio" name="type" value="01" class="hidden peer" checked>
                    <span class="h-10 border border-primary flex items-center justify-center rounded-lg peer-checked:bg-primary peer-checked:text-white transition-all">학생</span>
                </label>
                <label>
                    <input type="radio" name="type" value="02" class="hidden peer">
                    <span class="h-10 border border-primary flex items-center justify-center rounded-lg peer-checked:bg-primary peer-checked:text-white transition-all">교수</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('이미 가입하셨나요?') }}
            </a>

            <x-primary-button class="ms-4 bg-primary">
                {{ __('회원 가입') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
