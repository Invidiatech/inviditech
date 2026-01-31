<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeveloperToolsController extends Controller
{
    /**
     * Display the JSON Formatter & Validator tool.
     */
    public function jsonFormatter(): View
    {
        return view('website.tools.json-formatter');
    }

    /**
     * Display the Base64 Encoder/Decoder tool.
     */
    public function base64Tool(): View
    {
        return view('website.tools.base64-tool');
    }
}
