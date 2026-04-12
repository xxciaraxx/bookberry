<div>

    <div>
        <h1 class="text-2xl font-bold mb-1" style="color: #5A2A6E;">Welcome back 👋</h1>
        <p class="text-gray-500 text-sm mb-8">Sign in to your BookBerry account to continue.</p>

        {{-- Session error --}}
        @if (session('status'))
            <div class="mb-4 p-3 rounded-xl text-sm bg-green-50 text-green-700 border border-green-100">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="login" class="space-y-4">

            {{-- Email --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                    Email Address
                </label>
                <input
                    wire:model.live="email"
                    type="email"
                    placeholder="you@example.com"
                    autocomplete="email"
                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm
                        outline-none transition focus:border-purple-400"
                    style="background: white;"
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
                <div class="flex justify-between items-center mb-1.5">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Password
                    </label>
                    <a href="{{ route('password.request') }}"
                        class="text-xs font-medium hover:underline" style="color: #E94E77;">
                        Forgot password?
                    </a>
                </div>
                <div class="relative">
                    <input
                        wire:model.live="password"
                        type="{{ $showPassword ? 'text' : 'password' }}"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm pr-12
                            outline-none transition focus:border-purple-400"
                        style="background: white;"
                    />
                    <button
                        type="button"
                        wire:click="$toggle('showPassword')"
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
                @error('password')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Remember me --}}
            <label class="flex items-center gap-2 cursor-pointer">
                <input wire:model="remember" type="checkbox"
                    class="w-4 h-4 rounded accent-purple-700 cursor-pointer" />
                <span class="text-sm text-gray-600">Remember me for 30 days</span>
            </label>

            {{-- Submit --}}
            <button
                type="submit"
                wire:loading.attr="disabled"
                style="background: #5A2A6E;"
                class="w-full text-white font-semibold py-3.5 rounded-xl hover:opacity-90
                    transition disabled:opacity-60 flex items-center justify-center gap-2 text-sm">
                <span wire:loading.remove>Sign In to BookBerry</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    Signing in...
                </span>
            </button>

        </form>

        {{-- Divider --}}
        <div class="flex items-center gap-3 my-6">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400 font-medium">or</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        {{-- Register link --}}
        <p class="text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold hover:underline ml-1" style="color: #E94E77;">
                Create one free →
            </a>
        </p>
    </div>

</div>
