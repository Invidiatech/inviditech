<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    /**
     * Display Google Merchant Center.
     */
    public function index()
    {
        $stats = [
            'products_synced' => 0,
            'last_sync' => null,
            'feed_status' => 'Not Generated'
        ];
        
        return view('seo.merchant.index', compact('stats'));
    }

    /**
     * Sync products to Google Merchant.
     */
    public function syncProducts(Request $request)
    {
        return redirect()->route('seo.merchant.index')
            ->with('success', 'Google Merchant sync feature is under development.');
    }

    /**
     * Generate product feed.
     */
    public function generateFeed()
    {
        return redirect()->route('seo.merchant.index')
            ->with('success', 'Product feed generation feature is under development.');
    }
}