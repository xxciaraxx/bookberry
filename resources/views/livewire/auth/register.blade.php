<div>

    <div>
        <h1 class="text-2xl font-bold mb-1" style="color: #5A2A6E;">Create your account ✨</h1>
        <p class="text-gray-500 text-sm mb-7">
            Join BookBerry and start reading today. Free forever.
        </p>

        <form wire:submit="register" class="space-y-4">

            {{-- Full Name --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                    Full Name
                </label>
                <input
                    wire:model.blur="name"
                    type="text"
                    placeholder="Juan dela Cruz"
                    autocomplete="name"
                    class="w-full border-2 rounded-xl px-4 py-3 text-sm outline-none transition
                        {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-gray-200 focus:border-purple-400' }}"
                />
                @error('name')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                    Email Address
                </label>
                <input
                    wire:model.blur="email"
                    type="email"
                    placeholder="you@example.com"
                    autocomplete="email"
                    class="w-full border-2 rounded-xl px-4 py-3 text-sm outline-none transition
                        {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200 focus:border-purple-400' }}"
                />
                @error('email')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                    Password
                </label>
                <div class="relative">
                    <input
                        wire:model.live="password"
                        type="{{ $showPassword ? 'text' : 'password' }}"
                        placeholder="Create a strong password"
                        autocomplete="new-password"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm pr-12 outline-none transition
                            {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200 focus:border-purple-400' }}"
                    />
                    <button type="button" wire:click="$toggle('showPassword')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                        @if($showPassword)
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        @endif
                    </button>
                </div>

                {{-- Password strength bar --}}
                @if(strlen($password) > 0)
                    <div class="mt-2">
                        <div class="flex gap-1 mb-1.5">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                    style="background: {{ $i <= $this->passwordStrength ? $this->strengthColor : '#E5E7EB' }};"></div>
                            @endfor
                        </div>
                        <p class="text-xs font-medium" style="color: {{ $this->strengthColor }};">
                            {{ $this->strengthLabel }}
                        </p>
                    </div>
                @endif

                {{-- Password rules checklist --}}
                <div class="mt-3 grid grid-cols-2 gap-1.5">
                    @foreach([
                        [$hasMinLength, 'At least 8 characters'],
                        [$hasUppercase, 'Uppercase letter (A-Z)'],
                        [$hasLowercase, 'Lowercase letter (a-z)'],
                        [$hasNumber,    'Number (0-9)'],
                        [$hasSymbol,    'Special character (!@#$...)'],
                    ] as [$met, $label])
                        <div class="flex items-center gap-1.5 text-xs {{ $met ? 'text-green-600' : 'text-gray-400' }}">
                            @if($met)
                                <svg class="w-3.5 h-3.5 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                            {{ $label }}
                        </div>
                    @endforeach
                </div>

                @error('password')
                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                    Confirm Password
                </label>
                <div class="relative">
                    <input
                        wire:model.live="password_confirmation"
                        type="{{ $showConfirm ? 'text' : 'password' }}"
                        placeholder="Re-enter your password"
                        autocomplete="new-password"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm pr-12 outline-none transition
                            @if(strlen($password_confirmation) > 0)
                                {{ $password === $password_confirmation
                                    ? 'border-green-300 bg-green-50'
                                    : 'border-red-300 bg-red-50' }}
                            @else
                                border-gray-200 focus:border-purple-400
                            @endif"
                    />
                    <button type="button" wire:click="$toggle('showConfirm')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                        @if($showConfirm)
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        @endif
                    </button>
                </div>
                @if(strlen($password_confirmation) > 0 && $password !== $password_confirmation)
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Passwords do not match.
                    </p>
                @elseif(strlen($password_confirmation) > 0 && $password === $password_confirmation)
                    <p class="text-green-600 text-xs mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Passwords match!
                    </p>
                @endif
            </div>

            {{-- Terms --}}
            <label class="flex items-start gap-2.5 cursor-pointer">
                <input wire:model.defer="agreedToTerms" type="checkbox"
                    class="w-4 h-4 mt-0.5 rounded accent-purple-700 cursor-pointer shrink-0" />
                <span class="text-sm text-gray-600 leading-relaxed">
                    I agree to the
                    <a href="#" class="font-semibold hover:underline" style="color: #5A2A6E;">Terms of Service</a>
                    and
                    <a href="#" class="font-semibold hover:underline" style="color: #5A2A6E;">Privacy Policy</a>
                </span>
            </label>
            @error('agreedToTerms')
                <p class="text-red-500 text-xs -mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror

            {{-- Submit --}}
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="register"
                style="background: #E94E77;"
                class="w-full text-white font-semibold py-3.5 rounded-xl hover:opacity-90
                    transition disabled:opacity-60 flex items-center justify-center gap-2 text-sm">
                <span wire:loading wire:target="register" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                </span>
                <span wire:loading.remove wire:target="register">Create My Account</span>
                <span wire:loading wire:target="register">Creating account...</span>
            </button>
        </form>

        {{-- Divider --}}
        <div class="flex items-center gap-3 my-5">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400 font-medium">already have an account?</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <a href="{{ route('login') }}"
            class="w-full flex items-center justify-center font-semibold py-3 rounded-xl border-2
                border-purple-200 text-sm hover:bg-purple-50 transition"
            style="color: #5A2A6E;">
            Sign In Instead
        </a>
    </div>

</div>
