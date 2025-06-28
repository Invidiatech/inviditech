<?php

 namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Models\Seo\SeoPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\SeoAnalyzer;

class PageController extends Controller
{
    protected $seoAnalyzer;

    public function __construct(SeoAnalyzer $seoAnalyzer)
    {
        $this->seoAnalyzer = $seoAnalyzer;
    }

    public function index(Request $request)
    {
        $query = SeoPage::with('creator');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('meta_title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $pages = $query->paginate(15);

        return view('seo.pages.index', compact('pages'));
     }

    public function create()
    {
        return view('seo.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'focus_keyword' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['created_by'] = auth('seo')->id();

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('seo/pages', 'public');
        }

        // Auto-generate meta if not provided
        if (!$data['meta_title']) {
            $data['meta_title'] = $data['title'];
        }

        if (!$data['meta_description']) {
            $data['meta_description'] = Str::limit(strip_tags($data['content']), 155);
        }

        $page = SeoPage::create($data);

        // Calculate SEO score
        $page->seo_score = $this->seoAnalyzer->analyzePage($page);
        $page->readability_score = $this->seoAnalyzer->analyzeReadability($page->content);
        $page->save();

        return redirect()->route('seo.pages.index')->with('success', 'Page created successfully!');
    }

    public function show(SeoPage $page)
    {
        $seoAnalysis = $this->seoAnalyzer->getDetailedAnalysis($page);
        return view('seo.pages.show', compact('page', 'seoAnalysis'));
    }

    public function edit(SeoPage $page)
    {
        return view('seo.pages.edit', compact('page'));
    }

    public function update(Request $request, SeoPage $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'focus_keyword' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('seo/pages', 'public');
        }

        $page->update($data);

        // Recalculate SEO score
        $page->seo_score = $this->seoAnalyzer->analyzePage($page);
        $page->readability_score = $this->seoAnalyzer->analyzeReadability($page->content);
        $page->save();

        return redirect()->route('seo.pages.index')->with('success', 'Page updated successfully!');
    }

    public function destroy(SeoPage $page)
    {
        $page->delete();
        return redirect()->route('seo.pages.index')->with('success', 'Page deleted successfully!');
    }

    public function duplicate(SeoPage $page)
    {
        $newPage = $page->replicate();
        $newPage->title = $page->title . ' (Copy)';
        $newPage->slug = Str::slug($newPage->title) . '-' . time();
        $newPage->status = 'draft';
        $newPage->created_by = auth('seo')->id();
        $newPage->save();

        return redirect()->route('seo.pages.index', $newPage)->with('success', 'Page duplicated successfully!');
    }

    public function updateStatus(Request $request, SeoPage $page)
    {
        $page->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }
}
