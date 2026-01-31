<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seo\SeoBlog;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LaravelBasicsBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create Laravel category
        $laravelCategory = Category::firstOrCreate(
            ['slug' => 'laravel'],
            [
                'name' => 'Laravel',
                'description' => 'Laravel framework tutorials and guides',
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        // Get first admin/user
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ]);
        }

        // Create tags for Laravel basics
        $tags = [
            'Laravel Basics',
            'PHP',
            'Web Development',
            'Laravel Tutorial',
            'Beginner Guide',
            'MVC',
            'Eloquent ORM',
            'Routing',
            'Blade Templates',
            'Migrations',
        ];

        $tagModels = [];
        foreach ($tags as $tagName) {
            $tagModels[] = Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                [
                    'name' => $tagName,
                    'meta_title' => $tagName,
                    'meta_description' => "Articles about {$tagName}",
                ]
            );
        }

        // Blog posts data
        $posts = [
            [
                'title' => 'Getting Started with Laravel: A Complete Beginner\'s Guide',
                'excerpt' => 'Learn the fundamentals of Laravel framework, including installation, project setup, and basic concepts. Perfect for developers new to Laravel.',
                'content' => $this->getPost1Content(),
                'featured_image' => 'images/blog/laravel-getting-started.jpg',
                'focus_keyword' => 'Laravel beginner guide',
                'tags' => ['Laravel Basics', 'PHP', 'Web Development', 'Laravel Tutorial', 'Beginner Guide'],
            ],
            [
                'title' => 'Understanding Laravel Routing: Complete Guide with Examples',
                'excerpt' => 'Master Laravel routing with this comprehensive guide. Learn about basic routes, route parameters, named routes, route groups, and route model binding.',
                'content' => $this->getPost2Content(),
                'featured_image' => 'images/blog/laravel-routing.jpg',
                'focus_keyword' => 'Laravel routing',
                'tags' => ['Laravel Basics', 'Routing', 'Web Development', 'Laravel Tutorial'],
            ],
            [
                'title' => 'Laravel MVC Architecture Explained: Models, Views, and Controllers',
                'excerpt' => 'Deep dive into Laravel\'s MVC architecture. Understand how Models, Views, and Controllers work together to create powerful web applications.',
                'content' => $this->getPost3Content(),
                'featured_image' => 'images/blog/laravel-mvc.jpg',
                'focus_keyword' => 'Laravel MVC architecture',
                'tags' => ['Laravel Basics', 'MVC', 'Web Development', 'Laravel Tutorial'],
            ],
            [
                'title' => 'Laravel Blade Templates: A Complete Guide for Beginners',
                'excerpt' => 'Learn how to use Laravel\'s powerful Blade templating engine. Master template inheritance, components, directives, and best practices.',
                'content' => $this->getPost4Content(),
                'featured_image' => 'images/blog/laravel-blade.jpg',
                'focus_keyword' => 'Laravel Blade templates',
                'tags' => ['Laravel Basics', 'Blade Templates', 'Laravel Tutorial', 'Beginner Guide'],
            ],
            [
                'title' => 'Working with Laravel Eloquent ORM: Database Made Easy',
                'excerpt' => 'Discover Laravel\'s elegant Eloquent ORM. Learn how to interact with databases using intuitive PHP syntax and powerful query building.',
                'content' => $this->getPost5Content(),
                'featured_image' => 'images/blog/laravel-eloquent.jpg',
                'focus_keyword' => 'Laravel Eloquent ORM',
                'tags' => ['Laravel Basics', 'Eloquent ORM', 'Laravel Tutorial', 'Beginner Guide'],
            ],
            [
                'title' => 'Laravel Migrations and Database Schema: Complete Guide',
                'excerpt' => 'Learn how to manage your database schema with Laravel migrations. Create, modify, and rollback database changes with confidence.',
                'content' => $this->getPost6Content(),
                'featured_image' => 'images/blog/laravel-migrations.jpg',
                'focus_keyword' => 'Laravel migrations',
                'tags' => ['Laravel Basics', 'Migrations', 'Laravel Tutorial', 'Beginner Guide'],
            ],
            [
                'title' => 'Laravel Controllers: From Basics to Advanced Techniques',
                'excerpt' => 'Master Laravel controllers with this comprehensive guide. Learn about basic controllers, resource controllers, middleware, and dependency injection.',
                'content' => $this->getPost7Content(),
                'featured_image' => 'images/blog/laravel-controllers.jpg',
                'focus_keyword' => 'Laravel controllers',
                'tags' => ['Laravel Basics', 'Laravel Tutorial', 'MVC', 'Web Development'],
            ],
            [
                'title' => 'Laravel Request Validation: Ensuring Data Integrity',
                'excerpt' => 'Learn how to validate user input in Laravel. Explore validation rules, custom error messages, form requests, and validation best practices.',
                'content' => $this->getPost8Content(),
                'featured_image' => 'images/blog/laravel-validation.jpg',
                'focus_keyword' => 'Laravel validation',
                'tags' => ['Laravel Basics', 'Laravel Tutorial', 'Web Development', 'Beginner Guide'],
            ],
            [
                'title' => 'Laravel Relationships: Connecting Your Database Models',
                'excerpt' => 'Understand Laravel\'s powerful relationship system. Learn about one-to-one, one-to-many, many-to-many, and polymorphic relationships.',
                'content' => $this->getPost9Content(),
                'featured_image' => 'images/blog/laravel-relationships.jpg',
                'focus_keyword' => 'Laravel relationships',
                'tags' => ['Laravel Basics', 'Eloquent ORM', 'Laravel Tutorial', 'Beginner Guide'],
            ],
            [
                'title' => 'Laravel Middleware: Building Powerful Request Filters',
                'excerpt' => 'Discover Laravel middleware and how to use it to filter HTTP requests. Learn about creating custom middleware, route middleware, and global middleware.',
                'content' => $this->getPost10Content(),
                'featured_image' => 'images/blog/laravel-middleware.jpg',
                'focus_keyword' => 'Laravel middleware',
                'tags' => ['Laravel Basics', 'Laravel Tutorial', 'Web Development', 'Beginner Guide'],
            ],
        ];

        // Create blog posts
        foreach ($posts as $index => $postData) {
            $slug = Str::slug($postData['title']);
            
            // Calculate reading time based on content length
            $wordCount = str_word_count(strip_tags($postData['content']));
            $readingTime = ceil($wordCount / 225); // Average reading speed

            // Create the blog post
            $blog = SeoBlog::create([
                'title' => $postData['title'],
                'slug' => $slug,
                'meta_title' => $postData['title'],
                'meta_description' => $postData['excerpt'],
                'meta_keywords' => implode(', ', $postData['tags']),
                'content' => $postData['content'],
                'excerpt' => $postData['excerpt'],
                'is_indexed' => true,
                'is_featured' => $index < 3, // First 3 posts are featured
                'featured_image' => $postData['featured_image'],
                'featured_image_alt' => $postData['title'],
                'status' => 'published',
                'publish_date' => Carbon::now()->subDays(10 - $index),
                'canonical_url' => url('/blog/' . $slug),
                'og_title' => $postData['title'],
                'og_description' => $postData['excerpt'],
                'og_image' => $postData['featured_image'],
                'twitter_title' => $postData['title'],
                'twitter_description' => $postData['excerpt'],
                'twitter_image' => $postData['featured_image'],
                'schema_markup' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'BlogPosting',
                    'headline' => $postData['title'],
                    'description' => $postData['excerpt'],
                    'author' => [
                        '@type' => 'Person',
                        'name' => $user->name,
                    ],
                    'datePublished' => Carbon::now()->subDays(10 - $index)->toIso8601String(),
                ],
                'created_by' => $user->id,
                'category' => $laravelCategory->id,
                'seo_score' => rand(75, 95),
                'focus_keyword' => $postData['focus_keyword'],
                'readability_score' => rand(70, 85),
                'reading_time' => $readingTime,
                'views_count' => rand(100, 1000),
            ]);

            // Attach tags
            $postTags = [];
            foreach ($postData['tags'] as $tagName) {
                $tag = collect($tagModels)->firstWhere('name', $tagName);
                if ($tag) {
                    $postTags[] = $tag->id;
                }
            }
            $blog->tags()->attach($postTags);

            $this->command->info("Created blog post: {$postData['title']}");
        }

        $this->command->info('Laravel basics blog posts seeded successfully!');
    }

    private function getPost1Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>Introduction to Laravel</h2>
    <p>Laravel is a powerful, elegant PHP framework designed for building modern web applications. Created by Taylor Otwell in 2011, it has become one of the most popular PHP frameworks worldwide, known for its expressive syntax, robust features, and developer-friendly approach.</p>

    <h2>Why Choose Laravel?</h2>
    <p>Laravel stands out among PHP frameworks for several compelling reasons:</p>
    <ul>
        <li><strong>Elegant Syntax:</strong> Laravel's clean, expressive syntax makes coding enjoyable and productive</li>
        <li><strong>MVC Architecture:</strong> Built on the Model-View-Controller pattern for organized code</li>
        <li><strong>Eloquent ORM:</strong> Beautiful database interaction using intuitive PHP syntax</li>
        <li><strong>Blade Templating:</strong> Powerful yet simple templating engine</li>
        <li><strong>Built-in Tools:</strong> Authentication, caching, sessions, and more out of the box</li>
        <li><strong>Large Community:</strong> Extensive documentation and active community support</li>
    </ul>

    <h2>Prerequisites</h2>
    <p>Before diving into Laravel, you should have basic knowledge of:</p>
    <ul>
        <li>PHP fundamentals (variables, functions, classes, OOP concepts)</li>
        <li>HTML, CSS, and JavaScript basics</li>
        <li>Database concepts (SQL, tables, relationships)</li>
        <li>Command line basics</li>
    </ul>

    <h2>System Requirements</h2>
    <p>To run Laravel, your system needs:</p>
    <ul>
        <li>PHP >= 8.1</li>
        <li>Composer (PHP dependency manager)</li>
        <li>Database (MySQL, PostgreSQL, SQLite, or SQL Server)</li>
        <li>Node.js and NPM (for front-end assets)</li>
    </ul>

    <h2>Installing Laravel</h2>
    <p>There are multiple ways to install Laravel. The most common method is using Composer:</p>

    <h3>Method 1: Via Composer</h3>
    <pre><code>composer create-project laravel/laravel example-app
