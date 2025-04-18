<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Simply return the dashboard view without any data
        return view('admin.dashboard');
    }
}