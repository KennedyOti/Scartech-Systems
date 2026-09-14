<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Service;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('pages.about', [
            'services' => Service::active()->ordered()->get(),
            'clients' => Client::where('is_featured', true)->ordered()->get(),
        ]);
    }
}
