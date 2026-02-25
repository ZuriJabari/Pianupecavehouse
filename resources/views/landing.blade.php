<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pian Upe Cave House — Your Private Cave in the Wild</title>
    <meta name="description" content="Your own private cave in the wild — exclusively for you. A luxury cave house in Pian Upe Game Reserve, Eastern Uganda.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|cormorant-garamond:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" referrerpolicy="no-referrer" />

    <link rel="preload" href="{{ asset('hero/hero-poster.jpg') }}" as="image">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-[#f7f0e6] text-[#241b16] antialiased font-sans text-body md:text-body-lg leading-relaxed">
    <div class="relative min-h-screen">
        <!-- Sticky Nav -->
        <header id="site-header" class="site-header site-header--at-top fixed inset-x-0 top-0 z-40 border-b border-black/5 bg-[#f7f0e6]/90 backdrop-blur-sm">
            <div class="mx-auto max-w-6xl px-4 py-4 lg:px-6">
                <!-- Mobile: logo left, menu button right -->
                <div class="flex items-center justify-between lg:hidden">
                    <a href="#hero" class="header-logo flex flex-col leading-tight">
                        <span class="font-display font-semibold text-heading-md lg:text-heading-lg tracking-[0.5em] uppercase text-[#241b16]">PIAN UPE</span>
                        <span class="mt-1 font-sans text-label-xs tracking-[0.3em] uppercase text-[#241b16]/80">CAVE HOUSE</span>
                    </a>
                    <button
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#241b16]/25 bg-white/80 text-[#241b16] shadow-sm"
                        aria-label="Toggle navigation menu"
                        onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    >
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>

                <!-- Desktop: logo centered with nav items on both sides -->
                <div class="hidden items-center justify-between lg:flex">
                    <nav class="flex items-center gap-8 font-sans text-body-sm font-medium tracking-[0.18em] uppercase text-[#3b2b21]/85">
                        <a href="#about" class="lux-nav-link hover:text-black transition">The Cave</a>
                        <a href="#experiences" class="lux-nav-link hover:text-black transition">Experiences</a>
                        <a href="#rates" class="lux-nav-link hover:text-black transition">Rates</a>
                    </nav>

                    <a href="#hero" class="header-logo flex flex-col items-center text-center leading-tight">
                        <span class="font-display font-semibold text-heading-md lg:text-heading-lg tracking-[0.5em] uppercase text-[#241b16]">PIAN UPE</span>
                        <span class="mt-1 font-sans text-label-xs tracking-[0.3em] uppercase text-[#241b16]/80">CAVE HOUSE</span>
                    </a>

                    <nav class="flex items-center gap-8 font-sans text-body-sm font-medium tracking-[0.18em] uppercase text-[#3b2b21]/85">
                        <a href="#gallery" class="lux-nav-link hover:text-black transition">Gallery</a>
                        <a href="#contact" class="lux-nav-link hover:text-black transition">Contact</a>
                        <a href="{{ route('shop.index') }}" class="lux-nav-link hover:text-black transition">Shop</a>
                    </nav>
                </div>
            </div>
            <div id="mobile-menu" class="hidden border-t border-black/15 bg-black/95 backdrop-blur-md lg:hidden">
                <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-5 text-[#f5f2ea]/90">
                    <div class="flex items-center justify-between text-[11px] font-semibold uppercase tracking-[0.22em] text-[#f5f2ea]/60">
                        <span>Menu</span>
                        <span class="text-[#f5f2ea]/40">Pian Upe Cave House</span>
                    </div>
                    <nav class="space-y-2 font-sans text-sm font-medium uppercase tracking-[0.22em]">
                        <a href="#about" class="lux-nav-link block rounded-full bg-white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg-white/10 hover:text-white transition">The Cave</a>
                        <a href="#experiences" class="lux-nav-link block rounded-full bg-white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg-white/10 hover:text-white transition">Experiences</a>
                        <a href="#rates" class="lux-nav-link block rounded-full bg-white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg-white/10 hover:text-white transition">Rates</a>
                        <a href="#gallery" class="lux-nav-link block rounded-full bg:white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg:white/10 hover:text:white transition">Gallery</a>
                        <a href="{{ route('shop.index') }}" class="lux-nav-link block rounded-full bg:white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg:white/10 hover:text:white transition">Shop</a>
                        <a href="#contact" class="lux-nav-link block rounded-full bg:white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg:white/10 hover:text:white transition">Contact</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Floating CTA on mobile -->
        <a
            href="{{ route('booking') }}"
            class="lux-cta fixed bottom-5 left-1/2 z-40 flex -translate-x-1/2 items-center gap-2 rounded-full bg-[#241b16] px-6 py-3 font-sans text-label-xs font-semibold tracking-[0.22em] text-[#f7f0e6] shadow-lg shadow-black/40 lg:hidden"
        >
            Reserve
        </a>

        <!-- Floating WhatsApp chat -->
        <a
            href="https://wa.me/256777643084"
            target="_blank"
            aria-label="Chat on WhatsApp"
            class="fixed bottom-5 right-5 z-40 flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg shadow-black/40 hover:bg-[#22c55e] transition"
        >
            <i class="fa-brands fa-whatsapp text-2xl"></i>
        </a>

        <!-- Hero -->
        <section id="hero" class="relative flex min-h-screen items-center overflow-hidden bg-black section-fade-in">
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black via-black/40 to-[#050507]"></div>
            <div class="pointer-events-none absolute inset-y-0 left-0 w-full md:w-2/3 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute inset-0">
                <picture>
                    <source srcset="{{ asset('camera/gallery-v3/drone-0019.webp') }}" type="image/webp">
                    <img
                        src="{{ asset('camera/gallery-v3/drone-0019.jpg') }}"
                        alt="Pian Upe landscape"
                        class="h-full w-full object-cover"
                        loading="eager"
                        fetchpriority="high"
                        decoding="async"
                    />
                </picture>
            </div>
            <div class="relative z-10 mx-auto max-w-6xl px-4 py-32 lg:px-6">
                <div class="grid gap-12 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] lg:items-end">
                    <div class="max-w-2xl">
                        <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.28em] text-[#f5f2ea]/70">
                            PIAN UPE GAME RESERVE · KARAMOJA · NEAR SIPI FALLS
                        </p>
                        <p
                            role="heading"
                            aria-level="1"
                            class="mt-4 font-display text-4xl md:text-5xl lg:text-6xl leading-tight text-white"
                        >
                            Your private cave in the wild.
                        </p>
                        <p class="mt-5 max-w-xl font-sans text-xl md:text-2xl leading-relaxed text-[#f5f2ea]/80">
                            A fully private, full-board cave house carved into the rocks of Pian Upe — where silence, starlight, and savannah winds become part of your stay.
                        </p>
                        <p class="mt-3 font-sans text-lg text-[#f5f2ea]/70">
                            Hosted for one group at a time. No shared spaces, no strangers — just you and the savannah horizon.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center gap-4">
                            <a
                                href="#rates"
                                class="lux-cta rounded-full bg-[#f5f2ea] px-7 py-3 font-sans text-label-xs font-semibold tracking-[0.22em] text-[#181716] shadow-lg shadow-black/40 hover:bg-white"
                            >
                                Check Availability
                            </a>
                            <a href="#about" class="lux-nav-link font-sans text-body-sm font-medium text-[#f5f2ea]/80 hover:text-white">
                                Explore the Cave
                            </a>
                        </div>
                    </div>
                    <aside class="mt-10 w-full max-w-sm rounded-3xl border border-white/15 bg-black/55 p-7 font-sans text-body-sm text-[#f5f2ea]/85 backdrop-blur-md lg:mt-0 lg:ml-auto">
                        <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.24em] text-[#f5f2ea]/75">At a glance</h2>
                        <p class="mt-2 font-sans text-body-sm text-[#f5f2ea]/70">A quiet snapshot of what every stay includes.</p>
                        <dl class="mt-5 space-y-3">
                            <div class="flex items-start justify-between gap-4 pb-2">
                                <dt class="font-sans text-body-sm text-[#f5f2ea]/65">Stay</dt>
                                <dd class="text-right font-sans text-body-sm text-[#f5f2ea]/90">Private cave house · 1 group only</dd>
                            </div>
                            <div class="flex items-start justify-between gap-4 border-t border-white/10 pt-2">
                                <dt class="font-sans text-body-sm text-[#f5f2ea]/65">Rooms</dt>
                                <dd class="text-right font-sans text-body-sm text-[#f5f2ea]/90">3 cave rooms · full board</dd>
                            </div>
                            <div class="flex items-start justify-between gap-4 border-t border-white/10 pt-2">
                                <dt class="font-sans text-body-sm text-[#f5f2ea]/65">Rates</dt>
                                <dd class="text-right font-sans text-body-sm text-[#f5f2ea]/90">
                                    Full-board · $350 per night
                                </dd>
                            </div>
                            <div class="flex items-start justify-between gap-4 border-t border-white/10 pt-2">
                                <dt class="font-sans text-body-sm text-[#f5f2ea]/65">Access</dt>
                                <dd class="text-right font-sans text-body-sm text-[#f5f2ea]/90">4×4 required · private transfers available</dd>
                            </div>
                        </dl>
                    </aside>
                </div>
            </div>
        </section>

        <!-- Key Info Strip -->
        <section class="border-y border-[#e3d4c4] bg-gradient-to-r from-[#f6ebde] via-[#fdf7f0] to-[#f6ebde] section-fade-in mb-20">
            <div class="mx-auto max-w-6xl px-4 py-24 lg:px-6">
                <header class="max-w-3xl">
                    <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.28em] text-[#8d6b4a]/80">
                        Included in every stay
                    </p>
                    <p class="mt-3 font-display text-4xl md:text-5xl lg:text-6xl leading-tight text-[#241b16]">
                        A fully hosted, fully private stay in Pian Upe.
                    </p>
                    <p class="mt-4 font-sans text-body-lg leading-relaxed text-[#4b3b2f]/85">
                        Every booking includes a private cave house, full-board dining, and guided time in the reserve — quietly curated around your group, never rushed, never shared.
                    </p>
                </header>

                <dl class="mt-12 grid gap-6 font-sans text-body-sm text-[#4b3b2f]/85 lg:grid-cols-3">
                    <div class="flex flex-col justify-between rounded-3xl border border-[#e3d4c4] bg-[#fffaf3]/80 p-6 backdrop-blur-sm transition duration-300 ease-soft-out hover:-translate-y-1 hover:shadow-soft">
                        <div class="space-y-2">
                            <dt class="font-sans text-label-xs font-semibold uppercase tracking-[0.2em] text-[#8d6b4a]/85">Private stay</dt>
                            <dd class="font-display text-heading-sm text-[#241b16]">The cave house is yours alone.</dd>
                        </div>
                        <p class="mt-3 font-sans text-body-sm text-[#5b4636]">One group at a time, no shared spaces, no strangers — just your circle and the wild quiet outside.</p>
                    </div>

                    <div class="flex flex-col justify-between rounded-3xl border border-[#e3d4c4] bg-[#fffaf3]/80 p-6 backdrop-blur-sm transition duration-300 ease-soft-out hover:-translate-y-1 hover:shadow-soft">
                        <div class="space-y-2">
                            <dt class="font-sans text-label-xs font-semibold uppercase tracking-[0.2em] text-[#b65c2a]/85">Hosting & dining</dt>
                            <dd class="font-display text-heading-sm text-[#241b16]">Full-board, quietly attentive service.</dd>
                        </div>
                        <p class="mt-3 font-sans text-body-sm text-[#5b4636]">A small on-site team, private chef, and unhurried meals — from warm breakfasts to long, candlelit dinners.</p>
                    </div>

                    <div class="flex flex-col justify-between rounded-3xl border border-[#e3d4c4] bg-[#fffaf3]/80 p-6 backdrop-blur-sm transition duration-300 ease-soft-out hover:-translate-y-1 hover:shadow-soft">
                        <div class="space-y-2">
                            <dt class="font-sans text-label-xs font-semibold uppercase tracking-[0.2em] text-[#3a7b3c]/85">Wild Pian Upe</dt>
                            <dd class="font-display text-heading-sm text-[#241b16]">Guided drives, birdlife & access.</dd>
                        </div>
                        <p class="mt-3 font-sans text-body-sm text-[#405239]">Sunrise and sunset drives, birdwatching from the rocks, and support with 4×4 transfers and optional charter flights.</p>
                    </div>
                </dl>

                <p class="mt-8 font-sans text-body-sm text-[#5b4636]">
                    Free cancellation within 14 days before arrival, transparent pricing with no hidden service fees, and direct contact with the team before, during, and after your stay.
                </p>
            </div>
        </section>

        <!-- About & Exclusivity -->
        <section id="about" class="bg-[#f7f0e6] section-fade-in">
            <div class="mx-auto grid max-w-6xl gap-14 px-4 py-24 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] lg:px-6">
                <div>
                    <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#8d6b4a]/70">The Legend</h2>
                    <p class="mt-4 font-display text-4xl md:text-5xl lg:text-6xl tracking-tight text-[#241b16]">
                        Once a Karimojong warrior cave. Now a sanctuary of hush luxury.
                    </p>
                    <div class="mt-4 space-y-4 font-sans text-xl md:text-2xl leading-relaxed text-[#4b3b2f]/85">
                        <p>
                            Long before curated tasting menus and handwoven linens, this cavern carved into Pian Upe’s volcanic ridge was the covert rendezvous of Karimojong warriors. Cloaked in night, they gathered here to trade intelligence, map raids, and pledge alliances — strategies whispered against stone that still remembers every vow.
                        </p>
                        <div id="legend-extended" class="space-y-4 hidden">
                            <p>
                                When the drums of conflict fell silent, the same hideaway softened into a pastoral camp. Herders rested with their cattle, embers glowed against basalt walls, and stories travelled from elder to child while the savannah night kept vigil outside.
                            </p>
                            <p>
                                Today, that legacy greets you with candlelit stillness, bespoke turn-downs, and full-board indulgence. By day you roam the reserve’s wild reaches; by night you sleep beneath the very ceiling that once shielded strategists and storytellers. Your stay becomes another chapter in a living chronicle of resilience, reverence, and refined quiet.
                            </p>
                        </div>
                        <button
                            type="button"
                            data-legend-toggle
                            class="mt-4 inline-flex items-center gap-2 rounded-full border border-[#8d6b4a]/60 px-5 py-2 font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#8d6b4a]/90 hover:bg-[#8d6b4a] hover:text-[#f7f0e6] transition lux-cta"
                            aria-expanded="false"
                        >
                            <span data-legend-more>Read the full legend</span>
                            <span data-legend-less class="hidden">Show less</span>
                        </button>
                    </div>
                </div>
                <div class="space-y-6">
                    <figure class="relative overflow-hidden rounded-3xl border border-[#e3d4c4] bg-[#fdf7f0] shadow-soft">
                        <div class="relative aspect-[4/5] sm:aspect-[3/4] overflow-hidden">
                            <img
                                class="h-full w-full object-cover"
                                src="{{ asset('camera/backgrounds/footer-bg-optimized.jpg') }}"
                                alt="Traditional wooden headrest wrapped in cloth inside the cave."
                                loading="lazy"
                                decoding="async"
                            />
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>
                            <figcaption class="absolute inset-x-0 bottom-0 p-5 text-[#f5f2ea]">
                                <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.26em] text-[#f5f2ea]/80">
                                    From warrior watch to retreat ritual
                                </p>
                                <p class="mt-2 font-sans text-body-sm leading-relaxed text-[#f5f2ea]/90">
                                    A traditional headrest once used by Karimojong warriors in the cave — now a quiet object in the same space you sleep and dream in.
                                </p>
                            </figcaption>
                        </div>
                    </figure>
                </div>
            </div>
        </section>

        <!-- Parallax Interlude: The Landscape -->
        <section class="relative overflow-hidden section-fade-in parallax-section">
            <div
                class="absolute inset-0 bg-scroll md:bg-fixed bg-cover bg-center parallax-bg"
                data-parallax-speed="0.4"
                style="background-image: url('{{ asset('camera/backgrounds/bg-interlude-01-optimized.jpg') }}');">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/55 via-black/40 to-black/60"></div>
            <div class="relative mx-auto flex max-w-6xl items-center px-4 py-16 md:py-32 lg:px-6">
                <div class="max-w-xl text-[#f5f2ea]">
                    <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#f5f2ea]/70">
                        The Pian Upe horizon
                    </p>
                    <p class="mt-3 font-display text-4xl md:text-5xl lg:text-6xl leading-tight">
                        A horizon that refuses to end.
                    </p>
                    <p class="mt-3 font-sans text-lg md:text-xl leading-relaxed text-[#f5f2ea]/85">
                        Savannah plains, rock ridges, and a sky without edges — from first light to starlight, this is the backdrop to every stay.
                    </p>
                </div>
            </div>
        </section>

        <!-- Gallery -->
        <section id="gallery" class="bg-[#f7f0e6] section-fade-in is-visible">
            @php
                // Gallery set built from user-specified CAMERA PICTURES files,
                // exported as optimised JPEGs into public/camera/gallery-v3.
                $galleryImages = [
                    ['path' => 'camera/gallery-v3/img-0151.jpg',  'alt' => 'IMG_0151 · A moment overlooking the rocks and plains of Pian Upe.'],
                    ['path' => 'camera/gallery-v3/img-0226.jpg',  'alt' => 'IMG_0226 · Light and shadow across the rocky landscape near the cave.'],
                    ['path' => 'camera/gallery-v3/img-0238.jpg',  'alt' => 'IMG_0238 · Textures of stone, bush, and sky around Pian Upe Cave House.'],
                    ['path' => 'camera/gallery-v3/img-0245.jpg',  'alt' => 'IMG_0245 · Warm tones over the savannah and rocky outcrops.'],
                    ['path' => 'camera/gallery-v3/img-0275.jpg',  'alt' => 'IMG_0275 · Soft evening light falling over the Pian Upe horizon.'],
                    ['path' => 'camera/gallery-v3/img-0314.jpg',  'alt' => 'IMG_0314 · The wider landscape that cradles the cave house.'],
                    ['path' => 'camera/gallery-v3/img-0372.jpg',  'alt' => 'IMG_0372 · Closer detail from time spent on the rocks near the ridge.'],
                    ['path' => 'camera/gallery-v3/drone-0019.jpg','alt' => 'DJI_0019 · Drone view sweeping across the ridge and plains.'],
                    ['path' => 'camera/gallery-v3/drone-0038.jpg','alt' => 'DJI_0038 · Aerial shot catching the contours of Pian Upe at altitude.'],

                    ['path' => 'camera/gallery-v3/img-0367.jpg',  'alt' => 'IMG_0367 · View of the cave house and its surrounding rocks and plains.'],
                    ['path' => 'camera/gallery-v3/img-0337.jpg',  'alt' => 'IMG_0337 · Soft light over the savannah near the cave house.'],
                    ['path' => 'camera/gallery-v3/img-0294.jpg',  'alt' => 'IMG_0294 · The rocky landscape and vegetation around Pian Upe Cave House.'],
                    ['path' => 'camera/gallery-v3/img-0260.jpg',  'alt' => 'IMG_0260 · Evening tones across the Pian Upe horizon.'],
                    ['path' => 'camera/gallery-v3/img-0223.jpg',  'alt' => 'IMG_0223 · Details of rock, bush, and sky in the reserve.'],
                    ['path' => 'camera/gallery-v3/img-0221.jpg',  'alt' => 'IMG_0221 · Pian Upe bushland and distant ridges.'],
                    ['path' => 'camera/gallery-v3/img-0127.jpg',  'alt' => 'IMG_0127 · A quiet vantage point looking out over the plains.'],
                    ['path' => 'camera/gallery-v3/img-0117.jpg',  'alt' => 'IMG_0117 · Stone, grass, and sky textures around the cave.'],
                    ['path' => 'camera/gallery-v3/img-0044.jpg',  'alt' => 'IMG_0044 · Chairs and a resting spot with views of the savannah.'],
                    ['path' => 'camera/gallery-v3/img-0043.jpg',  'alt' => 'IMG_0043 · Warm afternoon light on the rocks near the house.'],
                    ['path' => 'camera/gallery-v3/img-0038.jpg',  'alt' => 'IMG_0038 · The wider valley and horizon at Pian Upe.'],
                    ['path' => 'camera/gallery-v3/img-0016.jpg',  'alt' => 'IMG_0016 · A path through the grasses leading towards the ridge.'],

                    ['path' => 'camera/gallery-v3/drone-0116.jpg','alt' => 'DJI_0116 · High-altitude drone view over the ridges and plains.'],
                    ['path' => 'camera/gallery-v3/drone-0077.jpg','alt' => 'DJI_0077 · Late light catching the contours of the reserve from above.'],
                    ['path' => 'camera/gallery-v3/drone-0072.jpg','alt' => 'DJI_0072 · Drone shot tracking the rocky ridge line.'],
                    ['path' => 'camera/gallery-v3/drone-0017.jpg','alt' => 'DJI_0017 · Aerial view moving across the savannah and rock formations.'],

                    ['path' => 'camera/gallery-v3/personal-0399.jpg','alt' => 'IMG_0399 · Personal moment on the rocks looking out over Pian Upe.'],
                    ['path' => 'camera/gallery-v3/img-0355.jpg',  'alt' => 'IMG_0355 · Landscape layers and grasses catching the evening light.'],
                    ['path' => 'camera/gallery-v3/img-0345.jpg',  'alt' => 'IMG_0345 · The ridge and open skies around the cave house.'],
                    ['path' => 'camera/gallery-v3/img-0321.jpg',  'alt' => 'IMG_0321 · Rolling hills and bushland in the distance.'],
                    ['path' => 'camera/gallery-v3/img-0318.jpg',  'alt' => 'IMG_0318 · Rock textures and low vegetation close to the cave.'],
                    ['path' => 'camera/gallery-v3/img-0313.jpg',  'alt' => 'IMG_0313 · A broader view of the rocky ridges and plains.'],
                    ['path' => 'camera/gallery-v3/img-0101.jpg',  'alt' => 'IMG_0101 · Early light and shadows across the Pian Upe landscape.'],
                ];
                $galleryPerPage = 9;
                $galleryPages = array_chunk($galleryImages, $galleryPerPage);
            @endphp
            <div class="mx-auto max-w-6xl px-4 py-16 md:py-20 lg:px-6">
                <header class="max-w-3xl">
                    <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#8d6b4a]/70">Gallery</p>
                    <p class="mt-3 font-display text-4xl md:text-5xl lg:text-6xl text-[#241b16]">Inside and around the cave house.</p>
                    <p class="mt-3 font-sans text-2xl md:text-3xl text-[#4b3b2f]/85">
                        Rooms carved into rock, terraces over the plains, and small details that make the cave house feel quietly lived‑in.
                    </p>
                </header>
                <div class="mt-8">
                    <div id="gallery-pages">
                        @foreach($galleryPages as $pageIndex => $images)
                            <div
                                class="gallery-page {{ $pageIndex === 0 ? '' : 'hidden' }}"
                                data-gallery-page="{{ $pageIndex }}"
                            >
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($images as $image)
                                        <figure class="overflow-hidden rounded-2xl border border-[#e3d4c4] bg-[#fdf7f0] transition-transform duration-700 ease-out will-change-transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/20">
                                            <div class="relative aspect-[4/5] overflow-hidden bg-gradient-to-b from-white/10 to-black/80">
                                                <picture>
                                                    <source srcset="{{ asset(str_replace('.jpg', '.webp', $image['path'])) }}" type="image/webp">
                                                    <img
                                                        class="h-full w-full object-cover js-gallery-image cursor-zoom-in"
                                                        src="{{ asset($image['path']) }}"
                                                        alt="{{ $image['alt'] }}"
                                                        data-full="{{ asset($image['path']) }}"
                                                        data-caption="{{ $image['alt'] }}"
                                                        loading="lazy"
                                                        decoding="async"
                                                    />
                                                </picture>
                                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-transparent via-black/20 to-black/60"></div>
                                            </div>
                                        </figure>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(count($galleryPages) > 1)
                        <div class="mt-8 flex items-center justify-center gap-2">
                            @foreach($galleryPages as $pageIndex => $images)
                                <button
                                    type="button"
                                    class="gallery-page-button {{ $pageIndex === 0 ? 'gallery-page-button--active' : '' }}"
                                    data-gallery-page-target="{{ $pageIndex }}"
                                    aria-label="Show gallery page {{ $pageIndex + 1 }}"
                                    @if($pageIndex === 0) aria-current="page" @endif
                                >
                                    {{ $pageIndex + 1 }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Experience & Amenities -->
        <section id="experiences" class="relative overflow-hidden section-fade-in bg-[#050507]">
            <div
                class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('{{ asset('camera/gallery-v3/img-0117.jpg') }}');">
            </div>
            <div class="absolute inset-0 bg-black/20"></div>
            <div
                class="pointer-events-none absolute inset-0 bg-cover bg-center"
                style="background-image: url('{{ asset('camera/backgrounds/experiences-hero-optimized.jpg') }}');">
            </div>
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/80 via-black/70 to-black/90"></div>
            <div class="relative mx-auto max-w-6xl px-4 py-20 lg:px-6">
                <div class="grid gap-14 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)] items-start">
                    <div>
                        <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#f5f2ea]/80">Experience</h2>
                        <p class="mt-3 font-display text-4xl md:text-5xl lg:text-6xl text-white">Days that move slowly, in a landscape that feels endless.</p>
                        <p class="mt-4 max-w-xl font-sans text-lg md:text-xl leading-relaxed text-[#f5f2ea]/90">
                            Game drives at first light, rock ridges at dusk, long firelit evenings, and quiet hours with nothing on the calendar.
                        </p>
                        <div class="mt-8 space-y-7 md:space-y-8">
                            <div class="border-t border-white/12 pt-6 pb-4 md:pt-7 md:pb-5">
                                <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.24em] text-[#f5f2ea]/80">Dawn on the plains</p>
                                <h3 class="mt-1 font-display text-2xl md:text-3xl text-white">Sunrise game drives.</h3>
                                <p class="mt-2 font-sans text-base md:text-lg leading-relaxed text-[#f5f2ea]/92">
                                    Soft light, cool air, and the savannah waking up around you — giraffes, eland, zebras, and wild ostriches in the distance.
                                </p>
                            </div>
                            <div class="border-t border-white/12 pt-6 pb-4 md:pt-7 md:pb-5">
                                <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.24em] text-[#f5f2ea]/80">Rock ridge rituals</p>
                                <h3 class="mt-1 font-display text-2xl md:text-3xl text-white">Sunrise on the rocks.</h3>
                                <p class="mt-2 font-sans text-base md:text-lg leading-relaxed text-[#f5f2ea]/92">
                                    Light hikes to rocky viewpoints for sunrise coffee, slow photographs, and wide-open silence.
                                </p>
                            </div>
                            <div class="border-t border-white/12 pt-6 pb-4 md:pt-7 md:pb-5">
                                <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.24em] text-[#f5f2ea]/80">Night fire &amp; stars</p>
                                <h3 class="mt-1 font-display text-2xl md:text-3xl text-white">Firelit evenings.</h3>
                                <p class="mt-2 font-sans text-base md:text-lg leading-relaxed text-[#f5f2ea]/92">
                                    A crackling fire, Karamoja’s big sky, and nothing but the sounds of the wild as the reserve settles into night.
                                </p>
                            </div>
                            <div class="border-t border-white/12 pt-6 pb-4 md:pt-7 md:pb-5">
                                <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.24em] text-[#f5f2ea]/80">Quiet, unstructured days</p>
                                <h3 class="mt-1 font-display text-2xl md:text-3xl text-white">Time to simply be.</h3>
                                <p class="mt-2 font-sans text-base md:text-lg leading-relaxed text-[#f5f2ea]/92">
                                    Time to read, sleep, journal, or simply watch the light move across the plains — a retreat for your mind, not your schedule.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#f5f2ea]/80">Amenities</h2>
                        <div class="mt-4 rounded-3xl bg-black/70 p-5 border border-white/10">
                            <ul class="grid gap-x-10 gap-y-3 md:gap-x-14 md:gap-y-4 font-sans text-body-sm text-[#f5f2ea]/92 sm:grid-cols-2">
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>3 rooms · cave house architecture</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>Full-board meals</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>Private chef & attendant</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>Fireplace & outdoor fire pit</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>Wildlife & savannah views</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>Stargazing setup</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>Guided drives & walks</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>Solar power & hot water</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>Outdoor seating & lounge areas</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]"></span>
                                    <span>Board games & slow evenings</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Rates & Booking -->
        <section id="rates" class="bg-[#050507] section-fade-in">
            <div class="mx-auto max-w-6xl px-4 py-14 md:py-18 lg:px-6">
                <div class="grid gap-10 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,1fr)] lg:items-start">

                    {{-- Left: rates info --}}
                    <div>
                        <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#f5f2ea]/50">Rates &amp; Availability</h2>
                        <p class="mt-3 font-display text-4xl md:text-5xl text-[#f5f2ea] leading-tight">Simple, transparent,<br class="hidden md:block"> and fully private.</p>
                        <p class="mt-4 font-sans text-base leading-relaxed text-[#f5f2ea]/60">
                            One group at a time. No shared spaces, no other guests. The cave house is yours entirely.
                        </p>

                        <div class="mt-7 space-y-3">
                            {{-- Rate card --}}
                            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                                <p class="font-sans text-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea]/45">Full-board rate</p>
                                <p class="mt-2 font-display text-3xl text-[#f5f2ea]">$350 <span class="text-lg font-sans font-normal text-[#f5f2ea]/50">/ night</span></p>
                                <p class="mt-2 font-sans text-sm text-[#f5f2ea]/55 leading-relaxed">
                                    Includes breakfast, lunch, dinner, drinking water, tea &amp; coffee. Meals often feature wild game — buffalo, antelope, wild pig — subject to season.
                                </p>
                            </div>

                            {{-- Details --}}
                            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                                <p class="font-sans text-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea]/45 mb-3">Stay details</p>
                                <dl class="space-y-2 font-sans text-sm text-[#f5f2ea]/70">
                                    <div class="flex justify-between gap-4">
                                        <dt>Minimum stay</dt><dd class="text-[#f5f2ea]/90">1 night</dd>
                                    </div>
                                    <div class="flex justify-between gap-4">
                                        <dt>Rooms</dt><dd class="text-[#f5f2ea]/90">Up to 3 · exclusive use</dd>
                                    </div>
                                    <div class="flex justify-between gap-4">
                                        <dt>Advance booking</dt><dd class="text-[#f5f2ea]/90">14 days minimum</dd>
                                    </div>
                                    <div class="flex justify-between gap-4">
                                        <dt>Airport transfer (4×4)</dt><dd class="text-[#f5f2ea]/90">+$200</dd>
                                    </div>
                                    <div class="flex justify-between gap-4">
                                        <dt>Guided game drive</dt><dd class="text-[#f5f2ea]/90">+$150</dd>
                                    </div>
                                    <div class="flex justify-between gap-4">
                                        <dt>Charter flight</dt><dd class="text-[#f5f2ea]/90">On request</dd>
                                    </div>
                                </dl>
                            </div>

                            {{-- Full Board Details --}}
                            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                                <p class="font-sans text-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea]/45 mb-3">Full Board Rates Include</p>
                                <ul class="space-y-2 font-sans text-sm text-[#f5f2ea]/70 leading-relaxed">
                                    <li class="flex items-start gap-2">
                                        <span class="mt-0.5 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]/40 flex-shrink-0"></span>
                                        <span>Full Board accommodation</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="mt-0.5 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]/40 flex-shrink-0"></span>
                                        <span>3 multiple course meals per day, all hot beverages and bar snacks, house drinks</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="mt-0.5 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]/40 flex-shrink-0"></span>
                                        <span>Other camp services provided at KWL</span>
                                    </li>
                                </ul>
                            </div>

                            {{-- Full Board Exclusions --}}
                            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                                <p class="font-sans text-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea]/45 mb-3">Full Board Rates Exclude</p>
                                <ul class="space-y-2 font-sans text-sm text-[#f5f2ea]/70 leading-relaxed">
                                    <li class="flex items-start gap-2">
                                        <span class="mt-0.5 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]/40 flex-shrink-0"></span>
                                        <span>National Park Fees</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="mt-0.5 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]/40 flex-shrink-0"></span>
                                        <span>Road Transfers</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="mt-0.5 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]/40 flex-shrink-0"></span>
                                        <span>Premium and non-house drinks</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="mt-0.5 h-1.5 w-1.5 rounded-full bg-[#f5f2ea]/40 flex-shrink-0"></span>
                                        <span>Optional activities</span>
                                    </li>
                                </ul>
                            </div>

                            {{-- Children Policy --}}
                            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                                <p class="font-sans text-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea]/45 mb-3">Children Policy</p>
                                <div class="space-y-3 font-sans text-sm text-[#f5f2ea]/70 leading-relaxed">
                                    <div>
                                        <p class="font-medium text-[#f5f2ea]/90 mb-1">Children's rate: Under 5 years</p>
                                        <p>Accommodated free if sharing room with full paying adults (maximum two children).</p>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[#f5f2ea]/90 mb-1">Children of 5-12 years of age</p>
                                        <p>Accommodated at reduced rates when sharing a room with full paying adults.</p>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[#f5f2ea]/90 mb-1">Children in their own room or of 13 years and above</p>
                                        <p>Pay the relevant full adult rates applicable.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: booking CTA --}}
                    <div id="booking-widget" class="lg:sticky lg:top-24">
                        <div class="rounded-3xl border border-white/12 bg-black/70 p-8 md:p-10 shadow-2xl shadow-black/60 backdrop-blur-sm text-center">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-[#f5f2ea]/10 mb-6">
                                <svg class="h-8 w-8 text-[#f5f2ea]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="font-sans text-xs font-semibold uppercase tracking-[0.26em] text-[#f5f2ea]/50 mb-2">Reserve your stay</p>
                            <h3 class="font-display text-2xl text-[#f5f2ea] mb-3">Book Your Dates</h3>
                            <p class="font-sans text-sm text-[#f5f2ea]/60 mb-6 leading-relaxed">
                                No payment required now. Our team will confirm your booking within 24 hours.
                            </p>
                            <a href="{{ route('booking') }}" 
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-[#f5f2ea] px-8 py-4 font-sans text-xs font-semibold tracking-[0.22em] text-[#181716] shadow-lg shadow-black/40 hover:bg-white transition-all hover:scale-105">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Start Booking
                            </a>
                            <p class="mt-6 font-sans text-xs text-[#f5f2ea]/35">
                                14-day advance booking required
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- Testimonials (placeholder) - temporarily hidden until real feedback is available --}}
        @if(false)
        <section class="border-y border-[#e3d4c4] bg-[#f7f0e6] section-fade-in">
            <div class="mx-auto max-w-6xl px-4 py-20 lg:px-6">
                <div class="flex items-end justify-between">
                    <div>
                        <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#8d6b4a]/70">Testimonials</h2>
                        <p class="mt-3 font-display text-4xl md:text-5xl lg:text-6xl text-[#241b16]">Whispers from the cave.</p>
                    </div>
                </div>
                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @foreach(range(1,3) as $i)
                        <article class="rounded-2xl border border-[#e3d4c4] bg-[#fffaf3] p-5 font-sans text-body text-[#4b3b2f]/85 shadow-sm">
                            <p class="leading-relaxed">“Placeholder review — future guests will share how Pian Upe Cave House felt: the silence, the stars, the sense of having the wild entirely to themselves.”</p>
                            <p class="mt-4 font-sans text-body-sm font-semibold text-[#241b16]">Guest Name</p>
                            <p class="font-sans text-body-sm text-[#7a6555]">Country · Stay dates</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Map & Directions -->
        <section id="map" class="relative overflow-hidden section-fade-in">
            <div class="absolute inset-0">
                {{-- Map placeholder; can be replaced with interactive map embed --}}
                <iframe
                    title="Pian Upe Cave House Map"
                    src="https://maps.app.goo.gl/3ZGYpWj6iheaRx6v8?g_st=iw"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="h-full w-full border-0"
                ></iframe>
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/45 to-black/10"></div>

            <div class="relative mx-auto flex min-h-[420px] max-w-6xl items-end px-4 py-16 md:min-h-[520px] md:py-24 lg:min-h-[580px] lg:px-6">
                <div class="max-w-xl rounded-3xl border border-white/25 bg-black/65 p-6 shadow-2xl shadow-black/60 backdrop-blur-sm md:p-8">
                    <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#f5f2ea]/70">Map & Directions</p>
                    <p class="mt-3 font-display text-3xl md:text-4xl lg:text-5xl leading-tight text-white">Find your way into the quiet.</p>
                    <p class="mt-3 font-sans text-body-sm md:text-body text-[#f5f2ea]/85">
                        A private ridge inside Pian Upe Game Reserve. Remote enough to feel like the edge of the world, connected enough for transfers and guided access.
                    </p>
                    <dl class="mt-5 grid gap-x-8 gap-y-4 font-sans text-body-sm text-[#f5f2ea]/90 md:grid-cols-2">
                        <div>
                            <dt class="text-label-xs uppercase tracking-[0.2em] text-[#f5f2ea]/70">Location</dt>
                            <dd class="mt-1">PIAN UPE GAME RESERVE · KARAMOJA · NEAR SIPI FALLS</dd>
                        </div>
                        <div>
                            <dt class="text-label-xs uppercase tracking-[0.2em] text-[#f5f2ea]/70">Coordinates</dt>
                            <dd class="mt-1">3°47’42.7”N 33°51’27.0”E</dd>
                        </div>
                        <div>
                            <dt class="text-label-xs uppercase tracking-[0.2em] text-[#f5f2ea]/70">Distance</dt>
                            <dd class="mt-1">Approx. 327 km from Kampala</dd>
                        </div>
                        <div>
                            <dt class="text-label-xs uppercase tracking-[0.2em] text-[#f5f2ea]/70">Access</dt>
                            <dd class="mt-1 font-semibold text-white">4×4 vehicle required</dd>
                            <dd class="mt-1 text-[#f5f2ea]/80">Private 4×4 transfers available from Entebbe Airport or Kampala, and charter flights to Pian Upe Airstrip on request.</dd>
                        </div>
                    </dl>
                    <div class="mt-5 flex flex-wrap items-center gap-3">
                        <a
                            href="https://www.google.com/maps?q=3.795194,33.857500&z=11"
                            target="_blank"
                            class="inline-flex items-center gap-2 rounded-full border border-[#f5f2ea]/60 bg-white/5 px-4 py-2 font-sans text-label-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea] hover:bg-white/10"
                        >
                            <span>Open in Google Maps</span>
                        </a>
                        <p class="font-sans text-[11px] text-[#f5f2ea]/65">
                            Approx. 327 km from Kampala · 4×4 required
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Parallax Interlude: At the Cave House -->
        <section class="relative overflow-hidden section-fade-in parallax-section">
            <div
                class="absolute inset-0 bg-scroll md:bg-fixed bg-cover bg-center parallax-bg"
                data-parallax-speed="0.3"
                style="background-image: url('{{ asset('camera/backgrounds/bg-interlude-02-optimized.jpg') }}');">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/55 via-black/35 to-black/65"></div>
            <div class="relative mx-auto flex max-w-6xl items-center px-4 py-20 md:py-32 lg:px-6">
                <div class="max-w-xl text-[#f5f2ea]">
                    <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#f5f2ea]/70">
                        Life at the cave house
                    </p>
                    <p class="mt-3 font-display text-4xl md:text-5xl lg:text-6xl leading-tight">
                        Slow rituals from sunrise to embers.
                    </p>
                    <p class="mt-3 font-sans text-lg md:text-xl leading-relaxed text-[#f5f2ea]/85">
                        Coffee on the rocks, unhurried meals, warm light on stone walls, and the quiet of Pian Upe just beyond the balcony.
                    </p>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="border-t border-[#e3d4c4] bg-[#f7f0e6] section-fade-in">
            <div class="mx-auto max-w-6xl px-4 py-20 lg:px-6">
                <div class="grid gap-12 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)]">
                    <div>
                        <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#8d6b4a]/70">Contact</h2>
                        <p class="mt-3 font-display text-4xl md:text-5xl lg:text-6xl text-[#241b16]">Speak directly to the team.</p>
                        <p class="mt-4 font-sans text-2xl md:text-3xl leading-relaxed text-[#4b3b2f]/85">
                            For bespoke retreats, group stays, and special requests, reach out directly. We’ll help you plan transfers, flights, and experiences around your stay.
                        </p>
                        <div class="mt-6 space-y-2 font-sans text-body text-[#4b3b2f]/85">
                            <p><span class="font-medium text-[#8d6b4a]/80">Phone:</span> +256 762 031 031 (MTN) · +256 704 881 798 (AIRTEL)</p>
                            <p><span class="font-medium text-[#8d6b4a]/80">WhatsApp:</span> +256 762 031 031 (MTN)</p>
                            <p><span class="font-medium text-[#8d6b4a]/80">Email:</span> reservations@pianupecave.com</p>
                            <p><span class="font-medium text-[#8d6b4a]/80">Website:</span> pianupecave.com</p>
                        </div>
                        <div class="mt-8 rounded-2xl border border-[#e3d4c4] bg-[#fffaf3] p-5 font-sans text-body text-[#4b3b2f]/85 shadow-sm">
                            <h3 class="font-sans text-label-xs font-semibold uppercase tracking-[0.24em] text-[#8d6b4a]/80">Payment Methods</h3>
                            <div class="mt-3 overflow-hidden rounded-xl border border-[#e3d4c4]/60 bg-white/60">
                                <table class="w-full text-left text-sm text-[#3b2f26]">
                                    <thead class="bg-[#f0e4d6] text-xs uppercase tracking-[0.14em] text-[#6c523c]/80">
                                        <tr>
                                            <th class="px-3 py-2 font-semibold">Method</th>
                                            <th class="px-3 py-2 font-semibold">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-t border-[#e3d4c4]">
                                            <td class="px-3 py-3 align-top font-medium text-[#4b3b2f]">Bank (KCB)</td>
                                            <td class="px-3 py-3 align-top space-y-1">
                                                <div>Account Name: <span class="font-medium">BEN LOKERIS KORIANG</span></div>
                                                <div>Account Number: <span class="font-mono font-medium">2303088216</span></div>
                                                <div>SWIFT: <span class="font-mono font-medium">KCBLUGKA</span></div>
                                            </td>
                                        </tr>
                                        <tr class="border-t border-[#e3d4c4]">
                                            <td class="px-3 py-3 align-top font-medium text-[#4b3b2f]">Airtel Money</td>
                                            <td class="px-3 py-3 align-top space-y-1">
                                                <div>Merchant Name: <span class="font-medium">Pian Upe</span></div>
                                                <div>Merchant Code: <span class="font-mono font-medium">7013424</span></div>
                                            </td>
                                        </tr>
                                        <tr class="border-t border-[#e3d4c4]">
                                            <td class="px-3 py-3 align-top font-medium text-[#4b3b2f]">MTN MoMo</td>
                                            <td class="px-3 py-3 align-top space-y-1">
                                                <div>Merchant Name: <span class="font-medium">Koriang Ben Lokeris</span></div>
                                                <div>Merchant Code: <span class="font-mono font-medium">06703748</span></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="https://wa.me/256762031031" target="_blank" class="inline-flex items-center rounded-full bg-[#25D366] px-6 py-2.5 font-sans text-label-xs font-semibold tracking-[0.22em] text-[#031106] shadow-lg shadow-black/40 hover:bg-[#22c55e] transition">
                                Chat on WhatsApp
                            </a>
                            <a
                                    href="#rates"
                                    class="inline-flex items-center rounded-full border border-[#8d6b4a]/40 px-6 py-2.5 font-sans text-label-xs font-semibold tracking-[0.22em] text-[#241b16] hover:bg-[#241b16] hover:text-[#f7f0e6] transition"
                            >
                                Book Your Stay
                            </a>
                        </div>
                    </div>
                    <figure class="relative overflow-hidden rounded-3xl border border-[#e3d4c4] bg-[#fffaf3] shadow-soft">
                        <div class="relative aspect-[4/5] sm:aspect-[3/4] overflow-hidden">
                            <img
                                class="h-full w-full object-cover transform transition-transform duration-700 ease-out will-change-transform hover:scale-105"
                                src="{{ asset('images/contact-optimized.jpg') }}"
                                alt="Dining table set inside the cave house with rock walls all around."
                                loading="lazy"
                                decoding="async"
                            />
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>
                            <figcaption class="absolute inset-x-0 bottom-0 p-5 text-[#f5f2ea]">
                                <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.26em] text-[#f5f2ea]/80">
                                    Hosted inside the cave
                                </p>
                                <p class="mt-2 font-sans text-body-sm leading-relaxed text-[#f5f2ea]/90">
                                    Meals and conversations unfold in the same stone hall that now holds your retreats and gatherings.
                                </p>
                            </figcaption>
                        </div>
                    </figure>
                </div>
            </div>
        </section>
		<!-- Footer -->
		<footer class="relative border-t border-black/40 bg-black">
			<div
				class="pointer-events-none absolute inset-0 bg-cover bg-center opacity-70"
				style="background-image: url('{{ asset('images/legend-optimized.jpg') }}');"
			></div>
			<div class="pointer-events-none absolute inset-0 bg-black/60"></div>

			<div class="relative mx-auto max-w-6xl px-4 py-14 lg:px-6 lg:py-16">
				<div class="grid gap-10 font-sans text-body text-[#f5f2ea]/85 md:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)_minmax(0,1fr)]">
					<div>
						<p class="font-display text-2xl md:text-3xl font-semibold uppercase tracking-[0.28em] text-[#f5f2ea]/80">Pian Upe Cave House</p>
						<p class="mt-3 font-sans text-body md:text-body-lg leading-relaxed text-[#f5f2ea]/85">
							A private cave house carved into the rocks of Pian Upe Game Reserve — hosted stays for couples, small groups, and quiet retreats.
						</p>
					</div>
					<div>
						<h3 class="font-sans text-label-xs font-semibold uppercase tracking-[0.25em] text-[#f5f2ea]/70">Explore</h3>
						<ul class="mt-3 space-y-1.5 font-sans text-body-sm">
							<li><a href="#about" class="hover:text-white transition">The Cave</a></li>
							<li><a href="#experiences" class="hover:text-white transition">Experiences</a></li>
							<li><a href="#rates" class="hover:text-white transition">Rates</a></li>
							<li><a href="#gallery" class="hover:text-white transition">Gallery</a></li>
							<li><a href="#map" class="hover:text-white transition">Map &amp; Directions</a></li>
							<li><a href="#contact" class="hover:text-white transition">Contact</a></li>
						</ul>
					</div>
					<div>
						<h3 class="font-sans text-label-xs font-semibold uppercase tracking-[0.25em] text-[#f5f2ea]/70">Reservations</h3>
						<ul class="mt-3 space-y-1.5 font-sans text-body-sm text-[#f5f2ea]/85">
							<li><span class="text-[#f5f2ea]/60">Phone:</span> +256 762 031 031 (MTN) · +256 704 881 798 (AIRTEL)</li>
							<li><span class="text-[#f5f2ea]/60">WhatsApp:</span> +256 762 031 031 (MTN)</li>
							<li><span class="text-[#f5f2ea]/60">Email:</span> reservations@pianupecave.com</li>
						</ul>
						<p class="mt-3 font-sans text-body md:text-body-lg leading-relaxed text-[#e5d7c8]/85">
							Check availability online, then confirm your stay directly with our team for transfers, flights, and special requests.
						</p>
					</div>
				</div>

				<div id="newsletter" class="mt-12 grid gap-8 border-t border-white/15 pt-8 md:grid-cols-[minmax(0,1.3fr)_minmax(0,1.1fr)] md:items-center">
					<div>
						<p class="font-display text-2xl md:text-3xl font-semibold uppercase tracking-[0.25em] text-[#f5f2ea]/80">Stay in the quiet</p>
						<p class="mt-2 font-sans text-body md:text-body-lg text-[#f5f2ea]/80">
							Occasional updates about retreat dates, special offers, and new experiences at the cave house.
						</p>
					</div>
					<form
						method="POST"
						action="{{ route('newsletter.subscribe') }}"
						class="flex flex-col gap-3 md:flex-row md:justify-end"
					>
						@csrf
						<input
							name="email"
							type="email"
							required
							value="{{ old('email') }}"
							placeholder="Your email address"
							class="w-full rounded-full border border-white/30 bg-black/40 px-4 py-2.5 font-sans text-body-sm text-[#f5f2ea] placeholder:text-white/40 focus:border-white focus:outline-none md:max-w-sm"
						/>
						<button
							type="submit"
							class="inline-flex items-center justify-center rounded-full bg-[#f5f2ea] px-6 py-2.5 font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#181716] shadow-md shadow-black/40 hover:bg-white transition"
						>
							Sign Up
						</button>
					</form>
				</div>

				@if(session('newsletter_subscribed'))
					<p class="mt-4 font-sans text-body text-emerald-300/90">{{ session('newsletter_subscribed') }}</p>
				@endif
				@error('email')
					<p class="mt-2 font-sans text-body text-red-300">{{ $message }}</p>
				@endif

				<div class="mt-10 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
					<div class="flex flex-wrap items-center gap-3">
						<p class="font-sans text-label-xs text-[#f5f2ea]/75">Find us</p>
						<div class="flex flex-wrap gap-2">
							<a
									href="https://www.instagram.com/pianupecave"
									target="_blank"
									class="flex h-9 w-9 items-center justify-center rounded-full border border-white/40 bg-black/40 font-sans text-label-xs text-[#f5f2ea] hover:bg-white hover:text-[#181716] transition"
									aria-label="Instagram"
							>
								<i class="fab fa-instagram"></i>
							</a>
							<a
									href="https://www.airbnb.com/"
									target="_blank"
									class="flex h-9 w-9 items-center justify-center rounded-full border border-white/40 bg-black/40 font-sans text-label-xs text-[#f5f2ea] hover:bg-white hover:text-[#181716] transition"
									aria-label="Airbnb"
							>
								<i class="fab fa-airbnb"></i>
							</a>
							<a
									href="https://www.tripadvisor.com/"
									target="_blank"
									class="flex h-9 w-9 items-center justify-center rounded-full border border-white/40 bg-black/40 font-sans text-label-xs text-[#f5f2ea] hover:bg-white hover:text-[#181716] transition"
									aria-label="Tripadvisor"
							>
								<i class="fa-solid fa-location-dot"></i>
							</a>
							<a
									href="mailto:reservations@pianupecave.com"
									class="flex h-9 w-9 items-center justify-center rounded-full border border-white/40 bg-black/40 font-sans text-label-xs text-[#f5f2ea] hover:bg-white hover:text-[#181716] transition"
									aria-label="Email"
							>
								<i class="fa-regular fa-envelope"></i>
							</a>
						</div>
					</div>
					<div class="font-sans text-body-sm text-[#f5f2ea]/70 text-right">
						<p>PIAN UPE GAME RESERVE · KARAMOJA · NEAR SIPI FALLS</p>
						<p class="mt-1">&copy; {{ now()->year }} Pian Upe Cave House. All rights reserved.</p>
						<p class="mt-1 text-[#f5f2ea]/55">
							Website by
							<a href="https://www.index.ug" target="_blank" class="underline underline-offset-4 hover:text-white">Index Digital</a>.
						</p>
					</div>
				</div>
			</div>
		</footer>

        <!-- LodgingBusiness structured data -->
        <script type="application/ld+json">
            @verbatim
            {
              "@context": "https://schema.org",
              "@type": "LodgingBusiness",
              "name": "Pian Upe Cave House",
              "description": "Your own private cave in the wild — exclusively for you.",
              "url": "https://pianupecave.com",
              "telephone": "+256761311772",
              "address": {
                "@type": "PostalAddress",
                "addressCountry": "UG",
                "addressRegion": "Eastern Uganda",
                "addressLocality": "Pian Upe Game Reserve"
              },
              "geo": {
                "@type": "GeoCoordinates",
                "latitude": 3.795194,
                "longitude": 33.8575
              },
              "amenityFeature": [
                {"@type": "LocationFeatureSpecification", "name": "Private cave house", "value": true},
                {"@type": "LocationFeatureSpecification", "name": "Full board meals", "value": true},
                {"@type": "LocationFeatureSpecification", "name": "Guided game drives", "value": true}
              ]
            }
            @endverbatim
        </script>

        <div id="gallery-lightbox" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm">
            <button
                id="gallery-lightbox-close"
                class="absolute right-4 top-4 rounded-full border border-white/40 bg-black/40 px-3 py-1 font-sans text-label-xs font-semibold uppercase tracking-[0.18em] text-white/80 hover:bg-black/70"
            >
                Close
            </button>
            <button
                id="gallery-lightbox-prev"
                class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full border border-white/40 bg-black/40 px-3 py-2 font-sans text-body-sm text-white/80 hover:bg-black/70"
            >
                &#10094;
            </button>
            <button
                id="gallery-lightbox-next"
                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full border border-white/40 bg-black/40 px-3 py-2 font-sans text-body-sm text-white/80 hover:bg-black/70"
            >
                &#10095;
            </button>
            <div class="flex h-full items-center justify-center px-4">
                <div class="max-w-4xl w-full">
                    <img
                        id="gallery-lightbox-image"
                        class="max-h-[80vh] w-full rounded-2xl object-contain shadow-2xl shadow-black/60"
                        alt=""
                    />
                    <p id="gallery-lightbox-caption" class="mt-4 text-center font-sans text-body-sm text-white/80"></p>
                </div>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
