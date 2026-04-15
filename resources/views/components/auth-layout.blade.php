<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'BookBerry' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        :root {
            --bb-purple:   #5A2A6E;
            --bb-lavender: #CBA0D9;
            --bb-pink:     #E94E77;
            --bb-cream:    #FFF8F2;
            --bb-charcoal: #2E2E2E;
        }
        body {
            background-color: var(--bb-cream);
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>
<body class="min-h-screen flex">

    @php
        $heroProducts = $heroProducts ?? \App\Models\Product::where('is_active', true)->latest()->take(4)->get();
        $rotations = ['-4deg', '2deg', '-2deg', '3deg'];
    @endphp

    {{-- Left decorative panel (desktop only) --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden"
        style="background: linear-gradient(145deg, #3D1A4E 0%, #5A2A6E 40%, #7B3F8E 70%, #9B5FAD 100%);">

        {{-- Decorative circles --}}
        <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full opacity-10"
            style="background: #CBA0D9;"></div>
        <div class="absolute -bottom-32 -right-16 w-96 h-96 rounded-full opacity-10"
            style="background: #E94E77;"></div>
        <div class="absolute top-1/3 right-0 w-48 h-48 rounded-full opacity-5"
            style="background: white;"></div>

        {{-- Content --}}
        <div class="relative z-10 flex flex-col justify-between p-12 w-full">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-2xl font-bold text-white">
                <img src="{{ asset('images/bookberry-logo.svg') }}" alt="BookBerry" class="h-9 w-9" />
                <span>
                    Book<span style="color: #CBA0D9;">Berry</span>
                </span>
            </a>

            {{-- Center content --}}
            <div>
                <div class="flex gap-3 mb-8">
                    @foreach([
                        ['📚', 'Wattpad', '#E94E77'],
                        ['🎌', 'Manga', '#3B82F6'],
                        ['💜', 'Romance', '#9B5FAD'],
                        ['⚔️', 'Action', '#059669'],
                    ] as [$icon, $label, $color])
                        <div class="px-3 py-1.5 rounded-full text-xs font-semibold text-white"
                            style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);">
                            {{ $icon }} {{ $label }}
                        </div>
                    @endforeach
                </div>

                <h2 class="text-4xl font-bold text-white leading-tight mb-4">
                    Your favorite reads,<br>all in one place.
                </h2>
                <p class="text-purple-200 text-lg leading-relaxed mb-8">
                    Discover Filipino Wattpad stories and Japanese manga.
                    Join thousands of readers on BookBerry.
                </p>

                {{-- Floating book cards (uses uploaded product covers) --}}
                <div class="flex gap-3">
                    @if(($heroProducts ?? collect())->count())
                        @foreach($heroProducts as $idx => $hero)
                            <div style="transform: rotate({{ $rotations[$idx] ?? '0deg' }});"
                                class="w-16 h-24 rounded-xl shadow-2xl overflow-hidden bg-white/10 border border-white/20 hover:-translate-y-1 transition-transform duration-200">
                                <img
                                    src="{{ $hero->image_url }}"
                                    alt="{{ $hero->title }}"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                />
                            </div>
                        @endforeach
                    @else
                        @foreach([
                            ['Ang Probinsyano', '#E94E77', '-4deg'],
                            ['One Piece', '#3B82F6', '2deg'],
                            ["Kuya's BFF", '#059669', '-2deg'],
                            ['Demon Slayer', '#7C3AED', '3deg'],
                        ] as [$bookTitle, $color, $rotate])
                            <div style="background: {{ $color }}; transform: rotate({{ $rotate }});"
                                class="w-16 h-24 rounded-xl shadow-2xl flex items-center justify-center
                                    text-white text-xs font-semibold text-center p-2 leading-tight
                                    hover:-translate-y-1 transition-transform duration-200">
                                {{ $bookTitle }}
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Bottom quote --}}
            <div class="border-t border-white/10 pt-6">
                <p class="text-purple-200 text-sm italic">
                    "A reader lives a thousand lives before he dies."
                </p>
                <p class="text-purple-300 text-xs mt-1">— George R.R. Martin</p>
            </div>
        </div>
    </div>

    {{-- Right form panel --}}
    <div class="flex-1 flex items-center justify-center p-6 lg:p-12 min-h-screen">
        <div class="w-full max-w-md">

            {{-- Mobile logo --}}
            <div class="lg:hidden text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-2xl font-bold" style="color: #5A2A6E;">
                    <img src="{{ asset('images/bookberry-logo.svg') }}" alt="BookBerry" class="h-9 w-9" />
                    <span>
                        Book<span style="color: #E94E77;">Berry</span>
                    </span>
                </a>
            </div>

            @if(($heroProducts ?? collect())->count())
                <div class="lg:hidden flex justify-center gap-2 mb-6">
                    @foreach($heroProducts as $idx => $hero)
                        <div style="transform: rotate({{ $rotations[$idx] ?? '0deg' }});"
                            class="w-12 h-16 rounded-lg overflow-hidden shadow-lg border border-purple-100/60 bg-white">
                            <img
                                src="{{ $hero->image_url }}"
                                alt="{{ $hero->title }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            />
                        </div>
                    @endforeach
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>