cd example-app
php artisan serve</code></pre>

    <h3>Method 2: Via Laravel Installer</h3>
    <pre><code>composer global require laravel/installer
laravel new example-app
cd example-app
php artisan serve</code></pre>

    <h2>Project Structure Overview</h2>
    <p>Understanding Laravel's directory structure is crucial:</p>
    <ul>
        <li><strong>app/</strong> - Contains your application's core code (Models, Controllers, Middleware)</li>
        <li><strong>bootstrap/</strong> - Framework bootstrap files</li>
        <li><strong>config/</strong> - Configuration files</li>
        <li><strong>database/</strong> - Migrations, seeders, and factories</li>
        <li><strong>public/</strong> - Publicly accessible files (index.php, assets)</li>
        <li><strong>resources/</strong> - Views, raw assets (CSS, JS)</li>
        <li><strong>routes/</strong> - Application routes</li>
        <li><strong>storage/</strong> - Logs, compiled views, file uploads</li>
        <li><strong>tests/</strong> - Automated tests</li>
        <li><strong>vendor/</strong> - Composer dependencies</li>
    </ul>

    <h2>Environment Configuration</h2>
    <p>Laravel uses environment variables stored in the <code>.env</code> file. Key configurations include:</p>
    <pre><code>APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=</code></pre>

    <h2>Your First Route</h2>
    <p>Let's create a simple "Hello World" route. Open <code>routes/web.php</code>:</p>
    <pre><code>Route::get('/hello', function () {
    return 'Hello, Laravel!';
});</code></pre>

    <h2>Artisan Command Line Tool</h2>
    <p>Laravel's Artisan CLI is incredibly powerful. Common commands:</p>
    <ul>
        <li><code>php artisan serve</code> - Start development server</li>
        <li><code>php artisan make:controller</code> - Create a controller</li>
        <li><code>php artisan make:model</code> - Create a model</li>
        <li><code>php artisan migrate</code> - Run database migrations</li>
        <li><code>php artisan tinker</code> - Open interactive shell</li>
    </ul>

    <h2>Creating Your First Controller</h2>
    <pre><code>php artisan make:controller WelcomeController</code></pre>
    <p>This creates a controller in <code>app/Http/Controllers/WelcomeController.php</code>:</p>
    <pre><code>namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}</code></pre>

    <h2>Best Practices for Beginners</h2>
    <ul>
        <li>Follow Laravel's naming conventions</li>
        <li>Use Artisan commands to generate files</li>
        <li>Keep controllers thin, models fat</li>
        <li>Always validate user input</li>
        <li>Use environment variables for sensitive data</li>
        <li>Read the official documentation regularly</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Laravel provides an excellent foundation for building modern web applications. With its elegant syntax, powerful features, and extensive ecosystem, you're well-equipped to create amazing projects. In the next tutorials, we'll dive deeper into specific Laravel features like routing, controllers, models, and more.</p>

    <h2>Next Steps</h2>
    <ul>
        <li>Explore Laravel's official documentation at <a href="https://laravel.com/docs" target="_blank">laravel.com/docs</a></li>
        <li>Watch Laravel tutorials on Laracasts</li>
        <li>Build a simple CRUD application</li>
        <li>Join the Laravel community on forums and Discord</li>
    </ul>
</div>
HTML;
    }

    private function getPost2Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>Introduction to Laravel Routing</h2>
    <p>Routing is the foundation of any Laravel application. It's how you define which URLs your application responds to and what code should handle those requests. Laravel makes routing incredibly simple yet powerful.</p>

    <h2>Basic Routing</h2>
    <p>All routes are defined in the <code>routes</code> directory. For web applications, you'll primarily work with <code>routes/web.php</code>.</p>

    <h3>Simple GET Route</h3>
    <pre><code>Route::get('/welcome', function () {
    return 'Welcome to Laravel!';
});</code></pre>

    <h3>Available Router Methods</h3>
    <p>Laravel supports all HTTP verbs:</p>
    <pre><code>Route::get($uri, $callback);
Route::post($uri, $callback);
Route::put($uri, $callback);
Route::patch($uri, $callback);
Route::delete($uri, $callback);
Route::options($uri, $callback);</code></pre>

    <h3>Multiple HTTP Methods</h3>
    <pre><code>Route::match(['get', 'post'], '/form', function () {
    // Handle GET or POST
});

Route::any('/any-method', function () {
    // Handle any HTTP verb
});</code></pre>

    <h2>Route Parameters</h2>
    <p>You can capture segments of the URI within your route:</p>

    <h3>Required Parameters</h3>
    <pre><code>Route::get('/user/{id}', function ($id) {
    return "User ID: " . $id;
});

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return "Post: {$postId}, Comment: {$commentId}";
});</code></pre>

    <h3>Optional Parameters</h3>
    <pre><code>Route::get('/user/{name?}', function ($name = 'Guest') {
    return "Hello, " . $name;
});</code></pre>

    <h3>Regular Expression Constraints</h3>
    <pre><code>Route::get('/user/{id}', function ($id) {
    return "User ID: " . $id;
})->where('id', '[0-9]+');

Route::get('/user/{name}', function ($name) {
    return "User: " . $name;
})->where('name', '[A-Za-z]+');

// Multiple constraints
Route::get('/post/{id}/{slug}', function ($id, $slug) {
    //
})->where(['id' => '[0-9]+', 'slug' => '[a-z-]+']);</code></pre>

    <h2>Named Routes</h2>
    <p>Named routes allow you to conveniently generate URLs or redirects. They're incredibly useful for maintaining your application:</p>

    <pre><code>Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Generating URLs using named routes
$url = route('dashboard');

// Generating redirects
return redirect()->route('dashboard');</code></pre>

    <h3>Named Routes with Parameters</h3>
    <pre><code>Route::get('/user/{id}/profile', function ($id) {
    //
})->name('user.profile');

// Generate URL
$url = route('user.profile', ['id' => 1]);
// Output: /user/1/profile</code></pre>

    <h2>Route Groups</h2>
    <p>Route groups allow you to share attributes across multiple routes:</p>

    <h3>Middleware Groups</h3>
    <pre><code>Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // Requires authentication
    });
    
    Route::get('/profile', function () {
        // Requires authentication
    });
});</code></pre>

    <h3>Prefix Groups</h3>
    <pre><code>Route::prefix('admin')->group(function () {
    Route::get('/users', function () {
        // Matches /admin/users
    });
    
    Route::get('/posts', function () {
        // Matches /admin/posts
    });
});</code></pre>

    <h3>Name Prefix</h3>
    <pre><code>Route::name('admin.')->group(function () {
    Route::get('/users', function () {
        // Route named "admin.users"
    })->name('users');
    
    Route::get('/posts', function () {
        // Route named "admin.posts"
    })->name('posts');
});</code></pre>

    <h3>Combined Group Attributes</h3>
    <pre><code>Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            // URL: /admin/dashboard
            // Name: admin.dashboard
            // Middleware: auth
        })->name('dashboard');
    });</code></pre>

    <h2>Route Model Binding</h2>
    <p>Laravel automatically injects model instances into your routes based on their ID:</p>

    <h3>Implicit Binding</h3>
    <pre><code>use App\Models\User;

Route::get('/users/{user}', function (User $user) {
    return $user->email;
});</code></pre>

    <h3>Custom Key Binding</h3>
    <pre><code>Route::get('/posts/{post:slug}', function (Post $post) {
    return $post;
});</code></pre>

    <h2>Controller Routes</h2>
    <p>Instead of closures, you typically route to controller methods:</p>

    <pre><code>use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);</code></pre>

    <h2>Resource Routes</h2>
    <p>Laravel's resource routes assign the typical CRUD routes to a controller with a single line:</p>

    <pre><code>Route::resource('photos', PhotoController::class);</code></pre>

    <p>This single line creates multiple routes:</p>
    <table>
        <tr><th>Verb</th><th>URI</th><th>Action</th><th>Route Name</th></tr>
        <tr><td>GET</td><td>/photos</td><td>index</td><td>photos.index</td></tr>
        <tr><td>GET</td><td>/photos/create</td><td>create</td><td>photos.create</td></tr>
        <tr><td>POST</td><td>/photos</td><td>store</td><td>photos.store</td></tr>
        <tr><td>GET</td><td>/photos/{photo}</td><td>show</td><td>photos.show</td></tr>
        <tr><td>GET</td><td>/photos/{photo}/edit</td><td>edit</td><td>photos.edit</td></tr>
        <tr><td>PUT/PATCH</td><td>/photos/{photo}</td><td>update</td><td>photos.update</td></tr>
        <tr><td>DELETE</td><td>/photos/{photo}</td><td>destroy</td><td>photos.destroy</td></tr>
    </table>

    <h2>Route Caching</h2>
    <p>For production performance, cache your routes:</p>
    <pre><code>php artisan route:cache</code></pre>
    <p>Clear route cache:</p>
    <pre><code>php artisan route:clear</code></pre>

    <h2>Viewing Routes</h2>
    <p>List all registered routes:</p>
    <pre><code>php artisan route:list</code></pre>

    <h2>Best Practices</h2>
    <ul>
        <li>Always use named routes for easier maintenance</li>
        <li>Group related routes together</li>
        <li>Use resource controllers for CRUD operations</li>
        <li>Apply middleware at the route level when possible</li>
        <li>Use route model binding to simplify code</li>
        <li>Cache routes in production for better performance</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Laravel's routing system is both simple for beginners and powerful for advanced applications. Understanding routes is essential as they're the entry point to your application's functionality. Practice creating different types of routes and experiment with the various features to become proficient.</p>
