<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Booking Invoice · Pian Upe Cave House</title>
</head>
<body style="margin:0;padding:0;background-color:#050507;font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;color:#f5f2ea;">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" style="padding:32px 12px;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:560px;background-color:#050507;border-radius:16px;border:1px solid rgba(245,242,234,0.12);">
                <tr>
                    <td style="padding:24px 24px 8px 24px;">
                        <p style="margin:0;font-size:10px;letter-spacing:0.24em;text-transform:uppercase;color:rgba(245,242,234,0.7);">Booking Invoice</p>
                        <h1 style="margin:8px 0 0 0;font-size:22px;font-weight:500;color:#f5f2ea;">Pian Upe Cave House</h1>
                        <p style="margin:12px 0 0 0;font-size:13px;color:rgba(245,242,234,0.7);">
                            Booking reference <span style="font-family:ui-monospace,Menlo,Monaco,Consolas,'Liberation Mono','Courier New',monospace;">{{ $booking->reference }}</span>
                        </p>
                        <p style="margin:4px 0 0 0;font-size:13px;color:rgba(245,242,234,0.7);">
                            Guest: {{ $booking->guest_name }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px 24px 16px 24px;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-size:13px;color:rgba(245,242,234,0.85);background-color:rgba(255,255,255,0.02);border-radius:12px;border:1px solid rgba(245,242,234,0.12);">
                            <tr>
                                <td style="padding:12px 16px 4px 16px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <td align="left">Check-in</td>
                                            <td align="right">{{ $booking->check_in->format('M j, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="padding-top:4px;">Check-out</td>
                                            <td align="right" style="padding-top:4px;">{{ $booking->check_out->format('M j, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="padding-top:4px;">Nights</td>
                                            <td align="right" style="padding-top:4px;">{{ $booking->nights }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="padding-top:4px;">Guests</td>
                                            <td align="right" style="padding-top:4px;">{{ $booking->guests_adults + $booking->guests_children }}</td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="padding-top:10px;font-weight:600;">Total</td>
                                            <td align="right" style="padding-top:10px;font-weight:600;">${{ number_format($booking->total_amount) }} {{ $booking->currency }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:4px 24px 24px 24px;">
                        <p style="margin:0 0 12px 0;font-size:13px;color:rgba(245,242,234,0.8);">
                            Thank you for choosing Pian Upe Cave House. This invoice summarises your provisional booking. To confirm your stay, please complete payment via bank transfer or cash as per the instructions below, and share proof of payment with our reservations team.
                        </p>
                        <div style="margin:0 0 12px 0;padding:12px 14px;border-radius:12px;border:1px solid rgba(245,242,234,0.14);background-color:rgba(255,255,255,0.02);">
                            <p style="margin:0 0 6px 0;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(245,242,234,0.7);">Bank Transfer</p>
                            <p style="margin:0 0 6px 0;font-size:13px;">We currently accept bank transfer payments. Please contact our team for up-to-date bank details:</p>
                            <ul style="margin:0;padding-left:18px;font-size:13px;">
                                <li>Email: <span style="font-weight:500;">reservations@pianupecave.com</span></li>
                                <li>Phone / WhatsApp: <span style="font-weight:500;">+256 777 643084</span></li>
                                <li>Please include your booking reference <span style="font-family:ui-monospace,Menlo,Monaco,Consolas,'Liberation Mono','Courier New',monospace;">{{ $booking->reference }}</span> as the payment reference.</li>
                            </ul>
                        </div>
                        <div style="margin:0 0 12px 0;padding:12px 14px;border-radius:12px;border:1px solid rgba(245,242,234,0.14);background-color:rgba(255,255,255,0.02);">
                            <p style="margin:0 0 6px 0;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(245,242,234,0.7);">Cash on Arrival</p>
                            <p style="margin:0;font-size:13px;">
                                For certain stays, it may be possible to settle your invoice in cash on arrival in Karamoja. Please coordinate this directly with our team in advance so we can confirm arrangements.
                            </p>
                        </div>
                        <p style="margin:0 0 8px 0;font-size:12px;color:rgba(245,242,234,0.7);">
                            You can also view this invoice online here:
                            <a href="{{ route('booking.pay', ['booking' => $booking->reference]) }}" style="color:#e5e1d3;text-decoration:underline;">View booking invoice</a>.
                        </p>
                        <p style="margin:0;font-size:12px;color:rgba(245,242,234,0.7);">
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
