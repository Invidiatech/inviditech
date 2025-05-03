@extends('user.dashboard.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-welcome">
    <h2>Welcome back, {{ $user->name }}!</h2>
    <p class="text-muted">Here's an overview of your activity on InvidiaTech.</p>
</div>

<!-- Stats Cards -->
<div class="row stats-cards">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-bookmark"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $bookmarkCount }}</h3>
                    <p class="stat-title">Bookmarks</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-comment"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $commentCount }}</h3>
                    <p class="stat-title">Comments</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $likeCount }}</h3>
                    <p class="stat-title">Likes</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Bookmarks -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Recent Bookmarks</h5>
                <a href="{{ route('dashboard.bookmarks') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentBookmarks->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentBookmarks as $bookmark)
                            <a href="{{ route('article.show', $bookmark->article->slug) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 text-truncate">{{ $bookmark->article->title }}</h6>
                                    <small>{{ $bookmark->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 text-muted small">{{ Str::limit($bookmark->article->excerpt ?? strip_tags($bookmark->article->content), 70) }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-bookmark"></i>
                        </div>
                        <p>You haven't bookmarked any articles yet.</p>
                        <a href="{{ route('articles') }}" class="btn btn-sm btn-primary">Browse Articles</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Comments -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Recent Comments</h5>
                <a href="{{ route('dashboard.comments') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentComments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentComments as $comment)
                            <a href="{{ route('article.show', $comment->article->slug) }}#comment-{{ $comment->id }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 text-truncate">On: {{ $comment->article->title }}</h6>
                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 small">{{ Str::limit($comment->content, 100) }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-comment"></i>
                        </div>
                        <p>You haven't commented on any articles yet.</p>
                        <a href="{{ route('articles') }}" class="btn btn-sm btn-primary">Browse Articles</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recommended Articles -->
<div class="card mt-2">
    <div class="card-header">
        <h5 class="card-title mb-0">Recommended For You</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- This could be populated with articles based on user's interests -->
            <div class="col-md-4 mb-3">
                <div class="card h-100 article-card">
                    <img src="/api/placeholder/400/200" class="card-img-top" alt="Article Image">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">Laravel</span>
                        <h5 class="card-title">Building a Blog with Laravel 10</h5>
                        <p class="card-text small">Learn how to create a fully-featured blog platform using Laravel 10, complete with authentication, admin panel, and more.</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Published 2 days ago</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 article-card">
                    <img src="/api/placeholder/400/200" class="card-img-top" alt="Article Image">
                    <div class="card-body">
                        <span class="badge bg-success mb-2">Tips & Tricks</span>
                        <h5 class="card-title">10 Must-Know VS Code Extensions for Web Developers</h5>
                        <p class="card-text small">Boost your productivity with these essential VS Code extensions that every web developer should know about.</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Published 5 days ago</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 article-card">
                    <img src="/api/placeholder/400/200" class="card-img-top" alt="Article Image">
                    <div class="card-body">
                        <span class="badge bg-danger mb-2">JavaScript</span>
                        <h5 class="card-title">Understanding Promises in JavaScript</h5>
                        <p class="card-text small">A comprehensive guide to working with Promises in JavaScript to handle asynchronous operations elegantly.</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Published 1 week ago</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection