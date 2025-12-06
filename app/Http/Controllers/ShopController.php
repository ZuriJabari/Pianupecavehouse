<?php

namespace App\Http\Controllers;

use App\Mail\ShopOrderInvoiceMail;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use App\Models\ShopProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $products = ShopProduct::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $cart = $this->buildCartSummary($request);

        return view('shop.index', [
            'products' => $products,
            'cart' => $cart,
        ]);
    }

    public function add(Request $request, ShopProduct $product): RedirectResponse
    {
        $cart = $request->session()->get('shop.cart', []);
        $current = (int) ($cart[$product->id] ?? 0);
        $cart[$product->id] = min($current + 1, 99);

        $request->session()->put('shop.cart', $cart);

        return back()->with('shop_notice', 'Added to your selection.');
    }

    public function remove(Request $request, ShopProduct $product): RedirectResponse
    {
        $cart = $request->session()->get('shop.cart', []);
        unset($cart[$product->id]);
        $request->session()->put('shop.cart', $cart);

        return back()->with('shop_notice', 'Removed from your selection.');
    }

    public function checkout(Request $request): View|RedirectResponse
    {
        $order = null;

        if ($reference = $request->session()->get('order_reference')) {
            $order = ShopOrder::where('reference', $reference)->with('items.product')->first();
        }

        $cart = $this->buildCartSummary($request);

        if (! $order && empty($cart['items'])) {
            return redirect()->route('shop.index')->with('shop_notice', 'Select an item first to request an order.');
        }

        return view('shop.checkout', [
            'cart' => $cart,
            'order' => $order,
        ]);
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $cart = $this->buildCartSummary($request);

        if (empty($cart['items'])) {
            return redirect()->route('shop.index')->with('shop_notice', 'Your selection is empty.');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:255'],
            'shipping_country' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $reference = 'SO-'.Str::upper(Str::random(6));

        $order = ShopOrder::create([
            'reference' => $reference,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?? null,
            'shipping_country' => $data['shipping_country'],
            'shipping_city' => $data['shipping_city'],
            'shipping_address' => $data['shipping_address'],
            'status' => 'pending',
            'subtotal_cents' => $cart['subtotal_cents'],
            'shipping_cents' => $cart['shipping_cents'],
            'total_cents' => $cart['total_cents'],
            'currency' => $cart['currency'],
            'notes' => $data['notes'] ?? null,
            'items_snapshot' => $cart['items'],
        ]);

        foreach ($cart['items'] as $item) {
            ShopOrderItem::create([
                'shop_order_id' => $order->id,
                'shop_product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'unit_price_cents' => $item['unit_price_cents'],
                'quantity' => $item['quantity'],
                'line_total_cents' => $item['line_total_cents'],
                'currency' => $cart['currency'],
            ]);
        }

        try {
            Mail::to($order->customer_email)->send(new ShopOrderInvoiceMail($order));
            Mail::to('reservations@pianupecave.com')->send(new ShopOrderInvoiceMail($order));
        } catch (\Throwable $e) {
            // Fail silently for now; order is still stored.
        }

        $request->session()->forget('shop.cart');

        return redirect()->route('shop.checkout')->with('order_reference', $order->reference);
    }

    protected function buildCartSummary(Request $request): array
    {
        $cart = $request->session()->get('shop.cart', []);

        if (empty($cart)) {
            return [
                'items' => [],
                'subtotal_cents' => 0,
                'shipping_cents' => 0,
                'total_cents' => 0,
                'currency' => 'USD',
            ];
        }

        $productIds = array_keys($cart);

        $products = ShopProduct::query()
            ->whereIn('id', $productIds)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $items = [];
        $subtotalCents = 0;
        $currency = 'USD';

        foreach ($cart as $productId => $qty) {
            $product = $products->get($productId);
            if (! $product) {
                continue;
            }

            $quantity = max(1, (int) $qty);
            $lineTotal = $product->price_cents * $quantity;
            $subtotalCents += $lineTotal;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'unit_price_cents' => $product->price_cents,
                'line_total_cents' => $lineTotal,
            ];

            $currency = $product->currency;
        }

        $shippingCents = 0;
        $totalCents = $subtotalCents + $shippingCents;

        return [
            'items' => $items,
            'subtotal_cents' => $subtotalCents,
            'shipping_cents' => $shippingCents,
            'total_cents' => $totalCents,
            'currency' => $currency,
        ];
    }
}