</div>
HTML;
    }

    private function getPost3Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>What is MVC Architecture?</h2>
    <p>MVC (Model-View-Controller) is a software design pattern that separates an application into three interconnected components. Laravel beautifully implements this pattern, making it easy to build scalable and maintainable applications.</p>

    <h2>The Three Components</h2>
    
    <h3>1. Model - The Data Layer</h3>
    <p>Models represent your data and business logic. They interact with the database and define relationships between different data entities.</p>
    
    <h4>What Models Do:</h4>
    <ul>
        <li>Represent database tables</li>
        <li>Define relationships between data</li>
        <li>Handle data validation</li>
        <li>Encapsulate business logic</li>
        <li>Query and manipulate data</li>
    </ul>

    <h4>Example Model:</h4>
    <pre><code>namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];
    
    // Relationship: A post belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relationship: A post has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    // Business logic: Check if post is published
    public function isPublished()
    {
        return $this->published_at !== null 
            && $this->published_at <= now();
    }
}</code></pre>

    <h3>2. View - The Presentation Layer</h3>
    <p>Views are responsible for presenting data to users. In Laravel, views are written using Blade templating engine.</p>

    <h4>What Views Do:</h4>
    <ul>
        <li>Display data to users</li>
        <li>Handle user interface logic</li>
        <li>Render HTML, CSS, and JavaScript</li>
        <li>Show forms for data input</li>
        <li>Present data in a user-friendly format</li>
    </ul>

    <h4>Example View (resources/views/posts/show.blade.php):</h4>
    <pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;{{ $post->title }}&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;article&gt;
        &lt;h1&gt;{{ $post->title }}&lt;/h1&gt;
        &lt;p&gt;By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}&lt;/p&gt;
        &lt;div&gt;
            {!! $post->content !!}
        &lt;/div&gt;
        
        &lt;h2&gt;Comments&lt;/h2&gt;
        @foreach($post->comments as $comment)
            &lt;div&gt;
                &lt;strong&gt;{{ $comment->user->name }}&lt;/strong&gt;
                &lt;p&gt;{{ $comment->content }}&lt;/p&gt;
            &lt;/div&gt;
        @endforeach
    &lt;/article&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>

    <h3>3. Controller - The Logic Layer</h3>
    <p>Controllers handle incoming requests, interact with models, and return views. They act as the intermediary between Models and Views.</p>

    <h4>What Controllers Do:</h4>
    <ul>
        <li>Receive and process HTTP requests</li>
        <li>Call model methods to retrieve/manipulate data</li>
        <li>Pass data to views</li>
        <li>Return responses to the client</li>
        <li>Handle application flow logic</li>
    </ul>

    <h4>Example Controller:</h4>
    <pre><code>namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Display all posts
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);
            
        return view('posts.index', compact('posts'));
    }
    
    // Display a single post
    public function show(Post $post)
    {
        // Load relationships
        $post->load('user', 'comments.user');
        
        return view('posts.show', compact('post'));
    }
    
    // Show form to create new post
    public function create()
    {
        return view('posts.create');
    }
    
    // Store a new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        
        $post = auth()->user()->posts()->create($validated);
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }
}</code></pre>

    <h2>How MVC Components Work Together</h2>
    
    <h3>Request Flow:</h3>
    <ol>
        <li><strong>User Request:</strong> User visits a URL (e.g., /posts/1)</li>
        <li><strong>Route:</strong> Laravel routes the request to the appropriate controller</li>
        <li><strong>Controller:</strong> Controller receives the request and calls the model</li>
        <li><strong>Model:</strong> Model queries the database and returns data</li>
        <li><strong>Controller:</strong> Controller passes data to the view</li>
        <li><strong>View:</strong> View renders the HTML with the data</li>
        <li><strong>Response:</strong> Controller returns the rendered view to the user</li>
    </ol>

    <h2>Complete Example: Blog Post System</h2>

    <h3>Step 1: Create the Model</h3>
    <pre><code>php artisan make:model Post -m</code></pre>

    <h3>Step 2: Define the Migration</h3>
    <pre><code>public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->string('title');
        $table->text('content');
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
    });
}</code></pre>

    <h3>Step 3: Create the Controller</h3>
    <pre><code>php artisan make:controller PostController --resource</code></pre>

    <h3>Step 4: Define Routes</h3>
    <pre><code>Route::resource('posts', PostController::class);</code></pre>

    <h3>Step 5: Create Views</h3>
    <p>Create views in <code>resources/views/posts/</code> directory:</p>
    <ul>
        <li>index.blade.php - List all posts</li>
        <li>show.blade.php - Show single post</li>
        <li>create.blade.php - Create new post form</li>
        <li>edit.blade.php - Edit post form</li>
    </ul>

    <h2>Benefits of MVC in Laravel</h2>
    <ul>
        <li><strong>Separation of Concerns:</strong> Each component has a specific responsibility</li>
        <li><strong>Maintainability:</strong> Easier to update and maintain code</li>
        <li><strong>Reusability:</strong> Components can be reused across the application</li>
        <li><strong>Testability:</strong> Each layer can be tested independently</li>
        <li><strong>Parallel Development:</strong> Different team members can work on different layers</li>
        <li><strong>Scalability:</strong> Easier to scale and add new features</li>
    </ul>

    <h2>Common MVC Mistakes to Avoid</h2>
    <ul>
        <li><strong>Fat Controllers:</strong> Don't put business logic in controllers</li>
        <li><strong>Logic in Views:</strong> Keep complex logic out of Blade templates</li>
        <li><strong>Anemic Models:</strong> Models should contain business logic, not just be data containers</li>
        <li><strong>Direct Database Queries in Controllers:</strong> Use models for database operations</li>
    </ul>

    <h2>MVC Best Practices</h2>
    <ul>
        <li>Keep controllers thin - they should orchestrate, not implement logic</li>
        <li>Put business logic in models or service classes</li>
        <li>Use form request classes for validation</li>
        <li>Implement repository pattern for complex queries</li>
        <li>Use view composers for shared view data</li>
        <li>Follow naming conventions consistently</li>
    </ul>

    <h2>Beyond Basic MVC</h2>
    <p>Laravel extends the basic MVC pattern with additional concepts:</p>
    <ul>
        <li><strong>Service Providers:</strong> Bootstrap application services</li>
        <li><strong>Middleware:</strong> Filter HTTP requests</li>
        <li><strong>Requests:</strong> Encapsulate validation logic</li>
        <li><strong>Resources:</strong> Transform data for API responses</li>
        <li><strong>Events & Listeners:</strong> Decouple application components</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Understanding MVC architecture is fundamental to working with Laravel effectively. The clear separation between Models, Views, and Controllers makes your code more organized, maintainable, and testable. As you build more complex applications, you'll appreciate how this pattern helps manage complexity and promotes clean code.</p>
</div>
HTML;
    }

    private function getPost4Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>Introduction to Blade Templates</h2>
    <p>Blade is Laravel's powerful, elegant templating engine. Unlike other PHP templating engines, Blade doesn't restrict you from using plain PHP in your views. However, it provides convenient shortcuts that make your views cleaner and more maintainable.</p>

    <h2>Why Use Blade?</h2>
    <ul>
        <li>Clean, readable syntax</li>
        <li>Template inheritance and sections</li>
        <li>Compiled and cached for performance</li>
        <li>Powerful control structures</li>
        <li>Component-based architecture</li>
        <li>No performance overhead - compiles to plain PHP</li>
    </ul>

    <h2>Blade Basics</h2>

    <h3>Displaying Data</h3>
    <p>Use double curly braces to echo data. Blade automatically escapes output to prevent XSS attacks:</p>
    <pre><code>{{ $name }}
{{ $user->email }}
{{ strtoupper($title) }}</code></pre>

    <h3>Unescaped Data</h3>
    <p>When you need to display HTML content, use <code>{!! !!}</code>:</p>
    <pre><code>{!! $htmlContent !!}</code></pre>

    <h3>Rendering JSON</h3>
    <pre><code>&lt;script&gt;
    var app = @json($array);
&lt;/script&gt;</code></pre>

    <h2>Control Structures</h2>

    <h3>If Statements</h3>
    <pre><code>@if (count($posts) === 1)
    &lt;p&gt;I have one post!&lt;/p&gt;
@elseif (count($posts) > 1)
    &lt;p&gt;I have multiple posts!&lt;/p&gt;
@else
    &lt;p&gt;I don't have any posts!&lt;/p&gt;
@endif</code></pre>

    <h3>Unless Statements</h3>
    <pre><code>@unless (auth()->check())
    &lt;p&gt;You are not signed in.&lt;/p&gt;
@endunless</code></pre>

    <h3>Authentication Directives</h3>
    <pre><code>@auth
    &lt;p&gt;Welcome back!&lt;/p&gt;
@endauth

@guest
    &lt;p&gt;Please login&lt;/p&gt;
@endguest</code></pre>

    <h3>Loops</h3>
    <pre><code>@foreach ($users as $user)
    &lt;p&gt;User: {{ $user->name }}&lt;/p&gt;
@endforeach

@for ($i = 0; $i < 10; $i++)
    &lt;p&gt;Number: {{ $i }}&lt;/p&gt;
@endfor

@while (true)
    &lt;p&gt;I'm looping forever!&lt;/p&gt;
    @break
@endwhile</code></pre>

    <h3>Loop Variable</h3>
    <p>Blade provides a <code>$loop</code> variable inside loops:</p>
    <pre><code>@foreach ($users as $user)
    @if ($loop->first)
        &lt;p&gt;This is the first iteration&lt;/p&gt;
    @endif

    &lt;p&gt;{{ $loop->index }}: {{ $user->name }}&lt;/p&gt;

    @if ($loop->last)
        &lt;p&gt;This is the last iteration&lt;/p&gt;
    @endif
@endforeach</code></pre>

    <h2>Template Inheritance</h2>

    <h3>Defining a Layout</h3>
    <p>Create a master layout (resources/views/layouts/app.blade.php):</p>
    <pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;@yield('title') - My App&lt;/title&gt;
    &lt;link rel="stylesheet" href="{{ asset('css/app.css') }}"&gt;
    @stack('styles')
&lt;/head&gt;
&lt;body&gt;
    &lt;nav&gt;
        @include('layouts.navigation')
    &lt;/nav&gt;

    &lt;main&gt;
        @yield('content')
    &lt;/main&gt;

    &lt;footer&gt;
        @include('layouts.footer')
    &lt;/footer&gt;

    @stack('scripts')
&lt;/body&gt;
&lt;/html&gt;</code></pre>

    <h3>Extending a Layout</h3>
    <pre><code>@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    &lt;h1&gt;Welcome to my website&lt;/h1&gt;
    &lt;p&gt;This is the content section&lt;/p&gt;
@endsection

@push('scripts')
    &lt;script src="{{ asset('js/custom.js') }}"&gt;&lt;/script&gt;
