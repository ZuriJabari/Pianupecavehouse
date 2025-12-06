<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shop · Pian Upe Cave House</title>
    <meta name="description" content="Pian Upe Cave House shop — curated souvenirs, prints, and keepsakes from the cave and the savannah.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|cormorant-garamond:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f7f0e6] text-[#241b16] antialiased font-sans text-body md:text-body-lg leading-relaxed">
<div class="relative min-h-screen">
    <!-- Sticky Nav -->
    <header id="site-header" class="site-header site-header--at-top fixed inset-x-0 top-0 z-40 border-b border-black/5 bg-[#f7f0e6]/90 backdrop-blur-sm">
        <div class="mx-auto max-w-6xl px-4 py-4 lg:px-6">
            <!-- Mobile: logo left, menu button right -->
            <div class="flex items-center justify-between lg:hidden">
                <a href="{{ route('landing') }}#hero" class="header-logo flex flex-col leading-tight">
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
                    <a href="{{ route('landing') }}#about" class="lux-nav-link hover:text-black transition">The Cave</a>
                    <a href="{{ route('landing') }}#experiences" class="lux-nav-link hover:text-black transition">Experiences</a>
                    <a href="{{ route('landing') }}#rates" class="lux-nav-link hover:text-black transition">Rates</a>
                </nav>

                <a href="{{ route('landing') }}#hero" class="header-logo flex flex-col items-center text-center leading-tight">
                    <span class="font-display font-semibold text-heading-md lg:text-heading-lg tracking-[0.5em] uppercase text-[#241b16]">PIAN UPE</span>
                    <span class="mt-1 font-sans text-label-xs tracking-[0.3em] uppercase text-[#241b16]/80">CAVE HOUSE</span>
                </a>

                <nav class="flex items-center gap-8 font-sans text-body-sm font-medium tracking-[0.18em] uppercase text-[#3b2b21]/85">
                    <a href="{{ route('landing') }}#gallery" class="lux-nav-link hover:text-black transition">Gallery</a>
                    <a href="{{ route('landing') }}#contact" class="lux-nav-link hover:text-black transition">Contact</a>
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
                    <a href="{{ route('landing') }}#about" class="lux-nav-link block rounded-full bg-white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg-white/10 hover:text-white transition">The Cave</a>
                    <a href="{{ route('landing') }}#experiences" class="lux-nav-link block rounded-full bg-white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg-white/10 hover:text-white transition">Experiences</a>
                    <a href="{{ route('landing') }}#rates" class="lux-nav-link block rounded-full bg-white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg-white/10 hover:text-white transition">Rates</a>
                    <a href="{{ route('landing') }}#gallery" class="lux-nav-link block rounded-full bg-white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg-white/10 hover:text-white transition">Gallery</a>
                    <a href="{{ route('shop.index') }}" class="lux-nav-link block rounded-full bg-white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg-white/10 hover:text-white transition">Shop</a>
                    <a href="{{ route('landing') }}#contact" class="lux-nav-link block rounded-full bg-white/0 px-4 py-2 text-[#f5f2ea]/85 hover:bg-white/10 hover:text-white transition">Contact</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="relative overflow-hidden section-fade-in">
            <div class="absolute inset-0">
                <img
                    src="{{ asset('camera/backgrounds/shop-hero.jpg') }}"
                    alt="Souvenir objects from Pian Upe Cave House."
                    loading="lazy"
                    decoding="async"
                    class="h-full w-full object-cover"
                />
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/55 to-black/85"></div>
            <div class="relative mx-auto flex min-h-[420px] max-w-6xl items-center px-4 py-32 md:min-h-[520px] md:py-40 lg:min-h-[600px] lg:px-6">
                <div class="max-w-xl text-[#f5f2ea]">
                    <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#f5f2ea]/70">Pian Upe keepsakes</p>
                    <h1
                        role="heading"
                        aria-level="1"
                        class="mt-4 font-display text-5xl md:text-6xl lg:text-7xl leading-tight text-white"
                    >
                        A small shop for quiet souvenirs.
                    </h1>
                    <p class="mt-4 font-sans text-lg md:text-xl text-[#f5f2ea]/85">
                        Prints, objects, and little rituals from the cave house and the savannah. Curated in small batches so you can carry a piece of Pian Upe home.
                    </p>
                    @if(session('shop_notice'))
                        <div class="mt-5 inline-flex rounded-2xl border border-white/25 bg-black/35 px-4 py-2.5 font-sans text-body-sm text-[#f5f2ea]/90 shadow-sm">
                            {{ session('shop_notice') }}
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="section-fade-in">
            <div class="mx-auto max-w-6xl px-4 py-10 lg:px-6 lg:py-16">
                <div class="grid gap-10 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] lg:items-start">
                    <div>
                        <div class="mt-2 grid gap-6 md:grid-cols-2">
                            @forelse($products as $product)
                                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-[#e3d4c4] bg-[#fffaf3] shadow-sm">
                                    <div class="relative aspect-[4/3] w-full overflow-hidden bg-[#e7d7c7]">
                                        @if($product->image_path)
                                            <img
                                                src="{{ asset($product->image_path) }}"
                                                alt="{{ $product->name }}"
                                                loading="lazy"
                                                decoding="async"
                                                class="h-full w-full object-cover transition duration-500 hover:scale-[1.03]"
                                            />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-sm text-[#6b5140]/75">
                                                Pian Upe souvenir
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-1 flex-col p-4 md:p-5">
                                        <h2 class="font-display text-xl text-[#241b16]">{{ $product->name }}</h2>
                                        @if($product->description)
                                            <p class="mt-2 line-clamp-3 font-sans text-body-sm text-[#4b3b2f]/85">{{ $product->description }}</p>
                                        @endif
                                        <div class="mt-4 flex items-center justify-between">
                                            <p class="font-sans text-body-sm font-semibold text-[#241b16]">{{ $product->price_formatted }}</p>
                                        </div>
                                        <form action="{{ route('shop.add', $product) }}" method="POST" class="mt-4">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="lux-cta inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#241b16] px-5 py-2.5 font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea] shadow-sm hover:bg-[#f5f2ea] hover:text-[#181716]"
                                            >
                                                <span>Add to selection</span>
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            @empty
                                <p class="font-sans text-body text-[#4b3b2f]/85">
                                    The shop is being curated. Check back soon for limited-edition souvenirs from Pian Upe Cave House.
                                </p>
                            @endforelse
                        </div>
                    </div>

                    <aside class="lg:sticky lg:top-28">
                        <div class="rounded-3xl border border-[#e3d4c4] bg-[#fffaf3] p-5 shadow-sm">
                            <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.26em] text-[#8d6b4a]/80">Your selection</h2>
                            @if(!empty($cart['items']))
                                <ul class="mt-4 space-y-3">
                                    @foreach($cart['items'] as $item)
                                        <li class="flex items-start justify-between gap-3">
                                            <div>
                                                <p class="font-sans text-body-sm font-semibold text-[#241b16]">{{ $item['product']->name }}</p>
                                                <p class="mt-1 font-sans text-[13px] text-[#6b5140]">Qty {{ $item['quantity'] }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-sans text-body-sm text-[#241b16]">{{ number_format($item['line_total_cents'] / 100, 0) }} {{ $cart['currency'] }}</p>
                                                <form action="{{ route('shop.remove', $item['product']) }}" method="POST" class="mt-1">
                                                    @csrf
                                                    <button type="submit" class="font-sans text-[11px] uppercase tracking-[0.18em] text-[#8d6b4a]/80 hover:text-[#3b2b21]">Remove</button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <dl class="mt-4 space-y-1 border-t border-[#e3d4c4]/80 pt-3 font-sans text-body-sm text-[#4b3b2f]/85">
                                    <div class="flex justify-between">
                                        <dt>Subtotal</dt>
                                        <dd>{{ number_format($cart['subtotal_cents'] / 100, 0) }} {{ $cart['currency'] }}</dd>
                                    </div>
                                    <div class="flex justify-between text-[#7a6555]">
                                        <dt>Shipping</dt>
                                        <dd>To be confirmed</dd>
                                    </div>
                                </dl>

                                <a
                                    href="{{ route('shop.checkout') }}"
                                    class="lux-cta mt-4 inline-flex w-full items-center justify-center rounded-full bg-[#241b16] px-5 py-2.5 font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea] shadow-md hover:bg-[#f5f2ea] hover:text-[#181716]"
                                >
                                    Request invoice
                                </a>

                                <p class="mt-3 font-sans text-[12px] text-[#7a6555]">
                                    No online payment yet — we’ll email you a detailed invoice with bank transfer options and confirm shipping.
                                </p>
                            @else
                                <p class="mt-4 font-sans text-body-sm text-[#7a6555]">
                                    Select an item from the shop to start your order. Your selection will appear here.
                                </p>
                            @endif
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <!-- Footer (same as landing page) -->
        <footer class="relative border-t border-black/40 bg-black">
			<div
				class="pointer-events-none absolute inset-0 bg-cover bg-center opacity-70"
				style="background-image: url('{{ asset('camera/backgrounds/footer-bg.jpg') }}');"
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
							<li><a href="{{ route('landing') }}#about" class="hover:text-white transition">The Cave</a></li>
							<li><a href="{{ route('landing') }}#experiences" class="hover:text-white transition">Experiences</a></li>
							<li><a href="{{ route('landing') }}#rates" class="hover:text-white transition">Rates</a></li>
							<li><a href="{{ route('landing') }}#gallery" class="hover:text-white transition">Gallery</a></li>
							<li><a href="{{ route('landing') }}#map" class="hover:text-white transition">Map &amp; Directions</a></li>
							<li><a href="{{ route('landing') }}#contact" class="hover:text-white transition">Contact</a></li>
						</ul>
					</div>
					<div>
						<h3 class="font-sans text-label-xs font-semibold uppercase tracking-[0.25em] text-[#f5f2ea]/70">Reservations</h3>
						<ul class="mt-3 space-y-1.5 font-sans text-body-sm text-[#f5f2ea]/85">
							<li><span class="text-[#f5f2ea]/60">Phone:</span> +256 (0) 761 311 772</li>
							<li><span class="text-[#f5f2ea]/60">WhatsApp:</span> +256 777 643084</li>
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
	</main>
</div>
</body>
</html>
