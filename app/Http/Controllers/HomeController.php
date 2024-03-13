<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response {
        $urls = Url::orderBy('created_at', 'desc')->get();
        return Inertia::render('Home', [
            'boom' => microtime(),
            'urls' => $urls,
            'good' => session('good')
        ]);
    }
}
