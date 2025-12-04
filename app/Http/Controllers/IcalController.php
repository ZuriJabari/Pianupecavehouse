<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Eluceo\iCal\Domain\Entity\Calendar as ICalCalendar;
use Eluceo\iCal\Domain\Entity\Event as ICalEvent;
use Eluceo\iCal\Domain\ValueObject\Date as ICalDate;
use Eluceo\iCal\Domain\ValueObject\MultiDay;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Illuminate\Http\Response;

class IcalController extends Controller
{
	public function property(Property $property): Response
	{
		$bookings = $property->bookings()
			->where('status', 'confirmed')
			->orderBy('check_in')
			->get();

		$events = [];
		foreach ($bookings as $booking) {
			if (! $booking->check_in || ! $booking->check_out) {
				continue;
			}

			$first = new ICalDate($booking->check_in);
			$last = new ICalDate($booking->check_out->copy()->subDay());
			$occurrence = new MultiDay($first, $last);

			$event = (new ICalEvent())
				->setSummary('Pian Upe Cave House Booking ' . $booking->reference)
				->setDescription('Guest ' . $booking->guest_name . ' · ' . ($booking->guests_adults + $booking->guests_children) . ' guests')
				->setOccurrence($occurrence);

			$events[] = $event;
		}

		$calendar = new ICalCalendar($events);
		$calendar->setProductIdentifier('-//PianUpeCave//Bookings//EN');

		$factory = new CalendarFactory();
		$component = $factory->createCalendar($calendar);

		$content = (string) $component;

		return response($content, 200)
			->header('Content-Type', 'text/calendar; charset=utf-8')
			->header('Content-Disposition', 'attachment; filename="pianupecave-' . $property->id . '.ics"');
	}
}
