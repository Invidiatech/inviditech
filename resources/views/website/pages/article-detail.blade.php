 
@extends('website.layouts.app')
@section('title', 'Article Detiail - InvidiaTech')
@section('content')    
     <!-- Main Content -->
     <main class="py-5">
        <div class="container">
            <div class="row">
                <!-- Article Tools (Left Sidebar) -->
                <div class="col-lg-1 d-none d-lg-block article-tools-container">
                    <div class="article-tools">
                        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Like">
                            <i class="far fa-heart"></i>
                        </div>
                        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Comment">
                            <i class="far fa-comment"></i>
                        </div>
                        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Save">
                            <i class="far fa-bookmark"></i>
                        </div>
                        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Share">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Download PDF" id="downloadPdf">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Print">
                            <i class="fas fa-print"></i>
                        </div>
                        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Reading Settings" data-bs-toggle="modal" data-bs-target="#readingSettingsModal">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="article-tool-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dark Mode" id="darkModeToggle">
                            <i class="fas fa-moon"></i>
                        </div>
                    </div>
                </div>

                <!-- Article Content -->
                <div class="col-lg-7 animate animate-delay-1">
                    <!-- Audio Player -->
                    <div class="audio-player mb-4">
                        <div class="audio-player-header">
                            <h4 class="audio-player-title">Listen to this article</h4>
                            <div class="audio-player-controls">
                                <button class="audio-player-btn" title="Speed">
                                    <i class="fas fa-tachometer-alt"></i> 1.0x
                                </button>
                                <button class="audio-player-btn" title="Volume">
                                    <i class="fas fa-volume-up"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <button class="audio-player-btn-play">
                                <i class="fas fa-play"></i>
                            </button>
                            <div class="w-100">
                                <div class="audio-player-progress">
                                    <div class="audio-player-progress-fill"></div>
                                    <div class="audio-player-progress-handle"></div>
                                </div>
                                <div class="audio-player-time">
                                    <span>00:00</span>
                                    <span>12:35</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Content -->
                    <article class="article-content">
                        <p>Laravel's Eloquent ORM is one of the framework's most powerful features, providing a beautiful, simple ActiveRecord implementation for working with your database. While most developers are familiar with basic Eloquent operations, there are numerous advanced techniques that can significantly improve your application's performance and code quality.</p>

                        <p>In this article, we'll explore sophisticated Eloquent techniques that go beyond the basics, helping you optimize database operations and write more efficient code. Whether you're building a high-traffic application or simply want to improve your Laravel skills, these advanced strategies will take your Eloquent usage to the next level.</p>

                        <h2 id="eager-loading">1. Mastering Eager Loading to Avoid N+1 Queries</h2>
                        <p>One of the most common performance issues in database-driven applications is the N+1 query problem. This occurs when you retrieve a collection of models and then need to access a relationship for each one, resulting in a separate query for each model in the collection.</p>

                        <p>For example, consider a blog application where you want to display a list of posts with each author's name:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Inefficient approach (N+1 problem)</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">$posts = Post::all();

foreach ($posts as $post) {
    echo $post->author->name; // This triggers a separate query for each post
}</code></pre>
                        </div>

                        <p>This code will execute one query to retrieve all posts, then an additional query for each post to fetch its author. If you have 100 posts, this results in 101 queries!</p>

                        <p>Eager loading solves this problem by loading all the relationships in a single query:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Efficient approach with eager loading</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">$posts = Post::with('author')->get();

foreach ($posts as $post) {
    echo $post->author->name; // No additional queries
}</code></pre>
                        </div>

                        <p>With this approach, only two queries are executed: one to retrieve all posts and another to retrieve all the related authors.</p>

                        <h3 id="nested-eager-loading">1.1 Nested Eager Loading</h3>
                        <p>You can also eager load nested relationships using dot notation:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Nested eager loading</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">$posts = Post::with('author.profile', 'comments.user')->get();</code></pre>
                        </div>

                        <p>This loads the posts, their authors, the authors' profiles, the posts' comments, and the users who made those comments, all in just a few queries.</p>

                        <h3 id="conditional-eager-loading">1.2 Conditional Eager Loading</h3>
                        <p>Sometimes you need to apply conditions to your eager loaded relationships. Laravel provides several methods to accomplish this:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Conditional eager loading</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">// Only load published comments
