<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Slide;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', 1)->orderBy('id', 'desc')->get();
        return view('home.slides', compact('slides'));
    }
}
