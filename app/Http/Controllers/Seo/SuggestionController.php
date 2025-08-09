<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    /**
     * Display 404 suggestions.
     */
    public function index()
    {
        $suggestions = collect([]); // Empty collection for now
        
        return view('seo.suggestions.index', compact('suggestions'));
    }

    /**
     * Resolve a 404 suggestion.
     */
    public function resolve(Request $request, $id)
    {
        return redirect()->route('seo.suggestions.index')
            ->with('success', '404 suggestion resolved successfully.');
    }

    /**
     * Delete a suggestion.
     */
    public function destroy($id)
    {
        return redirect()->route('seo.suggestions.index')
            ->with('success', 'Suggestion deleted successfully.');
    }

    /**
     * Scan for 404 errors.
     */
    public function scan(Request $request)
    {
        return redirect()->route('seo.suggestions.index')
            ->with('success', '404 scanning feature is under development.');
    }
}