@endpush</code></pre>

    <h2>Including Sub-Views</h2>

    <h3>Basic Include</h3>
    <pre><code>@include('partials.alert')</code></pre>

    <h3>Include with Data</h3>
    <pre><code>@include('partials.user-card', ['user' => $user])</code></pre>

    <h3>Conditional Include</h3>
    <pre><code>@includeIf('partials.sidebar')
@includeWhen($showSidebar, 'partials.sidebar')
@includeUnless($hideHeader, 'partials.header')</code></pre>

    <h2>Blade Components</h2>

    <h3>Creating a Component</h3>
    <pre><code>php artisan make:component Alert</code></pre>

    <h3>Component Class (app/View/Components/Alert.php):</h3>
    <pre><code>namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;

    public function __construct($type = 'info', $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function render()
    {
        return view('components.alert');
    }
}</code></pre>

    <h3>Component View (resources/views/components/alert.blade.php):</h3>
    <pre><code>&lt;div class="alert alert-{{ $type }}"&gt;
    {{ $message }}
&lt;/div&gt;</code></pre>

    <h3>Using the Component</h3>
    <pre><code>&lt;x-alert type="success" message="Operation successful!" /&gt;

&lt;x-alert type="danger"&gt;
    &lt;strong&gt;Error!&lt;/strong&gt; Something went wrong.
&lt;/x-alert&gt;</code></pre>

    <h2>Slots</h2>
    <p>Components can accept content through slots:</p>

    <h3>Component with Slots:</h3>
    <pre><code>&lt;!-- resources/views/components/card.blade.php --&gt;
&lt;div class="card"&gt;
    &lt;div class="card-header"&gt;
        {{ $header }}
    &lt;/div&gt;
    &lt;div class="card-body"&gt;
        {{ $slot }}
    &lt;/div&gt;
    @isset($footer)
        &lt;div class="card-footer"&gt;
            {{ $footer }}
        &lt;/div&gt;
    @endisset
&lt;/div&gt;</code></pre>

    <h3>Using the Component:</h3>
    <pre><code>&lt;x-card&gt;
    &lt;x-slot name="header"&gt;
        Card Title
    &lt;/x-slot&gt;

    This is the card body content.

    &lt;x-slot name="footer"&gt;
        Card Footer
    &lt;/x-slot&gt;
&lt;/x-card&gt;</code></pre>

    <h2>Useful Blade Directives</h2>

    <h3>CSRF Protection</h3>
    <pre><code>&lt;form method="POST" action="/profile"&gt;
    @csrf
    &lt;!-- Form fields --&gt;
&lt;/form&gt;</code></pre>

    <h3>Method Spoofing</h3>
    <pre><code>&lt;form method="POST" action="/profile"&gt;
    @csrf
    @method('PUT')
    &lt;!-- Form fields --&gt;
&lt;/form&gt;</code></pre>

    <h3>Validation Errors</h3>
    <pre><code>@error('email')
    &lt;div class="error"&gt;{{ $message }}&lt;/div&gt;
@enderror

@if ($errors->any())
    &lt;div class="alert alert-danger"&gt;
        &lt;ul&gt;
            @foreach ($errors->all() as $error)
                &lt;li&gt;{{ $error }}&lt;/li&gt;
            @endforeach
        &lt;/ul&gt;
    &lt;/div&gt;
@endif</code></pre>

    <h3>Session Data</h3>
    <pre><code>@if (session('status'))
    &lt;div class="alert alert-success"&gt;
        {{ session('status') }}
    &lt;/div&gt;
@endif</code></pre>

    <h2>Raw PHP</h2>
    <p>You can use raw PHP in Blade when needed:</p>
    <pre><code>@php
    $counter = 0;
    $total = count($items);
@endphp</code></pre>

    <h2>Custom Blade Directives</h2>
    <p>Create custom directives in a service provider:</p>
    <pre><code>// In AppServiceProvider
use Illuminate\Support\Facades\Blade;

public function boot()
{
    Blade::directive('datetime', function ($expression) {
        return "&lt;?php echo ($expression)->format('m/d/Y H:i'); ?&gt;";
    });
}

// Usage
@datetime($post->created_at)</code></pre>

    <h2>Best Practices</h2>
    <ul>
        <li>Always use <code>{{ }}</code> for displaying user input to prevent XSS</li>
        <li>Keep logic out of views - use controllers or view composers</li>
        <li>Use components for reusable UI elements</li>
        <li>Organize views in subdirectories by feature</li>
        <li>Use layouts for consistent page structure</li>
        <li>Leverage Blade directives instead of raw PHP when possible</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Blade templating engine makes creating dynamic, maintainable views a breeze. Its intuitive syntax, powerful features like components and inheritance, and excellent performance make it one of Laravel's standout features. Practice using different Blade directives and components to build clean, reusable view templates.</p>
</div>
HTML;
    }

    private function getPost5Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>Introduction to Eloquent ORM</h2>
    <p>Eloquent is Laravel's powerful Object-Relational Mapper (ORM) that makes it incredibly easy to interact with your database. Instead of writing raw SQL queries, you work with intuitive PHP objects and methods.</p>

    <h2>Why Eloquent?</h2>
    <ul>
        <li>Beautiful, expressive syntax</li>
        <li>Active Record implementation</li>
        <li>Built-in relationship handling</li>
        <li>Query builder integration</li>
        <li>Automatic timestamps</li>
        <li>Soft deletes support</li>
        <li>Model events and observers</li>
    </ul>

    <h2>Creating Models</h2>

    <h3>Generate a Model</h3>
    <pre><code>php artisan make:model Post

// With migration
php artisan make:model Post -m

// With migration, factory, and seeder
php artisan make:model Post -mfs

// With everything (migration, factory, seeder, controller, policy, requests)
php artisan make:model Post --all</code></pre>

    <h3>Basic Model Structure</h3>
    <pre><code>namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Table name (optional if following convention)
    protected $table = 'posts';

    // Primary key (optional if 'id')
    protected $primaryKey = 'id';

    // Disable timestamps
    public $timestamps = false;

    // Mass assignable attributes
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'published_at'
    ];

    // Guarded attributes (opposite of fillable)
    protected $guarded = ['id'];

    // Hidden attributes (for JSON)
    protected $hidden = ['password'];

    // Cast attributes to native types
    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'metadata' => 'array'
    ];
}</code></pre>

    <h2>Basic CRUD Operations</h2>

    <h3>Create (Insert)</h3>
    <pre><code>// Method 1: Create and save
$post = new Post;
$post->title = 'My First Post';
$post->content = 'This is the content';
$post->save();

// Method 2: Mass assignment
$post = Post::create([
    'title' => 'My First Post',
    'content' => 'This is the content',
    'user_id' => 1
]);

// First or Create
$post = Post::firstOrCreate(
    ['title' => 'My Post'],
    ['content' => 'Default content']
);

// Update or Create
$post = Post::updateOrCreate(
    ['title' => 'My Post'],
    ['content' => 'Updated content']
);</code></pre>

    <h3>Read (Retrieve)</h3>
    <pre><code>// Get all records
$posts = Post::all();

// Find by primary key
$post = Post::find(1);

// Find or fail (throws exception if not found)
$post = Post::findOrFail(1);

// Find multiple by primary keys
$posts = Post::find([1, 2, 3]);

// Get first record
$post = Post::first();

// Where clauses
$posts = Post::where('user_id', 1)->get();
$posts = Post::where('views', '>', 100)->get();
$posts = Post::where('status', 'published')
             ->where('is_featured', true)
             ->get();

// Order and limit
$posts = Post::orderBy('created_at', 'desc')
             ->take(10)
             ->get();

// Pagination
$posts = Post::paginate(15);
$posts = Post::simplePaginate(15);</code></pre>

    <h3>Update</h3>
    <pre><code>// Method 1: Find and update
$post = Post::find(1);
$post->title = 'Updated Title';
$post->save();

// Method 2: Direct update
Post::where('id', 1)->update([
    'title' => 'Updated Title'
]);

// Mass update
Post::where('user_id', 1)->update([
    'status' => 'published'
]);

// Increment/Decrement
$post->increment('views');
$post->increment('views', 10);
$post->decrement('likes');</code></pre>

    <h3>Delete</h3>
    <pre><code>// Find and delete
$post = Post::find(1);
$post->delete();

// Delete by primary key
Post::destroy(1);
Post::destroy([1, 2, 3]);

// Delete with conditions
Post::where('views', '<', 10)->delete();</code></pre>

    <h2>Query Scopes</h2>

    <h3>Local Scopes</h3>
    <pre><code>// In your model
class Post extends Model
{
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePopular($query, $threshold = 100)
    {
        return $query->where('views', '>', $threshold);
    }
}

// Usage
$posts = Post::published()->get();
$posts = Post::published()->featured()->get();
$posts = Post::popular(500)->get();</code></pre>

    <h3>Global Scopes</h3>
    <pre><code>// Create a scope class
namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PublishedScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('status', 'published');
    }
}

// Apply in model
protected static function booted()
{
    static::addGlobalScope(new PublishedScope);
}</code></pre>

    <h2>Accessors and Mutators</h2>

    <h3>Accessors (Get)</h3>
    <pre><code>class User extends Model
{
    // Laravel 9+ syntax
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
        );
    }

    // Or older syntax
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    // Virtual attribute
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

// Usage
echo $user->name; // Automatically capitalized
echo $user->full_name; // Virtual attribute</code></pre>

    <h3>Mutators (Set)</h3>
    <pre><code>class User extends Model
{
    // Laravel 9+ syntax
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value),
        );
    }

    // Or older syntax
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}

// Usage
$user->password = 'secret'; // Automatically hashed</code></pre>

    <h2>Collections</h2>
    <p>Eloquent returns collections which have powerful methods:</p>
    <pre><code>$posts = Post::all();

// Filter
$published = $posts->where('status', 'published');

// Map
$titles = $posts->map(function ($post) {
    return $post->title;
});

// Pluck
$titles = $posts->pluck('title');
$keyedTitles = $posts->pluck('title', 'id');

// Group
$grouped = $posts->groupBy('category_id');

// Sort
$sorted = $posts->sortBy('created_at');
$sorted = $posts->sortByDesc('views');

// Filter and chain
$result = $posts
    ->where('is_featured', true)
    ->sortByDesc('views')
    ->take(5);

// Check if empty
if ($posts->isEmpty()) {
    // No posts found
}

