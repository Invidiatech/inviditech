<?php
 namespace App\Http\Controllers;

 use App\Models\Category;
 use App\Http\Requests\CategoryRequest;
 use Illuminate\Http\Request;
 use Illuminate\Support\Str;
 use Illuminate\Support\Facades\Storage;
 
 class CategoryController extends Controller
 {
     public function __construct()
     {
         $this->middleware('auth')->except(['index', 'show']);
         $this->middleware('admin')->except(['index', 'show']);
     }
     
     public function index()
     {
         $featuredCategories = Category::featured()
             ->orderBy('sort_order')
             ->get();
             
         $categories = Category::where('is_featured', false)
             ->orderBy('name')
             ->get();
             
         return view('categories.index', compact('featuredCategories', 'categories'));
     }
     
     public function show($slug)
     {
         $category = Category::where('slug', $slug)->firstOrFail();
         
         $articles = $category->articles()
             ->with(['user', 'tags'])
             ->published()
             ->orderBy('published_at', 'desc')
             ->paginate(10);
             
         return view('categories.show', compact('category', 'articles'));
     }
     
     public function create()
     {
         return view('categories.create');
     }
     
     public function store(CategoryRequest $request)
     {
         $data = $request->validated();
         
         // Handle slug
         $data['slug'] = Str::slug($data['name']);
         
         // Handle image
         if ($request->hasFile('image')) {
             $data['image'] = $request->file('image')
                 ->store('categories', 'public');
         }
         
         Category::create($data);
         
         return redirect()->route('categories.index')
             ->with('success', 'Category created successfully!');
     }
     
 }
