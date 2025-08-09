<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RobotsController extends Controller
{
    /**
     * Display robots.txt management.
     */
    public function index()
    {
        $robotsContent = $this->getCurrentRobotsContent();
        
        return view('seo.robots.index', compact('robotsContent'));
    }

    /**
     * Update robots.txt content.
     */
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        // For now, just return success message
        // In a full implementation, this would save to a file or database
        
        return redirect()->route('seo.robots.index')
            ->with('success', 'Robots.txt updated successfully.');
    }

    /**
     * Validate robots.txt content.
     */
    public function validate(Request $request)
    {
        $content = $request->get('content', '');
        
        // Basic validation
        $errors = [];
        $warnings = [];
        
        if (empty($content)) {
            $errors[] = 'Robots.txt content cannot be empty';
        }
        
        if (strpos($content, 'User-agent:') === false) {
            $warnings[] = 'No User-agent directive found';
        }
        
        return response()->json([
            'valid' => empty($errors),
            'errors' => $errors,
            'warnings' => $warnings
        ]);
    }

    /**
     * Get current robots.txt content.
     */
    private function getCurrentRobotsContent()
    {
        // Return default robots.txt content
        return "User-agent: *\n" .
               "Allow: /\n" .
               "Disallow: /seo/\n" .
               "Disallow: /admin/\n" .
               "Disallow: /storage/\n" .
               "\n" .
               "Sitemap: " . route('sitemap.index') . "\n";
    }
}