$posts = Post::with(['comments' => function ($query) {
    $query->where('is_published', true);
}])->get();

// Only load the three most recent comments
$posts = Post::with(['comments' => function ($query) {
    $query->latest()->limit(3);
}])->get();</code></pre>
                        </div>

                        <h2 id="query-optimization">2. Query Optimization Techniques</h2>
                        <p>Beyond eager loading, there are several ways to optimize your Eloquent queries for better performance.</p>

                        <h3 id="select-specific-columns">2.1 Selecting Specific Columns</h3>
                        <p>By default, Eloquent selects all columns (<code>SELECT *</code>) from a table. However, if you only need specific columns, you can improve performance by explicitly selecting only what you need:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Selecting specific columns</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">// Only select id, title, and created_at columns
$posts = Post::select('id', 'title', 'created_at')->get();</code></pre>
                        </div>

                        <p>This is particularly effective when working with tables that have many columns or when you're retrieving large datasets.</p>

                        <blockquote>
                            <p>When selecting specific columns, always include the primary key (usually 'id') if you plan to access relationships, as Eloquent needs it to match related models.</p>
                        </blockquote>

                        <h3 id="chunking-results">2.2 Chunking Results for Large Datasets</h3>
                        <p>When dealing with a large number of database records, processing all of them at once can lead to memory issues. Laravel provides the <code>chunk</code> method to process large datasets in smaller chunks:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Chunking results</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">Post::chunk(100, function ($posts) {
    foreach ($posts as $post) {
        // Process each post
    }
});</code></pre>
                        </div>

                        <p>This will process 100 posts at a time, significantly reducing memory usage for large datasets.</p>

                        <h3 id="lazy-collections">2.3 Lazy Collections in Laravel 8+</h3>
                        <p>In Laravel 8 and newer, you can use lazy collections to process large datasets with minimal memory usage:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Using lazy collections</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">Post::cursor()->each(function ($post) {
    // Process each post without loading all posts into memory
});</code></pre>
                        </div>

                        <p>The <code>cursor</code> method returns a LazyCollection instance, which only loads one model into memory at a time.</p>

                        <h2 id="advanced-relationships">3. Advanced Relationship Techniques</h2>
                        <p>Laravel's relationship methods offer powerful features beyond basic associations. Here are some advanced techniques:</p>

                        <h3 id="has-many-through">3.1 Has Many Through Relationship</h3>
                        <p>The "has-many-through" relationship provides a convenient way to access distant relations. For example, a Country might have many Posts through Users:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Has Many Through relationship</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">class Country extends Model
{
    public function posts()
    {
        return $this->hasManyThrough(Post::class, User::class);
    }
}</code></pre>
                        </div>

                        <p>Now you can easily access all posts from authors in a specific country:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Using Has Many Through</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">$countryPosts = Country::find(1)->posts;</code></pre>
                        </div>

                        <h3 id="polymorphic-relationships">3.2 Polymorphic Relationships</h3>
                        <p>Polymorphic relationships allow a model to belong to more than one type of model. For example, a Comment model might belong to either a Post or a Video:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Polymorphic relationship definition</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">class Comment extends Model
{
    public function commentable()
    {
        return $this->morphTo();
    }
}

class Post extends Model
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

class Video extends Model
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}</code></pre>
                        </div>

                        <h3 id="custom-intermediate-table">3.3 Custom Pivot Models for Many-to-Many Relationships</h3>
                        <p>When your many-to-many relationship requires additional attributes or methods on the pivot table, you can define a custom pivot model:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Custom pivot model</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->using(RoleUser::class)
                    ->withPivot('expires_at');
    }
}

class RoleUser extends Pivot
{
    public function isExpired()
    {
        return $this->expires_at && Carbon::now()->gte($this->expires_at);
    }
}</code></pre>
                        </div>

                        <p>Now you can access methods on the pivot model:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Using custom pivot methods</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">$user = User::find(1);

