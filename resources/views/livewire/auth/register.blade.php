<x-layouts.auth>
    <a href="{{ route('register') }}"><img src="{{asset('templates/mazer/dist/assets/images/logo/logo.png')}}" alt="Logo" srcset=""></a>

    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Inscription')" :description="__('Veuillez renseigner les informations ci-dessous')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
                <!-- Lastname -->
            <flux:input
                name="name"
                :label="__('Nom complet (Nom & Prénom)')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Entrez le nom et le prénom')" />

                
            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Adresse mail')"
                type="email"
                required
                autocomplete="email"
                :placeholder="__('Entrez l\'adresse mail')" />


                <!-- Telephone -->
            <flux:input
                name="telephone"
                :label="__('Numéro de téléphone')"
                type="number"
                required
                autocomplete="telephone"
                :placeholder="__('Entrez le numéro de téléphone')" />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Mot de passe')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Entrez un mot de passe')"
                viewable />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirmez ce mot de passe')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirmez le mot de passe')"
                viewable />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('VALIDER') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Vous avez déjà un compte?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Connectez-vous') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>