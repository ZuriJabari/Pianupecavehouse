<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class BookingPageController extends Controller
{
    public function index()
    {
        $property = Property::where('is_primary', true)->first();
        
        return view('booking', [
            'property' => $property,
        ]);
    }
}