foreach ($user->roles as $role) {
    if ($role->pivot->isExpired()) {
        // Handle expired role
    }
}</code></pre>
                        </div>

                        <h2 id="query-scopes">4. Creating Powerful Query Scopes</h2>
                        <p>Query scopes allow you to encapsulate common query constraints into reusable methods, making your code cleaner and more maintainable.</p>

                        <h3 id="local-scopes">4.1 Local Scopes</h3>
                        <p>Local scopes are defined as methods on your model with names prefixed with "scope":</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Defining local scopes</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">class Post extends Model
{
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
    
    public function scopePopular($query, $minViews = 1000)
    {
        return $query->where('views', '>=', $minViews);
    }
    
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}</code></pre>
                        </div>

                        <p>You can then chain these scopes in your queries:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Using local scopes</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">// Get recent, popular, published posts
$posts = Post::published()->popular(500)->recent(14)->get();</code></pre>
                        </div>

                        <h3 id="dynamic-scopes">4.2 Dynamic Scopes</h3>
                        <p>Dynamic scopes allow you to pass parameters to filter your queries:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Dynamic scope example</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">class User extends Model
{
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}</code></pre>
                        </div>

                        <p>Using the dynamic scope:</p>

                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-title">Using dynamic scopes</span>
                                <button class="code-copy" title="Copy code">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <pre><code class="language-php">$admins = User::ofType('admin')->get();
