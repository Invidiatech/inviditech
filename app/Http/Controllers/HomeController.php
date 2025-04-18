<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('website.pages.home');
    }
    public function dashboard(){
        return view('admin.layouts.admin');
    }
}
