@extends('layouts.seo')
@section('title', 'SEO Analytics Dashboard')
@section('seo-content')

<div class="page-content">
    <!-- Page Header -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Analytics</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group" role="group">
                <input type="radio" class="btn-check" name="timeRange" id="7days" value="7" {{ $days == 7 ? 'checked' : '' }}>
                <label class="btn btn-outline-primary btn-sm" for="7days">7 Days</label>
                
                <input type="radio" class="btn-check" name="timeRange" id="30days" value="30" {{ $days == 30 ? 'checked' : '' }}>
                <label class="btn btn-outline-primary btn-sm" for="30days">30 Days</label>
                
                <input type="radio" class="btn-check" name="timeRange" id="90days" value="90" {{ $days == 90 ? 'checked' : '' }}>
                <label class="btn btn-outline-primary btn-sm" for="90days">90 Days</label>
            </div>
        </div>
    </div>

    <!-- Analytics Overview Cards -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <!-- Today's Visitors -->
        <div class="col">
            <div class="card radius-10 bg-gradient-blue position-relative">
                <div class="card-body text-white text-center">
                    <img class="card-icon" src="{{ asset('assets/images/avatars/Vector (1).png') }}">
                    <p class="mb-1 card-text">Today's Visitors</p>
                    <h5 class="mb-0 card-h5-dashboard" id="todayVisitors">{{ isset($analytics) ? number_format($analytics['today_visitors']) : '0' }}</h5>
                </div>
            </div>
        </div>
        
        <!-- Today's Page Views -->
        <div class="col">
            <div class="card radius-10 bg-gradient-purple position-relative">
                <div class="card-body text-white text-center">
                    <img class="card-icon" src="{{ asset('assets/images/avatars/Vector (3).png') }}">
                    <p class="mb-1 card-text">Today's Page Views</p>
                    <h5 class="mb-0 card-h5-dashboard" id="todayPageviews">{{ isset($analytics) ? number_format($analytics['today_pageviews']) : '0' }}</h5>
                </div>
            </div>
        </div>
        
        <!-- Total Visitors (Period) -->
        <div class="col">
            <div class="card radius-10 bg-gradient-red position-relative">
                <div class="card-body text-white text-center">
                    <img class="card-icon" src="{{ asset('assets/images/avatars/Vector (2).png') }}">
                    <p class="mb-1 card-text">Total Visitors</p>
                    <h5 class="mb-0 card-h5-dashboard">{{ isset($analytics) ? number_format($analytics['total_visitors']) : '0' }}</h5>
                </div>
            </div>
        </div>
        
        <!-- Bounce Rate -->
        <div class="col">
            <div class="card radius-10 bg-gradient-orange position-relative">
                <div class="card-body text-white text-center">
                    <img class="card-icon" src="{{ asset('assets/images/avatars/Vector (4).png') }}">
                    <p class="mb-1 card-text">Bounce Rate</p>
                    <h5 class="mb-0 card-h5-dashboard">{{ isset($analytics) ? number_format($analytics['bounce_rate'], 1) : '0' }}%</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Analytics Sections -->
    <div class="row mt-4">
        <!-- Trending Articles -->
        <div class="col-12 col-lg-6">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">🔥 Trending Articles</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($trendingArticles) && $trendingArticles->count() > 0)
                        @foreach($trendingArticles as $article)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ Str::limit($article->page_title, 50) }}</h6>
                                <p class="mb-0 text-secondary">{{ $article->views }} views</p>
                            </div>
                            <div class="badge bg-primary">{{ $article->views }}</div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-center py-4">
                        <i class="bx bx-trending-up font-50 text-secondary"></i>
                        <p class="text-secondary">No trending articles yet. Start tracking visits to see data here!</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Traffic Sources -->
        <div class="col-12 col-lg-6">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">📊 Traffic Sources</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($trafficSources) && $trafficSources->count() > 0)
                        @foreach($trafficSources as $source)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="font-22 me-2">
                                    @if($source->source == 'Google') 🔍
                                    @elseif($source->source == 'Direct') 🌐
                                    @elseif($source->source == 'Facebook') 📘
                                    @elseif($source->source == 'Twitter') 🐦
                                    @else 📊
                                    @endif
                                </div>
                                <div>
                                    <p class="mb-0">{{ $source->source }}</p>
                                </div>
                            </div>
                            <div class="badge bg-success">{{ $source->count }}</div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-center py-4">
                        <i class="bx bx-link-external font-50 text-secondary"></i>
                        <p class="text-secondary">No traffic source data yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Device & Location Stats -->
    <div class="row mt-4">
        <!-- Device Statistics -->
        <div class="col-12 col-lg-6">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">📱 Device Statistics</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($deviceStats) && $deviceStats->count() > 0)
                        @foreach($deviceStats as $device)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-{{ $device->device_type == 'mobile' ? 'mobile' : ($device->device_type == 'tablet' ? 'tablet' : 'desktop') }} me-2 font-22"></i>
                                <span>{{ ucfirst($device->device_type) }}</span>
                            </div>
                            <div class="badge bg-info">{{ $device->count }}</div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-center py-4">
                        <i class="bx bx-devices font-50 text-secondary"></i>
                        <p class="text-secondary">No device data yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Country Statistics -->
        <div class="col-12 col-lg-6">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">🌍 Top Countries</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($countryStats) && $countryStats->count() > 0)
                        @foreach($countryStats as $country)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="font-22 me-2">🌍</div>
                                <div>
                                    <p class="mb-0">{{ $country->country }}</p>
                                </div>
                            </div>
                            <div class="badge bg-warning">{{ $country->count }}</div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-center py-4">
                        <i class="bx bx-globe font-50 text-secondary"></i>
                        <p class="text-secondary">No location data yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Blog Statistics -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">📝 Blog Statistics</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-2">
                            <h4 class="text-primary">{{ isset($blogStats) ? $blogStats['total_articles'] : '0' }}</h4>
                            <p class="mb-0">Total Articles</p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="text-success">{{ isset($blogStats) ? $blogStats['published_articles'] : '0' }}</h4>
                            <p class="mb-0">Published</p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="text-warning">{{ isset($blogStats) ? $blogStats['draft_articles'] : '0' }}</h4>
                            <p class="mb-0">Drafts</p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="text-info">{{ isset($blogStats) ? $blogStats['featured_articles'] : '0' }}</h4>
                            <p class="mb-0">Featured</p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="text-danger">{{ isset($blogStats) ? number_format($blogStats['avg_seo_score'], 1) : '0' }}</h4>
                            <p class="mb-0">Avg SEO Score</p>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('seo.blogs.create') }}" class="btn btn-primary btn-sm">
                                <i class="bx bx-plus"></i> New Article
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Time range filter
    document.querySelectorAll('input[name="timeRange"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                window.location.href = '{{ route("seo.dashboard") }}?days=' + this.value;
            }
        });
    });

    // Auto-refresh every 5 minutes for real-time data
    setInterval(function() {
        // You can implement AJAX refresh here
        console.log('Auto-refresh triggered');
    }, 300000); // 5 minutes
});
</script>

<style>
/* Additional styles for the dashboard */
.card-h5-dashboard {
    font-weight: 600;
    font-size: 60px;
    margin: 0;
    text-align: right;
    color: white;
}

.card-text {
    width: 141px;
    height: 27px;
    color: rgba(255, 255, 255, 1);
    font-size: 18px;
    font-weight: 600;
}

.bg-gradient-blue {
    background: linear-gradient(98.86deg, #6BAAFC 0%, #305FEC 100%);
}

.bg-gradient-red {
    background: linear-gradient(98.86deg, #EF5E7A 0%, #D35385 100%);
}

.bg-gradient-purple {
    background: linear-gradient(98.86deg, #D623FE 0%, #A530F2 100%);
}

.bg-gradient-orange {
    background: linear-gradient(98.86deg, #FEA623 0%, #C97900 100%);
}

.card-icon {
    font-weight: 900;
    font-size: 62px;
    position: absolute;
    left: -3px;
    top: 83px;
    transform: rotate(-30deg);
    color: rgba(255, 255, 255, 0.13);
}

.font-22 {
    font-size: 22px;
}

.font-50 {
    font-size: 50px;
}
</style>
@endsection