// Count
$count = $posts->count();

// First and last
$first = $posts->first();
$last = $posts->last();</code></pre>

    <h2>Eager Loading</h2>
    <p>Prevent N+1 query problems:</p>
    <pre><code>// Without eager loading (N+1 problem)
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->user->name; // Queries for each post
}

// With eager loading (2 queries total)
$posts = Post::with('user')->get();
foreach ($posts as $post) {
    echo $post->user->name;
}

// Multiple relationships
$posts = Post::with(['user', 'comments', 'tags'])->get();

// Nested relationships
$posts = Post::with('comments.user')->get();

// Conditional eager loading
$posts = Post::with(['comments' => function ($query) {
    $query->where('approved', true);
}])->get();</code></pre>

    <h2>Soft Deletes</h2>
    <pre><code>use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
}

// Delete (soft delete)
$post->delete();

// Include soft deleted
$posts = Post::withTrashed()->get();

// Only soft deleted
$posts = Post::onlyTrashed()->get();

// Restore
$post->restore();

// Force delete (permanent)
$post->forceDelete();</code></pre>

    <h2>Best Practices</h2>
    <ul>
        <li>Use mass assignment protection (fillable or guarded)</li>
        <li>Always eager load relationships to avoid N+1 queries</li>
        <li>Use scopes for reusable query logic</li>
        <li>Cast attributes to appropriate types</li>
        <li>Use accessors/mutators for data transformation</li>
        <li>Implement soft deletes when you might need to recover data</li>
        <li>Use pagination for large datasets</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Eloquent ORM is one of Laravel's most powerful features. Its intuitive syntax and rich feature set make database interactions a joy. Practice using Eloquent for CRUD operations, learn about relationships in the next tutorial, and you'll be building database-driven applications efficiently.</p>
</div>
HTML;
    }

    private function getPost6Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>Introduction to Migrations</h2>
    <p>Database migrations are like version control for your database. They allow you to define and share your database schema with your team. With migrations, you can easily modify your database structure and roll back changes if needed.</p>

    <h2>Why Use Migrations?</h2>
    <ul>
        <li>Version control for your database schema</li>
        <li>Easy collaboration with team members</li>
        <li>Consistent database structure across environments</li>
        <li>Ability to rollback changes</li>
        <li>Database agnostic (works with MySQL, PostgreSQL, SQLite, etc.)</li>
        <li>No need to share SQL files</li>
    </ul>

    <h2>Creating Migrations</h2>

    <h3>Generate a Migration</h3>
    <pre><code>// Create a new table
php artisan make:migration create_posts_table

// Add columns to existing table
php artisan make:migration add_status_to_posts_table

// Create with model
php artisan make:model Post -m</code></pre>

    <h3>Migration File Structure</h3>
    <pre><code>use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};</code></pre>

    <h2>Creating Tables</h2>
    <pre><code>Schema::create('posts', function (Blueprint $table) {
    $table->id(); // Auto-incrementing primary key
    $table->string('title');
    $table->text('content');
    $table->foreignId('user_id')->constrained();
    $table->string('status')->default('draft');
    $table->boolean('is_published')->default(false);
    $table->timestamp('published_at')->nullable();
    $table->timestamps(); // created_at and updated_at
    $table->softDeletes(); // deleted_at for soft deletes
});</code></pre>

    <h2>Column Types</h2>

    <h3>String and Text</h3>
    <pre><code>$table->string('name'); // VARCHAR(255)
$table->string('name', 100); // VARCHAR(100)
$table->text('description'); // TEXT
$table->mediumText('content'); // MEDIUMTEXT
$table->longText('content'); // LONGTEXT</code></pre>

    <h3>Numeric</h3>
    <pre><code>$table->integer('votes'); // INTEGER
$table->tinyInteger('level'); // TINYINT
$table->smallInteger('votes'); // SMALLINT
$table->mediumInteger('votes'); // MEDIUMINT
$table->bigInteger('votes'); // BIGINT

$table->decimal('amount', 8, 2); // DECIMAL(8,2)
$table->float('amount', 8, 2); // FLOAT
$table->double('amount', 8, 2); // DOUBLE</code></pre>

    <h3>Date and Time</h3>
    <pre><code>$table->date('created_date'); // DATE
$table->dateTime('created_at'); // DATETIME
$table->time('sunrise'); // TIME
$table->timestamp('added_on'); // TIMESTAMP
$table->timestamps(); // created_at and updated_at
$table->softDeletes(); // deleted_at</code></pre>

    <h3>Boolean and JSON</h3>
    <pre><code>$table->boolean('is_active'); // BOOLEAN
$table->json('options'); // JSON
$table->jsonb('options'); // JSONB (PostgreSQL)</code></pre>

    <h3>Special Types</h3>
    <pre><code>$table->id(); // Auto-incrementing BIGINT
$table->uuid('id'); // UUID
$table->enum('status', ['pending', 'active', 'inactive']);
$table->ipAddress('visitor'); // IP address
$table->macAddress('device'); // MAC address</code></pre>

    <h2>Column Modifiers</h2>
    <pre><code>$table->string('email')->nullable(); // Allow NULL
$table->string('name')->default('Guest'); // Default value
$table->integer('votes')->unsigned(); // Unsigned integer
$table->string('status')->after('name'); // Position after column
$table->string('name')->unique(); // Unique constraint
$table->text('description')->comment('Post description'); // Add comment
$table->integer('votes')->default(0)->unsigned();</code></pre>

    <h2>Foreign Keys</h2>

    <h3>Modern Syntax</h3>
    <pre><code>// Create foreign key column and constraint
$table->foreignId('user_id')->constrained();

// With custom table name
$table->foreignId('user_id')->constrained('users');

// With cascade delete
$table->foreignId('user_id')
      ->constrained()
      ->onDelete('cascade');

// With cascade update
$table->foreignId('user_id')
      ->constrained()
      ->onUpdate('cascade')
      ->onDelete('cascade');</code></pre>

    <h3>Traditional Syntax</h3>
    <pre><code>$table->unsignedBigInteger('user_id');
$table->foreign('user_id')
      ->references('id')
      ->on('users')
      ->onDelete('cascade');</code></pre>

    <h2>Indexes</h2>
    <pre><code>// Primary key
$table->primary('id');

// Unique index
$table->unique('email');

// Regular index
$table->index('user_id');

// Composite index
$table->index(['user_id', 'created_at']);

// Drop index
$table->dropIndex('posts_user_id_index');

// Spatial index
$table->spatialIndex('location');</code></pre>

    <h2>Modifying Tables</h2>

    <h3>Adding Columns</h3>
    <pre><code>Schema::table('posts', function (Blueprint $table) {
    $table->string('slug')->after('title');
    $table->text('excerpt')->nullable();
});</code></pre>

    <h3>Modifying Columns</h3>
    <pre><code>Schema::table('posts', function (Blueprint $table) {
    $table->string('title', 200)->change();
    $table->text('content')->nullable()->change();
});</code></pre>

    <h3>Renaming Columns</h3>
    <pre><code>Schema::table('posts', function (Blueprint $table) {
    $table->renameColumn('content', 'body');
});</code></pre>

    <h3>Dropping Columns</h3>
    <pre><code>Schema::table('posts', function (Blueprint $table) {
    $table->dropColumn('excerpt');
    $table->dropColumn(['excerpt', 'slug']); // Multiple
});</code></pre>

    <h2>Running Migrations</h2>

    <h3>Basic Commands</h3>
    <pre><code>// Run all pending migrations
php artisan migrate

// Rollback last batch
php artisan migrate:rollback

// Rollback specific steps
php artisan migrate:rollback --step=2

// Reset all migrations
php artisan migrate:reset

// Rollback and re-run all
php artisan migrate:refresh

// Drop all tables and re-run
php artisan migrate:fresh

// Show migration status
php artisan migrate:status</code></pre>

    <h2>Migration Best Practices</h2>

    <h3>Complete Example</h3>
    <pre><code>// Creating posts table
public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        // Primary key
        $table->id();
        
        // Foreign keys
        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');
        $table->foreignId('category_id')
              ->nullable()
              ->constrained()
              ->onDelete('set null');
        
        // Regular columns
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('excerpt')->nullable();
        $table->longText('content');
        
        // Status and flags
        $table->enum('status', ['draft', 'published', 'archived'])
              ->default('draft');
        $table->boolean('is_featured')->default(false);
        $table->boolean('allow_comments')->default(true);
        
        // Metadata
        $table->integer('views_count')->default(0);
        $table->timestamp('published_at')->nullable();
        
        // Timestamps and soft deletes
        $table->timestamps();
        $table->softDeletes();
        
        // Indexes
        $table->index('status');
        $table->index('published_at');
        $table->index(['user_id', 'status']);
    });
}

public function down(): void
{
    Schema::dropIfExists('posts');
}</code></pre>

    <h2>Advanced Techniques</h2>

    <h3>Checking if Table/Column Exists</h3>
    <pre><code>if (Schema::hasTable('posts')) {
    // Table exists
}

if (Schema::hasColumn('posts', 'email')) {
    // Column exists
}</code></pre>

    <h3>Temporary Tables</h3>
    <pre><code>Schema::create('temp_posts', function (Blueprint $table) {
    $table->temporary();
    $table->id();
    $table->string('name');
});</code></pre>

    <h3>Raw SQL in Migrations</h3>
    <pre><code>DB::statement('ALTER TABLE posts ADD FULLTEXT search(title, content)');
DB::unprepared('CREATE TRIGGER ...');</code></pre>

    <h2>Common Migration Patterns</h2>

    <h3>Pivot Table for Many-to-Many</h3>
    <pre><code>Schema::create('post_tag', function (Blueprint $table) {
    $table->id();
    $table->foreignId('post_id')->constrained()->onDelete('cascade');
    $table->foreignId('tag_id')->constrained()->onDelete('cascade');
    $table->timestamps();
    
    $table->unique(['post_id', 'tag_id']);
});</code></pre>

    <h3>Polymorphic Relations</h3>
    <pre><code>Schema::create('images', function (Blueprint $table) {
    $table->id();
    $table->string('url');
    $table->morphs('imageable'); // Creates imageable_id and imageable_type
    $table->timestamps();
});</code></pre>

    <h2>Tips and Best Practices</h2>
    <ul>
        <li>Never modify committed migrations - create new ones instead</li>
        <li>Always provide a down() method for rollback</li>
        <li>Use descriptive migration names</li>
        <li>Add appropriate indexes for frequently queried columns</li>
        <li>Use foreign keys to maintain referential integrity</li>
        <li>Test migrations in development before production</li>
        <li>Back up production database before running migrations</li>
        <li>Use migration squashing for old migrations</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Laravel migrations provide a powerful way to manage your database schema. They make it easy to collaborate with your team, maintain consistency across environments, and track changes over time. Practice creating migrations for different scenarios, and you'll find managing your database structure becomes much easier.</p>
