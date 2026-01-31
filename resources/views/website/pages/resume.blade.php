@extends('website.layouts.app')
@section('title', 'Resume - Muhammad Nawaz')
@section('meta_title', 'Resume - Muhammad Nawaz | Full Stack Software Engineer')
@section('meta_description', 'View and download Muhammad Nawaz’s resume. Experience in Laravel, PHP, APIs, and modern web development.')
@section('meta_keywords', 'Resume, CV, Muhammad Nawaz, Software Engineer, Laravel, PHP')

@section('schema_markup')
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Resume - Muhammad Nawaz",
  "url": "{{ url('/resume') }}",
  "about": {
    "@type": "Person",
    "name": "Muhammad Nawaz",
    "jobTitle": "Full Stack Software Engineer"
  }
}
@endsection

@section('content')
<section class="page-header">
    <div class="page-header-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center animate">
                <h1 class="fw-bold mb-3">Resume</h1>
                <p class="lead">Download the latest CV and view a snapshot of experience.</p>
                <a href="{{ route('cv') }}" class="btn btn-primary">View CV PDF</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 animate">
                <h3 class="fw-bold">Experience Highlights</h3>
                <ul class="list-unstyled mt-3">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Laravel architecture and API engineering</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Database optimization and performance tuning</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Admin dashboards and CMS solutions</li>
                </ul>
            </div>
            <div class="col-lg-6 animate">
                <h3 class="fw-bold">Core Technologies</h3>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <span class="badge bg-primary">Laravel</span>
                    <span class="badge bg-secondary">PHP 8+</span>
                    <span class="badge bg-info">MySQL</span>
                    <span class="badge bg-dark">REST APIs</span>
                    <span class="badge bg-success">React</span>
                    <span class="badge bg-warning text-dark">Vue.js</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
