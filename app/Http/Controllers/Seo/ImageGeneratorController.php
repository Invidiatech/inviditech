<?php
namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;

class ImageGeneratorController extends Controller
{
    public function index()
    {
        return view('imagegenerator.index');
    }
}
