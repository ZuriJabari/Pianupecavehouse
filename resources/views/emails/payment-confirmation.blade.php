<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #181716;
        }
        .header h1 {
            color: #181716;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
            font-size: 14px;
        }
        .success-badge {
            background-color: #10b981;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-align: center;
            margin: 20px 0;
            font-weight: 600;
            font-size: 16px;
        }
        .info-section {
            margin: 25px 0;
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 6px;
        }
        .info-section h2 {
            color: #181716;
            font-size: 18px;
            margin: 0 0 15px;
            font-weight: 600;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #6b7280;
            font-weight: 500;
        }
        .info-value {
            color: #181716;
            font-weight: 600;
            text-align: right;
        }
        .total-row {
            background-color: #181716;
            color: #f5f2ea;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
        }
        .total-row .info-label,
        .total-row .info-value {
            color: #f5f2ea;
        }
        .message {
            margin: 25px 0;
            padding: 20px;
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 4px;
        }
        .message p {
            margin: 0;
            color: #92400e;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .footer a {
            color: #181716;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pian Upe Cave House</h1>
            <p>Payment Confirmation</p>
        </div>

        <div class="success-badge">
            ✓ Payment Received
        </div>

        <p>Dear {{ $booking->guest_name }},</p>

        <p>We are pleased to confirm that we have received your payment for your upcoming stay at Pian Upe Cave House.</p>

        <div class="info-section">
            <h2>Payment Details</h2>
            <div class="info-row">
                <span class="info-label">Payment Reference</span>
                <span class="info-value">{{ $payment->provider_payment_id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Method</span>
                <span class="info-value">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Date</span>
                <span class="info-value">{{ $payment->paid_at ? $payment->paid_at->format('F j, Y') : now()->format('F j, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Amount Paid</span>
                <span class="info-value">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</span>
            </div>
        </div>

        <div class="info-section">
            <h2>Booking Details</h2>
            <div class="info-row">
                <span class="info-label">Booking Reference</span>
                <span class="info-value">{{ $booking->reference }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Check-in</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('F j, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Check-out</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('F j, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Guests</span>
                <span class="info-value">{{ $booking->guests }} {{ Str::plural('guest', $booking->guests) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Rooms</span>
                <span class="info-value">{{ $booking->rooms }} {{ Str::plural('room', $booking->rooms) }}</span>
            </div>
        </div>

        <div class="total-row">
            <div class="info-row">
                <span class="info-label">Total Amount</span>
                <span class="info-value">{{ $booking->currency }} {{ number_format($booking->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="message">
            <p><strong>Your booking is now fully confirmed!</strong> We look forward to welcoming you to Pian Upe Cave House.</p>
        </div>

        <p>If you have any questions about your booking or payment, please don't hesitate to contact us.</p>

        <div class="footer">
            <p>
                <strong>Pian Upe Cave House</strong><br>
                Pian Upe Game Reserve, Eastern Uganda<br>
                Email: <a href="mailto:reservations@pianupecave.com">reservations@pianupecave.com</a><br>
                Phone: +256 (0) 761 311 772<br>
                WhatsApp: +256 777 643084
            </p>
        </div>
    </div>
</body>
</html>