$editors = User::ofType('editor')->get();</code></pre>
                        </div>

                        <h2 id="conclusion">5. Conclusion</h2>
                        <p>Mastering these advanced Eloquent techniques will significantly improve your Laravel applications' performance and code quality. We've covered eager loading to avoid N+1 queries, query optimization strategies, advanced relationship techniques, and powerful query scopes.</p>

                        <p>While these techniques provide substantial benefits, always remember to measure and test your optimizations in real-world scenarios. Database optimization is highly context-dependent, and what works for one application might not be ideal for another.</p>

                        <p>By applying these advanced Eloquent techniques thoughtfully, you'll create more efficient, maintainable Laravel applications that scale well even as your data grows.</p>
                    </article>

                    <!-- Article Tags -->
                    <div class="article-tags">
                        <a href="#" class="article-tag">Laravel</a>
                        <a href="#" class="article-tag">Eloquent</a>
                        <a href="#" class="article-tag">ORM</a>
                        <a href="#" class="article-tag">Database</a>
                        <a href="#" class="article-tag">Performance</a>
                        <a href="#" class="article-tag">PHP</a>
                    </div>

                    <!-- Article Share -->
                    <div class="article-share">
                        <span class="article-share-title">Share this article:</span>
                        <a href="#" class="article-share-link twitter" title="Share on Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="article-share-link facebook" title="Share on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="article-share-link linkedin" title="Share on LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="article-share-link" title="Copy link">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>

                    <!-- Author Bio -->
                    <div class="article-author">
                        <img src="/api/placeholder/100/100" alt="Jane Smith" class="article-author-img">
                        <div>
                            <h4 class="article-author-name">Jane Smith</h4>
                            <p class="article-author-bio">Jane is a senior Laravel developer with over 8 years of experience building enterprise applications. She specializes in database optimization, API development, and performance tuning. When not coding, she enjoys hiking and photography.</p>
                            <div class="article-author-social">
                                <a href="#" class="article-author-social-link" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="article-author-social-link" title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="article-author-social-link" title="GitHub">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="#" class="article-author-social-link" title="Personal Website">
                                    <i class="fas fa-globe"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Related Articles -->
                    <div class="related-articles">
                        <h3 class="related-articles-title">Related Articles</h3>
                        <div class="related-article">
                            <img src="/api/placeholder/100/100" alt="Related Article" class="related-article-img">
                            <div>
                                <a href="#" class="related-article-title">10 Laravel Eloquent Features You Might Not Know About</a>
                                <div class="related-article-meta">
                                    <span><i class="far fa-user me-1"></i> John Doe</span>
                                    <span class="ms-2"><i class="far fa-calendar me-1"></i> March 8, 2025</span>
                                </div>
                            </div>
                        </div>
                        <div class="related-article">
                            <img src="/api/placeholder/100/100" alt="Related Article" class="related-article-img">
                            <div>
                                <a href="#" class="related-article-title">Optimizing Database Performance in Laravel Applications</a>
                                <div class="related-article-meta">
                                    <span><i class="far fa-user me-1"></i> Sarah Johnson</span>
                                    <span class="ms-2"><i class="far fa-calendar me-1"></i> March 5, 2025</span>
                                </div>
                            </div>
                        </div>
                        <div class="related-article">
                            <img src="/api/placeholder/100/100" alt="Related Article" class="related-article-img">
                            <div>
                                <a href="#" class="related-article-title">Building Advanced API Endpoints with Laravel Resources</a>
                                <div class="related-article-meta">
                                    <span><i class="far fa-user me-1"></i> David Wilson</span>
                                    <span class="ms-2"><i class="far fa-calendar me-1"></i> March 1, 2025</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="comments-section mt-5">
                        <h3 class="mb-4">Comments (5)</h3>
                        
                        <!-- Comment Form -->
                        <div class="comment-form mb-5">
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" placeholder="Add a comment..."></textarea>
                            </div>
                            <button class="btn btn-accent-custom">Post Comment</button>
                        </div>
                        
                        <!-- Comment List -->
                        <div class="comment-list">
                            <div class="comment">
                                <div class="comment-header">
                                    <img src="/api/placeholder/50/50" alt="Commenter" class="comment-img">
                                    <div class="comment-meta">
                                        <div class="comment-name">Robert Thompson</div>
                                        <div class="comment-date">March 11, 2025</div>
                                    </div>
                                </div>
                                <div class="comment-content">
                                    <p>This article has been incredibly helpful! I've been struggling with N+1 query issues in my Laravel application, and your explanation of eager loading techniques solved my problem. Thank you for sharing this knowledge.</p>
                                </div>
                                <div class="comment-actions mt-2">
                                    <a href="#" class="me-3"><i class="far fa-thumbs-up me-1"></i> Like (12)</a>
                                    <a href="#"><i class="far fa-reply me-1"></i> Reply</a>
                                </div>
                                
                                <!-- Comment Reply -->
                                <div class="comment-reply mt-3">
                                    <div class="comment-header">
                                        <img src="/api/placeholder/50/50" alt="Commenter" class="comment-img">
                                        <div class="comment-meta">
                                            <div class="comment-name">Jane Smith <span class="badge bg-accent-custom ms-2">Author</span></div>
                                            <div class="comment-date">March 11, 2025</div>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>Thanks Robert! I'm glad the article helped you solve your N+1 query issues. Feel free to reach out if you have any other questions about Eloquent optimization.</p>
                                    </div>
                                    <div class="comment-actions mt-2">
                                        <a href="#" class="me-3"><i class="far fa-thumbs-up me-1"></i> Like (3)</a>
                                        <a href="#"><i class="far fa-reply me-1"></i> Reply</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="comment">
                                <div class="comment-header">
                                    <img src="/api/placeholder/50/50" alt="Commenter" class="comment-img">
                                    <div class="comment-meta">
                                        <div class="comment-name">Sarah Williams</div>
                                        <div class="comment-date">March 10, 2025</div>
                                    </div>
                                </div>
                                <div class="comment-content">
                                    <p>The section on custom pivot models was exactly what I needed! I've been trying to figure out how to add methods to my pivot relationships for a while. Great article overall, but that section in particular was a game-changer for my current project.</p>
                                </div>
                                <div class="comment-actions mt-2">
                                    <a href="#" class="me-3"><i class="far fa-thumbs-up me-1"></i> Like (8)</a>
                                    <a href="#"><i class="far fa-reply me-1"></i> Reply</a>
                                </div>
                            </div>
                            
                            <div class="comment">
                                <div class="comment-header">
                                    <img src="/api/placeholder/50/50" alt="Commenter" class="comment-img">
                                    <div class="comment-meta">
                                        <div class="comment-name">Michael Johnson</div>
                                        <div class="comment-date">March 10, 2025</div>
                                    </div>
                                </div>
                                <div class="comment-content">
                                    <p>Great article! One thing I'd add is that when using chunking for large datasets, you can also use chunkById which is often more efficient for very large tables. It would be great to see a follow-up article on Query Builder performance vs Eloquent for different use cases.</p>
                                </div>
                                <div class="comment-actions mt-2">
                                    <a href="#" class="me-3"><i class="far fa-thumbs-up me-1"></i> Like (5)</a>
                                    <a href="#"><i class="far fa-reply me-1"></i> Reply</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (Table of Contents) -->
                <div class="col-lg-4 animate animate-delay-2">
                    <div class="article-toc">
                        <h3 class="article-toc-title">Table of Contents</h3>
                        <ul class="article-toc-list">
                            <li class="article-toc-item">
                                <a href="#eager-loading" class="article-toc-link">1. Mastering Eager Loading to Avoid N+1 Queries</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#nested-eager-loading" class="article-toc-link level-3">1.1 Nested Eager Loading</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#conditional-eager-loading" class="article-toc-link level-3">1.2 Conditional Eager Loading</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#query-optimization" class="article-toc-link">2. Query Optimization Techniques</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#select-specific-columns" class="article-toc-link level-3">2.1 Selecting Specific Columns</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#chunking-results" class="article-toc-link level-3">2.2 Chunking Results for Large Datasets</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#lazy-collections" class="article-toc-link level-3">2.3 Lazy Collections in Laravel 8+</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#advanced-relationships" class="article-toc-link">3. Advanced Relationship Techniques</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#has-many-through" class="article-toc-link level-3">3.1 Has Many Through Relationship</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#polymorphic-relationships" class="article-toc-link level-3">3.2 Polymorphic Relationships</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#custom-intermediate-table" class="article-toc-link level-3">3.3 Custom Pivot Models</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#query-scopes" class="article-toc-link">4. Creating Powerful Query Scopes</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#local-scopes" class="article-toc-link level-3">4.1 Local Scopes</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#dynamic-scopes" class="article-toc-link level-3">4.2 Dynamic Scopes</a>
                            </li>
                            <li class="article-toc-item">
                                <a href="#conclusion" class="article-toc-link">5. Conclusion</a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Newsletter Signup -->
                    <div class="card mt-4 p-4">
                        <h4 class="mb-3">Subscribe to Our Newsletter</h4>
                        <p class="mb-3">Get the latest articles and technology insights delivered to your inbox.</p>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Your email address">
                            <button class="btn btn-accent-custom" type="button">Subscribe</button>
                        </div>
                        <small class="text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    
                    <!-- Popular Articles -->
                    <div class="card mt-4 p-4">
                        <h4 class="mb-3">Popular Articles</h4>
                        <div class="related-article">
                            <img src="/api/placeholder/100/100" alt="Popular Article" class="related-article-img">
                            <div>
                                <a href="#" class="related-article-title">Building RESTful APIs with Laravel Sanctum</a>
                                <div class="related-article-meta">
                                    <span><i class="far fa-eye me-1"></i> 5.2K views</span>
                                </div>
                            </div>
                        </div>
                        <div class="related-article">
                            <img src="/api/placeholder/100/100" alt="Popular Article" class="related-article-img">
                            <div>
                                <a href="#" class="related-article-title">Laravel Livewire vs. Inertia.js: A Practical Comparison</a>
                                <div class="related-article-meta">
                                    <span><i class="far fa-eye me-1"></i> 4.8K views</span>
                                </div>
                            </div>
                        </div>
                        <div class="related-article">
                            <img src="/api/placeholder/100/100" alt="Popular Article" class="related-article-img">
                            <div>
                                <a href="#" class="related-article-title">Deploying Laravel Applications with GitHub Actions</a>
                                <div class="related-article-meta">
                                    <span><i class="far fa-eye me-1"></i> 3.9K views</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Download PDF Card -->
                    <div class="card mt-4 p-4 text-center">
                        <h4 class="mb-3">Save for Later</h4>
                        <p class="mb-3">Download this article as a PDF to read offline or share with your team.</p>
                        <button class="btn btn-accent-custom w-100" id="downloadPdfBtn">
                            <i class="fas fa-file-pdf me-2"></i> Download as PDF
                        </button>
                    </div>
                    
                    <!-- Support/Donate Card -->
                    <div class="card mt-4 p-4 text-center">
                        <h4 class="mb-3">Support Our Work</h4>
                        <p class="mb-3">If you found this article helpful, consider supporting our content creation.</p>
                        <button class="btn btn-outline-primary w-100">
                            <i class="fas fa-heart me-2"></i> Support Us
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection