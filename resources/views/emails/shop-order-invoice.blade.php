<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Shop Order · Pian Upe Cave House</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;color:#111827;">
@php
    $items = $order->items_snapshot ?? [];
@endphp
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" style="padding:32px 12px;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:640px;background-color:#ffffff;border-radius:12px;border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,0.05);">
                <tr>
                    <td style="padding:24px 24px 12px 24px;border-bottom:1px solid #e5e7eb;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td align="left" style="vertical-align:top;">
                                    <div style="font-size:18px;font-weight:600;color:#111827;">Pian Upe Cave House</div>
                                    <div style="margin-top:4px;font-size:12px;color:#4b5563;">Boutique cave house stay in Karamoja, Uganda</div>
                                    <div style="margin-top:4px;font-size:12px;color:#4b5563;">Email: reservations@pianupecave.com · Phone / WhatsApp: +256 777 643084</div>
                                </td>
                                <td align="right" style="vertical-align:top;">
                                    <div style="font-size:22px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#111827;">SHOP ORDER</div>
                                    <div style="margin-top:8px;font-size:12px;color:#4b5563;">
                                        <div>Order #: <span style="font-family:ui-monospace,Menlo,Monaco,Consolas,'Liberation Mono','Courier New',monospace;">{{ $order->reference }}</span></div>
                                        <div>Issue date: {{ optional($order->created_at)->format('M j, Y') }}</div>
                                        <div>Currency: {{ $order->currency }}</div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 24px 8px 24px;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td width="55%" style="vertical-align:top;padding-right:16px;">
                                    <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;">Bill to</div>
                                    <div style="margin-top:6px;font-size:14px;font-weight:600;color:#111827;">{{ $order->customer_name }}</div>
                                    @if($order->customer_email)
                                        <div style="margin-top:2px;font-size:13px;color:#4b5563;">{{ $order->customer_email }}</div>
                                    @endif
                                    @if($order->customer_phone)
                                        <div style="margin-top:2px;font-size:13px;color:#4b5563;">{{ $order->customer_phone }}</div>
                                    @endif
                                </td>
                                <td width="45%" style="vertical-align:top;">
                                    <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;">Shipping details</div>
                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:6px;font-size:13px;color:#374151;">
                                        <tr>
                                            <td align="left" style="padding:1px 0;">Country</td>
                                            <td align="right" style="padding:1px 0;">{{ $order->shipping_country }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="padding:1px 0;">City</td>
                                            <td align="right" style="padding:1px 0;">{{ $order->shipping_city }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="padding:1px 0;">Address</td>
                                            <td align="right" style="padding:1px 0;">{{ $order->shipping_address }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px 24px 8px 24px;">
                        <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px;">Order summary</div>
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-size:13px;border-collapse:collapse;">
                            <thead>
                                <tr>
                                    <th align="left" style="padding:8px 8px;border-bottom:1px solid #e5e7eb;font-weight:600;color:#4b5563;">Item</th>
                                    <th align="center" style="padding:8px 8px;border-bottom:1px solid #e5e7eb;font-weight:600;color:#4b5563;">Qty</th>
                                    <th align="right" style="padding:8px 8px;border-bottom:1px solid #e5e7eb;font-weight:600;color:#4b5563;">Line total ({{ $order->currency }})</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td style="padding:8px 8px;border-bottom:1px solid #f3f4f6;">
                                            <div style="font-weight:500;">{{ $item['product_name'] ?? ($item['product']->name ?? '') }}</div>
                                        </td>
                                        <td align="center" style="padding:8px 8px;border-bottom:1px solid #f3f4f6;">{{ $item['quantity'] ?? 1 }}</td>
                                        <td align="right" style="padding:8px 8px;border-bottom:1px solid #f3f4f6;">{{ isset($item['line_total_cents']) ? number_format($item['line_total_cents'] / 100, 0) : '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:4px 24px 12px 24px;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-size:13px;">
                            <tr>
                                <td align="right" style="padding:4px 8px;color:#4b5563;">Subtotal</td>
                                <td align="right" style="padding:4px 8px;color:#111827;">{{ number_format($order->subtotal_cents / 100, 0) }} {{ $order->currency }}</td>
                            </tr>
                            <tr>
                                <td align="right" style="padding:4px 8px;color:#4b5563;">Shipping</td>
                                <td align="right" style="padding:4px 8px;color:#111827;">{{ number_format($order->shipping_cents / 100, 0) }} {{ $order->currency }}</td>
                            </tr>
                            <tr>
                                <td align="right" style="padding:8px 8px;font-weight:700;color:#111827;border-top:1px solid #e5e7eb;">Total due</td>
                                <td align="right" style="padding:8px 8px;font-weight:700;color:#111827;border-top:1px solid #e5e7eb;">{{ number_format($order->total_cents / 100, 0) }} {{ $order->currency }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px 24px 16px 24px;border-top:1px solid #e5e7eb;">
                        <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px;">Payment instructions</div>
                        <p style="margin:0 0 10px 0;font-size:13px;color:#4b5563;">
                            Thank you for choosing a Pian Upe Cave House keepsake. This invoice summarises your shop order. To confirm your order, please complete payment and share proof of payment with our team, quoting your order reference
                            <span style="font-family:ui-monospace,Menlo,Monaco,Consolas,'Liberation Mono','Courier New',monospace;">{{ $order->reference }}</span>.
                        </p>
                        <div style="margin:0 0 8px 0;padding:10px 12px;border-radius:8px;border:1px solid #e5e7eb;background-color:#f9fafb;">
                            <div style="margin:0 0 4px 0;font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:#6b7280;">Bank transfer</div>
                            <p style="margin:0 0 6px 0;font-size:13px;color:#374151;">We currently accept bank transfer payments. Please contact our team for up-to-date bank account details:</p>
                            <ul style="margin:0;padding-left:18px;font-size:13px;color:#374151;">
                                <li>Email: <span style="font-weight:500;">reservations@pianupecave.com</span></li>
                                <li>Phone / WhatsApp: <span style="font-weight:500;">+256 777 643084</span></li>
                                <li>Please include your shop order reference in the payment description.</li>
                            </ul>
                        </div>
                        <p style="margin:8px 0 4px 0;font-size:12px;color:#4b5563;">
                            If you have any questions or need anything adjusted on your invoice, please reply to this email or contact us at <span style="font-weight:500;">reservations@pianupecave.com</span>.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
