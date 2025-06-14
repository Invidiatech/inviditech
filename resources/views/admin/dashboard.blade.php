@extends('layouts.admin.master')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

    <!-- Welcome Alert -->
    <div id="alertBox" class="alert alert-info align-items-center gap-1 justify-content-between mb-3" role="alert" style="display: flex">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-info-circle"></i>
            <div>
                <strong>Welcome!</strong> Manage your tech blog and website content from here.
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    
    <!-- Dashboard Stats -->
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="dashboard-box item-1">
                        <h2 class="count">{{ $totalArticles ?? 25 }}</h2>
                        <h3 class="title">Total Articles</h3>
                        <div class="icon">
                            <i class="fas fa-newspaper fa-2x text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="dashboard-box item-2">
                        <h2 class="count">{{ $totalCategories ?? 8 }}</h2>
                        <h3 class="title">Categories</h3>
                        <div class="icon">
                            <i class="fas fa-folder fa-2x text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="dashboard-box item-3">
                        <h2 class="count">{{ $totalComments ?? 150 }}</h2>
                        <h3 class="title">Comments</h3>
                        <div class="icon">
                            <i class="fas fa-comments fa-2x text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="dashboard-box item-4">
                        <h2 class="count">{{ $totalUsers ?? 85 }}</h2>
                        <h3 class="title">Registered Users</h3>
                        <div class="icon">
                            <i class="fas fa-users fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Status -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="cardTitleBox">
                <h5 class="card-title chartTitle">
                    Content Status
                </h5>
            </div>

            <div class="d-flex flex-wrap gap-3 orderStatus">
                <a href="{{ route('admin.articles.index', ['status' => 'published']) }}" class="d-flex status flex-grow-1 completed">
                    <div class="d-flex align-items-center gap-2 justify-content-between w-100">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            <span>Published</span>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <span class="count">{{ $publishedArticles ?? 20 }}</span>
                </a>
                <a href="{{ route('admin.articles.index', ['status' => 'draft']) }}" class="d-flex status flex-grow-1 pending">
                    <div class="d-flex align-items-center gap-2 justify-content-between w-100">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-edit"></i>
                            <span>Drafts</span>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <span class="count">{{ $draftArticles ?? 5 }}</span>
                </a>
                <a href="" class="d-flex status flex-grow-1 inProgress">
                    <div class="d-flex align-items-center gap-2 justify-content-between w-100">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-clock"></i>
                            <span>Pending Comments</span>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <span class="count">{{ $pendingComments ?? 8 }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Website Analytics -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="cardTitleBox">
                <h5 class="card-title chartTitle">
                    Website Analytics
                </h5>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <div class="wallet h-100">
                        <h3 class="balance">{{ number_format($totalViews ?? 25000) }}</h3>
                        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap w-100">
                            <div>
                                <div class="d-flex align-items-center gap-1 percentUp">
                                    <span>+15.2%</span>
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                                <div class="title">Total Page Views</div>
                            </div>
                            <div class="wallet-icon svg-bg">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="wallet-others">
                                <div class="amount">{{ number_format($monthlyViews ?? 8500) }}</div>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="title">Monthly Views</div>
                                    <div class="icon svg-bg">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="wallet-others">
                                <div class="amount">{{ number_format($uniqueVisitors ?? 3200) }}</div>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="title">Unique Visitors</div>
                                    <div class="icon">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="wallet-others">
                                <div class="amount">{{ $avgReadTime ?? '3.5' }}m</div>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="title">Avg. Read Time</div>
                                    <div class="icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="wallet-others">
                                <div class="amount">{{ $bounceRate ?? '35' }}%</div>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="title">Bounce Rate</div>
                                    <div class="icon">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Statistics -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="cardTitleBox d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="card-title chartTitle mb-0">Blog Performance</h5>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <button class="statisticsBtn active" data-value="daily">
                            Daily
                        </button>
                        <button class="statisticsBtn" data-value="monthly">
                            Monthly
                        </button>
                        <button class="statisticsBtn" data-value="yearly">
                            Yearly
                        </button>
                    </div>

                    <div class="statisticsDivder"></div>

                    <div>
                        <input type="date" name="date" class="statisticsInput" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card theme-dark">
                        <div class="card-body">
                            <div class="border-bottom pb-3">
                                <h3 id="totalBlogPosts">{{ $totalArticles ?? 25 }}</h3>
                                <p>Total Blog Posts</p>
                            </div>
                            <canvas id="myChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card h-100 border theme-dark">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="border-bottom pb-3">
                                <h3>{{ $totalViews ?? 75 }}k</h3>
                                <p>Traffic Overview</p>
                            </div>
                            <div class="mt-auto colorDark">
                                <canvas id="myPieChart" width="200" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Comments -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="cardTitleBox d-flex justify-content-between align-items-center">
                <h5 class="card-title chartTitle">
                    Recent Comments <span style="color: #687387">(Latest 5 Comments)</span>
                </h5>
                <a href="" class="btn btn-sm btn-outline-primary">View All</a>
            </div>

            <div class="table-responsive">
                <table class="table dashboard">
                    <thead>
                        <tr>
                            <th><strong>Comment ID</strong></th>
                            <th><strong>User</strong></th>
                            <th><strong>Article</strong></th>
                            <th><strong>Date</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentComments ?? [] as $comment)
                        <tr>
                            <td class="tableId">#{{ $comment->id }}</td>
                            <td class="tablecustomer">{{ $comment->user->name ?? 'Guest' }}</td>
                            <td class="tableId">{{ Str::limit($comment->article->title ?? 'Article Title', 30) }}</td>
                            <td class="tableId">{{ $comment->created_at->format('d M, Y') ?? '06 Apr, 2025' }}</td>
                            <td class="tableStatus">
                                <div class="statusItem">
                                    @if(($comment->status ?? 'approved') === 'approved')
                                        <div class="circleDot animatedCompleted"></div>
                                        <div class="statusText">
                                            <span class="statusCompleted">Approved</span>
                                        </div>
                                    @else
                                        <div class="circleDot animatedPending"></div>
                                        <div class="statusText">
                                            <span class="statusPending">Pending</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="tableAction">
                                <a href="{{ route('admin.comments.show', $comment->id ?? 1) }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="View comment" class="circleIcon btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <!-- Sample data if no comments -->
                        <tr>
                            <td class="tableId">#001</td>
                            <td class="tablecustomer">John Doe</td>
                            <td class="tableId">Getting Started with Laravel</td>
                            <td class="tableId">{{ date('d M, Y') }}</td>
                            <td class="tableStatus">
                                <div class="statusItem">
                                    <div class="circleDot animatedCompleted"></div>
                                    <div class="statusText">
                                        <span class="statusCompleted">Approved</span>
                                    </div>
                                </div>
                            </td>
                            <td class="tableAction">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="View comment" class="circleIcon btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableId">#002</td>
                            <td class="tablecustomer">Jane Smith</td>
                            <td class="tableId">JavaScript Best Practices</td>
                            <td class="tableId">{{ date('d M, Y', strtotime('-1 day')) }}</td>
                            <td class="tableStatus">
                                <div class="statusItem">
                                    <div class="circleDot animatedPending"></div>
                                    <div class="statusText">
                                        <span class="statusPending">Pending</span>
                                    </div>
                                </div>
                            </td>
                            <td class="tableAction">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="View comment" class="circleIcon btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Popular Categories -->
        <div class="col-xxl-4 col-lg-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="cardTitleBox">
                        <h5 class="card-title chartTitle">
                            Popular Categories
                        </h5>
                    </div>

                    <div class="d-flex flex-column gap-1">
                        @forelse($popularCategories ?? [] as $category)
                        <a href="{{ route('admin.categories.show', $category->id ?? 1) }}" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <i class="fas fa-folder-open fa-2x text-primary"></i>
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">{{ $category->name ?? 'Web Development' }}</p>
                                    <p class="order">Articles: {{ $category->articles_count ?? 12 }}</p>
                                </div>
                            </div>
                        </a>
                        @empty
                        <!-- Sample data -->
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <i class="fas fa-folder-open fa-2x text-primary"></i>
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">Web Development</p>
                                    <p class="order">Articles: 12</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <i class="fas fa-folder-open fa-2x text-success"></i>
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">JavaScript</p>
                                    <p class="order">Articles: 8</p>
                                </div>
                            </div>
                        </a>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Most Popular Blog Posts -->
        <div class="col-xxl-4 col-lg-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="cardTitleBox">
                        <h5 class="card-title chartTitle">
                            Most Popular Posts
                        </h5>
                    </div>

                    <div class="d-flex flex-column gap-1">
                        @forelse($popularPosts ?? [] as $post)
                        <a href="{{ route('admin.articles.show', $post->id ?? 1) }}" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    @if($post->featured_image ?? null)
                                        <img src="{{ $post->featured_image }}" alt="Post thumbnail" loading="lazy"/>
                                    @else
                                        <i class="fas fa-newspaper fa-2x text-info"></i>
                                    @endif
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">{{ Str::limit($post->title ?? 'AI in Web Development 2025', 25) }}</p>
                                    <div class="d-flex gap-1 align-items-center text-black">
                                        <i class="bi bi-eye-fill"></i> {{ number_format($post->views ?? 1200) }} Views
                                    </div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <!-- Sample data -->
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <i class="fas fa-newspaper fa-2x text-info"></i>
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">AI in Web Development 2025</p>
                                    <div class="d-flex gap-1 align-items-center text-black">
                                        <i class="bi bi-eye-fill"></i> 1,200 Views
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <i class="fas fa-newspaper fa-2x text-warning"></i>
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">Laravel Tips & Tricks</p>
                                    <div class="d-flex gap-1 align-items-center text-black">
                                        <i class="bi bi-eye-fill"></i> 950 Views
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xxl-4 col-lg-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="cardTitleBox">
                        <h5 class="card-title chartTitle">
                            Quick Actions
                        </h5>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>Create New Article</span>
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
                            <i class="fas fa-folder-plus"></i>
                            <span>Add Category</span>
                        </a>
                        <a href=" " class="btn btn-outline-secondary d-flex align-items-center gap-2">
                            <i class="fas fa-users-cog"></i>
                            <span>Manage Users</span>
                        </a>
                        <a href=" " class="btn btn-outline-info d-flex align-items-center gap-2">
                            <i class="fas fa-cog"></i>
                            <span>Site Settings</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Dashboard-specific JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Statistics buttons
        document.querySelectorAll('.statisticsBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.statisticsBtn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Here you can add AJAX call to update charts based on selected period
                console.log('Statistics period changed to:', this.dataset.value);
            });
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.querySelector('.btn-close')) {
                    alert.style.transition = 'opacity 0.3s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);

        console.log('Tech Blog Dashboard loaded successfully');
    });
</script>
@endsection