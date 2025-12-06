<x-layouts.auth>
    <a href="{{ route('login') }}"><img src="{{asset('templates/mazer/dist/assets/images/logo/logo.png')}}" alt="Logo" srcset=""></a>

    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Connexion')" :description="__('Veuillez saisir vos informations de connexion')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.custom.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Adresse mail')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@exemple.com" />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Mot de passe')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Mot de passe')"
                    viewable />

                @if (Route::has('password.request'))
                <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                    {{ __('Mot de passe oublié ?') }}
                </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Se souvenir de moi')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('VALIDER') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Vous n\'avez pas de compte ?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Inscrivez-vous') }}</flux:link>
        </div>
        @endif
    </div>
</x-layouts.auth>