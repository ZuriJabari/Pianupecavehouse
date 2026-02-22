<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Payment Receipt · Pian Upe Cave House</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;color:#111827;">
@php
	$pricing = $booking->rate_snapshot ?? [];
	$nights = $pricing['nights'] ?? $booking->nights;
	$baseNightly = $pricing['base_nightly'] ?? null;
	$baseTotal = $pricing['base_total'] ?? $booking->total_amount;
	$addOnBreakdown = $pricing['add_on_breakdown'] ?? [];
	$addOnTotal = $pricing['add_on_total'] ?? 0;
	$subtotal = $pricing['subtotal'] ?? $baseTotal;
	$discount = $pricing['discount'] ?? 0;
	$total = $pricing['total'] ?? $booking->total_amount;
	$coupon = $pricing['coupon'] ?? null;
	$currency = $booking->currency;
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
									<div style="font-size:26px;font-weight:700;letter-spacing:0.16em;text-transform:uppercase;color:#111827;">RECEIPT</div>
									<div style="margin-top:8px;font-size:12px;color:#4b5563;">
										<div>Receipt #: <span style="font-family:ui-monospace,Menlo,Monaco,Consolas,'Liberation Mono','Courier New',monospace;">{{ $payment->provider_payment_id }}</span></div>
										<div>Payment date: {{ ($payment->paid_at ?? now())->format('M j, Y') }}</div>
										<div>Currency: {{ $currency }}</div>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<!-- Payment Status Badge -->
				<tr>
					<td style="padding:16px 24px;">
						<div style="display:inline-block;padding:8px 16px;background-color:#10b981;color:#ffffff;border-radius:6px;font-size:13px;font-weight:600;letter-spacing:0.05em;">
							✓ PAYMENT RECEIVED
						</div>
					</td>
				</tr>

				<tr>
					<td style="padding:8px 24px 8px 24px;">
						<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
							<tr>
								<td width="55%" style="vertical-align:top;padding-right:16px;">
									<div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;">Paid by</div>
									<div style="margin-top:6px;font-size:14px;font-weight:600;color:#111827;">{{ $booking->guest_name }}</div>
									@if($booking->guest_email)
										<div style="margin-top:2px;font-size:13px;color:#4b5563;">{{ $booking->guest_email }}</div>
									@endif
									@if($booking->guest_phone)
										<div style="margin-top:2px;font-size:13px;color:#4b5563;">{{ $booking->guest_phone }}</div>
									@endif
								</td>
								<td width="45%" style="vertical-align:top;">
									<div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;">Booking details</div>
									<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:6px;font-size:13px;color:#374151;">
										<tr>
											<td align="left" style="padding:1px 0;">Booking ref</td>
											<td align="right" style="padding:1px 0;font-family:ui-monospace,Menlo,Monaco,Consolas,'Liberation Mono','Courier New',monospace;">{{ $booking->reference }}</td>
										</tr>
										<tr>
											<td align="left" style="padding:1px 0;">Check-in</td>
											<td align="right" style="padding:1px 0;">{{ $booking->check_in->format('M j, Y') }}</td>
										</tr>
										<tr>
											<td align="left" style="padding:1px 0;">Check-out</td>
											<td align="right" style="padding:1px 0;">{{ $booking->check_out->format('M j, Y') }}</td>
										</tr>
										<tr>
											<td align="left" style="padding:1px 0;">Nights</td>
											<td align="right" style="padding:1px 0;">{{ $nights }}</td>
										</tr>
										<tr>
											<td align="left" style="padding:1px 0;">Guests</td>
											<td align="right" style="padding:1px 0;">{{ $booking->guests_adults + $booking->guests_children }}</td>
										</tr>
										@if($booking->rooms_requested)
											<tr>
												<td align="left" style="padding:1px 0;">Rooms</td>
												<td align="right" style="padding:1px 0;">{{ $booking->rooms_requested }}</td>
											</tr>
										@endif
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<!-- Payment Details Section -->
				<tr>
					<td style="padding:16px 24px 8px 24px;">
						<div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px;">Payment details</div>
						<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-size:13px;color:#374151;">
							<tr>
								<td align="left" style="padding:4px 0;">Payment method</td>
								<td align="right" style="padding:4px 0;font-weight:500;">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
							</tr>
							<tr>
								<td align="left" style="padding:4px 0;">Payment reference</td>
								<td align="right" style="padding:4px 0;font-family:ui-monospace,Menlo,Monaco,Consolas,'Liberation Mono','Courier New',monospace;">{{ $payment->provider_payment_id }}</td>
							</tr>
							<tr>
								<td align="left" style="padding:4px 0;">Payment date</td>
								<td align="right" style="padding:4px 0;">{{ ($payment->paid_at ?? now())->format('F j, Y') }}</td>
							</tr>
							@if($payment->notes)
								<tr>
									<td align="left" style="padding:4px 0;vertical-align:top;">Notes</td>
									<td align="right" style="padding:4px 0;">{{ $payment->notes }}</td>
								</tr>
							@endif
						</table>
					</td>
				</tr>

				<tr>
					<td style="padding:8px 24px 8px 24px;">
						<div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px;">Charges</div>
						<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-size:13px;border-collapse:collapse;">
							<thead>
								<tr>
									<th align="left" style="padding:8px 8px;border-bottom:1px solid #e5e7eb;font-weight:600;color:#4b5563;">Description</th>
									<th align="center" style="padding:8px 8px;border-bottom:1px solid #e5e7eb;font-weight:600;color:#4b5563;">Qty</th>
									<th align="right" style="padding:8px 8px;border-bottom:1px solid #e5e7eb;font-weight:600;color:#4b5563;">Amount ({{ $currency }})</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="padding:8px 8px;border-bottom:1px solid #f3f4f6;">Accommodation ({{ $nights }} night{{ $nights === 1 ? '' : 's' }} stay)</td>
									<td align="center" style="padding:8px 8px;border-bottom:1px solid #f3f4f6;">{{ $nights }}</td>
									<td align="right" style="padding:8px 8px;border-bottom:1px solid #f3f4f6;">{{ number_format($baseTotal) }}</td>
								</tr>
								@if($addOnTotal > 0 || !empty($addOnBreakdown))
									@foreach($addOnBreakdown as $key => $amount)
										@php
											$label = $key;
											if ($key === 'airport_transfer') {
												$label = 'Airport transfer';
											} elseif ($key === 'game_drive') {
												$label = 'Game drive';
											} elseif ($key === 'charter_flight_request') {
												$label = 'Charter flight (on request)';
											}
										@endphp
										<tr>
											<td style="padding:8px 8px;border-bottom:1px solid #f3f4f6;">{{ $label }}</td>
											<td align="center" style="padding:8px 8px;border-bottom:1px solid #f3f4f6;">1</td>
											<td align="right" style="padding:8px 8px;border-bottom:1px solid #f3f4f6;">{{ $amount > 0 ? number_format($amount) : 'To be confirmed' }}</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding:4px 24px 12px 24px;">
						<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-size:13px;">
							<tr>
								<td align="right" style="padding:4px 8px;color:#4b5563;">Subtotal</td>
								<td align="right" style="padding:4px 8px;color:#111827;">{{ number_format($subtotal) }} {{ $currency }}</td>
							</tr>
							@if($discount > 0)
								<tr>
									<td align="right" style="padding:4px 8px;color:#4b5563;">
										Discount @if($coupon && !empty($coupon['code'])) ({{ $coupon['code'] }}) @endif
									</td>
									<td align="right" style="padding:4px 8px;color:#16a34a;">-{{ number_format($discount) }} {{ $currency }}</td>
								</tr>
							@endif
							<tr>
								<td align="right" style="padding:8px 8px;font-weight:700;color:#111827;border-top:2px solid #111827;">Amount paid</td>
								<td align="right" style="padding:8px 8px;font-weight:700;color:#111827;border-top:2px solid #111827;">{{ number_format($payment->amount) }} {{ $currency }}</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding:8px 24px 24px 24px;border-top:1px solid #e5e7eb;">
						<div style="padding:16px;background-color:#f0fdf4;border:1px solid #86efac;border-radius:8px;">
							<p style="margin:0 0 8px 0;font-size:14px;font-weight:600;color:#166534;">
								✓ Your booking is confirmed!
							</p>
							<p style="margin:0;font-size:13px;color:#15803d;">
								Thank you for your payment. We look forward to welcoming you to Pian Upe Cave House. If you have any questions about your stay, please don't hesitate to contact us.
							</p>
						</div>
						<p style="margin:16px 0 4px 0;font-size:12px;color:#4b5563;">
							You can view your booking details online:
							<a href="{{ route('booking.pay', ['booking' => $booking->reference]) }}" style="color:#1f2937;text-decoration:underline;">View booking</a>
						</p>
						<p style="margin:0;font-size:12px;color:#6b7280;">
							If you have any questions, please contact us at <span style="font-weight:500;">reservations@pianupecave.com</span> or call/WhatsApp <span style="font-weight:500;">+256 777 643084</span>.
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