</div>
HTML;
    }

    private function getPost7Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>Introduction to Controllers</h2>
    <p>Controllers are the "C" in MVC architecture. They handle incoming HTTP requests, interact with models to retrieve or manipulate data, and return responses to users. Controllers help organize your application logic and keep your routes file clean.</p>

    <h2>Why Use Controllers?</h2>
    <ul>
        <li>Organize related request handling logic</li>
        <li>Keep route definitions clean and simple</li>
        <li>Reusable and testable code</li>
        <li>Separation of concerns</li>
        <li>Middleware integration</li>
        <li>Dependency injection support</li>
    </ul>

    <h2>Creating Controllers</h2>

    <h3>Basic Controller</h3>
    <pre><code>php artisan make:controller PostController</code></pre>

    <h3>Resource Controller</h3>
    <pre><code>php artisan make:controller PostController --resource</code></pre>

    <h3>API Resource Controller</h3>
    <pre><code>php artisan make:controller PostController --api</code></pre>

    <h3>Controller with Model</h3>
    <pre><code>php artisan make:controller PostController --model=Post</code></pre>

    <h2>Basic Controller Structure</h2>
    <pre><code>namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Display a specific post.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Store a new post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::create($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }
}</code></pre>

    <h2>Routing to Controllers</h2>

    <h3>Basic Routing</h3>
    <pre><code>use App\Http\Controllers\PostController;

// Single action
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store']);

// Named routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');</code></pre>

    <h3>Resource Routing</h3>
    <pre><code>Route::resource('posts', PostController::class);</code></pre>

    <p>This creates all CRUD routes automatically:</p>
    <table>
        <tr><th>Verb</th><th>URI</th><th>Action</th><th>Route Name</th></tr>
        <tr><td>GET</td><td>/posts</td><td>index</td><td>posts.index</td></tr>
        <tr><td>GET</td><td>/posts/create</td><td>create</td><td>posts.create</td></tr>
        <tr><td>POST</td><td>/posts</td><td>store</td><td>posts.store</td></tr>
        <tr><td>GET</td><td>/posts/{post}</td><td>show</td><td>posts.show</td></tr>
        <tr><td>GET</td><td>/posts/{post}/edit</td><td>edit</td><td>posts.edit</td></tr>
        <tr><td>PUT/PATCH</td><td>/posts/{post}</td><td>update</td><td>posts.update</td></tr>
        <tr><td>DELETE</td><td>/posts/{post}</td><td>destroy</td><td>posts.destroy</td></tr>
    </table>

    <h3>Partial Resource Routes</h3>
    <pre><code>// Only specific actions
Route::resource('posts', PostController::class)->only([
    'index', 'show'
]);

// Exclude specific actions
Route::resource('posts', PostController::class)->except([
    'create', 'store', 'destroy'
]);</code></pre>

    <h2>Resource Controller Methods</h2>

    <h3>Complete Resource Controller</h3>
    <pre><code>namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(15);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = auth()->user()->posts()->create($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('user', 'comments');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}</code></pre>

    <h2>Dependency Injection</h2>
    <p>Laravel automatically resolves dependencies in controller methods:</p>

    <h3>Type-Hinting Request</h3>
    <pre><code>public function store(Request $request)
{
    $name = $request->input('name');
    $email = $request->email;
}</code></pre>

    <h3>Form Requests</h3>
    <pre><code>use App\Http\Requests\StorePostRequest;

public function store(StorePostRequest $request)
{
    // Validation passed
    $validated = $request->validated();
    $post = Post::create($validated);
}</code></pre>

    <h3>Service Injection</h3>
    <pre><code>use App\Services\PostService;

public function store(Request $request, PostService $postService)
{
    $post = $postService->createPost($request->all());
    return redirect()->route('posts.show', $post);
}</code></pre>

    <h2>Controller Middleware</h2>

    <h3>In Constructor</h3>
    <pre><code>class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified')->only('create', 'store');
        $this->middleware('throttle:60,1')->only('store');
    }
}</code></pre>

    <h3>In Routes</h3>
    <pre><code>Route::resource('posts', PostController::class)
    ->middleware(['auth', 'verified']);</code></pre>

    <h2>Single Action Controllers</h2>
    <p>For controllers handling only one action:</p>
    <pre><code>namespace App\Http\Controllers;

use App\Models\Post;

class ShowPostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}

// Generate
php artisan make:controller ShowPostController --invokable

// Route
Route::get('/posts/{post}', ShowPostController::class);</code></pre>

    <h2>Returning Responses</h2>

    <h3>View Responses</h3>
    <pre><code>return view('posts.index', ['posts' => $posts]);
return view('posts.show', compact('post'));
return view('posts.index')->with('posts', $posts);</code></pre>

    <h3>Redirect Responses</h3>
    <pre><code>return redirect('/posts');
return redirect()->route('posts.index');
return redirect()->route('posts.show', $post);
return redirect()->back();
return redirect()->back()->withInput();

// With flash data
return redirect()->route('posts.index')
    ->with('success', 'Post created!');</code></pre>

    <h3>JSON Responses</h3>
    <pre><code>return response()->json(['success' => true]);
return response()->json($post, 201);

// Error response
return response()->json([
    'error' => 'Not found'
], 404);</code></pre>

    <h3>Download Responses</h3>
    <pre><code>return response()->download($pathToFile);
return response()->download($pathToFile, $name, $headers);</code></pre>

    <h2>API Controllers</h2>
    <pre><code>namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(15);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::create($validated);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|max:255',
            'content' => 'sometimes|required',
        ]);

        $post->update($validated);

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}</code></pre>

    <h2>Best Practices</h2>
    <ul>
        <li>Keep controllers thin - delegate business logic to models or services</li>
        <li>Use form request classes for validation</li>
        <li>Use resource controllers for CRUD operations</li>
        <li>Apply middleware for authentication and authorization</li>
        <li>Type-hint dependencies for automatic injection</li>
        <li>Return appropriate response types</li>
        <li>Use route model binding to simplify code</li>
        <li>Group related controllers in subdirectories</li>
        <li>Use single action controllers for simple actions</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Controllers are essential for organizing your application logic in Laravel. By understanding how to create and structure controllers effectively, you can build maintainable and scalable applications. Practice creating different types of controllers and explore Laravel's powerful features like resource routing and dependency injection.</p>
</div>
HTML;
    }

    private function getPost8Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>Introduction to Laravel Validation</h2>
    <p>Validation is crucial for any web application. Laravel provides a powerful and convenient validation system that makes it easy to validate incoming data. Whether you're building forms, APIs, or processing user input, Laravel's validation helps ensure data integrity and security.</p>

    <h2>Why Validate?</h2>
    <ul>
        <li>Ensure data integrity</li>
        <li>Prevent security vulnerabilities</li>
        <li>Provide user-friendly error messages</li>
        <li>Maintain database consistency</li>
        <li>Reduce bugs and unexpected behavior</li>
    </ul>

    <h2>Basic Validation</h2>

    <h3>In Controllers</h3>
    <pre><code>public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'age' => 'required|integer|min:18',
    ]);

    // Validation passed, use $validated data
    User::create($validated);
}</code></pre>

    <h3>Array Syntax</h3>
    <pre><code>$validated = $request->validate([
    'title' => ['required', 'max:255'],
    'email' => ['required', 'email', 'unique:users'],
    'password' => ['required', 'min:8', 'confirmed'],
]);</code></pre>

    <h2>Common Validation Rules</h2>

    <h3>Required and Presence Rules</h3>
    <pre><code>'field' => 'required',           // Must be present and not empty
'field' => 'required_if:other,value',  // Required if other field equals value
'field' => 'required_unless:other,value', // Required unless other field equals value
'field' => 'required_with:other',      // Required if other field is present
'field' => 'required_without:other',   // Required if other field is not present
'field' => 'nullable',                 // Can be null
'field' => 'present',                  // Must be present but can be empty</code></pre>

    <h3>String Validation</h3>
    <pre><code>'name' => 'string',              // Must be a string
'name' => 'min:3',               // Minimum 3 characters
'name' => 'max:255',             // Maximum 255 characters
'name' => 'size:10',             // Exactly 10 characters
'name' => 'alpha',               // Only alphabetic characters
'name' => 'alpha_num',           // Only alphanumeric characters
'name' => 'alpha_dash',          // Alpha-numeric, dashes, and underscores
'email' => 'email',              // Valid email format
'url' => 'url',                  // Valid URL
'username' => 'regex:/^[a-z0-9_-]{3,16}$/', // Custom regex</code></pre>

    <h3>Numeric Validation</h3>
    <pre><code>'age' => 'integer',              // Must be integer
'age' => 'numeric',              // Must be numeric (int or float)
'price' => 'decimal:2',          // Decimal with 2 places
'quantity' => 'min:1',           // Minimum value 1
'quantity' => 'max:100',         // Maximum value 100
'quantity' => 'between:1,100',   // Between 1 and 100
'score' => 'digits:4',           // Exactly 4 digits
'score' => 'digits_between:3,5', // Between 3 and 5 digits</code></pre>

    <h3>Date Validation</h3>
    <pre><code>'birthdate' => 'date',           // Valid date
'birthdate' => 'date_format:Y-m-d', // Specific format
'start_date' => 'after:tomorrow', // After tomorrow
'start_date' => 'after_or_equal:today', // Today or after
'end_date' => 'before:2025-12-31', // Before specific date
'end_date' => 'after:start_date', // After another field</code></pre>

    <h3>File Validation</h3>
    <pre><code>'photo' => 'file',               // Must be a file
