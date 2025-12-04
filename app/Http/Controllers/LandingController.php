<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class LandingController extends Controller
{
	public function index()
	{
		$property = Property::where('slug', 'pian-upe-cave-house')
			->with('rates')
			->first() ?? Property::with('rates')->first();

		$heroVideos = [
			'hero/hero-video1.mp4',
			'hero/hero-video2.mp4',
			'hero/hero-video3.mp4',
		];
		$heroVideo = $heroVideos[array_rand($heroVideos)];

		return view('landing', [
			'property' => $property,
			'heroVideo' => $heroVideo,
		]);
	}
}
