@extends('user.dashboard.layout')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
<div class="profile-header">
    <div class="profile-cover"></div>
    <div class="profile-info">
        <div class="profile-avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4299e1&color=fff" alt="{{ $user->name }}">
        </div>
        <h2 class="profile-name">{{ $user->name }}</h2>
        <p class="profile-title">Member since {{ $user->created_at->format('F Y') }}</p>
        
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-envelope text-muted me-3"></i>
                    <span>{{ $user->email }}</span>
                </div>
                
                <div class="d-flex align-items-center">
                    <i class="fas fa-calendar text-muted me-3"></i>
                    <span>Joined {{ $user->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('dashboard.settings') }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit me-1"></i> Edit Profile
                </a>
            </div>
        </div>
        
        <ul class="nav nav-tabs profile-tabs mt-4" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="false">Activity</button>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content" id="profileTabsContent">
    <!-- Overview Tab -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">About</h5>
                    </div>
                    <div class="card-body">
                        @if($user->bio)
                            <p>{{ $user->bio }}</p>
                        @else
                            <div class="empty-state">
                                <p>No bio information added yet.</p>
                                <a href="{{ route('dashboard.settings') }}" class="btn btn-sm btn-primary">Add Bio</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Interests</h5>
                        <a href="{{ route('dashboard.settings') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            @if(isset($user->interests) && count($user->interests) > 0)
                                @foreach($user->interests as $interest)
                                    <span class="badge bg-light text-dark">{{ $interest }}</span>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <p>No interests added yet.</p>
                                    <a href="{{ route('dashboard.settings') }}" class="btn btn-sm btn-primary">Add Interests</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Stats</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Articles Read
                                <span class="badge bg-primary rounded-pill">24</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Comments
                                <span class="badge bg-primary rounded-pill">8</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Bookmarks
                                <span class="badge bg-primary rounded-pill">12</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Likes
                                <span class="badge bg-primary rounded-pill">15</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Reading Preferences</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-3">Favorite Categories</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-info">Laravel</span>
                            <span class="badge bg-danger">JavaScript</span>
                            <span class="badge bg-success">PHP</span>
                            <span class="badge bg-warning">CSS</span>
                            <span class="badge bg-secondary">MySQL</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="mb-3">Reading Time</h6>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="readingTimeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Activity Tab -->
    <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    <div class="activity-item">
                        <div class="activity-icon bg-primary">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="activity-content">
                            <div class="d-flex justify-content-between">
                                <h6>You commented on an article</h6>
                                <small>2 days ago</small>
                            </div>
                            <p>You commented on <a href="#">Laravel 10 Features You Should Know About</a>: "Great article, thanks for sharing these tips!"</p>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon bg-success">
                            <i class="fas fa-bookmark"></i>
                        </div>
                        <div class="activity-content">
                            <div class="d-flex justify-content-between">
                                <h6>You bookmarked an article</h6>
                                <small>3 days ago</small>
                            </div>
                            <p>You bookmarked <a href="#">Understanding Promises in JavaScript</a></p>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon bg-danger">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="activity-content">
                            <div class="d-flex justify-content-between">
                                <h6>You liked an article</h6>
                                <small>5 days ago</small>
                            </div>
                            <p>You liked <a href="#">10 Must-Know VS Code Extensions for Web Developers</a></p>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon bg-info">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="activity-content">
                            <div class="d-flex justify-content-between">
                                <h6>You followed an author</h6>
                                <small>1 week ago</small>
                            </div>
                            <p>You followed <a href="#">Muhammad Nawaz</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Activity Chart</h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 300px;">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Activity Timeline */
    .activity-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .activity-timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 15px;
        width: 2px;
        background-color: #e2e8f0;
    }
    
    .activity-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .activity-item:last-child {
        padding-bottom: 0;
    }
    
    .activity-icon {
        position: absolute;
        left: -30px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        z-index: 1;
    }
    
    .activity-icon i {
        font-size: 0.875rem;
    }
    
    .activity-content {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
    }
    
    .activity-content h6 {
        margin-bottom: 0.25rem;
    }
    
    .activity-content small {
        color: #6c757d;
    }
    
    .activity-content p {
        margin-bottom: 0;
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
 
  