'photo' => 'image',              // Must be an image
'photo' => 'mimes:jpeg,png,jpg', // Specific MIME types
'photo' => 'mimetypes:image/jpeg,image/png',
'photo' => 'max:2048',           // Max size in kilobytes (2MB)
'photo' => 'dimensions:min_width=100,min_height=100',
'photo' => 'dimensions:ratio=3/2', // Image ratio</code></pre>

    <h3>Database Rules</h3>
    <pre><code>'email' => 'unique:users',       // Must be unique in users table
'email' => 'unique:users,email', // Specify column
'email' => 'unique:users,email,123', // Ignore ID 123
'email' => 'unique:users,email,123,id', // Specify ID column
'email' => 'exists:users',       // Must exist in users table
'role' => 'in:admin,editor,user', // Must be one of these values
'status' => 'not_in:pending,cancelled', // Cannot be these values</code></pre>

    <h2>Custom Error Messages</h2>

    <h3>Inline Messages</h3>
    <pre><code>$validated = $request->validate([
    'title' => 'required|max:255',
    'email' => 'required|email',
], [
    'title.required' => 'Please enter a title for your post.',
    'title.max' => 'The title is too long!',
    'email.required' => 'We need your email address!',
    'email.email' => 'Please enter a valid email address.',
]);</code></pre>

    <h3>Custom Attribute Names</h3>
    <pre><code>$validated = $request->validate([
    'title' => 'required',
], [], [
    'title' => 'post title',
]);

