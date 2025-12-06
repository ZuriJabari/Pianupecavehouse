<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shop Checkout · Pian Upe Cave House</title>
    <meta name="description" content="Confirm your Pian Upe Cave House shop order and receive a detailed invoice with payment instructions.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|cormorant-garamond:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f7f0e6] text-[#241b16] antialiased font-sans text-body md:text-body-lg leading-relaxed">
<div class="relative min-h-screen">
    <!-- Reuse simplified header linking back to main site -->
    <header id="site-header" class="site-header site-header--at-top fixed inset-x-0 top-0 z-40 border-b border-black/5 bg-[#f7f0e6]/90 backdrop-blur-sm">
        <div class="mx-auto max-w-6xl px-4 py-4 lg:px-6 flex items-center justify-between">
            <a href="{{ route('landing') }}#hero" class="header-logo flex flex-col leading-tight">
                <span class="font-display font-semibold text-heading-md lg:text-heading-lg tracking-[0.5em] uppercase text-[#241b16]">PIAN UPE</span>
                <span class="mt-1 font-sans text-label-xs tracking-[0.3em] uppercase text-[#241b16]/80">CAVE HOUSE</span>
            </a>
            <nav class="hidden items-center gap-6 font-sans text-body-sm font-medium tracking-[0.18em] uppercase text-[#3b2b21]/85 md:flex">
                <a href="{{ route('shop.index') }}" class="lux-nav-link hover:text-black transition">Shop</a>
                <a href="{{ route('landing') }}#rates" class="lux-nav-link hover:text-black transition">Stay</a>
                <a href="{{ route('landing') }}#contact" class="lux-nav-link hover:text-black transition">Contact</a>
            </nav>
        </div>
    </header>

    <main class="pt-24 lg:pt-28">
        <section class="section-fade-in">
            <div class="mx-auto max-w-6xl px-4 py-10 lg:px-6 lg:py-16">
                @if(isset($order) && $order)
                    <div class="mx-auto max-w-3xl rounded-3xl border border-[#e3d4c4] bg-[#fffaf3] p-6 shadow-xl md:p-8">
                        <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#8d6b4a]/70">Shop order received</p>
                        <h1 class="mt-3 font-display text-3xl md:text-4xl lg:text-5xl text-[#241b16] leading-tight">
                            Thank you. We’ve received your order.
                        </h1>
                        <p class="mt-3 font-sans text-body text-[#4b3b2f]/85">
                            Your order reference is <span class="font-mono text-sm font-semibold">{{ $order->reference }}</span>. A detailed invoice with payment instructions has been emailed to you and to the Pian Upe Cave House team.
                        </p>

                        <div class="mt-6 rounded-2xl border border-[#e3d4c4] bg-white/70 p-4">
                            <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#8d6b4a]/80">Order summary</h2>
                            <ul class="mt-3 space-y-2 font-sans text-body-sm text-[#4b3b2f]/90">
                                @foreach($order->items as $item)
                                    <li class="flex items-center justify-between gap-4">
                                        <span>{{ $item->product_name }} (x{{ $item->quantity }})</span>
                                        <span>{{ number_format($item->line_total_cents / 100, 0) }} {{ $order->currency }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <dl class="mt-4 space-y-1 border-t border-[#f0e0d0] pt-3 font-sans text-body-sm text-[#4b3b2f]/90">
                                <div class="flex justify-between">
                                    <dt>Subtotal</dt>
                                    <dd>{{ $order->subtotal_formatted }}</dd>
                                </div>
                                <div class="flex justify-between text-[#7a6555]">
                                    <dt>Shipping</dt>
                                    <dd>To be confirmed</dd>
                                </div>
                                <div class="flex justify-between pt-2 font-semibold text-[#241b16]">
                                    <dt>Total</dt>
                                    <dd>{{ $order->total_formatted }}</dd>
                                </div>
                            </dl>
                        </div>

                        <p class="mt-5 font-sans text-body-sm text-[#7a6555]">
                            If you need to adjust your order or shipping details, simply reply to the invoice email or contact us at <span class="font-semibold">reservations@pianupecave.com</span>.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('shop.index') }}" class="lux-cta inline-flex items-center justify-center rounded-full bg-[#241b16] px-5 py-2.5 font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea] shadow-md hover:bg-[#f5f2ea] hover:text-[#181716]">
                                Back to shop
                            </a>
                            <a href="{{ route('landing') }}#rates" class="lux-cta inline-flex items-center justify-center rounded-full border border-[#241b16]/40 bg-transparent px-5 py-2.5 font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#241b16] hover:bg-[#241b16] hover:text-[#f5f2ea]">
                                Plan a stay
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid gap-10 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] lg:items-start">
                        <div>
                            <p class="font-sans text-label-xs font-semibold uppercase tracking-[0.3em] text-[#8d6b4a]/70">Shop checkout</p>
                            <h1 class="mt-3 font-display text-3xl md:text-4xl lg:text-5xl text-[#241b16] leading-tight">
                                Share your details and we’ll send an invoice.
                            </h1>
                            <p class="mt-4 font-sans text-body text-[#4b3b2f]/85">
                                There’s no online payment yet. Once you submit, we’ll email you a detailed invoice with bank transfer information, then confirm shipping and delivery timing personally.
                            </p>

                            <div class="mt-6 rounded-3xl border border-[#e3d4c4] bg-[#fffaf3] p-5 shadow-sm">
                                <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#8d6b4a]/80">Your selection</h2>
                                <ul class="mt-3 space-y-2 font-sans text-body-sm text-[#4b3b2f]/90">
                                    @foreach($cart['items'] as $item)
                                        <li class="flex items-center justify-between gap-4">
                                            <span>{{ $item['product']->name }} (x{{ $item['quantity'] }})</span>
                                            <span>{{ number_format($item['line_total_cents'] / 100, 0) }} {{ $cart['currency'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <dl class="mt-4 space-y-1 border-t border-[#f0e0d0] pt-3 font-sans text-body-sm text-[#4b3b2f]/90">
                                    <div class="flex justify-between">
                                        <dt>Subtotal</dt>
                                        <dd>{{ number_format($cart['subtotal_cents'] / 100, 0) }} {{ $cart['currency'] }}</dd>
                                    </div>
                                    <div class="flex justify-between text-[#7a6555]">
                                        <dt>Shipping</dt>
                                        <dd>To be confirmed</dd>
                                    </div>
                                    <div class="flex justify-between pt-2 font-semibold text-[#241b16]">
                                        <dt>Estimated total</dt>
                                        <dd>{{ number_format($cart['total_cents'] / 100, 0) }} {{ $cart['currency'] }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="lg:sticky lg:top-28">
                            <div class="rounded-3xl border border-[#e3d4c4] bg-[#fffaf3] p-5 shadow-sm">
                                <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#8d6b4a]/80">Delivery & contact details</h2>

                                <form action="{{ route('shop.place-order') }}" method="POST" class="mt-4 space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block font-sans text-body-sm text-[#4b3b2f]/90">Full name</label>
                                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="mt-1 w-full rounded-lg border border-[#e3d4c4] bg-white px-3 py-2.5 font-sans text-body text-[#241b16] focus:border-[#8d6b4a] focus:outline-none" required>
                                        @error('customer_name')<p class="mt-1 font-sans text-body-sm text-red-500">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block font-sans text-body-sm text-[#4b3b2f]/90">Email</label>
                                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="mt-1 w-full rounded-lg border border-[#e3d4c4] bg-white px-3 py-2.5 font-sans text-body text-[#241b16] focus:border-[#8d6b4a] focus:outline-none" required>
                                        @error('customer_email')<p class="mt-1 font-sans text-body-sm text-red-500">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block font-sans text-body-sm text-[#4b3b2f]/90">Phone / WhatsApp (optional)</label>
                                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" class="mt-1 w-full rounded-lg border border-[#e3d4c4] bg-white px-3 py-2.5 font-sans text-body text-[#241b16] focus:border-[#8d6b4a] focus:outline-none">
                                        @error('customer_phone')<p class="mt-1 font-sans text-body-sm text-red-500">{{ $message }}</p>@enderror
                                    </div>
                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block font-sans text-body-sm text-[#4b3b2f]/90">Country</label>
                                            <input type="text" name="shipping_country" value="{{ old('shipping_country') }}" class="mt-1 w-full rounded-lg border border-[#e3d4c4] bg-white px-3 py-2.5 font-sans text-body text-[#241b16] focus:border-[#8d6b4a] focus:outline-none" required>
                                            @error('shipping_country')<p class="mt-1 font-sans text-body-sm text-red-500">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block font-sans text-body-sm text-[#4b3b2f]/90">City</label>
                                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" class="mt-1 w-full rounded-lg border border-[#e3d4c4] bg-white px-3 py-2.5 font-sans text-body text-[#241b16] focus:border-[#8d6b4a] focus:outline-none" required>
                                            @error('shipping_city')<p class="mt-1 font-sans text-body-sm text-red-500">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block font-sans text-body-sm text-[#4b3b2f]/90">Shipping address</label>
                                        <input type="text" name="shipping_address" value="{{ old('shipping_address') }}" class="mt-1 w-full rounded-lg border border-[#e3d4c4] bg-white px-3 py-2.5 font-sans text-body text-[#241b16] focus:border-[#8d6b4a] focus:outline-none" required>
                                        @error('shipping_address')<p class="mt-1 font-sans text-body-sm text-red-500">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block font-sans text-body-sm text-[#4b3b2f]/90">Notes (optional)</label>
                                        <textarea name="notes" rows="3" class="mt-1 w-full rounded-lg border border-[#e3d4c4] bg-white px-3 py-2.5 font-sans text-body text-[#241b16] focus:border-[#8d6b4a] focus:outline-none">{{ old('notes') }}</textarea>
                                        @error('notes')<p class="mt-1 font-sans text-body-sm text-red-500">{{ $message }}</p>@enderror
                                    </div>

                                    <button type="submit" class="lux-cta mt-2 inline-flex w-full items-center justify-center rounded-full bg-[#241b16] px-6 py-3 font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea] shadow-md hover:bg-[#f5f2ea] hover:text-[#181716]">
                                        Request invoice
                                    </button>

                                    <p class="mt-3 font-sans text-[12px] text-[#7a6555]">
                                        You won’t be charged online. We’ll review your order, email you an invoice with payment details, and confirm shipping directly.
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
</div>
</body>
</html>