// Error message: "The post title field is required."</code></pre>

    <h2>Form Request Validation</h2>

    <h3>Create Form Request</h3>
    <pre><code>php artisan make:request StorePostRequest</code></pre>

    <h3>Form Request Class</h3>
    <pre><code>namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Or implement authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A post title is required',
            'content.required' => 'Post content cannot be empty',
        ];
    }

    /**
     * Get custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'category_id' => 'category',
            'published_at' => 'publication date',
        ];
    }
}</code></pre>

    <h3>Using Form Requests</h3>
    <pre><code>use App\Http\Requests\StorePostRequest;

public function store(StorePostRequest $request)
{
    // Validation automatically done
    $validated = $request->validated();
    
    $post = Post::create($validated);
    
    return redirect()->route('posts.show', $post);
}</code></pre>

    <h2>Displaying Validation Errors</h2>

    <h3>In Blade Templates</h3>
    <pre><code>@if ($errors->any())
    &lt;div class="alert alert-danger"&gt;
        &lt;ul&gt;
            @foreach ($errors->all() as $error)
                &lt;li&gt;{{ $error }}&lt;/li&gt;
            @endforeach
        &lt;/ul&gt;
    &lt;/div&gt;
@endif

&lt;!-- Specific field errors --&gt;
@error('title')
    &lt;div class="error"&gt;{{ $message }}&lt;/div&gt;
@enderror

&lt;!-- In form fields --&gt;
&lt;input type="text" name="title" value="{{ old('title') }}"&gt;
@error('title')
    &lt;span class="text-danger"&gt;{{ $message }}&lt;/span&gt;
@enderror</code></pre>

    <h2>Validating Arrays</h2>
    <pre><code>// Array validation
$validated = $request->validate([
    'photos' => 'required|array|min:1|max:5',
    'photos.*' => 'required|image|max:2048',
]);

// Nested arrays
$validated = $request->validate([
    'users.*.name' => 'required|string',
    'users.*.email' => 'required|email|unique:users',
]);</code></pre>

    <h2>Conditional Rules</h2>
    <pre><code>use Illuminate\Validation\Rule;

$validated = $request->validate([
    'email' => [
        'required',
        'email',
        Rule::unique('users')->ignore($user->id),
    ],
    'role' => [
        'required',
        Rule::in(['admin', 'editor', 'user']),
    ],
]);</code></pre>

    <h2>Custom Validation Rules</h2>

    <h3>Closure Rules</h3>
    <pre><code>use Illuminate\Validation\Rule;

$validated = $request->validate([
    'username' => [
        'required',
        function ($attribute, $value, $fail) {
            if (strtolower($value) === 'admin') {
                $fail('The username cannot be "admin".');
            }
        },
    ],
]);</code></pre>

    <h3>Rule Objects</h3>
    <pre><code>php artisan make:rule Uppercase

// App\Rules\Uppercase.php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Uppercase implements Rule
{
    public function passes($attribute, $value)
    {
        return strtoupper($value) === $value;
    }

    public function message()
    {
        return 'The :attribute must be uppercase.';
    }
}

// Usage
use App\Rules\Uppercase;

$validated = $request->validate([
    'name' => ['required', new Uppercase],
]);</code></pre>

    <h2>After Validation Hooks</h2>
    <pre><code>$validator = Validator::make($request->all(), [
    'title' => 'required',
]);

$validator->after(function ($validator) {
    if ($this->somethingElseIsInvalid()) {
        $validator->errors()->add('field', 'Something is wrong!');
    }
});

if ($validator->fails()) {
    return redirect()->back()->withErrors($validator);
}</code></pre>

    <h2>Best Practices</h2>
    <ul>
        <li>Use Form Request classes for complex validation</li>
        <li>Always validate user input</li>
        <li>Provide clear, user-friendly error messages</li>
        <li>Use the old() helper to repopulate form fields</li>
        <li>Validate on both client and server side</li>
        <li>Use database rules (unique, exists) appropriately</li>
        <li>Create custom rules for reusable validation logic</li>
        <li>Keep validation rules in one place</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Laravel's validation system is powerful and flexible. By properly validating user input, you protect your application from invalid data and security vulnerabilities. Practice using different validation rules and techniques, and always prioritize data validation in your applications.</p>
</div>
HTML;
    }

    private function getPost9Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>Introduction to Eloquent Relationships</h2>
    <p>Eloquent relationships allow you to define how your database tables are connected. Laravel makes it incredibly easy to work with related data through intuitive methods that feel natural in PHP. Understanding relationships is crucial for building complex applications.</p>

    <h2>Types of Relationships</h2>
    <ul>
        <li>One to One</li>
        <li>One to Many</li>
        <li>Many to Many</li>
        <li>Has One Through</li>
        <li>Has Many Through</li>
        <li>Polymorphic Relationships</li>
    </ul>

    <h2>One to One Relationship</h2>
    <p>A one-to-one relationship is when one record relates to exactly one other record.</p>

    <h3>Example: User has one Profile</h3>
    <pre><code>// User Model
class User extends Model
{
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}

// Profile Model
class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// Migration
Schema::create('profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('bio');
    $table->string('website')->nullable();
    $table->timestamps();
});

// Usage
$user = User::find(1);
$bio = $user->profile->bio;

$profile = Profile::find(1);
$userName = $profile->user->name;</code></pre>

    <h2>One to Many Relationship</h2>
    <p>A one-to-many relationship is when one record can have multiple related records.</p>

    <h3>Example: User has many Posts</h3>
    <pre><code>// User Model
class User extends Model
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

// Post Model
class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// Migration
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->text('content');
    $table->timestamps();
});

// Usage
$user = User::find(1);
$posts = $user->posts; // Collection of posts

foreach ($user->posts as $post) {
    echo $post->title;
}

// Create related record
$user->posts()->create([
    'title' => 'New Post',
    'content' => 'Post content...',
]);</code></pre>

    <h2>Many to Many Relationship</h2>
    <p>A many-to-many relationship is when multiple records relate to multiple other records. This requires a pivot table.</p>

    <h3>Example: Posts have many Tags, Tags have many Posts</h3>
    <pre><code>// Post Model
class Post extends Model
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

// Tag Model
class Tag extends Model
{
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}

// Migrations
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});

Schema::create('post_tag', function (Blueprint $table) {
    $table->id();
    $table->foreignId('post_id')->constrained()->onDelete('cascade');
    $table->foreignId('tag_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});

// Usage
$post = Post::find(1);
$tags = $post->tags;

$tag = Tag::find(1);
$posts = $tag->posts;

// Attach tags to post
$post->tags()->attach([1, 2, 3]);

// Detach tags
$post->tags()->detach([1, 2]);

// Sync tags (replace all)
$post->tags()->sync([1, 2, 3]);

// Toggle tags
$post->tags()->toggle([1, 2]);</code></pre>

    <h3>Pivot Table Data</h3>
    <pre><code>// Add extra fields to pivot table
Schema::create('post_tag', function (Blueprint $table) {
    $table->id();
    $table->foreignId('post_id')->constrained();
    $table->foreignId('tag_id')->constrained();
    $table->integer('order')->default(0);
    $table->timestamps();
});

// Model
class Post extends Model
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class)
                    ->withPivot('order')
                    ->withTimestamps();
    }
}

// Usage
$post->tags()->attach(1, ['order' => 1]);

foreach ($post->tags as $tag) {
    echo $tag->pivot->order;
    echo $tag->pivot->created_at;
}</code></pre>

    <h2>Has Many Through</h2>
    <p>Access distant relationships through an intermediate model.</p>

    <h3>Example: Country has many Posts through Users</h3>
    <pre><code>// Country Model
class Country extends Model
{
    public function posts()
    {
        return $this->hasManyThrough(
            Post::class,
            User::class,
            'country_id', // Foreign key on users table
            'user_id',    // Foreign key on posts table
            'id',         // Local key on countries table
            'id'          // Local key on users table
        );
    }
}

// Usage
$country = Country::find(1);
$posts = $country->posts; // All posts by users from this country</code></pre>

    <h2>Polymorphic Relationships</h2>
    <p>A model can belong to multiple types of models on a single association.</p>

    <h3>Example: Images for Posts and Users</h3>
    <pre><code>// Image Model
class Image extends Model
{
    public function imageable()
    {
        return $this->morphTo();
    }
}

// Post Model
class Post extends Model
{
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

// User Model
class User extends Model
{
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}

// Migration
Schema::create('images', function (Blueprint $table) {
    $table->id();
    $table->string('url');
    $table->morphs('imageable'); // Creates imageable_id and imageable_type
    $table->timestamps();
});

// Usage
$post = Post::find(1);
$image = $post->image;

$user = User::find(1);
$images = $user->images;

// Create
$post->image()->create(['url' => 'image.jpg']);</code></pre>

    <h3>Many to Many Polymorphic</h3>
    <pre><code>// Tag can be attached to Posts and Videos
class Tag extends Model
{
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function videos()
    {
        return $this->morphedByMany(Video::class, 'taggable');
    }
}

class Post extends Model
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

// Migration
Schema::create('taggables', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tag_id')->constrained();
    $table->morphs('taggable');
    $table->timestamps();
});</code></pre>

    <h2>Querying Relationships</h2>

    <h3>Eager Loading</h3>
    <pre><code>// Load relationships
$posts = Post::with('user')->get();
$posts = Post::with(['user', 'comments'])->get();

// Nested relationships
$posts = Post::with('comments.user')->get();

// Conditional eager loading
$posts = Post::with(['comments' => function ($query) {
    $query->where('approved', true);
}])->get();</code></pre>

    <h3>Lazy Eager Loading</h3>
    <pre><code>$posts = Post::all();

if ($someCondition) {
    $posts->load('user');
}</code></pre>

    <h3>Relationship Existence</h3>
    <pre><code>// Get posts that have comments
$posts = Post::has('comments')->get();

// Get posts with at least 3 comments
$posts = Post::has('comments', '>=', 3)->get();

// Nested has
$posts = Post::has('comments.likes')->get();

// whereHas with conditions
$posts = Post::whereHas('comments', function ($query) {
    $query->where('approved', true);
})->get();</code></pre>

    <h3>Counting Related Models</h3>
    <pre><code>// Count relationships without loading
$posts = Post::withCount('comments')->get();

foreach ($posts as $post) {
    echo $post->comments_count;
}

// Multiple counts
$posts = Post::withCount(['comments', 'likes'])->get();

// Conditional count
$posts = Post::withCount([
    'comments',
    'comments as approved_comments_count' => function ($query) {
        $query->where('approved', true);
    }
])->get();</code></pre>

    <h2>Creating Related Models</h2>

    <h3>Save Method</h3>
    <pre><code>$user = User::find(1);

$post = new Post([
    'title' => 'New Post',
    'content' => 'Content...'
]);

$user->posts()->save($post);</code></pre>

    <h3>Create Method</h3>
    <pre><code>$user->posts()->create([
    'title' => 'New Post',
    'content' => 'Content...'
]);</code></pre>

    <h3>Many to Many</h3>
    <pre><code>$post->tags()->attach([1, 2, 3]);
$post->tags()->detach([2]);
$post->tags()->sync([1, 3, 4]);</code></pre>

    <h2>Updating Parent Timestamps</h2>
    <pre><code>class Comment extends Model
{
    protected $touches = ['post'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

// When comment is saved, post's updated_at is also updated</code></pre>

    <h2>Best Practices</h2>
    <ul>
        <li>Always eager load relationships to avoid N+1 queries</li>
        <li>Use relationship methods for queries (e.g., $user->posts()->where())</li>
        <li>Define inverse relationships for better functionality</li>
        <li>Use appropriate relationship types for your data structure</li>
        <li>Implement foreign key constraints in migrations</li>
        <li>Use withCount() instead of loading all related records when you just need counts</li>
        <li>Consider using polymorphic relationships for flexible associations</li>
        <li>Document complex relationship structures</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Eloquent relationships are powerful tools that make working with related data intuitive and efficient. Understanding how to properly define and query relationships is essential for building complex Laravel applications. Practice creating different types of relationships and learn to leverage eager loading for optimal performance.</p>
</div>
HTML;
    }

    private function getPost10Content(): string
    {
        return <<<'HTML'
<div class="article-content">
    <h2>Introduction to Middleware</h2>
    <p>Middleware provides a convenient mechanism for filtering HTTP requests entering your application. Think of middleware as layers that HTTP requests must pass through before reaching your application. Each layer can examine the request, perform actions, and either pass it along or reject it.</p>

    <h2>What is Middleware?</h2>
    <p>Middleware acts as a bridge between a request and a response. It can be used for:</p>
    <ul>
        <li>Authentication and authorization</li>
        <li>Logging and debugging</li>
        <li>CORS handling</li>
        <li>Input validation and sanitization</li>
        <li>Rate limiting</li>
        <li>Session management</li>
        <li>Response modification</li>
    </ul>

    <h2>Creating Middleware</h2>

    <h3>Generate Middleware</h3>
    <pre><code>php artisan make:middleware CheckAge</code></pre>

    <h3>Basic Middleware Structure</h3>
    <pre><code>namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAge
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->age < 18) {
            return redirect('home');
        }

        return $next($request);
    }
}</code></pre>

    <h2>Before and After Middleware</h2>

    <h3>Before Middleware</h3>
    <p>Runs before the request is handled:</p>
    <pre><code>class BeforeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Perform action before request
        logger('Request received: ' . $request->path());
        
        return $next($request);
    }
}</code></pre>

    <h3>After Middleware</h3>
    <p>Runs after the request is handled:</p>
    <pre><code>class AfterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Perform action after response
        logger('Response sent: ' . $response->status());
        
        return $response;
    }
}</code></pre>

    <h2>Registering Middleware</h2>

    <h3>Global Middleware</h3>
    <p>Runs on every HTTP request. Register in <code>bootstrap/app.php</code>:</p>
    <pre><code>use App\Http\Middleware\CheckAge;

->withMiddleware(function (Middleware $middleware) {
    $middleware->append(CheckAge::class);
})</code></pre>

    <h3>Route Middleware</h3>
    <p>Register in <code>bootstrap/app.php</code>:</p>
    <pre><code>->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'check.age' => \App\Http\Middleware\CheckAge::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})</code></pre>

    <h2>Using Middleware</h2>

    <h3>On Routes</h3>
    <pre><code>// Single middleware
Route::get('/profile', function () {
    //
})->middleware('auth');

// Multiple middleware
Route::get('/admin', function () {
    //
})->middleware(['auth', 'admin']);

// Middleware groups
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        //
    });
    
    Route::get('/settings', function () {
        //
    });
});</code></pre>

    <h3>In Controllers</h3>
    <pre><code>class UserController extends Controller
{
    public function __construct()
    {
        // Apply to all methods
        $this->middleware('auth');
        
        // Apply to specific methods
        $this->middleware('admin')->only(['destroy', 'edit']);
        $this->middleware('log')->except(['index']);
    }
}</code></pre>

    <h2>Middleware Parameters</h2>
    <p>Pass additional parameters to middleware:</p>

    <h3>Middleware with Parameters</h3>
    <pre><code>class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()->hasRole($role)) {
            abort(403);
        }

        return $next($request);
    }
}

// Usage
Route::get('/admin', function () {
    //
})->middleware('role:admin');

Route::get('/editor', function () {
    //
})->middleware('role:editor,publisher');</code></pre>

    <h2>Built-in Middleware</h2>

    <h3>Authentication Middleware</h3>
    <pre><code>Route::get('/dashboard', function () {
    //
})->middleware('auth');</code></pre>

    <h3>Guest Middleware</h3>
    <pre><code>Route::get('/login', function () {
    //
})->middleware('guest');</code></pre>

    <h3>Verified Middleware</h3>
    <pre><code>Route::get('/home', function () {
    //
})->middleware(['auth', 'verified']);</code></pre>

    <h3>Throttle Middleware</h3>
    <pre><code>// 60 requests per minute
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/api/data', function () {
        //
    });
});

// Named rate limiter
Route::middleware(['throttle:api'])->group(function () {
    //
});</code></pre>

    <h2>Practical Middleware Examples</h2>

    <h3>1. Admin Check Middleware</h3>
    <pre><code>class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}</code></pre>

    <h3>2. API Authentication Middleware</h3>
    <pre><code>class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-API-Token');

        if (!$token || !$this->isValidToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    private function isValidToken($token): bool
    {
        return ApiToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->exists();
    }
}</code></pre>

    <h3>3. Force HTTPS Middleware</h3>
    <pre><code>class ForceHttps
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->secure() && app()->environment('production')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}</code></pre>

    <h3>4. Request Logger Middleware</h3>
    <pre><code>class RequestLogger
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $response = $next($request);

        $duration = microtime(true) - $startTime;

        logger()->info('Request processed', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_id' => auth()->id(),
            'status' => $response->status(),
            'duration' => round($duration * 1000, 2) . 'ms',
        ]);

        return $response;
    }
}</code></pre>

    <h3>5. Sanitize Input Middleware</h3>
    <pre><code>class SanitizeInput
{
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$value) {
            $value = strip_tags($value);
        });

        $request->merge($input);

        return $next($request);
    }
}</code></pre>

    <h3>6. CORS Middleware</h3>
    <pre><code>class Cors
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }
}</code></pre>

    <h2>Middleware Groups</h2>
    <p>Laravel includes predefined middleware groups in <code>bootstrap/app.php</code>:</p>

    <h3>Web Middleware Group</h3>
    <ul>
        <li>Session state</li>
        <li>Cookie encryption</li>
        <li>CSRF protection</li>
        <li>View sharing</li>
    </ul>

    <h3>API Middleware Group</h3>
    <ul>
        <li>Rate limiting</li>
        <li>Stateless authentication</li>
    </ul>

    <h2>Terminable Middleware</h2>
    <p>Perform work after the response has been sent to the browser:</p>
    <pre><code>class TerminableMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        // Perform cleanup or logging after response sent
        logger('Response sent to browser');
    }
}</code></pre>

    <h2>Testing Middleware</h2>
    <pre><code>use Tests\TestCase;

class CheckAgeTest extends TestCase
{
    public function test_blocks_underage_users()
    {
        $response = $this->withoutMiddleware()
            ->get('/adult-content');

        $response->assertStatus(200);
    }

    public function test_middleware_redirects_underage()
    {
        $response = $this->get('/adult-content?age=16');

        $response->assertRedirect('/home');
    }
}</code></pre>

    <h2>Best Practices</h2>
    <ul>
        <li>Keep middleware focused on a single responsibility</li>
        <li>Use middleware for cross-cutting concerns</li>
        <li>Order middleware appropriately (authentication before authorization)</li>
        <li>Don't perform heavy operations in middleware</li>
        <li>Use terminable middleware for post-response tasks</li>
        <li>Test middleware thoroughly</li>
        <li>Document middleware parameters clearly</li>
        <li>Use middleware groups for common combinations</li>
    </ul>

    <h2>Conclusion</h2>
    <p>Middleware is a powerful feature in Laravel that helps you filter and modify HTTP requests in a clean, organized way. By understanding how to create and use middleware effectively, you can implement authentication, logging, CORS handling, and many other features that make your application more secure and maintainable.</p>
</div>
HTML;
    }
}
